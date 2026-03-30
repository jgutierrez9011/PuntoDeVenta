<?php
require_once 'cn.php';
require_once 'reg.php';

if(isset($_POST['fechabaja']) && (isset($_POST['idempleado'])) && (isset($_POST['estado_usuario'])) )
{
 $cambio_estado="";
 if($_POST['estado_usuario'] == 'f'){  $cambio_estado = "t"; } else {  $cambio_estado = "f"; }

 baja_colaborador($_POST['fechabaja'], $_POST['idempleado'], $cambio_estado);
}


/*Lista los tipos de identificacion que se pueden registrar en la base de datos*/
function fillperfil_usuario($val)
{
  $con = conexion_bd(1);
  $sql = pg_query($con,"SELECT idperfil,strperfil FROM tblcatperfilusr where bolactivo = 't'");
  echo '<option value="">Seleccione</option>';
  while($row = pg_fetch_assoc($sql))
  {
    echo '<option value="'. $row['idperfil'].'"';

    if($row['idperfil']==$val)
    {
          echo "selected";
    }

    echo ">".$row['strperfil'].'</option>' . "\n";
  }
};

/*Funcion para crear un nuevo colaborador*/
function insertar_colaborador($pnombre, $snombre, $papellido, $sapellido, $sexo,
                              $identificacion,  $telefono, $correo, $password, $direccion,$perfil)
{
  /*Se llama funcion para conectar con base de datos de postgreSQl*/
  $con = conexion_bd(1);

  $password = MD5($password);
  $usuario_creo = $_SESSION["correo"];

  $sql = "INSERT INTO public.tblcatusuario(
            strpnombre, strsnombre, strpapellido, strsapellido, strsexo,
            stridentificacion, strcontacto, strcorreo, strpassword, strdireccion, strusuariocreo, datfechacreo,intidperfil)
          VALUES ('$pnombre', '$snombre', '$papellido', '$sapellido','$sexo',
                  '$identificacion','$telefono','$correo','$password','$direccion', '$usuario_creo', current_timestamp,'$perfil');";

  $result = pg_query($con,$sql);
  $cmdtuplas= pg_affected_rows($result);

  //echo var_dump();

   /*si se inserta correctamente se envia token para mensaje de exito*/
  if($cmdtuplas == 1)
  {header("location: usuarios.php?token=1");}
  else
  /*si no se inserta correctamente se envia token para mensaje de error*/
 {
 header("location: usuarios.php?token=2");
  /*echo $pnombre."\n".$snombre."\n".$papellido."\n".$sapellido."\n".$idjefe."\n".$ididf."\n".$identificacion."\n".$carnet."\n".$idcargo."\n".$idfuncion;
  echo $correo."\n".$telefono."\n".$comision."\n".$usropen."\n".$usroda."\n".$usrwebclient."\n".$usrqflow."\n".$usrsiv."\n".$fechaingreso;
  echo $empresa."\n".$boljefe."\n".$comentario."\n".$usrcreo;*/
 }
};

/*Funcion para editar o actualizar la informacion de un colaborador*/
function actualizar_usuario($id,$pnombre, $snombre, $papellido, $sapellido, $identificacion,
                            $correo, $telefono,$sexo,$direccion,$idperfil,$strpassword)
{
  /*Se llama funcion para conectar con base de datos de postgreSQl*/
  $con = conexion_bd(1);

  $usuario_creo = $_SESSION["correo"];

  $sql="";

  if((strlen($strpassword)) == 0){

    $sql = "UPDATE public.tblcatusuario
     SET
         strpnombre = '$pnombre',
         strsnombre = '$snombre',
         strpapellido = '$papellido',
         strsapellido = '$sapellido',
         strsexo = '$sexo',
         strcorreo = '$correo',
         stridentificacion = '$identificacion',
         strdireccion = '$direccion',
         strcontacto = '$telefono',
         strusuariomodifico = '$usuario_creo',
         datfechamodifico = current_date,
         intidperfil = $idperfil
     WHERE intid =   $id";

   }else {

      $sql = "UPDATE public.tblcatusuario
       SET
           strpnombre = '$pnombre',
           strsnombre = '$snombre',
           strpapellido = '$papellido',
           strsapellido = '$sapellido',
           strsexo = '$sexo',
           strcorreo = '$correo',
           stridentificacion = '$identificacion',
           strdireccion = '$direccion',
           strcontacto = '$telefono',
           strusuariomodifico = '$usuario_creo',
           strpassword = MD5('$strpassword'),
           datfechamodifico = current_date,
           intidperfil = $idperfil
       WHERE intid = $id";

    }

  $result = pg_query($con,$sql);
  $cmdtuplas= pg_affected_rows($result);

  $id = base64_encode($id);

  /*si se actualiza correctamente se envia token para mensaje de exito*/
  if($cmdtuplas == 1)
  { header("location: usuariosedit.php?id=". $id ."&token=1");}
  else
  /*si no se actualiza correctamente se envia token para mensaje de exito*/
  { header("location: usuariosedit.php?id=". $id ."&token=2");}

};

/*Funcion que se manda a llamar para dar de baja a un colaborador*/
function baja_colaborador($fechabaja, $idempleado, $estado)
{
  /*Se manda a llamar funcion para conectar con base de datos de postgreSQl*/
  $con = conexion_bd(1);

  $usuario_creo = $_SESSION["correo"];

  $sql = "UPDATE public.tblcatusuario
          SET  strusuariomodifico = '$usuario_creo',
	             datfechamodifico = current_timestamp,
	             datfechabaja = '$fechabaja',
	             bolactivo = '$estado'
          WHERE intid = $idempleado";

  $result = pg_query($con,$sql);
  $cmdtuplas= pg_affected_rows($result);

  /*Si se actualiza correctamente se lanza alert de confirmacion*/
  if($cmdtuplas == 1)
  {
    if($estado)
    {
      echo '<script>
              alert("Se activo el usuario con exito.");
              window.history.go(-1);
            </script>';
    }else {
      echo '<script>
              alert("Se desactivo el usuario con exito.");
              window.history.go(-1);
            </script>';
    }

  }
  else
  /*Si no se actualiza correctamente se lanza alert de confirmacion*/
  { echo '<script>
            alert("Lo lamentamos no se logro dar de baja, por favor verifique.");
            window.history.go(-1);
          </script>';}
}


/*function fillperfilusuario($val)
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
}*/







 ?>
