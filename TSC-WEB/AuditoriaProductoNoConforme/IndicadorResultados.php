<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="14";
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
	<link rel="stylesheet" type="text/css" href="css/IndicadorResultado.css">
	<script src="charts-dist/Chart.min.js"></script>
	<script src="charts-dist/chartjs-plugin-datalabels.js"></script>
	<style type="text/css">
		.items1ps{
			width: 160px;
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
			<div class="headerTitle">Indicador de Resultados</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			
			<div class="rowLine" style="margin-bottom: 5px">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="downloadPDF()">Descargar PDF</button>
			</div>
			<div class="lblTitulo">INDICADORES DE RESULTADOS DE PRODUCTOS NO CONFORME</div>
			<div class="lblTitulo" id="titulodetalle"></div>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;">
					<canvas id="chart-area-ps"></canvas>
				</div>
			</div>
			<div class="contentTbl" id="caso1">
				<div class="lateralHeAders">
					<div class="items1 items1ps">DETALLE GENERAL</div>
					<div class="items1 items1ps items2">PRE. CLAS. PLANTA CHINCHA</div>
					<div class="items1 items1ps items2">PRE. CLAS. SERV. CHINCHA</div>
					<div class="items1 items1ps items2">PRE. CLAS. SERV. LIMA</div>
					<div class="items1 items1ps items2">PRENDAS CLASIFICADAS TSC</div>
					<div class="items1 items1ps items2">PRE. PROD. CHINCHA</div>
					<div class="items1 items1ps items2">PRE. PROD. LIMA</div>
					<div class="items1 items1ps items2">PRENDAS PRODUCIDAS TSC</div>
					<div class="items1 items1ps items2">% CLAS. PLANTA CHINCHA</div>
					<div class="items1 items1ps items2">% CLAS. SERV. CHINCHA</div>
					<div class="items1 items1ps items2">% CLAS. SERV. LIMA</div>
					<div class="items1 items1ps items2">% PRENDAS CLASIFICADAS TSC</div>
					<div class="items1 items1ps items2" style="background: red;color: yellow;">OBJETIVO</div>
				</div>
				<div class="contents" id="placeAniosPS">
				</div>
				<div class="contents" id="placeMesesPS">
				</div>
				<div class="contents" id="placeSemanasPS">
				</div>
			</div>
			<div class="contentTbl" id="caso2">
				<div class="lateralHeAders">
					<div class="items1 items1ps">DETALLE GENERAL</div>
					<div class="items1 items1ps items2">PRENDAS CLASIFICADAS TSC</div>
					<div class="items1 items1ps items2">PRENDAS PRODUCIDAS TSC</div>
					<div class="items1 items1ps items2">% PRE. CLAS.</div>
					<div class="items1 items1ps items2" style="background: red;color: yellow;">OBJETIVO</div>
				</div>
				<div class="contents" id="placeAniosPS">
				</div>
				<div class="contents" id="placeMesesPS">
				</div>
				<div class="contents" id="placeSemanasPS">
				</div>
			</div>
			<div class="lineDecoration"></div>
			<div class="lblTitulo">DIAGRAMA DE PARETO GENERAL - NIVEL N° 1</div>			
			<div class="lblTitulo"><span id="titParUno"></span></div>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;">
					<canvas id="chart-area2"></canvas>
				</div>
			</div>
			<div class="contentTbl" style="display: block;">
				<div class="tblSpace" style="width: 365px;">
					<div class="contentHeAders">
						<div class="items1" style="width: 120px;">DEFECTOS</div>
						<div class="items1" style="width: 80px;">FRECUENCIA</div>
						<div class="items1" style="width: 40px;">%</div>
						<div class="items1" style="width: 90px;">% ACUMULADO</div>
					</div>
					<div class="contentsBody" id="idDefUno">
					</div>
				</div>
			</div>

			<div class="lblTitulo"><span id="titParUno-Mes"></span></div>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;">
					<canvas id="chart-area2-mes"></canvas>
				</div>
			</div>
			<div class="contentTbl" style="display: block;">
				<div class="tblSpace" style="width: 365px;">
					<div class="contentHeAders">
						<div class="items1" style="width: 120px;">DEFECTOS</div>
						<div class="items1" style="width: 80px;">FRECUENCIA</div>
						<div class="items1" style="width: 40px;">%</div>
						<div class="items1" style="width: 90px;">% ACUMULADO</div>
					</div>
					<div class="contentsBody" id="idDefUno-Mes">
					</div>
				</div>
			</div>

			<div class="lineDecoration"></div>
			<div class="lblTitulo">DIAGRAMA DE PARETO GENERAL - NIVEL N° 2</div>
			<div class="lblTitulo"><span id="titParDos"></span></div>
			<div class="lblTitulo" style="margin: 5px 0px;text-align: left;">1. <span id="defPosUno"></span> (1er Mayor Defecto)</div>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;">
					<canvas id="chart-area3"></canvas>
				</div>
			</div>
			<div class="contentTbl" style="display: block;">
				<div class="tblSpace" style="width: 535px;">
					<div class="contentHeAders">
						<div class="items1" style="width: 120px;">DEFECTOS</div>
						<div class="items1" style="width: 80px;">FRECUENCIA</div>
						<div class="items1" style="width: 40px;">%</div>
						<div class="items1" style="width: 90px;">% ACUMULADO</div>
						<div class="items1 items3" style="width: 50px;background:transparent;border-color:transparent;"></div>
						<div class="items1" style="width: 100px;">% DEL GENERAL</div>
					</div>
					<div class="contentsBody" id="idDefectoUno">
					</div>
				</div>
			</div>

			<div class="lblTitulo" style="margin: 5px 0px;text-align: left;">2. <span id="defPosDos"></span> (2do Mayor Defecto)</div>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;">
					<canvas id="chart-area4"></canvas>
				</div>
			</div>
			<div class="contentTbl" style="display: block;">
				<div class="tblSpace" style="width: 535px;">
					<div class="contentHeAders">
						<div class="items1" style="width: 120px;">DEFECTOS</div>
						<div class="items1" style="width: 80px;">FRECUENCIA</div>
						<div class="items1" style="width: 40px;">%</div>
						<div class="items1" style="width: 90px;">% ACUMULADO</div>
						<div class="items1 items3" style="width: 50px;background:transparent;border-color:transparent;"></div>
						<div class="items1" style="width: 100px;">% DEL GENERAL</div>
					</div>
					<div class="contentsBody" id="idDefectoDos">
					</div>
				</div>
			</div>

			<div class="lblTitulo"><span id="titParDos-Mes"></span></div>
			<div class="lblTitulo" style="margin: 5px 0px;text-align: left;">1. <span id="defPosUno-Mes"></span> (1er Mayor Defecto)</div>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;">
					<canvas id="chart-area3-mes"></canvas>
				</div>
			</div>
			<div class="contentTbl" style="display: block;">
				<div class="tblSpace" style="width: 535px;">
					<div class="contentHeAders">
						<div class="items1" style="width: 120px;">DEFECTOS</div>
						<div class="items1" style="width: 80px;">FRECUENCIA</div>
						<div class="items1" style="width: 40px;">%</div>
						<div class="items1" style="width: 90px;">% ACUMULADO</div>
						<div class="items1 items3" style="width: 50px;background:transparent;border-color:transparent;"></div>
						<div class="items1" style="width: 100px;">% DEL GENERAL</div>
					</div>
					<div class="contentsBody" id="idDefectoUno-Mes">
					</div>
				</div>
			</div>
			<div class="lblTitulo" style="margin: 5px 0px;text-align: left;">2. <span id="defPosDos-Mes"></span> (2do Mayor Defecto)</div>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;">
					<canvas id="chart-area4-mes"></canvas>
				</div>
			</div>
			<div class="contentTbl" style="display: block;">
				<div class="tblSpace" style="width: 535px;">
					<div class="contentHeAders">
						<div class="items1" style="width: 120px;">DEFECTOS</div>
						<div class="items1" style="width: 80px;">FRECUENCIA</div>
						<div class="items1" style="width: 40px;">%</div>
						<div class="items1" style="width: 90px;">% ACUMULADO</div>
						<div class="items1 items3" style="width: 50px;background:transparent;border-color:transparent;"></div>
						<div class="items1" style="width: 100px;">% DEL GENERAL</div>
					</div>
					<div class="contentsBody" id="idDefectoDos-Mes">
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var codusu='<?php echo $_SESSION['user']; ?>';
		var codtipser='<?php echo $_GET['codtipser']; ?>';
		var codsede='<?php echo $_GET['codsede']; ?>';
		var fecha='<?php echo $_GET['fecha']; ?>';
	</script>
	<script type="text/javascript" src="js/IndicadorResultados-v1.6.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>