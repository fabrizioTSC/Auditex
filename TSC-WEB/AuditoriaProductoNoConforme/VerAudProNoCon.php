<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="14";
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
	<style>
		table,th,td{
			border-collapse: collapse;
		}
		table{
			width: 100%;
			font-size: 13px;
		}
		th,td{
			border: 1px #333 solid;
			padding: 5px;
		}
		th{
			background: #980f0f;
			color: #fff;
		}
		td{
			background: #fff;
		}
		td input{
			width: calc(100% - 10px);
			text-align: center;
			padding: 3px;
		}
		.cell-input{
			padding: 0px;
		}
		tr th:nth-child(1){
			width: 60px;
		}
		tr th:nth-child(2),tr th:nth-child(3),tr th:nth-child(4),
		tr th:nth-child(7),tr th:nth-child(5),tr th:nth-child(6),
		tr th:nth-child(8),
		tr td:nth-child(2),tr td:nth-child(3),tr td:nth-child(4),
		tr td:nth-child(7),tr td:nth-child(5),tr td:nth-child(6),
		tr td:nth-child(8){
			width: 30px;
		}
		.last-td{
			background: #999;
			color: #fff;
		}
		.td-void{
			border-style: none;
			background: transparent;
		}
		.div-inline span{
			padding: 0 2px;
			display: block;
			width: calc(100% - 21px);
			text-align: center;
		}
		.div-inline{
			display: inline-flex;
			width: 100%;
		}
		.div-inline button{
			border-style: none;
			background-color: #a21c1c;
			padding: 2px;
			color: #fff;
			width: 17px;
			font-size: 11px;
		}
		a{
			color: #369cad;
		}
	</style>
</head>
<body onLoad="cargarDatos('<?php echo $_GET['codfic']?>',
	'<?php echo $_SESSION['user'];?>')">
	<?php contentMenu();?>
	<div class="panelCarga" style="display: block;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Producto no Conforme</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="rowLine bodyPrimary">
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Ficha</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="idcodfic"></div>
					</div>
				</div>		
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Fecha</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="idfecha"></div>
					</div>
				</div>		
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Pedido</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="idpedido"></div>
					</div>
				</div>	
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Color</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="idcolor"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Est. TSC</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="idesttsc"></div>
					</div>
				</div>	
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Est. Cliente</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="idestcli"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Partida</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="idpartida"></div>
					</div>
				</div>		
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Linea/taller costura</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="idnomtal"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Célula taller corte</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="idnomtalcor"></div>
					</div>
				</div>
				<!--
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 180px;" id="idaudfincos">Aud. Final de Costura</div>
					<div class="spaceIpt" style="width: calc(100% - 180px);">
						<div class="valueRequest"></div>
					</div>
				</div>-->
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Art&iacute;culo</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="idarticulo"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Cantidad</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="idcantidad"></div>
					</div>
				</div>
			</div>
			<div class="spaceInLine"></div>
			<div id="tbltalla">
				
			</div>
			<!--
			<div class="btnPrimary" onclick="guardar_tallas()" style="margin: auto;margin-top: 10px;">Guardar</div>-->
			<div class="lineDecoration"></div>
			<div style="display: flex;">				
				<div class="rowLineFlex" style="margin-right: 5px;">
					<div class="lblNew" style="width: 100px;">Pre. Muestra:</div>
					<div class="spaceIpt" style="width: calc(100% - 100px);">
						<input type="number" style="width: calc(100% - 12px);" id="idcanmue">
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 100px;">Pre. Recuper:</div>
					<div class="spaceIpt" style="width: calc(100% - 100px);">
						<input type="number" style="width: calc(100% - 12px);" id="idcanrecup">
					</div>
				</div>
			</div>
			<div style="display: flex;margin-top: 5px;">				
				<div class="rowLineFlex" style="margin-right: 5px;">
					<div class="lblNew" style="width: 100px;">Clas. Total:</div>
					<div class="spaceIpt" style="width: calc(100% - 100px);">
						<div class="valueRequest" id="idcantot-det"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 100px;">Pre. 1ras:</div>
					<div class="spaceIpt" style="width: calc(100% - 100px);">
						<div class="valueRequest" id="idprepri-det"></div>
					</div>
				</div>
			</div>
			<div class="btnPrimary" onclick="grabar_datos_adic()" style="margin: auto;margin-top: 5px;">Grabar</div>
			<div class="lineDecoration"></div>
			<div class="sameLine">
				<div class="lblNew" style="width: 100px; padding-top: 8px;">Talla</div>
				<div class="spaceIpt" style="width: calc(100% - 100px);">
					<select id="selecttallas" class="classCmbBox">
					</select>
				</div>
			</div>	
			<div class="sameLine">
				<div class="lblNew" style="width: 100px; padding-top: 8px;">Defecto</div>
				<div class="spaceIpt" style="width: calc(100% - 100px);">
					<input type="text" id="iddefecto" class="classIpt">
				</div>
			</div>	
			<div class="tblDefectos" id="tbldefectos" style="margin-bottom: 10px;">
			</div>		
			<div class="sameLine">
				<div class="lblNew" style="width: 100px; padding-top: 8px;">Ubicaci&oacute;n</div>
				<div class="spaceIpt" style="width: calc(100% - 100px);">
					<select id="idubicacion" class="classCmbBox">
					</select>
				</div>
			</div>	
			<div class="sameLine">
				<div class="lblNew" style="width: 100px; padding-top: 8px;">Observaci&oacute;n</div>
				<div class="spaceIpt" style="width: calc(100% - 100px);">
					<textarea style="width: calc(100% - 12px);font-family: sans-serif;padding: 5px;" id="idobs"></textarea>
				</div>
			</div>
			<div class="btnPrimary" onclick="agregar_talla()" style="margin: auto;margin-top: 10px;">Agregar</div>
			<div class="lineDecoration"></div>
			<div style="width: 100%;overflow-x: scroll;">
				<table id="tbldeftal" style="min-width: 600px;">
					<tr>
						<th class="td-void"></th>
						<!--<th colspan="3">Cla. Ini.</th>-->
						<th colspan="3">Cla. Fin.</th>
						<th class="td-void"></th>
						<th class="td-void"></th>
						<th class="td-void"></th>
						<th class="td-void"></th>
					</tr>
					<tr>
						<th>Talla</th>
						<!--<th>2</th>
						<th>3</th>
						<th>4</th>-->
						<th>2</th>
						<th>3</th>
						<th>4</th>
						<th>Cod. Def.</th>
						<th>Defecto</th>
						<th>Ubicaci&oacute;n</th>
						<th>Obs.</th>
					</tr>
				</table>
			</div>
			<table style="margin-top: 10px;">
				<tr>
					<th>Resumen de Clasificaci&oacute;n Final - Ficha</th>
					<th>%</th>
				</tr>
				<!--
				<tr>
					<td>1ra</td>
					<td><span class="sum-cla" id="clasi-1">0</span>%</td>
				</tr>-->
				<tr>
					<td>2da</td>
					<td><span class="sum-cla" id="clasi-2">0</span>%</td>
				</tr>
				<tr>
					<td>3ra</td>
					<td><span class="sum-cla" id="clasi-3">0</span>%</td>
				</tr>
				<tr>
					<td>4ta</td>
					<td><span class="sum-cla" id="clasi-4">0</span>%</td>
				</tr>
				<tr>
					<td class="last-td">TOTAL</td>
					<td class="last-td"><span id="clasi-tot">0</span>%</td>
				</tr>
			</table>
			<div class="btnPrimary" onclick="terminar_auditora()" style="margin: auto;margin-top: 10px;">Terminar</div>
			<div class="lineDecoration"></div>
			<table style="margin-top: 10px;">
				<tr>
					<th>Clasificaci&oacute;n Pedido Color <span id="idpedcol"></span></th>
					<th>%</th>
				</tr>
				<tr>
					<td>2da <span id="valadd-2"></span></td>
					<td><span id="pedcol-2">0</span>%</td>
				</tr>
				<tr>
					<td>3ra <span id="valadd-3"></span></td>
					<td><span id="pedcol-3">0</span>%</td>
				</tr>
				<tr>
					<td>4ta <span id="valadd-4"></span></td>
					<td><span id="pedcol-4">0</span>%</td>
				</tr>
				<tr>
					<td class="last-td">TOTAL</td>
					<td class="last-td"><span id="pedcol-tot">0</span>%</td>
				</tr>
			</table>
		</div>
	</div>
	<script type="text/javascript">
		var codusu='<?php echo $_SESSION['user']; ?>';
		var parte='<?php echo $_GET['parte']; ?>';
		var numvez='<?php echo $_GET['numvez']; ?>';
	</script>
	<script type="text/javascript" src="js/VerAudProNoCon-v1.1.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" id="addscripts"></script>
	<script type="text/javascript">
		function goBack(){
			window.history.back();
		}
	</script>
</body>
</html>