<?php
ob_start();
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once 'cn.php';

$conexion = conexion_bd(1);
if (!$conexion) {
    error_log('Error: no se pudo conectar a la BD');
    http_response_code(500);
    exit('Error de conexión');
}

$medidaTicket = 180;
$num_factura = isset($_GET['factura']) ? (int) base64_decode($_GET['factura']) : 0;
$reimpresion = isset($_GET['print']) ? base64_decode($_GET['print']) : null;

$sql = "SELECT a.strusuariocreo cajero, *, 
               to_char(a.datfechacreo,'DD/MM/YYYY') fecha_facturo,
               to_char(a.datfechacreo,'HH24:MI:SS') hora_facturo,
               concat(c.strpnombre,' ',c.strsnombre,' ',c.strpapellido,' ',c.strsapellido) cliente
        FROM public.tblcatfacturaencabezado a
        INNER JOIN public.tblcatfacturadetalle b ON a.intidserie = b.intidfactura
        INNER JOIN tblcatclientes c ON a.intidcliente = c.intidcliente
        WHERE a.intidserie = $1";

$result = pg_query_params($conexion, $sql, [$num_factura]);

if (!$result) {
    error_log('Error SQL encabezado: ' . pg_last_error($conexion));
    http_response_code(500);
    exit('Error consultando factura');
}

$row_encabezado = pg_fetch_array($result);
if (!$row_encabezado) {
    http_response_code(404);
    exit('Factura no encontrada');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin GYM</title>
    <style>
        * {
            font-size: 12px;
            font-family: DejaVu Sans, sans-serif;
        }
        h1 { font-size: 18px; }
        td, th, tr, table {
            border-top: 1px solid black;
            border-collapse: collapse;
            margin: 0 auto;
        }
        td.precio { text-align: right; font-size: 11px; }
        td.cantidad { font-size: 11px; }
        td.producto { text-align: center; }
        th { text-align: center; }
        .centrado { text-align: center; align-content: center; }
        .ticket {
            width: <?php echo $medidaTicket ?>px;
            max-width: <?php echo $medidaTicket ?>px;
            margin: 2px;
            padding: 2px;
        }
        body { margin: 0; padding: 0; }
    </style>
</head>
<body>
<div class="centrado">
    <br>
    <?php if ($reimpresion !== null) { ?>
        <p style="font-size:10px"><strong>*****REIMPRESION*****</strong></p>
    <?php } ?>

    <p style="font-size:10px">Factura: <?php echo str_pad($row_encabezado['numerofactura'], 10, "0", STR_PAD_LEFT); ?></p>
    <p style="font-size:10px">Fecha: <?php echo htmlspecialchars($row_encabezado['fecha_facturo']); ?></p>
    <p style="font-size:10px">Hora: <?php echo htmlspecialchars($row_encabezado['hora_facturo']); ?></p>
    <p style="font-size:10px">Cliente: <?php echo htmlspecialchars($row_encabezado['cliente']); ?></p>
    <p style="font-size:10px">CAJERO: <?php echo htmlspecialchars($row_encabezado['cajero']); ?></p>
    <p style="font-size:10px"><?php echo htmlspecialchars($row_encabezado['strtipo']); ?></p>

    <table>
        <thead>
        <tr>
            <th class="cantidad" style="font-size:11px"><p>CANT</p></th>
            <th class="producto" style="font-size:11px">DESC</th>
            <th class="precio" style="font-size:11px">C$</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sqlDetalle = "SELECT *,
                              a.numdescuento descuento_encabezado,
                              b.numdescuento descuento_detalle,
                              (b.numdescuento * b.numsubttotal) desc_aplic_det
                       FROM public.tblcatfacturaencabezado a
                       INNER JOIN public.tblcatfacturadetalle b ON a.intidserie = b.intidfactura
                       INNER JOIN tblcatclientes c ON a.intidcliente = c.intidcliente
                       WHERE a.intidserie = $1";

        $resultDetalle = pg_query_params($conexion, $sqlDetalle, [$num_factura]);

        if (!$resultDetalle) {
            error_log('Error SQL detalle: ' . pg_last_error($conexion));
            http_response_code(500);
            exit('Error consultando detalle');
        }

        $neto = 0;
        $descuento = 0;
        $descuento_detalle = 0;
        $descuento_encabezado = 0;
        $impuesto = 0;
        $total = 0;

        while ($row_detalle = pg_fetch_array($resultDetalle)) {
            $neto += $row_detalle["numcantidad"] * $row_detalle["numprecioventa"];
            $descuento_detalle += $row_detalle["desc_aplic_det"];
            $descuento_encabezado = $row_detalle["descuento_encabezado"];
            $impuesto = $row_detalle['numiva'];
            $valor = $row_detalle["numcantidad"] * $row_detalle["numprecioventa"];
            ?>
            <tr>
                <td class="cantidad" style="font-size:11px"><?php echo $row_detalle["numcantidad"]; ?></td>
                <td class="producto" style="font-size:11px"><?php echo htmlspecialchars($row_detalle["strdescripcionproducto"]); ?></td>
                <td class="precio" style="font-size:11px"><?php echo number_format($valor, 2); ?></td>
            </tr>
        <?php } 
        $descuento = $descuento_detalle + $descuento_encabezado;
        $total = ($neto - $descuento) + $impuesto;
        ?>
        </tbody>
        <tr>
            <td class="cantidad"><strong>Neto</strong></td>
            <td class="producto"></td>
            <td class="precio"><?php echo number_format($neto, 2); ?></td>
        </tr>
        <tr>
            <td class="cantidad"><strong>Descuento</strong></td>
            <td class="producto"></td>
            <td class="precio"><?php echo number_format($descuento, 2); ?></td>
        </tr>
        <tr>
            <td class="cantidad"><strong>IVA</strong></td>
            <td class="producto"></td>
            <td class="precio"><?php echo number_format($impuesto, 2); ?></td>
        </tr>
        <tr>
            <td class="cantidad"><strong>Total</strong></td>
            <td class="producto"></td>
            <td class="precio"><?php echo number_format($total, 2); ?></td>
        </tr>
    </table>

    <p class="centrado" style="font-size: 9px;">sixpackgymnicaragua@gmail.com</p>
    <p class="centrado" style="font-size: 9px;">Whatsapp 8417-1616</p>
    <p class="centrado" style="font-size: 9px">Rotonda de Rubenia 1 cuadra al este, esquina a mano derecha.</p>
    <p class="centrado" style="font-size: 9px">¡GRACIAS POR SU VISITA!</p>
</div>
</body>
</html>
<?php

require_once '../dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$html = ob_get_clean();

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'DejaVu Sans');

$dompdf = new Dompdf($options);
$dompdf->setPaper([0, 0, 252, 650]);
$dompdf->set_option('dpi', 70);
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->render();

if (ob_get_length()) {
    ob_end_clean();
}

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="documento.pdf"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');

echo $dompdf->output();
exit;