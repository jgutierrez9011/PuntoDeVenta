<?php
require_once 'cn.php';
require_once 'reg.php';

$detalle = 0;
$ingreso = 0;
$contado = 0;
$credito = 0;
$recibos = 0;


$perfil = $_SESSION["intidperfil"];

/*SE CONSULTA PERMISO PARA OPCION DE ANULAR FACTURAS*/
$row_permiso_facturas = pg_fetch_array(pg_query(conexion_bd(1),"SELECT bolactivo
                                                                from public.tblcatperfilusrfrmdetalle
                                                                where idfrmdetalle = 8 and idperfil =  $perfil"));
$row_permiso_facturas_estado = $row_permiso_facturas['bolactivo'];




if(isset($_POST['fecha_inicio']))
{
/*  $fecharango = explode("-", $_POST['range']);
  $fechaini = trim($fecharango[0]);
  $fechafin = trim($fecharango[1]);*/

  $fechaini = $_POST['fecha_inicio'];
  $fechafin = $_POST['fecha_final'];
  $producto = $_POST['producto'];

  $_SESSION['fechainik'] = $fechaini;
  $_SESSION['fechafink'] = $fechafin;


  $sql="SELECT * from get_kardex ('$fechaini' , '$fechafin', $producto)";


  $result = pg_query(conexion_bd(1),$sql);
  $detalle = pg_affected_rows($result);

  $fecha =   $fechaini;
  $fecha_ = $fechafin;


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

    <link href="../vendor/bootstrap/css/bootstrap-select.min.css" rel="stylesheet">

  <link href="../vendor/bootstrap/css/select2.min.css" rel="stylesheet">

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

    <style type="text/css">
       th { white-space: nowrap; }
    </style>


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

             <h2 align="center">Kardex</h2>
             <h4 align="center">Libro de Almacen</h4>
             <br>

             <div class="row">
               <div class="col-md-12">
                      <a href="nueva_venta.php" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Nueva venta</a>
               </div>
             </div>


             <form role="kardex" method="post" action="kardex.php">
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
                 <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value=<?php if(isset($_SESSION['fechainik'])) echo $_SESSION['fechainik']; ?> required/>

               </div>

                <div class="col-md-3">

                <label>Fecha fin: </label>
                <input type="date" class="form-control" id="fecha_final" name="fecha_final" value=<?php if(isset($_SESSION['fechafink'])) echo $_SESSION['fechafink']; ?>  required/>

                </div>

                <div class="col-md-3">

                <label for="lblcliente">Producto</label>
                <select class="form-control select2 select_producto" name="producto" id="producto" required>
                <option value="">Selecciona Producto</option>
                </select>

                </div>

                <div class="col-md-3">
                 <br>
                 <button class="btn btn-default" type="submit"><i class='fa fa-search'></i></button>

                 </div>


            </div>
          </form>




          <div id="resultados_ajax"></div>
          <br>

          <div class="row">
            <div class="table-responsive">
            <br>
              <table class="table table-striped table-bordered display" id="tblfacturas" style="width:100%">
                  <thead>
                    <tr>
                      <th><p class="small"><strong>No.Producto</strong></p></th>
                      <th><p class="small"><strong>Producto</strong></p></th>
                      <th><p class="small"><strong>Movimiento</strong></p></th>
                       <th><p class="small"><strong>No.Documento</strong></p></th>
                       <th><p class="small"><strong>Fecha</strong></p></th>
                       <th><p class="small"><strong>Cantidad</strong></p></th>
                       <th><p class="small"><strong>Costo unidad</strong></p></th>
                       <th><p class="small"><strong>Costo total</strong></p></th>
                       <th><p class="small"><strong>Saldo cantidad</strong></p></th>
                  <!--     <th><p class="small"><strong>Saldo dinero</strong></p></th>
                       <th><p class="small"><strong>Costo promedio</strong></p></th> -->

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
                                /* $ingreso += $row['ingreso_ventas'];
                                 if($row['strtipo'] =='CONTADO') { $contado +=$row['ingreso_ventas']; }

                                 if($row['strtipo'] =='CREDITO') { $credito +=$row['ingreso_ventas']; }*/
                                 ?>

                                  <tr>

                                  <td align="center"><p class='small'><?php echo $row['idproducto']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['strnombre']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['tipo']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['numero_documento']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['fecha']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['cantidad']; ?></p></td>
                                  <td align="center"><p class='small'>C$ <?php echo $row['precio_costo_unidad']; ?></p></td>
                                  <td align="center"><p class='small'>C$ <?php echo $row['precio_costo_total']; ?></p></td>
                                  <td align="center"><p class='small'>   <?php echo $row['saldo_cantidad']; ?></p></td>
                                <!--  <td align="center"><p class='small'>C$ <?php //echo $row['saldo_dinero']; ?></p></td>
                                  <td align="center"><p class='small'>C$ <?php //echo $row['costo_promedio']; ?></p></td> -->

                                  </tr>

                                <?php } }  ?>
                              <!--  <tfoot>
                                  <tr>
                                      <th colspan="8" style="text-align:right">Total contado:</th>
                                      <th colspan="7">C$ <?php// echo number_format($contado,2); ?> </th>
                                  </tr>
                                  <tr>
                                      <th colspan="8" style="text-align:right">Total credito:</th>
                                      <th colspan="7">C$ <?php// echo number_format($credito,2); ?> </th>
                                  </tr>

            <tr>
                <th colspan="8" style="text-align:right">Total facturado:</th>
                <th colspan="7">C$ <?php //echo number_format($ingreso,2); ?> </th>
            </tr>
            <tr>
                <th colspan="8" style="text-align:right">Total recibos:</th>
                <th colspan="7">C$ <?php //echo number_format($recibos,2); ?> </th>
            </tr>
            <tr>
                <th colspan="8" style="text-align:right">Total ingreso:</th>
                <th colspan="7">C$ <?php// echo number_format($recibos+$contado,2); ?> </th>
            </tr>
        </tfoot> -->
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

    <script type="text/javascript" src="../vendor/datatables/js_/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/js/dataTables.bootstrap.min.js"></script>

    <script src="../vendor/bootstrap/js/select2.full.min.js"></script>


<script type="text/javascript">
$(function() {
		   $('#tblfacturas').DataTable({
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
       });
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

  <script>
  $(document).ready(function() {
      $( ".select_producto" ).select2({
      ajax: {
          url: "fnproductos.php",
          dataType: 'json',
          delay: 250,
          data: function (params) {
              return {
                  q: params.term // search term
              };
          },
          processResults: function (data) {
              // parse the results into the format expected by Select2.
              // since we are using custom formatting functions we do not need to
              // alter the remote JSON data
              return {
                  results: data
              };
          },
          cache: true



      },
      minimumInputLength: 2

  })

  });
  </script>

</body>

</html>
