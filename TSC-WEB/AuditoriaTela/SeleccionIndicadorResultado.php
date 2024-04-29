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
			<div class="headerTitle">Filtro de Indicador de Resul.</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="sameLine">
				<div class="lblNew" style="width: 110px;padding-top: 5px;">Proveedor</div>
				<input type="text" id="nombreProveedor" class="iptClass" style="width: calc(100% - 110px);font-size: 15px;">
			</div>
			<div class="tblSelection">
				<div class="listaTalleres" id="spaceproveedores">
					<div class="classTaller"></div>
				</div>
			</div>
			<div style="width: 100%;height: 10px;"></div>
			<div class="sameLine">
				<div class="lblNew" style="width: 110px;padding-top: 5px;">Auditores</div>
				<input type="text" id="nombreAuditor" class="iptClass" style="width: calc(100% - 110px);font-size: 15px;">
			</div>
			<div class="tblSelection">
				<div class="listaTalleres" id="spaceauditores">
					<div class="classTaller"></div>
				</div>
			</div>
			<div style="width: 100%;height: 10px;"></div>
			<div class="sameLine">
				<div class="lblNew" style="width: 110px;padding-top: 5px;">Coordinadores</div>
				<input type="text" id="nombreSupervisor" class="iptClass" style="width: calc(100% - 110px);font-size: 15px;">
			</div>
			<div class="tblSelection">
				<div class="listaTalleres" id="spacesupervisores">
					<div class="classTaller"></div>
				</div>
			</div>
			<div style="width: 100%;height: 10px;"></div>
			<div class="rowLine">				
				<div class="sameLine">
					<div class="lblNew" style="width: 140px;padding-top: 8px;">Fecha corte:</div>
					<input type="date" id="idFecha" class="iptClass" style="width: calc(100% - 140px);font-size: 15px;">
				</div>
			</div>
			<div style="width: 100%;height: 10px;"></div>
			<div class="rowLine">				
				<div class="sameLine">
					<div class="lblNew" style="width: 140px;padding-top: 8px;">Bloque:</div>
					<select class="classCmbBox" id="selectBloque" style="width: calc(100% - 140px);">
						<option value="0">Partida</option>
						<option value="1">Tono</option>
						<option value="2">Apariencia</option>
						<option value="3">Estabilidad Dimensional</option>
						<option value="4">Defectos</option>
					</select>
				</div>
			</div>
		</div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="mostraIndRes()">Mostrar indicadores</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript" src="js/SeleccionIndRes-1.1.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>