<?php 
	function contentMainHeader(){
?>	
    <nav class="navbar navbar-inverse" style="background-color: #922B21;">
        <div class="container-fluid">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><img alt="Brand" src="./Admin/img/logo.png" width="60px"></a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#" style="color: #ffffff;"> 
                            <span class="tperfil"> 
                                <?php 
                                    if ($_SESSION['perfil']==1) {
                                        echo "ADMINISTRADOR";
                                    }else{
                                        if ($_SESSION['perfil']==2) {
                                            echo "EJECUTIVO";
                                        }else{
                                            if ($_SESSION['perfil']==3) {
                                                echo "AUDITOR";
                                            }else{
                                                echo "CONTROLADOR";
                                            }
                                        }
                                    }
                                ?>: 
                            </span>  
                            <span class="tuser"><?php echo $_SESSION["user"]; ?></span>  
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false"><span class="glyphicon glyphicon-th" aria-hidden="true"
                                style="color: #ffffff;"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a href="main1.php">Men&uacute; principal</a></li>
                            <li><a href="logout.php?operacion=logout">Salir</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

<?php
	}
?>