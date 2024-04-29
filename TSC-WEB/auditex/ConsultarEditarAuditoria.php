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
<html lang="es">
<head>
	<title>AUDITEX</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/consultaAuditoria.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<style type="text/css">
		a{
			color:#2d99f5;
		}
		.seleccionado{
			background:#ccc;
		}
	</style>
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

	<div class="contentClasiRecu">
		<div class="contentEditar" style="max-height: 500px;overflow:auto">
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
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="cerrarClasiRecu()">Cancelar</button>
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
			<div class="headerTitle">Consultar / Editar Auditoria Final de Costura</div>
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
					<button class="btnBuscarSpace" style="width: 30px;margin-left: 5px;border-style: none;font-size: 22px;"><i class="fa fa-search" aria-hidden="true"></i></button>
				</div>
			</div>
			<div class="msgForFichas"></div>
			<div id="idContentTblFichas" style="display: none;">
				<div class="spaceInLine"></div>
				<div class="lblNew" style="width: 100%;">Selecci&oacute;n Auditoria a consultar</div>
				<div class="lblNew" style="width: 100%;" id="lblCanFic">Cantidad ficha: <span id="idCanFic"></span></div>
				<div class="rowLine" style="display: block;overflow-x: scroll;width: 100%;">
					<div class="tblPrendasDefecto" style="min-width: 600px;">
						<div class="tblHeader">
							<div class="itemHeader" style="width: 20%;">Auditor</div>
							<div class="itemHeader" style="width: 20%;">Taller</div>
							<div class="itemHeader" style="width: 10%;">Parte</div>	
							<div class="itemHeader" style="width: 10%;">Vez</div>	
							<div class="itemHeader" style="width: 10%;">Can. Par.</div>	
							<div class="itemHeader" style="width: 10%;">Fecha</div>
							<div class="itemHeader" style="width: 10%;">Tip Aud</div>
							<div class="itemHeader" style="width: 10%;">Resultado</div>
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
					<div class="lblNew" style="width: 120px;">Cliente</div>
					<div class="spaceIpt" style="width: calc(100% - 120px);">
						<div class="valueRequest" id="idCliente"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 120px;">Taller</div>
					<div class="spaceIpt" style="width: calc(100% - 120px);">
						<div class="valueRequest" id="idNombreTaller"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 120px;">Taller Corte</div>
					<div class="spaceIpt" style="width: calc(100% - 120px);">
						<div class="valueRequest" id="idNombreTalCor"></div>
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
					<div class="lblNew" style="width: 120px;">Tip. Tela</div>
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
			<div class="spaceInLine"></div>
			<div class="lblNew" style="width: 220px;">Distribuci&oacute;n por tallas</div>
			<div class="rowLine bodySecondary" style="display: block;margin-bottom: 10px;">
				<div class="tblDistributionTalla">
					<div class="tblHeader">
						<div class="itemHeader" style="width: 34%;">Talla</div>							
						<div class="itemHeader" style="width: 33%;">Cantidad Parcial</div>						
						<div class="itemHeader" style="width: 33%;">Cantidad AQL</div>						
					</div>
					<div class="tblBody" id="idTblTallas">
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

			<div class="lblNew" style="width: 220px;">Observaciones</div>
			<div id="observacionesnuevo" ></div>



			<div class="btnPrimary btnSpecialStyle" id="btnClasiRecu" onclick="clasiRecuperacion()" style="margin-top: 10px; width: 250px;margin-right: auto;margin-left: auto;">Clasificaci&oacute;n de ficha: primeras, segundas y observaciones</div>
			<div class="btnPrimary btnSpecialStyle" onclick="newdefecto()" style="margin-top: 10px; width: 250px;margin-right: auto;margin-left: auto;">Añadir defecto</div>
			<div class="btnPrimary" onclick="validar_esttsc()" style="margin-top: 10px;width: 150px;margin-left: calc(50% - 85px);">Auditar medidas</div>

<!-- <div class="btnPrimary btnSpecialStyle" id="btnanular" onclick="anular_ficha()" style="margin-top: 10px; width: 250px;margin-right: auto;margin-left: auto;">Anular Ficha</div> -->

			<div class="lineWithDecoration" style="margin-top: 10px;width: 100%;margin-left: 0px;"></div>
		</div>
		<div id="table-pendientes" style="display: none;margin: 0 10px;">
			<div class="lblNew" style="width: 100%;">Auditorias pendientes</div> 
			<div class="rowLine" style="display: block;width: 100%;overflow-x: scroll;">
				<div class="tblPrendasDefecto" style="min-width:500px;">
					<div class="tblHeader">
						<div class="itemHeader" style="width: 15%;">Parte</div>	
						<div class="itemHeader" style="width: 15%;">Vez</div>	
						<div class="itemHeader" style="width: 15%;">Can. Par.</div>
						<div class="itemHeader" style="width: 55%;">Taller</div>
					</div>
					<div class="tblBody" id="body-table-pendientes">
					</div>
				</div>
			</div>
			<div class="lineWithDecoration" style="margin-top: 10px;width: 100%;margin-left: 0px;"></div>
		</div>
		<div class="btnPrimary btnSpecialStyle" onclick="backToMain()" style="width: 200px;margin: auto;margin-top: 10px;">Terminar</div>	
		<div class="btnPrimary btnSpecialStyle" onclick="window.history.back();" style="width: 200px;margin: 10px auto 10px auto;">Volver</div>
	</div>
	<script type="text/javascript">
		var codusu_var='<?php echo $_SESSION['user']; ?>';
		var perusu_var='<?php echo $_SESSION['perfil']; ?>';
	</script>
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
	<script type="text/javascript" src="js/index-v1.1.js"></script>
	<script type="text/javascript" src="js/consultarEditarAuditoria-v1.5.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>