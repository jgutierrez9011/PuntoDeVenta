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

              <h4 class="page-header  mb-3 text-center">Listado de proveedores</h4>

              <br>

              <div id="resultados_ajax"></div>

              <br>
              <form class="needs-validation" method="post" action="">
                 <!-- Primera linea de campos en el fromulario-->
                <br>
                <div class="row">
                      <div class="col-md-4">
                         <a class="btn btn-primary" data-toggle="modal" id="nuevo_cliente" data-target="#proveedor_modal" role="button"><i class='fa fa-plus'></i> Nuevo proveedor</a>
                      </div>
                </div>
              		<br>
              </form>
          <br>
          <div class="row">
            <?php

            $cn =  conexion_bd(1);

             $sql = "SELECT intidproveedor, strnombre_empresa, strsitioweb_empresa, strtelefono_empresa,
                     strdirreccion_empresa, strdepartamento, strnombre_vendedor, strcorreo_vendedor,
                     strtelefono_vendedor, strusuariocreo, datfechacreo, strusuariomodifico, datfechamodifico
                     FROM public.tblcatproveedor;";

             $resul = pg_query($cn,$sql);

             $retorno = "<div class='row table-responsive'>
                            <table class='display nowrap stripe row-border order-column' id='mitabla' style='width:100%'>
                        <thead>
                        <tr>
                        <th><p class='small'><strong>Registro</strong></p></th>
                        <th><p class='small'><strong>Acciones</strong></p></th>
                        <th><p class='small'><strong>Empresa</strong></p></th>
                        <th><p class='small'><strong>Telefono de empresa</strong></p></th>

                        <th><p class='small'><strong>Correo</strong></p></th>
                        <th><p class='small'><strong>Nombre del vendedor</strong></p></th>
                        <th><p class='small'><strong>Telefono de vendedor</strong></p></th>
                        <th><p class='small'><strong>Sitio web</strong></p></th>
                        <th><p class='small'><strong>Direccion</strong></p></th>

                        <th><p class='small'><strong>Usuario creo</strong></p></th>
                        <th><p class='small'><strong>Fecha creo</strong></p></th>
                        <th><p class='small'><strong>Usuario modifico</strong></p></th>
                        <th><p class='small'><strong>Fecha modifico</strong></p></th>

                        </tr>
                        </thead>
                        <tbody>";
              while ($row = pg_fetch_array($resul)){

                /*$img = "";
                if( strlen($row['strimagen']) > 0)
                      {  $img = $row['strimagen']; }
               else {
                        if( $row['strsexo'] == 'MASCULINO')
                              {   $img = '../img/img_avatar.png';  }
                        else{ $img =  '../img/img_avatar2.png'; }
                     }*/

                    $retorno = $retorno."<tr>
                                         <td>
                                         <input type='hidden' id='txtid_prov_".$row["intidproveedor"]."' value='".$row["intidproveedor"]."' />
                                         <p class='small'>".$row["intidproveedor"]."</p>
                                         </td>
                                         <td class='text-right'>
                                         <div class='dropdown dropdown-action show'>
                                             <button class='btn btn-default dropdown-toggle' type='button' data-toggle='dropdown'>
                                             <i class='fa fa-ellipsis-v'></i>
                                              <span class='caret'></span></button>
                                              <ul class='dropdown-menu'>
                                                <li>
                                                <a href='#editar_proveedor_modal' class='edit_data' id='".$row["intidproveedor"]."' data-toggle='modal'><i class='fa fa-pencil m-r-5'></i> Editar</a>
                                                </li>
                                              <!--  <li>
                                                <a href='#editar_proveedor_modal' class='edit_data' id='".$row["intidproveedor"]."' data-toggle='modal'><i class='fa fa-eraser m-r-5'></i> Eliminar</a>
                                                </li> -->
                                              </ul>
                                            </div>
                                         </td>

                                         <td>
                                         <input type='hidden' id='txtnombre_emp_".$row["intidproveedor"]."' value='".$row["strnombre_empresa"]."' />
                                         <p class='small'>".$row["strnombre_empresa"]."</p>
                                         </td>

                                         <td>
                                         <input type='hidden' id='txttel_emp_".$row["intidproveedor"]."' value='".$row["strtelefono_empresa"]."' />
                                         <p class='small'>".$row["strtelefono_empresa"]."</p>
                                         </td>

                                         <td>
                                         <input type='hidden' id='txtemail_emp_".$row["intidproveedor"]."' value='".$row["strcorreo_vendedor"]."' />
                                         <p class='small'><i class='fa fa-user'></i>".$row["strcorreo_vendedor"]."</p>
                                         </td>

                                         <td>
                                         <input type='hidden' id='txtvendedor_emp_".$row["intidproveedor"]."' value='".$row["strnombre_vendedor"]."' />
                                         <p class='small'>".$row["strnombre_vendedor"]."</p>
                                         </td>

                                         <td>
                                         <input type='hidden' id='txttel_vendedor_".$row["intidproveedor"]."' value='".$row["strtelefono_vendedor"]."' />
                                         <p class='small'>".$row["strtelefono_vendedor"]."</p>
                                         </td>

                                         <td>
                                         <input type='hidden' id='txtweb_emp_".$row["intidproveedor"]."' value='".$row["strsitioweb_empresa"]."' />
                                         <p class='small'>".$row["strsitioweb_empresa"]."</p>
                                         </td>

                                         <td>
                                         <input type='hidden' id='txtdir_emp_".$row["intidproveedor"]."' value='".$row["strdirreccion_empresa"]."' />
                                         <p class='small'>".$row["strdirreccion_empresa"]."</p>
                                         </td>

                                         <td><p class='small'>".$row["strusuariocreo"]."</p></td>
                                         <td><p class='small'>".$row["datfechacreo"]."</p></td>
                                         <td><p class='small'>".$row["strusuariomodifico"]."</p></td>
                                         <td><p class='small'>".$row["datfechamodifico"]."</p></td>




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


    <!-- Modal agregar proveedores-->
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


      <input type="number" name="txtstrtelefono_vendedor" id="txtstrtelefono_vendedor" class="form-control"  data-rule-minlength="4" placeholder="Telefono del Vendedor" maxlength="30">
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

  <!-- PANTALLA PARA EDITAR LA INFORMACION DEL PROVEEDOR -->
  <!-- Modal agregar proveedores-->
  <form role="form" name="frm_editar_proveedor" id="frm_editar_proveedor"  method="post">
  <div class="modal fade" id="editar_proveedor_modal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar proveedor</h4>
        </div>
        <div class="modal-body">

          <ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#home">Proveedor</a></li>
  </ul>

  <div class="tab-content">
  <div id="home" class="tab-pane fade in active">

  <br>
  <div class="form-group">
     <input type="hidden" id="edit_id_prov" name="edit_id_prov" />
     <input type="text" name="txtstrnombre_vendedor_edit" id="txtstrnombre_vendedor_edit" class="form-control" required data-rule-minlength="4" placeholder="Nombre del vendedor" maxlength="30">

  </div>

  <div class="form-group">


    <input type="number" name="txtstrtelefono_vendedor_edit" id="txtstrtelefono_vendedor_edit" class="form-control"  data-rule-minlength="4" placeholder="Telefono del Vendedor" maxlength="30">
  </div>

  <div class="form-group">

    <input type="text" name="txtstrcorreo_vendedor_edit" id="txtstrcorreo_vendedor_edit" class="form-control" data-rule-minlength="4" placeholder="Correo del vendedor" maxlength="30">


  </div>

  <div class="form-group">
  <input type="text" name="txtstrnombre_empresa_edit" id="txtstrnombre_empresa_edit" class="form-control" placeholder="Nombre de la empresa" />


  </div>

  <div class="form-group">
    <input type="text" name="txtstrtelefono_empresa_edit" id="txtstrtelefono_empresa_edit" class="form-control"  data-rule-minlength="4" placeholder="Telefono de la empresa" maxlength="30">


  </div>

  <div class="form-group">
    <input type="text" name="txtstrsitioweb_empresa_edit" id="txtstrsitioweb_empresa_edit" class="form-control"  data-rule-minlength="4" placeholder="Sitio web de la empresa" maxlength="30">


  </div>

  <br>

  <div class="form-group">
  <textarea class="form-control text-uppercase font-italic" id="txtstrdirreccion_empresa_edit" name="txtstrdirreccion_empresa_edit" text="arial-label" placeholder="Dirección"></textarea>
  </div>

  </div>

  </div>



        </div>
        <div class="modal-footer">
          <button type="submit" id="guardar_datos_proveedor_edit" name="guardar_datos_proveedor_edit" class="btn btn-info right">Guardar</button>
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

           var id = $(this).attr("id");
           var nombre =  document.getElementById("txtnombre_emp_"+id).value;
           var telefono = document.getElementById("txttel_emp_"+id).value;
           var telefono_vendedor = document.getElementById("txttel_vendedor_"+id).value;
           var mail = document.getElementById("txtemail_emp_"+id).value;
           var vendedor = document.getElementById("txtvendedor_emp_"+id).value;
           var web = document.getElementById("txtweb_emp_"+id).value;
           var direccion = document.getElementById("txtdir_emp_"+id).value;

           $('#txtstrnombre_vendedor_edit').val(vendedor);
           $('#txtstrtelefono_vendedor_edit').val(telefono_vendedor);
           $('#txtstrtelefono_empresa_edit').val(telefono);
           $('#txtstrcorreo_vendedor_edit').val(mail);
           $('#txtstrnombre_empresa_edit').val(nombre);
           $('#txtstrsitioweb_empresa_edit').val(web);
           $('#txtstrdirreccion_empresa_edit').val(direccion);
           $('#txtid_prov_').val(direccion);
           $('#edit_id_prov').val(id);
           });


      });

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
          $(this).remove(); location.reload();});}, 5000);
          $('#proveedor_modal').modal('hide');
          }
      });
      event.preventDefault();

      })

      $( "#frm_editar_proveedor" ).submit(function( event ) {
      $('#guardar_datos_proveedor_edit').attr("disabled", true);
      var parametros = $(this).serialize();
       $.ajax({
          type: "POST",
          url: "fnproveedores.php",
          data: parametros,
           beforeSend: function(objeto){
            $("#resultados_ajax").html("Enviando...");
            $('#editar_proveedor_modal').modal('hide');
            },
          success: function(datos){
          $("#resultados_ajax").html(datos);
          $('#guardar_datos_proveedor_edit').attr("disabled", false);
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
