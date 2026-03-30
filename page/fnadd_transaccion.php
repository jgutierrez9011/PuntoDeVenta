<?php
require_once 'cn.php';
require_once 'reg.php';

if((isset($_POST['account_from'])) && (isset($_POST['account_to'])))
{
  registrar_transaccion();
}

function registrar_transaccion()
{
  $con = conexion_bd(1);

    $usuario = $_SESSION["correo"];
    $cuenta_debitar = $_POST['account_from'];
    $cuenta_acreditar= $_POST['account_to'];
    $fecha_transferencia= $_POST['date'];
    $monto = $_POST['amount'];
    $descripcion = $_POST['note'];

  $sql = "INSERT INTO tbltrntranferencia(
intidcuentadebitada, intidcuentaacreditada, strdescripcion, datfechattranferencia, nummonto, strusuariocreo, datfechacreo)
VALUES ($cuenta_debitar, $cuenta_acreditar, '$descripcion', '$fecha_transferencia', $monto, '$usuario', current_timestamp AT time zone 'CST6') returning intidtransferencia";

  $result = pg_query($con,$sql);
  $num_documento = pg_fetch_result($result, 0, 'intidtransferencia');

  $cmdresult = pg_affected_rows($result);

  if( ( $cmdresult > 0) )
  {
    pg_query($con," SELECT fntransfe_calcular_saldo_cuenta ($num_documento,'$usuario')");

    echo "<div class='alert alert-success alert-dismissible alerta'>
          <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>¡Exito!</strong> Transferencia realizada satisfactoriamente.
          </div>";
  }else {
    echo "<div class='alert alert-warning alert-dismissible alerta'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>¡Disculpe!</strong> No se realizo la transferencia por favor intente nuevamente, si no reporta al administrador.
          </div>";
  }
}


?>
