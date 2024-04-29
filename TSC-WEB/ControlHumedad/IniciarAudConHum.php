<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="16";
	//include("config/_validate_access.php");
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
	<div class="panelCarga" style="display: none;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<?php contentMenu();?>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Iniciar Auditoria de Control de Humedad</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="rowLine bodyPrimary">
				<div class="sameLine" style="margin-bottom: 5px;">
					<div class="lbl" style="width: 80px;">Ficha:</div>
					<div class="spaceIpt" style="width: calc(100% - 110px);">
						<input type="number" id="idcodfic" class="classIpt" style="width: calc(100% - 12px);">
					</div>
					<button class="btnBuscarSpace" style="width: 30px;margin-left: 5px;border-style: none;font-size: 22px;" onclick="search_ficha()"><i class="fa fa-search" aria-hidden="true"></i></button>
				</div>
				<div id="resultcontent" style="display: none;">
					<div class="rowLine">
						<div class="tblHeader" style="width: calc(100% - 10px);">
							<div class="itemHeader">Ficha</div>							
							<div class="itemHeader">Tipo Auditoria</div>
							<div class="itemHeader">Parte</div>
							<div class="itemHeader">Vez</div>
							<div class="itemHeader">Prendas</div>
						</div>
						<div class="tblContent tblMaxHeight">
							<div class="tblBody">
							</div>
						</div>
					</div>
					<div class="spaceInLine"></div>
					<div id="fichaSelection">
						<div class="subtitle">Seleccione una ficha</div>
						<div class="spaceInLine"></div>
						<div class="textCenter" id="fichaSelected"></div>
					</div>
					<div class="spaceInLine"></div>
					<!--
					<div id="muestraSelection">
						<div class="subtitle">Seleccionar tipo de muestra</div>
						<div class="spaceInLine"></div>
						<div class="detalleMuestras">
							<div class="spaceTipoMuestra">
								<div class="inputCheckSpace" data-target="idCheckAql">
									<input type="checkbox" class="iptCheckBox" id="idCheckAql">
									<div class="descCheack">Aql:&nbsp;<div id=aqlValue>15%</div></div>
								</div>
							</div>
						</div>
						-->
						<div class="iptForDiscrecional">
							<div class="sameLine">
								<div class="subtitle formAlternative">Cantidad de prendas a auditar:</div>
								<input type="number" id="idNumberPrendas">
							</div>
						</div>
					</div>
					<div class="spaceInLine"></div>
					<div class="finalBtn">
						<div class="btnPrimary btnNextPage" onclick="comenzarAuditoria()">Iniciar</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var codusu="<?php echo $_SESSION['user']; ?>";
	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/IniciarAudConHum-v1.0.js"></script>
</body>
</html>