var param_codran1=0;
var param_codran2=0;
$(document).ready(function(){
	$.ajax({
		type:"POST",
		data:{
			codtll:codtll,
			codtipser:codtipser,
			codsede:codsede,
			coddef:coddef
		},
		url:"config/getInfoIndDefXCod.php",
		success:function(data){
			console.log(data);
			$("#titulodetalle").append(titulo);
			$("#idDesDef").text(desdef.toUpperCase());
			param_codran2=parseInt(data.param[0].VALOR);
			param_codran1=parseInt(data.param[1].VALOR);

			var colors=[];
			var labels=[];
			var totdef=[];
			for (var i = 0; i < data.anios.length; i++) {
				colors.push('#1f71c5');
				labels.push(data.anios[i]['ANHO']);
				totdef.push(data.anios[i]['SUMDEF']);
			}
			for (var i = 0; i < data.meses.length; i++) {
				colors.push('#46c711');
				labels.push(proceMes(data.meses[i]['MES']));
				totdef.push(data.meses[i]['SUMDEF']);
			}
			for (var i = 0; i < data.semanas.length; i++) {
				colors.push('#ead431');
				labels.push("S. "+data.semanas[i]['SEMANA']);
				totdef.push(data.semanas[i]['SUMDEF']);
			}
			processGraph(labels,totdef,colors);
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

function processGraph(ar_lab,ar_apr,ar_color){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'bar',
			label: 'Total defectos',
			backgroundColor:ar_color,
			data: ar_apr
		}]
	};
	var wWin=window.innerWidth;
	var dBorder=true;
	var stepTicks=5;
	if (wWin<600) {
		dBorder=false;
		stepTicks=20;
	}
	var ctx = document.getElementById('chart-area').getContext('2d');
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
					display: true,
					scaleLabel: {
						display: false
					},
					gridLines: {
						display: dBorder,
						drawBorder: true,
						//color: ['none','rgb(50,200,50)','yellow','none']
					},
					ticks: {
						suggestedMin: 0,
						suggestedMax: 100
					}/*,
					afterBuildTicks: function(humdaysChart) {
					    humdaysChart.ticks = [];
					    humdaysChart.ticks.push(0);
					    humdaysChart.ticks.push(param_codran1);
					    humdaysChart.ticks.push(param_codran2);
					    humdaysChart.ticks.push(100);
					}*/
				}]
			},
			animation: {
                duration: 1,
                onComplete: function () {
                    var chartInstance = this.chart,
                    ctx = chartInstance.ctx;
                    ctx.fillStyle = "rgba(0, 0, 0, 1)";
			        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
			        ctx.textAlign = 'center';
			        ctx.textBaseline = 'bottom';

                    this.data.datasets.forEach(function (dataset, i) {
                    	//if (dataset.type=="bar") {
	                        var meta = chartInstance.controller.getDatasetMeta(i);
	                        meta.data.forEach(function (bar, index) {
	                            var data = Math.round(dataset.data[index]);//+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });
	                    //}
                    });

                }
            }
		}
	});
}

function downloadPDF(){
	$.ajax({
	  	type: "POST",
	  	url: "config/saveTmpImg.php",
	  	data: { 
	    	imgBase64: document.getElementById("chart-area").toDataURL("image/png"),
	    	img2: document.getElementById("chart-area2").toDataURL("image/png"),
	    	img3: document.getElementById("chart-area2-mes").toDataURL("image/png"),
	    	img4: document.getElementById("chart-area3").toDataURL("image/png"),
	    	img5: document.getElementById("chart-area4").toDataURL("image/png"),
	    	img6: document.getElementById("chart-area3-mes").toDataURL("image/png"),
	    	img7: document.getElementById("chart-area4-mes").toDataURL("image/png"),
			codtll:codtll,
			codtipser:codtipser,
			codsede:codsede,
			codusu:codusu
	  	},
	  	success:function(data){
	  		var title=$("#titulodetalle").text();
	  		var t2=$("#titParUno").text();
	  		var t3=$("#titParUno-Mes").text();
	  		var t4=$("#titParDos").text();
	  		var t4_1=$("#defPosUno").text();
	  		var t4_2=$("#defPosDos").text();
	  		var t5=$("#titParDos-Mes").text();
	  		var t5_1=$("#defPosUno-Mes").text();
	  		var t5_2=$("#defPosDos-Mes").text();
	  		var a=document.createElement("a");
	  		a.target="_blank";
	  		a.href="fpdf/crearPdf.php?n="+data+
	  		"&t="+title+"&t2="+t2+"&t3="+t3+"&t4="+t4+"&t4_1="+t4_1+"&t4_2="+t4_2+"&t5="+t5+"&t5_1="+t5_1+"&t5_2="+t5_2+
	  		"&ct="+codtll+"&cts="+codtipser+"&cs="+codsede+"&fecha="+fecha;
	  		a.click();
	  	}
	}).done(function(o) {
	  	console.log('Images Saved!'); 
	});
}

function back_page(){
	window.history.back();
}