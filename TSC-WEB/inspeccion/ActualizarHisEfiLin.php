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
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="css/MenuMonitor.css">
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
			<div class="headerTitle">Actualizar Histórico de Eficiencias de Linea</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="content-btns-monitor" id="space-to-charge">
		</div>
		<div class="rowLine">				
			<div class="sameLine" style="margin-bottom: 5px;">
				<div class="lblNew" style="width: 140px;padding-top: 8px;">Fecha:</div>
				<input type="date" id="idFecha" class="iptClass" style="width: calc(100% - 140px);font-size: 15px;font-family: sans-serif;">
			</div>
		</div>
		<div class="sameLine">			
			<button class="btnPrimary" style="margin:auto;margin-top: 10px;" onclick="update_hisefilin()">Actualizar</button>
		</div>
		<div class="sameLine">			
			<button class="btnPrimary" style="margin:auto;margin-top: 10px;" onclick="window.history.back()">Volver</button>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		$("#idFecha").val(get_today());
		function update_hisefilin(){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				url:"config/_getInfoRepLineas-cargav2.php",
				type:"GET",
				data:{
					fecha:$("#idFecha").val()
				},
				success:function(data){
					alert(data);
					$(".panelCarga").fadeOut(100);
				},
				error:function(err){
					alert("Hubo un error: "+err);
					$(".panelCarga").fadeOut(100);
				}
			})
		}
	</script>
</body>
</html>