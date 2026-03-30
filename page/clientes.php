<?php
require_once 'cn.php';
require_once 'reg.php';
//require_once 'fnusuario.php';


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

        <?php include 'icon.php' ?>
    <title>Admin Gym</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- css para plugin datatable  -->
		<link rel="stylesheet" type="text/css" href="../vendor/datatables/css_/jquery.dataTables.min.css">

		<link rel="stylesheet" type="text/css" href="../vendor/datatables/css_/buttons.dataTables.min.css">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery-3.3.1.min.js"></script>

    <!--script para cambiar etiquetas a datatable -->
  <script>
         $(document).ready(function(){
           $('#mitabla').DataTable({
             "fixedColumns":   {
                                "leftColumns": 1
                               },
             "order": [[1, "asc"]],
             "dom":'Bfrtip',
             "buttons": ['copy','csv','excel','pdf','print'],
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
         });
</script>


<style type="text/css">
table.dataTable thead tr {
  background-color: grey;
  color: #ffffff;
}
</style>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

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

              <h4 class="page-header  mb-3 text-center">Listado de clientes</h4>

              <br>

              <div id="resultados_ajax"></div>

              <br>
              <form class="needs-validation" method="post" action="">
                 <!-- Primera linea de campos en el fromulario-->
                <br>
                <div class="row">
                      <div class="col-md-4">
                         <a class="btn btn-primary" data-toggle="modal" id="nuevo_cliente" data-target="#cliente_modal" role="button"><i class='fa fa-plus'></i> Nuevo cliente</a>
                      </div>
                </div>
              		<br>
              </form>
          <br>
          <div class="row">
            <?php

            $cn =  conexion_bd(1);

             $sql = "SELECT intidcliente, bigcodcliente, concat(strpnombre::TEXT,' ',strsnombre::TEXT,' ',strpapellido::TEXT,' ',strsapellido::TEXT) nombre,
                     strsexo, stridentificacion, strcorreo, strtelefono, strcontacto, strfechadenacimiento, intaltura, intpeso, strgymanterior, strimagen,
                     strdireccion
                     from public.tblcatclientes;";

             $resul = pg_query($cn,$sql);

             $retorno = "<div class='row table-responsive'>
                            <table class='display nowrap stripe row-border order-column' id='mitabla' style='width:100%'>
                        <thead>
                        <tr>
                        <th><p class='small'><strong>Registro</strong></p></th>
                        <th><p class='small'><strong>Acciones</strong></p></th>
                        <th><p class='small'><strong>codigo</strong></p></th>
                        <th><p class='small'><strong>Foto</strong></p></th>

                        <th><p class='small'><strong>cliente</strong></p></th>
                        <th><p class='small'><strong>Identificación</strong></p></th>
                        <th><p class='small'><strong>Teléfono</strong></p></th>
                        <th><p class='small'><strong>Correo</strong></p></th>

                        <th><p class='small'><strong>Sexo</strong></p></th>
                        <th><p class='small'><strong>Dirección</strong></p></th>
                        <th><p class='small'><strong>Contacto</strong></p></th>
                        <th><p class='small'><strong>Fecha de nacimiento</strong></p></th>

                        </tr>
                        </thead>
                        <tbody>";
              while ($row = pg_fetch_array($resul)){

                $img = "";
                if( strlen($row['strimagen']) > 0)
                      {  $img = $row['strimagen']; }
               else {
                        if( $row['strsexo'] == 'MASCULINO')
                              {   $img = '../img/img_avatar.png';  }
                        else{ $img =  '../img/img_avatar2.png'; }
                     }

                    $retorno = $retorno."<tr>
                                         <td><p class='small'>".$row["intidcliente"]."</p></td>
                                         <td class='text-right'>
                                         <div class='dropdown dropdown-action show'>
                                             <button class='btn btn-default dropdown-toggle' type='button' data-toggle='dropdown'>
                                             <i class='fa fa-ellipsis-v'></i>
                                              <span class='caret'></span></button>
                                              <ul class='dropdown-menu'>
                                                <li><a href='editar_cliente.php?codigo=".base64_encode($row["intidcliente"])."'>Editar</a></li>
                                                <li><a href='#''>Eliminar</a></li>
                                              </ul>
                                            </div>
                                         </td>
                                         <td><p class='small'>".$row["bigcodcliente"]."</p></td>
                                         <td><a href='".$img."' target='_blank'><img src='".$img."'  width='50' height='50'></a></td>

                                         <td><p class='small'><i class='fa fa-user'></i>".$row["nombre"]."</td>
                                         <td><p class='small'>".$row["stridentificacion"]."</p></td>
                                         <td><p class='small'>".$row["strtelefono"]."</p></td>
                                         <td><p class='small'>".$row["strcorreo"]."</p></td>

                                         <td><p class='small'>".$row["strsexo"]."</p></td>
                                         <td><p class='small'>".$row["strdireccion"]."</p></td>
                                         <td><p class='small'>".$row["strcontacto"]."</p></td>
                                         <td><p class='small'>".$row["strfechadenacimiento"]."</p></td>




                                         </tr>";}
                    $retorno = $retorno."</tbody>
                                         </table>
                                         </div>";

                    echo $retorno;
             ?>
        <br>
          </div>

      <!-- Boton fuera de formulario para retornar al index -->

    <!--  <div class="row">

      <div class="col-md-4">
      <a href="colaboradores.php" class="btn btn-info" role="button">Regresar</a>
      </div>

      </div> -->

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>


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
         <input type="date" class="form-control datepicker" required name="txtfechanac">

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
    <input type="text" name="txttelefono" id="txttelefono" class="form-control" required data-rule-minlength="4" placeholder="Telefono" maxlength="30">

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
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>


      </div>
    </div>
    </form>

    <!-- /#wrapper -->
    <footer class="my-5 pt-5 text-muted text-center text-small">
      <p class="mb-1">&copy;<?php echo date("Y")-1; ?>-<?php echo date("Y"); ?> GYM</p>
      <ul class="list-inline">
        <li class="list-inline-item"><a href="index.php">Inicio</a></li>
       </ul>
    </footer>

    <script>

    $(document).ready(function(){

      $(document).on('click', '.edit_data', function(){

           var employee_id = $(this).attr("id");
           $('#idempleado').val(employee_id);
           });

           function time() {
               var timestamp = Math.floor(new Date().getTime() / 1000)
               return timestamp;
           }

           $('#nuevo_cliente').click(function(){
              $('#txtcodcliente').val( time() );
           });

      });

		</script>
    <script>
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


    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- jquery para plugin datatable permite exportar a excel, csv, pdf  -->
    <!-- <script type="text/javascript" src="../vendor/jquery/exp/jquery-1.12.4.js"></script> -->
    <script type="text/javascript" src="../vendor/datatables/js_/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../vendor/datatables/js/dataTables.fixedColumns.min.js"></script>

    <script type="text/javascript" src="../vendor/jquery/exp/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/buttons.flash.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/jszip.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/pdfmake.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/vfs_fonts.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/buttons.html5.min.js"></script>
    <script type="text/javascript" src="../vendor/jquery/exp/buttons.print.min.js"></script>


</body>

</html>
