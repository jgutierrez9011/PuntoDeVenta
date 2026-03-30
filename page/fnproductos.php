<?php
require_once 'cn.php';
require_once 'reg.php';

if(isset($_POST['txtnombreproducto']))
{
  //var_dump($_POST);
  insertar_producto($_POST['txtnombreproducto'], $_POST['txtpresentacion'], $_POST['txtdescripcion'], $_POST['txtfabricante'], $_POST['txttipoproducto'], $_POST['txtcuenta'],
                    $_POST['txtcosto'], $_POST['txtutilidad'], $_POST['txtprecioventa'], $_POST['txtstock'], $_POST['txtestado'], $_POST['txtcontrolinventario'],$_POST['txtvigencia']);
}


if(isset($_POST['txtnombreproducto_edit']))
{
  //var_dump($_POST);
  actualizar_producto($_POST['txtidproducto'],$_POST['txtnombreproducto_edit'], $_POST['txtpresentacion'], $_POST['txtdescripcion'], $_POST['txtfabricante'], $_POST['txttipoproducto'], $_POST['txtcuenta'],
                     $_POST['txtcosto'], $_POST['txtutilidad'], $_POST['txtprecioventa'], $_POST['txtstock'], $_POST['txtestado'], $_POST['txtcontrolinventario'],$_POST['txtvigencia']);
}

if(isset($_FILES['imgproducto']['name']))
{
  fn_guardar_img_producto($_POST['txtidproducto']);
}

if((isset($_GET['q'])) && (!isset($_POST["btnguardar_salida"]))){
     load_productos();
 }/*else {
   $json = [];
   echo json_encode($json);
 }*/

 if(isset($_POST['id_producto']))
 {
   data_productos();
 }


  if(isset($_POST['producto']))
  {
    insertar_ajuste($_POST['customer_id'], $_POST['producto'], $_POST['existencia'], $_POST['saldo'], $_POST['txtfechanac'], $_POST['cantidad'], $_POST['cmbaplicacosto'], $_POST['observacion']);
  }

function fill_tipo_producto($val)
{
  $con = conexion_bd(1);

  $sql = pg_query($con,"SELECT intidtipoproducto, strtipo
                        FROM public.tblcattipoproducto
                        WHERE bolactivo = 'True'
                        order by strtipo asc");

  echo '<option value="">Seleccione</option>';
  while($row = pg_fetch_assoc($sql))
  {
    echo '<option value="'.$row['intidtipoproducto'].'"';

    if($row['intidtipoproducto'] == $val )
    {
          echo "selected";
    }

    echo ">". $row['strtipo'] .'</option>';
  }
  pg_close($con);
}

function validarCantidadExtension()
{
  //formatos de archivos permitidos
  $allowed =  array('png' ,'jpg','jpeg','PNG','JPG','JPEG');
  //Variable para ver si es permitido
  $fileallowed = false;
      //valida si existe archivo


            $filename = $_FILES['imgproducto']['name'];
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

function fn_num_producto()
{
  try {
    $usuario = $_SESSION["correo"];
    $con = conexion_bd(1);
    $sql = "SELECT max(coalesce(intidproducto,0)) + 1 num_producto
            from tblcatproductos";
    $result = pg_query($con,$sql);
    $row = pg_fetch_array($result);
    echo $row[0];
  } catch (\Exception $e) {

  }
}

function fn_guardar_img_producto($producto)
{
try {
  $usuario = $_SESSION["correo"];
  $con = conexion_bd(1);

  $directorio = '../img_productos/'.$producto.'/'; //Declaramos una  variable con la ruta donde guardaremos los archivos
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


$directorio_anterior = '../img_productos/'.$producto.'/';

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

    if ( 0 < $_FILES['imgproducto']['error'] )
      {
          echo 'Error: ' . $_FILES['imgproducto']['error'] . '<br>';
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
            if(move_uploaded_file($_FILES['imgproducto']['tmp_name'], $directorio . $_FILES['imgproducto']['name'])) {

               $target_path = $directorio . $_FILES['imgproducto']['name'];
               $_SESSION['img_producto'] = $target_path;
               echo 'Si ya completo los campos requeridos de click en el boton guardar datos.';

              } else {
                $_SESSION['img_producto'] = "";
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

function insertar_producto($nombreproducto, $presentacion, $descripcion, $fabricante, $tipoproducto, $clasfcuenta,
                           $costo, $utilidad, $precioventa, $stock, $estado, $inventario, $vigencia)
{
  try {

    $insert_row = "";
    //$folder = "img_productos";
    $usuario = $_SESSION["correo"];
    $target_path = $_SESSION['img_producto'];
    $con = conexion_bd(1);
  //  $restriccion = validarCantidadExtension();

  //  if($restriccion){
    /*echo $zona."\n".$departamento."\n".$tienda."\n".$nombre."\n".$clasificacion."\n".$tipo."\n".$detalle."\n".$cantidad."\n".$unidadmedida."\n".$usuario;*/
    $nombreproducto = pg_escape_string($nombreproducto);
    $presentacion = pg_escape_string($presentacion);
    $descripcion = pg_escape_string($descripcion);
    $fabricante = pg_escape_string($fabricante);

    $sql = "INSERT INTO public.tblcatproductos(
            strnombre, presentacion, strdescripcion, strfabricante,
            strtipo, strclasingreso, numcosto, numutilidad,
            numprecioventa, intstock,
            strusuariocreo, datfechacreo, strestado, bolcontrolinventario, numvigencia,strimagenproducto
            )
    VALUES (upper('$nombreproducto'),upper('$presentacion'),upper('$descripcion'),upper('$fabricante'),
            '$tipoproducto', '$clasfcuenta', $costo, $utilidad,
             $precioventa, '$stock',
             '$usuario', current_timestamp AT time zone 'CST6', '$estado', '$inventario', $vigencia,'$target_path'
            ) returning intidproducto";

    $resul = pg_query($con,$sql);

    $_SESSION['img_producto'] = "";
    //Cuenta el numero de filas
    $cmdtuplas = pg_affected_rows($resul);
    //Verifica el numero de filas
    if($cmdtuplas == 1)
    {
                $num_producto = pg_fetch_result($resul, 0, 'intidproducto');
                pg_query($con,"INSERT INTO public.tblcatexistencia(
                               intidproducto, strnombreproducto, intexistencia, numcosto, total, datfechacreo, strusuariocreo)
                               VALUES ($num_producto, upper('$nombreproducto'), $stock, $costo, $costo * $stock, current_timestamp AT time zone 'CST6', '$usuario')");

                //header("location: nuevo_producto.php?token=1");
                echo "<div class='alert alert-success alert-dismissible alerta'>
                      <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                      <strong>¡Exito!</strong> Se ha creado el nuevo producto con exito.
                      </div>";

    }
    else
    {
      echo "<div class='alert alert-warning alert-dismissible alerta'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Disculpe!</strong> No se guardo la información por favor intente nuevamente.
            </div>";
    }
  //}
  } catch (Exception $e) {
           //header("location: nuevo_producto.php?token=2");
           echo "<div class='alert alert-warning alert-dismissible alerta'>
                 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                 <strong>¡Disculpe!</strong> No se guardo la información por favor intente nuevamente.
                 </div>";
  }
}

function actualizar_producto($id,$nombreproducto, $presentacion, $descripcion, $fabricante, $tipoproducto, $clasfcuenta,
                           $costo, $utilidad, $precioventa, $stock, $estado, $inventario, $vigencia)
{
  try {

    $insert_row = "";
    //$folder = "img_productos";
    $usuario = $_SESSION["correo"];
    $target_path = $_SESSION['img_producto'];
    $con = conexion_bd(1);
  //  $restriccion = validarCantidadExtension();

  //  if($restriccion){
    /*echo $zona."\n".$departamento."\n".$tienda."\n".$nombre."\n".$clasificacion."\n".$tipo."\n".$detalle."\n".$cantidad."\n".$unidadmedida."\n".$usuario;*/
    $nombreproducto = pg_escape_string($nombreproducto);
    $presentacion = pg_escape_string($presentacion);
    $descripcion = pg_escape_string($descripcion);
    $fabricante = pg_escape_string($fabricante);

    $sql = "UPDATE tblcatproductos
           SET strnombre = upper('$nombreproducto')
              ,presentacion = upper('$presentacion')
              ,strdescripcion = upper('$descripcion')
              ,strfabricante = upper('$fabricante')
              ,strtipo = '$tipoproducto'
              ,strclasingreso = '$clasfcuenta'
              ,numcosto = $costo
              ,numutilidad = $utilidad
              ,numprecioventa = $precioventa
              ,intstock =  '$stock'
              ,strusuariomodifico = '$usuario'
              ,datfechamodifico = current_timestamp AT time zone 'CST6'
              ,strestado = '$estado'
              ,bolcontrolinventario = '$inventario'
              ,strimagenproducto = '$target_path'
              ,numvigencia = $vigencia
          where intidproducto = $id";

    $resul = pg_query($con,$sql);
    $_SESSION['img_producto'] = "";
    //Cuenta el numero de filas
    $cmdtuplas = pg_affected_rows($resul);
    $msg="";
    //Verifica el numero de filas
    if($cmdtuplas == 1)
    {
      /*INICIA CODIGO EN EL QUE SE REALIZA UN AJUSTE SI SE CAMBIO LA CANTIDAD EXISTENTE DESDE EL CATALOGO DE PRODUCTO*/
      $cantidad_ajuste = $_POST["txtajuste"];
      $existencia = $_POST["txtexistencia"];
      $movimiento = "";
      $nuevo_stock = 0;
      $nueva_cant_ajuste = 0;

      if(($cantidad_ajuste <> $existencia) && ($cantidad_ajuste >= 0))
      {

        if($cantidad_ajuste > $existencia)
        {
          $movimiento = "Ajuste de inventario entrada";
          $nueva_cant_ajuste = $cantidad_ajuste - $existencia;
          $nuevo_stock      =  $existencia + $nueva_cant_ajuste;
        }

        if($cantidad_ajuste < $existencia)
        {
          $movimiento = "Ajuste de inventario salida";
          $nueva_cant_ajuste = $existencia - $cantidad_ajuste;
          $nuevo_stock      =  $existencia - $nueva_cant_ajuste;
        }

        $sql_ajuste ="INSERT INTO public.tbltrnajuste(
                      intidproducto,  strmovimiento, intexistencia, intcantidadajuste,
                      intstock,       numcosto,       numutilidad,  numprecioventa,
                      strusuariocreo, datfechacreo)
                      VALUES ($id, '$movimiento', $existencia, $nueva_cant_ajuste,
                              $nuevo_stock, $costo, $utilidad, $precioventa,
                              '$usuario', current_timestamp AT time zone 'CST6');
                      update tblcatexistencia set intexistencia = $nuevo_stock, numcosto = $costo ,total = $nuevo_stock *  $costo
                      where intidproducto = $id";
         $resul_ajuste = pg_query($con,$sql_ajuste);

         $cmdtuplas_ajuste = pg_affected_rows($resul_ajuste);

         if($cmdtuplas_ajuste > 0)
         {
           $msg = "<div class='alert alert-success alert-dismissible alerta'>
                 <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                 <strong>¡Exito!</strong> Se ha realizado el $movimiento con exito.
                 </div>";
         }else {
           $msg = "<div class='alert alert-warning alert-dismissible alerta'>
                 <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                 <strong>¡Exito!</strong> No se ha realizado el $movimiento , por favor verifique he intente nuevamente.
                 </div>";
         }

      }
                //header("location: nuevo_producto.php?token=1");
                echo "<div class='alert alert-success alert-dismissible alerta'>
                      <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                      <strong>¡Exito!</strong> Se ha actualizado el producto con exito.
                      </div> ". $msg;

    }
    else
    {
      echo "<div class='alert alert-warning alert-dismissible alerta'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Disculpe!</strong> No se guardo la información por favor intente nuevamente.
            </div>";
    }
  //}
  } catch (Exception $e) {
           //header("location: nuevo_producto.php?token=2");
           echo "<div class='alert alert-warning alert-dismissible alerta'>
                 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                 <strong>¡Disculpe!</strong> No se guardo la información por favor intente nuevamente.
                 </div>";
  }
}

function load_productos()
{

  $con = conexion_bd(1);

  $q = strtoupper($_GET['q']);

  $json = [];

  $sql = "SELECT a.intidproducto, a.strnombre
          /*,a.presentacion, b.strtipo tipo, c.numcosto, a.numutilidad,a.numprecioventa,
          c.intexistencia, a.strimagenproducto, a.strusuariocreo, a.datfechacreo::date, c.total*/
          from tblcatproductos a
          inner join tblcattipoproducto b on a.strtipo::int = b.intidtipoproducto
          left join tblcatexistencia c on a.intidproducto = c.intidproducto
          where a.strestado = true AND a.bolcontrolinventario = true and a.strnombre LIKE '%".$q."%'
          order by intidproducto asc";

  $result = pg_query($con,$sql);
  while($row = pg_fetch_assoc($result))
  {
       $json[] = ['id'=>$row['intidproducto'], 'text'=>$row['strnombre']];
  }

   echo json_encode($json);
}

function data_productos()
{

  $con = conexion_bd(1);

  $q = $_POST['id_producto'];

  $json = [];

  $sql = "SELECT
          c.intexistencia, c.total
          from tblcatproductos a
          inner join tblcattipoproducto b on a.strtipo::int = b.intidtipoproducto
          left join tblcatexistencia c on a.intidproducto = c.intidproducto
          where a.strestado = true AND a.bolcontrolinventario = true and a.intidproducto = $q";

  $result = pg_query($con,$sql);
  while($row = pg_fetch_assoc($result))
  {
       $json["existencia"] = $row['intexistencia'];
       $json["total"] = $row['total'];
  }

   echo json_encode($json);
}

function insertar_ajuste($id_cliente, $id_producto, $existencia, $saldo, $fecha, $cantidad, $aplica, $observacion)
{
  try {

    $usuario = $_SESSION["correo"];
    $con = conexion_bd(1);

    $sql = "INSERT INTO public.tbltrnajusteinventario(
            intidcliente, intidproducto, intexistencia, numtotal, datfecha,
            intcantidad, straplicacosto, strobservacion, strusuariocreo, datfechamodifico)
     VALUES ($id_cliente,$id_producto,$existencia, $saldo ,'$fecha',
             $cantidad, '$aplica','$observacion','$usuario', current_timestamp AT time zone 'CST6') returning idreg";

    //echo $sql;
    $resul = pg_query($con,$sql);

    //Cuenta el numero de filas
    $cmdtuplas = pg_affected_rows($resul);
    //Verifica el numero de filas
    if($cmdtuplas == 1)
    {
                $num_producto = pg_fetch_result($resul, 0, 'idreg');

                pg_query($con,"UPDATE tblcatexistencia
                               Set  intexistencia = (tblcatexistencia.intexistencia - $cantidad)
                                   ,total = (tblcatexistencia.intexistencia - $cantidad) * tblcatexistencia.numcosto
                               where tblcatexistencia.intidproducto = $id_producto");

                //header("location: nuevo_producto.php?token=1");
                echo "<div class='alert alert-success alert-dismissible alerta'>
                      <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                      <strong>¡Exito!</strong> Se ha registrado la salida del producto con exito.
                      </div>";

    }
    else
    {
      echo "<div class='alert alert-warning alert-dismissible alerta'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Disculpe!</strong> No se registro la salida por favor intente nuevamente.
            </div>";
    }
  //}
  } catch (Exception $e) {
           //header("location: nuevo_producto.php?token=2");
           echo "<div class='alert alert-warning alert-dismissible alerta'>
                 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                 <strong>¡Disculpe!</strong> No se registro la salida, se detecto un error, por favor intente nuevamente.
                 </div>";
  }
}

 ?>
