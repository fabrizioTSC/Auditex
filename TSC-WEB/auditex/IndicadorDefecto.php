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
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="css/IndicadorResultado-v1.0.css">
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
			<div class="headerTitle">Indicador de Defecto</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<!--
			<div class="rowLine" style="margin-bottom: 5px">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="downloadPDF()">Descargar PDF</button>
			</div>-->
			<div class="lblTitulo">INDICADOR DE DEFECTO: <span id="idDesDef"></span></div>
			<div class="lblTitulo" id="titulodetalle"></div>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;">
					<canvas id="chart-area"></canvas>
				</div>
			</div>
			<div class="rowLine" style="margin-bottom: 5px">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="back_page()">Volver</button>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var codusu='<?php echo $_SESSION['user']; ?>';
		var codtll='<?php echo $_GET['codtll']; ?>';
		var codtipser='<?php echo $_GET['codtipser']; ?>';
		var codsede='<?php echo $_GET['codsede']; ?>';
		var desdef='<?php echo $_GET['desdef']; ?>';
		var coddef='<?php echo $_GET['coddef']; ?>';
		var titulo='<?php echo $_GET['titulo']; ?>';
	</script>
	<script type="text/javascript" src="js/IndicadorDefecto-v1.0.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>