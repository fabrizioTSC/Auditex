<?php 
	function contentMenu(){
?>	
	<div class="menuContent" style="height: 1080px;">
		<div class="spaceMenu">
			<div class="userSpace">
				<div class="titleversion">AUDITEX v2.0 - 01/04/2020</div>
				<img src="assets/img/user.png" class="imgUser">
				<div class="detailUser" style="font-weight: bold; font-size: 13px; padding-bottom: 3px;">
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
					?>
				</div>
				<div class="detailUser"><?php echo $_SESSION['user'];?></div>
			</div>
			<div class="lineDecoration"></div>
			<div class="itemsMenu" onclick="redirect('main.php')">Inicio</div>
			<div class="itemsMenu" onclick="redirect('CambiarPassword.php')">Cambiar contrase&ntilde;a</div>
			<div class="itemsMenu" onclick="redirect('../../dashboard/')">Men&uacute; principal</div>
			<div class="itemsMenu" onclick="redirect('../../dashboard/logout.php?operacion=logout')">Salir</div>
		</div>
	</div>
<?php
	}
	function getGeneralContent(){
?>
	<div class="bodyContent mainBodyContent" style="padding-top: 0px;">
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('GenRep.php')">
					<div class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">Generar reportes</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('EmiRep.php')">
					<div class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">Emitir reportes</div>
				</div>
			</div>
		</div>
	</div>
<?php
	}
?>