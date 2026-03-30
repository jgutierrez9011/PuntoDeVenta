<?php
require_once 'cn.php';
require_once 'reg.php';

$perfil=$_SESSION["intidperfil"];

function fill_tbl($nombretabla, $consulta)
{
  $conn = conexion_bd(1);
  $sql = $consulta;
  $result = pg_query($conn,$sql);

  $maxfilas = 0;
  $maxcolumna = pg_num_fields($result);
  $countcolumna = 0;

  $headertable = "";
  $bodytable = "";

  for ($i = 0; $i < pg_num_fields($result); $i++)
  {
   $namecolum = "";
   $namecolum = trim(strtoupper(pg_field_name($result, $i)));

    if($i == 0)
    {
      $headertable = "<div class='row table-responsive'>
                      <table id='".$nombretabla."' class='display nowrap table-bordered' style='width:100%'>
                      <thead class='thead-dark'>
                           <tr>";

      $headertable = $headertable . "<th><p class=''><strong>". $namecolum. "</p></th>";

    }
    elseif ($i == $maxcolumna - 1)
    {

        $headertable = $headertable . "<th><p class=''><strong>". $namecolum. "</p></th>";

        $headertable =  $headertable . "</tr>
                                            </thead>";

    }
    else
    {
         $headertable =  $headertable . "<th><p class=''><strong>".$namecolum."</p></th>";
    }
  }

  pg_result_seek($result, 0);
  $maxfilas = pg_num_rows($result);
  $maxcolumna = pg_num_fields($result);
  $countrows = 0 ;
  $dato = "";

  while($row = pg_fetch_row($result))
  {
    $countrows +=1;
    //Cuando la tabla tiene solo un registro
    if(($countrows == 1) && ($countrows == $maxfilas))
    {
      $bodytable = "<tbody>";
      $bodytable =  $bodytable . "<tr>";
              for($j=0; $j<pg_num_fields($result);$j++)
              {
                      //echo "Entrada dos";
                      $dato = trim($row[$j]);
                      $bodytable = $bodytable. "<td><p class=''>".$dato."</p></td>";

              }
      $bodytable =  $bodytable . "</tr>";
      $bodytable = $bodytable ."</tbody>  </table> </div>";
    }
    //Cuando la tabla tiene mas de un registro y es la primera iteracion.
    elseif( ($countrows == 1) && ($countrows <> $maxfilas) )
    {
      $bodytable = "<tbody>";
      $bodytable =  $bodytable . "<tr>";
              for($j=0; $j<pg_num_fields($result);$j++)
              {
                 $dato = trim($row[$j]);
                 $bodytable = $bodytable. "<td><p class=''>".$dato."</p></td>";
               }
      $bodytable =  $bodytable . "</tr>";
    //Cuando va mas de una iteracion y no ha llegado al maximo de filas
      }elseif ( ($countrows > 1) && ($countrows <> $maxfilas) ) {
      $bodytable =  $bodytable . "<tr>";
                for($j=0; $j<pg_num_fields($result);$j++)
                {
                        $dato = trim($row[$j]);
                        $bodytable = $bodytable. "<td><p class=''>".$dato."</p></td>";
                }
      $bodytable =  $bodytable . "</tr>";

      }elseif ( ($countrows > 1) && ($countrows == $maxfilas) )
      {
         $bodytable =  $bodytable . "<tr>";
                    for($j=0; $j<pg_num_fields($result);$j++)
                    {
                            $dato = trim($row[$j]);
                            $bodytable = $bodytable. "<td><p class=''>".$dato."</p></td>";
                    }
         $bodytable =  $bodytable . "</tr>";
         $bodytable = $bodytable ."</tbody>  </table></div>";
      }
  }
  echo $headertable . $bodytable;
}


?>
