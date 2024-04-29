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
<html>
<head>
	<title>AUDITEX</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<style type="text/css">
		a{
			color: #40afe4;
		}
	</style>
</head>
<body onLoad="cargarDatos('<?php echo $_GET['codFic']?>',
	'<?php echo $_GET['codtll']?>',
	'<?php echo $_GET['tipoMuestra']?>',
	'<?php echo $_GET['numMuestra']?>',
	'<?php echo $_GET['numvez']?>',
	'<?php echo $_GET['parte']?>',
	'<?php echo $_GET['codtad']?>',
	'<?php echo $_GET['codaql']?>',
	<?php echo $_SESSION['codusu'];?>,
	'<?php echo $_SESSION['user'];?>',
	'<?php echo $_GET['tipoauditoria'];?>')">

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
	<div class="mainContent">
		<div class="headerContent">
			<!--
			<div class="backSpace">
				<div class="iconSpace"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
			</div>
			-->
			<div class="headerTitle">Registro de Prendas</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">			
			<div class="rowLine bodyPrimary">
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 110px;">Cliente</div>
					<div class="spaceIpt" style="width: calc(100% - 110px);">
						<div class="valueRequest" id="idCliente"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 110px;">Taller</div>
					<div class="spaceIpt" style="width: calc(100% - 110px);">
						<div class="valueRequest" id="idNombreTaller"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 110px;">Taller Corte</div>
					<div class="spaceIpt" style="width: calc(100% - 110px);">
						<div class="valueRequest" id="idNombreTalCor"></div>
					</div>
				</div>	
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 210px;">Ficha</div>
					<div class="spaceIpt" style="width: calc(100% - 210px);">
						<div class="valueRequest" id="idCodFicha"></div>
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
					<div class="lblNew" style="width: 210px;">Tipo Tela</div>
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
			</div>
			<div class="spaceInLine"></div>
			<div class="btnPrimary" onclick="validar_esttsc()" style="width: 150px;margin-left: calc(50% - 75px);">Auditar medidas</div>
			<div class="spaceInLine"></div>

			<div class="lblNew" style="width: 220px;">Distribución por tallas</div>
			<div class="rowLine bodySecondary" style="display: block;">
				<div class="tblDistributionTalla">
					<div class="tblHeader" id="tblheaderMod">
						<!-- <div class="itemHeader" style="width: 50%;">Talla</div>							
						<div class="itemHeader" style="width: 50%;">Cantidad</div>						 -->
					</div>
					<div class="tblBody" id="tblBodyMod">
					</div>
				</div>
			</div>

			<div class="lblNew" style="width: 220px;">Distribución por tallas AQL</div>

			<div class="rowLine bodySecondary" style="display: block;">
				<div class="tblDistributionTalla">
					<div class="tblHeader" id="tblheaderModAql">
						<!-- <div class="itemHeader" style="width: 50%;">Talla</div>							
						<div class="itemHeader" style="width: 50%;">Cantidad</div>						 -->
					</div>
					<div class="tblBody" id="tblBodyModAql">
					</div>
				</div>
			</div>




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
			<div class="spaceInLine"></div>	
			<div class="sameLine">
				<div class="rowLineFlex" style="margin-left: calc(50% - 75px);">
					<div class="lblNew" style="width: 100px; padding-top: 5px;">Cantidad</div>
					<div class="spaceIpt" style="width: calc(50px);">
						<input type="number" id="idCanPren" class="classIpt">
					</div>
				</div>
			</div>	
			<div class="spaceInLine"></div>
			<div class="sameLine">
				<div class="btnSpaceDouble">
					<div class="btnPrimary" onclick="aniadirPrenda()" style="width: 100%;">A&ntilde;adir</div>	
				</div>
			</div>	

			<div class="sameLine" style="margin-top:10px">
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 140px; padding-top: 8px;">Observación</div>
					<div class="spaceIpt" style="width: calc(100% - 140px);">
						<input type="text" id="txtobservacion" class="classIpt">
					</div>
				</div>
			</div>

		</div>
		<div class="lineWithDecoration"></div>
		<div class="bodyContent" style="padding-top: 0px;">			
			<div class="rowLine bodySecondary" style="display: none;" id="idTblResumen">
			<div class="lblNew" style="width: 100%;padding-top: 5px;">Resumen de Auditoria</div>			
				<div class="tblResumenAuditoria">
					<div class="tblHeader">
						<div class="itemHeader" style="width: 40%;">Defecto</div>							
						<div class="itemHeader" style="width: 40%;">Operaci&oacute;n</div>							
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
	<script type="text/javascript" src="js/RegistroPrendas-v1.3.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>