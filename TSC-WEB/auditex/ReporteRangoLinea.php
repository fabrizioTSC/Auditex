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
	<link rel="stylesheet" type="text/css" href="css/ReporteRangoLinea.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<script src="charts-dist/Chart.min.js"></script>
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
			<div class="headerTitle">Reporte de Ranking de rechazos de auditor&iacute;as finales de costura en L&iacute;neas/Servicios</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent" style="padding-bottom: 0px;">	
			<div class="lblNew" id="spacetitulo"></div>
			<div class="firstGraph">
				<div class="contentGraph" style="padding-top: 5px;">
					<canvas id="chart-area1"></canvas>
				</div>
			</div>
			<div class="content-table">
				<div class="table">
					<div class="tbl-header">
						<div class="head" style="width: 40px">N°</div>
						<div class="head" style="width: 180px">Nom. Comercial</div>
						<div class="head" style="width: 180px">Taller</div>
						<div class="head" style="width: 100px">Sede</div>
						<div class="head" style="width: 100px">Tip. Ser.</div>
						<div class="head" style="width: 60px">%</div>
						<div class="head" style="width: 70px">Tot. Aud.</div>
						<div class="head" style="width: 70px">Tot. Rec.</div>
					</div>
					<div class="tbl-body" id="placeResult">
						<div class="body-line">
							<div class="body" style="width: 90px">Cod. Tll.</div>
							<div class="body" style="width: 150px">Taller</div>
							<div class="body" style="width: 100px">Sede</div>
							<div class="body" style="width: 100px">Tip. Ser.</div>
							<div class="body" style="width: 50px">%</div>
							<div class="body" style="width: 70px">Tot. Aud.</div>
							<div class="body" style="width: 70px">Tot. Rec.</div>
						</div>
					</div>
				</div>
			</div>
			<div class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;width: 135px;
			padding: 5px;display: flex;padding-left: 20px;" 
			onclick="exportarRanking()">
				<img src="assets/img/excel.png" style="width: 30px;height: 30px;">
				<div style="padding: 5px;width:calc(80px);text-align: center;">Descargar</div>
			</div>
			<div class="lineDecoration"></div>
		</div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<!-- <button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="redirect('ReportesAuditoria.php')">Volver</button> -->
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="goBack()">Volver</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript">
		var anio="<?php if(isset($_GET['anio'])){echo $_GET['anio'];}else{echo "";} ?>";
		var mes="<?php if(isset($_GET['mes'])){echo $_GET['mes'];}else{echo "";} ?>";
		var semana="<?php if(isset($_GET['semana'])){echo $_GET['semana'];}else{echo "";} ?>";
		var fecini="<?php if(isset($_GET['fecini'])){echo $_GET['fecini'];}else{echo "";} ?>";
		var fecfin="<?php if(isset($_GET['fecfin'])){echo $_GET['fecfin'];}else{echo "";} ?>";
		var option="<?php echo $_GET['option']; ?>";
		var codsede="<?php echo $_GET['codsede']; ?>";
		var codtipser="<?php echo $_GET['codtipser']; ?>";
	</script>
	<script type="text/javascript" src="js/ReporteRankinLinea-v1.0.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		function goBack(){
			window.history.back();
		}
	</script>
</body>
</html>