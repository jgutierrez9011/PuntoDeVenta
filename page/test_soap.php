<?php
//Create the client object
$soapclient = new SoapClient('http://www.webservicex.net/globalweather.asmx?WSDL');

//Use the functions of the client, the params of the function are in
//the associative array
$params = array('CountryName' => 'Spain', 'CityName' => 'Alicante');
$response = $soapclient->getWeather($params);

var_dump($response);
?>
