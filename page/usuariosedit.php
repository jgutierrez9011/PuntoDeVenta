<?php
require_once 'cn.php';
require_once 'reg.php';
require_once 'fnusuario.php';

$con = conexion_bd(1);

$usuario = $_SESSION["correo"];

if (isset($_POST["btnguardar"]))
{
  actualizar_usuario($_POST['idusuario'],strtoupper($_POST['pnombreedit']), strtoupper($_POST["snombre"]), strtoupper($_POST["papellido"]), strtoupper($_POST["sapellido"]),
                     $_POST["idn"], $_POST["correo"], $_POST["telefono"], $_POST["sexo"], $_POST["direccion"], $_POST["perfil"],$_POST["password"]);
}

$idusuario = base64_decode($_GET["id"]);

//echo $idusuario;

$con = conexion_bd(1);

$sql = "SELECT * from tblcatusuario where intid = $idusuario";
$resul = pg_query($con,$sql);
$row = pg_fetch_array($resul);



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
    <title>GYM</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap select search live CSS -->
    <link href="../vendor/bootstrap/css/bootstrap-select.min.css" rel="stylesheet">

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
              <br>
              <div class="py-5 text-center">
              <img class="d-block mx-auto mb-4" src="../img/logo.jpg" alt="CLARO" width="92" height="82">
              <h2></h2>

              </div>

              <h4 class="page-header  mb-3 text-center">  Registro nuevo usuario</h4>
              <br>
              <div class="row">
                <?php
              if(isset($_GET["token"])):
                if($_GET["token"] == 1):
                  echo "<div class='alert alert-success'>
                       <strong>Exito!</strong> El usuario fue actualizado con exito!
                       </div>";
                elseif($_GET["token"] == 2):
                  echo "<div class='alert alert-warning'>
                        <strong>Error!</strong> Disculpe no se actualizo el usuario!, por favor verifique.
                        </div>";
                endif;
              endif;
                 ?>
              </div>
              <!-- /.row -->

              <!-- Datos del fromulario-->
              <form class="needs-validation" action="usuariosedit.php" method="post">
              <!-- Primera linea de campos en el fromulario-->
              <br>
              <div class="row">
                  <div class="col-md-3 mb-3">
                    <label for="primernombre">Primer nombre</label>
                    <input type="text" class="form-control" id="pnombre" name="pnombreedit" value="<?php echo $row["strpnombre"] ?>" required>
                    <input type="hidden" class="form-control" id="idusuario" name="idusuario" value="<?php echo $idusuario ?>" required>
                  </div>

                  <div class="col-md-3 mb-3">
                    <label for="segundonombre">Segundo nombre</label>
                    <input type="text" class="form-control" id="snombre" name="snombre" value="<?php echo $row["strsnombre"] ?>">
                  </div>

                  <div class="col-md-3 mb-3">
                    <label for="primerapellido">Primer apellido</label>
                    <input type="text" class="form-control" id="papellido" name="papellido" value="<?php echo $row["strpapellido"] ?>" required>
                  </div>

                  <div class="col-md-3 mb-3">
                    <label for="segundoapellido">Segundo apellido</label>
                    <input type="text" class="form-control" id="sapellido" name="sapellido" value="<?php echo $row["strsapellido"] ?>">
                  </div>
              </div>
              <br>

              <!-- Segunda linea de campos en el formulario-->

              <div class="row ">

                <div class="col-md-3 mb-3">
                  <label for="Sexo">Sexo</label>
                  <select class="form-control" id="sexo" name="sexo" required>
                            <option value="">Seleccione</option>
                              <option <?php if($row['strsexo'] == "FEMENINO") echo 'selected';?> value="FEMENINO">FEMENINO</option>
                                <option <?php if($row['strsexo'] == "MASCULINO") echo 'selected';?> value="MASCULINO">MASCULINO</option>

                  </select>
                </div>

                <div class="col-md-3 mb-3">
                     <label for="identificacion">Identificación</label>
                     <input type="text" class="form-control" id="idn" name="idn" value="<?php echo $row['stridentificacion'] ?>">
                     <div id="mensaje"></div>
                </div>

                <div class="col-md-3 mb-3">
                     <label for="telefono">Telefono</label>
                     <input type="text" class="form-control" id="telefono" name="telefono" maxlength="8" value="<?php echo $row['strcontacto'] ?>">
                </div>


              </div>
            </br>

              <!-- Tercera linea de campos en el formulario-->

              <div class="row ">

                <div class="col-md-3 mb-3">

                  <label for="Correo">Correo (Será el usuario) </label>
                  <input type="text" class="form-control" id="correo" name="correo" maxlength="8" required value="<?php echo $row['strcorreo'] ?>">

                </div>

                <div class="col-md-3 mb-3">

                  <label for="Correo">Contraseña</label>
                     <input class="form-control" placeholder="Contraseña" name="password" type="text" data-rule-required="true" data-rule-minlength="6">

                 </div>

               <div class="col-md-3 mb-3">
                 <label for="Sexo">Perfil de usuario</label>
                 <select class="form-control" id="perfil" name="perfil" required>
                       <?php echo fillperfil_usuario($row['intidperfil']) ?>
                 </select>
               </div>

              </div>

              <br>

              <div class="row">

              <div class="col-md-12 mb-3">
              <label for="comentario">Dirección</label>
              <textarea class="form-control text-uppercase font-italic" id="direccion" name="direccion" text="arial-label"><?php echo $row['strdireccion'] ?></textarea>
              </div>

              </div>

              <hr class="mb-4">

              <div class="row">

              <div class="col-md-4">
              <button class="btn btn-primary btn-sm" name="btnguardar" type="submit" value="btnguardar">Guardar</button>
              <a href="consulusuario.php" class="btn btn-primary btn-sm" role="button">Buscar</a>
              </div>

              </div>

              <br>

              </form>

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

    <!-- Bootstrap select whit search live -->
    <script src="../vendor/bootstrap/js/bootstrap-select.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>


</body>

</html>
