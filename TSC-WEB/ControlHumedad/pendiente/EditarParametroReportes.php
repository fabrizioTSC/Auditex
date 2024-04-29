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
			<div class="headerTitle">Par&aacute;metros de Reportes</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">		
			<div style="margin-bottom: 10px;">
				<div class="tblHeader">
					<div class="itemHeader" style="width: 50%;text-align: center;">Tipo Aud.</div>
					<div class="itemHeader" style="width: 20%;text-align: center;">Rango</div>
					<div class="itemHeader" style="width: 30%;text-align: center;">Valor</div>
				</div>
				<div class="tblBody" id="data-parametros">
				</div>
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;margin-bottom: 0px;" onclick="saveParameters()">Guardar cambios</button>
			<div class="lineDecoration"></div>
		<div class="rowLine">
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="redirect('main.php')">Volver</button>
		</div>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/ParametroReporte-v1.0.js"></script>
</body>
</html>