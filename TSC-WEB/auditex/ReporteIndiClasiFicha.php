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
<html lang="es">
<head>
	<title>AUDITEX</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/IndicadorResultado-v1.0.css">
	<link rel="stylesheet" type="text/css" href="css/IndicadorClasiFicha-v1.0.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<script src="charts-dist/Chart.min.js"></script>
</head>
<body>
	<?php contentMenu();?>
	<div class="panelCarga" style="display: block;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="mainContent">		
		<div class="headerContent">
			<div class="headerTitle">Indicador Clasi. Ficha</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent" style="padding-bottom: 0px;">	
			<div class="rowLine" style="margin-bottom: 5px">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="downloadPDF()">Descargar PDF</button>
			</div>
			<div class="lblNew" id="spacetitulo"></div>
			<div class="spaceForMainCharts">
				<div class="firstGraph chartsMain">
					<div class="contentGraph" style="padding: 5px 0px;">
						<canvas id="chart-areames"></canvas>
					</div>
				</div>
				<div class="spaceBMain"></div>
				<div class="firstGraph chartsMain">
					<div class="contentGraph" style="padding: 5px 0px;">
						<canvas id="chart-areasem"></canvas>
					</div>
				</div>
			</div>
			<div class="lineDecoration"></div>
			<div class="firstGraph">
				<div class="contentGraph" style="padding-top: 5px;">
					<canvas id="chart-area1"></canvas>
				</div>
			</div>
			<div class="lineDecoration"></div>
			<div class="firstGraph" id="spaceForGraph2" style="display: none;">
				<div class="contentGraph" style="padding-top: 5px;">
					<canvas id="chart-area2"></canvas>
				</div>
			</div>
			<div class="firstGraph" id="spaceForGraph3" style="display: none;">
				<div class="contentGraph" style="padding-top: 5px;">
					<canvas id="chart-area3"></canvas>
				</div>
			</div>
			<div class="firstGraph" id="spaceForGraph4" style="display: none;">
				<div class="contentGraph" style="padding-top: 5px;">
					<canvas id="chart-area4"></canvas>
				</div>
			</div>
			<div class="firstGraph" id="spaceForGraph5" style="display: none;">
				<div class="contentGraph" style="padding-top: 5px;">
					<canvas id="chart-area5"></canvas>
				</div>
			</div>
			<div class="firstGraph" id="spaceForGraph6" style="display: none;">
				<div class="contentGraph" style="padding-top: 5px;">
					<canvas id="chart-area6"></canvas>
				</div>
			</div>
			<div class="firstGraph" id="spaceForGraph7" style="display: none;">
				<div class="contentGraph" style="padding-top: 5px;">
					<canvas id="chart-area7"></canvas>
				</div>
			</div>
			<div class="firstGraph" id="spaceForGraph8" style="display: none;">
				<div class="contentGraph" style="padding-top: 5px;">
					<canvas id="chart-area8"></canvas>
				</div>
			</div>
			<div class="firstGraph" id="spaceForGraph9" style="display: none;">
				<div class="contentGraph" style="padding-top: 5px;">
					<canvas id="chart-area9"></canvas>
				</div>
			</div>

			<div class="firstGraph" id="spaceForGraph10" style="display: none;">
				<div class="contentGraph" style="padding-top: 5px;">
					<canvas id="chart-area10"></canvas>
				</div>
			</div>

			<div class="firstGraph" id="spaceForGraph11" style="display: none;">
				<div class="contentGraph" style="padding-top: 5px;">
					<canvas id="chart-area11"></canvas>
				</div>
			</div>
			<div class="firstGraph" id="spaceForGraph12" style="display: none;">
				<div class="contentGraph" style="padding-top: 5px;">
					<canvas id="chart-area12"></canvas>
				</div>
			</div>

			<div class="lblNew" id="spacetitulo-2"></div>
			<div class="contentTbl">
				<div class="lateralHeAders" id="idHeaderLateral">
					<div class="items1">SERVICIOS EXTERNOS CHINCHA</div>
					<div class="items1 items2">PRIMERAS</div>
					<div class="items1 items2">% PRIMERAS</div>
					<div class="items1 items2">MANCHAS POR PLANTA</div>
					<div class="items1 items2">% MANCHAS POR PLANTA</div>
				</div>
				<div class="contents" id="placeAnios">
				</div>
				<div class="contents" id="placeMeses">
				</div>
				<div class="contents" id="placeSemanas">
				</div>
			</div>
			<div class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;width: 135px;
			padding: 5px;display: flex;padding-left: 20px;" 
			onclick="exportar('<?php echo $_GET['codtll']; ?>','<?php echo $_GET['codsede']; ?>','<?php echo $_GET['codtipser']; ?>')">
				<img src="assets/img/excel.png" style="width: 30px;height: 30px;">
				<div style="padding: 5px;width:calc(80px);text-align: center;">Descargar</div>
			</div>
			<div class="lineDecoration"></div>
		</div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<!-- <button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="redirect('ReportesAuditoria.php')">Volver</button> -->
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="goBack()">Volver</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript">
		var codtll="<?php echo $_GET['codtll']; ?>";
		var codsede="<?php echo $_GET['codsede']; ?>";
		var codtipser="<?php echo $_GET['codtipser']; ?>";
	</script>
	<script type="text/javascript" src="js/IndicadorClasiFicha-v1.2.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		function goBack(){
			window.history.back();
		}
	</script>
</body>
</html>