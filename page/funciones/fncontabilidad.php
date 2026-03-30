<?php
require_once 'cn.php';
require_once 'reg.php';

if(isset($_POST['clasificacion']))
{
  fill_cat_ingresos($_POST['clasificacion']);
}

function fill_cat_ingresos($val)
{
  $con = conexion_bd(1);

  $sql = pg_query($con,"SELECT intidclasingreso, strnombrecategoria from tblcatingresos");


  echo '<option value="">Seleccione</option>';
  while($row = pg_fetch_assoc($sql))
  {
    echo '<option value="'. $row['intidclasingreso'].'"';

    if($row['intidclasingreso']==$val )
    {
          echo "selected";
    }

    echo ">". $row['strnombrecategoria'] .'</option>';
  }
  pg_close($con);
}

function fill_cat_gastos($val)
{
  $con = conexion_bd(1);

  $sql = pg_query($con,"SELECT intidclasgasto, strnombrecategoria from tblcatgastos");


  echo '<option value="">Seleccione</option>';
  while($row = pg_fetch_assoc($sql))
  {
    echo '<option value="'. $row['intidclasgasto'].'"';

    if($row['intidclasgasto']==$val )
    {
          echo "selected";
    }

    echo ">". $row['strnombrecategoria'] .'</option>';
  }
  pg_close($con);
}

function fill_cuenta($val)
{
  $con = conexion_bd(1);

  $sql = pg_query($con,"SELECT intidcuenta, strnombrecuenta, balanceinicial from tablcatcuentas");


  echo '<option value="">Seleccione</option>';
  while($row = pg_fetch_assoc($sql))
  {
    echo '<option value="'. $row['intidcuenta'].'"';

    if($row['intidcuenta']==$val )
    {
          echo "selected";
    }

    echo ">". $row['strnombrecuenta'] .' - Saldo: '.$row['balanceinicial'].'</option>';
  }
  pg_close($con);
}

 ?>
