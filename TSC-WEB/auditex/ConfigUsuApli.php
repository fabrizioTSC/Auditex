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
	<style type="text/css">
		table{
			width: 100%;
		}
		table,th,td{
			border-collapse: collapse;
			border:1px #000 solid;
			background-color: #fff;
		}
		th,td{
			padding: 5px;
			background-color: #fff;
			font-size: 13px;
		}
		th{
			background-color: #980f0f;
			color: #fff;
		}/*
		th:nth-child(2),td:nth-child(2){
			width: 40px;
			text-align: center;
		}*/
		td input[type="checkbox"]{
			margin: 0px;
		}
		td .classCmbBox{
			margin: 0px;
			font-size: 13px;
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
			<div class="headerTitle">Configurar Usuario / Aplicativo</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="sameLine">
				<div class="lblNew" style="width: 80px;padding-top: 5px;">Usuario</div>
				<input type="text" id="idusuario" class="iptClass" style="width: calc(100% - 80px);font-size: 15px;">
			</div>
			<div class="tblSelection">
				<div class="listaTalleres" id="listausuarios">
					<div class="taller"></div>
				</div>
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;" onclick="mostrar_roles()">Ver roles</button>
			<div id="idresult" style="display: none;margin-top: 10px;">
				<div class="lineDecoration"></div>
				<table>
					<tbody id="tblbody">
					</tbody>
				</table>
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;" onclick="save_roles()">Guardar</button>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/ConfigUsuApli-v1.0.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>