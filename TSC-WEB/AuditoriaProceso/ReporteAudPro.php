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
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="css/ReporteAudPro-v1.0.css">
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
			<div class="headerTitle">Reporte Aud. en Proceso</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="lblTitulo">REPORTE DE AUDITOR&Iacute;A EN PROCESO DE COSTURA - GENERAL</div>
			<div class="lblTitulo" id="titulodetalle"></div>
			<div class="firstGraph">
				<div class="contentGraph">
					<canvas id="chart-area"></canvas>
				</div>
			</div>
			<div class="contentTbl">
				<div class="lateralHeAders">
					<div class="items1">DETALLE GENERAL</div>
					<div class="items1 items2">PRENDAS APROB.</div>
					<div class="items1 items2">PRENDAS RECH.</div>
					<div class="items1 items2">TOTAL PRENDAS</div>
					<div class="items1">% APRO.</div>
					<div class="items1">% RECH.</div>
				</div>
				<div class="contents" id="placeAnios">
				</div>
				<div class="contents" id="placeMeses">
				</div>
				<div class="contents" id="placeSemanas">
				</div>
			</div>
			<div class="lineDecoration"></div>
			<div class="lblTitulo">DETALLE DE DEFECTOS</div>			
			<div class="lblTitulo"><span id="tit-uno"></span></div>
			<div class="firstGraph">
				<div class="contentGraph">
					<canvas id="chart-area2"></canvas>
				</div>
			</div>
			<div class="contentTbl" style="display: block;overflow: auto;">
				<div class="tblSpace" style="width: auto;">
					<div class="contentHeAders">
						<div class="items1" style="width: 60px;">N°</div>
						<div class="items1" style="width: 120px;">DEFECTOS</div>
						<div class="items1" style="width: 80px;">FRECUENCIA</div>
					</div>
					<div class="contentsBody" id="idDefSem">
					</div>
				</div>
			</div>
			<div class="lblTitulo"><span id="tit-dos"></span></div>
			<div class="firstGraph">
				<div class="contentGraph">
					<canvas id="chart-area3"></canvas>
				</div>
			</div>
			<div class="contentTbl" style="display: block;overflow: auto;">
				<div class="tblSpace" style="width: auto;">
					<div class="contentHeAders">
						<div class="items1" style="width: 60px;">N°</div>
						<div class="items1" style="width: 120px;">DEFECTOS</div>
						<div class="items1" style="width: 80px;">FRECUENCIA</div>
					</div>
					<div class="contentsBody" id="idDefMes">
					</div>
				</div>
			</div>
			<div class="btnPrimary btnNextPage" style="margin-left: auto;margin-right: auto;" onclick="redirect('FiltroReporteAudPro.php')">Volver</div>
		</div>
	</div>
	<script type="text/javascript">
		var codtll='<?php echo $_GET['codtll']; ?>';
		var codtipser='<?php echo $_GET['codtipser']; ?>';
		var codsede='<?php echo $_GET['codsede']; ?>';
	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/ReporteAudPro-v1.0.js"></script>
</body>
</html>