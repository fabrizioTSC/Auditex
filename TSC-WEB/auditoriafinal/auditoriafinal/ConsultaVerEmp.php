<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="15";
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
	<link rel="stylesheet" type="text/css" href="css/CheckListCorte-v1.0.css">
	<style type="text/css">
		.line-header{
			display: flex;
			width: calc(50% - 5px);
			margin-right: 5px;
		}
		.line-header label{
			font-weight: bold;
			margin-right: 5px;
		}
		.part-auditoria{
			width: calc(100% / 2);
		}
		.check-content {
		    background: #ccc;
		}
		.th-animate-col{
			background: #ccc;
			color: #000;
		}
		.th-animate-col-sel{
			background: #980f0f;
			color: #fff;
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
	<div class="mainContent" id="mainToScroll">
		<div class="headerContent">
			<div class="headerTitle">Auditoría de embalaje</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div id="idDetalle" style="display: block;margin-top: 5px;">
				<div style="display: flex;margin-bottom: 5px;">
					<div class="line-header">
						<label>Pedido:</label>
						<span id="pedido"><?php echo $_GET['pedido']; ?></span>
					</div>	
					<div class="line-header">
						<label>Color:</label>
						<span id="color"><?php echo $_GET['color']; ?></span>
					</div>
				</div>
				<div style="display: flex;margin-bottom: 5px;">
					<div class="line-header">
						<label>Cliente:</label>
						<span id="cliente"></span>
					</div>
					<div class="line-header">
						<label>P.O.:</label>
						<span id="po"></span>
					</div>
				</div>
				<div style="display: flex;margin-bottom: 5px;">
					<div class="line-header">
						<label>Est TSC:</label>
						<span id="esttsc"></span>
					</div>
					<div class="line-header">
						<label>Est Cliente:</label>
						<span id="estcli"></span>
					</div>
				</div>
				<div style="display: flex;margin-bottom: 5px;">
					<div class="line-header">
						<label>Auditor:</label>
						<span id="auditor"></span>
					</div>	
					<div class="line-header">
						<label>Estado:</label>
						<span id="estado"></span>
					</div>
				</div>
				<div style="display: flex;margin-bottom: 5px;">
					<div class="line-header">
						<label>Fec Inicio:</label>
						<span id="fecini"></span>
					</div>	
					<div class="line-header">
						<label>Fec Fin:</label>
						<span id="fecfin"></span>
					</div>
				</div>
				<div style="display: flex;margin-bottom: 5px;">
					<div class="line-header">
						<label>Num Cajas:</label>
						<span id="numcaj"></span>
					</div>	
					<div class="line-header">
						<label>Num Caj Aud:</label>
						<span id="numcajaud"></span>
					</div>
				</div>
				<div style="display: flex;margin-bottom: 5px;">
					<div class="line-header">
						<label style="width: 90px;">% Auditar:</label>
						<input id="poraud" type="number" style="width: calc(100% - 100px);padding: 5px;" />
					</div>
					<div class="line-header">
						<label>Cantidad:</label>
						<span id="cantidad"></span>
					</div>	
				</div>
			</div>
			<div class="btn-addrollo" onclick="animar_detalle()"><span id="btnContent">Ocultar detalle</span></div>
			<button class="btnPrimary" style="margin-top: 5px;" onclick="start_veremp()" id="btnstart">Iniciar</button>
			<div id="main-auditoria" style="display: none;">
				<div class="lineDecoration"></div>
				<div class="forms-content" id="form-1">
					<div class="lbl">1. Check List</div>
					<!--				
					<table>
						<tbody>
							<tr>
								<th class="th-animate-col" id="col-0" onclick="show_grupo(0)">TODOS</th>
								<th class="th-animate-col" id="col-1" onclick="show_grupo(1)">FOLDING</th>
								<th class="th-animate-col" id="col-2" onclick="show_grupo(2)">POLYBAG</th>
								<th class="th-animate-col" id="col-3" onclick="show_grupo(3)">TRIMS</th>
								<th class="th-animate-col" id="col-4" onclick="show_grupo(4)">CARTONS</th>
							</tr>
						</tbody>
					</table>
					<div style="display: flex;justify-content: flex-end;margin: 5px 0;">
						<h4 style="margin: 5px 0;margin-right: 5px;">TODOS</h4>
						<div style="display:flex;justify-content: center;">
							<div class="check-content">
								<div class="marker-check anicheblo" onclick="change_check_all(this)" id="check-0" data-cod="0" data-value="0">NO</div>
							</div>
						</div>
					</div>
					<div>
						<table>
							<thead>
								<tr>
									<th>Grupo</th>
									<th>Desc Inglés</th>
									<th>Descripción</th>
									<th>Validación</th>
								</tr>
							</thead>
							<tbody id="table-detalle-1">
								
							</tbody>
						</table>
					</div>
					<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="save_form1()" id="btngrachelis">Grabar</button>-->				
					<table>
						<tbody id="table-grupos">
							<tr>
								<th class="th-animate-col" id="col-0" onclick="show_grupo_dos(0)">TODOS</th>
								<th class="th-animate-col" id="col-1" onclick="show_grupo_dos(1)">FOLDING</th>
								<th class="th-animate-col" id="col-2" onclick="show_grupo_dos(2)">POLYBAG</th>
								<th class="th-animate-col" id="col-3" onclick="show_grupo_dos(3)">TRIMS</th>
								<th class="th-animate-col" id="col-4" onclick="show_grupo_dos(4)">CARTONS</th>
							</tr>
						</tbody>
					</table>
					<div style="display: flex;justify-content: flex-end;margin: 5px 0;">
						<h4 style="margin: 5px 0;margin-right: 5px;">TODOS</h4>
						<div style="display:flex;justify-content: center;">
							<div class="check-content">
								<div class="marker-check anicheblo" onclick="change_check_all_dos(this)" id="check-0" data-cod="0" data-value="0">NO</div>
							</div>
						</div>
					</div>
					<div style="width: 100%;overflow-x: scroll;">
						<table style="min-width: 600px;width: 100%;">
							<thead>
								<tr>
									<th>Tipo Avío</th>
									<th>Talla</th>
									<th>Código</th>
									<th>Descripción</th>
									<th>Valor</th>
								</tr>
							</thead>
							<tbody id="table-detalle-1-dos">
								
							</tbody>
						</table>
					</div>
				</div>
				<div class="forms-content" id="form-2" style="display: none;">
					<div class="lbl">2. Selección de Cajas</div>
					<div style="overflow-x: scroll;width: 100%;margin-bottom: 5px;">
						<table style="min-width: 600px;width: 100%;">
							<thead>
								<tr>
									<th>Vez</th>
									<th>Estado</th>
									<th>Resultado</th>
									<th>Usuario</th>
									<th>Fec Inicio</th>
									<th>Fec Fin</th>
									<th>Comentarios</th>
								</tr>
							</thead>
							<tbody id="table-detalle-vez">
								
							</tbody>
						</table>
					</div>
					<div style="display: flex;margin-bottom: 5px;">
						<label style="width: 90px;margin-top: 5px;"># Carton</label>
						<input type="number" id="ncarton" class="classIpt" style="padding: 5px;width: 120px;">
					</div>
					<div>
						<table>
							<thead>
								<tr>
									<th>N°</th>
									<th>#Carton (Ica)</th>
									<th>Size</th>
									<th>Quantity</th>
									<th>SKU</th>
									<th>Check Carton Sticker</th>
								</tr>
							</thead>
							<tbody id="table-detalle-2">
								
							</tbody>
						</table>
					</div>
				</div>
				<div class="forms-content" id="form-3" style="display: none;">
					<div class="lbl">3. Auditorar Cajas</h4>
					<div style="overflow-x: scroll;width: 100%;margin-bottom: 5px;">
						<table style="min-width: 600px;width: 100%;">
							<thead>
								<tr>
									<th>Vez</th>
									<th>Estado</th>
									<th>Resultado</th>
									<th>Usuario</th>
									<th>Fec Inicio</th>
									<th>Fec Fin</th>
									<th>Comentarios</th>
								</tr>
							</thead>
							<tbody id="table-detalle-vez-2">
								
							</tbody>
						</table>
					</div>
					<div style="display: flex;margin-top: 5px;">
						<label>Pendientes</label>
						<input type="checkbox" id="idpendiente" checked style="margin-bottom: 0px;">
					</div>
					<div style="overflow-x: scroll;margin-top: 5px;">
						<table>
							<thead>
								<tr>
									<th>Vez</th>
									<th>N PPL</th>
									<th>#Carton (Ica)</th>
									<th>Size</th>
									<th>Quantity</th>
									<th>SKU</th>
									<th>Check Carton Sticker</th>
									<th>Estado</th>
									<th>Resultado</th>
									<th>Auditor</th>
									<th>Fecha</th>
								</tr>
							</thead>
							<tbody id="table-detalle-3">
								
							</tbody>
						</table>
					</div>
					<div id="detalle-caja" style="display: none;">
						<h4 style="margin: 5px 0;">Detalle caja</h4>
						<div style="display: flex;margin-bottom: 10px;">
							<div class="line-header">
								<label>Caja:</label>
								<span id="numcajsel"></span>
							</div>	
							<div class="line-header">
								<label>Vez:</label>
								<span id="numcajvezsel"></span>
							</div>
						</div>
						<div style="overflow-x: scroll;margin-top: 5px;">
							<table>
								<thead>
									<tr>
										<th>Familia</th>
										<th>Defecto</th>
										<th>Código Aux</th>
										<th>Código</th>
										<th>Cantidad</th>
									</tr>
								</thead>
								<tbody id="table-detalle-4">
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="lineDecoration"></div>
				<label>Observación</label>
				<textarea style="width: calc(100% - 12px);padding: 5px;" id="obs"></textarea>
			</div>
		</div>
			<div class="lineDecoration"></div>
			<center>
			<button class="btnPrimary" style="margin-top: 5px;" onclick="window.history.back();">Volver</button>
			</center>
	</div>	
	<div class="content-parts-auditoria">
		<div class="body-parts-auditoria">
			<div class="part-auditoria part-active" id="redirect-1" onclick="show_form(1)">
				<div class="number-part">1</div>
				<div class="label-part">Check List</div>
			</div>
			<div class="part-auditoria" id="redirect-2" onclick="show_form(2)">
				<div class="number-part">2</div>
				<div class="label-part">Selección de Cajas</div>
			</div>
			<div class="part-auditoria" id="redirect-3" onclick="show_form(3)">
				<div class="number-part">3</div>
				<div class="label-part">Auditar Cajas</div>
			</div>
		</div>	
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		var pedido="<?php echo $_GET['pedido']; ?>";
		var color="<?php echo $_GET['color']; ?>";
		var numvez="0";
		var parte="1";
		var ar_cajas=[];
		var ar_defectos=[];
		var audter_v=false;
		var allow_edit=true;
		$(document).ready(function(){
			$("#ncarton").keyup(function(e){
				let html='';
				for (var i = 0; i < ar_cajas.length; i++) {
					if(ar_cajas[i].NROCAJAERP.indexOf($("#ncarton").val())>=0){
						html+=
							'<tr onclick="add_box('+ar_cajas[i].NROCAJAERP+')">'+
								'<td>'+ar_cajas[i].NROCAJAPPL+'</td>'+
								'<td>'+ar_cajas[i].NROCAJAERP+'</td>'+
								'<td>'+ar_cajas[i].DESTAL+'</td>'+
								'<td>'+ar_cajas[i].CANTIDAD+'</td>'+
								'<td>'+validar_null(ar_cajas[i].SKU)+'</td>'+
								'<td>'+ar_cajas[i].DIRECCION+'</td>'+
							'</tr>';
					}
				}
				$("#table-detalle-2").empty();
				$("#table-detalle-2").append(html);
			});
			$("#defecto").keyup(function(e){
				let html='';
				for (var i = 0; i < ar_defectos.length; i++) {
					let des=ar_defectos[i].DESFAM+' - '+ar_defectos[i].DESDEF+' ('+ar_defectos[i].CODDEFAUX+')';
					if(des.toUpperCase().indexOf($("#defecto").val().toUpperCase())>=0){
						html+='<div class="taller" onclick="select_defecto(\''+ar_defectos[i].CODDEF+'\',\''+des+'\')">'+des+'</div>'
					}
				}
				$("#tbl-defectos").empty();
				$("#tbl-defectos").append(html);
				coddef_v='';
			});
			let estado='0';
			if (document.getElementById("idpendiente").checked) {
				estado='P';
			}
			$("#idpendiente").click(function(){
				document.getElementById("detalle-caja").style.display="none";
				let estado='0';
				if (document.getElementById("idpendiente").checked) {
					estado='P';
				}
				$(".panelCarga").fadeIn(100);
				$.ajax({
					type:'POST',
					url:'config/getCajAudEstAF.php',
					data:{
						pedido:pedido,
						color:color,
						numvez:numvez,
						parte:parte,
						estado:estado
					},
					success:function(data){
						console.log(data);
						if (data.state) {
							fill_cajasaud(data.cajasaud);
						}else{
							alert(data.detail);
						}
						$(".panelCarga").fadeOut(100);
					},
				    error: function (jqXHR, exception) {
				        var msg = get_msg_error(jqXHR, exception);
				        alert(msg);
				        $(".panelCarga").fadeOut(200);
				    }
				});
			});
			$.ajax({
				type:'POST',
				url:'config/getVerEmpAF.php',
				data:{
					pedido:pedido,
					color:color,
					numvez:numvez,
					parte:parte,
					estado:estado
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						numvez=data.NUMVEZ
						$("#cliente").text(data.DESCLI);
						$("#po").text(data.PO);
						$("#esttsc").text(data.ESTTSC);
						$("#estcli").text(data.ESTCLI);
						$("#auditor").text(data.CODUSU);
						$("#estado").text(data.ESTADO);
						$("#fecini").text(data.FECINIAUD);
						$("#fecfin").text(data.FECFINAUD);
						$("#numcaj").text(data.NUMCAJPEDCOL);
						$("#numcajaud").text(data.NUMCAJAUD);
						$("#numcajaud").text(data.NUMCAJAUD);
						$("#cantidad").text(data.CANTIDAD);
						$("#poraud").val(data.PORAUD);
						if (data.audter) {
							$("#btnendaud").remove();
							$("#btngrachelis").remove();
							audter_v=true;
						}
						if (!data.btnstart) {
							document.getElementById("main-auditoria").style.display="block";
							$("#btnstart").remove();

							let html='';
							for (var i = 0; i < data.veces.length; i++) {
								html+=
								'<tr onclick="update_vez(\''+data.veces[i].NUMVEZ+'\',\''+data.veces[i].ESTADO+'\')">'+
									'<td>'+data.veces[i].NUMVEZ+'</td>'+
									'<td>'+data.veces[i].ESTADO+'</td>'+
									'<td>'+validar_null(data.veces[i].RESULTADO)+'</td>'+
									'<td>'+data.veces[i].CODUSU+'</td>'+
									'<td>'+data.veces[i].FECINIAUD+'</td>'+
									'<td>'+validar_null(data.veces[i].FECFINAUD)+'</td>'+
									'<td>'+data.veces[i].COMENTARIOS+'</td>'+
								'</tr>';
							}
							$("#table-detalle-vez").empty();
							$("#table-detalle-vez").append(html);
							$("#table-detalle-vez-2").empty();
							$("#table-detalle-vez-2").append(html);

							html='<tr>';
							for (var i = 0; i < data.grupos.length; i++) {
								html+='<th class="th-animate-col" id="col-'+data.grupos[i].CODGRPCLPRO+'" onclick="show_grupo_dos('+data.grupos[i].CODGRPCLPRO+')">'+data.grupos[i].DESGRPCLPRO+'</th>';
							}
							html+='</tr>';
							$("#table-grupos").empty();
							$("#table-grupos").append(html);

							html='';
							ar_defectos=data.defectos;
							for (var i = 0; i < ar_defectos.length; i++) {
								let des=ar_defectos[i].DESFAM+' - '+ar_defectos[i].DESDEF+' ('+ar_defectos[i].CODDEFAUX+')';
								html+='<div class="taller" onclick="select_defecto(\''+ar_defectos[i].CODDEF+'\',\''+des+'\')">'+des+'</div>'
							}
							$("#tbl-defectos").append(html);
							
							fill_cajas(data.cajas);
							fill_cajasaud(data.cajasaud);
						}
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				},
			    error: function (jqXHR, exception) {
			        var msg = get_msg_error(jqXHR, exception);
			        alert(msg);
			        $(".panelCarga").fadeOut(200);
			    }
			});
		});
		function save_defecto2(){
			if (coddef_v=='') {
				alert("Debe seleccionar un defecto");
				return;
			}
			if ($("#numdef").val()=="") {
				alert("Debe añadir una cantidad");
				return;
			}
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/addDefCajErpVerEmpAF.php',
				data:{
					pedido:pedido,
					color:color,
					numvez:numvez,
					parte:parte,
					numcajerp:caja_v,
					numvezcaj:vez_v,
					coddef:coddef_v,
					candef:$("#numdef").val(),
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						fill_defectos(data.detalle_defecto);
						coddef_v='';
						$("#numdef").val("");
						$("#defecto").val("");
						$("#defecto").keyup();
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function update_vez(vez,estado){
			document.getElementById("detalle-caja").style.display="none";
			let estado_check='0';
			if (document.getElementById("idpendiente").checked) {
				estado_check='P';
			}
			$(".panelCarga").fadeIn(100);
			numvez=vez;
			$.ajax({
				type:'POST',
				url:'config/getVezCajasVerEmpAF.php',
				data:{
					pedido:pedido,
					color:color,
					numvez:vez,
					parte:parte,
					estado:estado_check
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						fill_cajas(data.cajas);
						fill_cajasaud(data.cajasaud);
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function end_auditoria(){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/endVerEmpAF.php',
				data:{
					pedido:pedido,
					color:color,
					numvez:numvez,
					parte:parte,
					numcajaud:$("#numcajaud").text(),
					obs:$("#obs").val()
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
		function add_box(id){
		}
		var coddef_v='';
		function select_defecto(coddef,des){
			$("#defecto").val(des);
			coddef_v=coddef;
		}
		function fill_cajas(data){
			let html='';
			ar_cajas=data;
			for (var i = 0; i < ar_cajas.length; i++) {
				html+=
				'<tr onclick="add_box('+ar_cajas[i].NROCAJAERP+')">'+
					'<td>'+ar_cajas[i].NROCAJAPPL+'</td>'+
					'<td>'+ar_cajas[i].NROCAJAERP+'</td>'+
					'<td>'+ar_cajas[i].DESTAL+'</td>'+
					'<td>'+ar_cajas[i].CANTIDAD+'</td>'+
					'<td>'+validar_null(ar_cajas[i].SKU)+'</td>'+
					'<td>'+ar_cajas[i].DIRECCION+'</td>'+
				'</tr>';
			}
			$("#table-detalle-2").empty();
			$("#table-detalle-2").append(html);
		}
		function fill_cajasaud(data){
			let html='';
			for (var i = 0; i < data.length; i++) {
				html+=
				'<tr onclick="select_caja(\''+data[i].NUMVEZCAJA+'\',\''+data[i].NRO_CAJA_ERP+'\',\''+data[i].ESTADO+'\',\''+validar_null(data[i].RESULTADO)+'\')">'+
					'<td>'+data[i].NUMVEZCAJA+'</td>'+
					'<td>'+data[i].NROCAJAPPL+'</td>'+
					'<td>'+data[i].NRO_CAJA_ERP+'</td>'+
					'<td>'+data[i].DESTAL+'</td>'+
					'<td>'+data[i].CANTIDAD+'</td>'+
					'<td>'+validar_null(data[i].SKU)+'</td>'+
					'<td>'+data[i].DIRECCION+'</td>'+
					'<td>'+data[i].ESTADO+'</td>'+
					'<td>'+validar_null(data[i].RESULTADO)+'</td>'+
					'<td>'+data[i].CODUSU+'</td>'+
					'<td>'+validar_null(data[i].FECFIN)+'</td>'+
				'</tr>';								
			}
			$("#table-detalle-3").empty();
			$("#table-detalle-3").append(html);
		}
		function fill_defectos(data){
			let html='';
			for (var i = 0; i < data.length; i++) {
				html+=
				'<tr>'+
					'<td>'+data[i].DESFAM+'</td>'+
					'<td>'+data[i].DESDEF+'</td>'+
					'<td>'+data[i].CODDEFAUX+'</td>'+
					'<td>'+data[i].CODDEF+'</td>'+
					'<td>'+data[i].CANDEF+'</td>'+
				'</tr>';								
			}
			$("#table-detalle-4").empty();
			$("#table-detalle-4").append(html);
		}
		var vez_v='';
		var caja_v='';
		function select_caja(vez,caja,estado,resultado){
			$("#numcajsel").text(caja);
			$("#numcajvezsel").text(vez);
			vez_v=vez;
			caja_v=caja;
			document.getElementById("detalle-caja").style.display="block";
			/*
			if (resultado=="" ||resultado=="A") {
				$("#rescaj").val("A");
			}else{
				$("#rescaj").val("R");
			}*/
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/getDefCajAudVerEmpAF.php',
				data:{
					pedido:pedido,
					color:color,
					numvez:numvez,
					parte:parte,
					numcajerp:caja,
					numvezcaj:vez
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						fill_defectos(data.detalle_defecto);
					}else{
						alert(data.detail);
					}
					document.getElementById("detalle-caja").style.display="block";
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function update_cajaaud(){
			let resultado='A';
			if (document.getElementById("table-detalle-4").innerHTML!="") {
				resultado='R';
			}
			let estado='0';
			if (document.getElementById("idpendiente").checked) {
				estado='P';
			}
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/updateCajAudVerEmpAF.php',
				data:{
					pedido:pedido,
					color:color,
					numvez:numvez,
					parte:parte,
					numcajerp:caja_v,
					numvezcaj:vez_v,
					resultado:resultado,
					estado:estado
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						fill_cajasaud(data.cajasaud);
						document.getElementById("detalle-caja").style.display="none";
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function validar_null(text){
			if (text==null) {
				return "";
			}else{
				return text;
			}
		}
		function show_form(num_form){
			var validar=true;
			/*
			var validar=false;
			var i=0;
			while(i<ar_allow_forms.length){
				if (ar_allow_forms[i]==num_form) {
					validar=true;
				}
				i++;
			}*/
			if (validar) {
				$(".forms-content").css("display","none");
				$("#form-"+num_form).css("display","block");
				var array=document.getElementsByClassName("part-auditoria");
				for (var i = 0; i < array.length; i++) {
					array[i].classList.remove("part-active");
				}
				document.getElementById("redirect-"+num_form).classList.add("part-active");
			}else{
				alert("Bloque no disponible!");
			}
		}
		function change_check(dom){
			var text=dom.innerHTML;
			if (text=="NO") {
				text="SI";
				dom.dataset.value="1";
				dom.style.left="20px";
				dom.style.background="#55840b";
			}else{
				dom.style.background="#980f0f";
				text="NO";
				dom.dataset.value="0";
				dom.style.left="0px";
			}
			dom.innerHTML=text;
		}
		function change_check_all(dom){
			var text=dom.innerHTML;
			if (text=="NO") {
				text="SI";
				dom.dataset.value="1";
				dom.style.left="20px";
				dom.style.background="#55840b";
			}else{
				dom.style.background="#980f0f";
				text="NO";
				dom.dataset.value="0";
				dom.style.left="0px";
			}
			dom.innerHTML=text;
			let ar=document.getElementsByClassName("anicheblo");
			for (var i = 1; i < ar.length; i++) {
				let id=ar[i].id.replace("cheblo3-","");
				if(document.getElementById("fila-lleva-"+id).style.display!="none"){
					if (ar[i].innerHTML!=text) {
						change_check(ar[i]);
					}
				}
			}
		}
		function change_check_all_dos(dom){
			var text=dom.innerHTML;
			if (text=="NO") {
				text="SI";
				dom.dataset.value="1";
				dom.style.left="20px";
				dom.style.background="#55840b";
			}else{
				dom.style.background="#980f0f";
				text="NO";
				dom.dataset.value="0";
				dom.style.left="0px";
			}
			dom.innerHTML=text;
			let ar=document.getElementsByClassName("anicheblo");
			for (var i = 1; i < ar.length; i++) {
				if (ar[i].innerHTML!=text) {
					change_check(ar[i]);
				}
			}
		}
		function animar_detalle(){
			var display=$("#idDetalle").css("display");
			if (display=="block") {
				$("#idDetalle").fadeOut(100);
				$("#btnContent").text("Mostrar detalle");
				$("#idTabApa").css("max-height","calc(100vh - 233px)");
			}else{
				$("#idDetalle").fadeIn(100);
				$("#btnContent").text("Ocultar detalle");
				$("#idTabApa").css("max-height","calc(100vh - 506px)");
			}
		}
		function hide_miniform(id){
			$("#"+id).fadeOut(200);
			if (id=="modal-form2") {
				$("#idWordDefecto").val("");
				$("#idWordDefecto").keyup();
				coddef_v="";
			}
		}		
		function close_modal(id){
			$("#"+id).fadeOut(100);
		}
		function volver_inicio(){
			window.location.href="IniciarAudAca.php?codfic="+codfic;
		}
		function start_veremp(){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/startVerEmpAF.php',
				data:{
					pedido:pedido,
					color:color,
					numvez:numvez,
					parte:parte,
					poraud:$("#poraud").val()
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
		function save_form1(){
			let ar=document.getElementsByClassName("anicheblo");
			let ar_send=[];
			for (var i = 0; i < ar.length; i++) {
				if (ar[i].dataset.cod!="0") {
					let aux=[];
					aux.push(ar[i].dataset.cod);
					aux.push(ar[i].dataset.value);
					ar_send.push(aux);
				}
			}
			console.log(ar_send);
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/saveVerEmp1AF.php',
				data:{
					pedido:pedido,
					color:color,
					numvez:numvez,
					parte:parte,
					array:ar_send
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						show_form(2);
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}		

		function save_form1_dos(){
			let ar=document.getElementsByClassName("anicheblo");
			let ar_send=[];
			for (var i = 0; i < ar.length; i++) {
				if (ar[i].dataset.cod!="0") {
					let aux=[];
					aux.push(ar[i].dataset.cod);
					aux.push(ar[i].dataset.value);
					ar_send.push(aux);
				}
			}
			console.log(ar_send);
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/saveVerEmp1AF-v2.php',
				data:{
					pedido:pedido,
					color:color,
					numvez:numvez,
					parte:parte,
					array:ar_send
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						//show_form(2);
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}		
		function show_grupo(id){
			let ar1=document.getElementsByClassName("th-animate-col");
			for (var i = 0; i < ar1.length; i++) {
				ar1[i].classList.remove("th-animate-col-sel");
			}
			document.getElementById("col-"+id).classList.add("th-animate-col-sel");
			let ar=document.getElementsByClassName("fila-val");
			if (id==0) {
				for (var i = 0; i < ar.length; i++) {
					ar[i].style.display="table-row";
				}
			}else{
				for (var i = 0; i < ar.length; i++) {
					if(ar[i].dataset.codgrp==id){
						ar[i].style.display="table-row";
					}else{
						ar[i].style.display="none";
					}
				}
			}
		}
		function show_grupo_dos(id){
			let ar1=document.getElementsByClassName("th-animate-col");
			for (var i = 0; i < ar1.length; i++) {
				ar1[i].classList.remove("th-animate-col-sel");
			}
			document.getElementById("col-"+id).classList.add("th-animate-col-sel");
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/getGruChkLisVerEmp.php',
				data:{
					pedido:pedido,
					color:color,
					numvez:numvez,
					parte:parte,
					cod:id
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						let html='';
						for (var i = 0; i < data.chklis.length; i++) {
							html+=
							'<tr>'+
								'<td>'+data.chklis[i].TIPOAVIO+'</td>'+
								'<td>'+data.chklis[i].TALLA+'</td>'+
								'<td>'+data.chklis[i].CODAVIO+'</td>'+
								'<td>'+data.chklis[i].DESGRPCLPRO+'</td>'+
								'<td>'+
									'<div class="check-content" id="aca-cheblo3-'+data.chklis[i].CODAVIO+'">'+
										'<div class="marker-check anicheblo" onclick="change_check(this)" data-cod="'+data.chklis[i].CODAVIO+'" id="cheblo3-'+data.chklis[i].CODAVIO+'" data-value="0">NO</div>'+
									'</div>'+
								'</td>'+
							'</tr>';							
						}						
						document.getElementById("table-detalle-1-dos").innerHTML=html;

						for (var i = 0; i < data.chklis.length; i++) {
							if(data.chklis[i].VALOR=="1"){
								change_check(document.getElementById("cheblo3-"+data.chklis[i].CODAVIO));
							}
						}
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
	</script>
</body>
</html>