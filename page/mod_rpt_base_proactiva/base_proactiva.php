<?php
require_once 'cn.php';
require_once 'reg.php';
require_once 'fn_base_proactiva.php';

/*Variable que activa la opcion de descargar reportes*/
$ver_rpt = $_SESSION["permiso"];
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
    <title>Analítica SAC</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- css para plugin datatable  -->
  <!--  <link rel="stylesheet" type="text/css" href="../vendor/datatables/css_/jquery.dataTables.min.css"> -->

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
    table thead tr {
      background-color: #FF3333;
      color: #ffffff;
    }

    .panel-gris {
        border-color: #808080;
        background-color: #808080;
        color: #FFFFFF;

    }

    .modal-header {
                    padding:9px 15px;
                    border-bottom:1px solid #eee;
                    background-color: #F14444;
                    -webkit-border-top-left-radius: 5px;
                    -webkit-border-top-right-radius: 5px;
                    -moz-border-radius-topleft: 5px;
                    -moz-border-radius-topright: 5px;
                    border-top-left-radius: 5px;
                    border-top-right-radius: 5px;
                  }
    </style>
    <script type="text/javascript">
    function permite(elEvento){
          //variable que definen los caracteres permitidos
          var permitidos = "0123456789";
          var teclas_especiales = [8, 37, 39, 46];
          // 8 = BackSpace, 37 = Flecha Izquierda, 39 = Flecha Derecha, 46 = Suprimir
          //Obtener la tecla pulsada
          var evento = elEvento || window.event;
          var codigoCaracter = evento.charCode || evento.keyCode;
          var caracter = String.fromCharCode(codigoCaracter);
          //Comprobar si la tecla pulsada es alguna de las teclas teclas_especiales
          //(teclas de borrado y flechas horizontales)
          var tecla_especial = false;
          for(var i in teclas_especiales){
            if (codigoCaracter == teclas_especiales[i]){
                    tecla_especial = true;
                    break;
            }
          }
          //Comprobar si la tecla pulsada se encuentra en los caracteres permitidos
          //o si es una tecla especial
          return permitidos.indexOf(caracter) != -1 || tecla_especial;
    }
    </script>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include 'menu.php'; ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
              <br>

              <div class="py-5 text-center">
                  <img class="d-block mx-auto mb-4" src="../img/logoclaro.jpg" alt="CLARO" width="92" height="82">
              </div>

             <h2 align="center">Servicio al Cliente</h2>
             <h3 align="center">Base Proactiva</h3>
             <br />

  <!--  <form class="needs-validation" name="form1"  action="#" method="post"> -->
        <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="input-group">
                              <input type="text" class="form-control" id="bcontrato" name="bcontrato" value="" placeholder="Buscar por contrato o cédula" required data-toggle="tooltip" data-placement="top" title="Ejemplo: contrato">
                          <div class="input-group-btn">
                             <button class="btn btn-info" id="btn_buscar_contrato" name="btn_buscar_contrato" type="submit" value="btn_buscar_contrato"><i class="glyphicon glyphicon-search"></i></button>
                          </div>
                  </div>
              </div>
          </div>

          <br>
  <!--   </form> -->

     <br>

     <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><font color="white">Información detallada</font></h4>
      </div>
      <div class="modal-body">

        <div class="col-lg-12">
            <div class="panel panel-red">
                <div class="panel-heading">
                    Información del cliente
                </div>
                <div class="panel-body">


                <div class = "row" >
                  <div class="col-md-2 mb-2">
                     <input type = "hidden" class = "form-control" name ="num_id" id ="num_id">
                     <label for="lblid">Id</label>
                     <p><i id="id_cliente"></i></p>
                  </div>

                  <div class="col-md-4 mb-4">
                    <label for="lblcliente">Nombre del cliente</label>
                    <p><i id="nombredelcliente"></i></p>
                  </div>

                  <div class="col-md-3 mb-3">
                    <label for="lblcedula">Cédula</label>
                    <p><i id="cedulacliente"></i></p>
                  </div>

                  <div class="col-md-3 mb-3">
                    <label for="lblcontrato">Contrato</label>
                    <p><i id="contratocliente"></i></p>
                  </div>
                </div>

                <div class = "row">
                  <div class="col-md-4 mb-4">
                    <label for="lbltelefono">Teléfono</label>
                    <p><i id="telefonosclientes"></i></p>
                  </div>
                </div>

                </div>

            </div>
        </div>
       <br>
        <div class="col-lg-12">
            <div class="panel panel-red">
                <div class="panel-heading">
                    Daños del cliente
                </div>
                <div class="panel-body">
                <div class = "row">
                  <div class="col-md-2 mb-2">
                      <label for="lblmes_1">Mes 1</label>
                      <p><i id="mes1"></i></p>
                  </div>

                  <div class="col-md-2 mb-2">
                        <label for="lblmes_2">Mes 2</label>
                        <p><i id="mes2"></i></p>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label for="lblmes_3">Mes 3</label>
                        <p><i id="mes3"></i></p>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label for="lblmes_4">Mes 4</label>
                        <p><i id="mes4"></i></p>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label for="lblmes_5">Mes 5</label>
                        <p><i id="mes5"></i></p>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label for="lblmes_6">Mes 6</label>
                        <p><i id="mes6"></i></p>
                    </div>
                  </div>

                  <div class="col-md-2 mb-2">
                      <label for="lblcantidad_danos">Total daños</label>
                      <p><i id="total_danos"></i></p>
                  </div>

                    <div class="col-md-2 mb-2">
                        <label for="lbldanos_linea">Daños Linea</label>
                        <p><i id="danoslinea"></i></p>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label for="lbldanos_iba">Daños IBA</label>
                        <p><i id="danosiba"></i></p>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label for="lbldanos_tv">Daños TV </label>
                        <p><i id="danostv"></i></p>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label for="lblfecha_ultimo">Fecha último daño </label>
                        <p><i id="fecha_ultimo"></i></p>
                    </div>
              </div>
            </div>
        </div>
       <br>

       <div class="col-lg-12">
           <div class="panel panel-red">
               <div class="panel-heading">
                   Tecnología
               </div>
               <div class="panel-body">
              <div class = "row">
                 <div class="col-md-6 mb-2">
                   <label for="lblnodo">Nodo Internet</label>
                   <p><i id="nodo"></i></p>
                 </div>

                 <div class="col-md-2 mb-2">
                   <label for="lbltecnologia">Tecnología</label>
                   <p><i id="tecnologia"></i></p>
                 </div>

                 <div class="col-md-4 mb-2">
                   <label for="lblvelocidad">Velocidad Internet</label>
                   <p><i id="velocidad"></i></p>
                 </div>

             </div>
             </div>
           </div>
       </div>
       <br>
       <div class="col-lg-12">
           <div class="panel panel-red">
               <div class="panel-heading">
                   Arpus
               </div>
               <div class="panel-body">
              <div class = "row">
                 <div class="col-md-2 mb-2">
                   <label for="lblarpu_movil">Arpu Móvil</label>
                   <p><i id="arpu_movil_"></i></p>
                 </div>

                 <div class="col-md-2 mb-2">
                   <label for="lblarpu_multimedia">Arpu Multimedia</label>
                   <p><i id="arpu_multimedia_"></i></p>
                 </div>

                 <div class="col-md-2 mb-2">
                   <label for="lbltotal_arpu">Total Arpus</label>
                   <p><i id="total_arpus"></i></p>
                 </div>

                 <div class="col-md-2 mb-2">
                   <label for="lblserv_movil">Servicios Móvil</label>
                   <p><i id="serv_moviles"></i></p>
                 </div>

                 <div class="col-md-2 mb-2">
                   <label for="lblserv_multi">Servicios Multimedia</label>
                   <p><i id="serv_multimedia"></i></p>
                 </div>

                 <div class="col-md-2 mb-2">
                   <label for="lbltotal_servi">Total Servicios</label>
                   <p><i id="total_servicios"></i></p>
                 </div>
              </div>

              <div class = "row">
                 <div class="col-md-4 mb-4">
                   <label for="lblfecha_activacion_pos">Fecha Activación Pospago</label>
                   <p><i id="fecha_activacion_pos"></i></p>
                 </div>

                 <div class="col-md-4 mb-4">
                   <label for="lblfecha_activacion_mult">Fecha Activación Multimedia</label>
                   <p><i id="fecha_activacion_mult"></i></p>
                 </div>

                 <div class="col-md-4 mb-4">
                   <label for="lblantiguedad">Antiguedad</label>
                   <p><i id="antiguedad"></i></p>
                 </div>


             </div>

             </div>
           </div>
       </div>
           <br>
       <div class="col-lg-12">
           <div class="panel panel-red">
               <div class="panel-heading">
                   Ubicación
               </div>
               <div class="panel-body">
                <div class = "row">
                 <div class="col-md-4 mb-4">
                     <label for="lblciudad">Ciudad</label>
                     <p><i id="ciudad"></i></p>
                 </div>

                 <div class="col-md-4 mb-4">
                   <label for="lblzona_tecnica">Zona Técnica</label>
                   <p><i id="zona_tecnica"></i></p>
                 </div>

                 <div class="col-md-4 mb-4">
                   <label for="lbldepartamento">Departamento</label>
                    <p><i id="departamento_"></i></p>
                 </div>
               </div>

               <div class = "row" >
                 <div class="col-md-4 mb-4">
                   <label for="lblcolonia">Colonia</label>
                    <p><i id="colonia"></i></p>
                 </div>

                 <div class="col-md-8 mb-8">
                   <label for="lblcomplemento">Complemento Instalación</label>
                    <p><i id="complemento"></i></p>
                 </div>

               </div>
             </div>
           </div>
       </div>
        <br>

        <div class="col-lg-12">
          <div id ="panel_acciones">
            <div class="panel panel-red">
                <div class="panel-heading">
                    Acciones
                </div>
                <div class="panel-body">
                    <div id="mensaje"></div>
                    <br>
                <input type = "hidden" name = "txtnum_registro" id = "txtnum_registro" />
                <div class="col-md-3 mb-3">
                    <label for="lblobservacion">Observación</label>
                    <select class="form-control selectpicker" data-live-search="true" id="txtobservacion_" name="txtobservacion_" required>
                      <option>NC- No Contactados</option>
                      <option>CF– Contactado con Falla</option>
                      <option>CSF- Contactado sin Falla</option>
                      <option>CRF- Contactado con reclamo facturación</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                   <label for="Cargo">Número QFlow </label>
                   <input class="form-control" placeholder="#Qflow" id="txtNumeroQflow" name="txtNumeroQflow" type="number">
                   <div id="mensaje_qflow"></div>
                 </div>

                <div class="col-md-6 mb-3">
                <label for="lblcomentario">Comentario</label>
                <textarea class="form-control  font-italic" id="txtcomentario" name="txtcomentario" text="arial-label"></textarea>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="modal-footer">
      <div id ="botones_modal">
        <a href="registrar_danos.php" class="btn btn-info btn-sm" id ="dirige_registro_dano" role="button">Registrar Daños</a>
        <button type="button" class="btn btn-primary" id="btnguardarmodal" ng-clic = "refresh_base()" >Guardar</button>
        <button type="button" class="btn btn-default" id="btncerrarmodal" data-dismiss="modal" ng-click="limpiar()">Cerrar</button>
      </div>
      </div>


    </div>

  </div>
</div>

<!-- Modal para exportar base de clientes a excel-->
<div id="modal_exportar_xls" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
     <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><font color="white">×</font></button>
            <h3 id="myModalLabel_pros" align="center"><font color="white">Exportar a excel reporte de base proactiva</font></h3>
        </div>
        <div class="modal-body">

          <div id="resultfinalizo_pros"></div>

          <form name="frmmodal" action="rpt_export_base_proactiva.php" method="post">
          <!-- PANEL DEL ENCABEZADO -->
          <div class="panel panel-red">
                    <div class="panel-heading">Seleccione el periodo</div>
                          <div class="panel-body">

                          <div class="row">
                            <div class="col-md-4 mb-3">
                              <label for="Cargo">Reporte</label>
                              <select class="form-control selectpicker" data-live-search="true" id="rpt_seleccionado" name="rpt_seleccionado" required>
                                <option value="REGISTROS_EN_BANDEJA">REGISTROS EN BANDEJA</option>
                                <option value="REGISTROS_ACTUALIZADOS">REGISTROS ACTUALIZADOS</option>
                                <option value="REACTIVOS_NO_INGRESADOS">REACTIVOS NO INGRESADOS</option>
                                <option value="PROACTIVOS_NO_INGRESADOS">PROACTIVOS NO INGRESADOS</option>                    
                              </select>
                            </div>

                            <div class="col-md-4 mb-3">
                               <label for="lblperiodo_inicia">Fecha inicia</label>
                                <input type="date" class="form-control" id="fecha_ini" name="fecha_ini" required>
                            </div>

                            <div class="col-md-4 mb-3">
                              <label for="lblperiodo_finaliza">Fecha finaliza</label>
                                  <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                            </div>

                          </div>

                            <br>

                          </div>
          </div>

        </div>
     <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="btn_exportar_excel" id="btn_exportar_excel">exportar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
     </div>
   </form>
  </div>

</div>
</div> <!-- Cierra el modal -->
      <div id="mensaje"></div>
     <div class="panel panel-default">
     <div class="panel-heading">
         Área de trabajo
     </div>
     <!-- /.panel-heading -->
     <div class="panel-body">
         <!-- Nav tabs -->
         <ul class="nav nav-pills">
             <li class="active"><a href="#home-pills" data-toggle="tab">Base de clientes</a>
             </li>
             <li><a href="#profile-pills" id ="pestana_clien" data-toggle="tab">Mis Clientes</a>
             <li><a href="registrar_danos.php" class="btn btn-default btn-sm" id ="dirige_registro_dano_editar" role="button">Registrar Daños</a>
         </ul>

     <?php if ($ver_rpt == '1'){?>
         <div class="row">
           <br>
           <div class='form-group'>
               <div class="col-md-3 mb-3">
                     <button type='submit' data-toggle="modal" data-target="#modal_exportar_xls" class='btn btn-info' name="btnexpbasescorreciones" id="">
                 <span class='glyphicon glyphicon-save'></span>
                 Descargar reporte xls</button>
               </div>
           </div>
         </div>
      <?php } ?>

         <!-- Tab panes -->
         <div class="tab-content">
             <div class="tab-pane fade in active" id="home-pills">
               <br>
               <div class="row" style="aling='center'">
                <div class="col-md-12 mb-12">
                  <div class="table-responsive" ng-app="liveApp" ng-controller="liveController" ng-init="fetchData()">
                     <div class="alert alert-success alert-dismissible" ng-show="success" >
                         <a href="#" class="close" data-dismiss="alert" ng-click="closeMsg()" aria-label="close">&times;</a>
                         {{successMessage}}
                     </div>
                     <form name="testform" ng-submit="insertData()">
                         <table  datatable="ng" dt-options="vm.dtOptions" class="table table-bordered table-striped table-hover" >
                             <thead>
                                 <tr>
                                     <th><p class="small">Id</p></th>
                                     <th><p class="small">Nombre del Cliente</p></th>
                                     <th><p class="small">Cédula</p></th>
                                     <th><p class="small">Teléfono 1</p></th>
                                     <th><p class="small">Teléfono 2</p></th>
                                     <th><p class="small">Teléfono 3</p></th>
                                     <th><p class="small">Teléfono 4</p></th>
                                     <th><p class="small">Departamento</p></th>
                                     <th><p class="small">Más Info</p></th>
                                     <th width="50%"><p class="small">Observacion</p></th>
                                     <th width="90%"><p class="small">Caso Qflow</p></th>
                                     <th width="90%"><p class="small">Comentario</p></th>
                                     <th><p class="small">Acción</p></th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <tr>
                                 </tr>
                                 <tr ng-repeat="data in namesData" ng-include="getTemplate(data)">
                                 </tr>

                             </tbody>
                         </table>
                     </form>
                     <script type="text/ng-template" id="display">
                       <td><p class="small">{{data.id}}</p></td>
                       <td><p class="small">{{data.nombre_cliente}}</p></td>
                       <td><p class="small">{{data.cedula}}</p></td>
                       <td><p class="small">{{data.telefono_1}}</p></td>
                       <td><p class="small">{{data.telefono_2}}</p></td>
                       <td><p class="small">{{data.telefono_3}}</p></td>
                       <td><p class="small">{{data.telefono_4}}</p></td>
                       <td><p class="small">{{data.departamento}}</p></td>
                       <td><button class='btn btn-info btn-circle verinfo' id="{{data.id}}"  name='btnverinfo' type='submit' value='btnverinfo'><i class='fa fa-list'></i></button></td>
                       <td><p class="small">{{data.observacion}}</p></td>
                       <td><p class="small">{{data.qflow_numero}}</p></td>
                       <td><p class="small">{{data.comentario}}</p></td>

                         <td>
                             <button type="button" class="btn btn-primary btn-sm"  ng-click="showEdit(data)">Editar</button>

                         </td>
                     </script>
                     <script type="text/ng-template" id="edit">
                       <td><input type="text" name="cod" ng-model="formData.id" class="form-control"   placeholder="" ng-required="false" readonly /></td>
                       <td><input type="text" ng-model="formData.nombre_cliente" class="form-control" placeholder="" ng-required="true" readonly/></td>
                       <td><input type="text" ng-model="formData.cedula" class="form-control" placeholder="" ng-required="false" readonly/></td>
                       <td><input type="text" ng-model="formData.telefono_1" class="form-control" placeholder="" ng-required="false" readonly/></td>
                       <td><input type="text" ng-model="formData.telefono_2" class="form-control" placeholder="" ng-required="false" readonly/></td>
                       <td><input type="text" ng-model="formData.telefono_3" class="form-control" placeholder="" ng-required="false" readonly/></td>
                       <td><input type="text" ng-model="formData.telefono_4" class="form-control" placeholder="" ng-required="false" readonly/></td>
                       <td><input type="text" ng-model="formData.departamento" class="form-control" placeholder="" ng-required="false" readonly/></td>
                       <td><i class='fa fa-list'></i></td>
                       <td><select  ng-model="formData.observacion"  class="form-control" data-live-search="true" ng-required="true">
                                <option>CF– Contactado con Falla</option>
                                <option>NC- No Contactados</option>
                                <option>CSF- Contactado sin Falla</option>
                                <option>CRF- Contactado con reclamo facturación</option>
                           </select></td>
                      <td><input type="text" ng-model="formData.qflow_numero" class="form-control" placeholder="" ng-required="false" ng-blur="valqflow()"/>
                          <p ng-show="mostrar_msj_qflow" style="color:#FF0000";>Qflow no encontrado!</p>
                       </td>
                        <td><textarea ng-model="formData.comentario" class="form-control" placeholder="" ng-required="false"></textarea></td>
                         <td>
                             <input type="hidden" ng-model="formData.data.id" />
                             <button  type="button" class="btn btn-info btn-sm" ng-click="editData()">Guardar</button>
                             <button  type="button" class="btn btn-default btn-sm" ng-click="reset()">Cancelar</button>
                         </td>
                     </script>
                   </div>

                </div>
              </div>
             </div>
             <div class="tab-pane fade" id="profile-pills">
               <br>
               <div id ="recargar">  </div>
              <!--CIERRA EL SEGUNDO TAB-->
             </div>
         </div>
     </div>
     <!-- /.panel-body -->
 </div>
 <!-- /.panel -->
</div>

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <footer class="my-5 pt-5 text-muted text-center text-small">
          <p class="mb-1">&copy;<?php echo date("Y")-1; ?>-<?php echo date("Y"); ?> SAC</p>
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

    <script src="../vendor/angular/angular.min.js"></script>

    <script src="../vendor/angular/angular-datatables.min.js"></script>

    <script src="../vendor/datatables/js/jquery.datatables.min.js"></script>

    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <script>
    var app = angular.module('liveApp', []);

    app.controller('liveController', function($scope, $http){

        $scope.formData = {};

      //  $scope.addData = {};
        $scope.success = false;


        $scope.getTemplate = function(data){
            if (data.id === $scope.formData.id)
            {
                return 'edit';
            }
            else
            {
                return 'display';
            }
        };

        //PARA VER BASE ASIGNADA
        $scope.fetchData = function(){
            $http.get('fn_base_proactiva.php?select=1').success(function(data){
                $scope.namesData = data;
            });
        };


        $scope.showEdit = function(data) {
            $scope.mostrar_msj_qflow = false;
            $scope.success = false;
            $scope.formData = angular.copy(data);
        };

        $scope.editData = function(){
            $http({
                method:"POST",
                url:"editar_base_proactiva.php",
                data:$scope.formData,
            }).success(function(data){
                $scope.success = true;
                $scope.successMessage = data.messages;
                $scope.fetchData();
                $scope.formData = {};
            });

        };


       $scope.valqflow = function(){
         //alert($scope.formData.qflow_numero);
        // $scope.mostrar_msj_qflow = true;

         $http.post("fn_base_proactiva.php", {'_numqflow' : $scope.formData.qflow_numero, 'flag_qflow' : 1})
         .success(function(data){
            //  alert(data.contador);
              if(data.contador == 0)
              {
                $scope.formData.qflow_numero = "";
                 $scope.mostrar_msj_qflow = true;

              }
              else
              {
                 $scope.mostrar_msj_qflow = false;
              }
         });
       };



       $scope.limpiar = function (){

        $scope.closeMsg();


       };

        $scope.reset = function(){
            $scope.formData = {};
        };

        $scope.closeMsg = function(){
            $scope.success = false;
        };

    });

    </script>

    <script type="text/javascript">
    $(function(){

//Se ejecuta al cambiar de opciones en el campo "Observación"
      $('#txtobservacion_').change(function(){

        var observacion_ = document.getElementById("txtobservacion_").value;
         if (observacion_ == "CF– Contactado con Falla"){
           $('#dirige_registro_dano').show();
         }
         else {
           $('#dirige_registro_dano').hide();
         }


      });


       /*SE EJECUTA AL DAR GUARDAR EN EL BOTON DEL MODAL*/
     $('#btnguardarmodal').click(function(){

       var idguardar = document.getElementById("num_id").value;
         var _txtobservacion = $('#txtobservacion_').val();
         var _txtnumeroqflow_ = $('#txtNumeroQflow').val();
         var _txtcomentario = $('#txtcomentario').val();


                   $.ajax({
                    url:"fn_base_proactiva.php",
                    method:"POST",
                    data:{id_save: idguardar, txobservacion:_txtobservacion, txnumeroqflow: _txtnumeroqflow_, txcomentario: _txtcomentario},
                    dataType:"JSON",
                    success:function(datos)
                    {

                       $('#mensaje').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert">&times;</button>'+datos.mensaje+'</div>');
                    }
                       })

        })

        $('#btncerrarmodal').click(function(){
          $('#mensaje').html('');
        })

//Se ejecuta al darle click al botón buscar por contrato
        $('#btn_buscar_contrato').click(function(){
                 var num_contrato = document.getElementById("bcontrato").value;
                  $("#mensaje_qflow").html('');

                 if ((num_contrato.length == 0)){
                   alert("Por favor ingrese cédula o contrato");
                 }else{
                   $.ajax({
                    url:"fn_base_proactiva.php",
                    method:"POST",
                    data:{contrato_: num_contrato },
                    dataType:"JSON",
                    success:function(datos)
                    {
                      data = JSON.parse(JSON.stringify(datos));

                      $('#num_id').val(data[0].id);
                      $('#id_cliente').html(data[0].id);
                      $('#nombredelcliente').html(data[0].nombre_cliente);
                      $('#cedulacliente').html(data[0].cedula);
                      $('#contratocliente').html(data[0].contrato);
                      $('#telefonosclientes').html(data[0].telefono);
                      $('#mes1').html(data[0].mes_1);
                      $('#mes2').html(data[0].mes_2);
                      $('#mes3').html(data[0].mes_3);
                      $('#mes4').html(data[0].mes_4);
                      $('#mes5').html(data[0].mes_5);
                      $('#mes6').html(data[0].mes_6);
                      $('#total_danos').html(data[0].cantidad_danos);
                      $('#danoslinea').html(data[0].danos_linea);
                      $('#danosiba').html(data[0].danos_iba);
                      $('#danostv').html(data[0].danos_tv);
                      $('#fecha_ultimo').html(data[0].fecha_ultimo_dano);
                      $('#ciudad').html(data[0].ciudad);
                      $('#zona_tecnica').html(data[0].zona_tecnica);
                      $('#departamento_').html(data[0].departamento);
                      $('#colonia').html(data[0].colonia);
                      $('#complemento').html(data[0].complemento_inst);
                      $('#nodo').html(data[0].nodo_internet);
                      $('#tecnologia').html(data[0].tecnologia);
                      $('#velocidad').html(data[0].velocidad_internet);
                      $('#txtobservacion_').val(data[0].observacion);
                      $('#txtNumeroQflow').val(data[0].qflow_numero);
                      $('#txtcomentario').val(data[0].comentario);
                      $('#arpu_movil_').html(data[0].arpu_movil);
                      $('#arpu_multimedia_').html(data[0].arpu_mult);
                      $('#total_arpus').html(data[0].total_arpu);
                      $('#serv_moviles').html(data[0].serv_movil);
                      $('#serv_multimedia').html(data[0].serv_mult);
                      $('#total_servicios').html(data[0].total_servicios);
                      $('#fecha_activacion_pos').html(data[0].fecha_acti_pos);
                      $('#fecha_activacion_mult').html(data[0].fecha_acti_mul);
                      $('#antiguedad').html(data[0].antiguedad);

                    }
                         })

                         //$('#mensaje').hide();
                         $('#myModal').modal().show();
                         $('#panel_acciones').show();
                       $('#botones_modal').show();
                         $('#dirige_registro_dano').hide();

                 }


           })


// Se ejecutal al dar click al botón ver mas información
        $(document).on('click', '.verinfo', function(){
                      var y = $(this).attr("id");
                      $('#mensaje').html('');
                      $("#mensaje_qflow").html('');

                      $.ajax({
                       url:"fn_base_proactiva.php",
                       method:"POST",
                       data:{idregistro_: y },
                       dataType:"JSON",
                       success:function(datos)
                       {
                         //console.log(datos.cedulaclien);
                         $('#num_id').val(datos.numero_id);
                         $('#id_cliente').html(datos.numero_id);
                         $('#nombredelcliente').html(datos.name_clien);
                         $('#cedulacliente').html(datos.cedulaclien);
                         $('#contratocliente').html(datos.contratoclien);
                         $('#telefonosclientes').html(datos.telefonosdisp);
                         $('#mes1').html(datos.mesone);
                         $('#mes2').html(datos.mestwo);
                         $('#mes3').html(datos.mesthre);
                         $('#mes4').html(datos.mesfor);
                         $('#mes5').html(datos.mesfive);
                         $('#mes6').html(datos.messix);
                         $('#total_danos').html(datos.totaldanos);
                         $('#danoslinea').html(datos.lineadano);
                         $('#danosiba').html(datos.ibadano);
                         $('#danostv').html(datos.tvdano);
                         $('#fecha_ultimo').html(datos.ultimafecha);
                         $('#ciudad').html(datos.city);
                         $('#zona_tecnica').html(datos.zone_tecni);
                         $('#departamento_').html(datos.depart);
                         $('#colonia').html(datos.colonia_);
                         $('#complemento').html(datos.complement);
                         $('#nodo').html(datos.nodo);
                         $('#tecnologia').html(datos.tecno);
                         $('#velocidad').html(datos.velocidad);
                         $('#txtobservacion_').val(datos.observaciones);
                         $('#txtNumeroQflow').val(datos.qflows_);
                         $('#txtcomentario').val(datos.coment);
                         $('#arpu_movil_').html(datos.movil_arpus);
                         $('#arpu_multimedia_').html(datos.multi_arpus);
                         $('#total_arpus').html(datos.total_arpus_);
                         $('#serv_moviles').html(datos.movil_servi);
                         $('#serv_multimedia').html(datos.multi_servi);
                         $('#total_servicios').html(datos.total_servi_);
                         $('#fecha_activacion_pos').html(datos.activacion_fecha_pos);
                         $('#fecha_activacion_mult').html(datos.activacion_fecha_mult);
                         $('#antiguedad').html(datos.antiguedad_);
                       }
                            })

                      $('#myModal').modal().show();
                     $('#panel_acciones').hide();
                     $('#botones_modal').hide();
                    $('#dirige_registro_dano').hide();

             });
    // Función para refrescar los datos de la tabla "mis clientes"
             $('#pestana_clien').click(function(){

               var valor = 1;
               $.post('fn_base_proactiva.php',{refrescar: valor}).done(function(tabla)
               {
                 $('#recargar').html(tabla)

               });
               });

               /*procedimiento que se activa cuando el campo de numero qflow pierde el foco
                 */
             function fn_validar_qflow_proactivo()
             {
               var valor = document.getElementById("txtNumeroQflow").value;

               if((valor.length > 0) && (valor.length <= 8))
               {
                 $.ajax({
                  url:"fn_base_proactiva.php",
                  method:"POST",
                  data:{numqflow: valor},
                  dataType:"JSON",
                  success:function(datos)
                  {
                    // alert(datos.contador);
                      if(datos.contador == 0)
                      {
                           document.getElementById("mensaje_qflow").innerHTML = "<p style='color:#FF0000';>Qflow no encontrado!</p>";
                           $('#txtNumeroQflow').val('');
                      }else {
                           document.getElementById("mensaje_qflow").innerHTML = "";
                      }
                  }
                       })
               }
             }

             $(document).on('focusout', '#txtNumeroQflow', function(){
                     fn_validar_qflow_proactivo();
               });




      })
    </script>

</body>

</html>
