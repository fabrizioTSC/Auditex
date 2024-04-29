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
			<div class="headerTitle">Reporte de Eficacia de Costura</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="rowLine">
				<button class="btnPrimary" style="margin-top: 0px;" onclick="exportar_excel()">Descargar</button>
				<button class="btnPrimary" style="margin-top: 0px;" onclick="goBack()">Volver</button>
			</div>	
			<div class="lineDecoration"></div>	
			<div style="margin-bottom: 10px;overflow: scroll;max-height: calc(100vh - 123px);">
				<div class="tblHeader" style="width: 2810px;">
					<div class="itemHeader" style="width: 90px;text-align: center;">Lineas de Planta - Chincha</div>
					<div class="itemHeader" style="width: 50px;text-align: center;">Turno</div>
					<div class="itemHeader" style="width: 90px;text-align: center;">Fecha</div>
					<div class="itemHeader" style="width: 120px;text-align: center;">Operarios inicio de turno</div>
					<div class="itemHeader" style="width: 90px;text-align: center;">Hora fin de jornada</div>
					<div class="itemHeader" style="width: 150px;text-align: center;">Cliente</div>
					<div class="itemHeader" style="width: 70px;text-align: center;">Eficiencia</div>
					<div class="itemHeader" style="width: 70px;text-align: center;">Eficacia</div>
					<div class="itemHeader" style="width: 90px;text-align: center;">Min. Eficiencia</div>
					<div class="itemHeader" style="width: 90px;text-align: center;">Min. Eficacia</div>
					<div class="itemHeader" style="width: 90px;text-align: center;">Min. Asi.</div>
					<div class="itemHeader" style="width: 90px;text-align: center;">Prendas Ingresadas</div>
					<div class="itemHeader" style="width: 80px;text-align: center;">Prendas Producidas</div>
					<div class="itemHeader" style="width: 80px;text-align: center;">Proyecci&oacute;n</div>
					<div class="itemHeader" style="width: 60px;text-align: center;">Cuota</div>
					<div class="itemHeader" style="width: 90px;text-align: center;">Prendas auditadas aprobadas</div>
					<div class="itemHeader" style="width: 100px;text-align: center;">Prendas Inspeccionadas</div>
					<div class="itemHeader" style="width: 90px;text-align: center;">Prendas Defectuosas</div>
					<div class="itemHeader" style="width: 100px;text-align: center;">% Prendas Defectuosas</div>
					<div class="itemHeader" style="width: 90px;text-align: center;">Reproceso de costura</div>
					<div class="itemHeader" style="width: 100px;text-align: center;">% Reproceso de costura</div>
					<div class="itemHeader" style="width: 70px;text-align: center;">Efi. Est.</div>
					<div class="itemHeader" style="width: 70px;text-align: center;">Efc. Est.</div>
					<div class="itemHeader" style="width: 90px;text-align: center;">Min. Efi. Est.</div>
					<div class="itemHeader" style="width: 90px;text-align: center;">Min. Efc. Est.</div>
					<div class="itemHeader" style="width: 70px;text-align: center;">Efi. Ori.</div>
					<div class="itemHeader" style="width: 70px;text-align: center;">Efc. Ori.</div>
					<div class="itemHeader" style="width: 90px;text-align: center;">Min. Efi. Ori.</div>
					<div class="itemHeader" style="width: 90px;text-align: center;">Min. Efc. Ori.</div>
				</div>
				<div class="tblBody" id="data-lineas" style="width: 2810px;">
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
	<script type="text/javascript" src="js/ReporteLineas-v1.6.js"></script>
	<script type="text/javascript">
		function goBack(){
			window.history.back();
		}
	</script>
</body>
</html>