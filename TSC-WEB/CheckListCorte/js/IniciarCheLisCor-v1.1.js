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
	$("#idTaller").keyup(function(){
		codtllnue='';
		var html='';
		for (var i = 0; i < ar_talleres.length; i++) {
			if (ar_talleres[i].DESTLL.indexOf($("#idTaller").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="select_taller(\''+ar_talleres[i].CODTLL+'\',\''+ar_talleres[i].DESTLL+'\')">'+
				ar_talleres[i].DESTLL+'</div>';				
			}
		}
		document.getElementById("tbl-taller").innerHTML=html;
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
			console.log(data);
			if (data.state==false) {
				alert(data.description);
			}else{
				listaFichas= data.fichas;
				$(".tblBody").empty();
				var htmlFichas="";
				for (var i = 0; i < listaFichas.length; i++) {
					htmlFichas+=
					'<div class="tblLine" data-codfic="'+listaFichas[i].CODFIC+'" onclick="fichaSelection('+listaFichas[i].CODFIC+','+
						listaFichas[i].CODTAD+',\''+
						listaFichas[i].CODENV+'\','+
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
			get_talleres();
		}
	});		
}

var ar_talleres=[];
function get_talleres(){
	$.ajax({
		type:"POST",
		url:"config/getTalleres.php",
		success:function(data){
			console.log(data);
			ar_talleres=data.talleres;
			var html='';
			for (var i = 0; i < ar_talleres.length; i++) {
				html+='<div class="taller" onclick="select_taller(\''+ar_talleres[i].CODTLL+'\',\''+ar_talleres[i].DESTLL+'\')">'+
				ar_talleres[i].DESTLL+'</div>';				
			}
			document.getElementById("tbl-taller").innerHTML=html;
		}
	});	
}

var codtllnue='';
function select_taller(codtll,destll){
	codtllnue=codtll;
	$("#idTaller").val(destll);
}

var fichaCodFic=0;
var fichaCodTad=0;
var fichaNumVez=0;
var fichaParte=0;
var partida_var=0;
var codtll='';
var codenv_v='';
function fichaSelection(codfic,codtad,codenv,numvez,parte,partida){
	$("#idTaller").val("");
	$("#idTaller").keyup();
	console.log(codenv);
	fichaCodTad=codtad;
	fichaNumVez=numvez;
	codenv_v=codenv;
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
		$(".panelCarga").fadeIn(100);
		$.ajax({
			type:"POST",
			url:"config/getTallerFicha.php",
			data:{
				codfic:codfic
			},
			success:function(data){
				console.log(data);
				codtll=data.CODTLL;
				$("#idDesTll").text(data.DESTLL);
				$(".panelCarga").fadeOut(100);
			}
		});	
		document.getElementById("result-partida").style.display="block";
		document.getElementById("no-result-partida").style.display="none";	
	}
}

function comenzarAuditoria(){
	if (codtllnue!='' && codtllnue!=codtll) {
		$.ajax({
			type:"POST",
			url:"config/updateTallerFicha.php",
			data:{
				codfic:fichaCodFic,
				codtll:codtllnue,
				codenv:codenv_v
			},
			success:function(data){
				console.log(data);
				if (data.state) {
					window.location.href="CheckListCorte.php?codfic="+fichaCodFic+
					"&numvez="+fichaNumVez+"&parte="+fichaParte+"&codtad="+fichaCodTad+"&partida="+partida_var;
				}else{
					alert("No se pudo cambiar el taller");
					$(".panelCarga").fadeOut(100);	
				}
			}
		});	
	}else{
		window.location.href="CheckListCorte.php?codfic="+fichaCodFic+
		"&numvez="+fichaNumVez+"&parte="+fichaParte+"&codtad="+fichaCodTad+"&partida="+partida_var;
	}
}