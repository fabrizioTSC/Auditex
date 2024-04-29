var sedes=[];
var tipser=[];
var semanas=[];
function getTalleres(){
	$.ajax({
		type:"POST",
		url:"config/getFiltroRepRanLineas.php",
		data:{
			request:"1"
		},
		success:function(data){
			console.log(data);

			sedes=data.sedes;
			var html='';
			for (var i = 0; i < sedes.length; i++) {
				html+='<div class="taller" onclick="selectSede(\''+sedes[i].CODSEDE+'\',\''+formatText(sedes[i].DESSEDE)+'\')">'+sedes[i].DESSEDE+'</div>';
			}
			$("#spaceSedes").empty();
			$("#spaceSedes").append(html);

			tipser=data.tipser;
			var html='';
			for (var i = 0; i < tipser.length; i++) {
				html+='<div class="taller" onclick="selectTipSer(\''+tipser[i].CODTIPSERV+'\',\''+formatText(tipser[i].DESTIPSERV)+'\')">'+tipser[i].DESTIPSERV+'</div>';
			}
			$("#spaceTipoSer").empty();
			$("#spaceTipoSer").append(html);

			$("#nombreSede").val("(TODOS)");
			$("#nombreTipoSer").val("(TODOS)");
			$("#nombreAuditor").val("(TODOS)");
			codsede_var="0";
			codtipser_var="0";

			var html='';
			for (var i = 0; i < data.anios.length; i++) {
				html+='<option value="'+data.anios[i].ANIO+'">'+data.anios[i].ANIO+'</option>';
			}
			$(".select-anio").empty();
			$(".select-anio").append(html);
			$(".select-anio").val(data.anio);

			semanas=data.semanas;
			var html='';
			for (var i = 0; i < semanas.length; i++) {
				html+='<option value="'+semanas[i].NUMERO_SEMANA+'">Sem. '+semanas[i].NUMERO_SEMANA+' - Del '+semanas[i].MIN+' al '+semanas[i].MAX+'</option>';
			}
			$("#select-semana").empty();
			$("#select-semana").append(html);
			$("#select-semana").val(data.semana);
			
			$("#ipt1").click();

			var fecha=new Date();
			var dia=fecha.getDate();
			dia=""+dia;
			if (dia.length==1) {
				dia="0"+dia;
			}
			var mes=fecha.getMonth()+1;
			mes=""+mes;
			if (mes.length==1) {
				mes="0"+mes;
			}
			var anio=fecha.getFullYear();
			var hoy=anio+"-"+mes+"-"+dia;
			document.getElementById("rango1").value=hoy;
			document.getElementById("rango2").value=hoy;

			$("#select-mes1").val(mes);

			$(".panelCarga").fadeOut(200);
		}
	});
}

function mostraDatos() {
	var mensaje="";
	if (codtll==0) {
		mensaje+="Se mostrarán todos los talleres";
		if (codusu==0) {
			mensaje+=" y todos los auditores!";
		}
	}else{
		if (codusu==0) {
			mensaje+="Se mostrarán todos los auditores!";
		}
	}
	if (mensaje!="") {
		/*var option=confirm(mensaje);
		if (option==true) {*/
			enviarParamaetros();
		/*}*/
	}else{
		enviarParamaetros();
	}
}

function enviarParamaetros(){
	var add="";
	if (document.getElementById("ipt1").checked) {
		add+="&option=1&anio="+$("#select-anio1").val()+"&mes="+$("#select-mes1").val();
	}
	if (document.getElementById("ipt2").checked) {
		add+="&option=2&anio="+$("#select-anio").val()+"&semana="+$("#select-semana").val();
	}
	if (document.getElementById("ipt3").checked) {
		add+="&option=3&fecini="+$("#rango1").val()+"&fecfin="+$("#rango2").val();
	}
	var url="ReporteRangoLinea.php?codsede="+codsede_var+"&codtipser="+codtipser_var+add;
	//console.log(url);
	window.location.href=url;
}

$(document).ready(function(){
	$("#nombreSede").keyup(function(){
		var html='';
		for (var i = 0; i < sedes.length; i++) {
			if ((sedes[i].DESSEDE.toUpperCase()).indexOf($("#nombreSede").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="selectSede(\''+sedes[i].CODSEDE+'\',\''+formatText(sedes[i].DESSEDE)+'\')">'+sedes[i].DESSEDE+'</div>';
			}
		}
		$("#spaceSedes").empty();
		$("#spaceSedes").append(html);		
	});
	$("#nombreTipoSer").keyup(function(){
		var html='';
		for (var i = 0; i < tipser.length; i++) {
			if ((tipser[i].DESTIPSERV.toUpperCase()).indexOf($("#nombreTipoSer").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="selectTipSer(\''+tipser[i].CODTIPSERV+'\',\''+formatText(tipser[i].DESTIPSERV)+'\')">'+tipser[i].DESTIPSERV+'</div>';
			}
		}
		$("#spaceTipoSer").empty();
		$("#spaceTipoSer").append(html);
	});

	var arrayselect=document.getElementsByClassName("special-select");
	var arrayinput=document.getElementsByClassName("special-input");
	$(".input-radio-class").click(function(){
		var idctrl=this.id;
		for (var i = 0; i < arrayselect.length; i++) {
			if(arrayselect[i].dataset.ctrl==idctrl){
				arrayselect[i].disabled=false;
			}else{
				arrayselect[i].disabled=true;
			}
		}
		for (var i = 0; i < arrayinput.length; i++) {
			if(arrayinput[i].dataset.ctrl==idctrl){
				arrayinput[i].disabled=false;
			}else{
				arrayinput[i].disabled=true;
			}
		}
	});
	$(".input-radio-class").click(function(){
		var idctrl=this.id;
		for (var i = 0; i < arrayselect.length; i++) {
			if(arrayselect[i].dataset.ctrl==idctrl){
				arrayselect[i].disabled=false;
			}else{
				arrayselect[i].disabled=true;
			}
		}
		for (var i = 0; i < arrayinput.length; i++) {
			if(arrayinput[i].dataset.ctrl==idctrl){
				arrayinput[i].disabled=false;
			}else{
				arrayinput[i].disabled=true;
			}
		}
	});
	$("#select-anio").change(function(){
		$(".panelCarga").fadeIn(200);
		$.ajax({
			type:"POST",
			url:"config/getSemanasRepRanLinea.php",
			data:{
				anio:this.value
			},
			success:function(data){
				console.log(data);				
				semanas=data.semanas;
				var html='';
				for (var i = 0; i < semanas.length; i++) {
					html+='<option value="'+semanas[i].NUMERO_SEMANA+'">Sem. '+semanas[i].NUMERO_SEMANA+' - Del '+semanas[i].MIN+' al '+semanas[i].MAX+'</option>';
				}
				$("#select-semana").empty();
				$("#select-semana").append(html);
				$(".panelCarga").fadeOut(200);
			}
		});		
	});
});

var codsede_var="";
function selectSede(codsede,dessede){
	codsede_var=codsede;
	$("#nombreSede").val(dessede);
	$("#nombreTipoSer").val("(TODOS)");
	codtipser_var="0";
}

var codtipser_var="";
function selectTipSer(codtipser,destipser){
	if (codsede_var=="") {
		alert("Seleccione una sede primero!");
	}else{
		codtipser_var=codtipser;
		$("#nombreTipoSer").val(destipser);
	}
}