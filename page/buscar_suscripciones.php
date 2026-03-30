<?php
require_once 'cn.php';
require_once 'reg.php';

$detalle = 0;
$ingreso = 0;
$contado = 0;
$credito = 0;
$recibos = 0;
$estado = "";


$perfil = $_SESSION["intidperfil"];

/*SE CONSULTA PERMISO PARA OPCION DE ANULAR FACTURAS*/
$row_permiso_facturas = pg_fetch_array(pg_query(conexion_bd(1),"SELECT bolactivo
                                                                from public.tblcatperfilusrfrmdetalle
                                                                where idfrmdetalle = 8 and idperfil =  $perfil"));
$row_permiso_facturas_estado = $row_permiso_facturas['bolactivo'];




if(isset($_POST['txtestado_suscrip']))
{

  $estado = $_POST['txtestado_suscrip'];

  $sql="SELECT * ,
case when estado = 'ACTIVA' THEN current_date - datfechacreo::date
     when estado = 'INACTIVA' THEN datfechafin::date - datfechacreo::date
            ELSE 0 END dias_consumidos,
            case when numvigencia > 0 then
            round(round((case when estado = 'ACTIVA' THEN current_date - datfechacreo::date
            		    when estado = 'INACTIVA' THEN datfechafin::date - datfechacreo::date
                        ELSE 0 END / numvigencia::numeric),2)*100,0)
            else  100 end porcentaje_consumido
from
(
SELECT a.strusuariocreo cajero,
lpad(a.numerofactura::text,10,'0') factura,
to_char(a.datfechacreo,'DD/MM/YYYY')fecha_facturo,
to_char(a.datfechacreo,'HH24:MI:SS')hora_facturo,
c.bigcodcliente codigo_cliente,
concat(c.strpnombre,' ',c.strsnombre,' ',c.strpapellido,' ',c.strsapellido) cliente,
b.strdescripcionproducto,
a.datfechacreo,
a.datfechacreo::date + d.numvigencia datfechafin,
to_char(a.datfechacreo,'DD/MM/YYYY') fecha_inicia,
to_char(a.datfechacreo::date + d.numvigencia, 'DD/MM/YYYY') fecha_finaliza,
d.numvigencia,
Case when a.datfechacreo::date + d.numvigencia >= current_date then 'ACTIVA'
     when a.datfechacreo::date + d.numvigencia < current_date then 'INACTIVA' END estado
FROM public.tblcatfacturaencabezado a
inner join public.tblcatfacturadetalle b on a.intidserie = b.intidfactura
inner join tblcatclientes c on a.intidcliente = c.intidcliente
inner join tblcatproductos d on b.intidproducto = d.intidproducto and d.strtipo = '1'
where d.numvigencia >= 0 and
      ((case when '$estado' = 'ACTIVA' THEN a.datfechacreo::date + d.numvigencia >= current_date end) or
       (case when '$estado' = 'INACTIVA' THEN a.datfechacreo::date + d.numvigencia < current_date end) or
       (case when '$estado' = 'TODOS' THEN a.datfechacreo IS NOT NULL  end))
order by d.numvigencia desc)sub;";


  $result = pg_query(conexion_bd(1),$sql);
  $detalle = pg_affected_rows($result);

}else {

  $estado = "ACTIVA";

  $sql="SELECT * , case when estado = 'ACTIVA' THEN current_date - datfechacreo::date
                        when estado = 'INACTIVA' THEN datfechafin::date - datfechacreo::date
                        ELSE 0 END dias_consumidos,
                        case when numvigencia > 0 then
     round(round((case when estado = 'ACTIVA' THEN current_date - datfechacreo::date
     		    when estado = 'INACTIVA' THEN datfechafin::date - datfechacreo::date
                 ELSE 0 END / numvigencia::numeric),2)*100,0)
     else  100 end porcentaje_consumido
                    from
                    (
                    SELECT a.strusuariocreo cajero,
                    lpad(a.numerofactura::text,10,'0') factura,
                    to_char(a.datfechacreo,'DD/MM/YYYY')fecha_facturo,
                    to_char(a.datfechacreo,'HH24:MI:SS')hora_facturo,
                    c.bigcodcliente codigo_cliente,
                    concat(c.strpnombre,' ',c.strsnombre,' ',c.strpapellido,' ',c.strsapellido) cliente,
                    b.strdescripcionproducto,
                    a.datfechacreo,
                    a.datfechacreo::date + d.numvigencia datfechafin,
                    to_char(a.datfechacreo,'DD/MM/YYYY') fecha_inicia,
                    to_char(a.datfechacreo::date + d.numvigencia, 'DD/MM/YYYY') fecha_finaliza,
                    d.numvigencia,
                    Case when a.datfechacreo::date + d.numvigencia >= current_date then 'ACTIVA'
                         when a.datfechacreo::date + d.numvigencia < current_date then 'INACTIVA' END estado
                    FROM public.tblcatfacturaencabezado a
                    inner join public.tblcatfacturadetalle b on a.intidserie = b.intidfactura
                    inner join tblcatclientes c on a.intidcliente = c.intidcliente
                    inner join tblcatproductos d on b.intidproducto = d.intidproducto and d.strtipo = '1'
                    where d.numvigencia >= 0 and
                          ((case when '$estado' = 'ACTIVA' THEN a.datfechacreo::date + d.numvigencia >= current_date end) or
                           (case when '$estado' = 'INACTIVA' THEN a.datfechacreo::date + d.numvigencia < current_date end) or
                           (case when '$estado' = 'TODOS' THEN a.datfechacreo IS NOT NULL  end))
                    order by d.numvigencia desc)sub;";

  $result = pg_query(conexion_bd(1),$sql);
  $detalle = pg_affected_rows($result);

}

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
    <style type="text/css">
    table.dataTable thead tr {
      background-color: grey;
      color: #ffffff;
    }
    </style>

    <style type="text/css">
       th { white-space: nowrap; }
    </style>

    <style id="jsbin-css">


table#tblfacturas.dataTable tbody tr.green_row > .sorting_1
       {
           background-color: #ccf2cc;
       }

table#tblfacturas.dataTable tbody tr.green_row
       {
           background-color: #ccf2cc;
       }

table#tblfacturas.dataTable tbody tr.red_row > .sorting_1
      {
                  background-color: #ffc6c3;
      }

table#tblfacturas.dataTable tbody tr.red_row
      {
                  background-color: #ffc6c3;
      }

table#tblfacturas.dataTable tbody tr.yellow_row > .sorting_1
      {
                  background-color: #fcfc96;
      }

table#tblfacturas.dataTable tbody tr.yellow_row
      {
                  background-color: #fcfc96;
      }
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

             <h2 align="center">Lista de suscripciones</h2>
             <br>



             <form role="form_buscar_suscrip" method="post" action="buscar_suscripciones.php">
             <div class="row">
               <div class="col-md-3">

                 <label for="lblestado">Estado</label>
                 <select class="form-control" id="txtestado_suscrip" name="txtestado_suscrip" required>
                           <option value="TODOS" <?php if($estado == 'TODOS') echo 'selected'; ?>>TODOS</option>
                           <option value="ACTIVA" <?php if($estado == 'ACTIVA') echo 'selected'; ?>>ACTIVA</option>
                           <option value="INACTIVA" <?php if($estado == 'INACTIVA') echo 'selected'; ?>>INACTIVA</option>
                 </select>

               </div>

                <div class="col-md-3">

                 <button class="btn btn-default" type="submit"><i class='fa fa-search'></i></button>

                 </div>

                <div class="col-md-3">
                       <a href="nueva_venta.php" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Nueva venta</a>
                </div>
            </div>
          </form>

    <!-- FINALIZA MODALES -->

          <div id="resultados_ajax"></div>
          <br>

          <div class="row">
            <div class="table-responsive">
            <br>
              <table class="table table-striped table-bordered display" id="tblfacturas" style="width:100%">
                  <thead>
                    <tr>
                      <th><p class="small"><strong>Codigo Cliente</strong></p></th>
                       <th><p class="small"><strong>Cliente</strong></p></th>
                       <th><p class="small"><strong>Suscripcion</strong></p></th>
                       <th><p class="small"><strong>Fecha inicia</strong></p></th>
                       <th><p class="small"><strong>Fecha finaliza</strong></p></th>
                       <th><p class="small"><strong>Vigencia(Dias)</strong></p></th>
                       <th><p class="small"><strong>% consumido</strong></p></th>
                       <th><p class="small"><strong>Cajero</strong></p></th>
                       <th><p class="small"><strong>Factura</strong></p></th>
                       <th><p class="small"><strong>Fecha factura</strong></p></th>
                       <th><p class="small"><strong>Hora factura</strong></p></th>
                       <th><p class="small"><strong>Estado</strong></p></th>
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

                                 ?>
                                  <tr>
                                  <td align="center"><p class='small'><?php echo $row['codigo_cliente']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['cliente']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['strdescripcionproducto']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['fecha_inicia']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['fecha_finaliza']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['numvigencia']; ?></p></td>
                                  <td align="center" class='small'><?php echo $row['porcentaje_consumido']; ?></td>
                                  <td align="center"><p class='small'><?php echo $row['cajero']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['factura']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['fecha_facturo']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['hora_facturo']; ?></p></td>
                                  <td align="center"><p class='small'><?php echo $row['estado']; ?></p></td>
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

    <script type="text/javascript" src="../vendor/datatables/js_/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../vendor/datatables/js/dataTables.fixedColumns.min.js"></script>

    <script type="text/javascript" src="../vendor/jquery/exp/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/buttons.flash.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/jszip.min.js"></script>
  <!--  <script type="text/javascript" src="../vendor/jquery/exp/pdfmake.min.js"></script> -->
    <script type="text/javascript" src="../vendor/jquery/exp/vfs_fonts.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/buttons.html5.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/buttons.print.min.js"></script>

    <script src="../vendor/daterangepicker/moment.min.js"></script>

     <script src="../vendor/daterangepicker/daterangepicker.min.js"></script>

     <script src="../js/VentanaCentrada.js"></script>



<script type="text/javascript">
 $(document).ready(function(){
		var table =  $('#tblfacturas').DataTable({
         dom:'Bfrtip',
         buttons: ['excel'],
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
         rowCallback: function (row, data, index)
             {
               //alert(data[6]);

   					if ( Number(data[6]) < 60 )
   					  {
   						 $(row).addClass('green_row');
   					  }

   					  if ((Number(data[6]) >= 60) && (Number(data[6]) <= 80))
   					  {
   						 $(row).addClass('yellow_row');
   					  }

   					  if ((Number(data[6]) > 80))
   					  {
   						 $(row).addClass('red_row');
   					  }
        }

       });


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

</body>

</html>
