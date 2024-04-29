<?php 
	function contentMenu(){
?>	
	<div class="menuContent">
		<div class="spaceMenu">
			<div class="userSpace">
				<img src="assets/img/user.png" class="imgUser">
				<div class="detailUser" style="font-weight: bold; font-size: 13px; padding-bottom: 3px;">
					INSPECTOR
				</div>
				<div class="detailUser"><?php echo $_SESSION['user'];?></div>
			</div>
			<div class="lineDecoration"></div>
		
			<div class="itemsMenu" onclick="redirect('../../dashboard/')">Men&uacute; principal</div>
			<div class="itemsMenu" onclick="redirect('../../dashboard/logout.php?operacion=logout')">Salir</div>

		
		</div>
	</div>
<?php
	}
	function getAuditorContent(){
?>
	<div class="bodyContent mainBodyContent">		
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
	</div>
	<div class="bodyContent" style="padding-top: 0px;">		
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('FiltroIndResAudPro.php')">
					<div class="icon"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">INDICADORES RESULTADOS AUDITORIA EN PROCESO</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('EditarParametroReportes.php')">
					<div class="icon"><i class="fa fa-plus-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">CONFIGURAR PAR&Aacute;METRO REPORTES</div>
				</div>
			</div>
		</div>
	</div>
<?php
	}
?>