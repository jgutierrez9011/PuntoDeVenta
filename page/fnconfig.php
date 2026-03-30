<?php
require_once 'cn.php';
require_once 'reg.php';

if(isset($_FILES['imginicio_sesion']['name']))
{

  fn_guardar_img_producto('inicio');

}elseif (isset($_FILES['img_encabezado']['name'])) {

  fn_guardar_img_producto('logo');

}elseif (isset($_FILES['img_inicio']['name'])) {

  fn_guardar_img_producto('banner');

}


function validarCantidadExtension()
{
  //formatos de archivos permitidos
  $allowed =  array('png' ,'jpg','jpeg','PNG','JPG','JPEG');
  //Variable para ver si es permitido
  $fileallowed = false;
  $filename = "";
      //valida si existe archivo

            if(isset($_FILES['imginicio_sesion']))
            {
               $filename = $_FILES['imginicio_sesion']['name'];

            }elseif (isset($_FILES['img_encabezado'])) {

               $filename = $_FILES['img_encabezado']['name'];

            }elseif (isset($_FILES['img_inicio'])) {

               $filename = $_FILES['img_inicio']['name'];

            }

            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            if(!in_array($ext,$allowed))
            {
                 $fileallowed = false;
                 if($fileallowed == false)
                      {
                      //  echo "Extensión de archivo no permitida.";
                        return false;
                        exit;
                      }
            }else {
                // echo "Extensión de archivo permitida.";
                 $fileallowed = true;
                 return true;
            }

}

function fn_guardar_img_producto($ruta)
{
try {
  $usuario = $_SESSION["correo"];
  $con = conexion_bd(1);

  $directorio = "";

  if($ruta == 'logo'){
     $directorio = '../img/logo/'; //Declaramos una  variable con la ruta donde guardaremos los archivos

  }elseif ($ruta == 'inicio') {
    $directorio = '../img/inicio/'; //Declaramos una  variable con la ruta donde guardaremos los archivos

  }elseif ($ruta == 'banner') {
    $directorio = '../img/banner/'; //Declaramos una  variable con la ruta donde guardaremos los archivos

  }

  //$archivo = $directorio.$_FILES['multiarchivo']['name'];

  $restriccion = validarCantidadExtension();

  /*Instrucciones para almacenar las imagenes del producto*/
  //Como el elemento es un arreglos utilizamos foreach para extraer todos los valores
if($restriccion)
{

  //---ELIMINAMOS EL ARCHIVO ANTERIOR
/*$sql_archivo = "SELECT substring(strimagenproducto,16,100) archivo_actual
              from public.tblcatproductos
              where intidcliente = $archivo";
$resul_archivo = pg_query($con,$sql_archivo);
$row_archivo = pg_fetch_array($resul_archivo);*/

$directorio_anterior = '';

if($ruta == 'logo'){
   $directorio_anterior = '../img/logo/'; //Declaramos una  variable con la ruta donde guardaremos los archivos

}elseif ($ruta == 'inicio') {
  $directorio_anterior = '../img/inicio/'; //Declaramos una  variable con la ruta donde guardaremos los archivos

}elseif ($ruta == 'banner') {
  $directorio_anterior = '../img/banner/'; //Declaramos una  variable con la ruta donde guardaremos los archivos

}

//Validamos si la ruta de destino existe, en caso de no existir la creamos
if(file_exists($directorio_anterior))
{
        // Devuelve un vector con todos los archivos y directorios
        $files = scandir($directorio_anterior);
          $ficherosEliminados = 0;
        foreach($files as $f)
        {
          if (is_file($directorio_anterior.$f))
            {
            //  echo $directorio.$f;

               if (unlink($directorio_anterior.$f))
                {
                   $ficherosEliminados+=1;
                }
            }
        }
}
//----ARCHIVO ELIMINADO

         $error = "";
         $temp_name = "";
         $name = "";

        if(isset($_FILES['imginicio_sesion']))
        {
          $error = $_FILES['imginicio_sesion']['error'];
          $temp_name = $_FILES['imginicio_sesion']['tmp_name'];
          $name = $_FILES['imginicio_sesion']['name'];

        }elseif (isset($_FILES['img_encabezado'])) {

          $error = $_FILES['img_encabezado']['error'];
          $temp_name = $_FILES['img_encabezado']['tmp_name'];
          $name = $_FILES['img_encabezado']['name'];

        }elseif (isset($_FILES['img_inicio'])) {

          $error = $_FILES['img_inicio']['error'];
          $temp_name = $_FILES['img_inicio']['tmp_name'];
          $name = $_FILES['img_inicio']['name'];

        }

    if ( 0 < $error )
      {
          echo 'Error: ' . $error . '<br>';
      }
    else
      {

          //Validamos si la ruta de destino existe, en caso de no existir la creamos
          if(!file_exists($directorio))
          {
            mkdir($directorio, 0777, True) or die("No se puede crear el directorio de extracci&oacute;n");
          }

            $dir=opendir($directorio);

        //    move_uploaded_file($_FILES['imgproducto']['tmp_name'], '../img_productos/3/' . $_FILES['imgproducto']['name']);

            //Movemos y validamos que el archivo se haya cargado correctamente
            //El primer campo es el origen y el segundo el destino
            if(move_uploaded_file($temp_name, $directorio . $name)) {



               if(isset($_FILES['imginicio_sesion']))
               {
                 $target_path = $directorio . $_FILES['imginicio_sesion']['name'];
                 $_SESSION['imginicio_sesion'] = $target_path;

               }elseif (isset($_FILES['img_encabezado'])) {

                 $target_path = $directorio . $_FILES['img_encabezado']['name'];
                 $_SESSION['img_encabezado'] = $target_path;

               }elseif (isset($_FILES['img_inicio'])) {

                 $target_path = $directorio . $_FILES['img_inicio']['name'];
                 $_SESSION['img_inicio'] = $target_path;

               }

               echo 'Si ya completo los campos requeridos de click en el boton guardar datos.';

              } else {


                if(isset($_FILES['imginicio_sesion']))
                {
                  $_SESSION['imginicio_sesion'] = "";

                }elseif (isset($_FILES['img_encabezado'])) {

                  $_SESSION['img_encabezado'] = "";

                }elseif (isset($_FILES['img_inicio'])) {

                  $_SESSION['img_inicio'] = "";

                }
            }

            closedir($dir); //Cerramos el directorio de destino
       }

  }
  else {
    echo 'El formato de archivo no es soportado, por favor verifique.';
  }

} catch (\Exception $e) {

}

}
?>
