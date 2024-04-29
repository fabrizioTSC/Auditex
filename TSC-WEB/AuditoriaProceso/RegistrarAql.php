<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="6";
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
	<!-- Iconos de fuente externa -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
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
			<!--
			<div class="backSpace">
				<div class="iconSpace"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
			</div>
			-->
			<div class="headerTitle">Consultar AQL's</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">			
			<div class="rowLine">
				<div class="lbl" style="font-size: 18px;margin-bottom: 5px;width: 200px;">Escoga AQL</div>
				<select class="classCmbBox" id="idSelectAql">
				</select>
			</div>
		</div>
		<div class="bodyContent" style="display: none;padding-top: 0px;" id="idMsg">
			<div class="lblNew" style="color: red;font-size: 15px;">No hay detalle.</div>
		</div>
		<div class="bodyContent" style="display: none;padding-top: 0px;" id="idTblDetalleAql">			
			<div class="lblNew" style="width: 100%;">Detalle de AQL</div>			
				<div class="tblDetalleAql">
					<div class="tblHeader">
						<div class="itemHeader" style="width: 40%;">Rango</div>							
						<div class="itemHeader" style="width: 30%;">Cantidad</div>							
						<div class="itemHeader" style="width: 30%;">Defectos</div>						
					</div>
					<div class="tblBody tblBodyDetalle">
					</div>
				</div>
			</div>
		</div>
		<div class="lineWithDecoration"></div>
		<div class="bodyContent">
			<div class="rowLine">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="redirect('RegistrarAsignarAql.php')">Terminar</button>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/RegistrarAql.js"></script>
</body>
</html>