<?php
	session_start();
	if (!isset($_SESSION['user'])) {
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
	<link rel="stylesheet" type="text/css" href="css/consultaAuditoria.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<style>
		table{
			border-collapse: collapse;
			
		}
		table, td, th{
			border: 1px solid black;
		}
		th{
			padding: 5px;
		}
		.d-none{
			display: none;
		}
		.modalContainer{
			z-index: 10;
		}
		button{
			border-style: none;
		}
	</style>
</head>
<body onload="verificarPerfil(<?php echo $_SESSION['perfil'];?>)">
	<div class="modalContainer" id="modal-1" style="margin-top: 50px;">
		<div class="modalBackground" style="width: 300px;margin-left: auto;margin-right: auto;">
			<div class="modalTitle">Nueva observaci&oacute;n</div>
			<div class="lineDecoration"></div>
			<textarea style="font-family: sans-serif;width: calc(100% - 7px);height: 100px;" id="idTextObs"></textarea>
			<div class="lineDecoration"></div>
			<button class="btnModal" style="width: 100%;margin-bottom: 5px;" onclick="save_observacion()">Confimar</button>
			<button class="btnModal" style="width: 100%;" onclick="hide_modal('modal-1')">Cancelar</button>
		</div>
	</div>
	<div class="modalContainer" id="modal-2" style="margin-top: 50px;">
		<div class="modalBackground" style="width: 300px;margin-left: auto;margin-right: auto;">
			<div class="modalTitle">Editar observaci&oacute;n</div>
			<div class="lineDecoration"></div>
			<textarea style="font-family: sans-serif;width: calc(100% - 7px);height: 100px;" id="idTextObsEdit"></textarea>
			<div class="lineDecoration"></div>
			<button class="btnModal" style="width: 100%;margin-bottom: 5px;" onclick="save_edit_observacion()">Confimar</button>
			<button class="btnModal" style="width: 100%;" onclick="hide_modal('modal-2')">Cancelar</button>
		</div>
	</div>
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
				<!--
				<div class="lbl" style="margin-bottom: 5px;">Operaci&oacute;n</div>
				<select id="selectForOperaciones" class="classCmbBox"></select>-->
				<div class="lbl" style="margin-bottom: 5px;">Cantidad de prendas</div>
				<input type="number" id="idCantDefectos" class="iptNumber">
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 5px;" onclick="editarDefecto('edit')">Confirmar</button>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="cerrarMenuDefecto()">Cancerlar</button>
		</div>
	</div>

	<div class="contentClasiRecu">
		<div class="contentEditar">
			<div class="titleContent">Detalles de Auditor&iacute;a</div>
			<div class="notaminus" style="text-align: center;"><span id="idInfoRegister"></span></div>
			<div class="lineDecoration"></div>
			<div class="bodyEdicion" id="placeClaRec">
				<div class="sameline" style="width: 100%;margin-bottom: 5px;">
					<div class="lbl" style="margin: 0px;width: 50%">Defecto</div>
					<input type="number" id="ida" class="iptNumber" style="width: 50%;margin: 0px;">
				</div>
			</div>
			<div class="notaminus">NOTA: La cantidad parte de la ficha es <span id="idcanpar"></span></div>
			<button class="btnPrimary" id="idBtnRegClasiRecu" style="margin-left: calc(50% - 80px);margin-bottom: 5px;" onclick="saveClasiRecu()">Confirmar</button>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="cerrarClasiRecu()">Cancerlar</button>
		</div>
	</div>
	<div class="agregarDefectos">
		<div class="contentEditar">
			<div class="titleContent">Agregar defecto</div>
			<div class="lineDecoration"></div>
			<div class="bodyEdicion">
				<div class="lbl" style="margin-bottom: 5px;">Defecto</div>
				<select id="selectForDefectosNew" class="classCmbBox"></select>
				<!--
				<div class="lbl" style="margin-bottom: 5px;">Operaci&oacute;n</div>
				<select id="selectForOperacionesNew" class="classCmbBox"></select>-->
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
					<button class="btnBuscarSpace" style="width: 30px;margin-left: 5px;"><i class="fa fa-search" aria-hidden="true"></i></button>
				</div>
			</div>
			<div class="msgForFichas"></div>
			<div id="idContentTblFichas" style="display: none;">
				<div class="spaceInLine"></div>
				<div class="lblNew" style="width: 100%;">Selecci&oacute;n Auditoria a consultar</div>
				<div class="rowLine" style="display: block;">
					<div class="tblPrendasDefecto">
						<div class="tblHeader">
							<div class="itemHeader" style="width: 27%;">Auditor</div>
							<div class="itemHeader" style="width: 13%;">Parte</div>	
							<div class="itemHeader" style="width: 10%;">Vez</div>	
							<div class="itemHeader" style="width: 10%;">Can. Par.</div>	
							<div class="itemHeader" style="width: 20%;">Fecha</div>
							<div class="itemHeader" style="width: 20%;">Resultado</div>
						</div>
						<div class="tblBody" id="idTblFichas">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="lineWithDecoration" style="margin-bottom: 10px;"></div>
		<div class="bodyContent" id="idContentForFicha" style="display: none;">			
			<div class="rowLine bodyPrimary" style="margin-bottom: 5px;">				
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 120px;">Taller</div>
					<div class="spaceIpt" style="width: calc(100% - 120px);">
						<div class="valueRequest" id="idNombreTaller"></div>
					</div>
				</div>					
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 120px;">Pedido</div>
					<div class="spaceIpt" style="width: calc(100% - 120px);">
						<div class="valueRequest" id="idPedido"></div>
					</div>
				</div>					
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 120px;">Est. TSC</div>
					<div class="spaceIpt" style="width: calc(100% - 120px);">
						<div class="valueRequest" id="idesttsc"></div>
					</div>
				</div>					
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 120px;">Est. Cliente</div>
					<div class="spaceIpt" style="width: calc(100% - 120px);">
						<div class="valueRequest" id="idestcli"></div>
					</div>
				</div>		
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 120px;">Partida</div>
					<div class="spaceIpt" style="width: calc(100% - 120px);">
						<div class="valueRequest" id="idpartida"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 120px;">Color</div>
					<div class="spaceIpt" style="width: calc(100% - 120px);">
						<div class="valueRequest" id="idcolor"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 120px;">Tipo de Tela</div>
					<div class="spaceIpt" style="width: calc(100% - 120px);">
						<div class="valueRequest" id="idtiptel"></div>
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
						<div class="itemHeader" style="width: 80%;">Defecto</div>
						<div class="itemHeader" style="width: 20%;">Cantidad</div>						
					</div>
					<div class="tblBody" id="idTblDefectos">
					</div>
				</div>
			</div>
			<div class="btnPrimary btnSpecialStyle" onclick="newdefecto()" style="margin-top: 10px; width: 250px;margin-right: auto;margin-left: auto;">Añadir defecto</div>
			<!--<div class="lineWithDecoration" style="margin-top: 10px;width: 100%;margin-left: 0px;"></div>
			<div class="lblNew" style="width: 220px;">Observaciones</div>			
			<div id="tblObservaciones" style="margin-bottom: 5px;">				
			</div>
			<div style="color: #246e8c;text-decoration: underline;" onclick="show_panel_obs()">Añadir observaci&oacute;n</div>-->
			<!--
			<div class="lineWithDecoration" style="margin-top: 10px;width: 100%;margin-left: 0px;"></div>
			<div class="sameLine">
				<div class="btnPrimary" onclick="RegistrarMedidas()" style="width: 100%;">Medidas – Octavos</div>
			</div>	
			<div class="sameLine d-none" style="justify-content: center;margin-top:10px" id="DivContenido">
				<table>
					<thead>
						<tr>
							<th>HILO</th>
							<th>TRAVEZ</th>
							<th>LARG. MANGA</th>
							<th>OPERACIÓN</th>
						</tr>
					</thead>
					<tbody id="tablaCuerpo">

					</tbody>
				</table>
			</div>-->
		</div>
		<div class="sameLine">
			<div class="btnPrimary btnSpecialStyle" onclick="backToMain()">Terminar</div>
		</div>		
	</div>
	<script type="text/javascript">
		var codusu_var='<?php echo $_SESSION['user']; ?>';
		var perusu_var='<?php echo $_SESSION['perfil']; ?>';
	</script>
	<script type="text/javascript" src="js/index-v1.1.js"></script>
	<script type="text/javascript" src="js/consultarEditarAuditoria-v1.0.js"></script>
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