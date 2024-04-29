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
	<title>AUDITEX - INSPECCION</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="css/RegistroCuotasHoras-v1.2.css">
	<!--
	<script type="text/javascript" src="js/jquery/jquery-1.12.1.js"></script>
	<script type="text/javascript" src="js/jquery/jquery-ui-1.12.1.js"></script>
	<link rel="stylesheet" href="css/jquery/jquery-ui-1.12.1.css">
	-->
	<style type="text/css">
		.tblData{
			width: 100%;
		}
		.tbl-header,.tbl-body{
			width: 1200px;
		}
		.tbl-in3{
			min-width: 100px;
			width: calc(100% - 10px)/8;
		}
		.tbl-in4{
			min-width: 200px;
		}
	</style>
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
			<div class="headerTitle">Registro de Minutos de Compensaci&oacute;n por Ficha</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div style="display: flex;">
				<div class="lbl" style="width: 60px;padding-top: 6px;">Linea:</div>
				<div class="spaceIpt" style="width: calc(120px);">
					<select class="classSelect" id="select-lineas">
					</select>
				</div>
				<div class="lbl" style="width: 140px;padding-top: 6px;">Fecha:&nbsp;<span id="FechaSys"></span></div>
			</div>
			<div style="display: flex;">
				<div class="lbl" style="width: 60px;padding-top: 6px;">Turno:</div>
				<div class="spaceIpt" style="width: calc(120px);">
					<select class="classSelect" id="select-turno-linea">
					</select>
				</div>
			</div>
			<div id="info-linea">
				<div style="display: flex;">
					<div class="lbl" style="width: 60px;padding-top: 2px;">Cuota:</div>
					<div class="spaceIpt" style="width: calc(60px);">
						<input type="number" class="simple-ipt" id="cuota">
					</div>
					<div class="lbl" style="width: 60px;padding-top: 2px;margin-left: 5px;">H. Ini.:</div>
					<div class="spaceIpt" style="width: calc(60px);">
						<input type="text" class="simple-ipt ipt-hor-ini" id="hor-ini">
					</div>
					<div class="lbl" style="width: 60px;padding-top: 2px;margin-left: 5px;">H. Fin.:</div>
					<div class="spaceIpt" style="width: calc(60px);">
						<input type="text" class="simple-ipt ipt-hor-fin" id="hor-fin">
					</div>
				</div>
			</div>
			<div id="tbl-generate" style="display: block;">
				<div class="lineDecoration"></div>
				<div class="tblData">
					<div class="tbl-header">
						<div class="head-tbl tbl-in3">Ficha</div>
						<div class="head-tbl tbl-in3">Est. Cli.</div>
						<div class="head-tbl tbl-in3">Est. Tsc</div>
						<div class="head-tbl tbl-in3">Alternativa</div>
						<div class="head-tbl tbl-in3">Ruta</div>
						<div class="head-tbl tbl-in3">Tiem. Std.</div>
						<div class="head-tbl tbl-in3">T. Com. Est.</div>
						<div class="head-tbl tbl-in3">Tiem. Com.</div>
						<div class="head-tbl tbl-in3">Min. Tot.</div>
						<div class="head-tbl tbl-in4">Obser.</div>
					</div>
					<div class="tbl-body" id="space-fill">
					</div>
				</div>
				<div style="text-align: center;margin-top: 5px;">
					<button class="btnPrimary" style="margin-top: 0px;" onclick="guardarMinCom()">Guardar</button>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/RegistroMinCom-v1.2.js"></script>
</body>
</html>