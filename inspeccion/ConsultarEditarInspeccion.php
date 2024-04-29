<?php
	session_start();
	if (!isset($_SESSION['user-ins'])) {
		header('Location: index.php');
	}
	include("config/_contentMenu.php");
	include("config/connection.php");
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
	<link rel="stylesheet" type="text/css" href="css/responsive-demo-2.css">
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
		<div class="body-modaledit" id="modalEditDefOpe" style="display: none;">
			<div class="modaledit">
				<div class="lbl" style="padding: 0px;margin-bottom: 5px; text-align: center;">Edici&oacute;n de detalle de Inspecci&oacute;n</div>
				<div class="lineDecoration"></div>
				<div class="lbl" style="padding: 0px;margin-bottom:10px;">N° Inspecci&oacute;n: <span id="idNumInsEditDefOpe"></span></div>
				<div class="lbl" style="padding: 0px;margin-bottom:5px;">Operaci&oacute;n: <span id="nomoperacion"></span></div>
				<div class="lbl" style="padding: 0px;margin-bottom:5px;">Defecto: <span id="nomdefecto"></span></div>
				<div class="lbl" style="padding: 0px;margin-bottom:5px;">Cant. detalle:</div>
				<input type="text" id="idnewcandet" class="classIpt" style="width: 150px;margin-left: calc(50% - 82px);text-align: center;">
				<div class="rowLine bodyPrimary">
					<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 5px;" onclick="saveEditDetDefOpe()">Guardar</button>
				</div>
				<div class="rowLine bodyPrimary">
					<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 5px;" onclick="closeModalEditDefOpe()">Cancelar</button>
				</div>	
			</div>
		</div>
		<div class="body-modaledit" id="modalEdit" style="display: none;">
			<div class="modaledit">
				<div class="lbl" style="padding: 0px;margin-bottom: 5px; text-align: center;">Edici&oacute;n de Inspecci&oacute;n</div>
				<div class="lineDecoration"></div>
				<div class="lbl" style="padding: 0px;margin-bottom:5px;">N° Inspecci&oacute;n: <span id="idNumInsEdit"></span></div>
				<div class="lbl" style="padding: 0px;margin-bottom:5px;">Cant. Prendas defectuosas:</div>
				<input type="text" id="idnewcanpredef" class="classIpt" style="width: 150px;margin-left: calc(50% - 82px);text-align: center;">
				<div class="rowLine bodyPrimary">
					<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 5px;" onclick="saveEditInspect()">Guardar</button>
				</div>
				<div class="rowLine bodyPrimary">
					<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 5px;" onclick="closeModalEdit()">Cancelar</button>
				</div>	
			</div>
		</div>
		<div class="headerContent">
			<div class="headerTitle">Consulta de inspecci&oacute;n</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent" style="padding-bottom: 5px;">
			<div class="rowSameLine" style="margin-top: 5px;">
				<div class="lbl" style="width: 60px;">Ficha:</div>
				<input type="text" id="iccodfic" class="classIpt" style="width: 150px;margin-right: 10px;">
				<button class="btnclassSearch" onclick="searchFicha()"><i class="fa fa-search" aria-hidden="true"></i></button>
			</div>			
		</div>
		<div id="space1" style="display: none;">
			<div class="lineWithDecoration"></div>
			<div class="bodyContent">
				<div class="lbl" style="padding: 0px;margin-bottom: 10px;">Seleccione ficha a consultar:</div>
				<div class="tableAdapter" style="overflow-x: hidden;">
					<div class="tblPrendasDefecto" style="overflow-x: scroll;width: auto;">
						<div class="tblHeader" style="width: auto;">
							<div class="itemHeader2" style="width: 50px">N° Ins.</div>						
							<div class="itemHeader2" style="width: calc(100px);">Linea</div>
							<div class="itemHeader2" style="width: calc(90px);">Usuario</div>
							<div class="itemHeader2" style="width: calc(70px);">Fecha</div>
							<div class="itemHeader2" style="width: 60px;">Cant. Ficha</div>
							<div class="itemHeader2" style="width: 60px;">Pren. Ins.</div>
							<div class="itemHeader2" style="width: 60px;">Pren. Def.</div>
							<div class="itemHeader2" style="width: 60px;">Cant. Def.</div>
							<div class="itemHeader2" style="width: 60px;">Acci&oacute;n</div>
						</div>
						<div class="tblBody" id="idListaFichas" style="width: 700px;">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="space2" style="display: none;">
			<div class="lineWithDecoration"></div>
			<div class="btnSpace" style="padding:0px;margin-left: 10px;">
				<div class="btnPrimary btnBackAction" onclick="backFichas()"><i class="fa fa-chevron-left" aria-hidden="true"></i> Regresar a Fichas</div>
			</div>
			<div class="bodyContent">
				<div class="sameline">
					<div style="width: 190px;">N° Ins.:</div>
					<span id="idNumIns">0</span>
				</div>
				<div class="sameline">
					<div style="width: 190px;">Prendas inspeccionadas:</div>
					<span id="idCan">0</span>
				</div>
				<div class="sameline" style="margin-bottom: 10px;">
					<div style="width: 190px;">Prendas defectuosas:</div>
					<span id="idCanDef">0</span>
				</div>
				<div class="tblPrendasDefecto">
					<div class="tblHeader">
						<div class="itemHeader2" style="width: calc(50% - 85px);">Operaci&oacute;n</div>						
						<div class="itemHeader2" style="width: calc(50% - 85px);">Defecto</div>
						<div class="itemHeader2" style="width: 70px;">Cantidad</div>
						<div class="itemHeader2" style="width: 60px;">Acci&oacute;n</div>
					</div>
					<div class="tblBody" id="idListaIns">
						<div class="tblLine">
						</div>
					</div>
				</div>
			</div>

			<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;" id="spaceBtnEdit">
				<div class="rowLine bodyPrimary">
					<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="editInspect('EditarInspeccionFicha.php')">Editar</button>
				</div>		
			</div>
		</div>
		<div class="lineWithDecoration"></div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 5px;" onclick="redirect('main.php')">Terminar</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript">
		var codusu="<?php echo $_SESSION['user-ins']; ?>";
	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/ConsultarInspeccion-v1.2.js"></script>
</body>
</html>