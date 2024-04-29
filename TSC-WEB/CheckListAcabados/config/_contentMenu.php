<?php 
	function contentMenu(){
?>	
	<div class="menuContent">
		<div class="spaceMenu">
			<div class="userSpace">
				<div class="titleversion">CHECK LIST ACABADOS</div>
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
			<!-- <div class="itemsMenu" onclick="redirect('main.php')">Inicio</div>
			<div class="itemsMenu" onclick="redirect('../../dashboard/')">Men&uacute; principal</div>
			<div class="itemsMenu" onclick="redirect('config/logout.php')">Salir</div> -->

			<div class="itemsMenu" onclick="redirect('../../../dashboard/')">Men&uacute; principal</div>
			<div class="itemsMenu" onclick="redirect('../../../dashboard/logout.php?operacion=logout')">Salir</div>

		</div>
	</div>
<?php
	}
	function getGeneralContent(){
?>
	<div class="bodyContent mainBodyContent" style="padding-top: 10px;">		
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('IniciarCheckListAcabados.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REGISTRAR CHECK LIST ACABADOS</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ConsultarCheckListAcabados.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">CONSULTAR / EDITAR CHECK LIST ACABADOS</div>
				</div>
			</div>
		</div>
	</div>
<?php
	}
?>