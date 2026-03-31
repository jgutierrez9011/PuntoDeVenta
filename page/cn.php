<?php
session_start();

function conexion_bd($val)
{

  /*CADENA DE CONEXION PARA POSGRESQL*/
  if($val==1)
  {
    $host = getenv('PGHOST') ?: 'localhost';
    $port = getenv('PGPORT') ?: '5432';
    $dbname = getenv('PGDATABASE') ?: 'msgym';
    $user = getenv('PGUSER') ?: 'postgres';
    $password = getenv('PGPASSWORD') ?: 'posgres';

    $con = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
    if (pg_last_error($con))
    {
      echo "Fallo al conectarse a Base de datos :(" . pg_last_error($con) . ")";
      exit();
    }

    return $con;
  }

}

function globales_usuario($val)
{
  /*Conexion con la base de postgresql*/
  $con = conexion_bd(1);

  $usuario = $val;
  /*Funcion que escapa la variable*/
  $usuario = comillas_inteligentes($usuario, $con);
  /*se consulta el id de cargo del usuario logueado*/
  $sql="SELECT intid, concat(strpnombre::text,' ',strsnombre::text,' ',strpapellido::text,' ',strsapellido::text) nombre_usuario, strsexo,
       strcorreo, stridentificacion, strdireccion, strcontacto, strusuariocreo,
       datfechacreo, strusuariomodifico, datfechamodifico, datfechabaja,
       bolactivo, strpassword, intidperfil
  FROM public.tblcatusuario where bolactivo = 't'and strcorreo = '$usuario';";

  $resul_g = pg_query($con,$sql);
  $row_g = pg_fetch_array($resul_g);
  $_SESSION["idusuario"] = $row_g["intid"];
  $_SESSION["nombre_usuario"] = $row_g['nombre_usuario'];
  $_SESSION["intidperfil"] = $row_g['intidperfil'];
  $_SESSION["correo"] = $row_g['strcorreo'];
  $_SESSION["user"] = $row_g['strcorreo'];
  $_SESSION["imgclientenuevo"] = "";
  // No imprimir nada aquí para evitar problemas con header()
  // echo $_SESSION["idusuario"];

}

if  (isset($_COOKIE['COOKIE_INDEFINED_SESSION']) && empty($_SESSION["idusuario"]))
  {
  	if ($_COOKIE['COOKIE_INDEFINED_SESSION'])
    {
      $pgcon = conexion_bd(1);

  		$nombre_user = base64_decode($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['nombre']);
  		$password_user = base64_decode($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['password']);

  		$_SESSION["user"] = $nombre_user;
  		//AQUI HACES LA QUERY PARA BUSCAR EN TU BD UN USUARIO Y SU PASSWORD CON LAS VARIABLES ANTERIORES

      /* Autentificacion del usuario */
      $sql= "SELECT * FROM tblcatusuario where strcorreo='".$nombre_user."' and bolactivo = 'true'";
      //Crea la consulta a la BD
      $resultuser = pg_query($pgcon,$sql);
      //Cuenta el numero de filas
      $cmdtuplas = pg_affected_rows($resultuser);
      //Verifica el numero de filas
      if($cmdtuplas == 1)
      {
        //Obtiene las filas que retorna la consulta
        $sql= "SELECT * FROM tblcatusuario where strpassword='".$password_user."' and strcorreo='".$nombre_user."' and bolactivo = 'true'";
        $resultuser = pg_query($pgcon,$sql);
        $cmdtuplas = pg_affected_rows($resultuser);
        $fila = pg_fetch_assoc($resultuser);
        $user_id = $fila["strpassword"];

          if($password_user == $user_id)
          {
             globales_usuario($_SESSION["user"]);
  	 	       header("Location:index.php"); //envias al usuario a home.php si se lo encontro en la BD!
  	      }
       }
    }
  }

/*Funcion que valida la entrada de las cadenas y las escapa
 para evitar inyeccion SQL*/
function comillas_inteligentes($valor, $con = null)
{
    $valor = stripslashes($valor);
    if (!is_numeric($valor)) {
        if ($con) {
            $valor = pg_escape_string($con, $valor);
        } else {
            $valor = pg_escape_string($valor); // Solo para compatibilidad antigua
        }
    }
    return $valor;
}


/**
 * Funcion que devuelve un array con los valores:
 *	os => sistema operativo
 *	browser => navegador
 *	version => version del navegador
 */
function detectsystema()
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
}



function regacceso()
{
  $con = conexion_bd(1);

  //DIRECCION IP DESDE LA QUE SE ACCEDE A LA PAGINA
  $ip = $_SERVER['REMOTE_ADDR'];
  $info=detectsystema();
  $useragent = $_SERVER['HTTP_USER_AGENT'];
  $navegador = $info["browser"].'//'.$useragent;
  $user = $_SESSION["user"];

  $statement = "DELETE FROM tbltrnlogin WHERE strusuario = '$user';
                INSERT INTO tblaccesos(strusuario, datfechainicio, ip, strnavegador) VALUES ('$user', current_timestamp, '$ip', '$navegador');
                INSERT INTO tbltrnlogin(strusuario, datfechainicio) VALUES ('$user', current_timestamp)";

  pg_query($con,$statement);
}

?>
