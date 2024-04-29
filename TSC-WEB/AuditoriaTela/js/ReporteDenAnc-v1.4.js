window.chartColors = {
	red: 'rgb(255, 99, 132)',
	reddark: 'rgb(255, 50, 60)',
	orange: 'rgb(255, 159, 64)',
	yellow: 'rgb(255, 205, 86)',
	green: 'rgb(80, 200, 2)',
	blue: 'rgb(54, 162, 235)',
	purple: 'rgb(153, 102, 255)',
	grey: 'rgb(201, 203, 207)',
	black: 'rgb(50, 50, 50)',
	mostaza: 'rgb(195, 170, 5)',
	reddarkdark: 'rgb(140, 10, 20)'
};

function validate_total(valor){
	if (valor>100) {
		return 100;
	}else{
		return valor;
	}
}

$(document).ready(function(){
	$("#bodytbl").scroll(function(){
		if ($("#bodytbl").scrollTop()>0) {
			$("#data-header").css("top",$("#bodytbl").scrollTop()+"px");
		}else{
			$("#data-header").css("top","0px");
		}
	});
	$.ajax({
		type:"POST",
		data:{
			codcli:codcli,
			codprv:codprv,
			fecini:fecini,
			fecfin:fecfin,
			codtel:0,
			codcol:0,
			codpro:0
		},
		url:"config/getInfoRepDenAnc.php",
		success:function(data){
			var maxval=0;
			var minval=1000;
			var maxvalanc=0;
			var minvalanc=1000;
			var maxvalgra3=0;
			var minvalgra3=1000;
			var maxvalgra4=0;
			var minvalgra4=1000;
			var maxvalgra5=0;
			var minvalgra5=1000;
			var maxvalgra6=0;
			var minvalgra6=1000;
			var maxvalgra7=0;
			var minvalgra7=1000;
			console.log(data);

			$("#titulodetalle").append(data.titulo);

			var html='';
			for (var i = 0; i < data.telas.length; i++) {
				html+=
				'<option value="'+data.telas[i].CODTEL+'">'+data.telas[i].CODTEL+' - '+data.telas[i].DESTEL+'</option>';
			}
			$("#selectTela").empty();
			$("#selectTela").append(html);

			var html='';
			for (var i = 0; i < data.colores.length; i++) {
				html+=
				'<option value="'+data.colores[i].CODCOL+'">'+data.colores[i].DESCOL+'</option>';
			}
			$("#selectColor").empty();
			$("#selectColor").append(html);

			var html='';
			for (var i = 0; i < data.programa.length; i++) {
				html+=
				'<option value="'+data.programa[i].CODPRO+'">'+data.programa[i].DESPRO+'</option>';
			}
			$("#selectPrograma").empty();
			$("#selectPrograma").append(html);

			var html='';
			var labels=[];
			var valortsc=[];
			var valor=[];
			var li=[];
			var ls=[];
			var valortscanc=[];
			var valoranc=[];
			var lianc=[];
			var lsanc=[];
			var gra31=[];
			var gra32=[];
			var gra33=[];
			var gra34=[];
			var gra41=[];
			var gra42=[];
			var gra43=[];
			var gra44=[];
			var gra51=[];
			var gra52=[];
			var gra53=[];
			var gra54=[];
			var gra61=[];
			var gra62=[];
			var gra63=[];
			var gra64=[];
			var gra71=[];
			var gra72=[];
			var gra73=[];
			var gra74=[];

			// ################
			// ### AGREGADO ###
			// ################


			let valortscanchodespues 	= [];
			let valortanchodespues 		= [];
			let lianchodespues 			= [];
			let lsanchodespues 			= [];
			let maxvalanchodespues 		= 0;
			let minvalanchodespues 		= 1000;

			let valortscdensidaddespues 	= [];
			let valortdensidaddespues 		= [];
			let lidensidaddespues 			= [];
			let lsdensidaddespues 			= [];
			let maxvaldensidaddespues 		= 0;
			let minvaldensidaddespues 		= 1000;

			let kilospartida = [];





			for (var i = 0; i < data.detalle.length; i++) {
				labels.push(i+1);

				valortsc.push(parseFloat(data.detalle[i].VALORTSC));
				valor.push(parseFloat(data.detalle[i].VALOR));
				li.push(parseFloat(data.detalle[i].LI));
				ls.push(parseFloat(data.detalle[i].LS));



				valortscanc.push(parseFloat(data.detalle[i].VALORTSCANCHO));
				valoranc.push(parseFloat(data.detalle[i].VALORANCHO));
				lianc.push(parseFloat(data.detalle[i].LIANCHO));
				lsanc.push(parseFloat(data.detalle[i].LSANCHO));

				// KILOS PARTIDA
				kilospartida.push(parseFloat(data.detalle[i].PESO));


				// AGREGADO // ANCHO
				valortscanchodespues.push(parseFloat(data.detalle[i].VALORTSCENCANCHOAFTER));
				valortanchodespues.push(parseFloat(data.detalle[i].VALORENCANCHOAFTER));
				lianchodespues.push(parseFloat(data.detalle[i].LIENCANCHOAFTER));
				lsanchodespues.push(parseFloat(data.detalle[i].LSENCANCHOAFTER));

				if (parseFloat(data.detalle[i].VALORTSC)>maxvalanchodespues) {
					maxvalanchodespues=parseFloat(data.detalle[i].VALORENCANCHOAFTER);
				}
				if (parseFloat(data.detalle[i].VALORTSC)<minvalanchodespues) {
					minvalanchodespues=parseFloat(data.detalle[i].VALORENCANCHOAFTER);
				}

				// AGREGADO // DENSIDAD
				valortscdensidaddespues.push(parseFloat(data.detalle[i].VALORTSCENCDENSIDADAFTER));
				valortdensidaddespues.push(parseFloat(data.detalle[i].VALORENCDENSIDADAFTER));
				lidensidaddespues.push(parseFloat(data.detalle[i].LIENCDENSIDADAFTER));
				lsdensidaddespues.push(parseFloat(data.detalle[i].LSENCDENSIDADAFTER));

				if (parseFloat(data.detalle[i].VALORTSC)>maxvaldensidaddespues) {
					maxvaldensidaddespues=parseFloat(data.detalle[i].VALORENCDENSIDADAFTER);
				}
				if (parseFloat(data.detalle[i].VALORTSC)<minvaldensidaddespues) {
					minvaldensidaddespues=parseFloat(data.detalle[i].VALORENCDENSIDADAFTER);
				}



				if (parseFloat(data.detalle[i].VALORTSC)>maxval) {
					maxval=parseFloat(data.detalle[i].VALORTSC);
				}
				if (parseFloat(data.detalle[i].VALORTSC)<minval) {
					minval=parseFloat(data.detalle[i].VALORTSC);
				}
				if (parseFloat(data.detalle[i].VALOR)>maxval) {
					maxval=parseFloat(data.detalle[i].VALOR);
				}
				if (parseFloat(data.detalle[i].VALOR)<minval) {
					minval=parseFloat(data.detalle[i].VALOR);
				}
				if (parseFloat(data.detalle[i].LI)>maxval) {
					maxval=parseFloat(data.detalle[i].LI);
				}
				if (parseFloat(data.detalle[i].LI)<minval) {
					minval=parseFloat(data.detalle[i].LI);
				}
				if (parseFloat(data.detalle[i].LS)>maxval) {
					maxval=parseFloat(data.detalle[i].LS);
				}
				if (parseFloat(data.detalle[i].LS)<minval) {
					minval=parseFloat(data.detalle[i].LS);
				}
				//ANCHOS
				if (parseFloat(data.detalle[i].VALORTSCANCHO)>maxvalanc) {
					maxvalanc=parseFloat(data.detalle[i].VALORTSCANCHO);
				}
				if (parseFloat(data.detalle[i].VALORTSCANCHO)<minvalanc) {
					minvalanc=parseFloat(data.detalle[i].VALORTSCANCHO);
				}
				if (parseFloat(data.detalle[i].VALORANCHO)>maxvalanc) {
					maxvalanc=parseFloat(data.detalle[i].VALORANCHO);
				}
				if (parseFloat(data.detalle[i].VALORANCHO)<minvalanc) {
					minvalanc=parseFloat(data.detalle[i].VALORANCHO);
				}
				if (parseFloat(data.detalle[i].LIANCHO)>maxvalanc) {
					maxvalanc=parseFloat(data.detalle[i].LIANCHO);
				}
				if (parseFloat(data.detalle[i].LIANCHO)<minvalanc) {
					minvalanc=parseFloat(data.detalle[i].LIANCHO);
				}
				if (parseFloat(data.detalle[i].LSANCHO)>maxvalanc) {
					maxvalanc=parseFloat(data.detalle[i].LSANCHO);
				}
				if (parseFloat(data.detalle[i].LSANCHO)<minvalanc) {
					minvalanc=parseFloat(data.detalle[i].LSANCHO);
				}
				//GRA3
				gra31.push(parseFloat(data.detalle[i].VALORTSCENCANCHO3));
				gra32.push(parseFloat(data.detalle[i].VALORENCANCHO3));
				gra33.push(parseFloat(data.detalle[i].LIENCANCHO3));
				gra34.push(parseFloat(data.detalle[i].LSENCANCHO3));
				if (parseFloat(data.detalle[i].VALORTSCENCANCHO3)>maxvalgra3) {
					maxvalgra3=parseFloat(data.detalle[i].VALORTSCENCANCHO3);
				}
				if (parseFloat(data.detalle[i].VALORTSCENCANCHO3)<minvalgra3) {
					minvalgra3=parseFloat(data.detalle[i].VALORTSCENCANCHO3);
				}
				if (parseFloat(data.detalle[i].VALORENCANCHO3)>maxvalgra3) {
					maxvalgra3=parseFloat(data.detalle[i].VALORENCANCHO3);
				}
				if (parseFloat(data.detalle[i].VALORENCANCHO3)<minvalgra3) {
					minvalgra3=parseFloat(data.detalle[i].VALORENCANCHO3);
				}
				if (parseFloat(data.detalle[i].LIENCANCHO3)>maxvalgra3) {
					maxvalgra3=parseFloat(data.detalle[i].LIENCANCHO3);
				}
				if (parseFloat(data.detalle[i].LIENCANCHO3)<minvalgra3) {
					minvalgra3=parseFloat(data.detalle[i].LIENCANCHO3);
				}
				if (parseFloat(data.detalle[i].LSENCANCHO3)>maxvalgra3) {
					maxvalgra3=parseFloat(data.detalle[i].LSENCANCHO3);
				}
				if (parseFloat(data.detalle[i].LSENCANCHO3)<minvalgra3) {
					minvalgra3=parseFloat(data.detalle[i].LSENCANCHO3);
				}

				//GRA4
				gra41.push(parseFloat(data.detalle[i].VALORTSCENCLARGO3));
				gra42.push(parseFloat(data.detalle[i].VALORENCLARGO3));
				gra43.push(parseFloat(data.detalle[i].LIENCLARGO3));
				gra44.push(parseFloat(data.detalle[i].LSENCLARGO3));
				if (parseFloat(data.detalle[i].VALORTSCENCLARGO3)>maxvalgra4) {
					maxvalgra4=parseFloat(data.detalle[i].VALORTSCENCLARGO3);
				}
				if (parseFloat(data.detalle[i].VALORTSCENCLARGO3)<minvalgra4) {
					minvalgra4=parseFloat(data.detalle[i].VALORTSCENCLARGO3);
				}
				if (parseFloat(data.detalle[i].VALORENCLARGO3)>maxvalgra4) {
					maxvalgra4=parseFloat(data.detalle[i].VALORENCLARGO3);
				}
				if (parseFloat(data.detalle[i].VALORENCLARGO3)<minvalgra4) {
					minvalgra4=parseFloat(data.detalle[i].VALORENCLARGO3);
				}
				if (parseFloat(data.detalle[i].LIENCLARGO3)>maxvalgra4) {
					maxvalgra4=parseFloat(data.detalle[i].LIENCLARGO3);
				}
				if (parseFloat(data.detalle[i].LIENCLARGO3)<minvalgra4) {
					minvalgra4=parseFloat(data.detalle[i].LIENCLARGO3);
				}
				if (parseFloat(data.detalle[i].LSENCLARGO3)>maxvalgra4) {
					maxvalgra4=parseFloat(data.detalle[i].LSENCLARGO3);
				}
				if (parseFloat(data.detalle[i].LSENCLARGO3)<minvalgra4) {
					minvalgra4=parseFloat(data.detalle[i].LSENCLARGO3);
				}
				//GRA5
				gra51.push(parseFloat(data.detalle[i].VALORTSCREV3));
				gra52.push(parseFloat(data.detalle[i].VALORREV3));
				gra53.push(parseFloat(data.detalle[i].LIREV3));
				gra54.push(parseFloat(data.detalle[i].LSREV3));
				if (parseFloat(data.detalle[i].VALORTSCREV3)>maxvalgra5) {
					maxvalgra5=parseFloat(data.detalle[i].VALORTSCREV3);
				}
				if (parseFloat(data.detalle[i].VALORTSCREV3)<minvalgra5) {
					minvalgra5=parseFloat(data.detalle[i].VALORTSCREV3);
				}
				if (parseFloat(data.detalle[i].VALORREV3)>maxvalgra5) {
					maxvalgra5=parseFloat(data.detalle[i].VALORREV3);
				}
				if (parseFloat(data.detalle[i].VALORREV3)<minvalgra5) {
					minvalgra5=parseFloat(data.detalle[i].VALORREV3);
				}
				if (parseFloat(data.detalle[i].LIREV3)>maxvalgra5) {
					maxvalgra5=parseFloat(data.detalle[i].LIREV3);
				}
				if (parseFloat(data.detalle[i].LIREV3)<minvalgra5) {
					minvalgra5=parseFloat(data.detalle[i].LIREV3);
				}
				if (parseFloat(data.detalle[i].LSREV3)>maxvalgra5) {
					maxvalgra5=parseFloat(data.detalle[i].LSREV3);
				}
				if (parseFloat(data.detalle[i].LSREV3)<minvalgra5) {
					minvalgra5=parseFloat(data.detalle[i].LSREV3);
				}
				//GRA6
				gra61.push(parseFloat(data.detalle[i].VALORTSCINCACA3));
				gra62.push(parseFloat(data.detalle[i].VALORINCACA3));
				gra63.push(parseFloat(data.detalle[i].LIINCACA3));
				gra64.push(parseFloat(data.detalle[i].LSINCACA3));
				if (parseFloat(data.detalle[i].VALORTSCINCACA3)>maxvalgra6) {
					maxvalgra6=parseFloat(data.detalle[i].VALORTSCINCACA3);
				}
				if (parseFloat(data.detalle[i].VALORTSCINCACA3)<minvalgra6) {
					minvalgra6=parseFloat(data.detalle[i].VALORTSCINCACA3);
				}
				if (parseFloat(data.detalle[i].VALORINCACA3)>maxvalgra6) {
					maxvalgra6=parseFloat(data.detalle[i].VALORINCACA3);
				}
				if (parseFloat(data.detalle[i].VALORINCACA3)<minvalgra6) {
					minvalgra6=parseFloat(data.detalle[i].VALORINCACA3);
				}
				if (parseFloat(data.detalle[i].LIINCACA3)>maxvalgra6) {
					maxvalgra6=parseFloat(data.detalle[i].LIINCACA3);
				}
				if (parseFloat(data.detalle[i].LIINCACA3)<minvalgra6) {
					minvalgra6=parseFloat(data.detalle[i].LIINCACA3);
				}
				if (parseFloat(data.detalle[i].LSINCACA3)>maxvalgra6) {
					maxvalgra6=parseFloat(data.detalle[i].LSINCACA3);
				}
				if (parseFloat(data.detalle[i].LSINCACA3)<minvalgra6) {
					minvalgra6=parseFloat(data.detalle[i].LSINCACA3);
				}
				//GRA7
				gra71.push(parseFloat(data.detalle[i].VALORTSCINCLAV3));
				gra72.push(parseFloat(data.detalle[i].VALORINCLAV3));
				gra73.push(parseFloat(data.detalle[i].LIINCLAV3));
				gra74.push(parseFloat(data.detalle[i].LSINCLAV3));
				if (parseFloat(data.detalle[i].VALORTSCINCLAV3)>maxvalgra7) {
					maxvalgra7=parseFloat(data.detalle[i].VALORTSCINCLAV3);
				}
				if (parseFloat(data.detalle[i].VALORTSCINCLAV3)<minvalgra7) {
					minvalgra7=parseFloat(data.detalle[i].VALORTSCINCLAV3);
				}
				if (parseFloat(data.detalle[i].VALORINCLAV3)>maxvalgra7) {
					maxvalgra7=parseFloat(data.detalle[i].VALORINCLAV3);
				}
				if (parseFloat(data.detalle[i].VALORINCLAV3)<minvalgra7) {
					minvalgra7=parseFloat(data.detalle[i].VALORINCLAV3);
				}
				if (parseFloat(data.detalle[i].LIINCLAV3)>maxvalgra7) {
					maxvalgra7=parseFloat(data.detalle[i].LIINCLAV3);
				}
				if (parseFloat(data.detalle[i].LIINCLAV3)<minvalgra7) {
					minvalgra7=parseFloat(data.detalle[i].LIINCLAV3);
				}
				if (parseFloat(data.detalle[i].LSINCLAV3)>maxvalgra7) {
					maxvalgra7=parseFloat(data.detalle[i].LSINCLAV3);
				}
				if (parseFloat(data.detalle[i].LSINCLAV3)<minvalgra7) {
					minvalgra7=parseFloat(data.detalle[i].LSINCLAV3);
				}
				html+=
				'<div class="tblLine" >'+
					'<div class="itemBody2" style="width: 70px;">'+(i+1)+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].PARTIDA+'</div>'+
					'<div class="itemBody2" style="width: 150px;">'+data.detalle[i].PROVEEDOR+'</div>'+
					'<div class="itemBody2" style="width: 150px;">'+data.detalle[i].CLIENTE+'</div>'+
					'<div class="itemBody2" style="width: 150px;">'+data.detalle[i].PROGRAMA+'</div>'+
					'<div class="itemBody2" style="width: 150px;">'+data.detalle[i].CODTEL+'</div>'+
					'<div class="itemBody2" style="width: 150px;">'+data.detalle[i].DESTEL+'</div>'+
					'<div class="itemBody2" style="width: 150px;">'+data.detalle[i].CODCOL+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORTSC+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALOR+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LI+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LS+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORTSCANCHO+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORANCHO+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LIANCHO+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LSANCHO+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].FECFINAUD+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].PESO+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].GR_DESV+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].POR_GR_DESV+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].KG_AFEC+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].KG_AFEC_MAS+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORTSCENCANCHO3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORENCANCHO3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LIENCANCHO3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LSENCANCHO3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORTSCENCLARGO3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORENCLARGO3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LIENCLARGO3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LSENCLARGO3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORTSCREV3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORREV3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LIREV3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LSREV3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORTSCINCACA3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORINCACA3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LIINCACA3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LSINCACA3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORTSCINCLAV3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORINCLAV3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LIINCLAV3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LSINCLAV3+'</div>'+
				'</div>';
			}

			processGraph(labels,valortsc,valor,li,ls,'-den1',maxval,minval,kilospartida);
			processGraph(labels,valortscanc,valoranc,lianc,lsanc,'-anc1',maxvalanc,minvalanc,kilospartida);
			processGraph(labels,gra31,gra32,gra33,gra34,'-gra3',maxvalgra3,minvalgra3);
			processGraph(labels,gra41,gra42,gra43,gra44,'-gra4',maxvalgra4,minvalgra4);
			processGraph(labels,gra51,gra52,gra53,gra54,'-gra5',maxvalgra5,minvalgra5);
			processGraph(labels,gra61,gra62,gra63,gra64,'-gra6',maxvalgra6,minvalgra6);
			processGraph(labels,gra71,gra72,gra73,gra74,'-gra7',maxvalgra7,minvalgra7);

			// AGREGADO
			processGraph(labels,valortscanchodespues,valortanchodespues,lianchodespues,lsanchodespues,'-anc2',maxvalanchodespues,minvalanchodespues);
			processGraph(labels,valortscdensidaddespues,valortdensidaddespues,lidensidaddespues,lsdensidaddespues,'-den2',maxvaldensidaddespues,minvaldensidaddespues);


			// let valortscanchodespues 	= [];
			// let valortanchodespues 		= [];
			// let lianchodespues 			= [];
			// let lsanchodespues 			= [];
			// let maxvalanchodespues 		= 0;
			// let minvalanchodespues 		= 1000;

			$("#idTblBody").empty();
			$("#idTblBody").append(html);

			$(".panelCarga").fadeOut(200);
		},
	    error: function (jqXHR, exception) {
	        var msg = '';
	        if (jqXHR.status === 0) {
	            msg = 'Sin conexión.\nVerifique su conexión a internet!';
	        } else if (jqXHR.status == 404) {
	            msg = 'No se encuentra el archivo necesario para guardar la inspección!';
	        } else if (jqXHR.status == 500) {
	            msg = 'Servidor no disponible (Web de TSC). Intente más tarde';
	        } else if (exception === 'parsererror') {
	            msg = 'La respuesta tiene errores. Por favor, contactar al equipo de desarrollo!';
	        } else if (exception === 'timeout') {
	            msg = 'Tiempo de respuesta muy largo (Web de TSC)!';
	        } else if (exception === 'abort') {
	            msg = 'Se cancelo la consulta!';
	        } else {
	            msg = 'Error desconocido.\n' + jqXHR.responseText+'.\nInforme al equipo de desarrollo!';
	        }
	        alert(msg);
			$(".panelCarga").fadeOut(200);
	    }
	});
});

function ArrayAvg(myArray) {
    var i = 0, summ = 0, ArrayLen = myArray.length;
    while (i < ArrayLen) {
        summ = summ + myArray[i++];
}
    return summ / ArrayLen;
}

function processGraphHistograma(dataChart,id){

	document.getElementById('chart'+id).innerHTML='';
	document.getElementById('chart'+id).innerHTML='<canvas id="chart-area'+id+'"  ></canvas>';

	var ctx = document.getElementById('chart-area'+id).getContext('2d');

	window.myMixedChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels:dataChart.label,
			datasets:[{
				label:'Histograma',
				data:dataChart.data,
				backgroundColor:dataChart.colors,
				borderColor:dataChart.borders,
			}],
			
			// backgroundColor: [
            //     'rgba(255, 99, 132, 0.2)',
            //     'rgba(54, 162, 235, 0.2)',
            //     'rgba(255, 206, 86, 0.2)',
            //     'rgba(75, 192, 192, 0.2)',
            //     'rgba(153, 102, 255, 0.2)',
            //     'rgba(255, 159, 64, 0.2)'
            // ],
            // borderColor: [
            //     'rgba(255, 99, 132, 1)',
            //     'rgba(54, 162, 235, 1)',
            //     'rgba(255, 206, 86, 1)',
            //     'rgba(75, 192, 192, 1)',
            //     'rgba(153, 102, 255, 1)',
            //     'rgba(255, 159, 64, 1)'
            // ],
			borderWidth: 1
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true
					}
				}]
			}
		}

	});



}


function processGraph(labels,valortsc,valor,li,ls,id,maxval,minval,kilos = null){

	document.getElementById('chart'+id).innerHTML='';
	document.getElementById('chart'+id).innerHTML='<canvas id="chart-area'+id+'"></canvas>';


	if(kilos != null){

		// MOSTRAMOS VALORES
		let promedio 	= ArrayAvg(valortsc);
		let estandar 	= valor[0];
		let sumakilos	= kilos.reduce((a, b) => a + b, 0);
		let arraymult 	= [];
		for(let i = 0 ; i < valortsc.length; i++){
			arraymult.push( valortsc[i] *  kilos[i] );
		}

		let sumamult 		= arraymult.reduce((a, b) => a + b, 0);
		let ponderada 		= sumamult / sumakilos;

		let min = 1000000;
		if(promedio < min){ min = promedio;}
		if(estandar < min){ min = estandar;}
		if(ponderada < min){ min = ponderada;}

		let max = 0;
		if(promedio > max){ max = promedio;}
		if(estandar > max){ max = estandar;}
		if(ponderada > max){ max = ponderada;}


		// ARMAMOS PONDERADO
		processGraphPonderado([ promedio.toFixed(2)],[estandar.toFixed(2)],[ ponderada.toFixed(2)],id+"total",min,max);

		// HISTOGRAMA
		let minimoHistograma = Math.min(...valortsc);
		let maximoHistograma = Math.max(...valortsc);

		// let dataNueva = [];
		let label = [];
		let data = [];
		let colors = [];
		let borders = [];


		for(let x = minimoHistograma; x <=  maximoHistograma ; x++){

			let cantidad = valortsc.filter(obj => obj == x );
			cantidad = cantidad.length;

			label.push(x.toString());
			data.push(cantidad);
			colors.push('rgba(54, 162, 235, 0.2)');
			borders.push('rgba(54, 162, 235, 1)');

			// borders.push('rgb(255, 99, 132)');



		}

		processGraphHistograma({
			label,data,colors,borders
		},id+"Histograma");
		
	}

	


	var chartData = {
		labels: labels,
		datasets: [{
			type: 'line',
			label: 'Auditado TSC',
			backgroundColor:window.chartColors.blue,
			data: valortsc,
			lineTension: 0,
			borderWidth: 2,
			fill: false,
			yAxisID: 'y-axis-1',
			borderColor: window.chartColors.blue
		}, {
			type: 'line',
			label: 'Estandar',
			backgroundColor:window.chartColors.reddark,
			data: valor,
			lineTension: 0,
			borderWidth: 2,
			fill: false,
			yAxisID: 'y-axis-2',
			borderColor: window.chartColors.reddark
		}, {
			type: 'line',
			label: 'LI',
			backgroundColor:window.chartColors.black,
			data: li,
			lineTension: 0,
			borderWidth: 2,
			fill: false,
			yAxisID: 'y-axis-3',
			borderColor: window.chartColors.black
		}, {
			type: 'line',
			label: 'LS',
			backgroundColor:window.chartColors.yellow,
			data: ls,
			lineTension: 0,
			borderWidth: 2,
			fill: false,
			yAxisID: 'y-axis-4',
			borderColor: window.chartColors.yellow
		}]
	};

	var ctx = document.getElementById('chart-area'+id).getContext('2d');
	window.myMixedChart = new Chart(ctx, {
		type: 'bar',
		data: chartData,
		options: {
			responsive: true,
			tooltips: {
				mode: 'index',
				intersect: true
			},
			scales: {
				xAxes: [{
					display: true,
					scaleLabel: {
						display: true
					}
				}],				
				yAxes: [{
					type: 'linear',
					display: true,
					ticks: {
						suggestedMin: minval,
						suggestedMax: maxval
					},
					id: 'y-axis-1',
				},{
					type: 'linear',
					display: false,
					ticks: {
						suggestedMin: minval,
						suggestedMax: maxval
					},
					id: 'y-axis-2'
				},{
					type: 'linear',
					display: false,
					ticks: {
						suggestedMin: minval,
						suggestedMax: maxval
					},
					id: 'y-axis-3'
				},{
					type: 'linear',
					display: false,
					ticks: {
						suggestedMin: minval,
						suggestedMax: maxval
					},
					id: 'y-axis-4'
				}]
			},
			plugins: {
				datalabels: {
					formatter: function(value, context) {
						/*if (context.dataset.type!="line") {
							return Math.round(value)+"%";
						}else{*/
							return "";//Math.round(value);
						//}
					}
				}
			}
		}
	});
}


// console.log("promedio",promedio,"estandar",estandar,"ponderada",ponderada);


function processGraphPonderado(promedio,estandar,ponderado,id,minval,maxval){

	// 
	// console.log(promedio,estandar,ponderado,id,"RA");

	document.getElementById('chart'+id).innerHTML='';
	document.getElementById('chart'+id).innerHTML='<canvas  style="margin-top: 80px;"  id="chart-area'+id+'"></canvas>';

	var chartData = {
		labels: ["Información General"],
		datasets: [{
			type: 'line',
			label: 'Promedio',
			backgroundColor:window.chartColors.blue,
			data: promedio,
			lineTension: 0,
			borderWidth: 2,
			fill: false,
			yAxisID: 'y-axis-1',
			borderColor: window.chartColors.blue
		}, {
			type: 'line',
			label: 'Estandar',
			backgroundColor:window.chartColors.reddark,
			data: estandar,
			lineTension: 0,
			borderWidth: 2,
			fill: false,
			yAxisID: 'y-axis-2',
			borderColor: window.chartColors.reddark
		}, {
			type: 'line',
			label: 'Ponderado',
			backgroundColor:window.chartColors.black,
			data: ponderado,
			lineTension: 0,
			borderWidth: 2,
			fill: false,
			yAxisID: 'y-axis-3',
			borderColor: window.chartColors.black
		}
		]
	};

	var ctx = document.getElementById('chart-area'+id).getContext('2d');
	window.myMixedChart = new Chart(ctx, {
		type: 'bar',
		data: chartData,
		options: {
			responsive: false,
			tooltips: {
				mode: 'index',
				intersect: true
			},
			scales: {
				xAxes: [{
					display: true,
					scaleLabel: {
						display: true
					}
				}],				
				yAxes: [{
					type: 'linear',
					display: true,
					ticks: {
						suggestedMin: minval,
						suggestedMax: maxval
					},
					id: 'y-axis-1',
				},{
					type: 'linear',
					display: false,
					ticks: {
						suggestedMin: minval,
						suggestedMax: maxval
					},
					id: 'y-axis-2'
				},{
					type: 'linear',
					display: false,
					ticks: {
						suggestedMin: minval,
						suggestedMax: maxval
					},
					id: 'y-axis-3'
				},
				// {
				// 	type: 'linear',
				// 	display: false,
				// 	ticks: {
				// 		suggestedMin: minval,
				// 		suggestedMax: maxval
				// 	},
				// 	id: 'y-axis-4'
				// }
			]
			},
			plugins: {
				datalabels: {
					formatter: function(value, context) {
						/*if (context.dataset.type!="line") {
							return Math.round(value)+"%";
						}else{*/
							return "";//Math.round(value);
						//}
					}
				}
			}
		}
	});
}



function downloadPDF(){
	$.ajax({
	  	type: "POST",
	  	url: "config/saveTmpImgRepBlo.php",
	  	data: { 
	    	img1: document.getElementById("chart-area").toDataURL("image/png"),
	    	img2: document.getElementById("chart-area2").toDataURL("image/png"),
	    	img3: document.getElementById("chart-area3").toDataURL("image/png"),
	    	img4: document.getElementById("chart-area4").toDataURL("image/png"),
	    	img5: document.getElementById("chart-area5").toDataURL("image/png"),
			codprv:codprv,
			fecini:fecini,
			fecfin:fecfin,
			codusu:codusurep,
			codusueje:codusueje
	  	},
	  	success:function(data){
	  		var title=$("#titulodetalle").text();
	  		var a=document.createElement("a");
	  		a.target="_blank";
	  		a.href="fpdf/pdfRepBlo.php?n="+data+
	  		"&t="+title+"&codprv="+codprv+"&fecini="+fecini+"&fecfin="+fecfin+"&codusu="+codusurep+"&codusueje="+codusueje+
	  		"&sumpesblo="+sumpesblo+"&sumcanblo="+sumcanblo+"&sumpeston="+sumpeston+"&sumcanton="+sumcanton+
	  		"&sumpesapa="+sumpesapa+"&sumcanapa="+sumcanapa+"&sumpesapadef="+sumpesapadef+"&sumcanapadef="+sumcanapadef+
	  		"&sumpesed="+sumpesed+"&sumcaned="+sumcaned;
	  		a.click();
	  	}
	}).done(function(o) {
	  	console.log('Images Saved!'); 
	});
}

function exportar(){
	var a=document.createElement("a");
	a.target="_blank";
	a.href="config/exports/exportRepDenAnc.php?codcli="+codcli
	+"&codprv="+codprv
	+"&fecini="+fecini
	+"&fecfin="+fecfin
	+"&codtel="+$("#selectTela").val()
	+"&codcol="+$("#selectColor").val()
	+"&codpro="+$("#selectPrograma").val();
	a.click();
}

function update_reportes(){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		data:{
			codcli:codcli,
			codprv:codprv,
			fecini:fecini,
			fecfin:fecfin,
			codtel:$("#selectTela").val(),
			codcol:$("#selectColor").val(),
			codpro:$("#selectPrograma").val()
		},
		url:"config/updateInfoRepDenAnc.php",
		success:function(data){
			var maxval=0;
			var minval=1000;
			var maxvalanc=0;
			var minvalanc=1000;
			var maxvalgra3=0;
			var minvalgra3=1000;
			var maxvalgra4=0;
			var minvalgra4=1000;
			var maxvalgra5=0;
			var minvalgra5=1000;
			var maxvalgra6=0;
			var minvalgra6=1000;
			var maxvalgra7=0;
			var minvalgra7=1000;
			console.log(data);

			var html='';
			var labels=[];
			var valortsc=[];
			var valor=[];
			var li=[];
			var ls=[];
			var valortscanc=[];
			var valoranc=[];
			var lianc=[];
			var lsanc=[];
			var gra31=[];
			var gra32=[];
			var gra33=[];
			var gra34=[];
			var gra41=[];
			var gra42=[];
			var gra43=[];
			var gra44=[];
			var gra51=[];
			var gra52=[];
			var gra53=[];
			var gra54=[];
			var gra61=[];
			var gra62=[];
			var gra63=[];
			var gra64=[];
			var gra71=[];
			var gra72=[];
			var gra73=[];
			var gra74=[];


			// ################
			// ### AGREGADO ###
			// ################
			let valortscanchodespues 	= [];
			let valortanchodespues 		= [];
			let lianchodespues 			= [];
			let lsanchodespues 			= [];
			let maxvalanchodespues 		= 0;
			let minvalanchodespues 		= 1000;

			let valortscdensidaddespues 	= [];
			let valortdensidaddespues 		= [];
			let lidensidaddespues 			= [];
			let lsdensidaddespues 			= [];
			let maxvaldensidaddespues 		= 0;
			let minvaldensidaddespues 		= 1000;

			let kilospartida = [];

			for (var i = 0; i < data.detalle.length; i++) {

				// KILOS PARTIDA
				kilospartida.push(parseFloat(data.detalle[i].PESO));


				// AGREGADO // ANCHO
				valortscanchodespues.push(parseFloat(data.detalle[i].VALORTSCENCANCHOAFTER));
				valortanchodespues.push(parseFloat(data.detalle[i].VALORENCANCHOAFTER));
				lianchodespues.push(parseFloat(data.detalle[i].LIENCANCHOAFTER));
				lsanchodespues.push(parseFloat(data.detalle[i].LSENCANCHOAFTER));

				if (parseFloat(data.detalle[i].VALORTSC)>maxvalanchodespues) {
					maxvalanchodespues=parseFloat(data.detalle[i].VALORENCANCHOAFTER);
				}
				if (parseFloat(data.detalle[i].VALORTSC)<minvalanchodespues) {
					minvalanchodespues=parseFloat(data.detalle[i].VALORENCANCHOAFTER);
				}

				// AGREGADO // DENSIDAD
				valortscdensidaddespues.push(parseFloat(data.detalle[i].VALORTSCENCDENSIDADAFTER));
				valortdensidaddespues.push(parseFloat(data.detalle[i].VALORENCDENSIDADAFTER));
				lidensidaddespues.push(parseFloat(data.detalle[i].LIENCDENSIDADAFTER));
				lsdensidaddespues.push(parseFloat(data.detalle[i].LSENCDENSIDADAFTER));

				if (parseFloat(data.detalle[i].VALORTSC)>maxvaldensidaddespues) {
					maxvaldensidaddespues=parseFloat(data.detalle[i].VALORENCDENSIDADAFTER);
				}
				if (parseFloat(data.detalle[i].VALORTSC)<minvaldensidaddespues) {
					minvaldensidaddespues=parseFloat(data.detalle[i].VALORENCDENSIDADAFTER);
				}

				labels.push(i+1);
				valortsc.push(parseFloat(data.detalle[i].VALORTSC));
				valor.push(parseFloat(data.detalle[i].VALOR));
				li.push(parseFloat(data.detalle[i].LI));
				ls.push(parseFloat(data.detalle[i].LS));
				valortscanc.push(parseFloat(data.detalle[i].VALORTSCANCHO));
				valoranc.push(parseFloat(data.detalle[i].VALORANCHO));
				lianc.push(parseFloat(data.detalle[i].LIANCHO));
				lsanc.push(parseFloat(data.detalle[i].LSANCHO));
				if (parseFloat(data.detalle[i].VALORTSC)>maxval) {
					maxval=parseFloat(data.detalle[i].VALORTSC);
				}
				if (parseFloat(data.detalle[i].VALORTSC)<minval) {
					minval=parseFloat(data.detalle[i].VALORTSC);
				}
				if (parseFloat(data.detalle[i].VALOR)>maxval) {
					maxval=parseFloat(data.detalle[i].VALOR);
				}
				if (parseFloat(data.detalle[i].VALOR)<minval) {
					minval=parseFloat(data.detalle[i].VALOR);
				}
				if (parseFloat(data.detalle[i].LI)>maxval) {
					maxval=parseFloat(data.detalle[i].LI);
				}
				if (parseFloat(data.detalle[i].LI)<minval) {
					minval=parseFloat(data.detalle[i].LI);
				}
				if (parseFloat(data.detalle[i].LS)>maxval) {
					maxval=parseFloat(data.detalle[i].LS);
				}
				if (parseFloat(data.detalle[i].LS)<minval) {
					minval=parseFloat(data.detalle[i].LS);
				}
				//ANCHOS
				if (parseFloat(data.detalle[i].VALORTSCANCHO)>maxvalanc) {
					maxvalanc=parseFloat(data.detalle[i].VALORTSCANCHO);
				}
				if (parseFloat(data.detalle[i].VALORTSCANCHO)<minvalanc) {
					minvalanc=parseFloat(data.detalle[i].VALORTSCANCHO);
				}
				if (parseFloat(data.detalle[i].VALORANCHO)>maxvalanc) {
					maxvalanc=parseFloat(data.detalle[i].VALORANCHO);
				}
				if (parseFloat(data.detalle[i].VALORANCHO)<minvalanc) {
					minvalanc=parseFloat(data.detalle[i].VALORANCHO);
				}
				if (parseFloat(data.detalle[i].LIANCHO)>maxvalanc) {
					maxvalanc=parseFloat(data.detalle[i].LIANCHO);
				}
				if (parseFloat(data.detalle[i].LIANCHO)<minvalanc) {
					minvalanc=parseFloat(data.detalle[i].LIANCHO);
				}
				if (parseFloat(data.detalle[i].LSANCHO)>maxvalanc) {
					maxvalanc=parseFloat(data.detalle[i].LSANCHO);
				}
				if (parseFloat(data.detalle[i].LSANCHO)<minvalanc) {
					minvalanc=parseFloat(data.detalle[i].LSANCHO);
				}
				//GRA3
				gra31.push(parseFloat(data.detalle[i].VALORTSCENCANCHO3));
				gra32.push(parseFloat(data.detalle[i].VALORENCANCHO3));
				gra33.push(parseFloat(data.detalle[i].LIENCANCHO3));
				gra34.push(parseFloat(data.detalle[i].LSENCANCHO3));
				if (parseFloat(data.detalle[i].VALORTSCENCANCHO3)>maxvalgra3) {
					maxvalgra3=parseFloat(data.detalle[i].VALORTSCENCANCHO3);
				}
				if (parseFloat(data.detalle[i].VALORTSCENCANCHO3)<minvalgra3) {
					minvalgra3=parseFloat(data.detalle[i].VALORTSCENCANCHO3);
				}
				if (parseFloat(data.detalle[i].VALORENCANCHO3)>maxvalgra3) {
					maxvalgra3=parseFloat(data.detalle[i].VALORENCANCHO3);
				}
				if (parseFloat(data.detalle[i].VALORENCANCHO3)<minvalgra3) {
					minvalgra3=parseFloat(data.detalle[i].VALORENCANCHO3);
				}
				if (parseFloat(data.detalle[i].LIENCANCHO3)>maxvalgra3) {
					maxvalgra3=parseFloat(data.detalle[i].LIENCANCHO3);
				}
				if (parseFloat(data.detalle[i].LIENCANCHO3)<minvalgra3) {
					minvalgra3=parseFloat(data.detalle[i].LIENCANCHO3);
				}
				if (parseFloat(data.detalle[i].LSENCANCHO3)>maxvalgra3) {
					maxvalgra3=parseFloat(data.detalle[i].LSENCANCHO3);
				}
				if (parseFloat(data.detalle[i].LSENCANCHO3)<minvalgra3) {
					minvalgra3=parseFloat(data.detalle[i].LSENCANCHO3);
				}

				//GRA4
				gra41.push(parseFloat(data.detalle[i].VALORTSCENCLARGO3));
				gra42.push(parseFloat(data.detalle[i].VALORENCLARGO3));
				gra43.push(parseFloat(data.detalle[i].LIENCLARGO3));
				gra44.push(parseFloat(data.detalle[i].LSENCLARGO3));
				if (parseFloat(data.detalle[i].VALORTSCENCLARGO3)>maxvalgra4) {
					maxvalgra4=parseFloat(data.detalle[i].VALORTSCENCLARGO3);
				}
				if (parseFloat(data.detalle[i].VALORTSCENCLARGO3)<minvalgra4) {
					minvalgra4=parseFloat(data.detalle[i].VALORTSCENCLARGO3);
				}
				if (parseFloat(data.detalle[i].VALORENCLARGO3)>maxvalgra4) {
					maxvalgra4=parseFloat(data.detalle[i].VALORENCLARGO3);
				}
				if (parseFloat(data.detalle[i].VALORENCLARGO3)<minvalgra4) {
					minvalgra4=parseFloat(data.detalle[i].VALORENCLARGO3);
				}
				if (parseFloat(data.detalle[i].LIENCLARGO3)>maxvalgra4) {
					maxvalgra4=parseFloat(data.detalle[i].LIENCLARGO3);
				}
				if (parseFloat(data.detalle[i].LIENCLARGO3)<minvalgra4) {
					minvalgra4=parseFloat(data.detalle[i].LIENCLARGO3);
				}
				if (parseFloat(data.detalle[i].LSENCLARGO3)>maxvalgra4) {
					maxvalgra4=parseFloat(data.detalle[i].LSENCLARGO3);
				}
				if (parseFloat(data.detalle[i].LSENCLARGO3)<minvalgra4) {
					minvalgra4=parseFloat(data.detalle[i].LSENCLARGO3);
				}
				//GRA5
				gra51.push(parseFloat(data.detalle[i].VALORTSCREV3));
				gra52.push(parseFloat(data.detalle[i].VALORREV3));
				gra53.push(parseFloat(data.detalle[i].LIREV3));
				gra54.push(parseFloat(data.detalle[i].LSREV3));
				if (parseFloat(data.detalle[i].VALORTSCREV3)>maxvalgra5) {
					maxvalgra5=parseFloat(data.detalle[i].VALORTSCREV3);
				}
				if (parseFloat(data.detalle[i].VALORTSCREV3)<minvalgra5) {
					minvalgra5=parseFloat(data.detalle[i].VALORTSCREV3);
				}
				if (parseFloat(data.detalle[i].VALORREV3)>maxvalgra5) {
					maxvalgra5=parseFloat(data.detalle[i].VALORREV3);
				}
				if (parseFloat(data.detalle[i].VALORREV3)<minvalgra5) {
					minvalgra5=parseFloat(data.detalle[i].VALORREV3);
				}
				if (parseFloat(data.detalle[i].LIREV3)>maxvalgra5) {
					maxvalgra5=parseFloat(data.detalle[i].LIREV3);
				}
				if (parseFloat(data.detalle[i].LIREV3)<minvalgra5) {
					minvalgra5=parseFloat(data.detalle[i].LIREV3);
				}
				if (parseFloat(data.detalle[i].LSREV3)>maxvalgra5) {
					maxvalgra5=parseFloat(data.detalle[i].LSREV3);
				}
				if (parseFloat(data.detalle[i].LSREV3)<minvalgra5) {
					minvalgra5=parseFloat(data.detalle[i].LSREV3);
				}
				//GRA6
				gra61.push(parseFloat(data.detalle[i].VALORTSCINCACA3));
				gra62.push(parseFloat(data.detalle[i].VALORINCACA3));
				gra63.push(parseFloat(data.detalle[i].LIINCACA3));
				gra64.push(parseFloat(data.detalle[i].LSINCACA3));
				if (parseFloat(data.detalle[i].VALORTSCINCACA3)>maxvalgra6) {
					maxvalgra6=parseFloat(data.detalle[i].VALORTSCINCACA3);
				}
				if (parseFloat(data.detalle[i].VALORTSCINCACA3)<minvalgra6) {
					minvalgra6=parseFloat(data.detalle[i].VALORTSCINCACA3);
				}
				if (parseFloat(data.detalle[i].VALORINCACA3)>maxvalgra6) {
					maxvalgra6=parseFloat(data.detalle[i].VALORINCACA3);
				}
				if (parseFloat(data.detalle[i].VALORINCACA3)<minvalgra6) {
					minvalgra6=parseFloat(data.detalle[i].VALORINCACA3);
				}
				if (parseFloat(data.detalle[i].LIINCACA3)>maxvalgra6) {
					maxvalgra6=parseFloat(data.detalle[i].LIINCACA3);
				}
				if (parseFloat(data.detalle[i].LIINCACA3)<minvalgra6) {
					minvalgra6=parseFloat(data.detalle[i].LIINCACA3);
				}
				if (parseFloat(data.detalle[i].LSINCACA3)>maxvalgra6) {
					maxvalgra6=parseFloat(data.detalle[i].LSINCACA3);
				}
				if (parseFloat(data.detalle[i].LSINCACA3)<minvalgra6) {
					minvalgra6=parseFloat(data.detalle[i].LSINCACA3);
				}
				//GRA7
				gra71.push(parseFloat(data.detalle[i].VALORTSCINCLAV3));
				gra72.push(parseFloat(data.detalle[i].VALORINCLAV3));
				gra73.push(parseFloat(data.detalle[i].LIINCLAV3));
				gra74.push(parseFloat(data.detalle[i].LSINCLAV3));
				if (parseFloat(data.detalle[i].VALORTSCINCLAV3)>maxvalgra7) {
					maxvalgra7=parseFloat(data.detalle[i].VALORTSCINCLAV3);
				}
				if (parseFloat(data.detalle[i].VALORTSCINCLAV3)<minvalgra7) {
					minvalgra7=parseFloat(data.detalle[i].VALORTSCINCLAV3);
				}
				if (parseFloat(data.detalle[i].VALORINCLAV3)>maxvalgra7) {
					maxvalgra7=parseFloat(data.detalle[i].VALORINCLAV3);
				}
				if (parseFloat(data.detalle[i].VALORINCLAV3)<minvalgra7) {
					minvalgra7=parseFloat(data.detalle[i].VALORINCLAV3);
				}
				if (parseFloat(data.detalle[i].LIINCLAV3)>maxvalgra7) {
					maxvalgra7=parseFloat(data.detalle[i].LIINCLAV3);
				}
				if (parseFloat(data.detalle[i].LIINCLAV3)<minvalgra7) {
					minvalgra7=parseFloat(data.detalle[i].LIINCLAV3);
				}
				if (parseFloat(data.detalle[i].LSINCLAV3)>maxvalgra7) {
					maxvalgra7=parseFloat(data.detalle[i].LSINCLAV3);
				}
				if (parseFloat(data.detalle[i].LSINCLAV3)<minvalgra7) {
					minvalgra7=parseFloat(data.detalle[i].LSINCLAV3);
				}
				html+=
				'<div class="tblLine" >'+
					'<div class="itemBody2" style="width: 70px;">'+(i+1)+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].PARTIDA+'</div>'+
					'<div class="itemBody2" style="width: 150px;">'+data.detalle[i].PROVEEDOR+'</div>'+
					'<div class="itemBody2" style="width: 150px;">'+data.detalle[i].CLIENTE+'</div>'+
					'<div class="itemBody2" style="width: 150px;">'+data.detalle[i].PROGRAMA+'</div>'+
					'<div class="itemBody2" style="width: 150px;">'+data.detalle[i].CODTEL+'</div>'+
					'<div class="itemBody2" style="width: 150px;">'+data.detalle[i].DESTEL+'</div>'+
					'<div class="itemBody2" style="width: 150px;">'+data.detalle[i].CODCOL+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORTSC+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALOR+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LI+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LS+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORTSCANCHO+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORANCHO+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LIANCHO+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LSANCHO+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].FECFINAUD+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].PESO+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].GR_DESV+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].POR_GR_DESV+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].KG_AFEC+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].KG_AFEC_MAS+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORTSCENCANCHO3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORENCANCHO3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LIENCANCHO3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LSENCANCHO3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORTSCENCLARGO3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORENCLARGO3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LIENCLARGO3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LSENCLARGO3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORTSCREV3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORREV3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LIREV3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LSREV3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORTSCINCACA3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORINCACA3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LIINCACA3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LSINCACA3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORTSCINCLAV3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].VALORINCLAV3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LIINCLAV3+'</div>'+
					'<div class="itemBody2" style="width: 90px;">'+data.detalle[i].LSINCLAV3+'</div>'+
				'</div>';
			}


			processGraph(labels,valortsc,valor,li,ls,'-den1',maxval,minval,kilospartida);
			processGraph(labels,valortscanc,valoranc,lianc,lsanc,'-anc1',maxvalanc,minvalanc,kilospartida);
			processGraph(labels,gra31,gra32,gra33,gra34,'-gra3',maxvalgra3,minvalgra3);
			processGraph(labels,gra41,gra42,gra43,gra44,'-gra4',maxvalgra4,minvalgra4);
			processGraph(labels,gra51,gra52,gra53,gra54,'-gra5',maxvalgra5,minvalgra5);
			processGraph(labels,gra61,gra62,gra63,gra64,'-gra6',maxvalgra6,minvalgra6);
			processGraph(labels,gra71,gra72,gra73,gra74,'-gra7',maxvalgra7,minvalgra7);


			// AGREGADO

			// VALORES MAXIMOS Y MINIMOS DE LOS ARRAYS
			let arrayg1 = lianchodespues.concat(valortscanchodespues).concat(valortanchodespues).concat(lsanchodespues);
			let arrayg2 = lianchodespues.concat(valortscanchodespues).concat(valortanchodespues).concat(lsanchodespues);

			let max1 = Math.max(...arrayg1);
			let max2 = Math.max(...arrayg2);

			let min1 = Math.min(...arrayg1);
			let min2 = Math.min(...arrayg2);

			let max3 = Math.max(...[max1,max2]);
			let min3 = Math.min(...[min1,min2]);

			// VALORES MAXIMOS Y MINIMOS DE LOS ARRAYS

			// VALORES MAXIMOS Y MINIMOS DE LOS ARRAYS
			let arraygd1 = lidensidaddespues.concat(valortscdensidaddespues).concat(valortdensidaddespues).concat(lsdensidaddespues);
			let arraygd2 = lidensidaddespues.concat(valortscdensidaddespues).concat(valortdensidaddespues).concat(lsdensidaddespues);

			let max1d = Math.max(...arraygd1);
			let max2d = Math.max(...arraygd2);

			let min1d = Math.min(...arraygd1);
			let min2d = Math.min(...arraygd2);

			let max3d = Math.max(...[max1d,max2d]);
			let min3d = Math.min(...[min1d,min2d]);



			processGraph(labels,valortscanchodespues,valortanchodespues,lianchodespues,lsanchodespues,'-anc2',max3,min3);
			processGraph(labels,valortscdensidaddespues,valortdensidaddespues,lidensidaddespues,lsdensidaddespues,'-den2',max3d,min3d);


			$("#idTblBody").empty();
			$("#idTblBody").append(html);

			$(".panelCarga").fadeOut(200);
		},
	    error: function (jqXHR, exception) {
	        var msg = '';
	        if (jqXHR.status === 0) {
	            msg = 'Sin conexión.\nVerifique su conexión a internet!';
	        } else if (jqXHR.status == 404) {
	            msg = 'No se encuentra el archivo necesario para guardar la inspección!';
	        } else if (jqXHR.status == 500) {
	            msg = 'Servidor no disponible (Web de TSC). Intente más tarde';
	        } else if (exception === 'parsererror') {
	            msg = 'La respuesta tiene errores. Por favor, contactar al equipo de desarrollo!';
	        } else if (exception === 'timeout') {
	            msg = 'Tiempo de respuesta muy largo (Web de TSC)!';
	        } else if (exception === 'abort') {
	            msg = 'Se cancelo la consulta!';
	        } else {
	            msg = 'Error desconocido.\n' + jqXHR.responseText+'.\nInforme al equipo de desarrollo!';
	        }
	        alert(msg);
			$(".panelCarga").fadeOut(100);
	    }
	});
}