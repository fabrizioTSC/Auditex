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
<body>
	<?php contentMenu();?>
	<div class="panelCarga" style="display: block;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Control de Humedad Rechazado</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="rowLine bodyPrimary">
				<div id="div-ctrl-detalle">	
					<div class="rowLineFlex">	
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 100px;">Pedido</div>
							<div class="spaceIpt" style="width: calc(100% - 100px);">
								<div class="valueRequest" id="idpedido"><?php echo $_GET['pedido']; ?></div>
							</div>
						</div>
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 100px;">Color</div>
							<div class="spaceIpt" style="width: calc(100% - 100px);">
								<div class="valueRequest" id="idcolor"><?php echo $_GET['color']; ?></div>
							</div>
						</div>	
					</div>
					<div class="rowLineFlex">	
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 100px;">Cliente</div>
							<div class="spaceIpt" style="width: calc(100% - 100px);">
								<div class="valueRequest" id="idcliente"></div>
							</div>
						</div>	
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 100px;">P.O.</div>
							<div class="spaceIpt" style="width: calc(100% - 100px);">
								<div class="valueRequest" id="idpo"></div>
							</div>
						</div>
					</div>
					<div class="rowLineFlex">	
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 100px;">Est TSC</div>
							<div class="spaceIpt" style="width: calc(100% - 100px);">
								<div class="valueRequest" id="idesttsc"></div>
							</div>
						</div>
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 100px;">Est Cli</div>
							<div class="spaceIpt" style="width: calc(100% - 100px);">
								<div class="valueRequest" id="idestcli"></div>
							</div>
						</div>		
					</div>
					<div class="rowLineFlex">	
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 100px;">Auditor</div>
							<div class="spaceIpt" style="width: calc(100% - 100px);">
								<div class="valueRequest" id="idauditor"></div>
							</div>
						</div>
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 100px;">Estado</div>
							<div class="spaceIpt" style="width: calc(100% - 100px);">
								<div class="valueRequest" id="idestado"></div>
							</div>
						</div>		
					</div>
					<div class="rowLineFlex">	
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 100px;">Fec Ini</div>
							<div class="spaceIpt" style="width: calc(100% - 100px);">
								<div class="valueRequest" id="idfecini"></div>
							</div>
						</div>
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 100px;">Fec Fin</div>
							<div class="spaceIpt" style="width: calc(100% - 100px);">
								<div class="valueRequest" id="idfecfin"></div>
							</div>
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
						<div class="lblNew" style="width: 100px;margin-right: 5px;">Prenda</div>
						<div class="spaceIpt" style="width: calc(100% - 100px);">
							<div class="valueRequest" id="idprenda"></div>
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
				<div style="display: flex">
					<div class="rowLineFlex">
						<div class="lblNew" style="width: 100px;margin-right: 5px;">Humedad Max.:</div>
						<div class="spaceIpt" style="width: calc(100% - 100px);">
							<input type="number" id="idHumMax" disabled class="iptSpecial">
						</div>
					</div>
				</div>
				<button class=btn-link id="btn-detalle" onclick="ctrl_header()">Ocultar detalles</button>
				<!--
				<center>
					<button class="btnPrimary" onclick="guardar_datos_cabecera()" style="margin-top: 5px;">Guardar Datos</button>
				</center>-->
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
						<select id="idResultado" class="classCmbBox" style="width: calc(100% - 12px);">
							<option value="C">Aprobado no conforme</option>
							<option value="R">Rechazado</option>
						</select>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 100px;margin-right: 5px;">Promedio:</div>
					<div class="spaceIpt" style="width: 80px;">
						<input type="number" id="idPromedio" class="iptSpecial">
					</div>
				</div>
			</div>
			<!--
			<center>
				<button class="btnPrimary" onclick="guardar_humedad()" style="margin: auto;margin-top: 10px;">Guardar</button>
			</center>-->
			<div style="margin-top: 5px;" id="div-observacion">
				<div class="lblNew" style="width: 100px;margin-right: 5px;">Observación:</div>
				<textarea style="padding: 5px;font-family: sans-serif;width: calc(100% - 12px);" id="idObservacion"></textarea>
			</div>
			<div class="lblNew">Cargar imagen</div>
			<input type="file" id="idrutima" onchange="show_image()" accept="image/*">
			<br>
			<img id="idshowima" style="max-width: 400px; width: 100%;margin: 5px auto;"><br>
			<button class="btnPrimary" onclick="delete_img()" id="btn-del">Eliminar imagen</button>
			<div class="lineDecoration"></div>
			<center>
				<button class="btnPrimary" onclick="terminar_auditora_eje()" style="margin: auto;margin-top: 10px;">Terminar</button>
				<button class="btnPrimary" onclick="window.history.back();" style="margin: auto;margin-top: 10px;">Volver</button>
			</center>
		</div>
	</div>
	<script type="text/javascript">
		var pedido='<?php echo $_GET['pedido']; ?>';
		var dsccol='<?php echo $_GET['color']; ?>';
	</script>
	<script type="text/javascript">
		function show_image(){
			$(".panelCarga").fadeIn(100);
			let img=document.getElementById("idrutima").files[0];
			var reader=new FileReader();
		    reader.onload = function(){
			    let fd=new FormData();
			    fd.append('pedido',pedido);
			    fd.append('dsccol',dsccol);
			    fd.append('file',img);
			    let request=new XMLHttpRequest();
			    request.open('POST','config/saveImgConHum.php',true);
			    request.onload=function(){
			    	if (request.status==200) {
			    		if (request.responseText=="1") {
			    			alert("Imagen guardada");
							window.location.reload();
			    		}else{
			    			alert("No se pudo guardar la imagen");
			    		}
						$(".panelCarga").fadeOut(100);
			    	}
			    }
			    request.send(fd);
		    };
		    reader.readAsDataURL(img);
		}
		function delete_img(){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				data:{
					pedido:pedido,
					dsccol:dsccol
				},
				url:"config/deleteImgConHumAF.php",
				success:function(data){
					console.log(data);
					if (data.state) {
						window.location.reload();
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
$(document).ready(function(){
	$.ajax({
		type:"POST",
		data:{
			pedido:pedido,
			dsccol:dsccol
		},
		url:"config/getDetFicConHumAF.php",
		success:function(data){
			console.log(data);
			if (data.state) {
				document.getElementById("idcliente").innerHTML=data.datos.DESCLI;
				document.getElementById("idpo").innerHTML=data.datos.PO;
				document.getElementById("idesttsc").innerHTML=data.datos.ESTTSC;
				document.getElementById("idestcli").innerHTML=data.datos.ESTCLI;
				document.getElementById("idauditor").innerHTML=data.datos.CODUSU;
				document.getElementById("idestado").innerHTML=data.datos.ESTADO;
				document.getElementById("idfecini").innerHTML=data.datos.FECINIAUD;
				document.getElementById("idfecfin").innerHTML=data.datos.FECFINAUD;
				document.getElementById("idcantidad").innerHTML=data.datos.CANTIDAD;
				document.getElementById("idprenda").innerHTML=data.datos.PRENDA;
				document.getElementById("idTemAmb").value=data.datos.TEMAMB;
				document.getElementById("idHumAmb").value=data.datos.HUMAMB;
				document.getElementById("idHumMax").value=data.datos.HUMMAX;
				document.getElementById("idPromedio").value=data.datos.HUMPRO;
				document.getElementById("idResultado").value=data.datos.RESULTADO;
				document.getElementById("idObservacion").value=data.datos.OBSERVACION;
				if (data.datos.RUTIMA!="") {
					document.getElementById("idshowima").src="assets/imgconhum/"+data.datos.RUTIMA;
				}else{
					document.getElementById("btn-del").remove();
				}

				let html='';
				for (var i = 0; i < data.detalle_humedad.length; i++) {
					html+=
					'<tr>'+
						'<td><input type="number" value="'+data.detalle_humedad[i].IDREG+'" disabled></td>'+
						'<td><input class="class-humedad" data-idreg="'+data.detalle_humedad[i].IDREG+'" type="number" value="'+function_process_num(data.detalle_humedad[i].HUMEDAD)+'"></td>'+
					'</tr>';
				}
				document.getElementById("table-humedad").innerHTML=html;
			}else{
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(300);
		}
	});
});

function function_process_num(humedad){
	if (humedad==0) {
		return "";
	}else{
		return humedad;
	}
}

$(document).ready(function(){
	$("#iddefecto").keyup(function(){
		coddef_var="";
		desdef_var="";
		$("#tbldefectos").empty();
		var html="";
		var busqueda=document.getElementById("iddefecto").value;
		for (var i = 0; i < listaDefectos.length; i++) {
			if ((listaDefectos[i].desdef.toUpperCase()+
				listaDefectos[i].coddef.toUpperCase()+
				listaDefectos[i].coddefaux.toUpperCase()
				).indexOf(busqueda.toUpperCase())>=0) {
				html+='<div class="defecto" '+
				'onclick="addDefecto(\''+listaDefectos[i].desdef+'\',\''+listaDefectos[i].coddefaux+'\','+listaDefectos[i].coddef+')">'
				+listaDefectos[i].desdef+' ('+listaDefectos[i].coddefaux+')</div>';
			}
		}
		$("#tbldefectos").append(html);
	});
});

let desdef_var="";
let coddefaux_var="";
let coddef_var="";

function guardar_humedad(){
	let ar=document.getElementsByClassName("class-humedad");
	let ar_send=[];
	for (var i = 0; i < ar.length; i++) {
		let aux=[];
		aux.push(ar[i].dataset.idreg);
		if (ar[i].value!="") {
			aux.push(Math.round(parseFloat(ar[i].value)*100));
		}else{
			aux.push(0);
		}		
		ar_send.push(aux);
	}
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		data:{
			pedido:pedido,
			dsccol:dsccol,
			array:ar_send
		},
		url:"config/saveDetHumConHumAF.php",
		success:function(data){
			if(!data.state){
				alert(data.detail);
			}else{				
				document.getElementById("idResultado").value=data.RESULTADO;
				document.getElementById("idPromedio").value=data.HUMPRO;
			}
			$(".panelCarga").fadeOut(100);
		}
	});
}

function terminar_auditora(){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		data:{
			pedido:pedido,
			dsccol:dsccol,
			res:document.getElementById("idResultado").value,
			obs:document.getElementById("idObservacion").value
		},
		url:"config/endFicConHumAF.php",
		success:function(data){
			console.log(data);
			alert(data.detail);
			$(".panelCarga").fadeOut(100);
		}
	});
}

function terminar_auditora_eje(){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		data:{
			pedido:pedido,
			dsccol:dsccol,
			res:document.getElementById("idResultado").value,
			obs:document.getElementById("idObservacion").value
		},
		url:"config/endFicConHumEjeAF.php",
		success:function(data){
			console.log(data);
			alert(data.detail);
			$(".panelCarga").fadeOut(100);
		}
	});
}

function val_u(text){
	if (text==undefined || text==null) {
		return "-";
	}else{
		return text;
	}
}

function guardar_datos_cabecera(){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		data:{
			pedido:pedido,
			dsccol:dsccol,
			temamb:Math.round(parseFloat(document.getElementById("idTemAmb").value)*100),
			humamb:Math.round(parseFloat(document.getElementById("idHumAmb").value)*100)
		},
		url:"config/saveDetTemHumConHumAF.php",
		success:function(data){
			if(!data.state){
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(100);
		}
	});
}
	</script>
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
	</script>
</body>
</html>