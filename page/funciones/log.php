<?php
require_once '../cn.php';

if(isset($_POST['manual']))
{
  log_dowload_manuales($_POST['manual']);
}

function log_dowload_manuales($descripcion)
{
  $usuario =  $_SESSION["user"];
  /*se llama funcion para conectar con base de datos de postgreSQl*/
  $con = conexion_bd(1);
  $sql = "INSERT INTO msgsac.tbltrnlogdownload(strusuario, datfechadescargo, strdescripciondownload)
                                       VALUES ('$usuario', current_timestamp, '$descripcion');";
  $result = pg_query($con,$sql);
}
 ?>
