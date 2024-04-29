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
	<link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
</head>
<body onload="sendCodUser('<?php echo $_SESSION['codusu'] ?>')">
	<?php contentMenu();?>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Cambiar contrase&ntilde;a</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">			
			<div class="rowLine">
				<div class="lbl" style="padding-bottom: 5px;">Ingrese nueva contraseña</div>
				<input type="password" id="pass1" class="iptClass" style="margin-bottom: 10px;">
				<div class="lbl" style="padding-bottom: 5px;">Confirmar contraseña</div>
				<input type="password" id="pass2" class="iptClass" style="margin-bottom: 10px;">
				<button class="btnPrimary" onclick="confirmarPassword()" style="margin-left: calc(50% - 100px);width:200px;font-size: 15px;">Confimar contraseña</button>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/cambiarPassword.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>