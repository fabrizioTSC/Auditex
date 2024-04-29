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
		h4{
			margin: 5px 0;
		}
		input[type="checkbox"] {
			margin: 0;
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
			<div class="headerTitle">Verificado de Empaque</div>
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
			</div>
			<div class="btn-addrollo" onclick="animar_detalle()"><span id="btnContent">Ocultar detalle</span></div>
			<button class="btnPrimary" style="margin-top: 5px;" onclick="start_veremp()" id="btnstart">Iniciar</button>
			<div id="main-auditoria" style="display: none;">
				<div class="lineDecoration"></div>
				<div class="forms-content" id="form-1" style="display: block;">
					<div class="lbl">1. Packing List</div>
					<div style="margin-bottom: 5px;">
						<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="refresh_lista()">Mostrar</button>
					</div>
					<div style="margin-bottom: 5px;width: 100%;overflow-x: scroll;">
						<table style="min-width: 800px;">
							<thead>
								<tr>
									<th>N°</th>
									<th># Carton (Ica)</th>
									<th>Size</th>
									<th>Total</th>
									<th>Quantity</th>
									<th>SKU</th>
									<th>Check Carton Sticker</th>
									<th>Lote</th>
									<th>Llenado</th>
									<th>Almacén</th>
									<th>Caj Sel Aud</th>
								</tr>
							</thead>
							<tbody id="table-detalle-paclis">
								
							</tbody>
						</table>
					</div>
				</div>
				<div class="forms-content" id="form-2" style="display: none;">
					<div class="lbl">2. Check List</div>					
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
					<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="save_form1()" id="btngrachelis">Grabar</button>
				</div>
				<div class="forms-content" id="form-3" style="display: none;">
					<div class="lbl">3. Crear lote</div>
					<!--
					<h4>Lotes</h4>
					<div style="margin-bottom: 5px;width: 100%;overflow-x: scroll;">
						<table style="min-width: 600px;">
							<thead>
								<tr>
									<th>Lote</th>
									<th>Vez</th>
									<th>Célula</th>
									<th># Cajas</th>
									<th># Caj Aud</th>
									<th>Estado</th>
									<th>Resultado</th>
									<th>Usuario</th>
									<th>Fec Inicio</th>
									<th>Fec Fin</th>
								</tr>
							</thead>
							<tbody id="table-detalle-lotes">
								
							</tbody>
						</table>
					</div>-->
					<h4>Cajas disponibles</h4>
					<div style="display: flex;">
						<label style="width: 90px;margin-top: 5px;"># Carton</label>
						<input type="number" id="ncarton" class="classIpt" style="padding: 5px;width: 120px;">
					</div>
					<div style="display: flex;justify-content: flex-end;margin-bottom: 5px;">
						<h4>TODOS</h4>
						<input type="checkbox" onclick="change_all_check(this)" style="margin: 5px;">
					</div>
					<div style="margin-bottom: 5px;">
						<table>
							<thead>
								<tr>
									<th>N°</th>
									<th>#Carton (Ica)</th>
									<th>Size</th>
									<th>TOTAL</th>
									<th>Quantity</th>
									<th>SKU</th>
									<th>Check Carton Sticker</th>
									<th>Sel.</th>
								</tr>
							</thead>
							<tbody id="table-detalle-2">
								
							</tbody>
						</table>
					</div>
					<div style="display: flex;margin-bottom: 5px;" id="div-add-lote">
						<label style="width: 120px;margin-top: 5px;">Can Cajas disp:</label>
						<input type="number" id="cancajdis" class="classIpt" style="padding: 5px;width: 90px;" disabled>
					</div>
					<div class="sameLine">
						<div class="lbl" style="width: 120px;">Célula:</div>
						<div class="spaceIpt" style="width: calc(100% - 120px);">
							<input type="text" id="idcelula" class="classIpt" style="height: auto;padding: 5px;">
						</div>
					</div>
					<div class="tblSelection" id="table-celula" style="margin-bottom: 5px;">
					</div>
					<button class="btnPrimary" style="margin-bottom: 5px;" onclick="add_lote()">Crear lote</button>
				</div>
				<div class="forms-content" id="form-4" style="display: none;">
					<div class="lbl">4. Seleccion de cajas</div>
					<h4>Seleccione un lote:</h4>
					<div style="margin-bottom: 5px;width: 100%;overflow-x: scroll;">
						<table style="min-width: 600px;">
							<thead>
								<tr>
									<th>Lote</th>
									<th>Vez</th>
									<th>Célula</th>
									<th># Cajas</th>
									<th># Caj Aud</th>
									<th>Estado</th>
									<th>Resultado</th>
									<th>Usuario</th>
									<th>Fec Inicio</th>
									<th>Fec Fin</th>
								</tr>
							</thead>
							<tbody id="table-detalle-lotes-3">
								
							</tbody>
						</table>
					</div>
					<div class="line-header">
						<label>Lote selecionado:</label>
						<span id="lotesel"></span>
					</div>
					<div class="line-header">
						<label>Vez:</label>
						<span id="vezsel"></span>
					</div>
					<h4>Cajas disponibles a auditar</h4>
					<div style="display: flex;margin-bottom: 5px;">
						<label style="width: 90px;margin-top: 5px;"># Carton</label>
						<input type="number" id="ncarton" class="classIpt" style="padding: 5px;width: 120px;">
					</div>
					<div style="width: 100%;overflow-x: scroll;">
						<table style="min-width: 400px;">
							<thead>
								<tr>
									<th>N°</th>
									<th>#Carton (Ica)</th>
									<th>Size</th>
									<th>TOTAL</th>
									<th>Quantity</th>
									<th>SKU</th>
									<th>Check Carton Sticker</th>
								</tr>
							</thead>
							<tbody id="table-detalle-auditar">
								
							</tbody>
						</table>
					</div>
				</div>
				<div class="forms-content" id="form-5" style="display: none;">
					<div class="lbl">5. Auditorar Cajas</div>
					<h4>Lotes</h4>
					<div style="margin-bottom: 5px;width: 100%;overflow-x: scroll;">
						<table style="min-width: 600px;">
							<thead>
								<tr>
									<th>Lote</th>
									<th>Vez</th>
									<th>Célula</th>
									<th># Cajas</th>
									<th># Caj Aud</th>
									<th>Estado</th>
									<th>Resultado</th>
									<th>Usuario</th>
									<th>Fec Inicio</th>
									<th>Fec Fin</th>
								</tr>
							</thead>
							<tbody id="table-detalle-lotes-2">
								
							</tbody>
						</table>
					</div>
					<div id="detalle-celula" style="display: none;">						
						<div class="sameLine">
							<div class="lbl" style="width: 120px;">Célula:</div>
							<div class="spaceIpt" style="width: calc(100% - 120px);">
								<input type="text" id="idcelula-2" class="classIpt" style="height: auto;padding: 5px;">
							</div>
						</div>
						<div class="tblSelection" id="table-celula-2" style="margin-bottom: 5px;">
						</div>
						<button class="btnPrimary" style="margin-bottom: 5px;" onclick="add_lote_two()">Iniciar</button>
					</div>
					<div id="detalle-lote-vez" style="display: none;">
						<div class="line-header">
							<label>Lote selecionado:</label>
							<span id="lotesel-2"></span>
						</div>
						<div class="line-header">
							<label>Vez:</label>
							<span id="vezsel-2"></span>
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
							<div id="div-defecto">
								<div style="display: flex;margin-bottom: 5px;">
									<label style="width: 100px;">Defecto:</label>
									<input type="text" id="defecto" style="padding: 5px;width: calc(100% - 12px);">
								</div>
								<div id="tbl-defectos" style="background: #fff;margin:auto;margin-bottom: 5px;max-width: 500px;width: 100%;max-height: 150px;overflow-y: scroll;">
								</div>
								<div style="display: flex;margin-bottom: 5px;">
									<label style="width: 100px;">Cantidad:</label>
									<input type="number" id="numdef" style="padding: 5px;width: calc(100% - 12px);">
								</div>					
								<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="save_defecto2()">Agregar</button>
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
							<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="update_cajaaud()" id="btntercaj">Terminar Caja</button>
						</div>
						<div class="lineDecoration"></div>
						<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="update_endlote()">Terminar Lote</button>
					</div>
					<div class="lineDecoration"></div>
					<label>Observación</label>
					<textarea style="width: calc(100% - 12px);padding: 5px;" id="obs"></textarea>
					<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="end_auditoria()" id="btnendaud">Terminar auditoria</button>
				</div>
			</div>
		</div>
	</div>	
	<div class="content-parts-auditoria">
		<div class="body-parts-auditoria">
			<div class="part-auditoria part-active" id="redirect-1" onclick="show_form(1)">
				<div class="number-part">1</div>
				<div class="label-part">Packing List</div>
			</div>
			<div class="part-auditoria" id="redirect-2" onclick="show_form(2)">
				<div class="number-part">2</div>
				<div class="label-part">Check List</div>
			</div>
			<div class="part-auditoria" id="redirect-3" onclick="show_form(3)">
				<div class="number-part">3</div>
				<div class="label-part">Crear lote</div>
			</div>
			<div class="part-auditoria" id="redirect-4" onclick="show_form(4)">
				<div class="number-part">4</div>
				<div class="label-part">Selección de Cajas</div>
			</div>
			<div class="part-auditoria" id="redirect-5" onclick="show_form(5)">
				<div class="number-part">5</div>
				<div class="label-part">Auditar Cajas</div>
			</div>
		</div>	
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		var pedido="<?php echo $_GET['pedido']; ?>";
		var color="<?php echo $_GET['color']; ?>";
		var numvez="1";
		var parte="1";
		var ar_cajas=[];
		var ar_defectos=[];
		var audter_v=false;
		var cancajdis=0;
		var lote_v='';
		var ar_celulas=[];
		var codcel_v ='';
		function change_all_check(dom){
			var ar=document.getElementsByClassName("sel-addbox");
			if (dom.checked) {
				for (var i = 0; i < ar.length; i++) {
					ar[i].checked=true;
				}
			}else{
				for (var i = 0; i < ar.length; i++) {
					ar[i].checked=false;
				}
			}
		}
		$(document).ready(function(){
			$("#ncarton").keyup(function(e){
				let html='';
				for (var i = 0; i < ar_cajas.length; i++) {
					if(ar_cajas[i].NROCAJAERP.indexOf($("#ncarton").val())>=0){
						html+=
							'<tr>'+
								'<td>'+ar_cajas[i].NROCAJAPPL+'</td>'+
								'<td>'+ar_cajas[i].NROCAJAERP+'</td>'+
								'<td>'+ar_cajas[i].DESTAL+'</td>'+
								'<td>'+ar_cajas[i].CANTIDAD+'</td>'+
								'<td>'+ar_cajas[i].SKU+'</td>'+
								'<td>'+ar_cajas[i].DIRECCION+'</td>'+
								'<td><input class="sel-addbox" type="checkbox" id="sel-'+ar_cajas[i].NROCAJAERP+'"/></td>'+
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
			$("#idcelula").keyup(function(){
				let html='';
				for (var i = 0; i < ar_celulas.length; i++) {
					if(ar_celulas[i].DESTLL.toUpperCase().indexOf($("#idcelula").val().toUpperCase())>=0){
						html+='<div class="taller" onclick="select_celula(\''+ar_celulas[i].CODTLL+'\',\''+ar_celulas[i].DESTLL+'\')">'+ar_celulas[i].DESTLL+'</div>';
					}
				}							
				$("#table-celula").empty();
				$("#table-celula").append(html);
				codcel_v='';
			});		
			$("#idcelula-2").keyup(function(){
				let html='';
				for (var i = 0; i < ar_celulas.length; i++) {
					if(ar_celulas[i].DESTLL.toUpperCase().indexOf($("#idcelula-2").val().toUpperCase())>=0){
						html+='<div class="taller" onclick="select_celula(\''+ar_celulas[i].CODTLL+'\',\''+ar_celulas[i].DESTLL+'\')">'+ar_celulas[i].DESTLL+'</div>';
					}
				}							
				$("#table-celula-2").empty();
				$("#table-celula-2").append(html);
				codcel_v='';
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
					url:'config/getCajAudEst.php',
					data:{
						pedido:pedido,
						color:color,
						numvez:numvez,
						parte:parte,
						lote:lote_v,
						numvezlote:numvezlote_v,
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
				url:'config/getVerEmp.php',
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
						if (data.audter) {
							$("#btnendaud").remove();
							$("#btngrachelis").remove();
							audter_v=true;
						}
						if (!data.btnstart) {
							cancajdis=parseInt(data.cajdis);
							if (cancajdis==0) {
								document.getElementById("div-add-lote").remove();
							}else{
								document.getElementById("cancajdis").value=cancajdis;
							}
							document.getElementById("main-auditoria").style.display="block";
							$("#btnstart").remove();

							fill_lotes(data.lotes);

							let html='';
							for (var i = 0; i < data.detalle.length; i++) {
								html+=
								'<tr class="fila-val" data-codgrp="'+data.detalle[i].CODGRP+'" style="display:none;" id="fila-lleva-'+data.detalle[i].CODCHKLSTACA+'">'+
									'<td>'+data.detalle[i].DESCHKLSTACA+'</td>'+
									'<td>'+data.detalle[i].DESCHKLSTACAING+'</td>'+
									'<td>'+data.detalle[i].DESCHKLSTACADOS+'</td>'+
									'<td>'+
										'<div class="check-content" id="aca-cheblo3-'+data.detalle[i].CODCHKLSTACA+'">'+
											'<div class="marker-check anicheblo" onclick="change_check(this)" data-cod="'+data.detalle[i].CODCHKLSTACA+'" id="cheblo3-'+data.detalle[i].CODCHKLSTACA+'" data-value="0">NO</div>'+
										'</div>'+
									'</td>'+
								'</tr>';
							}
							$("#table-detalle-1").empty();
							$("#table-detalle-1").append(html);

							//fill_cajas_pl(data.paclis);

							ar_celulas=data.celulas;
							html='';
							for (var i = 0; i < ar_celulas.length; i++) {
								html+='<div class="taller" onclick="select_celula(\''+ar_celulas[i].CODTLL+'\',\''+ar_celulas[i].DESTLL+'\')">'+ar_celulas[i].DESTLL+'</div>';;
							}							
							$("#table-celula").empty();
							$("#table-celula").append(html);
							$("#table-celula-2").empty();
							$("#table-celula-2").append(html);

							for (var i = 0; i < data.detalle.length; i++) {
								if (data.detalle[i].VALOR=="1") {
									$("#check-"+data.detalle[i].CODCHKLSTACA).click();
								}
							}

							html='';
							ar_defectos=data.defectos;
							for (var i = 0; i < ar_defectos.length; i++) {
								let des=ar_defectos[i].DESFAM+' - '+ar_defectos[i].DESDEF+' ('+ar_defectos[i].CODDEFAUX+')';
								html+='<div class="taller" onclick="select_defecto(\''+ar_defectos[i].CODDEF+'\',\''+des+'\')">'+des+'</div>'
							}
							$("#tbl-defectos").append(html);
							
							fill_cajas(data.cajas);
							//fill_cajasaud(data.cajasaud);
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
		function select_celula(codcel,descel){
			codcel_v=codcel;
			$("#idcelula").val(descel);
			$("#idcelula-2").val(descel);
		}
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
				url:'config/addDefCajErpVerEmp.php',
				data:{
					pedido:pedido,
					color:color,
					numvez:numvez,
					parte:parte,
					numvezlote:numvezlote_v,
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
		function end_auditoria(){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/endVerEmp.php',
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
			if (!audter_v) {
				if (lote_v=="") {
					alert("Debe seleccionar un lote");
					return;
				}
				let estado='0';
				if (document.getElementById("idpendiente").checked) {
					estado='P';
				}
				var c=confirm("Desea agregar el carton "+id+"?");
				if (c) {
					$(".panelCarga").fadeIn(100);
					$.ajax({
						type:'POST',
						url:'config/addCajErpVerEmp.php',
						data:{
							pedido:pedido,
							color:color,
							numvez:numvez,
							parte:parte,
							lote:lote_v,
							numvezlote:numvezlote_v,
							numcajerp:id,
							estado:estado
						},
						success:function(data){
							console.log(data);
							if (data.state) {
								fill_lotes(data.lotes);
								fill_cajasaud(data.cajasaud);
								fill_cajas_a_auditar(data.cajas);
								fill_cajas_pl(data.paclis);
							}else{
								alert(data.detail);
							}
							$(".panelCarga").fadeOut(100);
						}
					});
				}

			}
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
				'<tr>'+
					'<td>'+ar_cajas[i].NROCAJAPPL+'</td>'+
					'<td>'+ar_cajas[i].NROCAJAERP+'</td>'+
					'<td>'+ar_cajas[i].DESTAL+'</td>'+
					'<td>'+ar_cajas[i].TOTAL+'</td>'+
					'<td>'+ar_cajas[i].CANTIDAD+'</td>'+
					'<td>'+ar_cajas[i].SKU+'</td>'+
					'<td>'+ar_cajas[i].DIRECCION+'</td>'+
					'<td><input class="sel-addbox" type="checkbox" id="sel-'+ar_cajas[i].NROCAJAERP+'"/></td>'+
				'</tr>';
			}
			$("#table-detalle-2").empty();
			$("#table-detalle-2").append(html);
		}
		function fill_cajas_a_auditar(data){
			let html='';
			ar_cajas=data;
			for (var i = 0; i < ar_cajas.length; i++) {
				html+=
				'<tr onclick="add_box(\''+ar_cajas[i].NROCAJAERP+'\')">'+
					'<td>'+ar_cajas[i].NROCAJAPPL+'</td>'+
					'<td>'+ar_cajas[i].NROCAJAERP+'</td>'+
					'<td>'+ar_cajas[i].DESTAL+'</td>'+
					'<td>'+ar_cajas[i].TOTAL+'</td>'+
					'<td>'+ar_cajas[i].CANTIDAD+'</td>'+
					'<td>'+ar_cajas[i].SKU+'</td>'+
					'<td>'+ar_cajas[i].DIRECCION+'</td>'+
				'</tr>';
			}
			$("#table-detalle-auditar").empty();
			$("#table-detalle-auditar").append(html);
		}
		function fill_cajasaud(data){
			let html='';
			for (var i = 0; i < data.length; i++) {
				html+=
				'<tr onclick="select_caja(\''+data[i].NUMVEZCAJA+'\',\''+data[i].NRO_CAJA_ERP+'\',\''+data[i].ESTADO+'\',\''+lote_v+'\')">'+
					'<td>'+data[i].NUMVEZCAJA+'</td>'+
					'<td>'+data[i].NROCAJAPPL+'</td>'+
					'<td>'+data[i].NRO_CAJA_ERP+'</td>'+
					'<td>'+data[i].DESTAL+'</td>'+
					'<td>'+data[i].CANTIDAD+'</td>'+
					'<td>'+data[i].SKU+'</td>'+
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
		function select_caja(vez,caja,estado,lote){
			if (estado=='T') {
				document.getElementById("btntercaj").style.display="none";
				document.getElementById("div-defecto").style.display="none";
			}else{
				document.getElementById("btntercaj").style.display="block";
				document.getElementById("div-defecto").style.display="block";
			}
			$("#numcajsel").text(caja);
			$("#numcajvezsel").text(vez);
			vez_v=vez;
			caja_v=caja;
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/getDefCajAudVerEmp.php',
				data:{
					pedido:pedido,
					color:color,
					numvez:numvez,
					parte:parte,
					lote:lote,
					numvezlote:numvezlote_v,
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
				url:'config/updateCajAudVerEmp.php',
				data:{
					pedido:pedido,
					color:color,
					numvez:numvez,
					parte:parte,
					lote:lote_v,
					numvezlote:numvezlote_v,
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
				/*if (num_form==1) {
					$(".panelCarga").fadeIn(100);
					$.ajax({
						type:'POST',
						url:'config/getPacLisVerEmp.php',
						data:{
							pedido:pedido,
							color:color
						},
						success:function(data){
							console.log(data);
							if (data.state) {
								fill_cajas_pl(data.paclis);
							}else{
								alert(data.detail);
							}
							$(".panelCarga").fadeOut(100);
						}
					});
				}*/
			}else{
				alert("Bloque no disponible!");
			}
		}
		function refresh_lista(){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/getPacLisVerEmp.php',
				data:{
					pedido:pedido,
					color:color
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						fill_cajas_pl(data.paclis);
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
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
				url:'config/startVerEmp.php',
				data:{
					pedido:pedido,
					color:color,
					numvez:numvez,
					parte:parte
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
				url:'config/saveVerEmp1.php',
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
		function fill_lotes(data){
			let html='';
			for (var i = 0; i < data.length; i++) {
				html+=
				'<tr onclick="select_lote(\''+data[i].NROLOTE+'\',\''+data[i].NUMVEZLOTE+'\',\''+data[i].DESCEL+'\',\''+validar_null(data[i].CODUSU)+'\')">'+
					'<td>'+data[i].NROLOTE+'</td>'+
					'<td>'+data[i].NUMVEZLOTE+'</td>'+
					'<td>'+data[i].DESCEL+'</td>'+
					'<td>'+data[i].NUMCAJLOTE+'</td>'+
					'<td>'+data[i].NUMCAJAUDLOTE+'</td>'+
					'<td>'+data[i].ESTADO+'</td>'+
					'<td>'+validar_null(data[i].RESULTADO)+'</td>'+
					'<td>'+validar_null(data[i].CODUSU)+'</td>'+
					'<td>'+data[i].FECINI+'</td>'+
					'<td>'+validar_null(data[i].FECFIN)+'</td>'+
				'</tr>';
			}/*
			$("#table-detalle-lotes").empty();
			$("#table-detalle-lotes").append(html);*/
			$("#table-detalle-lotes-2").empty();
			$("#table-detalle-lotes-2").append(html);
			$("#table-detalle-lotes-3").empty();
			$("#table-detalle-lotes-3").append(html);
		}
		var numvezlote_v='';
		function select_lote(lote,numvezlote,descel,codusu){
			document.getElementById("detalle-lote-vez").style.display="none";
			document.getElementById("detalle-celula").style.display="none";
			document.getElementById("lotesel").innerHTML=lote;
			document.getElementById("lotesel-2").innerHTML=lote;
			document.getElementById("vezsel").innerHTML=numvezlote;
			document.getElementById("vezsel-2").innerHTML=numvezlote;
			lote_v=lote;
			numvezlote_v=numvezlote;
			if (descel=="" && codusu=="") {
				show_form(5);
				document.getElementById("detalle-celula").style.display="block";
			}else{
				document.getElementById("detalle-lote-vez").style.display="block";
				let estado='0';
				if (document.getElementById("idpendiente").checked) {
					estado='P';
				}
				$(".panelCarga").fadeIn(100);
				$.ajax({
					type:'POST',
					url:'config/getCajLotAudVerEmp.php',
					data:{
						pedido:pedido,
						color:color,
						numvez:numvez,
						parte:parte,
						lote:lote,
						numvezlote:numvezlote,
						estado:estado
					},
					success:function(data){
						console.log(data);
						if (data.state) {
							//fill_cajas(data.cajasxlote);
							fill_cajas_a_auditar(data.cajasxlote);
							fill_cajasaud(data.cajasaud);
						}else{
							alert(data.detail);
						}
						$(".panelCarga").fadeOut(100);
					}
				});
			}
		}
		function add_lote(){
			let cantidad=parseInt(document.getElementById("cancajdis").value);
			if (codcel_v=='') {
				alert("Debe seleccionar una célula");
				return;
			}
			var ar=document.getElementsByClassName("sel-addbox");
			var ar_send=[];
			for (var i = 0; i < ar.length; i++) {
				if(ar[i].checked){
					ar_send.push(ar[i].id.replace("sel-",""));
				}
			}
			console.log(ar_send);
			if (ar_send.length==0) {
				alert("Debe seleccionar almenos una caja");
				return;
			}
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/saveLoteVerEmp.php',
				data:{
					pedido:pedido,
					color:color,
					numvez:numvez,
					parte:parte,
					codcel:codcel_v,
					numcajsel:ar_send.length,
					array:ar_send
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						//document.getElementById("div-add-lote").remove();
						fill_lotes(data.lotes);
						fill_cajas(data.cajas);
						fill_cajas_pl(data.paclis);
						$("#idcelula").val("");
						$("#idcelula").keyup();
						$("#idcelula-2").val("");
						$("#idcelula-2").keyup();
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function add_lote_two(){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/updateCelLotVerEmp.php',
				data:{
					pedido:pedido,
					color:color,
					numvez:numvez,
					parte:parte,
					codcel:codcel_v,
					lote:lote_v,
					numvezlote:numvezlote_v
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						fill_lotes(data.lotes);
						document.getElementById("detalle-lote-vez").style.display="block";
						document.getElementById("detalle-celula").style.display="none";
						select_lote(lote_v,numvezlote_v,'asd','asd');
						$("#idcelula-2").val("");
						$("#idcelula-2").keyup();
						$("#idcelula").val("");
						$("#idcelula").keyup();
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function update_endlote(){
			if (lote_v=="") {
				alert("Debe seleccionar un lote");
				return;
			}
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/endLoteVerEmp.php',
				data:{
					pedido:pedido,
					color:color,
					numvez:numvez,
					parte:parte,
					lote:lote_v,
					numvezlote:numvezlote_v
				},
				success:function(data){
					console.log(data);
					alert(data.detail);
					if (data.state) {
						fill_lotes(data.lotes);
						document.getElementById("detalle-caja").style.display="none";
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
		function fill_cajas_pl(data){
			html='';
			for (var i = 0; i < data.length; i++) {
				html+=
				'<tr>'+
					'<td>'+data[i].NROCAJAPPL+'</td>'+
					'<td>'+data[i].NROCAJAERP+'</td>'+
					'<td>'+data[i].DESTAL+'</td>'+
					'<td>'+data[i].TOTAL+'</td>'+
					'<td>'+data[i].CANTALLA+'</td>'+
					'<td>'+data[i].SKU+'</td>'+
					'<td>'+data[i].DIRECCION+'</td>'+
					'<td>'+data[i].NROLOTE+'</td>'+
					'<td>'+data[i].LLENADO+'</td>'+
					'<td>'+data[i].ALMACEN+'</td>'+
					'<td>'+data[i].CAJASELAUD+'</td>'+
				'</tr>';
			}
			$("#table-detalle-paclis").empty();
			$("#table-detalle-paclis").append(html);
		}
	</script>
</body>
</html>