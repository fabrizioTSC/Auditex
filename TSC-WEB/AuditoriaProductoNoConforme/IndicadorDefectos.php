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
	<link rel="stylesheet" type="text/css" href="css/IndicadorResultado-v1.0.css">
	<script src="charts-dist/Chart.min.js"></script>
	<style type="text/css">
		.modalBackground::-webkit-scrollbar{
			background: transparent;
		}
		.modalBackground::-webkit-scrollbar-thumb{
			background: #aaa;
		}
	</style>
</head>
<body>
		
	<div class="menuContent">
		<div class="spaceMenu">
			<div class="userSpace">
				<div class="titleversion">AUDITEX v1.5 - 25/04/2019</div>
				<img src="assets/img/user.png" class="imgUser">
				<div class="detailUser" style="font-weight: bold; font-size: 13px; padding-bottom: 3px;">
					EJECUTIVO				</div>
				<div class="detailUser">EJECUTIVO</div>
			</div>
			<div class="lineDecoration"></div>
			<div class="itemsMenu" onclick="redirect('main.php')">Inicio</div>
			<div class="itemsMenu" onclick="redirect('CambiarPassword.php')">Cambiar contrase&ntilde;a</div>
			<div class="itemsMenu" onclick="redirect('config/logout.php')">Salir</div>
		</div>
	</div>
	<div class="panelCarga" style="display: block;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="modalContainer" id="idModal">
		<div class="modalBackground" style="max-height: calc(100vh - 60px);overflow-y: scroll;">
			<!--<div class="rowLine" style="margin-bottom: 5px">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="downloadPDF()">Descargar PDF</button>
			</div>-->
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
					<div class="items1 items2"># DEF. TOT.</div>
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
			<div style="display: flex;margin-bottom: 10px;">
				<div style="width: calc(50% - 200px);"></div>
				<div class="lblTitulo" style="width: 100px;margin-top: 12px;">AÑO:</div>
				<select class="classCmbBox" style="width: 100px;margin-bottom: 0px;" id="idNumAnio">
				</select>
				<div class="lblTitulo" style="width: 100px;margin-top: 12px;">SEMANA:</div>
				<select class="classCmbBox" style="width: 100px;margin-bottom: 0px;" id="idNumSem">
				</select>
			</div>		
			<div class="contentTbl" style="display: block;">
				<div class="tblSpace" style="width: 100%;">
					<div class="contentHeAders">
						<div class="items1" style="width: calc(70% - 10px);">DEFECTO</div>
						<div class="items1" style="width: calc(15% - 10px);">TOTAL</div>
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
		var codusu='<?php echo $_SESSION["user"] ?>';
		var codtll='<?php echo $_GET["codtll"] ?>';
		var codtipser='<?php echo $_GET["codtipser"] ?>';
		var codsede='<?php echo $_GET["codsede"] ?>';
	</script>
	<script type="text/javascript" src="js/IndicadorDefectos-v1.0.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>