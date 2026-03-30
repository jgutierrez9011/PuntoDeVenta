<?php
require 'cn.php';
require_once 'reg.php';
require_once 'funciones/funciones.php';

if(isset($_POST["txtstrnombre_vendedor"]))
{
insertar_proveedor();
}

if((isset($_GET['q'])) && (!isset($_POST["guardar_datos_proveedor"]))){
     load_proveedor();
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

 if(isset($_POST["edit_id_prov"]))
 {
   fn_editar_proveedor();
 }

 if((isset($_POST['producto'])) && (isset($_POST['cantidad'])))
 {
   agregarfacturadetalle_compra();
 }

 if(isset($_GET['cod']))
 {
   if($_GET['cod'] == 1)
   {
      fill_detalle_venta(conexion_bd(1),0,0);
   }
 }

 function load_proveedor()
 {

   $con = conexion_bd(1);

   $q = strtoupper($_GET['q']);

   $json = [];

   $sql = "SELECT * from
(
select intidproveedor id, case when length(strnombre_empresa) > 0 then upper(strnombre_empresa) else upper(strnombre_vendedor) end as proveedor
from public.tblcatproveedor
)sub
where proveedor LIKE '%".$q."%'";

   $result = pg_query($con,$sql);
   while($row = pg_fetch_assoc($result))
   {
        $json[] = ['id'=>$row['id'], 'text'=>$row['proveedor']];
   }

    echo json_encode($json);
 }

function insertar_proveedor()
{
  try {

    $con = conexion_bd(1);

    $usuario = $_SESSION["correo"];


    $nombre_vendedor = strtoupper ($_POST['txtstrnombre_vendedor']);

    if(strlen($_POST['txtstrtelefono_vendedor']) > 0)
    {
        $telefono_vendedor = $_POST['txtstrtelefono_vendedor'];
    }
    else
    {
      $telefono_vendedor = 0;
    }

    $correo_vendedor = $_POST['txtstrcorreo_vendedor'];
    $nombre_empresa = strtoupper ($_POST['txtstrnombre_empresa']);


        if(strlen($_POST['txtstrtelefono_empresa']) > 0)
        {
          $telefono_empresa = $_POST['txtstrtelefono_empresa'];
        }
        else
        {
          $telefono_empresa = 0;
        }


    $sitio_web_empresa = $_POST['txtstrsitioweb_empresa'];
    $direccion_empresa = strtoupper ($_POST['txtstrdirreccion_empresa']);


    $sql = "INSERT INTO public.tblcatproveedor
(
strnombre_empresa, strsitioweb_empresa, strtelefono_empresa,
strdirreccion_empresa, strnombre_vendedor, strcorreo_vendedor, strtelefono_vendedor,
strusuariocreo, datfechacreo)
VALUES('$nombre_empresa','$sitio_web_empresa', $telefono_empresa,
       '$direccion_empresa','$nombre_vendedor','$correo_vendedor',
        $telefono_vendedor,'$usuario',current_timestamp AT time zone 'CST6');";

      //  echo $sql;

  $result = pg_query($con,$sql);

  $cmdtuplas = pg_affected_rows($result);

  if($cmdtuplas == 1)
  {
       //echo '<script> alert("Se registro al cliente con exito");</script>';
       //header("location: nueva_venta.php");
       echo "<div class='alert alert-success alert-dismissible alerta'>
             <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
             <strong>¡Exito!</strong> Se ha registrado el proveedor con exito.
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

function fillproductos()
{

   $cn =  conexion_bd(1);

   $perfil = $_SESSION["intidperfil"];
   $atributo = NULL;

   $row_permiso = pg_fetch_array(pg_query($cn,"SELECT bolactivo
                                from public.tblcatperfilusrfrmdetalle
                                where idfrmdetalle = 4 and idperfil =  $perfil"));
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
where a.strestado = true AND a.bolcontrolinventario = true
order by intidproducto asc";

   $resul = pg_query($cn,$sql);

   $retorno = "  <br>
                <div class='container-fluid'>

                <div class='row'>
                  <div class='col-md-12' mb-40>

                 <div class='row table-responsive'>

                  <table class='table table-striped table-bordered' id='mitabla' cellspacing='0' cellpadding='3' width='50%'>

              <thead>
              <tr class='warning'>
              <th><p class='small'><strong>Codigo</strong></p></th>
              <th><p class='small'><strong>Imagen</strong></p></th>

              <th><p class='small'><strong>Nombre</strong></p></th>
              <th><p class='small'><strong>Existencia</strong></p></th>
              <th><p class='small'><strong>C$ Precio de costo</strong></p></th>

              <th><p class='small'><strong>Cantidad</strong></p></th>
              <th><p class='small'><strong>Bonificado</strong></p></th>
              <th></th>

              </tr>
              </thead>
              <tbody>";
    while ($row = pg_fetch_array($resul)){

          $idproducto = $row["intidproducto"];

          $combo_descuento = fill_descuento(conexion_bd(1), $idproducto ,0,'form-control',$atributo);

          $retorno = $retorno."<tr>

                               <td>
                               <p class='small'>".$row["intidproducto"]."
                               <input type='hidden' class='form-control input-sm'  id='producto_".$idproducto."' value='$idproducto' />
                               </p>
                               </td>

                               <td>
                               <img src='".$row["strimagenproducto"]."'  width='40' height='40'>
                               </td>

                               <td>
                               <p class='small'>".$row["strnombre"]."-".$row["presentacion"]."
                               <input type='hidden' class='form-control input-sm'  id='nombre_".$idproducto."' value='".$row["strnombre"]."-".$row["presentacion"]."' />
                               </p>
                               </td>

                               <td>
                               <p class='small'>".$row["intstock"]."</p>
                               </td>

                               <td width='7px'>
                               <input type='number' step='.01' class='form-control input-sm'  id='precio_".$idproducto."' value='".$row["numcosto"]."' />
                               </td>

                              <td width='7px'>
                              <input type='number' class='form-control input-sm'  id='cantidad_$idproducto' value='1' />
                              </td>

                              <td width='7px'>
                              <input type='number' class='form-control input-sm' id='cantidad_bonif_$idproducto' value='0' />
                              </td>

                              <td align='center'>
                              <a href='#' onclick='agregar($idproducto)' class='btn btn-info add_producto'  id='$idproducto' ><span class='glyphicon glyphicon-shopping-cart '></span></a>
                              </td>

                              </tr>";}
          $retorno = $retorno."</tbody>
                               </table>
                               </div>
                                    </div>
                                          </div>
                                                </div>
                               ";

          echo $retorno;
}

function agregarfacturadetalle_compra()
{
  try
  {
    $con = conexion_bd(1);

    $usuario = $_SESSION["correo"];

    $idproducto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];

    $cantidad_bonificado = $_POST['cant_bonificado'];

    $nombre_producto = $_POST['nombreproducto'];
    $precio_venta = $_POST['precioventa'];

    $impuesto_aplicado = $_POST["impuestofact"];
    $descuento_aplicado = $_POST["descuentofact"];

  //  if( $_POST['descuento'] > 0.01)
  //  {
  //    $descuento = $_POST['descuento'];
  //  }
  //  else
  //  {
      $descuento = 0.00;
  //  }


    $sub_total =  ( ( $_POST['cantidad'] *  $_POST['precioventa'] ) );

  //  if( $_POST['descuento'] > 0.01)
  //  {
  //    $total =  ( ($_POST['cantidad'] *  $_POST['precioventa']) - ( ($_POST['cantidad'] *  $_POST['precioventa']) * $descuento) ) ;
  //  }
  //  else
  //  {
        $total =  (  ($_POST['cantidad'] *  $_POST['precioventa'])  ) ;
  //  }




    $sql_tmp = "INSERT INTO public.tbltempfacturadetalle_compra(
        intidproducto, numcantidad, numcantbonificado, strdescripcionproducto,
        numprecioventa, numsubttotal, numdescuento, numtotal, strusuariocreo,
        datfechacreo)
    VALUES ( $idproducto, $cantidad, $cantidad_bonificado, '$nombre_producto',
      $precio_venta , $sub_total, $descuento,   $total , '$usuario',
      current_timestamp AT time zone 'CST6' )";


    $result_detalle = pg_query($con,$sql_tmp);

    $comdtuplas = pg_affected_rows($result_detalle);


    if ( $comdtuplas > 0 )
    {
      fill_detalle_compra(conexion_bd(1),$descuento_aplicado,$impuesto_aplicado);

    }

  } catch (Exception $e) {
      header("location:index.php?token=3");
  }
}

function fn_editar_proveedor(){
  try {
    $usuario = $_SESSION["correo"];
    $nombre = $_POST["txtstrnombre_vendedor_edit"];
    $telefono = $_POST['txtstrtelefono_vendedor_edit'];
    $correo = $_POST['txtstrcorreo_vendedor_edit'];
    $empresa = $_POST['txtstrnombre_empresa_edit'];
    $web = $_POST['txtstrsitioweb_empresa_edit'];
    $direccion = $_POST['txtstrdirreccion_empresa_edit'];
    $id = $_POST['edit_id_prov'];
    $result = pg_query(conexion_bd(1),"UPDATE public.tblcatproveedor
	                                     SET  strnombre_empresa= UPPER('$empresa'),
	                                          strtelefono_empresa= '$telefono',
		                                        strcorreo_vendedor= '$correo',
		                                        strnombre_vendedor= UPPER('$nombre'),
	                                          strsitioweb_empresa= '$web',
		                                        strdirreccion_empresa=UPPER('$direccion'),
                                            strusuariomodifico= '$usuario',
		                                        datfechamodifico=current_timestamp AT time zone 'CST6'
                                       WHERE intidproveedor=$id;");

    $cmd = pg_affected_rows($result);

    if($cmd > 0)
    {
      echo "<div class='alert alert-success alert-dismissible alerta'>
            <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Exito!</strong> Se actualizo la infromación satisfactoriamente.
            </div>";
    }else {
      echo "<div class='alert alert-warning alert-dismissible alerta'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <strong>¡Disculpe!</strong> No se actualizo la información por favor intente nuevamente, si no reporta al administrador.
            </div>";
    }
  } catch (\Exception $e) {
      header("location:index.php?token=3");
  }
}


?>
