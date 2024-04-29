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
			option:option
		},
		url:"config/getInfoRepRanDefectos.php",
		success:function(data){
			console.log(data);
			var ar_lab=[];
			var ar_val=[];
			var ar_ins=[];
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

			var maxdef=0;

			var html='';
			for (var i = 0; i < data.talleres.length; i++) {
				html+='<div class="body-line">'+
						'<div class="body" style="width: 40px">'+(i+1)+'</div>'+
						'<div class="body" style="width: calc(20% - 18px);">'+data.talleres[i].LINEA+'</div>'+
						'<div class="body" style="width: calc(20% - 18px);">'+data.talleres[i].TURNO+'</div>'+
						'<div class="body" style="width: calc(20% - 18px);">'+data.talleres[i].PRE_DEF+'</div>'+
						'<div class="body" style="width: calc(20% - 18px);">'+data.talleres[i].PRE_INS+'</div>'+
						'<div class="body" style="width: calc(20% - 18px);">'+Math.round(data.talleres[i].POR_DEF*1000)/10+'%</div>'+
					'</div>';
					ar_lab.push(data.talleres[i].LINEA+" - "+data.talleres[i].TURNO);
					ar_val.push(data.talleres[i].PRE_DEF);
					if (data.talleres[i].PRE_DEF) {
						maxdef=data.talleres[i].PRE_DEF;
					}
					ar_ins.push(Math.round(data.talleres[i].POR_DEF*1000)/10);
			}
			$("#placeResult").empty();
			$("#placeResult").append(html);

			var chartData = {
				labels: ar_lab,
				datasets: [{
					type: 'line',
					backgroundColor:window.chartColors.black,
					data: ar_val,
					fill:false,
					label: 'Pre. Defectuosas',
					yAxisID: 'y-axis-1',
					borderWidth: 4,
					lineTension: 0
				},{
					type: 'bar',
					backgroundColor:window.chartColors.reddark,
					data: ar_ins,
					label: '% pre. def.',
					yAxisID: 'y-axis-2'
				}]
			};
			var ctx = document.getElementById('chart-area1').getContext('2d');
			window.myMixedChart = new Chart(ctx, {
				type: 'bar',
				data: chartData,
				options: {
					responsive: true,
					legend: {
						display:true
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
							}
						}],/*
						yAxes: [{
							display: true,
							scaleLabel: {
								display: false
							},
							ticks: {
								suggestedMin: 0,
								suggestedMax: 100
							}
						}],*/
						yAxes: [{
							type: 'linear',
							display: true,
							position: 'right',
							id: 'y-axis-1',
							ticks: {
								suggestedMin: 0,
								suggestedMax: maxdef
							}
						},{
							type: 'linear',
							display: true,
							position: 'left',
							id: 'y-axis-2',
							ticks: {
								suggestedMin: 0
							}
						}]
					},
					legend:{
						labels:{
							usePointStyle: true
						}
					},
					title: {
						display: true,
						text: 'Porcentaje de prendas defectuosas por Línea – Turno'
					}/*,
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
		            }*/
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