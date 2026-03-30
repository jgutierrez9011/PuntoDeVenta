<?php
require_once 'cn.php';
require_once 'reg.php';
require_once 'funciones/funciones.php';

if((isset($_POST['proveedor_id'])) && (isset($_POST['valor_tasa_cambio'])))
{
  fn_save_factura_compra();
}

if((isset($_GET['id'])) && (isset($_GET['fact'])))
{
   eliminar_factura_compra($_GET['id'],$_GET['fact']);
}

function fn_save_factura_compra()
{

  try {

   /*VALIDACION DE CANTIDADES MAYORES A LAS EXISTENCIAS DE PRODUCTOS*/
  /*   $existencia = fn_validar_existencia();

   if($existencia == 0)
   { */
     $con = conexion_bd(1);

     $usuario = $_SESSION["correo"];

     $idcliente = $_POST['proveedor_id'];
     $netofactura = $_POST['neto_factura'];
     $descuentofactura = $_POST['descuento_factura'];
     $ivafactura = $_POST['iva_factura'];
     $totalfactura = $_POST['total_factura'];
     $valor_tasa_cambio = $_POST['valor_tasa_cambio'];
     $tipo_factura = $_POST['cmbtipo_factura'];

     $estado_factura = "";
     if($tipo_factura=="CONTADO")
     {
       $estado_factura = "CERRADO";
     }elseif ($tipo_factura=="CREDITO") {
       $estado_factura = "PENDIENTE";
     }



     //$numero_factura = $_POST['sale_number'];
     $dato = [];

     $sql_num_fact = "SELECT count(coalesce(numerofactura,0)) + 1 num_factura
             FROM tblcatfacturaencabezado_compra";
     $result_num_fact = pg_query($con,$sql_num_fact);
     $row_num_fact = pg_fetch_array($result_num_fact);
     //echo str_pad($row['num_factura'], 10 , "0", STR_PAD_LEFT);
     $numero_factura = str_pad($row_num_fact['num_factura'], 10 , "0", STR_PAD_LEFT);

      $sql_encabezado = "INSERT INTO public.tblcatfacturaencabezado_compra(
                         intidproveedor, datfechafactura, numtasacambio, numsubtotal,
                         numdescuento, numiva, numtotal, strusuariocreo,
                         datfechacreo, strestado, strtipo, numerofactura)
       VALUES ($idcliente,current_timestamp AT time zone 'CST6',$valor_tasa_cambio,$netofactura,
               $descuentofactura,$ivafactura,$totalfactura,'$usuario',
              current_timestamp AT time zone 'CST6','$estado_factura','$tipo_factura', $numero_factura) returning intidserie";



      $result_encabezado = pg_query($con,$sql_encabezado);

      $cmdtuplas = pg_affected_rows($result_encabezado);

      if($cmdtuplas > 0)
      {

        $num_factura_serie = pg_fetch_result($result_encabezado, 0, 'intidserie');



        if($tipo_factura=="CONTADO")
        {
          $sql_detalle = "INSERT INTO public.tblcatfacturadetalle_compra(
                          intidfactura, intidproducto, numcantidad, numcantbonificado, strdescripcionproducto,
                          numprecioventa, numsubttotal, numdescuento, numtotal, strusuariocreo,
                          datfechacreo)
                          select $num_factura_serie, intidproducto, numcantidad, numcantbonificado, strdescripcionproducto,
                          numprecioventa, numsubttotal, numdescuento, numtotal, strusuariocreo,
                          datfechacreo
                          from tbltempfacturadetalle_compra
                          where strusuariocreo = '$usuario';
                          select fncompra_calcular_saldo_cuenta ($numero_factura, 2,'$usuario')";
        }elseif ($tipo_factura=="CREDITO") {
          $sql_detalle = "INSERT INTO public.tblcatfacturadetalle_compra(
                          intidfactura, intidproducto, numcantidad, numcantbonificado, strdescripcionproducto,
                          numprecioventa, numsubttotal, numdescuento, numtotal, strusuariocreo,
                          datfechacreo)
                          select $num_factura_serie, intidproducto, numcantidad, numcantbonificado, strdescripcionproducto,
                          numprecioventa, numsubttotal, numdescuento, numtotal, strusuariocreo,
                          datfechacreo
                          from tbltempfacturadetalle_compra
                          where strusuariocreo = '$usuario';
                          select fncompracredito_calcular_saldo_cuenta ($numero_factura, 6,'$usuario')";
        }


         $result_detalle = pg_query($con,$sql_detalle);

         $cmdtuplas_detalle = pg_affected_rows($result_detalle);

         if($cmdtuplas_detalle > 0)
         {
           /*AQUI EL CODIGO PARA ACTUALIZAR EL INVENTARIO*/
           $result_facturado = pg_query($con,"SELECT a.intidproducto, a.numcantidad, a.numcantbonificado
           from tbltempfacturadetalle_compra a inner join tblcatproductos b on
           a.intidproducto = b.intidproducto and b.bolcontrolinventario = true and b.strestado = true
           inner join tblcatexistencia c on a.intidproducto = c.intidproducto /*and c.intexistencia > a.numcantidad*/
           where a.strusuariocreo = '$usuario'");

           while($row_facturado = pg_fetch_array($result_facturado))
           {
             $producto = $row_facturado['intidproducto'];
             $cantidad = $row_facturado['numcantidad'];
             $cantidad_bonif = $row_facturado['numcantbonificado'];

             pg_query($con,"UPDATE tblcatexistencia
                            Set  intexistencia = (tblcatexistencia.intexistencia + $cantidad + $cantidad_bonif)
                                ,total = (tblcatexistencia.intexistencia + $cantidad) * tblcatexistencia.numcosto
                            where tblcatexistencia.intidproducto = $producto");

           }

           pg_query($con,"DELETE FROM tbltempfacturadetalle_compra WHERE strusuariocreo = '$usuario'");


           echo base64_encode($numero_factura);
         }

      }else{
        //echo ;
      }

  /* }else{
     echo "VERICAR EXISTENCIAS";
   }  */

  } catch (\Exception $e) {

  }

}

function eliminar_factura_compra($id,$numfactura)
{
  $con = conexion_bd(1);

  $usuario = $_SESSION["correo"];

  $id = base64_decode($id);
  $numfactura = base64_decode($numfactura);

  $sql="UPDATE tblcatfacturaencabezado_compra
        SET strestado = 'ANULADA'
        WHERE intidserie = $id and strestado <> 'ANULADA';";


  $result = pg_query($con,$sql);

  $filas = pg_affected_rows ( $result );

  if($filas > 0)
  {
    pg_query($con,"DELETE FROM tbltrnmovimientos WHERE numreferencia = $numfactura and strreferencia = 'COMPRA';
                   SELECT public.fnactualizar_saldo_cuenta(2,'$usuario');");

    /*AQUI EL CODIGO PARA ACTUALIZAR EL INVENTARIO*/
    $result_facturado = pg_query($con,"SELECT a.intidproducto, a.numcantidad, a.numcantbonificado
    from tblcatfacturadetalle_compra a inner join tblcatproductos b on
    a.intidproducto = b.intidproducto and b.bolcontrolinventario = true
    inner join tblcatexistencia c on a.intidproducto = c.intidproducto
    where a.intidfactura = $id");

    while($row_facturado = pg_fetch_array($result_facturado))
    {
      $producto = $row_facturado['intidproducto'];
      $cantidad = $row_facturado['numcantidad'];
      $cant_bonificado = $row_facturado['numcantbonificado'];

      pg_query($con,"UPDATE tblcatexistencia
                     Set  intexistencia = (tblcatexistencia.intexistencia - ($cantidad + $cant_bonificado))
                         ,total = (tblcatexistencia.intexistencia - $cantidad) * tblcatexistencia.numcosto
                     where tblcatexistencia.intidproducto = $producto");

    }

    echo "<div class='alert alert-success alert-dismissible alerta'>
          <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>¡Exito!</strong> Se ha anulado con exito.
          </div>";


  }else {

    echo "<div class='alert alert-warning alert-dismissible alerta'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>¡Disculpe!</strong> No se anulo por favor intente nuevamente, si no reporta al administrador.
          </div>";
  }

}
?>
