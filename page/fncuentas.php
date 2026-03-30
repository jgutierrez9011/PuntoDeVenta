<?php
require_once 'cn.php';
require_once 'reg.php';



if(isset($_POST['nombre_cuenta']))
{
  crear_cuenta();
}

if(isset($_POST['id_cuenta_update']))
{
editar_cuenta();
}

if(isset($_POST['nombre_categoria_gasto']))
{
  crear_cat_gasto();
}

if(isset($_POST['id_categoria_gasto_update']))
{
editar_cat_gasto();
}

if(isset($_POST['nombre_categoria_ingreso']))
{
  crear_cat_ingreso();
}

if(isset($_POST['id_categoria_ingreso_update']))
{
editar_cat_ingreso();
}

function crear_cuenta()
{
  $con = conexion_bd(1);

    $usuario = $_SESSION["correo"];
    $cuenta = $_POST['nombre_cuenta'];
    $balance_inicial = $_POST['balance_incial'];
    //$razon = $_POST['cmbrazon'];

  $sql = "INSERT INTO public.tablcatcuentas(
            strnombrecuenta,  bolactivo, balanceinicial, usuariocreo, datfechacreo)
    VALUES ('$cuenta', 'true', $balance_inicial, '$usuario', current_timestamp AT time zone 'CST6') returning intidcuenta";

  $result = pg_query($con,$sql);

  $cmdresult = pg_affected_rows($result);

  if( ( $cmdresult > 0) )
  {

    $insert_row = pg_fetch_result($result, 0, 'intidcuenta');
    $result = pg_query($con,"INSERT INTO public.tbltrnmovimientos(
	                           intidcuenta, numdebito, numcredito, numsaldo, datfechacreo, usuariocreo)
	                           VALUES ($insert_row, 0, $balance_inicial, $balance_inicial, current_timestamp AT time zone 'CST6', '$usuario')");
    if($result)
    {
      echo "<div class='alert alert-success alert-dismissible alerta'>
            <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Exito!</strong> Se creo la cuenta con exito.
            </div>";

    }
  }else {
    echo "<div class='alert alert-warning alert-dismissible alerta'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>¡Disculpe!</strong> No se creo la cuenta por favor intente nuevamente, si no reporta al administrador.
          </div>";
  }
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
    }else {
      echo "<div class='alert alert-warning alert-dismissible alerta'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Disculpe!</strong> No se actualizo la cuenta por favor intente nuevamente, si no reporta al administrador.
            </div>";
    }

  } catch (\Exception $e) {
    echo $e;
  }

}


function crear_cat_gasto()
{
  $con = conexion_bd(1);

  $usuario = $_SESSION["correo"];
  $cuenta = $_POST['nombre_categoria_gasto'];

  $sql = "INSERT INTO tblcatgastos(strnombrecategoria, strusuariocreo, datfechacreo, boolactivo)
          VALUES (UPPER('$cuenta'), '$usuario', current_timestamp AT time zone 'CST6', 'true')";

  $result = pg_query($con,$sql);

  $cmdresult = pg_affected_rows($result);

  if( ( $cmdresult > 0) )
  {
    echo "<div class='alert alert-success alert-dismissible alerta'>
          <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>¡Exito!</strong> Se creo la categoria de gasto con exito.
          </div>";
  }else {
    echo "<div class='alert alert-warning alert-dismissible alerta'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>¡Disculpe!</strong> No se creo la categoria por favor intente nuevamente, si no reporta al administrador.
          </div>";
  }
}


function editar_cat_gasto()
{
  try {

    $usuario = $_SESSION["correo"];
    $cuenta = $_POST['nombre_categoria_gasto_update'];
    $id = $_POST['id_categoria_gasto_update'];
    $result = pg_query(conexion_bd(1),"UPDATE tblcatgastos
                                       set strnombrecategoria = UPPER('$cuenta'),
	                                         strusuariomodifico = '$usuario',
	                                         datfechamodifico = current_timestamp AT time zone 'CST6'
                                       where intidclasgasto = $id");

    $cmd = pg_affected_rows($result);

    if($cmd > 0)
    {
      echo "<div class='alert alert-success alert-dismissible alerta'>
            <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Exito!</strong> Se actualizo categoría de gasto satisfactoriamente.
            </div>";
    }else {
      echo "<div class='alert alert-warning alert-dismissible alerta'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Disculpe!</strong> No se actualizo la categoría de gasto por favor intente nuevamente, si no reporta al administrador.
            </div>";
    }

  } catch (\Exception $e) {
    echo $e;
  }

}


function crear_cat_ingreso()
{
  $con = conexion_bd(1);

  $usuario = $_SESSION["correo"];
  $cuenta = $_POST['nombre_categoria_ingreso'];

  $sql = "INSERT INTO tblcatingresos(strnombrecategoria, strusuariocreo, datfechacreo, boolactivo)
          VALUES ('$cuenta', '$usuario', current_timestamp AT time zone 'CST6', 'true')";

  $result = pg_query($con,$sql);

  $cmdresult = pg_affected_rows($result);

  if( ( $cmdresult > 0) )
  {
    echo "<div class='alert alert-success alert-dismissible alerta'>
          <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>¡Exito!</strong> Se creo la categoría de ingreso con exito.
          </div>";
  }else {
    echo "<div class='alert alert-warning alert-dismissible alerta'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>¡Disculpe!</strong> No se creo la categoría por favor intente nuevamente, si no reporta al administrador.
          </div>";
  }
}


function editar_cat_ingreso()
{
  try {

    $usuario = $_SESSION["correo"];
    $cuenta = $_POST['nombre_categoria_ingreso_update'];
    $id = $_POST['id_categoria_ingreso_update'];
    $result = pg_query(conexion_bd(1),"UPDATE tblcatingresos
                                       set strnombrecategoria = UPPER('$cuenta'),
	                                         strusuariomodifico = '$usuario',
	                                         datfechamodifico = current_timestamp AT time zone 'CST6'
                                       where intidclasingreso = $id");

    $cmd = pg_affected_rows($result);

    if($cmd > 0)
    {
      echo "<div class='alert alert-success alert-dismissible alerta'>
            <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Exito!</strong> Se actualizo categoría de ingreso satisfactoriamente.
            </div>";
    }else {
      echo "<div class='alert alert-warning alert-dismissible alerta'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Disculpe!</strong> No se actualizo la categoría de ingreso por favor intente nuevamente, si no reporta al administrador.
            </div>";
    }

  } catch (\Exception $e) {
    echo $e;
  }

}



 ?>
