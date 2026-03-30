<?php
require_once 'cn.php';
require_once 'reg.php';

  $detalle = 0;
  $result = pg_query(conexion_bd(1),"SELECT intidclasingreso, strnombrecategoria categoria, strusuariocreo, datfechacreo fecha,
       strusuariomodifico, datfechamodifico, boolactivo
  FROM tblcatingresos");
  $detalle = pg_affected_rows($result);

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

             <h2 align="left">Categoría de ingresos</h2>
             <br>

             <div id="resultados_ajax"></div>
          <!--   <div class="row">
                <div class="col-md-12">
             <a href="nueva_venta.php" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Nueva venta</a>
                 </div>
             </div>
             <br> -->
             <form role="form" method="post" action="buscar_facturas.php">
             <div class="row">
               <div class="col-md-4">

            <!--     <div class="input-group">
                     <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                     </div>
                 <input type="text" class="form-control pull-right active" value="<?php echo $fecha." - ".$fecha_  ?>" id="range" name="range" readonly="">

                 <span class="input-group-btn">
							   <button class="btn btn-default" type="submit" onclick='fecha();'><i class='fa fa-search'></i></button>
						  </span>

            </div> -->

               </div>

                <div class="col-md-8">
                       <!--<a href="nueva_venta.php" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Agregar cuenta</a> -->
                       <a href="#new" role="button" class="btn btn-primary pull-right" data-toggle="modal"><strong><i class="fa fa-plus"></i> Agregar cuenta</strong></a>
                </div>
            </div>
          </form>

             <br>


             <div class="row">
               <div class="table-responsive">
               <br>
                 <table class="table table-striped table-bordered" id="tblfacturas" style="width:100%">
                     <thead>
                       <tr>
                          <th><p class="small"><strong>Fecha</strong></p></th>
                          <th><p class="small"><strong>Categoria</strong></p></th>
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
                                     <td><?php echo $row['fecha']; ?></td>
                                     <td align="center">
                                       <p class='small'><?php echo $row['categoria']; ?></p>
                                       <input type="hidden" id="cuenta_<?php echo $row['intidclasingreso']; ?>" value="<?php echo $row['categoria']; ?>" />
                                     </td>
                                     <td>
                                       <div class="btn-group pull-right">
                                       <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
                                        <ul class="dropdown-menu">
                                              <li>
                                                <a href="#update"  class="edit_data" id="<?php echo $row['intidclasingreso'] ?>" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Editar</a>
                                              </li>
                                              <li>
                                              <!--  <a href="#" onclick="eliminar('1853')"><i class="fa fa-trash"></i> Anular</a> -->
                                              </li>
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
               <h3 id="myModalLabel" align="center">Nueva categoría</h3>
           </div>
           <div class="modal-body">
             <form role="form" name="frm_crear_categoria_ingreso" id="frm_crear_categoria_ingreso" method="post">
               <div class="form-group">
                 <strong>Nombre</strong><br>
                 <input type="text" id="nombre_categoria_ingreso" name="nombre_categoria_ingreso" class="form-control" autocomplete="off" required>
               </div>
               <br>
             <div class="modal-footer">
                 <button class="btn" data-dismiss="modal" aria-hidden="true"><strong>Cerrar</strong></button>
                 <button type="submit" id="guardar_cat_ingreso" name="guardar_cat_ingreso" class="btn btn-primary"><strong>Guardar</strong></button>
             </div>
             </form>
           </div>
        </div>
     </div>
   </div>

   <div id="update" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-md">
        <div class="modal-content">
           <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               <h3 id="myModalLabel" align="center">Editar categoría</h3>
           </div>
           <div class="modal-body">
             <form role="form" name="frm_editar_categoria_ingreso" id="frm_editar_categoria_ingreso" method="post">
               <div class="form-group">
                 <strong>N°</strong><br>
                 <input type="text" id="id_categoria_ingreso_update" name="id_categoria_ingreso_update" class="form-control" autocomplete="off" readonly required>
               </div>
               <br>
               <div class="form-group">
                 <strong>Nombre</strong><br>
                 <input type="text" id="nombre_categoria_ingreso_update" name="nombre_categoria_ingreso_update" class="form-control" autocomplete="off" required>
               </div>
               <br>
             <div class="modal-footer">
                 <button class="btn" data-dismiss="modal" aria-hidden="true"><strong>Cerrar</strong></button>
                 <button type="submit" id="btn_guardar_cat_ingreso" name="btn_guardar_cat_ingreso" class="btn btn-primary"><strong>Guardar</strong></button>
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

    <script src="../vendor/daterangepicker/moment.min.js"></script>

     <script src="../vendor/daterangepicker/daterangepicker.min.js"></script>

     <script src="../js/VentanaCentrada.js"></script>


<script type="text/javascript">

$(function() {

      $(document).on('click', '.edit_data', function()
      {

      var id_cuenta = $(this).attr("id");
      var nombre_cuenta =   document.getElementById("cuenta_"+id_cuenta).value;
      $('#id_categoria_ingreso_update').val(id_cuenta);
      $('#nombre_categoria_ingreso_update').val(nombre_cuenta);

      });

     $('#tblfacturas').DataTable();

	});


  $( "#frm_crear_categoria_ingreso" ).submit(function( event ) {
  $('#guardar_cat_ingreso').attr("disabled", true);
  var parametros = $(this).serialize();
   $.ajax({
      type: "POST",
      url: "fncuentas.php",
      data: parametros,
       beforeSend: function(objeto){
        $("#resultados_ajax").html("Enviando...");
        },
      success: function(datos){
      $("#resultados_ajax").html(datos);
      $('#guardar_cat_ingreso').attr("disabled", false);
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

<script>
$("#frm_editar_categoria_ingreso").submit(function( event ) {

$('#btn_guardar_cat_ingreso').attr("disabled", true);

var parametros = $(this).serialize();
 $.ajax({
    type: "POST",
    url: "fncuentas.php",
    data: parametros,
     beforeSend: function(objeto){
      $("#resultados_ajax").html("Enviando...");
      },
    success: function(datos){
    $("#resultados_ajax").html(datos);
    $('#btn_guardar_cat_ingreso').attr("disabled", false);

   window.setTimeout(function() {
   $(".alert").fadeTo(500, 0).slideUp(500, function(){
   $(this).remove(); location.reload();});}, 5000);
   $('#update').modal('hide');
   }
});
event.preventDefault();
})
</script>

</body>

</html>
