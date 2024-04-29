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
	<!-- Iconos de fuente externa -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
</head>
<body onload="verificarPerfil(<?php echo $_SESSION['perfil'];?>)">
	<div class="opcionesDefecto">
		<div class="opcion btnEditar" onclick="abrirMenuDefecto()">Editar</div>
		<div class="spaceVertical"></div>
		<div class="opcion btnEliminar" onclick="borrarDefecto('delete')">Eliminar</div>
		<div class="spaceVertical"></div>
		<div class="opcion btnClose" onclick="closeOpcionesDefecto()"><i class="fa fa-times" aria-hidden="true"></i></div>
	</div>
	<div class="editarDefectos">
		<div class="contentEditar">
			<div class="titleContent">Editar defecto</div>
			<div class="lineDecoration"></div>
			<div class="bodyEdicion">
				<div class="lbl" style="margin-bottom: 5px;">Defecto</div>
				<select id="selectForDefectos" class="classCmbBox"></select>
				<div class="lbl" style="margin-bottom: 5px;">Operaci&oacute;n</div>
				<select id="selectForOperaciones" class="classCmbBox"></select>
				<div class="lbl" style="margin-bottom: 5px;">Cantidad de prendas</div>
				<input type="number" id="idCantDefectos" class="iptNumber">
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 5px;" onclick="editarDefecto('edit')">Confirmar</button>
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
				<input type="number" id="idCantDefectosNew" class="iptNumber">
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
			<div class="headerTitle">Consultar / Editar Auditoria</div>
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
			<div class="msgForFichas"></div>
			<div id="idContentTblFichas" style="display: none;">
				<div class="spaceInLine"></div>
				<div class="lblNew" style="width: 100%;">Seleccion Auditoria a consultar</div>
				<div class="rowLine" style="display: block;">
					<div class="tblPrendasDefecto">
						<div class="tblHeader">
							<div class="itemHeader" style="width: 27%;">Tipo Auditoria</div>
							<div class="itemHeader" style="width: 13%;">Parte</div>	
							<div class="itemHeader" style="width: 10%;">Vez</div>	
							<div class="itemHeader" style="width: 25%;">Fecha</div>
							<div class="itemHeader" style="width: 25%;">Resultado</div>
						</div>
						<div class="tblBody">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="lineWithDecoration" style="margin-bottom: 10px;"></div>
		<div class="bodyContent" id="idContentForFicha" style="display: none;">			
			<div class="rowLine bodyPrimary" style="margin-bottom: 5px;">				
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 70px;">Taller</div>
					<div class="spaceIpt" style="width: calc(100% - 70px);">
						<div class="valueRequest" id="idNombreTaller"></div>
					</div>
				</div>		
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 210px;">Cantidad de prendas</div>
					<div class="spaceIpt" style="width: calc(100% - 210px);">
						<div class="valueRequest" id="idCantPrendas"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 210px;margin: 0px;">Muestreo</div>
					<div class="spaceIpt" style="width: calc(100% - 210px);">
						<div class="valueRequest" id="idMuestreo"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 210px;"></div>
					<div class="spaceIpt" style="width: calc(100% - 210px);">
						<div class="valueRequest" id="idNumPrendasAuditar"></div>
					</div>
				</div>
			</div>
			<div class="lblNew" style="width: 220px;">Prendas con Defecto</div>
			<div id="msgForDefectos" style="display: none; color: red;">No hay defectos!</div>
			<div class="rowLine" id="tblContentDefectos" style="display: block;">
				<div class="tblPrendasDefecto">
					<div class="tblHeader">
						<div class="itemHeader" style="width: 40%;">Defecto</div>
						<div class="itemHeader" style="width: 40%;">Operaci&oacute;n</div>	
						<div class="itemHeader" style="width: 20%;">Cantidad</div>						
					</div>
					<div class="tblBody" id="idTblDefectos">
					</div>
				</div>
			</div>
			<div class="btnPrimary btnSpecialStyle" onclick="newdefecto()" style="margin-top: 10px;">Añadir defecto</div>	
			<div class="lineWithDecoration" style="margin-top: 10px;width: 100%;margin-left: 0px;"></div>
		</div>
		<div class="sameLine">
			<div class="btnPrimary btnSpecialStyle">Terminar</div>

<!--			<div class="btnPrimary btnSpecialStyle" onclick="backToMain()">Terminar</div>-->

		</div>		
	</div>
	<script type="text/javascript" src="js/index.js"></script>
	<script type="text/javascript" src="js/consultarEditarAuditoria.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>