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
	<link rel="stylesheet" type="text/css" href="css/consultaAuditoria.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<style type="text/css">
		.h4-spe{
			margin-left: auto;
			margin-right: auto;
			max-width: 800px;
			width: 100%;
		}
		.table-spe{
			margin-left: auto;
			margin-right: auto;
			max-width: 800px;
			width: 100%;
		}
		h4{
			margin-bottom: 0;
			margin-top: 10px;
		}
		table{
			margin-top: 10px;
			border-collapse: collapse;
		}
		th{
			background: #980f0f;
			color: #fff;
		}
		td{
			background: #fff;
			color: #333;
		}
		td,th{
			padding: 5px;
			font-size: 13px;
			border:1px solid #333;
		}
	</style>
</head>
<body>
	<?php contentMenu();?>
	<div class="panelCarga" style="display: none;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Consulta de Medidas</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="sameLine">
				<div class="lblNew" style="width: 120px;padding-top: 11px;margin-right: 5px;">Estilo TSC</div>
				<input type="text" id="idesttsc" class="iptClass" style="width: calc(120px);font-size: 15px;">
				<button class="btnPrimary" style="width: 80px;margin-left: 10px;" onclick="consultar_esttsc()">Consultar</button>
			</div>
			<div id="resultesttsc" style="display: none;">
				<h4 class="h4-spe">Seleccione encogimiento</h4>
				<table class="table-spe">
					<thead>
						<tr>
							<th>HILO</th>
							<th>TRAVEZ</th>
							<th>LARGMANGA</th>
						</tr>
					</thead>
					<tbody id="table-body">
					</tbody>
				</table>
				<div id="result-encogimiento" style="display: none;">
					<h4>Reporte de medidas</h4>
					<h4 id="titulo">Medidas cargadas en desorden</h4>
					<table>
						<thead id="table-head-2">
							<tr>
								<th>COD.</th>
								<th>DESCRIPCIÓN</th>
								<th>P/C</th>
								<th>CRITICA</th>
								<th>MARGEN (1)</th>
								<th>MARGEN (2)</th>
								<th>TALLAS</th>
							</tr>
						</thead>
						<tbody id="table-body-2">
						</tbody>
					</table>				
				</div>		
			</div>
		</div>				
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		function consultar_esttsc(){
			document.getElementById("resultesttsc").style.display="none";
			document.getElementById("result-encogimiento").style.display="none";
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				url:"config/getEncogimientosAFC.php",
				data:{
					esttsc:document.getElementById("idesttsc").value
				},
				success:function(data){
					console.log(data);
					$(".panelCarga").fadeOut(100);
					if (data.state) {
						document.getElementById("table-body").innerHTML=data.detail;
						document.getElementById("resultesttsc").style.display="block";
					}else{
						alert(data.detail);
					}
				}
			});
		}
		function show_medidas(hilo,travez,largmanga){
			document.getElementById("result-encogimiento").style.display="none";
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				url:"config/getEncogimientoAFC.php",
				data:{
					esttsc:document.getElementById("idesttsc").value,
					hilo:Math.round(parseFloat(hilo)*100),
					travez:Math.round(parseFloat(travez)*100),
					largmanga:Math.round(parseFloat(largmanga)*100)
				},
				success:function(data){
					console.log(data);
					$(".panelCarga").fadeOut(100);
					if (data.state) {
						if (data.desorden) {
							document.getElementById("titulo").style.display="block";
						}else{
							document.getElementById("titulo").style.display="none";
						}
						document.getElementById("table-head-2").innerHTML=data.head;
						document.getElementById("table-body-2").innerHTML=data.body;
						document.getElementById("result-encogimiento").style.display="block";
					}else{
						alert(data.detail);
					}
				}
			});
		}
	</script>
</body>
</html>