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
	<style type="text/css">
		input[type="checkbox"]{
			margin-top: 5px;
		}
		input[type="date"]{
			font-size: 15px;
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
			<div class="headerTitle">Men&uacute; Reporte Turnos</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent" style="padding-bottom: 5px;">
			<div class="sameline" style="font-weight: bold;">
				Reporte por d&iacute;a <input type="checkbox" id="check1" checked>
			</div>
			<div id="option1">
				<div class="sameline" style="margin-top: 5px; display: flex;">
					<div class="lbl" style="width: 80px;">Fecha:</div>
					<input type="date" id="idFecha" class="iptClass" style="width: 200px;margin-right: 10px;">
				</div>
			</div>	
			<div class="lineDecoration"></div>
			<div class="sameline" style="font-weight: bold;">
				Reporte por semanas <input type="checkbox" id="check2">
			</div>
			<div id="option2" style="display: none;">
				<div class="spaceAlign" style="display: flex;">
					<div class="lbl" style="width: 80px;">Año:</div>
					<select class="classSelect" id="select-anio1" style="width: 80px;margin-right: 5px;">
					</select>
					<div class="lbl" style="width: 80px;">Semana:</div>
					<select class="classSelect" id="select-semana" style="width: 80px;">
					</select>
				</div>
			</div>	
			<div class="lineDecoration"></div>
			<div class="sameline" style="font-weight: bold;">
				Reporte por meses <input type="checkbox" id="check3">
			</div>
			<div id="option3" style="display: none;">
				<div class="spaceAlign" style="display: flex;">
					<div class="lbl" style="width: 80px;">Año:</div>
					<select class="classSelect" id="select-anio2" style="width: 80px;margin-right: 5px;">
					</select>
					<div class="lbl" style="width: 80px;">Mes:</div>
					<select class="classSelect" id="select-mes" style="width: 80px;">
					</select>
				</div>
			</div>	
			<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
				<div class="rowLine bodyPrimary">
					<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 5px;" onclick="showReporte()">Mostrar reporte</button>
				</div>		
			</div>
			<div class="lineDecoration"></div>
			<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
				<div class="rowLine bodyPrimary">
					<!-- <button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="redirect('main.php')">Volver</button> -->
					<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="goBack()">Volver</button>
				</div>		
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var codusu='<?php echo $_SESSION['user']; ?>';
	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/MenuReporteTurnos-1.0.js"></script>
	<script type="text/javascript">
		function goBack(){
			window.history.back();
		}
	</script>
</body>
</html>