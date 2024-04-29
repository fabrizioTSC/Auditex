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
<body onload="chargeTallerTerFichas('<?php echo $_SESSION['user']; ?>')">
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
			<div class="headerTitle">Terminar Fichas</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">			
			<div class="rowLine">
				<div class="sameLine">
					<div class="lbl" style="width: 120px;">Ingrese taller:</div>
					<div class="spaceIpt" style="width: calc(100% - 120px);font-size: 15px">
						<input type="text" id="idTallerName" class="classIpt">
					</div>
				</div>
				<div class="tblSelection">
					<div class="listaTalleres">
						<div class="classTaller" data-idtaller="" data-nomtaller=""></div>
					</div>
				</div>
			</div>
		</div>
		<div class="bodyContent" style="display: none;padding-top: 0px;" id="idMsg">
			<div class="lblNew" style="color: red;font-size: 15px;">No hay talleres.</div>
		</div>
		<div class="lineWithDecoration"></div>
		<div id="hiddenSpace" style="display: none;">
			<div class="tblDistributionTalla" style="margin-top: 10px;margin-bottom: 10px">
				<div class="tblHeader">
					<div class="itemHeader" style="width: 50%;">Ficha</div>							
					<div class="itemHeader" style="width: 50%;">Terminar</div>						
				</div>
				<div class="tblBody" id="fichasTaller">
				</div>
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;margin-bottom: 5px;" onclick="saveFichasTerminadas()">Guardar cambios</button>
			<div class="lineWithDecoration"></div>
		</div>
		<div class="bodyContent">
			<div class="rowLine">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="redirect('main.php')">Terminar</button>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/TerminarFichas.js"></script>
</body>
</html>