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

      .fondo{
        background-color: #E7EEFC;
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
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
<section class="content-header">
<h3 class="page-header"><i class='fa fa-edit'></i> Agregar nueva compra</h3>
</section>

<div id="resultados_ajax"></div>

<div class="row">
<div class="col-md-12 mb-3">
                   <div class="panel panel-default">
                       <div class="panel-heading-custom panel-heading">
                           Nueva compra
                       </div>
                       <div class="panel-body">

                   <form role="form" name="save_sale" id="save_sale" method="post">

                         <div class="panel panel-default">
                           <div class="panel-body">Detalles de la compra <button type="submit" id="purchase_order" name="purchase_order"  class="btn btn-success pull-right "><i class="fa fa-print"></i> Guardar datos</button></div>

                         </div>
                         <ul class="list-group">
                             <li class="list-group-item">

                               <div class="row">
                                   <div class="col-md-5">
                                    <label for="segundonombre">Proveedor</label>
                                    <div class="input-group">
                                                         <select class="form-control select2" name="proveedor_id" id="proveedor_id" required>
                                                           <option value="">Selecciona Proveedor</option>
                                                         </select>
                                                         <span class="input-group-btn">
                                                           <button class="btn btn-default btn-sm" type="button" data-toggle="modal" id="nuevo_proveedor" data-target="#proveedor_modal"><i class='fa fa-plus'></i> Nuevo</button>
                                                         </span>
                                    </div>

                                   </div>

                                   <div class="col-md-3">
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
                                     <label for="primerapellido">Compra N°</label>
                                      <input type="text" class="form-control input-sm" name="sale_number" id="sale_number" readonly required value="<?php echo fn_generar_factura_compra(conexion_bd(1)) ?>">
                                   </div>

                                   <div class="col-md-2">
                                     <label for="segundoapellido">Agregar productos</label>
                                     <button type="button" id="addproduct" class="btn btn-block btn-info" data-toggle="modal" data-target="#myModal"><i class='fa fa-search'></i> Buscar productos</button>
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
                                                                              where idfrmdetalle = 7 and idperfil =  $perfil"));
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

                               <hr>
                               <form role="form" name="grabar_producto" id="grabar_producto"  method="post">
                                      <div class="row">
                                        <div class="col-md-4">
                                              <input class='form-control' type='number' name='cantidad_codbarra' id='cantidad_codbarra'  value='1' required>
                                         </div>

                                         <div class="col-md-6">
                                                 <div class="input-group">
                                                     <input class='form-control' type='text' name='codigobarra_producto' id='codigobarra_producto' required placeholder="Ingresa el código de producto">
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
                              <p>Verifique lo facturado antes de guardar e imprimir.</p>
                       </div>
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
    <form role="form" name="crear_proveedor" id="crear_proveedor"  method="post">
    <div class="modal fade" id="proveedor_modal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Nuevo proveedor</h4>
          </div>
          <div class="modal-body">

            <ul class="nav nav-tabs">
<li class="active"><a data-toggle="tab" href="#home">Proveedor</a></li>
</ul>

<div class="tab-content">
<div id="home" class="tab-pane fade in active">

<br>
<div class="form-group">
       <input type="text" name="txtstrnombre_vendedor" id="txtstrnombre_vendedor" class="form-control" required data-rule-minlength="4" placeholder="Nombre del vendedor" maxlength="30">

</div>

  <div class="form-group">


      <input type="text" name="txtstrtelefono_vendedor" id="txtstrtelefono_vendedor" class="form-control"  data-rule-minlength="4" placeholder="Telefono del Vendedor" maxlength="30">
  </div>

  <div class="form-group">

      <input type="text" name="txtstrcorreo_vendedor" id="txtstrcorreo_vendedor" class="form-control" data-rule-minlength="4" placeholder="Correo del vendedor" maxlength="30">


  </div>

  <div class="form-group">
    <input type="text" name="txtstrnombre_empresa" id="txtstrnombre_empresa" class="form-control" placeholder="Nombre de la empresa" />


  </div>

  <div class="form-group">
      <input type="text" name="txtstrtelefono_empresa" id="txtstrtelefono_empresa" class="form-control"  data-rule-minlength="4" placeholder="Telefono de la empresa" maxlength="30">


  </div>

  <div class="form-group">
      <input type="text" name="txtstrsitioweb_empresa" id="txtstrsitioweb_empresa" class="form-control"  data-rule-minlength="4" placeholder="Sitio web de la empresa" maxlength="30">


  </div>

  <br>

  <div class="form-group">
    <textarea class="form-control text-uppercase font-italic" id="txtstrdirreccion_empresa" name="txtstrdirreccion_empresa" text="arial-label" placeholder="Dirección"></textarea>
  </div>

</div>

</div>



          </div>
          <div class="modal-footer">
            <button type="submit" id="guardar_datos_proveedor" name="guardar_datos_proveedor" class="btn btn-info right">Registrar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

  </form>


    <!-- Modal agregar productos-->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog" style="width:1000px;">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Buscar productos</h4>
          </div>
          <div class="modal-body">


                  <div id="loader" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->

                  <div class="outer_div"></div><!-- Datos ajax Final -->
                  <br>

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
            <h4 class="modal-title" id="myModalLabel"><font>¿Desea eliminar el producto de la compra?</font></h4>
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

function format_table(){

  /*$.fn.DataTable.tables( {visible: true, api: true} ).columns.adjust();*/

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

$(document).ready(function() {
    $( ".select2" ).select2({
    ajax: {
        url: "fnproveedores.php",
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

function load(idcontrato){
  $("#loader").fadeIn('slow');
 // var sysfacturador = $("#sisfacturador").val();

  $.ajax({
     url:"fnproveedores.php?modalproducto="+idcontrato,
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
     url:"fncompra.php?cod="+codcliente,
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

$( "#crear_proveedor" ).submit(function( event ) {

$('#guardar_datos_proveedor').attr("disabled", true);
var parametros = $(this).serialize();
 $.ajax({
    type: "POST",
    url: "fnproveedores.php",
    data: parametros,
     beforeSend: function(objeto){
      $("#resultados_ajax").html("Enviando...");
      },
    success: function(datos){
    $("#resultados_ajax").html(datos);
    $('#guardar_datos_proveedor').attr("disabled", false);
    //load(1);
    window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
    $(this).remove();});}, 5000);
    $('#proveedor_modal').modal('hide');
    }
});
event.preventDefault();

})

/*SE EJECUTAR AL DAR CLIC AL BOTON AGREGAR FACTURAS*/
$('#addproduct').click(function(){
       load(1);
 })

 function agregar (id)
   {
     var producto_=document.querySelector("#producto_"+id).value;
     var nombreproducto_=document.querySelector("#nombre_"+id).value;
     var precioventa_=document.querySelector("#precio_"+id).value;
    // var descuento_=document.querySelector("#cmbdescuento_"+id).value;
     var cantidad_=document.querySelector("#cantidad_"+id).value;

     var cantidad_bonificado_ =document.querySelector("#cantidad_bonif_"+id).value;

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
       url: "fnproveedores.php",
       data: "producto="+producto_+"&precioventa="+precioventa_+"&cantidad="+cantidad_+"&nombreproducto="+nombreproducto_+"&descuentofact="+descuentofact_+"&impuestofact="+impuestofact_+"&cant_bonificado="+cantidad_bonificado_,
    beforeSend: function(objeto){
     $("#resultados").html("Mensaje: Cargando...");
     },
       success: function(datos){
   //$("#resultados").html(datos);
    $(".outer_div_det").html(datos).fadeIn('slow');
   }
     });

   }

   $(document).on('click', '.delete_data', function(){

        var fila_id = $(this).attr("id");
        $('#idfila').val(fila_id);

        });


       $('#btnelimina').click(function(){

            var fila_id_ =document.querySelector("#idfila").value;

            $.ajax({
              type: "POST",
              url: "fncompra.php",
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
           url: "fncompra.php",
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

       $('#purchase_order').click(function(event){

   			var proveedor_id_ = $("#proveedor_id").val();
         var neto_factura_ = $("#neto_factura").val();
         var descuento_factura_ =  $("#descuento_factura").val();
         var iva_factura_ =  $("#iva_factura").val();
         var total_factura_ =  $("#total_factura").val();
         var valor_tasa_cambio_ =  $("#valor_tasa_cambio").val();
         $('#cmbtipo_factura').removeAttr('disabled');
         var tipo_fac_ = $("#cmbtipo_factura").val();
         var sale_number_ = $("#sale_number").val();


         $.ajax({
           type: "POST",
           url: "nueva_factura_comp.php",
           data: {proveedor_id:proveedor_id_, neto_factura:neto_factura_, descuento_factura:descuento_factura_, iva_factura:iva_factura_, total_factura:total_factura_, valor_tasa_cambio:valor_tasa_cambio_, cmbtipo_factura:tipo_fac_, sale_number:sale_number_} ,
        beforeSend: function(objeto){

         $("#resultados").html("Mensaje: Cargando...");

         },
       success: function(datos){

          //VentanaCentrada('imprimir_compra.php?factura='+datos,'Nueva factura','','1024','768','true');
          VentanaCentrada('imp_compra.php?factura='+datos,'Nueva factura','','1024','768','true');
          location.reload();

       },
       error : function(xhr, status) {
          alert('Disculpe, existió un problema');
      },
     })

         event.preventDefault();

   		});

</script>

</body>

</html>
