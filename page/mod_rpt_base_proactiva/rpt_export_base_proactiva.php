<?php
 ini_set('memory_limit', '4000M');
 require_once 'cn.php';
 require_once '../PHPExcel/Classes/PHPExcel/IOFactory.php';

/*function export_correciones($scrip)
{*/

$periodo_inicia = $_POST['fecha_ini'];
$periodo_finaliza = $_POST['fecha_fin'];
$reporte = $_POST['rpt_seleccionado'];



$scrip = "";

if($reporte == "REGISTROS_ACTUALIZADOS")
{
  $scrip = "SELECT 'REGISTROS ACTUALIZADOS' AS estado_del_caso, c.empleado as ejecutivo, a.*
  FROM qflow.tbl_base_proactiva a
  left join msgsac.vw_colaboradores c on a.ejecutivo_modifico = c.strcorreo
  WHERE length(a.ejecutivo_modifico) > 0 and a.fecha_modifico::date between '$periodo_inicia' and '$periodo_finaliza'";
}
elseif ($reporte == "REGISTROS_EN_BANDEJA")
{
  $scrip = "SELECT 'REGISTROS EN BANDEJA'::text AS estado_del_caso, c.empleado ejecutivo, a.*
  FROM qflow.tbl_base_proactiva a
  inner join qflow.tbl_temp_base_proactiva b on a.id = b.id
  inner join msgsac.vw_colaboradores c on b.usuario_sesion = c.strcorreo and length(c.strcorreo) > 0
  where (b.fecha_sesion)::date between '$periodo_inicia' and '$periodo_finaliza' ";
}
elseif ($reporte == "REACTIVOS_NO_INGRESADOS")
{
  $scrip = "SELECT * FROM qflow.tbl_sabana_qflows
WHERE idperiodo = 202101 AND hora_inicio::date between '$periodo_inicia' and '$periodo_finaliza'  and carnet_cierra in ('401739','401807','401965','401584')
AND upper(tipo) = 'WF' AND upper(nivel_iv) like '%WF%' AND caso not in (SELECT numero_qflow FROM qflow.tbl_qflow_vs_danos where ejecutivo_creo in ('ingridv.sanchez@claro.com.ni',
'juddyt.vargas@claro.com.ni',
'katherine.arce@claro.com.ni','kevin.estraram@claro.com.ni'));";
}
elseif ($reporte == "PROACTIVOS_NO_INGRESADOS")
{
  $scrip = "SELECT * FROM qflow.tbl_base_proactiva
            WHERE
            EJECUTIVO_MODIFICO IS NOT NULL AND observacion = 'CF– Contactado con Falla' AND fecha_modifico::date between '$periodo_inicia' and '$periodo_finaliza'
            AND CEDULA NOT IN (SELECT cedula_cliente FROM qflow.tbl_qflow_vs_danos where ejecutivo_creo in ('ingridv.sanchez@claro.com.ni',
            'juddyt.vargas@claro.com.ni',
            'katherine.arce@claro.com.ni','kevin.estraram@claro.com.ni'));";
}


// Instantiate a new PHPExcel object
$objPHPExcel = new PHPExcel();
//Start adding next sheets
$con = conexion_bd(1);

  $k=0;

  $result = pg_query($con,$scrip);
  // Add new sheet
  $objWorkSheet = $objPHPExcel->createSheet($k); //Setting index when creating

  // Initialise the Excel row number
   $rowCountcolum = 1;
   $field = 0;
   $column = 'A';

   for ($i = 1; $i < pg_num_fields($result); $i++)
  {
    $objWorkSheet->setCellValue($column.$rowCountcolum, pg_field_name($result, $i));
    $column++;
  }

  //start while loop to get data
  $rowCount = 2;
  while($row = pg_fetch_row($result))
  {
      $column = 'A';
      for($j=1; $j<pg_num_fields($result);$j++)
      {
          if(!isset($row[$j]))
              $value = NULL;
          elseif ($row[$j] != "")
              $value = strip_tags($row[$j]);
          else
              $value = "";

          $objWorkSheet->setCellValueExplicit($column.$rowCount, $value, PHPExcel_Cell_DataType::TYPE_STRING);
          $column++;
      }
      $rowCount++;
  }

  // Rename sheet


  $objWorkSheet->setTitle($reporte);

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="REPORTE_BASE_PROACTIVA.xls"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
ob_end_clean();
ob_start();
$objWriter->save('php://output');

/*}*/
?>
