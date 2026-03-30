<?php
require_once 'cn.php';
require_once 'reg.php';
//require_once 'fnusuario.php';

if(isset($_POST["inactivar"]))
{
   baja_colaborador($_POST["fechabaja"],$_POST["idempleado"],$_SESSION['user']);
};

$estado="";
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="../img/icon.png">
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
                  <?php require_once 'logo.php'; ?>
              </div>

              <h4 class="page-header  mb-3 text-center">Buscar usuario</h4>

              <br>
              <form class="needs-validation" method="post" action="">
                 <!-- Primera linea de campos en el fromulario-->
                <br>
                <div class="row">
                      <div class="col-md-4">
                         <a href="usuarios.php" class="btn btn-primary" role="button">Nuevo usuario</a>
                      </div>
                </div>
              		<br>
              </form>
          <br>
          <div class="row">
            <?php

            $cn =  conexion_bd(1);

             $sql = "SELECT intid, concat(strpnombre::text,' ',strsnombre::text,' ',strpapellido::text,' ',strsapellido::text) nombre_usuario, strsexo,
                     strcorreo, stridentificacion, strdireccion, strcontacto, strusuariocreo,
                     datfechacreo, strusuariomodifico, datfechamodifico, datfechabaja,
                     a.bolactivo, strpassword, intidperfil, strperfil
                     FROM public.tblcatusuario a
                     left join tblcatperfilusr b on a.intidperfil = b.idperfil";

             $resul = pg_query($cn,$sql);

             $retorno = "<div class='row table-responsive'>
                            <table class='display nowrap stripe row-border order-column' id='mitabla' style='width:100%'>
                        <thead>
                        <tr>
                        <th><p class='small'><strong>Registro</strong></p></th>
                        <th><p class='small'><strong>Nombre</strong></p></th>
                        <th><p class='small'><strong>Sexo</strong></p></th>
                        <th><p class='small'><strong>Correo</strong></p></th>
                        <th><p class='small'><strong>Identificacion</strong></p></th>
                        <th><p class='small'><strong>Direccion</strong></p></th>
                        <th><p class='small'><strong>Contacto</strong></p></th>
                        <th><p class='small'><strong>Correo</strong></p></th>
                        <th><p class='small'><strong>Usuario creo</strong></p></th>
                        <th><p class='small'><strong>Fecha creo</strong></p></th>
                        <th><p class='small'><strong>Usuario modifico</strong></p></th>
                        <th><p class='small'><strong>Fecha modifico</strong></p></th>
                        <th><p class='small'><strong>Fecha baja</strong></p></th>
                        <th><p class='small'><strong>Perfil</strong></p></th>
                        <th><p class='small'><strong></strong></p></th>
                        <th><p class='small'><strong></strong></p></th>
                        </tr>
                        </thead>
                        <tbody>";
              while ($row = pg_fetch_array($resul)){
                        //$estado="";
                        $valor = "";
                    if($row["bolactivo"]=='t'){

                        $valor = $row["bolactivo"];
                        $estado='<span id="'.$valor .'" class="label label-success">ACTIVO</span>';

                    }elseif($row["bolactivo"]=='f'){

                        $valor = $row["bolactivo"];
                        $estado='<span id="'.$valor .'" class="label label-danger">INACTIVO</span> ';

                    }
                    $retorno = $retorno."<tr>
                                         <td><p class='small'>".$row["intid"]."</p></td>
                                         <td><p class='small'>".$row["nombre_usuario"]."</p></td>
                                         <td><p class='small'>".$row["strsexo"]."</p></td>
                                         <td><p class='small'>".$row["strcorreo"]."</p></td>
                                         <td><p class='small'>".$row["stridentificacion"]."</p></td>
                                         <td><p class='small'>".$row["strdireccion"]."</p></td>
                                         <td><p class='small'>".$row["strcontacto"]."</p></td>
                                         <td><p class='small'>".$row["strcorreo"]."</p></td>
                                         <td><p class='small'>".$row["strusuariocreo"]."</p></td>
                                         <td><p class='small'>".$row["datfechacreo"]."</p></td>
                                         <td><p class='small'>".$row["strusuariomodifico"]."</p></td>
                                         <td><p class='small'>".$row["datfechamodifico"]."</p></td>
                                         <td><p class='small'>".$row["datfechabaja"]."</p></td>
                                         <td><p class='small'>".$row["strperfil"]."</p></td>
                                         <td><a data-toggle='modal' data-target='#confirm-delete' id='".$row["intid"]."' class='edit_data'><center>". $estado ."</center></a> <input type='hidden' id='estado_".$row["intid"]."' value=".   $valor ." /> </td>
                                         <td><p class='small'><a href='usuariosedit.php?id=".base64_encode($row["intid"])."' data-toggle='tooltip' title='Editar'><span class='glyphicon glyphicon-pencil'></span></a></p></td>
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
            <h4 class="modal-title" id="myModalLabel">Activar/Inactivar usuario</h4>
          </div>

          <div class="modal-body">

            <form role="form" action="fnusuario.php" method="post">

                   <div class="form-group">
                       <label for="inputName">Fecha</label>
                       <input type="date" class="form-control" id="fechabaja" name="fechabaja" required/>
                   </div>

                   <div class="form-group">
                       <input type="hidden" class="form-control" id="idempleado" name="idempleado"/>
                       <input type="hidden" class="form-control" id="estado_usuario" name="estado_usuario"/>
                   </div>

                   <input type="submit" name="inactivar" id="inactivar" value="Desactivar" class="btn btn-danger"/>

                   <input type="submit" name="activar" id="activar" value="Activar" class="btn btn-success"/>

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
           var estado = $("#estado_" + employee_id).val();

           $('#idempleado').val(employee_id);
           $('#estado_usuario').val(estado);

             if(estado == 't'){
               $("#inactivar").show();
               $("#activar").hide();
             }else {
               $("#inactivar").hide();
               $("#activar").show();
             }

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
