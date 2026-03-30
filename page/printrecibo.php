<?php ob_start();
require_once 'cn.php';

$medidaTicket = 180;

$num_factura = $_GET['factura'];
$recibo = $_GET['recibo'];

/*CARGA LA INFORMACION DE LA FACTURA*/
$sql = "SELECT a.strusuariocreo cajero, * , to_char(a.datfechacreo,'DD/MM/YYYY')fecha_facturo,
 to_char(a.datfechacreo,'HH24:MI:SS')hora_facturo,
concat(c.strpnombre,' ',c.strsnombre,' ',c.strpapellido,' ',c.strsapellido) cliente
FROM public.tblcatfacturaencabezado a
inner join public.tblcatfacturadetalle b on a.intidserie = b.intidfactura
inner join tblcatclientes c on a.intidcliente = c.intidcliente
where a.numerofactura = $num_factura";
$result = pg_query(conexion_bd(1),$sql);
$row_encabezado = pg_fetch_array($result);

/*CALCULA EL SALDO DE LA CUENTA EN FUNCION DEL RECIBO O PAGO GENERADO*/
$sql_saldo = "SELECT a.numerofactura, a.numtotal, sum(b.numtotal_cobrado) total_pagado, a.numtotal - sum(b.numtotal_cobrado) saldo
FROM public.tblcatfacturaencabezado a inner join
(
select intnumdocumento, numerofactura, numtotal_cobrado
from tbltrnpagos
where intnumdocumento <= $recibo
group by intnumdocumento,numerofactura
) b on a.numerofactura = b.numerofactura
where b.numerofactura = $num_factura
group by a.numerofactura, a.numtotal";
$rows_saldo_factura = pg_fetch_array(pg_query(conexion_bd(1),$sql_saldo));
$saldo_factura = number_format($rows_saldo_factura['saldo'],2);
$total_factura = number_format($rows_saldo_factura['numtotal'],2);
$total_pagado = number_format($rows_saldo_factura['total_pagado'],2);
//$doc_recibo = $rows_saldo_factura['intnumdocumento'];

$sql_recibo = "SELECT datfechacreo, strusuariocreo creo_recibo, to_char(datfechacreo,'DD/MM/YYYY')fecha_recibo,
               to_char(datfechacreo,'HH24:MI:SS')hora_recibo
               from tbltrnpagos
               where intnumdocumento = $recibo";
$row_recibo = pg_fetch_array(pg_query(conexion_bd(1),$sql_recibo));
$fecha_creo_recibo = $row_recibo['fecha_recibo'];
$hora_creo_recibo = $row_recibo['hora_recibo'];
$usuario_creo_recibo = $row_recibo['creo_recibo'];

?>
<!DOCTYPE html>
<html>

<head>

  <?php require_once 'icon.php'?>
  <title>Admin GYM</title>

    <style>
        * {
            font-size: 12px;
            font-family: 'DejaVu Sans', serif;
        }

        h1 {
            font-size: 18px;
        }

        .ticket {
            margin: 2px;
        }

        td,
        th,
        tr,
        table {
            border-top: 1px solid black;
            border-collapse: collapse;
            margin: 0 auto;
        }

        td.precio {
            text-align: right;
            font-size: 11px;
        }

        td.cantidad {
            font-size: 11px;
        }

        td.producto {
            text-align: center;
        }

        th {
            text-align: center;
        }


        .centrado {
            text-align: center;
            align-content: center;
        }

        .ticket {
            width: <?php echo $medidaTicket ?>px;
            max-width: <?php echo $medidaTicket ?>px;
        }

        /*img {
            max-width: inherit;
            width: inherit;
        }*/

        * {
            margin: 2;
            padding: 0;
        }

        .ticket {
            margin: 2px;
            padding: 2px;
        }

        body {
            /*text-align: center;*/
        }
    </style>

</head>

<body>
    <div class="centrado">
      <br>
			<img src="../img/logo_fact_2.jpg">
      <!--  <h1>SIX PACK</h1>
				<h1>GYM</h1> -->
        <p style="font-size:10px">Recibo N°: <?php echo  $recibo?></p>
        <p style="font-size:10px">Pago de Factura: <?php echo str_pad($row_encabezado['numerofactura'], 10 , "0", STR_PAD_LEFT) ?></p>
        <p style="font-size:10px">Fecha: <?php echo $fecha_creo_recibo ?></p>
				<p style="font-size:10px">Hora: <?php echo $hora_creo_recibo ?></p>
				<p style="font-size:10px">Cliente: <?php echo $row_encabezado['cliente'] ?></p>
				<p style="font-size:10px">CAJERO: <?php echo $usuario_creo_recibo ?></p>
        <p style="font-size:10px"><?php echo $row_encabezado['strtipo'] ?></p>

        <table>
            <thead>
                <tr>
                    <th class="cantidad" style="font-size:11px"><p>CANT</p></th>
                    <th class="producto" style="font-size:11px">DESC</th>
									<!--	<th class="cantidad" style="font-size:11px">PRECIO</th>  -->
                    <th class="precio" style="font-size:11px">C$</th>
                </tr>
            </thead>
            <tbody>
                <?php

								$sql = "SELECT *, to_char(a.datfechacreo,'DD/MM/YYYY')fecha_facturo,
								 to_char(a.datfechacreo,'HH24:MI:SS')hora_facturo,
								concat(c.strpnombre,' ',c.strsnombre,' ',c.strpapellido,' ',c.strsapellido) cliente,
                a.numdescuento descuento_encabezado, b.numdescuento descuento_detalle,
                (b.numdescuento * b.numsubttotal) desc_aplic_det
								FROM public.tblcatfacturaencabezado a
								inner join public.tblcatfacturadetalle b on a.intidserie = b.intidfactura
								inner join tblcatclientes c on a.intidcliente = c.intidcliente
								where a.numerofactura = $num_factura ";
								$result = pg_query(conexion_bd(1),$sql);


                $neto = 0;
								$descuento=0;
                $descuento_detalle=0;
                $descuento_encabezado=0;
                $impuesto = 0;
								$total=0;
                while ($row_detalle = pg_fetch_array($result)) {

                    $neto += $row_detalle["numcantidad"] * $row_detalle["numprecioventa"];

                    $descuento_detalle += $row_detalle["desc_aplic_det"];

                    $descuento_encabezado = $row_detalle["descuento_encabezado"];

                    $impuesto = $row_detalle['numiva'];

                    $valor =  $row_detalle["numcantidad"]* $row_detalle["numprecioventa"];
                ?>
                    <tr>
                        <td class="cantidad" style="font-size:11px; aling:center"><?php echo $row_detalle["numcantidad"] ?></td>
                        <td class="producto" style="font-size:11px"><?php echo $row_detalle["strdescripcionproducto"] ?></td>
											<!--	<td class="cantidad" style="font-size:11px"><?php //echo  number_format($row_detalle["numprecioventa"],2) ?></td> -->
                        <td class="precio" style="font-size:11px"><?php echo number_format(	$valor, 2) ?></td>
                    </tr>
                <?php }
                  $descuento = 	$descuento_detalle +  $descuento_encabezado;

                  $total=($neto-$descuento) + $impuesto;
                 ?>
            </tbody>
        <!--    <tr>
                <td class="cantidad"><strong>Neto</strong></td>
								<td class="producto"></td>

                <td class="precio">
                    <?php //echo number_format($neto, 2) ?>
                </td>
            </tr>
						<tr>
                <td class="cantidad"><strong>Descuento</strong></td>
								<td class="producto"> </td>

                <td class="precio">
                    <?php //echo number_format($descuento, 2) ?>
                </td>
            </tr>
            <tr>
                <td class="cantidad"><strong>IVA</strong></td>
                <td class="producto"> </td>

                <td class="precio">
                    <?php //echo number_format($impuesto, 2) ?>
                </td>
            </tr> -->
						<tr>
                <td class="cantidad"><strong>Total</strong></td>
								<td class="producto"> </td>

                <td class="precio">
                  <?php echo number_format($total, 2) ?>
                </td>
            </tr>
            <tr>
                <td class="cantidad"><strong>Pago</strong></td>
								<td class="producto"> </td>

                <td class="precio">
                  <?php echo number_format($total_pagado, 2) ?>
                </td>
            </tr>
            <tr>
                <td class="cantidad"><strong>Saldo</strong></td>
								<td class="producto"> </td>

                <td class="precio">
                  <?php echo number_format($saldo_factura , 2) ?>
                </td>
            </tr>
        </table>
						<p class="centrado" style="font-size: 9px;">sixpackgymnicaragua@gmail.com</p>
            <p class="centrado" style="font-size: 9px">Rotonda de Rubenia 1 cuadra al este, esquina a mano derecha.
whatsapp 8417-1616</p>
						<p class="centrado" style="font-size: 9px">¡GRACIAS POR SU VISITA!</p>
    </div>
</body>

</html>
<?php
//include_once "./vendor/autoload.php";
require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->setPaper(array(0,0,252,650));
$dompdf->set_option('dpi', 70);
//ob_start();
//require_once "factura.php";
$html = ob_get_clean();
$dompdf->loadHtml($html);
$dompdf->render();
header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=recibo.pdf");
echo $dompdf->output();
?>
