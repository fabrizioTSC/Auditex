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
<body>
	<?php contentMenu();?>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Registrar / Asignar AQL</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">			
			<div class="rowLine" style="display: flex;">
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('RegistrarAql.php')">
						<div class="icon"><i class="fa fa-plus-square-o" aria-hidden="true"></i></div>
						<div class="detailSpecialButton addPaddings">CONSULTAR AQL'S</div>
					</div>
				</div>
				<div class="itemMainContent">
					<div class="bodySpecialButton" onclick="redirect('AsignarAqlToFichaAuditoria.php')">
						<div class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">ASIGNAR AQL A FICHA AUDITORIA</div>
					</div>
				</div>
			</div>		
		</div>
		<div class="bodyContent" style="padding-top: 0;">			
			<div class="rowLine" style="display: flex;">
				<div class="itemMainContent" style="padding-top: 0;">
					<div class="bodySpecialButton" onclick="redirect('AsignarAqlToTipoAuditoria.php')">
						<div class="icon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></div>
						<!--<div class="detailSpecialButton addPaddings">ACTULIZAR ROL DE USUARIO</div>-->
						<div class="detailSpecialButton addPaddings">ASIGNAR AQL A TIPO AUDITORIA</div>
					</div>
				</div>
				<div class="itemMainContent" style="padding-top: 0;">
					<div class="bodySpecialButton" onclick="redirect('main.php')">
						<div class="icon"><i class="fa fa-arrow-left" aria-hidden="true"></i></div>
						<div class="detailSpecialButton">REGRESAR A MEN&Uacute; PRINCIPAL</div>
					</div>
				</div>
			</div>		
		</div>
	</div>
	<script type="text/javascript" src="js/index-v1.1.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>