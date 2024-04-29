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
	<link rel="stylesheet" type="text/css" href="css/consultaAuditoria.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
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
			<div class="headerTitle">Resultados de Auditor&iacute;a</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="sameLine">
				<div class="lblNew" style="width: 80px;padding-top: 5px;">Proveedor</div>
				<input type="text" id="nombreProveedor" class="iptClass" style="width: calc(100% - 80px);font-size: 15px;">
			</div>
			<div class="tblSelection">
				<div class="listaTalleres" id="spaceproveedores">
					<div class="classTaller"></div>
				</div>
			</div>
			<div style="width: 100%;height: 10px;"></div>
			<div class="rowLine">				
				<div class="lblNew">Rango de Fechas</div>
				<div class="sameLine">
					<div class="lblNew" style="width: 120px;padding-top: 8px;">Desde</div>
					<input type="date" id="idFechaDesde" class="iptClass" style="width: calc(100% - 120px);font-size: 15px;">
				</div>
				<div style="width: 100%;height: 5px;"></div>
				<div class="sameLine">
					<div class="lblNew" style="width: 120px;padding-top: 8px;">Hasta</div>
					<input type="date" id="idFechaHasta" class="iptClass" style="width: calc(100% - 120px);font-size: 15px;">
				</div>
			</div>
			<div style="width: 100%;height: 10px;"></div>
			<div class="rowLine">				
				<div class="sameLine">
					<div class="lblNew" style="width: 120px;padding-top: 8px;">Estado:</div>
					<select class="classCmbBox" id="selectEstados" style="width: calc(100% - 120px);">
						<option value="0">TODOS</option>
						<option value="1">Terminado</option>
						<option value="2">Por terminar</option>
						<option value="3">En auditor&iacute;a</option>
					</select>
				</div>
			</div>
			<div style="width: 100%;height: 10px;"></div>
			<div class="rowLine">				
				<div class="sameLine">
					<div class="lblNew" style="width: 120px;padding-top: 8px;">Resultado:</div>
					<select class="classCmbBox" id="selectResultado" style="width: calc(100% - 120px);">
						<option value="0">TODOS</option>
						<option value="A">Aprobado</option>
						<option value="R">Rechazado</option>
						<option value="C">Aprobado no conforme</option>
					</select>
				</div>
			</div>
		</div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="mostraReporte()">Mostrar resultado</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript" src="js/SeleccionRepGen-v1.2.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>