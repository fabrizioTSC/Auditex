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
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<style type="text/css">
		.itemBody{
			font-size: 12px;
		}
		input[type="checkbox"]{
			margin-bottom: 0px;
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
	<div class="body-modal" id="modal-1" style="display: none;">
		<div class="content-modal">
			<div class="lbl-modal">Buscar usuario</div>
			<div class="line-decoration"></div>			
			<input type="text" id="idUsuario" class="classIpt" style="width: calc(100% - 14px);margin-bottom: 5px;">
			<div class="lista" id="lista-usuarios">
			</div>
			<button class="btnPrimary" style="width: 100%; margin-bottom: 5px;" onclick="add_usuario()">Agregar</button>
			<button class="btnPrimary" style="width: 100%;" onclick="hide_modal('modal-1')">Cancelar</button>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Configuraci&oacute;n de mail's</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div style="display: flex;">
				<div class="lbl" style="width: 200px;">Indicador de resultados de</div>
				<select id="idTipAud" class="classCmbBox" style="width: auto;margin-bottom: 5px;">
				</select>
			</div>
			<div style="display: flex;margin-bottom: 5px;">
				<div class="lbl" style="font-size: 12px;font-weight: normal;color: #138cc5;" onclick="show_modal('modal-1')"><i class="fa fa-plus" aria-hidden="true"></i> Agregar usuario</div>
			</div>
			<div style="margin-bottom: 10px;overflow: scroll;">
				<div class="tblHeader" id="header-to-alter">
					<div class="itemHeader" style="width: 190px;text-align: center;">Apellidos y Nombres</div>
					<div class="itemHeader" style="width: 150px;text-align: center;">Email</div>
					<div id="allHeaders" style="display: flex;">
						
					</div>	
				</div>
				<div class="tblBody" id="data-users">
				</div>
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;margin-bottom: 0px;" onclick="saveParameters()">Guardar cambios</button>
			<div class="lineDecoration"></div>
		<div class="rowLine">
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="redirect('main.php')">Volver</button>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="enviar_mail()">Enviar mail</button>
		</div>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/MailsAutomaticos-v1.1.js"></script>
</body>
</html>