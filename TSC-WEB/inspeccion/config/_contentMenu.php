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
		<!--
			<div class="itemsMenu" onclick="redirect('main.php')">Inicio</div>
			<div class="itemsMenu" onclick="redirect('../../dashboard/')">Men&uacute; principal</div>
			<div class="itemsMenu" onclick="redirect('config/logout.php')">Salir</div>
		-->
			<div class="itemsMenu" onclick="redirect('../../../dashboard/')">Men&uacute; principal</div>
			<div class="itemsMenu" onclick="redirect('../../../dashboard/logout.php?operacion=logout')">Salir</div>
		
		</div>
	</div>
<?php
	}
	function getInspectorContent(){
?>	
	<div class="bodyContent mainBodyContent">			
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('IniciarInspeccion.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REGISTRAR INSPECCI&Oacute;N</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ConsultarEditarInspeccion.php')">
					<div class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">CONSULTAR INSPECCI&Oacute;N</div>
				</div>
			</div>
		</div>				
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ReporteInspeccion.php')">
					<div class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTE INSPECCI&Oacute;N</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('RegistroCuotasHoras.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REGISTRO DE CUOTAS Y HORAS</div>
				</div>
			</div>
		</div>			
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('MenuReporteMonitor.php')">
					<div class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTE MONITOR</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('EditarParametroReportes.php')">
					<div class="icon"><i class="fa fa-plus-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">CONFIGURAR PAR&Aacute;METRO REPORTES</div>
				</div>
			</div>
		</div>		
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('MenuReporteLineas.php')">
					<div class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTE DE EFICACIA DE COSTURA</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('FiltroIndicadorResultados.php')">
					<div class="icon"><i class="fa fa-plus-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">INDICADOR DE RESULTADOS</div>
				</div>
			</div>
		</div>	
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ReporteTurnos.php')">
					<div class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTE GERENCIAL POR TURNOS</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('MenuReporteTurnos.php')">
					<div class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTE GERENCIAL POR TURNOS - HIST&Oacute;RICO</div>
				</div>
			</div>
		</div>			
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('RegistroMinCom.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REGISTRO MINUTOS DE COMPENSACI&Oacute;N POR FICHA</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('RegistroMinComEstTsc.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REGISTRO MINUTOS DE COMPENSACI&Oacute;N POR ESTILO</div>
				</div>
			</div>
		</div>		
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ReporteEvolucionOpeHor.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REGISTRO EVOLUCI&Oacute;N OPERACIONES POR HORA</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ReporteEvolucionDefHor.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REGISTRO EVOLUCI&Oacute;N DEFECTOS POR HORA</div>
				</div>
			</div>
		</div>	
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('SeleccionMinCom.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTE DE REGISTRO MINUTOS COMPENSADOS POR FICHA</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('SeleccionMinComEst.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTE DE REGISTRO MINUTOS COMPENSADOS POR ESTILO</div>
				</div>
			</div>
		</div>
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('SeleccionReporteRankingDefectos.php')">
					<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTE DE PORCENTAJE DE PRENDAS DEFECTUOSAS POR L&Iacute;NEA/TURNO</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('SeleccionEfiEfcLin.php')">
					<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">INDICADOR DE EFICIENCIA Y EFICACIA DE LINEAS</div>
				</div>
			</div>
		</div>
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ActualizarHisEfiLin.php')">
					<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">ACTUALIZAR HISTORICO EFICIENCIA LINEAS</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('SeleccionReporteDefectos.php')">
					<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTE DEFECTOS DE INSPECCI&Oacute;N</div>
				</div>
			</div>
		</div>
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('SeleccionIndicadorDefectos.php')">
					<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">INDICADOR DE DEFECTOS</div>
				</div>
			</div>
		</div>

	</div>
<?php
	}
?>