<?php
require_once 'cn.php';
require_once 'reg.php';
require_once 'fnproductos.php';
require_once 'funciones.php';

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
              <h3 class="page-header"><i class='fa fa-edit'></i> Agregar nuevo producto</h3>
              </section>

            <div id="resultados_ajax"></div>

             <div class="panel panel-primary">
                 <div class="panel-heading">
                     Detalles del producto
                 </div>
                 <div class="panel-body">



                  <form name="crear_producto" id="crear_producto" method="post" enctype="multipart/form-data">

                   <div class="row">

                     <div class="col-md-3 mb-3">
                         <label for="lblnombre">Nombre</label>
                         <input type="text" class="form-control input-sm" name="txtnombreproducto" id="txtnombreproducto" required>
                         <input type="hidden" class="form-control input-sm" name="txtidproducto" id="txtnombreproducto" value="<?php echo fn_num_producto();?>" required>
                     </div>

                     <div class="col-md-3 mb-3">
                         <label for="lblpresentacion">Presentacion</label>
                         <input type="text" class="form-control input-sm" name="txtpresentacion" id="txtpresentacion">
                     </div>

                     <div class="col-md-3 mb-3">
                         <label for="lblpresentacion">Descripción</label>
                         <input type="text" class="form-control input-sm" name="txtdescripcion" id="txtdescripcion" required>
                     </div>

                     <div class="col-md-3 mb-3">
                         <label for="lblpresentacion">Distribuidor / Fabricante</label>
                         <input type="text" class="form-control input-sm" name="txtfabricante" id="txtfabricante">
                     </div>


                   </div>

                   <br>

                   <div class="row">

                     <div class="col-md-3 mb-3">
                         <label for="lbltipoproducto">Tipo de producto</label>
                         <select class="form-control" id="txttipoproducto" name="txttipoproducto" placeholder="Inscripciones, agua, suplementos, etc." required>
                                  <?php echo fill_tipo_producto('N'); ?>
                         </select>
                     </div>

                     <div class="col-md-3 mb-3">
                         <label for="lblcuenta">Clasificacion cuenta</label>
                         <select class="form-control" id="txtcuenta" name="txtcuenta" placeholder="grupo de cuenta de ingresos" required>
                                  <?php echo fill_tipo_ingreso('N'); ?>
                         </select>
                     </div>

                     <div class="col-md-3 mb-3">
                         <label for="lblcosto">Costo</label>
                         <div class="form-group input-group">
                                            <span class="input-group-addon">C$</span>
                         <input type="number" class="form-control input-sm utilidad" name="txtcosto" id="txtcosto" value="0.0" step=".01" placeholder="0.0 C$">
                       </div>
                     </div>

                     <div class="col-md-3 mb-3">
                         <label for="lblprecioventa">Precio de venta</label>
                         <div class="form-group input-group">
                                            <span class="input-group-addon">C$</span>
                           <input type="number" class="form-control input-sm utilidad" name="txtprecioventa" id="txtprecioventa" value="0.0" step=".01"  placeholder="0.0 C$" required>
                         </div>
                     </div>




                   </div>

                   <br>

                   <div class="row">

                     <div class="col-md-3 mb-3">
                         <label for="lblutilidad">Utilidad</label>
                         <div class="form-group input-group">
                                            <span class="input-group-addon">C$</span>
                         <input type="number" class="form-control input-sm" name="txtutilidad" id="txtutilidad" value="0" step=".01" placeholder="0.0 C$" >
                       </div>
                     </div>



                     <div class="col-md-3 mb-3">
                         <label for="lblstock">Stock inicial</label>
                         <input type="number" class="form-control input-sm" name="txtstock" id="txtstock" value="0" placeholder="0">
                     </div>

                     <div class="col-md-3 mb-3">
                         <label for="lblestado">Estado</label>
                         <select class="form-control" id="txtestado" name="txtestado" placeholder="grupo de cuenta de ingresos" required>
                                   <option value="">Seleccione...</option>
                                   <option value="True" selected>Activo</option>
                                   <option value="False">Inactivo</option>
                         </select>
                     </div>

                     <div class="col-md-3 mb-3">
                       <label for="lblcosto">Vigencia</label>
                       <div class="form-group input-group">
                                          <span class="input-group-addon">Dias</span>
                       <input type="number" class="form-control input-sm utilidad" name="txtvigencia" id="txtvigencia" value="0" placeholder="0.0 C$">
                     </div>
                     </div>


                   </div>

                   <div class="row">

                     <div class="col-md-3 mb-3">
                       <label for="lblestado">Control de inventario</label>
                       <select class="form-control" id="txtcontrolinventario" name="txtcontrolinventario" placeholder="grupo de cuenta de ingresos" required>
                                 <option value="">Seleccione...</option>
                                 <option value="True">Control de inventario</option>
                                 <option value="False" selected>Sin control de inventario</option>
                       </select>
                     </div>

                  </div>

                   <br>

                   <div class="row">

                     <div class="col-md-12 mb-3">

                           <label for="lblimgproducto">Subir imagen</label>
                           <span class="bt-primary">
                           <input type="file" class="form-control-file" id="imgproducto" name="imgproducto" onchange="upload_image(<?php echo fn_num_producto(); ?>)" accept="image/jpeg,image/jpeg,image/png">
                           </span>
                           <small id="fileHelp" class="text-muted">En este campo puedes subir o enviar las imagen del producto.</small>

                     </div>

                   </div>

                   <button type="submit" name="btnguardar" id="btnguardar"  class="btn btn-success pull-right guardar_datos"><i class="fa fa-th-large"></i> Guardar datos</button>

                 </form>

                   <br>


                 </div>
                 <div class="panel-footer">

                 </div>
             </div>


             <div class="col-md-4">
             <a href="producto.php" class="btn btn-primary btn-sm" role="button"> < Buscar producto</a>
             </div>

             <br>

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

    <script>
    		function upload_image(product_id)
        {
    				$("#resultados_ajax").text('Cargando...');
    				var inputFileImage = document.getElementById("imgproducto");
    				var file = inputFileImage.files[0];
    				var data = new FormData();
    				data.append('imgproducto',file);
    				data.append('txtidproducto',product_id);


    				$.ajax({
    					url: "fnproductos.php",        // Url to which the request is send
    					type: "POST",             // Type of request to be send, called as method
    					data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
    					contentType: false,       // The content type used when sending data to the server.
    					cache: false,             // To unable request pages to be cached
    					processData:false,        // To send DOMDocument or non processed data file it is set to false
    					success: function(data)   // A function to be called if request succeeds
    					{
    						$("#resultados_ajax").html('Mensaje: Cargando...complete los campos requeridos y de clic al boton guardar datos.');

    					}
    				});

    			}
        </script>

<script>
		$( "#crear_producto" ).submit(function( event ) {
		  $('.guardar_datos').attr("disabled", true);
		  var parametros = $(this).serialize();
		  $.ajax({
				type: "POST",
				url: "fnproductos.php",
				data: parametros,
				 beforeSend: function(objeto){
					$("#resultados_ajax").html("Mensaje: Cargando...");
				  },
				success: function(datos){
				$("#resultados_ajax").html(datos);
				$('.guardar_datos').attr("disabled", false);
				window.setTimeout(function() {
				$(".alerta").fadeTo(500, 0).slideUp(500, function(){
				$(this).remove(); location.reload();});}, 5000);

			  }
		});
		  event.preventDefault();
		});
</script>

  <script>
  $(function(){

    function calcular_utilidad (precio, costo)
    {
        if(isNaN(precio)){ precio = 0}
        if(isNaN(costo)){ costo = 0}

          return Math.round((precio - costo) * 100) / 100;

    }

$('#txtprecioventa').on('keyup',function(){


var precio_ =   parseFloat(document.getElementById("txtprecioventa").value);
var costo_ =    parseFloat(document.getElementById("txtcosto").value);

var valor = calcular_utilidad(precio_,costo_);

//alert(precio_);

 $("#txtutilidad").val(valor);

});

});
  </script>

</body>

</html>
