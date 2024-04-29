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
	<style>
		.desc-link{
			text-decoration: underline;
			color: #0974b3;
		}
		.modal{
			background: rgba(50,50,50,0.6);
			width: 100%;
			height: calc(100vh - 60px);
			padding-top: 60px;
			position: fixed;
			top: 0;
			left: 0;
			z-index: 10;
			font-family: sans-serif;
		}
		.contentEditar{
			max-width: 480px;
			margin: auto;
			cursor: pointer;
		}
	</style>
</head>
<body>
	<div class="modal" id="modal1" style="display: none;">
		<div class="contentEditar">
			<div class="titleContent">Seleccionar encogimiento</div>
			<div class="lineDecoration"></div>
			<div class="bodyEdicion">
			    <table>
			        <thead>
			            <tr>
			                <th>HILO</th>
		                	<th>TRAVEZ</th>
			                <th>LARG. MANGA</th>
		                	<th>OPERACIÓN</th>
			            </tr>
			        </thead>
			        <tbody id="tbl-body">
			        </tbody>
			    </table>
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;" onclick="close_modal('modal1')">Cancerlar</button>
		</div>
	</div>
	<?php contentMenu();?>
	<div class="panelCarga" style="display: block;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="mainContent" id="mainToScroll">
		<div class="headerContent">
			<div class="headerTitle">Check List de Acabados</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div id="idDetalle" style="display: block;margin-top: 5px;">
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 145px;">Ficha</div>
					<div class="spaceIpt" style="width: calc(100% - 145px);">
						<div class="valueRequest" id="idcodfic"><?php echo $_GET['codfic']; ?></div>
					</div>
				</div>		
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 145px;">Fecha</div>
					<div class="spaceIpt" style="width: calc(100% - 145px);">
						<div class="valueRequest" id="idfecha"></div>
					</div>
				</div>		
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 145px;">Pedido</div>
					<div class="spaceIpt" style="width: calc(100% - 145px);">
						<div class="valueRequest" id="idpedido"></div>
					</div>
				</div>	
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 145px;">Color</div>
					<div class="spaceIpt" style="width: calc(100% - 145px);">
						<div class="valueRequest" id="idcolor"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 145px;">Est. TSC</div>
					<div class="spaceIpt" style="width: calc(100% - 145px);">
						<div class="valueRequest" id="idesttsc"></div>
					</div>
				</div>	
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 145px;">Est. Cliente</div>
					<div class="spaceIpt" style="width: calc(100% - 145px);">
						<div class="valueRequest" id="idestcli"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 145px;">Partida</div>
					<div class="spaceIpt" style="width: calc(100% - 145px);">
						<div class="valueRequest" id="idpartida"></div>
					</div>
				</div>		
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 145px;">Taller</div>
					<div class="spaceIpt" style="width: calc(100% - 145px);">
						<div class="valueRequest" id="idnomtal"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 145px;">Aud. Final de Corte</div>
					<div class="spaceIpt" style="width: calc(100% - 145px);">
						<div class="valueRequest" id="idnomtalcor"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 180px;" id="idaudprocor">Aud. Proceso de Corte</div>
					<div class="spaceIpt" style="width: calc(100% - 180px);">
						<div class="valueRequest"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 180px;" id="idaudfincos">Aud. Final de Costura</div>
					<div class="spaceIpt" style="width: calc(100% - 180px);">
						<div class="valueRequest"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 145px;">Art&iacute;culo</div>
					<div class="spaceIpt" style="width: calc(100% - 210px);">
						<div class="valueRequest" id="idarticulo"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 145px;">Cantidad</div>
					<div class="spaceIpt" style="width: calc(100% - 145px);">
						<div class="valueRequest" id="idcantidad"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 145px;">Cliente</div>
					<div class="spaceIpt" style="width: calc(100% - 145px);">
						<div class="valueRequest" id="idcliente"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 145px;">Ruta prenda</div>
					<div class="spaceIpt" style="width: calc(100% - 145px);">
						<div class="valueRequest" id="idruttel"></div>
					</div>
				</div>
				<div id="tbltalla" style="margin-bottom: 5px;">
					
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 145px;">Hora de inicio</div>
					<div class="spaceIpt" style="width: calc(100% - 145px);">
						<div class="valueRequest" id="idhorara"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 145px;">Trabajador por</div>
					<div class="spaceIpt" style="width: calc(100% - 145px);">
						<div class="valueRequest" id="idtrabajado"></div>
					</div>
				</div>
			</div>
			<div class="btn-addrollo" onclick="animar_detalle()"><span id="btnContent">Ocultar detalle</span></div>
			<div class="lineDecoration"></div>
			<div class="forms-content" id="form-1">
				<div class="lbl">1. Validaci&oacute;n de documentaci&oacute;n</div>
				<div id="content-check1">
				</div>
				<div class="lbl">Observaci&oacute;n:</div>
				<div style="width: 100%;">
					<textarea class="textarea-class" id="observacion1"></textarea>
				</div>
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="validate_form1()" id="btn-1">Guardar</button>
			</div>
			<div class="forms-content" id="form-2" style="display: none;">
				<div class="lbl">2. Validaci&oacute;n de la Ficha de Producci&oacute;n</div>
				<div id="content-check2">
					<div class="sameline">
						<div class="lbl-form">Ficha t&eacute;cnica</div>
						<div class="check-content">
							<div class="marker-check">NO</div>
						</div>
					</div>
				</div>
				<div class="lbl">Observaci&oacute;n:</div>
				<div style="width: 100%;">
					<textarea class="textarea-class" id="observacion2"></textarea>
				</div>
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="validate_form2()" id="btn-3">Guardar</button>
			</div>
			<div class="forms-content" id="form-3" style="display: none;">
				<div class="lbl">3. Validaci&oacute;n de Medidas</div>
				<div id="content-check3">
					<div class="sameline">
						<div class="lbl-form">Ficha t&eacute;cnica</div>
						<div class="check-content">
							<div class="marker-check">NO</div>
						</div>
					</div>
				</div>
				<div class="lbl">Observaci&oacute;n:</div>
				<div style="width: 100%;">
					<textarea class="textarea-class" id="observacion3"></textarea>
				</div>
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="validate_form3()" id="btn-3">Guardar</button>
			</div>
			<div class="forms-content" id="form-4" style="display: none;">
				<div class="lbl">4. Resultados</div>
				<div class="lbl" style="margin-top: 10px;">1. Resultado de Validaci&oacute;n de documentaci&oacute;n: <span id="idres1"></span></div>
				<div id="idobs1" style="display: none;">Observacion: <span id="idobscon1"></span></div>
				<div class="lbl" style="margin-top: 10px;">2. Resultado de Validaci&oacute;n de la Ficha de Producci&oacute;n: <span id="idres2"></span></div>
				<div id="idobs2" style="display: none;">Observacion: <span id="idobscon2"></span></div>
				<div class="lbl" style="margin-top: 10px;">3. Resultado de Validaci&oacute;n de Medidas: <span id="idres3"></span></div>
				<div id="idobs3" style="display: none;">Observacion: <span id="idobscon3"></span></div>
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="volver_inicio()" id="btn-3">Volver</button>
		</div>
	</div>
	<div class="content-parts-auditoria">
		<div class="body-parts-auditoria">
			<div class="part-auditoria part-active" id="redirect-1" onclick="show_form(1)">
				<div class="number-part">1</div>
				<div class="label-part">Documentaci&oacute;n</div>
			</div>
			<div class="part-auditoria" id="redirect-2" onclick="show_form(2)">
				<div class="number-part">2</div>
				<div class="label-part">Ficha de Producci&oacute;n</div>
			</div>
			<div class="part-auditoria" id="redirect-3" onclick="show_form(3)">
				<div class="number-part">3</div>
				<div class="label-part">Medidas</div>
			</div>
			<div class="part-auditoria" id="redirect-4" onclick="show_form(4)">
				<div class="number-part">4</div>
				<div class="label-part">Resultados</div>
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
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		var codfic="<?php echo $_GET['codfic']; ?>";
		var codtipser="1";
		var codtad="";
		var numvez="";
		var parte="";
		var partida="";

		var perfil_usu="<?php echo $_SESSION['perfil']; ?>";
		var codusu_v="<?php echo $_SESSION['user']; ?>";

		var ar_ruta=[];
		var ar_allow_forms=[];
		function process_resultado(text){
			if (text==state_a) {
				return "Aprobado";
			}else{
				if (text=="P") {
					return "Pendiente";
				}else{
					if (text=="" || text==null) {
						return "-";
					}else{
						return "Rechazado";
					}	
				}	
			}	
		}
		function getTipSer(id){
			if (id=="2") {
				return "SERVICIO";
			}else{
				return "PLANTA";
			}
		}
		$(document).ready(function(){			
			$("#idficha").text(codfic);
			$.ajax({
				type:'POST',
				url:'config/startCheLisAca.php',
				data:{
					codfic:codfic,
					codtipser:codtipser,
					codusu:codusu_v
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						document.getElementById("idaudprocor").innerHTML='<a href="../auditoriaproceso/ConsultarEditarAuditoriaProceso.php?codfic='+codfic+'">Aud. Proceso de Costura</a>';
						document.getElementById("idaudfincos").innerHTML='<a href="../auditex/ConsultarEditarAuditoria.php?codfic='+codfic+'">Aud. Final de Costura</a>';
						let percent=parseInt(data.ficha.CANTIDAD)/parseInt(data.ficha.CANTIDAD);

						var html1=
						'<table>'+
							'<tr>'+
								'<th>Talla</th>';
						var html2=
							'<tr>'+
								'<td>Cantidad</td>';
						let sum_value=0;
						for (var i = 0; i < data.dettal.length; i++) {
							let value=parseInt(percent*data.dettal[i].CANPRE);
							if (i!=data.dettal.length-1) {
								sum_value+=value;
							}else{
								value=data.ficha.CANTIDAD-sum_value;
							}
							html1+='<th>'+data.dettal[i].DESTAL+'</th>';
							html2+='<td><center>'+value+'</center></td>';
						}
						html1+=
								'<th>Total</th>'+
							'<tr>';
						html2+=
								'<td><center>'+data.ficha.CANTIDAD+'</center></td>'+
							'<tr>';
						html1+=html2+
						'</table>';
						$("#tbltalla").append(html1);

						if (data.detficaud.HORARA!=null) {
							document.getElementById("idhorara").innerHTML=data.detficaud.HORARA;
							document.getElementById("idfecha").innerHTML=data.detficaud.FECINIAUD;
						}

						document.getElementById("idtrabajado").innerHTML=getTipSer(codtipser);
						codtad=data.detficaud.CODTAD;
						numvez=data.detficaud.NUMVEZ;
						parte=data.detficaud.PARTE;
						document.getElementById("idcantidad").innerHTML=data.ficha.CANTIDAD;

						document.getElementById("idpedido").innerHTML=data.partida.pedido;
						document.getElementById("idesttsc").innerHTML=data.partida.esttsc;
						document.getElementById("idestcli").innerHTML=data.partida.estcli;
						document.getElementById("idnomtal").innerHTML=data.partida.tallercos;
						document.getElementById("idarticulo").innerHTML=data.partida.articulo;
						document.getElementById("idcliente").innerHTML=data.partida.cliente;
						if (data.partida.partida!=undefined) {
							document.getElementById("idpartida").innerHTML=
							'<a href="../Auditoriatela/VerAuditoriaTela.php?partida='+data.partida.partida+
							'&codtel='+data.partida.codtel+'&codprv='+data.partida.codprv+
							'&numvez='+data.partida.numvez+'&parte='+data.partida.parte+
							'&codtad='+data.partida.codtad+'">'+data.partida.partida+'</a>';
							document.getElementById("idnomtalcor").innerHTML=
							'<a href="../AuditoriaFinalCorte/ConsultarEditarAuditoria.php?codfic='+
							codfic+'">'+data.partida.tallercor+'</a>';
						}				
						if (data.partida.color!=undefined) {
							document.getElementById("idcolor").innerHTML=data.partida.color;
						}

						for (var i = 0; i < data.maxform; i++) {
							ar_allow_forms.push(i+1);
						}
						ar_allow_forms.push(4);

						ar_ruta=data.rutatela;
						var ruta='';
						for (var i = 0; i < data.rutatela.length; i++) {
							if (i!=0) {
								ruta+=' / ';
							}
							ruta+=
							data.rutatela[i].CODETAPA+' - '+data.rutatela[i].ETAPA;
						}
						$("#idruttel").text(ruta);
						var aux={CODETAPA:"0",ETAPA:"INICIAL"};
						ar_ruta.push(aux);

						if (data.detficaud.OBSDOC!="") {
							$("#idobs1").css("display","block");
							$("#idobscon1").text(data.detficaud.OBSDOC);
						}
						$("#idres1").text(process_resultado(data.detficaud.RESDOC));
						if (data.detficaud.OBSFICPRO!="") {
							$("#idobs2").css("display","block");
							$("#idobscon2").text(data.detficaud.OBSFICPRO);
						}
						$("#idres2").text(process_resultado(data.detficaud.RESFICPRO));
						if (data.detficaud.OBSMED!="") {
							$("#idobs3").css("display","block");
							$("#idobscon3").text(data.detficaud.OBSMED);
						}
						$("#idres3").text(process_resultado(data.detficaud.RESMED));

						var html='';
						var ar1_automatic=[];
						for (var i = 0; i < data.chkblo1.length; i++) {
							let adicional='';
							if (data.chkblo1[i].CODDOC==1) {
								adicional=' - Vez: <span id="idnumvezft">0</span>';
							}
							html+=
							'<div class="sameline">'+
								'<div class="lbl-form">'+data.chkblo1[i].DESDOC+adicional+'</div>'+
								'<div class="check-content2">';
							if (data.chkblo1[i].REPOSO=="1") {
								html+=
									'<input type="number" id="cheval-'+data.chkblo1[i].CODDOC+'" style="width: calc(100% - 12px);font-size: 12px;padding: 4px;" disabled value="0"/>';
							}
							html+=
								'</div>'+
								'<div class="check-content">'+
									'<div class="marker-check cheblo1 anicheblo1" id="cheblo1-'+data.chkblo1[i].CODDOC+'" data-coddoc="'+data.chkblo1[i].CODDOC+'" data-value="0" data-validar="'+data.chkblo1[i].VALIDAR+'" data-reposo="'+data.chkblo1[i].REPOSO+'" data-editable="'+data.chkblo1[i].EDITABLE+'">NO</div>'+
								'</div>'+
							'</div>';
							/*
							if (data.chkblo1[i].CODDOC=="4") {
								var aux=[];
								aux.push(data.chkblo1[i].CODDOC);
								aux.push("5");
								ar1_automatic.push(aux);
							}
							if (data.chkblo1[i].CODDOC=="2") {
								var aux=[];
								aux.push(data.chkblo1[i].CODDOC);
								aux.push("0");
								ar1_automatic.push(aux);
							}*/
						}
						html+=
						'<script>'+
							'$(".anicheblo1").click(function(){'+
								'change_check1(this,0);'+
							'});';
						$("#content-check1").empty();
						$("#content-check1").append(html);
						$("#observacion1").text(data.detficaud.OBSDOC);

						var html='';
						for (var i = 0; i < data.chkblo2.length; i++) {
							html+=
							'<div class="sameline">'+
								'<div class="lbl-forms3">'+data.chkblo2[i].DESFICPRO+'</div>'+
								'<div class="check-content">'+
									'<div class="marker-check cheblo2 anicheblo2" id="cheblo2-'+data.chkblo2[i].CODFICPRO+'" data-codficpro="'+data.chkblo2[i].CODFICPRO+'" data-value="0" data-validar="'+data.chkblo2[i].VALIDAR+'" data-editable="'+data.chkblo2[i].EDITABLE+'">NO</div>'+
								'</div>'+
							'</div>';
							if (data.chkblo2[i].CODFICPRO=="2") {
								html+=
							'<div class="sameline" id="codficpro-'+data.chkblo2[i].CODFICPRO+'" style="display:none;">'+
								'<textarea class="textarea-class" id="obs-'+data.chkblo2[i].CODFICPRO+'"></textarea>'
							'</div>';

							}
						}
						html+=
						'<script>'+
							'$(".anicheblo2").click(function(){'+
								'change_check1(this,0);'+
							'});';
						$("#content-check2").empty();
						$("#content-check2").append(html);
						$("#observacion2").text(data.detficaud.OBSFICPRO);

						var html='';
						for (var i = 0; i < data.chkblo3.length; i++) {
							let desc=data.chkblo3[i].DESMED;
							if (data.chkblo3[i].RUTABASE!=null) {
								desc='<div class="desc-link" onclick="go_link(\''+data.chkblo3[i].RUTABASE+'\')">'+data.chkblo3[i].DESMED+'</div>';
							}
							html+=
							'<div class="sameline">'+
								'<div class="lbl-forms3">'+desc+'</div>'+
								'<div class="check-content">'+
									'<div class="marker-check cheblo3 anicheblo3" id="cheblo3-'+data.chkblo3[i].CODMED+'" data-codten="'+data.chkblo3[i].CODMED+'" data-value="0" data-validar="'+data.chkblo3[i].VALIDAR+'" data-editable="'+data.chkblo3[i].EDITABLE+'">NO</div>'+
								'</div>'+
							'</div>';
						}
						html+=
						'<script>'+
							'$(".anicheblo3").click(function(){'+
								'change_check1(this);'+
							'});';
						$("#content-check3").empty();
						$("#content-check3").append(html);
						$("#observacion3").text(data.detficaud.OBSMED);

						/*
						for (var i = 0; i < ar1_automatic.length; i++) {
							validar_ruta(ar1_automatic[i][0],ar1_automatic[i][1]);
						}*/

						for (var i = 0; i < data.chkblosave.length; i++) {
							if (data.chkblosave[i].RESDOC=="1") {
								var ele=document.getElementById("cheblo1-"+data.chkblosave[i].CODDOC);
								if (ele.dataset.value=="0") {
									change_check1(ele,1);
								}
							}
						}
						for (var i = 0; i < data.chkblosave2.length; i++) {
							if (data.chkblosave2[i].RESFICPRO=="1") {
								var ele=document.getElementById("cheblo2-"+data.chkblosave2[i].CODFICPRO);
								if (ele.dataset.value=="0") {
									change_check1(ele,1);
								}
							}
							if (document.getElementById("obs-"+data.chkblosave2[i].CODFICPRO) && data.detficaud.OBSREV!=null) {
								document.getElementById("obs-"+data.chkblosave2[i].CODFICPRO).value=data.detficaud.OBSREV;
							}
						}
						for (var i = 0; i < data.chkblosave3.length; i++) {
							if (data.chkblosave3[i].RESMED=="1") {
								var ele=document.getElementById("cheblo3-"+data.chkblosave3[i].CODMED);
								if (ele.dataset.value=="0") {
									change_check1(ele,1);
								}
							}
						}
						show_form(data.maxform);
						$("#idnumvezft").text(data.detficaud.NUMVEZFT);
					}else{
						alert(data.detail);
						//window.location.href="IniciarCheckListAcabados.php";
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
		function validar_ruta(coddoc,value){
			var i=0;
			var end=ar_ruta.length;
			var validate=true;
			while(i<end && validate){
				if (ar_ruta[i].CODETAPA==value) {
					validate=false;
					change_check1(document.getElementById("cheblo1-"+coddoc),1);
				}
				i++;
			}
		}
		function change_check1(dom,permiso){
			let val_funcion=true;
			if ((dom.id).indexOf("cheblo3-")>=0) {
				let ar=document.getElementsByClassName("anicheblo3");
				for (var i = 0; i < ar.length; i++) {
					if(ar[i].dataset.value=="1" && ar[i].id!=dom.id){
						val_funcion=false;
					}
				}
			}
			if (val_funcion) {
				if (permiso==1) {
					var text=dom.innerHTML;
					if (text=="NO") {
						text="SI";
						dom.dataset.value="1";
						dom.style.left="20px";
						dom.style.background="#55840b";
						if (dom.dataset.reposo=="1") {
							$("#cheval-"+dom.dataset.coddoc).attr("disabled",false);
						}
					}else{
						dom.style.background="#980f0f";
						text="NO";
						dom.dataset.value="0";
						dom.style.left="0px";
						if (dom.dataset.reposo=="1") {
							$("#cheval-"+dom.dataset.coddoc).attr("disabled",true);
						}
					}
					dom.innerHTML=text;	
				}else{
					if (dom.dataset.editable=="1") {
						var text=dom.innerHTML;
						if (text=="NO") {
							text="SI";
							dom.style.background="#55840b";
							dom.dataset.value="1";
							dom.style.left="20px";
							if (dom.dataset.reposo=="1") {
								$("#cheval-"+dom.dataset.coddoc).attr("disabled",false);
							}
						}else{
							text="NO";
							dom.style.background="#980f0f";
							dom.dataset.value="0";
							dom.style.left="0px";
							if (dom.dataset.reposo=="1") {
								$("#cheval-"+dom.dataset.coddoc).attr("disabled",true);
							}
						}
						dom.innerHTML=text;
					}
				}
				if (document.getElementById("codficpro-"+dom.dataset.codficpro)) {
					if(document.getElementById("codficpro-"+dom.dataset.codficpro).style.display=="block"){
						document.getElementById("codficpro-"+dom.dataset.codficpro).style.display="none";
					}else{
						document.getElementById("codficpro-"+dom.dataset.codficpro).style.display="block";
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
		function show_form(num_form){
			if (num_form==4) {
				$(".panelCarga").fadeIn(100);
				$.ajax({
					type:'POST',
					url:'config/getResultadosCLACA.php',
					data:{
						codfic:codfic,
						codtad:codtad,
						numvez:numvez,
						parte:parte
					},
					success:function(data){
						console.log(data);
						$("#idres1").text(process_resultado(data.RESDOC));
						$("#idres2").text(process_resultado(data.RESFICPRO));
						$("#idres3").text(process_resultado(data.RESMED));
						if (data.OBSDOC!="") {
							$("#idobs1").css("display","block");
							$("#idobscon1").text(data.OBSDOC);	
						}
						if (data.OBSFICPRO!="") {
							$("#idobs2").css("display","block");
							$("#idobscon2").text(data.OBSFICPRO);	
						}
						if (data.OBSMED!="") {
							$("#idobs3").css("display","block");
							$("#idobscon3").text(data.OBSMED);	
						}
						$(".panelCarga").fadeOut(100);
					}
				});
			}
			var validar=false;
			var i=0;
			while(i<ar_allow_forms.length){
				if (ar_allow_forms[i]==num_form) {
					validar=true;
				}
				i++;
			}
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
		var state_a="A";
		var state_r="R";
		function validate_form1(){
			var obs=$("#observacion1").val();
			if (obs.length>100) {
				alert("La observación no debe tener más de 100 caracteres!");
			}else{
				var ar=document.getElementsByClassName("cheblo1");
				var ar_send=[];
				var con_a=0;
				var con_r=0;
				for (var i = 0; i < ar.length; i++) {
					var aux=[];
					aux.push(ar[i].dataset.coddoc);
					aux.push(ar[i].dataset.value);
					ar_send.push(aux);
					if (ar[i].dataset.validar=="1") {
						if (ar[i].dataset.value=="1") {
							con_a++;
						}else{
							con_r++;
						}
					}
				}
				var resultado=state_a;
				if (con_r>0) {
					resultado=state_r;
				}
				console.log(ar_send);
				let numvezft=parseInt($("#idnumvezft").text())+1;
				$(".panelCarga").fadeIn(100);
				$.ajax({
					type:'POST',
					url:'config/saveCheBlo1.php',
					data:{
						codfic:codfic,
						codtad:codtad,
						numvez:numvez,
						parte:parte,
						array:ar_send,
						resultado:resultado,
						obs:obs,
						numvezft:numvezft
					},
					success:function(data){
						console.log(data);
						if (data.state) {
							if (resultado==state_a) {
								ar_allow_forms.push(2);
								show_form(2);
							}
							if (data.horara!="") {
								document.getElementById("idhorara").innerHTML=data.horara;
							}
							$("#idnumvezft").text(numvezft);
						}else{
							alert(data.detail);
						}
						$(".panelCarga").fadeOut(100);
					}
				});
			}
		}
		function validate_form2(){
			var obs=$("#observacion2").val();
			if (obs.length>100) {
				alert("La observación no debe tener más de 100 caracteres!");
			}else{
				let revirado=0;
				let obsrev="";
				var ar=document.getElementsByClassName("cheblo2");
				var ar_send=[];
				var con_a=0;
				var con_r=0;
				for (var i = 0; i < ar.length; i++) {
					var aux=[];
					aux.push(ar[i].dataset.codficpro);
					aux.push(ar[i].dataset.value);
					ar_send.push(aux);
					if (ar[i].dataset.validar=="1") {
						if (ar[i].dataset.value=="1") {
							con_a++;
						}else{
							con_r++;
						}
					}
					if (document.getElementById("codficpro-"+ar[i].dataset.codficpro)) {
						if(document.getElementById("codficpro-"+ar[i].dataset.codficpro).style.display=="none"){
							document.getElementById("obs-"+ar[i].dataset.codficpro).value="";
						}
						if(document.getElementById("obs-"+ar[i].dataset.codficpro).value!=""){
							revirado=1;
							obsrev=document.getElementById("obs-"+ar[i].dataset.codficpro).value;
						}
					}
				}
				var resultado=state_a;
				if (con_r>0) {
					resultado=state_r;
				}
				$(".panelCarga").fadeIn(100);
				$.ajax({
					type:'POST',
					url:'config/saveCheBlo2.php',
					data:{
						codfic:codfic,
						codtad:codtad,
						numvez:numvez,
						parte:parte,
						array:ar_send,
						resultado:resultado,
						obs:obs,
						revirado:revirado,
						obsrev:obsrev
					},
					success:function(data){
						console.log(data);
						if (data.state) {
							if (resultado==state_a) {
								ar_allow_forms.push(3);
								show_form(3);
							}
						}else{
							alert(data.detail);
						}
						$(".panelCarga").fadeOut(100);
					}
				});
			}
		}
		function validate_form3(){
			var obs=$("#observacion3").val();
			if (obs.length>100) {
				alert("La observación no debe tener más de 100 caracteres!");
			}else{
				let iscodeta=false;
				for (var i = 0; i < ar_ruta.length; i++) {
					if(ar_ruta[i].CODETAPA=="18"){
						iscodeta=true;
					}
				}

				var ar=document.getElementsByClassName("cheblo3");
				var ar_send=[];
				var con_a=0;
				var con_r=0;
				for (var i = 0; i < ar.length; i++) {
					var aux=[];
					aux.push(ar[i].dataset.codten);
					aux.push(ar[i].dataset.value);
					ar_send.push(aux);
					/*
					if (ar[i].dataset.validar=="1") {
						if (ar[i].dataset.value=="1") {
							con_a++;
						}else{
							con_r++;
						}
					}*/
					if (iscodeta) {
						if(ar[i].dataset.codten=="3"){
							if (ar[i].dataset.value=="1") {
								con_a++;
							}
						}
					}else{
						if(ar[i].dataset.codten=="2"){
							if (ar[i].dataset.value=="1") {
								con_a++;
							}
						}
					}
				}
				var resultado=state_r;
				if (con_a>0) {
					resultado=state_a;
				}
				$(".panelCarga").fadeIn(100);
				$.ajax({
					type:'POST',
					url:'config/saveCheBlo3.php',
					data:{
						codfic:codfic,
						codtad:codtad,
						numvez:numvez,
						parte:parte,
						array:ar_send,
						resultado:resultado,
						obs:obs
					},
					success:function(data){
						console.log(data);
						if (data.state) {
							if (resultado==state_a) {
								ar_allow_forms.push(4);
								show_form(4);
							}
						}else{
							alert(data.detail);
						}
						$(".panelCarga").fadeOut(100);
					}
				});
			}
		}
		function close_modal(id){
			$("#"+id).fadeOut(100);
		}
		function go_link(id){
			if (id=="1") {				
				$(".panelCarga").fadeIn(100);
				$.ajax({
					type:'POST',
					url:'config/getEncogimientosFicha.php',
					data:{
						codfic:codfic
					},
					success:function(data){
						console.log(data);
						if (data.state) {
							let html='';
							for (var i = 0; i < data.fichas.length; i++) {
								html+=
								'<tr>'+
            						'<td>'+data.fichas[i].hilo+'</td>'+
            						'<td>'+data.fichas[i].travez+'</td>'+
            						'<td>'+data.fichas[i].largmanga+'</td>'+
            						'<td><a href="../auditoriafinalcorte/RegistrarMedidasAudFinCor.php?codfic='+codfic+'&hilo='+data.fichas[i].hilo+'&travez='+data.fichas[i].travez+'&largmanga='+data.fichas[i].largmanga+'">ver</a></td>'+
								'</tr>';
							}
							document.getElementById("tbl-body").innerHTML=html;
							$("#modal1").fadeIn(100);
						}else{
							$("#modal1").fadeOut(100);
							alert(data.detail);
						}
						$(".panelCarga").fadeOut(100);
					}
				});
			}else{
				if (id=="2") {
					window.location.href="../auditex/AuditoriaMedidas.php?codfic="+codfic;
				}
			}
		}
		function exportar_audtel(){
			var a=document.createElement("a");
			a.target="_blank";
			a.href="config/exports/exportCheLisCor.php?codfic="+$("#idficha").text()
			+"&tal="+$("#idtaller").text()
			+"&cli="+$("#idcliente").text()
			+"&partida="+$("#idpartida").text()
			+"&pedido="+$("#idpedido").text()
			+"&codtel="+$("#idcodtel").text()
			+"&esttsc="+$("#idesttsc").text()
			+"&color="+$("#idcolor").text()
			+"&estcli="+$("#idestcli").text()
			+"&ruttel="+$("#idruttel").text()
			+"&canpre="+$("#idcanpre").text()
			+"&numvez="+numvez
			+"&parte="+parte
			+"&codtad="+codtad
			+"&obs1="+$("#observacion1").val()
			+"&obs2="+$("#observacion2").val()
			+"&obs3="+$("#observacion3").val();
			a.click();
		}
		function exportar_audtel_pdf(){
			var a=document.createElement("a");
			a.target="_blank";
			a.href="fpdf/crearPdfCheLisCor.php?codfic="+$("#idficha").text()
			+"&tal="+$("#idtaller").text()
			+"&cli="+$("#idcliente").text()
			+"&partida="+$("#idpartida").text()
			+"&pedido="+$("#idpedido").text()
			+"&codtel="+$("#idcodtel").text()
			+"&esttsc="+$("#idesttsc").text()
			+"&color="+$("#idcolor").text()
			+"&estcli="+$("#idestcli").text()
			+"&ruttel="+$("#idruttel").text()
			+"&canpre="+$("#idcanpre").text()
			+"&numvez="+numvez
			+"&parte="+parte
			+"&codtad="+codtad
			+"&obs1="+$("#observacion1").val()
			+"&obs2="+$("#observacion2").val()
			+"&obs3="+$("#observacion3").val();
			a.click();
		}
		function volver_inicio(){
			window.location.href="IniciarAudAca.php?codfic="+codfic;
		}
	</script>
</body>
</html>