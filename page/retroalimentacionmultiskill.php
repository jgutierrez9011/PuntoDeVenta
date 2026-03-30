<?php
require_once 'cn.php';
require_once 'reg.php';
require_once 'fnmultiskill.php';

$usuario = $_SESSION['user'];

$con = conexion_bd(1);

$sql="SELECT a.intcarnet, a.strcorreo, a.intidempleado,b.intidtienda, c.strtienda, e.strzona from msgsac.tblcatempleado as a
inner join msgsac.tbltrnempzona as b on a.intidempleado = b.intidempleado
inner join msgsac.tblcattienda as c on b.intidtienda=c.intidtienda
inner join msgsac.tblcatdepartamentos as d on c.intiddepto = d.intiddepto
inner join msgsac.tblcatzonas as e on d.intidzona = e.intidzona
WHERE a.strcorreo = '$usuario' and b.bolactivo = 'True'";

  /*$sql= "SELECT numcarnet, tienda, Zona, email FROM msgsac.plantilla WHERE email='$usuario'"; */

$resul = pg_query($con,$sql);
$row = pg_fetch_array($resul);

if (isset($_POST["btnguardar"]))
{

insertar_problematica($usuario, $_POST['zona'], $_POST['tienda'], $_POST['area'], $_POST['segmento'], $_POST['problematica'], $_POST['comentario']);
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
    <title>Analítica SAC</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!--<link href="../vendor/bootstrap/css/bootstrap-multiselect.css" rel="stylesheet">-->

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
              <div class="py-5 text-center">
                  <img class="d-block mx-auto mb-4" src="../img/logoclaro.jpg" alt="CLARO" width="92" height="82">
              </div>

             <h2 align="center">Servicio al Cliente</h2>
             <h3 align="center">Incidentes multiskill</h3>
             <br>

             <!-- Datos del fromulario-->
             <form class="needs-validation" action="retroalimentacionmultiskill.php" method="post" enctype="multipart/form-data">
             <!-- Primera linea de campos en el fromulario-->
             <div class="row">
               <?php
             if(isset($_GET["token"])):
               if($_GET["token"] == 1):
                 echo "<div class='alert alert-success'>
                      <strong>Exito!</strong> El incidente fue registrado con exito!
                      </div>";
               elseif($_GET["token"] == 2):
                 echo "<div class='alert alert-warning'>
                       <strong>Error!</strong> Disculpe no se registro el incidente!, por favor intente nuevamente.
                       </div>";
			   elseif($_GET["token"] == 3):
                 echo "<div class='alert alert-warning'>
                       <strong>Error!</strong> Disculpe no se registro el incidente!, por favor no cambie la platilla solo complete el formato e intente nuevamente.
                       </div>";
               endif;
             endif;
                ?>
             </div>
             <div class="row">

                 <div class="col-md-3 mb-3">
                   <input type="hidden" class="form-control" id="tienda" name="tienda" value="<?php echo $row['strtienda'];?>" required>
                   <input type="hidden" class="form-control" id="zona" name="zona"     value="<?php echo $row['strzona'];?>" required>
                 </div>

             </div>
             <br>
             <div class="row">
                 <div class="col-md-3 mb-3">
                   <label for="area">Area :</label>
                     <select class="form-control selectpicker" data-live-search="true" id="area" name="area" required><?php echo fillarea('N');?></select>
                 </div>

                 <div class="col-md-3 mb-3">
                   <label for="Segmento">Segmento :</label>
                     <select class="form-control" data-live-search="true" id="segmento" name="segmento" required>
                            <option value="">Seleccione</option>
                     </select>
                 </div>

                 <div class="col-md-3 mb-3">
                       <label for="Problematica">Problematica con :</label>
                         <select class="form-control" data-live-search="true" id="problematica" name="problematica" required>
                              <option value="">Seleccione</option>
                        </select>
                 </div>
             </div>
             <br>

             <div class="row">

             <div class="col-md-12 mb-3">
             <label for="comentario">comentario del inconveniente</label>
             <textarea class="form-control text-uppercase font-italic" id="comentario" rows="10" name="comentario" text="arial-label"></textarea>
             </div>

             </div>

             <br>

             <div class="row">
                   <div class="col-md-12 mb-3">
                     <label for="file">Subir imagen</label>
                     <span class="bt-primary">
                     <input type="file" class="form-control-file" id="multiarchivo[]" name="multiarchivo[]" accept="image/jpeg,image/jpeg,application/pdf,application/msword">
                     </span>
                     <small id="fileHelp" class="text-muted">En este campo puedes subir o enviar las imagenes que ilustran el caso.</small>
                   </div>
             </div>

             <hr class="mb-4">

             <div class="row">

             <div class="col-md-4">
             <button class="btn btn-info btn-lg btn-block" name="btnguardar" type="submit" value="btnguardar">Guardar</button>
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
          <p class="mb-1">&copy; 2017-2018 SAC</p>
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

    <!-- Bootstrap select whit search live -->
    <script src="../vendor/bootstrap/js/bootstrap-select.min.js"></script>

    <!--<script src="../vendor/bootstrap/js/bootstrap-multiselect.js"></script>-->

    <script type="text/javascript">

        $(function() {

          //Lista de funciones
          $('#area').change(function()
            {
              var el_area = $(this).val();

              $.post('fnmultiskill.php', {area: el_area} ).done(function (respuesta)
               {
                 $('#segmento').html(respuesta);
                 $('#problematica').html("Seleccione");
               })
            })



          //Lista de funciones
          $('#segmento').change(function()
            {
              var la_problematica = $(this).val();

              $.post('fnmultiskill.php', {problematica: la_problematica} ).done(function (respuesta)
               {
                 $('#problematica').html(respuesta);
               })
            })

            $('#problematica').change(function()
              {
                var problematica = $(this).val();

                if((problematica == "ALTA") || (problematica == "RENOVACIÓN") ||  (problematica == "MIGRACIÓN") ||  (problematica == "POSVENTA") ||  (problematica == "OTROS"))
                {
$("#comentario").val("#INCIDENTE:\r\n #CONTRATO:\r\n #CÉDULA DEL CLIENTE:\r\n PLAN COMERCIAL:\r\n INCONSISTENCIA: \n\r •RECUERDE: PRINT DE PANTALLA (DEL CONTRATO Y LOS FACTURADORES, SEGÚN CORRESPONDA) EN WORD O PDF.");
                }


              })


        })

    </script>

</body>

</html>
