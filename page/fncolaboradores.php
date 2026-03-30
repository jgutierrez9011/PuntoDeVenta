<?php
require_once 'cn.php';

if(isset($_REQUEST['btnagregar']))
{
  fninsertarubiempleado($_POST['idempleado'], $_POST['tienda'],$_SESSION['user'], $_POST['observacion']);
}


if(isset($_REQUEST['btnagregarjefe']))
{
fnInsertRespcac($_POST['colaboradorjefe'], $_POST['tienda'], $_POST['comentario']);
}

if(isset($_REQUEST['btnagregarjefezona']))
{
  fnInsertRespzona($_POST['colaboradorjefe'], $_POST['zona'], $_POST['comentario']);
}

if(isset($_POST['cdn']))
{
  fnexistecedula($_POST['cdn']);
}

if((isset($_POST['cargo'])) && (isset($_POST['funcion'])))
{
  fillfunciones($_POST['cargo'],$_POST['funcion']);
}


/*Listado de cargos*/
function fillcargo($val)
{
  $con = conexion_bd(1);
  $sql = pg_query($con,"SELECT * FROM msgsac.tblcatcargo where bolsac = 'True'");
  echo '<option value="">Seleccione</option>';
  while($row = pg_fetch_assoc($sql))
  {
    echo '<option value="'. $row['intidcargo'].'"';

    if($row['intidcargo']==$val )
    {
          echo "selected";
    }

    echo ">". $row['strcargo'] .'</option>';
  }
}

/*Listado de funciones*/
function fillespecialidad()
{
  $con = conexion_bd(1);
  $sql = pg_query($con,"SELECT intidfuncion, intidcargo, strfuncion, bolactivo FROM expmed.tblcatespecialidad where bolactivo = 't'");

  echo '<option value="">Seleccione</option>';
  while($row = pg_fetch_assoc($sql))
  {

   echo '<option value="'.$row['intidfuncion'].'"';

   if($row['intidfuncion'] == $funcion) {
         echo "selected";
   }
   echo ">".$row['strfuncion']."</option>";

  }
}

/*Listado de jefes*/
function filljefes($idjefe)
{
  $con = conexion_bd(1);
  $sql = pg_query($con,"SELECT intidempleado, concat(strpnombre::text,' ',strsnombre::text,' ',strpapellido::text,' ',strsapellido::text) jefe, strcorreo
                        FROM msgsac.tblcatempleado
                        WHERE boljefe = 't'");

  echo '<option value="">Seleccione</option>';
  while($row = pg_fetch_assoc($sql))
  {

   echo '<option value="'.$row['intidempleado'].'"';

   if($row['intidempleado'] == $idjefe) {
         echo "selected";
   }
   echo ">".$row['jefe']."</option>";

  }
}



/*Lista los tipos de identificacion que se pueden registrar en la base de datos*/
function fillidentificacion($val)
{
  $con = conexion_bd(1);
  $sql = pg_query($con,"SELECT * FROM msgsac.tblcattipoidentificacion");
  echo '<option value="">Seleccione</option>';
  while($row = pg_fetch_assoc($sql))
  {
    echo '<option value="'. $row['intididf'].'"';

    if($row['intididf']==$val)
    {
          echo "selected";
    }

    echo ">".$row['stridn'].'</option>' . "\n";
  }
};

/*Funcion para crear un nuevo colaborador*/
function insertar_colaborador($pnombre, $snombre, $papellido, $sapellido, $idjefe,
                              $ididf, $identificacion, $carnet, $idcargo, $idfuncion,
                              $correo, $telefono, $comision, $usropen, $usroda,
                              $usrwebclient, $usrqflow, $usrsiv, $fechaingreso,
                              $empresa, $boljefe, $comentario, $usrcreo, $userdominio)
{
  /*Se llama funcion para conectar con base de datos de postgreSQl*/
  $con = conexion_bd(1);

  $result_bolsac = pg_query($con,"SELECT bolsac FROM msgsac.tblcatcargo WHERE intidcargo = $idcargo");
  $row_bolsac =    pg_fetch_assoc($result_bolsac);
  $bolsac =    $row_bolsac['bolsac'];


  if(empty($comision)){ $comision = "NO COMISIONA"; }

  $sql = "INSERT INTO msgsac.tblcatempleado(strpnombre, strsnombre, strpapellido, strsapellido, intidjefe,
                                            intididf, stridentificacion, intcarnet, intidcargo, intidfuncion,
                                            strcorreo, strtelefono, strcomision, strusropen, strusroda, strusrwebclient,
                                            strusrqflow, strusrsiv, strfechaingreso, datfechacreo,
                                            intiddra, boljefe, bolactivo, strcomentario, strusuariocreo, struserdominio, strusersiv, bolsac)
                                     VALUES('$pnombre', '$snombre', '$papellido', '$sapellido', $idjefe,
                                             $ididf, '$identificacion', '$carnet', $idcargo, $idfuncion,
                                            '$correo', '$telefono', '$comision', '$usropen', '$usroda','$usrwebclient',
                                            '$usrqflow', '$usrsiv', '$fechaingreso', current_timestamp,
                                            '$empresa','$boljefe', 'TRUE','$comentario', '$usrcreo', '$userdominio', '$usersiv', '$bolsac') returning intidempleado";

  $result = pg_query($con,$sql);
  $cmdtuplas= pg_affected_rows($result);
  /*Obtiene el ultimo id del ultimo insert que se realizo*/
  $insert_row = pg_fetch_result($result, 0, 'intidempleado');

  if($cmdtuplas > 0)
  {
     $g_idtienda = $_SESSION["idtienda"];
     $g_usuario =  $_SESSION["user"];
     fninsertarubinewempleado($insert_row, $g_idtienda, $g_usuario);
  }
   /*si se inserta correctamente se envia token para mensaje de exito*/
  if($cmdtuplas == 1)
  {header("location: colaboradores.php?token=1");}
  else
  /*si no se inserta correctamente se envia token para mensaje de error*/
  {
  header("location: colaboradores.php?token=2");
  /*echo $pnombre."\n".$snombre."\n".$papellido."\n".$sapellido."\n".$idjefe."\n".$ididf."\n".$identificacion."\n".$carnet."\n".$idcargo."\n".$idfuncion;
  echo $correo."\n".$telefono."\n".$comision."\n".$usropen."\n".$usroda."\n".$usrwebclient."\n".$usrqflow."\n".$usrsiv."\n".$fechaingreso;
  echo $empresa."\n".$boljefe."\n".$comentario."\n".$usrcreo;*/
  }
};

/*Funcion para editar o actualizar la informacion de un colaborador*/
function actualizar_colaborador($pnombre, $snombre, $papellido, $sapellido, $idjefe,
                                $ididf, $identificacion, $carnet, $idcargo, $idfuncion,
                                $correo, $telefono, $comisiona, $usropen, $usroda,
                                $usrwebclient, $usrqflow, $usrsiv, $fechaingreso,
                                $empresa, $boljefe, $comentario, $usrcreo, $idempleado, $userdominio, $usersiv)
{
  /*Se llama funcion para conectar con base de datos de postgreSQl*/
  $con = conexion_bd(1);

  if(empty($comision)){ $comision = "NO COMISIONA"; }

  $sql = "UPDATE msgsac.tblcatempleado
           SET
             strpnombre ='$pnombre',
             strsnombre ='$snombre',
             strpapellido ='$papellido',
             strsapellido ='$sapellido',
             intidjefe = $idjefe,
             intididf = $ididf,
             stridentificacion ='$identificacion',
             intcarnet ='$carnet',
             intidcargo = $idcargo,
             intidfuncion=$idfuncion,
             strcorreo='$correo',
             strtelefono='$telefono',
             strusropen='$usropen',
             strusroda='$usroda',
             strusrwebclient='$usrwebclient',
             strusrqflow='$usrqflow',
             strusrsiv='$usrsiv',
             strfechaingreso='$fechaingreso',
             boljefe='$boljefe',
             datfechamodifico=current_timestamp,
             strcomentario='$comentario',
             strusuriomod='$usrcreo',
             strcomision='$comisiona',
             intiddra='$empresa',
             struserdominio='$userdominio',
             strusersiv='$usersiv'
          WHERE intidempleado = $idempleado";

  $result = pg_query($con,$sql);
  $cmdtuplas= pg_affected_rows($result);


  /*si se actualiza correctamente se envia token para mensaje de exito*/
  if($cmdtuplas == 1)
  { header("location: editarcolaboradores.php?id=".$idempleado."&token=1");}
  else
  /*si no se actualiza correctamente se envia token para mensaje de exito*/
{ header("location: editarcolaboradores.php?id=".$idempleado."&token=2");
  /*echo $pnombre."\n".$snombre."\n".$papellido."\n".$sapellido."\n".$ididf."\n".$identificacion."\n".$carnet."\n".$idcargo."\n".$correo;
  echo $telefono."\n".$comisiona."\n".$usropen."\n".$usroda."\n".$usrwebclient."\n".$usrqflow."\n".$usrsiv."\n".$fechaingreso."\n".$boljefe."\n".$comentario."\n".$usrcreo."\n".$idempleado."\n".$empresa;*/
}

};

/*Funcion que se manda a llamar para dar de baja a un colaborador*/
function baja_colaborador($fechabaja,$idempleado,$usuario)
{
  /*Se manda a llamar funcion para conectar con base de datos de postgreSQl*/
  $con = conexion_bd(1);

  $sql = "UPDATE msgsac.tblcatempleado
   SET
       datfechabaja='$fechabaja',
       bolactivo='False',
       datfechamodifico=current_timestamp,
       strusuriomod='$usuario'
 WHERE intidempleado=$idempleado";

  $result = pg_query($con,$sql);
  $cmdtuplas= pg_affected_rows($result);

  /*Si se actualiza correctamente se lanza alert de confirmacion*/
  if($cmdtuplas == 1)
  { echo '<script>
            alert("Se dio de baja con exito.");
            window.history.go(-1);
          </script>';}
  else
  /*Si no se actualiza correctamente se lanza alert de confirmacion*/
  { echo '<script>
            alert("Lo lamentamos no se logro dar de baja, por favor verifique.");
            window.history.go(-1);
          </script>';}
}

/*Funcion para asignar una tienda a un coloborador*/
function fninsertarubiempleado($idempleado, $idtienda, $usuario, $observacion)
{
  /*se llama funcion para conectar con base de datos de postgreSQl*/
  $con = conexion_bd(1);

  $sql = "UPDATE msgsac.tbltrnempzona
           SET bolactivo = 'False',
               strusuariomodifico = '$usuario',
               datfecharmodifico = current_timestamp
           WHERE intidempleado   = $idempleado;";

  $sql .= "INSERT INTO msgsac.tbltrnempzona(intidempleado, intidtienda, bolactivo, datfechacreo, strusuariocreo, strobservacion)
          VALUES ($idempleado, $idtienda, 'True', current_timestamp, '$usuario', '$observacion');";

  $result = pg_query($con,$sql);
  $cmdtuplas= pg_affected_rows($result);

  /*si se inserta correctamente se envia token para mensaje de exito*/
  if($cmdtuplas == 1)
  { header("location: asigubicacion.php?id=".$idempleado."&token=1");}
  else
  /*si no se inserta correctamente se envia token para mensaje de exito*/
  { header("location: asigubicacion.php?id=".$idempleado."&token=2");}
}

/*Funcion para asignar una tienda a un coloborador*/
function fninsertarubinewempleado($idempleado, $idtienda, $usuario)
{
  /*se llama funcion para conectar con base de datos de postgreSQl*/
  $con = conexion_bd(1);

  $sql = "UPDATE msgsac.tbltrnempzona
           SET bolactivo = 'False',
               strusuariomodifico = '$usuario',
               datfecharmodifico = current_timestamp,
               bolcomisiona = 'False'
           WHERE intidempleado   = $idempleado;";

  $sql .= "INSERT INTO msgsac.tbltrnempzona(intidempleado, intidtienda, bolactivo, datfechacreo, strusuariocreo, bolcomisiona)
          VALUES ($idempleado, $idtienda, 'True', current_timestamp, '$usuario', 'True');";

  $result = pg_query($con,$sql);
  $cmdtuplas= pg_affected_rows($result);

  return $cmdtuplas;
}

/*Funcion para asignar a una tienda  un coloborador como responsable o jefe*/
function fnInsertRespcac($idempleado, $idtienda, $comentario)
{
  /*se llama funcion para conectar con base de datos de postgreSQl*/
  $con = conexion_bd(1);

  $usuario =  $_SESSION['user'];

  $sql = "UPDATE msgsac.tbltrnresptienda
          SET bolactivo = 'False',
              strusuarioinactivo = '$usuario',
              datfechainactivo = current_timestamp
          WHERE intidtienda = $idtienda;
          INSERT INTO msgsac.tbltrnresptienda(intidtienda, intidempleado, strcomentario, bolactivo, strusuario, datfechacreo)
                                      VALUES ($idtienda, $idempleado, '$comentario', 'True', '$usuario', current_timestamp);";

  $result = pg_query($con,$sql);
  $cmdtuplas= pg_affected_rows($result);

  /*si se inserta correctamente se envia token para mensaje de exito*/
  if($cmdtuplas == 1)
  { header("location: asigresptienda.php?token=1");}
  else
  /*si no se inserta correctamente se envia token para mensaje de exito*/
  { header("location: asigresptienda.php?token=2");}
}

/*Funcion para asignar a una zona  un coloborador como responsable o jefe*/
function fnInsertRespzona($idempleado, $idzona, $comentario)
{
  /*se llama funcion para conectar con base de datos de postgreSQl*/
  $con = conexion_bd(1);

  $usuario =  $_SESSION['user'];

  $sql = "UPDATE msgsac.tbltrnrespzona
          SET bolactivo = 'False',
              strusuarioinactivo = '$usuario',
              datfechainactivo = current_timestamp
          WHERE intidzona = $idzona;
          INSERT INTO msgsac.tbltrnrespzona(intidzona, intidempleado, strcomentario, bolactivo, strusuario, datfechacreo)
                                      VALUES ($idzona, $idempleado, '$comentario', 'True', '$usuario', current_timestamp);";

  $result = pg_query($con,$sql);
  $cmdtuplas= pg_affected_rows($result);

  /*si se inserta correctamente se envia token para mensaje de exito*/
  if($cmdtuplas == 1)
  { header("location: asigrespzona.php?token=1");}
  else
  /*si no se inserta correctamente se envia token para mensaje de exito*/
  { header("location: asigrespzona.php?token=2");}
}


function fillcomisiona($val)
{
  $con = conexion_bd(1);
  $sql = pg_query($con,"SELECT * FROM msgsac.tblcatcomision");
  echo '<option value="">Seleccione</option>';
  while($row = pg_fetch_assoc($sql))
  {
    echo '<option value="'. $row['strdescripcion'].'"';

    if($row['strdescripcion']==$val )
    {
          echo "selected";
    }

    echo ">". $row['strdescripcion'] .'</option>';
  }
}

function fillperfilusuario($val)
{
  $con = conexion_bd(1);
  $sql = pg_query($con,"SELECT idperfil, strperfil, bolactivo FROM msgsac.tblcatperfilusr");
  echo '<option value="">Seleccione</option>';
  while($row = pg_fetch_assoc($sql))
  {
    echo '<option value="'. $row['idperfil'].'"';

    if($row['idperfil']==$val )
    {
          echo "selected";
    }

    echo ">". $row['strperfil'] .'</option>';
  }
}

function actualizar_usuario ($idemp, $loginweb, $perfil, $permiso)
{
  $con = conexion_bd(1);
  $sql="UPDATE msgsac.tblcatempleado
        SET bolloginweb='$loginweb', intidperfil=$perfil, strpermiso = '$permiso'
        WHERE intidempleado = $idemp";

  $result = pg_query($con,$sql);
  $cmdtuplas= pg_affected_rows($result);

  /*si se actualiza correctamente se envia token para mensaje de exito*/
  if($cmdtuplas == 1)
  { header("location: permisosasig.php?id=".$idemp."&token=1");}
  else
  /*si no se actualiza correctamente se envia token para mensaje de exito*/
{ header("location: permisosasig.php?id=".$idemp."&token=2");
  /*echo $idemp."\n".$loginweb."\n".$password."\n".$perfil."\n".$permiso;*/
}
}

function set_password ($idemp)
{
  $con = conexion_bd(1);
  $sql="UPDATE msgsac.tblcatempleado
        Set strpassword = MD5(concat('Claro',intidempleado))
        where intidempleado = $idemp";

  $result = pg_query($con,$sql);
  $cmdtuplas= pg_affected_rows($result);

  /*si se actualiza correctamente se envia token para mensaje de exito*/
  if($cmdtuplas == 1)
  { header("location: permisosasig.php?id=".$idemp."&token=3");}
  else
  /*si no se actualiza correctamente se envia token para mensaje de exito*/
{ header("location: permisosasig.php?id=".$idemp."&token=2");
  /*echo $idemp."\n".$loginweb."\n".$password."\n".$perfil."\n".$permiso;*/
}
}

/*Funcion para editar o actualizar la informacion de un colaborador*/
function actualizar_perfil($pnombre, $snombre, $papellido, $sapellido,
                           $telefono, $usropen, $usroda,
                           $usrwebclient, $usrqflow, $usrsiv,
                           $usrcreo, $idempleado, $userdominio, $usersiv, $ip)
{
  /*Se llama funcion para conectar con base de datos de postgreSQl*/
  $con = conexion_bd(1);

  if(empty($comision)){ $comision = "NO COMISIONA"; }

  $sql = "UPDATE msgsac.tblcatempleado
           SET
             strpnombre='$pnombre',
             strsnombre='$snombre',
             strpapellido='$papellido',
             strsapellido='$sapellido',
             strtelefono='$telefono',
             strusropen='$usropen',
             strusroda='$usroda',
             strusrwebclient='$usrwebclient',
             strusrqflow='$usrqflow',
             strusrsiv='$usrsiv',
             datfechamodifico=current_timestamp,
             strusuriomod='$usrcreo',
             struserdominio='$userdominio',
             strusersiv='$usersiv',
             ip_pc_asignada='$ip'
          WHERE intidempleado = $idempleado";

  $result = pg_query($con,$sql);
  $cmdtuplas= pg_affected_rows($result);

  /*si se actualiza correctamente se envia token para mensaje de exito*/
  if($cmdtuplas == 1)
  { header("location: miperfil.php?codigo=".base64_encode($idempleado)."&token=1");}
  else
  /*si no se actualiza correctamente se envia token para mensaje de exito*/
{ header("location: editarcolaboradores.php?codigo=".$idempleado."&token=2");
  /*echo $pnombre."\n".$snombre."\n".$papellido."\n".$sapellido."\n".$ididf."\n".$identificacion."\n".$carnet."\n".$idcargo."\n".$correo;
  echo $telefono."\n".$comisiona."\n".$usropen."\n".$usroda."\n".$usrwebclient."\n".$usrqflow."\n".$usrsiv."\n".$fechaingreso."\n".$boljefe."\n".$comentario."\n".$usrcreo."\n".$idempleado."\n".$empresa;*/
}

};

/*Carga las zonas segun la asignacion de ubicacion*/
function fillzonajefe($idemp,$val,$bandera)
{
  $con = conexion_bd(1);
  $sql = "";
  if($bandera == 1){
  $sql = pg_query($con,"SELECT intidzona, strzona, bolactivo
                        FROM msgsac.tblcatzonas
                        where intidzona in (select j.intidzona from msgsac.tblcatempleado as g
                                            inner join msgsac.tbltrnempzona as h on g.intidempleado = h.intidempleado
                                            inner join msgsac.tblcattienda as i on h.intidtienda = i.intidtienda
                                            inner join msgsac.tblcatdepartamentos as j on i.intiddepto = j.intiddepto
                                            where g.intidempleado = $idemp and h.bolactivo = 'True')");
  }

  if($bandera == 2){
  $sql = pg_query($con,"SELECT intidzona, strzona, bolactivo FROM msgsac.tblcatzonas");
  }

  echo '<option value="">Seleccione</option>';
  while($row = pg_fetch_assoc($sql))
  {
    echo '<option value="'. $row['intidzona'].'"';

    if($row['intidzona']==$val )
    {
          echo "selected";
    }

    echo ">". $row['strzona'] .'</option>';
  }
  pg_close($con);
}

/*Carga las zonas segun la asignacion de ubicacion*/
function filltiendajefe($idemp, $val,$bandera)
{
  $con = conexion_bd(1);
  $sql = "";

  if($bandera == 1)
  { $sql = pg_query($con,"SELECT intidtienda, intiddepto, strtiendaunificada, strtienda, boltunificada, bolactivo, tipo FROM msgsac.tblcattienda where tipo in ('TIENDA','AGENCIA')"); }
  elseif ($bandera == 2)
  { $sql = pg_query($con,"SELECT intidtienda, intiddepto, strtiendaunificada, strtienda, boltunificada, bolactivo, tipo FROM msgsac.tblcattienda where intidtienda = $val;"); }


  echo '<option value="">Seleccione</option>';
  while($row = pg_fetch_assoc($sql))
  {
    echo '<option value="'. $row['intidtienda'].'"';

    if($row['intidtienda']==$val )
    {
          echo "selected";
    }

    echo ">". $row['strtienda'] .'</option>';
  }
  pg_close($con);
}

 ?>
