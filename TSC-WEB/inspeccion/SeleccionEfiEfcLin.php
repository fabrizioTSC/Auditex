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
			font-family: sans-serif;
		}
	</style>
</head>
<body>		
	<?php contentMenu(); ?>
	<div class="panelCarga" style="display: block;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Filtro Indicador Eficiancia y 	Eficacia de Linea</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent" style="padding-bottom: 5px;">
			<div class="sameline" style="margin-top: 5px; display: flex;">
				<div class="lbl" style="width: 130px;">Linea:</div>
				<select id="idlinea" class="classCmbBox" style="width: 200px;margin-right: 10px;">
				</select>
			</div>
			<div class="sameline" style="margin-top: 5px; display: flex;">
				<div class="lbl" style="width: 130px;">Turno:</div>
				<select id="idturno" class="classCmbBox" style="width: 200px;margin-right: 10px;">
					<option value="1">1</option>
					<option value="2">2</option>
				</select>
			</div>
			<div class="sameline" style="margin-top: 5px; display: flex;">
				<div class="lbl" style="width: 130px;">Fecha reporte:</div>
				<input type="date" id="idfecha" class="iptClass" style="width: 200px;margin-right: 10px;">
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;" onclick="showReporte()">Mostrar reporte</button>
			<div class="lineDecoration"></div>
			<!-- <button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="redirect('main.php')">Volver</button> -->
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="goBack()">Volver</button>
		</div>
	</div>
	<script type="text/javascript">
		var codusu='<?php echo $_SESSION['user']; ?>';
	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/SeleccionEfiEfcLin-1.0.js"></script>
	<script type="text/javascript">
		function goBack(){
			window.history.back();
		}
	</script>
</body>
</html>