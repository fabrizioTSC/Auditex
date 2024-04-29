var esttsc=[];
var ficha=[];
$(document).ready(function(){
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
	});/*
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
	document.getElementById("idFecha").value=hoy;*/
});

function consultar_esttsc(){
	$(".panelCarga").fadeIn(200);
	$.ajax({
		type:"POST",
		data:{
			esttsc:$("#nombreEsttsc").val()
		},
		url:"config/getFichasRepDesMed.php",
		success:function(data){
			console.log(data);

			if (data.ficha.length!=0) {
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
			}else{
				alert("No se encontró el estilo!");
				$("#resultesttsc").css("display","none");
			}
			$(".panelCarga").fadeOut(200);			
		}
	});
}

var codesttsc_var="";
function selectEsttsc(codesttsc,desesttsc){
	codesttsc_var=codesttsc;
	$("#nombreEsttsc").val(desesttsc);

	var html='<div class="taller" onclick="selectFicha(\''+ficha[0].CODFIC+'\',\''+ficha[0].DESFIC+'\')">'+ficha[0].DESFIC+'</div>';
	for (var i = 0; i < ficha.length; i++) {
		if (ficha[i].ESTTSC==codesttsc) {
			html+='<div class="taller" onclick="selectFicha(\''+ficha[i].CODFIC+'\',\''+ficha[i].DESFIC+'\')">'+ficha[i].DESFIC+'</div>';
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

function mostraReporte(){
	if (codfic_var=="") {
		alert("Seleccione una ficha!");
	}else{
		window.location.href="ReporteDesMed.php?esttsc="+$("#nombreEsttsc").val()+"&codfic="+codfic_var;
	}
}