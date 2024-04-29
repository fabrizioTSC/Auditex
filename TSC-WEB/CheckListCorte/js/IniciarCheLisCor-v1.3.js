$(document).ready(function(){
	/*$(".classIpt").keyup(function(){
		var ar=document.getElementsByClassName("tblLine");
		for (var i = 0; i < ar.length; i++) {
			if (ar[i].dataset.codfic.indexOf($(".classIpt").val())>=0) {
				ar[i].style.display="flex";
			}else{
				ar[i].style.display="none";
			}
		}
	});*/
	$("#idTaller").keyup(function(){
		codtllnue='';
		var html='';
		for (var i = 0; i < ar_talleres.length; i++) {
			if (ar_talleres[i].DESTLL.indexOf($("#idTaller").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="select_taller(\''+ar_talleres[i].CODTLL+'\',\''+ar_talleres[i].DESTLL+'\',\''+ar_talleres[i].CODTIPSER+'\')">'+
				ar_talleres[i].DESTLL+'</div>';				
			}
		}
		document.getElementById("tbl-taller").innerHTML=html;
	});
	$("#idCelula").keyup(function(){
		codcel=codcelant;
		var html='';
		for (var i = 0; i < ar_celula.length; i++) {
			if (ar_celula[i].DESTLL.indexOf($("#idCelula").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="select_celula(\''+ar_celula[i].CODTLL+'\',\''+ar_celula[i].DESTLL+'\')">'+
				ar_celula[i].DESTLL+'</div>';				
			}
		}
		document.getElementById("tbl-celula").innerHTML=html;
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
	/*
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
						'<div class="itemBody" style="width:12%;">'+listaFichas[i].CODFIC+'</div>'+
						'<div class="itemBody" style="width:16%;">'+validate_null(listaFichas[i].CODUSU)+'</div>'+
						'<div class="itemBody" style="width:10%;">'+listaFichas[i].CANPAR+'</div>'+
						'<div class="itemBody" style="width:12%;">'+validate_null(listaFichas[i].PARTIDA)+'</div>'+
						'<div class="itemBody" style="width:25%;">'+validate_null(listaFichas[i].CODTEL)+'</div>'+
						'<div class="itemBody" style="width:25%;">'+validate_null(listaFichas[i].COLOR)+'</div>'+
					'</div>';
				}
				$(".tblBody").append(htmlFichas);
			}
			$(".panelCarga").fadeOut(100);
			get_talleres();
			get_celulas();
		}
	});		*/
			get_talleres();
			get_celulas();
}

function search_ficha(){
	document.getElementById("result-partida").style.display="none";
	document.getElementById("fichaSelected").style.display="none";

	if ($("#codfic").val()=="") {
		alert("Escriba una ficha");
		return;
	}
	$(".panelCarga").fadeIn(300);

	

	$.ajax({
		type:"POST",
		data:{
			codfic:$("#codfic").val()
		},
		url:"config/getFichasCheLisCorXFic.php",
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
						'<div class="itemBody" style="width:12%;">'+listaFichas[i].CODFIC+'</div>'+
						'<div class="itemBody" style="width:16%;">'+validate_null(listaFichas[i].CODUSU)+'</div>'+
						'<div class="itemBody" style="width:10%;">'+listaFichas[i].CANPAR+'</div>'+
						'<div class="itemBody" style="width:12%;">'+validate_null(listaFichas[i].PARTIDA)+'</div>'+
						'<div class="itemBody" style="width:25%;">'+validate_null(listaFichas[i].CODTEL)+'</div>'+
						'<div class="itemBody" style="width:25%;">'+validate_null(listaFichas[i].COLOR)+'</div>'+
					'</div>';
				}
				$(".tblBody").append(htmlFichas);
				if (data.fichas.length==0) {
					$("#text-efect").css("display","none");
				}else{
					$("#text-efect").css("display","block");
				}
			}
			$(".panelCarga").fadeOut(100);
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
				html+='<div class="taller" onclick="select_taller(\''+ar_talleres[i].CODTLL+'\',\''+ar_talleres[i].DESTLL+'\',\''+ar_talleres[i].CODTIPSER+'\')">'+
				ar_talleres[i].DESTLL+'</div>';				
			}
			document.getElementById("tbl-taller").innerHTML=html;
		}
	});
}

var ar_celula=[];
function get_celulas(){
	$.ajax({
		type:"POST",
		url:"config/getCelulasCLC.php",
		success:function(data){
			console.log(data);
			ar_celula=data.celula;
			var html='';
			for (var i = 0; i < ar_celula.length; i++) {
				html+='<div class="taller" onclick="select_celula(\''+ar_celula[i].CODTLL+'\',\''+ar_celula[i].DESTLL+'\')">'+
				ar_celula[i].DESTLL+'</div>';				
			}
			document.getElementById("tbl-celula").innerHTML=html;
		}
	});	
}

var codtllnue='';
function select_taller(codtll,destll,codtipser){
	codtllnue=codtll;
	$("#idTaller").val(destll);
	if (codtipser=="1") {
		document.getElementById("result-celula").style.display="block";
	}else{
		document.getElementById("result-celula").style.display="none";
	}
	$("#idCelula").val("");
	$("#idCelula").keyup();
}
var codcelant;
var codcel;
function select_celula(codtll,destll){
	codcel=codtll;
	$("#idCelula").val(destll);	
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
	document.getElementById("result-celula").style.display="none";
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
				if (data.DESCEL=="") {
					$("#idDesCel").text("NINGUNA");	
					codcelant="0";
				}else{
					$("#idDesCel").text(data.DESCEL);
					codcel=data.CODCEL;
					document.getElementById("result-celula").style.display="block";
				}
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
				codenv:codenv_v,
				codcel:codcel
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