<?php
/* Inicia nueva sesion */
require_once 'cn.php';

if(isset($_SESSION["user"]))
{
//Si la variable de session del usuario no es igual a vacio lo manda al index.php
	header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Facturacionweb.site Sistemas" />
    <meta name="author" content="Facturacionweb.site" />

		<link rel="shortcut icon" href="../img/icon.png">
    <title>Login - GYM</title>

    <link rel="stylesheet" href="../neon/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css"  id="style-resource-1">
    <link rel="stylesheet" href="../neon/css/font-icons/entypo/css/entypo.css"  id="style-resource-2">
    <link rel="stylesheet" href="../neon/css/font-icons/entypo/css/animation.css"  id="style-resource-3">
    <link rel="stylesheet" href="../neon/css/neon.css"  id="style-resource-5">
    <link rel="stylesheet" href="../neon/css/custom.css"  id="style-resource-6">

    <script src="../neon/js/jquery-1.10.2.min.js"></script>

</head>

<body class="page-body login-page login-form-fall">
    	<div id="container" >
      <!-- COMIENZA CONTENEDOR -->
			<div class="login-container">

			 <div class="login-header login-caret">

				 <div class="login-content" >

					 <a href="#" class="logo">
						<!-- <img src="../img/logosinfondo-14.png" alt="" width="80%" /> -->
						 <?php
						 $path = '../img/inicio';
						 $verimg = "";
						 if(file_exists($path)){
						   $directorio = opendir($path);
						      while ($archivo = readdir($directorio))
						      {
						        if(!is_dir($archivo)){
						          $verimg = $verimg."
						                              <img src='../img/inicio/$archivo' alt='' width='80%' height='auto' /> ";
						        }
						      }
						       echo $verimg ;
						 }
						 ?>
					 </a>

					 <p class="description">Estimado usuario, inicie sesion para acceder al área administrativa!</p>

					 <!-- progress bar indicator -->
					 <div class="login-progressbar-indicator">
						 <h3>43%</h3>
						 <span>Iniciando Sesión...</span>
					 </div>
				 </div>

			 </div>

			 <div class="login-progressbar">
				 <div></div>
			 </div>

			 <div class="login-form">

				 <div class="login-content">

					 <form action="loginusuario.php" method='post' id="bb">
						 <div class="form-group">
							 <div class="input-group">
								 <div class="input-group-addon">
									 <i class="entypo-user"></i>
								 </div>
									 <input class="form-control" placeholder="Correo" name="email" type="text" maxlength="30" data-rule-required="true" autofocus>
							 </div>
						 </div>

						 <div class="form-group">
							 <div class="input-group">
								 <div class="input-group-addon">
									 <i class="entypo-key"></i>
								 </div>
								 <input class="form-control" placeholder="Contraseña" name="password" type="password" data-rule-required="true">

							 </div>
							 <br>
							  <input name="remember" type="checkbox" value="Remember Me">Recordarme
						 </div>

						 <div class="form-group">
							 <button type="submit" name="btnLogin" class="btn btn-primary">
								 Iniciar Sesión
								 <i class="entypo-login"></i>
							 </button>
						 </div>
					 </form>

						 <div class="login-bottom-links">
							 <a href="recuperarlogin.php" class="link">¿Olvido su Contraseña?</a>
						 </div>

						 <div class="login-bottom-links">
              <!-- <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/"><img alt="Licencia de Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png" /></a><br />Este obra está bajo una <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">licencia de Creative Commons Reconocimiento-NoComercial-SinObraDerivada 4.0 Internacional</a>.-->
							 <!--<a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/"><img alt="Licencia de Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-nd/4.0/80x15.png" /></a><br />Este obra está bajo una <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">licencia de Creative Commons Reconocimiento-NoComercial-SinObraDerivada 4.0 Internacional</a>.-->
						 </div>
				 </div>

			 </div>

			</div>


			<!--TERMINA CONTENEDOR -->
		</div>

		<footer class="my-5 pt-5 text-muted text-center text-small">
      <p class="mb-1">&copy;<?php echo date("Y")-1; ?>-<?php echo date("Y"); ?> GYM</p>
      <ul class="list-inline">
       </ul>
    </footer>

    <script src="../neon/js/gsap/main-gsap.js" id="script-resource-1"></script>
    <script src="../neon/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
    <script src="../neon/js/bootstrap.min.js" id="script-resource-3"></script>
    <script src="../neon/js/joinable.js" id="script-resource-4"></script>
    <script src="../neon/js/resizeable.js" id="script-resource-5"></script>
    <script src="../neon/js/neon-api.js" id="script-resource-6"></script>
    <script src="../neon/js/jquery.validate.min.js" id="script-resource-7"></script>
    <script src="../neon/js/neon-login.js" id="script-resource-8"></script>
    <script src="../neon/js/neon-custom.js" id="script-resource-9"></script>
    <script src="../neon/js/neon-demo.js" id="script-resource-10"></script>
    </body>
</html>
