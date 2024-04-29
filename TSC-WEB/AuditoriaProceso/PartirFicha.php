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
	<link rel="stylesheet" type="text/css" href="css/consultaAuditoria.css">
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
			<div class="headerTitle">Partir ficha</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">	
			<div class="rowLineFlex">
				<div style="margin-left: 10%;width: 80%;display: flex;">
					<div class="lblNew" style="width: 70px;padding-top: 5px;">Ficha</div>
					<div class="spaceIpt" style="width: calc(100% - 105px);">
						<input type="text" id="idCodFicha" class="iptClass">
					</div>
					<div class="btnBuscarSpace" style="width: 30px;margin-left: 5px;"><i class="fa fa-search" aria-hidden="true"></i></div>
				</div>
			</div>
			<div class="msgForFichas"></div>
			<div id="idContentTblFichas" style="display: none;">
				<div class="spaceInLine"></div>
				<div class="lblNew" style="width: 100%;">Seleccione ficha a partir</div>
				<div class="rowLine" style="display: block;">
					<div class="tblPrendasDefecto">
						<div class="tblHeader">
							<div class="itemHeader verticalHeader">Ficha</div>							
							<div class="itemHeader">Tipo Auditoria</div>
							<div class="itemHeader verticalHeader">Parte</div>
							<div class="itemHeader verticalHeader">Vez</div>
							<div class="itemHeader verticalHeader">Prendas</div>
						</div>
						<div class="tblBody">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="bodyContent" id="idContentDescription" style="display: none;padding-bottom: 0px;">
			<div class="lineWithDecoration" style="margin-top: 0px;margin-bottom: 10px;width: 100%;margin-left: 0px;"></div>
			<div class="rowLine bodyPrimary">				
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 70px;">Taller</div>
					<div class="spaceIpt" style="width: calc(100% - 70px);">
						<div class="valueRequest" id="idNombreTaller"></div>
					</div>
				</div>		
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 210px;">Ficha</div>
					<div class="spaceIpt" style="width: calc(100% - 210px);">
						<div class="valueRequest" id="idCodFichaText"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 210px;">Cantidad de prendas</div>
					<div class="spaceIpt" style="width: calc(100% - 210px);">
						<div class="valueRequest" id="idCantPrendas"></div>
					</div>
				</div>
				<div id="divPartir">
					<div class="lblNew" style="width: 100%;">Cantidad de prendas de ficha parcial</div>
					<div class="spaceIpt" style="margin-left: calc(100% - 102px);width: 102px;">
						<input type="number" id="idNewCantParte" class="iptClass" style="width: calc(100% - 12px);">
					</div>
					<div class="rowLine">
						<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 10px;margin-bottom: 10px;" onclick="partirFicha()">Partir Ficha</button>
					</div>
				</div>
			</div>
		</div>
		<div class="lineWithDecoration" style="margin-left:10px;margin-top: 0px;margin-bottom: 10px; width: calc(100% - 20px);"></div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="redirect('main.php')">Terminar</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript" src="js/index.js"></script>
	<script type="text/javascript" src="js/PartirFicha.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>