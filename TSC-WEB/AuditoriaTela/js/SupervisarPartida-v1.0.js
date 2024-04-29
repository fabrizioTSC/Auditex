
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
function autoevaluar1(dom){
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
	$("#select1-1-"+dom.dataset.codton).empty();
	$("#select1-2-"+dom.dataset.codton).empty();
	if (dom.value=="C") {
		var html='';
		var pos=0;
		for (var i = 0; i < ar_rec1.length; i++) {
			if (i==0) {
				pos=ar_rec1[i].CODREC1;
			}
			html+=
			'<option value="'+ar_rec1[i].CODREC1+'-'+ar_rec1[i].LISTA2+'">'+ar_rec1[i].DESREC1+'</option>';
		}
		$("#select1-1-"+dom.dataset.codton).append(html);
		html='';
		for (var i = 0; i < ar_rec2.length; i++) {
			if (ar_rec2[i].CODREC1==pos) {
				html+=
				'<option value="'+ar_rec2[i].CODREC1+'-'+ar_rec2[i].CODREC2+'">'+ar_rec2[i].DESREC2+'</option>';
			}
		}
		$("#select1-2-"+dom.dataset.codton).append(html);
	}
}
function autoevaluar11(dom){
	var array=dom.value.split("-");
	if (array[1]=="1") {
		$(".panelCarga").fadeIn(100);
		$.ajax({
			type:'POST',
			url:'config/getRec2Tono.php',
			data:{
				codrec1:array[0],
			},
			success:function(data){
				console.log(data);
				var html='';
				for (var i = 0; i < data.rec2.length; i++) {
					html+=
					'<option value="'+data.rec2[i].CODREC1+'-'+data.rec2[i].CODREC2+'">'+data.rec2[i].DESREC2+'</option>';
				}
				$("#select1-2-"+dom.dataset.codton).empty();
				$("#select1-2-"+dom.dataset.codton).append(html);
				$(".panelCarga").fadeOut(100);
			}
		});
	}else{
		console.log("No buscar");
		$("#select1-2-"+dom.dataset.codton).empty();
	}
}
var res_2_v="A";
function autoevaluar2(dom){
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
	$("#select2-1-"+dom.dataset.codapa).empty();
	$("#input2-2-"+dom.dataset.codapa).attr("disabled",true);
	$("#input2-2-"+dom.dataset.codapa).val(0);
	$("#input2-3-"+dom.dataset.codapa).attr("disabled",true);
	$("#input2-3-"+dom.dataset.codapa).val(0);
	if (dom.value=="C") {				
		$(".panelCarga").fadeIn(100);
		$.ajax({
			type:'POST',
			url:'config/getRec1Apa.php',
			data:{
				codgrprec:dom.dataset.codgrprec
			},
			success:function(data){
				console.log(data);
				var html='';
				for (var i = 0; i < data.rec1.length; i++) {
					html+=
					'<option value="'+data.rec1[i].CODREC1+'-'+data.rec1[i].CM+'-'+data.rec1[i].CAIDA+'">'+data.rec1[i].DESREC1+'</option>';
					if (i==0) {
						if (data.rec1[i].CM=="1") {
							$("#input2-2-"+dom.dataset.codapa).attr("disabled",false);
						}
						if (data.rec1[i].CAIDA=="1") {
							$("#input2-3-"+dom.dataset.codapa).attr("disabled",false);
						}
					}
				}
				$("#select2-1-"+dom.dataset.codapa).append(html);
				$(".panelCarga").fadeOut(100);
			}
		});
	}
}
function autoevaluar21(dom){
	var ar=dom.value.split("-");
	if (ar[1]=="1") {
		$("#input2-2-"+dom.dataset.codapa).attr("disabled",false);
	}else{
		$("#input2-2-"+dom.dataset.codapa).attr("disabled",true);
		$("#input2-2-"+dom.dataset.codapa).val(0);
	}
	if (ar[2]=="1") {
		$("#input2-3-"+dom.dataset.codapa).attr("disabled",false);
	}else{
		$("#input2-3-"+dom.dataset.codapa).attr("disabled",true);
		$("#input2-3-"+dom.dataset.codapa).val(0);
	}
}
var res_3_v="A";
function autoevaluar3(dom){
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
		//$("#idcalificacion-3").val(res_3_v);
	}else{
		if (cont_c>0) {
			$("#idcalificacion-3").text(text_anc);
			res_3_v="C";
			//$("#idcalificacion-3").val(res_3_v);
		}else{
			$("#idcalificacion-3").text(text_apr);
			res_3_v="A";
		}
	}/*
	if (cont_a==0 && cont_c==0 && cont_r==0) {
		$("#idcalificacion-3").text("-");
	}*/
	$("#select-estdim-1-"+dom.dataset.codestdim).empty();
	$("#input3-2-"+dom.dataset.codestdim).val("0");
	if (dom.value=="C") {
		var html='';
		for (var i = 0; i < ar_estdimrec1.length; i++) {
			html+=
			'<option value="'+ar_estdimrec1[i].CODREC1+'-'+ar_estdimrec1[i].CAIDA+'">'+ar_estdimrec1[i].DESREC1+'</option>';
		}
		$("#select-estdim-1-"+dom.dataset.codestdim).append(html);
	}
}
function autoevaluar31(dom){
	var array=dom.value.split("-");
	if (array[1]!="0") {
		$("#input3-2-"+dom.dataset.codestdim).attr("disabled",false);
	}else{
		$("#input3-2-"+dom.dataset.codestdim).attr("disabled",true);
		$("#input3-2-"+dom.dataset.codestdim).val("0");
	}
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
		res_3_v=$("#idcalificacion-3").val();
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
			
			$("#observacion1").val(data.partida.OBSTON);
			$("#observacion2").val(data.partida.OBSAPA);
			$("#observacion3").val(data.partida.OBSESTDIM);
			$("#observacion4").val(data.partida.OBSDEF);

			if (data.partida.RESTONEJETSC!=null) {
				$("#idRes1").css("display","block");
				$("#idResponsable-1").text(data.partida.CODUSUTONEJETSC);
				$("#idEncar-1").text(data.partida.NOMENC1);
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
			
			if(data.res3=='A'){
				show_form(parseInt(data.numform));
			}else{
				show_form(parseInt(data.numform)-1);						
			}*/

			for (var i = 0; i < data.forms_allow.length; i++) {
				aud_per.push(data.forms_allow[i]);
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
			$("#idruttel").text(data.partida.RUTA)
			$("#idRendimiento").text(data.partida.RENDIMIENTO+" (metros: "+data.partida.RENMET+")");
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
				for (var i = 0; i < numrollos_v.length; i++) {
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
									'<div class="lbl" style="width: calc(50% - 5px);padding-right: 5px;padding-top: 7px;">Rapport:</div>'+
									'<input type="number" id="idrapport-'+numrollos_v[i].NUMROL+'" style="padding: 5px;width: calc(50% - 12px);" min="0" value="'+numrollos_v[i].RAPPORT+'">'+
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
			}
			var html='';
			for (var i = 0; i < data.responsable.length; i++) {
				html+='<option value="'+data.responsable[i].CODRES+'">'+data.responsable[i].DESRES+'</option>';
			}
			$("#selectResponsable").append(html);
			var html='';
			/*
			var option_select='';
			if (perfil_usu=="2") {
				option_select='<option value="C">Aprobado no conforme</option>';
			}*/
			for (var i = 0; i < data.tonos.length; i++) {
				html+=
				'<div class="line-table lines-tono" id="line-1-'+data.tonos[i].CODTON+'">'+
					'<div class="item-table item-main">'+data.tonos[i].DESTON+'</div>'+
					'<div class="item-table item-secondary">'+
						'<select class="selectclass-min select-1" id="select1-'+data.tonos[i].CODTON+'" data-codton="'+data.tonos[i].CODTON+'">'+
							'<option value="C">Aprobado no conforme</option>'+
							'<option value="R">Rechazado</option>'+
						'</select>'+
					'</div>'+
					'<div class="item-table item-secondary">'+
						'<select class="selectclass-min select-1-1" id="select1-1-'+data.tonos[i].CODTON+'" data-codton="'+data.tonos[i].CODTON+'">'+/*;
					for (var p = 0; p < data.rec1.length; p++) {
						html+=
							'<option value="'+data.rec1[p].CODREC1+'-'+data.rec1[p].LISTA2+'">'+data.rec1[p].DESREC1+'</option>';
					}
				html+=*/
						'</select>'+
					'</div>'+
					'<div class="item-table item-secondary">'+
						'<select class="selectclass-min select-1-2" id="select1-2-'+data.tonos[i].CODTON+'" data-codton="'+data.tonos[i].CODTON+'">'+/*;
					for (var p = 0; p < data.rec2.length; p++) {
						html+=
							'<option value="'+data.rec2[p].CODREC1+'-'+data.rec2[p].CODREC2+'">'+data.rec2[p].DESREC2+'</option>';
					}
				html+=*/
						'</select>'+
					'</div>'+
				'</div>';						
			}
			ar_rec1=data.rec1;
			ar_rec2=data.rec2;
			html+=
			'<script type="text/javascript">'+
				'$(".select-1").change(function(){'+
					'autoevaluar1(this);'+
				'});'+
				'$(".select-1-1").change(function(){'+
					'autoevaluar11(this);'+
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
								'<select class="selectclass-min select-2" id="select2-'+data.apariencia[i].CODAPA+'" data-codapa="'+data.apariencia[i].CODAPA+'" data-codgrprec="'+data.apariencia[i].CODGRPREC+'">'+
									'<option value="C">Aprobado no conforme</option>'+
									'<option value="R">Rechazado</option>'+
								'</select>'+
							'</div>'+
							'<div class="item-table itemr2-secondary">'+
								'<select class="selectclass-min select-2-1" id="select2-1-'+data.apariencia[i].CODAPA+'" data-codapa="'+data.apariencia[i].CODAPA+'">'+
								'</select>'+
							'</div>'+
							'<div class="item-table itemr2-secondary">'+
								'<input type="number" id="input2-2-'+data.apariencia[i].CODAPA+'" class="input" data-estdim="'+data.apariencia[i].CODAPA+'" value="0">'+
							'</div>'+
							'<div class="item-table itemr2-secondary">'+
								'<input type="number" id="input2-3-'+data.apariencia[i].CODAPA+'" class="input" data-estdim="'+data.apariencia[i].CODAPA+'" value="0">'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</div>';	
			}
			html+=
			'<script type="text/javascript">'+
				'$(".select-2").change(function(){'+
					'autoevaluar2(this);'+
				'});'+
				'$(".select-2-1").change(function(){'+
					'autoevaluar21(this);'+
				'});';
			$("#form2").append(html);

			var html='';
			for (var i = 0; i < data.estdim.length; i++) {
				var tol='';
				var min;
				var max;
				if (parseInt(data.estdim[i].TOLERANCIA)!=0) {
					tol='+/- '+data.estdim[i].TOLERANCIA+' '+data.estdim[i].DIMTOL;
				}else{
					tol=data.estdim[i].TOLERANCIA;
				}
				var val='';
				if (data.estdim[i].DIMVAL=="%") {
					/*
					val=parseFloat('0'+data.estdim[i].VALOR)*100+' '+data.estdim[i].DIMVAL;
					min=parseFloat('0'+data.estdim[i].VALOR)*100-parseFloat(data.estdim[i].TOLERANCIA);
					max=parseFloat('0'+data.estdim[i].VALOR)*100+parseFloat(data.estdim[i].TOLERANCIA);*/
					val=parseFloat('0'+data.estdim[i].VALOR)+' '+data.estdim[i].DIMVAL;
					min=parseFloat('0'+data.estdim[i].VALOR)-parseFloat(data.estdim[i].TOLERANCIA);
					max=parseFloat('0'+data.estdim[i].VALOR)+parseFloat(data.estdim[i].TOLERANCIA);							
				}else{
					val=data.estdim[i].VALOR;
					if (data.estdim[i].DIMTOL=="%") {
						min=parseFloat(data.estdim[i].VALOR)-parseFloat(data.estdim[i].VALOR)*parseFloat(data.estdim[i].TOLERANCIA)/100;
						max=parseFloat(data.estdim[i].VALOR)+parseFloat(data.estdim[i].VALOR)*parseFloat(data.estdim[i].TOLERANCIA)/100;
					}else{
						min=parseFloat(data.estdim[i].VALOR)-parseFloat(data.estdim[i].TOLERANCIA);
						max=parseFloat(data.estdim[i].VALOR)+parseFloat(data.estdim[i].TOLERANCIA);
					}
				}
				if (data.estdim[i].VALOR!="0") {
					html+=
					'<div class="line-table" id="line-3-'+data.estdim[i].CODESTDIM+'">'+
						'<div class="item-table item3-1">'+data.estdim[i].DESESTDIM+'</div>'+
						'<div class="item-table item3-2">'+tol+'</div>'+
						'<div class="item-table item3-2">'+val+'</div>'+
						'<div class="item-table item3-2">'+
							'<input type="number" id="" class="">'+
						'</div>'+
						'<div class="item-table item3-2">'+
							'<input type="number" id="aud3-'+data.estdim[i].CODESTDIM+'" class="input-validate" data-min="'+min+'" data-max="'+max+'" data-estdim="'+data.estdim[i].CODESTDIM+'" value="0" disabled>'+
						'</div>'+
						'<div class="item-table item3-2">'+
							'<select class="selectclass-min select-3" id="select-estdim-'+data.estdim[i].CODESTDIM+'" data-codestdim="'+data.estdim[i].CODESTDIM+'">'+
								'<option value="C">Aprobado no conforme</option>'+
								'<option value="R">Rechazado</option>'+
							'</select>'+
						'</div>'+
						'<div class="item-table item3-2">'+
							'<select class="selectclass-min select-3-1" id="select-estdim-1-'+data.estdim[i].CODESTDIM+'" data-codestdim="'+data.estdim[i].CODESTDIM+'">'+/*;
						for (var p = 0; p < data.rec1estdim.length; p++) {
							html+=
								'<option value="'+data.rec1estdim[p].CODREC1+'-'+data.rec1estdim[p].CAIDA+'">'+data.rec1estdim[p].DESREC1+'</option>';
						}
					html+=*/
							'</select>'+
						'</div>'+
						'<div class="item-table item3-2">'+
							'<input type="number" id="input3-2-'+data.estdim[i].CODESTDIM+'" class="input" data-estdim="'+data.estdim[i].CODESTDIM+'" value="0">'+
						'</div>'+
					'</div>';
				}
			}
			ar_estdimrec1=data.rec1estdim;
			html+=
			'<script type="text/javascript">'+
				'$(".input-validate").keyup(function(){'+
					//'validate3(this);'+
				'});'+
				'$(".select-3").change(function(){'+
					'autoevaluar3(this);'+
				'});'+
				'$(".select-3-1").change(function(){'+
					'autoevaluar31(this);'+
				'});';
			$("#form3").append(html);
			if (data.res1!=null) {
				res_1_v=data.res1;
				$("#idcalificacion-1").text(procesarResultado(data.res1));
				for (var i = 0; i < data.detalle1.length; i++) {
					/*
					if (data.detalle1[i].RESTSC!="R") {
						$("#line-1-"+data.detalle1[i].CODTON).remove();
					}else{
						$("#select1-"+data.detalle1[i].CODTON).val(data.detalle1[i].RESTSC);
						$("#select1-1-"+data.detalle1[i].CODTON).empty();
						$("#select1-1-"+data.detalle1[i].CODTON).append('<option>'+data.detalle1[i].DESREC1+'</option>');
						$("#select1-2-"+data.detalle1[i].CODTON).empty();
						$("#select1-2-"+data.detalle1[i].CODTON).append('<option>'+data.detalle1[i].DESREC2+'</option>');
					}*/
					$("#line-1-"+data.detalle1[i].CODTON).removeClass("lines-tono");
					$("#select1-"+data.detalle1[i].CODTON).val(data.detalle1[i].RESTSC);
					$("#select1-1-"+data.detalle1[i].CODTON).empty();
					$("#select1-1-"+data.detalle1[i].CODTON).append('<option>'+data.detalle1[i].DESREC1+'</option>');
					$("#select1-2-"+data.detalle1[i].CODTON).empty();
					$("#select1-2-"+data.detalle1[i].CODTON).append('<option>'+data.detalle1[i].DESREC2+'</option>');
				}
			}
			if (data.res2!=null) {
				res_2_v=data.res2;
				$("#idcalificacion-2").text(procesarResultado(data.res2));
				for (var i = 0; i < data.detalle2.length; i++) {
					/*if (data.detalle2[i].RESTSC!="R") {
						$("#line-2-"+data.detalle2[i].CODAPA).remove();
					}else{
						$("#select2-"+data.detalle2[i].CODAPA).val(data.detalle2[i].RESTSC);
					}*/
					$("#select2-"+data.detalle2[i].CODAPA).val(data.detalle2[i].RESTSC);
					$("#line-2-"+data.detalle2[i].CODAPA).css("display","flex");
				}
			}

			if (data.res3!=null) {
				res_3_v=data.res3;
				$("#idcalificacion-3").text(procesarResultado(data.res3));
				//$("#idcalificacion-3").val(data.res3);
				for (var i = 0; i < data.detalle3.length; i++) {
					if (data.detalle3[i].RESTSC!="R") {
						$("#line-3-"+data.detalle3[i].CODESTDIM).remove();
					}else{
						$("#aud3-"+data.detalle3[i].CODESTDIM).val(data.detalle3[i].VALORTSC);
						$("#aud3-"+data.detalle3[i].CODESTDIM).keyup();
						$("#select-estdim-"+data.detalle3[i].CODESTDIM).val(data.detalle3[i].RESTSC);
					}
					if (data.detalle3[i].DESREC1!="") {
						$("#select-estdim-1-"+data.detalle3[i].CODESTDIM).empty();
						$("#select-estdim-1-"+data.detalle3[i].CODESTDIM).append('<option>'+data.detalle3[i].DESREC1+'</option>');
						$("#input3-2-"+data.detalle3[i].CODESTDIM).val(data.detalle3[i].CAIDA);
					}
				}
			}
			if (data.partida.CODRES!="") {
				$("#selectResponsable").val(data.partida.CODRES);
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

			if(data.res1=='R'){
				show_form(1);
			}else{
				if(data.res2=='R'){
					show_form(2);
				}else{
					if(data.res3=='R'){
						show_form(3);
					}else{
						show_form(4);
					}
				}
			}
			$(".panelCarga").fadeOut(200);
		}
	});
});
var ar_rec1;
var ar_rec2;
var ar_estdimrec1;
var ar_select_save=[];
var block_save=0;
function validate_form1(){
	var array=document.getElementsByClassName("select-1");
	var validar=true;
	var ar_select=[];
	for (var i = 0; i < array.length; i++) {
		//console.log(array[i].dataset.codton+" - "+array[i].value);
		var aux=[];
		aux.push(array[i].dataset.codton);
		aux.push(array[i].value);
		if ($("#select1-1-"+array[i].dataset.codton).val()!=null) {
			var ar_codrec1=$("#select1-1-"+array[i].dataset.codton).val().split("-");
			aux.push(ar_codrec1[0]);
		}else{
			aux.push("");
		}
		if ($("#select1-2-"+array[i].dataset.codton).val()!=null) {
			var ar_codrec2=$("#select1-2-"+array[i].dataset.codton).val().split("-");
			aux.push(ar_codrec2[1]);
		}else{
			aux.push("");
		}
		ar_select.push(aux);
	}
	block_save=1;
	ar_select_save=ar_select;
	$("#modal-form6").css("display","block");
}
var tam_obs=100;
function save_block(){
	$(".panelCarga").fadeIn(200);
	if (block_save==1) {
		if ($("#observacion1").val().length>100) {
			alert("La observación debe tener menos de "+tam_obs+" caracteres!");
		}else{
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
					array:ar_select_save,
					resultado:res_1_v,
					codusu:codusu_v,
					perusu:perfil_usu,
					obs:$("#observacion1").val(),
					codres:$("#selectResponsable").val()
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						//window.location.href="ListaASupervisar.php";
						alert("Datos guardados!");
						if (data.tryend) {
							var c=confirm("Desea terminar la auditoria de la partida?");
							if (c) {
								change_end_auditoria();
							}
						}
					}else{
						alert(data.detail);
					}
					$("#modal-form6").css("display","none");
					$(".panelCarga").fadeOut(200);
				}
			});
		}
	}else{
		if (block_save==3) {	
			if ($("#observacion3").val().length>100) {
				alert("La observación debe tener menos de "+tam_obs+" caracteres!");
			}else{				
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
						array:ar_select_save,
						resultado:res_3_v,
						codusu:codusu_v,
						perusu:perfil_usu,
						obs:$("#observacion3").val(),
						codres:$("#selectResponsable").val()
					},
					success:function(data){
						console.log(data);
						/*
						if (data.state) {
							window.location.href="ListaASupervisar.php";
						}else{
							alert(data.detail);
							$(".panelCarga").fadeOut(200);
							$("#modal-form6").css("display","none");
						}*/
						if (data.state) {
							//window.location.href="ListaASupervisar.php";
							alert("Datos guardados!");
							if (data.tryend) {
								var c=confirm("Desea terminar la auditoria de la partida?");
								if (c) {
									change_end_auditoria();
								}
							}
						}else{
							alert(data.detail);
						}
						$("#modal-form6").css("display","none");
						$(".panelCarga").fadeOut(200);
					}
				});
			}
		}else{
			if (block_save==2) {
				if ($("#observacion2").val().length>100) {
					alert("La observación debe tener menos de "+tam_obs+" caracteres!");
				}else{
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
							array:ar_select_save,
							resultado:res_2_v,
							codusu:codusu_v,
							perusu:perfil_usu,
							obs:$("#observacion2").val(),
							codres:$("#selectResponsable").val()
						},
						success:function(data){
							console.log(data);
							/*if (data.state) {
								window.location.href="ListaASupervisar.php";
							}else{
								alert(data.detail);
								$(".panelCarga").fadeOut(200);
							}*/
							if (data.state) {
								//window.location.href="ListaASupervisar.php";
								alert("Datos guardados!");
								if (data.tryend) {
									var c=confirm("Desea terminar la auditoria de la partida?");
									if (c) {
										change_end_auditoria();
									}
								}
							}else{
								alert(data.detail);
							}
							$("#modal-form6").css("display","none");
							$(".panelCarga").fadeOut(200);
						}
					});
				}
			}else{
				if ($("#observacion4").val().length>100) {
					alert("La observación debe tener menos de "+tam_obs+" caracteres!");
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
							obs:$("#observacion4").val(),
							resultado:$("#idResultado4").val(),
							codres:$("#selectResponsable").val()
						},
						success:function(data){
							console.log(data);
							if(data.state){
								if (data.tryend==1) {
									change_end_auditoria();
								}
								$("#modal-form6").css("display","none");
								$(".panelCarga").fadeOut(200);
							}else{
								alert(data.detail);
							}
						}
					});
				}
			}
		}				
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
		if ($("#select2-1-"+array[i].dataset.codapa).val()==null) {
			aux.push("");
			aux.push("");
			aux.push("0");
			aux.push("0");
		}else{
			aux.push(array[i].dataset.codgrprec);
			var ar_rec1=$("#select2-1-"+array[i].dataset.codapa).val().split("-");
			aux.push(ar_rec1[0]);
			aux.push($("#input2-2-"+array[i].dataset.codapa).val());
			aux.push($("#input2-3-"+array[i].dataset.codapa).val());
		}
		ar_select.push(aux);
	}
	block_save=2;
	ar_select_save=ar_select;
	$("#modal-form6").css("display","block");
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
		aux.push(document.getElementById("aud3-"+array[i].dataset.codestdim).value*100);
		var ar_codrec1=document.getElementById("select-estdim-1-"+array[i].dataset.codestdim).value.split("-");
		aux.push(ar_codrec1[0]);
		aux.push(document.getElementById("input3-2-"+array[i].dataset.codestdim).value*100);
		ar_select.push(aux);
		if (array[i].value=="") {
			validate=false;
		}
	}
	if (validate) {
		block_save=3;
		ar_select_save=ar_select;
		$("#modal-form6").css("display","block");
	}else{
		alert("Complete los valores!");
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
	var validar=false;
	for (var i = 0; i < aud_per.length; i++) {
		if(aud_per[i]==num_form){
			validar=true;
		}
	}
	//var validar=true;
	if (validar) {
		$(".forms-content").css("display","none");
		$("#form-"+num_form).css("display","block");
		var array=document.getElementsByClassName("part-auditoria");
		for (var i = 0; i < array.length; i++) {
			array[i].classList.remove("part-active");
		}
		//console.log(num_form);
		document.getElementById("redirect-"+num_form).classList.add("part-active");
	}else{
		alert("Bloque no disponible!");
	}
}
function iniciar_auditoria(){
	window.location.href="AuditoriaTela.php?p="+$("#idpartida").val();
}
function finish_auditoria_tela(){
	if(numrollos_v.length!=rollosaud_v){
		alert("Faltan agregar rollos para auditar!");
	}else{
		block_save=4;
		$("#modal-form6").css("display","block");
	}
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
			}
			$(".panelCarga").fadeOut(200);
		}
	});
}
