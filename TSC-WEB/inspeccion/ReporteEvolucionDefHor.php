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
	<title>AUDITEX - INSPECCION</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="css/RegistroCuotasHoras-v1.2.css">
	<link rel="stylesheet" type="text/css" href="css/demo-v5.css">
	<!--
	<script type="text/javascript" src="js/jquery/jquery-1.12.1.js"></script>
	<script type="text/javascript" src="js/jquery/jquery-ui-1.12.1.js"></script>
	<link rel="stylesheet" href="css/jquery/jquery-ui-1.12.1.css">
	-->
	<style type="text/css">
		.tblData2{
			width: 100%;
		}
		.body-tbl{
			overflow: hidden;
		}
		.tbl-in3{
		}
		.tbl-in4{
		}
		.iptClass{
			font-family: sans-serif;
		}
		.total-block{
			font-weight: bold;
			font-size: 14px;
			border:1px solid #666;
			border-width: 1px 0px 1px 0px;
		}
		.line-body{
			display: flex;
			border-top: 1px solid #999;
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
	<div class="body-modaledit" id="modalEdit" style="display: none;font-family: sans-serif;">
		<div class="modaledit">
			<div class="lbl" style="padding: 0px;margin-bottom: 5px; text-align: center;">Operaciones</div>
			<div class="lineDecoration"></div>
			<div class="lbl" style="padding: 0px;margin-bottom:5px;">Fecha: <span id="idFechaOpe"></span></div>
			<div class="lbl" style="padding: 0px;margin-bottom:5px;">Defecto: <span id="idDefectoOpe"></span></div>
			<div class="lbl" style="padding: 0px;margin-bottom:5px;" id="content-linea">Linea: <span id="idLineaOpe"></span></div>
			<div class="lbl" style="padding: 0px;margin-bottom:5px;" id="content-hora">Hora: <span id="idHoraOpe"></span></div>
			<div class="tbl-ope">
				<div class="tbl-header-ope" style="width: 100%;">
					<div class="head-tbl" style="width:70%;">Operaci&oacute;n</div>
					<div class="head-tbl" style="width:30%;">Cantidad</div>
				</div>
				<div class="tbl-body-ope" id="data-body-ope" style="width: 100%;">
					<div class="line-body">
						<div class="body-tbl" style="width:70%;">Operaci&oacute;n</div>
						<div class="body-tbl" style="width:30%;">Cantidad</div>
					</div>
				</div>
			</div>
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 5px;" onclick="closeModal('modalEdit')">Cerrar</button>
			</div>	
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Reporte Evoluci&oacute;n de Defectos por Hora</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div style="display: flex;">
				<div class="lbl" style="width: 60px;padding-top: 6px;">Fecha:</div>
				<div class="spaceIpt" style="width: 190px;">
					<input type="date" id="idFecha" class="iptClass" style="width: calc(180px);font-size: 15px;">
				</div>
				<button class="btnPrimary" style="margin-left: 5px;width: 50px;height: 33px;padding: 5px;" onclick="update_reporte()"><i class="fa fa-search" aria-hidden="true"></i></button>
			</div>
			<div id="tbl-generate" style="display: block;">
				<div class="lineDecoration"></div>
				<div id="maintbl" style="overflow-x: scroll;height: calc(100vh - 161px);position: relative;margin-top: 10px;">
					<div class="tblData2" style="position: relative;">
						<div class="tbl-header" id="data-header" style="position: relative;z-index: 11;">
							<div class="head-tbl" style="width:200px;">DEFECTOS</div>
							<div class="head-tbl" style="width:90px;">LINEA</div>
							<div>
								<div class="head-tbl" id="header-hora">HORA</div>
								<div id="header-horas" style="display: flex;">
									<div class="head-tbl" style="width:50px;">6</div>
								</div>
							</div>
						</div>
						<div class="tbl-body" id="data-body" style="position: relative;">
							<div style="display: flex;">
								<div id="space-def">
									<div class="body-tbl" style="width:200px;">DEFECTO 1</div>
								</div>
								<div id="space-lindef">
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--
				<div style="text-align: center;margin-top: 5px;">
					<button class="btnPrimary" style="margin-top: 0px;" onclick="export_excel()">Descargar</button>
				</div>-->
			</div>
			<div id="tbl-none" style="display: none;">
				<div style="color: #b31717;margin-top: 5px;">No hay resultados</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/ReporteDefHor-v1.0.js"></script>
</body>
</html>