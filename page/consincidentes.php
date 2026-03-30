<?php
require_once 'cn.php';
require_once 'reg.php';
require_once 'fncombustible.php';


$fechainicio="";$fechafinal="";$detalle=0;$idnota=0;$filas=0;$cuentafilas = 0;$target = "";

if(isset($_REQUEST['btnbuscar']))
{
   $fechainicio = $_POST['fechaini']; $fechafinal = $_POST['fechafin'];
   $_SESSION['fechainiconsulnota'] = $fechainicio;
   $_SESSION['fechafinconsulnota'] = $fechafinal;
   $conexion = conexion_bd(1);
   $usuario=$_SESSION['user'];

   /*se consulta el id de cargo del usuario logueado*/
  /* $sql="SELECT coalesce(a.intidcargo,0) intidcargo, a.intidempleado, coalesce(a.strpermiso,'0') strpermiso from msgsac.tblcatempleado as a where a.strcorreo = '$usuario'";
   $resul = pg_query($conexion,$sql);
   $row = pg_fetch_array($resul);*/

   $g_cargo =$_SESSION["idcargo"];
   $g_idemp = $_SESSION["idempleado"];
   $g_vertodo = $_SESSION["permiso"];

   $sql_tbl = "	SELECT a.intidproblematica registro, concat(b.strpnombre::text,' ',b.strsnombre::text,' ',b.strpapellido::text,' ',b.strsapellido::text) Ejecutivo, c.strcargo,
                a.strzona, d.strtiendaunificada, a.strtienda, a.strsegmento segmento, a.strproblematica problematica, a.datfechacreo fecha, a.strcomentario comentario, f.strruta
                from msgsac.tbltrnproblematica a inner join msgsac.tblcatempleado b on a.strusuario = b.strcorreo and b.bolactivo = 'True'
                inner join msgsac.tblcatcargo c on c.intidcargo = b.intidcargo
                left join msgsac.tblcattienda d on a.strtienda = d.strtienda
                left join msgsac.tblcatzonas e on a.strzona = e.strzona
                left join (select distinct intidrq, strruta, strtipo from msgsac.tbltrnimgincidentemultiskill) f on a.intidproblematica = f.intidrq
	              where ((case when $g_cargo = 6 then  e.intidzona in   (select j.intidzona from msgsac.tblcatempleado as g
							                                                         inner join msgsac.tbltrnempzona as h on g.intidempleado = h.intidempleado
							                                                         inner join msgsac.tblcattienda as i on h.intidtienda = i.intidtienda
							                                                         inner join msgsac.tblcatdepartamentos as j on i.intiddepto = j.intiddepto
							                                                         where g.intidempleado = $g_idemp and h.bolactivo = 'True') end) or
	                     (case when $g_cargo = 4 or $g_cargo = 5 then d.strtiendaunificada in   (select i.strtiendaunificada from msgsac.tblcatempleado as g
										                                                                           inner join msgsac.tbltrnempzona as h on g.intidempleado = h.intidempleado
										                                                                           inner join msgsac.tblcattienda as i on h.intidtienda = i.intidtienda
							                                                                                 inner join msgsac.tblcatdepartamentos as j on i.intiddepto = j.intiddepto
							                                                                                 where g.intidempleado = $g_idemp and h.bolactivo = 'True') end) or
	                    (case when $g_cargo not in (4,5,6) then   a.strusuario  = '$usuario' end) or
	                    (case when $g_vertodo = 1  then  (a.intidproblematica  > 0 ) end)) and a.datfechacreo::date between '$fechainicio' and '$fechafinal'
                      order by a.intidproblematica asc";

    $detalle = pg_query($conexion,$sql_tbl);
    $filas = pg_num_rows($detalle);

    echo $sql_tbl."\n".$g_cargo." ".$g_idemp." ".$g_vertodo;
}

if(isset($_SESSION['fechainiconsulnota']) && isset($_SESSION['fechafinconsulnota']))
{
   $fechainicio =$_SESSION['fechainiconsulnota']; $fechafinal = $_SESSION['fechafinconsulnota'];
   $conexion = conexion_bd(1);
   $usuario=$_SESSION['user'];

   /*se consulta el id de cargo del usuario logueado*/
  /* $sql="SELECT coalesce(a.intidcargo,0) intidcargo, a.intidempleado, coalesce(a.strpermiso,'0') strpermiso from msgsac.tblcatempleado as a where a.strcorreo = '$usuario'";
   $resul = pg_query($conexion,$sql);
   $row = pg_fetch_array($resul);*/

   $g_cargo =$_SESSION["idcargo"];
   $g_idemp = $_SESSION["idempleado"];
   $g_vertodo = $_SESSION["permiso"];

   $sql_tbl = "SELECT a.intidproblematica registro, concat(b.strpnombre::text,' ',b.strsnombre::text,' ',b.strpapellido::text,' ',b.strsapellido::text) Ejecutivo, c.strcargo,
                a.strzona, d.strtiendaunificada, a.strtienda, a.strsegmento segmento, a.strproblematica problematica, a.datfechacreo fecha, a.strcomentario comentario, f.strruta
                from msgsac.tbltrnproblematica a inner join msgsac.tblcatempleado b on a.strusuario = b.strcorreo and b.bolactivo = 'True'
                inner join msgsac.tblcatcargo c on c.intidcargo = b.intidcargo
                left join msgsac.tblcattienda d on a.strtienda = d.strtienda
                left join msgsac.tblcatzonas e on a.strzona = e.strzona
                left join (select distinct intidrq, strruta, strtipo from msgsac.tbltrnimgincidentemultiskill) f on a.intidproblematica = f.intidrq
	              where ((case when $g_cargo = 6 then  e.intidzona in   (select j.intidzona from msgsac.tblcatempleado as g
							                                                         inner join msgsac.tbltrnempzona as h on g.intidempleado = h.intidempleado
							                                                         inner join msgsac.tblcattienda as i on h.intidtienda = i.intidtienda
							                                                         inner join msgsac.tblcatdepartamentos as j on i.intiddepto = j.intiddepto
							                                                         where g.intidempleado = $g_idemp and h.bolactivo = 'True') end) or
	                     (case when $g_cargo = 4 or $g_cargo = 5 then d.strtiendaunificada in   (select i.strtiendaunificada from msgsac.tblcatempleado as g
										                                                                           inner join msgsac.tbltrnempzona as h on g.intidempleado = h.intidempleado
										                                                                           inner join msgsac.tblcattienda as i on h.intidtienda = i.intidtienda
							                                                                                 inner join msgsac.tblcatdepartamentos as j on i.intiddepto = j.intiddepto
							                                                                                 where g.intidempleado = $g_idemp and h.bolactivo = 'True') end) or
	                    (case when $g_cargo not in (4,5,6) then   a.strusuario  = '$usuario' end) or
	                    (case when $g_vertodo = 1  then  (a.intidproblematica  > 0 ) end)) and a.datfechacreo::date between '$fechainicio' and '$fechafinal'
                      order by a.intidproblematica asc";

    $detalle = pg_query($conexion,$sql_tbl);
    $filas = pg_num_rows($detalle);
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

    <title>Analítica SAC</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- css para plugin datatable  -->
    <link rel="stylesheet" type="text/css" href="../vendor/datatables/css_/jquery.dataTables.min.css">

    <link rel="stylesheet" type="text/css" href="../vendor/datatables/css_/buttons.dataTables.min.css">

    <link rel="stylesheet" type="text/css" href="../vendor/datatables/css/dataTables.checkboxes.css">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery-3.3.1.min.js"></script>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  <style type="text/css">

  .modal-header {
                  padding:9px 15px;
                  border-bottom:1px solid #eee;
                  background-color: #000000;
                  -webkit-border-top-left-radius: 5px;
                  -webkit-border-top-right-radius: 5px;
                  -moz-border-radius-topleft: 5px;
                  -moz-border-radius-topright: 5px;
                  border-top-left-radius: 5px;
                  border-top-right-radius: 5px;
                }

                .divTable{
                        	display: table;
                        	width: 100%;
                        }
                        .divTableRow {
                        	display: table-row;
                        }
                        .divTableHeading {
                        	background-color: #EEE;
                        	display: table-header-group;
                        }
                        .divTableCell, .divTableHead {
                        	border: 1px solid #999999;
                        	display: table-cell;
                        	padding: 3px 10px;
                        }
                        .divTableHeading {
                        	background-color: #EEE;
                        	display: table-header-group;
                        	font-weight: bold;
                        }
                        .divTableFoot {
                        	background-color: #EEE;
                        	display: table-footer-group;
                        	font-weight: bold;
                        }
                        .divTableBody {
                        	display: table-row-group;
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
              <h2>Servicio al cliente</h2>
              <h4 class="page-header  mb-3 text-center">Ver/consultar incidentes</h4>
              </div>


              <br>
               <form id="frm-example" action="" method="POST">
                  <div id="result"></div>

                  <div class="panel panel-red">
                      <div class="panel-heading">Buscar por</div>
                      <div class="panel-body">
                          <div class="row">
                              <div class="col-md-6 mb-3">
                                <label for="fini">Fecha inicio</label>
                                <input type="date" class="form-control" id="fechaini" name="fechaini" value="<?php if(isset($_SESSION['fechainiconsulnota'])) echo $_SESSION['fechainiconsulnota']; ?>" required>
                              </div>

                              <div class="col-md-6 mb-3">
                                <label for="ffin">Fecha final</label>
                                <input type="date" class="form-control" id="fechafin" name="fechafin" value="<?php if(isset($_SESSION['fechafinconsulnota'])) echo $_SESSION['fechafinconsulnota']; ?>" required>
                              </div>
                          </div>
                          <br>
                      <button class="btn btn-info" type="submit" name="btnbuscar">Buscar</button>
                        <br>
                      </div>
                  </div>
                  <br>


                  <div class="row table-responsive">
                      <table class="display nowrap" id="mitabla" style="width:100%" cellspacing="0">
                          <thead>
                            <tr>
                               <th><p class="small"><strong>Registro</strong></p></th>
                               <th><p class="small"><strong>Ejecutivo</strong></p></th>
                               <th><p class="small"><strong>Cargo</strong></p></th>
                               <th><p class="small"><strong>Zona</strong></p></th>
                               <th><p class="small"><strong>Tienda Unificada</strong></p></th>
                               <th><p class="small"><strong>Tienda</strong></p></th>
                               <th><p class="small"><strong>Segmento</strong></p></th>
                               <th><p class="small"><strong>Problematica</strong></p></th>
                               <th><p class="small"><strong>Fecha</strong></p></th>
                               <th><p class="small"><strong>Comentario</strong></p></th>
                                <th><p class="small"><strong>Archivo</strong></p></th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php
                                 if($detalle<>0)
                                  while($row = pg_fetch_array($detalle))
                                     {
                                         $cuentafilas = $cuentafilas + 1;

                                        /* $path = '../combustible/'.$row['intiddetconsumo'];

                                         if(file_exists($path)){
                                           $directorio = opendir($path);
                                              while ($archivo = readdir($directorio))
                                              {
                                                if(!is_dir($archivo))
                                                {
                                                  $target = $path.'/'.$archivo;
                                                }
                                              }
                                            }*/

                                         ?>

                                          <tr>
                                          <td align="center"><p class='small'><?php echo $row['registro']; ?></p></td>
                                          <td align="center"><p class='small'><?php echo $row['ejecutivo']; ?></p></td>
                                          <td align="center"><p class='small'><?php echo $row['strcargo']; ?></p></td>
                                          <td align="center"><p class='small'><?php echo $row['strzona']; ?></p></td>
                                          <td align="center"><p class='small'><?php echo $row['strtiendaunificada']; ?></p></td>
                                          <td align="center"><p class='small'><?php echo $row['strtienda']; ?></p></td>
                                          <td align="center"><p class='small'><?php echo $row['segmento']; ?></p></td>
                                          <td align="center"><p class='small'><?php echo $row['problematica']; ?></p></td>
                                          <td align="center"><p class='small'><?php echo $row['fecha']; ?></p></td>
                                          <td align="center"><p class='small'><?php echo $row['comentario']; ?></p></td>
                                          <td><a href='<?php echo $row['strruta']; ?>' target='_blank'><img  src='<?php echo $row['strruta']; ?>' alt='Archivo' width='50' height='50'></a></td>

                                        <?php
                                             if($cuentafilas == $filas)
                                             {
                                               ?>
                                                          </tbody>
                                                       </table>
                                                   </form>
                                                 </div>
                                        <?php } ?>

                                   <?php }?>



                                             <?php
                                                  if($filas == 0)
                                                  {
                                                    ?>
                                                               </tbody>
                                                            </table>
                                                        </form>
                                                      </div>
                                             <?php } ?>
                                             <div class="col-md-4">
                                                  <a href="retroalimentacionmultiskill.php" class="btn btn-info" role="button">regresar</a>
                                             </div>

                <br>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <footer class="my-5 pt-5 text-muted text-center text-small">
          <p class="mb-1">&copy; 2017-2018 SAC</p>
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

    <!-- jquery para plugin datatable permite exportar a excel, csv, pdf  -->
    <!-- <script type="text/javascript" src="../vendor/jquery/exp/jquery-1.12.4.js"></script> -->
    <script type="text/javascript" src="../vendor/datatables/js_/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/buttons.flash.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/jszip.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/pdfmake.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/vfs_fonts.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/buttons.html5.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/buttons.print.min.js"></script>

    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script src="../vendor/datatables/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="../vendor/datatables/js/dataTables.checkboxes.min.js"></script>



    <!--script para cambiar etiquetas a datatable -->
  <script>
         $(function(){

           var table= $('#mitabla').DataTable({
             "order": [[1, "asc"]],
             "dom":'Bfrtip',
             "buttons": ['copy','csv','excel','print'],
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
             }
           });

         })
</script>

</body>

</html>
