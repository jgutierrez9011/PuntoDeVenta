<?php
require_once 'cn.php';

$codigo = base64_decode($_GET['codigo']);

$con = conexion_bd(1);
$sql = "SELECT * from tblcatclientes where intidcliente = $codigo";

$result = pg_query($con,$sql);
$row = pg_fetch_array($result);

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
              <h3 class="page-header"><i class='fa fa-edit'></i> Editar cliente</h3>
              </section>

             <div id="resultados_ajax"></div>
             <br>

             <div class="row">

                    <div class="col-md-4 mb-3">

                          <div class="thumbnail">
                            <a href="<?php if(strlen($row['strimagen']) > 0)
                                                   { echo $row['strimagen']; }
                                            else {
                                                    if( $row['strsexo'] == 'MASCULINO')
                                                            {   echo '../img/img_avatar.png';  }
                                                    else{ echo '../img/img_avatar2.png'; }
                                                 }?>" target="_blank">
                              <img src="<?php if(strlen($row['strimagen']) > 0)
                                                     { echo $row['strimagen']; }
                                              else {
                                                      if( $row['strsexo'] == 'MASCULINO')
                                                              {   echo '../img/img_avatar.png';  }
                                                      else{ echo '../img/img_avatar2.png'; }
                                                   }?>" alt="Lights" style="width:100%">
                              <div class="caption">
                                <label for="lblimgproducto">Subir imagen</label>
                                <span class="bt-primary">
                                <input type="file" class="form-control-file" id="imgcliente" name="imgcliente" onchange="upload_image(<?php echo base64_decode($_GET['codigo']) ?>)"  accept="image/jpeg,image/jpeg,image/png">
                                </span>
                                <small id="fileHelp" class="text-muted">En este campo puedes subir o enviar las imagen del producto.</small>
                              </div>
                            </a>
                          </div>

                    </div>

                    <div class="col-md-8 mb-3">


                      <form name="update_register" id="update_register" class="form-horizontal" method="post" enctype="multipart/form-data">

                                  <ul class="nav nav-tabs">
                      <li class="active"><a data-toggle="tab" href="#home">Cliente</a></li>
                      <li><a data-toggle="tab" href="#menu1">Contacto</a></li>
                    <!--  <li><a data-toggle="tab" href="#menu2">Fotografía</a></li> -->
                      </ul>

                      <div class="tab-content">
                      <div id="home" class="tab-pane fade in active">

                      <br>
                      <div class="form-group">

                          <input type="text" name="txtcodcliente_edit" id="txtcodcliente_edit"  value="<?php echo $row['bigcodcliente'] ?>" class="form-control" readonly/>
                          <input type="hidden" name="txtidcliente" id="txtidcliente" value="<?php echo $row['intidcliente'] ?>"/>
                      </div>

                        <div class="form-group">

                          <input type="text" name="txtpnombre_edit" id="txtpnombre_edit" class="form-control" value="<?php echo $row['strpnombre'] ?>" required data-rule-minlength="4" placeholder="Primer nombre" maxlength="30">

                        </div>

                        <div class="form-group">

                          <input type="text" name="txtsnombre" id="txtsnombre" class="form-control" value="<?php echo $row['strsnombre'] ?>" data-rule-minlength="4" placeholder="Segundo nombre" maxlength="30">

                        </div>

                        <div class="form-group">

                          <input type="text" name="txtpapellido" id="txtpapellido" class="form-control" value="<?php echo $row['strpapellido'] ?>" required data-rule-minlength="4" placeholder="Primer apellido" maxlength="30">

                        </div>

                        <div class="form-group">
                        <!--  <label for="lblsnombre" class="control-label">Segundo apellido :</label> -->
                          <input type="text" name="txtsapellido" id="txtsapellido" class="form-control" value="<?php echo $row['strsapellido'] ?>" data-rule-minlength="4" placeholder="Segundo apellido" maxlength="30">

                        </div>

                        <div class="input-group">
                               <input type="date" class="form-control datepicker" name="txtfechanac" value="<?php echo $row['strfechadenacimiento'] ?>">

                               <div class="input-group-addon">
                                   <a href="#"><i class="fa fa-calendar"> Fecha de nacimiento</i></a>
                               </div>
                        </div>

                        <br>

                        <div class="form-group">
                        <!--  <label for="lblsnombre" class="control-label">Segundo apellido :</label> -->
                          <input type="text" name="txtidentificacion" id="txtidentificacion" class="form-control"  value="<?php echo $row['stridentificacion'] ?>" data-rule-minlength="4" placeholder="Identificación" maxlength="30">

                        </div>

                        <div class="form-group">
                        <!--  <label for="lblsexo" class="control-label">Sexo :</label> -->
                          <select class="form-control" id="cmbsexo" name="cmbsexo" placeholder="sexo" required>
                                    <option value="">Seleccione sexo</option>
                                      <option  <?php if($row['strsexo'] == 'MASCULINO') echo 'selected'; ?>>MASCULINO</option>
                                      <option <?php if($row['strsexo'] == 'FEMENINO') echo 'selected'; ?>>FEMENINO</option>
                          </select>

                        </div>

                        <div class="form-group">
                          <textarea class="form-control text-uppercase font-italic" id="txtdireccion" name="txtdireccion" text="arial-label" placeholder="Dirección"><?php echo $row['strdireccion'] ?></textarea>
                        </div>

                      </div>
                      <div id="menu1" class="tab-pane fade">

                      <br>

                        <div class="form-group">
                        <!--  <label for="lblpnombre" class="control-label">Primer nombre :</label> -->
                          <input type="email" name="txtcorreo" id="txtcorreo" class="form-control" value="<?php echo $row['strcorreo'] ?>" data-rule-minlength="4" placeholder="correo / email" maxlength="30">

                        </div>

                        <div class="form-group">
                        <!--  <label for="lblsnombre" class="control-label">Segundo nombre :</label> -->
                          <input type="text" name="txttelefono" id="txttelefono" class="form-control" value="<?php echo $row['strtelefono'] ?>" data-rule-minlength="4" placeholder="Telefono" maxlength="30">

                        </div>

                        <div class="form-group">
                        <!--  <label for="lblpnombre" class="control-label">Primer apellido :</label> -->
                          <input type="text" name="txtcontacto" id="txtcontacto" class="form-control" value="<?php echo $row['strcontacto'] ?>"  data-rule-minlength="4" placeholder="Contacto en caso de emergencia" maxlength="30">

                        </div>

                        <div class="form-group">
                        <!--  <label for="lblsnombre" class="control-label">Segundo apellido :</label> -->
                          <input type="text" name="txtaltura" id="txtaltura" class="form-control" value="<?php echo $row['intaltura'] ?>" data-rule-minlength="4" placeholder="Altura" maxlength="30">

                        </div>

                        <div class="form-group">
                        <!--  <label for="lblsnombre" class="control-label">Segundo apellido :</label> -->
                          <input type="text" name="txtpeso" id="txtpeso" class="form-control" value="<?php echo $row['intpeso'] ?>" data-rule-minlength="4" placeholder="Peso" maxlength="30">

                        </div>

                        <div class="form-group">
                        <!--  <label for="lblsexo" class="control-label">Sexo :</label> -->
                        <input type="text" name="txtgymanterior" id="txtgymanterior" class="form-control" value="<?php echo $row['strgymanterior'] ?>" data-rule-minlength="4" placeholder="Gimnasio anterior" maxlength="30">

                        </div>

                        <div class="form-group">
                        <!--  <label for="lblsexo" class="control-label">Sexo :</label> -->
                        <input type="text" name="txtanioentrenando" id="txtanioentrenando" class="form-control" value="<?php echo $row['intanioentrenando'] ?>" data-rule-minlength="4" placeholder="Tiempo entrenado" maxlength="30">

                        </div>

                        <div class="form-group">
                        <!--  <label for="lblsexo" class="control-label">Sexo :</label> -->
                          <select class="form-control" id="cmbestado" name="cmbestado" placeholder="Estado" required>
                                    <option value="">Seleccione estado</option>
                                      <option  <?php if($row['bolactivo'] == 't') echo 'selected'; ?> Value="true">ACTIIVO</option>
                                      <option <?php if($row['bolactivo'] == 'f') echo 'selected'; ?> Value="false">INACTIVO</option>
                          </select>

                        </div>


                      </div>
                    <!--  <div id="menu2" class="tab-pane fade">
                      <br>

                      <div class="row">

                        <div class="col-md-12 mb-3">



         <div class="container">
           <br>

         <img class="d-block mx-auto mb-4" src="../img/img_avatar.png" alt="" width="92" height="82">
         <h4><b>John Doe</b></h4>
         <p>Architect & Engineer</p>
         <label for="lblimgproducto">Subir imagen</label>
         <span class="bt-primary">
         <input type="file" class="form-control-file" id="imgproducto" name="imgproducto" onchange="upload_image()" accept="image/jpeg,image/jpeg,image/png">
         </span>
         <small id="fileHelp" class="text-muted">En este campo puedes subir o enviar las imagen del producto.</small>
         </div>

                        </div>



                      </div>
                      <br>

                      <div class="row">
                        <div class="col-md-4">
                          <div class="thumbnail">
                            <a href="../img/img_avatar.png">
                              <img src="../img/img_avatar.png" alt="Lights" style="width:100%">
                              <div class="caption">
                                <label for="lblimgproducto">Subir imagen</label>
                                <span class="bt-primary">
                                <input type="file" class="form-control-file" id="imgproducto" name="imgproducto" onchange="upload_image()" accept="image/jpeg,image/jpeg,image/png">
                                </span>
                                <small id="fileHelp" class="text-muted">En este campo puedes subir o enviar las imagen del producto.</small>
                              </div>
                            </a>
                          </div>
                        </div>
                      </div>


                    </div> -->
                      </div>


                                </div>

                                <div class="modal-footer">
                                  <button type="submit" id="guardar_datos_cliente" name="guardar_datos_cliente" class="btn btn-primary">Actualizar</button>
                                  <a class="btn btn-primary" href="clientes.php" role="button">Regresar</a>
                                </div>
                              </div>

                              </form>

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

<script type="text/javascript">

    $(document).ready(function() {

        $('#multi-select-demo').multiselect({
          includeSelectAllOption: true,
          enableFiltering: true,
          filterBehavior: 'value'
          });


    });

</script>
<script>
    function upload_image(product_id){
        $("#resultados_ajax").text('Cargando...');
        var inputFileImage = document.getElementById("imgcliente");
        var file = inputFileImage.files[0];
        var data = new FormData();
        data.append('imgcliente',file);
        data.append('idcliente',product_id);


        $.ajax({
          url: "fnclientes.php",        // Url to which the request is send
          type: "POST",             // Type of request to be send, called as method
          data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
          contentType: false,       // The content type used when sending data to the server.
          cache: false,             // To unable request pages to be cached
          processData:false,        // To send DOMDocument or non processed data file it is set to false
          success: function(data)   // A function to be called if request succeeds
          {
            $("#resultados_ajax").html('Mensaje: Cargando...se completo la actualización de la fotografía.');

          }
        });

      }
</script>
<script>
		$( "#update_register" ).submit(function( event ) {
		  $('.actualizar_datos').attr("disabled", true);
		  var parametros = $(this).serialize();
		  $.ajax({
				type: "POST",
				url: "fnclientes.php",
				data: parametros,
				 beforeSend: function(objeto){
					$("#resultados_ajax").html("Mensaje: Cargando...");
				  },
				success: function(datos){
				$("#resultados_ajax").html(datos);
				$('.actualizar_datos').attr("disabled", false);
				window.setTimeout(function() {
				$(".alert").fadeTo(500, 0).slideUp(500, function(){
				$(this).remove();});}, 5000);
				//generarbarcode();
			  }
		});
		  event.preventDefault();
		});
	</script>

</body>

</html>
