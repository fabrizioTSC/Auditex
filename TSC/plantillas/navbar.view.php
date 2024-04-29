<!-- NAV -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-sistema" style="<?php echo isset($_GET["maxnavbar"]) ?  'height:8vh; ' : ''; ?>">

    <a class="navbar-brand font-weight-bold" href="#"><?php echo $_SESSION['navbar']; ?></a>

    <div class="ml-auto" >
        <a href="#"  role="button" data-toggle="dropdown" >
            <i class="fa fa-bars" style="color:white" aria-hidden="true"></i>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item text-center" href="#">
            <i class="fas fa-user fa-2x"></i>
                <?php

                        if ($_SESSION['perfil']==1) {
                            echo "<h5>ADMINISTRADOR</h5>";
                        }else{
                            if ($_SESSION['perfil']==2) {
                                echo "<h5>EJECUTIVO</h5>";
                            }else{
                                if ($_SESSION['perfil']==3) {
                                    echo "<h5>AUDITOR</h5>";
                                }else{
                                    echo "<h5>CONTROLADOR</h5>";
                                }
                            }
                        }
                        
                        echo "<h6>".$_SESSION['user']."</h6>";
                ?>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="/dashboard/">Menu Principal</a>
          <a class="dropdown-item" href="/dashboard/logout.php?operacion=logout">Salir</a>

        </div>

    </div>				
  <!-- </div> -->
  
</nav>