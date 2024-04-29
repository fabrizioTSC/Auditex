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
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/consultaAuditoria.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
</head>
<body>
	<div class="panelCarga" style="display: none;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<?php contentMenu();?>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Asignar Aql a Ficha Auditoria</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">	
			<div class="rowLineFlex">
				<div style="margin-left: 10%;width: 80%;display: flex;">
					<div class="lblNew" style="width: 70px;padding-top: 5px;">Ficha</div>
					<div class="spaceIpt" style="width: calc(100% - 105px);">
						<input type="number" id="idCodFicha" class="iptClass" style="width: calc(100% - 12px);">
					</div>
					<div class="btnBuscarSpace" style="width: 30px;margin-left: 5px;"><i class="fa fa-search" aria-hidden="true"></i></div>
				</div>
			</div>
			<div class="msgForFichas"></div>
			<div id="idContentTblFichas" style="display: none;">
				<div class="spaceInLine"></div>
				<div class="lblNew" style="width: 100%;">Seleccion Auditoria a asignar</div>
				<div class="rowLine" style="display: block;">
					<div class="tblPrendasDefecto">
						<div class="tblHeader">
							<div class="itemHeader" style="width: 50%;">Taller</div>	
							<div class="itemHeader" style="width: 15%;">Parte</div>	
							<div class="itemHeader" style="width: 15%;">Vez</div>
							<div class="itemHeader" style="width: 20%;">Prendas</div>
						</div>
						<div class="tblBody">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="bodyContent" id="idContentForAql" style="display: none;padding-bottom: 0px;">
			<div class="rowLine bodyPrimary">
				<div class="lbl" style="margin-bottom:5px;font-size: 15px;">Seleccionar AQL</div>
				<select class="classCmbBox" id="idSelectForAql"></select>
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 5px;" onclick="ModifcarAqlToFicha()">Confirmar</button>
			</div>
		</div>
		<div class="lineWithDecoration" style="margin-bottom: 10px;"></div>
		<div class="rowLine">			
			<div class="btnPrimary" onclick="redirect('RegistrarAsignarAql.php')" style="margin-left: calc(50% - 80px);width: 140px;">Terminar</div>
		</div>		
	</div>
	<script type="text/javascript" src="js/index-v1.1.js"></script>
	<script type="text/javascript" src="js/AsignarAqlToTipoAuditoria.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>