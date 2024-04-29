$(document).ready(function(){
	$.ajax({
		type:"POST",
		data:{
			codtll:codtll,
			codtipser:codtipser,
			codsede:codsede
		},
		url:"config/getInfoRepAudPro.php",
		success:function(data){
			console.log(data);
			var labels=[];
			var rechazado=[];
			var aprobado=[];
			var colors=[];
			var html='';
			$("#titulodetalle").append(data.titulo);
			for (var i = 0; i < data.anios.length; i++) {
				var PorPreApro=Math.round(data.anios[i]['PREN_APR']*10000/data.anios[i]['PREN_TOT'])/100;
				var styleC="colorB";
				var color=window.chartColors.yellow;
				var colorbox=window.colorsBox.yellow;
				if (PorPreApro>=95) {
					styleC="colorA";
					color=window.chartColors.green;
					colorbox=colorsBox.green;
				}else{
					if (PorPreApro<85) {
						styleC="colorC";
						color=window.chartColors.reddark;
						colorbox=colorsBox.red;
					}
				}			
				html+=
				'<div class="divanios['+i+']">'+
					'<div class="itemhs1">'+data.anios[i]['ANHO']+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['PREN_APR'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['PREN_REC'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['PREN_TOT'])+'</div>'+
					'<div class="itemhs1 items4" style="background:'+colorbox+';">'+PorPreApro+'%</div>'+
					'<div class="itemhs1 items4">'+Math.round((100-PorPreApro)*100)/100+'%</div>'+
				'</div>';
				colors.push(color);
				labels.push(data.anios[i]['ANHO']);
				rechazado.push(Math.round((100-PorPreApro)*100)/100);
				aprobado.push(PorPreApro);
			}
			$("#placeAnios").append(html);

			html='';
			for (var i = 0; i < data.meses.length; i++) {
				var PorPreApro=Math.round(data.meses[i]['PREN_APR']*10000/data.meses[i]['PREN_TOT'])/100;
				var styleC="colorB";
				var color=window.chartColors.yellow;
				var colorbox=window.colorsBox.yellow;
				if (PorPreApro>=95) {
					styleC="colorA";
					color=window.chartColors.green;
					colorbox=colorsBox.green;
				}else{
					if (PorPreApro<85) {
						styleC="colorC";
						color=window.chartColors.reddark;
						colorbox=colorsBox.red;
					}
				}			
				html+=
				'<div class="divanios['+i+']">'+
					'<div class="itemhs1">'+proceMes(data.meses[i]['ANHOMES'].substr(4,5))+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['PREN_APR'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['PREN_REC'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['PREN_TOT'])+'</div>'+
					'<div class="itemhs1 items4" style="background:'+colorbox+';">'+PorPreApro+'%</div>'+
					'<div class="itemhs1 items4">'+Math.round((100-PorPreApro)*100)/100+'%</div>'+
				'</div>';
				colors.push(color);
				labels.push(proceMes(data.meses[i]['ANHOMES'].substr(4,5)));
				rechazado.push(Math.round((100-PorPreApro)*100)/100);
				aprobado.push(PorPreApro);
			}
			$("#placeMeses").append(html);

			html='';
			var numSem=0;
			for (var i = 0; i < data.semanas.length; i++) {
				var PorPreApro=Math.round(data.semanas[i]['PREN_APR']*10000/data.semanas[i]['PREN_TOT'])/100;
				var styleC="colorB";
				var color=window.chartColors.yellow;
				var colorbox=window.colorsBox.yellow;
				if (PorPreApro>=95) {
					styleC="colorA";
					color=window.chartColors.green;
					colorbox=colorsBox.green;
				}else{
					if (PorPreApro<85) {
						styleC="colorC";
						color=window.chartColors.reddark;
						colorbox=colorsBox.red;
					}
				}			
				html+=
				'<div class="divanios['+i+']">'+
					'<div class="itemhs1">S. '+data.semanas[i]['NUMERO_SEMANA']+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['PREN_APR'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['PREN_REC'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['PREN_TOT'])+'</div>'+
					'<div class="itemhs1 items4" style="background:'+colorbox+';">'+PorPreApro+'%</div>'+
					'<div class="itemhs1 items4">'+Math.round((100-PorPreApro)*100)/100+'%</div>'+
				'</div>';
				colors.push(color);
				labels.push("S. "+data.semanas[i]['NUMERO_SEMANA']);
				rechazado.push(Math.round((100-PorPreApro)*100)/100);
				aprobado.push(PorPreApro);
				if (data.semanas.length-1==i) {
					numSem=data.semanas[i]['NUMERO_SEMANA'];
				}
			}
			$("#placeSemanas").append(html);
			processGraph(labels,rechazado,aprobado,colors);

			var fecha=new Date();

			var defLbl=[];
			var defCan=[];
			var html="";
			var sumTot=0;
			//$("#tit-uno").text(data.anios[data.anios.length-1]['ANHO']+" - Semana "+data.semanas[data.semanas.length-1]['NUMERO_SEMANA']);
			$("#tit-uno").text(fecha.getFullYear()+" - Semana "+data.numSem);
			for (var i = 0; i < data.detSem.length; i++) {
				html+=
				'<div class="lineBody">'+
					'<div class="itemhs1 items4" style="width: 60px;text-align:center;">'+(i+1)+'</div>'+
					'<div class="itemhs1 items4" style="width: 120px;text-align:left;">'+data.detSem[i]['DESDEF']+'</div>'+
					'<div class="itemhs1 items4" style="width: 80px;">'+formatNumber(data.detSem[i]['CANDEF'])+'</div>'+
				'</div>';
				sumTot+=parseInt(data.detSem[i]['CANDEF']);
				if (i<10) {
					defLbl.push(data.detSem[i]['DESDEF']);		
					defCan.push(data.detSem[i]['CANDEF']);
				}
			}
			$("#idDefSem").append(html);
			processGraphDefecto(defLbl,defCan,'area2',sumTot);

			var defLbl=[];
			var defCan=[];
			var html="";
			var sumTot=0;
			var mes=(fecha.getMonth()+1)+"";
			if (mes.length==1) {
				mes="0"+mes;
			}
			//$("#tit-dos").text(data.anios[data.anios.length-1]['ANHO']+" - "+proceMesLarge(data.meses[i]['ANHOMES'].substr(4,5)));
			$("#tit-dos").text(fecha.getFullYear()+" - "+proceMesLarge(mes));
			for (var i = 0; i < data.detMes.length; i++) {
				html+=
				'<div class="lineBody">'+
					'<div class="itemhs1 items4" style="width: 60px;text-align:center;">'+(i+1)+'</div>'+
					'<div class="itemhs1 items4" style="width: 120px;text-align:left;">'+data.detMes[i]['DESDEF']+'</div>'+
					'<div class="itemhs1 items4" style="width: 80px;">'+formatNumber(data.detMes[i]['CANDEF'])+'</div>'+
				'</div>';		
				sumTot+=parseInt(data.detMes[i]['CANDEF']);
				if (i<10) {
					defLbl.push(data.detMes[i]['DESDEF']);		
					defCan.push(data.detMes[i]['CANDEF']);
				}
			}
			$("#idDefMes").append(html);
			processGraphDefecto(defLbl,defCan,'area3',sumTot);
			$(".panelCarga").fadeOut(200);
		}
	});
});

window.arrayColor=['rgb(255,150,60)','rgb(240,200,160)'];

function processGraph(ar_lab,ar_rec,ar_apr,ar_color){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'line',
			label: 'Pre. Rechazadas',
			borderColor: window.chartColors.black,
			borderWidth: 2,
			fill: false,
			data: ar_rec,
			lineTension: 0
		}, {
			type: 'bar',
			label: 'Pre. Aprobadas',
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
						drawBorder: false,
						color: ['none', 'rgb(50,200,50)', 'none','yellow', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none', 'none']
					},
					ticks: {
						suggestedMin: 0,
						suggestedMax: 100,
						stepSize: stepTicks
					}
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
	                            var data = Math.round(dataset.data[index])+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });
	                    //}
                    });

                }
            }
		}
	});
}

function processGraphDefecto(ar_lab,ar_defCan,area,sumTot){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'bar',
			backgroundColor: arrayColor[0],
			label: 'Frecuencia',
			yAxisID: 'y-axis-1',
			data: ar_defCan
		}]
	};
	var ctx = document.getElementById('chart-'+area).getContext('2d');
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
					position: 'left',
					id: 'y-axis-1',
					ticks: {
						suggestedMin: 0
					}
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
                        var meta = chartInstance.controller.getDatasetMeta(i);
                        meta.data.forEach(function (bar, index) {
                            var data = Math.round(dataset.data[index]*100/sumTot)+"%";
                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
                        });
                    });
                }
            }
		}
	});
}