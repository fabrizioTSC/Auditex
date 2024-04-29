<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="3";
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
	<link rel="stylesheet" type="text/css" href="css/consultaAuditoria.css">
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
			<div class="headerTitle">Filtro de Reporte de desviaci&oacute;n de Medidas</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div style="border-bottom: 1px #333 solid;margin-bottom: 10px;padding-bottom: 10px;">
				<div class="sameLine">
					<div class="lblNew" style="width: 120px;padding-top: 11px;">Pedido</div>
					<input type="text" id="pedido" class="iptClass" style="width: calc(120px);font-size: 15px;">
					<button class="btnPrimary" style="width: 35px;margin-left: 10px;" onclick="search_pedido()"><i class="fa fa-search" aria-hidden="true"></i></button>
				</div>
				<div class="sameLine" id="div-colores" style="padding-top: 10px;display: none;">
					<div class="lblNew" style="width: 120px;padding-top: 11px;">Color</div>
					<select id="color" class="classCmbBox" style="width: 180px;margin: 0;">
						<option>asd</option>
					</select>
					<button class="btnPrimary" style="width: 80px;margin-left: 10px;" onclick="search_esttsc()">Buscar</button>
				</div>
			</div>
			<div class="sameLine">
				<div class="lblNew" style="width: 120px;padding-top: 11px;">Estilo TSC</div>
				<input type="text" id="nombreEsttsc" class="iptClass" style="width: calc(120px);font-size: 15px;">
				<button class="btnPrimary" style="width: 80px;margin-left: 10px;" onclick="consultar_esttsc()">Consultar</button>
			</div>
			<div id="resultesttsc" style="display: none;">
				<div style="width: 100%;height: 20px;"></div>
				<div class="sameLine">
					<div class="lblNew" style="width: 120px;padding-top: 5px;">Ficha</div>
					<input type="text" id="nombreFicha" class="iptClass" style="width: calc(100% - 120px);font-size: 15px;">
				</div>
				<div class="tblSelection">
					<div class="listaTalleres" id="spaceficha">
						<div class="taller"></div>
					</div>
				</div>
				<div class="sameLine" style="margin-top:5px;">
					<label>Rango de fechas</label>
				</div>
				<div class="sameLine" style="margin-bottom:5px;">
					<div class="lblNew" style="width: 80px;padding-top: 11px;">Desde</div>
					<input type="date" id="fecini" class="iptClass" style="width: calc(120px);font-size: 15px;">
				</div>
				<div class="sameLine">
					<div class="lblNew" style="width: 80px;padding-top: 11px;">Hasta</div>
					<input type="date" id="fecfin" class="iptClass" style="width: calc(120px);font-size: 15px;">
				</div>
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;" onclick="mostraReporte()">Mostrar reporte</button>
			</div>
		</div>				
	</div>
	<script type="text/javascript" src="js/SeleccionRepDesMed-v1.1.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>