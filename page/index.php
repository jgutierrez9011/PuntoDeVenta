<?php
/* Inicia nueva sesion */
require_once 'cn.php';
require_once 'reg.php';

if(!isset($_SESSION["user"])){

//Si la variable de session del usuario no es igual a vacio lo manda al index.php
	header("location: login.php");

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

		<link rel="shortcut icon" href="../img/icon.png">
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
		<style>

		.logo {
		  max-width: 100%;
		  height: auto;
			background-size: cover;
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
                <div class="row">
                <!--  <img class="logo"  src="../img/baner_abril_2021.jpg" alt="Analítica GCAC"> -->
									<?php
		 						 $path = '../img/banner';
		 						 $verimg = "";
		 						 if(file_exists($path)){
		 						   $directorio = opendir($path);
		 						      while ($archivo = readdir($directorio))
		 						      {
		 						        if(!is_dir($archivo)){
		 						          $verimg = $verimg."
		 						                              <img src='../img/banner/$archivo' alt='' width='80%' height='auto' /> ";
		 						        }
		 						      }
		 						       echo $verimg ;
		 						 }
		 						 ?>
                </div>
              <br />

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <footer class="my-5 pt-5 text-muted text-center text-small">
          <p class="mb-1">&copy;<?php echo date("Y")-1; ?>-<?php echo date("Y"); ?> GYM</p>
          <ul class="list-inline">
            <li class="list-inline-item"><a href="#">Inicio</a></li>
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

	<!--	<script src="../vendor/jquery/outbase.js"></script> -->

</body>

</html>
