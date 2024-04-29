function cargarAuditoriaRegistrada(codfic,tipoAud,cantidadDeMuestra,numvez,parte,codtad,codaql){
	document.getElementById("idCodFicha").innerHTML=codfic;
	document.getElementById("idNumPrendasAuditar").innerHTML="("+cantidadDeMuestra+" prendas)";
	$.ajax({
		type:"POST",
		data:{
			codfic:codfic,
			numvez:numvez,
			parte:parte,
			codtad:codtad,
			codaql:codaql
		},
		url:"config/getFichaAPC.php",
		success:function(data){
			console.log(data);
			document.getElementById("idNombreTaller").innerHTML=data.ficha.DESTLL;
			if (data.ficha.CANPRE!=data.ficha.CANPAR) {
				document.getElementById("idCantPrendas").innerHTML=data.ficha.CANPAR+" de "+data.ficha.CANPRE;	
			}else{
				document.getElementById("idCantPrendas").innerHTML=data.ficha.CANPAR;
			}			
			if (tipoAud=="aql") {
				document.getElementById("idMuestreo").innerHTML=tipoAud.toUpperCase()+" "+data.ficha.AQL+"%";
			}else{
				document.getElementById("idMuestreo").innerHTML=tipoAud.toUpperCase();
			}
			getAuditoriaDefectos(codfic,numvez,parte,codtad);
		}
	});
}

function getAuditoriaDefectos(codfic,numvez,parte,codtad){
	$.ajax({
		type:"POST",
		data:{
			codfic:codfic,
			numvez:numvez,
			parte:parte,
			codtad:codtad
		},
		url:"config/getDefectosAPC.php",
		success:function(data){
			var htmlContent="";
			var suma=0;
			for (var i = 0; i < data.defectos.length; i++) {
				htmlContent+=
				'<div class="tblLine">'+
					'<div class="itemBody" style="width: 80%;">'+data.defectos[i].DESDEF+'</div>'+
					'<div class="itemBody" style="width: 20%;">'+data.defectos[i].CANDEF+'</div>'+
				'</div>';				
				if (i==0) {
					suma=parseInt(data.defectos[i].CANDEF);
				}else{
					suma+=parseInt(data.defectos[i].CANDEF);
				}
			}
			htmlContent+=
				'<div class="tblLine finalPartTbl">'+
					'<div class="itemBody" style="width: 80%;">TOTAL</div>'+
					'<div class="itemBody" style="width: 20%;">'+suma+'</div>'+
				'</div>';
			$(".tblBody").append(htmlContent);
			$(".panelCarga").fadeOut(300);
		}
	});
}