<?php 
	function contentMenu(){
?>	
	<div class="menuContent">
		<div class="spaceMenu">
			<div class="userSpace">
				<div class="titleversion"></div>
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

			<div class="itemsMenu" onclick="redirect('CambiarPassword.php')">Cambiar contrase&ntilde;a</div>
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
				<div class="bodySpecialButton" onclick="redirect('IniciarAudConHum.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REGISTRAR AUDITORIA DE CONTROL DE HUMEDAD</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ConsultarAudConHum.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">CONSULTAR AUDITORIA DE CONTROL DE HUMEDAD</div>
				</div>
			</div>
			<!--
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('SeleccionIndicadorResultado.php')">
					<div class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTE INDICADOR DE RESULTADOS</div>
				</div>
			</div>-->
		</div>
		<!--
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('SeleccionReporteGeneral.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTE GENERAL</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ReporteAuditorFecha.php')">
					<div class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTE DE N&Uacute;MERO DE AUDITOR&Iacute;AS POR AUDITOR/FECHA</div>
				</div>
			</div>
		</div>
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('EditarParametroReportes.php')">
					<div class="icon"><i class="fa fa-plus-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">CONFIGURAR PAR&Aacute;METRO REPORTES</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('SeleccionIndDef.php')">
					<div class="icon"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">INDICADOR DE DEFECTOS</div>
				</div>
			</div>
		</div>
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ConsultarEditarAuditoria.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">CONSULTAR / EDITAR AUDITORIA</div>
				</div>
			</div>
		</div>-->
	</div>
<?php
	}
?>