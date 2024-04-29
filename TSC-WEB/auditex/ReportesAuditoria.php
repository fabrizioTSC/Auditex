<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="10";
	include("config/_validate_access.php");
	include("config/_contentMenu.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>AUDITEX</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="css/resize-button-v1.0.css">
</head>
<body>
	<?php contentMenu();?>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Reportes</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">			
			<div class="rowLine" style="display: flex;">			
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('ReporteAuditorFecha.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">Reporte de n&uacute;mero de auditor&iacute;as por Auditor/Fecha</div>
					</div>
				</div>
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('ResultadosAuditoria.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">Reporte general</div>
					</div>
				</div>
			</div>
			<div class="rowLine" style="display: flex;">
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('SeleccionIndicadorResultado2.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">Indicador de Resultados de Auditor&iacute;a Final Costura</div>
					</div>					
				</div>
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('Reporte2.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">Reporte nivel de sobreauditor&iacute;as por taller</div>
					</div>
				</div>
			</div>
			<div class="rowLine" style="display: flex;">
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('Reporte4.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">Porcentaje de Defectos por Talleres, Defectos y Rango de fechas</div>
					</div>
				</div>
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('Reporte5.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">Porcentaje de Defectos por Talleres y Rango de fechas</div>
					</div>
				</div>				
			</div>
			<div class="rowLine" style="display: flex;">
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('FiltroIndicadorClasiFicha.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">Indicador de Clasificaci&oacute;n Ficha</div>
					</div>
				</div>
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('FiltroReporteRangoLinea.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">Reporte ranking Lineas/Servicios</div>
					</div>					
				</div>	
			</div>
			<div class="rowLine" style="display: flex;">
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('SeleccionFormatoAudFin.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">Detalle Auditoria Final</div>
					</div>
				</div>
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('FiltroRepRegClasi.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">Reporte Auditor&iacute;as Aprobadas sin Clasificaci&oacute;n</div>
					</div>
				</div>
			</div>
			<div class="rowLine" style="display: flex;">
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('FiltroIndicadorDefectos.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">Indicador de Defectos</div>
					</div>
				</div>
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('SeleccionEvolucionIndicador.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">Evoluci&oacute;n de indicadores</div>
					</div>
				</div>
			</div>
			<div class="rowLine" style="display: flex;">
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('FiltroFichasSinIniciar.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">Reporte de fichas sin iniciar</div>
					</div>
				</div>
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('FiltroFichasSinTerminar.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">Reporte de fichas sin terminar</div>
					</div>
				</div>
			</div>
			<div class="rowLine" style="display: flex;">
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('FiltroFichasInicioAutomatico.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">Reporte de fichas iniciadas automaticamente</div>
					</div>
				</div>
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('FiltroFichasIniTer.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">Reporte de fichas iniciadas o terminadas</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
	<script type="text/javascript" src="js/index-v1.1.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>