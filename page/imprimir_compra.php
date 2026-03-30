<?php
ob_start();

require_once 'cn.php';

$num_factura = base64_decode($_GET['factura']);

$sql = "SELECT *, to_char(a.datfechacreo,'DD/MM/YYYY') fecha_facturo,
 to_char(a.datfechacreo,'HH24:MI:SS')hora_facturo,
 upper(c.strnombre_vendedor) as vendedor,
 (b.numdescuento * b.numsubttotal) desc_aplic_det,
 a.numdescuento descuento_encabezado
FROM public.tblcatfacturaencabezado_compra a
inner join public.tblcatfacturadetalle_compra b on a.intidserie = b.intidfactura
inner join tblcatproveedor c on a.intidproveedor = c.intidproveedor
where a.numerofactura = $num_factura";
$result = pg_query(conexion_bd(1),$sql);
$row_encabezado = pg_fetch_array($result);

 ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Navigation -->
    <?php include 'icon.php' ?>
    <title>Admin GYM - Compra</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="../vendor/bootstrap/css/bootstrap-multiselect.css" rel="stylesheet">

    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <style type="text/css">

    .centrado {
        text-align: center;
        align-content: center;
    }

    footer {
               position: fixed;
               bottom: 0cm;
               left: 0cm;
               right: 0cm;
               height: 2cm;
           }

    </style>

</head>

<body>

         <footer>
    <p class="centrado" style="font-size: 9px;">sixpackgymnicaragua@gmail.com</p>
    <p class="centrado" style="font-size: 9px">Rubenia, de la funeraria bonilla 2 calles al norte, 1/2 cuadra al este.
whatsapp 8417-1616</p>
       </footer>

    <div id="">

        <!-- Navigation -->
        <?php //include 'menu.php' ?>

        <!-- Page Content -->
        <div id="">

 <!--<section> -->

            <div class="">
              <br>

              <div class="py-5 text-center">
                  <img class="d-block mx-auto mb-4" src="../img/logosinfondo_2.png" alt="" width="112" height="102">
              </div>

 <div class="row">
         <div class="col-md-12">
           <h2 class="page-header">
             SIXPACK GYM <small class="pull-right">Fecha: <?php echo $row_encabezado['fecha_facturo']; ?></small>
           </h2>
         </div><!-- /.col -->
 </div>
 <!-- info row -->


 <div class="row">
<table>
  <tr>
    <td>
      <div class="col-md-5">
         Vendedor / Proveedor
         <address>
           <strong><?php echo $row_encabezado['vendedor'] ?></strong>
           <br>Teléfono: <?php echo $row_encabezado['strtelefono_vendedor'] ?>
           <br>Email: <?php echo $row_encabezado['strcorreo_vendedor'] ?>
         </address>

       </div><!-- /.col -->
    </td>
    <td>
       <div class="col-md-5">
        Empresa
         <address>
           <strong>Nombre de la empresa : <?php echo $row_encabezado['strnombre_empresa'] ?></strong>
           <br>Dirección: <?php echo $row_encabezado['strdirreccion_empresa'] ?>
           <br>Teléfono: <?php echo $row_encabezado['strtelefono_empresa'] ?>
           <br>Sitio web: <?php echo $row_encabezado['strsitioweb_empresa'] ?>
         </address>

       </div><!-- /.col -->
     </td>
    <td>
      <div class="col-md-2">
           <b>Tipo :<?php echo $row_encabezado['strtipo'] ?></b><br>
           <b>Compra # <?php echo str_pad($row_encabezado['numerofactura'], 10 , "0", STR_PAD_LEFT) ?></b><br>
      <br>
       </div><!-- /.col -->
    </td>
  </tr>


</table>

 </div><!-- /.row -->


 <!-- Table row -->
 <div class="row">
   <div class="col-xs-12 table-responsive">
     <table class="table table-striped">
       <thead>
         <tr>
           <th>CODIGO</th>
           <th class='text-center'>CANT.</th>
           <th>DESCRIPCION</th>
           <th><span class="pull-right">PRECIO UNIT.</span></th>
   <th><span class="pull-right">PRECIO TOTAL</span></th>
         </tr>
       </thead>
       <tbody>
         <?php
            $neto = 0;
            $descuento=0;
            $descuento_detalle=0;
            $descuento_encabezado=0;
            $impuesto = 0;
            $total=0;
             pg_result_seek($result, 0);
             while($row = pg_fetch_array($result))
             {   //$idnota = $row['numnota'];
                //    $cuentafilas = $cuentafilas + 1;
                $neto += $row["numcantidad"] * $row["numprecioventa"];

                $descuento_detalle += $row["desc_aplic_det"];

                $descuento_encabezado = $row["descuento_encabezado"];

                $impuesto = $row['numiva'];

                $valor =  $row["numcantidad"]* $row["numprecioventa"];
                    ?>
         <tr>
           <td><?php echo $row["intidproducto"]; ?></td>
           <td class='text-center'><?php echo $row["numcantidad"]; ?></td>
           <td> <?php echo $row["strdescripcionproducto"]; ?></td>
           <td><span class="pull-right"><?php echo number_format($row["numprecioventa"],2); ?></span></td>
           <td><span class="pull-right"><?php echo number_format($row["numtotal"],2); ?></span></td>
         </tr>
         <?php
             }
             $descuento = 	$descuento_detalle +  $descuento_encabezado;

             $total=($neto-$descuento) + $impuesto;
          ?>
       </tbody>
     </table>
   </div><!-- /.col -->
 </div><!-- /.row -->

 <div class="row">
   <!-- accepted payments column -->
   <div class="col-md-8">


   </div><!-- /.col -->

   <div class="col-md-4">

                 <table class="table">

                   <tr>
                     <th style="width:50%" class="text-right"></th>
                     <td class="text-right"></td>
                     <th style="width:50%" class="text-right">Subtotal C$</th>
                     <td class="text-right"><?php echo number_format($neto, 2)?></td>
                   </tr>

                   <tr>
                     <th style="width:50%" class="text-right"></th>
                     <td class="text-right"></td>
                     <th class="text-right">IVA <?php //echo number_format($impuesto, 2) * 100.0 ?>% </th>
                     <td class="text-right"><?php echo number_format($impuesto, 2) ?></td>
                   </tr>

                   <tr>
                     <th style="width:50%" class="text-right"></th>
                     <td class="text-right"></td>
                     <th class="text-right">Total C$</th>
                     <td class="text-right"><?php echo number_format($total, 2) ?></td>
                   </tr>

                 </table>

   </div><!-- /.col -->

 </div><!-- /.row -->




        </div>
            <!-- /.container-fluid -->

 <!--</section> -->

        </div>
        <!-- /#page-wrapper -->

    </div>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>
<?php
//include_once "./vendor/autoload.php";
require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->setPaper('letter','portrait');
//ob_start();
//require_once "factura.php";
$html = ob_get_clean();
$dompdf->loadHtml(utf8_decode($html));
$dompdf->render();
header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=documento.pdf");
echo $dompdf->output();
?>
