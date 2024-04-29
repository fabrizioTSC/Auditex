function search_ficha(){	
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		url:"config/getFichasACH.php",
		data:{
			codfic:$("#idcodfic").val()
		},
		success:function(data){
			console.log(data);
			if (data.state) {
				window.location.href="AudConHum.php?codfic="+$("#idcodfic").val();
			}else{
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(100);
		}
	});	
}
/*
var codAqlForUpdate=0;
function comenzarAuditoria(){
	var tipoMuestra="";
	var codAuditoria=0;
	var numMuestra=0;
	if (document.getElementById("idCheckAql").checked==true) {
		tipoMuestra="aql";
		codAqlForUpdate=fichaCodAql;
		sendParameters(codficFinal,tipoMuestra,numMuestra);
	}else{
		alert("Seleccione su tipo de muestra.");
	}
}

var fichaCodTad=0;
var fichaNumVez=0;
var fichaParte=0;
var fichaCodAql=0;
function fichaSelection(codfic,aql,codtad,numvez,parte,codaql){
	fichaCodTad=codtad;
	fichaNumVez=numvez;
	fichaParte=parte;
	fichaCodAql=codaql;
	document.getElementById("fichaSelected").style.display="block";
	$("#fichaSelected").empty();
	$("#fichaSelected").append("Ficha seleccionada: "+codfic);
	codficFinal=codfic;
	document.getElementById("aqlValue").innerHTML=aql+"%";
	document.getElementById("muestraSelection").style.display="block";	
	var checkList =document.getElementsByClassName("iptCheckBox");
	for (var i = 0; i < checkList.length; i++) {
		checkList[i].checked=false;
	}
	$(".iptForDiscrecional").css("display","none");
	$("#idNumberPrendas").val("");	
	$("#idCheckAql").click();
	$(".finalBtn").css("display","block");
}

function sendParameters(codficFinal,tipoMuestra,numMuestra){
	$(".panelCarga").fadeIn(200);
	var numeroPrendas=0;
	if($("#idNumberPrendas").val()!=""){
		numeroPrendas=$("#idNumberPrendas").val();
	}
	$.ajax({
		type:"POST",
		url:"config/updateFichaAPC.php",
		data:{			
			codfic:codficFinal,
			numvez:fichaNumVez,
			parte:fichaParte,
			codaql:fichaCodAql,
			codtad:fichaCodTad,
			tipaud:tipoMuestra,
			newnumero:numeroPrendas,
			codusu:codusu
		},
		success:function(data){
			//console.log(data);
			if(data.state==false){
				alert(data.err.description);
				$(".panelCarga").fadeOut(300);
			}else{
				window.location.href="AudProCor.php?codFic="+codficFinal+
				"&numvez="+fichaNumVez+"&parte="+fichaParte+"&codtad="+fichaCodTad+
				"&tipoMuestra="+tipoMuestra+"&numMuestra="+numMuestra+"&codaql="+fichaCodAql;
			}
		}
	});
}*/