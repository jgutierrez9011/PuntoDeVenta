<?php
require_once 'cn.php';
require_once 'reg.php';
require_once 'funciones/fncontabilidad.php';

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

              <h2 align="left">Nueva tranferencia</h2>
              <br>

              <div id="resultados_ajax"></div>

              <div class="row">
                   <div class="col-md-12">

                     <form method="post" id="add_transfer" name="add_transfer" class="form-horizontal form-label-left">

                                                     <div class="form-group row">
                                                         <label class="col-md-3 col-form-label">Cuenta a debitar <span class="text-danger">*</span></label>
                                                         <div class="col-md-8">
                                                             <select class="form-control select2" name="account_from" data-placeholder="Selecciona Cuenta a debitar" id="account_from" >
                                                                       <?php echo fill_cuenta('N');?>
                                                             </select>
                                                         </div>
                                                     </div>

                                                     <div class="form-group row">
                                                         <label class="col-md-3 col-form-label">Cuenta Destino<span class="text-danger">*</span></label>
                                                         <div class="col-md-8">
                                                             <select class="form-control select2 disable " name="account_to" data-placeholder="Selecciona Cuenta destino" id="account_to" >
                                                                       <?php echo fill_cuenta('N');?>
                                                             </select>
                                                         </div>
                                                     </div>



                                                     <div class="form-group row">
                                                         <label class="col-md-3 col-form-label">Fecha<span class="text-danger">*</span></label>
                                                         <div class="col-md-8">
                                                             <div class="cal-icon">
                                                                      <input class="form-control datetimepicker" type="date" id="date"  name="date" value="<?php
                                                                      date_default_timezone_set("America/Managua");
                                                                      echo date('d-m-Y');
                                                                      ?>">
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <div class="form-group row">
                                                         <label class="col-md-3 col-form-label">Monto<span class="text-danger">*</span></label>
                                                         <div class="col-md-8">
                                                            <input class="form-control" type="text"  name="amount" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" required>
                                                         </div>
                                                     </div>

                                                     <div class="form-group row">
                                                         <label class="col-md-3 col-form-label">Nota </label>
                                                         <div class="col-md-8">
                                                             <input type="text" name="note" class="form-control">
                                                         </div>
                                                     </div>

                                                     <hr>

                                                     <div class="text-center">
                                                         <button id="save_data" type="submit" class="btn btn-primary">Guardar</button>
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

$( "#add_transfer" ).submit(function( event ) {
$('#save_data').attr("disabled", true);
var parametros = $(this).serialize();
 $.ajax({
    type: "POST",
    url: "fnadd_transaccion.php",
    data: parametros,
     beforeSend: function(objeto){
      $("#resultados_ajax").html("Enviando...");
      },
    success: function(datos){
    $("#resultados_ajax").html(datos);
    $('#save_data').attr("disabled", false);
    //load(1);
    window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
    $(this).remove();});}, 5000);

    }
});
event.preventDefault();
})

</script>

</body>

</html>
