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
	<style type="text/css">
		.modalBackground .lblTitulo{
			color: #333;
		}
		.modalBackground::-webkit-scrollbar{
			background: transparent;
		}
		.modalBackground::-webkit-scrollbar-thumb{
			background: #aaa;
		}
		.ext-def{
			font-weight: 800;
		    color: #fff;
		    background: #138dc7;
		    width: 12px;
		    text-align: center;
		    border-radius: 4px;
			cursor: pointer;
		}
		.items5{
			background: #ddd;
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
	<div class="modalContainer" id="idModal">
		<div class="modalBackground" style="max-height: calc(100vh - 60px);overflow-y: scroll;">
			<div class="rowLine" style="margin-bottom: 5px">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="downloadPDF()">Descargar PDF</button>
			</div>
			<div class="lblTitulo">INDICADOR DE DEFECTO: <span id="idDesDef"></span></div>
			<div class="lblTitulo" id="titulodetalle"></div>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;" id="content-canvas">
					<canvas id="chart-area"></canvas>
				</div>
			</div>
			<div class="contentTbl">
				<div class="lateralHeAders">
					<div class="items1">DETALLE GENERAL</div>
					<div class="items1 items2"># DEF.</div>
					<div class="items1 items2"># PRE. INS.</div>
					<div class="items1">% DEF.</div>
				</div>
				<div class="contents" id="placeAnios">
				</div>
				<div class="contents" id="placeMeses">
				</div>
				<div class="contents" id="placeSemanas">
				</div>
			</div>
			<div class="rowLine" style="margin-bottom: 5px">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="hide_modal()">Volver</button>
			</div>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Indicador de Defectos</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="lblTitulo">INDICADORES DE DEFECTOS</div>
			<div class="lblTitulo" id="titulodetalle2"></div>
			<div style="display: flex;margin-top: 10px;">
				<input class="class-radio" type="radio" name="tipo" id="tipo0" checked>
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
			<div style="display: flex;margin-top: 10px;">
				<input class="class-radio" type="radio" name="tipo" id="tipo1">
				<label style="font-size: 13px;" for="tipo1">Rango de fechas</label>
			</div>
			<div style="display: flex;justify-content: center;">
				<div class="lblTitulo" style="width: 100px;margin-top: 8px;">Desde:</div>
				<input type="date" style="font-family:sans-serif;width: 200px;margin-bottom: 0px;" id="idFecIni">
				<div class="lblTitulo" style="width: 100px;margin-top: 8px;">Hasta:</div>
				<input type="date" style="font-family:sans-serif;width: 200px;margin-bottom: 0px;" id="idFecFin">
			</div>	
			<center>
				<button class="btnPrimary" style="margin-top: 10px;" onclick="update_reporte()">Ver</button>
			</center>
			<div class="contentTbl" style="display: block;margin-top: 10px;">
				<div class="tblSpace" style="width: 100%;">
					<div class="contentHeAders">
						<div class="items1" style="width: calc(55% - 10px);">DEFECTO</div>
						<div class="items1" style="width: calc(15% - 10px);">CAN. DEF.</div>
						<div class="items1" style="width: calc(15% - 10px);">CAN. INS.</div>
						<div class="items1" style="width: calc(15% - 10px);">%</div>
					</div>
					<div class="contentsBody" id="idDefectos">
						<!--
						<div class="lineBody">
							<div class="itemhs1 items4" style="width: 120px;text-align:left;"></div>
							<div class="itemhs1 items4" style="width: 80px;"></div>
							<div class="itemhs1 items4" style="width: 40px;"></div>
						</div>-->
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var codusu='<?php echo $_SESSION['user']; ?>;';
		var codlin='<?php echo $_GET['codlin']; ?>';
		var codtipser='0';
		var codsede='0';
	</script>
	<script type="text/javascript" src="js/IndicadorDefectos-v1.1.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>