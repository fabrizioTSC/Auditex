<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="1";
	include("config/_validate_access.php");
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
	<style>
		table,th,td{
			border-collapse: collapse;
		}
		table{
			width: 100%;
			font-size: 13px;
			position: relative;
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
		.btn-link{
			background: transparent;
			border: none;
			text-decoration: underline;
			color: #007eff;
			outline: none;
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
			<div class="headerTitle">Consulta Aud. Control de Humedad</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">			
			<div class="rowLine bodyPrimary">
				<div id="div-ctrl-detalle">
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
				<button class=btn-link id="btn-detalle" onclick="ctrl_header()">Ocultar detalles</button>
			</div>
			<div class="lineDecoration"></div>
			<div class="content-table" id="table-main">
				<table>
					<thead>
						<tr>
							<th id="th-h1">ID</th>
							<th id="th-h2">HUMEDAD</th>
						</tr>
					</thead>
					<thead id="table-head-active" style="position: absolute;top: 0;left: 0;">
						<tr>
							<th id="th-h1-r">ID</th>
							<th id="th-h2-r">HUMEDAD</th>
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
					<div class="lblNew" style="width: 80px;margin-right: 5px;">Resultado:</div>
					<div class="spaceIpt" style="width: calc(100% - 80px);">
						<select id="idResultado" class="classCmbBox" style="width: calc(100% - 12px);" onchange="validar_obs(this)">
							<option value="A">Aprobado</option>
							<option value="C">Aprobado no conforme</option>
							<option value="R">Rechazado</option>
						</select>
						<!--
						<span id="idResultado"></span>-->
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 100px;margin-right: 5px;">Promedio:</div>
					<div class="spaceIpt" style="width: 80px;">
						<input type="number" id="idPromedio" class="iptSpecial">
					</div>
				</div>
			</div>
			<div style="margin-top: 5px; display: none;" id="div-observacion">
				<div class="lblNew" style="width: 100px;margin-right: 5px;">Observación:</div>
				<textarea style="padding: 5px;font-family: sans-serif;width: calc(100% - 12px);" id="idObservacion"></textarea>
			</div>
			<center>
				<button class="btnPrimary" onclick="correct_auditoria()" style="margin-top: 5px;" id="btn-editable">Guardar</button>	
				<!-- <button class="btnPrimary" onclick="volver_main()" style="margin-top: 5px;">Volver</button>	 -->
				<button class="btnPrimary" onclick="volver_main()" style="margin-top: 5px;">Volver</button>	
			</center>
		</div>
	</div>
	<script type="text/javascript">
		var codusu='<?php echo $_SESSION['user']; ?>';
		var codfic='<?php echo $_GET['codfic']; ?>';
		var parte='<?php echo $_GET['parte']; ?>';
		var numvez='<?php echo $_GET['numvez']; ?>';
	</script>
	<script type="text/javascript" src="js/VerAudConHum-v1.0.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" id="addscripts"></script>
	<script type="text/javascript">
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
		document.getElementById("th-h1-r").style.width=(document.getElementById("th-h1").offsetWidth+5)+"px";
		document.getElementById("th-h2-r").style.width=(document.getElementById("th-h2").offsetWidth-5)+"px";
		document.getElementById("table-main").addEventListener("scroll",function(){
			document.getElementById("table-head-active").style.top=document.getElementById("table-main").scrollTop+"px";
		});
		function validar_obs(dom){
			if (dom.value=="C") {
				document.getElementById("div-observacion").style.display="block";
			}else{
				document.getElementById("div-observacion").style.display="none";
				document.getElementById("idObservacion").value="";
			}
		}
		function volver_main(){
			window.location.href="IniciarAudAca.php?codfic="+codfic;
		}
		function correct_auditoria(){
			/*if (document.getElementById("idResultado").value=="R" &&
				document.getElementById("idObservacion").value=="") {
				alert
			}*/
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				data:{
					codfic:codfic,
					numvez:numvez,
					parte:parte,
					resultado:document.getElementById("idResultado").value,
					obs:document.getElementById("idObservacion").value
				},
				url:"config/updateResACH.php",
				success:function(data){
					console.log(data);
					alert(data.detail);
					$(".panelCarga").fadeOut(100);
				}
			});
		}
	</script>
</body>
</html>