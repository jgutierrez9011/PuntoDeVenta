<?php
require_once 'cn.php';
require_once 'reg.php';

  $detalle = 0; $estado ="";
  $result = pg_query(conexion_bd(1),"SELECT * FROM public.tblcatdescuento
ORDER BY intidimpuesto ASC");
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

   <style type="text/css">
   table.dataTable thead tr {
     background-color: grey;
     color: #ffffff;
   }
   </style>


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

             <h2 align="left">Listado de descuentos</h2>
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
                       <a href="#new" role="button" class="btn btn-primary pull-right" data-toggle="modal"><strong><i class="fa fa-plus"></i> Nuevo descuento</strong></a>
                </div>
            </div>
          </form>

             <br>


             <div class="row">
               <div class="table-responsive">
               <br>
                 <table class="table table-striped table-bordered" id="tbltipoproducto" style="width:100%">
                     <thead>
                       <tr>
                          <th><p class="small"><strong>No.</strong></p></th>
                          <th><p class="small"><strong>Descripción</strong></p></th>
                          <th><p class="small"><strong>Valor</strong></p></th>
                          <th><p class="small"><strong>Estado</strong></p></th>

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
                                    $valor = "";
                                if($row["bolactivo"]=='t'){

                                    $valor = $row["bolactivo"];
                                    $estado='<span id="'.$valor .'" class="label label-success">ACTIVO</span>';

                                }elseif($row["bolactivo"]=='f'){

                                    $valor = $row["bolactivo"];
                                    $estado='<span id="'.$valor .'" class="label label-danger">INACTIVO</span> ';

                                }
                                    ?>

                                     <tr>
                                     <td><?php echo $row['intidimpuesto']; ?></td>
                                     <td align="center"><p class='small' ><?php echo $row['descripcion']; ?></p>
                                     <input type="hidden" id="descripcion_<?php echo $row['intidimpuesto']; ?>" value="<?php echo $row['descripcion']; ?>" />
                                     </td>

                                     <td align="center"><p class='small'><?php echo $row['numvalor']; ?></p>
                                     <input type="hidden" id="valor_<?php echo $row['intidimpuesto']; ?>" value="<?php echo $row['numvalor']; ?>" />
                                     </td>

                                     <td align="center"><p class='small'><?php echo $estado; ?></p>
                                     <input type="hidden" id="estado_<?php echo $row['intidimpuesto']; ?>" value="<?php echo $row['bolactivo']; ?>" />
                                     </td>

                                     <td>
                                       <div class="btn-group pull-right">
                                       <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
                                        <ul class="dropdown-menu">
                                              <li><a href="#update" class="edit_data" id="<?php echo $row['intidimpuesto']; ?>" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Editar</a>

                                              </li>
                                            <!--  <li><a href="#" onclick="eliminar('1853')"><i class="fa fa-trash"></i> Anular</a></li> -->
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
               <h3 id="myModalLabel" align="center">Nuevo descuento</h3>
           </div>
           <div class="modal-body">
             <form role="form" name="frm_add_descuento" id="frm_add_descuento" method="post">
               <div class="form-group">
                 <strong>Descripcion </strong><br>
                 <input type="text" id="descripcion_descuento" name="descripcion_descuento" placeholder="00.00 %" class="form-control" autocomplete="off" required>
               </div>
               <br>

               <div class="form-group">
                 <strong>Valor </strong><br>
                 <input type="number" id="valor_descuento" name="valor_descuento" class="form-control" step=".01" placeholder="00.00" autocomplete="off" required>
               </div>
               <br>

             <div class="modal-footer">
                 <button class="btn" data-dismiss="modal" aria-hidden="true"><strong>Cerrar</strong></button>
                 <button type="submit" id="btn_add_descuento" name="btn_add_descuento" class="btn btn-primary"><strong>Guardar</strong></button>
             </div>
             </form>
           </div>
        </div>
     </div>
   </div>

   <!-- Modal -->
  <div id="update" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
       <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h3 id="myModalLabel" align="center">Editar tipo de producto</h3>
          </div>
          <div class="modal-body">
            <form role="form" name="frm_editar_descuento" id="frm_editar_descuento" method="post">
              <div class="form-group">
                <strong>Descripcion </strong><br>
                <input type="hidden" id="id_tipo" name="id_tipo" class="form-control" autocomplete="off" required>
                <input type="text" id="descrip_descuento" name="descrip_descuento" class="form-control" autocomplete="off" required>
              </div>
              <br>

              <div class="form-group">
                <strong>Valor </strong><br>
                <input type="number" id="valor_descuento_edit" name="valor_descuento_edit" class="form-control" step=".01" placeholder="00.00" autocomplete="off" required>
              </div>
              <br>


              <div class="form-group">
                <strong>Estado </strong><br>
                <select class="form-control" id="estado_clasificacion_edit" name="estado_clasificacion_edit" required>
                <option value="true">ACTIVO</option>
                <option value="false">INACTIVO</option>
                </select>
              </div>
              <br>

            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true"><strong>Cerrar</strong></button>
                <button type="submit" id="editar_descuento" name="editar_descuento" class="btn btn-primary"><strong>Guardar</strong></button>
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
       $(document).on('click', '.edit_data', function(){

       var id_tipo = $(this).attr("id");
       var descripcion =  document.getElementById("descripcion_"+id_tipo).value;
       var valor = document.getElementById("valor_"+id_tipo).value;
       var estado = document.getElementById("estado_"+id_tipo).value;
       $('#id_tipo').val(id_tipo);
       $('#descrip_descuento').val(descripcion);
       $('#valor_descuento_edit').val(valor);

       if(estado == "t")
       {
          $("#estado_clasificacion_edit option[value='true'").attr("selected",true);
       }else if (estado == "f") {
          $("#estado_clasificacion_edit option[value='false'").attr("selected",true);
       }

       });

     $('#tbltipoproducto').DataTable(
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

	});


  $( "#frm_add_descuento" ).submit(function( event ) {
  $('#btn_add_descuento').attr("disabled", true);
  var parametros = $(this).serialize();
   $.ajax({
      type: "POST",
      url: "fndescuento.php",
      data: parametros,
       beforeSend: function(objeto){
        $("#resultados_ajax").html("Enviando...");
        },
      success: function(datos){
      $("#resultados_ajax").html(datos);
      $('#btn_add_descuento').attr("disabled", false);
      //load(1);
      window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
      $(this).remove(); location.reload();});}, 5000);
      $('#new').modal('hide');
      }
  });
  event.preventDefault();
  })

  $( "#frm_editar_descuento" ).submit(function( event ) {
  $('#editar_descuento').attr("disabled", true);
  var parametros = $(this).serialize();
   $.ajax({
      type: "POST",
      url: "fndescuento.php",
      data: parametros,
       beforeSend: function(objeto){
        $("#resultados_ajax").html("Enviando...");
        $('#update').modal('hide');
        },
      success: function(datos){
      $("#resultados_ajax").html(datos);
      $('#editar_descuento').attr("disabled", false);
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
