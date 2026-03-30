<?php
require_once 'cn.php';
require_once 'reg.php';

if(isset($_POST['descripcion_tipo_producto']))
{
  add_tipo_producto();
}

if(isset($_POST['descrip_tipo_producto']))
{
  update_tipo_producto();
}


function add_tipo_producto()
{
  try {

    $descripcion = $_POST['descripcion_tipo_producto'];
    $result = pg_query(conexion_bd(1),"INSERT INTO public.tblcattipoproducto(strtipo, bolactivo) VALUES (UPPER('$descripcion'), 'true')");

    $cmd = pg_affected_rows($result);

    if($cmd > 0)
    {
      echo "<div class='alert alert-success alert-dismissible alerta'>
            <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Exito!</strong> Se agrego el nuevo tipo de producto satisfactoriamente.
            </div>";
    }else {
      echo "<div class='alert alert-warning alert-dismissible alerta'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Disculpe!</strong> No se creo agrego el tipo por favor intente nuevamente, si no reporta al administrador.
            </div>";
    }

  } catch (\Exception $e) {
    echo $e;
  }
}


function update_tipo_producto()
{
  try {

    $descripcion = $_POST['descrip_tipo_producto'];
    $estado = $_POST['estado_clasificacion'];
    $id = $_POST['id_tipo'];
    $result = pg_query(conexion_bd(1),"UPDATE public.tblcattipoproducto
     SET strtipo= upper('$descripcion'),
         bolactivo= '$estado'
     WHERE intidtipoproducto = $id");

    $cmd = pg_affected_rows($result);

    if($cmd > 0)
    {
      echo "<div class='alert alert-success alert-dismissible alerta'>
            <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Exito!</strong> Se actualizo el nuevo tipo de producto satisfactoriamente.
            </div>";
    }else {
      echo "<div class='alert alert-warning alert-dismissible alerta'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Disculpe!</strong> No se creo actualizo el tipo por favor intente nuevamente, si no reporta al administrador.
            </div>";
    }

  } catch (\Exception $e) {
    echo $e;
  }

}
?>
