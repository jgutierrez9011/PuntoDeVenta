<?php
require_once 'cn.php';
require_once 'reg.php';
//require_once 'fnusuario.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

        <?php include 'icon.php' ?>
    <title>Admin Gym</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- css para plugin datatable  -->
		<link rel="stylesheet" type="text/css" href="../vendor/datatables/css_/jquery.dataTables.min.css">

		<link rel="stylesheet" type="text/css" href="../vendor/datatables/css_/buttons.dataTables.min.css">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery-3.3.1.min.js"></script>

    <!--script para cambiar etiquetas a datatable -->
  <script>
         $(document).ready(function(){
           $('#mitabla').DataTable({
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
         });
</script>


<style type="text/css">
table.dataTable thead tr {
  background-color: grey;
  color: #ffffff;
}
</style>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

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

              <h4 class="page-header  mb-3 text-center">Listado de productos</h4>

              <br>
              <form class="needs-validation" method="post" action="">
                 <!-- Primera linea de campos en el fromulario-->
                <br>
                <div class="row">
                      <div class="col-md-4">
                         <a href="nuevo_producto.php" class="btn btn-primary" role="button"><i class='fa fa-plus'></i> Nuevo producto</a>
                      </div>
                </div>
              		<br>
              </form>
          <br>
          <div class="row">
            <?php

            $cn =  conexion_bd(1);

             $sql = "SELECT a.intidproducto, a.strnombre, a.presentacion, a.strdescripcion, a.strfabricante, a.strtipo, b.strtipo tipo, a.strclasingreso, a.numcosto, a.numutilidad
                     ,a.numprecioventa,
                     case when a.bolcontrolinventario = true then 'Control de inventario'
 else 'Sin control de inventario' end inventario, a.intstock, a.strimagenproducto, a.strusuariocreo, a.datfechacreo, a.strusuariomodifico, a.datfechamodifico,
 case when a.strestado = true then 'Activo'
 ELSE 'Inactivo' end estado
                     from tblcatproductos a
                     inner join tblcattipoproducto b on a.strtipo::int = b.intidtipoproducto";

             $resul = pg_query($cn,$sql);

             $retorno = "<div class='row table-responsive'>
                            <table class='table table-striped table-bordered table-hover' id='mitabla' style='width:100%'>
                        <thead>
                        <tr>
                        <th><p class='small'><strong>Registro</strong></p></th>
                        <th><p class='small'><strong>Imagen de producto</strong></p></th>
                        <th><p class='small'><strong>Acciones</strong></p></th>
                        <th><p class='small'><strong>Nombre</strong></p></th>
                        <th><p class='small'><strong>Presentación</strong></p></th>
                        <th><p class='small'><strong>Descripción</strong></p></th>
                        <th><p class='small'><strong>Distribuidor / Fabricante</strong></p></th>
                        <th><p class='small'><strong>Tipo de producto</strong></p></th>
                        <th><p class='small'><strong>C$ Costo</strong></p></th>
                        <th><p class='small'><strong>C$ Utilidad</strong></p></th>
                        <th><p class='small'><strong>C$ Precio de venta</strong></p></th>
                        <th><p class='small'><strong>Stock inicial</strong></p></th>
                        <th><p class='small'><strong>Estado</strong></p></th>
                        <th><p class='small'><strong>Control de inventario</strong></p></th>
                        </tr>
                        </thead>
                        <tbody>";
              while ($row = pg_fetch_array($resul)){

                    $retorno = $retorno."<tr>
                                         <td><p class='small'>".$row["intidproducto"]."</p></td>
                                         <td><a href='".$row["strimagenproducto"]."' target='_blank'><img src='".$row["strimagenproducto"]."'  width='50' height='50'></a></td>
                                         <td><p class='small'><a href='editar_producto.php?codigo=".base64_encode($row["intidproducto"])."' data-toggle='tooltip' title='Editar'><span class='glyphicon glyphicon-pencil'></span></a></p></td>
                                         <td><p class='small'>".$row["strnombre"]."</p></td>
                                         <td><p class='small'>".$row["presentacion"]."</p></td>
                                         <td><p class='small'>".$row["strdescripcion"]."</p></td>
                                         <td><p class='small'>".$row["strfabricante"]."</p></td>
                                         <td><p class='small'>".$row["tipo"]."</p></td>
                                         <td><p class='small'>".$row["numcosto"]."</p></td>
                                         <td><p class='small'>".$row["numutilidad"]."</p></td>
                                         <td><p class='small'>".$row["numprecioventa"]."</p></td>
                                         <td><p class='small'>".$row["intstock"]."</p></td>
                                         <td><p class='small'>".$row["estado"]."</p></td>
                                         <td><p class='small'>".$row["inventario"]."</p></td>

                                         </tr>";}
                    $retorno = $retorno."</tbody>
                                         </table>
                                         </div>";

                    echo $retorno;
             ?>
        <br>
          </div>

      <!-- Boton fuera de formulario para retornar al index -->

    <!--  <div class="row">

      <div class="col-md-4">
      <a href="colaboradores.php" class="btn btn-info" role="button">Regresar</a>
      </div>

      </div> -->

            </div>
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

    <!-- Modal -->
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Inactivar/Baja al colaborador</h4>
          </div>

          <div class="modal-body">

            <form role="form" action="consulcolaborador.php" method="post">
                   <div class="form-group">
                       <label for="inputName">Fecha de baja</label>
                       <input type="date" class="form-control" id="fechabaja" name="fechabaja" required/>
                   </div>
                   <div class="form-group">
                       <input type="hidden" class="form-control" id="idempleado" name="idempleado"/>
                   </div>
                   <input type="submit" name="inactivar" id="inactivar" value="Inactivar" class="btn btn-danger"/>
            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>

    <script>

    $(document).ready(function(){

      $(document).on('click', '.edit_data', function(){

           var employee_id = $(this).attr("id");
           $('#idempleado').val(employee_id);
           });

      });

		</script>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- jquery para plugin datatable permite exportar a excel, csv, pdf  -->
    <!-- <script type="text/javascript" src="../vendor/jquery/exp/jquery-1.12.4.js"></script> -->
    <script type="text/javascript" src="../vendor/datatables/js_/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../vendor/datatables/js/dataTables.fixedColumns.min.js"></script>

    <script type="text/javascript" src="../vendor/jquery/exp/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/buttons.flash.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/jszip.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/pdfmake.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/vfs_fonts.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/buttons.html5.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/buttons.print.min.js"></script>


</body>

</html>
