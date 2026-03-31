<?php
require_once 'cn.php';
require_once 'reg.php';
require_once 'funciones/funciones.php';

$con = conexion_bd(1);

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

  <!--  <link href="../vendor/bootstrap/css/bootstrap-multiselect.css" rel="stylesheet"> -->
        <link href="../vendor/bootstrap/css/bootstrap-select.min.css" rel="stylesheet">

      <link href="../vendor/bootstrap/css/select2.min.css" rel="stylesheet">

      <!-- DataTables CSS -->
      <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

      <!-- css para plugin datatable  -->
      <link rel="stylesheet" type="text/css" href="../vendor/datatables/css_/jquery.dataTables.min.css">

      <link rel="stylesheet" type="text/css" href="../vendor/datatables/css_/buttons.dataTables.min.css">


    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


    <script src="../vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
      .border {
      border-radius: 5px;
      background-color: #f2f2f2;
      padding: 20px;
       box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
             }

      .i-am-centered { margin: auto; max-width: 300px;}

    .panel-default>.panel-heading-custom {

    background-color: grey;
    border-color: grey;
      color: #ffffff;
     }

     .panel-footer{
    background-color:grey;
    border-color: grey;
    color: #FFFFFF;
}
      </style>

      <style>
        @media only screen and (max-width: 700px) {
          video {
            max-width: 40%;
          }
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

             <!-- Content Wrapper. Contains page content -->


<section class="content-header">
<h3 class="page-header"><i class='fa fa-edit'></i> Agregar nueva venta</h3>
</section>

<div id="resultados_ajax"></div>

<div class="row">
<div class="col-md-12 mb-3">
                   <div class="panel panel-default">
                       <div class="panel-heading-custom panel-heading">
                           Nueva venta
                       </div>
                       <div class="panel-body">

                      <form role="form" name="save_sale" id="save_sale" method="post">

                         <div class="panel panel-default">

                           <div class="panel-body">Detalles de la Factura
                             <button type="submit" id="save_print" name="save_print"  class="btn btn-success pull-right "><i class="fa fa-print"></i> Guardar e imprimir</button>
                           </div>


                         </div>



                         <br>

                         <ul class="list-group">
                             <li class="list-group-item">

                               <div class="row">
                                   <div class="col-md-5">
                                    <label for="segundonombre">Cliente</label>
                                     <div class="input-group">
                                     											<select class="form-control select2" name="customer_id" id="customer_id" required>
                                     												<option value="">Selecciona Cliente</option>
                                     											</select>
                                     											<span class="input-group-btn">
                                     												<button class="btn btn-default btn-sm" type="button" data-toggle="modal" id="nuevo_cliente" data-target="#cliente_modal"><i class='fa fa-plus'></i> Nuevo</button>
                                     											</span>
                                     </div>

                                   </div>

                                   <div class="col-md-2">
                                     <label for="segundonombre">Fecha</label>
                                     <div class="input-group">
                                            <input type="text" class="form-control input-sm datepicker" name="purchase_date"  value="<?php
                                            date_default_timezone_set("America/Managua");
                                            echo date('d-m-Y');
                                            ?>" disabled="">

                                            <div class="input-group-addon">
                                                <a href="#"><i class="fa fa-calendar"></i></a>
                                            </div>
                                        </div>
                                   </div>

                                   <div class="col-md-2">
                                     <label for="primerapellido">Factura N°</label>
                                     <input type="text" class="form-control input-sm" name="sale_number" id="sale_number" readonly required value="<?php echo fn_generar_factura(conexion_bd(1)) ?>">
                                   </div>



                                   <div class="col-md-2">
                                     <label for="segundoapellido">Agregar productos</label>
                                     <button type="button" id="addproduct" class="btn btn-block btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class='fa fa-search'></i>Buscar productos</button>
                                   </div>
                               </div>

                             </li>

                              <li class="list-group-item">
                                <div class="row">

                                  <div class="col-md-3">

                                   <div class="form-inline form-group">
                                   <label for="tipfactura">Tipo de factura:</label>
                                   <?php

                                   $cn =  conexion_bd(1);

                                   $perfil = $_SESSION["intidperfil"];

                                   $row_permiso = pg_fetch_array(pg_query($cn,"SELECT bolactivo
                                                                               from public.tblcatperfilusrfrmdetalle
                                                                               where idfrmdetalle = 6 and idperfil =  $perfil"));
                                   ?>
                                   <select class="form-control" id="cmbtipo_factura" <?php if($row_permiso['bolactivo'] == 'f') echo 'disabled'; ?> name="cmbtipo_factura" placeholder='Contado o Credito'>
                                   <?php echo fill_tipofactura(conexion_bd(1),'factura','CONTADO','form-control'); ?>
                                   </select>
                                    </div>

                                  </div>

                                  <div class="col-md-4">

                                     <div class="form-inline form-group">
                                     <label for="tipcambio">Tipo cambio $ : </label>
                                     <input class="form-control" readonly name="valor_tasa_cambio" id="valor_tasa_cambio" value="<?php echo tasa_cambio($con)?>" />
                                    </div>

                                  </div>

                                </div>

                              </li>

                        </form>

                             <li class="list-group-item">

                                <form role="form" name="grabar_producto" id="grabar_producto"  method="post">
                                       <div class="row">
                                         <div class="col-md-4">
        											                 <input class='form-control' type='number' name='cantidad_codbarra' id='cantidad_codbarra'  value='1' required>
        										              </div>

                                          <div class="col-md-6">
                            											<div class="input-group">
                            													<input class='form-control' type='text' name='codigobarra_producto' id='codigobarra_producto' required placeholder="Ingresa el código del producto">
                            													<span class="input-group-btn">
                            														<button class="btn btn-default" type="submit" ><i class='fa fa-barcode'></i> </button>
                            													</span>
                            											</div>
        										               </div>

                                       </div>

                                  </form>

                             </li>

                             <li class="list-group-item">

                               <div class="row">

                               <div class="col-md-12">

                               <div id="loader_det" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
                               <div class="outer_div_det"></div><!-- Datos ajax Final -->

                             </div>

                               </div>


                             </li>

                          </ul>





                       </div>
                       <div class="panel-footer">
                                <p>Verifique lo facturado antes de guardar e imprimir, no se aceptan devoluciones.</p>
                       </div>
                   </div>
               </div>
</div>



            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <!-- Modal agregar clientes-->
<form role="form" name="crear_cliente" id="crear_cliente"  method="post">
    <div class="modal fade" id="cliente_modal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Nuevo Cliente</h4>
          </div>
          <div class="modal-body">

            <ul class="nav nav-tabs">
<li class="active"><a data-toggle="tab" href="#home">Cliente</a></li>
<li><a data-toggle="tab" href="#menu1">Contacto</a></li>
<li><a data-toggle="tab" href="#menu2">Fotografía</a></li>
</ul>

<div class="tab-content">
<div id="home" class="tab-pane fade in active">

<br>
<div class="form-group">

  	<input type="text" name="txtcodcliente" id="txtcodcliente"  value="<?php // echo time(); ?>" class="form-control" readonly/>

</div>

  <div class="form-group">

    <input type="text" name="txtpnombre" id="txtpnombre" class="form-control" required data-rule-minlength="4" placeholder="Primer nombre" maxlength="30">

  </div>

  <div class="form-group">

    <input type="text" name="txtsnombre" id="txtsnombre" class="form-control" data-rule-required="true" data-rule-minlength="4" placeholder="Segundo nombre" maxlength="30">

  </div>

  <div class="form-group">

    <input type="text" name="txtpapellido" id="txtpapellido" class="form-control" required data-rule-minlength="4" placeholder="Primer apellido" maxlength="30">

  </div>

  <div class="form-group">
  <!--  <label for="lblsnombre" class="control-label">Segundo apellido :</label> -->
    <input type="text" name="txtsapellido" id="txtsapellido" class="form-control" data-rule-minlength="4" placeholder="Segundo apellido" maxlength="30">

  </div>

  <div class="input-group">
         <input type="date" class="form-control datepicker" name="txtfechanac">

         <div class="input-group-addon">
             <a href="#"><i class="fa fa-calendar"> Fecha de nacimiento</i></a>
         </div>
  </div>

  <br>

  <div class="form-group">
  <!--  <label for="lblsnombre" class="control-label">Segundo apellido :</label> -->
    <input type="text" name="txtidentificacion" id="txtidentificacion" class="form-control"  data-rule-minlength="4" placeholder="Identificación" maxlength="30">

  </div>

  <div class="form-group">
  <!--  <label for="lblsexo" class="control-label">Sexo :</label> -->
    <select class="form-control" id="cmbsexo" name="cmbsexo" placeholder="sexo" required>
              <option value="">Seleccione sexo</option>
                <option value="MASCULINO">MASCULINO</option>
                <option value="FEMENINO">FEMENINO</option>
    </select>

  </div>

  <div class="form-group">
    <textarea class="form-control text-uppercase font-italic" id="txtdireccion" name="txtdireccion" text="arial-label" placeholder="Dirección"></textarea>
  </div>

</div>
<div id="menu1" class="tab-pane fade">

<br>

  <div class="form-group">
  <!--  <label for="lblpnombre" class="control-label">Primer nombre :</label> -->
    <input type="email" name="txtcorreo" id="txtcorreo" class="form-control" data-rule-minlength="4" placeholder="correo / email" maxlength="30">

  </div>

  <div class="form-group">
  <!--  <label for="lblsnombre" class="control-label">Segundo nombre :</label> -->
    <input type="text" name="txttelefono" id="txttelefono" class="form-control" data-rule-minlength="4" placeholder="Telefono" maxlength="30">

  </div>

  <div class="form-group">
  <!--  <label for="lblpnombre" class="control-label">Primer apellido :</label> -->
    <input type="text" name="txtcontacto" id="txtcontacto" class="form-control"  data-rule-minlength="4" placeholder="Contacto en caso de emergencia" maxlength="30">

  </div>

  <div class="form-group">
  <!--  <label for="lblsnombre" class="control-label">Segundo apellido :</label> -->
    <input type="text" name="txtaltura" id="txtaltura" class="form-control"  value="0" data-rule-minlength="4" placeholder="Altura" maxlength="30">

  </div>

  <div class="form-group">
  <!--  <label for="lblsnombre" class="control-label">Segundo apellido :</label> -->
    <input type="text" name="txtpeso" id="txtpeso" class="form-control" value="0"  data-rule-minlength="4" placeholder="Peso" maxlength="30">

  </div>

  <div class="form-group">
  <!--  <label for="lblsexo" class="control-label">Sexo :</label> -->
  <input type="text" name="txtgymanterior" id="txtgymanterior" class="form-control"  data-rule-minlength="4" placeholder="Gimnasio anterior" maxlength="30">

  </div>

  <div class="form-group">
  <!--  <label for="lblsexo" class="control-label">Sexo :</label> -->
  <input type="text" name="txtanioentrenando" id="txtanioentrenando" value="0" class="form-control" data-rule-minlength="4" placeholder="Tiempo entrenado" maxlength="30">

  </div>

</div>
<div id="menu2" class="tab-pane fade">
<br>


<div class="i-am-centered">
<div class="row">
    <div class="col-md-12 mb-3">
          <h4>Selecciona un dispositivo para tomar la fotografia</h4>
        	<div>

        		<select name="listaDeDispositivos" id="listaDeDispositivos"></select>
            <br>
        	<!--	  <button id="boton" class="btn btn-info">Tomar foto</button> -->
        		<p id="estado"></p>

        	</div>
        	<br>
        	<video muted="muted" id="video" width="300" class="take_photo" ></video>
          <button type="submit" class="btn btn_info take_photo"  id="boton">Tomar foto</button>
        	<canvas id="canvas" style="display: none;"></canvas>
  </div>
</div>
</div>



</div>
</div>


          </div>

          <div class="modal-footer">
            <button type="submit" id="guardar_datos_cliente" name="guardar_datos_cliente" class="btn btn-info right">Registrar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>


      </div>
    </div>
    </form>


    <!-- Modal agregar producto-->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Buscar productos</h4>
          </div>
          <div class="modal-body">


                  <div id="loader" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
                  <div class="outer_div" ></div><!-- Datos ajax Final -->

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>

      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel"><font>¿Desea eliminar el producto de la factura?</font></h4>
          </div>

          <div class="modal-body">


                   <div class="form-group">
                       <input type="hidden" class="form-control" id="idfila" name="idfila"/>
                   </div>
                   <input type="submit" name="btnelimina" id="btnelimina" value="Eliminar" class="btn btn-danger"/>


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
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

  <script type="text/javascript" src="../vendor/datatables/js_/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
  <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

  <!-- jquery para plugin datatable permite exportar a excel, csv, pdf  -->
  <!-- <script type="text/javascript" src="../vendor/jquery/exp/jquery-1.12.4.js"></script> -->

  <script type="text/javascript" src="../vendor/datatables/js/dataTables.fixedColumns.min.js"></script>

  <script src="../vendor/bootstrap/js/select2.full.min.js"></script>
    <!-- Bootstrap select whit search live -->
  <script src="../vendor/bootstrap/js/bootstrap-multiselect.js"></script>


<script src="../js/VentanaCentrada.js"></script>


<script type="text/javascript">


function time() {
    var timestamp = Math.floor(new Date().getTime() / 1000)
    return timestamp;
}

/*GUARDA LA NOTA DE CREDITO*/
$('#nuevo_cliente').click(function(){
   $('#txtcodcliente').val( time() );
});

$(document).ready(function() {
    $( ".select2" ).select2({
    ajax: {
        url: "fnclientes.php",
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

<script>
function format_table(){
  var mytable = $('#mitabla').DataTable({
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
}

function format_table_det(){
  var mytabledet = $('#mitabladet').DataTable({
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
}

 function load(idcontrato){
   $("#loader").fadeIn('slow');
  // var sysfacturador = $("#sisfacturador").val();

   $.ajax({
      url:"fnclientes.php?modalproducto="+idcontrato,
      beforeSend: function(objeto){
      $('#loader').html('<img src="../img/ajax-loader.gif" alt="loading"/> Cargando...');
     },
     success:function(data){
       $(".outer_div").html(data).fadeIn('slow');
       $('#loader').html('');
         format_table();
     }
   })
 }

 function load_det(codcliente){
   $("#loader_det").fadeIn('slow');
  // var sysfacturador = $("#sisfacturador").val();
  // var descuentofact_ = document.querySelector("#cmbdescuento_factura").value;
  // var impuestofact_ = document.querySelector("#cmbimpuesto_factura").value;

   $.ajax({
      url:"fnventa.php?cod="+codcliente,
      beforeSend: function(objeto){
      $('#loader_det').html('<img src="../img/ajax-loader.gif" alt="loading"/> Cargando...');
     },
     success:function(data){
       $(".outer_div_det").html(data).fadeIn('slow');
       $('#loader_det').html('');
      format_table_det();
     }
   })
 }

 load_det(1);
 format_table_det();

 /*SE EJECUTAR AL DAR CLIC AL BOTON AGREGAR FACTURAS*/
 $('#addproduct').click(function(){
        load(1);
  })

$( "#crear_cliente" ).submit(function( event ) {

$('#guardar_datos_cliente').attr("disabled", true);
var parametros = $(this).serialize();
 $.ajax({
    type: "POST",
    url: "fnclientes.php",
    data: parametros,
     beforeSend: function(objeto){
      $("#resultados_ajax").html("Enviando...");
      },
    success: function(datos){
    $("#resultados_ajax").html(datos);
    $('#guardar_datos_cliente').attr("disabled", false);
    //load(1);
    window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
    $(this).remove();});}, 5000);
    $('#cliente_modal').modal('hide');
    }
});
event.preventDefault();

})

function agregar (id)
  {
    var producto_=document.querySelector("#producto_"+id).value;
    var nombreproducto_=document.querySelector("#nombre_"+id).value;
    var precioventa_=document.querySelector("#precio_"+id).value;
    var precio_costo_=document.querySelector("#precio_costo_"+id).value;
    var descuento_=document.querySelector("#cmbdescuento_"+id).value;
    var cantidad_=document.querySelector("#cantidad_"+id).value;

    var descuentofact_ = document.querySelector("#cmbdescuento_factura").value;

    var impuestofact_ = document.querySelector("#cmbimpuesto_factura").value;

    console.log("impuesto es: "+impuestofact_);
    console.log("descuento es: "+descuentofact_);
    //Inicia validacion
    if (cantidad_.length <= 0)
    {
    alert('Esto no es un numero');
    document.getElementById('#cantidad_'+id).focus();
    return false;
    }

    //Fin validacion

    $.ajax({
      type: "POST",
      url: "fnclientes.php",
      data: "producto="+producto_+"&precioventa="+precioventa_+"&cantidad="+cantidad_+"&nombreproducto="+nombreproducto_+"&descuento="+descuento_+"&descuentofact="+descuentofact_+"&impuestofact="+impuestofact_+"&precio_costo="+precio_costo_,
   beforeSend: function(objeto){
    $("#resultados").html("Mensaje: Cargando...");
    },
      success: function(datos){
  //$("#resultados").html(datos);
   $(".outer_div_det").html(datos).fadeIn('slow');
  }
    });

  }

    $( "#grabar_producto" ).submit(function( event ) {

      var producto_cantidad_=document.querySelector("#cantidad_codbarra").value;
      var codigobarra_producto_=document.querySelector("#codigobarra_producto").value;

      var descuentofact_ = document.querySelector("#cmbdescuento_factura").value;
      var impuestofact_ = document.querySelector("#cmbimpuesto_factura").value;

      //Inicia validacion
      if (isNaN(producto_cantidad_))
      {
      alert('Esto no es un numero');
      document.getElementById('#cantidad_codbarra').focus();
      return false;
      }
      if (isNaN(codigobarra_producto_))
      {
      alert('Esto no es un numero');
      document.getElementById('#codigobarra_producto').focus();
      return false;
      }

      //Fin validacion

      $.ajax({
        type: "POST",
        url: "fnventa.php",
        data: "producto_cantidad="+producto_cantidad_+"&codigobarra_producto="+codigobarra_producto_+"&descuentofact="+descuentofact_+"&impuestofact="+impuestofact_,
     beforeSend: function(objeto){
      $("#resultados").html("Mensaje: Cargando...");
      },
        success: function(datos){
    //$("#resultados").html(datos);
     $(".outer_div_det").html(datos).fadeIn('slow');
     $("#codigobarra_producto").val('');
    }
      });


    event.preventDefault();
    })

    $(document).on('click', '.delete_data', function(){

         var fila_id = $(this).attr("id");
         $('#idfila').val(fila_id);

         });


        $('#btnelimina').click(function(){

             var fila_id_ =document.querySelector("#idfila").value;

             $.ajax({
               type: "POST",
               url: "fnventa.php",
               data: "idfila="+fila_id_,
            beforeSend: function(objeto){
             $("#resultados").html("Mensaje: Cargando...");
             },
               success: function(datos){
           //$("#resultados").html(datos);
          //  $(".outer_div_det").html(datos).fadeIn('slow');
          //  $("#codigobarra_producto").val('');
          load_det(1);
        //  format_table_det();
          $('#confirm-delete').modal('hide');
           }
             });

        })

		function tax_value(){

     var descuentosfact_ = document.querySelector("#cmbdescuento_factura").value;
     var impuestosfact_ = document.querySelector("#cmbimpuesto_factura").value;


			$(".outer_div_det" ).load("fnventa.php?impuestos="+impuestosfact_+"&descuentos="+descuentosfact_);


		}

  //  $( "#save_sale" ).submit(function( event ) {

    $('#save_print').click(function(event){
  event.preventDefault();

  var customer_id_ = $("#customer_id").val();
  var neto_factura_ = $("#neto_factura").val();
  var descuento_factura_ = $("#descuento_factura").val();
  var iva_factura_ = $("#iva_factura").val();
  var total_factura_ = $("#total_factura").val();
  var valor_tasa_cambio_ = $("#valor_tasa_cambio").val();

  $('#cmbtipo_factura').removeAttr('disabled');
  var tipo_fac_ = $("#cmbtipo_factura").val();
  var sale_number_ = $("#sale_number").val();
  var cmb_descuento_fact_ = $("#cmbdescuento_factura").val();
  var cmb_impuesto_fact_ = $("#cmbimpuesto_factura").val();

  // Abrir ventana inmediatamente por acción del usuario
  var winFactura = window.open('', 'Nueva factura', 'width=1024,height=768');

  if (!winFactura) {
    alert('Permiso denegado: habilita las ventanas emergentes para este sitio.');
    return;
  }

  winFactura.document.write('<html><head><title>Generando factura...</title></head><body><p>Generando factura...</p></body></html>');

  $.ajax({
    type: "POST",
    url: "nueva_factura.php",
    data: {
      customer_id: customer_id_,
      neto_factura: neto_factura_,
      descuento_factura: descuento_factura_,
      iva_factura: iva_factura_,
      total_factura: total_factura_,
      valor_tasa_cambio: valor_tasa_cambio_,
      cmbtipo_factura: tipo_fac_,
      sale_number: sale_number_,
      cmb_descuento_fact: cmb_descuento_fact_,
      cmb_impuesto_fact: cmb_impuesto_fact_
    },
    beforeSend: function() {
      $("#resultados_ajax").html("Mensaje: Cargando...");
    },
    success: function(datos) {
      datos = $.trim(datos);

      if (!datos) {
        winFactura.document.body.innerHTML = "<p>No se recibió número de factura.</p>";
        return;
      }

      winFactura.location.href = "factura.php?factura=" + encodeURIComponent(datos);

      setTimeout(function() {
        location.reload();
      }, 1000);
    },
    error: function(xhr, status, error) {
      winFactura.document.body.innerHTML = "<p>Error al generar la factura.</p>";
      console.log(xhr.responseText);
      alert('Disculpe, existió un problema');
    }
  });
});
</script>

<script type="text/javascript">

$( "#boton" ).submit(function( event ) {
  event.preventDefault();
});

const tieneSoporteUserMedia = () =>
    !!(navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia)
const _getUserMedia = (...arguments) =>
    (navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia).apply(navigator, arguments);

// Declaramos elementos del DOM
const $video = document.querySelector("#video"),
    $canvas = document.querySelector("#canvas"),
    $estado = document.querySelector("#estado"),
    $boton = document.querySelector("#boton"),
    $listaDeDispositivos = document.querySelector("#listaDeDispositivos");

const limpiarSelect = () => {
    for (let x = $listaDeDispositivos.options.length - 1; x >= 0; x--)
        $listaDeDispositivos.remove(x);
};
const obtenerDispositivos = () => navigator
    .mediaDevices
    .enumerateDevices();

// La función que es llamada después de que ya se dieron los permisos
// Lo que hace es llenar el select con los dispositivos obtenidos
const llenarSelectConDispositivosDisponibles = () => {

    limpiarSelect();
    obtenerDispositivos()
        .then(dispositivos => {
            const dispositivosDeVideo = [];
            dispositivos.forEach(dispositivo => {
                const tipo = dispositivo.kind;
                if (tipo === "videoinput") {
                    dispositivosDeVideo.push(dispositivo);
                }
            });

            // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
            if (dispositivosDeVideo.length > 0) {
                // Llenar el select
                dispositivosDeVideo.forEach(dispositivo => {
                    const option = document.createElement('option');
                    option.value = dispositivo.deviceId;
                    option.text = dispositivo.label;
                    $listaDeDispositivos.appendChild(option);
                });
            }
        });
}



(function() {
    // Comenzamos viendo si tiene soporte, si no, nos detenemos
    if (!tieneSoporteUserMedia()) {
        alert("Lo siento. Tu navegador no soporta esta característica");
        $estado.innerHTML = "Parece que tu navegador no soporta esta característica. Intenta actualizarlo.";
        return;
    }
    //Aquí guardaremos el stream globalmente
    let stream;


    // Comenzamos pidiendo los dispositivos
    obtenerDispositivos()
        .then(dispositivos => {
            // Vamos a filtrarlos y guardar aquí los de vídeo
            const dispositivosDeVideo = [];

            // Recorrer y filtrar
            dispositivos.forEach(function(dispositivo) {
                const tipo = dispositivo.kind;
                if (tipo === "videoinput") {
                    dispositivosDeVideo.push(dispositivo);
                }
            });

            // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
            // y le pasamos el id de dispositivo
            if (dispositivosDeVideo.length > 0) {
                // Mostrar stream con el ID del primer dispositivo, luego el usuario puede cambiar
                mostrarStream(dispositivosDeVideo[0].deviceId);
            }
        });



    const mostrarStream = idDeDispositivo => {
        _getUserMedia({
                video: {
                    // Justo aquí indicamos cuál dispositivo usar
                    deviceId: idDeDispositivo,
                }
            },
            (streamObtenido) => {
                // Aquí ya tenemos permisos, ahora sí llenamos el select,
                // pues si no, no nos daría el nombre de los dispositivos
                llenarSelectConDispositivosDisponibles();

                // Escuchar cuando seleccionen otra opción y entonces llamar a esta función
                $listaDeDispositivos.onchange = () => {
                    // Detener el stream
                    if (stream) {
                        stream.getTracks().forEach(function(track) {
                            track.stop();
                        });
                    }
                    // Mostrar el nuevo stream con el dispositivo seleccionado
                    mostrarStream($listaDeDispositivos.value);
                }

                // Simple asignación
                stream = streamObtenido;

                // Mandamos el stream de la cámara al elemento de vídeo
                $video.srcObject = stream;
                $video.play();

                //Escuchar el click del botón para tomar la foto
                //Escuchar el click del botón para tomar la foto
               $boton.addEventListener("click", function() {

                 //Pausar reproducción
                 $video.pause();

                 //Obtener contexto del canvas y dibujar sobre él
                 let contexto = $canvas.getContext("2d");
                 $canvas.width = $video.videoWidth;
                 $canvas.height = $video.videoHeight;
                 contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);

                 let foto = $canvas.toDataURL(); //Esta es la foto, en base 64
                 $estado.innerHTML = "Enviando foto. Por favor, espera...";
                 fetch("./guardar_foto.php", {
                         method: "POST",
                         body: encodeURIComponent(foto),
                         headers: {
                             "Content-type": "application/x-www-form-urlencoded",
                         }
                     })
                     .then(resultado => {
                         // A los datos los decodificamos como texto plano
                         return resultado.text()
                     })
                     .then(nombreDeLaFoto => {
                         // nombreDeLaFoto trae el nombre de la imagen que le dio PHP
                         console.log("La foto fue enviada correctamente");
                         $estado.innerHTML = `Foto guardada con éxito. Puedes verla <a target='_blank' href='${nombreDeLaFoto}'> aquí</a>`;

                     })

                 //Reanudar reproducción
                 $video.play();

              });

            /*  function fn_take_photo ()
              {

              }*/

              /*  $(document).on('click', '.take_photo', function(){

                });*/

            }, (error) => {
                console.log("Permiso denegado o error: ", error);
                $estado.innerHTML = "No se puede acceder a la cámara, o no diste permiso.";
            });
    }
} ) ();
</script>

</body>

</html>
