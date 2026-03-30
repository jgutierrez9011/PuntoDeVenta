<?php
/*
    Tomar una fotografía y guardarla en un archivo
    @date @date 2018-10-22
    @author parzibyte
    @web parzibyte.me/blog
*/
require 'cn.php';

$imagenCodificada = file_get_contents("php://input"); //Obtener la imagen
if(strlen($imagenCodificada) <= 0) exit("No se recibió ninguna imagen");
//La imagen traerá al inicio data:image/png;base64, cosa que debemos remover
$imagenCodificadaLimpia = str_replace("data:image/png;base64,", "", urldecode($imagenCodificada));

//Venía en base64 pero sólo la codificamos así para que viajara por la red, ahora la decodificamos y
//todo el contenido lo guardamos en un archivo
$imagenDecodificada = base64_decode($imagenCodificadaLimpia);

//Calcular un nombre único
$nombreImagenGuardada = "foto_" . uniqid() . ".png";

//Escribir el archivo
file_put_contents('../img_cliente/'.$nombreImagenGuardada, $imagenDecodificada);

$_SESSION["imgclientenuevo"] = '../img_cliente/'.$nombreImagenGuardada;

$nombreImagenGuardada = '../img_cliente/'.$nombreImagenGuardada;
//Terminar y regresar el nombre de la foto
exit($nombreImagenGuardada);
?>
