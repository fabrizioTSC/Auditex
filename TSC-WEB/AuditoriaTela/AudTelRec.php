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
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="css/AuditoriaTela.css">
	<style type="text/css">
		@media(max-width: 500px){
			#idTabApa{
				overflow-x: scroll;
			}
			#idTabApaHed,#form2{
				min-width: 500px;
			}
		}
		@media(max-width: 730px){
			#headertbl3,#form3{
				min-width: 770px;
			}
		}
		table,td{
			border-collapse: collapse;
		}
		table{
			width: 100%;
			min-width: 700px;
			font-size: 13px;
		}
		thead td{
			background: #980f0f;
			color: #fff;
		}
		tbody td,thead td{
			border: 1px #333 solid;
			padding: 5px;
		}
		td{
			background: #fff;
		}
		td input{
			width: calc(100% - 10px);
			text-align: center;
			padding: 3px;
		}
		input[type="number"], input[type="text"]{
			width: calc(100% - 2px);
			border-radius: 0;
		}
		.cell-input{
			padding: 0px;
		}
		tr td:nth-child(1),
		tr td:nth-child(2),
		tr td:nth-child(3),
		tr td:nth-child(4),
		tr td:nth-child(5),
		tr td:nth-child(6){
			width: 50px;
			text-align: center;
			font-size: 12px;
		}
		tbody tr td:nth-child(1),
		tbody tr td:nth-child(2),
		tbody tr td:nth-child(3),
		tbody tr td:nth-child(4),
		tbody tr td:nth-child(5),
		tbody tr td:nth-child(6){
			background: #ddd;
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
	<div class="miniform-content" id="modal-form3" style="display: none;background: transparent;height: auto;">
		<div class="miniform-body" style="margin: 0px;margin-top: 60px; margin-left: 10px;box-shadow: 0px 0px 13px 5px rgba(50,50,50,0.5);">
			<div class="lbl">Buscar apariencia</div>
			<div class="lineDecoration"></div>
			<input type="text" id="idWordApariencia" style="padding:5px;width:calc(100% - 12px);">
			<button class="btnPrimary" style="margin:auto;margin-top: 5px;" onclick="hide_apariencia()">Cancelar</button>
		</div>
	</div>
	<div class="mainContent" id="mainToScroll">
		<div class="headerContent">
			<div class="headerTitle">Auditoria de Tela Rectilineo</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div id="idDetalle" style="display: block;">
				<div class="sameline">
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Partida: <span id="idPartida"><?php echo $_GET['partida']; ?></span></div>
					<div class="lbl" style="width: 50%;">Cliente: <span id="idCliente"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Proveedor: <span id="idProveedor"></span></div>
					<div class="lbl" style="width: 50%;">Cod. Tela: <span id="idCodtela"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Cod. Color: <span id="idCodCol"></span></div>
					<div class="lbl" style="width: 50%;">Color: <span id="idColor"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Art&iacute;culo: <span id="idArticulo"></span></div>
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Composici&oacute;n: <span id="idComposicion"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: 50%;">Programa: <span id="idPrograma"></span></div>
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">X-Factory: <span id="idXFactory"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: 50%;">Cant. programada: <span id="idCanPro"></span></div>
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;display: flex;">Peso (Kg):&nbsp;
						<div style="display: flex;">
							<input type="number" id="idPesVal" style="width: calc(80px);padding: 2px;">
							<button class="btnPrimary" style="width: 30px;padding: 0px;" onclick="save_peso()"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
						</div>
					</div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: 50%;">Peso programado: <span id="idPesoPrg"></span></div>
					<div class="lbl" style="width: 50%;">Auditor: <span id="idAuditor"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: 50%;">Fec. Inicio: <span id="idfecini"></span></div>
					<div class="lbl" style="width: 50%;">Fec. Fin: <span id="idfecfin"></span></div>
				</div>
			</div>
			<div class="btn-addrollo" onclick="animar_detalle()"><span id="btnContent">Ocultar detalle</span></div>
			<div class="lineDecoration"></div>
			<div class="forms-content" id="form-1">
				<div class="lbl">1. TONO</div>
				<div class="table-form" style="margin: 5px 0px;">
					<div class="header-table">
						<div class="line-table">
							<div class="item-table item-main">CONTROL DE TONO</div>
							<div class="item-table item-secondary">TSC</div>
							<div class="item-table item-secondary">REC. 1</div>
							<div class="item-table item-secondary">REC. 2</div>
						</div>
					</div>
					<div class="body-table" id="form1">
					</div>
				</div>
				<div class="lbl">Calificaci&oacute;n: <span id="idcalificacion-1">Aprobado</span></div>
				<div id="idRespon1" style="display:none;">
					<div class="lbl">Responsable: <span id="idRespon-1"></span></div>
					<div class="lbl">Encargado: <span id="idEncar-1"></span></div>
				</div>
				<div id="observacion1-res-1" style="display:none;">
					<div class="lbl">Observaci&oacute;n: <span id="observacion1-1"></span></div>
				</div>
				<div id="tbl-observacion-1" style="margin-bottom: 5px;">
					<!--<div class="lineObservacion" id="obs-1-1">Obs 1</div>-->
				</div>	
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="validate_form1()" id="btn-1">Guardar</button>
			</div>
			<div class="forms-content" id="form-2" style="display: none;">
				<div class="lbl">2. APARIENCIA <button class="btnPrimary" style="width: 35px;padding: 5px;" onclick="look_apariencia()"><i class="fa fa-search" aria-hidden="true"></i></button></div>
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="validate_form2()" id="btn-2">Guardar</button>
				<div class="table-form" style="margin: 5px 0px;overflow-y: scroll;max-height: calc(100vh - 506px);position: relative;" id="idTabApa">
					<div class="header-table" id="idTabApaHed" style="position: relative;z-index: 11;">
						<div class="line-table">
							<div class="item-table item2-submain">&Aacute;REA</div>
							<div class="item-table item2-main">C. APARIENCIA</div>
							<div class="item-table item2-secondary">TSC</div>
							<div class="item-table item2-secondary">REC.</div>
							<div class="item-table item2-secondary">CM.</div>
							<div class="item-table item2-secondary">% CAIDA</div>
						</div>
					</div>
					<div class="body-table" id="form2" style="position: relative;">
					</div>
				</div>
				<div class="lbl">Calificaci&oacute;n: <span id="idcalificacion-2">Aprobado</span></div>
				<div id="idRespon2" style="display:none;">
					<div class="lbl">Responsable: <span id="idRespon-2"></span></div>
					<div class="lbl">Encargado: <span id="idEncar-2"></span></div>
				</div>
				<div id="observacion2-res-2" style="display:none;">
					<div class="lbl">Observaci&oacute;n: <span id="observacion2-2"></span></div>
				</div>
				<div id="tbl-observacion-2" style="margin-bottom: 5px;">
					<!--<div class="lineObservacion" id="obs-1-1">Obs 1</div>-->
				</div>
			</div>
			<div class="forms-content" id="form-3" style="display: none;">
				<div style="width: 100%; overflow-x: scroll;">
					<table>
						<thead>						
							<tr>
								<td>Talla</td>
								<td>Unid. Pro.</td>
								<td>Largo</td>
								<td>Tol.</td>
								<td>Alto</td>
								<td>Tol.</td>
								<td>Largo Obte.</td>
								<td>Alto Obte.</td>
								<td>Unid. real</td>
								<td>Unid. 2das</td>
								<td>% 2das</td>
								<td>Observaciones</td>
							</tr>
						</thead>
						<tbody id="tbl-body">
							<!--
							<tr>
								<td class="clase-talla" data-codtal="014">XS</td>
								<td>XS</td>
								<td>XS</td>
								<td>XS</td>
								<td>XS</td>
								<td>XS</td>
								<td class="cell-input">
									<input class="ipt-tal" id="largo-014" data-codtal="014" type="text" value="0">
								</td>
								<td class="cell-input">
									<input class="ipt-tal" id="alto-014" data-codtal="015" type="text" value="0">
								</td>
								<td class="cell-input">
									<input class="ipt-tal" id="unirea-014" data-codtal="016" type="text" value="0">
								</td>
								<td class="cell-input">
									<input class="ipt-tal" id="uniseg-014"  data-codtal="017" type="text" value="0">
								</td>
								<td><center><span id="por-014">0</span>%</center></td>
								<td class="cell-input">
									<input class="ipt-tal" id="largo-014" data-codtal="018" type="text" value="0">
								</td>
							</tr>-->
						</tbody>
					</table>
				</div>
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="validate_form3()">Guardar</button>
			</div>

			<div class="forms-content" id="form-5" style="display: none;">
				<div class="lbl">5. RESULTADO DE LA AUDITOR&Iacute;A (<span id="ResultadoFinal"></span>)</div>
				<!--
				<div class="sameline">
					<div class="lbl" style="width: 200px;">Puntaje partida:</div>
					<div class="lbl"><span id="idPuntajePartida"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: 200px;">Calificaci&oacute;n partida:</div>
					<div class="lbl"><span id="idTipoPartida"></span></div>
				</div>
				<div class="">
					<div class="table-form" id="table-5">
						<div class="header-table">
							<div class="line-table">
								<div class="item-table item3-1" style="width: 60%;"></div>
								<div class="item-table item3-2" style="width: 20%;">KG</div>
								<div class="item-table item3-2" style="width: 20%;">%</div>
							</div>
						</div>
						<div class="body-table" id="form5">
							<div class="line-table">
								<div class="item-table item3-1" style="width: 60%;">KG Partida</div>
								<div class="item-table item3-2" style="width: 20%;" id="idKGPar"></div>
								<div class="item-table item3-2" style="width: 20%;" id="idKGParPor"></div>
							</div>
							<div class="line-table">
								<div class="item-table item3-1" style="width: 60%;">KG Auditado</div>
								<div class="item-table item3-2" style="width: 20%;" id="idKGAud"></div>
								<div class="item-table item3-2" style="width: 20%;" id="idKGAudPor"></div>
							</div>
							<div class="line-table">
								<div class="item-table item3-1" style="width: 60%;">KG Aprovechable</div>
								<div class="item-table item3-2" style="width: 20%;" id="idKGApr"></div>
								<div class="item-table item3-2" style="width: 20%;" id="idKGAprPor"></div>
							</div>
							<div class="line-table">
								<div class="item-table item3-1" style="width: 60%;">KG de Caida</div>
								<div class="item-table item3-2" style="width: 20%;" id="idKGCai"></div>
								<div class="item-table item3-2" style="width: 20%;" id="idKGCaiPor"></div>
							</div>
						</div>
					</div>
				</div>-->
				<div class="lbl" style="margin-top: 5px;">1. TONO</div>
				<div class="lbl">Calificaci&oacute;n: <span id="idcali-1-res">Aprobado</span></div>
				<div id="idRespon1-res" style="display:none;">
					<div class="lbl">Responsable: <span id="idRespon-1-res"></span></div>
					<div class="lbl">Encargado: <span id="idEncar-1-res"></span></div>
				</div>
				<div id="observacion1-res" style="display:none;">
					<div class="lbl">Observaci&oacute;n: <span id="observacion1"></span></div>
				</div>
				<div id="detalleres1" style="display: none;">
					<div class="table-form" style="margin: 5px 0px;">
						<div class="header-table">
							<div class="line-table">
								<div class="item-table item-main">CONTROL DE TONO - TACTO - PILLLING</div>
								<div class="item-table item-secondary">TSC</div>
								<div class="item-table item-secondary">REC. 1</div>
								<div class="item-table item-secondary">REC. 2</div>
							</div>
						</div>
						<div class="body-table" id="detalleres-form1">
						</div>
					</div>
				</div>
				<div class="lbl" style="margin-top: 5px;">2. APARIENCIA</div>
				<div class="lbl">Calificaci&oacute;n: <span id="idcali-2-res">Aprobado</span></div>
				<div id="idRespon2-res" style="display:none;">
					<div class="lbl">Responsable: <span id="idRespon-2-res"></span></div>
					<div class="lbl">Encargado: <span id="idEncar-2-res"></span></div>
				</div>
				<div id="observacion2-res" style="display:none;">
					<div class="lbl">Observaci&oacute;n: <span id="observacion2"></span></div>
				</div>
				<div id="detalleres2" style="display: none;">
					<div class="table-form" style="margin: 5px 0px;position: relative;">
						<div class="header-table" style="position: relative; z-index: 11; top: 0px;">
							<div class="line-table">
								<div class="item-table item2-submain">ÁREA</div>
								<div class="item-table item2-main">C. APARIENCIA</div>
								<div class="item-table item2-secondary">TSC</div>
								<div class="item-table item2-secondary">REC.</div>
								<div class="item-table item2-secondary">CM.</div>
								<div class="item-table item2-secondary">% CAIDA</div>
							</div>
						</div>
						<div class="body-table" id="detalleres-form2" style="position: relative;">
						</div>
					</div>
				</div>
				<div class="lbl" style="margin-top: 5px;">3. MEDIDAS</div>
				<div class="lbl">Calificaci&oacute;n: <span id="idcali-3-res">Aprobado</span></div>
				<div id="idRespon3-res" style="display:none;">
					<div class="lbl">Responsable: <span id="idRespon-3-res"></span></div>
					<div class="lbl">Encargado: <span id="idEncar-3-res"></span></div>
				</div>
				<div id="observacion3-res" style="display:none;">
					<div class="lbl">Observaci&oacute;n: <span id="observacion3"></span></div>
				</div>
				<div id="detalleres3" style="display: none;">
					<div class="table-animate">
						<div class="table-form" id="table-3">
							<div class="header-table" id="headertbl3">
								<div class="line-table">
									<div class="item-table item3-1">CARACTERISTICA</div>
									<div class="item-table item3-2">TOLERANCIA</div>
									<div class="item-table item3-2">ESTANDAR</div>
									<div class="item-table item3-2">PROVEEDOR</div>
									<div class="item-table item3-2">TSC</div>
									<div class="item-table item3-2">CONCLUSION</div>
									<div class="item-table item3-2">REC. 1</div>
									<div class="item-table item3-2">% CAIDA</div>
								</div>
							</div>
							<div class="body-table" id="detalleres-form3" style="min-width: 770px;">								
							</div>
						</div>
					</div>
				</div>
				<!--
				<div class="lbl" style="margin-top: 5px;">4. CONTROL DE DEFECTOS</div>
				<div id="idRespon4-res" style="display:none;">
					<div class="lbl">Responsable: <span id="idRespon-4-res"></span></div>
					<div class="lbl">Encargado: <span id="idEncar-4-res"></span></div>
				</div>
				<div id="observacion4-res" style="display:none;">
					<div class="lbl">Observaci&oacute;n: <span id="observacion4"></span></div>
				</div>
				<div id="detalleres4" style="display: none;">
					<div class="table-animate">
						<div class="table-form">
							<div class="header-table">
								<div class="line-table">
									<div class="item-table item3-2" style="width:20%">N°</div>
									<div class="item-table item3-2" style="width:20%">ESTADO</div>
									<div class="item-table item3-2" style="width:20%">CALIFICACION</div>
									<div class="item-table item3-2" style="width:20%">PUN. ROLLO</div>
									<div class="item-table item3-2" style="width:20%">PUN. DEF.</div>
								</div>
							</div>
							<div class="body-table" id="detalleres-form4">								
							</div>
						</div>
					</div>
				</div>-->
			</div>
			<div class="lineDecoration"></div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="redirect('IniciarAuditoriaTela.php')">Volver</button>
			<!--
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="end_auditoria()">Terminar</button>-->
		</div>
	</div>
	<div class="content-parts-auditoria">
		<div class="body-parts-auditoria">
			<div class="part-auditoria part-active" id="redirect-1" onclick="show_form(1)">
				<div class="number-part">1</div>
				<div class="label-part">Tono</div>
			</div>
			<div class="part-auditoria" id="redirect-2" onclick="show_form(2)">
				<div class="number-part">2</div>
				<div class="label-part">Apariencia</div>
			</div>
			<div class="part-auditoria" id="redirect-3" onclick="show_form(3)">
				<div class="number-part">3</div>
				<div class="label-part">Medidas</div>
			</div>
			<div class="part-auditoria" id="redirect-4" onclick="show_form(4)">
				<div class="number-part">4</div>
				<div class="label-part">Defectos</div>
			</div>
			<div class="part-auditoria" id="redirect-5" onclick="show_form(5)">
				<div class="number-part">5</div>
				<div class="label-part">Resultado</div>
			</div>
		</div>	
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" id="add-script">
	</script>
	<script type="text/javascript">
		var perfil_usu="<?php echo $_SESSION['perfil']; ?>";
		var codusu="<?php echo $_SESSION['user']; ?>";
		var partida="<?php echo $_GET['partida']; ?>";
		var codprv="<?php echo $_GET['codprv']; ?>";
		var codtel="<?php echo $_GET['codtel']; ?>";
		var codtad="<?php echo $_GET['codtad']; ?>";
		var parte="<?php echo $_GET['parte']; ?>";
		var numvez="<?php echo $_GET['numvez']; ?>";
		$(document).ready(function(){	
			$("#idWordApariencia").keyup(function(){
				var ar=document.getElementsByClassName("item-toshow");
				var last_i=0;
				var ll=0;
				for (var i = 0; i < ar.length; i++) {
					if(ar[i].innerHTML.toUpperCase().indexOf($("#idWordApariencia").val().toUpperCase())>=0){
						if (ll==0) {
							last_i=i;	
						}
						ll++;
						ar[i].classList.add("lineSearch");						
					}else{
						ar[i].classList.remove("lineSearch");
					}
				}
				//var y_pos=$("#idTabApa").scrollTop()+ar[last_i].getBoundingClientRect().y-200;
				var y_pos=(last_i-1)*33;
				console.log(y_pos);
				$("#idTabApa").scrollTop(0);
				$("#idTabApa").scrollTop(y_pos);
			});		
			$.ajax({
				type:'POST',
				url:'config/startAudTelRec.php',
				data:{
					partida:partida,
					codprv:codprv,
					codtel:codtel,
					codtad:codtad,
					parte:parte,
					numvez:numvez
				},
				success:function(data){
					console.log(data);

					$("#idCliente").text(data.partida.DESCLI);
					$("#idProveedor").text(data.partida.DESPRV);
					$("#idCodtela").text(codtel);
					$("#idArticulo").text(data.partida.DESTEL);
					$("#idCodCol").text(data.partida.CODCOL);
					$("#idColor").text(data.partida.DESCOL);
					$("#idComposicion").text(data.partida.COMPOS);
					$("#idPrograma").text(data.partida.PROGRAMA);
					$("#idXFactory").text(data.partida.XFACTORY);
					$("#idPesVal").val(data.partida.PESO);
					$("#idCanPro").text(data.partida.CANPRG);
					$("#idPesoPrg").text(data.partida.PESOPRG);
					$("#idAuditor").text(data.partida.CODUSU);
					$("#idfecini").text(data.partida.FECINIAUD);
					$("#idfecfin").text(data.partida.FECFINAUD);

					/*bloque tono*/
					let html='';
					var option_select='';
					if (perfil_usu=="2") {
						option_select='<option value="C">Aprobado no conforme</option>';
					}
					for (var i = 0; i < data.tonos.length; i++) {
						html+=
						'<div class="line-table">'+
							'<div class="item-table item-main">'+data.tonos[i].DESTON+'</div>'+
							'<div class="item-table item-secondary">'+
								'<select class="selectclass-min select-1" data-clicked="0" id="select1-'+data.tonos[i].CODTON+'" data-codton="'+data.tonos[i].CODTON+'">'+
									'<option value="A">Aprobado</option>'+
									option_select+
									'<option value="R">Rechazado</option>'+
								'</select>'+
							'</div>'+
							'<div class="item-table item-secondary">'+
								'<select class="selectclass-min" id="select1-1-'+data.tonos[i].CODTON+'" data-codton="'+data.tonos[i].CODTON+'">'+
								'</select>'+
							'</div>'+
							'<div class="item-table item-secondary">'+
								'<select class="selectclass-min" id="select1-2-'+data.tonos[i].CODTON+'" data-codton="'+data.tonos[i].CODTON+'">'+
								'</select>'+
							'</div>'+
						'</div>';						
					}
					html+=
					'<script type="text/javascript">'+
						'$(".select-1").change(function(){'+
							'autoevaluar1();'+
						'});'+
						'$(".select-1").click(function(){'+
							'this.dataset.clicked="1";'+
						'});';
					$("#form1").append(html);

					/*apariencia*/
					html='';for (var i = 0; i < data.apariencia.length; i++) {
						html+=
						'<div class="line-table">'+
							'<div class="item-table item2-submain item2-headerrow">'+data.apariencia[i].DSCAREAD+'</div>'+
							'<div class="content-row">'+
								'<div class="line-table">'+
									'<div class="item-table itemr2-main item-toshow">'+data.apariencia[i].DESAPA+'</div>'+
									'<div class="item-table itemr2-secondary">'+
										'<select class="selectclass-min select-2" data-clicked="0" id="select2-'+data.apariencia[i].CODAPA+'" data-codapa="'+data.apariencia[i].CODAPA+'">'+
											'<option value="A">Aprobado</option>'+
											option_select+
											'<option value="R">Rechazado</option>'+
										'</select>'+
									'</div>'+
									'<div class="item-table itemr2-secondary">'+
										'<select class="selectclass-min" id="select2-1-'+data.apariencia[i].CODAPA+'" data-codapa="'+data.apariencia[i].CODAPA+'">'+
										'</select>'+
									'</div>'+
									'<div class="item-table itemr2-secondary">'+
										'<input type="number" id="input2-2-'+data.apariencia[i].CODAPA+'" class="input" data-estdim="'+data.apariencia[i].CODAPA+'" value="0" disabled>'+
									'</div>'+
									'<div class="item-table itemr2-secondary">'+
										'<input type="number" id="input2-3-'+data.apariencia[i].CODAPA+'" class="input" data-estdim="'+data.apariencia[i].CODAPA+'" value="0" disabled>'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>';	
					}
					html+=
					'<script type="text/javascript">'+
						'$(".select-2").change(function(){'+
							'autoevaluar2();'+
						'});'+
						'$(".select-2").click(function(){'+
							'this.dataset.clicked="1";'+
						'});';
					$("#form2").append(html);

					html='';
					for (var i = 0; i < data.detalle.length; i++) {
					html+=
						'<tr>'+
							'<td class="clase-talla" data-codtal="'+data.detalle[i].CODTAL+'">'+data.detalle[i].DESTAL+'</td>'+
							'<td>'+data.detalle[i].CANPRGTAL+'</td>'+
							'<td>'+data.detalle[i].LARGO+'</td>'+
							'<td>'+data.detalle[i].TOLLARGO+'</td>'+
							'<td>'+data.detalle[i].ALTO+'</td>'+
							'<td>'+data.detalle[i].TOLALTO+'</td>'+
							'<td class="cell-input">'+
								'<input class="ipt-tal" id="largo-'+data.detalle[i].CODTAL+'" data-codtal="'+data.detalle[i].CODTAL+'" type="text" value="0">'+
							'</td>'+
							'<td class="cell-input">'+
								'<input class="ipt-tal" id="alto-'+data.detalle[i].CODTAL+'" data-codtal="'+data.detalle[i].CODTAL+'" type="text" value="0">'+
							'</td>'+
							'<td class="cell-input">'+
								'<input class="ipt-tal" onblur="calc_percent(this);" id="unirea-'+data.detalle[i].CODTAL+'" data-codtal="'+data.detalle[i].CODTAL+'" type="text" value="0">'+
							'</td>'+
							'<td class="cell-input">'+
								'<input class="ipt-tal" onblur="calc_percent(this);" id="uniseg-'+data.detalle[i].CODTAL+'"  data-codtal="'+data.detalle[i].CODTAL+'" type="text" value="0">'+
							'</td>'+
							'<td><center><span id="por-'+data.detalle[i].CODTAL+'">0</span>%</center></td>'+
							'<td class="cell-input">'+
								'<input class="ipt-tal" id="obs-'+data.detalle[i].CODTAL+'" data-codtal="'+data.detalle[i].CODTAL+'" type="text">'+
							'</td>'+
						'</tr>';
					}
					$("#tbl-body").append(html);

					/*RECREANDO VALORES*/
					/*TONO*/
					for (var i = 0; i < data.detalle_tono.length; i++) {
						document.getElementById("select1-"+data.detalle_tono[i].CODTON).value=data.detalle_tono[i].RESTSC;
						//document.getElementById("select1-"+data.detalle_tono[i].CODTON).value=data.detalle_tono[i].RESTSC;						
					}
					if (data.partida.RESTONTSC!=null) {
						document.getElementById("idcalificacion-1").innerHTML=procesarResultado(data.partida.RESTONTSC);
					}

					/*APARIENCIA*/
					for (var i = 0; i < data.detalle_apariencia.length; i++) {
						document.getElementById("select2-"+data.detalle_apariencia[i].CODAPA).value=data.detalle_apariencia[i].RESTSC;
						//document.getElementById("select2-"+data.detalle_apariencia[i].CODTON).value=data.detalle_apariencia[i].RESTSC;					
					}
					if (data.partida.RESAPATSC!=null) {
						document.getElementById("idcalificacion-2").innerHTML=procesarResultado(data.partida.RESAPATSC);
					}

					for (var i = 0; i < data.guardado.length; i++) {
						document.getElementById("largo-"+data.guardado[i].CODTAL).value=data.guardado[i].LARGO;
						document.getElementById("alto-"+data.guardado[i].CODTAL).value=data.guardado[i].ALTO;
						document.getElementById("unirea-"+data.guardado[i].CODTAL).value=data.guardado[i].CANAUD;
						document.getElementById("uniseg-"+data.guardado[i].CODTAL).value=data.guardado[i].CANSEG;
						document.getElementById("obs-"+data.guardado[i].CODTAL).value=data.guardado[i].OBS;
						let den=parseInt(data.guardado[i].CANAUD);
						if (den!=0) {
							let num=parseInt(data.guardado[i].CANSEG);
							$("#por-"+data.guardado[i].CODTAL).text(Math.round(num*10000/den)/100);
						}
					}
					$(".panelCarga").fadeOut(100);
				},
			    error: function (jqXHR, exception) {
			        var msg = '';
			        if (jqXHR.status === 0) {
			            msg = 'Sin conexión.\nVerifique su conexión a internet!';
			        } else if (jqXHR.status == 404) {
			            msg = 'No se encuentra el archivo necesario para guardar la inspección!';
			        } else if (jqXHR.status == 500) {
			            msg = 'Servidor no disponible (Web de TSC). Intente más tarde';
			        } else if (exception === 'parsererror') {
			            msg = 'La respuesta tiene errores. Por favor, contactar al equipo de desarrollo!';
			        } else if (exception === 'timeout') {
			            msg = 'Tiempo de respuesta muy largo (Web de TSC)!';
			        } else if (exception === 'abort') {
			            msg = 'Se cancelo la consulta!';
			        } else {
			            msg = 'Error desconocido.\n' + jqXHR.responseText+'.\nInforme al equipo de desarrollo!';
			        }
			        alert(msg);
			        $(".panelCarga").fadeOut(100);
			    }
			});
		});
		function calc_percent(dom){
			let codtal=dom.dataset.codtal;
			let den=parseInt($("#unirea-"+codtal).val());
			if (den!=0) {
				let num=parseInt($("#uniseg-"+codtal).val());
				$("#por-"+codtal).text(Math.round(num*10000/den)/100);
			}
		}
		var res_1_v="A";
		var text_apr="Aprobado";
		var text_anc="Aprobado no conforme";
		var text_rec="Rechazado";
		function procesarResultado(res){
			if(res=="A"){
				return text_apr;
			}
			if(res=="C"){
				return text_anc;
			}
			if(res=="R"){
				return text_rec;
			}
			return '';
		}
		function autoevaluar1(){
			var cont_a=0;
			var cont_c=0;
			var cont_r=0;
			var array=document.getElementsByClassName("select-1");
			for (var i = 0; i < array.length; i++) {
				if(array[i].value=="A"){
					cont_a++;
				}
				if(array[i].value=="C"){
					cont_c++;
				}
				if(array[i].value=="R"){
					cont_r++;
				}
			}
			if (cont_r>0) {
				$("#idcalificacion-1").text(text_rec);
				res_1_v="R";
			}else{
				if (cont_c>0) {
					$("#idcalificacion-1").text(text_anc);
					res_1_v="C";
				}else{
					$("#idcalificacion-1").text(text_apr);
					res_1_v="A";
				}
			}
			if (cont_a==0 && cont_c==0 && cont_r==0) {
				$("#idcalificacion-1").text("-");
			}
		}
		var res_2_v="A";
		function autoevaluar2(){
			var cont_a=0;
			var cont_c=0;
			var cont_r=0;
			var array=document.getElementsByClassName("select-2");
			for (var i = 0; i < array.length; i++) {
				if(array[i].value=="A"){
					cont_a++;
				}
				if(array[i].value=="C"){
					cont_c++;
				}
				if(array[i].value=="R"){
					cont_r++;
				}
			}
			if (cont_r>0) {
				$("#idcalificacion-2").text(text_rec);
				res_2_v="R";
			}else{
				if (cont_c>0) {
					$("#idcalificacion-2").text(text_anc);
					res_2_v="C";
				}else{
					$("#idcalificacion-2").text(text_apr);
					res_2_v="A";
				}
			}
			if (cont_a==0 && cont_c==0 && cont_r==0) {
				$("#idcalificacion-2").text("-");
			}
		}

		function validate_form1(){
			var array=document.getElementsByClassName("select-1");
			var validar=true;
			var ar_select=[];
			for (var i = 0; i < array.length; i++) {
				if (array[i].dataset.clicked=="1") {
					var aux=[];
					aux.push(array[i].dataset.codton);
					aux.push(array[i].value);
					ar_select.push(aux);
				}
			}
			console.log(ar_select);
			console.log(res_1_v);
			if (validar) {
				$(".panelCarga").fadeIn(200);
				$.ajax({
					type:'POST',
					url:'config/saveAudRecForm1.php',
					data:{
						partida:partida,
						codtel:$("#idCodtela").text(),
						codprv:codprv,
						codtad:codtad,
						numvez:numvez,
						parte:parte,
						array:ar_select,
						resultado:res_1_v,
						codusu:codusu,
						perusu:perfil_usu
					},
					success:function(data){
						console.log(data);
						if (data.state) {
							if(res_1_v!='R'){
								if (data.tryend) {
									var c=confirm("Ya se encuentra revisadas todas las partes. Desea finalizar la auditoría?");
									if (c) {
										finish_auditoria();
									}
									show_form(5);
								}else{
									show_form(2);
								}
							}else{
								alert("Bloque rechazado!");
							}
						}else{
							alert(data.detail);
						}
						$(".panelCarga").fadeOut(200);
					}
				});
			}else{
				alert("Seleccione todas las calificaciones de Tono!");
			}
		}
		function validate_form2(){
			var array=document.getElementsByClassName("select-2");
			var ar_select=[];
			for (var i = 0; i < array.length; i++) {
				if (array[i].dataset.clicked=="1") {
					var aux=[];
					aux.push(array[i].dataset.codapa);
					aux.push(array[i].value);
					aux.push("");
					aux.push("");
					aux.push("0");
					aux.push("0");
					ar_select.push(aux);
				}
			}
			$(".panelCarga").fadeIn(200);
			$.ajax({
				type:'POST',
				url:'config/saveAudRecForm2.php',
				data:{
					partida:partida,
					codtel:$("#idCodtela").text(),
					codprv:codprv,
					codtad:codtad,
					numvez:numvez,
					parte:parte,
					array:ar_select,
					resultado:res_2_v,
					codusu:codusu,
					perusu:perfil_usu
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						if(res_2_v!='R'){
							if (data.tryend) {
								var c=confirm("Ya se encuentra revisadas todas las partes. Desea finalizar la auditoría?");
								if (c) {
									finish_auditoria();
								}
								show_form(5);
							}else{
								show_form(3);	
							}
						}else{
							alert("Bloque rechazado!");
						}
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(200);
				}
			});
		}

		function validate_form3(){
			let ar=document.getElementsByClassName("clase-talla");
			let ar_send=[];
			for (var i = 0; i < ar.length; i++) {
				let codtal=ar[i].dataset.codtal;
				let aux=[];
				aux.push(codtal);
				aux.push(document.getElementById("largo-"+codtal).value);
				aux.push(document.getElementById("alto-"+codtal).value);
				aux.push(document.getElementById("unirea-"+codtal).value);
				aux.push(document.getElementById("uniseg-"+codtal).value);
				aux.push(document.getElementById("obs-"+codtal).value);
				ar_send.push(aux);
			}
			$(".panelCarga").fadeIn(200);
			$.ajax({
				type:'POST',
				url:'config/saveAudRecForm3.php',
				data:{
					partida:partida,
					codprv:codprv,
					codtel:codtel,
					codtad:codtad,
					numvez:numvez,
					parte:parte,
					codusu:codusu,
					array:ar_send,
					perusu:perfil_usu
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						show_form(5);
					}
					alert(data.detail);
					$(".panelCarga").fadeOut(200);
				}
			});
		}
		function end_auditoria(){
			let ar=document.getElementsByClassName("clase-talla");
			let ar_send=[];
			for (var i = 0; i < ar.length; i++) {
				let codtal=ar[i].dataset.codtal;
				let aux=[];
				aux.push(codtal);
				aux.push(document.getElementById("largo-"+codtal).value);
				aux.push(document.getElementById("alto-"+codtal).value);
				aux.push(document.getElementById("unirea-"+codtal).value);
				aux.push(document.getElementById("uniseg-"+codtal).value);
				aux.push(document.getElementById("obs-"+codtal).value);
				ar_send.push(aux);
			}
			$(".panelCarga").fadeIn(200);
			$.ajax({
				type:'POST',
				url:'config/finishAudTelRec.php',
				data:{
					partida:partida,
					codprv:codprv,
					codtel:codtel,
					codtad:codtad,
					numvez:numvez,
					parte:parte,
					codusu:codusu,
					array:ar_send
				},
				success:function(data){
					console.log(data);
					alert(data.detail);
					$(".panelCarga").fadeOut(200);
				}
			});
		}
		function save_peso(){
			if ($("#idPesVal").val()!="") {
				let peso=parseInt(parseFloat($("#idPesVal").val())*100);
				$(".panelCarga").fadeIn(200);
				$.ajax({
					type:'POST',
					url:'config/updatePesoPAR.php',
					data:{
						partida:partida,
						codprv:codprv,
						codtel:codtel,
						codtad:codtad,
						numvez:numvez,
						parte:parte,
						peso:peso
					},
					success:function(data){
						console.log(data);
						if (!data.state) {
							alert(data.detail);
						}
						$(".panelCarga").fadeOut(200);
					}
				});
			}else{
				alert("Ingrese un valor de peso!");
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
		function show_form(num_form){
			if (num_form==5) {				
				$(".panelCarga").fadeIn(200);
				$.ajax({
					type:'POST',
					url:'config/updateResumenATR.php',
					data:{
						partida:partida,
						codtel:$("#idCodtela").text(),
						codprv:codprv,
						codtad:codtad,
						numvez:numvez,
						parte:parte
					},
					success:function(data){
						console.log(data);
							document.getElementById("idcali-1-res").innerHTML=procesarResultado(data.partida.RESTONTSC);
							document.getElementById("idcali-2-res").innerHTML=procesarResultado(data.partida.RESAPATSC);
							document.getElementById("idcali-3-res").innerHTML=procesarResultado(data.partida.RESMEDTSC);
							/*
							$("#ResultadoFinal").text(procesarResultado(data.resultado));
							$("#idPuntajePartida").text(data.calificacion);
							$("#idTipoPartida").text(data.tipo);
							$("#idKGPar").text(data.peso);
							$("#idKGParPor").text("100%");
							$("#idKGAud").text(data.pesoaud);
							$("#idKGAudPor").text(Math.round(data.pesoaud*10000/data.peso)/100+"%");
							$("#idKGApr").text(data.pesoapro);
							$("#idKGAprPor").text(Math.round(data.pesoapro*10000/data.peso)/100+"%");
							$("#idKGCai").text(data.pesocai);
							$("#idKGCaiPor").text(Math.round(data.pesocai*10000/data.peso)/100+"%");*/
						$(".panelCarga").fadeOut(200);
					}
				});
			}
			if (num_form==4) {
				alert("No disponible");
				return;
			}
			var validar=true;
			if (validar) {
				$(".forms-content").css("display","none");
				$("#form-"+num_form).css("display","block");
				var array=document.getElementsByClassName("part-auditoria");
				for (var i = 0; i < array.length; i++) {
					array[i].classList.remove("part-active");
				}
				document.getElementById("redirect-"+num_form).classList.add("part-active");
			}else{
				alert("Auditoria no disponible!");
			}
		}

		function finish_auditoria(){
			$(".panelCarga").fadeIn(200);
			$.ajax({
				type:'POST',
				url:'config/finishATR.php',
				data:{
					partida:partida,
					codtel:$("#idCodtela").text(),
					codprv:codprv,
					codtad:codtad,
					numvez:numvez,
					parte:parte
				},
				success:function(data){
					console.log(data);
					if(!data.state){
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(200);
				}
			});
		}
		function look_apariencia(){
			$("#modal-form3").fadeIn(100);
			$("#idWordApariencia").focus();
		}
		function hide_apariencia(){
			var ar=document.getElementsByClassName("item-toshow");
			for (var i = 0; i < ar.length; i++) {
				ar[i].classList.remove("lineSearch");
			}
			$("#modal-form3").fadeOut(200);
		}
	</script>
</body>
</html>