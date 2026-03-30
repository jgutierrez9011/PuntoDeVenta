<?php
require_once 'cn.php';
require_once 'reg.php';

$detalle = 0;
$ingreso = 0;
$contado = 0;
$credito = 0;
$recibos = 0;
if(isset($_POST['fecha_inicio']))
{
/*  $fecharango = explode("-", $_POST['range']);
  $fechaini = trim($fecharango[0]);
  $fechafin = trim($fecharango[1]);*/

  $fechaini = $_POST['fecha_inicio'];
  $fechafin = $_POST['fecha_final'];


  $sql="SELECT pagos.intnumdocumento numero_recibo, pagos.numerofactura,
facturas.strestado estado_factura,
pagos.intserie serie,
to_char(pagos.datfechacreo,'DD/MM/YYYY HH24:MI:SS') fecha,
concat(clientes.strpnombre,' ',clientes.strsnombre,' ',clientes.strpapellido,' ',clientes.strsapellido) cliente,
facturas.numtotal total_factura,
pagos.numtotal_cobrado total_cobrado,
facturas.numtotal - (
select sum(sub.numtotal_cobrado) total_cobrado from
(
select a.intnumdocumento, a.intserie, a.numerofactura, a.numtotal_cobrado
from tbltrnpagos a
)sub
where sub.intserie <= pagos.intserie and sub.numerofactura = pagos.numerofactura
) saldo, facturas.intidserie serie_factura
from tbltrnpagos pagos
inner join public.tblcatfacturaencabezado facturas on pagos.numerofactura = facturas.numerofactura
inner join tblcatclientes clientes on facturas.intidcliente = clientes.intidcliente
where pagos.datfechacreo::date between '$fechaini' and '$fechafin'
order by pagos.intnumdocumento, pagos.intserie";


  $result = pg_query(conexion_bd(1),$sql);
  $detalle = pg_affected_rows($result);

  $fecha =   $fechaini;
  $fecha_ = $fechafin;

  $sql_recibos = "SELECT sum(total_cobrado) total
                  from
                  (
                  select pagos.intnumdocumento numero_recibo, pagos.numerofactura, pagos.intserie serie, pagos.numtotal_cobrado total_cobrado,
                  facturas.numtotal total_factura,
                  facturas.numtotal - (
                  select sum(sub.numtotal_cobrado) total_cobrado from
                  (
                  select a.intnumdocumento, a.intserie, a.numerofactura, a.numtotal_cobrado
                  from tbltrnpagos a
                  )sub
                  where sub.intserie <= pagos.intserie and sub.numerofactura = pagos.numerofactura
                  ) saldo
                  from tbltrnpagos pagos
                  inner join public.tblcatfacturaencabezado facturas on pagos.numerofactura = facturas.numerofactura
                  where pagos.datfechacreo::date between '$fechaini' and '$fechafin'
                  order by pagos.intnumdocumento, pagos.intserie
                  ) sub3";

  $row_total_recibos = pg_fetch_array(pg_query(conexion_bd(1),$sql_recibos));
  $recibos = $row_total_recibos['total'];
}

/*if(!isset($_POST['range']))
{
  date_default_timezone_set("America/Managua");
  $fecha = date('d/m/Y');
  $fecha_ = date('d/m/Y');
}*/



 ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Navigation -->
    <?php require_once 'icon.php'; ?>
    <title>Admin GYM</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="../vendor/bootstrap/css/bootstrap-multiselect.css" rel="stylesheet">

    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- css para plugin datatable  -->
    <link rel="stylesheet" type="text/css" href="../vendor/datatables/css_/jquery.dataTables.min.css">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="../vendor/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />

    <script src="../vendor/jquery/jquery-3.3.1.min.js"></script>

   <!--<script src="../vendor/daterangepicker/jquery.min.js"></script> -->




    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
    table.dataTable thead tr {
      background-color: grey;
      color: #ffffff;
    }
    </style>

    <style type="text/css">
       th { white-space: nowrap; }
    </style>


</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php require_once 'menu.php'; ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
              <br>

              <div class="py-5 text-center">
                  <?php require_once 'logo.php'; ?>
              </div>

             <h2 align="center">Recibos de caja</h2>
             <br>



             <form role="form_buscar_facturas" method="post" action="buscar_recibos.php">
             <div class="row">
               <div class="col-md-3">

                 <!--<div class="input-group">
                     <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                     </div>
                 <!-- <input type="text" class="form-control pull-right active" value="<?php //echo$fecha." - ".$fecha_  ?>" id="range" name="range" readonly=""> -->




                <!-- <span class="input-group-btn">
							   <button class="btn btn-default" type="submit"><i class='fa fa-search'></i></button>
						  </span>

            </div> -->

                 <label>Fecha inicio: </label>
                 <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required/>

               </div>

                <div class="col-md-3">

                <label>Fecha fin: </label>
                <input type="date" class="form-control" id="fecha_final" name="fecha_final"  required/>

                </div>

                <div class="col-md-3">

                 <button class="btn btn-default" type="submit"><i class='fa fa-search'></i></button>

                 </div>

                <div class="col-md-3">
                       <a href="nueva_venta.php" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Nueva venta</a>
                </div>
            </div>
          </form>

          <!-- INICIAN MODALES -->
          <div class="modal fade" id="cobrosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Detalle de cobros</h4>
      </div>
      <div class="modal-body">
        <div id="msg"></div>
        <div id="loader2" class="text-center"></div>



    <div class="outer_div2"></div>
    <div id="loader_pago" class="row-fluid"></div>
      <?php //echo fn_fill_pagos('N'); ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div><form class="form-horizontal" id="agregar_cobro" method="post">
<!-- Modal -->
<div class="modal fade" id="agregarCobroModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar cobro</h4>
      </div>
      <div class="modal-body">

      <div id="loader3" class="text-center"></div>
      <div class="outer_div3">
  <div class="form-group">
    <label for="purchase_order_number" class="col-sm-3 control-label">Nº de documento</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" id="numero_recibo" name="numero_recibo" value="" required="" readonly>
      <input type="hidden" name="numero_factura" id="numero_factura" value="">
    </div>
  </div>
  <div class="form-group">
    <label for="purchase_date" class="col-sm-3 control-label">Fecha de venta</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" id="fecha_recibo" name="fecha_recibo" value="" required="" readonly>
    </div>
  </div>

  <div class="form-group">
    <label for="supplier_id" class="col-sm-3 control-label">Cliente</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" value="" required="" disabled="">
    </div>
  </div>
  <div class="form-group">
    <label for="total" class="col-sm-3 control-label">Total a cobrar</label>
    <div class="col-sm-9">
      <input type="number" class="form-control" id="total" name="total" step=".01" required>
    </div>
  </div>
  <div class="form-group">
    <label for="note" class="col-sm-3 control-label">Notas</label>
    <div class="col-sm-9">
      <textarea name="note" id="notas" class="form-control" maxlength="255"></textarea>
    </div>
  </div>






</div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" id="btnguardar_recibo">Guardar datos</button>
      </div>
    </div>
  </div>
</div>

</form><form class="form-horizontal" id="editar_cobro">
<!-- Modal -->
<div class="modal fade" id="editarCobroModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar cobro</h4>
      </div>
      <div class="modal-body">
      <div id="loader4" class="text-center"></div>
      <div class="outer_div4">

        <div class="form-group">
          <label for="purchase_order_number" class="col-sm-3 control-label">Nº de documento</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="edit_numero_recibo" name="edit_numero_recibo" value="" required="" readonly>
            <input type="hidden" name="edit_numero_factura" id="edit_numero_factura" value="">
          </div>
        </div>
        <div class="form-group">
          <label for="purchase_date" class="col-sm-3 control-label">Fecha de venta</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="edit_fecha_recibo" name="edit_fecha_recibo" value="" required="" readonly>
          </div>
        </div>

        <div class="form-group">
          <label for="supplier_id" class="col-sm-3 control-label">Cliente</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="edit_nombre_cliente" name="edit_nombre_cliente" value="" required="" disabled="">
          </div>
        </div>
        <div class="form-group">
          <label for="total" class="col-sm-3 control-label">Total a cobrar</label>
          <div class="col-sm-9">
            <input type="number" class="form-control" id="edit_total" name="edit_total" step=".01" required>
          </div>
        </div>
        <div class="form-group">
          <label for="note" class="col-sm-3 control-label">Notas</label>
          <div class="col-sm-9">
            <textarea name="edit_notas" id="edit_notas" class="form-control" maxlength="255"></textarea>
          </div>
        </div>

      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Actualizar datos</button>
      </div>
    </div>
  </div>
</div>
</form>
    <!-- FINALIZA MODALES -->


          <div id="resultados_ajax"></div>
          <br>

          <div class="row">
            <div class="table-responsive">
            <br>
              <table class="table table-striped table-bordered display" id="tblfactura" style="width:100%">
                  <thead>
                    <tr>
                       <th><p class="small"><strong>No.Recibo</strong></p></th>
                       <th><p class="small"><strong>Acciones</strong></p></th>
                       <th><p class="small"><strong>No.Factura</strong></p></th>
                       <th><p class="small"><strong>Estado</strong></p></th>
                       <th><p class="small"><strong>Fecha</strong></p></th>
                       <th><p class="small"><strong>Cliente</strong></p></th>
                       <th><p class="small"><strong>Total factura</strong></p></th>
                       <th><p class="small"><strong>Total cobrado</strong></p></th>
                       <th><p class="small"><strong>Saldo</strong></p></th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                        if($detalle > 0){
                         pg_result_seek($result,0);
                         $detalle = pg_affected_rows($result);
                         if($detalle<>0)
                          while($row = pg_fetch_array($result))
                             {

                                 ?>

                                  <tr>

                                  <td align="center"><p class='small'><?php echo $row['numero_recibo']; ?></p></td>
                                  <td>
                                    <div class="btn-group pull-right">
                                     <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
                                      <ul class="dropdown-menu">
                                            <li><a href="#" class="cobro" data-target="#cobrosModal" data-toggle="modal" data-id="<?php echo $row['numerofactura'] ?>" id="<?php echo $row['numerofactura'] ?>"><i class="fa fa-dollar"></i> Cobros</a></li>
                                            <li><a href="#" onclick="view_pdf('<?php echo base64_encode($row['serie_factura']) ?>');"><i class="fa fa-file-pdf-o"></i> Ver PDF</a></li>
                                          <!--  <li><a href="#" onclick="eliminar('<?php //echo base64_encode($row['intidserie']) ?>','<?php //echo base64_encode($row['numerofactura']) ?>')"><i class="fa fa-trash"></i> Anular</a></li> -->
                                      </ul>
                                    </div>
                                  </td>
                                  <td><?php echo $row['numerofactura']; ?></td>
                                  <td align="center"><p class='small'><?php echo $row['estado_factura']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['fecha']; ?></p></td>

                                  <td align="center"><p class='small'><?php echo $row['cliente']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['total_factura']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['total_cobrado']; ?></p></td>

                                  <td align="center"><p class='small'><?php echo $row['saldo']; ?></p></td>


                                  </tr>

                                <?php } }  ?>
                               <tfoot>

                                  <tr>
                                      <th colspan="7" style="text-align:right">Total recibos:</th>
                                      <th colspan="2"> <?php echo number_format($recibos,2); ?> C$</th>
                                  </tr>


                               </tfoot>
                                                  </tbody>
                                               </table>


                                <br>

             </div>
           </div>


             </div>
             <br>





         </div>
     </div>
     <br>

            <!-- /.container-fluid -->

        <!-- /#page-wrapper -->

    <!-- /#wrapper -->
    <footer class="my-5 pt-5 text-muted text-center text-small">
      <p class="mb-1">&copy;<?php echo date("Y")-1; ?>-<?php echo date("Y"); ?> GYM</p>
      <ul class="list-inline">
        <li class="list-inline-item"><a href="index.php">Inicio</a></li>
       </ul>
    </footer>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <script src="../vendor/bootstrap/js/bootstrap-multiselect.js"></script>



    <script type="text/javascript" src="../vendor/datatables/js_/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <script type="text/javascript" src="../vendor/datatables/js_/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../vendor/datatables/js/dataTables.fixedColumns.min.js"></script>

    <script type="text/javascript" src="../vendor/jquery/exp/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/buttons.flash.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/jszip.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/pdfmake.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/vfs_fonts.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/buttons.html5.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/buttons.print.min.js"></script>

    <script src="../vendor/daterangepicker/moment.min.js"></script>

  <!--   <script src="../vendor/daterangepicker/daterangepicker.min.js"></script> -->

     <script src="../js/VentanaCentrada.js"></script>


     <script type="text/javascript">
     $(function() {
     		   $('#tblfactura').DataTable({
              order: [[1, "asc"]],
              dom:'Bfrtip',
              buttons: ['copy','csv','excel','pdf','print'],
              language:{
                lengthMenu: "Mostrar _MENU_ registros por pagina",
                info: "Mostrando pagina _PAGE_ de _PAGES_",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(filtrada de _MAX_ registros)",
                loadingRecords: "Cargando...",
                processing:     "Procesando...",
                search: "Buscar:",
                zeroRecords:    "No se encontraron registros coincidentes",
                paginate: {
                  next:       "Siguiente",
                  previous:   "Anterior"
                },
              },
            });
     		        //Date range picker
            // $('#range').daterangepicker();

           /* $('#range').daterangepicker({
         locale:{
           format: "DD/MM/YYYY",
           separator: " - ",
           applyLabel: "Aplicar",
           cancelLabel: "Cancelar",
           fromLabel: "Desde",
           toLabel: "Hasta",
           customRangeLabel: "Custom",
           daysOfWeek: [
               "Do",
               "Lu",
               "Ma",
               "Mi",
               "Ju",
               "Vi",
               "Sa"
           ],
           monthNames: [
               "Enero",
               "Febrero",
               "Marzo",
               "Abril",
               "Mayo",
               "Junio",
               "Julio",
               "Agosto",
               "Septiembre",
               "Octubre",
               "Noviembre",
               "Diciembre"
           ],
             firstDay: 1
         },
         opens: 'right'
       }, function(start, end, label) {
         console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
       });*/



     	});

       function view_pdf(id){
           VentanaCentrada('factura.php?print=true&factura='+id,'Reimprimir factura','','1024','768','true');
         }

     </script>

     <script>
     		function eliminar(id,fact){
     			if(confirm('Esta acción  eliminará de forma permanente la factura \n\n Desea continuar?')){

             var parametros = {"id":id,"fact":fact};

     				$.ajax({
     					url:'nueva_factura.php',
     					data: parametros,
     					 beforeSend: function(objeto){
     				      $("#resultados_ajax").html("Enviando...");
     				  },
     					success:function(data){
     					 $("#resultados_ajax").html(data);
     						window.setTimeout(function() {
     						$(".alert").fadeTo(500, 0).slideUp(500, function(){
     						$(this).remove(); location.reload();});}, 5000);
     					}
     				})
     			}
     		}
     	</script>

       <script>

       $(document).on('click', '.cobro', function(){

            var idfactura = $(this).attr("id");

            $.ajax({
              type: "POST",
              url: "fnpagos.php",
              data: {factura:idfactura},
               beforeSend: function(objeto){
                $("#loader2").html("Mensaje: Cargando...");
                },
              success: function(datos)
              {
               $("#loader2").html("");
               $(".outer_div2").html(datos).fadeIn('slow');
              }
          });

            });

            $(document).on('click', '.nuevo_recibo', function(){

                 var idfactura = $(this).attr("id");

                 $.ajax({
                    type: "POST",
                    url: "fnpagos.php",
                    data: {numfactura:idfactura},
                    dataType:"JSON",
                    beforeSend: function(objeto){
                     //$("#loader2").html("Mensaje: Cargando...");
                     },
                   success: function(datos)
                   {
                    //$("#loader2").html("");
                    //$(".outer_div2").html(datos).fadeIn('slow');
                    $('#nombre_cliente').val(datos.cliente);
                    $('#fecha_recibo').val(datos.fecha_actual);
                    $('#numero_recibo').val(datos.numero_recibo);
                    $('#numero_factura').val(datos.numerofactura);
                   }
               });

                 });

                 $( "#agregar_cobro" ).submit(function( event ) {

                 $('#btnguardar_recibo').attr("disabled", true);
                 var num_factura = $('#numero_factura').val();
                 var parametros = $(this).serialize();

                  $.ajax({
                     type: "POST",
                     url: "fnpagos.php",
                     data: parametros,
                     success: function(datos){

                     $("#msg").html(datos);

                     $('#btnguardar_recibo').attr("disabled", false);

                     $.ajax({
                       type: "POST",
                       url: "fnpagos.php",
                       data: {factura:num_factura},
                        beforeSend: function(objeto){
                         $("#loader2").html("Mensaje: Cargando...");
                         },
                       success: function(datos)
                       {
                        $("#loader2").html("");
                        $(".outer_div2").html(datos).fadeIn('slow');
                       }
                     });

                     window.setTimeout(function() {
                     $(".alert").fadeTo(500, 0).slideUp(500, function(){
                     $(this).remove();});}, 5000);

                     $('#nombre_cliente').val("");
                     $('#fecha_recibo').val("");
                     $('#numero_recibo').val("");
                     $('#notas').val("");
                     $('#total').val("");

                     $('#agregarCobroModal').modal('hide');

                     }
                 });
                 event.preventDefault();

                 })

           $('#editarCobroModal').on('show.bs.modal', function (event) {
     		  var button = $(event.relatedTarget) // Button that triggered the modal
     		  var id_ = button.data('id') // Extract info from data-* attributes
     		  //var charge_id = button.data('charge_id') // Extract info from data-* attributes
     		  //var parametros = {"action":"ajax","id":id};

     			$.ajax({
             type: "POST",
     				url:'fnpagos.php',
     				data: { id:id_ },
             dataType:"JSON",
     				beforeSend: function(objeto){
     					$("#loader4").html('<img src="../img/ajax-loader.gif" alt="loading"/> Cargando...');
     				 },
     				success:function(data){
               $('#edit_nombre_cliente').val(data.nombre_cliente);
               $('#edit_fecha_recibo').val(data.datfechacreo);
               $('#edit_numero_recibo').val(data.intnumdocumento);
               $('#edit_numero_factura').val(data.numerofactura);
               $('#edit_notas').val(data.strobservacion);
               $('#edit_total').val(data.numtotal_cobrado);
     					$("#loader4").html("");
     				}
     			});
     		})

         $("#editar_cobro" ).submit(function(event) {
     			var factura_=$("#edit_numero_factura").val();
     			var parametros = $(this).serialize();
     			$.ajax({
     				type: "POST",
     				url:'fnpagos.php',
     				data: parametros,
     				 beforeSend: function(objeto){
     					$("#loader_pago").html('<img src="../img/ajax-loader.gif" alt="loading"/> Cargando...');
     				  },
     				success: function(data){

     					$("#loader_pago").html(data).fadeIn('slow');
     					$('#editarCobroModal').modal('hide');

              $.ajax({
                 type: "POST",
                 url: "fnpagos.php",
                 data: {factura:factura_},
                  beforeSend: function(objeto){
                   $("#loader2").html("Mensaje: Cargando...");
                   },
                 success: function(datos)
                 {
                  $("#loader2").html("");
                  $(".outer_div2").html(datos).fadeIn('slow');
                 }
               });

               window.setTimeout(function() {
               $(".alert").fadeTo(500, 0).slideUp(500, function(){
               $(this).remove();});}, 5000);



     			  }
     			});
     			event.preventDefault();
     		});

         function eliminar_cobro(recibo,comprobante){
     			if(confirm('Esta acción  eliminará de forma permanente el cobro \n\n ¿Desea continuar?')){

     				$.ajax({
               type: "POST",
     					url:'fnpagos.php',
     					data: {doc_recibo : recibo,  fact_comprobante : comprobante},
     					 beforeSend: function(objeto){
     					$("#loader2").html('<img src="../img/ajax-loader.gif" alt="loading"/> Cargando...');
     				  },
     					success:function(data){
     						$(".outer_div2").html(data).fadeIn('slow');
     						$("#loader2").html("");

                 $.ajax({
                    type: "POST",
                    url: "fnpagos.php",
                    data: {factura:comprobante},
                     beforeSend: function(objeto){
                      $("#loader2").html("Mensaje: Cargando...");
                      },
                    success: function(datos)
                    {
                     $("#loader2").html("");
                     $(".outer_div2").html(datos).fadeIn('slow');
                    }
                  });

                  window.setTimeout(function() {
                  $(".alert").fadeTo(500, 0).slideUp(500, function(){
                  $(this).remove();});}, 5000);

     					}
     				})

     			}
     		}

         function print_charge(doc_recibo,doc_factura){
     			VentanaCentrada('recibo.php?factura='+doc_factura +'&recibo=' + doc_recibo,'Recibo','','900','620','true');
     		}
       </script>

</body>

</html>
