function redirect(path){
	window.location.href=path;
}

/**********************/
/* Variables Globales */
var codficFinal="";
var codTaller="";
/**********************/
var listaTalleres=[];
var codUsuario=0;
function getTalleres(codusu){
	codUsuario=codusu;
	$.ajax({
		type:"POST",
		url:"config/getTalleres.php",
		data:{
			request:"1"
		},
		success:function(data){
			$(".listaTalleres").empty();
			var htmlTalleres="";
			for (var i = 0; i < data.talleres.length; i++) {
				//htmlTalleres+='<div class="taller" onclick="addWord(\''+data.talleres[i].DESTLL+'\','+data.talleres[i].CODTLL+')">'+data.talleres[i].DESTLL+'|'+data.talleres[i].CODTLL+'</div>';
				htmlTalleres+='<div class="taller" onclick="addWord(\''+data.talleres[i].DESTLL+'\','+data.talleres[i].CODTLL+')">'+data.talleres[i].DESTLL+'|'+data.talleres[i].DESCOM+'</div>';
			}
			listaTalleres.push(data.talleres);
			$(".listaTalleres").append(htmlTalleres);
			$(".panelCarga").fadeOut(300);
		}
	});
}

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
			codusu:codUsuario
		},
		success:function(data){
			console.log(data);
			if(data.state==false){
				alert(data.err.description);
				$(".panelCarga").fadeOut(300);
			}else{
				window.location.href="RegistroDePrendas.php?codFic="+codficFinal+"&codtll="+codTaller+
				"&numvez="+fichaNumVez+"&parte="+fichaParte+"&codtad="+fichaCodTad+
				"&tipoMuestra="+tipoMuestra+"&numMuestra="+numMuestra+"&codaql="+fichaCodAql;
			}
		}
	});
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
}
function getFichas(){
	if (codTaller=="") {
		alert("Seleccione un taller de la lista");
	}else{
		$(".panelCarga").fadeIn(300);
		$.ajax({
			type:"POST",
			url:"config/getFichas.php",
			data:{
				codtll:codTaller
			},
			success:function(data){
				if (data.state==false) {
					alert(data.description);
				}else{
					$(".tblBody").empty();
					console.log(data);
					var htmlFichas="";
					for (var i = 0; i < data.fichas.length; i++) {
						htmlFichas+=
						'<div class="tblLine" onclick="fichaSelection('+data.fichas[i].CODFIC+',\''+
							data.fichas[i].AQL+'\','+
							data.fichas[i].CODTAD+','+
							data.fichas[i].NUMVEZ+','+
							data.fichas[i].PARTE+','+
							data.fichas[i].CODAQL+')">'+
							'<div class="itemBody codAuditoria">'+data.fichas[i].CODFIC+'</div>';
							if (data.fichas[i].TIPAUD='M') {
								htmlFichas+='<div class="itemBody">Final costura</div>';
							}else{
								htmlFichas+='<div class="itemBody">Otra auditoria</div>';
							}
						htmlFichas+=
							'<div class="itemBody">'+data.fichas[i].PARTE+'</div>'+
							'<div class="itemBody">'+data.fichas[i].NUMVEZ+'</div>'+
							'<div class="itemBody">'+data.fichas[i].CANPAR+'</div>'+
						'</div>';
					}
					$(".tblBody").append(htmlFichas);					
					document.getElementById("nameTaller").innerHTML=data.fichas[0].DESTLL;
					$(".bodyPrimary").css("display","none");
					$(".bodySecondary").css("display","block");
				}
				$(".panelCarga").fadeOut(300);
			}
		});
	}
}

function addWord(word,codtll){
	document.getElementById("idTallerName").value=word;
	codTaller=codtll;
	getFichas();
}

$(document).ready(function(){
	$(".inputCheckSpace").click(function(){
		var checkList =document.getElementsByClassName("iptCheckBox");
		for (var i = 0; i < checkList.length; i++) {
			if (checkList[i].id==this.dataset.target) {
				checkList[i].checked=true;
			}else{
				checkList[i].checked=false;
			}
		}
		if (this.dataset.target=="idCheckDiscrecional") {
			$(".iptForDiscrecional").css("display","block");
		}else{
			$(".iptForDiscrecional").css("display","none");			
		}
		$(".finalBtn").css("display","block");
	});
	$(".btnBackAction").click(function(){		
		$(".bodyPrimary").css("display","block");
		$(".bodySecondary").css("display","none");
		document.getElementById("muestraSelection").style.display="none";
		$("#fichaSelected").empty();
		var checkList =document.getElementsByClassName("iptCheckBox");
		for (var i = 0; i < checkList.length; i++) {
			checkList[i].checked=false;
		}
		$(".iptForDiscrecional").css("display","none");
		$(".finalBtn").css("display","none");
	});
	$("#idTallerName").keyup(function(){
		$(".listaTalleres").empty();
		var htmlTalleres="";
		var busqueda=document.getElementById("idTallerName").value;
		for (var i = 0; i < listaTalleres[0].length; i++) {
			if ((listaTalleres[0][i].DESTLL.toUpperCase()).indexOf(busqueda.toUpperCase())>=0) {				
				htmlTalleres+='<div class="taller" onclick="addWord(\''+listaTalleres[0][i].DESTLL+'\','+listaTalleres[0][i].CODTLL+')">'+listaTalleres[0][i].DESTLL+"</div>";
			}
		}
		$(".listaTalleres").append(htmlTalleres);
	});
});

/* AUDITORIA REGISTRADA */

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
		url:"config/getFicha.php",
		success:function(data){
			console.log(data);
			document.getElementById("idNombreTaller").innerHTML=data.ficha.DESTLL;
			if (data.ficha.canpre!=data.ficha.CANPAR) {
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
			codfic:CODFIC,
			numvez:NUMVEZ,
			parte:PARTE,
			codtad:CODTAD
		},
		url:"config/getAuditoriaDefectos.php",
		success:function(data){
			var htmlContent="";
			var suma=0;
			for (var i = 0; i < data.defectos.length; i++) {
				console.log(data.defectos[i]);
				htmlContent+=
				'<div class="tblLine">'+
					'<div class="itemBody" style="width: 40%;">'+data.defectos[i].DESDEF+'</div>'+
					'<div class="itemBody" style="width: 40%;">'+data.defectos[i].DESOPE+'</div>'+
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

function terminarAuditoriaRegistrada(){
	window.location.href="main.php";
}