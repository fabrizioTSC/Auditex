var titulo_var="";
$(document).ready(function(){
	$.ajax({
		type:"POST",
		data:{
			anio:anio,
			mes:mes,
			semana:semana,
			fecini:fecini,
			fecfin:fecfin,
			option:option,
			codtipser:codtipser,
			codsede:codsede
		},
		url:"config/getInfoRepRanLinea.php",
		success:function(data){
			console.log(data);
			var ar_lab=[];
			var ar_val=[];
			if (option=="1") {
				$("#spacetitulo").text(data.titulo+proceMesLarge(mes));	
			}else{
				$("#spacetitulo").text(data.titulo);
			}

			var fontSize=10;
			var tamLabel=20;
			if (window.innerWidth<380) {
				fontSize=8;
				tamLabel=16;
			}

			var html='';
			for (var i = 0; i < data.talleres.length; i++) {
				var por=formatPercent(data.talleres[i].PORCENTAJE);
				html+='<div class="body-line">'+
						'<div class="body" style="width: 40px">'+(i+1)+'</div>'+
						'<div class="body" style="width: 180px">'+data.talleres[i].DESCOM+'</div>'+
						'<div class="body" style="width: 180px">'+data.talleres[i].DESTLL+'</div>'+
						'<div class="body" style="width: 100px">'+data.talleres[i].DESSEDE+'</div>'+
						'<div class="body" style="width: 100px">'+data.talleres[i].DESTIPSERV+'</div>'+
						'<div class="body" style="width: 60px">'+por+' %</div>'+
						'<div class="body" style="width: 70px">'+data.talleres[i].AUD_TOT+'</div>'+
						'<div class="body" style="width: 70px">'+data.talleres[i].AUD_REC+'</div>'+
					'</div>';
				if (i<10) {
					//ar_lab.push("Tal. "+(i+1));
					ar_lab.push(validateLength(data.talleres[i].DESCOM,tamLabel));
					ar_val.push(por);
				}
			}
			$("#placeResult").empty();
			$("#placeResult").append(html);

			var chartData = {
				labels: ar_lab,
				datasets: [{
					type: 'bar',
					backgroundColor:window.chartColors.reddark,
					data: ar_val
				}]
			};
			var ctx = document.getElementById('chart-area1').getContext('2d');
			window.myMixedChart = new Chart(ctx, {
				type: 'bar',
				data: chartData,
				options: {
					responsive: true,
					legend: {
						display:false
					},
					tooltips: {
						mode: 'index',
						intersect: true
					},
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true
							},
			                ticks: {
			                    autoSkip: false,
			                    maxRotation: 90,
			                    minRotation: 80,
                				fontSize: fontSize
			                }
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: false
							},
							ticks: {
								suggestedMin: 0,
								suggestedMax: 100
							}
						}]
					},
					title: {
						display: true,
						text: 'TOP 10 - Líneas con mayor porcentaje de rechazo'
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
		                    	if (dataset.type=="bar") {
			                        var meta = chartInstance.controller.getDatasetMeta(i);
			                        meta.data.forEach(function (bar, index) {
			                            var data = Math.round(dataset.data[index]*100)/100+"%";
			                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
			                        });
			                    }
		                    });

		                }
		            }
				}
			});
			$(".panelCarga").fadeOut(100);
		}
	});
});

function formatPercent(val){
	val=parseFloat(val.replace(",","."));
	val=Math.round(val*10000)/100;
	return val;
}

function exportarRanking(){
	window.location.href="config/exports/exportReportRankinLinea.php?codsede="+codsede+"&codtipser="+codtipser+
		"&anio="+anio+"&mes="+mes+"&semana="+semana+"&fecini="+fecini+"&fecfin="+fecfin+"&titulo="+$("#spacetitulo").text()+"&option="+option;
}