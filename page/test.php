<!DOCTYPE html>
<?php

/*$myArr = array (
  array("Volvo",22),
  array("BMW",15),
  array("Saab",5),
  array("Land Rover",17)
);

$myJSON = json_encode($myArr);

echo $myJSON;*/
function calculartiempo ($fecha_iniciar , $fecha_finalizar){

$date1 = date_create($fecha_iniciar);
$date2 = date_create($fecha_finalizar);
$diferencia = date_diff($date1, $date2);

$tiempo = array();
foreach ($diferencia as $valor){
  $tiempo[] = $valor;
  }
return $tiempo;
}

/*$x = calculartiempo ('2020-12-04' ,'2020-12-04');
echo "<pre>";
 print_r($x[11]);
echo "</pre>";*/

function conexion_bd($val)
{

  /*CADENA DE CONEXION PARA POSGRESQL*/
  if($val==1)
  {
            $con = pg_connect("host=172.27.32.75 port=5400 dbname=sac user=postgres password=gerenciaSAC.indc_6!");
            //$con = pg_connect("user=postgres password=claro2018 host=localhost port=5400 dbname=sac");
        if (pg_last_error($con))
        {
          echo "Fallo al contenctar a Base de datos :(".$con->pg_last_error().")".$con->pg_last_error();
          exit();
        }

        return $con;
  }

  /*CADENA DE CONEXION PARA ORACLE*/
  if($val==2)
  {
        //Cadena de conexion a servidor oracle anterior (ya no se usa)
	   /*$dbstr = "(DESCRIPTION= (ADDRESS=(PROTOCOL=TCP)(HOST=172.26.10.211)(PORT=1525))
                  (CONNECT_DATA=(SERVER=DEDICATED)(SERVICE_NAME = TAESPP)))"; */

		//Cadena de conexion a servidor oracle
		 $dbstr = " (DESCRIPTION = (ADDRESS=(PROTOCOL=TCP)(HOST=172.18.125.207)(PORT=3876))
                  (CONNECT_DATA=(SERVER = DEDICATED)(service_name = taedb)))";


        $con = oci_connect('SAC_IND','5ac1ND$2020',$dbstr);
        if(!$con)
        {
         $m = oci_error();
         echo "Fallo al contenctar a Base de datos :(".$m.")";
         exit();
        }

        return $con;
  }
  /*CADENA DE CONEXION PARA POSTGRESQL PDO*/
  if($val==3)
  {
        try {
                 //$con = new PDO('pgsql:host=172.27.32.75; port=5400; dbname=sac; user=postgres; password=gerenciaSAC.indc_6!');
               $con = new PDO('pgsql:host=172.27.32.75; port=5400; dbname=sac; user=postgres; password=gerenciaSAC.indc_6!');
               //$con = new PDO('pgsql:host=localhost; port=5400; dbname=sac; user=postgres; password=claro2018');
            } catch (PDOException $e) {
                 print "¡Error!: " . $e->getMessage() . "<br/>";
                 die();
             }
        return $con;
  }

  /*CADENA QUE CONECTA CON SQL SERVER*/
  if($val==4)
   {
       try
       {
         $serverName = "172.24.0.199"; //serverName\instanceName
         $connectionInfo = array( "Database"=>"SabanaDeDatos", "UID"=>"sa", "PWD"=>"Claro$2013");
         $con = sqlsrv_connect( $serverName, $connectionInfo);

         if( $con ) {
              //echo "Conexión establecida.<br />";
              return $con;
         }else{
              echo "Conexión no se pudo establecer.<br />";
              print_r( sqlsrv_errors(), true);
         }
       }
       catch(Exception $e)
       {
           echo("Error!");
       }
   }

};



//echo $conn = conexion_bd(4);


/*$newlist = "";

$lista = "123, 456, 789";

$arreglo = explode(",",$lista);
for ($i=0;$i<count($arreglo);$i++)
   {
     if(is_numeric($arreglo[$i]))
     {
       if($i == count($arreglo)-1)
       {
         $newlist = "'".$arreglo[$i]."'";
         echo $newlist."\n";
       }else {
         $newlist = "'".$arreglo[$i]."',";
         echo $newlist."\n";
       }

     }
   }*/

function comprobar_nombre_usuario($nombre_usuario){
   //compruebo que el tamaño del string sea válido.
   if (strlen($nombre_usuario)<3 || strlen($nombre_usuario)>80){
      echo $nombre_usuario . " no es válido<br>";
      return false;
   }

   //compruebo que los caracteres sean los permitidos
   $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZáéíóú ";
   for ($i=0; $i<strlen($nombre_usuario); $i++){
      if (strpos($permitidos, substr($nombre_usuario,$i,1))===false){
         echo $nombre_usuario . " no es válido<br>";
         return false;
      }
   }
   echo $nombre_usuario . " es válido<br>";
   return true;
}

//echo comprobar_nombre_usuario('Jhonny Francisco Gutiérrez Gómez');

$json = json_encode(array(
     "client" => array(
        "build" => "1.0",
        "name" => "xxxxxx",
        "version" => "1.0"
     ),
     "protocolVersion" => 4,
     "data" => array(
        "distributorId" => "xxxx",
        "distributorPin" => "xxxx",
        "locale" => "en-US"
     )
));

/*  try {
    $con = new PDO('pgsql:host=181.49.117.32; port=5400; dbname=sac; user=postgres; password=gerenciaSAC.indc_6!');
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}*/
//echo $json;


//$color = "";
//setlocale(LC_ALL,"Spanish_Nicaragua");
//setlocale(LC_ALL,"Spanish_Nicaragua");
//$fechaactual = date("m");
//echo $fechaactual;
/*setlocale(LC_ALL,"Spanish_Nicaragua");
$valor = 202012;
$monthNum  = substr($valor, -2, 1);
if($monthNum > 0)
{
  $monthNum  = substr($valor, -2);
  $dateObj   = DateTime::createFromFormat('!m', $monthNum);
  $monthName = strftime('%B', $dateObj->getTimestamp());
  echo $monthName;
}else {
  $monthNum  = substr($valor, -1);
  $dateObj   = DateTime::createFromFormat('!m', $monthNum);
  $monthName = strftime('%B', $dateObj->getTimestamp());
  echo $monthName;
}*/
//$dateObj   = DateTime::createFromFormat('!m', $monthNum);
//$monthName = strftime('%B', $dateObj->getTimestamp());
//echo $monthName;
//echo $fechaactual;
//$ultimodiames = new DateTime();
//$ultimodiames->modify('last day of this month');
//$ultimodiames = $ultimodiames->format('d');
//Se divide la cantidad de dias transcurridos entre el total de dias del mes
//$escala = number_format(round((($fechaactual['mday']) / $ultimodiames)*100,2),2);
//echo $escala - 10;

//Primer dia del mes actual
/*$fecha = new DateTime();
$fecha->modify('first day of this month');
echo $fecha->format('d/m/Y');*/

//Ultimo dia del mes actual
/*$fecha = new DateTime();
$fecha->modify('last day of this month');*/
//echo $fecha->format('d/m/Y');
function getRealIP() {
if (!empty($_SERVER['HTTP_CLIENT_IP']))
return $_SERVER['HTTP_CLIENT_IP'];

if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
return $_SERVER['HTTP_X_FORWARDED_FOR'];

return $_SERVER['REMOTE_ADDR'];
}
//echo getRealIP();

//DIRECCION IP DESDE LA QUE SE ACCEDE A LA PAGINA
//echo $_SERVER['REMOTE_ADDR'];

//echo $_SERVER['REMOTE_HOST'];
/**
 * Función para detectar el sistema operativo, navegador y versión del mismo
 */
//$info=detect();

//echo "Sistema operativo: ".$info["os"];
//echo "Navegador: ".$info["browser"];
//echo "Versión: ".$info["version"];
//echo $_SERVER['HTTP_USER_AGENT'];

/**
 * Funcion que devuelve un array con los valores:
 *	os => sistema operativo
 *	browser => navegador
 *	version => version del navegador
 */
/*function detect()
{
	$browser=array("IE","OPERA","MOZILLA","NETSCAPE","FIREFOX","SAFARI","CHROME");
	$os=array("WIN","MAC","LINUX");

	# definimos unos valores por defecto para el navegador y el sistema operativo
	$info['browser'] = "OTHER";
	$info['os'] = "OTHER";

	# buscamos el navegador con su sistema operativo
	foreach($browser as $parent)
	{
		$s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
		$f = $s + strlen($parent);
		$version = substr($_SERVER['HTTP_USER_AGENT'], $f, 15);
		$version = preg_replace('/[^0-9,.]/','',$version);
		if ($s)
		{
			$info['browser'] = $parent;
			$info['version'] = $version;
		}
	}

	# obtenemos el sistema operativo
	foreach($os as $val)
	{
		if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),$val)!==false)
			$info['os'] = $val;
	}

	# devolvemos el array de valores
	return $info;
}*/
$cadena = "#INCIDENTE:\r\n #CONTRATO:\r\n #CÉDULA DEL CLIENTE:\r\n PLAN COMERCIAL:\r\n INCONSISTENCIA: \n\r •RECUERDE: PRINT DE PANTALLA (DEL CONTRATO Y LOS FACTURADORES, SEGÚN CORRESPONDA";
$cadena = strtoupper($cadena);
echo $cadena;
echo strpos($cadena,"INCIDENTE:")." - INCIDENTE -";
echo strpos($cadena,"#CONTRATO:")." - CONTRATO -";
echo strpos($cadena,"#CÉDULA DEL CLIENTE:")." - CÉDULA DEL CLIENTE -";
echo strpos($cadena,"PLAN COMERCIAL:")." - PLAN COMERCIAL -";
echo strpos($cadena,"INCONSISTENCIA:")." - INCONSISTENCIA: -";
echo strpos($cadena,"RECUERDE:")." - RECUERDE";

if((strpos($cadena,"INCIDENTE:") > 0) && ( strpos($cadena,"#CONTRATO:") > 0) && (strpos($cadena,"#CÉDULA DEL CLIENTE:")>0) && ( strpos($cadena,"PLAN COMERCIAL:") > 0 ) && (strpos($cadena,"INCONSISTENCIA:") > 0) && (strpos($cadena,"RECUERDE:") > 0))
{
  echo "exito";
}





?>
<html>
<head>
	<title>Envío de mails con PHP</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<!-- Bootstrap Core CSS -->
   <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
    if(isset($_POST['enviar'])){
        $cuerpo = '
        <!DOCTYPE html>
        <html>
        <head>
         <title></title>
        </head>
        <body>
        '.$_POST['cuerpo'].'
        </body>
        </html>';

        //para el envío en formato HTML
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

        //dirección del remitente
        $headers .= "From: ".$_POST['nombre']." <".$_POST['emisor'].">\r\n";

        //Una Dirección de respuesta, si queremos que sea distinta que la del remitente
        $headers .= "Reply-To: ".$_POST['emisor']."\r\n";

        //Direcciones que recibián copia
        //$headers .= "Cc: ejemplo2@gmail.com\r\n";

        //direcciones que recibirán copia oculta
        //$headers .= "Bcc: ejemplo3@yahoo.com\r\n";
        if(mail($_POST['receptor'],$_POST['asunto'],$cuerpo,$headers)){
    		echo "<script>alert('Funcion \"mail()\" ejecutada, por favor verifique su bandeja de correo.');</script>";
    	}else{
    		echo "<script>alert('No se pudo enviar el mail, por favor verifique su configuracion de correo SMTP saliente.');</script>";
    	}
    }
?>

	<form method="post">
    	<div style="background-color:#888888; width:60%; font-family:Verdana, Geneva, sans-serif; padding: 10px;">
        	<h1>Formulario de env&iacute;o de correos a trav&eacute;s de PHP con la funci&oacute;n "mail()".</h1>
            <label>Asunto</label><br>
            <input type="text" size="55" name="asunto" value="" required autofocus style="" placeholder="Asunto" ><br>
            <label>De</label><br>
            <input type="text" size="25" name="nombre" value="" required style="" placeholder="Tu Nombre" >
            <input type="email" size="25" name="emisor" required style="" placeholder="Email remitente" value=""><br>
            <label>Para</label><br>
            <input type="text" size="55" name="receptor" required style="" placeholder="Email destinatario" value="">
            <label>Si quieres enviar a varios e-mails, separalos con una coma ",".</label><br><br>
            <label>Mensaje</label><br>
            <textarea name="cuerpo" style="" placeholder="Contenido del mensaje" cols="57" rows="10"></textarea><br>
            <input type="submit" name="enviar" value="Enviar">
            <br><br>
        </div>
    </form>



           <table id='example' class='display' cellspacing='0'>
           <thead>
               <tr><th>plan_telefono</th><th>fecha_nota</th><th>canal_de_venta</th><th>username</th><th>nombre_usuario</th><th>codigo_cliente</th><th>nombre_cliente</th><th>causa</th><th>concepto_de_facturacion</th><th>monto</th><th>factura_acreditada</th><th>mes_factura</th><th>anio_factura</th><th>observacion_nota_credito</th><th>id_documento</th><th>monto_original_factura</th><th>id_cliente</th><th>proceso</th><th>fecha_vencimiento</th><th>monto_abierto_factura</th><th>estado</th><th>id_canal</th><th>plan_comercial</th><th>numero_plan</th><th>monto_credito</th><th>producto</th><th>tienda</th><th>canal</th><th>tienda_unificada</th><th>zona</th><th>servicio</th><th>validacion_causas</th><th>validacion_concepto</th><th>dia</th><th>mes</th><th>año</th><th>zona2</th></tr>
                                          </thead>
                                                <tbody>
                                                      <tr>
                                                          <td colspan='38'>Sum: $180</td>
                                                      </tr>
                                                 </tbody>
                                      </table>

<!--<div class="row table-responsive">
		<table class="table table-bordered">
				<thead>
					<tr>
						 <th><p class="small"> <strong>No. Factura</strong> </p></th>
						 <th><p class="small"> <strong>Mes de Factura</strong> </p></th>
						 <th><p class="small"> <strong>Monto de Factura</strong> </p></th>
						 <th><p class="small"> <strong>Monto de Credito</strong> </p></th>
						 <th><p class="small"> <strong>Agregar</strong> </p></th>
					</tr>
			</thead>
					<tbody>
						<tr>
						<td align="center"> <input type="text" class="form-control"  name="factura"      value="" readonly> </td>
						<td align="center"> <input type="text" class="form-control"  name="fechafactura" value="" readonly> </td>
						<td align="center"> <input type="text" class="form-control"  name="montofactura" value="" readonly> </td>
						<td align="center">  <input  type="text" class="form-control" name="montocredito" value="">        </td>
						<td align="center"> <a data-toggle="modal" data-target="#confirm-delete" id="" class="btn btn-info edit_data"><span class="fa fa-arrows"></span></a></td>
						</tr>
					</tbody>
														 </table>
													 </div> -->
