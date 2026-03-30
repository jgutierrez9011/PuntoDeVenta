<?php
require_once 'cn.php';
require_once 'reg.php';

if(isset($_POST["id_cuenta_update"]))
{
editar_cuenta();
}

function editar_cuenta()
{
  try {

    $usuario = $_SESSION["correo"];
    $balance = $_POST['balance_incial_update'];
    $cuenta = $_POST['nombre_cuenta_update'];
    $id = $_POST['id_cuenta_update'];

    $result = pg_query(conexion_bd(1),"UPDATE tablcatcuentas
                                       set strnombrecuenta = '$cuenta',
                                           balanceinicial = $balance,
	                                         usuariomodifico = '$usuario',
	                                         datmodifico = current_timestamp AT time zone 'CST6'
                                       where intidcuenta = $id");

    $cmd = pg_affected_rows($result);

    if($cmd > 0)
    {
      echo "<div class='alert alert-success alert-dismissible alerta'>
            <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Exito!</strong> Se actualizo cuenta satisfactoriamente.
            </div>";
    }
    else
    {
      echo "<div class='alert alert-warning alert-dismissible alerta'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Disculpe!</strong> No se actualizo la cuenta por favor intente nuevamente, si no reporta al administrador.
            </div>";
    }

  } catch (\Exception $e) {
    echo $e;
  }

}
?>
