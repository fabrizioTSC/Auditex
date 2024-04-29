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
</head>
<body onLoad="getUsuarios()">
	<?php contentMenu();?>
	<div class="panelCarga" style="display: block;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Actualizar Rol de Usuarios</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="sameLine">
				<div class="lbl" style="width: 125px;">Ingresar Usuario</div>
				<input type="text" id="nombreusuario" class="classIpt" style="width: calc(100% - 130px);">
			</div>
			<div class="tblSelection">
				<div class="listaTalleres">
					<div class="classTaller" data-idtaller="" data-nomtaller=""></div>
				</div>
			</div>
			<div style="width: 100%;height: 10px;"></div>		
			<div class="rowLine" style="display: flex;">				
				<div class="lbl" style="width: 120px;">Rol de Usuario</div>
				<select id="rolusuario" class="classCmbBox" style="width: calc(100% - 120px);">
					<option value="0">(NINGUNO)</option>
					<option value="1">ADMINISTRADOR</option>
					<option value="2">EJECUTIVO</option>
					<option value="3">AUDITOR</option>
					<option value="5">INSPECTOR</option>
				</select>
			</div>
			<div class="rowLine">
				<button class="btnPrimary btnPrimaryDisabled" id="btnUpdate" style="margin-left: calc(50% - 80px); margin-top: 10px;" onclick="updateRolUsuario()" disabled>Registrar</button>
			</div>
		</div>
		<div class="lineWithDecoration"></div>
			<div class="rowLine">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 10px;" onclick="redirect('main.php')">Salir</button>
			</div>	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/ActualizarRolUsuario.js"></script>
</body>
</html>