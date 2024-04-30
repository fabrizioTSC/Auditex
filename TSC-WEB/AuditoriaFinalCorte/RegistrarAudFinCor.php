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
	<style>
		.modalTitle{
			color:black;
		}
		.textMsgCarga{
			color:black;
		}
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
		.line-for-obs{
			border-top: 1px solid #333;
		}
		.line-for-obs:nth-child(1){
			border:none;
		}
	</style>
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
</head>
<body onLoad="cargarDatos('<?php echo $_GET['codFic']?>',
	'<?php echo $_GET['tipoMuestra']?>',
	'<?php echo $_GET['numMuestra']?>',
	'<?php echo $_GET['numvez']?>',
	'<?php echo $_GET['parte']?>',
	'<?php echo $_GET['codtad']?>',
	'<?php echo $_GET['codaql']?>',
	<?php echo $_SESSION['codusu'];?>,
	'<?php echo $_SESSION['user'];?>')">
	<div class="panelCarga" style="display: block;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="msgInstant" style="display: none;">
		<div class="bodyMsgInstant">
			<div class="textMsgCarga">CARGANDO...</div>
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
	<div class="modalContainer" id="modal-1" style="margin-top: 50px;">
		<div class="modalBackground" style="width: 300px;margin-left: auto;margin-right: auto;">
			<div class="modalTitle">Nueva observaci&oacute;n</div>
			<div class="lineDecoration"></div>
			<textarea style="font-family: sans-serif;width: calc(100% - 7px);height: 100px;" id="idTextObs" maxlength="100"></textarea>
			<div class="lineDecoration"></div>
			<button class="btnModal" style="width: 100%;margin-bottom: 5px;" onclick="save_observacion()">Confimar</button>
			<button class="btnModal" style="width: 100%;" onclick="hide_modal('modal-1')">Cancelar</button>
		</div>
	</div>
	<div class="modalContainer" id="modal-2" style="margin-top: 50px;">
		<div class="modalBackground" style="width: 300px;margin-left: auto;margin-right: auto;">
			<div class="modalTitle">Editar observaci&oacute;n</div>
			<div class="lineDecoration"></div>
			<textarea style="font-family: sans-serif;width: calc(100% - 7px);height: 100px;" id="idTextObsEdit" maxlength="100"></textarea>
			<div class="lineDecoration"></div>
			<button class="btnModal" style="width: 100%;margin-bottom: 5px;" onclick="save_edit_observacion()">Confimar</button>
			<button class="btnModal" style="width: 100%;" onclick="hide_modal('modal-2')">Cancelar</button>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Registro de Prendas</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">			
			<div class="rowLine bodyPrimary">				
				<div class="rowLineFlex">
					<div class="lblNew" id="linkaudprocor"></div>
				</div>	
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 70px;">Cliente</div>
					<div class="spaceIpt" style="width: calc(100% - 70px);">
						<div class="valueRequest" id="idCliente"></div>
					</div>
				</div>	
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 70px;">Taller</div>
					<div class="spaceIpt" style="width: calc(100% - 70px);">
						<div class="valueRequest" id="idNombreTaller"></div>
					</div>
				</div>		
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 210px;">Ficha</div>
					<div class="spaceIpt" style="width: calc(100% - 210px);">
						<div class="valueRequest" id="idCodFicha"></div>
					</div>
				</div>	
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 210px;">Pedido</div>
					<div class="spaceIpt" style="width: calc(100% - 210px);">
						<div class="valueRequest" id="idPedido"></div>
					</div>
				</div>	
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 210px;">Est. TSC</div>
					<div class="spaceIpt" style="width: calc(100% - 210px);">
						<div class="valueRequest" id="idEsttsc"></div>
					</div>
				</div>	
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 210px;">Est. Cliente</div>
					<div class="spaceIpt" style="width: calc(100% - 210px);">
						<div class="valueRequest" id="idEstcli"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 210px;">Partida</div>
					<div class="spaceIpt" style="width: calc(100% - 210px);">
						<div class="valueRequest" id="idpartida"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 210px;">Color</div>
					<div class="spaceIpt" style="width: calc(100% - 210px);">
						<div class="valueRequest" id="idcolor"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 210px;">Tipo de Tela</div>
					<div class="spaceIpt" style="width: calc(100% - 210px);">
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
					<div class="lblNew" style="width: 210px;margin-bottom: 0px;">Muestreo</div>
					<div class="spaceIpt" style="width: calc(100% - 210px);">
						<div class="valueRequest" id="idMuestreo"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 210px;"></div>
					<div class="spaceIpt" style="width: calc(100% - 210px);margin-bottom: 5px;">
						<div class="valueRequest" id="idNumPrendasAuditar"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 210px;">Cantidad max. de defectos</div>
					<div class="spaceIpt" style="width: calc(100% - 210px);">
						<div class="valueRequest" id="idCanMaxDef"></div>
					</div>
				</div>
				<div class="sameLine">
					<div class="btnPrimary" onclick="RegistrarMedidas()" style="width: 100%;">Medidas – Octavos</div>
				</div>	
				<div class="sameLine d-none" style="justify-content: center;margin-top:10px" id="DivContenido">
				</div>
			</div>
			<div class="spaceInLine"></div>
			<div class="lblNew" style="width: 220px;">Distribuci&oacute;n por tallas</div>
			<div class="rowLine bodySecondary" style="display: block;">
				<div class="tblDistributionTalla">
					<div class="tblHeader">
						<div class="itemHeader" style="width: 50%;">Talla</div>							
						<div class="itemHeader" style="width: 50%;">Cantidad</div>						
					</div>
					<div class="tblBody">
					</div>
				</div>
			</div>
			<div class="spaceInLine"></div>
			<div class="lblNew" style="width: 100%;">Observaciones</div>
			<div id="tblObservaciones" style="margin-bottom: 5px;">
				
			</div>
			<div style="color: #246e8c;text-decoration: underline;" onclick="show_panel_obs()">Añadir observaci&oacute;n</div>
		</div>
		<div class="lineWithDecoration"></div>
		<div class="bodyContent">	
			<div class="sameLine">
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 140px; padding-top: 8px;">Ingrese defecto</div>
					<div class="spaceIpt" style="width: calc(100% - 140px);">
						<input type="text" id="idDefecto" class="classIpt">
					</div>
				</div>
			</div>	
			<div class="tblDefectos">
			</div>		
			<!--
			<div class="spaceInLine"></div>	
			<div class="sameLine">
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 140px; padding-top: 8px;">Ingrese operaci&oacute;n</div>
					<div class="spaceIpt" style="width: calc(100% - 140px);">
						<input type="text" id="idOperacion" class="classIpt">
					</div>
				</div>
			</div>	
			<div class="tblOperaciones">
			</div>
			-->
			<div class="spaceInLine"></div>	
			<div class="sameLine">
				<div class="rowLineFlex" style="margin-left: calc(50% - 75px);">
					<div class="lblNew" style="width: 100px; padding-top: 5px;">Cantidad</div>
					<div class="spaceIpt" style="width: calc(50px);">
						<input type="number" id="idCanPren" class="classIpt" min="0">
					</div>
				</div>
			</div>				
			<!--
			<div class="spaceInLine"></div>
			<div class="lblMsg">Quedan 0 prendas por auditar</div>
			-->
			<div class="spaceInLine"></div>
			<div class="sameLine">
				<div class="btnSpaceDouble">
					<div class="btnPrimary" onclick="aniadirPrenda()" style="width: 100%;">A&ntilde;adir</div>	
				</div>
			</div>	
		</div>
		<div class="lineWithDecoration"></div>
		<div class="bodyContent" style="padding-top: 0px;">			
			<div class="rowLine bodySecondary" style="display: none;" id="idTblResumen">
			<div class="lblNew" style="width: 100%;padding-top: 5px;">Resumen de Auditoria</div>			
				<div class="tblResumenAuditoria">
					<div class="tblHeader">
						<div class="itemHeader" style="width: 80%;">Defecto</div>						
						<div class="itemHeader" style="width: 20%;">Total</div>						
					</div>
					<div class="tblBodyResumen">
					</div>
				</div>
			</div>
			<div class="spaceInLine"></div>
			<div class="sameLine">
				<div class="btnPrimary" onclick="terminarAuditoraFicha()" style="width: 100%;">Terminar</div>
			</div>					
		</div>
	</div>
	<script type="text/javascript" src="js/RegistrarAudFinCor-v1.8.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>

	<!-- AGREGADO PARA LA INTEGRACION -->
	<script src="/tsc/auditex-moldes/js/integracioncorte/integracion.js"></script>
	<!-- END -->

</body>
</html>