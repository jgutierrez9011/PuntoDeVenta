<?php
require_once 'cn.php';
/*usuario y contraseña*/
$email= $_POST['email'];
$pass= MD5($_POST['password']);
$pgcon = conexion_bd(1);


/* Autentificacion del usuario */
$sql= "SELECT * FROM tblcatusuario where strcorreo='".$email."' and bolactivo = 'true'";
//Crea la consulta a la BD
$resultuser = pg_query($pgcon,$sql);
//Cuenta el numero de filas
$cmdtuplas = pg_affected_rows($resultuser);
//Verifica el numero de filas
if($cmdtuplas == 1){
  //Obtiene las filas que retorna la consulta
  $sql= "SELECT * FROM tblcatusuario where strpassword='".$pass."' and strcorreo='".$email."' and bolactivo = 'true'";
  $resultuser = pg_query($pgcon,$sql);
  $cmdtuplas = pg_affected_rows($resultuser);
  $fila = pg_fetch_assoc($resultuser);
  $user_id = $fila["strpassword"];

        if($pass == $user_id){

             //hora del inicio de sesion
             $_SESSION["time"] = time();
             //usuario que inicio sesion
             $_SESSION["user"] = $email;
             //globales de usuario
            globales_usuario($_SESSION["user"]);

             regacceso();

             /*Genera una sesion activa que dura 24 horas*/
             if (array_key_exists('remember',$_POST))
             {
             // Crear un nuevo cookie de sesion, que expira a los 30 días
             //ini_set('session.cookie_lifetime', 60 * 60 * 24 * 1);
             //session_regenerate_id(TRUE);
             setcookie("COOKIE_INDEFINED_SESSION", TRUE, time()+86400);
		         setcookie("COOKIE_DATA_INDEFINED_SESSION[nombre]", base64_encode($email), time()+86400);
             setcookie("COOKIE_DATA_INDEFINED_SESSION[password]", base64_encode($pass), time()+86400);

             }
             /*else
             {
	             setcookie("COOKIE_CLOSE_NAVEGADOR", TRUE, 0) . "<br/>";
             }*/

              header("Location:index.php");
              //echo "inicio con exito.";

        }else{
            header('Location: login.php?token='.md5('$#tokens#$')."&id=".base64_encode($user_id));
            //echo "password no coincide";
             }
   }else{
            header('Location: login.php?token='.md5('$#stop#$'));
          //echo "No se encontro usuario";
   }
 ?>
