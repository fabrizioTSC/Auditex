<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="14";
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
		.main-content{
			width: 100%;
			max-width: 500px;
			margin: 0 auto;
		}
		table{
			border-collapse: collapse;
			width: 100%;
		}
		th{
			padding: 5px;
			background: #980f0f;
			color: #fff;
		}
		td{
			padding: 5px;
			background: #fff;
			color: #000;
		}
		td input{
			width: calc(100% - 12px)!important;
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
			<div class="headerTitle">Actualizar Objetivos</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="main-content">
				<table id="table-anios">
				</table>		
			</div>
		</div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="guardar_obj()">Guardar</button>
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="window.history.back();">Volver</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript">		
		$(document).ready(function(){
			$.ajax({
				type:"POST",
				data:{
				},
				url:"config/getObjetivosAnio.php",
				success:function(data){
					console.log(data);
					$("#table-anios").append(data.html);	
					$(".panelCarga").fadeOut(200);
				},
			    error: function (jqXHR, exception) {
			        var msg = '';
			        if (jqXHR.status === 0) {
			            msg = 'Sin conexión.\nVerifique su conexión a internet!';
			        } else if (jqXHR.status == 404) {
			            msg = 'No se encuentra el archivo necesario para guardar la inspección!';
			        } else if (jqXHR.status == 500) {
			            msg = 'Servidor no disponible (Web de TSC). Intente más tarde';
			        } else if (exception === 'parsererror') {
			            msg = 'La respuesta tiene errores. Por favor, contactar al equipo de desarrollo!';
			        } else if (exception === 'timeout') {
			            msg = 'Tiempo de respuesta muy largo (Web de TSC)!';
			        } else if (exception === 'abort') {
			            msg = 'Se cancelo la consulta!';
			        } else {
			            msg = 'Error desconocido.\n' + jqXHR.responseText+'.\nInforme al equipo de desarrollo!';
			        }
			        alert(msg);
					$(".panelCarga").fadeOut(200);
			    }
			});
		});

		function guardar_obj(){
			var ar=document.getElementsByClassName("ipt-objanio");
			var ar_send=[];
			for (var i = 0; i < ar.length; i++) {
				var aux=[];
				aux.push(ar[i].id.replace("anio-",""));
				aux.push(Math.round(parseFloat(ar[i].value)*100));
				ar_send.push(aux);
			}
			console.log(ar_send);
			$(".panelCarga").fadeIn(200);
			$.ajax({
				type:"POST",
				data:{
					array:ar_send
				},
				url:"config/saveObjetivosAnio.php",
				success:function(data){
					console.log(data);
					if (!data.state) {
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(200);
				},
			    error: function (jqXHR, exception) {
			        var msg = '';
			        if (jqXHR.status === 0) {
			            msg = 'Sin conexión.\nVerifique su conexión a internet!';
			        } else if (jqXHR.status == 404) {
			            msg = 'No se encuentra el archivo necesario para guardar la inspección!';
			        } else if (jqXHR.status == 500) {
			            msg = 'Servidor no disponible (Web de TSC). Intente más tarde';
			        } else if (exception === 'parsererror') {
			            msg = 'La respuesta tiene errores. Por favor, contactar al equipo de desarrollo!';
			        } else if (exception === 'timeout') {
			            msg = 'Tiempo de respuesta muy largo (Web de TSC)!';
			        } else if (exception === 'abort') {
			            msg = 'Se cancelo la consulta!';
			        } else {
			            msg = 'Error desconocido.\n' + jqXHR.responseText+'.\nInforme al equipo de desarrollo!';
			        }
			        alert(msg);
					$(".panelCarga").fadeOut(200);
			    }
			});
		}
	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>