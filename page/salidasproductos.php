<?php
require_once 'cn.php';
require_once 'reg.php';

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
              <h3 class="page-header"><i class='fa fa-edit'></i> Salida de productos</h3>
              </section>
              <br/>

              <div id="resultados_ajax"></div>

              <div class="panel panel-primary">
                  <div class="panel-heading">
                      Registrar detalle de la salida
                  </div>
                  <div class="panel-body">

                    <form name="salida_producto" id="salida_producto" method="post">
                    <div class="row">

                       <div class="col-md-4 mb-3">

                         <label for="lblcliente">Cliente</label>
                         <select class="form-control select2" name="customer_id" id="customer_id" required>
                           <option value="">Selecciona Cliente</option>
                         </select>

                       </div>

                       <div class="col-md-4 mb-3">

                         <label for="lblcliente">Producto</label>
                         <select class="form-control select2 select_producto" name="producto" id="producto" required>
                           <option value="">Selecciona Producto</option>
                         </select>

                       </div>

                       <div class="col-md-4 mb-3">
                               <label for="lblfecha">Existencia</label>
                               <input type="number" class="form-control input-sm" id="existencia" name="existencia" readonly required>
                       </div>

                    </div>

                    <br>

                    <div class="row">

                            <div class="col-md-4 mb-3">
                                    <label for="lblfecha">Saldo</label>
                                    <input type="number" class="form-control input-sm" id="saldo" name="saldo" readonly>
                            </div>

                             <div class="col-md-4 mb-3">
                                     <label for="lblfecha">Fecha</label>

                                       <div class="input-group">
                                                <input type="date" class="form-control datepicker" name="txtfechanac" value="">
                                                 <div class="input-group-addon">
                                                     <a href="#"><i class="fa fa-calendar"> Fecha</i></a>
                                                 </div>
                                      </div>
                             </div>

                             <div class="col-md-4 mb-3">
                                     <label for="lblfecha">Cantidad</label>
                                     <input type="number" class="form-control input-sm" id="cantidad" name="cantidad" value="">
                             </div>

                    </div>

                    <br>

                    <div class="row ">

                      <div class="col-md-3 mb-3">
                        <label for="lblcosto">Aplica costo</label>
                        <select class="form-control" id="cmbaplicacosto" name="cmbaplicacosto" required>
                                  <option value="">Seleccione</option>
                                    <option value="SI">SI</option>
                                      <option value="NO">NO</option>

                        </select>
                      </div>

                    </div>

                    <br>

                    <div class="row">
                      <div class="col-md-12 mb-3">
                      <label for="comentario">Observación</label>
                      <textarea class="form-control text-uppercase font-italic" id="observacion" name="observacion" text="arial-label"></textarea>
                      </div>
                    </div>

                    <br>

                    <button type="submit" name="btnguardar_salida" id="btnguardar_salida"  class="btn btn-success pull-right guardar_datos"><i class="fa fa-th-large"></i> Guardar datos</button>

                  </form>

                    <br>

                  </div>
                  <div class="panel-footer">

                  </div>
              </div>









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

    <script src="../vendor/bootstrap/js/select2.full.min.js"></script>

    <script src="../vendor/bootstrap/js/bootstrap-multiselect.js"></script>

<script type="text/javascript">

    $(document).ready(function() {

        $('#multi-select-demo').multiselect({
          includeSelectAllOption: true,
          enableFiltering: true,
          filterBehavior: 'value'
          });


    });

</script>

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
            console.log();(data);
            return {
                results: data

            };
        },
        cache: true



    },
    minimumInputLength: 2

})

});

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


$('#producto').change(function()
  {
    var el_producto = $(this).val();

    /*$.post('fnproductos.php', {id_producto: el_producto} ).done(function (respuesta)
     {
       $('#existencia').val(1);
     });*/
     $.ajax({
      url:"fnproductos.php",
      method:"POST",
      data:{id_producto:el_producto},
      dataType:"JSON",
      success:function(data)
      {
         //Quitamos la imagen de carga en el contenedor
         $('#existencia').val(data.existencia);
         $('#saldo').val(data.total);
      }
           })
  });


</script>

<script>

		$( "#salida_producto" ).submit(function( event ) {

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

				window.setTimeout(function() {
				$(".alerta").fadeTo(500, 0).slideUp(500, function(){
				$(this).remove(); location.reload();});}, 5000);

			  }
		});
		  event.preventDefault();
		});
	</script>

</body>

</html>
