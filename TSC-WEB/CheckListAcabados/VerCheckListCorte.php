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
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="css/CheckListCorte-v1.0.css">
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
			<div class="headerTitle">Check List Corte</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="btnPrimary" style="margin-left: calc(50% - 80px);width: 135px;
			padding: 5px;display: flex;padding-left: 20px;" onclick="exportar_audtel()">
				<img src="assets/img/excel.png" style="width: 30px;height: 30px;">
				<div style="padding: 5px;width:calc(80px);text-align: center;">Descargar</div>
			</div>
			<div class="btnPrimary" style="margin-left: calc(50% - 80px);width: 150px;margin-top: 5px;
			padding: 5px;display: flex;" onclick="exportar_audtel_pdf()">
				<div style="padding: 5px;width:calc(100% - 10px);text-align: center;">Descargar PDF</div>
			</div>
			<div id="idDetalle" style="display: block;">
				<div class="sameline">
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Taller: <span id="idtaller"></span></div>
					<div class="lbl" style="width: 50%;">Cliente: <span id="idcliente"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Ficha: <span id="idficha"></span></div>
					<div class="lbl" style="width: 50%; display: flex;">Partida:&nbsp;<div id="idpartida"></div></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Pedido: <span id="idpedido"></span></div>
					<div class="lbl" style="width: 50%;">Cod. Tela: <span id="idcodtel"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Est. TSC: <span id="idesttsc"></span></div>
					<div class="lbl" style="width: 50%;">Color: <span id="idcolor"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Est. Cliente: <span id="idestcli"></span></div>
					<div class="lbl" style="width: 50%;">Ruta prenda: <span id="idruttel"></span></div>
				</div>
				<div class="sameline">
					<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;">Can. Prendas: <span id="idcanpre"></span></div>
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
				<div class="lbl">2. Validaci&oacute;n del tizado/moldes <div class="specialLabel">Veces</div><div style="float: right;">Rep.</div></div>
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
				<div class="lbl">3. Validaci&oacute;n del tendido</div>
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
				<div class="lbl" style="margin-top: 10px;">2. Resultado de Validaci&oacute;n del tizado/moldes: <span id="idres2"></span></div>
				<div id="idobs2" style="display: none;">Observacion: <span id="idobscon2"></span></div>
				<div class="lbl" style="margin-top: 10px;">3. Resultado de Validaci&oacute;n del tendido: <span id="idres3"></span></div>
				<div id="idobs3" style="display: none;">Observacion: <span id="idobscon3"></span></div>
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="window.location.href='ConsultarCheckListCorte.php';">Volver</button>
			</div>
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
				<div class="label-part">Tizado/moldes</div>
			</div>
			<div class="part-auditoria" id="redirect-3" onclick="show_form(3)">
				<div class="number-part">3</div>
				<div class="label-part">Tendido</div>
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
		var codtad="<?php echo $_GET['codtad']; ?>";
		var numvez="<?php echo $_GET['numvez']; ?>";
		var parte="<?php echo $_GET['parte']; ?>";
		var partida="<?php echo $_GET['partida']; ?>";

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
		$(document).ready(function(){			
			$("#idficha").text(codfic);
			$.ajax({
				type:'POST',
				url:'config/verCheLisCor.php',
				data:{
					codfic:codfic,
					codtad:codtad,
					numvez:numvez,
					parte:parte,
					partida:partida,
					codusu:codusu_v
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						$("#idpartida").append('<a href="../auditoriatela/VerAuditoriaTela.php?partida='+partida+
							'&codtel='+data.tela.CODTEL+'&codprv='+data.link.CODPRV+'&numvez='+data.link.NUMVEZ+
							'&parte='+data.link.PARTE+'&codtad='+data.link.CODTAD+'">'+partida+'</a>');
						if (data.partida.OBSDOC!="") {
							$("#idobs1").css("display","block");
							$("#idobscon1").text(data.partida.OBSDOC);
						}
						$("#idres1").text(process_resultado(data.partida.RESDOC));
						if (data.partida.OBSTIZ!="") {
							$("#idobs2").css("display","block");
							$("#idobscon2").text(data.partida.OBSTIZ);
						}
						$("#idres2").text(process_resultado(data.partida.RESTIZ));
						if (data.partida.OBSTEN!="") {
							$("#idobs3").css("display","block");
							$("#idobscon3").text(data.partida.OBSTEN);
						}
						$("#idres3").text(process_resultado(data.partida.RESTEN));

						$("#idtaller").text(data.partida.DESTLL);
						$("#idpedido").text(data.partida.PEDIDO);
						$("#idesttsc").text(data.partida.ESTTSC);
						$("#idestcli").text(data.partida.ESTCLI);
						$("#idcanpre").text(data.partida.CANPAR);
						$("#idcliente").text(data.partida.DESCLI);
						$("#idcodtel").text(data.tela.CODTEL);
						$("#idcolor").text(data.tela.COLOR);

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

						var html='';
						var ar1_automatic=[];
						for (var i = 0; i < data.chkblo1.length; i++) {
							html+=
							'<div class="sameline">'+
								'<div class="lbl-form">'+data.chkblo1[i].DESDOC+'</div>'+
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
							}
						}
						html+=
						'<script>'+
							'$(".anicheblo1").click(function(){'+
								'change_check1(this,0);'+
							'});';
						$("#content-check1").empty();
						$("#content-check1").append(html);
						$("#observacion1").text(data.partida.OBSDOC);

						var html='';
						for (var i = 0; i < data.chkblo2.length; i++) {
							html+=
							'<div class="sameline">'+
								'<div class="lbl-forms2">'+data.chkblo2[i].DESTIZ+'</div>'+
								'<div class="check-content3" style="margin-top:5px;">'+
									'<span id="cheblonum2-'+data.chkblo2[i].CODTIZ+'">0</span>'+
								'</div>'+
								'<div class="check-content">'+
									'<div class="marker-check cheblo2 anicheblo2" id="cheblo2-'+data.chkblo2[i].CODTIZ+'" data-codtiz="'+data.chkblo2[i].CODTIZ+'" data-value="0" data-validar="'+data.chkblo2[i].VALIDAR+'" data-editable="'+data.chkblo2[i].EDITABLE+'">NO</div>'+
								'</div>'+
								'<div class="check-content3" style="margin-top:5px;">'+
									'<input type="checkbox" id="idtizche-'+data.chkblo2[i].CODTIZ+'"/>'+
								'</div>'+
							'</div>';
						}
						html+=
						'<script>'+
							'$(".anicheblo2").click(function(){'+
								'change_check1(this,0);'+
							'});';
						$("#content-check2").empty();
						$("#content-check2").append(html);
						$("#observacion2").text(data.partida.OBSTIZ);

						var html='';
						for (var i = 0; i < data.chkblo3.length; i++) {
							html+=
							'<div class="sameline">'+
								'<div class="lbl-forms3">'+data.chkblo3[i].DESTEN+'</div>'+
								'<div class="check-content">'+
									'<div class="marker-check cheblo3 anicheblo3" id="cheblo3-'+data.chkblo3[i].CODTEN+'" data-codten="'+data.chkblo3[i].CODTEN+'" data-value="0" data-validar="'+data.chkblo3[i].VALIDAR+'" data-editable="'+data.chkblo3[i].EDITABLE+'">NO</div>'+
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
						$("#observacion3").text(data.partida.OBSTEN);

						for (var i = 0; i < ar1_automatic.length; i++) {
							validar_ruta(ar1_automatic[i][0],ar1_automatic[i][1]);
						}

						for (var i = 0; i < data.chkblosave.length; i++) {
							if (data.chkblosave[i].RESDOC=="1") {
								var ele=document.getElementById("cheblo1-"+data.chkblosave[i].CODDOC);
								if (ele.dataset.value=="0") {
									change_check1(ele,1);
									if (data.chkblosave[i].REPOSO!="0") {
										document.getElementById("cheval-"+data.chkblosave[i].CODDOC).value=data.chkblosave[i].REPOSO;
									}
								}
							}
						}
						for (var i = 0; i < data.chkblosave2.length; i++) {
							$("#cheblonum2-"+data.chkblosave2[i].CODTIZ).text(data.chkblosave2[i].VECES);
							if (data.chkblosave2[i].RESTIZ=="1") {
								var ele=document.getElementById("cheblo2-"+data.chkblosave2[i].CODTIZ);
								if (ele.dataset.value=="0") {
									change_check1(ele,1);
								}
							}
						}
						for (var i = 0; i < data.chkblosave3.length; i++) {
							if (data.chkblosave3[i].RESTEN=="1") {
								var ele=document.getElementById("cheblo3-"+data.chkblosave3[i].CODTEN);
								if (ele.dataset.value=="0") {
									change_check1(ele,1);
								}
							}
						}
						show_form(data.maxform);
					}else{
						alert(data.detail);
						window.location.href="ConsultarCheckListCorte.php";
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
					url:'config/getResultadosCLC.php',
					data:{
						codfic:codfic,
						codtad:codtad,
						numvez:numvez,
						parte:parte
					},
					success:function(data){
						console.log(data);
						$("#idres1").text(process_resultado(data.RESDOC));
						$("#idres2").text(process_resultado(data.RESTIZ));
						$("#idres3").text(process_resultado(data.RESTEN));
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
					if (document.getElementById("cheval-"+ar[i].dataset.coddoc)) {
						aux.push(document.getElementById("cheval-"+ar[i].dataset.coddoc).value);
					}else{
						aux.push(0);
					}
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
						obs:obs
					},
					success:function(data){
						console.log(data);
						if (data.state) {
							if (resultado==state_a) {
								ar_allow_forms.push(2);
								show_form(2);	
							}
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
				var ar=document.getElementsByClassName("cheblo2");
				var ar_send=[];
				var con_a=0;
				var con_r=0;
				for (var i = 0; i < ar.length; i++) {
					var aux=[];
					aux.push(ar[i].dataset.codtiz);
					aux.push(ar[i].dataset.value);
					if (document.getElementById("idtizche-"+ar[i].dataset.codtiz).checked) {
						aux.push("1");
					}else{
						aux.push("0");
					}
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
				console.log(resultado);
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
						obs:obs
					},
					success:function(data){
						console.log(data);
						if (data.state) {
							if (resultado==state_a) {
								ar_allow_forms.push(3);
								show_form(3);
							}
							for (var i = 0; i < data.chkblosave2.length; i++) {
								$("#cheblonum2-"+data.chkblosave2[i].CODTIZ).text(data.chkblosave2[i].VECES);
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
				var ar=document.getElementsByClassName("cheblo3");
				var ar_send=[];
				var con_a=0;
				var con_r=0;
				for (var i = 0; i < ar.length; i++) {
					var aux=[];
					aux.push(ar[i].dataset.codten);
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
				console.log(resultado);
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
	</script>
</body>
</html>