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
		.item3-1{
			width: calc(100% - 712px);
		}
		.item3-3{
			width: calc(300px - 12px);
		}
		.item2-1{
			width: calc(100% - 502px);
		}
		.itemr2-main{
			width: calc(100% - 422px);
		}
		.item2-3{
			width: calc(270px - 12px);
		}
		.item1-1-1{
			width: calc(100% - 482px);
		}
		.item1-1-2{
			width: calc(70px - 12px);
		}
		.item1-1-3{
			width: calc(200px - 12px);
		}
		@media(max-width: 700px){
			.content-table1{
				overflow-x: scroll;
			}
			#table1-1,#table1-2{
				min-width: 700px;
			}
			#idTabApa{
				overflow-x: scroll;
			}
			#idTabApaHed,#form2{
				min-width: 700px;
			}
		}
		@media(max-width: 1140px){
			#headertbl3,#form3{
				min-width: 1140px;
			}
			.table-animate{
				overflow-x: scroll;				
			}
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
			<div class="headerTitle">Consultar Auditoria de Telas</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div id="idDetalle" style="display: block;">
				<div class="sameline">
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Partida: <span id="idPartida"></span></div>
					<div class="lbl" style="width: 50%;">Cliente: <span id="idCliente">Lacoste</span></div>
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
					<div class="lbl" style="width: 50%;">Destino: <span id="idDestino"></span></div>
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Peso (Kg): <span id="idPesoPartida"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: 50%;">Rend. por peso: <span id="idRendimiento"></span></div>
					<div class="lbl" style="width: 50%;">Peso programado: <span id="idPesoPrg"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: 50%;">Rend. por peso (Real): <span id="idRendimientoReal"></span></div>
					<!-- <div class="lbl" style="width: 50%;">Peso programado: <span id="idPesoPrg"></span></div> -->
				</div>
				<div class="sameline">
					<div class="lbl" style="width: 50%;">Auditor: <span id="idAuditor"></span></div>
					<div class="lbl" style="width: 50%;">Coordinador: <span id="idSupervisor"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: 50%;">Fec. Inicio: <span id="idfecini"></span></div>
					<div class="lbl" style="width: 50%;">Fec. Fin: <span id="idfecfin"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: 50%;">Ruta Tela: <span id="idruttel"></span></div>
					<div class="lbl" style="width: 50%;">Est. Cliente: <span id="idEstCliEstCon"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;display: flex;">CMC Prov.:&nbsp;					
						<div style="display: flex;">
							<input type="number" id="idcmcprv" style="width: calc(80px);padding: 2px;">
							<button class="btnPrimary" id="idbtncmcprv" style="width: 30px;padding: 0px;" onclick="save_cmcprv()"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
						</div>
					</div>
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;display: flex;">CMC WTS:&nbsp;						
						<div style="display: flex;">
							<input type="number" id="idcmcwts" style="width: calc(80px);padding: 2px;">
							<button class="btnPrimary" id="idbtncmcwts" style="width: 30px;padding: 0px;" onclick="save_cmcwts()"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
						</div>
					</div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: 50%;" id="label-estcon">Proy. Ca&iacute;da: <span id="idEstCon" style="color: red;"></span></div>
				</div>
				<div id="detalle-adi-estcon">
					<div class="sameline">
						<div class="lbl" style="width: 50%;">Datacolor: <span id="idDatColEstCon"></span></div>
						<div class="lbl" style="width: 50%;">Motivo: <span id="idMotEstCon"></span></div>
					</div>
				</div>
			</div>
			<div class="btn-addrollo" onclick="animar_detalle()"><span id="btnContent">Ocultar detalle</span></div>
			<div class="btnPrimary" style="margin-left: calc(50% - 80px);width: 135px;
			padding: 5px;display: flex;padding-left: 20px;" onclick="exportar_audtel()">
				<img src="assets/img/excel.png" style="width: 30px;height: 30px;">
				<div style="padding: 5px;width:calc(80px);text-align: center;">Descargar</div>
			</div>
			<div class="btnPrimary" style="margin-left: calc(50% - 80px);width: 150px;margin-top: 5px;
			padding: 5px;display: flex;" onclick="exportar_audtel_pdf()">
				<div style="padding: 5px;width:calc(100% - 10px);text-align: center;">Descargar PDF</div>
			</div>
			<div class="btnPrimary" style="margin-left: calc(50% - 80px);width: 150px;margin-top: 5px;
			padding: 5px;display: flex;" onclick="javascript:history.back()">
				<div style="padding: 5px;width:calc(100% - 10px);text-align: center;">Volver</div>
			</div>
			<div class="btnPrimary" style="margin-left: calc(50% - 80px);width: 150px;margin-top: 5px;
			padding: 5px;display: flex;" onclick="change_pendiente()" id="button-pendiente">
				<div style="padding: 5px;width:calc(100% - 10px);text-align: center;">Cambiar a pendiente</div>
			</div>
			<!--
			<div class="sameline">
				<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Ruta de Tela: <span>Te&ntilde;ido + Antipilling Neutro</span></div>
				<div class="lbl" style="width: 50%;">Tratamiento post-tinto: <span>Ninguno</span></div>
			</div>-->
			<div class="lineDecoration"></div>
			<div class="forms-content" id="form-1">
				<div class="lbl">1. TONO</div>
				<div class="content-table1">
					<div class="table-form" id="table1-1" style="margin: 5px 0px;">
						<div class="header-table">
							<div class="line-table">
								<div class="item-table item-main item1-1-1">CONTROL DE TONO - TACTO - PILLLING</div>
								<div class="item-table item-secondary item1-1-2">TSC</div>
								<div class="item-table item-secondary item1-1-3">REC. 1</div>
								<div class="item-table item-secondary item1-1-3">REC. 2</div>
							</div>
						</div>
						<div class="body-table" id="form1">
						</div>
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
				<div class="lineDecoration"></div>
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="validate_form1()" id="button1">Guardar</button>
			</div>
			<div class="forms-content" id="form-2" style="display: none;">
				<div class="lbl">2. APARIENCIA</div>
				<div class="table-form" style="margin: 5px 0px;" id="idTabApa">
					<div class="header-table" id="idTabApaHed">
						<div class="line-table">
							<div class="item-table item2-submain">&Aacute;REA</div>
							<div class="item-table item2-main item2-1">C. APARIENCIA</div>
							<div class="item-table item2-secondary">TSC</div>
							<div class="item-table item2-secondary item2-3">REC.</div>
							<div class="item-table item2-secondary">CM.</div>
							<!--
							<div class="item-table item2-secondary">% CAIDA</div>-->
						</div>
					</div>
					<div class="body-table" id="form2">
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
				<div class="lineDecoration"></div>
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="validate_form2()" id="button2">Guardar</button>
			</div>
			<div class="forms-content" id="form-3" style="display: none;">
				<div class="lbl">3. ESTABILIDAD DIMENSIONAL</div>
				<div class="table-animate">
					<div class="table-form" id="table-3">
						<div class="header-table" id="headertbl3">
							<div class="line-table">
								<div class="item-table item3-1">CARACTERISTICA</div>
								<div class="item-table item3-2">TOL (+)</div>
								<div class="item-table item3-2">TOL (-)</div>
								<div class="item-table item3-2">ESTANDAR</div>
								<div class="item-table item3-2">PROVEEDOR</div>
								<div class="item-table item3-2">TSC</div>
								<div class="item-table item3-2">TESTING</div>
								<div class="item-table item3-2">CONCLUSION</div>
								<div class="item-table item3-3">REC. 1</div>
								<!--
								<div class="item-table item3-2">% CAIDA</div>-->
							</div>
						</div>
						<div class="body-table" id="form3">
							<!--
							<div class="line-table">
								<div class="item-table item3-1">ANCHO ACABADO BW</div>
								<div class="item-table item3-2">+/-2 cm</div>
								<div class="item-table item3-2">1.95</div>
								<div class="item-table item3-2">
									<input type="number" id="" class="">
								</div>
								<div class="item-table item3-2">
									<input type="number" id="" class="">
								</div>
								<div class="item-table item3-2">
									<select class="selectclass-min select-3">
										<option value="N"></option>
										<option value="R">Rechazado</option>
										<option value="C">Aprobado no conforme</option>
										<option value="A">Aprobado</option>
									</select>
								</div>
							</div>-->
						</div>
					</div>
				</div>					
				<div class="lbl" style="margin: 5px 0px;">Calificaci&oacute;n: 
					<select class="selectclass-min" id="idcalificacion-3" style="width: 150px; margin-bottom: 5px;" disabled>
						<option value="A">Aprobado</option>
						<option value="C">Aprobado no conforme</option>
						<option value="R">Rechazado</option>
					</select>
					<!--<span id="idcalificacion-3">Aprobado</span>-->
				</div>
				<div id="idRespon3" style="display:none;">
					<div class="lbl">Responsable: <span id="idRespon-3"></span></div>
					<div class="lbl">Encargado: <span id="idEncar-3"></span></div>
				</div>
				<div id="observacion3-res-3" style="display:none;">
					<div class="lbl">Observaci&oacute;n: <span id="observacion3-3"></span></div>
				</div>
				<div class="lineDecoration"></div>
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="validate_form3()" id="button3">Guardar</button>
			</div>
			<div class="forms-content" id="form-4" style="display: none;">
				<div class="lbl">4. CONTROL DE DEFECTOS (Rollos: <span id="idnumerorollos"></span> - Rollos a auditar: <span id="idrolaud"></span>)</div>
				<div class="lbl">Calificaci&oacute;n: <span id="idcalificacion4"></span></div>
				<div class="content-part4" id="space-audrol">
					<div class="numrollos-btns" id="btns-rollos">
					</div>
				</div>
				<div id="final-btn" style="display: block;">
					<div class="lineDecoration"></div>
					<!--
					<div>
						<div class="lbl">Resultado:</div>
						<select class="selectclass-min select-4" id="idResultado4" style="width: 150px; margin-bottom: 5px;">
							<option value="A">Aprobado</option>
							<option value="C">Aprobado no conforme</option>
							<option value="R">Rechazado</option>
						</select>
					</div>-->
					<div id="idRespon4" style="display:none;">
						<div class="lbl">Responsable: <span id="idRespon-4"></span></div>
						<div class="lbl">Encargado: <span id="idEncar-4"></span></div>
					</div>
					<div id="observacion4-res-4" style="display:none;">
						<div class="lbl">Observaci&oacute;n: <span id="observacion4-4"></span></div>
					</div>
					<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="finish_auditoria_tela()" id="button4">Terminar auditor&iacute;a</button>
				</div>
			</div>
			<div class="forms-content" id="form-5" style="display: none;">
				<div class="lbl">5. RESULTADO DE LA AUDITOR&Iacute;A (<span id="ResultadoFinal"></span>)</div>
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
				</div>
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
					<div class="content-table1">
						<div class="table-form" id="table1-2" style="margin: 5px 0px;">
							<div class="header-table">
								<div class="line-table">
									<div class="item-table item-main item1-1-1">CONTROL DE TONO - TACTO - PILLLING</div>
									<div class="item-table item-secondary item1-1-2">TSC</div>
									<div class="item-table item-secondary item1-1-3">REC. 1</div>
									<div class="item-table item-secondary item1-1-3">REC. 2</div>
								</div>
							</div>
							<div class="body-table" id="detalleres-form1">
							</div>
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
								<div class="item-table item2-main item2-1">C. APARIENCIA</div>
								<div class="item-table item2-secondary">TSC</div>
								<div class="item-table item2-secondary item2-3">REC.</div>
								<div class="item-table item2-secondary">CM.</div>
								<!--
								<div class="item-table item2-secondary">% CAIDA</div>-->
							</div>
						</div>
						<div class="body-table" id="detalleres-form2" style="position: relative;">
						</div>
					</div>
				</div>
				<div class="lbl" style="margin-top: 5px;">3. ESTABILIDAD DIMENSIONAL</div>
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
									<div class="item-table item3-2">TESTING</div>
									<div class="item-table item3-2">CONCLUSION</div>
									<div class="item-table item3-3">REC. 1</div>
									<!--
									<div class="item-table item3-2">% CAIDA</div>-->
								</div>
							</div>
							<div class="body-table" id="detalleres-form3" style="min-width: 1140px;">								
							</div>
						</div>
					</div>
				</div>
				<div class="lbl" style="margin-top: 5px;">4. CONTROL DE DEFECTOS</div>
				<div class="lbl">Calificaci&oacute;n: <span id="idcali-4-res">Aprobado</span></div>
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
				</div>
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="redirect('main.php')">Volver</button>
			</div>
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
				<div class="label-part">Estabilidad dimensional</div>
			</div>
			<div class="part-auditoria" id="redirect-4" onclick="show_form(4)">
				<div class="number-part">4</div>
				<div class="label-part">Control de defectos</div>
			</div>
			<div class="part-auditoria" id="redirect-5" onclick="show_form(5)">
				<div class="number-part">5</div>
				<div class="label-part">Resultado</div>
			</div>
		</div>	
	</div>
	<div class="miniform-content" id="modal-form2" style="display: none;">
		<div class="miniform-body">
			<div class="lbl">Seleccione defecto</div>
			<div class="lineDecoration"></div>
			<div class="sameline" style="margin-bottom: 5px;">
				<select class="selectclass-min" style="padding: 5px;" id="selectDefecto">
				</select>
			</div>
			<div class="sameline" style="margin-bottom: 5px;">
				<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;padding-top: 7px;">Puntuaci&oacute;n:</div>
				<input type="number" id="idPuntoDefecto" style="padding: 5px;width: calc(50% - 12px);" min="1" max="4" value="1">
			</div>
			<button class="btnPrimary" style="margin:auto;margin-top: 5px;" onclick="add_defecto()">Agregar</button>
			<button class="btnPrimary" style="margin:auto;margin-top: 5px;" onclick="hide_miniform('modal-form2')">Cancelar</button>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		var perfil_usu="<?php echo $_SESSION['perfil']; ?>";
		var codusu_v="<?php echo $_SESSION['user']; ?>";
		var partida="<?php echo $_GET['partida']; ?>";
		var codtel="<?php echo $_GET['codtel']; ?>";
		var codprv="<?php echo $_GET['codprv']; ?>";
		var numvez="<?php echo $_GET['numvez']; ?>";
		var parte="<?php echo $_GET['parte']; ?>";
		var codtad="<?php echo $_GET['codtad']; ?>";
		function add_defecto(){
			$("#table-defectos").fadeIn(200);
			var ar=$("#selectDefecto").val().split("-");
			if (document.getElementById("lbl-"+ar[1])==null) {
				var point=parseInt($("#idPuntoDefecto").val());
				var point1='';
				var point2='';
				var point3='';
				var point4='';
				var points=0;
				switch(point){
					case 1:point1=' mini-btn-active';
					points=1;
					break;
					case 2:point2=' mini-btn-active';
					points=2;
					break;
					case 3:point3=' mini-btn-active';
					points=3;
					break;
					case 4:point4=' mini-btn-active';
					points=4;
					break;
				}
				var html=
					'<div class="sameline classdefectos" style="margin-bottom: 5px;" id="lbl-'+ar[1]+'" data-coddef="'+ar[1]+'" data-points="'+points+'" data-peso="'+ar[2]+'">'+
						'<div class="lbl" style="width: 150px;padding-top: 5px;">'+ar[0]+'</div>'+
						'<div class="sameline puntuacion">'+
							'<div class="mini-btn btn-'+ar[1]+point1+'" id="btn-'+ar[1]+'-1" onclick="change_points('+ar[1]+',1)">1</div>'+
							'<div class="mini-btn btn-'+ar[1]+point2+'" id="btn-'+ar[1]+'-2" onclick="change_points('+ar[1]+',2)">2</div>'+
							'<div class="mini-btn btn-'+ar[1]+point3+'" id="btn-'+ar[1]+'-3" onclick="change_points('+ar[1]+',3)">3</div>'+
							'<div class="mini-btn btn-'+ar[1]+point4+'" id="btn-'+ar[1]+'-4" onclick="change_points('+ar[1]+',4)">4</div>'+
						'</div>'+
					'</div>';
				$("#table-defectos").append(html);
				hide_miniform('modal-form2');
			}else{
				alert("Ya existe ese defecto en la lista!");
			}
		}
		function change_points(coddef,point){
			var array=document.getElementsByClassName("btn-"+coddef);
			for (var i = 0; i < array.length; i++) {
				array[i].classList.remove("mini-btn-active");
			}
			document.getElementById("btn-"+coddef+"-"+point).classList.add("mini-btn-active");
			//document.getElementById("lbl-"+coddef).value=point;
			document.getElementById("lbl-"+coddef).dataset.points=point;
		}
		function open_form_defecto(){
			$("#modal-form2").fadeIn(200);
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
		}
		function show_numrollo(dom){
			var ar=document.getElementsByClassName("numrol");
			for (var i = 0; i < ar.length; i++) {
				if(ar[i].dataset.idbtn!=undefined){
					ar[i].classList.remove("numrol-active");
				}
			}
			if (dom.dataset.idbtn!=undefined) {
				$(".content-audrol").css("display","none");
				$("#audrol-"+dom.dataset.idbtn).css("display","block");
				numrol_uso=dom.dataset.idbtn;
				dom.classList.add("numrol-active");
			}
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
		var res_3_v="A";
		function autoevaluar3(){
			var cont_a=0;
			var cont_c=0;
			var cont_r=0;
			var array=document.getElementsByClassName("select-3");
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
				//$("#idcalificacion-3").text(text_rec);
				res_3_v="R";
				$("#idcalificacion-3").val(res_3_v);
			}else{
				if (cont_c>0) {
					//$("#idcalificacion-3").text(text_anc);
					res_3_v="C";
					$("#idcalificacion-3").val(res_3_v);
				}/*else{
					$("#idcalificacion-3").text(text_apr);
					res_3_v="A";
				}*/
			}/*
			if (cont_a==0 && cont_c==0 && cont_r==0) {
				$("#idcalificacion-3").text("-");
			}*/
		}
		function validate3(dom){
			var min=parseFloat(dom.dataset.min);
			var max=parseFloat(dom.dataset.max);
			var value=parseFloat(dom.value);
			var html='';
			if (value>=min && value<=max) {
				html+=
					'<option value="A">Aprobado</option>';
			}else{
				html+=
					'<option value="R">Rechazado</option>'+
					'<option value="C">Aprobado no conforme</option>';
			}
			$("#select-estdim-"+dom.dataset.estdim).empty();
			$("#select-estdim-"+dom.dataset.estdim).append(html);
			autoevaluar3();
		}
		function verify_content(text){
			if (text==undefined) {
				return '';
			}else{
				return text;
			}
		}
		var partida="<?php echo $_GET['partida']; ?>";
		var codtad_v;
		var numvez_v;
		var parte_v;
		var codprv_v;
		var aud_per=[];
		var rollos_v=0;
		var rollosaud_v=0;
		var numrollos_v=[];
		$(document).ready(function(){
			$("#idcalificacion-3").change(function(){
				var ar=document.getElementsByClassName("select-3");
				for (var i = 0; i < ar.length; i++) {
					ar[i].value=$("#idcalificacion-3").val();
				}
			});
			$("#idnumrollos").blur(function(){
				if (parseFloat($("#idnumrollos").val())<1) {
					alert("Ingrese un valor correcto!");
					$("#idnumrollos").val("");
					$("#idnumrollos").focus();
				}
			});
			$("#idPartida").text(partida);
			$.ajax({
				type:'POST',
				url:'config/getAuditoriaTela.php',
				data:{
					partida:partida,
					codtel:codtel,
					codprv:codprv,
					numvez:numvez,
					parte:parte,
					codtad:codtad
				},
				success:function(data){
					console.log(data);
					if (!data.button_creest) {
						$("#button-estcon2").remove();
						$("#button-estcon3").remove();
						$("#idEstCon").text("PENDIENTE");
					}
					if (!data.button_delest) {
						$("#button-canestcon2").remove();
						$("#button-canestcon3").remove();
						if (data.button_creest) {
							$("#label-estcon").remove();
							$("#detalle-adi-estcon").remove();
						}
					}
					if (!data.button_creest && !data.button_delest) {
						$("#idEstCon").text(data.ESTCON+"%");
					}
					$("#idDatColEstCon").text(data.DATCOL);
					$("#idMotEstCon").text(data.MOTIVO);

					if (!data.button_pendiente) {
						$("#button-pendiente").remove();
					}

					$("#idEstCliEstCon").text(data.partida.ESTILOCLI);		
					$("#idcmcprv").val(data.partida.CMCPRV);
					$("#idcmcwts").val(data.partida.CMCWTS);
					if (!data.btncmcwts) {
						$("#idcmcwts").attr("disabled",true);
						$("#idbtncmcwts").remove();
					}
					if (!data.btncmcprv) {
						$("#idcmcprv").attr("disabled",true);
						$("#idbtncmcprv").remove();
					}

					if (data.partida.OBSTON!="") {
						$("#observacion1-res").css("display","block");
						$("#observacion1").text(data.partida.OBSTON);
						$("#observacion1-res-1").css("display","block");
						$("#observacion1-1").text(data.partida.OBSTON);
					}
					if (data.partida.OBSAPA!="") {
						$("#observacion2-res").css("display","block");
						$("#observacion2").text(data.partida.OBSAPA);
						$("#observacion2-res-2").css("display","block");
						$("#observacion2-2").text(data.partida.OBSAPA);
					}
					if (data.partida.OBSESTDIM!="") {
						$("#observacion3-res").css("display","block");
						$("#observacion3").text(data.partida.OBSESTDIM);
						$("#observacion3-res-3").css("display","block");
						$("#observacion3-3").text(data.partida.OBSESTDIM);
					}
					if (data.partida.OBSDEF!="") {
						$("#observacion4-res").css("display","block");
						$("#observacion4").text(data.partida.OBSDEF);
						$("#observacion4-res-4").css("display","block");
						$("#observacion4-4").text(data.partida.OBSDEF);
					}

					if (data.partida.RESTONEJETSC!=null) {
						$("#idRes1").css("display","block");
						$("#idResponsable-1").text(data.partida.CODUSUTONEJETSC);
					}

					if (data.partida.RESAPAEJETSC!=null) {
						$("#idRes2").css("display","block");
						$("#idResponsable-2").text(data.partida.CODUSUAPAEJETSC);
					}

					if (data.partida.RESESTDIMEJETSC!=null) {
						$("#idRes3").css("display","block");
						$("#idResponsable-3").text(data.partida.CODUSUESTDIMEJETSC);
					}

					if (data.partida.RESROLLOEJETSC!=null) {
						$("#idRes4").css("display","block");
						$("#idResponsable-4").text(data.partida.CODUSUROLLOEJETSC);
					}

					if (data.partida.CODUSUTONAUDTSC!=null) {
						$("#idAud1").css("display","block");
						$("#idAuditor-1").text(data.partida.CODUSUTONAUDTSC);
					}

					if (data.partida.CODUSUAPAAUDTSC!=null) {
						$("#idAud2").css("display","block");
						$("#idAuditor-2").text(data.partida.CODUSUAPAAUDTSC);
					}

					if (data.partida.CODUSUESTDIMAUDTSC!=null) {
						$("#idAud3").css("display","block");
						$("#idAuditor-3").text(data.partida.CODUSUESTDIMAUDTSC);
					}

					if (data.partida.CODUSUROLLOAUDTSC!=null) {
						$("#idAud4").css("display","block");
						$("#idAuditor-4").text(data.partida.CODUSUROLLOAUDTSC);
					}

					/////RESPONSABLES
					if (data.partida.RES1!="") {
						$("#idRespon1").css("display","block");
						$("#idRespon-1").text(data.partida.RES1);
						$("#idEncar-1").text(data.partida.NOMENC1);
						$("#idRespon1-res").css("display","block");
						$("#idRespon-1-res").text(data.partida.RES1);
						$("#idEncar-1-res").text(data.partida.NOMENC1);
					}

					if (data.partida.RES2!="") {
						$("#idRespon2").css("display","block");
						$("#idRespon-2").text(data.partida.RES2);
						$("#idEncar-2").text(data.partida.NOMENC2);
						$("#idRespon2-res").css("display","block");
						$("#idRespon-2-res").text(data.partida.RES2);
						$("#idEncar-2-res").text(data.partida.NOMENC2);
					}

					if (data.partida.RES3!="") {
						$("#idRespon3").css("display","block");
						$("#idRespon-3").text(data.partida.RES3);
						$("#idEncar-3").text(data.partida.NOMENC3);
						$("#idRespon3-res").css("display","block");
						$("#idRespon-3-res").text(data.partida.RES3);
						$("#idEncar-3-res").text(data.partida.NOMENC3);
					}

					$("#idcali-4-res").text(procesarResultado(data.partida.RESROLLOTSC));

					if (data.partida.RES4!="") {
						$("#idRespon4").css("display","block");
						$("#idRespon-4").text(data.partida.RES4);
						$("#idEncar-4").text(data.partida.NOMENC4);
						$("#idRespon4-res").css("display","block");
						$("#idRespon-4-res").text(data.partida.RES3);
						$("#idEncar-4-res").text(data.partida.NOMENC3);
					}

					$("#ResultadoFinal").text(procesarResultado(data.partida.RESULTADO));
					$("#idPuntajePartida").text(data.partida.CALIFICACION);
					$("#idTipoPartida").text(data.partida.TIPO);
					$("#idKGPar").text(data.partida.PESO);
					$("#idKGParPor").text("100%");
					$("#idKGAud").text(data.partida.PESOAUD);
					$("#idKGAudPor").text(Math.round(data.partida.PESOAUD*10000/data.partida.PESO)/100+"%");
					$("#idKGApr").text(data.partida.PESOAPRO);
					$("#idKGAprPor").text(Math.round(data.partida.PESOAPRO*10000/data.partida.PESO)/100+"%");
					$("#idKGCai").text(data.partida.PESOCAI);
					$("#idKGCaiPor").text(Math.round(data.partida.PESOCAI*10000/data.partida.PESO)/100+"%");

					$("#idResultado4").val(data.partida.RESULTADO);
					/*
					var html='';
					for (var i = 0; i < data.observaciones1.length; i++) {
						html+='<div class="lineObservacion" id="obs-'+data.observaciones1[i].CODTIPOB+'-'+data.observaciones1[i].CODOBS+'">'+data.observaciones1[i].DESOBS+'</div>';
					}
					$("#tbl-observacion-1").append(html);
					var html='';
					for (var i = 0; i < data.observaciones2.length; i++) {
						html+='<div class="lineObservacion" id="obs-'+data.observaciones2[i].CODTIPOB+'-'+data.observaciones2[i].CODOBS+'">'+data.observaciones2[i].DESOBS+'</div>';
					}
					$("#tbl-observacion-2").append(html);
					var html='';
					for (var i = 0; i < data.observaciones3.length; i++) {
						html+='<div class="lineObservacion" id="obs-'+data.observaciones3[i].CODTIPOB+'-'+data.observaciones3[i].CODOBS+'">'+data.observaciones3[i].DESOBS+'</div>';
					}
					$("#tbl-observacion-3").append(html);
					var html='';
					for (var i = 0; i < data.observaciones4.length; i++) {
						html+='<div class="lineObservacion" id="obs-'+data.observaciones4[i].CODTIPOB+'-'+data.observaciones4[i].CODOBS+'">'+data.observaciones4[i].DESOBS+'</div>';
					}
					$("#tbl-observacion-4").append(html);
					
					for (var i = 0; i < parseInt(data.numform); i++) {
						aud_per.push(i+1);
					}
					show_form(parseInt(data.numform));*/

					if(data.res1!=null &&
						data.res2!=null &&
						data.res3!=null &&
						data.partida.FECFINAUD!=null){
						show_form(5);
					}

					$("#selectDefecto").empty();
					var html='';
					for (var i = 0; i < data.defectos.length; i++) {
						html+=
						'<option value="'+data.defectos[i].DESDEF+'-'+data.defectos[i].CODDEF+'-'+data.defectos[i].PESO+'">'+data.defectos[i].DESDEF+'</option>';
					}/*
					if (data.partida.block=="0" || data.partida.editable=="0") {
						if (!(perfil_usu=="2" && data.partida.editable=="1")) {
							$("#button1").remove();
							$("#button2").remove();
							$("#button3").remove();
							$("#button4").remove();
						}
					}*/
					$("#selectDefecto").append(html);
					codtad_v=codtad;
					numvez_v=numvez;
					parte_v=parte;
					codprv_v=codprv;
					rollos_v=parseInt(data.partida.ROLLOS);
					$("#idnumerorollos").text(rollos_v);
					rollosaud_v=parseInt(data.partida.ROLLOSAUD);
					$("#idrolaud").text(rollosaud_v);
					$("#idCliente").text(data.partida.DESCLI);
					$("#idProveedor").text(data.partida.DESPRV);
					$("#idCodtela").text(data.partida.CODTEL);
					$("#idArticulo").text(data.partida.DESTEL);
					$("#idCodCol").text(data.partida.CODCOL);
					$("#idColor").text(data.partida.DSCCOL);
					$("#idComposicion").text(data.partida.COMPOS);
					$("#idPrograma").text(data.partida.PROGRAMA);
					$("#idXFactory").text(data.partida.XFACTORY);
					$("#idDestino").text(data.partida.DESTINO);
					$("#idPesoPartida").text(data.partida.PESO);
					$("#idPesoPrg").text(data.partida.PESOPRG);
					$("#idcalificacion4").text(data.partida.CALIFICACION);					
					$("#idRendimiento").text(data.partida.RENDIMIENTO+" (metros: "+data.partida.RENMET+")");

					let realmetros = parseFloat(data.partida.RENDIMIENTOREAL) * parseFloat(data.partida.PESO);

					$("#idRendimientoReal").text(data.partida.RENDIMIENTOREAL+" (metros: "+realmetros.toFixed(2)+")");

					$("#idAuditor").text(data.partida.CODUSU);
					$("#idSupervisor").text(data.partida.CODUSUEJE);
					$("#idfecini").text(data.partida.FECINIAUD);
					$("#idfecfin").text(data.partida.FECFINAUD);
					$("#idruttel").text(data.partida.RUTA)
					if (data.partida.ROLLOSAUD==null) {
						
					}else{
						var html='';
						for (var i = 0; i < parseInt(data.partida.ROLLOS); i++) {
							html+='<div class="numrol numrol-disabled" id="btnrollo-'+(i+1)+'">'+(i+1)+'</div>';
						}
						html+=
						'<script type="text/javascript">'+
							'$(".numrol").click(function(){'+
								'show_numrollo(this);'+
							'});';
						$("#btns-rollos").append(html);
						$("#form-rollos").css("display","none");
						$("#form-rollo-defectos").css("display","block");
						var html2='';
						numrollos_v=data.numrollos;
						var htmld='';
						for (var i = 0; i < numrollos_v.length; i++) {
							if (numrollos_v[i].ESTADO=="O") {
								htmld+=
								'<div class="line-table">'+
									'<div class="item-table item3-2" style="width:20%">'+numrollos_v[i].NUMROL+'</div>'+
									'<div class="item-table item3-2" style="width:20%">'+numrollos_v[i].ESTADO+'</div>'+
									'<div class="item-table item3-2" style="width:20%">'+numrollos_v[i].CALIFICACION+'</div>'+
									'<div class="item-table item3-2" style="width:20%">'+numrollos_v[i].PUNTOS+'</div>'+
									'<div class="item-table item3-2" style="width:20%">'+numrollos_v[i].PUNTOSDEF+'</div>'+
								'</div>';
							}
							
							document.getElementById("btnrollo-"+numrollos_v[i].NUMROL).classList.remove("numrol-disabled");
							document.getElementById("btnrollo-"+numrollos_v[i].NUMROL).dataset.idbtn=numrollos_v[i].NUMROL;
							var display='none';
							if(i==0){
								document.getElementById("btnrollo-"+numrollos_v[i].NUMROL).classList.add("numrol-active");
								display='block';
								numrol_uso=numrollos_v[i].NUMROL;
							}

							html2+=
							'<div class="content-audrol" id="audrol-'+numrollos_v[i].NUMROL+'" style="display:'+display+';">'+
								'<div style="display: flex;">'+
									'<div style="width: calc(50% - 3px);">'+
										'<div class="sameline" style="margin-bottom: 5px;">'+
											'<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;padding-top: 7px;">N° rollo:</div>'+
											'<input type="number" id="idNumRolloNew-'+numrollos_v[i].NUMROL+'" style="padding: 5px;width: 50px;" disabled value="'+numrollos_v[i].NUMROL+'">'+
										'</div>'+
										'<div class="sameline" style="margin-bottom: 5px;">'+
											'<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;padding-top: 7px;">Ancho sin reposo (cm):</div>'+
											'<input type="number" id="idancsinrep-'+numrollos_v[i].NUMROL+'" style="padding: 5px;width: calc(50% - 12px);" min="0" value="'+numrollos_v[i].ANCSINREP+'">'+
										'</div>'+
										'<div class="sameline" style="margin-bottom: 5px;">'+
											'<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;padding-top: 7px;">Densidad sin reposo (gr/cm2):</div>'+
											'<input type="number" id="iddensinrep-'+numrollos_v[i].NUMROL+'" style="padding: 5px;width: calc(50% - 12px);" min="0" value="'+numrollos_v[i].DENSINREP+'">'+
										'</div>'+
										'<div class="sameline" style="margin-bottom: 5px;">'+
											'<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;padding-top: 7px;">Peso por rollo (kg):</div>'+
											'<input type="number" id="idpesporrol-'+numrollos_v[i].NUMROL+'" style="padding: 5px;width: calc(50% - 12px);" min="0" value="'+numrollos_v[i].PESO+'">'+
										'</div>'+
										'<div class="sameline" style="margin-bottom: 5px;">'+
											'<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;padding-top: 7px;">Metros (m):</div>'+
											'<input type="number" id="idmetros-'+numrollos_v[i].NUMROL+'" style="padding: 5px;width: calc(50% - 12px);" min="0" value="'+numrollos_v[i].METLIN+'">'+
										'</div>'+
										'<div class="sameline" style="margin-bottom: 5px;">'+
											'<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;padding-top: 7px;">Ancho total (cm):</div>'+
											'<input type="number" id="idanctot-'+numrollos_v[i].NUMROL+'" style="padding: 5px;width: calc(50% - 12px);" min="0" value="'+numrollos_v[i].ANCTOT+'">'+
										'</div>'+
										'<div class="sameline" style="margin-bottom: 5px;">'+
											'<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;padding-top: 7px;">Ancho util con reposo (cm):</div>'+
											'<input type="number" id="idancuti-'+numrollos_v[i].NUMROL+'" style="padding: 5px;width: calc(50% - 12px);" min="0" value="'+numrollos_v[i].ANCUTI+'">'+
										'</div>'+
										'<div class="sameline" style="margin-bottom: 5px;">'+
											'<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;padding-top: 7px;">Inclinaci&oacute;n std.:</div>'+
											'<input type="number" id="idincstd-'+numrollos_v[i].NUMROL+'" style="padding: 5px;width: calc(50% - 12px);" min="0" value="'+numrollos_v[i].INCSTD+'">'+
										'</div>	'+
									'</div>'+
									'<div style="width: 5px;"></div>'+
									'<div style="width: calc(50% - 2px);">'+
										'<div class="sameline" style="margin-bottom: 5px;">'+
											'<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;padding-top: 7px;">Inclinaci&oacute;n der.:</div>'+
											'<input type="number" id="idincder-'+numrollos_v[i].NUMROL+'" style="padding: 5px;width: calc(50% - 12px);" min="0" value="'+numrollos_v[i].INCDER+'">'+
										'</div>'+
										'<div class="sameline" style="margin-bottom: 5px;">'+
											'<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;padding-top: 7px;">Inclinaci&oacute;n iza.:</div>'+
											'<input type="number" id="idinciza-'+numrollos_v[i].NUMROL+'" style="padding: 5px;width: calc(50% - 12px);" min="0" value="'+numrollos_v[i].INCIZQ+'">'+
										'</div>'+
										'<div class="sameline" style="margin-bottom: 5px;">'+
											'<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;padding-top: 7px;">Inclinaci&oacute;n med.:</div>'+
											'<input type="number" id="idincmed-'+numrollos_v[i].NUMROL+'" style="padding: 5px;width: calc(50% - 12px);" min="0" value="'+numrollos_v[i].INCMED+'">'+
										'</div>'+
										'<div class="sameline" style="margin-bottom: 5px;">'+
											'<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;padding-top: 7px;"> Rapport (cm):</div>'+
											'<input type="text" id="idrapport-'+numrollos_v[i].NUMROL+'" style="padding: 5px;width: calc(50% - 12px);" min="0" value="'+numrollos_v[i].RAPPORT+'">'+
										'</div>'+
										'<div class="sameline" style="margin-bottom: 5px;">'+
											'<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;padding-top: 7px;">Puntos por rollo:</div>'+
											'<input type="number" id="idpuntos-'+numrollos_v[i].NUMROL+'" style="padding: 5px;width: calc(50% - 12px);" min="0" value="'+numrollos_v[i].PUNTOS+'" disabled>'+
										'</div>'+
										'<div class="sameline" style="margin-bottom: 5px;">'+
											'<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;padding-top: 7px;">Calificaci&oacute;n:</div>'+
											'<input type="text" id="idcalificacion-'+numrollos_v[i].NUMROL+'" style="padding: 5px;width: calc(50% - 12px);" min="0" value="'+verify_content(numrollos_v[i].CALIFICACION)+'" disabled>'+
										'</div>'+
									'</div>'+
								'</div>'+
								'<button class="btnPrimary btntonotshow" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="validate_form4(\''+numrollos_v[i].NUMROL+'\')">Guardar</button>'+
								'<div class="lineDecoration"></div>'+
								'<div class="table-defectos">'+
									'<div class="header-table">'+
										'<div class="line-table">'+
											'<div class="item-table" style="width:calc(40% - 62px);">&Aacute;rea</div>'+
											'<div class="item-table" style="width:calc(40% - 62px);">Defecto</div>'+
											'<div class="item-table" style="width:calc(20% - 12px);">Puntaje por Defecto</div>'+
											'<div class="item-table" style="width:calc(100px - 12px);">Cantidad</div>'+
										'</div>'+
									'</div>'+
									'<div class="body-table" id="content-defectos-'+numrollos_v[i].NUMROL+'">';
							var cantidadPuntos=0;
							for (var j = 0; j < numrollos_v[i].DEFECTOS.length; j++) {
								html2+=
										'<div class="line-table" id="defecto-'+numrollos_v[i].NUMROL+'-'+numrollos_v[i].DEFECTOS[j].CODDEF+'">'+
											'<div class="item-table" style="width:calc(40% - 62px);">'+numrollos_v[i].DEFECTOS[j].DESARE+'</div>'+
											'<div class="item-table" style="width:calc(40% - 62px);">'+numrollos_v[i].DEFECTOS[j].DESDEF+'</div>'+
											'<div class="item-table" style="width:calc(20% - 12px);">'+numrollos_v[i].DEFECTOS[j].PESO+'</div>'+
											'<div class="item-table" style="width:calc(100px - 12px);display:flex;">'+
												'<div class="btn-add" onclick="edit_value('+numrollos_v[i].NUMROL+','+numrollos_v[i].DEFECTOS[j].CODDEF+',1,'+numrollos_v[i].DEFECTOS[j].PESO+')">'+
													'<span id="numdefrol-'+numrollos_v[i].NUMROL+'-'+numrollos_v[i].DEFECTOS[j].CODDEF+'">'+numrollos_v[i].DEFECTOS[j].CANTIDAD+'</span>'+
												'</div>'+
												'<div class="btn-minus" onclick="edit_value('+numrollos_v[i].NUMROL+','+numrollos_v[i].DEFECTOS[j].CODDEF+',0,'+numrollos_v[i].DEFECTOS[j].PESO+')">'+
													'<i class="fa fa-minus" aria-hidden="true"></i>'+
												'</div>'+
											'</div>'+
										'</div>';
								cantidadPuntos+=parseInt(numrollos_v[i].DEFECTOS[j].CANTIDAD)*parseInt(numrollos_v[i].DEFECTOS[j].PESO);
							}
							html2+=
									'</div>'+
									'<div class="header-table">'+
										'<div class="line-table">'+
											'<div class="item-table" style="width:calc(80% - 112px);background:transparent;"></div>'+
											'<div class="item-table" style="width:calc(20% - 12px);">Total puntaje</div>'+
											'<div class="item-table" style="width:calc(100px - 12px);text-align:center;"><span id="puntot-'+numrollos_v[i].NUMROL+'">'+cantidadPuntos+'</span></div>'+
										'</div>'+
									'</div>'+
								'</div>'+
								/*'<div class="btn-addrollo" onclick="open_form_defecto()" style="margin-bottom: 5px;font-size: 13px;text-align: right;">Agregar defecto</div>'+*/
							'</div>';
						}
						$("#space-audrol").append(html2);

						if (htmld!="") {
							$("#detalleres4").css("display","block");
							$("#detalleres-form4").empty();
							$("#detalleres-form4").append(htmld);
						}
					}
					var html='';
					var option_select='';
					if (perfil_usu=="2") {
						option_select='<option value="C">Aprobado no conforme</option>';
					}
					for (var i = 0; i < data.tonos.length; i++) {
						html+=
						'<div class="line-table lines-tono" id="line-1-'+data.tonos[i].CODTON+'">'+
							'<div class="item-table item-main item1-1-1">'+data.tonos[i].DESTON+'</div>'+
							'<div class="item-table item-secondary item1-1-2">'+
								'<select class="selectclass-min select-1" id="select1-'+data.tonos[i].CODTON+'" data-codton="'+data.tonos[i].CODTON+'">'+
									'<option value="A">Aprobado</option>'+
									option_select+
									'<option value="R">Rechazado</option>'+
								'</select>'+
							'</div>'+
							'<div class="item-table item-secondary item1-1-3" id="item1-1-'+data.tonos[i].CODTON+'">'+
								'<select class="selectclass-min" id="select1-1-'+data.tonos[i].CODTON+'" data-codton="'+data.tonos[i].CODTON+'">'+
								'</select>'+
							'</div>'+
							'<div class="item-table item-secondary item1-1-3" id="item1-2-'+data.tonos[i].CODTON+'">'+
								'<select class="selectclass-min" id="select1-2-'+data.tonos[i].CODTON+'" data-codton="'+data.tonos[i].CODTON+'">'+
								'</select>'+
							'</div>'+
						'</div>';						
					}
					html+=
					'<script type="text/javascript">'+
						'$(".select-1").change(function(){'+
							'autoevaluar1();'+
						'});';
					$("#form1").append(html);
					var html='';
					var antaredef='';
					for (var i = 0; i < data.apariencia.length; i++) {
						html+=
						'<div class="line-table line-apa-area">'+
							'<div class="item-table item2-submain item2-headerrow">'+data.apariencia[i].DSCAREAD+'</div>'+
							'<div class="content-row">'+
								'<div class="line-table lines-apariencia" id="line-2-'+data.apariencia[i].CODAPA+'" style="display:none;">'+
									'<div class="item-table itemr2-main">'+data.apariencia[i].DESAPA+'</div>'+
									'<div class="item-table itemr2-secondary">'+
										'<select class="selectclass-min select-2" id="select2-'+data.apariencia[i].CODAPA+'" data-codapa="'+data.apariencia[i].CODAPA+'">'+
											'<option value="A">Aprobado</option>'+
											'<option value="C">Aprobado no conforme</option>'+
											'<option value="R">Rechazado</option>'+
										'</select>'+
									'</div>'+
									'<div class="item-table itemr2-secondary item2-3" id="itemrec2-2-'+data.apariencia[i].CODAPA+'">'+
										'<select class="selectclass-min" id="select2-1-'+data.apariencia[i].CODAPA+'" data-codapa="'+data.apariencia[i].CODAPA+'">'+
										'</select>'+
									'</div>'+
									'<div class="item-table itemr2-secondary">'+
										'<input type="number" id="input2-2-'+data.apariencia[i].CODAPA+'" class="input" data-estdim="'+data.apariencia[i].CODAPA+'" value="0" disabled>'+
									'</div>'+
									/*
									'<div class="item-table itemr2-secondary">'+
										'<input type="number" id="input2-3-'+data.apariencia[i].CODAPA+'" class="input" data-estdim="'+data.apariencia[i].CODAPA+'" value="0" disabled>'+
									'</div>'+*/
								'</div>'+
							'</div>'+
						'</div>';	
					}
					html+=
					'<script type="text/javascript">'+
						'$(".select-2").change(function(){'+
							'autoevaluar2();'+
						'});';
					$("#form2").append(html);

					var html='';
					for (var i = 0; i < data.estdim.length; i++) {
						var tol='';
						var tol_negativa='';
						var min;
						var max;

						// TOLERANCIA
						if (parseInt(data.estdim[i].TOLERANCIA)!=0) {
							tol='+ '+data.estdim[i].TOLERANCIA+' '+data.estdim[i].DIMTOL;
						}else{
							tol=data.estdim[i].TOLERANCIA;
						}

						// TOLEERANCIA NEGATIVA
						if (parseInt(data.estdim[i].TOLERANCIA_NEGATIVA)!=0) {
							tol_negativa='- '+data.estdim[i].TOLERANCIA_NEGATIVA+' '+data.estdim[i].DIMTOL;
						}else{
							tol_negativa=data.estdim[i].TOLERANCIA_NEGATIVA;
						}

						var val='';
						if (data.estdim[i].DIMVAL=="%") {
							/*
							val=parseFloat('0'+data.estdim[i].VALOR)*100+' '+data.estdim[i].DIMVAL;
							min=parseFloat('0'+data.estdim[i].VALOR)*100-parseFloat(data.estdim[i].TOLERANCIA);
							max=parseFloat('0'+data.estdim[i].VALOR)*100+parseFloat(data.estdim[i].TOLERANCIA);*/							
							// val=parseFloat('0'+data.estdim[i].VALOR)+' '+data.estdim[i].DIMVAL;
							// min=parseFloat('0'+data.estdim[i].VALOR)-parseFloat(data.estdim[i].TOLERANCIA);
							// max=parseFloat('0'+data.estdim[i].VALOR)+parseFloat(data.estdim[i].TOLERANCIA);
							var valor=parseFloat('0'+data.estdim[i].VALOR);
							val=parseFloat('0'+data.estdim[i].VALOR)+' '+data.estdim[i].DIMVAL;
							min=valor-parseFloat(data.estdim[i].TOLERANCIA_NEGATIVA);
							max=valor+parseFloat(data.estdim[i].TOLERANCIA);

						}else{
							val=data.estdim[i].VALOR;
							if (data.estdim[i].DIMTOL=="%") {
								min=parseFloat(data.estdim[i].VALOR)-parseFloat(data.estdim[i].VALOR)*parseFloat(data.estdim[i].TOLERANCIA_NEGATIVA)/100;
								max=parseFloat(data.estdim[i].VALOR)+parseFloat(data.estdim[i].VALOR)*parseFloat(data.estdim[i].TOLERANCIA)/100;
								// min=parseFloat(data.estdim[i].VALOR)-parseFloat(data.estdim[i].VALOR)*parseFloat(data.estdim[i].TOLERANCIA)/100;
								// max=parseFloat(data.estdim[i].VALOR)+parseFloat(data.estdim[i].VALOR)*parseFloat(data.estdim[i].TOLERANCIA)/100;
							}else{
								min=parseFloat(data.estdim[i].VALOR)-parseFloat(data.estdim[i].TOLERANCIA_NEGATIVA);
								max=parseFloat(data.estdim[i].VALOR)+parseFloat(data.estdim[i].TOLERANCIA);
								// min=parseFloat(data.estdim[i].VALOR)-parseFloat(data.estdim[i].TOLERANCIA);
								// max=parseFloat(data.estdim[i].VALOR)+parseFloat(data.estdim[i].TOLERANCIA);
							}
						}
						html+=
							'<div class="line-table" id="line-estdim-'+data.estdim[i].CODESTDIM+'">'+
								'<div class="item-table item3-1">'+data.estdim[i].DESESTDIM+'</div>'+
								'<div class="item-table item3-2">'+tol+'</div>'+
								'<div class="item-table item3-2">'+tol_negativa+'</div>'+
								'<div class="item-table item3-2">'+val+'</div>'+
								'<div class="item-table item3-2">'+
									'<input type="number" id="" class="">'+
								'</div>'+
								'<div class="item-table item3-2">'+
									'<input type="number" id="aud3-'+data.estdim[i].CODESTDIM+'" class="input-validate" data-min="'+min+'" data-max="'+max+'" data-estdim="'+data.estdim[i].CODESTDIM+'" value="0">'+
								'</div>'+
								'<div class="item-table item3-2">'+data.estdim[i].TESTING+'</div>'+
								'<div class="item-table item3-2">'+
									'<select class="selectclass-min select-3" id="select-estdim-'+data.estdim[i].CODESTDIM+'" data-codestdim="'+data.estdim[i].CODESTDIM+'">'+
										'<option value="A">Aprobado</option>'+
										'<option value="C">Aprobado no conforme</option>'+
										'<option value="R">Rechazado</option>'+
									'</select>'+
								'</div>'+
								'<div class="item-table item3-3" id="itemrec3-3-'+data.estdim[i].CODESTDIM+'">'+
									'<select class="selectclass-min select-3-1" id="select-estdim-1-'+data.estdim[i].CODESTDIM+'" data-codestdim="'+data.estdim[i].CODESTDIM+'">'+
									'</select>'+
								'</div>'+
								/*
								'<div class="item-table item3-2">'+
									'<input type="number" id="input3-2-'+data.estdim[i].CODESTDIM+'" class="input" data-estdim="'+data.estdim[i].CODESTDIM+'" value="0">'+
								'</div>'+*/
							'</div>';
					}
					html+=
					'<script type="text/javascript">'+
						'$(".input-validate").keyup(function(){'+
							//'validate3(this);'+
						'});'+
						'$(".select-3").change(function(){'+
							//'autoevaluar3();'+
						'});';
					$("#form3").append(html);
					if (data.res1!=null) {
						/*
						for (var i = 0; i < data.detalle1.length; i++) {
							$("#select1-"+data.detalle1[i].CODTON).val(data.detalle1[i].RESTSC);
						}*/
						res_1_v=data.res1;
						$("#idcalificacion-1").text(procesarResultado(data.res1));
						$("#idcali-1-res").text(procesarResultado(data.res1));
						var htmld='';
						for (var i = 0; i < data.detalle1.length; i++) {
							htmld+=
							'<div class="line-table">'+
								'<div class="item-table item-main item1-1-1">'+data.detalle1[i].DESTON+'</div>'+
								'<div class="item-table item-secondary item1-1-2">ANC</div>'+
								'<div class="item-table item-secondary item1-1-3">'+data.detalle1[i].DESREC1+'</div>'+
								'<div class="item-table item-secondary item1-1-3">'+data.detalle1[i].DESREC2+'</div>'+
							'</div>';
							/*if (data.detalle1[i].RESTSC!="R") {
								$("#line-1-"+data.detalle1[i].CODTON).remove();
							}else{
								$("#select1-"+data.detalle1[i].CODTON).val(data.detalle1[i].RESTSC);
							}
							if (data.detalle1[i].DESREC1!="") {
								$("#select1-1-"+data.detalle1[i].CODTON).append('<option>'+data.detalle1[i].DESREC1+'</option>')
							}
							if (data.detalle1[i].DESREC2!="") {
								$("#select1-2-"+data.detalle1[i].CODTON).append('<option>'+data.detalle1[i].DESREC2+'</option>')
							}*/
							$("#line-1-"+data.detalle1[i].CODTON).removeClass("lines-tono");
							$("#select1-"+data.detalle1[i].CODTON).val(data.detalle1[i].RESTSC);
							$("#select1-1-"+data.detalle1[i].CODTON).empty();
							$("#select1-1-"+data.detalle1[i].CODTON).append('<option>'+data.detalle1[i].DESREC1+'</option>');
							document.getElementById("item1-1-"+data.detalle1[i].CODTON).innerHTML=data.detalle1[i].DESREC1;
							$("#select1-2-"+data.detalle1[i].CODTON).empty();
							$("#select1-2-"+data.detalle1[i].CODTON).append('<option>'+data.detalle1[i].DESREC2+'</option>');
							document.getElementById("item1-2-"+data.detalle1[i].CODTON).innerHTML=data.detalle1[i].DESREC2;
						}
						if (data.res1=="C") {
							$("#detalleres1").css("display","block");
							$("#detalleres-form1").empty();
							$("#detalleres-form1").append(htmld);
						}
					}else{
						$("#form1").empty();
					}
					if (data.res2!=null) {
						res_2_v=data.res2;
						$("#idcalificacion-2").text(procesarResultado(data.res2));
						$("#idcali-2-res").text(procesarResultado(data.res2));
						/*for (var i = 0; i < data.detalle2.length; i++) {
							$("#select2-"+data.detalle2[i].CODAPA).val(data.detalle2[i].RESTSC);
						}*/
						var htmld='';
						for (var i = 0; i < data.detalle2.length; i++) {
							htmld+=
							'<div class="line-table">'+
								'<div class="item-table item2-submain item2-headerrow">'+data.detalle2[i].DSCAREAD+'</div>'+
								'<div class="content-row">'+
									'<div class="line-table">'+
										'<div class="item-table itemr2-main item-toshow item2-1">'+data.detalle2[i].DESAPA+'</div>'+
										'<div class="item-table itemr2-secondary">ANC</div>'+
										'<div class="item-table itemr2-secondary item2-3">'+data.detalle2[i].DESREC1+'</div>'+
										'<div class="item-table itemr2-secondary">'+data.detalle2[i].CM+'</div>'+
										//'<div class="item-table itemr2-secondary">'+data.detalle2[i].CAIDA+'</div>'+
									'</div>'+
								'</div>'+
							'</div>';
							/*if (data.detalle2[i].RESTSC!="R") {
								$("#line-2-"+data.detalle2[i].CODAPA).remove();
							}else{
								$("#select2-"+data.detalle2[i].CODAPA).val(data.detalle2[i].RESTSC);
							}
							if (data.detalle2[i].DESREC1!="") {
								$("#select2-1-"+data.detalle2[i].CODAPA).append('<option>'+data.detalle2[i].DESREC1+'</option>');
								$("#input2-2-"+data.detalle2[i].CODAPA).val(data.detalle2[i].CM);
								$("#input2-3-"+data.detalle2[i].CODAPA).val(data.detalle2[i].CAIDA);
							}*/

							$("#select2-"+data.detalle2[i].CODAPA).val(data.detalle2[i].RESTSC);
							$("#line-2-"+data.detalle2[i].CODAPA).css("display","flex");
							if (data.detalle2[i].DESREC1!="") {
								//$("#select2-1-"+data.detalle2[i].CODAPA).append('<option>'+data.detalle2[i].DESREC1+'</option>');
								$("#input2-2-"+data.detalle2[i].CODAPA).val(data.detalle2[i].CM);
								$("#input2-3-"+data.detalle2[i].CODAPA).val(data.detalle2[i].CAIDA);
								$("#select2-1-"+data.detalle2[i].CODAPA).append('<option>'+data.detalle2[i].DESREC1+'</option>');
								document.getElementById("itemrec2-2-"+data.detalle2[i].CODAPA).innerHTML=data.detalle2[i].DESREC1;
							}else{
								document.getElementById("itemrec2-2-"+data.detalle2[i].CODAPA).innerHTML="";
							}
						}
						if (data.res2=="C") {
							$("#detalleres2").css("display","block");
							$("#detalleres-form2").empty();
							$("#detalleres-form2").append(htmld);
						}
					}else{
						$("#form2").empty();
					}
					if (data.res3!=null) {
						res_3_v=data.res3;
						//$("#idcalificacion-3").text(procesarResultado(data.res3));
						$("#idcalificacion-3").val(data.res3);
						$("#idcali-3-res").text(procesarResultado(data.res3));
						var htmld='';
						for (var i = 0; i < data.detalle3.length; i++) {
							if (data.detalle3[i].RESTSC=="R") {
								document.getElementById("line-estdim-"+data.detalle3[i].CODESTDIM).style.background="#d09292";
							}
							if (data.detalle3[i].RESTSC=="C") {
								var tol='';
								if (parseInt(data.estdim[i].TOLERANCIA)!=0) {
									tol='+/- '+data.estdim[i].TOLERANCIA+' '+data.estdim[i].DIMTOL;
								}else{
									tol=data.estdim[i].TOLERANCIA;
								}
								var val='';
								if (data.estdim[i].DIMVAL=="%") {
									val=parseFloat('0'+data.estdim[i].VALOR)+' '+data.estdim[i].DIMVAL;
								}else{
									val=data.estdim[i].VALOR;
								}
								htmld+=
								'<div class="line-table">'+
									'<div class="item-table item3-1">'+data.detalle3[i].DESESTDIM+'</div>'+
									'<div class="item-table item3-2">'+tol+'</div>'+
									'<div class="item-table item3-2">'+val+'</div>'+
									'<div class="item-table item3-2">'+data.detalle3[i].VALORPRV+'</div>'+
									'<div class="item-table item3-2">'+data.detalle3[i].VALORTSC+'</div>'+
									'<div class="item-table item3-2">'+data.detalle3[i].TESTING+'</div>'+
									'<div class="item-table item3-2">ANC</div>'+
									'<div class="item-table item3-3">'+data.detalle3[i].DESREC1+'</div>'+
									//'<div class="item-table item3-2">'+data.detalle3[i].CAIDA+'</div>'+
								'</div>';
								console.log(data.detalle3[i].DESREC1);
							}
							$("#aud3-"+data.detalle3[i].CODESTDIM).val(data.detalle3[i].VALORTSC);
							$("#aud3-"+data.detalle3[i].CODESTDIM).keyup();
							$("#select-estdim-"+data.detalle3[i].CODESTDIM).val(data.detalle3[i].RESTSC);
							if (data.detalle3[i].DESREC1!="") {
								//$("#select-estdim-1-"+data.detalle3[i].CODESTDIM).append('<option>'+data.detalle3[i].DESREC1+'</option>');
								$("#input3-2-"+data.detalle3[i].CODESTDIM).val(data.detalle3[i].CAIDA);
								document.getElementById("itemrec3-3-"+data.detalle3[i].CODESTDIM).innerHTML=data.detalle3[i].DESREC1;
							}else{
								document.getElementById("itemrec3-3-"+data.detalle3[i].CODESTDIM).innerHTML="";
							}
						}

						if (data.res3=="C") {
							$("#detalleres3").css("display","block");
							$("#detalleres-form3").empty();
							$("#detalleres-form3").append(htmld);
						}
					}else{
						$("#form3").empty();
					}

					var ar_ton=document.getElementsByClassName("lines-tono");
					var ids_tono=[];
					for (var i = 0; i < ar_ton.length; i++) {
						ids_tono.push(ar_ton[i].id);
					}
					for (var i = 0; i < ids_tono.length; i++) {
						$("#"+ids_tono[i]).remove();
					}

					var ar_apa=document.getElementsByClassName("lines-apariencia");
					var ids_apa=[];
					for (var i = 0; i < ar_apa.length; i++) {
						if(ar_apa[i].style.display=="none"){
							ids_apa.push(ar_apa[i].id);
						}
					}
					for (var i = 0; i < ids_apa.length; i++) {
						$("#"+ids_apa[i]).remove();
					}

					var ar=document.getElementsByClassName("line-apa-area");
					for (var i = 0; i < ar.length; i++) {
						var ar_2=ar[i].getElementsByClassName("content-row");
						if(ar_2[0].innerHTML==""){
							ar[i].innerHTML="";
						}
					}

					$(".btntonotshow").remove();
					$("#button1").remove();
					$("#button2").remove();
					$("#button3").remove();
					$("#button4").remove();
					$(".panelCarga").fadeOut(200);
				}
			});
		});
		function validate_form1(){
			var array=document.getElementsByClassName("select-1");
			var validar=true;
			var ar_select=[];
			for (var i = 0; i < array.length; i++) {
				console.log(array[i].dataset.codton+" - "+array[i].value);
				var aux=[];
				aux.push(array[i].dataset.codton);
				aux.push(array[i].value);
				ar_select.push(aux);
			}
			if (validar) {
				$(".panelCarga").fadeIn(200);
				$.ajax({
					type:'POST',
					url:'config/saveAuditoriaForm1.php',
					data:{
						partida:partida,
						codtel:$("#idCodtela").text(),
						codprv:codprv_v,
						codtad:codtad_v,
						numvez:numvez_v,
						parte:parte_v,
						array:ar_select,
						resultado:res_1_v,
						codusu:codusu_v,
						perusu:perfil_usu
					},
					success:function(data){
						console.log(data);
						if (data.state) {
							window.location.href="ListaASupervisar.php";
						}else{
							alert(data.detail);
							$(".panelCarga").fadeOut(200);
						}
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
				console.log(array[i].dataset.codapa+" - "+array[i].value);
				var aux=[];
				aux.push(array[i].dataset.codapa);
				aux.push(array[i].value);
				ar_select.push(aux);
			}
			$(".panelCarga").fadeIn(200);
			$.ajax({
				type:'POST',
				url:'config/saveAuditoriaForm2.php',
				data:{
					partida:partida,
					codtel:$("#idCodtela").text(),
					codprv:codprv_v,
					codtad:codtad_v,
					numvez:numvez_v,
					parte:parte_v,
					array:ar_select,
					resultado:res_2_v,
					codusu:codusu_v,
					perusu:perfil_usu
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						window.location.href="ListaASupervisar.php";
					}else{
						alert(data.detail);
						$(".panelCarga").fadeOut(200);
					}
				}
			});
		}
		function validate_form3(){
			var array=document.getElementsByClassName("select-3");
			var ar_select=[];
			var validate=true;
			for (var i = 0; i < array.length; i++) {
				//console.log(array[i].dataset.codestdim+" - "+array[i].value);
				var aux=[];
				aux.push(array[i].dataset.codestdim);
				aux.push(array[i].value);
				aux.push(document.getElementById("aud3-"+array[i].dataset.codestdim).value);
				ar_select.push(aux);
				if (array[i].value=="") {
					validate=false;
				}
			}
			//console.log(ar_select);
			if (validate) {
				$(".panelCarga").fadeIn(200);
				$.ajax({
					type:'POST',
					url:'config/saveAuditoriaForm3.php',
					data:{
						partida:partida,
						codtel:$("#idCodtela").text(),
						codprv:codprv_v,
						codtad:codtad_v,
						numvez:numvez_v,
						parte:parte_v,
						array:ar_select,
						resultado:res_3_v,
						codusu:codusu_v,
						perusu:perfil_usu
					},
					success:function(data){
						console.log(data);
						if (data.state) {
							window.location.href="ListaASupervisar.php";
						}else{
							alert(data.detail);
							$(".panelCarga").fadeOut(200);
						}
					}
				});
			}else{
				alert("Complete todos los campos de la auditoría!");
			}
		}
		function validate_form4(){
			var array=document.getElementsByClassName("classdefectos");
			var ar=[];
			var sumpun=0;
			for (var i = 0; i < array.length; i++) {
				var aux=[];
				aux.push(array[i].dataset.coddef);
				aux.push(array[i].dataset.points);
				ar.push(aux);
				sumpun+=parseInt(array[i].dataset.peso)*parseInt(array[i].dataset.points);
			}
			console.log(ar);
			console.log(sumpun);
			if (validate_field_4()) {
				alert("Información del rollo guardada!");
				rollo_nuevo=false;
			}else{
				alert("Debe completar todos los campos de información para el rollo!");
			}
		}
		function validate_field_4(){
			if ($("#iddensinrep").val()!="" &&
				$("#idmetros").val()!="" &&
				$("#idancuti").val()!="" &&
				$("#idincder").val()!="" &&
				$("#idincmed").val()!="" &&
				$("#idancsinrep").val()!="" &&
				$("#idpesporrol").val()!="" &&
				$("#idanctot").val()!="" &&
				$("#idincstd").val()!="" &&
				$("#idinciza").val()!="" &&
				$("#idrapport").val()!="") {
				return true;
			}else{
				return false;
			}
		}
		function reset_field_4(){
			$("#iddensinrep").val("");
			$("#idmetros").val("");
			$("#idancuti").val("");
			$("#idincder").val("");
			$("#idincmed").val("");
			$("#idancsinrep").val("");
			$("#idpesporrol").val("");
			$("#idanctot").val("");
			$("#idincstd").val("");
			$("#idinciza").val("");
			$("#idrapport").val("");
		}
		function add_rollo(){
			var num=$("#idNumRolloNew").val();
			var html=''+
			'<div class="line-table">'+
				'<div class="item-table itemb4-1 item-center">'+num+'</div>'+
				'<div class="item-table itemb4-1"><input type="number" id="" style="width: calc(100% - 2px);"></div>'+
				'<div class="item-table itemb4-1"><input type="number" id="" style="width: calc(100% - 2px);"></div>'+
				'<div class="item-table itemb4-1"><input type="number" id="" style="width: calc(100% - 2px);"></div>'+
				'<div class="item-table itemb4-1 item-center" onclick="add_value(\''+num+'-'+1+'\')"><span id="'+num+'-'+1+'">0</span></div>'+
				'<div class="item-table itemb4-1 item-center" onclick="add_value(\''+num+'-'+2+'\')"><span id="'+num+'-'+2+'">0</span></div>'+
				'<div class="item-table itemb4-1 item-center" onclick="add_value(\''+num+'-'+3+'\')"><span id="'+num+'-'+3+'">0</span></div>'+
				'<div class="item-table itemb4-1 item-center" onclick="add_value(\''+num+'-'+4+'\')"><span id="'+num+'-'+4+'">0</span></div>'+
				'<div class="item-table itemb4-1 item-center" onclick="add_value(\''+num+'-'+5+'\')"><span id="'+num+'-'+5+'">0</span></div>'+
				'<div class="item-table itemb4-1 item-center" onclick="add_value(\''+num+'-'+6+'\')"><span id="'+num+'-'+6+'">0</span></div>'+
				'<div class="item-table itemb4-1 item-center" onclick="add_value(\''+num+'-'+7+'\')"><span id="'+num+'-'+7+'">0</span></div>'+
				'<div class="item-table itemb4-1 item-center" onclick="add_value(\''+num+'-'+8+'\')"><span id="'+num+'-'+8+'">0</span></div>'+
				'<div class="item-table itemb4-1 item-center" onclick="add_value(\''+num+'-'+9+'\')"><span id="'+num+'-'+9+'">0</span></div>'+
				'<div class="item-table itemb4-1 item-center" onclick="add_value(\''+num+'-'+10+'\')"><span id="'+num+'-'+10+'">0</span></div>'+
				'<div class="item-table itemb4-1 item-center" onclick="add_value(\''+num+'-'+11+'\')"><span id="'+num+'-'+11+'">0</span></div>'+
				'<div class="item-table itemb4-1 item-center" onclick="add_value(\''+num+'-'+12+'\')"><span id="'+num+'-'+12+'">0</span></div>'+
				'<div class="item-table itemb4-1 item-center" onclick="add_value(\''+num+'-'+13+'\')"><span id="'+num+'-'+13+'">0</span></div>'+
				'<div class="item-table itemb4-1 item-center" onclick="add_value(\''+num+'-'+14+'\')"><span id="'+num+'-'+14+'">0</span></div>'+
				'<div class="item-table itemb4-1 item-center" onclick="add_value(\''+num+'-'+15+'\')"><span id="'+num+'-'+15+'">0</span></div>'+
				'<div class="item-table itemb4-1 item-center" onclick="add_value(\''+num+'-'+16+'\')"><span id="'+num+'-'+16+'">0</span></div>'+
				'<div class="item-table itemb4-1 item-center" onclick="add_value(\''+num+'-'+17+'\')"><span id="'+num+'-'+17+'">0</span></div>'+
				'<div class="item-table itemb4-1 item-center" onclick="add_value(\''+num+'-'+18+'\')"><span id="'+num+'-'+18+'">0</span></div>'+
				'<div class="item-table itemb4-1 item-center" onclick="add_value(\''+num+'-'+19+'\')"><span id="'+num+'-'+19+'">0</span></div>'+
				'<div class="item-table itemb4-1 item-center" onclick="add_value(\''+num+'-'+20+'\')"><span id="'+num+'-'+20+'">0</span></div>'+
				'<div class="item-table itemb4-1"><input type="number" id="" style="width: calc(100% - 2px);"></div>'+
				'<div class="item-table itemb4-1"><input type="number" id="" style="width: calc(100% - 2px);"></div>'+
				'<div class="item-table itemb4-1"><input type="number" id="" style="width: calc(100% - 2px);"></div>'+
				'<div class="item-table itemb4-1"><input type="number" id="" style="width: calc(100% - 2px);"></div>'+
				'<div class="item-table itemb4-1"><input type="number" id="" style="width: calc(100% - 2px);"></div>'+
				'<div class="item-table itemb4-1"><input type="number" id="" style="width: calc(100% - 2px);"></div>'+
				'<div class="item-table itemb4-1"><input type="number" id="" style="width: calc(100% - 2px);"></div>'+
				'<div class="item-table itemb4-1"><input type="number" id="" style="width: calc(100% - 2px);"></div>'+
				'<div class="item-table itemb4-1"><input type="number" id="" style="width: calc(100% - 2px);"></div>'+
				'<div class="item-table itemb4-1"><input type="number" id="" style="width: calc(100% - 2px);"></div>'+
				'<div class="item-table itemb4-1"><input type="number" id="" style="width: calc(100% - 2px);"></div>'+
			'</div>';
			$("#add-newrollos").append(html);
			hide_miniform();
		}
		function add_value(id){
			var value=parseInt($("#"+id).text())+1;
			$("#"+id).text(value)
		}
		var ar_numrollos=[];
		var rollo_nuevo=false;
		function show_detail_rollo(){
			if($("#idnumrollos").val()==""){
				alert("Ingrese el número de rollos de la partida!");
			}else{
				if(!rollo_nuevo){
					rollos_v=parseInt($("#idnumrollos").val());
					if (rollos_v<=ar_numrollos.length) {
						alert("Ya no puede agregar más rollos!");
					}else{
						var html='<div class="lbl">Defectos:</div>';
						$("#table-defectos").empty();
						$("#table-defectos").css("display","none");
						$("#table-defectos").append(html);
						reset_field_4();
						var validate=false;
						var ran=0;
						while(validate==false){
							validate=true;
							ran=Math.round(Math.random()*(rollos_v-1))+1;
							for (var i = 0; i < ar_numrollos.length; i++) {
								if(ar_numrollos[i]==ran){
									validate=false;
								}
							}
						}
						ar_numrollos.push(ran);
						$("#idNumRolloNew").val(ran);
						$(".content-part4").fadeIn(200);
						rollo_nuevo=true;
					}
				}else{
					alert("Asegúrece de haber guardado la información del rollo primero!");
				}
			}
		}
		function hide_miniform(id){
			$("#"+id).fadeOut(200);
		}		
		function show_form(num_form){
			/*var validar=false;
			for (var i = 0; i < aud_per.length; i++) {
				if(aud_per[i]==num_form){
					validar=true;
				}
			}*/
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
		function iniciar_auditoria(){
			window.location.href="AuditoriaTela.php?p="+$("#idpartida").val();
		}
		function finish_auditoria_tela(){
			if(numrollos_v.length!=rollosaud_v){
				alert("Faltan agregar rollos para auditar!");
			}else{
				$(".panelCarga").fadeIn(200);
				$.ajax({
					type:'POST',
					url:'config/finishAuditoriaTela.php',
					data:{
						partida:partida,
						codtel:$("#idCodtela").text(),
						codprv:codprv_v,
						codtad:codtad_v,
						numvez:numvez_v,
						parte:parte_v,
						codusu:codusu_v,
						perusu:perfil_usu,
						resultado:$("#idResultado4").val()
					},
					success:function(data){
						console.log(data);
						if(data.state){
							alert("Auditoria finalizada!");
							window.location.href="main.php";
						}else{
							alert(data.detail);
						}
						$(".panelCarga").fadeOut(200);
					}
				});
			}
		}
		function change_pendiente(){
			$(".panelCarga").fadeIn(200);
			$.ajax({
				type:'POST',
				url:'config/changeStatePendiente.php',
				data:{
					partida:partida,
					codtel:$("#idCodtela").text(),
					codprv:codprv_v,
					codtad:codtad_v,
					numvez:numvez_v,
					parte:parte_v
				},
				success:function(data){
					console.log(data);
					if(data.state){
						alert("Auditoria cambiada!");
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(200);
				}
			});
		}
		function exportar_audtel(){
			var estcon="";
			if(document.getElementById("idEstCon")){
				estcon=document.getElementById("idEstCon").innerHTML;
			}
			var a=document.createElement("a");
			a.target="_blank";
			a.href="config/exports/exportAuditoriaTela.php?partida="+$("#idPartida").text()
			+"&cli="+$("#idCliente").text()
			+"&prov="+$("#idProveedor").text()
			+"&codtel="+$("#idCodtela").text()
			+"&art="+$("#idArticulo").text()
			+"&col="+$("#idColor").text()
			+"&com="+$("#idComposicion").text()
			+"&prog="+$("#idPrograma").text()
			+"&xfac="+$("#idXFactory").text()
			+"&des="+$("#idDestino").text()
			+"&pes="+$("#idPesoPartida").text()
			+"&codprv="+codprv_v
			+"&parte="+parte_v
			+"&numvez="+numvez_v
			+"&codtad="+codtad_v
			+"&numrollos="+$("#idnumerorollos").text()
			+"&audrollos="+$("#idrolaud").text()
			+"&cali4="+$("#idcalificacion4").text()
			//+"&respon="+$("#idResponsable").text()
			+"&caliGen="+$("#idResultado4").val()
			+"&pesoprg="+$("#idPesoPrg").text()
			+"&aud1="+$("#idAuditor-1").text()
			+"&aud2="+$("#idAuditor-2").text()
			+"&aud3="+$("#idAuditor-3").text()
			+"&aud4="+$("#idAuditor-4").text()
			+"&coo1="+$("#idResponsable-1").text()
			+"&coo2="+$("#idResponsable-2").text()
			+"&coo3="+$("#idResponsable-3").text()
			+"&coo4="+$("#idResponsable-4").text()
			+"&ren="+$("#idRendimiento").text()
			+"&respon1="+$("#idRespon-1").text()
			+"&respon2="+$("#idRespon-2").text()
			+"&respon3="+$("#idRespon-3").text()
			+"&respon4="+$("#idRespon-4").text()
			+"&auditor="+$("#idAuditor").text()
			+"&supervisor="+$("#idSupervisor").text()
			+"&feciniaud="+$("#idfecini").text()
			+"&fecfinaud="+$("#idfecfin").text()
			+"&ruttel="+$("#idruttel").text()
			+"&encar1="+$("#idEncar-1").text()
			+"&encar2="+$("#idEncar-2").text()
			+"&encar3="+$("#idEncar-3").text()
			+"&encar4="+$("#idEncar-4").text()
			+"&obs1="+$("#observacion1").text()
			+"&obs2="+$("#observacion2").text()
			+"&obs3="+$("#observacion3").text()
			+"&obs4="+$("#observacion4").text()
			+"&resblo4="+$("#idcali-4-res").text()
			+"&estcon="+estcon
			+"&datcol="+$("#idDatColEstCon").text()
			+"&motivo="+$("#idMotEstCon").text()
			+"&estcliestcon="+$("#idEstCliEstCon").text()
			+"&cmcprv="+$("#idcmcprv").val()
			+"&cmcwts="+$("#idcmcwts").val();
			a.click();
		}
		function exportar_audtel_pdf(){
			var estcon="";
			if(document.getElementById("idEstCon")){
				estcon=document.getElementById("idEstCon").innerHTML;
			}
			var a=document.createElement("a");
			a.target="_blank";
			a.href="fpdf/pdfAudTel.php?partida="+$("#idPartida").text()
			+"&cli="+$("#idCliente").text()
			+"&prov="+$("#idProveedor").text()
			+"&codtel="+$("#idCodtela").text()
			+"&art="+$("#idArticulo").text()
			+"&col="+$("#idColor").text()
			+"&com="+$("#idComposicion").text()
			+"&prog="+$("#idPrograma").text()
			+"&xfac="+$("#idXFactory").text()
			+"&des="+$("#idDestino").text()
			+"&pes="+$("#idPesoPartida").text()
			+"&codprv="+codprv_v
			+"&parte="+parte_v
			+"&numvez="+numvez_v
			+"&codtad="+codtad_v
			+"&numrollos="+$("#idnumerorollos").text()
			+"&audrollos="+$("#idrolaud").text()
			+"&cali4="+$("#idcalificacion4").text()
			//+"&respon="+$("#idResponsable").text()
			+"&caliGen="+$("#idResultado4").val()
			+"&pesoprg="+$("#idPesoPrg").text()
			+"&aud1="+$("#idAuditor-1").text()
			+"&aud2="+$("#idAuditor-2").text()
			+"&aud3="+$("#idAuditor-3").text()
			+"&aud4="+$("#idAuditor-4").text()
			+"&coo1="+$("#idResponsable-1").text()
			+"&coo2="+$("#idResponsable-2").text()
			+"&coo3="+$("#idResponsable-3").text()
			+"&coo4="+$("#idResponsable-4").text()
			+"&ren="+$("#idRendimiento").text()
			+"&respon1="+$("#idRespon-1").text()
			+"&respon2="+$("#idRespon-2").text()
			+"&respon3="+$("#idRespon-3").text()
			+"&respon4="+$("#idRespon-4").text()
			+"&auditor="+$("#idAuditor").text()
			+"&supervisor="+$("#idSupervisor").text()
			+"&feciniaud="+$("#idfecini").text()
			+"&fecfinaud="+$("#idfecfin").text()
			+"&ruttel="+$("#idruttel").text()
			+"&encar1="+$("#idEncar-1").text()
			+"&encar2="+$("#idEncar-2").text()
			+"&encar3="+$("#idEncar-3").text()
			+"&encar4="+$("#idEncar-4").text()
			+"&obs1="+$("#observacion1").text()
			+"&obs2="+$("#observacion2").text()
			+"&obs3="+$("#observacion3").text()
			+"&obs4="+$("#observacion4").text()
			+"&resblo4="+$("#idcali-4-res").text()
			+"&estcon="+estcon
			+"&datcol="+$("#idDatColEstCon").text()
			+"&motivo="+$("#idMotEstCon").text()
			+"&estcliestcon="+$("#idEstCliEstCon").text()
			+"&cmcprv="+$("#idcmcprv").val()
			+"&cmcwts="+$("#idcmcwts").val();
			a.click();
		}
		function animar_detalle(){
			var display=$("#idDetalle").css("display");
			if (display=="block") {
				$("#idDetalle").fadeOut(100);
				$("#btnContent").text("Mostrar detalle");
				$("#idTabApa").css("max-height","calc(100vh - 330px)");
			}else{
				$("#idDetalle").fadeIn(100);
				$("#btnContent").text("Ocultar detalle");
				$("#idTabApa").css("max-height","calc(100vh - 450px)");
			}
		}
		function save_cmcprv(){
			if ($("#idcmcprv").val()=="") {
				alert("Debe completar el valor de CMC proveedor!");
				return;
			}
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/updateCMCPRV.php',
				data:{
					partida:partida,
					codtel:$("#idCodtela").text(),
					codprv:codprv_v,
					codtad:codtad_v,
					numvez:numvez_v,
					parte:parte_v,
					cmcprv:Math.round(parseFloat($("#idcmcprv").val())*100)
				},
				success:function(data){
					console.log(data);
					alert(data.detail);
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function save_cmcwts(){
			if ($("#idcmcwts").val()=="") {
				alert("Debe completar el valor de CMC WTS!");
				return;
			}
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/updateCMCWTS.php',
				data:{
					partida:partida,
					codtel:$("#idCodtela").text(),
					codprv:codprv_v,
					codtad:codtad_v,
					numvez:numvez_v,
					parte:parte_v,
					cmcwts:Math.round(parseFloat($("#idcmcwts").val())*100)
				},
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