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
	<link rel="stylesheet" type="text/css" href="css/consultaAuditoria.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
</head>
<body onload="getTalleres()">
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
			<div class="sameLine">
				<div class="lblNew" style="width: 80px;padding-top: 5px;">Taller</div>
				<input type="text" id="nombreTaller" class="iptClass" style="width: calc(100% - 80px);font-size: 15px;">
			</div>
			<div class="tblSelection">
				<div class="listaTalleres" id="spaceTalleres">
					<div class="classTaller"></div>
				</div>
			</div>
			<div style="width: 100%;height: 20px;"></div>
			<div class="sameLine">
				<div class="lblNew" style="width: 80px;padding-top: 5px;">Auditor</div>
				<input type="text" id="nombreAuditor" class="iptClass" style="width: calc(100% - 80px);font-size: 15px;">
			</div>
			<div class="tblSelection">
				<div class="listaAuditores">
					<div class="taller"></div>
				</div>
			</div>
			<div style="width: 100%;height: 20px;"></div>
			<div class="rowLine" style="display: flex;">				
				<div class="lblNew" style="width: 130px;padding-top: 5px;">Tipo Auditor&iacute;a</div>
				<select id="idTipoAuditoria" class="classCmbBox" style="width: calc(100% - 130px);font-size: 15px;">
					<option value="0">(TODOS)</option>
				</select>
			</div>
			<div style="width: 100%;height: 10px;"></div>
			<div class="rowLine">				
				<div class="lblNew">Rango de Fechas</div>
				<div class="sameLine">
					<div class="lblNew" style="width: 70px;padding-top: 8px;">Desde</div>
					<input type="date" id="idFechaDesde" class="iptClass" style="width: calc(100% - 70px);font-size: 15px;">
				</div>
				<div style="width: 100%;height: 5px;"></div>
				<div class="sameLine">
					<div class="lblNew" style="width: 70px;padding-top: 8px;">Hasta</div>
					<input type="date" id="idFechaHasta" class="iptClass" style="width: calc(100% - 70px);font-size: 15px;">
				</div>
			</div>
			<div style="width: 100%;height: 10px;"></div>
			<div class="rowLine">				
				<div class="lblNew">Tipo de Resultado</div>
				<div class="sameLine" data-target="idGrafico" style="display: none;">
					<div class="lblNew" style="width: 90px;">Gr&aacute;fica</div>
					<input class="checkDetect" type="checkbox" id="idGrafico" style="margin-top: 2px;margin-bottom: 0px;">
				</div>
				<!--
				<div style="width: 100%;height: 5px;"></div>
				-->
				<div class="sameLine" data-target="idDatos">
					<div class="lblNew" style="width: 90px;">Datos</div>
					<input class="checkDetect" type="checkbox" id="idDatos" style="margin-top: 2px;margin-bottom: 0px;" checked>
				</div>
			</div>
		</div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="mostraDatos()">Mostrar resultado</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript" src="js/SeleccionReporteGeneral-v1.0.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>