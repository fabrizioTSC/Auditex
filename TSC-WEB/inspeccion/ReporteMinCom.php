<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: ../../dashboard/index.php');
	}
	$appcod="101";
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
	<link rel="stylesheet" type="text/css" href="css/ReporteRangoDefectos.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<script src="charts-dist/Chart.min.js"></script>
</head>
<body>		
	<div class="menuContent">
		<div class="spaceMenu">
			<div class="userSpace">
				<div class="titleversion">AUDITEX v1.5 - 25/04/2019</div>
				<img src="assets/img/user.png" class="imgUser">
				<div class="detailUser" style="font-weight: bold; font-size: 13px; padding-bottom: 3px;">
					EJECUTIVO				</div>
				<div class="detailUser">EJECUTIVO</div>
			</div>
			<div class="lineDecoration"></div>
			<div class="itemsMenu" onclick="redirect('main.php')">Inicio</div>
			<div class="itemsMenu" onclick="redirect('CambiarPassword.php')">Cambiar contrase&ntilde;a</div>
			<div class="itemsMenu" onclick="redirect('../../dashboard/logout.php?operacion=logout')">Salir</div>
		</div>
	</div>
	<div class="panelCarga" style="display: block;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="mainContent">		
		<div class="headerContent">
			<div class="headerTitle">Reporte Minutos Compensados por ficha</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent" style="padding-bottom: 0px;">	
			<div class="lblNew" id="spacetitulo"></div>
			<div class="content-table" style="height: calc(100vh - 200px);">
				<div class="table" style="width: 1320px;">
					<div class="tbl-header">
						<div class="head" style="width: 80px;">Fecha</div>
						<div class="head" style="width: 70px;">Linea</div>
						<div class="head" style="width: 70px;">Turno</div>
						<div class="head" style="width: 70px;">Hora Ini.</div>
						<div class="head" style="width: 70px;">Hora Fin.</div>
						<div class="head" style="width: 80px;">Ficha</div>
						<div class="head" style="width: 80px;">Est. Cli.</div>
						<div class="head" style="width: 80px;">Est. TSC</div>
						<div class="head" style="width: 120px;">Alternativa</div>
						<div class="head" style="width: 80px;">Ruta</div>
						<div class="head" style="width: 80px;">Tie. STD</div>
						<div class="head" style="width: 80px;">T. Com. Est.</div>
						<div class="head" style="width: 80px;">Tie. Com.</div>
						<div class="head" style="width: 80px;">Tie. Total</div>
						<div class="head" style="width: 140px;">Observaci&oacute;n</div>
					</div>
					<div class="tbl-body" id="placeResult">
					</div>
				</div>
			</div>
			<div class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;width: 135px;
			padding: 5px;display: flex;padding-left: 20px;" 
			onclick="exportarMinCom()">
				<img src="assets/img/excel.png" style="width: 30px;height: 30px;">
				<div style="padding: 5px;width:calc(80px);text-align: center;">Descargar</div>
			</div>
			<div class="lineDecoration"></div>
		</div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="redirect('main.php')">Volver</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript">
		var fecini="<?php if(isset($_GET['fecini'])){echo $_GET['fecini'];}else{echo "";} ?>";
		var fecfin="<?php if(isset($_GET['fecfin'])){echo $_GET['fecfin'];}else{echo "";} ?>";
	</script>
	<script type="text/javascript" src="js/ReporteMinCom-v1.1.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>