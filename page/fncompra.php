<?php
require_once 'cn.php';
require_once 'reg.php';
require_once 'funciones/funciones.php';

if(isset($_GET['cod']))
{
  if($_GET['cod'] == 1)
  {
     fill_detalle_compra(conexion_bd(1),0,0);
  }
}

if(isset($_POST['idfila']))
{
  eliminar_producto_detalle_compra();
}

if(isset($_POST['producto_cantidad']) && (isset($_POST['codigobarra_producto'])))
{
  add_producto_detalle_compra();
}

function eliminar_producto_detalle_compra()
{
  try {

  } catch (\Exception $e) {

  }

  $cone = conexion_bd(1);

  $fila = $_POST['idfila'];

  $sql_delete = "DELETE FROM public.tbltempfacturadetalle_compra
                 WHERE intidserie = $fila";
  pg_query($cone,$sql_delete);
}

function add_producto_detalle_compra()
{
  try
  {
    $con = conexion_bd(1);

    $usuario = $_SESSION["correo"];

    $producto = $_POST['codigobarra_producto'];
    $cantidad = $_POST['producto_cantidad'];

    $impuesto_aplicado = $_POST["impuestofact"];
    $descuento_aplicado = $_POST["descuentofact"];

    $sql_busca_producto = "SELECT a.intidproducto,
                           a.strnombre, a.numprecioventa , a.numprecioventa,
                           case when a.bolcontrolinventario = true then 'Control de inventario'
                           else 'Sin control de inventario' end inventario, a.intstock,
                           case when a.strestado = true then 'Activo'
                           ELSE 'Inactivo' end estado
                           from tblcatproductos a
                           inner join tblcattipoproducto b on a.strtipo::int = b.intidtipoproducto
                           where a.intidproducto = $producto and a.strestado = true AND a.bolcontrolinventario = true limit 1";


    $result_busqueda_producto = pg_query($con,$sql_busca_producto);

     $filas = pg_affected_rows($result_busqueda_producto);

    if($filas  > 0)
    {

      $row_producto = pg_fetch_array($result_busqueda_producto);
      $nombre_producto = $row_producto['strnombre'];
      $precio_venta =  $row_producto['numprecioventa'];

      $sub_total = $cantidad * $precio_venta;

      $sql_tmp = "INSERT INTO public.tbltempfacturadetalle_compra(
          intidproducto, numcantidad, strdescripcionproducto,
          numprecioventa, numsubttotal, numdescuento, numtotal, strusuariocreo,
          datfechacreo)
      VALUES ( $producto, $cantidad, '$nombre_producto',
        $precio_venta , $sub_total, 0,   $sub_total , '$usuario',
        current_timestamp AT time zone 'CST6')";

      $result_detalle = pg_query($con,$sql_tmp);

      $comdtuplas = pg_affected_rows($result_detalle);


      if ( $comdtuplas > 0 )
      {

          fill_detalle_compra(conexion_bd(1),$descuento_aplicado,$impuesto_aplicado);

      }


    }else {
        fill_detalle_compra(conexion_bd(1),$descuento_aplicado,$impuesto_aplicado);
    }


  } catch (Exception $e) {
      header("location:index.php?token=3");
  }
}
?>
