<?php
require_once 'cn.php';
require_once 'reg.php';

if(isset($_POST['descripcion_impuesto']))
{
  add_impuesto();
}

if(isset($_POST['valor_impuesto_edit']))
{
  update_impuesto();
}

function add_impuesto()
{
  try {

    $descripcion = $_POST['descripcion_impuesto'];
    $valor = $_POST['valor_impuesto'];
    $result = pg_query(conexion_bd(1),"INSERT INTO public.tblcatimpuesto(nombre, numvalor) VALUES (UPPER('$descripcion') , $valor)");

    $cmd = pg_affected_rows($result);

    if($cmd > 0)
    {
      echo "<div class='alert alert-success alert-dismissible alerta'>
            <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Exito!</strong> Se agrego el nuevo impuesto satisfactoriamente.
            </div>";
    }else {
      echo "<div class='alert alert-warning alert-dismissible alerta'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Disculpe!</strong> No se creo agrego el impuesto por favor intente nuevamente, si no reporta al administrador.
            </div>";
    }

  } catch (\Exception $e) {
    echo $e;
  }
}

function update_impuesto()
{
  try {

    $descripcion = $_POST['descrip_impuesto'];
    $valor = $_POST['valor_impuesto_edit'];
    $estado = $_POST['estado_clasificacion_edit'];
    $id = $_POST['id_tipo'];
    $result = pg_query(conexion_bd(1),"UPDATE public.tblcatimpuesto
	                                     SET nombre = upper('$descripcion'),
	                                         numvalor = $valor,
		                                       bolactivo = $estado
                                       WHERE intidimpuesto = $id;");

    $cmd = pg_affected_rows($result);

    if($cmd > 0)
    {
      echo "<div class='alert alert-success alert-dismissible alerta'>
            <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Exito!</strong> Se actualizo el nuevo impuesto de producto satisfactoriamente.
            </div>";
    }else {
      echo "<div class='alert alert-warning alert-dismissible alerta'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Disculpe!</strong> No se creo actualizo el impuesto por favor intente nuevamente, si no reporta al administrador.
            </div>";
    }

  } catch (\Exception $e) {
    echo $e;
  }

}

 ?>
