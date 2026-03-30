<?PHP
require_once 'cn.php';
require_once 'reg.php';
require_once 'funciones/funciones.php';

date_default_timezone_set("America/Managua");
$fecha_hora_actual = date('Y-m-d H:i:s');

if(isset($_GET['cod']))
{
  if($_GET['cod'] == 1)
  {
     fill_detalle_venta(conexion_bd(1),0,0);
  }
}

if( (isset($_GET['impuestos'])) || (isset($_GET['descuentos'])) )
{
     fill_detalle_venta(conexion_bd(1),$_GET['descuentos'],$_GET['impuestos']);
}

if(isset($_POST['producto_cantidad']) && (isset($_POST['codigobarra_producto'])))
{
  add_producto_detalle();
}

if(isset($_POST['idfila']))
{
  eliminar_producto_detalle();
}


/*function fill_detalle_venta()
{
  $usuario = $_SESSION["correo"];

  $cn =  conexion_bd(1);

   $sql = "SELECT a.intidserie, a.intidproducto, a.numcantidad, a.strdescripcionproducto,
           round(a.numprecioventa,2) numprecioventa , a.numsubttotal, a.numdescuento, round(a.numtotal,2) numtotal, a.strusuariocreo,
           round((a.numcantidad *   a.numprecioventa) * a.numdescuento,2) descuento_aplicado,
           a.datfechacreo, rank() over (order by a.datfechacreo asc) as rownumber
           FROM tbltempfacturadetalle a
           where a.strusuariocreo = '$usuario'";

     $resul = pg_query($cn,$sql);
     $neto = 0;
     $descuento = number_format(0,2);
     $iva = number_format(0,2);
     $total = 0;

     $combo_descuento = fill_descuento(conexion_bd(1), 'factura' ,0, '');
     $combo_impuesto = fill_impuesto(conexion_bd(1), 'factura' ,0, '');

   $retorno = "  <div class='row table-responsive'>
                  <table class='table table-bordered' id='' style='width:100%'>
              <thead>
              <tr class='warning'>
               <th><p class='small'><strong>N° Fila</strong></p></th>
              <th><p class='small'><strong>Codigo</strong></p></th>
              <th><p class='small'><strong>Cantidad</strong></p></th>

              <th><p class='small'><strong>Descripcion</strong></p></th>
              <th><p class='small'><strong>Precio unit C$</strong></p></th>
              <th><p class='small'><strong>Descuento C$</strong></p></th>
              <th><p class='small'><strong>Precio total C$</strong></p></th>
              <th></th>

              </tr>
              </thead>
              <tbody>";
    while ($row = pg_fetch_array($resul)){

          $idproducto = $row["intidproducto"];
             $neto = number_format($neto + $row["numtotal"],2);
             $total = $neto;
          $retorno = $retorno."<tr>
                               <td><p class='small'>".$row["rownumber"]."</p></td>
                               <td><p class='small'>".$row["intidproducto"]."</p></td>
                               <td><p class='small'>".$row["numcantidad"]."</p></td>

                               <td><p class='small'>".$row["strdescripcionproducto"]."</p></td>


                               <td><p class='small'>".$row["numprecioventa"]."</p></td>

                               <td><p class='small'>".$row["descuento_aplicado"]."</p></td>

                               <td><p class='small'>".$row["numtotal"]."</p></td>

                               <td><a data-toggle='modal' data-target='#confirm-delete' id='".$row["intidserie"]."' class='btn btn-danger delete_data'><span class='fa fa-trash-o'></span></a></td>




                               </tr>";}
          $retorno = $retorno."<tr>
          <td colspan='6' align='right'><strong>NETO C$</strong></td>
          <td colspan='4' align='left'><p class='small'>".$neto."</p></td>
                               </tr>

                               <tr>
                               <td colspan='6' align='right'>
                               <strong><p class'small'>Descuento ". $combo_descuento ." </strong></p>
                               </td>
          <td colspan='4' align='left'><p class='small'>".$descuento."</p></td>
                               </tr>

                               <tr>
                               <td colspan='6' align='right'>
                                <strong><p class'small'>Impuesto ". $combo_impuesto ." </strong></p>
                               </td>
          <td colspan='4' align='left'><p class='small'>".$iva."</p></td>
                               </tr>

          <td colspan='6' align='right'><strong>Total a pagar C$</strong></td>
          <td colspan='4' align='left'><p class='small'>".$total."</p></td>
                              </tr>
                               </tbody>
                               </table>
                               </div>";

          echo $retorno;
}*/

function add_producto_detalle()
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
                           where a.intidproducto = $producto and a.strestado = true limit 1";


    $result_busqueda_producto = pg_query($con,$sql_busca_producto);

     $filas = pg_affected_rows($result_busqueda_producto);

    if($filas  > 0)
    {

      $row_producto = pg_fetch_array($result_busqueda_producto);
      $nombre_producto = $row_producto['strnombre'];
      $precio_venta =  $row_producto['numprecioventa'];

      $sub_total = $cantidad * $precio_venta;

      $sql_tmp = "INSERT INTO public.tbltempfacturadetalle(
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
          fill_detalle_venta(conexion_bd(1),$descuento_aplicado,$impuesto_aplicado);
        /*$sql = "SELECT a.intidserie, a.intidproducto, a.numcantidad, a.strdescripcionproducto,
                a.numprecioventa, a.numsubttotal, a.numdescuento, a.numtotal, a.strusuariocreo,
                a.datfechacreo, rank() over (order by a.datfechacreo asc) as rownumber
                FROM tbltempfacturadetalle a
                where a.strusuariocreo = '$usuario'";

        $resul = pg_query($con,$sql);
        $sub_total_encabezado = 0;

        $retorno = "  <div class='row table-responsive'>
                       <table class='table table-bordered' id='tbldetalleproducto' style='width:100%'>
                   <thead>
                   <tr class='warning'>
                   <th><p class='small'><strong>N°</strong></p></th>
                   <th><p class='small'><strong>Codigo</strong></p></th>
                   <th><p class='small'><strong>Cantidad</strong></p></th>

                   <th><p class='small'><strong>Descripcion</strong></p></th>
                   <th><p class='small'><strong>Precio unit</strong></p></th>
                   <th><p class='small'><strong>Precio total</strong></p></th>
                   <th></th>

                   </tr>
                   </thead>
                   <tbody>";
         while ($row = pg_fetch_array($resul)){

               $idproducto = $row["intidproducto"];
               $sub_total_encabezado = $sub_total_encabezado + $row["numtotal"];
               $retorno = $retorno."<tr>
                                    <td><p class='small'>".$row["rownumber"]."</p></td>
                                    <td><p class='small'>".$row["intidproducto"]."</p></td>
                                    <td><p class='small'>".$row["numcantidad"]."</p></td>

                                    <td><p class='small'>".$row["strdescripcionproducto"]."</p></td>


                                    <td><p class='small'>".$row["numprecioventa"]."</p></td>

                                    <td><p class='small'>".$row["numtotal"]."</p></td>

                                    <td><a data-toggle='modal' data-target='#confirm-delete' id='".$row["intidserie"]."' class='btn btn-danger delete_data'><span class='fa fa-trash-o'></span></a></td>




                                    </tr>";}
               $retorno = $retorno."<tr>
               <td colspan='5' align='right'><strong>Total</strong></td>
               <td colspan='3' align='left'><p class='small'>".$sub_total_encabezado."</p></td>
                                    </tr>
                                    </tbody>
                                    </table>
                                    </div>";

               echo $retorno;*/
      }

    /*  if($comdtuplas > 0)
      {
        header("location:credito.php");
      }*/
    }else {
        fill_detalle_venta(conexion_bd(1),$descuento_aplicado,$impuesto_aplicado);
    }


  } catch (Exception $e) {
      header("location:index.php?token=3");
  }
}

function eliminar_producto_detalle()
{
  try {

  } catch (\Exception $e) {

  }

  $cone = conexion_bd(1);

  $fila = $_POST['idfila'];

  $sql_delete = "DELETE FROM public.tbltempfacturadetalle
                 WHERE intidserie = $fila";
  pg_query($cone,$sql_delete);
}


?>
