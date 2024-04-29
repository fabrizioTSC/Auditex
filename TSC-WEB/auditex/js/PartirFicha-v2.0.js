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
	$(".panelCarga").fadeOut(300);
	$(".btnBuscarSpace").click(function(){
		var codfic=document.getElementById("idCodFicha").value;
		$("#idContentForFicha").css("display","none");
		$("#idTblDefectos").empty();
		$(".msgForFichas").empty();
		$(".msgForFichas").css("display","none");
		$(".panelCarga").fadeIn(100);
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
				console.log(data);
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
								formatText(data.fichas[i].DESTLL)+'\',\''+
								data.fichas[i].CODTLL+'\','+
								data.fichas[i].CANPAR+','+
								data.fichas[i].CANTIDAD+')">'+
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
				getTalleres();
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
				'<div class="taller" onclick="select_taller(\''+ar_talleres[i].CODTLL+'\',\''+ar_talleres[i].DESTLL+'\')">'+
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
				'<div class="taller" onclick="select_taller(\''+ar_talleres[i].CODTLL+'\',\''+ar_talleres[i].DESTLL+'\')">'+
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
var fsfpcodaql=0;
var fsfpcodtad=0;
var fsfpnumvez=0;
var fsfpparte=0;
var fsfpcantidad=0;
var antcodtll='';

function fichaSelectedForPartir(codfic,aql,codaql,codtad,numvez,parte,destll,codtll,cantidadParte,cantPren){

	$(".panelCarga").fadeIn();

	$.ajax({
		type:"GET",
		data:{
			operacion: 'gettallafichas',
			ficha:codfic,
			opcion:2,
			parte:parte,
			vez:numvez
		},
		url:"/tsc/controllers/auditex-costura/auditoriafinal.controller.php",
		success:function(data){
			let tallas = JSON.parse(data);
			let tr = "";

			for(let item of tallas){

				let cantidadreal = item.CANTIDAD == null ? 0 : item.CANTIDAD;
				let cantidaddisponible = item.CANPRE - item.CANTCONSU;


				tr += `
					<tr>
						<td>${item.DESTAL}</td>
						<td>
							<input type='number' style='width:50%' data-idtalla='${item.CODTAL}'  data-max='${cantidaddisponible}'  max='${cantidaddisponible}' value='${cantidadreal}'  class='txtcant' />
						</td>
						<td>
							${cantidaddisponible}
						</td>
					</tr>
				`;
			}

			$("#tbodytallas").html(tr);

			$(".panelCarga").fadeOut();
			calcTot();	

			// console.log("TALLAS",tallas);
			
		}

	});
	
	
	$("#idTaller").val('');
	codtll_v='';
	antcodtll=codtll;
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

$("#tbodytallas").on('keyup','.txtcant',function(){
	calcTot();
});

function calcTot(){
	let cant = $(".txtcant");
	let tot = 0;
	for(let item of cant){
		tot += parseFloat( $(item).val() );
	}

	$("#idNewCantParte").val(tot);
}


function validacionTallas(){

	let cant = $(".txtcant");

	let totaltallas = 0;
	let totalparte 	= $("#idNewCantParte").val().trim() != "" ? parseFloat( $("#idNewCantParte").val().trim()) : 0;
	let error = false;


	for(let item of cant){

		let cant = $(item).val();
		let max = $(item).data("max");
		totaltallas += parseFloat(cant);

		if(cant > max){
			error = true;
		}

	}
	// console.log(totalparte,totaltallas);

	if(!error){
		if(totaltallas > totalparte){
			// alert("La cantidad no puede ser mayor a la cantidad parte");
			return {success:false,mensaje:"La cantidad no puede ser mayor a la cantidad parte"}
		}else{
			return {success:true,mensaje:"correcto"}
			// return true;
		}
	}else{
		// return false;
		return {success:false,mensaje:"La cantidad de una de las tallas es mayor a la cantidad máxima"}

	}

	



}


async function partirFicha(){


	// validacionTallas();

	var cantidadIngresada = $("#idNewCantParte").val().trim();

	if(cantidadIngresada != ""){



		if (cantidadIngresada > fsfpcantidad) {
			alert("La cantidad no debe exceder a la total de la ficha!");
		}else{
			
			let validacion  = validacionTallas();

			$(".panelCarga").fadeIn(300);

			if(validacion.success){

				let tallas = $(".txtcant");
				let idPartirconTalla = $("#idPartirconTalla").prop("checked");

				if(idPartirconTalla){

					// PARTIMOS TALLAS
					for(let item of tallas){

						let cant = $(item).val();
						let idtalla = $(item).data("idtalla");

						await saveTallas(fsfpcodfic,fsfpnumvez,fsfpparte,idtalla,cant);

					}

				}	
				

				// PARTIMOS GENERAL
				let partirgeneral = await parttifichanew();

				if (partirgeneral.state==true) {
					alert("Ficha partida!");
					$("#divPartir").css("display","none");
					$(".btnBuscarSpace").click();
					$("#idContentDescription").css("display","none");
				}else{
					alert("No se pudo partir la ficha!");
				}

				$(".panelCarga").fadeOut(300);

			}else{
				alert(validacion.mensaje);
				// alert("La cantidad no puede ser mayor a la cantidad parte");
			}
			

		}


	}else{
		alert("Ingrese cantidad");
	}

}

async function saveTallas(ficha,vez,parte,idtalla,cant){


	let response = await $.ajax({
		type:"POST",
		data:{				
			ficha,vez,parte,idtalla,cant,operacion:'settallafichas'
		},
		url:"/tsc/controllers/auditex-costura/auditoriafinal.controller.php",
	});

	return response;
}

async function parttifichanew(){

	let response = await $.ajax({
		type:"POST",
		data:{				
			codfic:fsfpcodfic,
			codaql:fsfpcodaql,
			codtad:fsfpcodtad,
			numvez:fsfpnumvez,
			parte:fsfpparte,
			nuecan:$("#idNewCantParte").val(),
			codtll:antcodtll,
			nuecodtll:codtll_v
		},
		url:"config/PartirFicha.php",

		// success:function(data){
		// 	//console.log(data);
		// 	if (data.state==true) {
		// 		alert("Ficha partida!");
		// 		$("#divPartir").css("display","none");
		// 		$(".btnBuscarSpace").click();
		// 		$("#idContentDescription").css("display","none");
		// 	}else{
		// 		alert("No se pudo partir la ficha!");
		// 	}
		// 	$(".panelCarga").fadeOut(300);
		// }
	});

	return response;

}