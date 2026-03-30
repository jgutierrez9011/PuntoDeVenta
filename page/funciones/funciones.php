<?php

function limpiar($tags){
  $tags = trim($tags);
  return $tags;
}


function estado($estado){
 if($estado=='t'){
   return '<span class="label label-success">Activo</span>';
 }else{
   return '<span class="label label-danger">No Activo</span>';
 }
}

/*Funcion utilizada para mandar mensaje a pantalla de exito, error, informacion de cada procedimiento del CRUD*/
function mensajes($mensaje,$tipo){
 if($tipo=='verde'){
   $tipo='alert alert-success';
 }elseif($tipo=='rojo'){
   $tipo='alert alert-danger';
 }elseif($tipo=='azul'){
   $tipo='alert alert-info';
 }
 return '<div class="'.$tipo.'" align="center">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>'.$mensaje.'</strong>
          </div>';
}

function tasa_cambio($con)
{
  $sql="SELECT monto from tblcattasacambio where fecha = current_date";
  $result = pg_query($con,$sql);
  $row = pg_fetch_array($result);
  echo $row['monto'];
}



function fill_descuento($con,$id,$val,$estilo,$estado)
{
  //$con = conexion_bd(1);

  $sql = pg_query($con,"SELECT intidimpuesto, descripcion, numvalor FROM public.tblcatdescuento order by numvalor asc");

  $combo = "<select class='".$estilo."' id='cmbdescuento_".$id."'  name='cmbdescuento_".$id."' onchange='tax_value()' ".$estado." placeholder='descuento'>";
  while($row = pg_fetch_assoc($sql))
  {
      $combo =   $combo . "<option value='".$row['numvalor']."'";

    if( $row['numvalor'] == $val )
    {
          $combo =   $combo . 'selected';
    }

      $combo = $combo . ">". $row['descripcion'] ."</option>";
  }

  return $combo."</select>";

  pg_close($con);
}

function fill_impuesto($con,$id,$val,$estilo,$estado)
{
  //$con = conexion_bd(1);

  $sql = pg_query($con,"SELECT intidimpuesto, nombre, numvalor FROM public.tblcatimpuesto");

  $combo = "<select class='".$estilo."' id='cmbimpuesto_".$id."'  name='cmbimpuesto_".$id."'  onchange='tax_value()' ".$estado." placeholder='descuento'>";
  while($row = pg_fetch_assoc($sql))
  {
      $combo =   $combo . "<option value='".$row['numvalor']."'";

    if( $row['numvalor'] == $val )
    {
          $combo =   $combo . 'selected';
    }

      $combo = $combo . ">". $row['nombre'] ."</option>";
  }

  return $combo."</select>";

  pg_close($con);
}

function fill_tipofactura($con,$id,$val,$estilo)
{
try {
  //$con = conexion_bd(1);

  $sql = pg_query($con,"SELECT intid, tipo, boolactivo
FROM public.tblcattipofactura
where boolactivo = true");

  //$combo = "<select class='".$estilo."' id='cmbtipo_".$id."' disabled name='cmbtipo_".$id."' placeholder='Contado o Credito'>";
  $combo="" ;
  while($row = pg_fetch_assoc($sql))
  {
    $combo =   $combo . "<option value='".$row['tipo']."'";

    if($row['tipo'] == $val )
    {
          $combo =   $combo . 'selected';
    }

      $combo = $combo . ">". $row['tipo'] ."</option>";
  }

 //return $combo."</select>";

 return $combo;



  pg_close($con);
} catch (\Exception $e) {

}

}


/*function generate_numbers($start, $count, $digits) {
   $result = array();
   for ($n = $start; $n < $start + $count; $n++) {
      $result[] = str_pad($n, $digits, "0", STR_PAD_LEFT);
   }
   return $result;
}*/

function fn_generar_factura($con)
{
  $sql = "SELECT count(coalesce(numerofactura,0)) + 1 num_factura
          FROM tblcatfacturaencabezado";
  $result = pg_query($con,$sql);
  $row = pg_fetch_array($result);
  echo str_pad($row['num_factura'], 10 , "0", STR_PAD_LEFT);

}

function fn_generar_factura_compra($con)
{
  $sql = "SELECT count(coalesce(numerofactura,0)) + 1 num_factura
          FROM tblcatfacturaencabezado_compra";
  $result = pg_query($con,$sql);
  $row = pg_fetch_array($result);
  echo str_pad($row['num_factura'], 10 , "0", STR_PAD_LEFT);

}

function fill_detalle_venta($cn,$descuento_aplicado,$impuesto_aplicado)
{
  $usuario = $_SESSION["correo"];

//  $cn =  conexion_bd(1);

$perfil = $_SESSION["intidperfil"];
$atributo = NULL;
$atributo_iva = NULL;

$row_permiso = pg_fetch_array(pg_query($cn,"SELECT bolactivo
                             from public.tblcatperfilusrfrmdetalle
                             where idfrmdetalle = 2 and idperfil =  $perfil"));
if($row_permiso['bolactivo'] == 'f')
{
  $atributo = 'disabled';
}

$row_permiso_iva = pg_fetch_array(pg_query($cn,"SELECT bolactivo
                             from public.tblcatperfilusrfrmdetalle
                             where idfrmdetalle = 3 and idperfil =  $perfil"));
if($row_permiso_iva['bolactivo'] == 'f')
{
  $atributo_iva = 'disabled';
}

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


     $combo_descuento = fill_descuento(conexion_bd(1), 'factura' ,$descuento_aplicado, 'n', $atributo);
     $combo_impuesto = fill_impuesto(conexion_bd(1), 'factura' ,$impuesto_aplicado, 'n', $atributo_iva);

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


          $descuento = number_format($neto * $descuento_aplicado,2);

          $iva = number_format(($neto - $descuento) * $impuesto_aplicado,2);

          $total = number_format(($neto - $descuento) + $iva,2);

          $retorno = $retorno."<tr>
          <td colspan='6' align='right'><strong>NETO C$</strong></td>
          <td colspan='4' align='left'><p class='small'>".$neto."</p>
          <input type='hidden' name='neto_factura' id='neto_factura' value='$neto' />
          </td>
                               </tr>

                               <tr>
                               <td colspan='6' align='right'>
                               <strong><p class'small'>Descuento ". $combo_descuento ." </strong></p>
                               </td>
          <td colspan='4' align='left'>
          <p class='small' >".$descuento."</p>
          <input type='hidden' name='descuento_factura' id='descuento_factura' value='$descuento' />
          </td>
                               </tr>

                               <tr>
                               <td colspan='6' align='right'>
                                <strong><p class'small'>Impuesto ". $combo_impuesto ." </strong></p>
                               </td>
          <td colspan='4' align='left'>
          <p class='small' >".$iva."</p>
          <input type='hidden' name='iva_factura' id='iva_factura' value='$iva' />
          </td>
                               </tr>

          <td colspan='6' align='right'><strong>Total a pagar C$</strong></td>
          <td colspan='4' align='left'>
          <p class='small'>".$total."</p>
          <input type='hidden' name='total_factura' id='total_factura' value='$total' />
          </td>
                              </tr>
                               </tbody>
                               </table>
                               </div>";

          echo $retorno;
}

function fill_detalle_compra($cn,$descuento_aplicado,$impuesto_aplicado)
{
  $usuario = $_SESSION["correo"];

//  $cn =  conexion_bd(1);

$perfil = $_SESSION["intidperfil"];
$atributo = NULL;
$atributo_iva = NULL;

$row_permiso = pg_fetch_array(pg_query($cn,"SELECT bolactivo
                             from public.tblcatperfilusrfrmdetalle
                             where idfrmdetalle = 4 and idperfil =  $perfil"));
if($row_permiso['bolactivo'] == 'f')
{
  $atributo = 'disabled';
}

$row_permiso_iva = pg_fetch_array(pg_query($cn,"SELECT bolactivo
                             from public.tblcatperfilusrfrmdetalle
                             where idfrmdetalle = 5 and idperfil =  $perfil"));
if($row_permiso_iva['bolactivo'] == 'f')
{
  $atributo_iva = 'disabled';
}

   $sql = "SELECT a.intidserie, a.intidproducto, a.numcantidad, a.numcantbonificado, a.strdescripcionproducto,
           round(a.numprecioventa,2) numprecioventa , a.numsubttotal, a.numdescuento, round(a.numtotal,2) numtotal, a.strusuariocreo,
           round((a.numcantidad *   a.numprecioventa) * a.numdescuento,2) descuento_aplicado,
           a.datfechacreo, rank() over (order by a.datfechacreo asc) as rownumber
           FROM tbltempfacturadetalle_compra a
           where a.strusuariocreo = '$usuario'";

     $resul = pg_query($cn,$sql);
     $neto = 0;
     $descuento = number_format(0,2);
     $iva = number_format(0,2);
     $total = 0;


     $combo_descuento = fill_descuento(conexion_bd(1), 'factura' ,$descuento_aplicado, 'n', $atributo);
     $combo_impuesto = fill_impuesto(conexion_bd(1), 'factura' ,$impuesto_aplicado, 'n', $atributo_iva);

   $retorno = "  <div class='row table-responsive'>
                  <table class='table table-bordered' id='' style='width:100%'>
              <thead>
              <tr class='warning'>
               <th><p class='small'><strong>N° Fila</strong></p></th>
              <th><p class='small'><strong>Codigo</strong></p></th>
              <th><p class='small'><strong>Cantidad</strong></p></th>
              <th><p class='small'><strong>Bonificado</strong></p></th>

              <th><p class='small'><strong>Descripcion</strong></p></th>
              <th><p class='small'><strong>Precio costo unit C$</strong></p></th>
              <th><p class='small'><strong>Descuento C$</strong></p></th>
              <th><p class='small'><strong>Precio total C$</strong></p></th>
              <th></th>

              </tr>
              </thead>
              <tbody>";
    while ($row = pg_fetch_array($resul)){

          $idproducto = $row["intidproducto"];

             $neto = $neto + $row["numtotal"];
             //echo $neto."---";
             $total = $neto;
          $retorno = $retorno."<tr>
                               <td><p class='small'>".$row["rownumber"]."</p></td>
                               <td><p class='small'>".$row["intidproducto"]."</p></td>
                               <td><p class='small'>".$row["numcantidad"]."</p></td>
                               <td><p class='small'>".$row["numcantbonificado"]."</p></td>

                               <td><p class='small'>".$row["strdescripcionproducto"]."</p></td>


                               <td><p class='small'>".$row["numprecioventa"]."</p></td>

                               <td><p class='small'>".$row["descuento_aplicado"]."</p></td>

                               <td><p class='small'>".$row["numtotal"]."</p></td>

                               <td><a data-toggle='modal' data-target='#confirm-delete' id='".$row["intidserie"]."' class='btn btn-danger delete_data'><span class='fa fa-trash-o'></span></a></td>




                               </tr>";}



          $descuento = number_format($neto * $descuento_aplicado,2);

          $iva = number_format(($neto - $descuento) * $impuesto_aplicado,2);

          $total = number_format(($neto - $descuento) + $iva,2);

          $retorno = $retorno."<tr>

          <td colspan='7' align='right'><strong>NETO C$</strong></td>
          <td colspan='5' align='left'><p class='small'>".number_format($neto,2)."</p>
          <input type='hidden' name='neto_factura' id='neto_factura' value='".number_format($neto,2)."' />
          </td>
                               </tr>

                               <tr>
                               <td colspan='7' align='right'>
                               <strong><p class'small'>Descuento ". $combo_descuento ." </strong></p>
                               </td>
          <td colspan='5' align='left'>
          <p class='small' >".$descuento."</p>
          <input type='hidden' name='descuento_factura' id='descuento_factura' value='$descuento' />
          </td>
                               </tr>

                               <tr>
                               <td colspan='7' align='right'>
                                <strong><p class'small'>Impuesto ". $combo_impuesto ." </strong></p>
                               </td>
          <td colspan='5' align='left'>
          <p class='small' >".$iva."</p>
          <input type='hidden' name='iva_factura' id='iva_factura' value='$iva' />
          </td>
                               </tr>

          <td colspan='7' align='right'><strong>Total a pagar C$</strong></td>
          <td colspan='5' align='left'>
          <p class='small'>".$total."</p>
          <input type='hidden' name='total_factura' id='total_factura' value='$total' />
          </td>
                              </tr>
                               </tbody>
                               </table>
                               </div>";

          echo $retorno;
}

/*Funcion para enviar correos*/
function sendmail($nombre, $remitente, $receptor, $asunto, $cuerpo)
{
  $headers  = "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

  //dirección del remitente
  $headers .= "From: ".$nombre." <".$remitente.">\r\n";

  //Una Dirección de respuesta, si queremos que sea distinta que la del remitente
  $headers .= "Reply-To: ".$remitente."\r\n";

  mail($receptor,$asunto,$cuerpo,$headers);
}
 ?>
