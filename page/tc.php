<?php
require_once 'cn.php';
require_once 'reg.php';
/*
 * @EXAMPLE BCN MODIFICADO POR JHONNY F. GUTIERREZ  correo: jhonfc9011@gmail.com
 * Ejemplo de utilización del servicio WSDL, con PHP
 */

/*
 * CODIGO CLIENTE WSDL DE PHP
 */


$servicio = "https://servicios.bcn.gob.ni/Tc_Servicio/ServicioTC.asmx?WSDL"; //url del servicio
$parametros = array(); //parametros de la llamada


/*
 * Cuando presiona el boton Consultar de Mes
 * Este envia los datos al vinculo que aparece en "action" del formulario
 * En caso de ser asi, con la funcion "$_REQUEST" de php, verificamos
 * que posee ese vinculo, en este caso se envia una variable con un valor
 * la variables es "Consultar", el valor es "Mes"
 */
if (isset($_GET['Consultar']) && $_GET['Consultar'] == "Mes") {      //Verificamos que la consulta es por tasa de cambio Mensual

    $parametros['Ano'] = (int)$_POST['Year'];
    $parametros['Mes'] = (int)$_POST['Month'];

    //echo "Mes = ". $_REQUEST['Month'] . "anio =" .$_REQUEST['Year'];
    $ValorTasaMes = "";

    $options = [
    'cache_wsdl'     => WSDL_CACHE_NONE,
    'trace'          => 1,
    'stream_context' => stream_context_create(
        [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            ]
        ]
    )
];

    $client = new SoapClient($servicio, $options);

    $result = $client->RecuperaTC_Mes($parametros); //llamamos al métdo que nos interesa con los parámetros

    $Class = (array) $result->RecuperaTC_MesResult;
    $ValorDelXML = $Class['any'];
    $xml = simplexml_load_string($ValorDelXML);
    $array = (array) $xml;
    foreach ($array as $key => $a) {                    //Recorremos el arreglo con todos los Datos
        foreach ($a as $key2 => $aa) {                      //Con este For, recorremos Los Dias del Mes
            foreach ($aa as $key3 => $a3) {                 //Con este for, recorremos las Fechas y Sus valores
                if ($key3 == "Fecha" || $key3 == "Valor")
                    $ValorTasaMes .= ' ' . $key3 . '-' . $a3;;
            }           //Terminado este For, pasa a la Siguiente Fecha
            $ValorTasaMes .='
';
        }
    }
} else if (isset($_GET['Consultar']) && $_GET['Consultar']  == "Dia") {      //Verificamos que la consulta es por tasa de cambio Diario
    $parametros['Dia'] = $_REQUEST['Day'];
    $parametros['Mes'] = $_REQUEST['Month_Day'];
    $parametros['Ano'] = $_REQUEST['Year_Day'];

    $options = [
    'cache_wsdl'     =>  WSDL_CACHE_NONE,
    'trace'          => 1,
    'stream_context' => stream_context_create(
        [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            ]
        ]
    )
];

    $client = new SoapClient($servicio,$options);
    $result = $client->RecuperaTC_Dia($parametros); //llamamos al métdo que nos interesa con los parámetros
    $TasaDiaria = ($result->RecuperaTC_DiaResult);
    //echo $TasaDiaria;
}


//try {

    $options = [
    'cache_wsdl'     => WSDL_CACHE_NONE,
    'trace'          => 1,
    'stream_context' => stream_context_create(
        [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            ]
        ]
    )
];


$client = new SoapClient("https://servicios.bcn.gob.ni/Tc_Servicio/ServicioTC.asmx?WSDL", $options);

$checkVatParameters = array(
    'Mes' => 5,
    'Ano' => 2021
);

$result = $client->RecuperaTC_Mes($checkVatParameters);
print_r($result);

//}
//catch(Exception $e) {
  //  echo $e->getMessage();
//}



?>

<b>Solicitud de Tasa de Cambio</b>
</br><i>Ejemplo Sencillo</i>
</br>
<hr align="left" style="width: 300px;"></hr>  <!-- CODIGO DE LA RAYITA QUE VE- -->


<!--
CODIGO DE CONSULTA POR MES
-->
</br><b><i>Solicitud Por Mes</i></b>
<form action="tc.php?Consultar=Mes" method="POST">
    <table border="0">
        <tbody>
            <tr>
                <th>A&ntilde;o</th>
                <td><input type="text" name="Year" id="Year" value="" size="10" /></td>
            </tr>
            <tr>
                <th>Mes</th>
                <td><input type="text" name="Month" id="Month" value="" size="10" /></td>
            </tr>
            <tr>
                <th>Consultar</th>
                <td><input type="submit" name="Consultar" value="Ejecutar Consulta" /></td>
            </tr>
            <tr>
                <th>Resultado</th>
                <td><textarea name="" rows="10" cols="35" readonly="readonly"><?php  if(isset($ValorTasaMes)) { echo $ValorTasaMes; }; ?></textarea>
                </td>
            </tr>
        </tbody>
    </table>
</form>
<!--
Codigo de JavaScript
-->
<script>
    var Fecha=new Date();   //Declaramos una variable para tomar las Fechas
    var Ano=Fecha.getFullYear();    //Tomamos el año actual en la variable "Ano""
    var Mes=Fecha.getMonth()+1;   //Tomamos el mes actual en la variable "Mes"
    //Le sumamos 1, por que toma como mes inicial "0"
    document.getElementById('Year').value = Ano;        //Asignamos al campo de texto "Year" el valor del Año
    document.getElementById('Month').value = Mes;       //Asignamos al campo de texto "Month" el valor del Mes
</script>

<!--
FIN DE CODIGO DE CONSULTA POR MES
-->

<hr align="left" style="width: 300px;"></hr>  <!-- CODIGO DE LA RAYITA QUE VE- -->

<!--
CODIGO DE CONSULTA POR DIA
-->
</br><b><i>Solicitud Por Dia</i></b>
</br>
<form action="tc.php?Consultar=Dia" method="POST">
    <table border="0">
        <tbody>
            <tr>
                <th>A&ntilde;o</th>
                <td><input type="text" name="Year_Day" id="Year_Day" value="" size="10" /></td>
            </tr>
            <tr>
                <th>Mes</th>
                <td><input type="text" name="Month_Day" id="Month_Day" value="" size="10" /></td>
            </tr>
            <tr>
                <th>Dia</th>
                <td><input type="text" name="Day" id="Day" value="" size="10" /></td>
            </tr>
            <tr>
                <th>Consultar</th>
                <td><input type="submit" value="Ejecutar Consulta" /></td>
            </tr>
            <tr>
                <th>Resultado</th>
                <td><input type="text" name="" value="<?php if(isset($TasaDiaria)) {echo $TasaDiaria;}; ?>C$" size="10" readonly="readonly" /></td>
            </tr>
        </tbody>
    </table>
</form>

<!--
Codigo de JavaScript
-->
<script>
    var Fecha=new Date();   //Declaramos una variable para tomar las Fechas
    var Ano=Fecha.getFullYear();    //Tomamos el año actual en la variable "Ano""
    var Mes=Fecha.getMonth()+1;   //Tomamos el mes actual en la variable "Mes"
    var Dia=Fecha.getDate();
    //Le sumamos 1, por que toma como mes inicial "0"
    document.getElementById('Year_Day').value = Ano;        //Asignamos al campo de texto "Year" el valor del Año
    document.getElementById('Month_Day').value = Mes;       //Asignamos al campo de texto "Month" el valor del Mes
    document.getElementById('Day').value = Dia;       //Asignamos al campo de texto "Day" el valor del Dia
</script>

<!--
FIN DE CODIGO DE CONSULTA POR MES
-->
