$(document).ready(function(){
	$("#idCodfic").keyup(function(){
		$(".tblBody").empty();
		var htmlFichas="";
		for (var i = 0; i < listaFichas.length; i++) {
			if(listaFichas[i].CODFIC.indexOf($("#idCodfic").val())>=0){

				// htmlFichas+=
				// '<div class="tblLine" onclick="fichaSelection('+listaFichas[i].CODFIC+',\''+
				// 	listaFichas[i].AQL+'\','+
				// 	listaFichas[i].CODTAD+','+
				// 	listaFichas[i].NUMVEZ+','+
				// 	listaFichas[i].PARTE+','+
				// 	listaFichas[i].CODAQL+')">'+
				// 	'<div class="itemBody codAuditoria">'+listaFichas[i].CODFIC+'</div>';
                htmlFichas += `

					<div class="tblLine"
						onclick="fichaSelection(${listaFichas[i].CODFIC},'${listaFichas[i].AQL}',${listaFichas[i].CODTAD},${listaFichas[i].NUMVEZ},
						${listaFichas[i].PARTE},${listaFichas[i].CODAQL},'${listaFichas[i].TIPAUD}')"
					>
					<div class="itemBody codAuditoria"> ${listaFichas[i].CODFIC} </div>

				`;


					if (listaFichas[i].TIPAUD='M') {
						htmlFichas+='<div class="itemBody">Final costura</div>';
					}else{
						htmlFichas+='<div class="itemBody">Otra auditoria</div>';
					}
				htmlFichas+=
					'<div class="itemBody">'+listaFichas[i].PARTE+'</div>'+
					'<div class="itemBody">'+listaFichas[i].NUMVEZ+'</div>'+
					'<div class="itemBody">'+listaFichas[i].CANPAR+'</div>'+
				'</div>';
			}
		}
		$(".tblBody").append(htmlFichas);
	});
});

var codAqlForUpdate=0;
function comenzarAuditoria(){
	var tipoMuestra="";
	var codAuditoria=0;
	var numMuestra=0;
	if (document.getElementById("idCheckDiscrecional").checked==true) {
		tipoMuestra="discrecional";
		codAqlForUpdate=0;
		if ($("#idNumberPrendas").val()=="") {
			alert("Debe ingresar un numero de prendas para discrecional.");
		}else{
			numMuestra=$("#idNumberPrendas").val();
			sendParameters(codficFinal,tipoMuestra,numMuestra);
		}
	}else{
		if (document.getElementById("idCheckAql").checked==true) {
			tipoMuestra="aql";
			codAqlForUpdate=fichaCodAql;
			sendParameters(codficFinal,tipoMuestra,numMuestra);
		}else{
			alert("Seleccione su tipo de muestra.");
		}
	}
}

function sendParameters(codficFinal,tipoMuestra,numMuestra){
	$(".panelCarga").fadeIn(300);
	//console.log(usuario);
	var numeroPrendas=0;
	if($("#idNumberPrendas").val()!=""){
		numeroPrendas=$("#idNumberPrendas").val();
	}
	$.ajax({
		type:"POST",
		url:"config/updateFichaAuditoria.php",
		data:{			
			codfic:codficFinal,
			numvez:fichaNumVez,
			parte:fichaParte,
			codaql:fichaCodAql,
			codtad:fichaCodTad,
			tipaud:tipoMuestra,
			newnumero:numeroPrendas,
			codusu:codUsuario,
			usuario:usuario,
			codtll:codTaller,
			tipoauditoria:fichatipoauditoria
		},
		success:function(data){
			//console.log(data);
			if(data.state==false){
				alert(data.err.description);
				$(".panelCarga").fadeOut(300);
			}else{


				window.location.href="RegistroDePrendas.php?codFic="+codficFinal+"&codtll="+codTaller+
				"&numvez="+fichaNumVez+"&parte="+fichaParte+"&codtad="+fichaCodTad+
				"&tipoMuestra="+tipoMuestra+"&numMuestra="+numMuestra+"&codaql="+fichaCodAql+"&tipoauditoria="+fichatipoauditoria;


			}
		}
	});
}