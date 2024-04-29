<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="101";
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
	<link rel="stylesheet" type="text/css" href="css/MenuMonitor.css">
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
			<div class="headerTitle">Selecci&oacute;n de Monitores</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="content-btns-monitor" id="space-to-charge">
		</div>
		<div class="rowLine">				
			<div class="sameLine" style="margin-bottom: 5px;">
				<div class="lblNew" style="width: 140px;padding-top: 8px;">Fecha desde:</div>
				<input type="date" id="idFecha" value="<?php echo date("Y-m-d");?>" class="iptClass" style="width: calc(100% - 140px);font-size: 15px;">
			</div>			
			<div class="sameLine">
				<div class="lblNew" style="width: 140px;padding-top: 8px;">Fecha hasta:</div>
				<input type="date" id="idFechaFin" value="<?php echo date("Y-m-d");?>"  class="iptClass" style="width: calc(100% - 140px);font-size: 15px;">
			</div>
		</div>
		<div class="sameline">
			<button  class="btnPrimary" style="margin:auto;margin-top: 10px; " onclick="mostrarReporte()">MOSTRAR REPORTE</button>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/MReportelineas-v1.2.js"></script>
</body>
</html>