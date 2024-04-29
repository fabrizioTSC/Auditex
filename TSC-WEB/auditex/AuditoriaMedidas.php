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
	<meta name="viewport" content="width=device-width,heigh=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index.css">
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
		a, .link-a {
		    color: #5092c1;
		}
		.btn-prenda{
			margin-left: 20px;
		}
		.item-s2 {
		    width: 130px;
		}
		.column-tbl-s2 {
		    width: 142px;
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
			<div class="headerTitle">Auditor&iacute;a final de Medidas</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="title-medida">Ficha: <?php echo $_GET['codfic']; ?></div>		
			<div class="lineDecoration"></div><div id="content-aud" style="display: block;">
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Cantidad Ficha</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="canfic"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Cliente</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="cliente"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Pedido - Color</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="pedido"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Est TSC - Cliente</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="esttsc"></div>
					</div>
				</div>	
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Prenda</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="despre"></div>
					</div>
				</div>	
				<div class="rowLineFlex">
					<div class="spaceIpt" style="width: calc(100% - 145px);">
						<div class="valueRequest" id="audfincor"></div>
					</div>
				</div>			
				<div class="rowLineFlex">
					<div class="spaceIpt" style="width: calc(100% - 145px);">
						<div class="valueRequest" id="audprocos"></div>
					</div>
				</div>		
				<div class="rowLineFlex">
					<div class="spaceIpt" style="width: calc(100% - 145px);">
						<div class="valueRequest" id="audfincos"></div>
					</div>
				</div>			
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Taller Corte</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="destllcor"></div>
					</div>
				</div>		
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Taller Costura</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="destll"></div>
					</div>
				</div>			
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Artículo</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="articulo"></div>
					</div>
				</div>		
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Partida</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="partida"></div>
					</div>
				</div>			
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Ruta Prenda</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="rutpre"></div>
					</div>
				</div>	
			</div>
			<a onclick="ctrl_header()" id="ctrl-header" style="text-decoration: underline;color: #0089ff;font-size: 12px;">Ocultar detalle ficha</a>
			<div class="lineDecoration"></div>
			<div id="content-main">
				<div class="sameline" style="margin-bottom: 5px;">
					<div class="lblNew" style="width: 150px;padding-top: 7px;">Prendas por talla:</div>
					<input type="number" id="CanXTalla" class="iptClass" style="width: calc(50px);" value="1" min="1">
				</div>	
				<div class="sameline" style="margin-bottom: 5px;">
					<div class="lblNew" style="width: 150px;padding-top: 7px;">Prendas por talla adic.:</div>
					<input type="number" id="CanXTallaAdi" class="iptClass" style="width: calc(50px);" value="0" min="0">
				</div>	
				<div class="sameline">
					<div class="btnPrimary" onclick="redirect('main.php')" style="width: 150px;margin-right: calc(50% - 150px);">Volver</div>
					<div class="btnPrimary" onclick="generateTable()" style="width: 150px;margin-left: calc(50% - 150px);">Generar</div>
				</div>
				<div class="lineDecoration"></div>	
				<div id="resume-medida" style="display: none;overflow: scroll;max-height: calc(100vh - 185px);position: relative;">
					<div class="tbl-header" id="space-res-hader" style="display: flex;position: relative;z-index: 10;">
					</div>
					<div id="space-tbl-medidas" style="display: flex;position: relative;">
					</div>
				</div>
				<div id="confirmar-resultado" style="display: block;">
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
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 10px;margin-bottom: 0px;" onclick="download_excel()" id="btndescarga">Descargar</button>
				<div class="btnPrimary" onclick="redirect_registro()" style="margin-top: 10px;">Iniciar auditor&iacute;a</div>
				<div class="btnPrimary" onclick="window.history.back()" style="margin-top: 10px;">Volver</div>
			</div>
			<div id="second-frame" style="display: none;">
				<a onclick="add_pulgadas()" id="ctrl-pulg" style="font-size: 12px;text-decoration: underline;">Ampliar pulgadas</a>
				<div class="title-medida">Talla&nbsp;<span id="talla-select"></span>&nbsp;- Prendas <div class="content-btns-prenda" id="space-btns-prendas"></div></div>
				<div id="space-tbl-generate" style="max-height: calc(100vh - 212px);overflow-y: scroll;position: relative;">
				</div>
				<div class="sameline" style="margin-top: 5px;">
					<div class="btnPrimary" onclick="move_frame(0)" style="width: 100px;margin-right: calc(50% - 100px);">Anterior</div>
					<div class="btnPrimary" onclick="move_frame(1)" style="width: 100px;margin-left: calc(50% - 100px);">Siguiente</div>
				</div>
				<div class="lineDecoration"></div>
				<textarea id="comentarioAM" style="width: calc(100% - 7px);font-family: sans-serif;margin-top: 5px;"></textarea>
				<div class="btnPrimary" onclick="save_comment()" id="btn-end">Guardar observaciones</div>
				<div class="lineDecoration"></div>
				<div class="btnPrimary" onclick="endRegistroMedida('main.php')">Finalizar</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var codfic="<?php echo $_GET['codfic']; ?>";
		var esttsc="<?php echo isset($_GET['esttsc']) ? $_GET["esttsc"] :""; ?>";
		var consulta="<?php echo isset($_GET['consulta']) ? $_GET["consulta"] :""; ?>";
		var numvez="<?php echo isset($_GET['numvez']) ? $_GET["numvez"] :""; ?>";
		var parte="<?php echo isset($_GET['parte']) ? $_GET["parte"] :""; ?>";
		var codtad="<?php echo isset($_GET['codtad']) ? $_GET["codtad"] :""; ?>";
		var codaql="<?php echo isset($_GET['codaql']) ? $_GET["codaql"] :""; ?>";
		var tipoauditoria="<?php echo isset($_GET['tipoauditoria']) ? $_GET["tipoauditoria"] :""; ?>";
		var codtll="<?php echo isset($_GET['codtll']) ? $_GET["codtll"] :""; ?>";
		var nummuestra="<?php echo isset($_GET['nummuestra']) ? $_GET["nummuestra"] :""; ?>";
		function ctrl_header(){
			if(document.getElementById("content-aud").style.display=="none"){
				document.getElementById("content-aud").style.display="block";
				document.getElementById("ctrl-header").innerHTML="Ocultar detalle Ficha";
			}else{
				document.getElementById("content-aud").style.display="none";
				document.getElementById("ctrl-header").innerHTML="Mostrar detalle ficha";
			}
		}
	</script>
	<script type="text/javascript" src="js/AuditoriaMedidas-v1.2.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>


	<script>

		// GET OBSERVACIONES MEDIDAS
		$.ajax({
			url:"/tsc/controllers/auditex-costura/medidasauditables.controller.php",
			type:"GET",
			data:{
				ficha:codfic,
				parte:parte,
				numvez:numvez,
				codtad:codtad,
				operacion: 'getobservacion'
			},
			success:function (data){
				let response = JSON.parse(data);
				$("#txtobservacionmedidas").val(response.OBSERVACION_MEDIDAS);

			}
		});


	</script>









</body>
</html>