<?php
require_once 'cn.php';

function fill_tipo_ingreso($val)
{
  $con = conexion_bd(1);

  $sql = pg_query($con,"SELECT * from
(
SELECT intidclasingreso, strnombrecategoria
FROM public.tblcatingresos
where boolactivo = true
union
select intidclasgasto, strnombrecategoria
from public.tblcatgastos
where boolactivo = true
)sub
order by strnombrecategoria asc");

  echo '<option value="">Seleccione</option>';
  while($row = pg_fetch_assoc($sql))
  {
    echo '<option value="'. $row['strnombrecategoria'].'"';

    if($row['strnombrecategoria']==$val )
    {
          echo "selected";
    }

    echo ">". $row['strnombrecategoria'] .'</option>';
  }
  pg_close($con);
}

function fn_tasa_cambio($con)
{
  $sql="SELECT monto from tblcattasacambio where fecha = current_date";
  $result = pg_query($con,$sql);
  $row = pg_fetch_array($result);
  echo $row['monto'];
}
 ?>
