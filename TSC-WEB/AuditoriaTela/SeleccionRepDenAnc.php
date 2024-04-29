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
			<div class="headerTitle">Filtro de Reporte - Estabilidad Dimensional</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<!--
			<div class="sameLine">
				<div class="lblNew" style="width: 80px;padding-top: 5px;">Sede</div>
				<input type="text" id="nombreSede" class="iptClass" style="width: calc(100% - 80px);font-size: 15px;">
			</div>
			<div class="tblSelection">
				<div class="listaTalleres" id="spaceSedes">
					<div class="taller"></div>
				</div>
			</div>
			<div style="width: 100%;height: 20px;"></div>
			<div class="sameLine">
				<div class="lblNew" style="width: 120px;padding-top: 5px;">Tipo servicio</div>
				<input type="text" id="nombreTipoSer" class="iptClass" style="width: calc(100% - 120px);font-size: 15px;">
			</div>
			<div class="tblSelection">
				<div class="listaTalleres" id="spaceTipoSer">
					<div class="taller"></div>
				</div>
			</div>
			<div style="width: 100%;height: 20px;"></div>
			-->
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
				<div class="lblNew" style="width: 110px;padding-top: 5px;">Cliente</div>
				<input type="text" id="nombreCliente" class="iptClass" style="width: calc(100% - 110px);font-size: 15px;">
			</div>
			<div class="tblSelection">
				<div class="listaTalleres" id="spaceclientes">
					<div class="classTaller"></div>
				</div>
			</div>
			<!--
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
			</div>-->
			<div style="width: 100%;height: 10px;"></div>
			<div class="rowLine">				
				<div class="sameLine">
					<div class="lblNew" style="width: 140px;padding-top: 8px;">Fecha inicio:</div>
					<input type="date" id="idfecini" class="iptClass" style="width: calc(100% - 140px);font-size: 15px;">
				</div>
			</div>
			<div style="width: 100%;height: 10px;"></div>
			<div class="rowLine">				
				<div class="sameLine">
					<div class="lblNew" style="width: 140px;padding-top: 8px;">Fecha fin:</div>
					<input type="date" id="idfecfin" class="iptClass" style="width: calc(100% - 140px);font-size: 15px;">
				</div>
			</div>
			<!--
			<div style="width: 100%;height: 10px;"></div>
			<div class="rowLine">				
				<div class="sameLine">
					<div class="lblNew" style="width: 140px;padding-top: 8px;">Resultado:</div>
					<select class="classCmbBox" id="selectResultado" style="width: calc(100% - 140px);">
						<option value="C">Aprobado no Conforme</option>
						<option value="R">Rechazado</option>
					</select>
				</div>
			</div>-->
		</div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="mostraIndRes()">Mostrar reporte</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript" src="js/SeleccionRepDenAnc-v1.0.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>