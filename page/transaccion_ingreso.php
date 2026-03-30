<?php
require_once 'cn.php';
require_once 'reg.php';
require_once 'fntrasaccion_contab.php';
//require_once 'funciones/fncontabilidad.php';

  $detalle = 0;

  if(isset($_POST['fecha_inicio']))
  {
    $fechaini = $_POST['fecha_inicio'];
    $fechafin = $_POST['fecha_final'];

  $result = pg_query(conexion_bd(1),"SELECT a.intidregingreso, a.datingreso, b.strnombrecuenta, c.strnombrecategoria, a.strdescripcion, a.nummonto, a.intidcuenta, a.intidclasingreso
  from tbltrningresos a
  inner join tablcatcuentas b on a.intidcuenta = b.intidcuenta
  inner join tblcatingresos c on a.intidclasingreso = c.intidclasingreso where a.datingreso::date between '$fechaini' and '$fechafin'")  ;
  $detalle = pg_affected_rows($result);

  /*date_default_timezone_set("America/Managua");
  $fecha = date('d/m/Y');
  $fecha_ = date('d/m/Y');*/
  }
  else
  {
    $result = pg_query(conexion_bd(1),"SELECT a.intidregingreso, a.datingreso, b.strnombrecuenta, c.strnombrecategoria, a.strdescripcion, a.nummonto, a.intidcuenta, a.intidclasingreso
    from tbltrningresos a
    inner join tablcatcuentas b on a.intidcuenta = b.intidcuenta
    inner join tblcatingresos c on a.intidclasingreso = c.intidclasingreso");
    $detalle = pg_affected_rows($result);
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

             <h2 align="left">Ingresos</h2>
             <hr>
             <br>

             <div id="resultados_ajax"></div>
          <!--   <div class="row">
                <div class="col-md-12">
             <a href="nueva_venta.php" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Nueva venta</a>
                 </div>
             </div>
             <br> -->
             <form role="form" method="post" action="transaccion_ingreso.php">
             <div class="row">
               <div class="col-md-3">

            <!--    <div class="input-group">
                     <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                     </div>
                 <input type="text" class="form-control pull-right active" value="<?php //echo $fecha." - ".$fecha_  ?>" id="range" name="range" readonly="">

                 <span class="input-group-btn">
							   <button class="btn btn-default" type="submit" onclick='fecha();'><i class='fa fa-search'></i></button>
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
                       <!--<a href="nueva_venta.php" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Agregar cuenta</a> -->
                       <a href="#new" role="button" class="btn btn-primary pull-right" data-toggle="modal"><strong><i class="fa fa-plus"></i> Agregar ingreso</strong></a>
                </div>
            </div>
          </form>

             <br>


             <div class="row">
               <div class="table-responsive">
               <br>
                 <table class="table table-striped table-bordered" id="tblingresos" style="width:100%">
                     <thead>
                       <tr>
                          <th><p class="small"><strong>Fecha</strong></p></th>
                          <th><p class="small"><strong>cuenta</strong></p></th>
                          <th><p class="small"><strong>Categoría</strong></p></th>
                          <th><p class="small"><strong>Descripción</strong></p></th>
                          <th><p class="small"><strong>Cantidad</strong></p></th>
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
                                     <td>
                                         <p class='small'><?php echo $row['datingreso']; ?></p>
                                         <input type="hidden" name="fecha_ingreso_<?php echo $row['intidregingreso']; ?>" id="fecha_ingreso_<?php echo $row['intidregingreso']; ?>" value="<?php echo $row['datingreso'] ?>" />
                                     </td>
                                     <td align="center">
                                            <p class='small'><?php echo $row['strnombrecuenta']; ?></p>
                                            <input type="hidden" name="codigo_cuenta_<?php echo $row['intidregingreso']; ?>" id="codigo_cuenta_<?php echo $row['intidregingreso']; ?>" value="<?php echo $row['intidcuenta'] ?>" />
                                     </td>
                                     <td align="center">
                                            <p class='small'><?php echo $row['strnombrecategoria']; ?></p>
                                            <input type="hidden" name="codigo_ingreso_<?php echo $row['intidregingreso']; ?>" id="codigo_ingreso_<?php echo $row['intidregingreso']; ?>" value="<?php echo $row['intidclasingreso']; ?>" />
                                     </td>
                                     <td align="center">
                                           <p class='small'><?php echo $row['strdescripcion']; ?></p>
                                           <input type="hidden" name="descripcion_ingreso_<?php echo $row['intidregingreso']; ?>" id="descripcion_ingreso_<?php echo $row['intidregingreso']; ?>" value="<?php echo $row['strdescripcion']; ?>" />
                                     </td>
                                     <td align="center">
                                            <p class='small'><?php echo $row['nummonto']; ?></p>
                                            <input type="hidden" name="editar_monto_<?php echo $row['intidregingreso']; ?>" id="editar_monto_<?php echo $row['intidregingreso']; ?>" value="<?php echo $row['nummonto']; ?>" />
                                     </td>
                                     <td>
                                       <div class="btn-group pull-right">
                                       <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
                                        <ul class="dropdown-menu">
                                              <li><a href="#edit" class="edit_data"  id="<?php echo $row['intidregingreso']; ?>" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Editar</a></li>
                                              <li><a href="#" onclick="eliminar('1853')"><i class="fa fa-trash"></i> Anular</a></li>
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

    <!-- /#wrapper -->
    <!-- Modal -->
   <div id="new" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-md">
        <div class="modal-content">
           <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               <h3 id="myModalLabel" align="center">Nuevo ingreso</h3>
           </div>
           <div class="modal-body">
             <form role="form" name="frm_registrar_ingreso" id="frm_registrar_ingreso" method="post">
               <div class="m-b-20">
                                     <div class="row">
                                         <div class="col-md-12">
                                             <div class="form-group">
                                                 <label>Cuenta a creditar <span class="text-danger">*</span></label>
                                                 <div class="">
                                                     <select class="select2 form-control" name="account" required>
                                                       <?php echo fill_cuenta('N'); ?>
                                                 </select>
                                                 </div>
                                             </div>
                                         </div>

                                         <div class="col-md-12">
                                             <div class="form-group">
                                                 <label>Fecha <span class="text-danger">*</span></label>
                                                 <div class="cal-icon">
                                                      <input class="form-control" type="date"  name="date" value="04/04/2021">
                                                  </div>
                                             </div>
                                      </div>

                                      <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Descripción <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="description" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Monto <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text"  name="amount" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                           <div class="form-group">
                                               <label>Categoría <span class="text-danger">*</span></label>
                                               <select class="form-control col-xs-3" name="category" required>
                                                  <?php echo fill_cat_ingresos('N'); ?>
                                                                                                        </select>
                                           </div>
                                       </div>

                </div>
              </div>


             <div class="modal-footer">
                 <button class="btn" data-dismiss="modal" aria-hidden="true"><strong>Cerrar</strong></button>
                 <button type="submit" id="guardar_ingreso" name="guardar_ingreso" class="btn btn-primary"><strong>Guardar</strong></button>
             </div>
             </form>
           </div>
        </div>
     </div>
   </div>

   <!-- Modal -->
  <div id="edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
       <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h3 id="myModalLabel" align="center">Editar ingreso</h3>
          </div>
          <div class="modal-body">
            <form role="form" name="frm_editar_ingreso" id="frm_registrar_ingreso" method="post">
              <div class="m-b-20">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Cuenta a creditar <span class="text-danger">*</span></label>
                                                <div class="">
                                                    <select class="select2 form-control" name="account_edit" id="account_edit" required>
                                                      <?php //echo fill_cuenta('N'); ?>
                                                </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Fecha <span class="text-danger">*</span></label>
                                                <div class="cal-icon">
                                                     <input class="form-control" type="date"  name="date_edit" id="date_edit" value="04/04/2021">
                                                 </div>
                                            </div>
                                     </div>

                                     <div class="col-md-12">
                                           <div class="form-group">
                                               <label>Descripción <span class="text-danger">*</span></label>
                                               <input class="form-control" type="text" name="description_edit" id="description_edit" required>
                                           </div>
                                       </div>

                                       <div class="col-md-12">
                                           <div class="form-group">
                                               <label>Monto <span class="text-danger">*</span></label>
                                               <input class="form-control" type="text"  name="amount_edit" id="amount_edit" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" required>
                                           </div>
                                       </div>

                                       <div class="col-md-12">
                                          <div class="form-group">
                                              <label>Categoría <span class="text-danger">*</span></label>
                                              <select class="form-control col-xs-3" name="category_edit" id="category_edit" required>
                                                 <?php //echo fill_cat_ingresos('N'); ?>
                                                                                                       </select>
                                          </div>
                                      </div>

               </div>
             </div>


            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true"><strong>Cerrar</strong></button>
                <button type="submit" id="btn_editar_ingreso" name="btn_editar_ingreso" class="btn btn-primary"><strong>Guardar</strong></button>
            </div>
            </form>
          </div>
       </div>
    </div>
  </div>

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

     <script src="../vendor/daterangepicker/daterangepicker.min.js"></script>

     <script src="../js/VentanaCentrada.js"></script>


<script type="text/javascript">

$(function() {

  $(document).on('click', '.edit_data', function()
  {

  var id_ingreso = $(this).attr("id");
  var cuenta =   document.getElementById("codigo_cuenta_"+id_ingreso).value;
  var categoria =   document.getElementById("codigo_ingreso_"+id_ingreso).value;
  var descripcion =   document.getElementById("descripcion_ingreso_"+id_ingreso).value;
  var monto =   document.getElementById("editar_monto_"+id_ingreso).value;
  var fecha =   document.getElementById("fecha_ingreso_"+id_ingreso).value;
  $('#description_edit').val(descripcion);
  $('#amount_edit').val(monto);
  $('#date_edit').val(fecha);


  $.post('fntrasaccion_contab.php', { clasificacion: categoria } ).done(function (respuesta)
   {
     $('#category_edit').html(respuesta);

   });

   $.post('fntrasaccion_contab.php', { clasificacion_cuenta: cuenta } ).done(function (respuesta)
    {
      $('#account_edit').html(respuesta);

    });

  });

     $('#tblingresos').DataTable({
       "fixedColumns":   {
                          "leftColumns": 1
                         },
       "order": [[1, "asc"]],
       "dom":'Bfrtip',
       "buttons": ['copy','csv','excel','pdf','print'],
       "language":{
         "lengthMenu": "Mostrar _MENU_ registros por pagina",
         "info": "Mostrando pagina _PAGE_ de _PAGES_",
         "infoEmpty": "No hay registros disponibles",
         "infoFiltered": "(filtrada de _MAX_ registros)",
         "loadingRecords": "Cargando...",
         "processing":     "Procesando...",
         "search": "Buscar:",
         "zeroRecords":    "No se encontraron registros coincidentes",
         "paginate": {
           "next":       "Siguiente",
           "previous":   "Anterior"
         },
       }
     });

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


  $( "#frm_registrar_ingreso" ).submit(function( event ) {
  $('#guardar_ingreso').attr("disabled", true);
  var parametros = $(this).serialize();
   $.ajax({
      type: "POST",
      url: "fntrasaccion_contab.php",
      data: parametros,
       beforeSend: function(objeto){
        $("#resultados_ajax").html("Enviando...");
        },
      success: function(datos){
      $("#resultados_ajax").html(datos);
      $('#guardar_ingreso').attr("disabled", false);
      //load(1);
      window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
      $(this).remove(); location.reload();});}, 5000);
      $('#new').modal('hide');
      }
  });
  event.preventDefault();
  })

</script>

</body>

</html>
