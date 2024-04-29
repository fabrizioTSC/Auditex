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
		.btn-link{
			background: transparent;
			border: none;
			text-decoration: underline;
			color: #007eff;
			outline: none;
		}
		h4{
			margin: 5px 0;
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
			<div class="headerTitle">Calidad Interna</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="rowLine bodyPrimary">
				<div id="div-ctrl-detalle">	
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 70px;">Pedido</div>
							<div class="spaceIpt" style="width: calc(100% - 70px);">
								<div class="valueRequest" id="idpedido"><?php echo $_GET['pedido']; ?></div>
							</div>
						</div>
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 70px;">Color</div>
							<div class="spaceIpt" style="width: calc(100% - 70px);">
								<div class="valueRequest" id="idcolor"><?php echo $_GET['color']; ?></div>
							</div>
						</div>	
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
			</div>
			<div id="content-main" style="display: none;">	
				<div class="lineDecoration"></div>	
				<div class="lbl">Seleccione vez</div>
				<div style="width: 100%; overflow-x: scroll;margin-bottom: 5px;">
					<table style="min-width: 700px;">
						<tbody id="body-veces">
							<tr>
								<th>Parte</th>
								<th>Vez</th>
								<th>Estado</th>
								<th>Resultado</th>
								<th>Auditor</th>
								<th>Fec Inicio</th>
								<th>Fec Fin</th>
								<th>Cantidad</th>
								<th>AQL</th>
								<th>Can Def</th>
								<th>Max Def</th>
							</tr>
						</tbody>
					</table>
				</div>		
				<div style="width: 100%;overflow-x: scroll;margin-top: 5px;">
					<table style="min-width:500px;width: 100%;">
						<tbody id="tbl-det-defectos">
							<tr>
								<th>Familia</th>
								<th>Defecto</th>
								<th>Código Aux</th>
								<th>Cantidad</th>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="rowLineFlex" style="margin-top: 5px;">
					<div class="lblNew" style="width: 100px;">Resultado</div>
					<div class="spaceIpt" style="width: calc(100% - 100px);">
						<div class="valueRequest" id="idresultado"></div>
					</div>
				</div>
				<h4>Fotos cargadas</h4>
				<div class="table-fotos">
					<table>
						<thead>
							<tr>
								<th>Foto</th>
								<th>Observación</th>
								<th>Opción</th>
							</tr>
						</thead>
						<tbody id="body-fotos">
						</tbody>
					</table>
				</div>
			</div>
			<div style="margin-top: 5px;">
				<div class="lblNew" style="width: 100px;margin-right: 5px;">Observación:</div>
				<textarea style="padding: 5px;font-family: sans-serif;width: calc(100% - 12px);" id="idObservacion"></textarea>
			</div>
			<div class="lineDecoration"></div>
			<center>
				<button class="btnPrimary" onclick="window.history.back();" style="margin: auto;margin-top: 10px;">Volver</button>
			</center>
		</div>
	</div>
	<script type="text/javascript">
		var pedido='<?php echo $_GET['pedido']; ?>';
		var dsccol='<?php echo $_GET['color']; ?>';
		var parte='';
		var numvez='0';
		$(document).ready(function(){
			$("#defecto").keyup(function(){
				coddef_v='';
				var html='';
				for (var i = 0; i < ar_defectos.length; i++) {
					let des=ar_defectos[i].CODDEF+' - '+ar_defectos[i].DESDEF+' ('+ar_defectos[i].CODDEFAUX+')';
					if (des.toUpperCase().indexOf($("#defecto").val().toUpperCase())>=0) {
						html+='<div class="taller" onclick="select_defecto(\''+ar_defectos[i].CODDEF+'\',\''+des+'\')">'+des+'</div>';
					}
				}
				document.getElementById("tbl-defectos").innerHTML=html;
			});
			$.ajax({
				type:"POST",
				url:"config/getInfoCalIntAF.php",
				data:{
					pedido:pedido,
					dsccol:dsccol,
					numvez:numvez
				},
				success:function(data){
					console.log(data);
					parte=data.datos.PARTE;
					numvez=data.datos.NUMVEZ;
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
					document.getElementById("idparte").innerHTML=data.datos.PARTE;
					document.getElementById("idvez").innerHTML=data.datos.NUMVEZ;
					document.getElementById("idaql").innerHTML=data.datos.AQL+"% ("+data.datos.CANAUD+" prendas)";
					document.getElementById("idmaxdef").innerHTML=data.datos.CANDEFMAX;
					document.getElementById("idresultado").innerHTML=process_result(data.datos.RESULTADO);
					if (data.datos.FECINIAUD!=null) {
						document.getElementById("content-main").style.display="block";
						fill_defectos(data.defectos);
						fill_fotos(data.fotos);let html='';
						for (var i = 0; i < data.veces.length; i++) {
							html+=
							'<tr onclick="update_show_vez(\''+data.veces[i].PARTE+'\',\''+data.veces[i].NUMVEZ+'\',\''+data.veces[i].ESTADO+'\')">'+
								'<td>'+data.veces[i].PARTE+'</td>'+
								'<td>'+data.veces[i].NUMVEZ+'</td>'+
								'<td>'+data.veces[i].ESTADOTXT+'</td>'+
								'<td>'+val_null(data.veces[i].RESULTADOTXT)+'</td>'+
								'<td>'+data.veces[i].CODUSU+'</td>'+
								'<td>'+data.veces[i].FECINIAUD+'</td>'+
								'<td>'+val_null(data.veces[i].FECFINAUD)+'</td>'+
								'<td>'+data.veces[i].CANTIDAD+'</td>'+
								'<td>'+data.veces[i].AQL+'</td>'+
								'<td>'+data.veces[i].CANAUD+'</td>'+
								'<td>'+data.veces[i].CANDEFMAX+'</td>'+
							'</tr>';						
						}
						document.getElementById("body-veces").innerHTML+=html;
					}

					$(".panelCarga").fadeOut(100);
				}
			});
		});
		function val_null(text){
			if (text==null) {
				return '';
			}else{
				return text;
			}
		}
		function fill_fotos(data){
			let html='';
			for (var i = 0; i < data.length; i++) {
				html+=
				'<tr>'+
					'<td>'+
						'<div style="text-align: center;">'+
						'<img src="assets/imgcalint/'+data[i].RUTIMA+'">'+
						'</div>'+
					'</td>'+
					'<td>'+data[i].OBSIMAGEN+'</td>'+
					'<td></td>'+
				'</tr>';
			}
			document.getElementById("body-fotos").innerHTML=html;
		}
		var coddef_v='';
		function select_defecto(coddef,desdef){
			coddef_v=coddef;
			document.getElementById("defecto").value=desdef;
		}
		var ar_defectos=[];
		function get_defectos(){
			$.ajax({
				type:"POST",
				url:"config/getDefectos.php",
				success:function(data){
					console.log(data);
					ar_defectos=data.defectos;
					var html='';
					for (var i = 0; i < ar_defectos.length; i++) {
						let des=ar_defectos[i].CODDEF+' - '+ar_defectos[i].DESDEF+' ('+ar_defectos[i].CODDEFAUX+')';
						html+='<div class="taller" onclick="select_defecto(\''+ar_defectos[i].CODDEF+'\',\''+des+'\')">'+des+'</div>';
					}
					document.getElementById("tbl-defectos").innerHTML=html;
				}
			});	
		}
		function start_calint(){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				url:"config/startCalIntAF.php",
				data:{
					pedido:pedido,
					dsccol:dsccol,
					parte:parte,
					numvez:numvez
				},
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
		function add_defecto(){
			if (document.getElementById("idCanDef").value=="") {
				alert("Debe añadir una cantidad de defecto");
				return;
			}
			if (coddef_v=="") {
				alert("Debe seleccionar un defecto");
				return;
			}
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/saveDefCalIntAF.php',
				data:{
					pedido:pedido,
					dsccol:dsccol,
					parte:parte,
					numvez:numvez,
					coddef:coddef_v,
					candef:document.getElementById("idCanDef").value
				},
				success:function(data){
					console.log(data);
					if (!data.state) {
						alert(data.detail);
					}else{
						$("#defecto").val("");
						$("#defecto").keyup();
						$("#idCanDef").val("");
						fill_defectos(data.defectos);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function fill_defectos(data){
			let html=
			'<tr>'+
				'<th>Familia</th>'+
				'<th>Defecto</th>'+
				'<th>Código Aux</th>'+
				'<th>Cantidad</th>'+
			'</tr>';
			for (var i = 0; i < data.length; i++) {
				html+=
				'<tr>'+
					'<td>'+data[i].DESFAM+'</td>'+
					'<td>'+data[i].DESDEF+'</td>'+
					'<td>'+data[i].CODDEFAUX+'</td>'+
					'<td>'+
						'<div style="display:flex;">'+
							'<span style="padding:5px;">'+data[i].CANDEF+'</span>'+
						'</td>'+
					'</td>'+
				'</tr>';				
			}
			document.getElementById("tbl-det-defectos").innerHTML=html;
		}
		function update_def(value,coddef){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/updateDefCalIntAF.php',
				data:{
					pedido:pedido,
					dsccol:dsccol,
					parte:parte,
					numvez:numvez,
					coddef:coddef,
					candef:value
				},
				success:function(data){
					console.log(data);
					if (!data.state) {
						alert(data.detail);
					}else{
						fill_defectos(data.defectos);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function update_show_vez(parte,vez,estado){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				url:"config/updateInfoCalIntAF.php",
				data:{
					pedido:pedido,
					dsccol:dsccol,
					parte:parte,
					numvez:vez
				},
				success:function(data){
					console.log(data);
					fill_defectos(data.defectos);
					fill_fotos(data.fotos);
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function terminar_auditora(){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/endCalIntAF.php',
				data:{
					pedido:pedido,
					dsccol:dsccol,
					parte:parte,
					numvez:numvez
				},
				success:function(data){
					console.log(data);
					if (!data.state) {
						alert(data.detail);
					}else{
						document.getElementById("idestado").innerHTML=process_estado(data.ESTADO);
						document.getElementById("idresultado").innerHTML=process_result(data.RESULTADO);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function process_estado(text){
			if (text="P") {
				return "Pendiente";
			}else{
				return "Terminado";
			}
		}
		function process_result(text){
			switch (text){
				case 'A':return "APROBADO";
					break;
				case 'R':return "RECHAZADO";
					break;
				case 'C':return "APROBADO NO CONFORME";
					break;
				case '':return "";
					break;
				case null:return "";
					break;
				default:return text;
					break;
			}
		}
	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
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
	</script>
</body>
</html>