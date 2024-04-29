<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="101";
	include("config/_validate_access.php");
	include("config/_contentMenu.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>AUDITEX - INSPECCION</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="css/demo-v5.css">
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
			<div class="headerTitle">Inspecci&oacute;n de fichas</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div id="space1">
				<div class="rowLine bodyPrimary">
					<div class="sameLine">
						<div class="lbl" style="width: 120px;">Ingrese taller:</div>
						<div class="spaceIpt" style="width: calc(100% - 120px);">
							<input type="text" id="idTallerName" class="classIpt">
						</div>
					</div>
					<div class="tblSelection">
						<div class="listaTalleres">
						</div>
					</div>
				</div>
			</div>
			<div id="space2" style="display: none;">
				<div class="rowLine">
					<div class="btnSpace">
						<div class="btnPrimary btnBackAction" onclick="backLineas()"><i class="fa fa-chevron-left" aria-hidden="true"></i> Regresar a lineas</div>
					</div>
					<div class="subtitle">Fichas a inspeccionar</div>
					<div class="spaceInLine"></div>					
					<div class="sameLine" style="margin-bottom: 5px;">
						<div class="lblNew" style="width: 70px;padding-top: 10px;">Ficha: </div>
						<input type="text" id="idcodficSearch" class="classIpt" style="width: calc(100% - 70px);font-size: 15px;">
					</div>
					<div class="tblContent tblMaxHeight" style=" overflow-y: scroll; max-height: calc(100vh - 190px);">
						<div class="tblHeader">
							<div class="itemHeader" style="width: calc(50% - 10px);">Ficha</div>							
							<div class="itemHeader" style="width: calc(50% - 10px);">Cantidad</div>
						</div>
						<div class="tblBody">
						</div>
					</div>
				</div>
			</div>
			<div id="space3" style="display: none;">
				<div class="btnSpace">
					<div class="btnPrimary btnBackAction" onclick="backFichas()"><i class="fa fa-chevron-left" aria-hidden="true"></i> Regresar a fichas</div>
				</div>
				<div class="sameLine" style="width: 100%;margin-left: 0px;">
					<div class="lbl" style="width: 100px;">Taller:</div>
					<div class="spaceIpt" style="width: calc(100% - 100px);">
						<div class="lbl" id="idDesTll"></div>
					</div>
				</div>
				<div class="sameLine" style="width: 100%;margin-left: 0px;margin-bottom: 5px;">
					<div class="lbl" style="width: 100px;">Cod. Fic.:</div>
					<div class="spaceIpt" style="width: calc(100% - 100px);">
						<div class="lbl" id="idCodFic"></div>
					</div>
				</div>
				<!--
				<div class="sameLine" style="margin-bottom: 10px;">
					<div class="lbl" style="width: 80px;">Turno:</div>
					<div class="spaceIpt" style="width: calc(100% - 80px);">
						<input type="number" id="idTurno" class="classIpt" value="1" disabled>
					</div>
				</div>
				-->
				<div class="btnPrimary btnNextPage" style="margin-left: auto;margin-right: auto;" onclick="irInspeccion()">Inspeccionar ficha</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var codusu="<?php echo $_SESSION['user']; ?>";
	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/IniciarInspeccion-v1.1.js"></script>
</body>
</html>