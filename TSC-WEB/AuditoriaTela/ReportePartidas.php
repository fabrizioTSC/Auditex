<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="1";
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
</head>
<body>
	<?php contentMenu();?>
	<div class="panelCarga" style="display: none;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Reporte de Partidas</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="sameline" style="margin-bottom: 5px;">
				<div class="lbl" style="width: 70px;">Partida:</div>
				<div class="spaceIpt" style="width: calc(100% - 70px);font-size: 15px">
					<input type="text" id="idpartida" class="classIpt" value="" style="width: auto;">
				</div>
			</div>
			<div class="rowLine bodyPrimary" style="display: flex;">
				<button class="btnPrimary" style="width: auto;margin-right: 5px;" onclick="search_partida()">Consultar</button>
				<div class="btnPrimary" style="width: 135px;margin-right: 5px;
				padding: 5px;display: flex;padding-left: 20px;" onclick="export_excel()" id="spaceBtnExport">
					<img src="assets/img/excel.png" style="width: 30px;height: 30px;">
					<div style="padding: 5px;width:calc(80px);text-align: center;">Descargar</div>
				</div>
				<button class="btnPrimary" style="width: auto;" onclick="redirect('main.php')">Volver</button>
			</div>
			<div id="maintbl" style="margin-top: 10px;overflow-x: scroll;max-height: calc(100vh - 165px);position: relative;">
				<div id="bodytbl" style="position: relative;">
					<div class="tblHeader" id="data-header" style="position: relative;z-index: 11;width: 1620px;">
						<div class="itemHeader2" style="width: 110px;">Opción</div>
						<div class="itemHeader2" style="width: 90px;">Partida</div>
						<div class="itemHeader2" style="width: 150px;">Cod. Tela</div>
						<div class="itemHeader2" style="width: 90px;">Situaci&oacute;n</div>
						<div class="itemHeader2" style="width: 90px;">Color</div>
						<div class="itemHeader2" style="width: 150px;">Proveedor</div>
						<div class="itemHeader2" style="width: 150px;">Ruta</div>
						<div class="itemHeader2" style="width: 150px;">Art&iacute;culo</div>
						<div class="itemHeader2" style="width: 150px;">Composici&oacute;n</div>
						<div class="itemHeader2" style="width: 90px;">Rendimiento</div>
						<div class="itemHeader2" style="width: 90px;">Peso</div>
						<div class="itemHeader2" style="width: 90px;">Programa</div>
						<div class="itemHeader2" style="width: 90px;">X Factory</div>
					</div>
					<div class="tblBody" id="idTblBody" style="position: relative;width: 1620px;">
					</div>
				</div>
			</div>
			<div id="no-result" style="margin-top: 10px;color: #ca0b0b;display: none;">No hay resultados!</div>
		</div>
	</div>
	<script type="text/javascript" src="js/ReportePartidas-v1.2.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>