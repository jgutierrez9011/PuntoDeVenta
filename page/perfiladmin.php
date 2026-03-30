<?php
require_once 'cn.php';
require_once 'reg.php';
require_once 'funciones/funciones.php';

if(!empty($_GET['id']))
{
  $con = conexion_bd(1);
  $codigo = $_GET['id'];
  $usuario = $_SESSION['user'];

  /*Muestra las pantallas por perfil*/
  $sql="SELECT a.idperfilusrfrm, b.strformulario, a.bolactivo, c.strperfil
        FROM tblcatperfilusrfrm as a
        inner join tblcatformularios as b on a.idfrm = b.idfrm
        inner join tblcatperfilusr as c on a.idperfil = c.idperfil
        WHERE a.idperfil= $codigo";

  /*ejecuta consulta de pantallas por perfil*/
  $resul = pg_query($con,$sql);
  $row = pg_fetch_array($resul);

}

if((!empty($_GET['cambiomnu'])) && (!empty($_GET['es'])))
{
  $conexion = conexion_bd(1);
  $cambio=limpiar($_GET['cambiomnu']);
  $estado_u=limpiar($_GET['es']);
  $id_usu=limpiar($_GET['cod']);
  if($estado_u =='Activo'){
    pg_query($conexion,"UPDATE tblcatmenuperfil SET bolactivo= 'False'WHERE intidmenuperfil = $cambio");
  }else{
    pg_query($conexion,"UPDATE tblcatmenuperfil SET bolactivo= 'True'WHERE intidmenuperfil = $cambio");
  }
  header('Location: perfiladmin.php?id='.$id_usu);
}


if((!empty($_GET['cambio'])) && (!empty($_GET['es'])))
{
  $conexion = conexion_bd(1);
  $cambio=limpiar($_GET['cambio']);
  $estado_u=limpiar($_GET['es']);
  $id_usu=limpiar($_GET['cod']);
  if($estado_u =='Activo'){
    pg_query($conexion,"UPDATE tblcatperfilusrfrm SET bolactivo  =  'False' WHERE idperfilusrfrm = $cambio");
  }else{
    pg_query($conexion,"UPDATE tblcatperfilusrfrm SET bolactivo  =  'True' WHERE idperfilusrfrm = $cambio");
  }
  header('Location: perfiladmin.php?id='.$id_usu);
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

    <title>Admin GYM</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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

             <!-- <h2 align="center">Servicio al Cliente</h2> -->
             <br />
             <div class="row ">
                   <table class="table table-bordered">
                     <tr class="well">
                         <td>
                               <h3 align="center">
                                Administrar perfiles de usuario<br></h3>
                                <h3 align="center">Perfil : <?php echo $row["strperfil"]; ?></h3>

                         </td>
                      </tr>
                   </table>
             </div>

             <div class="panel panel-default">
                 <div class="panel-heading">
                     Basic Tabs
                 </div>
                 <!-- /.panel-heading -->
                 <div class="panel-body">
                     <!-- Nav tabs -->
                     <ul class="nav nav-tabs">
                         <li class="active"><a href="#home" data-toggle="tab">Adm Gym</a>
                         </li>
                         <li><a href="#profile" data-toggle="tab"> - </a>
                         </li>
                     </ul>

                     <!-- Tab panes -->
                     <div class="tab-content">
                         <div class="tab-pane fade in active" id="home">
                             <br>
                             <!--Tabla que muestra los menus por perfil-->
                             <div class="row table-responsive">
                               <table class="table table-bordered">
                                 <tr class="well">
                                       <td><strong>Descripcion del menu</strong></td>
                                       <td width="20%"></td>
                                 </tr>
                                   <?php
                                   $con = conexion_bd(1);

                                   $sql="SELECT a.intidmenuperfil, b.strmenu, a.bolactivo, c.strperfil, b.strtipomenu
                                         from tblcatmenuperfil as a
                                         inner join tblcatmenu as b on a.intidmenu = b.intidmenu
                                         inner join tblcatperfilusr as c on a.idperfil = c.idperfil
                                         where a.idperfil = $codigo and (b.strnivelmenu = '1')";

                                   $estado_menu = '';

                                   $resul = pg_query($con,$sql);

                               while($row_menu = pg_fetch_array($resul)){

                                 if($row_menu['bolactivo']=='f'){

                                   $color_menu  ='btn btn-danger btn-xs';
                                   $estado_menu = 'Inactivo';

                                 }else{

                                   $color_menu='btn btn-primary btn-xs';
                                   $estado_menu = 'Activo';

                                 }
                                 ?>
                                 <tr>
                                   <td><strong>+ <?php echo $row_menu[1]; ?></strong></td>
                                     <td>
                                         <center>
                                             <div class="btn-group btn-group-xs">
                                                 <a href="perfiladmin.php?cambiomnu=<?php echo $row_menu[0]; ?>&es=<?php echo $estado_menu; ?>&cod=<?php echo $codigo; ?>" role="button"   class="<?php echo $color_menu; ?>" data-toggle="modal"><strong><?php echo $estado_menu; ?></strong></a>
                                             </div>
                                         </center>
                                     </td>
                                 </tr>
                                 <?php
                                 $con_ = conexion_bd(1);

                                 $sql_sub ="SELECT a.idperfilusrfrm, b.strformulario, a.bolactivo, c.strperfil, b.strkeymenu, a.idfrm, a.idperfil
                                            FROM tblcatperfilusrfrm as a
                                            inner join tblcatformularios as b on a.idfrm = b.idfrm
                                            inner join tblcatperfilusr as c on a.idperfil = c.idperfil
                                            WHERE a.idperfil= $codigo and b.strkeymenu = '$row_menu[4]'
                                            order by a.idperfilusrfrm asc";
                                  //echo $row_menu[0]."\n".$row_menu[4];
                                  $estado_sub = '';

                                  $resul_sub = pg_query($con_, $sql_sub);

                                  $filas_sub = pg_num_rows($resul_sub);

                                  if($filas_sub > 0)
                                  {
                                    while($row_sub=pg_fetch_array($resul_sub)){

                                    if($row_sub['bolactivo']=='f'){

                                             $color_sub  ='btn btn-danger btn-xs';
                                             $estado_sub = 'Inactivo';

                                    }else{
                                             $color_sub ='btn btn-primary btn-xs';
                                             $estado_sub = 'Activo';

                                           }


                                   ?>
                                   <tr>
                                     <td><a href="perfiladmindet.php?formdet=<?php echo $row_sub[5];?>&perfil=<?php echo $row_sub[6];?>" >- <?php echo $row_sub[1]; ?></a></td>
                                       <td>
                                           <center>
                                               <div class="btn-group btn-group-xs">
                                                   <a href="perfiladmin.php?cambio=<?php echo $row_sub[0]; ?>&es=<?php echo $estado_sub; ?>&cod=<?php echo $codigo; ?>" role="button"   class="<?php echo $color_sub; ?>" data-toggle="modal"><strong><?php echo $estado_sub; ?></strong></a>
                                               </div>
                                           </center>
                                       </td>
                                   </tr>
                                 <?php } ?>
                                   <?php } ?>
                                   <?php } ?>
                               </table>
                                   <div align="left"><a href="perfil.php" class="btn btn-info btn-sm" role="button"><i class="glyphicon glyphicon-menu-left"></i> <strong>Regresar a perfiles</strong></a></div>
                             </div>
                         </div>
                         <div class="tab-pane fade" id="profile">
                             <br>
                             <!--Tabla que muestra los menus por perfil de indicadores sac-->
                             <div class="row table-responsive">
                               <table class="table table-bordered">
                                 <tr class="well">
                                       <td><strong>Descripcion del menu</strong></td>
                                       <td width="20%"></td>
                                 </tr>
                                   <?php
                                   $con = conexion_bd(1);

                                   $sql="SELECT a.intidmenuperfil, b.strmenu, a.bolactivo, c.strperfil, b.strtipomenu
                                         from tblcatmenuperfil as a
                                         inner join tblcatmenu as b on a.intidmenu = b.intidmenu
                                         inner join tblcatperfilusr as c on a.idperfil = c.idperfil
                                         where a.idperfil = $codigo and (b.strnivelmenu = '0' or b.strnivelmenu = '2')";

                                   $estado_menu = '';

                                   $resul = pg_query($con,$sql);

                               while($row_menu = pg_fetch_array($resul)){

                                 if($row_menu['bolactivo']=='f'){

                                   $color_menu  ='btn btn-danger btn-xs';
                                   $estado_menu = 'Inactivo';

                                 }else{

                                   $color_menu='btn btn-primary btn-xs';
                                   $estado_menu = 'Activo';

                                 }
                                 ?>
                                 <tr>
                                   <td><strong>+ <?php echo $row_menu[1]; ?></strong></td>
                                     <td>
                                         <center>
                                             <div class="btn-group btn-group-xs">
                                                 <a href="perfiladmin.php?cambiomnu=<?php echo $row_menu[0]; ?>&es=<?php echo $estado_menu; ?>&cod=<?php echo $codigo; ?>" role="button"   class="<?php echo $color_menu; ?>" data-toggle="modal"><strong><?php echo $estado_menu; ?></strong></a>
                                             </div>
                                         </center>
                                     </td>
                                 </tr>
                                 <?php
                                 $con_ = conexion_bd(1);

                                 $sql_sub ="SELECT a.idperfilusrfrm, b.strformulario, a.bolactivo, c.strperfil, b.strkeymenu
                                            FROM tblcatperfilusrfrm as a
                                            inner join tblcatformularios as b on a.idfrm = b.idfrm
                                            inner join tblcatperfilusr as c on a.idperfil = c.idperfil
                                            WHERE a.idperfil= $codigo and b.strkeymenu = '$row_menu[4]'
                                            order by a.idperfilusrfrm asc";
                                  //echo $row_menu[0]."\n".$row_menu[4];
                                  $estado_sub = '';

                                  $resul_sub = pg_query($con_, $sql_sub);

                                  $filas_sub = pg_num_rows($resul_sub);

                                  if($filas_sub > 0)
                                  {
                                    while($row_sub=pg_fetch_array($resul_sub)){

                                    if($row_sub['bolactivo']=='f'){

                                             $color_sub  ='btn btn-danger btn-xs';
                                             $estado_sub = 'Inactivo';

                                    }else{
                                             $color_sub ='btn btn-primary btn-xs';
                                             $estado_sub = 'Activo';

                                           }


                                   ?>
                                   <tr>
                                     <td>- <?php echo $row_sub[1]; ?></td>
                                       <td>
                                           <center>
                                               <div class="btn-group btn-group-xs">
                                                   <a href="perfiladmin.php?cambio=<?php echo $row_sub[0]; ?>&es=<?php echo $estado_sub; ?>&cod=<?php echo $codigo; ?>" role="button"   class="<?php echo $color_sub; ?>" data-toggle="modal"><strong><?php echo $estado_sub; ?></strong></a>
                                               </div>
                                           </center>
                                       </td>
                                   </tr>
                                 <?php } ?>
                                   <?php } ?>
                                   <?php } ?>
                               </table>
                                   <div align="left"><a href="perfil.php" class="btn btn-info btn-sm" role="button"><i class="glyphicon glyphicon-menu-left"></i> <strong>Regresar a perfiles</strong></a></div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <!-- /.panel-body -->
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
