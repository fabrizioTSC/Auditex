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
	$(".panelCarga").fadeOut(300);
	$(".btnBuscarSpace").click(function(){
		var codfic=document.getElementById("idCodFicha").value;
		$("#idContentForFicha").css("display","none");
		$("#idTblDefectos").empty();
		$(".msgForFichas").empty();
		$(".msgForFichas").css("display","none");
		$.ajax({
			type:"POST",
			url:"config/getFicha.php",
			data:{
				codfic:codfic,
				typeRequest:1
			},
			success:function(data){
				$(".tblBody").empty();
				$("#idContentTblFichas").css("display","none");
				//console.log(data);
				if (data.state==true) {
					var htmlFichas="";
					for (var i = 0; i < data.fichas.length; i++) {
							htmlFichas+=
							'<div class="tblLine" onclick="fichaSelectedForPartir('+data.fichas[i].CODFIC+',\''+
								data.fichas[i].AQL+'\','+
								data.fichas[i].CODAQL+','+
								data.fichas[i].CODTAD+','+
								data.fichas[i].NUMVEZ+','+
								data.fichas[i].PARTE+',\''+
								formatText(data.fichas[i].DESTLL)+'\','+
								data.fichas[i].CANPAR+','+
								data.fichas[i].CANPRE+')">'+
								'<div class="itemBody">'+data.fichas[i].CODFIC+'</div>';
							if (data.fichas[i].TIPAUD=='M') {
								htmlFichas+='<div class="itemBody">Final de costura</div>';
							}else{
								htmlFichas+='<div class="itemBody">Otro</div>';
							}
							htmlFichas+=
								'<div class="itemBody">'+data.fichas[i].PARTE+'</div>'+
								'<div class="itemBody">'+data.fichas[i].NUMVEZ+'</div>'+
								'<div class="itemBody">'+data.fichas[i].CANPAR+'</div>'+
							'</div>';
					}
					$(".tblBody").append(htmlFichas);			
					$("#idContentTblFichas").css("display","block");

				}else{
					$(".msgForFichas").append("No se encontro la ficha!");
					$(".msgForFichas").css("display","block");
				}
			}
		})
	});
});

var fsfpcodfic=0;
var fsfpcodaql=0;
var fsfpcodtad=0;
var fsfpnumvez=0;
var fsfpparte=0;
var fsfpcantidad=0;
function fichaSelectedForPartir(codfic,aql,codaql,codtad,numvez,parte,destll,cantidadParte,cantPren){
	$("#idContentDescription").css("display","block");
	document.getElementById("idNombreTaller").innerHTML=destll;
	document.getElementById("idCodFichaText").innerHTML=codfic;
	if (cantidadParte!=cantPren) {
		document.getElementById("idCantPrendas").innerHTML=cantidadParte+ " de "+cantPren;	
	}else{
		document.getElementById("idCantPrendas").innerHTML=cantidadParte;	
	}	
	fsfpcodfic=codfic;
	fsfpcodaql=codaql;
	fsfpcodtad=codtad;
	fsfpnumvez=numvez;
	fsfpparte=parte;
	fsfpcantidad=cantidadParte;
	$("#idNewCantParte").val("");
	$("#divPartir").css("display","block");
}

function partirFicha(){
	var cantidadIngresada=$("#idNewCantParte").val();
	if (cantidadIngresada>=fsfpcantidad) {
		alert("La cantidad no debe exceder a la total de la ficha!");
	}else{
		$(".panelCarga").fadeIn(300);
		$.ajax({
			type:"POST",
			data:{				
				codfic:fsfpcodfic,
				codaql:fsfpcodaql,
				codtad:fsfpcodtad,
				numvez:fsfpnumvez,
				parte:fsfpparte,
				nuecan:$("#idNewCantParte").val()
			},
			url:"config/PartirFicha.php",
			success:function(data){
				//console.log(data);
				if (data.state==true) {
					alert("Ficha partida!");
					$("#divPartir").css("display","none");
					$(".btnBuscarSpace").click();
					$("#idContentDescription").css("display","none");
				}else{
					alert("No se pudo partir la ficha!");
				}
				$(".panelCarga").fadeOut(300);
			}
		});
	}
}