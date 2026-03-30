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
              <h3 class="page-header"><i class='fa fa-edit'></i> Configuración General</h3>
              </section>
              <br/>
              <div id="resultados_ajax"></div>
              <br/>

              <div class="panel panel-primary">
                  <div class="panel-heading">
                      Cargar imagen de inicio de sesión
                  </div>
                  <div class="panel-body">
                   <form name="cargar_img_sesion" id="cargar_img_sesion" method="post" enctype="multipart/form-data">
                    <br>
                    <div class="row">
                      <div class="col-md-12 mb-3">
                            <label for="lblimgproducto">Subir imagen de inicio de sesión</label>
                            <span class="bt-primary">
                            <input type="file" class="form-control-file" id="imginicio_sesion" name="imginicio_sesion" accept="image/jpeg,image/jpeg,image/png">
                            </span>
                            <small class="text-muted">En este campo puedes subir o enviar la imagen de la pantalla de inicio de sesión.</small>
                      </div>
                    </div>
                    <button type="submit" name="btnguardar_1" id="btnguardar_1"  class="btn btn-success pull-right guardar_datos"><i class="fa fa-th-large"></i> Guardar datos</button>
                  </form>
                    <br>
                  </div>
                  <div class="panel-footer">
                  </div>
              </div>

              <div class="panel panel-primary">
                  <div class="panel-heading">
                      Cargar imagen de encabezado de pagina
                  </div>
                  <div class="panel-body">
                   <form name="cargar_img_paginas" id="cargar_img_paginas" method="post" enctype="multipart/form-data">
                    <br>
                    <div class="row">
                      <div class="col-md-12 mb-3">
                            <label for="lblimgproducto">Subir de encabezado de pagina</label>
                            <span class="bt-primary">
                            <input type="file" class="form-control-file" id="img_encabezado" name="img_encabezado" accept="image/jpeg,image/jpeg,image/png">
                            </span>
                            <small id="fileHelp" class="text-muted">En este campo puedes subir o enviar la imagen que se visualiza en cada pantalla como encabezado.</small>
                      </div>
                    </div>
                    <button type="submit" name="btnguardar_2" id="btnguardar_2"  class="btn btn-success pull-right guardar_datos"><i class="fa fa-th-large"></i> Guardar datos</button>
                  </form>
                    <br>
                  </div>
                  <div class="panel-footer">
                  </div>
              </div>

              <div class="panel panel-primary">
                  <div class="panel-heading">
                      Cargar imagen de inicio
                  </div>
                  <div class="panel-body">
                   <form name="cargar_img_inicio" id="cargar_img_inicio" method="post" enctype="multipart/form-data">
                    <br>
                    <div class="row">
                      <div class="col-md-12 mb-3">
                            <label for="lblimgproducto">Subir imagen de pantalla de inicio</label>
                            <span class="bt-primary">
                            <input type="file" class="form-control-file" id="img_inicio" name="img_inicio" accept="image/jpeg,image/jpeg,image/png">
                            </span>
                            <small id="fileHelp" class="text-muted">En este campo puedes subir o enviar la imagen que en la pantalla de inicio.</small>
                      </div>
                    </div>
                    <button type="submit" name="btnguardar_3" id="btnguardar_3"  class="btn btn-success pull-right guardar_datos"><i class="fa fa-th-large"></i> Guardar datos</button>
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

    <script src="../vendor/bootstrap/js/bootstrap-multiselect.js"></script>

    <script>
        function upload_image()
        {
            $("#resultados_ajax").text('Cargando...');
            $('.btnguardar_1').attr("disabled", true);
            var inputFileImage = document.getElementById("imginicio_sesion");
            var file = inputFileImage.files[0];
            var data = new FormData();
            data.append('imginicio_sesion',file);
            //data.append('txtidproducto',product_id);

            $.ajax({
              url: "fnconfig.php",        // Url to which the request is send
              type: "POST",             // Type of request to be send, called as method
              data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
              contentType: false,       // The content type used when sending data to the server.
              cache: false,             // To unable request pages to be cached
              processData:false,        // To send DOMDocument or non processed data file it is set to false
              success: function(data)   // A function to be called if request succeeds
              {
                $("#resultados_ajax").html("<div class='alert alert-success alert-dismissible alerta'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>¡Exito!</strong> Se cargo la imagen de inicio de sesión con exito.</div>");
                $('.btnguardar_1').attr("disabled", false);
              }
            });

          }

          function upload_image_2()
          {
              $("#resultados_ajax").text('Cargando...');
              $('.btnguardar_2').attr("disabled", true);
              var inputFileImage = document.getElementById("img_encabezado");
              var file = inputFileImage.files[0];
              var data = new FormData();
              data.append('img_encabezado',file);
              //data.append('txtidproducto',product_id);

              $.ajax({
                url: "fnconfig.php",        // Url to which the request is send
                type: "POST",             // Type of request to be send, called as method
                data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,        // To send DOMDocument or non processed data file it is set to false
                success: function(data)   // A function to be called if request succeeds
                {
                  $("#resultados_ajax").html("<div class='alert alert-success alert-dismissible alerta'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>¡Exito!</strong> Se cargo la imagen de enbezado de pagina con exito.</div>");
                  $('.btnguardar_2').attr("disabled", false);
                }
              });

            }

            function upload_image_3()
            {
                $("#resultados_ajax").text('Cargando...');
                $('.btnguardar_3').attr("disabled", true);
                var inputFileImage = document.getElementById("img_inicio");
                var file = inputFileImage.files[0];
                var data = new FormData();
                data.append('img_inicio',file);
                //data.append('txtidproducto',product_id);

                $.ajax({
                  url: "fnconfig.php",        // Url to which the request is send
                  type: "POST",             // Type of request to be send, called as method
                  data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                  contentType: false,       // The content type used when sending data to the server.
                  cache: false,             // To unable request pages to be cached
                  processData:false,        // To send DOMDocument or non processed data file it is set to false
                  success: function(data)   // A function to be called if request succeeds
                  {
                    $("#resultados_ajax").html("<div class='alert alert-success alert-dismissible alerta'><a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>¡Exito!</strong> Se cargo la imagen de pantalla de inicio con exito.</div>");
                    $('.btnguardar_3').attr("disabled", false);
                  }
                });

              }


          $( "#cargar_img_sesion" ).submit(function( event ) {

            upload_image();

            event.preventDefault();
          });

          $( "#cargar_img_paginas" ).submit(function( event ) {

            upload_image_2();

            event.preventDefault();
          });

          $( "#cargar_img_inicio" ).submit(function( event ) {

            upload_image_3();

            event.preventDefault();
          });
        </script>



</body>

</html>
