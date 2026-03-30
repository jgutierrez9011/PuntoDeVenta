<?php
require_once 'cn.php';
require_once 'reg.php';

if((isset($_POST['account'])) && (isset($_POST['category'])))
{
  registrar_ingreso();
}

if((isset($_POST['account_gasto'])) && (isset($_POST['category_gasto'])))
{
  registrar_gasto();
}

if(isset($_POST['clasificacion']))
{
  fill_cat_ingresos($_POST['clasificacion']);
}

if(isset($_POST['clasificacion_cuenta']))
{
  fill_cuenta($_POST['clasificacion_cuenta']);
}

function fill_cat_ingresos($val)
{
  $con = conexion_bd(1);

  $sql = pg_query($con,"SELECT intidclasingreso, strnombrecategoria from tblcatingresos");


  echo '<option value="">Seleccione</option>';
  while($row = pg_fetch_assoc($sql))
  {
    echo '<option value="'. $row['intidclasingreso'].'"';

    if($row['intidclasingreso']==$val )
    {
          echo "selected";
    }

    echo ">". $row['strnombrecategoria'] .'</option>';
  }
  pg_close($con);
}

function fill_cuenta($val)
{
  $con = conexion_bd(1);

  $sql = pg_query($con,"SELECT intidcuenta, strnombrecuenta, balanceinicial from tablcatcuentas");


  echo '<option value="">Seleccione</option>';
  while($row = pg_fetch_assoc($sql))
  {
    echo '<option value="'. $row['intidcuenta'].'"';

    if($row['intidcuenta']==$val )
    {
          echo "selected";
    }

    echo ">". $row['strnombrecuenta'] .' - Saldo: '.$row['balanceinicial'].'</option>';
  }
  pg_close($con);
}

function registrar_ingreso()
{
  $con = conexion_bd(1);

    $usuario = $_SESSION["correo"];
    $cuenta = $_POST['account'];
    $categoria_ingreso = $_POST['category'];
    $descripcion = $_POST['description'];
    $monto = $_POST['amount'];
    $fecha_ingreso = $_POST['date'];

  $sql = "INSERT INTO public.tbltrningresos(
            intidcuenta, intidclasingreso, strdescripcion,
            nummonto, datingreso, datfechacreo, usuariocreo)
    VALUES ($cuenta, $categoria_ingreso, '$descripcion', $monto, '$fecha_ingreso', current_timestamp AT time zone 'CST6', '$usuario') returning intidregingreso";

  $result = pg_query($con,$sql);
  $num_documento = pg_fetch_result($result, 0, 'intidregingreso');

  $cmdresult = pg_affected_rows($result);




  if( ( $cmdresult > 0) )
  {
    pg_query($con,"SELECT fningreso_calcular_saldo_cuenta($num_documento, $cuenta,'$usuario')");

    echo "<div class='alert alert-success alert-dismissible alerta'>
          <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>¡Exito!</strong> Tu ingreso ha sido ingresado satisfactoriamente.
          </div>";
  }else {
    echo "<div class='alert alert-warning alert-dismissible alerta'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>¡Disculpe!</strong> No se creo registro por favor intente nuevamente, si no reporta al administrador.
          </div>";
  }
}

function registrar_gasto()
{
  $con = conexion_bd(1);

    $usuario = $_SESSION["correo"];
    $cuenta = $_POST['account_gasto'];
    $categoria_gasto = $_POST['category_gasto'];
    $descripcion = $_POST['description'];
    $monto = $_POST['amount'];
    $fecha_gasto = $_POST['date'];

  $sql = "INSERT INTO public.tbltrngastos(
    intidcuenta, intidclasgasto, strdescripcion, nummonto, datgasto, datfechacreo, usuariocreo)
    VALUES ($cuenta, $categoria_gasto, '$descripcion', $monto, '$fecha_gasto', current_timestamp AT time zone 'CST6', '$usuario') returning intidreggasto
    ";

  $result = pg_query($con,$sql);
  $num_documento = pg_fetch_result($result, 0, 'intidreggasto');

  $cmdresult = pg_affected_rows($result);

  if( ( $cmdresult > 0) )
  {
    pg_query($con,"SELECT fngasto_calcular_saldo_cuenta($num_documento, $cuenta,'$usuario')");

    echo "<div class='alert alert-success alert-dismissible alerta'>
          <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>¡Exito!</strong> Tu gasto ha sido ingresado satisfactoriamente.
          </div>";
  }else {
    echo "<div class='alert alert-warning alert-dismissible alerta'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>¡Disculpe!</strong> No se creo registro por favor intente nuevamente, si no reporta al administrador.
          </div>";
  }
}


?>
