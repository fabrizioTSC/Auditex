$(document).ready(function(){
	$.ajax({
		type:"POST",
		url:"config/getInfoRepDefectos.php",
		data:{
			lineas:l,
			fecha:fecha,
			fechafin:fechafin
		},
		success:function(data){
			console.log(data);
			var html='';
			for (var i = 0; i < data.lineas.length; i++) {
				html+=
					'<div class="tblLine" style="width: 1560px;">'+
						'<div class="itemBody" style="width: 90px;text-align: center;">'+data.lineas[i].CODINSCOS+'</div>'+
						'<div class="itemBody" style="width: 50px;text-align: center;">'+data.lineas[i].CODFIC+'</div>'+
						'<div class="itemBody" style="width: 90px;text-align: center;">'+data.lineas[i].CANFIC+'</div>'+
						'<div class="itemBody" style="width: 120px;text-align: center;">'+data.lineas[i].FECINS+'</div>'+
						'<div class="itemBody" style="width: 90px;text-align: center;">'+data.lineas[i].CODUSU+'</div>'+
						'<div class="itemBody" style="width: 250px;text-align: center;">'+data.lineas[i].DESTLL+'</div>'+
						'<div class="itemBody" style="width: 150px;text-align: center;">'+data.lineas[i].DEFECTO+'</div>'+
						'<div class="itemBody" style="width: 150px;text-align: center;">'+data.lineas[i].FAMILIA+'</div>'+
						'<div class="itemBody" style="width: 150px;text-align: center;">'+data.lineas[i].OPERACION+'</div>'+
						'<div class="itemBody" style="width: 90px;text-align: center;">'+data.lineas[i].CANDEF+'</div>'+
						'<div class="itemBody" style="width: 90px;text-align: center;">'+data.lineas[i].CANINS+'</div>'+
						'<div class="itemBody" style="width: 120px;text-align: center;">'+data.lineas[i].CANPREDEF+'</div>'+
					'</div>';
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
	a.href="config/export-ins/exportRepDef.php?lineas="+l+"&fecha="+fecha+"&fechafin="+fechafin;
	a.click();
}