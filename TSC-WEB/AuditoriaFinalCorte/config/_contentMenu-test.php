<?php 
	function contentMenu(){
?>	
	<div class="menuContent">
		<div class="spaceMenu">
			<div class="userSpace">
				<div class="titleversion">AUDITEX v1.5 - 25/04/2019</div>
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
			<div class="itemsMenu" onclick="redirect('config/logout.php')">Salir</div>
		</div>
	</div>
<?php
	}
	function getAdminContent(){
?>
	<div class="bodyContent mainBodyContent">			
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ActualizarRolUsuario.php')">
					<div class="icon"><i class="fa fa-users" aria-hidden="true"></i></div>
					<!--<div class="detailSpecialButton addPaddings">ACTULIZAR ROL DE USUARIO</div>-->
					<div class="detailSpecialButton">ACTUALIZAR ROL DE USUARIO</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ConsultarEditarAuditoria.php')">
					<div class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton addPaddings">CONSULTAR AUDITORIA</div>
				</div>
			</div>
		</div>		
	</div>
	<div class="bodyContent" style="margin-left: calc(25% - 10px);width: 50%;padding-top:0;">			
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent" style="width: 100%;padding-top:0;">
				<div class="bodySpecialButton" onclick="redirect('RegistrarAsignarAql.php')">
					<div class="icon"><i class="fa fa-plus-square-o" aria-hidden="true"></i></div>
					<!--<div class="detailSpecialButton addPaddings">ACTULIZAR ROL DE USUARIO</div>-->
					<div class="detailSpecialButton addPaddingsTwo">ASIGNAR AQL</div>
				</div>
			</div>
		</div>
	</div>
<?php
	}
	function getAuditorContent(){
?>
	<div class="bodyContent mainBodyContent">			
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('RegistrarAuditoria.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REGISTRAR AUDITORIA FINAL</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ConsultarEditarAuditoria.php')">
					<div class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton in3lines">CONSULTAR / EDITAR AUDITORIA</div>
				</div>
			</div>
		</div>
		<!--
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('IniciarAuditoriaProceso.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REGISTRAR AUDITORIA EN PROCESO</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ConsultarEditarAuditoriaProceso.php')">
					<div class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">CONSULTAR AUDITORIA EN PROCESO</div>
				</div>
			</div>
		</div>
		-->
	</div>
	<div class="bodyContent" style="margin-left: calc(25% - 10px);width: 50%;padding-top:0;">			
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent" style="width: 100%;padding-top:0;">
				<div class="bodySpecialButton" onclick="redirect('PartirFicha.php')">
					<div class="icon"><i class="fa fa-files-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton addPaddingsTwo">PARTIR FICHA</div>
				</div>
			</div>
		</div>
	</div>
<?php
	}
	//function getControladorContent(){
	function getGeneralContent(){
?>
	<div class="bodyContent" style="padding-top: 0px;">
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('IniciarFicha.php')">
					<div class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton addPaddingsTwo">INICIAR FICHAS</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('TerminarFicha.php')">
					<div class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton addPaddings">TERMINAR FICHAS</div>
				</div>
			</div>
		</div>
	</div>
	<div class="bodyContent" style="margin-left: calc(25% - 10px);width: 50%;padding-top:0;">			
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent" style="width: 100%;padding-top:0;">
				<div class="bodySpecialButton" onclick="redirect('ConsultarFichas.php')">
					<div class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton addPaddings">CONSULTAR FICHAS</div>
				</div>
			</div>
		</div>
	</div>
<?php
	}
	function getEjecutivoContent(){
?>
	<div class="bodyContent mainBodyContent">			
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ReportesAuditoria.php')">
					<div class="icon"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTES AUDITOR&Iacute;A FINAL</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ConsultarEditarAuditoria.php')">
					<div class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton addPaddings">CONSULTAR AUDITORIA</div>
				</div>
			</div>
		</div>
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('PartirFicha.php')">
					<div class="icon"><i class="fa fa-files-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton addPaddingsTwo">PARTIR FICHA</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('RegistrarAsignarAql.php')">
					<div class="icon"><i class="fa fa-plus-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton addPaddings">REGISTRAR / ASIGNAR AQL</div>
				</div>
			</div>
		</div>
	</div>	
	<div class="bodyContent" style="margin-left: calc(25% - 10px);width: 50%;padding-top:0;">			
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent" style="width: 100%;padding-top:0;">
				<div class="bodySpecialButton" onclick="redirect('RegistrarDefecto.php')">
					<div class="icon"><i class="fa fa-plus-square-o" aria-hidden="true"></i></div>
					<!--<div class="detailSpecialButton addPaddings">ACTULIZAR ROL DE USUARIO</div>-->
					<div class="detailSpecialButton addPaddings">REGISTRAR DEFECTO</div>
				</div>
			</div>
		</div>
	</div>
<?php
	}
?>