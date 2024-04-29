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
			width: calc(250px - 12px);
		}
		.item3-nuevo{
			width: calc(140px - 12px);
		}
		@media(max-width: 500px){
			#idTabApa{
				overflow-x: scroll;
			}
			#idTabApaHed,#form2{
				min-width: 500px;
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
	<div class="mainContent" id="mainToScroll">
		<div class="headerContent">
			<div class="headerTitle">Auditoria de Telas</div>
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
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;display: flex;">Peso (Kg):&nbsp;						
						<div style="display: flex;">
							<input type="number" id="idPesVal" style="width: calc(80px);padding: 2px;">
							<button class="btnPrimary" style="width: 30px;padding: 0px;" onclick="save_peso()"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
						</div>
					</div>
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
					<!--<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Cod. Combo: <span id="idCodCombo"></span></div>-->
					<div class="lbl" style="width: 50%;">Combinación: <span id="idCombo"></span></div>
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
							<div class="item-table item2-secondary item3-nuevo">REC.</div>
							<div class="item-table item2-secondary">CM.</div>
							<!--
							<div class="item-table item2-secondary">% CAIDA</div>-->
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
				<div class="lbl" style="margin: 5px 0px;">Calificaci&oacute;n: <span id="idcalificacion-3">Aprobado</span></div>
				<div id="idRespon3" style="display:none;">
					<div class="lbl">Responsable: <span id="idRespon-3"></span></div>
					<div class="lbl">Encargado: <span id="idEncar-3"></span></div>
				</div>
				<div id="observacion3-res-3" style="display:none;">
					<div class="lbl">Observaci&oacute;n: <span id="observacion3-3"></span></div>
				</div>
				<!--
				<div id="idAud3" style="display:none;">
					<div class="lbl">Auditor: <span id="idAuditor-3"></span></div>
				</div>
				<div id="idRes3" style="display:none;">
					<div class="lbl">Coordinador: <span id="idResponsable-3"></span></div>
				</div>
				<div class="lineDecoration"></div>
				<div class="sameline">
					<div class="lbl" style="width: 120px;">Observaciones</div>
					<div class="btn-addrollo" onclick="open_form_observacion('3')" style="font-size: 13px;margin-top: 1px;">Agregar observaci&oacute;n</div>
				</div>-->
				<div id="tbl-observacion-3" style="margin-bottom: 5px;">
					<!--<div class="lineObservacion" id="obs-1-1">Obs 1</div>-->
				</div>
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="validate_form3()" id="btn-3">Guardar</button>
			</div>
			<div class="forms-content" id="form-4" style="display: none;">
				<div id="form-rollos">	
					<div class="sameline" style="width: 150px;margin-bottom: 5px;">
						<div class="lbl" style="width: calc(100px);padding-right: 5px;padding-top: 7px;">N° Rollos:</div>
						<input type="number" id="idnumrollos" style="padding: 5px;width: calc(50% - 17px);" min="1">						
					</div>
					<div class="sameline">
						<div class="sameline" style="width: 100%;">
							<input type="checkbox" id="idRollosAuto" style="width: 20px;">
							<div style="font-size: 13px;padding-top: 3px;">Seleccionar rollos automaticamente</div>
						</div>
					</div>
					<div class="lbl" style="width: 100%;margin-bottom: 5px;">Tipo de Muestra</div>
					<div class="sameline">
						<div class="sameline" style="width: 100px;">
							<input type="radio" id="idtodos" style="width: 20px;" name="tipo">
							<div>TODOS</div>
						</div>
						<div class="sameline" style="width: 100px;">
							<input type="radio" id="idaql" style="width: 20px;" checked="checked" name="tipo">
							<div>AQL</div>
						</div>
					</div>
					<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="generar_rollos()">Generar rollos</button>
				</div>
				<div id="form-rollo-defectos" style="display: none;">	
					<div class="lbl">4. CONTROL DE DEFECTOS (Rollos: <span id="idnumerorollos"></span> - Rollos a auditar: <span id="idrolaud"></span>)</div>
					<div class="content-part4" id="space-audrol">
						<div class="numrollos-btns" id="btns-rollos">
						</div>
					</div>
					<div id="idRespon4" style="display:none;">
						<div class="lbl">Responsable: <span id="idRespon-4"></span></div>
						<div class="lbl">Encargado: <span id="idEncar-4"></span></div>
					</div>
					<div id="observacion4-res-4" style="display:none;">
						<div class="lbl">Observaci&oacute;n: <span id="observacion4-4"></span></div>
					</div>
						<!--
					<div id="idAud4" style="display:none;">
						<div class="lbl">Auditor: <span id="idAuditor-4"></span></div>
					</div>
					<div id="idRes4" style="display:none;">
						<div class="lbl">Coordinador: <span id="idResponsable-4"></span></div>
					</div>-->
					<div id="final-btn" style="display: block;">
						<!--
						<div class="lineDecoration"></div>
						<div class="sameline">
							<div class="lbl" style="width: 120px;">Observaciones</div>
							<div class="btn-addrollo" onclick="open_form_observacion('4')" style="font-size: 13px;margin-top: 1px;">Agregar observaci&oacute;n</div>
						</div>
						<div id="tbl-observacion-4" style="margin-bottom: 5px;">
							<div class="lineObservacion" id="obs-1-1">Obs 1</div>
						</div>-->
						<div class="lineDecoration"></div>
						<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="finish_auditoria_tela()">Terminar Auditoria</button>
					</div>
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
								<div class="item-table item2-secondary item3-nuevo">REC.</div>
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
									<div class="item-table item3-2">CONCLUSION</div>
									<div class="item-table item3-3">REC. 1</div>
									<!--
									<div class="item-table item3-2">% CAIDA</div>-->
								</div>
							</div>
							<div class="body-table" id="detalleres-form3" style="min-width: 770px;">								
							</div>
						</div>
					</div>
				</div>
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
				</div>
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="redirect('IniciarAuditoriaTela.php')">Volver</button>
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
			<div class="lbl">Buscar defecto</div>
			<div class="lineDecoration"></div>
			<input type="text" id="idWordDefecto" style="padding:5px;">
			<div class="contentDefectos" id="body-defectos">
				<div class="lineDefecto">Defecto 1</div>
			<!--
				<select class="selectclass-min" style="padding: 5px;" id="selectDefecto">
				</select>-->
			</div>
			<button class="btnPrimary" style="margin:auto;margin-top: 5px;" onclick="add_defecto()">Agregar</button>
			<button class="btnPrimary" style="margin:auto;margin-top: 5px;" onclick="hide_miniform('modal-form2')">Cancelar</button>
		</div>
	</div>
	<div class="miniform-content" id="modal-form5" style="display: none;">
		<div class="miniform-body">
			<div class="lbl">Seleccione rollo a copiar</div>
			<div class="lineDecoration"></div>
			<select class="selectclass-min" style="padding: 5px;" id="idSelectRollos">
			</select>
			<button class="btnPrimary" style="margin:auto;margin-top: 5px;" onclick="copy_inforollo()">Copiar</button>
			<button class="btnPrimary" style="margin:auto;margin-top: 5px;" onclick="hide_miniform('modal-form5')">Cancelar</button>
		</div>
	</div>
	<div class="miniform-content" id="modal-form4" style="display: none;">
		<div class="miniform-body">
			<div class="lbl">Seleccione observaci&oacute;n</div>
			<div class="lineDecoration"></div>
			<select class="selectclass-min" style="padding: 5px;" id="idSelectObservacion">
			</select>
			<button class="btnPrimary" style="margin:auto;margin-top: 5px;" onclick="add_observacion()">Agregar</button>
			<button class="btnPrimary" style="margin:auto;margin-top: 5px;" onclick="hide_miniform('modal-form4')">Cancelar</button>
		</div>
	</div>
	<div class="miniform-content" id="modal-form3" style="display: none;background: transparent;height: auto;">
		<div class="miniform-body" style="margin: 0px;margin-top: 60px; margin-left: 10px;box-shadow: 0px 0px 13px 5px rgba(50,50,50,0.5);">
			<div class="lbl">Buscar apariencia</div>
			<div class="lineDecoration"></div>
			<input type="text" id="idWordApariencia" style="padding:5px;">
			<button class="btnPrimary" style="margin:auto;margin-top: 5px;" onclick="hide_apariencia()">Cancelar</button>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		var perfil_usu="<?php echo $_SESSION['perfil']; ?>";
		var codusu_v="<?php echo $_SESSION['user']; ?>";
		var coddef_v="";
		var peso_v="";
		var desdef_v="";
		var desaredef_v="";
		var codaredef_v="";
		var numrol_link="<?php if(isset($_GET['numrol'])){echo $_GET['numrol'];}else{ echo ""; } ?>";
		var numform_v="<?php if(isset($_GET['numform'])){echo $_GET['numform'];}else{ echo ""; } ?>";
		function select_defecto(desdef,coddef,peso,desaredef,codaredef){
			coddef_v=coddef;
			peso_v=peso;
			desdef_v=desdef;
			codaredef_v=codaredef;
			desaredef_v=desaredef;
			$("#idWordDefecto").val(desdef);
		}
		function add_defecto(){
			//var ar=$("#selectDefecto").val().split("-");
			if (coddef_v=="") {
				alert("Seleccione un defecto de la lista!");
			}else{
				if (document.getElementById("defecto-"+numrol_uso+"-"+coddef_v)==null) {				
					$(".panelCarga").fadeIn(200);
					$.ajax({
						type:'POST',
						url:'config/saveRolloDefecto.php',
						data:{
							partida:partida,
							codtel:$("#idCodtela").text(),
							codprv:codprv_v,
							codtad:codtad_v,
							numvez:numvez_v,
							parte:parte_v,
							numrol:numrol_uso,
							coddef:coddef_v,
							peso:peso_v,
							cantidad:1,
							codusu:codusu_v,
							perusu:perfil_usu
						},
						success:function(data){
							console.log(data);	
							if (data.state) {						
								var html=
									'<div class="line-table" id="defecto-'+numrol_uso+'-'+coddef_v+'">'+
										'<div class="item-table" style="width:calc(40% - 62px);">'+desaredef_v+'</div>'+
										'<div class="item-table" style="width:calc(40% - 62px);">'+desdef_v+'</div>'+
										'<div class="item-table" style="width:calc(20% - 12px);">'+peso_v+'</div>'+
										'<div class="item-table" style="width:calc(100px - 12px);display:flex;">'+
											'<div class="btn-add" onclick="edit_value('+numrol_uso+','+coddef_v+',1,'+peso_v+')">'+
												'<span id="numdefrol-'+numrol_uso+'-'+coddef_v+'">1</span>'+
											'</div>'+
											'<div class="btn-minus" onclick="edit_value('+numrol_uso+','+coddef_v+',0,'+peso_v+')">'+
												'<i class="fa fa-minus" aria-hidden="true"></i>'+
											'</div>'+
										'</div>'+
									'</div>';
								$("#content-defectos-"+numrol_uso).append(html);
								var value_tot=parseInt($("#puntot-"+numrol_uso).text());
								$("#puntot-"+numrol_uso).text(value_tot+parseInt(peso_v));
								$("#idpuntos-"+numrol_uso).val(data.punrol);
								hide_miniform('modal-form2');
							}else{
								alert(data.detail);
							}
							$(".panelCarga").fadeOut(200);
						}
					});
				}else{
					alert("Ya existe ese defecto en la lista!");
				}
			}
		}
		function open_form_defecto(){
			if (validate_field_4()) {
				$("#modal-form2").fadeIn(200);
			}else{
				alert("Complete la información del rollo primero!");
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
				$("#idcalificacion-3").text(text_rec);
				res_3_v="R";
			}else{
				if (cont_c>0) {
					$("#idcalificacion-3").text(text_anc);
					res_3_v="C";
				}else{
					$("#idcalificacion-3").text(text_apr);
					res_3_v="A";
				}
			}
			if (cont_a==0 && cont_c==0 && cont_r==0) {
				$("#idcalificacion-3").text("-");
			}
		}
		//VALIDACION

		// function validate3(dom){
		// 	var min=parseFloat(dom.dataset.min);
		// 	var max=parseFloat(dom.dataset.max);
		// 	var validatol=dom.dataset.validatol;
		// 	var value=parseFloat(dom.value);
		// 	var html='';
		// 	if (validatol=="0") {
		// 		if (value>=min && value<=max) {
		// 			html+=
		// 				'<option value="A">Aprobado</option>';
		// 		}else{
		// 			html+=
		// 				'<option value="R">Rechazado</option>';/*+
		// 				'<option value="C">Aprobado no conforme</option>';*/
		// 		}
		// 		$("#select-estdim-"+dom.dataset.estdim).empty();
		// 		$("#select-estdim-"+dom.dataset.estdim).append(html);
		// 		autoevaluar3();
		// 	}else{
		// 		if (value<=max) {
		// 			html+=
		// 				'<option value="A">Aprobado</option>';
		// 		}else{
		// 			html+=
		// 				'<option value="R">Rechazado</option>';
		// 		}
		// 		$("#select-estdim-"+dom.dataset.estdim).empty();
		// 		$("#select-estdim-"+dom.dataset.estdim).append(html);
		// 		autoevaluar3();				
		// 	}
		// }

		// VALIDACION MODIFICADA
		function validate3(dom){
			var min=parseFloat(dom.dataset.min);
			var max=parseFloat(dom.dataset.max);
			var validatol=dom.dataset.validatol;
			var value=parseFloat(dom.value);
			var html='';
			/*
			console.log(dom);
			console.log(`Min: ${min}`);
			console.log(`Max: ${max}`);
			console.log(`Validatol: ${validatol}`);
			console.log(`Valor: ${value}`);
			*/
			if (validatol=="0") {
				if (value>=min && value<=max) {
					html+=
						'<option value="A">Aprobado</option>';
				}else{
					html+=
						'<option value="R">Rechazado</option>';/*+
						'<option value="C">Aprobado no conforme</option>';*/
				}

				$("#select-estdim-"+dom.dataset.estdim).empty();
				$("#select-estdim-"+dom.dataset.estdim).append(html);
				autoevaluar3();
			}else{
 
				// MODIFICADO

				// if (value<=max) {
				// 	html+=
				// 		'<option value="A">Aprobado</option>';
				// }else{
				// 	html+=
				// 		'<option value="R">Rechazado</option>';
				// }
				// $("#select-estdim-"+dom.dataset.estdim).empty();
				// $("#select-estdim-"+dom.dataset.estdim).append(html);
				// autoevaluar3();		
				
				// CAMBIOS ACTULIZADOS
				/*
				if (value < -max) {
					html+=
						'<option value="R">Rechazado</option>';
				}else{
					html+=
						'<option value="A">Aprobado</option>';
				}
				*/
				
				// CAMBIOS GF
				// if (value>=min && value<=max) {
				if (value>=0.00 && value<=max) {
					html+= '<option value="A">Aprobado</option>';
				}else{
					html+= '<option value="R">Rechazado</option>';
				}
				

				$("#select-estdim-"+dom.dataset.estdim).empty();
				$("#select-estdim-"+dom.dataset.estdim).append(html);
				autoevaluar3();		

			}
		}

		var partida="<?php echo $_GET['p']; ?>";
		var codprv_v="<?php if(isset($_GET['codprv'])){echo $_GET['codprv'];}else{echo "";} ?>";
		var codtel_v="<?php if(isset($_GET['codtel'])){echo $_GET['codtel'];}else{echo "";} ?>";
		var codtad_v;
		var numvez_v;
		var parte_v;
		var codaql_v;
		var aud_per=[];
		var rollos_v=0;
		var rollosaud_v=0;
		var numrol_uso;
		function generar_rollos(){
			if ($("#idPesVal").val()=="") {
				alert("Debe guardar el peso de la partida primero!");
			}else{
				if ($("#idnumrollos").val()=="") {
					alert("Complete el número de rollos!");
				}else{
					if (parseInt($("#idnumrollos").val())<=0) {
						alert("Complete un número correcto de rollos!");
					}else{
						var	tipo='1';//aql
						if($("#idtodos").is(':checked')){
							tipo='2';
						}
						var	rolaut='0';
						if($("#idRollosAuto").is(':checked')){
							rolaut='1';
						}
						$(".panelCarga").fadeIn(200);
						$.ajax({
							type:'POST',
							url:'config/generarRollos.php',
							data:{
								partida:partida,
								codtel:$("#idCodtela").text(),
								codprv:codprv_v,
								codtad:codtad_v,
								numvez:numvez_v,
								parte:parte_v,
								tipo:tipo,
								numrol:$("#idnumrollos").val(),
								codaql:codaql_v,
								rolaut:rolaut,
								codusu:codusu_v,
								perusu:perfil_usu
							},
							success:function(data){
								console.log(data);
								if (data.state) {						
									rollosaud_v=data.canaud;
									//window.location.reload();
									window.location.href="AuditoriaTela.php?p="+$("#idPartida").text()+
									"&codprv="+codprv_v+"&codtel="+codtel_v+"&numform=4";
									/*
									$("#form-rollos").css("display","none");
									$("#form-rollo-defectos").css("display","block");*/
								}else{						
									alert(data.detail);
								}
								$(".panelCarga").fadeOut(200);
							}
						});
					}
				}
			}
		}
		function show_numrollo(dom){
			var numero_rollo=dom.id.replace("btnrollo-","");
			if(numrollos_v.length!=rollosaud_v){
				if(document.getElementById("audrol-"+numero_rollo)==null){
					var c=confirm("Desea agregar el rollo "+numero_rollo+" para auditar?");
					if (c) {
						$(".panelCarga").fadeIn(100);
						$.ajax({
							type:'POST',
							url:'config/addRolloAAuditar.php',
							data:{
								partida:partida,
								codtel:$("#idCodtela").text(),
								codprv:codprv_v,
								codtad:codtad_v,
								numvez:numvez_v,
								parte:parte_v,
								numrol:numero_rollo
							},
							success:function(data){
								console.log(data);
								if (!data.state) {
									alert(data.detail);
									$(".panelCarga").fadeOut(100);
								}else{
									window.location.href="AuditoriaTela.php?p="+partida+"&codprv="+codprv_v+"&codtel="+codtel_v+"&numform=4&numrol="+numero_rollo;
								}
							}
						});
					}
				}
			}

			var ar=document.getElementsByClassName("numrol");
			for (var i = 0; i < ar.length; i++) {
				if(ar[i].dataset.idbtn!=undefined){
					ar[i].classList.remove("numrol-active");
				}
			}
			if (dom.dataset.idbtn!=undefined) {
				$(".panelCarga").fadeIn(100);
				$.ajax({
					type:'POST',
					url:'config/getDefectosPorRollo.php',
					data:{
						partida:partida,
						codtel:$("#idCodtela").text(),
						codprv:codprv_v,
						codtad:codtad_v,
						numvez:numvez_v,
						parte:parte_v,
						numrol:numero_rollo
					},
					success:function(data){
						console.log(data);

						var cantidadPuntos=0;
						var html='';
						for (var j = 0; j < data.defectos.length; j++) {
							html+=
								'<div class="line-table" id="defecto-'+numero_rollo+'-'+data.defectos[j].CODDEF+'">'+
									'<div class="item-table" style="width:calc(40% - 62px);">'+data.defectos[j].DESARE+'</div>'+
									'<div class="item-table" style="width:calc(40% - 62px);">'+data.defectos[j].DESDEF+'</div>'+
									'<div class="item-table" style="width:calc(20% - 12px);">'+data.defectos[j].PESO+'</div>'+
									'<div class="item-table" style="width:calc(100px - 12px);display:flex;">'+
										'<div class="btn-add" onclick="edit_value('+numero_rollo+','+data.defectos[j].CODDEF+',1,'+data.defectos[j].PESO+')">'+
											'<span id="numdefrol-'+numero_rollo+'-'+data.defectos[j].CODDEF+'">'+data.defectos[j].CANTIDAD+'</span>'+
										'</div>'+
										'<div class="btn-minus" onclick="edit_value('+numero_rollo+','+data.defectos[j].CODDEF+',0,'+data.defectos[j].PESO+')">'+
											'<i class="fa fa-minus" aria-hidden="true"></i>'+
										'</div>'+
									'</div>'+
								'</div>';
							cantidadPuntos+=parseInt(data.defectos[j].CANTIDAD)*parseInt(data.defectos[j].PESO);
						}

						$("#content-defectos-"+numero_rollo).empty();
						$("#content-defectos-"+numero_rollo).append(html);
						$("#puntot-"+numero_rollo).text(cantidadPuntos);

						$(".content-audrol").css("display","none");
						$("#audrol-"+dom.dataset.idbtn).css("display","block");
						numrol_uso=dom.dataset.idbtn;
						dom.classList.add("numrol-active");
						$(".panelCarga").fadeOut(100);
					}
				});
			}
		}
		function edit_value(numrol,coddef,option,peso){
			var value=parseInt($("#numdefrol-"+numrol+"-"+coddef).text());
			var value_tot=parseInt($("#puntot-"+numrol).text());
			if (option==0) {
				if (value!=0) {
					$("#numdefrol-"+numrol+"-"+coddef).text(value-1);
					$("#puntot-"+numrol).text(value_tot-peso);
				}
			}else{
				$("#numdefrol-"+numrol+"-"+coddef).text(value+1);
				$("#puntot-"+numrol).text(value_tot+peso);
			}
			$(".panelCarga").fadeIn(200);
			$.ajax({
				type:'POST',
				url:'config/saveRolloDefecto.php',
				data:{
					partida:partida,
					codtel:$("#idCodtela").text(),
					codprv:codprv_v,
					codtad:codtad_v,
					numvez:numvez_v,
					parte:parte_v,
					numrol:numrol,
					coddef:coddef,
					peso:peso,
					cantidad:$("#numdefrol-"+numrol+"-"+coddef).text(),					
					codusu:codusu_v,
					perusu:perfil_usu
				},
				success:function(data){
					console.log(data);	
					$("#idpuntos-"+numrol).val(data.punrol);
					$("#idcalificacionTipo-"+numrol).val(data.calificacion);
					if (!data.state) {					
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(200);
				}
			});
		}
		function verify_content(text){
			if (text==undefined) {
				return '';
			}else{
				return text;
			}
		}
		var numrollos_v=[];
		var ar_defectos=[];
		var ar_observaciones=[];

		$(document).ready(function(){
			$("#idTabApa").scroll(function(){
				if ($("#idTabApa").scrollTop()>=10) {
					$("#idTabApaHed").css("position","absolute");
					$("#idTabApaHed").css("top",$("#idTabApa").scrollTop()+"px");
				}else{
					$("#idTabApaHed").css("position","relative");
					$("#idTabApaHed").css("top","0px");
				}
			});
			$("#idWordDefecto").keyup(function(){
				$("#body-defectos").empty();
				var html='';
				for (var i = 0; i < ar_defectos.length; i++) {
					if (ar_defectos[i].DESDEF.indexOf($("#idWordDefecto").val().toUpperCase())>=0) {
						html+=
						'<div class="lineDefecto" onclick="select_defecto(\''+ar_defectos[i].DESDEF+'\',\''+ar_defectos[i].CODDEF+'\',\''+ar_defectos[i].PESO+'\',\''+ar_defectos[i].DESARE+'\',\''+ar_defectos[i].CODARE+'\')">'+ar_defectos[i].DESDEF+' ('+ar_defectos[i].DESARE+')</div>';
					}
				}
				$("#body-defectos").append(html);
			});
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
			$("#idtodos").click(function(e){/*
				if($("#idtodos").is(':checked')){
					$("#idaql").attr("checked",true);
					$("#idtodos").attr("checked",false);
				}else{
					$("#idaql").attr("checked",false);
					$("#idtodos").attr("checked",true);
				}
				e.preventDefault();*/
			});
			$("#idaql").click(function(e){/*
				if($("#idaql").is(':checked')){
					$("#idtodos").attr("checked",true);
					$("#idaql").attr("checked",false);
				}else{
					$("#idtodos").attr("checked",false);
					$("#idaql").attr("checked",true);
				}
				e.preventDefault();*/
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
				url:'config/startAuditoriaTela.php',
				data:{
					partida:partida,
					codprv:codprv_v,
					codtel:codtel_v
				},
				success:function(data){
					console.log(data);

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

					if (data.partida.RES4!="") {
						$("#idRespon4").css("display","block");
						$("#idRespon-4").text(data.partida.RES4);
						$("#idEncar-4").text(data.partida.NOMENC4);
						$("#idRespon4-res").css("display","block");
						$("#idRespon-4-res").text(data.partida.RES4);
						$("#idEncar-4-res").text(data.partida.NOMENC4);
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
					}

					if (data.partida.RES2!="") {
						$("#idRespon2").css("display","block");
						$("#idRespon-2").text(data.partida.RES2);
						$("#idEncar-2").text(data.partida.NOMENC2);
					}

					if (data.partida.RES3!="") {
						$("#idRespon3").css("display","block");
						$("#idRespon-3").text(data.partida.RES3);
						$("#idEncar-3").text(data.partida.NOMENC3);
					}

					if (data.partida.RES4!="") {
						$("#idRespon4").css("display","block");
						$("#idRespon-4").text(data.partida.RES4);
						$("#idEncar-4").text(data.partida.NOMENC4);
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
					
					show_form(parseInt(data.numform));

					ar_defectos=data.defectos;
					$("#body-defectos").empty();
					var html='';
					for (var i = 0; i < ar_defectos.length; i++) {
						html+=
						//'<option value="'+data.defectos[i].DESDEF+'-'+data.defectos[i].CODDEF+'-'+data.defectos[i].PESO+'">'+data.defectos[i].DESDEF+'</option>';
						'<div class="lineDefecto" onclick="select_defecto(\''+ar_defectos[i].DESDEF+'\',\''+ar_defectos[i].CODDEF+'\',\''+ar_defectos[i].PESO+'\',\''+ar_defectos[i].DESARE+'\',\''+ar_defectos[i].CODARE+'\')">'+ar_defectos[i].DESDEF+' ('+ar_defectos[i].DESARE+')</div>';
					}
					$("#body-defectos").append(html);
					if(data.res1!=null){
						res_1_v=data.res1;
						if(data.res1=="C"){
							$("#btn-1").remove();
						}	
					}
					if(data.res2!=null){
						res_2_v=data.res2;						
						if(data.res2=="C"){
							$("#btn-2").remove();
						}
					}
					if(data.res3!=null){
						res_3_v=data.res3;
						if(data.res3=="C"){
							$("#btn-3").remove();
						}	
					}
					codtad_v=data.partida.CODTAD;
					numvez_v=data.partida.NUMVEZ;
					parte_v=data.partida.PARTE;
					codprv_v=data.partida.CODPRV;
					codtel_v=data.partida.CODTEL;
					rollos_v=parseInt(data.partida.ROLLOS);
					$("#idnumerorollos").text(rollos_v);
					codaql_v=data.partida.CODAQL;
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
					$("#idPesVal").val(data.partida.PESO);
					//$("#idResponsable").text(data.partida.DESRES);
					$("#idPesoPrg").text(data.partida.PESOPRG);

					//AGREGADO 11/12/2023
					$("#idCombo").text(data.partida.COMBO);

					$("#idRendimiento").text(data.partida.RENDIMIENTO+" (metros: "+data.partida.RENMET+")");

					let realmetros = parseFloat(data.partida.RENDIMIENTOREAL) * parseFloat(data.partida.PESO);

					$("#idRendimientoReal").text(data.partida.RENDIMIENTOREAL+" (metros: "+realmetros.toFixed(2)+")");



					$("#idAuditor").text(data.partida.CODUSU);
					$("#idSupervisor").text(data.partida.CODUSUEJE);
					$("#idfecini").text(data.partida.FECINIAUD);
					$("#idfecfin").text(data.partida.FECFINAUD);
					$("#idruttel").text(data.partida.RUTA);
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
						var htmld='';
						numrollos_v=data.numrollos;
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
								'<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-bottom: 5px;" onclick="show_copypaste(\''+numrollos_v[i].NUMROL+'\')">Copiar valores</button>'+
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
											'<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;padding-top: 7px;">Rapport (cm):</div>'+
											'<input type="text" id="idrapport-'+numrollos_v[i].NUMROL+'" style="padding: 5px;width: calc(50% - 12px);" min="0" value="'+numrollos_v[i].RAPPORT+'">'+
										'</div>'+
										'<div class="sameline" style="margin-bottom: 5px;">'+
											'<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;padding-top: 7px;">Puntos por rollo:</div>'+
											'<input type="number" id="idpuntos-'+numrollos_v[i].NUMROL+'" style="padding: 5px;width: calc(50% - 12px);" min="0" value="'+numrollos_v[i].PUNTOS+'" disabled>'+
										'</div>'+
										'<div class="sameline" style="margin-bottom: 5px;">'+
											'<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;padding-top: 7px;">Calificaci&oacute;n:</div>'+
											'<input type="text" id="idcalificacionTipo-'+numrollos_v[i].NUMROL+'" style="padding: 5px;width: calc(50% - 12px);" value="'+verify_content(numrollos_v[i].CALIFICACION)+'" disabled>'+
										'</div>'+
									'</div>'+
								'</div>'+
								'<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="validate_form4(\''+numrollos_v[i].NUMROL+'\')">Guardar</button>'+
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
								'<div class="btn-addrollo" onclick="open_form_defecto()" style="margin-bottom: 5px;font-size: 13px;text-align: right;">Agregar defecto</div>'+
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
					var html='';
					var antaredef='';
					/*
					for (var i = 0; i < data.apariencia.length; i++) {
						if (antaredef!=data.apariencia[i].CODAREAD) {
							if (i!=0) {
								html+=
							'</div>'+
						'</div>';
							}
							html+=
						'<div class="line-table">'+
							'<div class="item-table item2-submain item2-headerrow">'+data.apariencia[i].DSCAREAD+'</div>'+
							'<div class="content-row">';
						}
						html+=
								'<div class="line-table">'+
									'<div class="item-table itemr2-main item-toshow">'+data.apariencia[i].DESAPA+'</div>'+
									'<div class="item-table itemr2-secondary">'+
										'<select class="selectclass-min select-2" id="select2-'+data.apariencia[i].CODAPA+'" data-codapa="'+data.apariencia[i].CODAPA+'">'+
											'<option value="A">Aprobado</option>'+
											option_select+
											'<option value="R">Rechazado</option>'+
										'</select>'+
									'</div>'+
								'</div>';
						antaredef=data.apariencia[i].CODAREAD;
						if(i==data.apariencia.length-1){
							html+=
							'</div>'+
						'</div>';							
						}
					}*/					
					for (var i = 0; i < data.apariencia.length; i++) {
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
									'<div class="item-table itemr2-secondary item3-nuevo">'+
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
						'});'+
						'$(".select-2").click(function(){'+
							'this.dataset.clicked="1";'+
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

						// TOLERANCIA NEGATIVA
						if (parseInt(data.estdim[i].TOLERANCIA_NEGATIVA)!=0) {
							tol_negativa='- '+data.estdim[i].TOLERANCIA_NEGATIVA+' '+data.estdim[i].DIMTOL;
						}else{
							tol_negativa=data.estdim[i].TOLERANCIA_NEGATIVA;
						}

						var val='';
						var valor=parseFloat('0'+data.estdim[i].VALOR);
						if (data.estdim[i].DIMVAL=="%") {
							/*valor=Math.round(valor*10000)/100;
							val=Math.round(parseFloat('0'+data.estdim[i].VALOR)*10000)/100+' '+data.estdim[i].DIMVAL;
							min=valor-parseFloat(data.estdim[i].TOLERANCIA);
							max=valor+parseFloat(data.estdim[i].TOLERANCIA);*/
							val=parseFloat('0'+data.estdim[i].VALOR)+' '+data.estdim[i].DIMVAL;
							min=valor-parseFloat(data.estdim[i].TOLERANCIA_NEGATIVA);
							max=valor+parseFloat(data.estdim[i].TOLERANCIA);
						}else{
							val=data.estdim[i].VALOR;
							/*
							if (data.estdim[i].DIMTOL=="%") {
								min=parseFloat(data.estdim[i].VALOR)-parseFloat(data.estdim[i].VALOR)*parseFloat(data.estdim[i].TOLERANCIA_NEGATIVA)/100;
								max=parseFloat(data.estdim[i].VALOR)+parseFloat(data.estdim[i].VALOR)*parseFloat(data.estdim[i].TOLERANCIA)/100;
							}else{
								min=parseFloat(data.estdim[i].VALOR)-parseFloat(data.estdim[i].TOLERANCIA_NEGATIVA);
								max=parseFloat(data.estdim[i].VALOR)+parseFloat(data.estdim[i].TOLERANCIA);
							}
							*/

							
							if (data.estdim[i].DIMTOL=="%") {
								min=parseFloat(val)-parseFloat(val)*parseFloat(data.estdim[i].TOLERANCIA_NEGATIVA)/100;
								max=parseFloat(val)+parseFloat(val)*parseFloat(data.estdim[i].TOLERANCIA)/100;
							}else{
								min=parseFloat(val)-parseFloat(data.estdim[i].TOLERANCIA_NEGATIVA);
								max=parseFloat(val)+parseFloat(data.estdim[i].TOLERANCIA);
							}
						}
						
						
						if (data.estdim[i].CODESTDIM == "5" || data.estdim[i].CODESTDIM == "6" || data.estdim[i].CODESTDIM == "8" || data.estdim[i].CODESTDIM == "9") {
							
							console.log("Funciona");
							console.log(data.estdim[i].CODESTDIM);
						}
						

						var part_select='<select class="selectclass-min select-3" id="select-estdim-'+data.estdim[i].CODESTDIM+'" data-tiporeposo="'+data.estdim[i].TIPOREPOSO+'"  data-codestdim="'+data.estdim[i].CODESTDIM+'" ></select>';
						/*if (valor=="0" || valor==0) {
							part_select='';
						}*/
						html+=
							'<div class="line-table">'+
								'<div class="item-table item3-1">'+data.estdim[i].DESESTDIM+'</div>'+
								'<div class="item-table item3-2">'+tol+'</div>'+
								'<div class="item-table item3-2">'+tol_negativa+'</div>'+
								'<div class="item-table item3-2" onclick="autocompletar_estdim(\''+valor+'\','+data.estdim[i].CODESTDIM+')">'+val+'</div>'+
								'<div class="item-table item3-2">'+
									'<input type="number" id="" class="">'+
								'</div>'+
								'<div class="item-table item3-2">'+
									'<input type="number" id="aud3-'+data.estdim[i].CODESTDIM+'" class="input-validate" data-validatol="'+data.estdim[i].VALIDATOL+'" data-min="'+min+'" data-max="'+max+'" data-estdim="'+data.estdim[i].CODESTDIM+'" value="0">'+
								'</div>'+
								'<div class="item-table item3-2">'+
									part_select+
								'</div>'+
								'<div class="item-table item3-3">'+
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
							'validate3(this);'+
						'});'+
						'$(".input-validate").blur(function(){'+
							'validate3(this);'+
						'});'+
						'$(".select-3").change(function(){'+
							'autoevaluar3();'+
						'});';
					$("#form3").append(html);
					if (data.res1!=null) {
						var htmld='';
						for (var i = 0; i < data.detalle1.length; i++) {
							htmld+=
							'<div class="line-table">'+
								'<div class="item-table item-main">'+data.detalle1[i].DESTON+'</div>'+
								'<div class="item-table item-secondary">ANC</div>'+
								'<div class="item-table item-secondary"><select class="selectclass-min"><option>'+data.detalle1[i].DESREC1+'</option></select></div>'+
								'<div class="item-table item-secondary"><select class="selectclass-min"><option>'+data.detalle1[i].DESREC2+'</option></select></div>'+
							'</div>';
							if (data.detalle1[i].RESTSC=="C") {
								$("#select1-"+data.detalle1[i].CODTON).empty();
								$("#select1-"+data.detalle1[i].CODTON).append('<option value="C">'+text_anc+'</option>');
							}
							$("#select1-"+data.detalle1[i].CODTON).val(data.detalle1[i].RESTSC);
							if (data.detalle1[i].DESREC1!="") {
								$("#select1-1-"+data.detalle1[i].CODTON).append('<option>'+data.detalle1[i].DESREC1+'</option>')
							}
							if (data.detalle1[i].DESREC2!="") {
								$("#select1-2-"+data.detalle1[i].CODTON).append('<option>'+data.detalle1[i].DESREC2+'</option>')
							}
						}
						$("#idcalificacion-1").text(procesarResultado(data.res1));
						$("#idcali-1-res").text(procesarResultado(data.res1));
						if (data.res1=="C") {
							$("#detalleres1").css("display","block");
							$("#detalleres-form1").empty();
							$("#detalleres-form1").append(htmld);
						}
					}
					if (data.res2!=null) {
						var htmld='';
						for (var i = 0; i < data.detalle2.length; i++) {
							htmld+=
							'<div class="line-table">'+
								'<div class="item-table item2-submain item2-headerrow">'+data.detalle2[i].DESAPA+'</div>'+
								'<div class="content-row">'+
									'<div class="line-table">'+
										'<div class="item-table itemr2-main item-toshow">'+data.detalle2[i].DSCAREAD+'</div>'+
										'<div class="item-table itemr2-secondary">ANC</div>'+
										'<div class="item-table itemr2-secondary item3-nuevo"><select class="selectclass-min"><option>'+data.detalle2[i].DESREC1+'</option></select></div>'+
										'<div class="item-table itemr2-secondary">'+data.detalle2[i].CM+'</div>'+
										//'<div class="item-table itemr2-secondary">'+data.detalle2[i].CAIDA+'</div>'+
									'</div>'+
								'</div>'+
							'</div>';
							if (data.detalle2[i].RESTSC=="C") {
								$("#select2-"+data.detalle2[i].CODAPA).empty();
								$("#select2-"+data.detalle2[i].CODAPA).append('<option value="C">'+text_anc+'</option>');
							}
							$("#select2-"+data.detalle2[i].CODAPA).val(data.detalle2[i].RESTSC);
							if (data.detalle2[i].DESREC1!="") {
								$("#select2-1-"+data.detalle2[i].CODAPA).append('<option>'+data.detalle2[i].DESREC1+'</option>');
								$("#input2-2-"+data.detalle2[i].CODAPA).val(data.detalle2[i].CM);
								$("#input2-3-"+data.detalle2[i].CODAPA).val(data.detalle2[i].CAIDA);
							}
						}
						$("#idcalificacion-2").text(procesarResultado(data.res2));
						$("#idcali-2-res").text(procesarResultado(data.res2));
						if (data.res2=="C") {
							$("#detalleres2").css("display","block");
							$("#detalleres-form2").empty();
							$("#detalleres-form2").append(htmld);
						}
					}
					if (data.res3!=null) {
						var htmld='';
						for (var i = 0; i < data.detalle3.length; i++) {
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
									'<div class="item-table item3-2">ANC</div>'+
									'<div class="item-table item3-3"><select class="selectclass-min"><option>'+data.detalle3[i].DESREC1+'</option></select></div>'+
									//'<div class="item-table item3-2">'+data.detalle3[i].CAIDA+'</div>'+
								'</div>';
							}

							$("#aud3-"+data.detalle3[i].CODESTDIM).val(data.detalle3[i].VALORTSC);
							$("#aud3-"+data.detalle3[i].CODESTDIM).keyup();
							$("#select-estdim-"+data.detalle3[i].CODESTDIM).empty();
							$("#select-estdim-"+data.detalle3[i].CODESTDIM).append('<option value="'+data.detalle3[i].RESTSC+'">'+procesarResultado(data.detalle3[i].RESTSC)+'<option>');
							//console.log(data.detalle3[i].RESTSC);
							if (data.detalle3[i].DESREC1!="") {
								$("#select-estdim-1-"+data.detalle3[i].CODESTDIM).append('<option>'+data.detalle3[i].DESREC1+'</option>');
								$("#input3-2-"+data.detalle3[i].CODESTDIM).val(data.detalle3[i].CAIDA);
							}
						}
						$("#idcalificacion-3").text(procesarResultado(data.res3));
						$("#idcali-3-res").text(procesarResultado(data.res3));

						if (data.res3=="C") {
							$("#detalleres3").css("display","block");
							$("#detalleres-form3").empty();
							$("#detalleres-form3").append(htmld);
						}
					}
					if (numform_v!="") {
						show_form(parseInt(numform_v));
					}
					$(".panelCarga").fadeOut(200);
					if (numrol_link!="") {
						var ar=document.getElementsByClassName("numrol");
						for (var i = 0; i < ar.length; i++) {
							if(ar[i].dataset.idbtn==numrol_link){
								show_numrollo(ar[i]);
							}
						}
					}
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
			        $(".panelCarga").fadeOut(200);
			    }
			});
		});

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
							if(res_1_v!='R'){
								//aud_per.push(2);
								if (data.tryend) {
									var c=confirm("Ya se encuentra revisadas todas las partes. Desea finalizar la auditoría?");
									if (c) {
										change_end_auditoria();
									}
									show_form(5);
								}else{
									show_form(2);	
								}
							}else{
								alert("Bloque rechazado!");
								//alert("A la espera de revisión del Supervisor!");
								//window.location.href="main.php";
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
				//console.log(array[i].dataset.codapa+" - "+array[i].value);
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
						if(res_2_v!='R'){
							//aud_per.push(3);
							if (data.tryend) {
								var c=confirm("Ya se encuentra revisadas todas las partes. Desea finalizar la auditoría?");
								if (c) {
									change_end_auditoria();
								}
								show_form(5);
							}else{
								show_form(3);	
							}
						}else{
							alert("Bloque rechazado!");
							//alert("A la espera de revisión del Supervisor!");
							//window.location.href="main.php";
						}
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(200);
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
				aux.push(parseInt(parseFloat(document.getElementById("aud3-"+array[i].dataset.codestdim).value)*100));
				aux.push("");
				aux.push("0");

				let tiporeposo = array[i].dataset.tiporeposo;

				ar_select.push(aux);
				if (array[i].value=="" && tiporeposo == "0") {
					validate=false;
				}
			}

			console.log(ar_select);

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
							if(res_3_v!='R'){
								if (data.tryend) {
									var c=confirm("Ya se encuentra revisadas todas las partes. Desea finalizar la auditoría?");
									if (c) {
										change_end_auditoria();
									}
									show_form(5);
								}else{
									//aud_per.push(4);
									show_form(4);
								}
							}else{
								alert("Bloque rechazado!");
								//alert("A la espera de revisión del Supervisor!");
								//window.location.href="main.php";
							}
						}else{
							alert(data.detail);
						}
						$(".panelCarga").fadeOut(200);
					}
				});
			}else{
				alert("Complete los campos obligatorios de la auditoría!");
			}
		}
		function convert_float(text){
			return text.replace(".",",");
		}
		function validate_form4(numrol){
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
				$(".panelCarga").fadeIn(200);
				$.ajax({
					type:'POST',
					url:'config/saveInfoRollo.php',
					data:{
						partida:partida,
						codtel:$("#idCodtela").text(),
						codprv:codprv_v,
						codtad:codtad_v,
						numvez:numvez_v,
						parte:parte_v,
						numrol:numrol,
						densinrep:convert_float($("#iddensinrep-"+numrol_uso).val()),
						metlin:convert_float($("#idmetros-"+numrol_uso).val()),
						ancuti:convert_float($("#idancuti-"+numrol_uso).val()),
						incder:convert_float($("#idincder-"+numrol_uso).val()),
						incmed:convert_float($("#idincmed-"+numrol_uso).val()),
						ancsinrep:convert_float($("#idancsinrep-"+numrol_uso).val()),
						peso:convert_float($("#idpesporrol-"+numrol_uso).val()),
						anctot:convert_float($("#idanctot-"+numrol_uso).val()),
						incstd:convert_float($("#idincstd-"+numrol_uso).val()),
						incizq:convert_float($("#idinciza-"+numrol_uso).val()),
						rapport:convert_float($("#idrapport-"+numrol_uso).val()),
						codusu:codusu_v,
						perusu:perfil_usu
					},
					success:function(data){
						console.log(data);
						if(!data.state){
							alert(data.detail);
						}else{
							$("#idpuntos-"+numrol).val(data.punrol);
							$("#idcalificacionTipo-"+numrol).val(data.calificacion);
						}
						$(".panelCarga").fadeOut(200);
					}
				});
			}else{
				alert("Debe completar todos los campos de información para el rollo!");
			}
		}
		function validate_field_4(){
			if ($("#iddensinrep-"+numrol_uso).val()!="" &&
				$("#idmetros-"+numrol_uso).val()!="" &&
				$("#idancuti-"+numrol_uso).val()!="" &&
				$("#idincder-"+numrol_uso).val()!="" &&
				$("#idincmed-"+numrol_uso).val()!="" &&
				$("#idancsinrep-"+numrol_uso).val()!="" &&
				$("#idpesporrol-"+numrol_uso).val()!="" &&
				$("#idanctot-"+numrol_uso).val()!="" &&
				$("#idincstd-"+numrol_uso).val()!="" &&
				$("#idinciza-"+numrol_uso).val()!="") {
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
			if (id=="modal-form2") {
				$("#idWordDefecto").val("");
				$("#idWordDefecto").keyup();
				coddef_v="";
			}
		}		
		function show_form(num_form){
			if (num_form==5) {				
				$(".panelCarga").fadeIn(200);
				$.ajax({
					type:'POST',
					url:'config/updateResumenAudTel.php',
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
							$("#idKGCaiPor").text(Math.round(data.pesocai*10000/data.peso)/100+"%");
						}else{
							alert(data.detail);
						}
						$(".panelCarga").fadeOut(200);
					}
				});
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
		function iniciar_auditoria(){
			window.location.href="AuditoriaTela.php?p="+$("#idpartida").val();
		}


		function finish_auditoria_tela(){
			if(numrollos_v.length!=rollosaud_v){
				alert("Faltan agregar rollos para auditar!");
			}else{
				$(".panelCarga").fadeIn(200);

				// VALIDAMOS QUE NO TENGA LOS DATOS COMPLETOS EN LA PARTIDA
				ValidarRegistroDeEstabilidadDimensional(TerminarAuditoriaCompleto);

			}
		}

		function ValidarRegistroDeEstabilidadDimensional(funcionllamar){

			$.ajax({
				type:'GET',
				url:'/tsc/controllers/auditex-tela/partidaauditoria.controller.php',
				data:{

					partida:partida,
					codtela:$("#idCodtela").text(),
					codprov:codprv_v,
					codtad:codtad_v,
					numvez:numvez_v,
					parte:parte_v,
					operacion: "getvalidateestabilidaddimensional"
				},
				success:function(data){
					let response = JSON.parse(data);
					if( parseFloat( response.CANT  )  > 0 ){
						
						$(".panelCarga").fadeOut(200);
						alert("Tiene datos sin registrar en la Estabilidad Dimensional");
					}else{
						// EJECTUAMOS FUNCION
						funcionllamar();
					}
					// console.log(data);
					// if(data.state){
					// 	//aud_per.push(5);
					// 	show_form(5);
					// 	$("#ResultadoFinal").text(procesarResultado(data.resultado));
					// 	$("#idPuntajePartida").text(data.calificacion);
					// 	$("#idTipoPartida").text(data.tipo);
					// 	$("#idKGPar").text(data.peso);
					// 	$("#idKGParPor").text("100%");
					// 	$("#idKGAud").text(data.pesoaud);
					// 	$("#idKGAudPor").text(Math.round(data.pesoaud*10000/data.peso)/100+"%");
					// 	$("#idKGApr").text(data.pesoapro);
					// 	$("#idKGAprPor").text(Math.round(data.pesoapro*10000/data.peso)/100+"%");
					// 	$("#idKGCai").text(data.pesocai);
					// 	$("#idKGCaiPor").text(Math.round(data.pesocai*10000/data.peso)/100+"%");
					// 	if (data.tryend) {
					// 		var c=confirm("Ya se encuentra revisadas todas las partes. Desea finalizar la auditoría?");
					// 		if (c) {
					// 			change_end_auditoria();
					// 		}
					// 	}
					// }else{
					// 	alert(data.detail);
					// }
					// $(".panelCarga").fadeOut(200);
				}
			});

		}


		function TerminarAuditoriaCompleto(){

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
					resultado:'A'
				},
				success:function(data){
					console.log(data);
					if(data.state){
						//aud_per.push(5);
						show_form(5);
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
						$("#idKGCaiPor").text(Math.round(data.pesocai*10000/data.peso)/100+"%");
						if (data.tryend) {
							var c=confirm("Ya se encuentra revisadas todas las partes. Desea finalizar la auditoría?");
							if (c) {
								change_end_auditoria();
							}
						}
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(200);
				}
			});
		}


		function change_end_auditoria(){
			$(".panelCarga").fadeIn(200);
			$.ajax({
				type:'POST',
				url:'config/change_state_auditoria.php',
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
					if(!data.state){
						alert(data.detail);
					}else{
						show_form(5);
					}
					$(".panelCarga").fadeOut(200);
				}
			});
		}
		function look_apariencia(){
			$("#modal-form3").fadeIn(200);
			$("#idWordApariencia").focus();
		}
		function hide_apariencia(){
			var ar=document.getElementsByClassName("item-toshow");
			for (var i = 0; i < ar.length; i++) {
				ar[i].classList.remove("lineSearch");
			}
			$("#modal-form3").fadeOut(200);
		}
		function autocompletar_estdim(valor,id){
			$("#aud3-"+id).val(valor);
			$("#aud3-"+id).keyup();
		}
		function open_form_observacion(numform){
			$("#modal-form4").fadeIn(100);
			var html='';
			for (var i = 0; i < ar_observaciones.length; i++) {
				if (ar_observaciones[i].CODTIPOB==numform) {
					html+='<option value="'+ar_observaciones[i].CODTIPOB+'-'+ar_observaciones[i].CODOBS+'-'+ar_observaciones[i].DESOBS+'">'+ar_observaciones[i].DESOBS+'</option>';
				}
			}
			$("#idSelectObservacion").empty();
			$("#idSelectObservacion").append(html);
		}
		function add_observacion(){
			var ar=$("#idSelectObservacion").val().split("-");
			if (document.getElementById("obs-"+ar[0]+"-"+ar[1])==null) {
				$(".panelCarga").fadeIn(200);
				$.ajax({
					type:'POST',
					url:'config/addObservacionParAud.php',
					data:{
						partida:partida,
						codtel:$("#idCodtela").text(),
						codprv:codprv_v,
						codtad:codtad_v,
						numvez:numvez_v,
						parte:parte_v,
						codtipob:ar[0],
						codobs:ar[1]
					},
					success:function(data){
						console.log(data);
						if(data.state){
							$("#tbl-observacion-"+ar[0]).append('<div class="lineObservacion" id="obs-'+ar[0]+'-'+ar[1]+'">'+ar[2]+'</div>');
						}else{
							alert(data.detail);
						}
						$(".panelCarga").fadeOut(200);
					}
				});
			}else{
				alert("La observación ya fue agregada!");
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
		var numrol_obj;
		function show_copypaste(numrol){
			$(".panelCarga").fadeIn(200);
			$.ajax({
				type:'POST',
				url:'config/getRollosToCopy.php',
				data:{
					partida:partida,
					codtel:$("#idCodtela").text(),
					codprv:codprv_v,
					codtad:codtad_v,
					numvez:numvez_v,
					parte:parte_v,
					numrol:numrol
				},
				success:function(data){
					console.log(data);
					if(data.state){
						if (data.rollos.length==0) {
							alert("No hay rollos con informacion actualmente!");	
						}else{
							numrol_obj=numrol;
							var html='';
							for (var i = 0; i < data.rollos.length; i++) {
								html+='<option value="'+data.rollos[i].NUMROL+'">'+data.rollos[i].NUMROL+'</option>';
							}
							$("#idSelectRollos").empty();
							$("#idSelectRollos").append(html);
							$("#modal-form5").fadeIn(100);
						}
					}else{
						alert("Hubo un error, intente nuevamente!");
					}
					$(".panelCarga").fadeOut(200);
				}
			});
		}
		function copy_inforollo(){
			$(".panelCarga").fadeIn(200);
			$.ajax({
				type:'POST',
				url:'config/saveInfoCopy.php',
				data:{
					partida:partida,
					codtel:$("#idCodtela").text(),
					codprv:codprv_v,
					codtad:codtad_v,
					numvez:numvez_v,
					parte:parte_v,
					numrolobj:numrol_obj,
					numrol:$("#idSelectRollos").val(),					
					codusu:codusu_v,
					perusu:perfil_usu
				},
				success:function(data){
					console.log(data);
					if(data.state){
						//window.location.reload();
						var path="AuditoriaTela.php?p="+partida+"&codprv="+codprv_v+
						"&codtel="+codtel_v+"&numform=4&numrol="+numrol_obj;
						window.location.href=path;
					}else{
						alert("Hubo un error, intente nuevamente!");
					}
					$(".panelCarga").fadeOut(200);
				}
			});
		}
		function save_peso(){
			if ($("#idPesVal").val()=="") {
				alert("Complete el peso de la partida!");
			}else{	
				if (parseInt($("#idPesVal").val())<=0) {
					alert("Ingrese un valor correcto para el peso!");
				}else{				
					$(".panelCarga").fadeIn(200);
					$.ajax({
						type:'POST',
						url:'config/savePesoPartida.php',
						data:{
							partida:partida,
							codtel:$("#idCodtela").text(),
							codprv:codprv_v,
							codtad:codtad_v,
							numvez:numvez_v,
							parte:parte_v,
							peso:$("#idPesVal").val()
						},
						success:function(data){
							console.log(data);
							if(!data.state){
								alert(data.detail);
							}else{
								if (data.tryend) {
									var c=confirm("Ya se encuentra revisadas todas las partes. Desea finalizar la auditoría?");
									if (c) {
										change_end_auditoria();
									}
								}
							}
							$(".panelCarga").fadeOut(200);
						}
					});
				}
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