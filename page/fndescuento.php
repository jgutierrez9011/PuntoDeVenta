<?php
require_once 'cn.php';
require_once 'reg.php';

if(isset($_POST['descripcion_descuento']))
{
  add_descuento();
}

if(isset($_POST['valor_descuento_edit']))
{
  update_descuento();
}

function add_descuento()
{
  try {

    $descripcion = $_POST['descripcion_descuento'];
    $valor = $_POST['valor_descuento'];
    $result = pg_query(conexion_bd(1),"INSERT INTO public.tblcatdescuento(descripcion, numvalor,bolactivo) VALUES (UPPER('$descripcion') , $valor, true)");

    $cmd = pg_affected_rows($result);

    if($cmd > 0)
    {
      echo "<div class='alert alert-success alert-dismissible alerta'>
            <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Exito!</strong> Se agrego el nuevo descuento satisfactoriamente.
            </div>";
    }else {
      echo "<div class='alert alert-warning alert-dismissible alerta'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Disculpe!</strong> No se creo agrego el descuento por favor intente nuevamente, si no reporta al administrador.
            </div>";
    }

  } catch (\Exception $e) {
    echo $e;
  }
}

function update_descuento()
{
  try {

    $descripcion = $_POST['descrip_descuento'];
    $valor = $_POST['valor_descuento_edit'];
    $estado = $_POST['estado_clasificacion_edit'];
    $id = $_POST['id_tipo'];
    $result = pg_query(conexion_bd(1),"UPDATE public.tblcatdescuento
	                                     SET descripcion = upper('$descripcion'),
	                                         numvalor = $valor,
		                                       bolactivo = $estado
                                       WHERE intidimpuesto = $id;");

    $cmd = pg_affected_rows($result);

    if($cmd > 0)
    {
      echo "<div class='alert alert-success alert-dismissible alerta'>
            <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Exito!</strong> Se actualizo el nuevo descuento de producto satisfactoriamente.
            </div>";
    }else {
      echo "<div class='alert alert-warning alert-dismissible alerta'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Disculpe!</strong> No se creo actualizo el descuento por favor intente nuevamente, si no reporta al administrador.
            </div>";
    }

  } catch (\Exception $e) {
    echo $e;
  }

}

 ?>
