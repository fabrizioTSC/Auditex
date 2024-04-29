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
			<div class="headerTitle">Registrar Defecto</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">			
			<div class="rowLine bodyPrimary">
				<div class="lbl" style="font-size: 18px;">Ingrese Defecto</div>
				<div class="lineDecoration"></div>
				<div class="lbl" style="margin-bottom:5px;">Descripci&oacute;n</div>
				<input type="text" id="description" class="classIpt" style="margin-bottom:10px;">
				<div class="lbl" style="margin-bottom:5px;">C&oacute;digo auxiliar</div>
				<input type="text" id="descriptionAuxiliar" class="classIpt" style="margin-bottom:10px;">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="agregarDefecto()">Agregar</button>
			</div>
			<div class="rowLine bodySecondary" style="display: block;">
				<div class="rowLine">
					<div class="lineDecoration"  style="margin-top: 15px;"></div>
					<div class="subtitle" style="margin-top: 10px;">Defectos registrados</div>
					<div class="spaceInLine"></div>
					<div class="tblContent">
						<div class="tblHeader">
							<div class="itemHeader" style="width:15%;">C&oacute;digo</div>							
							<div class="itemHeader" style="width:70%;">Descripci&oacute;n</div>
							<!--<div class="itemHeader" style="width:35%;">Desc. Auxiliar</div>-->
							<div class="itemHeader" style="width:15%;">Estado</div>
						</div>
						<div class="tblBody" style="overflow-y: scroll;max-height: 350px;">
						</div>
					</div>
				</div>
			</div>
			<div class="rowLine">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 10px;" onclick="redirect('main.php')">Terminar</button>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/RegistrarDefecto.js"></script>
</body>
</html>