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
	<link rel="stylesheet" type="text/css" href="css/IndicadorResultado-v1.0.css">
	<script src="charts-dist/Chart.min.js"></script>
	<script src="charts-dist/chartjs-plugin-datalabels.js"></script>
	<style type="text/css">
		.spaceGraph{
			background: #fff;
			padding: 10px;
			pointer-events: none;
			max-width: 700px;
			width: calc(100% - 20px);
			margin: 0 auto;
		}
		.modalBackground::-webkit-scrollbar{
			background: transparent;
		}
		.modalBackground::-webkit-scrollbar-thumb{
			background: #aaa;
		}
	</style>
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
			<div class="headerTitle">Indicador de Concesionados</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="lblTitulo">INDICADORES DE CONCESIONADOS</div>
			<div class="lblTitulo" id="titulodetalle2"></div>	
			<div style="display: flex;margin-top: 10px;">
				<input class="class-radio" type="radio" name="tipo" id="tipo1" checked>
				<label style="font-size: 13px;" for="tipo1">Rango de fechas</label>
			</div>
			<div style="display: flex;justify-content: center;">
				<div class="lblTitulo" style="width: 100px;margin-top: 8px;">Desde:</div>
				<input type="date" style="font-family:sans-serif;width: 200px;margin-bottom: 0px;" id="idFecIni">
				<div class="lblTitulo" style="width: 100px;margin-top: 8px;">Hasta:</div>
				<input type="date" style="font-family:sans-serif;width: 200px;margin-bottom: 0px;" id="idFecFin">
			</div>	
			<div style="display: flex;margin-top: 10px;">
				<input class="class-radio" type="radio" name="tipo" id="tipo0">
				<label style="font-size: 13px;" for="tipo0">Año/Semana</label>
			</div>
			<div style="display: flex;justify-content: center;">
				<div class="lblTitulo" style="width: 100px;margin-top: 12px;">AÑO:</div>
				<select class="classCmbBox" style="width: 100px;margin-bottom: 0px;" id="idNumAnio">
				</select>
				<div class="lblTitulo" style="width: 100px;margin-top: 12px;">SEMANA:</div>
				<select class="classCmbBox" style="width: 100px;margin-bottom: 0px;" id="idNumSem">
				</select>
			</div>	
			<center>
				<button class="btnPrimary" style="margin-top: 10px;" onclick="get_infindcon()">Ver</button>
			</center>
			<h3 style="margin-bottom: 5px;">Responsables por Tono</h3>
			<div class="spaceGraph" id="chart1">
				<canvas id="chart-area1"></canvas>
			</div>
			<div class="contentTbl" style="display: block;margin-top: 10px;">
				<div class="tblSpace" style="width: 100%;">
					<div class="contentHeAders">
						<div class="items1" style="width: calc(70% - 10px);">Responsable</div>
						<div class="items1" style="width: calc(15% - 10px);">kg</div>
						<div class="items1" style="width: calc(15% - 10px);">%</div>
					</div>
					<div class="contentsBody" id="table-res-1">
					</div>
				</div>
			</div>
			<h3 style="margin-bottom: 5px;">Responsables por Apariencia</h3>
			<div class="spaceGraph" id="chart2">
				<canvas id="chart-area2"></canvas>
			</div>
			<div class="contentTbl" style="display: block;margin-top: 10px;">
				<div class="tblSpace" style="width: 100%;">
					<div class="contentHeAders">
						<div class="items1" style="width: calc(70% - 10px);">Responsable</div>
						<div class="items1" style="width: calc(15% - 10px);">kg</div>
						<div class="items1" style="width: calc(15% - 10px);">%</div>
					</div>
					<div class="contentsBody" id="table-res-2">
					</div>
				</div>
			</div>
			<h3 style="margin-bottom: 5px;">Responsables por Estabilidad Dimensional</h3>
			<div class="spaceGraph" id="chart3">
				<canvas id="chart-area3"></canvas>
			</div>
			<div class="contentTbl" style="display: block;margin-top: 10px;">
				<div class="tblSpace" style="width: 100%;">
					<div class="contentHeAders">
						<div class="items1" style="width: calc(70% - 10px);">Responsable</div>
						<div class="items1" style="width: calc(15% - 10px);">kg</div>
						<div class="items1" style="width: calc(15% - 10px);">%</div>
					</div>
					<div class="contentsBody" id="table-res-3">
					</div>
				</div>
			</div>
			<h3 style="margin-bottom: 5px;">Responsables por Defectos</h3>
			<div class="spaceGraph" id="chart4">
				<canvas id="chart-area4"></canvas>
			</div>
			<div class="contentTbl" style="display: block;margin-top: 10px;">
				<div class="tblSpace" style="width: 100%;">
					<div class="contentHeAders">
						<div class="items1" style="width: calc(70% - 10px);">Responsable</div>
						<div class="items1" style="width: calc(15% - 10px);">kg</div>
						<div class="items1" style="width: calc(15% - 10px);">%</div>
					</div>
					<div class="contentsBody" id="table-res-4">
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var codprv='<?php echo $_GET['codprv']; ?>';
		var codcli='<?php echo $_GET['codcli']; ?>';
		var fecini='<?php echo $_GET['fecini']; ?>';
		var fecfin='<?php echo $_GET['fecfin']; ?>';
	</script>
	<script type="text/javascript" src="js/IndicadorConcesionados-v1.0.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>