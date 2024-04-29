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
	<link rel="stylesheet" type="text/css" href="css/consultaAuditoria.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
</head>
<body>
	<div class="opcionesDefecto">
		<div style="display: flex;">
			<div class="opcion btnEditar" onclick="abrirMenuDefecto()">Editar</div>
			<div class="spaceVertical"></div>
			<div class="opcion btnEliminar" onclick="gestionDefecto('delete')">Eliminar</div>
			<div class="spaceVertical"></div>
			<div class="opcion btnClose" onclick="closeOpcionesDefecto()"><i class="fa fa-times" aria-hidden="true"></i></div>
		</div>
	</div>
	<div class="editarDefectos">
		<div class="contentEditar">
			<div class="titleContent">Editar defecto</div>
			<div class="lineDecoration"></div>
			<div class="bodyEdicion">
				<div class="lbl" style="margin-bottom: 5px;">Operador</div>
				<select id="selectForOperadores" class="classCmbBox"></select>
				<div class="lbl" style="margin-bottom: 5px;">Operaci&oacute;n</div>
				<select id="selectForOperaciones" class="classCmbBox"></select>
				<div class="lbl" style="margin-bottom: 5px;">Defecto</div>
				<select id="selectForDefectos" class="classCmbBox"></select>
				<div class="lbl" style="margin-bottom: 5px;">Cantidad de prendas</div>
				<input type="number" id="idCantDefectos" class="iptNumber" min="0">
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 5px;" onclick="gestionDefecto('edit')">Confirmar</button>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="cerrarMenuDefecto()">Cancerlar</button>
		</div>
	</div>
	<div class="agregarDefectos">
		<div class="contentEditar">
			<div class="titleContent">Agregar defecto</div>
			<div class="lineDecoration"></div>
			<div class="bodyEdicion">
				<div class="lbl" style="margin-bottom: 5px;">Defecto</div>
				<select id="selectForDefectosNew" class="classCmbBox"></select>
				<div class="lbl" style="margin-bottom: 5px;">Operaci&oacute;n</div>
				<select id="selectForOperacionesNew" class="classCmbBox"></select>
				<div class="lbl" style="margin-bottom: 5px;">Cantidad de prendas</div>
				<input type="number" id="idCantDefectosNew" class="iptNumber" min="0">
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 5px;" onclick="guardarDefecto()">Confirmar</button>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="cerrarMenuDefectoNew()">Cancerlar</button>
		</div>
	</div>
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
			<div class="headerTitle" style="font-size: 16px;padding-top: 6px;">Consultar Auditoria Proceso Costura</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">	
			<div class="rowLineFlex">
				<div style="margin-left: 10%;width: 80%;display: flex;">
					<div class="lblNew" style="width: 60px;padding-top: 8px;">Ficha</div>
					<div class="spaceIpt" style="width: calc(100% - 90px);">
						<input type="number" id="idCodFicha" style="width: calc(100% - 10px);">
					</div>
					<div class="btnBuscarSpace" style="width: 30px;margin-left: 5px;"><i class="fa fa-search" aria-hidden="true"></i></div>
				</div>
			</div>
			<div id="idContentTblFichas" style="display: none;">
				<div class="spaceInLine"></div>
				<div class="lblNew" style="width: 100%;">Seleccione auditoria a consultar</div>
				<div class="rowLine" style="display: block;">
					<div class="tblPrendasDefecto">
						<div class="tblHeader">
							<!--
							<div class="itemHeader" style="width: 27%;">Tipo Auditoria</div>
							<div class="itemHeader" style="width: 13%;">Parte</div>	
							<div class="itemHeader" style="width: 10%;">Vez</div>	
							<div class="itemHeader" style="width: 25%;">Fecha</div>
							<div class="itemHeader" style="width: 25%;">Resultado</div>
							-->
							<div class="itemHeader" style="width: 20%;">Secuen.</div>
							<div class="itemHeader" style="width: 20%;">Auditor</div>
							<div class="itemHeader" style="width: 30%;">Fec. Inicio</div>
							<div class="itemHeader" style="width: 30%;">Fec. Fin</div>
						</div>
						<div class="tblBody" id="resultFichas">
						</div>
					</div>
				</div>
				<div class="lineDecoration"></div>
			</div>
			<div id="spaceResultado" style="display: none;">
				<div class="sameline txtSizeLbl">
					<div class="lblSimple" style="margin-bottom:5px;">Partida:</div>
					<span id="idpartida"></span>
				</div>
				<div class="sameline txtSizeLbl">
					<div class="lblSimple" style="margin-bottom:5px;">Aud. Final Corte:</div>
					<span id="idaudfincor"></span>
				</div>
				<div class="btnPrimary btnSpecialStyle" onclick="contunieAudPro()" style="margin-bottom: 5px; width: calc(80% - 20px); margin-left: 10%;">Continuar auditoria</div>
				<div class="lblNew" style="width: 220px;">Operaciones/Defectos</div>
				<div class="rowLine" id="tblContentDefectos" style="display: block;">
					<div class="tblPrendasDefecto">
						<div class="tblHeader">
							<div class="itemHeader" style="width: 100px;">Item</div>
							<div class="itemHeader" style="width: 200px;">Taller/Linea</div>
							<div class="itemHeader" style="width: 200px;">Operario</div>
							<div class="itemHeader" style="width: 200px;">Operación</div>
							<div class="itemHeader" style="width: 100px;">Vez</div>
							<div class="itemHeader" style="width: 200px;">Defecto</div>
							<div class="itemHeader" style="width: 100px;">Cant.</div>
							<div class="itemHeader" style="width: 100px;">Auditor</div>
							<div class="itemHeader" style="width: 100px;">Resultado</div>
							<div class="itemHeader" style="width: 100px;">Fecha</div>

						</div>
						<div class="tblBody" id="idTblDefectos">
						</div>
					</div>
				</div>
				<div class="lineDecoration"></div>
			</div>
		</div>
		<!--<div class="btnPrimary btnSpecialStyle" onclick="backToMain()" style="width: 180px;margin: auto;">Terminar</div>-->

		<div class="btnPrimary btnSpecialStyle" style="width: 180px;margin: auto;">Terminar</div>
		<div class="btnPrimary btnSpecialStyle" onclick="window.history.back();" style="width: 180px;margin: auto;margin-top: 10px;">Volver</div>
	</div>
	<script type="text/javascript" src="js/consultarEditarAuditoriaProceso.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		var codfic="";
		<?php
			if (isset($_GET['codfic'])) {
		?>
		codfic="<?php echo $_GET['codfic']; ?>";
		$("#idCodFicha").val(codfic);
		<?php
			}
		?>
	</script>
</body>
</html>