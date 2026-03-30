<?php
require_once 'cn.php';
require_once 'reg.php';

$detalle = 0;

$perfil = $_SESSION["intidperfil"];

/*SE CONSULTA PERMISO PARA OPCION DE ANULAR FACTURAS*/
$row_permiso_facturas = pg_fetch_array(pg_query(conexion_bd(1),"SELECT bolactivo
                                                                from public.tblcatperfilusrfrmdetalle
                                                                where idfrmdetalle = 18 and idperfil =  $perfil"));
$row_permiso_facturas_estado = $row_permiso_facturas['bolactivo'];

if(isset($_POST['fecha_inicio']))
{
  /*$fecharango = explode("-", $_POST['range']);
  $fechaini = trim($fecharango[0]);
  $fechafin = trim($fecharango[1]);*/

  $fechaini = $_POST['fecha_inicio'];
  $fechafin = $_POST['fecha_final'];

  $sql="SELECT a.numerofactura, lpad(a.numerofactura::text,10,'0') factura, c.strnombre_vendedor proveedor, to_char(a.datfechacreo,'DD-MM-YYYY') fecha,
  concat(f.strpnombre,' ',f.strsnombre,' ',f.strpapellido,' ',f.strsapellido) usuario,
  a.numsubtotal, a.numdescuento, a.numiva, a.numtotal, a.intidserie, a.strestado, a.strtipo
  FROM  public.tblcatfacturaencabezado_compra a
 inner join public.tblcatfacturadetalle_compra b on a.intidserie = b.intidfactura
 inner join tblcatproveedor c on a.intidproveedor = c.intidproveedor
 inner join tblcatproductos d on b.intidproducto = d.intidproducto
 inner join tblcattipoproducto e on d.strtipo::integer = e.intidtipoproducto
 inner join tblcatusuario f on a.strusuariocreo = f.strcorreo and f.bolactivo = true
 where a.datfechacreo::date between '$fechaini'  and '$fechafin'
 group by 1,2,3,4,5,6,7,8,9,10,11,12
 order by a.numerofactura desc";


  $result = pg_query(conexion_bd(1),$sql);
  $detalle = pg_affected_rows($result);

  $fecha =   $fechaini;
  $fecha_ = $fechafin;
}

if(!isset($_POST['range']))
{
  date_default_timezone_set("America/Managua");
  $fecha = date('d/m/Y');
  $fecha_ = date('d/m/Y');
}



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
    <?php include 'icon.php' ?>
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


</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include 'menu.php' ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
              <br>

              <div class="py-5 text-center">
                  <?php include 'logo.php' ?>
              </div>

             <h2 align="center">Compras</h2>
             <br>


          <!--   <div class="row">
                <div class="col-md-12">
             <a href="nueva_venta.php" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Nueva venta</a>
                 </div>
             </div>
             <br> -->
             <form role="form" method="post" action="buscar_compras.php">
             <div class="row">
               <div class="col-md-3">

                <!-- <div class="input-group">
                     <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                     </div>
                 <input type="text" class="form-control pull-right active" value="<?php //echo $fecha." - ".$fecha_  ?>" id="range" name="range" readonly="">

                 <span class="input-group-btn">
							   <button class="btn btn-default" type="submit" ><i class='fa fa-search'></i></button>
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
                       <a href="nueva_compra.php" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Nueva compra</a>
                </div>
            </div>
          </form>
             </div>
             <br>

             <!-- INICIAN MODALES -->
     <div class="modal fade" id="cobrosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           <h4 class="modal-title" id="exampleModalLabel">Detalle de pago a cuenta x pagar</h4>
         </div>
         <div class="modal-body">
           <div id="msg"></div>
           <div id="loader2" class="text-center"></div>



      <div class="outer_div2"></div>
      <div id="loader_pago" class="row-fluid"></div>

         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
         </div>
       </div>
     </div>
   </div>

   <form class="form-horizontal" id="agregar_cobro" method="post">
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

   </form>

             <div id="resultados_ajax"></div>
             <br>


             <div class="row">
               <div class="table-responsive">
               <br>
                 <table class="table table-striped table-bordered" id="tblfacturas" style="width:100%">
                     <thead>
                       <tr>
                          <th><p class="small"><strong>Factura No.</strong></p></th>
                          <th><p class="small"><strong>Tipo factura</strong></p></th>
                          <th><p class="small"><strong>Estado</strong></p></th>
                          <th><p class="small"><strong>Proveedor</strong></p></th>
                          <th><p class="small"><strong>Fecha</strong></p></th>
                          <th><p class="small"><strong>Usuario</strong></p></th>
                          <th><p class="small"><strong>Neto</strong></p></th>
                          <th><p class="small"><strong>Descuento</strong></p></th>
                          <th><p class="small"><strong>IVA</strong></p></th>
                          <th><p class="small"><strong>Total</strong></p></th>
                          <th><p class="small"><strong>Acciones</strong></p></th>
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
                                    //$cuentafilas = $cuentafilas + 1;
                                    ?>

                                     <tr>
                                     <td><?php echo $row['factura']; ?></td>
                                     <td align="center"><p class='small'><?php echo $row['strtipo']; ?></p></td>
                                     <td align="center"><p class='small'><?php echo $row['strestado']; ?></p></td>
                                     <td align="center"><p class='small'><?php echo $row['proveedor']; ?></p></td>
                                     <td align="center"><p class='small'><?php echo $row['fecha']; ?></p></td>
                                     <td align="center"><p class='small'><?php echo $row['usuario']; ?></p></td>
                                     <td align="center"><p class='small'><?php echo $row['numsubtotal']; ?></p></td>
                                     <td align="center"><p class='small'><?php echo $row['numdescuento']; ?></p></td>
                                     <td align="center"><p class='small'><?php echo $row['numiva']; ?></p></td>
                                     <td align="center"><p class='small'><?php echo $row['numtotal']; ?></p></td>
                                     <td>
                                        <div class="btn-group pull-right">
									                       <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
								                          <ul class="dropdown-menu">
                                                <li><a href="#" class="cobro" data-target="#cobrosModal" data-toggle="modal" data-id="<?php echo $row['numerofactura'] ?>" id="<?php echo $row['numerofactura'] ?>"><i class="fa fa-dollar"></i> Cobros</a></li>
																		            <li><a href="#" onclick="view_pdf('<?php echo base64_encode($row['numerofactura']) ?>');"><i class="fa fa-file-pdf-o"></i> Ver PDF</a></li>
                                                <?php if($row_permiso_facturas_estado == 't') { ?>
																			          <li><a href="#" onclick="eliminar('<?php echo base64_encode($row['intidserie']) ?>','<?php echo base64_encode($row['numerofactura']) ?>')"><i class="fa fa-trash"></i> Anular</a></li>
                                                <?php } ?>
																	        </ul>
							                          </div>
                                     </td>
                                     </tr>

                                   <?php } }  ?>
                                                     </tbody>
                                                  </table>


                                   <br>

                </div>
              </div>



         </div>
     </div>
     <br>

            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
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

    <script src="../vendor/daterangepicker/moment.min.js"></script>

     <script src="../vendor/daterangepicker/daterangepicker.min.js"></script>

     <script src="../js/VentanaCentrada.js"></script>


<script type="text/javascript">

$(function() {
		   $('#tblfacturas').DataTable(
         {
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
         }
       );
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
        //VentanaCentrada('imprimir_compra.php?factura='+id,'Reimprimir factura','','1024','768','true');
        VentanaCentrada('imp_compra.php?print=true&factura='+id,'Reimprimir factura','','1024','768','true');
    }

</script>

<script>

		function eliminar(id,fact){
			if(confirm('Esta acción  eliminará de forma permanente la compra \n\n Desea continuar?')){

        var parametros = {"id":id,"fact":fact};

				$.ajax({
					url:'nueva_factura_comp.php',
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

    $(document).on('click', '.nuevo_recibo', function(){

         var idfactura = $(this).attr("id");

         $.ajax({
            type: "POST",
            url: "fnabonocred.php",
            data: {numfactura:idfactura},
            dataType:"JSON",
            beforeSend: function(objeto){
             //$("#loader2").html("Mensaje: Cargando...");
             },
           success: function(datos)
           {
            //$("#loader2").html("");
            //$(".outer_div2").html(datos).fadeIn('slow');
            $('#nombre_cliente').val(datos.proveedor);
            $('#fecha_recibo').val(datos.fecha_actual);
            $('#numero_recibo').val(datos.numero_recibo);
            $('#numero_factura').val(datos.numerofactura);
           }
       });

         });

    $(document).on('click', '.cobro', function(){

         var idfactura = $(this).attr("id");

         $.ajax({
           type: "POST",
           url: "fnabonocred.php",
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

         $( "#agregar_cobro" ).submit(function( event ) {

         $('#btnguardar_recibo').attr("disabled", true);
         var num_factura = $('#numero_factura').val();
         var parametros = $(this).serialize();

          $.ajax({
             type: "POST",
             url: "fnabonocred.php",
             data: parametros,
             success: function(datos){

             $("#msg").html(datos);

             $('#btnguardar_recibo').attr("disabled", false);

             $.ajax({
               type: "POST",
               url: "fnabonocred.php",
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

         function print_charge(doc_recibo,doc_factura){
     			VentanaCentrada('recibocred.php?factura='+doc_factura +'&recibo=' + doc_recibo,'Recibo','','900','620','true');
     		}


        function eliminar_cobro(recibo,comprobante){
    			if(confirm('Esta acción  eliminará de forma permanente el cobro \n\n ¿Desea continuar?')){

    				$.ajax({
              type: "POST",
    					url:'fnabonocred.php',
    					data: {doc_recibo : recibo,  fact_comprobante : comprobante},
    					 beforeSend: function(objeto){
    					$("#loader2").html('<img src="../img/ajax-loader.gif" alt="loading"/> Cargando...');
    				  },
    					success:function(data){
    						$(".outer_div2").html(data).fadeIn('slow');
    						$("#loader2").html("");

                $.ajax({
                   type: "POST",
                   url: "fnabonocred.php",
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
	</script>

</body>

</html>
