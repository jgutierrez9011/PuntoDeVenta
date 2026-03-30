<?php
require_once 'cn.php';
require_once 'reg.php';

$detalle = 0;

if(isset($_POST['fecha_inicio']))
{
/*  $fecharango = explode("-", $_POST['range']);
  $fechaini = trim($fecharango[0]);
  $fechafin = trim($fecharango[1]);*/

  $fechaini = $_POST['fecha_inicio'];
  $fechafin = $_POST['fecha_final'];


  $sql="SELECT a.numerofactura, lpad(a.numerofactura::text,10,'0') factura, concat(c.strpnombre,' ',c.strsnombre,' ',c.strpapellido,' ',c.strsapellido) cliente, to_char(a.datfechacreo,'DD-MM-YYYY') fecha,
  concat(f.strpnombre,' ',f.strsnombre,' ',f.strpapellido,' ',f.strsapellido) usuario,
  a.numsubtotal, a.numdescuento, a.numiva, a.numtotal, a.intidserie, a.strestado, a.strtipo
  FROM public.tblcatfacturaencabezado a
  inner join public.tblcatfacturadetalle b on a.intidserie = b.intidfactura
  inner join tblcatclientes c on a.intidcliente = c.intidcliente
  inner join tblcatproductos d on b.intidproducto = d.intidproducto
  inner join tblcattipoproducto e on d.strtipo::integer = e.intidtipoproducto
  inner join tblcatusuario f on a.strusuariocreo = f.strcorreo and f.bolactivo = true
  where a.datfechacreo::date between '$fechaini'  and '$fechafin'
  group by 1,2,3,4,5,6,7,8,9,10,11,12
  order by a.numerofactura desc";


  $result = pg_query(conexion_bd(1),$sql);
  $detalle = pg_affected_rows($result);

  $fecha =   $fechaini;
  $fecha_ = $fechafin;
}

if(!isset($_POST['range']))
{
  date_default_timezone_set("America/Managua");
  $fecha = date('d/m/Y');
  $fecha_ = date('d/m/Y');
}



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
    <?php require_once 'icon.php'; ?>
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


</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php require_once 'menu.php'; ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
              <br>

              <div class="py-5 text-center">
                  <?php require_once 'logo.php'; ?>
              </div>

             <h2 align="center">Facturas</h2>
             <br>



             <form role="form_buscar_facturas" method="post" action="buscar_facturas.php">
             <div class="row">
               <div class="col-md-3">

                 <!--<div class="input-group">
                     <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                     </div>
                 <!-- <input type="text" class="form-control pull-right active" value="<?php //echo$fecha." - ".$fecha_  ?>" id="range" name="range" readonly=""> -->




                <!-- <span class="input-group-btn">
							   <button class="btn btn-default" type="submit"><i class='fa fa-search'></i></button>
						  </span>

            </div> -->

                 <label>Fecha inicio: </label>
                 <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required/>

               </div>

                <div class="col-md-3">

                <label>Fecha fin: </label>
                <input type="date" class="form-control" id="fecha_final" name="fecha_final"  required/>

                </div>

                <div class="col-md-3">

                 <button class="btn btn-default" type="submit"><i class='fa fa-search'></i></button>

                 </div>

                <div class="col-md-3">
                       <a href="nueva_venta.php" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Nueva venta</a>
                </div>
            </div>
          </form>

          <div id="resultados_ajax"></div>
          <br>

          <div class="row">
            <div class="table-responsive">
            <br>
              <table class="table table-striped table-bordered" id="tblfacturas" style="width:100%">
                  <thead>
                    <tr>
                       <th><p class="small"><strong>Factura No.</strong></p></th>
                       <th><p class="small"><strong>Tipo factura</strong></p></th>
                       <th><p class="small"><strong>Estado</strong></p></th>
                       <th><p class="small"><strong>Cliente</strong></p></th>
                       <th><p class="small"><strong>Fecha</strong></p></th>
                       <th><p class="small"><strong>Usuario</strong></p></th>
                       <th><p class="small"><strong>Neto</strong></p></th>
                       <th><p class="small"><strong>Descuento</strong></p></th>
                       <th><p class="small"><strong>IVA</strong></p></th>
                       <th><p class="small"><strong>Total</strong></p></th>
                       <th><p class="small"><strong>Acciones</strong></p></th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                        if($detalle > 0){
                         pg_result_seek($result,0);
                         $detalle = pg_affected_rows($result);
                         if($detalle<>0)
                          while($row = pg_fetch_array($result))
                             {
                                 //$cuentafilas = $cuentafilas + 1;
                                 ?>

                                  <tr>
                                  <td><?php echo $row['factura']; ?></td>
                                  <td align="center"><p class='small'><?php echo $row['strtipo']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['strestado']; ?></p></td>

                                  <td align="center"><p class='small'><?php echo $row['cliente']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['fecha']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['usuario']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['numsubtotal']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['numdescuento']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['numiva']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['numtotal']; ?></p></td>
                                  <td>
                                     <div class="btn-group pull-right">
                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
                                       <ul class="dropdown-menu">
                                             <li><a href="#" onclick="view_pdf('<?php echo base64_encode($row['numerofactura']) ?>');"><i class="fa fa-file-pdf-o"></i> Ver PDF</a></li>
                                             <li><a href="#" onclick="eliminar('<?php echo base64_encode($row['intidserie']) ?>','<?php echo base64_encode($row['numerofactura']) ?>')"><i class="fa fa-trash"></i> Anular</a></li>
                                       </ul>
                                     </div>
                                  </td>
                                  </tr>

                                <?php } }  ?>
                                                  </tbody>
                                               </table>


                                <br>

             </div>
           </div>


             </div>
             <br>





         </div>
     </div>
     <br>

            <!-- /.container-fluid -->

        <!-- /#page-wrapper -->

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

    <script src="../vendor/daterangepicker/moment.min.js"></script>

     <script src="../vendor/daterangepicker/daterangepicker.min.js"></script>

     <script src="../js/VentanaCentrada.js"></script>


<script type="text/javascript">

$(function() {
		   $('#tblfacturas').DataTable();
		        //Date range picker
       // $('#range').daterangepicker();

      /* $('#range').daterangepicker({
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
  });*/



	});

  function view_pdf(id){
      VentanaCentrada('factura.php?factura='+id,'Reimprimir factura','','1024','768','true');
    }

</script>

<script>
		function eliminar(id,fact){
			if(confirm('Esta acción  eliminará de forma permanente la factura \n\n Desea continuar?')){

        var parametros = {"id":id,"fact":fact};

				$.ajax({
					url:'nueva_factura.php',
					data: parametros,
					 beforeSend: function(objeto){
				      $("#resultados_ajax").html("Enviando...");
				  },
					success:function(data){
					 $("#resultados_ajax").html(data);
						window.setTimeout(function() {
						$(".alert").fadeTo(500, 0).slideUp(500, function(){
						$(this).remove(); location.reload();});}, 5000);
					}
				})
			}
		}
	</script>

</body>

</html>
