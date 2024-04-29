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
	<link rel="stylesheet" type="text/css" href="css/ReporteRangoDefectos.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="css/IndicadorResultado-v1.0.css">
	<script src="charts-dist/Chart.min.js"></script>
	<script src="charts-dist/chartjs-plugin-datalabels.js"></script>
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
			<div class="headerTitle">Indicador Eficiencia y Eficacia de Linea</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>			
			</div>
		</div>
		<div class="bodyContent mainBodyContent" style="padding-bottom: 0px;">	
			<div class="lblNew" id="spacetitulo"></div>
			<center>
				<button class="btnPrimary" style="margin-bottom: 5px;" onclick="download_pdf()">Descargar PDF</button>
			</center>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;">
					<canvas id="chart-area"></canvas>
				</div>
			</div>
			<div class="contentTbl">
				<div class="lateralHeAders">
					<div class="items1">DETALLE GENERAL</div>
					<div class="items1 items2">MIN. EFICIENCIA</div>
					<div class="items1 items2">MIN. EFICACIA</div>
					<div class="items1 items2">MIN. ASI.</div>
					<div class="items1 items2">EFICIENCIA</div>
					<div class="items1 items2">EFICACIA</div>
				</div>
				<div class="contents" id="placeAnios">
				</div>
				<div class="contents" id="placeMeses">
				</div>
				<div class="contents" id="placeSemanas">
				</div>
			</div>
			<!--
			<div class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;width: 135px;
			padding: 5px;display: flex;padding-left: 20px;" 
			onclick="exportarRanking()">
				<img src="assets/img/excel.png" style="width: 30px;height: 30px;">
				<div style="padding: 5px;width:calc(80px);text-align: center;">Descargar</div>
			</div>-->
			<div class="lineDecoration"></div>
			<!-- <button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="redirect('main.php')">Volver</button> -->
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="goBack()">Volver</button>
		</div>
	</div>
	<script type="text/javascript">
		var linea="<?php echo $_GET['linea']; ?>";
		var turno="<?php echo $_GET['turno']; ?>";
		var fecha="<?php echo $_GET['fecha']; ?>";
		function download_pdf(){
			$.ajax({
			  	type: "POST",
			  	url: "config/saveTmpImg3.php",
			  	data: { 
			    	img: document.getElementById("chart-area").toDataURL("image/png")
			  	},
			  	success:function(data){
			    	/*anio:anio,
					mes:mes,
					semana:semana,
					fecini:fecini,
					fecfin:fecfin,
					option:option*/
			  		var a=document.createElement("a");
			  		a.target="_blank";
			  		a.href="fpdf/crearPdfEfiEfcLin.php?n="+data
			  		+"&t="+document.getElementById("spacetitulo").innerHTML
			  		+"&linea="+linea
			  		+"&turno="+turno
			  		+"&fecha="+fecha
			  		+"&ran1="+param_codran1
			  		+"&ran2="+param_codran2;
			  		a.click();
			  	}
			}).done(function(o) {
			  	console.log('Images Saved!'); 
			});
		}
	</script>
	<script type="text/javascript" src="js/IndEfiEfcLin-v1.1.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		function goBack(){
			window.history.back();
		}
	</script>

</body>
</html>