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
	<link rel="stylesheet" type="text/css" href="css/index-v1.0.css">
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
			<div class="sameLine">
				<div class="lblNew" style="width: 120px;padding-top: 11px;">Estilo TSC</div>
				<input type="text" id="nombreEsttsc" class="iptClass" style="width: calc(120px);font-size: 15px;">
				<button class="btnPrimary" style="width: 80px;margin-left: 10px;" onclick="consultar_esttsc()">Consultar</button>
			</div>
			<!--
			<div class="tblSelection">
				<div class="listaTalleres" id="spaceesttsc">
					<div class="taller"></div>
				</div>
			</div>
			-->
			<div id="resultesttsc" style="display: none;">
				<div style="width: 100%;height: 20px;"></div>
				<div class="sameLine">
					<div class="lblNew" style="width: 120px;padding-top: 5px;">Pedido</div>
					<input type="text" id="nombrePedido" class="iptClass" style="width: calc(100% - 120px);font-size: 15px;">
				</div>
				<div class="tblSelection">
					<div class="listaTalleres" id="spaceficha">
						<div class="taller"></div>
					</div>
				</div>
				<div id="resultesttsc-2" style="display: none;">
					<div style="width: 100%;height: 20px;"></div>
					<div class="sameLine">
						<div class="lblNew" style="width: 120px;padding-top: 5px;">Color</div>
						<input type="text" id="nombreColor" class="iptClass" style="width: calc(100% - 120px);font-size: 15px;">
					</div>
					<div class="tblSelection">
						<div class="listaTalleres" id="spaceColor">
							<div class="taller"></div>
						</div>
					</div>
					<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;" onclick="mostraReporte()">Mostrar reporte</button>
				</div>
			</div>
		</div>				
	</div>
	<script type="text/javascript" src="js/SeleccionRepDesMed-v1.0.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>