<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="16";
	//include("config/_validate_access.php");
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
			width: calc(100% - 10px)!important;
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
		.iptSpecial{
			width: calc(100% - 22px)!important;
		}
		.content-table{
			overflow-y: scroll;
			max-height: 500px;
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
			<div class="headerTitle">Auditoria de Control de Humedad</div>
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
					<div class="lblNew" style="width: 130px;">Taller</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="idnomtal"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Aud. Final Corte</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="idnomtalcor"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 180px;" id="idaudfincos">Aud. Final de Costura</div>
					<div class="spaceIpt" style="width: calc(100% - 180px);">
						<div class="valueRequest"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 130px;">Art&iacute;culo</div>
					<div class="spaceIpt" style="width: calc(100% - 130px);">
						<div class="valueRequest" id="idarticulo"></div>
					</div>
				</div>
				<div style="display: flex">
					<div class="rowLineFlex">
						<div class="lblNew" style="width: 100px;margin-right: 5px;">Cantidad</div>
						<div class="spaceIpt" style="width: calc(100% - 100px);">
							<div class="valueRequest" id="idcantidad"></div>
						</div>
					</div>
					<div class="rowLineFlex">
						<div class="lblNew" style="width: 100px;margin-right: 5px;">Humedad Max.:</div>
						<div class="spaceIpt" style="width: calc(100% - 100px);">
							<input type="number" id="idHumMax" disabled class="iptSpecial">
						</div>
					</div>
				</div>
				<div style="display: flex">
					<div class="rowLineFlex">
						<div class="lblNew" style="width: 100px;margin-right: 5px;">Temperatura Amb.:</div>
						<div class="spaceIpt" style="width: calc(100% - 100px);">
							<input type="number" id="idTemAmb" class="iptSpecial">
						</div>
					</div>
					<div class="rowLineFlex">
						<div class="lblNew" style="width: 100px;margin-right: 5px;">Humedad Amb.:</div>
						<div class="spaceIpt" style="width: calc(100% - 100px);">
							<input type="number" id="idHumAmb" class="iptSpecial">
						</div>
					</div>
				</div>
				<center>
					<button class="btnPrimary" onclick="guardar_datos_cabecera()" style="margin-top: 5px;">Guardar Datos</button>
				</center>
			</div>
			<div class="lineDecoration"></div>
			<div class="content-table">
				<table>
					<thead>
						<tr>
							<th>ID</th>
							<th>HUMEDAD</th>
						</tr>
					</thead>
					<tbody id=table-humedad>
						<tr>
							<td><input type="number" value="1" disabled></td>
							<td><input class="class-humedad" data-idreg="1" type="number" value="0"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div style="display: flex;margin-top: 5px;">
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 100px;margin-right: 5px;">Resultado:</div>
					<div class="spaceIpt" style="width: calc(100% - 100px);">
						<span id="idResultado"></span>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 100px;margin-right: 5px;">Promedio:</div>
					<div class="spaceIpt" style="width: 80px;">
						<input type="number" id="idPromedio" class="iptSpecial">
					</div>
				</div>
			</div>
			<center>
				<button class="btnPrimary" onclick="guardar_humedad()" style="margin: auto;margin-top: 10px;">Guardar</button>
			</center>
			<div class="lineDecoration"></div>
			<center>
				<button class="btnPrimary" onclick="terminar_auditora()" style="margin: auto;margin-top: 10px;">Terminar</button>
			</center>
		</div>
	</div>
	<script type="text/javascript">
		var codusu='<?php echo $_SESSION['user']; ?>';
	</script>
	<script type="text/javascript" src="js/AudConHum-v1.0.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" id="addscripts"></script>
</body>
</html>