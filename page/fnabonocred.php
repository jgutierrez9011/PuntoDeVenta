<?php
require_once 'cn.php';
require_once 'reg.php';

if(isset($_POST['factura']))
{
   fn_fill_pagos($_POST['factura']);
}

if(isset($_POST['numfactura']))
{
   fill_nuevo_recibo($_POST['numfactura']);
}

if((isset($_POST['numero_factura'])))
{
   insertar_pago($_POST['numero_factura'], $_POST['total'], $_POST['note']);
}

if((isset($_POST['doc_recibo'])) && (isset($_POST['fact_comprobante'])))
{
  delete_recibo($_POST['doc_recibo'],$_POST['fact_comprobante']);
}

function fn_fill_pagos($factura)
{
  try {
    $con = conexion_bd(1);

    $sql="SELECT intnumdocumento, numerofactura, intserie, datfecha,
          intidcliente, numtotal_cobrado, strobservacion, datfechacreo,
          strusuariocreo, datfechamodifico, strusuariomodifico
          FROM tbltrnpagos_cxp where numerofactura = $factura";

    $result = pg_query($con,$sql);


    $sql_saldo = "SELECT a.numerofactura, a.numtotal, coalesce(b.total_pagado,0) total_pagado, (a.numtotal - b.total_pagado)  saldo
FROM public.tblcatfacturaencabezado_compra a left join
(select numerofactura, sum(numtotal_cobrado) total_pagado
from tbltrnpagos_cxp
group by numerofactura) b on a.numerofactura = b.numerofactura
where a.numerofactura = $factura";
    $rows_saldo_factura = pg_fetch_array(pg_query($con,$sql_saldo));
    $saldo_factura = number_format($rows_saldo_factura['saldo'],2);
    $total_factura = number_format($rows_saldo_factura['numtotal'],2);
    $total_pagado = number_format($rows_saldo_factura['total_pagado'],2);

    $perfil = $_SESSION["intidperfil"];

    /*SE CONSULTA PERMISO PARA OPCION DE ANULAR RECIBOS*/
    $row_permiso_recibos = pg_fetch_array(pg_query(conexion_bd(1),"SELECT bolactivo
                                                                    from public.tblcatperfilusrfrmdetalle
                                                                    where idfrmdetalle = 17 and idperfil =  $perfil"));
    $row_permiso_recibos_estado = $row_permiso_recibos['bolactivo'];

    $retorno = "<div class='pull-right' style='margin-top:-60px;'>
   <button class='btn btn-primary nuevo_recibo' data-toggle='modal' data-target='#agregarCobroModal' data-id='".$factura."' id='".$factura."'><i class='fa fa-plus'></i> <div class='hidden-xs' style='display:inline-block'>Agregar cobro</div></button>
   </div>";

   $retorno = $retorno. "
                 <div class='row'>
                 <div class='col-md-12'>
                 <div class='row table-responsive'>

                  <table class='table' id='tbl_pagos'>
              <thead>
              <tr class='warning'>

              <th><p class='small'><strong>#</strong></p></th>
              <th><p class='small'><strong>Fecha</strong></p></th>
              <th><p class='small'><strong>Total</strong></p></th>
              <th><p class='small'><strong>Acciones</strong></p></th>

              </tr>
              </thead>
              <tbody>";

$filas =  pg_affected_rows($result);

if($filas > 0)
{

   while ($row = pg_fetch_array($result)){

         $idrecibo = $row["intnumdocumento"];
         $total_recibo = number_format($row["numtotal_cobrado"],2);

         $retorno = $retorno."<tr>
                              <td><p class='small' >".$row["intnumdocumento"]." <input type='hidden' class='form-control'  id='recibo_".$idrecibo."' value='$idrecibo' /></p></td>

                              <td><p class='small'>".$row["datfecha"]."</p></td>

                              <td><p class='small' >". $total_recibo ."<input type='hidden' class='form-control'  id='recibo_total_".$total_recibo."' value='".$row["numtotal_cobrado"]."' /></p></td>

                              <td align='center'>

                              <a href='#' class='btn btn-default btn-sm' onclick=print_charge('".base64_encode($idrecibo)."','".base64_encode($factura)."');><i class='fa fa-print'></i></a>

                        <!--  <a href='#' class='btn btn-info btn-sm' data-toggle='modal' data-target='#editarCobroModal' data-id='".$idrecibo."' data-charge_id='".$idrecibo."'><i class='fa fa-edit'></i>  </a> -->
                              ";

                              if($row_permiso_recibos_estado == 't')
                              {
                                $retorno = $retorno."<a href='#' class='btn btn-danger btn-sm' onclick='eliminar_cobro(".$idrecibo.",".$factura.")'><i class='fa fa-trash'></i> </a>";
                              }

                              "</td>


                              </tr>";}

        $retorno = $retorno."<tr>
			                          <th class='text-right' colspan='2'>Monto de factura</th>
			                          <td class=''>". $total_factura ."</td>
                                <td></td>
		                         </tr>
                             <tr>
                     			      <th class='text-right' colspan='2'>Total abonado</th>
                     			      <td class=''>". $total_pagado ."</td>
                                <td></td>
                     		     </tr>
                             <tr>
                     			      <th class='text-right' colspan='2'>Saldo</th>
                     			      <td class=''>". $saldo_factura ."</td>
                                <td></td>
                     		     </tr>";
} else {

  $retorno = $retorno."<tr>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       </tr>";

                       $retorno = $retorno."<tr>
                                               <th class='text-right' colspan='2'>Monto de factura</th>
                                               <td class=''>". $total_factura ."</td>
                                               <td></td>
                                            </tr>
                                            <tr>
                                               <th class='text-right' colspan='2'>Total abonado</th>
                                               <td class=''>". $total_pagado ."</td>
                                               <td></td>
                                            </tr>
                                            <tr>
                                               <th class='text-right' colspan='2'>Saldo</th>
                                               <td class=''>". $saldo_factura ."</td>
                                               <td></td>
                                            </tr>";
}

           $retorno = $retorno."</tbody>
                                </table>
                                </div></div></div>";

           echo $retorno;

  } catch (\Exception $e) {
    echo $e;
  }

}

function insertar_pago($factura,$monto_cobrado,$observacion)
{
  try {
    $con = conexion_bd(1);

    $usuario = $_SESSION["correo"];

    $sql_num_recibo = "SELECT coalesce(max(coalesce(intnumdocumento,0)),0) + 1 as num_recibo
                       FROM tbltrnpagos_cxp";
    $result_num_recibo = pg_query($con,$sql_num_recibo);
    $row_num_recibo = pg_fetch_array($result_num_recibo);
    $num_recibo = $row_num_recibo["num_recibo"];

    $sql_factura = "SELECT a.numerofactura, lpad(a.numerofactura::text,10,'0') factura, c.strnombre_vendedor proveedor, to_char(a.datfechacreo,'DD-MM-YYYY') fecha,
  concat(f.strpnombre,' ',f.strsnombre,' ',f.strpapellido,' ',f.strsapellido) usuario,
  a.numsubtotal, a.numdescuento, a.numiva, a.numtotal, a.intidserie, a.strestado, a.strtipo tipo_factura,
  a.intidproveedor, $num_recibo as numero_recibo
  FROM  public.tblcatfacturaencabezado_compra a
 inner join public.tblcatfacturadetalle_compra b on a.intidserie = b.intidfactura
 inner join tblcatproveedor c on a.intidproveedor = c.intidproveedor
 inner join tblcatproductos d on b.intidproducto = d.intidproducto
 inner join tblcattipoproducto e on d.strtipo::integer = e.intidtipoproducto
 inner join tblcatusuario f on a.strusuariocreo = f.strcorreo and f.bolactivo = true
 where a.numerofactura = $factura
 group by 1,2,3,4,5,6,7,8,9,10,11,12
 order by a.numerofactura desc";

    $row_factura = pg_fetch_array(pg_query($con,$sql_factura));
    $idcliente = $row_factura['intidproveedor'];
    $tipofactura = $row_factura['tipo_factura'];

    if($tipofactura == 'CREDITO')
    {
      $sql_saldo = "SELECT a.numerofactura, a.numtotal, coalesce(b.total_pagado,0) total_pagado,
                    (a.numtotal - coalesce(b.total_pagado,0))  saldo
                    FROM public.tblcatfacturaencabezado_compra a left join
                    (select numerofactura, sum(numtotal_cobrado) total_pagado
                    from tbltrnpagos_cxp
                    group by numerofactura) b on a.numerofactura = b.numerofactura
                    where a.numerofactura = $factura";
      $rows_saldo_factura = pg_fetch_array(pg_query($con,$sql_saldo));
      $saldo_factura = $rows_saldo_factura['saldo'];
      $total_factura = $rows_saldo_factura['numtotal'];
      $total_pagado =  $rows_saldo_factura['total_pagado'] + $monto_cobrado;

      if($saldo_factura >= $monto_cobrado)
      {
        $sql_num_serie_recibo = "SELECT count(coalesce(intserie,0)) + 1 num_serie
                                 FROM tbltrnpagos_cxp where numerofactura = $factura";
        $result_num_serie_recibo = pg_query($con,$sql_num_serie_recibo);
        $row_num_serie_recibo = pg_fetch_array($result_num_serie_recibo);
        $num_serie_recibo = $row_num_serie_recibo["num_serie"];

        $sql="INSERT INTO tbltrnpagos_cxp(
              intnumdocumento, numerofactura, intserie, datfecha, intidcliente, numtotal_cobrado, strobservacion, datfechacreo, strusuariocreo)
              VALUES ($num_recibo, $factura, $num_serie_recibo, current_timestamp AT time zone 'CST6', $idcliente, $monto_cobrado, '$observacion', current_timestamp AT time zone 'CST6', '$usuario');
              select fnrecibocxp_calcular_saldo_cuenta2 ($num_recibo, 2,'$usuario');
              select fnrecibocxp_calcular_saldo_cuenta2 ($num_recibo, 6,'$usuario')";

        $result = pg_query($con,$sql);

        $cmdtuplas = pg_affected_rows($result);

        if($cmdtuplas > 0)
        {
           /*SI LA FACTURA YA FUE CANCELADA QUE EL ESTADO SEA CERRADO*/
           if( $total_factura == $total_pagado )
           {
               $sql_estado_factura = "UPDATE public.tblcatfacturaencabezado_compra
                                      SET datfechamodifico = current_timestamp AT time zone 'CST6',
                                          strusuariomodifico = '$usuario',
	                                        strestado = 'CERRADO'
                                      WHERE numerofactura = $factura";
               $result_estado_factura = pg_query($con,$sql_estado_factura);
           }
                     //$factura_doc = addslashes(base64_encode($factura));
                     //$num_recibo_doc = addslashes(base64_encode($num_recibo));
          echo "<script>
                    VentanaCentrada('printrecibocred.php?factura='+$factura +'&recibo=' + $num_recibo,'Recibo','','900','620','true');
                </script>
                <div class='alert alert-success alert-dismissible alerta'>
                <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>¡Exito!</strong> Se ha registrado el pago exitosamente.
                </div>";

        } else {

          echo "<div class='alert alert-warning alert-dismissible alerta'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>¡Disculpe!</strong> No se registro el pago por favor intente nuevamente, si no reporta al administrador.
                </div>";
        }
      }else {
        echo "<div class='alert alert-danger alert-dismissible alerta'>
              <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
              <strong>¡Disculpe!</strong> La factura no tiene saldo pendiente , no se registro pago.
              </div>";
      }

    }else {

      echo "<div class='alert alert-warning alert-dismissible alerta'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Disculpe!</strong> La factura no es de crédito , no se registro pago.
            </div>";
    }

  } catch (Exception $e) {
    echo $e;
  }
}


function fill_nuevo_recibo($factura)
{
  try {
    $con = conexion_bd(1);

    $usuario = $_SESSION["correo"];

    $sql_num_recibo = "SELECT coalesce(max(coalesce(intnumdocumento,0)),0) + 1 num_recibo
                     FROM tbltrnpagos_cxp";
    $result_num_recibo = pg_query($con,$sql_num_recibo);
    $row_num_recibo = pg_fetch_array($result_num_recibo);
    $num_recibo = $row_num_recibo["num_recibo"];

    $sql = "SELECT a.numerofactura, lpad(a.numerofactura::text,10,'0') factura, c.strnombre_vendedor proveedor, to_char(a.datfechacreo,'DD-MM-YYYY') fecha,
  concat(f.strpnombre,' ',f.strsnombre,' ',f.strpapellido,' ',f.strsapellido) usuario,
  a.numsubtotal, a.numdescuento, a.numiva, a.numtotal, a.intidserie, a.strestado, a.strtipo tipo_factura,
  a.intidproveedor, to_char(current_timestamp AT time zone 'CST6' ,'DD-MM-YYYYY HH12:MI:SS') fecha_actual , $num_recibo as numero_recibo
  FROM  public.tblcatfacturaencabezado_compra a
 inner join public.tblcatfacturadetalle_compra b on a.intidserie = b.intidfactura
 inner join tblcatproveedor c on a.intidproveedor = c.intidproveedor
 inner join tblcatproductos d on b.intidproducto = d.intidproducto
 inner join tblcattipoproducto e on d.strtipo::integer = e.intidtipoproducto
 inner join tblcatusuario f on a.strusuariocreo = f.strcorreo and f.bolactivo = true
 where a.numerofactura = $factura
 group by 1,2,3,4,5,6,7,8,9,10,11,12
 order by a.numerofactura desc";

        $row = pg_fetch_array(pg_query($con,$sql));

        $data = $row;

        echo json_encode($data);

  } catch (\Exception $e) {
    echo $e;
  }
}


function delete_recibo($recibo,$factura)
{
  try {
    $con = conexion_bd(1);

    $usuario = $_SESSION["correo"];

    $sql_delete_recibo = "DELETE FROM public.tbltrnpagos_cxp WHERE intnumdocumento = $recibo;";

    pg_query($con,"DELETE FROM tbltrnmovimientos WHERE numreferencia = $recibo and strreferencia = 'RECIBO_CXP' ;
                   SELECT public.fnactualizar_saldo_cuenta(6,'$usuario');
                   SELECT public.fnactualizar_saldo_cuenta(2,'$usuario');");

    $result = pg_query($con,$sql_delete_recibo);

    $sql_saldo = "SELECT a.numerofactura, a.numtotal, coalesce(b.total_pagado,0) total_pagado,
                  (a.numtotal - coalesce(b.total_pagado,0))  saldo
                  FROM public.tblcatfacturaencabezado_compra a left join
                  (select numerofactura, sum(numtotal_cobrado) total_pagado
                  from tbltrnpagos_cxp
                  group by numerofactura) b on a.numerofactura = b.numerofactura
                  where a.numerofactura = $factura";
    $rows_saldo_factura = pg_fetch_array(pg_query($con,$sql_saldo));
    $saldo_factura = $rows_saldo_factura['saldo'];
    $total_factura = $rows_saldo_factura['numtotal'];
    $total_pagado =  $rows_saldo_factura['total_pagado'];

    /*SI LA FACTURA YA FUE CANCELADA QUE EL ESTADO SEA CERRADO*/
    if( $total_factura == $total_pagado )
    {
        $sql_estado_factura = "UPDATE public.tblcatfacturaencabezado_compra
                               SET datfechamodifico = current_timestamp AT time zone 'CST6',
                                   strusuariomodifico = '$usuario',
                                   strestado = 'CERRADO'
                               WHERE numerofactura = $factura";
        $result_estado_factura = pg_query($con,$sql_estado_factura);
    }else {
      $sql_estado_factura = "UPDATE public.tblcatfacturaencabezado_compra
                             SET datfechamodifico = current_timestamp AT time zone 'CST6',
                                 strusuariomodifico = '$usuario',
                                 strestado = 'PENDIENTE'
                             WHERE numerofactura = $factura";
      $result_estado_factura = pg_query($con,$sql_estado_factura);
    }


    if($result)
    {

      echo "<div class='alert alert-success alert-dismissible alerta'>
            <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Exito!</strong> Se ha eleminido el pago exitosamente.
            </div>";
    }else {

      echo "<div class='alert alert-warning alert-dismissible alerta'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Disculpe!</strong> No se elimino el pago por favor intente nuevamente, si no reporta al administrador.
            </div>";
    }

  } catch (\Exception $e) {

  }

}

 ?>
