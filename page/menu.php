<?php
require_once 'cn.php';
require_once 'encabezado.php';


if (!empty($_SESSION["user"]))
{

  $usersac = $_SESSION["user"];
  $idemp   = base64_encode($_SESSION["idusuario"]);

  $con = conexion_bd(1);

  $menu = "<nav class='navbar navbar-default navbar-static-top' role='navigation' style='margin-bottom: 0'>
      <div class='navbar-header'>
          <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-collapse'>
              <span class='sr-only'>Toggle navigation</span>
              <span class='icon-bar'></span>
              <span class='icon-bar'></span>
              <span class='icon-bar'></span>
          </button>
          <a class='navbar-brand' href='login.php'>Admin GYM</a>";

  $menuhorizontal = "SELECT b.idperfil, c.strtipomenu, c.strmenu, c.strhref, c.strclassicono
                     FROM tblcatusuario as a
                     inner join tblcatmenuperfil as b on a.intidperfil = b.idperfil
                     inner join tblcatmenu as c on b.intidmenu = c.intidmenu
                     where a.strcorreo = '$usersac' and b.bolactivo = 'True' and a.bolactivo = 'True' and c.strnivelmenu = '0' and c.strtipomenu <> 'mnu-dropdown'
                     order by c.intidmenu asc";

  $resulmenuhorizontal = pg_query($con,$menuhorizontal);

  $filas_menuhorizontal = pg_num_rows($resulmenuhorizontal);

  if ($filas_menuhorizontal > 0)
  {
      while($row_menuhorizontal = pg_fetch_array($resulmenuhorizontal))
      {
                $menuhorizontal = $row_menuhorizontal['strmenu'] ; $menuhorizontalref = $row_menuhorizontal['strhref'];
                $menu = $menu."<a class='navbar-brand' href='$menuhorizontalref'>$menuhorizontal</a>";
      }
  }

  $menu=$menu."</div>
      <!-- /.navbar-header -->

      <ul class='nav navbar-top-links navbar-right'>";

          $menuhorizontal_tolbar = "SELECT b.idperfil, c.strtipomenu, c.strmenu, c.strhref, c.strclassicono
                             FROM tblcatusuario as a
                             inner join tblcatmenuperfil as b on a.intidperfil = b.idperfil
                             inner join tblcatmenu as c on b.intidmenu = c.intidmenu
                             where a.strcorreo = '$usersac' and b.bolactivo = 'True' and a.bolactivo = 'True' and c.strnivelmenu = '0' and c.strtipomenu = 'mnu-dropdown'
                             order by c.intidmenu desc";

          $resulmenuhorizontal_tolbar = pg_query($con,$menuhorizontal_tolbar);

          $filas_menuhorizontal_tolbar = pg_num_rows($resulmenuhorizontal_tolbar);

          if ($filas_menuhorizontal_tolbar > 0)
          {
              while($row_menuhorizontal_tolbar = pg_fetch_array($resulmenuhorizontal_tolbar))
              {
                    if($row_menuhorizontal_tolbar['strmenu'] == 'Cliente unico')
                    {
                      $menu=$menu."
                      <!--comienza dropdown bases -->
                      <li class='dropdown'>
                          <a class='dropdown-toggle' href='".$row_menuhorizontal_tolbar['strhref']."' title='Cliente unico' style='background-color: #FF3333;'>
                              <i class='".$row_menuhorizontal_tolbar['strclassicono']."'  style='color: #FBF8F7'></i>
                          </a>
                              <!-- /.dropdown-bases -->
                      </li>";
                     }
                        if($row_menuhorizontal_tolbar['strmenu'] == 'Exportar bases')
                        {
                          $menu=$menu."
                          <!--comienza dropdown bases -->
                          <li class='dropdown'>
                              <a class='dropdown-toggle' data-toggle='dropdown' title='Exportar bases de indicadores' href='#' style='background-color: #FF3333;'>
                                  <i class='fa fa-tasks fa-fw' style='color: #FBF8F7'></i> <i class='fa fa-caret-down' style='color: #FBF8F7'></i>
                              </a>
                              <ul class='dropdown-menu dropdown-tasks
                                     <li class='divider'></li>
                                     <li>
                                         <a class='text-center' href='#'>
                                             <strong>Exportar bases en Excel</strong>
                                         </a>
                                     </li>
                                     <li class='divider'></li>

                                     <li>

                                     <a>
                                        <form action='exportbases.php' method='post'>
                                          <div class='form-group'>
                                               <label for='pwd'>Inicio:</label>
                                               <input type='date' class='form-control' id='finicio_tolbar'  name='finicio_tolbar' required>
                                          </div>
                                          <div class='form-group'>
                                               <label for='pwd'>Fin:</label>
                                               <input type='date' class='form-control' id='ffin_tolbar' name='ffin_tolbar' required>
                                          </div>
                                          <div class='form-group text-center'>
                                                <button type='submit'class='btn btn-success' id='btnexpbases'>
                                                <span class='glyphicon glyphicon-save'></span>
                                                Descargar archivo</button>
                                          </div>
                                        </form>
                                     </a>
                                     </li>

                                 </ul>
                                 <!-- /.dropdown-bases -->
                             </li>";
                        }
              }
          }

      $menu=$menu."<li class='dropdown'>
              <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
                  <i class='fa fa-user fa-fw'></i> <i class='fa fa-caret-down'></i>
                  $usersac
              </a>
              <ul class='dropdown-menu dropdown-user'>
                <!--  <li><a href='miperfil.php?codigo=$idemp'><i class='fa fa-gear fa-fw'></i> Mi perfil</a>
                  </li> -->
                <!--  <li><a href='password.php''><i class='fa fa-user fa-fw'></i>Cambiar mi contraseña</a>
                  </li> -->
                  <li><a href='#' onClick='return salir()'><i class='fa fa-sign-out fa-fw'></i> Salir</a>
                  </li>
              </ul>
              <!-- /.dropdown-user -->
         </li>
          <!-- /.dropdown -->
      </ul>
      <!-- /.dropdown -->

      <!-- /.navbar-top-links -->

      <div class='navbar-default sidebar' role='navigation'>
          <div class='sidebar-nav navbar-collapse'>
              <ul class='nav' id='side-menu'>";

    $sqlmenu = "SELECT b.idperfil, c.strtipomenu, c.strmenu, c.strhref, c.strclassicono
                FROM tblcatusuario as a
                inner join tblcatmenuperfil as b on a.intidperfil = b.idperfil
                inner join tblcatmenu as c on b.intidmenu = c.intidmenu
                where a.strcorreo = '$usersac' and b.bolactivo = 'True' and a.bolactivo = 'True' and c.strnivelmenu = '1'
                order by c.intidmenu asc";

    $resulmenu = pg_query($con,$sqlmenu);

    $filas_menu = pg_num_rows($resulmenu);

    if ($filas_menu > 0){

      while($row_menu = pg_fetch_array($resulmenu)){

            $href = $row_menu['strhref']; $icono = $row_menu['strclassicono']; $nombremenu = $row_menu['strmenu']; $idperfil = $row_menu['idperfil'];

            $tipomenu = $row_menu['strtipomenu'];

            $menu = $menu."<li><a href='$href'><i class='$icono'></i>$nombremenu<span class='fa arrow'></span></a>";

            $sqlsubmenu = "SELECT a.idperfilusrfrm, b.strformulario, b.strnombreform, a.bolactivo, c.strperfil, b.strkeymenu
                           FROM tblcatperfilusrfrm as a
                           inner join tblcatformularios as b on a.idfrm = b.idfrm
                           inner join tblcatperfilusr as c on a.idperfil = c.idperfil
                           WHERE a.idperfil= $idperfil and b.strkeymenu = '$tipomenu' and a.bolactivo = 'True'
                           order by a.idperfilusrfrm asc";

            $con_ = conexion_bd(1);

            $resulsubmenu = pg_query($con_,$sqlsubmenu);

            $filas_submenu = pg_num_rows($resulsubmenu);

            if ($filas_submenu > 0)
            {

                  $menu = $menu."<ul class='nav nav-second-level'>";

                  while($row_submenu = pg_fetch_array($resulsubmenu))
                  {

                    $href_submenu = $row_submenu['strnombreform']; $nombre_submenu = $row_submenu['strformulario'];

                    $menu = $menu."<li><a href='$href_submenu'>$nombre_submenu</a></li>";

                    $filas_submenu = $filas_submenu - 1;

                    if($filas_submenu == 0)
                             {$menu = $menu."</ul>
                                                <!-- /.nav-second-level -->
                                             </li>";
                             }
                  }

              }

              $filas_menu = $filas_menu - 1;

              if($filas_menu == 0)
                    {
                           $menu = $menu."</ul>
                                          </div>
                                                <!-- /.sidebar-collapse -->
                                          </div>
                                                <!-- /.navbar-static-side -->
                                          </nav>";
                    }

            else {
              $menu = $menu."<li>";
            }
        }

    }else{
      $menu = $menu."</ul>
                          </div>
                                <!-- /.sidebar-collapse -->
                          </div>
                                <!-- /.navbar-static-side -->
                          </nav>";
    }

    echo $menu;

 ?>
<?php
}else{
 ?>
 <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
     <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
             <span class="sr-only">Toggle navigation</span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" href="login.php">Admin GYM</a>
     </div>
     <!-- /.navbar-header -->

     <!--<ul class="nav navbar-top-links navbar-right">
         <li class="dropdown">
             <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                 <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
             </a>
             <ul class="dropdown-menu dropdown-user">
                 <li><a href="#"><i class="fa fa-user fa-fw"></i> Perfil</a>
                 </li>
                 <li><a href="#"><i class="fa fa-gear fa-fw"></i> Ajustes</a>
                 </li>
                 <li class="divider"></li>
                 <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
                 </li>
             </ul>
             <!-- /.dropdown-user -->
      <!--  </li> -->
         <!-- /.dropdown -->
  <!--   </ul>  -->
     <!-- /.navbar-top-links -->

     <div class="navbar-default sidebar" role="navigation">
         <div class="sidebar-nav navbar-collapse">
             <ul class="nav" id="side-menu">
                 <!--<li>
                   <a href="dashboard.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard<span class="fa arrow"></span></a>
                </li>-->
                <!-- <li>
                     <a href="bases.php"><i class="fa fa-database fa-fw"></i> Bases indicadores SAC<span class="fa arrow"></span></a>
                 </li> -->
              <!--   <li>
                     <a href="#"><i class="fa fa-edit fa-fw"></i> Formularios<span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                         <li>
                             <a href="traslados.php">Traslados</a>
                         </li>
                         <li>
                             <a href="claroclub.php">Claro Club</a>
                         </li>
                         <li>
                             <a href="posprepago.php">POS Prepago</a>
                         </li>
                     </ul> -->
                     <!-- /.nav-second-level -->
              <!--   </li> -->
              <!--    <li>
                     <a href="#"><i class="fa fa-bell fa-fw"></i>Campañas<span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                         <li>
                             <a href="preapos.php">Pre A Pos</a>
                         </li>
                     </ul> -->
                     <!-- /.nav-second-level -->
               <!--   </li> -->
               <!--   <li>
                     <a href="#"><i class="fa fa-file-o fa-fw"></i> Archivos<span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                         <li>
                             <a href = "clinicaretension.php">Clinica de Retención</a>
                         </li>
                         <li>
                             <a href="distribuidores.php">Distribuidores</a>
                         </li>
                         <li>
                             <a href = "../bases/monitor diario sac.xlsx">Archivo para monitoreo diario</a>
                         </li>
                     </ul>  -->
                     <!-- /.nav-second-level -->
              <!--   </li> -->
            <!--     <li>
                     <a href="reel.html" target="_blank"><i class="fa fa-film fa-fw"></i> Reel<span class="fa arrow"></span></a>
                 </li>
                 <li>
                     <a href="#"><i class="fa fa-info-circle  fa-fw"></i> Información<span class="fa arrow"></span></a>
                 </li>   -->
             </ul>
         </div>
         <!-- /.sidebar-collapse -->
     </div>
     <!-- /.navbar-static-side -->
 </nav>

 <?php
}
  ?>
