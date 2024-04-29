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

function sendParameters(codficFinal,tipoMuestra,numMuestra){
	$(".panelCarga").fadeIn(200);
	var numeroPrendas=0;
	if($("#idNumberPrendas").val()!=""){
		numeroPrendas=$("#idNumberPrendas").val();
	}
	$.ajax({
		type:"POST",
		url:"config/updateFichaAuditoriaCorte.php",
		data:{			
			codfic:codficFinal,
			numvez:fichaNumVez,
			parte:fichaParte,
			codaql:fichaCodAql,
			codtad:fichaCodTad,
			tipaud:tipoMuestra,
			newnumero:numeroPrendas,
			usuario:usuario_afc
		},
		success:function(data){
			//console.log(data);
			if(data.state==false){
				alert(data.err.description);
				$(".panelCarga").fadeOut(300);
			}else{
				window.location.href="RegistrarAudFinCor.php?codFic="+codficFinal+
				"&numvez="+fichaNumVez+"&parte="+fichaParte+"&codtad="+fichaCodTad+
				"&tipoMuestra="+tipoMuestra+"&numMuestra="+numMuestra+"&codaql="+fichaCodAql;
			}
		}
	});
}