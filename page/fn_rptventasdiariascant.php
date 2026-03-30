<?php
require_once 'cn.php';
require_once 'reg.php';

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
   $namecolum = trim(strtoupper (pg_field_name($result, $i)));

    if($i == 0)
    {
      $headertable = "<div class='row table-responsive'>
                      <table id='".$nombretabla."' class='display nowrap table-bordered' style='width:100%'>
                      <thead class='thead-dark'>
                           <tr>";

      $headertable = $headertable . "<th><p class='small'><strong>". $namecolum. "</p></th>";

    }
    elseif ($i == $maxcolumna - 1)
    {

        $headertable = $headertable . "<th><p class='small'><strong>". $namecolum. "</p></th>";

        $headertable =  $headertable . "</tr>
                                            </thead>";

    }
    else
    {
         $headertable =  $headertable . "<th><p class='small'><strong>".$namecolum."</p></th>";
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
                      $dato = trim(strtoupper ($row[$j]));
                      $bodytable = $bodytable. "<td><p class='small'>".$dato."</p></td>";

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
                 $dato = trim(strtoupper ($row[$j]));
                 $bodytable = $bodytable. "<td><p class='small'>".$dato."</p></td>";
               }
      $bodytable =  $bodytable . "</tr>";
    //Cuando va mas de una iteracion y no ha llegado al maximo de filas
      }elseif ( ($countrows > 1) && ($countrows <> $maxfilas) ) {
      $bodytable =  $bodytable . "<tr>";
                for($j=0; $j<pg_num_fields($result);$j++)
                {
                        $dato = trim(strtoupper ($row[$j]));
                        $bodytable = $bodytable. "<td><p class='small'>".$dato."</p></td>";
                }
      $bodytable =  $bodytable . "</tr>";

      }elseif ( ($countrows > 1) && ($countrows == $maxfilas) )
      {
         $bodytable =  $bodytable . "<tr>";
                    for($j=0; $j<pg_num_fields($result);$j++)
                    {
                            $dato = trim(strtoupper ($row[$j]));
                            $bodytable = $bodytable. "<td><p class='small'>".$dato."</p></td>";
                    }
         $bodytable =  $bodytable . "</tr>";
         $bodytable = $bodytable ."</tbody>  </table></div>";
      }
  }
  echo $headertable . $bodytable;
}

function fn_create_temp_table($fechaini,$fechafin)
{
  try {
    $conn = conexion_bd(1);

    $table_part1 = 'CREATE TEMPORARY TABLE temp_ventas_dia_cant';
    $table_part2 = '(clasificador text, tipo text, producto text,';
    $table_part3 = '';

    $sql = "SELECT date_trunc('day',dd)::date from
            generate_series('$fechaini'::timestamp,'$fechafin'::timestamp,'1 day'::interval) dd";

    $result = pg_query($conn,$sql);
    $maxfilas = pg_num_rows($result);
    $contador = 0;

     while($row_rango_dias = pg_fetch_row($result))
     {
       $contador +=1;

       if($contador < $maxfilas)
       {

         $table_part3 = $table_part3.'"'.$row_rango_dias[0].'" numeric,';

       }elseif ($contador == $maxfilas) {

          $table_part3 = $table_part3.'"'.$row_rango_dias[0].'" numeric);';

       }

     }

     return $table_part1.$table_part2.$table_part3;

  } catch (\Exception $e) {

  }
}

function fn_select_table ($fechaini,$fechafin)
{
  try {
    $conn = conexion_bd(1);

    $table_part1 = '';

    $sql = "SELECT date_trunc('day',dd)::date from
            generate_series('$fechaini'::timestamp,'$fechafin'::timestamp,'1 day'::interval) dd";

    $result = pg_query($conn,$sql);
    $maxfilas = pg_num_rows($result);
    $contador = 0;

     while($row_rango_dias = pg_fetch_row($result))
     {
       $contador +=1;

       if($contador < $maxfilas)
       {

         $table_part1 = $table_part1.'"'.$row_rango_dias[0].'",';

       }elseif ($contador == $maxfilas) {

          $table_part1 = $table_part1.'"'.$row_rango_dias[0].'"';

       }

     }

     return $table_part1;

  } catch (\Exception $e) {

  }
}


function fn_script_ingresoVentas_cantidad($fechaini, $fechafin)
{
  try {

    $conn = conexion_bd(1);
    $rango_dias = " 'VALUES (";
    $rango_dias_num = " ct ( periodo text, ";
    $rango_dias_suma = '';
    $rango_dias_select = '';
    $create_temp_table = fn_create_temp_table($fechaini,$fechafin);
    $campos_fecha = fn_select_table ($fechaini,$fechafin);

    $sql = "SELECT to_char(date_trunc('day',dd)::date,'dd') dia from
            generate_series('$fechaini'::timestamp,'$fechafin'::timestamp,'1 day'::interval) dd";

    $result = pg_query($conn,$sql);
    $maxfilas = pg_num_rows($result);
    $contador = 0;

     while($row_rango_dias = pg_fetch_row($result))
     {
       $contador +=1;

       if($contador < $maxfilas)
       {

         $rango_dias = $rango_dias."''".$row_rango_dias[0]."''::text), (";

         $rango_dias_num = $rango_dias_num.'"'.$row_rango_dias[0].'" numeric, ';

         //round(coalesce(sum("01"),0),2) "Día 1",

         $rango_dias_suma = $rango_dias_suma.'round(coalesce(sum("'.$row_rango_dias[0].'"),0),2) "'.$row_rango_dias[0].'", ';

         $rango_dias_select = $rango_dias_select.'"'.$row_rango_dias[0].'",';

       }elseif ($contador == $maxfilas) {

         $rango_dias = $rango_dias."''".$row_rango_dias[0]."''::text)'::text) ";

         $rango_dias_num = $rango_dias_num.'"'.$row_rango_dias[0].'" numeric) ';

         $rango_dias_suma = $rango_dias_suma.'round(coalesce(sum("'.$row_rango_dias[0].'"),0),2) "'.$row_rango_dias[0].'"';

         $rango_dias_select = $rango_dias_select.'"'.$row_rango_dias[0].'"';

       }

     }

     //echo $rango_dias.$rango_dias_num;
     //echo $rango_dias_suma;

    $sentencia_part1 ="SELECT
                       CASE WHEN split_part(periodo,'-',2) <> 'SUSCRIPCIONES'  THEN 'REVOLVENTE'
                       ELSE split_part(periodo,'-',2) END clasificador,
                       split_part(periodo,'-',2) tipo,
                       split_part(periodo,'-',3) producto,";

    $sentencia_part2 = " FROM crosstab('
                        select
                        CONCAT(to_char(b.datfechacreo::date,''YYYYMMDD''),''-'',e.strtipo,''-'',d.strnombre) periodo,
                        to_char(b.datfechacreo::date,''DD'') dia,
                        sum(b.numcantidad) cantidad_total
                        FROM public.tblcatfacturaencabezado a
                        inner join public.tblcatfacturadetalle b on a.intidserie = b.intidfactura
                        inner join tblcatclientes c on a.intidcliente = c.intidcliente
                        inner join tblcatproductos d on b.intidproducto = d.intidproducto
                        inner join tblcattipoproducto e on d.strtipo::integer = e.intidtipoproducto
                        group by 1,2
                        order by 1 asc'::text,";

    $sentencia_part3 = "where split_part(periodo,'-',1)::date between '$fechaini'::date and '$fechafin'::date
                        group by 1,2,3";

    $new_setencia = $sentencia_part1.$rango_dias_suma.$sentencia_part2.$rango_dias.$rango_dias_num.$sentencia_part3;

    $sentencia_insert = "INSERT INTO temp_ventas_dia_cant";

    return "DROP TABLE IF EXISTS temp_ventas_dia_cant; ".$create_temp_table." ".$sentencia_insert." ".$new_setencia."; "."SELECT tipo, producto, ".$campos_fecha." FROM temp_ventas_dia_cant;";

  } catch (\Exception $e) {

  }
}

?>
