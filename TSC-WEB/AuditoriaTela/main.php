<?php

	header('Location: ../../dashboard/index.php');
	/*
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="1";
	include("config/_validate_access.php");
	include("config/_contentMenu.php"); */
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
<body>
	<?php contentMenu();?>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Panel de Inicio</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<?php
			if ($_SESSION['perfil']=="4") {
				getAnaConContent();
			}else{
				if ($_SESSION['perfil']=="2") {
					getEjecutivoContent();
				}else{
					getAuditorContent();
				}
			}
		?>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>