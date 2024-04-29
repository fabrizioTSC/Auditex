var listaTalleres=[];
$(document).ready(function(){
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
	$.ajax({
		type:"POST",
		url:"config/getTalleres.php",
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
	$("#idcodficSearch").keyup(function(){
		$(".tblBody").empty();
		var htmlFichas="";
		for (var i = 0; i < fichas.length; i++) {
			if ((fichas[i].CODFIC).indexOf($("#idcodficSearch").val())>=0) {
				htmlFichas+=
				'<div class="tblLine" onclick="fichaSelection('+fichas[i].CODFIC+',\''+fichas[i].ESTTSC+'\')">'+
					'<div class="itemBody" style="width: calc(50% - 10px);">'+fichas[i].CODFIC+'</div>'+
					'<div class="itemBody" style="width: calc(50% - 10px);">'+fichas[i].CANPAR+'</div>'+
				'</div>';
			}
		}
		$(".tblBody").append(htmlFichas);	
	});
});

function formatText(string){
	while(string.indexOf('"')>0){
		string=string.replace('"','');
	}
	while(string.indexOf('\'')>0){
		string=string.replace('\'','');
	}
	return string;
}

var codtll_var;
function addWord(word,codtll){
	$("#idDesTll").text(word);
	codtll_var=codtll;
	getFichas(codtll_var);
}

var fichas=[];
function getFichas(codtll){
	$(".panelCarga").fadeIn(200);
	$.ajax({
		type:"POST",
		url:"config/getFichas.php",
		data:{
			codtll:codtll
		},
		success:function(data){
			console.log(data);
			if (data.state==false) {
				alert(data.description);
			}else{
				fichas=data.fichas;
				$(".tblBody").empty();
				var htmlFichas="";
				for (var i = 0; i < data.fichas.length; i++) {
					htmlFichas+=
					'<div class="tblLine" onclick="fichaSelection('+data.fichas[i].CODFIC+',\''+data.fichas[i].ESTTSC+'\')">'+
						'<div class="itemBody" style="width: calc(50% - 10px);">'+data.fichas[i].CODFIC+'</div>'+
						'<div class="itemBody" style="width: calc(50% - 10px);">'+data.fichas[i].CANPAR+'</div>'+
					'</div>';
				}
				$(".tblBody").append(htmlFichas);			
				$("#space2").css("display","block");
				$("#space1").css("display","none");			
			}

			$(".panelCarga").fadeOut(300);
		}
	});
}

function backLineas(){
	$("#space1").css("display","block");
	$("#space2").css("display","none");
}

var esttsc_var;
function fichaSelection(codfic,esttsc){
	esttsc_var=esttsc;
	$(".panelCarga").fadeIn(200);
	$.ajax({
		type:"POST",
		url:"config/getValidateFicha.php",
		data:{
			codfic:codfic,
			codusu:codusu,
			codtll:codtll_var
		},
		success:function(data){
			//console.log(data);
			if (data.state==false) {
				$("#idCodFic").text(codfic);
				$("#space3").css("display","block");
				$("#space2").css("display","none");

				$(".panelCarga").fadeOut(300);
			}else{
				var conf=confirm("Ya existe la inspección de la ficha para hoy y en el turno seleccionado. ¿Desea ir a la inspección para continuarla?");
				if (conf) {
					window.location.href="EditarInspeccionFicha.php?codinscos="+data.codinscos;
				}else{
					$(".panelCarga").fadeOut(300);					
				}
			}
		}		
	});
}

function backFichas(){
	$("#space2").css("display","block");
	$("#space3").css("display","none");
}

function irInspeccion(){
	$(".panelCarga").fadeIn(300);
	$.ajax({
		type:"POST",
		url:"config/startEstiloOperacion.php",
		data:{
			esttsc:esttsc_var
		},
		success:function(data){
			//console.log(data);
			if (data.state==true) {
				location.href="InspeccionFicha.php?codfic="+$("#idCodFic").text()+"&codtll="+codtll_var+"&esttsc="+esttsc_var;
			}else{
				alert(data.detail);
				$(".panelCarga").fadeOut(300);
			}
		}
	});
}