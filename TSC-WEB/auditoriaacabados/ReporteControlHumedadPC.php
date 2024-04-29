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
	<link rel="stylesheet" type="text/css" href="css/index-v1.0.css">
	<link rel="stylesheet" type="text/css" href="css/consultaAuditoria.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<style type="text/css">
		.ipt-check,.ipt-check-s{
			margin: 0!important;
		}
		.td-c{
			text-align: center;
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
			<div class="headerTitle">Reporte Control de Humedad</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
				<div><span>Pedido: </span><span id="pedido-d">asd</span></div>
				<div><span>Colores: </span><span id="colores-d">gfsdfsd</span></div>
				<table style="margin-top: 5px;">
					<thead>
						<tr>
							<th>Nro</th>
							<th>Ficha</th>
							<th>Color</th>
							<th>Fecha</th>
							<th>Auditor</th>
							<th>Humedad Promedio</th>
							<th></th>
						</tr>
					</thead>
					<tbody id="tbl-consulta">
					</tbody>
				</table>
				<div style="margin-top: 5px;"><a style="text-decoration: underline;cursor: pointer;" onclick="ver_fichas()">Ver fichas sin registro</a></div>
				<div id="table-sr" style="display: none;">
					<table style="margin-top: 5px;">
						<thead>
							<tr>
								<th>Nro</th>
								<th>Ficha</th>
								<th>Color</th>
							</tr>
						</thead>
						<tbody id="tbl-consulta-2">
						</tbody>
					</table>
				</div>
				<div style="display: flex;justify-content: center;">
					<button class="btnPrimary" style="margin-top: 5px;" onclick="volver()">Volver</button>
				</div>
		</div>
	</div>
	<script type="text/javascript">
		var pedido="<?php echo $_GET['pedido']; ?>";
		var colores="<?php echo $_GET['colores']; ?>";
		$(document).ready(function(){
			document.getElementById("pedido-d").innerHTML=pedido;
			document.getElementById("colores-d").innerHTML=colores;
			$.ajax({
				type:"POST",
				data:{
					pedido:pedido,
					colores:colores
				},
				url:"config/getConRepConHum.php",
				success:function(data){
					console.log(data);
					if (data.state) {
						document.getElementById("tbl-consulta").innerHTML=data.html;
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		});
		function ver_fichas(){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				data:{
					pedido:pedido,
					colores:colores
				},
				url:"config/getConRepConHumSinReg.php",
				success:function(data){
					console.log(data);
					if (data.state) {
						document.getElementById("table-sr").style.display="block";
						document.getElementById("tbl-consulta-2").innerHTML=data.html;
					}else{
						document.getElementById("table-sr").style.display="none";
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function volver(){
			window.history.back();
		}
	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>