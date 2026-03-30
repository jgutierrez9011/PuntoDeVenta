<!--<img class="d-block mx-auto mb-4" src="../img/logosinfondo_2.png" alt="" width="112" height="102">-->

<?php
$path = '../img/logo';
$verimg = "";
if(file_exists($path)){
  $directorio = opendir($path);
     while ($archivo = readdir($directorio))
     {
       if(!is_dir($archivo)){
         $verimg = $verimg."
                             <img class='d-block mx-auto mb-4' src='../img/logo/$archivo' alt='' width='12%' height='auto' /> ";
       }
     }
      echo $verimg ;
}
?>
