<?php
require 'cn.php';
require_once 'reg.php';
require_once 'funciones/funciones.php';

if(isset($_POST["txtpnombre"]))
{
insertar_cliente();
}

if(isset($_FILES['imgcliente']['name']))
{
  fn_guardar_img_cliente($_POST['idcliente']);
}

if(isset($_POST['txtpnombre_edit']))
{
   actualizar_cliente();
}

if((isset($_GET['q'])) && (!isset($_POST["guardar_datos_cliente"]))){
     load_cliente();
 }/*else {
   $json = [];
   echo json_encode($json);
 }*/

 if(isset($_GET['modalproducto']))
 {
   if($_GET['modalproducto'] == 1)
   {
     fillproductos();
   }
 }

 if((isset($_POST['producto'])) && (isset($_POST['cantidad'])))
 {
   agregarfacturadetalle();
 }

 if((isset($_POST['customer_id'])) && (isset($_POST['valor_tasa_cambio'])))
 {
   fn_save_factura();
 }

 /*function fill_detalle_venta_aux()
 {
   $usuario = $_SESSION["correo"];

   $cn =  conexion_bd(1);

    $sql = "SELECT a.intidserie, a.intidproducto, a.numcantidad, a.strdescripcionproducto,
            round(a.numprecioventa,2) numprecioventa , a.numsubttotal, a.numdescuento, round(a.numtotal,2) numtotal, a.strusuariocreo,
            round((a.numcantidad *   a.numprecioventa) * a.numdescuento,2) descuento_aplicado,
            a.datfechacreo, rank() over (order by a.datfechacreo asc) as rownumber
            FROM tbltempfacturadetalle a
            where a.strusuariocreo = '$usuario'";

      $resul = pg_query($cn,$sql);
      $neto = 0;
      $descuento = number_format(0,2);
      $iva = number_format(0,2);
      $total = 0;

      $combo_descuento = fill_descuento(conexion_bd(1), 'factura' ,0, '');
      $combo_impuesto = fill_impuesto(conexion_bd(1), 'factura' ,0, '');

    $retorno = "  <div class='row table-responsive'>
                   <table class='table table-bordered' id='' style='width:100%'>
               <thead>
               <tr class='warning'>
                <th><p class='small'><strong>N° Fila</strong></p></th>
               <th><p class='small'><strong>Codigo</strong></p></th>
               <th><p class='small'><strong>Cantidad</strong></p></th>

               <th><p class='small'><strong>Descripcion</strong></p></th>
               <th><p class='small'><strong>Precio unit C$</strong></p></th>
               <th><p class='small'><strong>Descuento C$</strong></p></th>
               <th><p class='small'><strong>Precio total C$</strong></p></th>
               <th></th>

               </tr>
               </thead>
               <tbody>";
     while ($row = pg_fetch_array($resul)){

           $idproducto = $row["intidproducto"];
              $neto = number_format($neto + $row["numtotal"],2);
              $total = $neto;
           $retorno = $retorno."<tr>
                                <td><p class='small'>".$row["rownumber"]."</p></td>
                                <td><p class='small'>".$row["intidproducto"]."</p></td>
                                <td><p class='small'>".$row["numcantidad"]."</p></td>

                                <td><p class='small'>".$row["strdescripcionproducto"]."</p></td>


                                <td><p class='small'>".$row["numprecioventa"]."</p></td>

                                <td><p class='small'>".$row["descuento_aplicado"]."</p></td>

                                <td><p class='small'>".$row["numtotal"]."</p></td>

                                <td><a data-toggle='modal' data-target='#confirm-delete' id='".$row["intidserie"]."' class='btn btn-danger delete_data'><span class='fa fa-trash-o'></span></a></td>




                                </tr>";}
           $retorno = $retorno."<tr>
           <td colspan='6' align='right'><strong>NETO C$</strong></td>
           <td colspan='4' align='left'><p class='small'>".$neto."</p></td>
                                </tr>

                                <tr>
                                <td colspan='6' align='right'>
                                <strong><p class'small'>Descuento ". $combo_descuento ." </strong></p>
                                </td>
           <td colspan='4' align='left'><p class='small'>".$descuento."</p></td>
                                </tr>

                                <tr>
                                <td colspan='6' align='right'>
                                 <strong><p class'small'>Impuesto ". $combo_impuesto ." </strong></p>
                                </td>
           <td colspan='4' align='left'><p class='small'>".$iva."</p></td>
                                </tr>

           <td colspan='6' align='right'><strong>Total a pagar C$</strong></td>
           <td colspan='4' align='left'><p class='small'>".$total."</p></td>
                               </tr>
                                </tbody>
                                </table>
                                </div>";

           echo $retorno;
 }*/

function insertar_cliente()
{
  try {

    $con = conexion_bd(1);

    $usuario = $_SESSION["correo"];


    $pnombre = strtoupper ($_POST['txtpnombre']);
    $snombre = strtoupper ($_POST['txtsnombre']);
    $papellido = strtoupper ($_POST['txtpapellido']);
    $sapellido = strtoupper ($_POST['txtsapellido']);
    $fechanac = $_POST['txtfechanac'];

    $identificacion = strtoupper($_POST['txtidentificacion']);
    $sexo = $_POST['cmbsexo'];
    $correo = $_POST['txtcorreo'];
    $telefono = $_POST['txttelefono'];

    $contacto = $_POST['txtcontacto'];

    $altura = $_POST["txtaltura"];
     //if(isset($_POST["txtaltura"])) { $altura = $_POST["txtaltura"]; } else  {   $altura = 0; };
    $peso = $_POST['txtpeso'];
  //   if(isset($_POST['txtpeso'])) { $peso = $_POST['txtpeso']; } else  {  $peso = 0; };

    $gymanterior = $_POST['txtgymanterior'];
    $anioentrenando = $_POST['txtanioentrenando'];
    $direccion = strtoupper($_POST['txtdireccion']);
    $codcliente = $_POST['txtcodcliente'];

    $imagen = $_SESSION["imgclientenuevo"];

    /*if(strlen($imagen) > 0)
    {
      $directorio = '..'.$imagen; //Declaramos una  variable con la ruta donde guardaremos los archivos
      $target_path = '..img_cliente/'.$directorio; //Indicamos la ruta de destino, así como el nombre del archivo

      move_uploaded_file($directorio, $target_path);
    }*/


    $sql = "INSERT INTO tblcatclientes(bigcodcliente,
            strpnombre, strsnombre, strpapellido, strsapellido,
            strsexo, stridentificacion, strcorreo, strtelefono, strcontacto,
            strfechadenacimiento, strdireccion, intaltura, intpeso, strgymanterior,
            intanioentrenando, strimagen, strusuariocreo, datfechacreo)
            VALUES
            ($codcliente,'$pnombre', '$snombre', '$papellido', '$sapellido','$sexo', '$identificacion','$correo', '$telefono', '$contacto', '$fechanac',  '$direccion ', $altura, $peso,
             '$gymanterior', '$anioentrenando', '$imagen', '$usuario', current_timestamp AT time zone 'CST6')";

  $result = pg_query($con,$sql);

  $cmdtuplas = pg_affected_rows($result);

  if($cmdtuplas == 1)
  {
       $_SESSION["imgclientenuevo"] = "";
       //echo '<script> alert("Se registro al cliente con exito");</script>';
       //header("location: nueva_venta.php");
       echo "<div class='alert alert-success alert-dismissible alerta'>
             <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
             <strong>¡Exito!</strong> Se ha registrado el cliente con exito.
             </div>";

  }else {
       //echo '<script> alert("No se registro al cliente, por favor vuelva a intentar o reporte al administrador.");</script>';
       //header("location: nueva_venta.php");
       echo "<div class='alert alert-warning alert-dismissible alerta'>
             <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
             <strong>¡Disculpe!</strong> No se guardo la información por favor intente nuevamente, si no reporta al administrador.
             </div>";

  }


  } catch (\Exception $e) {
    echo "<div class='alert alert-warning alert-dismissible alerta'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>¡Disculpe!</strong> No se guardo la información por favor intente nuevamente, si no reporta al administrador .".$e."
          </div>";
  }
}

function actualizar_cliente()
{
  try {

    $con = conexion_bd(1);

    $usuario = $_SESSION["correo"];


    $pnombre = strtoupper ($_POST['txtpnombre_edit']);
    $snombre = strtoupper ($_POST['txtsnombre']);
    $papellido = strtoupper ($_POST['txtpapellido']);
    $sapellido = strtoupper ($_POST['txtsapellido']);
    $fechanac = $_POST['txtfechanac'];

    $identificacion = strtoupper($_POST['txtidentificacion']);
    $sexo = $_POST['cmbsexo'];
    $correo = $_POST['txtcorreo'];
    $telefono = $_POST['txttelefono'];

    $contacto = $_POST['txtcontacto'];

    $altura = $_POST["txtaltura"];
     //if(isset($_POST["txtaltura"])) { $altura = $_POST["txtaltura"]; } else  {   $altura = 0; };
    $peso = $_POST['txtpeso'];
  //   if(isset($_POST['txtpeso'])) { $peso = $_POST['txtpeso']; } else  {  $peso = 0; };

    $gymanterior = $_POST['txtgymanterior'];
    $anioentrenando = $_POST['txtanioentrenando'];
    $direccion = strtoupper($_POST['txtdireccion']);
  //  $codcliente = $_POST['txtcodcliente'];

    $estado = $_POST['cmbestado'];
    $idcliente = $_POST['txtidcliente'];

    $imagen = $_SESSION["imgclientenuevo"];

    /*if(strlen($imagen) > 0)
    {
      $directorio = '..'.$imagen; //Declaramos una  variable con la ruta donde guardaremos los archivos
      $target_path = '..img_cliente/'.$directorio; //Indicamos la ruta de destino, así como el nombre del archivo

      move_uploaded_file($directorio, $target_path);
    }*/


    $sql = "UPDATE tblcatclientes
   SET strpnombre= '$pnombre',
       strsnombre='$snombre',
       strpapellido='$papellido',
       strsapellido='$sapellido',
       strsexo='$sexo',
       stridentificacion='$identificacion',
       strcorreo='$correo',
       strtelefono='$telefono',
       strcontacto='$contacto',
       strfechadenacimiento='$fechanac',
       strdireccion='$direccion',
       intaltura='$altura',
       intpeso='$peso',
       strgymanterior='$gymanterior',
       intanioentrenando='$anioentrenando',
       strusuariomodifico='$usuario',
       datfechamodifico=current_timestamp AT time zone 'CST6',
       bolactivo= '$estado'
 WHERE intidcliente = $idcliente ";


  $result = pg_query($con,$sql);

  $cmdtuplas = pg_affected_rows($result);

  if($cmdtuplas == 1)
  {
       $_SESSION["imgclientenuevo"] = "";
       //echo '<script> alert("Se registro al cliente con exito");</script>';
       //header("location: nueva_venta.php");
       echo "<div class='alert alert-success alert-dismissible alerta'>
             <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
             <strong>¡Exito!</strong> Se actualizo la información del cliente con exito.
             </div>";

  }else {
       //echo '<script> alert("No se registro al cliente, por favor vuelva a intentar o reporte al administrador.");</script>';
       //header("location: nueva_venta.php");
       echo "<div class='alert alert-warning alert-dismissible alerta'>
             <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
             <strong>¡Disculpe!</strong> No se actualizo la información por favor intente nuevamente, si no reporta al administrador.
             </div>";

  }


  } catch (\Exception $e) {
    echo "<div class='alert alert-warning alert-dismissible alerta'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          <strong>¡Disculpe!</strong> No se guardo la información por favor intente nuevamente, si no reporta al administrador .".$e."
          </div>";
  }
}

function load_cliente()
{

  $con = conexion_bd(1);

  $q = strtoupper($_GET['q']);

  $json = [];

  $sql = "SELECT intidcliente, concat(strpnombre,' ',strsnombre,' ',strpapellido,' ',strsapellido) cliente
          FROM public.tblcatclientes
          where bolactivo = true
          and concat(strpnombre,' ',strsnombre,' ',strpapellido,' ',strsapellido) LIKE '%".$q."%'";

  $result = pg_query($con,$sql);
  while($row = pg_fetch_assoc($result))
  {
       $json[] = ['id'=>$row['intidcliente'], 'text'=>$row['cliente']];
  }

   echo json_encode($json);
}

function validarCantidadExtension()
{
  //formatos de archivos permitidos
  $allowed =  array('png' ,'jpg','PNG','JPG');
  //Variable para ver si es permitido
  $fileallowed = false;
      //valida si existe archivo


            $filename = $_FILES['imgcliente']['name'];
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

function fn_guardar_img_cliente($archivo)
{
try {
  $usuario = $_SESSION["correo"];
  $con = conexion_bd(1);

  $directorio = '../img_cliente/'; //Declaramos una  variable con la ruta donde guardaremos los archivos
  //$archivo = $directorio.$_FILES['multiarchivo']['name'];

  $restriccion = validarCantidadExtension();

  /*Instrucciones para almacenar las imagenes del producto*/
  //Como el elemento es un arreglos utilizamos foreach para extraer todos los valores
if($restriccion)
{
  //---ELIMINAMOS EL ARCHIVO ANTERIOR
  $sql_archivo = "SELECT substring(strimagen,16,100) archivo_actual
                  from public.tblcatclientes
                  where intidcliente = $archivo";
  $resul_archivo = pg_query($con,$sql_archivo);
  $row_archivo = pg_fetch_array($resul_archivo);


  $directorio_anterior = '../img_cliente/'.$row_archivo['archivo_actual'];

  //Validamos si la ruta de destino existe, en caso de no existir la creamos
  if(file_exists($directorio_anterior))
  {
            // Devuelve un vector con todos los archivos y directorios
            $files = scandir($directorio_anterior);
            $ficherosEliminados = 0;

                if (is_file($directorio_anterior))
                  {
                  //  echo $directorio.$f;

                     if (unlink($directorio_anterior))
                      {
                         $ficherosEliminados+=1;
                      }
                  }
    }
 //----ARCHIVO ELIMINADO

    if ( 0 < $_FILES['imgcliente']['error'] )
      {
          echo 'Error: ' . $_FILES['imgcliente']['error'] . '<br>';
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
            if(move_uploaded_file($_FILES['imgcliente']['tmp_name'], $directorio . $_FILES['imgcliente']['name']))
            {

               $target_path = $directorio . $_FILES['imgcliente']['name'];
               $sql_update_img = "UPDATE tblcatclientes
                                  SET strimagen = '$target_path',
                                      strusuariomodifico = '$usuario',
                                      datfechamodifico = current_timestamp AT time zone 'CST6'
                                  WHERE intidcliente = $archivo";
               $resul_update_img = pg_query($con,$sql_update_img);
               $cmd = pg_affected_rows($resul_update_img);
               if($cmd > 0)
               {
                 //$_SESSION['img_producto'] = $target_path;
                 echo 'La fotografía del cliente se ha actualizado.';
               }

              } else {
                //$_SESSION['img_producto'] = "";
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

function fillproductos()
{

   $cn =  conexion_bd(1);

   $perfil = $_SESSION["intidperfil"];
   $atributo = NULL;

   $row_permiso = pg_fetch_array(pg_query($cn,"SELECT bolactivo
                                from public.tblcatperfilusrfrmdetalle
                                where idfrmdetalle = 2 and idperfil =  $perfil"));
   if($row_permiso['bolactivo'] == 'f')
   {
     $atributo = 'disabled';
   }


   $sql = "SELECT a.intidproducto, a.strnombre, a.presentacion, a.strdescripcion, a.strfabricante, a.strtipo, b.strtipo tipo, a.strclasingreso, a.numcosto, a.numutilidad
,a.numprecioventa,
case when a.bolcontrolinventario = true then 'Control de inventario'
else 'Sin control de inventario' end inventario, coalesce(c.intexistencia,a.intstock) intstock, a.strimagenproducto, a.strusuariocreo, a.datfechacreo, a.strusuariomodifico, a.datfechamodifico,
case when a.strestado = true then 'Activo'
ELSE 'Inactivo' end estado
from tblcatproductos a
inner join tblcattipoproducto b on a.strtipo::int = b.intidtipoproducto
left join tblcatexistencia c on a.intidproducto = c.intidproducto
where a.strestado = true and a.strclasingreso = 'VENTAS'
order by strnombre asc";

   $resul = pg_query($cn,$sql);

   $retorno = "  <div class='row'>
                 <div class='col-md-12 mb-3'>
                 <div class='row table-responsive'>

                  <table class='table' id='mitabla' style='width:100%'>
              <thead>
              <tr class='warning'>
              <th><p class='small'><strong>Codigo</strong></p></th>
              <th><p class='small'><strong>Imagen</strong></p></th>

              <th><p class='small'><strong>Nombre</strong></p></th>
              <th><p class='small'><strong>Existencia</strong></p></th>
              <th><p class='small'><strong>C$ Precio de venta</strong></p></th>
              <th><p class='small'><strong>Descuento</strong></p></th>
              <th style='width:2%'><p class='small'><strong>Cantidad</strong></p></th>
              <th></th>

              </tr>
              </thead>
              <tbody>";
    while ($row = pg_fetch_array($resul)){

          $idproducto = $row["intidproducto"];

          $combo_descuento = fill_descuento(conexion_bd(1), $idproducto ,0,'form-control',$atributo);

          $retorno = $retorno."<tr>
                               <td><p class='small' >".$row["intidproducto"]." <input type='hidden' class='form-control'  id='producto_".$idproducto."' value='$idproducto' /></p></td>
                               <td><img src='".$row["strimagenproducto"]."'  width='40' height='40'></td>

                               <td><p class='small'>".$row["strnombre"]."-".$row["presentacion"]." <input type='hidden' class='form-control'  id='nombre_".$idproducto."' value='".$row["strnombre"]."-".$row["presentacion"]."' /></p></td>
                               <td><p class='small'>".$row["intstock"]."</p></td>

                               <td><p class='small' >".$row["numprecioventa"]."<input type='hidden' class='form-control'  id='precio_".$idproducto."' value='".$row["numprecioventa"]."' /><input type='hidden' class='form-control'  id='precio_costo_".$idproducto."' value='".$row["numcosto"]."' /></p></td>

                               <td><p class='small'>". $combo_descuento ."</p></td>

                              <td class ='col-sm-3'>
                                         <input type='number' class='form-control' id='cantidad_$idproducto' value='1' />

                              </td>

                              <td align='center'> <a href='#' onclick='agregar($idproducto)' class='btn btn-info add_producto'  id='$idproducto' ><span class='glyphicon glyphicon-shopping-cart '></span></a></td>


                               </tr>";}
          $retorno = $retorno."</tbody>
                               </table>
                               </div></div></div>";

          echo $retorno;
}

function agregarfacturadetalle()
{
  try
  {
    $con = conexion_bd(1);

    $usuario = $_SESSION["correo"];

    $idproducto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];
    $nombre_producto = $_POST['nombreproducto'];
    $precio_venta = $_POST['precioventa'];
    $precio_costo = $_POST['precio_costo'];

    $impuesto_aplicado = $_POST["impuestofact"];
    $descuento_aplicado = $_POST["descuentofact"];

    if( $_POST['descuento'] > 0.01)
    {
      $descuento = $_POST['descuento'];
    }
    else
    {
      $descuento = 0.00;
    }


    $sub_total =  ( ( $_POST['cantidad'] *  $_POST['precioventa'] ) );

    if( $_POST['descuento'] > 0.01)
    {
      $total =  ( ($_POST['cantidad'] *  $_POST['precioventa']) - ( ($_POST['cantidad'] *  $_POST['precioventa']) * $descuento) ) ;
    }
    else
    {
        $total =  (  ($_POST['cantidad'] *  $_POST['precioventa'])  ) ;
    }




    $sql_tmp = "INSERT INTO public.tbltempfacturadetalle(
        intidproducto, numcantidad, strdescripcionproducto,
        numprecioventa, numsubttotal, numdescuento, numtotal, strusuariocreo,
        datfechacreo, numcosto)
    VALUES ( $idproducto, $cantidad, '$nombre_producto',
      $precio_venta , $sub_total, $descuento,   $total , '$usuario',
      current_timestamp AT time zone 'CST6',  $precio_costo)";



    $result_detalle = pg_query($con,$sql_tmp);

    $comdtuplas = pg_affected_rows($result_detalle);


    if ( $comdtuplas > 0 )
    {
      fill_detalle_venta(conexion_bd(1),$descuento_aplicado,$impuesto_aplicado);
      /*$sql = "SELECT a.intidserie, a.intidproducto, a.numcantidad, a.strdescripcionproducto,
              a.numprecioventa, a.numsubttotal, a.numdescuento, a.numtotal, a.strusuariocreo,
              a.datfechacreo, rank() over (order by a.datfechacreo asc) as rownumber
              FROM tbltempfacturadetalle a
              where a.strusuariocreo = '$usuario'";

      $resul = pg_query($con,$sql);
      $sub_total_encabezado = 0;

      $retorno = "  <div class='row table-responsive'>
                     <table class='table table-bordered' id='tbldetalleproducto' style='width:100%'>
                 <thead>
                 <tr class='warning'>
                 <th><p class='small'><strong>N°</strong></p></th>
                 <th><p class='small'><strong>Codigo</strong></p></th>
                 <th><p class='small'><strong>Cantidad</strong></p></th>

                 <th><p class='small'><strong>Descripcion</strong></p></th>
                 <th><p class='small'><strong>Precio unit</strong></p></th>
                 <th><p class='small'><strong>Precio total</strong></p></th>
                 <th></th>

                 </tr>
                 </thead>
                 <tbody>";
       while ($row = pg_fetch_array($resul)){

             $idproducto = $row["intidproducto"];
             $sub_total_encabezado = $sub_total_encabezado + $row["numtotal"];
             $retorno = $retorno."<tr>
                                  <td><p class='small'>".$row["rownumber"]."</p></td>
                                  <td><p class='small'>".$row["intidproducto"]."</p></td>
                                  <td><p class='small'>".$row["numcantidad"]."</p></td>

                                  <td><p class='small'>".$row["strdescripcionproducto"]."</p></td>


                                  <td><p class='small'>".$row["numprecioventa"]."</p></td>

                                  <td><p class='small'>".$row["numtotal"]."</p></td>

                                  <td><a data-toggle='modal' data-target='#confirm-delete' id='".$row["intidserie"]."' class='btn btn-danger delete_data'><span class='fa fa-trash-o'></span></a></td>




                                  </tr>";}
             $retorno = $retorno."<tr>
             <td colspan='5' align='right'><strong>Total</strong></td>
             <td colspan='3' align='left'><p class='small'>".$sub_total_encabezado."</p></td>
                                  </tr>
                                  </tbody>
                                  </table>
                                  </div>";

             echo $retorno;*/
    }

  /*  if($comdtuplas > 0)
    {
      header("location:credito.php");
    }*/
  } catch (Exception $e) {
      header("location:index.php?token=3");
  }
}

?>
