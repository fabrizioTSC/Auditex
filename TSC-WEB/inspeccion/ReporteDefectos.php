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
			<div class="headerTitle">Reporte Defectos de Inspecci&oacute;n</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="rowLine">
				<button class="btnPrimary" style="margin-top: 0px;" onclick="exportar_excel()">Descargar</button>
				<button class="btnPrimary" style="margin-top: 0px;" onclick="redirect('main.php')">Volver</button>
			</div>	
			<div class="lineDecoration"></div>	
			<div style="margin-bottom: 10px;overflow: scroll;max-height: calc(100vh - 123px);">
				<div class="tblHeader" style="width: 1560px;">
					<div class="itemHeader" style="width: 90px;text-align: center;">Inspecci&oacute;n</div>
					<div class="itemHeader" style="width: 50px;text-align: center;">Ficha</div>
					<div class="itemHeader" style="width: 90px;text-align: center;">Cant. Ficha</div>
					<div class="itemHeader" style="width: 120px;text-align: center;">Fecha</div>
					<div class="itemHeader" style="width: 90px;text-align: center;">Usuario</div>
					<div class="itemHeader" style="width: 250px;text-align: center;">Taller</div>
					<div class="itemHeader" style="width: 150px;text-align: center;">Defecto</div>
					<div class="itemHeader" style="width: 150px;text-align: center;">Familia defecto</div>
					<div class="itemHeader" style="width: 150px;text-align: center;">Operaci&oacute;n</div>
					<div class="itemHeader" style="width: 90px;text-align: center;">Cant. Defectos</div>
					<div class="itemHeader" style="width: 90px;text-align: center;">Cant. Inspeccionada</div>
					<div class="itemHeader" style="width: 120px;text-align: center;">Cant. Prendas Defectuosas</div>
				</div>
				<div class="tblBody" id="data-lineas" style="width: 1560px;">
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var l="<?php echo $_GET['l']; ?>";
		var fecha="<?php echo $_GET['fecha']; ?>";
		var fechafin="<?php echo $_GET['fechafin']; ?>";
	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/ReporteInspeccion-v1.0.js"></script>
</body>
</html>