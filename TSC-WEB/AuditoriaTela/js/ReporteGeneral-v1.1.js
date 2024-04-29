$(document).ready(function(){
	$("#maintbl").scroll(function(){
		$("#data-header").css("position","absolute");
		$("#data-header").css("top",$("#maintbl").scrollTop()+"px");
	});
	$.ajax({
		type:"POST",
		data:{
			fecini:fecini,
			fecfin:fecfin,
			codprv:codprv,
			estado:estado,
			resultado:resultado
		},
		url:"config/getInfoRepGen.php",
		success:function(data){
			console.log(data);
			switch(estado) {
				case "0":
					$("#idEstado").text("Todos");
					break;
				case "1":
					$("#idEstado").text("Terminado");
					break;
				case "2":
					$("#idEstado").text("Por terminar");
					break;
				case "3":
					$("#idEstado").text("En auditaría");
					break;
			}
			if (data.info.length>0) {

				$("#msgNoResultados").css("display","none");
				var html='';
				for (var i = 0; i < data.info.length; i++) {
					html+='<div class="tblLine">'+
						'<div class="itemBody2" style="width: 80px;">'+data.info[i].PARTIDA+'</div>'+
						'<div class="itemBody2" style="width: 150px;">'+data.info[i].DESPRV+'</div>'+
						'<div class="itemBody2" style="width: 150px;">'+data.info[i].CLIENTE+'</div>'+
						'<div class="itemBody2" style="width: 100px;">'+data.info[i].CODTEL+'</div>'+
						'<div class="itemBody2" style="width: 300px;">'+data.info[i].DESTEL+'</div>'+
						'<div class="itemBody2" style="width: 100px;">'+data.info[i].PROGRAMA+'</div>'+
						'<div class="itemBody2" style="width: 100px;">'+data.info[i].CODCOL+'</div>'+
						'<div class="itemBody2" style="width: 300px;">'+data.info[i].DSCCOL+'</div>'+


						'<div class="itemBody2" style="width: 80px;">'+data.info[i].NUMVEZ+'</div>'+
						'<div class="itemBody2" style="width: 80px;">'+format_null(data.info[i].CODUSU)+'</div>'+
						'<div class="itemBody2" style="width: 80px;">'+format_null(data.info[i].CODUSUEJE)+'</div>'+
						'<div class="itemBody2" style="width: 90px;">'+data.info[i].FECINIAUD+'</div>'+
						'<div class="itemBody2" style="width: 90px;">'+data.info[i].FECFINAUD+'</div>'+
						'<div class="itemBody2" style="width: 90px;">'+data.info[i].RESULTADO+'</div>'+
						'<div class="itemBody2" style="width: 80px;">'+data.info[i].ESTADO+'</div>'+
						'<div class="itemBody2" style="width: 90px;">'+val_res(data.info[i].RESTONTSC)+'</div>'+
						'<div class="itemBody2" style="width: 90px;">'+val_res(data.info[i].RESAPATSC)+'</div>'+
						'<div class="itemBody2" style="width: 90px;">'+val_res(data.info[i].RESESTDIMTSC)+'</div>'+
						'<div class="itemBody2" style="width: 90px;">'+val_res(data.info[i].ROLLOS)+'</div>'+
						'<div class="itemBody2" style="width: 90px;">'+val_res(data.info[i].ROLLOSAUD)+'</div>'+
						'<div class="itemBody2" style="width: 90px;">'+val_res(data.info[i].CALIFICACION)+'</div>'+
						'<div class="itemBody2" style="width: 90px;">'+val_res(data.info[i].PUNTOS)+'</div>'+
						'<div class="itemBody2" style="width: 90px;">'+val_res(data.info[i].TIPO)+'</div>'+
						'<div class="itemBody2" style="width: 90px;">'+val_res(data.info[i].PESO)+'</div>'+
						'<div class="itemBody2" style="width: 90px;">'+val_res(data.info[i].PESOAUD)+'</div>'+
						'<div class="itemBody2" style="width: 90px;">'+val_res(data.info[i].PESOAPRO)+'</div>'+
						'<div class="itemBody2" style="width: 90px;">'+val_res(data.info[i].PESOCAI)+'</div>'+
						'<div class="itemBody2" style="width: 90px;">'+val_res(data.info[i].PORKGCAIDA)+'</div>'+
					'</div>';
				}
				$("#idTblBody").empty();
				$("#idTblBody").append(html);
			}else{
				$("#maintbl").css("display","none")
			}
			$(".panelCarga").fadeOut(100);
		}
	});
});

function format_null(text){
	if (text==null) {
		return "";
	}else{
		return text;
	}
}

function val_res(text){
	if (text==null) {
		return "-";
	}else{
		return text;
	}
}

function exportar(){
	var a = document.createElement("a");
	a.href="config/exports/exportRepGen.php?fecini="+fecini+"&fecfin="+fecfin+"&codprv="+codprv+
		"&estado="+estado+"&resultado="+resultado;
	a.target="_blank";
	a.click();
}