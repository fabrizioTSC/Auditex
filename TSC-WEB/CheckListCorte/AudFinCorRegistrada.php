<?php
	session_start();
	if (!isset($_SESSION['user-afc'])) {
		header('Location: index.php');
	}
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
<body onLoad="cargarAuditoriaRegistrada('<?php echo $_GET['codfic']; ?>',
	'<?php echo $_GET['tipoAuditoria']; ?>',
	'<?php echo $_GET['cantidadDeMuestra']; ?>',
	'<?php echo $_GET['numvez']; ?>',
	'<?php echo $_GET['parte']; ?>',
	'<?php echo $_GET['codtad']; ?>',
	'<?php echo $_GET['codaql']; ?>')">
	<div class="panelCarga" style="display: block;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<?php contentMenu();?>
	<div class="modalContainer">
		<div class="modalBackground">
			<div class="modalTitle">¿Confimar los datos?</div>
			<div class="lineDecoration"></div>
			<div class="modalBody"></div>
			<div class="lineDecoration"></div>
			<div class="modalButtons">
				<button class="btnModal" onclick="cerrarModal()">Cancelar</button>
				<div class="spaceVertical"></div>
				<button class="btnModal" onclick="confirmarAuditoriaPrenda()">Confimar</button>
			</div>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Auditoria Registrada</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">			
			<div class="rowLine bodyPrimary">				
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 70px;">Taller</div>
					<div class="spaceIpt" style="width: calc(100% - 70px);">
						<div class="valueRequest" id="idNombreTaller"></div>
					</div>
				</div>		
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 220px;">Ficha</div>
					<div class="spaceIpt" style="width: calc(100% - 220px);">
						<div class="valueRequest" id="idCodFicha"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 220px;">Cantidad de prendas</div>
					<div class="spaceIpt" style="width: calc(100% - 220px);">
						<div class="valueRequest" id="idCantPrendas"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 220px;">Muestreo</div>
					<div class="spaceIpt" style="width: calc(100% - 220px);">
						<div class="valueRequest" id="idMuestreo"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 220px;"></div>
					<div class="spaceIpt" style="width: calc(100% - 220px);">
						<div class="valueRequest" id="idNumPrendasAuditar"></div>
					</div>
				</div>
			</div>
			<div class="spaceInLine"></div>
			<div class="lblNew" style="width: 220px;">Prendas con Defecto</div>
			<div class="rowLine" style="display: block;">
				<div class="tblPrendasDefecto">
					<div class="tblHeader">
						<div class="itemHeader" style="width: 80%;">Defecto</div>
						<div class="itemHeader" style="width: 20%;">Cantidad</div>						
					</div>
					<div class="tblBody">
					</div>
				</div>
			</div>
			<div class="lblNew" style="width: 100%; color: red;text-align: center;padding-top: 5px;">
			<?php
				if ($_GET['resultado']=="R") {
					echo "Auditoria rechazada!";
				}else{
					echo "Auditoria aprobada!";
				}
			?>
			</div>
		</div>
		<div class="lineDecoration"></div>
		<div class="sameLine">
					<div class="btnPrimary btnSpecialStyle" onclick="terminarAuditoriaRegistrada()">Terminar</div>
		</div>		
	</div>
	<script type="text/javascript" src="js/index-v1.1.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>