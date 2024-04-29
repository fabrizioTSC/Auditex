$(document).ready(function(){
	$.ajax({
		type:"POST",
		url:"config/getInfoRepLineas.php",
		data:{
			lineas:l,
			fecha:fecha,
			fechafin:fechafin
		},
		success:function(data){
			console.log(data);
			var html='';
			for (var i = 0; i < data.lineas.length; i++) {
				if (data.lineas[i].turno!=0) {
					var pren_defe=0;
					if (data.lineas[i].prendas_inspecionadas!=0) {
						pren_defe=Math.round(data.lineas[i].prendas_defectuosas*100/data.lineas[i].prendas_inspecionadas);
					}
					var pren_repr=0;
					if (data.lineas[i].prendas_inspecionadas!=0) {
						pren_repr=Math.round(data.lineas[i].prendas_reproceso*100/data.lineas[i].prendas_inspecionadas);
					}
					var style_size="";
					if(data.lineas[i].cliente.length>20){
						style_size=" font-size:12px;";
					}
					html+=
						'<div class="tblLine" style="width: 2810px;">'+
							'<div class="itemBody" style="width: 90px;text-align: center;">'+data.lineas[i].linea+'</div>'+
							'<div class="itemBody" style="width: 50px;text-align: center;">'+data.lineas[i].turno+'</div>'+
							'<div class="itemBody" style="width: 90px;text-align: center;">'+data.lineas[i].fecha+'</div>'+
							'<div class="itemBody" style="width: 120px;text-align: center;">'+data.lineas[i].numope+'</div>'+
							'<div class="itemBody" style="width: 90px;text-align: center;">'+format_for_hora(data.lineas[i].hora)+'</div>'+
							'<div class="itemBody" style="width: 150px;text-align: center;'+style_size+'">'+data.lineas[i].cliente+'</div>'+
							'<div class="itemBody" style="width: 70px;text-align: center;">'+data.lineas[i].eficienciacom+'%</div>'+
							'<div class="itemBody" style="width: 70px;text-align: center;">'+data.lineas[i].eficaciacom+'%</div>'+
							'<div class="itemBody" style="width: 90px;text-align: center;">'+formatMiles(data.lineas[i].mineficienciacom)+'</div>'+
							'<div class="itemBody" style="width: 90px;text-align: center;">'+formatMiles(data.lineas[i].mineficaciacom)+'</div>'+
							'<div class="itemBody" style="width: 90px;text-align: center;">'+formatMiles(data.lineas[i].minasi)+'</div>'+
							'<div class="itemBody" style="width: 90px;text-align: center;">'+data.lineas[i].preing+'</div>'+
							'<div class="itemBody" style="width: 80px;text-align: center;">'+formatMiles(data.lineas[i].prendas_producidas)+'</div>'+
							'<div class="itemBody" style="width: 80px;text-align: center;">'+format_proyeccion(data.lineas[i].prendas_producidas*data.lineas[i].factor)+'</div>'+
							'<div class="itemBody" style="width: 60px;text-align: center;">'+formatMiles(data.lineas[i].cuota)+'</div>'+
							'<div class="itemBody" style="width: 90px;text-align: center;">'+formatMiles(data.lineas[i].preaudapr)+'</div>'+
							'<div class="itemBody" style="width: 100px;text-align: center;">'+formatMiles(data.lineas[i].prendas_inspecionadas)+'</div>'+
							'<div class="itemBody" style="width: 90px;text-align: center;">'+formatMiles(data.lineas[i].prendas_defectuosas)+'</div>'+
							'<div class="itemBody" style="width: 100px;text-align: center;">'+pren_defe+'%</div>'+
							'<div class="itemBody" style="width: 90px;text-align: center;">'+formatMiles(data.lineas[i].prendas_reproceso)+'</div>'+
							'<div class="itemBody" style="width: 100px;text-align: center;">'+pren_repr+'%</div>'+//
							'<div class="itemBody" style="width: 70px;text-align: center;">'+data.lineas[i].eficienciacomest+'%</div>'+
							'<div class="itemBody" style="width: 70px;text-align: center;">'+data.lineas[i].eficaciacomest+'%</div>'+
							'<div class="itemBody" style="width: 90px;text-align: center;">'+formatMiles(data.lineas[i].mineficienciacomest)+'</div>'+
							'<div class="itemBody" style="width: 90px;text-align: center;">'+formatMiles(data.lineas[i].mineficaciacomest)+'</div>'+
							'<div class="itemBody" style="width: 70px;text-align: center;">'+data.lineas[i].eficiencia+'%</div>'+
							'<div class="itemBody" style="width: 70px;text-align: center;">'+data.lineas[i].eficacia+'%</div>'+
							'<div class="itemBody" style="width: 90px;text-align: center;">'+formatMiles(data.lineas[i].mineficiencia)+'</div>'+
							'<div class="itemBody" style="width: 90px;text-align: center;">'+formatMiles(data.lineas[i].mineficacia)+'</div>'+
						'</div>';
				}else{					
					html+=
						'<div class="tblLine" style="width: 2810px;">'+
							'<div class="itemBody" style="width: 90px;text-align: center;">'+data.lineas[i].linea+'</div>'+
							'<div class="itemBody" style="width: 50px;text-align: center;"></div>'+
							'<div class="itemBody" style="width: 90px;text-align: center;">'+data.lineas[i].fecha+'</div>'+
							'<div class="itemBody" style="width: 50px;">DESACTIVADO</div>'+
						'</div>';
				}
			}
			$("#data-lineas").empty();
			$("#data-lineas").append(html);			
			$(".panelCarga").fadeOut(200);
		},
		error:function(XMLHttpRequest, textStatus, errorThrown) { 
			alert("Ocurrió un error de carga de datos. Consulte al equipo de desarrollo!");
		}
	});
});

function format_for_hora(text){
	return text.substr(0,2)+":"+text.substr(2,2);
}

function formatMiles(value){
	var value=value+"";
	if (value.indexOf(",")>=0) {
		value=value.replace(",",".");
	}
	let ar=value.split(".");
	let entero=ar[0];
	var i=entero.length-1;
	var a=0;
	var aux="";
	while(i>=0){
		if (a%3==0 && a!=0) {
			aux=entero[i]+","+aux;
		}else{
			aux=entero[i]+aux;
		}
		a++;
		i--;
	}
	return aux;
}

function format_proyeccion(value){
	return Math.round(value);
}

function exportar_excel(){
	var a=document.createElement("a");
	a.target="_blank";
	a.href="config/export-ins/exportRepEfiLin.php?lineas="+l+"&fecha="+fecha+"&fechafin="+fechafin;
	a.click();
}