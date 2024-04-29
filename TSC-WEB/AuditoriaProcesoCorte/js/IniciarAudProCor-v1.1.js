var listaFichas=[];
function getFichas(){
	$(".panelCarga").fadeIn(300);
	$.ajax({
		type:"POST",
		url:"config/getFichasAPC.php",
		success:function(data){
			//console.log(data);
			if (data.state==false) {
				alert(data.description);
			}else{
				listaFichas= data.fichas;
				$(".tblBody").empty();
				var htmlFichas="";
				for (var i = 0; i < listaFichas.length; i++) {
					htmlFichas+=
					'<div class="tblLine" onclick="fichaSelection('+listaFichas[i].CODFIC+',\''+
						listaFichas[i].AQL+'\','+
						listaFichas[i].CODTAD+','+
						listaFichas[i].NUMVEZ+','+
						listaFichas[i].PARTE+','+
						listaFichas[i].CODAQL+')">'+
						'<div class="itemBody codAuditoria">'+listaFichas[i].CODFIC+'</div>'+
						'<div class="itemBody">'+listaFichas[i].CODUSU+'</div>'+
						'<div class="itemBody">'+listaFichas[i].PARTE+'</div>'+
						'<div class="itemBody">'+listaFichas[i].NUMVEZ+'</div>'+
						'<div class="itemBody">'+listaFichas[i].CANPAR+'</div>'+
					'</div>';
				}
				$(".tblBody").append(htmlFichas);
			}
			$(".panelCarga").fadeOut(300);
		}
	});		
}

function search_ficha(){	
	document.getElementById("fichaSelection").style.display="none";
	document.getElementById("muestraSelection").style.display="none";
	$(".panelCarga").fadeIn(300);
	$.ajax({
		type:"POST",
		url:"config/getFichasAPC.php",
		data:{
			codfic:$("#idcodfic").val()
		},
		success:function(data){
			console.log(data);
			if (data.state==false) {
				alert(data.description);
				$("#resultcontent").css("display","none");
			}else{
				listaFichas= data.fichas;
				$(".tblBody").empty();
				var htmlFichas="";
				for (var i = 0; i < listaFichas.length; i++) {
					htmlFichas+=
					'<div class="tblLine" onclick="fichaSelection('+listaFichas[i].CODFIC+',\''+
						listaFichas[i].AQL+'\','+
						listaFichas[i].CODTAD+','+
						listaFichas[i].NUMVEZ+','+
						listaFichas[i].PARTE+','+
						listaFichas[i].CODAQL+')">'+
						'<div class="itemBody codAuditoria">'+listaFichas[i].CODFIC+'</div>'+						
						'<div class="itemBody">'+listaFichas[i].CODUSU+'</div>'+
						'<div class="itemBody">'+listaFichas[i].PARTE+'</div>'+
						'<div class="itemBody">'+listaFichas[i].NUMVEZ+'</div>'+
						'<div class="itemBody">'+listaFichas[i].CANPAR+'</div>'+
					'</div>';
				}
				$(".tblBody").append(htmlFichas);
				$("#resultcontent").css("display","block");
				$(".finalBtn").css("display","none");
			}
			$(".panelCarga").fadeOut(300);
		}
	});	
}

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
	/* AUTO CLICK A AQL*/
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
}