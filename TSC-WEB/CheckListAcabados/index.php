<?php
	session_start();
	if (isset($_SESSION['codusu'])){
		header("Location: main.php");
	}else{
		header("Location: http://textilweb.tsc.com.pe:81/");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>AUDITEX</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body onload="cargarFondo()">
	<div class="panelCarga">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="allBody">
		<div class="mainContent">
			<div class="titleLogin">AUDITEX</div>
		</div>
		<form method="POST" action="config/login.php">
			<div class="iptsSpace">
				<input class="iptLogin" type="text" name="username" placeholder="Usuario">
				<input class="iptLogin" type="password" name="password" placeholder="Password">
			</div>
			<div class="spaceInLine"></div>
			<?php
				if (isset($_SESSION['error'])) {
					if ($_SESSION['error']==0) {
			?>
			<div class="lineError">No existe el usuario</div>
			<?php
						session_destroy();
					}
					if ($_SESSION['error']==1) {
			?>
			<div class="lineError">Password err&oacute;neo</div>
			<?php
						session_destroy();
					}
				}
			?>
			<div class="spaceInLine"></div>
			<div class="spaceInLine"></div>
			<div class="iptsSpace">
				<button type="submit" class="btnPrimaryLogin" style="font-family:sans-serif;">Ingresar</button>	
			</div>
		</form>
	</div>
	<script type="text/javascript" src="js/login.js"></script>
</body>
</html>