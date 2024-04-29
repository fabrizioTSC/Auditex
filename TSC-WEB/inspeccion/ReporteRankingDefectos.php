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
	<script src="charts-dist/Chart.min.js"></script>
	<style type="text/css">
		.firstGraph{
			width: 100%;
		}
		#main-table{
			position: relative;
		}
		#head-table{
			position: absolute;
			top: 0;
			z-index: 10;
		}
		@media(max-width: 700px){	
			.contentGraph{
				min-width: 700px;
				padding-top: 0;
				margin-bottom: 0;
			}
			.firstGraph{
				overflow-x: scroll;
				margin-bottom: 10px;
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
			<div class="headerTitle">Reporte de Porcentaje de Prendas Defectuosas por L&iacute;nea - Turno</div>
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
				<div class="contentGraph" style="padding-top: 5px;">
					<canvas id="chart-area1"></canvas>
				</div>
			</div>
			<div class="content-table" style="max-height: calc(100vh - 200px);height: auto;" id="main-table">
				<div class="table">
					<div class="tbl-header">
						<div class="head" style="width: 40px">N°</div>
						<div class="head" style="width: calc(20% - 18px);">Linea</div>
						<div class="head" style="width: calc(20% - 18px);">Turno</div>
						<div class="head" style="width: calc(20% - 18px);">Pre. Def.</div>
						<div class="head" style="width: calc(20% - 18px);">Pre. Ins.</div>
						<div class="head" style="width: calc(20% - 18px);">% Def.</div>
					</div>
					<div class="tbl-header" id="head-table">
						<div class="head" style="width: 40px">N°</div>
						<div class="head" style="width: calc(20% - 18px);">Linea</div>
						<div class="head" style="width: calc(20% - 18px);">Turno</div>
						<div class="head" style="width: calc(20% - 18px);">Pre. Def.</div>
						<div class="head" style="width: calc(20% - 18px);">Pre. Ins.</div>
						<div class="head" style="width: calc(20% - 18px);">% Def.</div>
					</div>
					<div class="tbl-body" id="placeResult">
					</div>
				</div>
			</div>
			<div class="lineDecoration"></div>
		</div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<!-- <button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="redirect('main.php')">Volver</button> -->
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
		document.getElementById("main-table").addEventListener('scroll',function(){
			document.getElementById("head-table").style.top=document.getElementById("main-table").scrollTop+"px";
		});
		function download_pdf(){
			$.ajax({
			  	type: "POST",
			  	url: "config/saveTmpImg3.php",
			  	data: { 
			    	img: document.getElementById("chart-area1").toDataURL("image/png")
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
			  		a.href="fpdf/crearPdfRanPreDef.php?n="+data
			  		+"&t="+document.getElementById("spacetitulo").innerHTML
			  		+"&anio="+anio
			  		+"&mes="+mes
			  		+"&semana="+semana
			  		+"&fecini="+fecini
			  		+"&fecfin="+fecfin
			  		+"&option="+option;
			  		a.click();
			  	}
			}).done(function(o) {
			  	console.log('Images Saved!'); 
			});
		}
	</script>
	<script type="text/javascript" src="js/ReporteRankingDefectos-v1.1.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		function goBack(){
			window.history.back();
		}
	</script>
</body>
</html>