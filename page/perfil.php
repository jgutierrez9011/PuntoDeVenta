<?php
require_once 'cn.php';
require_once 'reg.php';
require_once 'funciones/funciones.php';
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
    <title>Admin | Gym</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery-3.3.1.min.js"></script>

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

            <!-- <h4 align="center">Nuevo perfil</h4> -->
             <br />

             <div class="row ">
                   <table class="table table-bordered">
                     <tr class="well">
                         <td>
                               <h3 align="center">
                                Administrar perfiles de usuario<br>
                                <a href="#new" role="button" class="btn btn-primary" data-toggle="modal"><strong>Crear nuevo perfil</strong></a>
                               </h3>
                         </td>
                      </tr>
                   </table>
             </div>

             <!-- Modal -->
            <div id="new" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-md">
                 <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel" align="center">Registrar nuevo perfil</h3>
                    </div>
                    <div class="modal-body">
                      <form name="xx" action="" method="post">
                        <div class="form-group">
                          <strong>Descripcion del perfil</strong><br>
                          <input type="text" name="nombre" class="form-control" autocomplete="off" required value="">
                        </div>
                      <div class="modal-footer">
                          <button class="btn" data-dismiss="modal" aria-hidden="true"><strong>Cerrar</strong></button>
                          <button type="submit" class="btn btn-primary"><strong>Registrar</strong></button>
                      </div>
                      </form>
                    </div>
                 </div>
              </div>
            </div>

             <?php

             if(!empty($_POST['nombre']))
                 {
                         $conexion = conexion_bd(1);
                         $nombre=limpiar($_POST['nombre']);
                         if(!empty($_POST['id'])){
                           $id=limpiar($_POST['id']);
                           pg_query($conexion," UPDATE tblcatperfilusr SET strperfil='$nombre'  WHERE idperfil = $id ");
                           echo mensajes("El perfil ha sido actualizado con exito","verde");
                         }else{

                           pg_query($conexion,"INSERT INTO tblcatperfilusr(strperfil, bolactivo) VALUES ('$nombre', 'True');");

                           $sql=pg_query($conexion,"SELECT MAX(idperfil) as idperfil FROM tblcatperfilusr");
                           if($row=pg_fetch_array($sql)){	$id_perfil=$row['idperfil'];		}

                           $sql=pg_query($conexion,"SELECT idfrm, strformulario, strnombreform, bolestado FROM tblcatformularios;");
                           
                           while($row=pg_fetch_row($sql)){
                             $id_formulario=$row[0];
                             pg_query($conexion,"INSERT INTO tblcatperfilusrfrm (idfrm, idperfil, bolactivo) VALUES ( $id_formulario, $id_perfil, 'False')");
                           }

                           $sql2=pg_query($conexion,"SELECT intidmenu, strmenu, strtipomenu, strnivelmenu, bolactivo FROM tblcatmenu;");
                           while($row=pg_fetch_row($sql2)){
                             $id_menu=$row[0];
                             pg_query($conexion,"INSERT INTO tblcatmenuperfil(idperfil, intidmenu, bolactivo) VALUES ( $id_perfil, $id_menu, 'False')");
                           }

                           $sql3=pg_query($conexion,"SELECT idfrmdetalle, idfrm, strnombreelemento, strtipotag, bolestado from tblcatformulariodetalle order by idfrmdetalle asc, idfrm asc;");
                           while($row=pg_fetch_row($sql3)){
                             $id_frmdet=$row[0];
                             pg_query($conexion,"INSERT INTO tblcatperfilusrfrmdetalle(idfrmdetalle, idperfil, bolactivo) VALUES ( $id_frmdet, $id_perfil, 'False')");
                           }

                           echo mensajes("El perfil ha sido registrado con exito","verde");
                         }
                 }
              ?>

             <div class="row table-responsive">
               <table class="table table-bordered">
                 <tr class="well">
                     <td><strong>Descripcion de perfil</strong></td>
                       <td width="20%"></td>
                   </tr>
                   <?php
               $conexion = conexion_bd(1);
               $sql=pg_query($conexion,"SELECT idperfil, strperfil, bolactivo FROM tblcatperfilusr;");
               while($row=pg_fetch_array($sql)){
                 $nn=0;
                 $url=$row['idperfil'];
                 $sql2=pg_query($conexion,"SELECT a.idperfilusrfrm, b.strformulario, a.bolactivo
                                           FROM tblcatperfilusrfrm as a
                                           inner join tblcatformularios as b on a.idfrm = b.idfrm
                                           WHERE a.idperfil= $row[0] and a.bolactivo ='True'");
                 while($row2=pg_fetch_row($sql2)){
                   $nn++;
                 }

                 if($nn==0){
                   $color='btn btn-danger btn-xs';
                 }else{
                   $color='btn btn-primary btn-xs';
                 }
             ?>
                   <tr>
                     <td><?php echo $row[1]; ?></td>
                       <td>
                           <center>
                               <div class="btn-group btn-group-xs">
                                   <a data-target="#m<?php echo $row[0]; ?>" role="button"   class="btn btn-default btn-xs" data-toggle="modal"><i class="fa fa-edit"></i> <strong>Editar Perfil</strong></a>
                                   <a href="perfiladmin.php?id=<?php echo $url; ?>" class="<?php echo $color; ?>"><i class="fa fa-list-ul"></i> <strong>Admin</strong></a>
                               </div>
                           </center>
                       </td>
                   </tr>

                   <!-- Modal -->
                   <div id="m<?php echo $row[0]; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                     <div class="modal-dialog modal-md">
                       <div class="modal-content">
                               <div class="modal-header">
                                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                   <h3 class="modal-title" id="myModalLabel">Actualizar Perfil</h3>
                               </div>
                        <div class="modal-body">

                          <form name="foms" action="" method="post">
                            <div class="form-group">
                              <strong>Descripcion del perfil</strong><br>
                                <input type="hidden" name="id" class="form-control" value="<?php echo $row[0]; ?>">
                                <input type="text" name="nombre" class="form-control" autocomplete="off" required value="<?php echo $row[1]; ?>">
                             </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal" aria-hidden="true"><strong>Cerrar</strong></button>
                                <button type="submit" class="btn btn-primary"><strong>Actualizar</strong></button>
                            </div>
                          </form>

                        </div>

                       </div>
                     </div>
                   </div>

                   <?php } ?>
               </table>

             </div>

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

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
