<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="3";
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
		h5{
			margin: 5px 0;
		}
		table{
			margin-bottom: 10px;
		}
		table,th,td{
		  	border: 1px solid black;
		  	border-collapse: collapse;
		  	font-size: 12px;
		  	text-align: center;
		}
		th{
			background: #980f0f;
			color: #fff;
		}
		td{
			background: #fff;
			color: #000;
		}
		th,td{
			padding: 5px;
			width: calc(100%/9);
		}
		.class-total{
			background: #333;
			color: #fff;
		}
		.portotpul,.totpul{
			background: #ccc;
		}
		center{
			font-size: 13px;
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
	<?php contentMenu();?>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Reporte de Desviaci&oacute;n de Medidas</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="title-medida">Estilo TSC: <?php if($_GET['esttsc']!="0"){echo $_GET['esttsc'];}else{ echo "TODOS";} ?></div>
			<div class="title-medida">Ficha: <?php if($_GET['codfic']!="0"){echo $_GET['codfic'];}else{ echo "TODOS";} ?></div>
			<div class="title-medida">Estilo Cliente:&nbsp;<span id="idestcli"></span></div>
			<div class="title-medida">Cliente:&nbsp;<span id="idcliente"></span></div>
			<div class="lineDecoration"></div>
			<div id="content-main">
			</div>
			<!--
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 10px;margin-bottom: 0px;" onclick="download_excel()" id="btndescarga">Descargar</button>-->
			<div class="btn-primary" onclick="window.history.back();">Volver</div>
		</div>
	</div>
	<script type="text/javascript">
		var esttsc="<?php echo $_GET['esttsc']; ?>";
		var codfic="<?php echo $_GET['codfic']; ?>";
	</script>
	<script type="text/javascript" src="js/ReporteDesMed-v1.0.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>