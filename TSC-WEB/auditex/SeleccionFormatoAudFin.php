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
	<script type="text/javascript" src="js/jquery/jquery-1.12.1.js"></script>
	<script type="text/javascript" src="js/jquery/jquery-ui-1.12.1.js"></script>
	<link rel="stylesheet" href="css/jquery/jquery-ui-1.12.1.css">
	<style type="text/css">
		.filter_option{
			width: calc(100% / 3);
			border-bottom: 1px #999 solid;
			padding: 10px;
			text-align: center;
			font-size: 15px;
		}
		.filter_active{
			border: 1px #999 solid;
			border-bottom: 0px #999 solid;
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
			<div class="headerTitle">Filtro de Detalle Aud. Fin.</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div style="display: flex;margin-bottom: 10px;">
				<div onclick="show_option(1)" id="option1" class="filter_option filter_active">
					TODOS
				</div>
				<div onclick="show_option(2)" id="option2" class="filter_option">
					PEDIDO
				</div>
				<div onclick="show_option(3)" id="option3" class="filter_option">
					FICHA
				</div>
			</div>
			<div class="content_filtro" id="content-option1">
				<div class="sameLine">
					<div class="lblNew" style="width: 80px;padding-top: 5px;">Sede</div>
					<input type="text" id="nombreSede" class="iptClass" style="width: calc(100% - 80px);font-size: 15px;">
				</div>
				<div class="tblSelection">
					<div class="listaTalleres" id="spaceSedes">
						<div class="taller"></div>
					</div>
				</div>
				<div style="width: 100%;height: 20px;"></div>
				<div class="sameLine">
					<div class="lblNew" style="width: 120px;padding-top: 5px;">Tipo servicio</div>
					<input type="text" id="nombreTipoSer" class="iptClass" style="width: calc(100% - 120px);font-size: 15px;">
				</div>
				<div class="tblSelection">
					<div class="listaTalleres" id="spaceTipoSer">
						<div class="taller"></div>
					</div>
				</div>
				<div style="width: 100%;height: 20px;"></div>
				<div class="sameLine">
					<div class="lblNew" style="width: 80px;padding-top: 5px;">Taller</div>
					<input type="text" id="nombreTaller" class="iptClass" style="width: calc(100% - 80px);font-size: 15px;">
				</div>
				<div class="tblSelection">
					<div class="listaTalleres" id="spaceTalleres">
						<div class="classTaller"></div>
					</div>
				</div>
				<div class="sameLine" style="margin-top: 5px;">
					<div class="lblNew" style="width: 120px;padding-top: 5px;">Fecha inicio</div>
					<div style="width: calc(100% - 120px);display: flex;">
						<input type="text" id="rango1" class="special-input" data-ctrl="ipt3"/>
					</div>
				</div>			
				<div class="sameLine" style="margin-top: 5px;">
					<div class="lblNew" style="width: 120px;padding-top: 5px;">Fecha fin</div>
					<div style="width: calc(100% - 120px);display: flex;">
						<input type="text" id="rango2" class="special-input" data-ctrl="ipt3">
					</div>
				</div>
			</div>
			<div class="content_filtro" id="content-option2" style="display: none;">
				<div class="sameLine" style="margin-bottom: 5px;">
					<div class="lblNew" style="width: 80px;padding-top: 5px;">Pedido</div>
					<input type="number" id="idPedido" class="iptClass" style="width: calc(100% - 80px);font-size: 15px;">
				</div>
				<div class="sameLine" style="margin-top: 1px;">
					<input type="checkbox" id="fechas2" style="margin-bottom: 0px;">
					<div class="lblNew" style="width: 120px;padding-top: 1px;">Rango</div>					
				</div>
				<div class="sameLine" style="margin-top: 5px;">
					<div class="lblNew" style="width: 120px;padding-top: 5px;">Fecha inicio</div>
					<div style="width: calc(100% - 120px);display: flex;">
						<input type="text" id="dosrango1" class="special-input" data-ctrl="ipt3"/>
					</div>
				</div>			
				<div class="sameLine" style="margin-top: 5px;">
					<div class="lblNew" style="width: 120px;padding-top: 5px;">Fecha fin</div>
					<div style="width: calc(100% - 120px);display: flex;">
						<input type="text" id="dosrango2" class="special-input" data-ctrl="ipt3">
					</div>
				</div>
			</div>
			<div class="content_filtro" id="content-option3" style="display: none;">
				<div class="sameLine" style="margin-bottom: 5px;">
					<div class="lblNew" style="width: 100px;padding-top: 5px;">Cod. Ficha</div>
					<input type="number" id="idCodFic" class="iptClass" style="width: calc(100% - 100px);font-size: 15px;">
				</div>
				<div class="sameLine" style="margin-top: 1px;">
					<input type="checkbox" id="fechas3" style="margin-bottom: 0px;">
					<div class="lblNew" style="width: 120px;padding-top: 1px;">Rango</div>					
				</div>
				<div class="sameLine" style="margin-top: 5px;">
					<div class="lblNew" style="width: 120px;padding-top: 5px;">Fecha inicio</div>
					<div style="width: calc(100% - 120px);display: flex;">
						<input type="text" id="tresrango1" class="special-input" data-ctrl="ipt3"/>
					</div>
				</div>			
				<div class="sameLine" style="margin-top: 5px;">
					<div class="lblNew" style="width: 120px;padding-top: 5px;">Fecha fin</div>
					<div style="width: calc(100% - 120px);display: flex;">
						<input type="text" id="tresrango2" class="special-input" data-ctrl="ipt3">
					</div>
				</div>
			</div>
		</div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="mostrarFormato()">Mostrar resultados</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript" src="js/SeleccionFormatoAudFin-1.1.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>