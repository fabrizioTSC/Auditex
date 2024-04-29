<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="2";
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
	<link rel="stylesheet" type="text/css" href="css/RegistroMedidas-v1.0.css">
	<style type="text/css">
		.item-maxheight{
			height: 40px;
		}
		.item-c2,.item-c3,.item-c4,.item-c5{
			height: 10px;
		}
		.header-content{
			position: relative;
			z-index: 10;
		}
		.main-content-medida{
			position: relative;
		}
	</style>
</head>
<body>
	<div class="panelCarga" style="display: block;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="msgInstant" style="display: none;">
		<div class="bodyMsgInstant">
			<div class="textMsgCarga">CARGANDO...</div>
		</div>
	</div>
	<?php contentMenu();?>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Auditor&iacute;a final de Medidas</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="title-medida">Ficha: <?php echo $_GET['codfic']; ?></div>		
			<div class="lineDecoration"></div>
			<div id="content-main">
				<div class="sameline" style="margin-bottom: 5px;">
					<div class="lblNew" style="width: 150px;padding-top: 7px;">Prendas por talla:</div>
					<input type="number" id="CanXTalla" class="iptClass" style="width: calc(50px);" value="1" min="1">
				</div>	
				<div class="sameline">
					<div class="btn-primary" onclick="redirect('main.php')" style="width: 150px;margin-right: calc(50% - 150px);">Volver</div>
					<div class="btn-primary" onclick="generateTable()" style="width: 150px;margin-left: calc(50% - 150px);">Generar</div>
				</div>
				<div class="lineDecoration"></div>	
				<div id="resume-medida" style="display: none;overflow: scroll;max-height: calc(100vh - 185px);position: relative;">
					<div class="tbl-header" id="space-res-hader" style="display: flex;position: relative;z-index: 10;">
					</div>
					<div id="space-tbl-medidas" style="display: flex;position: relative;">
					</div>
				</div>
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 10px;margin-bottom: 0px;" onclick="download_excel()" id="btndescarga">Descargar</button>
				<div class="btn-primary" onclick="redirect_registro()" style="margin-top: 10px;">Iniciar auditor&iacute;a</div>
			</div>
			<div id="second-frame" style="display: none;">
				<div class="title-medida">Talla&nbsp;<span id="talla-select"></span>&nbsp;- Prendas <div class="content-btns-prenda" id="space-btns-prendas"></div></div>
				<div id="space-tbl-generate" style="max-height: calc(100vh - 212px);overflow-y: scroll;position: relative;">
				</div>
				<div class="sameline" style="margin-top: 5px;">
					<div class="btn-primary" onclick="move_frame(0)" style="width: 100px;margin-right: calc(50% - 100px);">Anterior</div>
					<div class="btn-primary" onclick="move_frame(1)" style="width: 100px;margin-left: calc(50% - 100px);">Siguiente</div>
				</div>
				<div class="lineDecoration"></div>
				<div class="btn-primary" onclick="endRegistroMedida('main.php')">Finalizar</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var codfic="<?php echo $_GET['codfic']; ?>";
		var hilo="<?php echo isset($_GET['hilo']) ? $_GET["hilo"] :"vacio" ; ?>";
		var travez="<?php echo isset($_GET['travez']) ? $_GET["travez"] :"vacio" ; ?>";
		var largmanga="<?php echo isset($_GET['largmanga']) ? $_GET["largmanga"] :"vacio" ; ?>";
	</script>
	<script type="text/javascript" src="js/RegistrarMedAudFinCor-v1.3.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>