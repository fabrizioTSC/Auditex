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
	<div class="panelCarga" style="display: none;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Filtro Minutos Compensados por Estilo</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent" style="padding-bottom: 5px;">
			<div class="sameline" style="margin-top: 5px; display: flex;">
				<div class="lbl" style="width: 130px;">Fecha inicio:</div>
				<input type="date" id="idfecini" class="iptClass" style="width: 200px;margin-right: 10px;">
			</div>
			<div class="sameline" style="margin-top: 5px; display: flex;">
				<div class="lbl" style="width: 130px;">Fecha fin:</div>
				<input type="date" id="idfecfin" class="iptClass" style="width: 200px;margin-right: 10px;">
			</div>
			<div style="width: 100%;height: 20px;"></div>
			<div class="sameLine">
				<div class="lblNew" style="width: 120px;padding-top: 11px;">Estilo TSC</div>
				<input type="text" id="nombreEsttsc" class="iptClass" style="width: calc(100% - 222px);font-size: 15px;">
				<button class="btnPrimary" style="width: 80px;margin-left: 10px;" onclick="consultar_esttsc()">Consultar</button>
			</div>
			<div id="resultesttsc" style="display: none;">
				<div style="width: 100%;height: 20px;"></div>
				<div class="sameLine">
					<div class="lblNew" style="width: 120px;padding-top: 5px;">Ficha</div>
					<input type="text" id="nombreFicha" class="iptClass" style="width: calc(100% - 120px);font-size: 15px;">
				</div>
				<div class="tblSelection">
					<div class="listaTalleres" id="spaceficha">
						<div class="taller"></div>
					</div>
				</div>
			</div>
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;" onclick="showReporte()">Mostrar reporte</button>
			</div>	
			<div class="lineDecoration"></div>
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="redirect('main.php')">Volver</button>
			</div>	
		</div>
	</div>
	<script type="text/javascript">
		var codusu='<?php echo $_SESSION['user']; ?>';
	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/SeleccionMinComEst-1.0.js"></script>
</body>
</html>