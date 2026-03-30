<?php
require_once 'cn.php';
require_once 'reg.php';

//ini_set("soap.wsdl_cache_enabled", 0);
  /*
   * @EXAMPLE BCN MODIFICADO POR JHONNY F. GUTIERREZ  correo: jhonfc9011@gmail.com
   * Ejemplo de utilización del servicio WSDL, con PHP
   */

  /*
   * CODIGO CLIENTE WSDL DE PHP
   */

  $servicio = "https://servicios.bcn.gob.ni/Tc_Servicio/ServicioTC.asmx?WSDL"; //url del servicio
  $parametros = array(); //parametros de la llamada
  $mensaje ="";


  /*
   * Cuando presiona el boton Consultar de Mes
   * Este envia los datos al vinculo que aparece en "action" del formulario
   * En caso de ser asi, con la funcion "$_REQUEST" de php, verificamos
   * que posee ese vinculo, en este caso se envia una variable con un valor
   * la variables es "Consultar", el valor es "Mes"
   */
  if (isset($_GET['Consultar']) && $_GET['Consultar'] == "Mes")
  {      //Verificamos que la consulta es por tasa de cambio Mensual

if(isset($_POST['Year']) && isset($_POST['Month']))
{
  $parametros['Ano'] = (int)$_POST['Year'];
  $parametros['Mes'] = (int)$_POST['Month'];

  //echo "Mes = ". $_REQUEST['Month'] . "anio =" .$_REQUEST['Year'];
  $ValorTasaMes = "";

  $options = [
  'cache_wsdl'     => WSDL_CACHE_NONE,
  'trace'          => 1,
  'stream_context' => stream_context_create(
      [
          'ssl' => [
              'verify_peer'       => false,
              'verify_peer_name'  => false,
              'allow_self_signed' => true
          ]
      ]
  ),
 'exceptions' => true,
];

  $client = new SoapClient($servicio, $options);

  $result = $client->RecuperaTC_Mes($parametros); //llamamos al métdo que nos interesa con los parámetros

  $Class = (array) $result->RecuperaTC_MesResult;
  $ValorDelXML = $Class['any'];
  $xml = simplexml_load_string($ValorDelXML);
  $array = (array) $xml;
  $fecha = "";
  $tasa = "";
  $count=0;

  $fecha_array= array();
  $tasa_array= array();


  foreach ($array as $key => $a) {
                   //Recorremos el arreglo con todos los Datos
      foreach ($a as $key2 => $aa) {                      //Con este For, recorremos Los Dias del Mes

          foreach ($aa as $key3 => $a3)
          {                 //Con este for, recorremos las Fechas y Sus valores

              if ($key3 == "Fecha")
              {
                  array_push($fecha_array,$a3);
              }

              if ($key3 == "Valor")
              {
                  array_push($tasa_array,$a3);
              }
              if ($key3 == "Fecha" || $key3 == "Valor")
                  $ValorTasaMes .= ' ' . $key3 . '-' . $a3;;


          }
          //Terminado este For, pasa a la Siguiente Fecha
          $ValorTasaMes .='
';
      }

  }

  $anio = (int)$_POST['Year'];
  $mes = (int)$_POST['Month'];
  pg_query(conexion_bd(1),"DELETE FROM public.tblcattasacambio
                           where date_part('year',fecha) = $anio AND date_part('month',fecha) = $mes;");

  for ($i = 0; $i <= count($fecha_array) - 1; $i++)
  {
    pg_query(conexion_bd(1),"INSERT INTO public.tblcattasacambio(fecha, monto) VALUES ('$fecha_array[$i]',$tasa_array[$i])") ;
  }

    $mensaje =  "<div class='alert alert-success'>
                 <strong>Exito!</strong> Se importo la tasa de cambio con exito!
                 </div>";

}



  }


  /*Funcion que importa creditos de excel a base de datos en postgres*/
  function Importar_tc()
  {
        try
        {
          $anio = (int)$_POST['Year_'];
          $mes = (int)$_POST['Month_'];
          pg_query(conexion_bd(1),"DELETE FROM public.tblcattasacambio
                                   where date_part('year',fecha) = $anio AND date_part('month',fecha) = $mes;");

    //subir la imagen del articulo
    $nameEXCEL = $_FILES['periodofile']['name'];
    $tmpEXCEL = $_FILES['periodofile']['tmp_name'];
    $extEXCEL = pathinfo($nameEXCEL);

    $urlnueva = "../xls/tc.csv";

    /*Valida si existe el archivo*/
    if (file_exists($urlnueva))
    {
      /*Valida si es un archivo*/
      if (is_file($urlnueva))
        {
          /*elimina el archivo*/
          unlink($urlnueva);
        }
    }

    if(is_uploaded_file($tmpEXCEL))
    {
      copy($tmpEXCEL,$urlnueva);
    }

    $fecha_array= array();
    $tasa_array= array();

  $row = 1;
  if (($handle = fopen("../xls/tc.csv", "r")) !== FALSE) {
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          $num = count($data);
          //echo "<p> $num fields in line $row: <br /></p>\n";
          $row++;
          for ($c=0; $c < $num; $c++) {
            //  echo $data[$c] . "<br />\n";

              if(strlen ( $data[$c]) == 10 ){
                //echo $data[$c] . "<br />\n";
                array_push($fecha_array,$data[$c]);
              }

              if(strlen ( $data[$c]) <= 7 ){
                //echo $data[$c] . "<br />\n";
                array_push($tasa_array,$data[$c]);
              }
          }
      }
      fclose($handle);
  }

  for ($i = 0; $i <= count($fecha_array) - 1; $i++)
  {
    pg_query(conexion_bd(1),"INSERT INTO public.tblcattasacambio(fecha, monto) VALUES ('$fecha_array[$i]',$tasa_array[$i])") ;
  }

  $mensaje =  "<div class='alert alert-success'>
       <strong>Exito!</strong> Se importo la tasa de cambio con exito!
       </div>";


        }
        catch (Exception $e)
        {
        $mensaje = "<div class='alert alert-warning'>
                <strong>Error!</strong> Ups, Disculpe no se actualizo!, por favor verifique.
                </div>";
        }
  }

  if(isset($_POST["btnimportar"]))
  {
    Importar_tc();
  }

  $detalle = 0; $estado ="";
  $result = pg_query(conexion_bd(1),"SELECT id, fecha, monto FROM public.tblcattasacambio
                                     order by fecha asc;");
  $detalle = pg_affected_rows($result);


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

   <style type="text/css">
   table.dataTable thead tr {
     background-color: grey;
     color: #ffffff;
   }
   </style>


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
        <?php include 'menu.php' ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
              <br>

              <div class="py-5 text-center">
                  <?php include 'logo.php' ?>
              </div>

             <h2 align="left">Tasa de cambio</h2>

             <br>

             <?php
             if(isset($mensaje)){echo $mensaje;}
             ?>

             <div id="resultados_ajax"></div>


             <div class="panel panel-default">
              <div class="panel-heading">
                  <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><b><i>Formulario de solicitud por mes de la oficial tasa de cambio  al Banco central de Nicaragua</i></b></a>
                  </h4>
              </div>
              <div id="collapseTwo" class="panel-collapse collapse in">
                  <div class="panel-body">

                    <form action="tasacambio.php?Consultar=Mes" method="POST">

                      <div class="row">
                        <div class="col-md-3 mb-3">
                          <label for="email">A&ntilde;o</label>
                          <input type="text" class="form-control" name="Year" id="Year" value="" size="10" required />
                        </div>
                        <div class="col-md-3 mb-3">
                          <label for="pwd">Mes:</label>
                          <input type="text" class="form-control" name="Month" id="Month" value="" size="10" required/>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="pwd">Resultado:</label>
                        <textarea class="form-control" name="" rows="2" cols="35" readonly="readonly"><?php  if(isset($ValorTasaMes)) { echo $ValorTasaMes; }; ?></textarea>
                      </div>

                      <input type="submit" class="btn btn-default" name="Consultar" value="Insertar tasa de cambio" />

                    </form>
                    <!--
                    Codigo de JavaScript
                    -->
                    <script>
                        var Fecha=new Date();   //Declaramos una variable para tomar las Fechas
                        var Ano=Fecha.getFullYear();    //Tomamos el año actual en la variable "Ano""
                        var Mes=Fecha.getMonth()+1;   //Tomamos el mes actual en la variable "Mes"
                        //Le sumamos 1, por que toma como mes inicial "0"
                        document.getElementById('Year').value = Ano;        //Asignamos al campo de texto "Year" el valor del Año
                        document.getElementById('Month').value = Mes;       //Asignamos al campo de texto "Month" el valor del Mes
                    </script>

                  </div>
              </div>
              </div>

              <br>

              <div class="panel panel-default">
               <div class="panel-heading">
                   <h4 class="panel-title">
                       <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><b><i>Importar tasa de cambio desde Excel (csv)</i></b></a>
                   </h4>
               </div>
               <div id="collapseThree" class="panel-collapse collapse">
                   <div class="panel-body">

                     <form class="form-inline" enctype="multipart/form-data" method="post">

                           <div class="row">

                             <div class="col-md-3 mb-3">
                               <label for="email">A&ntilde;o</label>
                               <input type="text" class="form-control" name="Year_" id="Year_" value=""  required/>
                             </div>

                             <div class="col-md-3 mb-3">
                               <label for="pwd">Mes:</label>
                               <input type="text" class="form-control" name="Month_" id="Month_" value="" required/>
                             </div>

                           </div>

                           <br>

                           <div class="row">
                           <div class="col-md-3 mb-3">
                             <label for="pwd">Archivo:</label>
                            <input type="file" class="form-control" id="periodofile" name="periodofile" accept=".csv" required>
                           </div>
                         </div>
                         <br>


                          <button class="btn" name="btnimportar" type="submit" value="btnimportar">Importar</button>
                          <br>
                          <p><strong>Nota:</strong>Importe un archivo en formato CSV que contenga la columna fecha y la columna monto sin encabezado
                           que el separador sea coma y el nombre sea tc.csv</p>
                     </form>
                     <!--
                     Codigo de JavaScript
                     -->
                     <script>
                         var Fecha=new Date();   //Declaramos una variable para tomar las Fechas
                         var Ano=Fecha.getFullYear();    //Tomamos el año actual en la variable "Ano""
                         var Mes=Fecha.getMonth()+1;   //Tomamos el mes actual en la variable "Mes"
                         var Ano_=Fecha.getFullYear();    //Tomamos el año actual en la variable "Ano""
                         var Mes_=Fecha.getMonth()+1;   //Tomamos el mes actual en la variable "Mes"
                         //Le sumamos 1, por que toma como mes inicial "0"
                         document.getElementById('Year_').value = Ano;        //Asignamos al campo de texto "Year" el valor del Año
                         document.getElementById('Month_').value = Mes;       //Asignamos al campo de texto "Month" el valor del Mes
                     </script>

                   </div>
               </div>
               </div>







             <div class="row">
               <div class="table-responsive">
               <br>
                 <table class="table table-striped table-bordered" id="tbl_tipocambio" style="width:100%">
                     <thead>
                       <tr>
                          <th><p class="small"><strong>No.</strong></p></th>
                          <th><p class="small"><strong>Fecha</strong></p></th>
                          <th><p class="small"><strong>Monto</strong></p></th>
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
                                     <td><?php echo $row['id']; ?></td>
                                     <td align="center"><p class='small' ><?php echo $row['fecha']; ?></p></td>

                                     <td align="center"><p class='small'><?php echo $row['monto']; ?></p></td>
                                     </tr>

                                   <?php } }  ?>
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

    <!-- /#wrapper -->
    <!-- Modal -->
   <div id="new" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-md">
        <div class="modal-content">
           <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               <h3 id="myModalLabel" align="center">Nuevo tipo de producto</h3>
           </div>
           <div class="modal-body">
             <form role="form" name="frm_agregar_tipo_producto" id="frm_agregar_tipo_producto" method="post">
               <div class="form-group">
                 <strong>Descripcion </strong><br>
                 <input type="text" id="descripcion_tipo_producto" name="descripcion_tipo_producto" class="form-control" autocomplete="off" required>
               </div>
               <br>

             <div class="modal-footer">
                 <button class="btn" data-dismiss="modal" aria-hidden="true"><strong>Cerrar</strong></button>
                 <button type="submit" id="agregar_tipo_producto" name="agregar_tipo_producto" class="btn btn-primary"><strong>Guardar</strong></button>
             </div>
             </form>
           </div>
        </div>
     </div>
   </div>

   <!-- Modal -->
  <div id="update" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
       <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h3 id="myModalLabel" align="center">Editar tipo de producto</h3>
          </div>
          <div class="modal-body">
            <form role="form" name="frm_editar_tipo_producto" id="frm_editar_tipo_producto" method="post">
              <div class="form-group">
                <strong>Descripcion </strong><br>
                <input type="hidden" id="id_tipo" name="id_tipo" class="form-control" autocomplete="off" required>
                <input type="text" id="descrip_tipo_producto" name="descrip_tipo_producto" class="form-control" autocomplete="off" required>
              </div>
              <br>

              <div class="form-group">
                <strong>Estado </strong><br>
                <select class="form-control" id="estado_clasificacion" name="estado_clasificacion" required>
                <option value="true"> ACTIVO </option>
                <option value="false"> INACTIVO </option>
                </select>
              </div>
              <br>

            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true"><strong>Cerrar</strong></button>
                <button type="submit" id="editar_tipo_producto" name="editar_tipo_producto" class="btn btn-primary"><strong>Guardar</strong></button>
            </div>
            </form>
          </div>
       </div>
    </div>
  </div>

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
       $(document).on('click', '.edit_data', function(){

       var id_tipo = $(this).attr("id");
       var tipo =   document.getElementById("tipo_"+id_tipo).value;
       $('#id_tipo').val(id_tipo);
       $('#descrip_tipo_producto').val(tipo);
       });

     $('#tbl_tipocambio').DataTable(
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

	});


  $( "#frm_agregar_tipo_producto" ).submit(function( event ) {
  $('#agregar_tipo_producto').attr("disabled", true);
  var parametros = $(this).serialize();
   $.ajax({
      type: "POST",
      url: "fntipoproductos.php",
      data: parametros,
       beforeSend: function(objeto){
        $("#resultados_ajax").html("Enviando...");
        },
      success: function(datos){
      $("#resultados_ajax").html(datos);
      $('#agregar_tipo_producto').attr("disabled", false);
      //load(1);
      window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
      $(this).remove(); location.reload();});}, 5000);
      $('#new').modal('hide');
      }
  });
  event.preventDefault();
  })

  $( "#frm_editar_tipo_producto" ).submit(function( event ) {
  $('#editar_tipo_producto').attr("disabled", true);
  var parametros = $(this).serialize();
   $.ajax({
      type: "POST",
      url: "fntipoproductos.php",
      data: parametros,
       beforeSend: function(objeto){
        $("#resultados_ajax").html("Enviando...");
        $('#update').modal('hide');
        },
      success: function(datos){
      $("#resultados_ajax").html(datos);
      $('#editar_tipo_producto').attr("disabled", false);
      //load(1);
      window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
      $(this).remove(); location.reload();});}, 5000);
      $('#new').modal('hide');
      }
  });
  event.preventDefault();
  })

</script>

</body>

</html>
