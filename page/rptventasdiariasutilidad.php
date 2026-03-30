<?php
require_once 'cn.php';
require_once 'reg.php';
require_once 'fn_rptventasdiariasutilidad.php';
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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
    .container:before, .container:after {
display:table;
content:””;
}

.container:after {
clear:both;
}

.container {
width:500px;
margin:0 auto;
border:1px solid #fff;
box-shadow:0px 2px 7px #292929;
-moz-box-shadow: 0px 2px 7px #292929;
-webkit-box-shadow: 0px 2px 7px #292929;
border-radius:10px;
-moz-border-radius:10px;
-webkit-border-radius:10px;
background-color:#ffffff;
}

.mainbody {
height:250px;
width:500px;
border: solid #eee;
border-width:1px 0;
}

.header, .footer {
height: 40px;
width:50px;
border : 1px solid red;
padding: 5px;
}

.footer {
background-color: whiteSmoke;
-webkit-border-bottom-right-radius:5px;
-webkit-border-bottom-left-radius:5px;
-moz-border-radius-bottomright:5px;
-moz-border-radius-bottomleft:5px;
border-bottom-right-radius:5px;
border-bottom-left-radius:5px;
}

tr.group,
tr.group:hover {
    background-color: #ddd !important;
}

table.table-bordered{
    border:1px solid black;
    margin-top:20px;
  }
table.table-bordered > thead > tr > th{
    border:1px solid black;
}
table.table-bordered > tbody > tr > td{
    border:1px solid black;
}

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

              <section class="content-header">
              <h3 class="page-header"><i class='fa fa-edit'></i>Buscar Utilidad de ventas diarias por tipo de producto</h3>
              </section>
              <br/>

              <form role="form_buscar_facturas" method="post" action="rptventasdiariasutilidad.php">
              <div class="row">
                <div class="col-md-3">

                  <label>Fecha inicio: </label>
                  <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php if(isset($_SESSION['fechainiconsul'])) echo $_SESSION['fechainiconsul']; ?>" required/>

                </div>

                 <div class="col-md-3">

                 <label>Fecha fin: </label>
                 <input type="date" class="form-control" id="fecha_final" name="fecha_final"  value="<?php if(isset($_SESSION['fechafinconsul'])) echo $_SESSION['fechafinconsul']; ?>" required/>

                 </div>

                 <div class="col-md-3">

                  <button class="btn btn-default" type="submit"><i class='fa fa-search'></i></button>

                  </div>

                 <div class="col-md-3">
                        <a href="nueva_venta.php" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Nueva venta</a>
                 </div>
             </div>
           </form>
           <br>

              <?php
              //echo fn_script_ingresoVentas_diarias();
              //echo fn_create_temp_table();

              $detalle='';

              if(isset($_POST['fecha_inicio']))
              {
              /*  $fecharango = explode("-", $_POST['range']);
                $fechaini = trim($fecharango[0]);
                $fechafin = trim($fecharango[1]);*/

                $fechaini = $_POST['fecha_inicio'];
                $fechafin = $_POST['fecha_final'];

                $_SESSION['fechainiconsul'] = $fechaini;
                $_SESSION['fechafinconsul'] = $fechafin;


                /*$sql ="SELECT tipo, producto, dia1,
                       dia2, dia3, dia4, dia5, dia6,
                       dia7, dia8, dia9, dia10, dia11,
                       dia12, dia13, dia14, dia15, dia16,
                       dia17, dia18, dia19, dia20, dia21,
                       dia22, dia23, dia24, dia25, dia26,
                       dia27, dia28, dia29, dia30, dia31
                      from fn_rptventasdiarias_monto( '$fechaini', '$fechafin');";*/
                $sql = fn_script_ingresoVentas_diarias_utilidad($fechaini, $fechafin);

                echo "
                     <section class='content-header'>
                     <h4 class='page-header  mb-3 text-center'>Utilidad de ventas diarias por tipo de producto </br> Periodo del : ".$fechaini." al ".$fechafin."</h4>
                     </section>
                     ";

                $detalle = fill_tbl('ventas_diarias_utilidad', $sql);

                $fecha =   $fechaini;
                $fecha_ = $fechafin;

              }


               ?>
        </div>
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

<script type="text/javascript">

$(document).ready(function() {
/*var nFilas = $("#ventas_diarias tr").length;
var nColumnas = $("#ventas_diarias tr:last td").length;
var  nColumnas = nColumnas - 2;

var valueCampo = 0;
var array=[]
for (var j = 1; j <= nColumnas; j++)
{
   eval("var total"+j*+"="+valueCampo+";");
   array[j]=valueCampo;
}*/
var groupColumn = 0;
var table = $('#ventas_diarias_utilidad').DataTable({
        "processing": true,
        "autowidth": true,
        "columnDefs": [
            { "visible": false, "targets": groupColumn }
        ],
        "order": [[ groupColumn, 'asc' ]],
        "displayLength": 25,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
            var total=0;
            var total1=0;
            var total2=0;
            var total3=0;
            var total4=0;
            var total5=0;
            var total6=0;
            var total7=0;
            var total8=0;
            var total9=0;
            var total10=0;
            var total11=0;
            var total12=0;
            var total13=0;
            var total14=0;
            var total15=0;
            var total16=0;
            var total17=0;
            var total18=0;
            var total19=0;
            var total20=0;
            var total21=0;
            var total22=0;
            var total23=0;
            var total24=0;
            var total25=0;
            var total26=0;
            var total27=0;
            var total28=0;
            var total29=0;
            var total30=0;
            var filas = api.column(groupColumn, {page:'current'} ).data();

            filas.each( function ( group, i ) {

                if ( last !== group ) {
                  if(last!=null){
                    $(rows).eq( i - 1).after(
                        `<tr class="total warning">
                        <td colspan=""><strong>Total:</strong></td>
                        <td colspan=""><strong>C$ ${ total }  </strong></td>
                        <td colspan=""><strong>C$ ${ total1 } </strong></td>
                        <td colspan=""><strong>C$ ${ total2 } </strong></td>
                        <td colspan=""><strong>C$ ${ total3 } </strong></td>
                        <td colspan=""><strong>C$ ${ total4 } </strong></td>
                        <td colspan=""><strong>C$ ${ total5 } </strong></td>
                        <td colspan=""><strong>C$ ${ total6 } </strong></td>
                        <td colspan=""><strong>C$ ${ total7 } </strong></td>
                        <td colspan=""><strong>C$ ${ total8 } </strong></td>
                        <td colspan=""><strong>C$ ${ total9 } </strong></td>
                        <td colspan=""><strong>C$ ${ total10 } </strong></td>
                        <td colspan=""><strong>C$ ${ total11 } </strong></td>
                        <td colspan=""><strong>C$ ${ total12 } </strong></td>
                        <td colspan=""><strong>C$ ${ total13 } </strong></td>
                        <td colspan=""><strong>C$ ${ total14 } </strong></td>
                        <td colspan=""><strong>C$ ${ total15 } </strong></td>
                        <td colspan=""><strong>C$ ${ total16 } </strong></td>
                        <td colspan=""><strong>C$ ${ total17 } </strong></td>
                        <td colspan=""><strong>C$ ${ total18 } </strong></td>
                        <td colspan=""><strong>C$ ${ total19 } </strong></td>
                        <td colspan=""><strong>C$ ${ total20 } </strong></td>
                        <td colspan=""><strong>C$ ${ total21 } </strong></td>
                        <td colspan=""><strong>C$ ${ total22 } </strong></td>
                        <td colspan=""><strong>C$ ${ total23 } </strong></td>
                        <td colspan=""><strong>C$ ${ total24 } </strong></td>
                        <td colspan=""><strong>C$ ${ total25 } </strong></td>
                        <td colspan=""><strong>C$ ${ total26 } </strong></td>
                        <td colspan=""><strong>C$ ${ total27 } </strong></td>
                        <td colspan=""><strong>C$ ${ total28 } </strong></td>
                        <td colspan=""><strong>C$ ${ total29 } </strong></td>
                        <td colspan=""><strong>C$ ${ total30 } </strong></td>
                        </tr>`
                    );

                    total=0;
                    total1=0;
                    total2=0;
                    total3=0;
                    total4=0;
                    total5=0;
                    total6=0;
                    total7=0;
                    total8=0;
                    total9=0;
                    total10=0;
                    total11=0;
                    total12=0;
                    total13=0;
                    total14=0;
                    total15=0;
                    total16=0;
                    total17=0;
                    total18=0;
                    total19=0;
                    total20=0;
                    total21=0;
                    total22=0;
                    total23=0;
                    total24=0;
                    total25=0;
                    total26=0;
                    total27=0;
                    total28=0;
                    total29=0;
                    total30=0;
                  }

                  $(rows).eq( i ).before(
                    '<tr class="group"><td colspan="33"><strong>'+group+'</strong></td></tr>'
                  );

                  last = group;
                }

                total+=+$(rows).eq( i ).children()[1].textContent;
                total1+=+$(rows).eq( i ).children()[2].textContent;
                total2+=+$(rows).eq( i ).children()[3].textContent;
                total3+=+$(rows).eq( i ).children()[4].textContent;
                total4+=+$(rows).eq( i ).children()[5].textContent;
                total5+=+$(rows).eq( i ).children()[6].textContent;
                total6+=+$(rows).eq( i ).children()[7].textContent;
                total7+=+$(rows).eq( i ).children()[8].textContent;
                total8+=+$(rows).eq( i ).children()[9].textContent;
                total9+=+$(rows).eq( i ).children()[10].textContent;
                total10+=+$(rows).eq( i ).children()[11].textContent
                total11+=+$(rows).eq( i ).children()[12].textContent
                total12+=+$(rows).eq( i ).children()[13].textContent;
                total13+=+$(rows).eq( i ).children()[14].textContent;
                total14+=+$(rows).eq( i ).children()[15].textContent;
                total15+=+$(rows).eq( i ).children()[16].textContent;
                total16+=+$(rows).eq( i ).children()[17].textContent;
                total17+=+$(rows).eq( i ).children()[18].textContent;
                total18+=+$(rows).eq( i ).children()[19].textContent;
                total19+=+$(rows).eq( i ).children()[20].textContent;
                total20+=+$(rows).eq( i ).children()[21].textContent;
                total21+=+$(rows).eq( i ).children()[22].textContent;
                total22+=+$(rows).eq( i ).children()[23].textContent;
                total23+=+$(rows).eq( i ).children()[24].textContent;
                total24+=+$(rows).eq( i ).children()[25].textContent;
                total25+=+$(rows).eq( i ).children()[26].textContent;
                total26+=+$(rows).eq( i ).children()[27].textContent;
                total27+=+$(rows).eq( i ).children()[28].textContent;
                total28+=+$(rows).eq( i ).children()[29].textContent;
                total29+=+$(rows).eq( i ).children()[30].textContent;

                if(i==filas.length-1){
                    $(rows).eq( i ).after(
                        `<tr class="total">
                            <td colspan=""><strong>Total:</strong></td>
                            <td colspan=""><strong>C$ ${ total }  </strong></td>
                            <td colspan=""><strong>C$ ${ total1 } </strong></td>
                            <td colspan=""><strong>C$ ${ total2 } </strong></td>
                            <td colspan=""><strong>C$ ${ total3 } </strong></td>
                            <td colspan=""><strong>C$ ${ total4 } </strong></td>
                            <td colspan=""><strong>C$ ${ total5 } </strong></td>
                            <td colspan=""><strong>C$ ${ total6 } </strong></td>
                            <td colspan=""><strong>C$ ${ total7 } </strong></td>
                            <td colspan=""><strong>C$ ${ total8 } </strong></td>
                            <td colspan=""><strong>C$ ${ total9 } </strong></td>
                            <td colspan=""><strong>C$ ${ total10 } </strong></td>
                            <td colspan=""><strong>C$ ${ total11 } </strong></td>
                            <td colspan=""><strong>C$ ${ total12 } </strong></td>
                            <td colspan=""><strong>C$ ${ total13 } </strong></td>
                            <td colspan=""><strong>C$ ${ total14 } </strong></td>
                            <td colspan=""><strong>C$ ${ total15 } </strong></td>
                            <td colspan=""><strong>C$ ${ total16 } </strong></td>
                            <td colspan=""><strong>C$ ${ total17 } </strong></td>
                            <td colspan=""><strong>C$ ${ total18 } </strong></td>
                            <td colspan=""><strong>C$ ${ total19 } </strong></td>
                            <td colspan=""><strong>C$ ${ total20 } </strong></td>
                            <td colspan=""><strong>C$ ${ total21 } </strong></td>
                            <td colspan=""><strong>C$ ${ total22 } </strong></td>
                            <td colspan=""><strong>C$ ${ total23 } </strong></td>
                            <td colspan=""><strong>C$ ${ total24 } </strong></td>
                            <td colspan=""><strong>C$ ${ total25 } </strong></td>
                            <td colspan=""><strong>C$ ${ total26 } </strong></td>
                            <td colspan=""><strong>C$ ${ total27 } </strong></td>
                            <td colspan=""><strong>C$ ${ total28 } </strong></td>
                            <td colspan=""><strong>C$ ${ total29 } </strong></td>
                            <td colspan=""><strong>C$ ${ total30 } </strong></td>
                        </tr>`
                    );
                }



            });
        },
        dom: 'Bfrtip',
        buttons: [
            {extend:'print',text: "Imprimir",title: "Ventas diarias por producto",footer:true },
            {extend:'excel',text: "Exportar Excel",title: "Ventas diarias por producto" },
            {extend:'pdf',text: "Exportar PDF",title: "Ventas diarias por producto"},
            {extend:'copy',text: "Copiar portapapeles",title: "Ventas diarias por producto"}
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        }
    } );
} );
</script>

</body>

</html>
