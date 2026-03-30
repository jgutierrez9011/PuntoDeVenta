<?php
require_once 'cn.php';
require_once 'reg.php';
require_once 'fnregistrar_danos.php';

$fechainicio="";
$fechafinal="";
$detalle=0;
$filas=0;
$datos_dif=[];

if(isset($_REQUEST['btnbuscar']))
{
  $g_cargo = $_SESSION["idcargo"];
  $g_idemp = $_SESSION["idempleado"];
  $g_vertodo = $_SESSION["permiso"];
  $usuario = $_SESSION['user'];

  $fechainicio = $_POST['fechaini'];
  $fechafinal = $_POST['fechafin'];

  $directorio = '../xls/'.$g_idemp.'.csv';
  $directorio_file = 'E:\www\base\xls\\'.$g_idemp.'.csv';
  /*CONEXION A POSTGRESQL*/
  $conexion = conexion_bd(1);

/*----------------------------------------------------------------------------*/
 /*CONEXION A SQL SERVER*/
  $con_sql = conexion_bd(4);
//$conexion = conexion_bd(1);

$datos = [];

$datos_dif = calculartiempo($_POST['fechaini'] , $_POST['fechafin'] );

if( ($datos_dif[11]  >=  0)  && ($datos_dif[11] <= 30)  )
{

  /*CONSULTA QUE MUESTRA LOS CASOS QUE SE APERTURARON EN SISTEMA DE Q-FLOW*/
  /*$sql_sabana = "Select distinct
               c.CaseId caso, convert(NVARCHAR,c.ReferenceDate,20) fecha_aperturo, convert(NVARCHAR,b.StartDate,20) fecha_cerro
  from [QflowNI].qf.StepClassificationAll sc with (nolock)
  inner join [QflowNI].qf.StepAll s On sc.StepId=s.StepId
  Inner Join [QflowNI].qf.ProcessAll p with (nolock) on s.ProcessId = p.ProcessId
  Inner Join [QflowNI].qf.CaseAll c with (nolock) on c.CaseId = p.CaseId
  inner join [QflowNI].[qf].[StepAll] b on p.LastStepId = b.StepId
  where convert(date,s.StartDate,103) between ? and  ?";*/
  $sql_sabana = "Select distinct
               c.CaseId caso, convert(NVARCHAR,c.ReferenceDate,20) fecha_aperturo, convert(NVARCHAR,b.StartDate,20) fecha_cerro,
			   CASE p.ProcessStatus
                                               WHEN 1 THEN 'Cerrado'
                                               ELSE
                                                               CASE bosa.StatusId
                                                                               WHEN 1 THEN 'Abierto'
                                                                               WHEN 2 THEN 'Pendientes'
                                                                               WHEN 3 THEN 'Incompletos'
                                                                               WHEN 4 THEN 'Procesados'
                                                                               ELSE 'Abierto'
                                                               END
                                               END AS 'estado'
  from [QflowNI].qf.StepClassificationAll sc with (nolock)
  inner join [QflowNI].qf.StepAll s On sc.StepId=s.StepId
  Inner Join [QflowNI].qf.ProcessAll p with (nolock) on s.ProcessId = p.ProcessId
  inner join [CEN-NI-QFLOW-03].[QflowNI].[qf].[Service] servicio WITH (NOLOCK)  ON p.CurrentServiceId = servicio.ServiceId
  INNER JOIN [CEN-NI-QFLOW-03].[QflowNI].[qf].[Unit] unidades  WITH (NOLOCK) ON unidades.UnitId = servicio.UnitId
  Inner Join [QflowNI].qf.CaseAll c with (nolock) on c.CaseId = p.CaseId
  inner join [QflowNI].[qf].[StepAll] b on p.LastStepId = b.StepId
  LEFT JOIN  [CEN-NI-QFLOW-03].[QflowNI].[qf].[acfBOStatusAssignedSP] bosa WITH (NOLOCK) ON servicio.ServiceProfileId = bosa.ProfileId
  where convert(date,s.StartDate,103) between ? and  ?";

  $stmt = sqlsrv_query($con_sql, $sql_sabana,array($fechainicio, $fechafinal));
  
 /* if( $stmt === false)
   {
    die( print_r( sqlsrv_errors(), true));
   }*/

  $inserciones = 0;
  while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
  {

     $datos[] = $row['caso'].','.$row['fecha_aperturo'].','.$row['fecha_cerro'].','.$row['estado'].','.$usuario;

  };
  
   sqlsrv_free_stmt($stmt);

  /*VALIDANDO SI EXISTE UN ARCHIVO CSV DEL USUARIO QUE ESTA CONSULTANDO*/
  /*SI SE COMPRUEBA QUE LA DIRECCION ES DE UN ARCHIVO PASA A ELIMINAR EL ARCHIVO DEL USUARIO*/
  if (is_file($directorio))
    {
  /*ELIMINAR EL ARCHIVO*/
    unlink($directorio);
    }

  /*FUNCION QUE VALIDA SI EXISTE UN ARCHIVO CSV, SI NO EXISTE LO CREA*/
  $fp = fopen($directorio, 'wb');
  /*CICLO QUE AGREGA LOS DATOS AL ARCHIVO CSV*/
  foreach ( $datos as $line ) {
      /*FUNCION QUE CONVIERTE LOS DATOS EN UNA CADENA SEPARA POR COMAS*/
      $val = explode(",", $line);
      fputcsv($fp, $val);
  }
  fclose($fp);

  /*CONSULTA QUE BUSCA LA INFORMACION DEL ARCHIVO CSV QUE GENERO EL USUARIO PARA INSERTAR EN LA TABLA EN LA BD DE POSTGRESQL*/
  $sql_import = "DELETE FROM qflow.tbltemp_seguimiento_casos where usuario = '$usuario';
                 COPY qflow.tbltemp_seguimiento_casos(caso, fecha_inicio, fecha_finalizo, estado, usuario)
                 FROM '$directorio_file ' WITH DELIMITER ',' CSV ENCODING 'LATIN9';";

  $result_import = pg_query($conexion,$sql_import);

  if($result_import)
  {
  /*SE REPITE VA NO DEJAR ARCHIVOS CSV EN EL SERVIDOR LO DE VALIDANDO SI EXISTE UN ARCHIVO CSV DEL USUARIO QUE ESTA CONSULTANDO*/
  /*SI SE COMPRUEBA QUE LA DIRECCION ES DE UN ARCHIVO PASA A ELIMINAR EL ARCHIVO DEL USUARIO*/
  if (is_file($directorio))
    {
  /*ELIMINAR EL ARCHIVO*/
    unlink($directorio);
    }
  }

  /*SI SE INSERTO EXISTOSAMENTE LA INFORMACION DEL CSV A POSTGRESQL SE EJECUTA LA CONSULTA*/
  if($result_import)
  {

    $sql = "SELECT a.id, a.nombre_cliente, a.cedula_cliente, a.numero_producto, a.numero_qflow,
                   a.numero_dano, a.ejecutivo_creo, d.fecha_inicio, d.fecha_finalizo,
                   round((date_part('epoch'::text, coalesce(d.fecha_finalizo,now()) - d.fecha_inicio) * 24::double precision / 86400::double precision)::numeric, 2) horas_acumuladas,
                  CASE 
WHEN (plantilla.strfuncion = 'BACKOFFICE LOCAL') THEN CASE WHEN (round((date_part('epoch'::text, coalesce(d.fecha_finalizo,now()) - d.fecha_inicio) * 24::double precision / 86400::double precision)::numeric, 2) <= 12 )THEN 'VERDE'
                                                           WHEN (round((date_part('epoch'::text, coalesce(d.fecha_finalizo,now()) - d.fecha_inicio) * 24::double precision / 86400::double precision)::numeric, 2) > 12 ) AND
                                                                (round((date_part('epoch'::text, coalesce(d.fecha_finalizo,now()) - d.fecha_inicio) * 24::double precision / 86400::double precision)::numeric, 2) <= 18 )THEN 'AMARILLO'
                                                           WHEN (round((date_part('epoch'::text, coalesce(d.fecha_finalizo,now()) - d.fecha_inicio) * 24::double precision / 86400::double precision)::numeric, 2) > 18 )THEN 'ROJO'END
                                                           
WHEN (plantilla.strfuncion = 'BACKOFFICE INTEGRAL') THEN CASE WHEN (round((date_part('epoch'::text, coalesce(d.fecha_finalizo,now()) - d.fecha_inicio) * 24::double precision / 86400::double precision)::numeric, 2) <= 6 )THEN 'VERDE'
                                                              WHEN (round((date_part('epoch'::text, coalesce(d.fecha_finalizo,now()) - d.fecha_inicio) * 24::double precision / 86400::double precision)::numeric, 2) > 6 ) AND
                                                                   (round((date_part('epoch'::text, coalesce(d.fecha_finalizo,now()) - d.fecha_inicio) * 24::double precision / 86400::double precision)::numeric, 2) <= 12 )THEN 'AMARILLO'
                                                              WHEN (round((date_part('epoch'::text, coalesce(d.fecha_finalizo,now()) - d.fecha_inicio) * 24::double precision / 86400::double precision)::numeric, 2) > 12 )THEN 'ROJO'END
END semaforo,
                 a.fecha_creo, a.ejecutivo_modifico, a.fecha_modifico, a.tienda, a.zona, a.comentario,
                 plantilla.strfuncion, d.estado 
        FROM qflow.tbl_qflow_vs_danos a
        left join qflow.tbltemp_seguimiento_casos d on a.numero_qflow = d.caso and '$usuario' = d.usuario
        left join msgsac.tblcattienda b on a.tienda = b.strtienda
        left join msgsac.tblcatzonas c on a.zona = c.strzona
        left join msgsac.vwplantillasac plantilla on a.ejecutivo_creo = plantilla.strcorreo
        where  coalesce(d.fecha_inicio::date,a.fecha_creo::date) BETWEEN  '$fechainicio' AND '$fechafinal'  and
                 ((case when $g_cargo = 6 then a.zona  in (select k.strzona from msgsac.tblcatempleado as g
                                                           inner join msgsac.tbltrnempzona as h on g.intidempleado = h.intidempleado
                                                           inner join msgsac.tblcattienda as i on h.intidtienda = i.intidtienda
                                                           inner join msgsac.tblcatdepartamentos as j on i.intiddepto = j.intiddepto
                                                           inner join msgsac.tblcatzonas as k on k.intidzona = j.intidzona
                                                           where g.intidempleado = $g_idemp and h.bolactivo = 'True') end) or
                 (case when $g_cargo = 4 or $g_cargo = 5 then b.strtiendaunificada in (select i.strtiendaunificada
                                                                                       from msgsac.tblcatempleado as g
                                                                                       inner join msgsac.tbltrnempzona as h on g.intidempleado = h.intidempleado
                                                                                       inner join msgsac.tblcattienda as i on h.intidtienda = i.intidtienda
                                                                                       inner join msgsac.tblcatdepartamentos as j on i.intiddepto = j.intiddepto
                                                                                       inner join msgsac.tblcatzonas as k on k.intidzona = j.intidzona
                                                                                       where g.intidempleado = $g_idemp and h.bolactivo = 'True') end) or
                 (case when $g_cargo not in (4,5,6) then a.ejecutivo_creo = '$usuario' end) or
                (case when $g_vertodo = 1 then (length( a.numero_qflow::text) > 0 ) end))
                                                                 ORDER BY a.fecha_creo desc;";

  $detalle = pg_query($conexion,$sql);
  $filas = pg_num_rows($detalle);

  }

 

}



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
    <?php include 'icon.php' ?>

    <title>Analítica SAC</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
  <!--  <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet"> -->

        <!-- css para plugin datatable  -->
	<!--	<link rel="stylesheet" type="text/css" href="../vendor/datatables/css_/jquery.dataTables.min.css">

   <link rel="stylesheet" type="text/css" href="../vendor/datatables/css_/buttons.dataTables.min.css"> -->

  <!-- Custom CSS -->
   <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
<script src="../vendor/jquery/jquery-3.3.1.min.js"></script>


<style>

.search {
  width: 100%;
    padding: 12px 20px;
    box-sizing: border-box;
    border: none;
    background-color: #C00000;
    color: white;
}

.inputsearch::placeholder {
  color:white;
}

hr.new5 {
  border: 10px solid #C00000;
  border-radius: 5px;
}

.border {
border-radius: 5px;
background-color: #f2f2f2;
padding: 20px;
 box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
       }

</style>

<style id="jsbin-css">


table#tblclientesdanos.dataTable tbody tr.green_row > .sorting_1
       {
           background-color: #77DD77;
       }

table#tblclientesdanos.dataTable tbody tr.green_row
       {
           background-color: #77DD77;
       }

table#tblclientesdanos.dataTable tbody tr.red_row > .sorting_1
      {
                  background-color: #FF6961;
      }

table#tblclientesdanos.dataTable tbody tr.red_row
      {
                  background-color: #FF6961;
      }

table#tblclientesdanos.dataTable tbody tr.yellow_row > .sorting_1
      {
                  background-color: #FDFD96;
      }

table#tblclientesdanos.dataTable tbody tr.yellow_row
      {
                  background-color: #FDFD96;
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
                  <img class="d-block mx-auto mb-4" src="../img/logoclaro.jpg" alt="CLARO" width="92" height="82">
              </div>

             <h2 align="center">Servicio al Cliente</h2>
             <h4 class="page-header  mb-3 text-center">Consultar registros de bitácora de daños</h4>
             <br/>

             <?php

             if(count($datos_dif) > 0)
             {
               if( $datos_dif[11] > 30)
               {
                 echo "<div id = 'Mensaje_Error' class='alert alert-warning'>
                      <strong>Error!</strong> No se puede seleccionar más de 31 días!
                      </div>";
               }
             }
             ?>

             <div class="panel panel-red">
                      <div class="panel-heading">Buscar por</div>
                      <div class="panel-body">
                        <form  name="frmbusqueda"  method="post">

                          <div class="row">
                              <div class="col-md-3 mb-3">
                                <label for="fini">Fecha inicio</label>
                                <input type="date" class="form-control input-sm" id="fechaini" name="fechaini" value="<?php if(isset($_SESSION['fechainicio_agenda'])) echo $_SESSION['fechainicio_agenda']; ?>" required>
                              </div>


                          <div class="col-md-3 mb-3">
                          <label for="ffin">Fecha fin</label>
                          <input type="date" class="form-control input-sm" id="fechafin" name="fechafin" value="<?php if(isset($_SESSION['fechafin_agenda'])) echo $_SESSION['fechafin_agenda']; ?>" required>
                           </div>
                          </div>
                          <br>
                      <button class="btn btn-info" type="submit" name="btnbuscar">Buscar</button>

                        </form>
                        <br>
                      </div>
                  </div>


             <!--Primera fila -->
             <div class="border">

            <br>

            <div class="row">

            <div class="col-md-12 mb-3">

            <div class='table-responsive'>
                 <table id='tblclientesdanos' class='display nowrap' style='width:100%'>
                   <thead>
                     <tr>
                        <th>Nombre del cliente</th>
                        <th>Cédula del cliente</th>
                        <th>Número de producto</th>
                        <th>Número de daño</th>
                        <th>Número de Q-flow</th>
                        <th>Fecha inicio qflow</th>
                        <th>Fecha finalizo qflow</th>
						<th>Estado</th>
                        <th>Horas acumuladas</th>
                        <th>Semáforo</th>
                        <th>Comentario</th>
                        <th>Ejecutivo creo</th>
						<th>Ejecutivo funcion</th>
                        <th>Fecha creo</th>
                        <th>Ejecutivo modifico</th>
                        <th>Fecha modifico</th>
                        <th>Tienda</th>
                        <th>Zona</th>
                     </tr>
                     </thead>
                            <tbody>
                              <?php
                                 if ($detalle <> 0) {
                                  while($row = pg_fetch_array($detalle))
                                     {


                                         ?>

                                          <tr>
                                          <td ><?php echo $row['nombre_cliente']; ?></td>
                                          <td ><?php echo $row['cedula_cliente']; ?></td>
                                          <td ><?php echo $row['numero_producto']; ?></td>
                                          <td ><?php echo $row['numero_dano']; ?></td>
                                          <td ><?php echo $row['numero_qflow']; ?></td>
                                          <td ><?php echo $row['fecha_inicio']; ?></td>
                                          <td ><?php echo $row['fecha_finalizo']; ?></td>
										  <td ><?php echo $row['estado']; ?></td>
                                          <td ><?php echo $row['horas_acumuladas']; ?></td>
                                          <td ><?php echo $row['semaforo']; ?></td>
                                          <td ><?php echo $row['comentario']; ?></td>
                                          <td ><?php echo $row['ejecutivo_creo']; ?></td>
										  <td ><?php echo $row['strfuncion']; ?></td>
                                          <td><?php echo $row['fecha_creo']; ?></td>
                                          <td><?php echo $row['ejecutivo_modifico']; ?></td>
                                          <td><?php echo $row['fecha_modifico']; ?></td>
                                          <td><?php echo $row['tienda']; ?></td>
                                          <td><?php echo $row['zona']; ?></td>
                                        </tr>
                                           <?php }
                                           }
                                           ?>
                                          </tbody>
                                          </table>
            </div>
            <br>
            </div>

             <hr class="new5">
             <div class="col-md-1 mb-3">
             <a href="registrar_danos.php" class="btn btn-info btn-sm" role="button">Regresar</a>
            </div>

        <br>
       <br>

       </div><!-- Cierra el fondo de formulario-->
	   <br>
            </div>
            <br>

           </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <footer class="my-5 pt-5 text-muted text-center text-small">
          <p class="mb-1">&copy; <?php echo date("Y")-1; ?>-<?php echo date("Y"); ?> SAC</p>
          <ul class="list-inline">
            <li class="list-inline-item"><a href="index.php">Inicio</a></li>
           </ul>
    </footer>

    <script>

    </script>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

  <!--  <script src="../vendor/datatables/js_/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script> -->

    <!-- jquery para plugin datatable permite exportar a excel, csv, pdf  -->
    <!-- <script type="text/javascript" src="../vendor/jquery/exp/jquery-1.12.4.js"></script> -->
    <link href="../vendor/datatables/css_/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <script src="../vendor/datatables/js_/jquery.dataTables.min.js"></script>

   <script type="text/javascript" src="../vendor/jquery/exp/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/buttons.flash.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/jszip.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/pdfmake.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/vfs_fonts.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/buttons.html5.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/buttons.print.min.js"></script>




    <script>
          $(document).ready(function(){
        var table = $('#tblclientesdanos').DataTable({
          "dom":'Bfrtip',
          "buttons": ['excel'],
          "language":{
            "lengthMenu": "Mostrar _MENU_ registros por pagina",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrada de _MAX_ registros)",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando...",
            "search": "Buscar:",
            "zeroRecords":    "No se encontraron registros coincidentes",
            "paginate": {
              "next":       "Siguiente",
              "previous":   "Anterior"
            },
          },
          rowCallback: function (row, data)
          {
		   if(data[12] == "BACKOFFICE INTEGRAL")
		   {
					if (Number(data[8]) <= 6)
					  {
						 $(row).addClass('green_row');
					  }

					  if ((Number(data[8]) > 6) && (Number(data[8]) <= 12))
					  {
						 $(row).addClass('yellow_row');
					  }

					  if ((Number(data[8]) > 12))
					  {
						 $(row).addClass('red_row');
					  }
		    }
			else
			{
					   if (Number(data[8]) <= 12)
					  {
						 $(row).addClass('green_row');
					  }

					  if ((Number(data[8]) > 12) && (Number(data[8]) <= 18))
					  {
						 $(row).addClass('yellow_row');
					  }

					  if ((Number(data[8]) > 18))
					  {
						 $(row).addClass('red_row');
					  }
			}
          }
            });
          });


    </script>

</body>

</html>
