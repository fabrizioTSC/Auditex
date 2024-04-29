$(document).ready(function(){
	/*
	$.ajax({
		type:"POST",
		data:{
		},
		url:"config/getFiltroRepMinComEst.php",
		success:function(data){
			console.log(data);

			esttsc=data.esttsc;
			var html='';
			for (var i = 0; i < esttsc.length; i++) {
				html+='<div class="taller" onclick="selectEsttsc(\''+esttsc[i].CODESTTSC+'\',\''+esttsc[i].DESESTTSC+'\')">'+esttsc[i].DESESTTSC+'</div>';
			}
			$("#spaceesttsc").empty();
			$("#spaceesttsc").append(html);

			ficha=data.ficha;
			var html='';
			for (var i = 0; i < ficha.length; i++) {
				html+='<div class="taller" onclick="selectFicha(\''+ficha[i].CODFIC+'\',\''+ficha[i].DESFIC+'\')">'+ficha[i].DESFIC+'</div>';
			}
			$("#spaceficha").empty();
			$("#spaceficha").append(html);

			$("#nombreEsttsc").val("(TODOS)");
			$("#nombreFicha").val("(TODOS)");
			codesttsc_var="0";
			codfic_var="0";

			$(".panelCarga").fadeOut(200);			
		}
	});
	$("#nombreEsttsc").keyup(function(){
		var html='';
		for (var i = 0; i < esttsc.length; i++) {
			if ((esttsc[i].DESESTTSC.toUpperCase()).indexOf($("#nombreEsttsc").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="selectEsttsc(\''+esttsc[i].CODESTTSC+'\',\''+esttsc[i].DESESTTSC+'\')">'+esttsc[i].DESESTTSC+'</div>';
			}
		}
		$("#spaceesttsc").empty();
		$("#spaceesttsc").append(html);		
	});
	$("#nombreFicha").keyup(function(){
		var html='';
		for (var i = 0; i < ficha.length; i++) {
			if ((ficha[i].DESFIC.toUpperCase()).indexOf($("#nombreFicha").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="selectFicha(\''+ficha[i].CODFIC+'\',\''+ficha[i].DESFIC+'\')">'+ficha[i].DESFIC+'</div>';
			}
		}
		$("#spaceficha").empty();
		$("#spaceficha").append(html);	
	});*/
	var fecha=new Date();
  	fecha.setDate(fecha.getDate() - 1);
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
	document.getElementById("idfecini").value=hoy;
	document.getElementById("idfecfin").value=hoy;
});

var codesttsc_var="";
function selectEsttsc(codesttsc,desesttsc){
	codesttsc_var=codesttsc;
	$("#nombreEsttsc").val(desesttsc);

	var html='';
	if (codesttsc=="0") {
		for (var i = 0; i < ficha.length; i++) {
			html+='<div class="taller" onclick="selectFicha(\''+ficha[i].CODFIC+'\',\''+ficha[i].DESFIC+'\')">'+ficha[i].DESFIC+'</div>';
		}
	}else{
		html='<div class="taller" onclick="selectFicha(\''+ficha[0].CODFIC+'\',\''+ficha[0].DESFIC+'\')">'+ficha[0].DESFIC+'</div>';
		for (var i = 0; i < ficha.length; i++) {
			if (ficha[i].ESTTSC==codesttsc) {
				html+='<div class="taller" onclick="selectFicha(\''+ficha[i].CODFIC+'\',\''+ficha[i].DESFIC+'\')">'+ficha[i].DESFIC+'</div>';	
			}
		}
	}
	$("#spaceficha").empty();
	$("#spaceficha").append(html);
}

var codfic_var="";
function selectFicha(codfic,desfic){
	codfic_var=codfic;
	$("#nombreFicha").val(desfic);
}

function showReporte(){
	let esttsc="";
	if ($("#nombreEsttsc").val()=="") {
		esttsc="0";
		codfic_var="0";
	}else{
		esttsc=$("#nombreEsttsc").val();
	}
	if (document.getElementById("resultesttsc").style.display=="none") {
		let c=confirm("Desea buscar en todos los estilos?");
		if (c) {
			esttsc="0";
			codfic_var="0";
			window.location.href='ReporteMinComEst.php?esttsc='+esttsc+'&codfic='+codfic_var+
			'&fecini='+$("#idfecini").val()+'&fecfin='+$("#idfecfin").val();
		}
	}else{
		if (codfic_var=="") {
			alert("Seleccione una ficha!");
		}else{
			window.location.href='ReporteMinComEst.php?esttsc='+esttsc+'&codfic='+codfic_var+
			'&fecini='+$("#idfecini").val()+'&fecfin='+$("#idfecfin").val();
		}
	}
}

function consultar_esttsc(){
	$(".panelCarga").fadeIn(200);
	$.ajax({
		type:"POST",
		data:{
			esttsc:$("#nombreEsttsc").val()
		},
		url:"config/getFiltroRepMinComEst.php",
		success:function(data){
			console.log(data);
			codfic_var="";
			if (data.ficha.length==1) {
				alert("No hay fichas para el estilo!");
				$("#resultesttsc").css("display","none");
			}else{
				ficha=data.ficha;
				var html='';
				for (var i = 0; i < ficha.length; i++) {
					html+='<div class="taller" onclick="selectFicha(\''+ficha[i].CODFIC+'\',\''+ficha[i].DESFIC+'\')">'+ficha[i].DESFIC+'</div>';
				}
				$("#spaceficha").empty();
				$("#spaceficha").append(html);

				$("#nombreFicha").val("(TODOS)");
				codfic_var="0";
				$("#resultesttsc").css("display","block");
			}
			$(".panelCarga").fadeOut(200);			
		}
	});	
}