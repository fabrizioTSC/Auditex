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
</head>
<body>
	<div class="panelCarga" style="display: block;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<?php contentMenu();?>
	<div class="mainContent">
		<div class="headerContent">
			<!--
			<div class="backSpace">
				<div class="iconSpace"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
			</div>
			-->
			<div class="headerTitle">Asignar Aql a Tipo Auditoria</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">			
			<div class="rowLine bodyPrimary">
				<div class="lbl" style="margin-bottom:5px;">Seleccionar tipo auditoria</div>
				<select class="classCmbBox" id="idSelectForTipoAuditoria"></select>
				<div class="lbl" style="margin-bottom:5px;">Seleccionar AQL</div>
				<select class="classCmbBox" id="idSelectForAql"></select>
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="ModifcarAql()">Confirmar</button>
			</div>
			<div class="lineWithDecoration" style="margin-top: 10px;margin-bottom: 10px;margin-left: 0px;width: 100%;"></div>
			<div class="rowLine">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="redirect('RegistrarAsignarAql.php')">Salir</button>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/AsignarAqlToTipoAuditoria.js"></script>
</body>
</html>