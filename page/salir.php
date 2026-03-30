<?php
//Destruye la session del usuario y lo redireccina a index.php
include 'sesion.php';

$con = conexion_bd(1);

$user = $_SESSION["user"];

$statement = "DELETE FROM msgsac.tbltrnlogin WHERE strusuario = '$user';
              DELETE FROM msgsac.tbl_tmp_trn_recuperacion_pospago WHERE strusuario = '$user';";

pg_query($con,$statement);




if (isset($_COOKIE['COOKIE_INDEFINED_SESSION'])) {

   setcookie("COOKIE_INDEFINED_SESSION", TRUE, time()-86400);
   setcookie("COOKIE_DATA_INDEFINED_SESSION[nombre]", $email, time()-86400);
   setcookie("COOKIE_DATA_INDEFINED_SESSION[password]", $pass, time()-86400);

    unset($_COOKIE['COOKIE_INDEFINED_SESSION']);
    unset($_COOKIE['COOKIE_DATA_INDEFINED_SESSION[nombre]']);
    unset($_COOKIE['COOKIE_DATA_INDEFINED_SESSION[password]']);

    setcookie('COOKIE_INDEFINED_SESSION', null, -1, '/');
    setcookie('COOKIE_DATA_INDEFINED_SESSION[nombre]', null, -1, '/');
    setcookie('COOKIE_DATA_INDEFINED_SESSION[password]', null, -1, '/');

}

session_destroy();
header("Location: login.php");
?>
