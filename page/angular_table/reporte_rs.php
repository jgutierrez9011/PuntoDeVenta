<?php
require_once 'cn.php';
require_once 'reg.php';

/*CAMPAÑA REDES SOCIALES*/

/*se llama funcion para la conexion*/
$connect = new PDO('pgsql:host=172.27.32.75; port=5400; dbname=sac; user=postgres; password=gerenciaSAC.indc_6!');
$connect2 = conexion_bd(1);

$usuario =  $_SESSION["user"];

$sql ="SELECT g.intidempleado, 
g.strpnombre, 
g.strsnombre, 
g.strpapellido, 
g.strsapellido, 
case when  i.strtienda is null then n.strdistribuidor else i.strtienda end as tienda, 
k.strzona, 
case when l.strdepartamento is null then n.strdescripcionvia else l.strdepartamento end as departamento
from msgsac.tblcatempleado as g
left join msgsac.tbltrnempzona as h on g.intidempleado = h.intidempleado and h.bolactivo = 'True'
left join msgsac.tblcattienda as i on h.intidtienda = i.intidtienda
left join msgsac.tblcatdepartamentos as j on i.intiddepto = j.intiddepto
left join msgsac.tblcatzonas as k on j.intidzona = k.intidzona
left join msgsac.tblcatdepartamentosnic as l on j.intiddptonic = l.intiddptonic
left join msgsac.tblcatviaatencion as n on g.intidviaatencion = n.intidvia
       where g.strcorreo = '$usuario' ";

$resul = pg_query($connect2,$sql);
$row = pg_fetch_array($resul);
$tienda = $row['tienda'];
$departamento = $row['departamento'];
$primer_nombre = $row['strpnombre'];
$segundo_nombre = $row['strsnombre'];
$primer_apellido = $row['strpapellido'];


$Y = date("Y");
  $M = date("m");
  $idperiodo = $Y."".$M;
 /*where distribuidor = '".$tienda."*/
$query = "SELECT * FROM renovaciones.vw_reporte_camp_rs_canales" ;



$statement = $connect->prepare($query);

$statement->execute();

while($row = $statement->fetch(PDO::FETCH_ASSOC))
{
 $data2[] = $row;
}

echo json_encode($data2);

?>