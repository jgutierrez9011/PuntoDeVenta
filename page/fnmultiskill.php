<?php
require_once 'cn.php';
require_once 'reg.php';
require_once 'funciones/funciones.php';

if(isset($_POST['area']))
{
  fillsegmento($_POST['area']);
}

if(isset($_POST['problematica']))
{
  fillproblematica($_POST['problematica'],'N');
}

/*Listado de segmentos*/
function fillarea($val)
{
  $con = conexion_bd(1);
  $sql = pg_query($con,"SELECT * from msgsac.tblcatarea where bolactivo = 't' order by strnombre asc");
  echo '<option value="">Seleccione</option>';
  while($row = pg_fetch_assoc($sql))
  {
    echo '<option value="'. $row['strnombre'].'"';

    if($row['strnombre']==$val )
    {
          echo "selected";
    }

    echo ">". $row['strnombre'] .'</option>';
  }
}

//echo  fillsegmento('PROCESOS');

/*Listado de segmentos*/
function fillsegmento($val)
{
  $con = conexion_bd(1);
  $sql = pg_query($con,"SELECT * FROM msgsac.tblcatsegmento
                        where bolactivo = 't' and strarea = '$val'
                        order by strdescripcionsegmento asc");

  echo '<option value="">Seleccione</option>';

  while($row = pg_fetch_assoc($sql))
  {

    $key = $row['strdescripcionsegmento'].'-'.$row['strarea'];

    echo '<option value="'. $key . '"';

    if( $row['strdescripcionsegmento'] == $val )
    {
          echo "selected";
    }

    echo ">". $row['strdescripcionsegmento'] .'</option>';
   }
}

//echo fillproblematica('OPEN-PROCESOS','N');
/*Listado de problematicas*/
function fillproblematica($segmento, $val)
{
  $con = conexion_bd(1);

  $sql = pg_query($con,"SELECT * FROM msgsac.tblcatsubsegmento
                  where bolactivo = 't' and strdescripcionsegmento = trim('$segmento')
                  order by strdescripcionsubsegmento asc");

  echo '<option value="">Seleccione</option>';
  while($row = pg_fetch_assoc($sql))
  {
    echo '<option value="'. $row['strdescripcionsubsegmento'].'"';

    if($row['strdescripcionsubsegmento']==$val )
    {
          echo "selected";
    }

    echo ">". $row['strdescripcionsubsegmento'] .'</option>';
  }
}

/*Funcion para crear un nuevo colaborador*/
function insertar_problematica($usuario, $zona, $tienda, $area, $segmento, $subsegmento,
                              $comentario)
{
  /*Se llama funcion para conectar con base de datos de postgreSQl*/
  $con = conexion_bd(1);

  $folder = "d";
  $sql="";
  
 // $comentario = stroupper($comentario);

  if($area == "CONTRATO ÚNICO")
  {
	  
	  
	  if((strpos($comentario,"INCIDENTE:") > 0) && ( strpos($comentario,"#CONTRATO:") > 0) && (strpos($comentario,"#CÉDULA DEL CLIENTE:")>0) && ( strpos($comentario,"PLAN COMERCIAL:") > 0 ) && (strpos($comentario,"INCONSISTENCIA:") > 0) && (strpos($comentario,"RECUERDE:") > 0))
			{
			    $sql = "INSERT INTO msgsac.tbltrnproblematica(
             strusuario, strzona, strtienda, strarea, strsegmento,
             strproblematica, datfechacreo, strcomentario)
             VALUES ('$usuario', '$zona', '$tienda', '$area', '$segmento', '$subsegmento', current_timestamp, '$comentario')  returning intidproblematica ";
			}
			else
			{
				 header("location: retroalimentacionmultiskill.php?token=3");
				 exit;
			}
  }
  
  $sql = "INSERT INTO msgsac.tbltrnproblematica(
             strusuario, strzona, strtienda, strarea, strsegmento,
             strproblematica, datfechacreo, strcomentario)
        VALUES ('$usuario', '$zona', '$tienda', '$area', '$segmento', '$subsegmento', current_timestamp, '$comentario')  returning intidproblematica ";

  $result = pg_query($con,$sql);
  $cmdtuplas= pg_affected_rows($result);

  $insert_row = pg_fetch_result($result, 0, 'intidproblematica');

  foreach($_FILES['multiarchivo']['tmp_name'] as $key => $tmp_name)
  {
    //Validamos que el archivo exi8sta
    if($_FILES['multiarchivo']['name'][$key]) {

      $filename = $_FILES['multiarchivo']['name'][$key]; //Obtenemos el nombre original del archivo
      $source = $_FILES['multiarchivo']['tmp_name'][$key]; //Obtenemos un nombre temporal del archivo

      $directorio = '../multiskill/'.$insert_row.'/'.$folder.'/'; //Declaramos una  variable con la ruta donde guardaremos los archivos
      //$archivo = $directorio.$_FILES['multiarchivo']['name'];

      //Validamos si la ruta de destino existe, en caso de no existir la creamos
      if(!file_exists($directorio)){
        mkdir($directorio, 0777, True) or die("No se puede crear el directorio de extracci&oacute;n");
      }

      $dir=opendir($directorio); //Abrimos el directorio de destino
      $target_path = $directorio.$filename; //Indicamos la ruta de destino, así como el nombre del archivo

      //Movemos y validamos que el archivo se haya cargado correctamente
      //El primer campo es el origen y el segundo el destino
      if(move_uploaded_file($source, $target_path)) {

         $sqlimg = "INSERT INTO msgsac.tbltrnimgincidentemultiskill(intidrq, strruta, strtipo) VALUES ('$insert_row','$target_path', 'D');";
         $resul = pg_query($con,$sqlimg);
         //Cuenta el numero de filas
         $cmdtuplas = pg_affected_rows($resul);
         if($cmdtuplas > 0){
                echo '<script> alert("Se logro almacenar las imagenes");</script>';
         }
        } else {
          echo '<script> alert("Ha ocurrido un error, por favor inténtelo de nuevo");</script>';
      }
      closedir($dir); //Cerramos el directorio de destino
    }
      }

   /*si se inserta correctamente se envia token para mensaje de exito*/
  if($cmdtuplas == 1)
  {
    $sql_mail="SELECT strcorreo from msgsac.tblcatarea where strnombre = '$area'";
    $resul_mail = pg_query($con,$sql_mail);
    $row_mail = pg_fetch_array($resul_mail);

    $sql_ejecutivo="SELECT concat(strpnombre::text,' ',strsnombre::text,' ',strpapellido::text,' ',strsapellido::text) ejecutivo
                    from msgsac.tblcatempleado
                    where strcorreo = '$usuario'";
    $resul_ejecutivo = pg_query($con,$sql_ejecutivo);
    $row_ejecutivo = pg_fetch_array($resul_ejecutivo);
    $ejecutivo = $row_ejecutivo['ejecutivo'];

    $msn= "<strong>Zona : </strong>".$zona."\r\n<br>";
    $msn= $msn."<strong>Tienda : </strong>".$tienda."\r\n<br>";
    $msn= $msn."<strong>Ejecutivo : </strong>".$ejecutivo."\r\n<br>";
    $msn= $msn."<strong>Correo : </strong>".$usuario."\r\n<br>";
    $msn= $msn."<strong>Area : </strong>".$area."\r\n<br>";
    $msn= $msn."<strong>Segmento : </strong>".$segmento."\r\n<br>";
    $msn= $msn."<strong>Problematica : </strong>".$subsegmento."\r\n<br>";
    $msn= $msn."<strong>Comentario del inconveniente : </strong>".$comentario;

    $destinatario = $row_mail['strcorreo'];
    sendmail('Nuevo incidente - Multiskill', 'incidentes.multiskill@claro.com.ni', $destinatario, 'Nuevo incidente - '.$subsegmento, $msn);

    header("location: retroalimentacionmultiskill.php?token=1");
  }
  else
  /*si no se inserta correctamente se envia token para mensaje de error*/
  {
  header("location: retroalimentacionmultiskill.php?token=2");
  }
}
 ?>
