<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="3";
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
<body onLoad="getFichas()">
	<div class="panelCarga" style="display: block;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<?php contentMenu();?>
	<div class="mainContent">
		<div class="headerContent">
			<!--
			<div class="backSpace">
				<div class="iconSpace"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
			</div>
			-->
			<div class="headerTitle">Iniciar Auditor&iacute;a Final Corte</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<!--
			<div class="rowLine bodyPrimary">
				<div class="sameLine">
					<div class="lbl" style="width: 120px;">Ingrese taller:</div>
					<div class="spaceIpt" style="width: calc(100% - 120px);">
						<input type="text" id="idTallerName" class="classIpt">
					</div>
				</div>
				<div class="tblSelection">
					<div class="listaTalleres">
						<div class="classTaller" data-idtaller="" data-nomtaller=""></div>
					</div>
				</div>
			</div>
			<div class="rowLine bodySecondary">-->
			<div class="rowLine bodyPrimary">
				<div class="sameLine" style="margin-bottom: 5px;">
					<div class="lbl" style="width: 80px;">Ficha:</div>
					<div class="spaceIpt" style="width: calc(100% - 80px);">
						<input type="number" id="idTallerName" class="classIpt" style="width: 100%">
					</div>
				</div>
				<div class="rowLine">
					<!--
					<div class="btnSpace">
						<div class="btnPrimary btnBackAction"><i class="fa fa-chevron-left" aria-hidden="true"></i> Regresar a talleres</div>
					</div>
					<div class="subtitle">Auditorias pendientes para:</div>
					<div id="nameTaller"></div>
					<div class="spaceInLine"></div>
					-->
						<div class="tblHeader" style="width: calc(100% - 10px);">
							<div class="itemHeader verticalHeader">Ficha</div>							
							<div class="itemHeader">Usuario</div>
							<div class="itemHeader verticalHeader">Parte</div>
							<div class="itemHeader verticalHeader">Vez</div>
							<div class="itemHeader verticalHeader">Prendas</div>
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
						<!--
						<div class="spaceTipoMuestra">
							<div class="inputCheckSpace" data-target="idCheckDiscrecional">
								<input type="checkbox" class="iptCheckBox" id="idCheckDiscrecional">
								<div class="descCheack">Discrecional</div></div>
							</div>
						</div>
						-->
					</div>
					<div class="iptForDiscrecional">
						<div class="sameLine">
							<div class="subtitle formAlternative">Cantidad de prendas a auditar:</div>
							<input type="number" id="idNumberPrendas">
						</div>
					</div>
				</div>
				<div class="spaceInLine"></div>
				<div class="finalBtn">
					<div class="btnPrimary btnNextPage" onclick="comenzarAuditoria()">Iniciar auditoria</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var usuario_afc="<?php echo $_SESSION['user']; ?>";
	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<!--
	<script type="text/javascript" src="js/index-v1.1.js"></script>-->
	<script type="text/javascript" src="js/IniciarAudFinCor-v1.1.js"></script>
</body>
</html>