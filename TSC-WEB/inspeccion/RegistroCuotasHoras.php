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
			<div class="headerTitle">Registro de Cuotas y Horas</div>
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
				<div class="lbl" style="width: 70px;padding-top: 6px;">Fecha:&nbsp;</div>
				<div class="spaceIpt" style="width: calc(120px);">
					<select class="classSelect" id="select-fechas">
					</select>
				</div>
				<!--
				<button id="btn1" style="display: block;height: 27px;" onclick="show_day_before()">Anterior</button>
				<button id="btn2" style="display: none;height: 27px;" onclick="show_day_after()">Siguiente</button>
				<input type="date" id="FechaSys" style="padding: 5px;height: 16px;width: 110px;border-radius: 5px;border: 1px solid #999;font-family: sans-serif;">-->
			</div>
			<div style="display: flex;">
				<div class="lbl" style="width: 60px;padding-top: 6px;">Turno:</div>
				<div class="spaceIpt" style="width: calc(120px);">
					<select class="classSelect" id="select-turno-linea">
					</select>
				</div>
			</div>
			<div style="display: flex;margin-top: 5px;">
				<button class="btn-primary" style="margin-right: calc(50% - 140px);" onclick="agregar_turno()">Agregar turno</button>
				<button class="btn-primary" style="margin-left: calc(50% - 140px);" onclick="redirect('main.php')">Volver</button>
			</div>
			<div id="info-linea" style="display: none;">
				<div class="lineDecoration"></div>
				<div id="title-nuevo" class="lbl" style="margin-bottom: 5px;padding-top: 0px;">Turno a agregar: <span id="turno-siguiente"></span></div>
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
				<div style="display: flex;margin-top: 5px;">
					<div class="lbl" style="width: 90px;padding-top: 2px;">Cam. Est.:</div>
					<div class="spaceIpt" style="width: calc(30px);text-align: right;">
						<input type="checkbox" class="simple-ipt" id="camest">
					</div>
					<div class="lbl" style="width: 60px;padding-top: 2px;margin-left: 5px;">Jor.:</div>
					<div class="spaceIpt" style="width: calc(60px);">
						<input type="number" class="simple-ipt" id="jor">
					</div>
				</div>
				<div style="display: flex;margin-top: 5px;" id="btn-generate">
					<button class="btn-primary" style="margin: auto;" onclick="generarHoras()">Generar horas</button>
				</div>
			</div>
			<div id="tbl-generate" style="display: none;">
				<div class="lineDecoration"></div>
				<div class="tblData">
					<div class="tbl-header">
						<div class="head-tbl tbl-in3">Hora</div>
						<div class="head-tbl tbl-in3">Operarios</div>
						<div class="head-tbl tbl-in3">Min. Hora</div>
						<div class="head-tbl tbl-in3">Min. Desc.</div>
						<div class="head-tbl tbl-in3">Minutos Asig.</div>
					</div>
					<div class="tbl-body" id="space-fill">
					</div>
				</div>
				<div style="text-align: right;width: 100%;margin-top: 5px;">
					<span>Total minutos: <span id="total-minutos">11111</span></span>
				</div>
				<div style="display: flex;margin-top: 5px;">
					<div style="width:calc(50%); text-align: left">
						<button class="btn-primary" id="btn-eliminar" onclick="delete_turno()">Eliminar turno</button>
					</div>
					<div style="width:calc(50%); text-align: right;">
						<button class="btn-primary" onclick="guardarHoras()">Guardar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/RegistroCuotasHoras-v1.9.js"></script>
</body>
</html>