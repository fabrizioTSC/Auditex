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
	<link rel="stylesheet" type="text/css" href="css/index-v1.0.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="css/AuditoriaMedidas-v1.0.css">
	<style type="text/css">
		.btnPrimary {
			margin: auto;
		}
		.item-maxheight{
			height: 40px;
		}
		.column-tbl-s2 {
		    width: 142px;
		}
		.item-s2 {
		    width: 130px;
		    font-size: 11px;
		}
		.item-c2,.item-c3,.item-c4,.item-c5{
			height: 10px;
		}
		.header-content{
			position: relative;
			z-index: 10;
		}
		.main-content-medida{
			position: relative;
		}
		#second-frame a{
			text-decoration: underline;
			color: #00adff;
			font-size: 13px;
		}
		.btn-link{
			background: transparent;
			border: none;
			text-decoration: underline;
			color: #007eff;
			outline: none;
		}
		.btn-prenda{
			margin-left: 20px;
		}
	</style>
</head>
<body>
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
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Auditoría de medidas</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="title-medida">Pedido: <?php echo $_GET['pedido']; ?></div>	
			<div class="title-medida">Color: <?php echo $_GET['dsccol']; ?></div>		
			<div class="lineDecoration"></div>
				<div id="div-ctrl-detalle">	
					<div class="rowLineFlex">
						<div class="lblNew" style="width: 70px;">Prenda</div>
						<div class="spaceIpt" style="width: calc(100% - 70px);">
							<div class="valueRequest" id="idprenda"></div>
						</div>
					</div>	
					<div class="rowLineFlex">	
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 70px;">Parte</div>
							<div class="spaceIpt" style="width: calc(100% - 70px);">
								<div class="valueRequest" id="idparte"></div>
							</div>
						</div>
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 70px;">Vez</div>
							<div class="spaceIpt" style="width: calc(100% - 70px);">
								<div class="valueRequest" id="idvez"></div>
							</div>
						</div>	
					</div>
					<div class="rowLineFlex">	
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 70px;">Cliente</div>
							<div class="spaceIpt" style="width: calc(100% - 70px);">
								<div class="valueRequest" id="idcliente"></div>
							</div>
						</div>	
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 70px;">P.O.</div>
							<div class="spaceIpt" style="width: calc(100% - 70px);">
								<div class="valueRequest" id="idpo"></div>
							</div>
						</div>
					</div>
					<div class="rowLineFlex">	
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 70px;">Est TSC</div>
							<div class="spaceIpt" style="width: calc(100% - 70px);">
								<div class="valueRequest" id="idesttsc"></div>
							</div>
						</div>
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 70px;">Est Cli</div>
							<div class="spaceIpt" style="width: calc(100% - 70px);">
								<div class="valueRequest" id="idestcli"></div>
							</div>
						</div>		
					</div>
					<div class="rowLineFlex">	
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 70px;">Auditor</div>
							<div class="spaceIpt" style="width: calc(100% - 70px);">
								<div class="valueRequest" id="idauditor"></div>
							</div>
						</div>
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 70px;">Estado</div>
							<div class="spaceIpt" style="width: calc(100% - 70px);">
								<div class="valueRequest" id="idestado"></div>
							</div>
						</div>		
					</div>
					<div class="rowLineFlex">	
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 70px;">Fec Ini</div>
							<div class="spaceIpt" style="width: calc(100% - 70px);">
								<div class="valueRequest" id="idfecini"></div>
							</div>
						</div>
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 70px;">Fec Fin</div>
							<div class="spaceIpt" style="width: calc(100% - 70px);">
								<div class="valueRequest" id="idfecfin"></div>
							</div>
						</div>		
					</div>
					<div class="rowLineFlex">	
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 70px;">Cantidad</div>
							<div class="spaceIpt" style="width: calc(100% - 70px);">
								<div class="valueRequest" id="idcantidad"></div>
							</div>
						</div>	
					</div>
					<div class="rowLineFlex">	
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 70px;">AQL</div>
							<div class="spaceIpt" style="width: calc(100% - 70px);">
								<div class="valueRequest" id="idaql"></div>
							</div>
						</div>
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 70px;">Max Def</div>
							<div class="spaceIpt" style="width: calc(100% - 70px);">
								<div class="valueRequest" id="idmaxdef"></div>
							</div>
						</div>
					</div>
				</div>
				<button class=btn-link id="btn-detalle" onclick="ctrl_header()">Ocultar detalles</button>
			<div class="lineDecoration"></div>
			<div id="content-main">
				<div class="sameline" style="margin-bottom: 5px;">
					<div class="lblNew" style="width: 150px;padding-top: 7px;">Prendas por talla:</div>
					<input type="number" id="CanXTalla" class="iptClass" style="width: calc(50px);" value="1" min="1">
				</div>	
				<div class="sameline" style="margin-bottom: 5px;">
					<div class="lblNew" style="width: 200px;padding-top: 7px;">Prendas por talla adicional:</div>
					<input type="number" id="CanXTallaAdi" class="iptClass" style="width: calc(50px);" value="0" min="1">
				</div>	
				<div class="sameline">
					<div class="btnPrimary" onclick="window.history.back();" style="width: 150px;margin-right: calc(50% - 150px);">Volver</div>
					<div class="btnPrimary" id="btn-generar" onclick="generateTable()" style="width: 150px;margin-left: calc(50% - 150px);">Generar</div>
				</div>
				<div class="sameline" style="margin-top: 5px;" id="space-editar">
					<div class="btnPrimary" style="width: 150px;margin-right: calc(50% - 150px);background: transparent;"></div>
					<div class="btnPrimary" onclick="editar_table()" style="width: 150px;margin-left: calc(50% - 150px);">Editar</div>
				</div>
				<div class="lineDecoration"></div>	
				<div id="resume-medida" style="display: none;overflow: scroll;max-height: calc(100vh - 185px);position: relative;">
					<div class="tbl-header" id="space-res-hader" style="display: flex;position: relative;z-index: 10;">
					</div>
					<div id="space-tbl-medidas" style="display: flex;position: relative;">
					</div>
				</div>
				<div id="confirmar-resultado" style="display:none;">
					<div class="sameLine" style="margin-top:10px;">
						<label>Resultado</label>
						<select id="con-resultado" class="classCmbBox" style="margin-left:5px;">
							<option value="A">Aprobado</option>
							<option value="C">Aprobado no conforme</option>
							<option value="R">Rechazado</option>
						</select>
					</div>
					<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 0px;" onclick="confirmar_resultado()" id="btndescarga">Confirmar resultado</button>
				</div>
				<div class="btnPrimary" onclick="window.history.back();" style="margin-top: 10px;">Volver</div>
			</div>
			<div id="second-frame" style="display: none;">
				<a onclick="add_pulgadas()" id="ctrl-pulg">Ampliar pulgadas</a>
				<div class="title-medida">Talla&nbsp;<span id="talla-select"></span>&nbsp;- Prendas <div class="content-btns-prenda" id="space-btns-prendas"></div></div>
				<div id="space-tbl-generate" style="max-height: calc(100vh - 233px);overflow-y: scroll;position: relative;">
				</div>
				<div class="sameline" style="margin-top: 5px;">
					<div class="btnPrimary" onclick="move_frame(0)" style="width: 100px;margin-right: calc(50% - 100px);">Anterior</div>
					<div class="btnPrimary" onclick="move_frame(1)" style="width: 100px;margin-left: calc(50% - 100px);">Siguiente</div>
				</div>
				<textarea id="comentarioAM" style="width: calc(100% - 7px);font-family: sans-serif;margin-top: 5px;"></textarea>
				<div class="btnPrimary" onclick="save_comment()" id="btn-end">Guardar observaciones</div>
				<div class="lineDecoration"></div>
				<div class="btnPrimary" onclick="endRegistroMedida()" id="btn-end">Finalizar</div>				
				<div class="btnPrimary" onclick="window.history.back();" style="margin-top: 5px;">Volver</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var pedido="<?php echo $_GET['pedido']; ?>";
		var dsccol="<?php echo $_GET['dsccol']; ?>";
		var esttsc="";
		const text_menos="Ocultar detalles";
		const text_mas="Mostrar detalles";
		function ctrl_header(){
			if (document.getElementById("div-ctrl-detalle").style.display=="block"
				|| document.getElementById("div-ctrl-detalle").style.display=="") {
				document.getElementById("div-ctrl-detalle").style.display="none";
				document.getElementById("btn-detalle").innerHTML=text_mas;
			}else{
				document.getElementById("div-ctrl-detalle").style.display="block";
				document.getElementById("btn-detalle").innerHTML=text_menos;
			}
		}
	</script>
	<script type="text/javascript" src="js/AuditoriaMedidas-v1.6.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>