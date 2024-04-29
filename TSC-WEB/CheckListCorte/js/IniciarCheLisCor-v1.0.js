$(document).ready(function(){
	$(".classIpt").keyup(function(){
		var ar=document.getElementsByClassName("tblLine");
		for (var i = 0; i < ar.length; i++) {
			if (ar[i].dataset.codfic.indexOf($(".classIpt").val())>=0) {
				ar[i].style.display="flex";
			}else{
				ar[i].style.display="none";
			}
		}
	});
});

function validate_null(text){
	if (text==null) {
		return '';
	}else{
		return text;
	}
}

var listaFichas=[];
function getFichas(){
	$(".panelCarga").fadeIn(300);
	$.ajax({
		type:"POST",
		url:"config/getFichasCheLisCor.php",
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
					'<div class="tblLine" data-codfic="'+listaFichas[i].CODFIC+'" onclick="fichaSelection('+listaFichas[i].CODFIC+','+
						listaFichas[i].CODTAD+','+
						listaFichas[i].NUMVEZ+','+
						listaFichas[i].PARTE+',\''+
						validate_null(listaFichas[i].PARTIDA)+'\')">'+
						'<div class="itemBody" style="width:15%;">'+listaFichas[i].CODFIC+'</div>'+
						'<div class="itemBody" style="width:15%;">'+listaFichas[i].CANPAR+'</div>'+
						'<div class="itemBody" style="width:15%;">'+validate_null(listaFichas[i].PARTIDA)+'</div>'+
						'<div class="itemBody" style="width:30%;">'+validate_null(listaFichas[i].CODTEL)+'</div>'+
						'<div class="itemBody" style="width:25%;">'+validate_null(listaFichas[i].COLOR)+'</div>'+
					'</div>';
				}
				$(".tblBody").append(htmlFichas);
			}
			$(".panelCarga").fadeOut(100);
		}
	});		
}

var fichaCodFic=0;
var fichaCodTad=0;
var fichaNumVez=0;
var fichaParte=0;
var partida_var=0;
/*
function fichaSelection(codfic,codtad,numvez,parte){
	fichaCodTad=codtad;
	fichaNumVez=numvez;
	fichaParte=parte;
	fichaCodFic=codfic;
	document.getElementById("fichaSelected").style.display="block";
	$("#fichaSelected").empty();
	$("#fichaSelected").append("Ficha seleccionada: "+codfic);
	$("#muestraSelection").css("display","block");
}

function searchPartida(){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		url:"config/searchPartidaCheLisCor.php",
		data:{			
			partida:$("#idpartida").val()
		},
		success:function(data){
			console.log(data);
			if(data.state){
				document.getElementById("idcodtel").innerHTML=data.partidas[0].CODTEL;
				document.getElementById("idcolor").innerHTML=data.partidas[0].DSCCOL;
				document.getElementById("idarticulo").innerHTML=data.partidas[0].DESTEL;
				$("#no-result-partida").css("display","none");
				$("#result-partida").css("display","block");
			}else{
				$("#no-result-partida").css("display","block");
				$("#result-partida").css("display","none");
			}
			$(".panelCarga").fadeOut(100);
		}
	});
}*/
function fichaSelection(codfic,codtad,numvez,parte,partida){
	fichaCodTad=codtad;
	fichaNumVez=numvez;
	fichaParte=parte;
	fichaCodFic=codfic;
	document.getElementById("fichaSelected").style.display="block";
	$("#fichaSelected").empty();
	$("#fichaSelected").append("Ficha seleccionada: "+codfic);
	partida_var=partida;
	if (partida=="") {
		document.getElementById("result-partida").style.display="none";
		document.getElementById("no-result-partida").style.display="block";
	}else{
		document.getElementById("result-partida").style.display="block";
		document.getElementById("no-result-partida").style.display="none";		
	}
}

function comenzarAuditoria(){
	window.location.href="CheckListCorte.php?codfic="+fichaCodFic+
	"&numvez="+fichaNumVez+"&parte="+fichaParte+"&codtad="+fichaCodTad+"&partida="+partida_var;
}