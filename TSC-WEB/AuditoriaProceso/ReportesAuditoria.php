<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="6";
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
	<!-- Iconos de fuente externa -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
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
					<div class="bodySpecialButton" onclick="redirect('Reporte1.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton addPaddings">Reporte Ratio de n&uacute;mero de veces de auditoría</div>
					</div>
				</div>
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('Reporte2.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">Reporte Ratio de n&uacute;mero de veces de auditoría por taller</div>
					</div>
				</div>
			</div>
			<div class="rowLine" style="display: flex;">
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('Reporte3.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">Porcentaje de Defectos por Defectos y Rango de fechas</div>
					</div>
				</div>
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('Reporte4.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">Porcentaje de Defectos por Talleres, Defectos y Rango de fechas</div>
					</div>
				</div>
			</div>			
			<div class="rowLine" style="display: flex;">
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('Reporte5.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">Porcentaje de Defectos por Talleres y Rango de fechas</div>
					</div>
				</div>
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('ResultadosAuditoria.php')">
						<div class="icon" style="padding-bottom: 0px;"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
						<div class="detailSpecialButton addPaddingsThree">Reporte general</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
	<script type="text/javascript" src="js/index.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>