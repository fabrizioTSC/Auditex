function redirect(path){
	window.location.href=path;
}

function formatText(string){
	while(string.indexOf('"')>0){
		string=string.replace('"','');
	}
	while(string.indexOf('\'')>0){
		string=string.replace('\'','');
	}
	return string;
}

/**********************/
/* Variables Globales */
var codficFinal="";
var codTaller="";
/**********************/
var listaTalleres=[];
var codUsuario=0;
var usuario=0;
function getTalleres(codusu,user){
	codUsuario=codusu;
	usuario=user;
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
				htmlTalleres+='<div class="taller" onclick="addWord(\''+formatText(data.talleres[i].DESTLL)+'\',\''+data.talleres[i].CODTLL+'\')">'+data.talleres[i].DESTLL+'</div>';
			}
			listaTalleres.push(data.talleres);
			$(".listaTalleres").append(htmlTalleres);
			$(".panelCarga").fadeOut(300);
		}
	});
}

var fichaCodTad=0;
var fichaNumVez=0;
var fichaParte=0;
var fichaCodAql=0;
var fichatipoauditoria = "";
function fichaSelection(codfic,aql,codtad,numvez,parte,codaql,tipoauditoria){


	console.log("RAAAAA");

	fichaCodTad=codtad;
	fichaNumVez=numvez;
	fichaParte=parte;
	fichaCodAql=codaql;
	fichatipoauditoria = tipoauditoria;

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
var listaFichas=[];
function getFichas(){
	listaFichas=[];
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
				//console.log(data);
				if (data.state==false) {
					alert(data.description);
				}else{
					listaFichas=data.fichas;
					$(".tblBody").empty();
					var htmlFichas="";
					for (var i = 0; i < listaFichas.length; i++) {

						console.log("TIPAUD",listaFichas[i].TIPAUD);

						htmlFichas += `

							<div class="tblLine"
								onclick="fichaSelection(${listaFichas[i].CODFIC},'${listaFichas[i].AQL}',${listaFichas[i].CODTAD},${listaFichas[i].NUMVEZ},
								${listaFichas[i].PARTE},${listaFichas[i].CODAQL},'${listaFichas[i].TIPAUD}')"
							>
							<div class="itemBody codAuditoria"> ${listaFichas[i].CODFIC} </div>

						`;


						// htmlFichas+=
						// '<div class="tblLine" onclick="fichaSelection('+listaFichas[i].CODFIC+',\''+
						// 	listaFichas[i].AQL+'\','+
						// 	listaFichas[i].CODTAD+','+
						// 	listaFichas[i].NUMVEZ+','+
						// 	listaFichas[i].PARTE+','+
						// 	listaFichas[i].CODAQL+','+
						// 	+listaFichas[i].TIPAUD+')">'+
						// 	'<div class="itemBody codAuditoria">'+listaFichas[i].CODFIC+'</div>';

							if (listaFichas[i].TIPAUD == 'M') {
								htmlFichas+='<div class="itemBody">Final costura</div>';
							}else if (listaFichas[i].TIPAUD == 'E') {
								htmlFichas+='<div class="itemBody">Auditoria Especial</div>';
							}
							else{
								htmlFichas+='<div class="itemBody">Otra auditoria</div>';
							}

						htmlFichas+=
							'<div class="itemBody">'+listaFichas[i].PARTE+'</div>'+
							'<div class="itemBody">'+listaFichas[i].NUMVEZ+'</div>'+
							'<div class="itemBody">'+listaFichas[i].CANPAR+'</div>'+
						'</div>';
					}
					$(".tblBody").append(htmlFichas);				
					$(".bodyPrimary").css("display","none");
					$(".bodySecondary").css("display","block");
				}
				$(".panelCarga").fadeOut(300);
			}
		});
	}
}

function addWord(word,codtll){
	//console.log(codtll);
	document.getElementById("idTallerName").value=word;
	codTaller=codtll;	
	$("#nameTaller").text(word);
	getFichas();
}

$(document).ready(function(){
	$("#idNumberPrendas").keydown(function(e){
		if (e.keyCode==109||e.keyCode==189||e.keyCode==107||e.keyCode==187) {
			e.preventDefault();
		}
	});
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
			////console.log(listaTalleres[0][i].DESTLL.toUpperCase());
			if ((listaTalleres[0][i].DESTLL.toUpperCase()).indexOf(busqueda.toUpperCase())>=0) {				
				htmlTalleres+='<div class="taller" onclick="addWord(\''+formatText(listaTalleres[0][i].DESTLL)+'\',\''+listaTalleres[0][i].CODTLL+'\')">'+listaTalleres[0][i].DESTLL+"</div>";
			}
		}
		$(".listaTalleres").append(htmlTalleres);
	});
});

/* AUDITORIA REGISTRADA */

function cargarAuditoriaRegistrada(codfic,tipoAud,cantidadDeMuestra,numvez,parte,codtad,codaql,fichatipoauditoria){

	document.getElementById("idCodFicha").innerHTML=codfic;
	document.getElementById("idNumPrendasAuditar").innerHTML="("+cantidadDeMuestra+" prendas)";
	$.ajax({
		type:"POST",
		data:{
			codfic:codfic,
			numvez:numvez,
			parte:parte,
			codtad:codtad,
			codaql:codaql,
			fichatipoauditoria
		},
		url:"config/getFicha.php",
		success:function(data){
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
			getAuditoriaDefectos(codfic,numvez,parte,codtad,fichatipoauditoria);
		}
	});
}

function getAuditoriaDefectos(codfic,numvez,parte,codtad,fichatipoauditoria){
	$.ajax({
		type:"POST",
		data:{
			codfic:codfic,
			numvez:numvez,
			parte:parte,
			codtad:codtad,
			fichatipoauditoria
		},
		url:"config/getAuditoriaDefectos.php",
		success:function(data){
			var htmlContent="";
			var suma=0;
			for (var i = 0; i < data.defectos.length; i++) {
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

function registrarClasiFicha(){	
	window.location.href="ConsultarEditarAuditoria.php?codfic="+$("#idCodFicha").text();	
}