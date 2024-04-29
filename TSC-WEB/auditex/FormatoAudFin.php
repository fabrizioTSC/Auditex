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
	<link rel="stylesheet" type="text/css" href="css/IndicadorResultado-v1.0.css">
	<link rel="stylesheet" type="text/css" href="css/IndicadorClasiFicha-v1.0.css">
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
			<div class="headerTitle">Formato Auditoria Final</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent" style="padding-bottom: 0px;">
			<div class="btnPrimary" style="margin-left: calc(50% - 80px);width: 135px;
			padding: 5px;display: flex;padding-left: 20px;" onclick="exportar()">
				<img src="assets/img/excel.png" style="width: 30px;height: 30px;">
				<div style="padding: 5px;width:calc(80px);text-align: center;">Descargar</div>
			</div>
			<div class="lineDecoration"></div>
			<div class="lblNew" id="title-form"></div>
			<div id="tbl-formato" style="overflow: scroll; max-height: calc(100vh - 185px);">
				<div style="width: 1620px; position: relative;">
					<div class="tblHeader" id="tbl-header-animate" style="position: relative;top: 0px;left: 0px;z-index: 10;">
						<div class="itemHeader2" style="width: 50px;">Item</div>
						<div class="itemHeader2" style="width: 80px;">Fecha</div>
						<div class="itemHeader2" style="width: 100px;">Auditor</div>
						<div class="itemHeader2" style="width: 130px;">Linea/Servicio</div>
						<div class="itemHeader2" style="width: 150px;">Cliente</div>
						<div class="itemHeader2" style="width: 60px;">Estilo</div>
						<div class="itemHeader2" style="width: 80px;">Pedido</div>
						<div class="itemHeader2" style="width: 60px;">Ficha</div>
						<div class="itemHeader2" style="width: 100px;">Color</div>
						<div class="itemHeader2" style="width: 80px;">Parte</div>
						<div class="itemHeader2" style="width: 80px;font-size: 12px;">Cant. veces auditada</div>
						<div class="itemHeader2" style="width: 80px;">Lote</div>
						<div class="itemHeader2" style="width: 80px;">Muestra</div>
						<div class="itemHeader2" style="width: 80px;">Cod. Def.</div>
						<div class="itemHeader2" style="width: 100px;">Desc. Def.</div>
						<div class="itemHeader2" style="width: 80px;">Cant. Def.</div>
						<div class="itemHeader2" style="width: 60px;">A/R</div>
					</div>
					<div class="tblBody" id="body-response" style="position: relative;">
					</div>
				</div>		
			</div>
		</div>
		<div class="rowLine bodyPrimary" style="margin-top: 5px;margin-bottom: 10px;">
			<!-- <button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="redirect('ReportesAuditoria.php')">Volver</button> -->
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="goBack()">Volver</button>
		</div>	
	</div>
	<script type="text/javascript">
		var option="<?php echo $_GET['option']; ?>";
		var codtll="<?php if(isset($_GET['codtll'])){echo $_GET['codtll'];}else{echo '';} ?>";
		var codsede="<?php if(isset($_GET['codsede'])){echo $_GET['codsede'];}else{echo '';} ?>";
		var codtipser="<?php if(isset($_GET['codtipser'])){echo $_GET['codtipser'];}else{echo '';} ?>";
		var pedido="<?php if(isset($_GET['pedido'])){echo $_GET['pedido'];}else{echo '';} ?>";
		var codfic="<?php if(isset($_GET['codfic'])){echo $_GET['codfic'];}else{echo '';} ?>";
		var check="<?php if(isset($_GET['check'])){echo $_GET['check'];}else{echo '';} ?>";
		var fecini="<?php echo $_GET['fecini']; ?>";
		var fecfin="<?php echo $_GET['fecfin']; ?>";
	</script>
	<script type="text/javascript" src="js/FormatoAudFin-v1.2.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		function goBack(){
			window.history.back();
		}
	</script>
</body>
</html>