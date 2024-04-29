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
	<link rel="stylesheet" type="text/css" href="css/consultaAuditoria.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<style type="text/css">
		.itemvariable{
			width: calc(100% - 700px);
		}
		.sizerTbl{
			width: auto;
		}
		@media(max-width: 850px){
			.itemvariable{
				width: 150px;
			}	
			.sizerTbl{
				width: 850px;
			}
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
			<div class="headerTitle">Reporte de Fichas Inicio Autom&aacute;tico</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent" style="padding-bottom: 0px;">
			<div class="lblTitulo" id="titulodetalle"></div>
			<div class="mayorContent" id="tblMain">
				<div class="rowLine sizerTbl" style="display: block;">
					<div class="tblPrendasDefecto" style="position: relative;">
						<div class="tblHeader" id="tbl-header" style="position: relative;z-index: 10;">
							<div class="itemHeader2" style="width: 80px;">Ficha</div>
							<div class="itemHeader2" style="width: 100px;">Sede</div>
							<div class="itemHeader2" style="width: 100px;">Tip. Servicio</div>
							<div class="itemHeader2 itemvariable">Taller</div>
							<div class="itemHeader2" style="width: 100px;">Fec. Mov.</div>
							<div class="itemHeader2" style="width: 100px;">Usuario Mov.</div>
							<div class="itemHeader2" style="width: 150px;">Observaci&oacute;n</div>
						</div>
						<div class="tblBody" id="tbl-body" style="position: relative;">
						</div>
					</div>
				</div>
			</div>
			<div class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;width: 135px;
				padding: 5px;display: flex;padding-left: 20px;" onclick="exportar()">
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
		var codtll="<?php echo $_GET['codtll']; ?>";
		var codsed="<?php echo $_GET['codsede']; ?>";
		var codtipser="<?php echo $_GET['codtipser']; ?>";
	</script>
	<script type="text/javascript" src="js/FichasIniAut-v1.1.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		function goBack(){
			window.history.back();
		}
	</script>
</body>
</html>