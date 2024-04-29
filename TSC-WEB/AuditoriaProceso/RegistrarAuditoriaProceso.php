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
	<title>AUDITEX - INSPECCION</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
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
			<div class="headerTitle">Auditoria En Proceso Costura</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="sameline txtSizeLbl">
				<div class="lblSimple" style="margin-bottom:5px;">Ficha:</div>
				<span id="idFicha">Ficha</span>
			</div>
			<div class="sameline txtSizeLbl">
				<div class="lblSimple" style="margin-bottom:5px;">Linea/Servicio:</div>
				<span id="idLinea" style="width:calc(100% - 150px);">Linea</span>
			</div>
			<div class="sameline txtSizeLbl">
				<div class="lblSimple" style="margin-bottom:5px;">Cliente:</div>
				<span id="idCliente" style="width:calc(100% - 150px);">Cliente</span>
			</div>
			<div class="sameline txtSizeLbl">
				<div class="lblSimple" style="margin-bottom:5px;">Color:</div>
				<span id="idColor">Color</span>
			</div>
			<div class="sameline txtSizeLbl">
				<div class="lblSimple" style="margin-bottom:5px;">Partida:</div>
				<span id="idpartida"></span>
			</div>
			<div class="sameline txtSizeLbl">
				<div class="lblSimple" style="margin-bottom:5px;">Aud. Final Corte:</div>
				<span id="idaudfincor"></span>
			</div>
			<div class="lineDecoration"></div>
			<div class="txtSizeLbl" id="contentOperacion">

				<div class="lblSimple" style="margin-bottom:5px; width: 100%;">Buscar operador:</div>
				<input type="text" id="idOperador" class="classIpt" style="margin-bottom: 5px;">
				<div class="tblOperador" style="margin-bottom: 10px;">
				</div>	

				<div class="lblSimple" style="margin-bottom:5px; width: 100%;">Buscar operación:</div>
				<input type="text" id="idOperacion" class="classIpt" style="margin-bottom: 5px;">
				<div class="tblOperacion" style="margin-bottom: 10px;">
				</div>

				
				<div class="lblSimple" style="margin-bottom:5px; width: 100%;">Cantidad Prendas:</div>
				<input type="number" id="txtcantprendas" class="classIpt" style="margin-bottom: 5px;width:100%" autocomplete="off" value="0">



				<!-- <div class="centercontent" style="width:150px; display: flex;">

					<div class="lblSimple" style="margin-bottom:5px; width: 150px;">Cantidad Prendas:</div>
					<input type="number" id="txtcantprendas" class="classIpt" style="margin-bottom: 5px;" autocomplete="off" value="0">
				</div> -->


				<div class="btnPrimary centercontent" onclick="pass_addOperacion()">Agregar operaci&oacute;n</div>
			</div>

			<div class="txtSizeLbl" id="contentDefecto" style="display: none;">
				<div class="btnSpace">
					<div class="btnPrimary btnBackAction" onclick="back_addOperacion()" style="width: 190px;">
						<i class="fa fa-chevron-left" aria-hidden="true"></i> Agregar nueva operaci&oacute;n
					</div>
				</div>
				<div class="sameline txtSizeLbl">
					<div class="lblSimple" style="margin-bottom:5px;">Operador:</div>
					<span id="idOperadorTxt">Color</span>
				</div>
				<div class="sameline txtSizeLbl">
					<div class="lblSimple" style="margin-bottom:5px;">Operaci&oacute;n:</div>
					<span id="idOperacionTxt">Color</span>
				</div>

				<div class="lblSimple" style="margin-bottom:5px; width: 100%;">Buscar defecto:</div>
				<input type="text" id="idDefecto" class="classIpt" style="margin-bottom: 5px;">
				<div class="tblDefectos" style="margin-bottom: 10px;">
				</div>

				<div class="centercontent" style="width:150px; display: flex;">
					<div class="lblSimple" style="margin-bottom:5px; width: 80px;padding-top: 10px;">Cantidad:</div>					
					<input type="text" id="idCanDef" class="classIpt" style="margin-bottom: 5px;width: calc(100% - 82px);" value="0">		
				</div>

				<div  style="width:100%; display: flex;">
					<div class="lblSimple" style="margin-bottom:5px; width: 80px;padding-top: 10px;">Observación:</div>					
					<input type="text" id="txtobservacion" class="classIpt" style="margin-bottom: 5px;width: 100%;" >		
				</div>


				<div class="btnPrimary centercontent" onclick="pass_addDefecto()">Agregar defecto</div>
				<div class="lineDecoration"></div>
				<div class="tblDefectosRegistrados" style="display: none;">
					<div class="lblSimple" style="margin-bottom:5px; width: 100%;">Defectos registrados</div>
					<div class="tblResumenAuditoria">
						<div class="tblHeader">
							<div class="itemHeader" style="width: 50%;">Defecto</div>							
							<div class="itemHeader" style="width: 25%;">Cantidad</div>				
							<div class="itemHeader" style="width: 25%;">Observación</div>				
						</div>
						<div class="tblBodyResumen">
						</div>
					</div>
					<div class="lineDecoration"></div>
				</div>
				<div class="btnPrimary centercontent" onclick="end_AuditoriaProceso()">Terminar auditoria</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var codusu="<?php echo $_SESSION['user']; ?>";
		var codusu_num="<?php echo $_SESSION['codusu']; ?>";
		var codfic="<?php echo $_GET['codfic']; ?>";
		var turno="<?php echo $_GET['turno']; ?>";
		var codtll="<?php echo $_GET['codtll']; ?>";
		var secuen="<?php if(isset($_GET['secuen'])){echo $_GET['secuen'];}else{ echo "0";} ?>";
	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/AuditoriaProceso-v1.1.js"></script>
</body>
</html>