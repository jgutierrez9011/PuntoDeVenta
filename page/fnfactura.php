<?php
//include_once "./vendor/autoload.php";
require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->setPaper('b7', 'portrait');
ob_start();
require_once "factura.php";
$html = ob_get_clean();
$dompdf->loadHtml($html);
$dompdf->render();
header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=documento.pdf");
echo $dompdf->output();
