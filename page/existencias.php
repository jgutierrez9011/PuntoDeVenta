<?php
require_once 'cn.php';
require_once 'reg.php';

$detalle = 0;
$saldo = 0;
/*if(isset($_POST['range']))
{*/
  //$fecharango = explode("-", $_POST['range']);
  //$fechaini = trim($fecharango[0]);
  //$fechafin = trim($fecharango[1]);

  $sql="SELECT a.intidproducto, a.strnombre, a.presentacion, b.strtipo tipo, c.numcosto, a.numutilidad
,a.numprecioventa,
c.intexistencia, a.strimagenproducto, a.strusuariocreo, a.datfechacreo::date,
c.total
from tblcatproductos a
inner join tblcattipoproducto b on a.strtipo::int = b.intidtipoproducto
left join tblcatexistencia c on a.intidproducto = c.intidproducto
where a.strestado = true AND a.bolcontrolinventario = true
order by intidproducto asc";


  $result = pg_query(conexion_bd(1),$sql);
  $detalle = pg_affected_rows($result);

//  $fecha =   $fechaini;
//  $fecha_ = $fechafin;
//}

/*if(!isset($_POST['range']))
{
  date_default_timezone_set("America/Managua");
  $fecha = date('d/m/Y');
  $fecha_ = date('d/m/Y');
}*/



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
    <title>Admin GYM</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="../vendor/bootstrap/css/bootstrap-multiselect.css" rel="stylesheet">

    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- css para plugin datatable  -->
    <link rel="stylesheet" type="text/css" href="../vendor/datatables/css_/jquery.dataTables.min.css">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="../vendor/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />

    <script src="../vendor/jquery/jquery-3.3.1.min.js"></script>

   <!--<script src="../vendor/daterangepicker/jquery.min.js"></script> -->




    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
    table.dataTable thead tr {
      background-color: grey;
      color: #ffffff;
    }
    </style>


</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include 'menu.php' ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
              <br>

              <div class="py-5 text-center">
                  <?php include 'logo.php' ?>
              </div>

             <h2 align="center">Listado de productos</h2>

             <br>


             <div class="row">
               <div class="table-responsive">
               <br>
                 <table class="table table-striped table-bordered" id="tblfacturas" style="width:100%">
                     <thead>
                       <tr>
                          <th><p class="small"><strong>Codigo</strong></p></th>
                          <th><p class="small"><strong>Imagen</strong></p></th>
                          <th><p class="small"><strong>Producto</strong></p></th>
                          <th><p class="small"><strong>Presentacion</strong></p></th>
                          <th><p class="small"><strong>Tipo</strong></p></th>
                          <th><p class="small"><strong>Existencia</strong></p></th>
                          <th><p class="small"><strong>Precio de venta</strong></p></th>
                          <th><p class="small"><strong>Precio de costo</strong></p></th>
                          <th><p class="small"><strong>Total</strong></p></th>
                          <th><p class="small"><strong>Fecha creo</strong></p></th>
                       </tr>
                       </thead>
                       <tbody>
                         <?php

                            pg_result_seek($result,0);
                            $detalle = pg_affected_rows($result);
                            if($detalle<>0)
                             while($row = pg_fetch_array($result))
                                {
                                    //$cuentafilas = $cuentafilas + 1;
                                    if( $row['intexistencia'] > 0)
                                    {
                                      $saldo += $row['total'];
                                    }
                                    ?>

                                     <tr>
                                     <td><?php echo $row['intidproducto']; ?></td>
                                     <td align="center"><img src="<?php echo $row["strimagenproducto"]?>"  width='40' height='40'></td>
                                     <td align="center"><p class='small'><?php echo $row['strnombre']; ?></p></td>
                                     <td align="center"><p class='small'><?php echo $row['presentacion']; ?></p></td>
                                     <td align="center"><p class='small'><?php echo $row['tipo']; ?></p></td>
                                     <td align="center"><p class='small'><?php echo $row['intexistencia']; ?></p></td>
                                     <td align="center"><p class='small'><?php echo $row['numprecioventa']; ?></p></td>
                                     <td align="center"><p class='small'><?php echo $row['numcosto']; ?></p></td>
                                     <td align="center"><p class='small'><?php echo $row['total']; ?></p></td>
                                     <td align="center"><p class='small'><?php echo $row['datfechacreo']; ?></p></td>

                                     </tr>

                                   <?php }   ?>
                                   <tfoot>
               <tr>
                   <th colspan="8" style="text-align:right">Total inventario:</th>
                   <th colspan="2"> <?php echo number_format($saldo,2); ?> C$</th>
               </tr>
           </tfoot>
                                                     </tbody>
                                                  </table>


                                   <br>

                </div>
              </div>



         </div>
     </div>
     <br>

            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <footer class="my-5 pt-5 text-muted text-center text-small">
      <p class="mb-1">&copy;<?php echo date("Y")-1; ?>-<?php echo date("Y"); ?> GYM</p>
      <ul class="list-inline">
        <li class="list-inline-item"><a href="index.php">Inicio</a></li>
       </ul>
    </footer>



    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <script src="../vendor/bootstrap/js/bootstrap-multiselect.js"></script>



    <script type="text/javascript" src="../vendor/datatables/js_/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <script type="text/javascript" src="../vendor/datatables/js_/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../vendor/datatables/js/dataTables.fixedColumns.min.js"></script>

    <script type="text/javascript" src="../vendor/jquery/exp/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/buttons.flash.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/jszip.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/pdfmake.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/vfs_fonts.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/buttons.html5.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/buttons.print.min.js"></script>

    <script src="../vendor/daterangepicker/moment.min.js"></script>

     <script src="../vendor/daterangepicker/daterangepicker.min.js"></script>

     <script src="../js/VentanaCentrada.js"></script>


<script type="text/javascript">

$(function() {
		   $('#tblfacturas').DataTable(
         {
           order: [[1, "asc"]],
           dom:'Bfrtip',
           buttons: ['copy','csv','excel','pdf','print'],
           language:{
             lengthMenu: "Mostrar _MENU_ registros por pagina",
             info: "Mostrando pagina _PAGE_ de _PAGES_",
             infoEmpty: "No hay registros disponibles",
             infoFiltered: "(filtrada de _MAX_ registros)",
             loadingRecords: "Cargando...",
             processing:     "Procesando...",
             search: "Buscar:",
             zeroRecords:    "No se encontraron registros coincidentes",
             paginate: {
               next:       "Siguiente",
               previous:   "Anterior"
             },
           },
         }
       );
		        //Date range picker
       // $('#range').daterangepicker();

       $('#range').daterangepicker({
    locale:{
      format: "DD/MM/YYYY",
      separator: " - ",
      applyLabel: "Aplicar",
      cancelLabel: "Cancelar",
      fromLabel: "Desde",
      toLabel: "Hasta",
      customRangeLabel: "Custom",
      daysOfWeek: [
          "Do",
          "Lu",
          "Ma",
          "Mi",
          "Ju",
          "Vi",
          "Sa"
      ],
      monthNames: [
          "Enero",
          "Febrero",
          "Marzo",
          "Abril",
          "Mayo",
          "Junio",
          "Julio",
          "Agosto",
          "Septiembre",
          "Octubre",
          "Noviembre",
          "Diciembre"
      ],
        firstDay: 1
    },
    opens: 'right'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });



	});

  function view_pdf(id){
        VentanaCentrada('imprimir_compra.php?factura='+id,'Reimprimir factura','','1024','768','true');
    }

</script>

</body>

</html>
