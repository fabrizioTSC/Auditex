function formatText(string){
	while(string.indexOf('"')>0){
		string=string.replace('"','');
	}
	while(string.indexOf('\'')>0){
		string=string.replace('\'','');
	}
	return string;
}

$(document).ready(function(){
	$("#idNewCantParte").keydown(function(e){
		if (e.keyCode==109||e.keyCode==189||e.keyCode==107||e.keyCode==187) {
			e.preventDefault();
		}
	});
	$("#idCodFicha").keyup(function(e){
		if (e.keyCode==13) {
			$(".btnBuscarSpace").click();
		}
	});
	$(".panelCarga").fadeOut(100);
	getTalleres();
	$(".btnBuscarSpace").click(function(){
		var codfic=document.getElementById("idCodFicha").value;
		$("#idContentForFicha").css("display","none");
		$("#idContentDescription").css("display","none");
		$("#idTblDefectos").empty();
		$(".msgForFichas").empty();
		$(".msgForFichas").css("display","none");
		$(".panelCarga").fadeIn(100);
		$("#idTaller").val("");
		$("#idTaller").keyup();
		$.ajax({
			type:"POST",
			url:"config/getFicAsiTal.php",
			data:{
				codfic:codfic
			},
			success:function(data){
				$(".tblBody").empty();
				$("#idContentTblFichas").css("display","none");
				console.log(data);
				if (data.state==true) {
					var html="";
					for (var i = 0; i < data.fichas.length; i++) {
						html+=
							'<div class="tblLine" onclick="fichaSelectedForAsignar('+data.fichas[i].CODFIC+',\''+
								data.fichas[i].PARTE+'\',\''+
								data.fichas[i].CODTLL+'\',\''+
								data.fichas[i].DESTLL+'\','+
								data.fichas[i].CANPAR+','+
								data.fichas[i].CANTOT+')">'+
								'<div class="itemBody">'+data.fichas[i].CODFIC+'</div>'+
								'<div class="itemBody">'+data.fichas[i].PARTE+'</div>'+
								'<div class="itemBody">'+data.fichas[i].DESTLL+'</div>'+
								'<div class="itemBody">'+data.fichas[i].CANPAR+'</div>'+
								'<div class="itemBody">'+data.fichas[i].CANTOT+'</div>'+
							'</div>';
					}
					$(".tblBody").append(html);			
					$("#idContentTblFichas").css("display","block");
				}
				if(data.fichas.length==0){
					$(".msgForFichas").append("No se encontro la ficha!");
					$(".msgForFichas").css("display","block");
				}
				$(".panelCarga").fadeOut(100);
			}
		});
	});
	$("#idTaller").keyup(function(){
		codtll_v='';
		$("#tabla-talleres").empty();
		let html='';
		for (var i = 0; i < ar_talleres.length; i++) {
			if ((ar_talleres[i].DESTLL+ar_talleres[i].DESCOM).toUpperCase().indexOf($("#idTaller").val().toUpperCase())>=0) {
				html+=
				'<div class="taller" onclick="select_taller(\''+ar_talleres[i].CODTLL+'\',\''+formatText(ar_talleres[i].DESTLL)+'\')">'+
					ar_talleres[i].DESTLL+
				'</div>';
			}
		}
		$("#tabla-talleres").append(html);
	});
});

var ar_talleres=[];
function getTalleres(){
	$.ajax({
		type:"POST",
		url:"config/getTalleres.php",
		data:{
		},
		success:function(data){
			ar_talleres=data.talleres;
			$("#tabla-talleres").empty();
			let html='';
			for (var i = 0; i < ar_talleres.length; i++) {
				html+=
				'<div class="taller" onclick="select_taller(\''+ar_talleres[i].CODTLL+'\',\''+formatText(ar_talleres[i].DESTLL)+'\')">'+
					ar_talleres[i].DESTLL+
				'</div>';
			}
			$("#tabla-talleres").append(html);
		}
	});
}

var codtll_v='';
function select_taller(codtll,destll){
	codtll_v=codtll;
	$("#idTaller").val(destll);
}

var fsfpcodfic=0;
var fsfpparte=0;
var fsfpparte=0;
var antcodtll='';
function fichaSelectedForAsignar(codfic,parte,codtll,destll,canpar,cantot){
	$("#idTaller").val('');
	codtll_v='';
	antcodtll=codtll;
	$("#idContentDescription").css("display","block");
	document.getElementById("idNombreTaller").innerHTML=destll;
	document.getElementById("idCodFichaText").innerHTML=codfic;
	document.getElementById("idParteText").innerHTML=parte;
	document.getElementById("idCantPrendas").innerHTML=canpar+" de "+cantot;
	fsfpcodfic=codfic;
	fsfpparte=parte;
}

function reasignar_taller(){
	var cantidadIngresada=$("#idNewCantParte").val();
	if (codtll_v=='') {
		alert("Debe seleccionar un taller nuevo");
	}else{
		$(".panelCarga").fadeIn(100);
		$.ajax({
			type:"POST",
			data:{				
				codfic:fsfpcodfic,
				codtad:10,
				parte:fsfpparte,
				codtll:antcodtll,
				nuecodtll:codtll_v
			},
			url:"config/updateTallerFicha.php",
			success:function(data){
				console.log(data);
				if (data.state==true) {
					alert("Ficha actualizada!");
					$(".panelCarga").fadeOut(100);
					$(".btnBuscarSpace").click();
					$("#idContentDescription").css("display","none");
				}else{
					alert("No se pudo actualizar la ficha!");
					$(".panelCarga").fadeOut(100);
				}
			}
		});
	}
}