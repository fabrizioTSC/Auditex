var param_codran1=0;
var param_codran2=0;
$(document).ready(function(){
	$.ajax({
		type:"POST",
		data:{
			codtll:codtll,
			codtipser:codtipser,
			codsede:codsede,
			fecha:fecha
		},
		url:"config/getInfoIndicadores.php",
		success:function(data){
			console.log(data);
			if(data.anios.length!=0){
				var labels=[];
				var rechazado=[];
				var aprobado=[];
				var colors=[];
				var html='';
				param_codran2=parseInt(data.param[0].VALOR);
				param_codran1=parseInt(data.param[1].VALOR);
				$("#titulodetalle").append(data.titulo);
				for (var i = 0; i < data.anios.length; i++) {		
					var PorPreApro=Math.round(data.anios[i]['PRE_SINDEF']*10000/data.anios[i]['PRE_TOT'])/100;
					var styleC="colorB";
					var color=window.chartColors.yellow;
					if (PorPreApro>=param_codran1) {
						styleC="colorA";
						color=window.chartColors.green;
					}else{
						if (PorPreApro<param_codran2) {
							styleC="colorC";
							color=window.chartColors.reddark;
						}
					}
					html+=
					'<div class="divanios[i]">'+
						'<div class="itemhs1">'+data.anios[i]['ANHO']+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['PRE_SINDEF'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['PRE_DEF'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['PRE_TOT'])+'</div>'+
						'<div class="itemhs1 items4 '+styleC+'">'+PorPreApro+'%</div>'+
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
					var PorPreApro=Math.round(data.meses[i]['PRE_SINDEF']*10000/data.meses[i]['PRE_TOT'])/100;
					var styleC="colorB";
					var color=window.chartColors.yellow;
					if (PorPreApro>=param_codran1) {
						styleC="colorA";
						color=window.chartColors.green;
					}else{
						if (PorPreApro<param_codran2) {
							styleC="colorC";
							color=window.chartColors.reddark;
						}
					}
					html+=
					'<div class="divanios[i]">'+
						'<div class="itemhs1">'+proceMes(data.meses[i]['MES'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['PRE_SINDEF'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['PRE_DEF'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['PRE_TOT'])+'</div>'+
						'<div class="itemhs1 items4 '+styleC+'">'+PorPreApro+'%</div>'+
						'<div class="itemhs1 items4">'+Math.round((100-PorPreApro)*100)/100+'%</div>'+
					'</div>';
					colors.push(color);
					labels.push(proceMes(data.meses[i]['MES']));
					rechazado.push(Math.round((100-PorPreApro)*100)/100);
					aprobado.push(PorPreApro);
				}
				$("#placeMeses").append(html);

				html='';
				var numSem=0;
				for (var i = 0; i < data.semanas.length; i++) {	
					var PorPreApro=Math.round(data.semanas[i]['PRE_SINDEF']*10000/data.semanas[i]['PRE_TOT'])/100;
					var styleC="colorB";
					var color=window.chartColors.yellow;
					if (PorPreApro>=param_codran1) {
						styleC="colorA";
						color=window.chartColors.green;
					}else{
						if (PorPreApro<param_codran2) {
							styleC="colorC";
							color=window.chartColors.reddark;
						}
					}
					html+=
					'<div class="divanios[i]">'+
						'<div class="itemhs1">S. '+data.semanas[i]['NUMERO_SEMANA']+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['PRE_SINDEF'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['PRE_DEF'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['PRE_TOT'])+'</div>'+
						'<div class="itemhs1 items4 '+styleC+'">'+PorPreApro+'%</div>'+
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

				$("#titParUno").text(data.anios[data.anios.length-1]['ANHO']+" - Semana "+numSem);
				$("#titParDos").text(data.anios[data.anios.length-1]['ANHO']+" - Semana "+numSem);
				$("#titParUno-Mes").text(data.anios[data.anios.length-1]['ANHO']+" - "+proceMesLarge(data.meses[data.meses.length-1]['MES']));
				$("#titParDos-Mes").text(data.anios[data.anios.length-1]['ANHO']+" - "+proceMesLarge(data.meses[data.meses.length-1]['MES']));

				var defLbl=[];
				var defCan=[];
				var defPor=[];
				var defColor=[];
				html='';
				var sumPor=0;
				var pos=0;
				for (var i = 0; i < data.defuno.length; i++) {
					var por1=0;
					if (i!=data.defuno.length-1) {
						por1=Math.round(data.defuno[i]['SUMA']*10000/data.sumDU)/100;
						sumPor+=Math.round(por1*100)/100;
					}else{
						por1=Math.round((100-sumPor)*100)/100;
						sumPor=100;
					}
					if (i==0) {
						$("#defPosUno").text(data.defuno[i]['DSCFAMILIA']);
					}
					if (i==1) {
						$("#defPosDos").text(data.defuno[i]['DSCFAMILIA']);
					}
					html+=
					'<div class="lineBody">'+
						'<div class="itemhs1 items4" style="width: 120px;text-align:left;">'+(i+1)+'. '+data.defuno[i]['DSCFAMILIA']+'</div>'+
						'<div class="itemhs1 items4" style="width: 80px;">'+formatNumber(data.defuno[i]['SUMA'])+'</div>'+
						'<div class="itemhs1 items4" style="width: 40px;">'+por1+'%</div>'+
						'<div class="itemhs1 items4" style="width: 90px;">'+Math.round(sumPor*100)/100+'%</div>'+
					'</div>';		
					defLbl.push(data.defuno[i]['DSCFAMILIA']);		
					defCan.push(data.defuno[i]['SUMA']);
					defPor.push(Math.round(sumPor*100)/100);
					defColor.push(window.arrayColor[pos]);
					if (sumPor>80) {
						pos=1;
					}
				}
				sumTotSem=data.sumDU;
				processGraph2(defLbl,defCan,defPor,defColor);
				$("#idDefUno").append(html);

				//Grafico - Tabla nivel 1 - Mes
				var defLbl=[];
				var defCan=[];
				var defPor=[];
				var defColor=[];
				html='';
				var sumPor=0;
				var pos=0;
				for (var i = 0; i < data.defunomes.length; i++) {
					var por1=0;
					if (i!=data.defunomes.length-1) {
						por1=Math.round(data.defunomes[i]['SUMA']*10000/data.sumDUM)/100;
						sumPor+=Math.round(por1*100)/100;
					}else{
						por1=Math.round((100-sumPor)*100)/100;
						sumPor=100;
					}
					if (i==0) {
						$("#defPosUno-Mes").text(data.defunomes[i]['DSCFAMILIA']);
					}
					if (i==1) {
						$("#defPosDos-Mes").text(data.defunomes[i]['DSCFAMILIA']);
					}
					html+=
					'<div class="lineBody">'+
						'<div class="itemhs1 items4" style="width: 120px;text-align:left;">'+(i+1)+'. '+data.defunomes[i]['DSCFAMILIA']+'</div>'+
						'<div class="itemhs1 items4" style="width: 80px;">'+formatNumber(data.defunomes[i]['SUMA'])+'</div>'+
						'<div class="itemhs1 items4" style="width: 40px;">'+por1+'%</div>'+
						'<div class="itemhs1 items4" style="width: 90px;">'+Math.round(sumPor*100)/100+'%</div>'+
					'</div>';		
					defLbl.push(data.defunomes[i]['DSCFAMILIA']);		
					defCan.push(data.defunomes[i]['SUMA']);
					defPor.push(Math.round(sumPor*100)/100);
					defColor.push(window.arrayColor[pos]);
					if (sumPor>80) {
						pos=1;
					}
				}
				sumTotMes=data.sumDUM;
				processGraph2Mes(defLbl,defCan,defPor,defColor);
				$("#idDefUno-Mes").append(html);

				sumTotUSem=data.sumDefectosU;
				sumTotDSem=data.sumDefectosD;
				sumTotUMes=data.sumDefectosUM;
				sumTotDMes=data.sumDefectosDM;

				var defLbl=[];
				var defCan=[];
				var defPor=[];
				var defColor=[];
				html='';
				var sumPor=0;
				var pos=0;
				for (var i = 0; i < data.defectosU.length; i++) {
					var por1=0;
					if (i!=data.defectosU.length-1) {
						por1=Math.round(data.defectosU[i]['SUMA']*10000/data.sumDefectosU)/100;
						sumPor+=por1;
					}else{
						por1=Math.round((100-sumPor)*100)/100;
						sumPor=100;
					}
					if(sumPor>100){
						sumPor=100;
					}
					html+=
					'<div class="lineBody">'+
						'<div class="itemhs1 items4" style="width: 120px;text-align:left;">'+(i+1)+'. '+data.defectosU[i]['DESDEF']+'</div>'+
						'<div class="itemhs1 items4" style="width: 80px;">'+formatNumber(data.defectosU[i]['SUMA'])+'</div>'+
						'<div class="itemhs1 items4" style="width: 40px;">'+por1+'%</div>'+
						'<div class="itemhs1 items4" style="width: 90px;">'+Math.round(sumPor*100)/100+'%</div>'+
						'<div class="itemhs1 items3" style="width: 50px; background:transparent;border-color:transparent;"></div>'+
						'<div class="itemhs1 items4 itemSpecial" style="width: 100px;">'+Math.round(data.defectosU[i]['SUMA']*10000/data.sumDU)/100+'%</div>'+
					'</div>';		
					defLbl.push(data.defectosU[i]['DESDEF']);		
					defCan.push(data.defectosU[i]['SUMA']);
					defPor.push(Math.round(sumPor*100)/100);
					defColor.push(window.arrayColor[pos]);
					if (sumPor>80) {
						pos=1;
					}
				}
				processGraph3(defLbl,defCan,defPor,defColor);
				$("#idDefectoUno").append(html);

				var defLbl=[];
				var defCan=[];
				var defPor=[];
				var defColor=[];
				html='';
				var sumPor=0;
				var pos=0;
				for (var i = 0; i < data.defectosD.length; i++) {
					var por1=0;
					if (i!=data.defectosD.length-1) {
						por1=Math.round(data.defectosD[i]['SUMA']*10000/data.sumDefectosD)/100;
						sumPor+=por1;
					}else{
						por1=Math.round((100-sumPor)*100)/100;
						sumPor=100;
					}
					if(sumPor>100){
						sumPor=100;
					}
					html+=
					'<div class="lineBody">'+
						'<div class="itemhs1 items4" style="width: 120px;text-align:left;">'+(i+1)+'. '+data.defectosD[i]['DESDEF']+'</div>'+
						'<div class="itemhs1 items4" style="width: 80px;">'+formatNumber(data.defectosD[i]['SUMA'])+'</div>'+
						'<div class="itemhs1 items4" style="width: 40px;">'+por1+'%</div>'+
						'<div class="itemhs1 items4" style="width: 90px;">'+Math.round(sumPor*100)/100+'%</div>'+
						'<div class="itemhs1 items3" style="width: 50px; background:transparent;border-color:transparent;"></div>'+
						'<div class="itemhs1 items4 itemSpecial" style="width: 100px;">'+Math.round(data.defectosD[i]['SUMA']*10000/data.sumDU)/100+'%</div>'+
					'</div>';		
					defLbl.push(data.defectosD[i]['DESDEF']);		
					defCan.push(data.defectosD[i]['SUMA']);
					defPor.push(Math.round(sumPor*100)/100);
					defColor.push(window.arrayColor[pos]);
					if (sumPor>80) {
						pos=1;
					}
				}
				processGraph4(defLbl,defCan,defPor,defColor);
				$("#idDefectoDos").append(html);

				var defLbl=[];
				var defCan=[];
				var defPor=[];
				var defColor=[];
				html='';
				var sumPor=0;
				var pos=0;
				for (var i = 0; i < data.defectosUM.length; i++) {
					var por1=0;
					if (i!=data.defectosUM.length-1) {
						por1=Math.round(data.defectosUM[i]['SUMA']*10000/data.sumDefectosUM)/100;
						sumPor+=por1;
					}else{
						por1=Math.round((100-sumPor)*100)/100;
						sumPor=100;
					}
					if(sumPor>100){
						sumPor=100;
					}
					html+=
					'<div class="lineBody">'+
						'<div class="itemhs1 items4" style="width: 120px;text-align:left;">'+(i+1)+'. '+data.defectosUM[i]['DESDEF']+'</div>'+
						'<div class="itemhs1 items4" style="width: 80px;">'+formatNumber(data.defectosUM[i]['SUMA'])+'</div>'+
						'<div class="itemhs1 items4" style="width: 40px;">'+por1+'%</div>'+
						'<div class="itemhs1 items4" style="width: 90px;">'+Math.round(sumPor*100)/100+'%</div>'+
						'<div class="itemhs1 items3" style="width: 50px; background:transparent;border-color:transparent;"></div>'+
						'<div class="itemhs1 items4 itemSpecial" style="width: 100px;">'+Math.round(data.defectosUM[i]['SUMA']*10000/data.sumDUM)/100+'%</div>'+
					'</div>';		
					defLbl.push(data.defectosUM[i]['DESDEF']);		
					defCan.push(data.defectosUM[i]['SUMA']);
					defPor.push(Math.round(sumPor*100)/100);
					defColor.push(window.arrayColor[pos]);
					if (sumPor>80) {
						pos=1;
					}
				}
				processGraph3Mes(defLbl,defCan,defPor,defColor);
				$("#idDefectoUno-Mes").append(html);

				var defLbl=[];
				var defCan=[];
				var defPor=[];
				var defColor=[];
				html='';
				var sumPor=0;
				var pos=0;
				for (var i = 0; i < data.defectosDM.length; i++) {
					var por1=0;
					if (i!=data.defectosDM.length-1) {
						por1=Math.round(data.defectosDM[i]['SUMA']*10000/data.sumDefectosDM)/100;
						sumPor+=por1;
					}else{
						por1=Math.round((100-sumPor)*100)/100;
						sumPor=100;
					}
					if(sumPor>100){
						sumPor=100;
					}
					html+=
					'<div class="lineBody">'+
						'<div class="itemhs1 items4" style="width: 120px;text-align:left;">'+(i+1)+'. '+data.defectosDM[i]['DESDEF']+'</div>'+
						'<div class="itemhs1 items4" style="width: 80px;">'+formatNumber(data.defectosDM[i]['SUMA'])+'</div>'+
						'<div class="itemhs1 items4" style="width: 40px;">'+por1+'%</div>'+
						'<div class="itemhs1 items4" style="width: 90px;">'+Math.round(sumPor*100)/100+'%</div>'+
						'<div class="itemhs1 items3" style="width: 50px; background:transparent;border-color:transparent;"></div>'+
						'<div class="itemhs1 items4 itemSpecial" style="width: 100px;">'+Math.round(data.defectosDM[i]['SUMA']*10000/data.sumDUM)/100+'%</div>'+
					'</div>';		
					defLbl.push(data.defectosDM[i]['DESDEF']);		
					defCan.push(data.defectosDM[i]['SUMA']);
					defPor.push(Math.round(sumPor*100)/100);
					defColor.push(window.arrayColor[pos]);
					if (sumPor>80) {
						pos=1;
					}
				}
				processGraph4Mes(defLbl,defCan,defPor,defColor);
				$("#idDefectoDos-Mes").append(html);
			}else{
				alert("No hay informacion para el reporte!");
			}
			$(".panelCarga").fadeOut(200);
		}
	});
});
var sumTotSem=0;
var sumTotMes=0;
var sumTotUSem=0;
var sumTotUMes=0;
var sumTotDSem=0;
var sumTotDMes=0;

window.arrayColor=['rgb(255,150,60)','rgb(240,200,160)'];

function processGraph(ar_lab,ar_rec,ar_apr,ar_color){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'line',
			label: 'Aud. rechazadas',
			borderColor: window.chartColors.black,
			borderWidth: 2,
			fill: false,
			data: ar_rec,
			lineTension: 0
		}, {
			type: 'bar',
			label: 'Aud. aprobadas',
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
						color: ['none','rgb(50,200,50)','yellow','none']
					},
					ticks: {
						suggestedMin: 0,
						suggestedMax: 100
					},
					afterBuildTicks: function(humdaysChart) {
					    humdaysChart.ticks = [];
					    humdaysChart.ticks.push(0);
					    humdaysChart.ticks.push(param_codran1);
					    humdaysChart.ticks.push(param_codran2);
					    humdaysChart.ticks.push(100);
					}
				}]
			},
			legend:{
				labels:{
					usePointStyle: true
				}
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
                            var data = Math.round(dataset.data[index])+"%";
                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
                        });
                    });

                }
            }
		}
	});
}

function processGraph2(ar_lab,ar_defCan,ar_defPor,ar_defCol){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'line',
			label: 'Acumulado',
			borderColor: window.chartColors.red,
			borderWidth: 2,
			fill: false,
			data: ar_defPor,
			yAxisID: 'y-axis-2',
			lineTension: 0
		}, {
			type: 'bar',
			backgroundColor: ar_defCol,
			label: 'Frecuencia',
			yAxisID: 'y-axis-1',
			data: ar_defCan
		}]
	};
	var ctx = document.getElementById('chart-area2').getContext('2d');
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
						suggestedMin: 0/*,
						suggestedMax: 100,*/
					}
				}, {
					type: 'linear',
					display: true,
					position: 'right',
					id: 'y-axis-2',
					ticks: {
						suggestedMin: 0,
						suggestedMax: 100,
					}
				}]
			},
			legend:{
				labels:{
					usePointStyle: true
				}
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
	                            var data = Math.round(dataset.data[index]*100/sumTotSem)+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });
	                    }else{
	                        var meta = chartInstance.controller.getDatasetMeta(i);
	                        meta.data.forEach(function (bar, index) {
	                            var data = Math.round(dataset.data[index])+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });	                    	
	                    }
                    });
                }
            }
		}
	});
}

function processGraph2Mes(ar_lab,ar_defCan,ar_defPor,ar_defCol){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'line',
			label: 'Acumulado',
			borderColor: window.chartColors.red,
			borderWidth: 2,
			fill: false,
			data: ar_defPor,
			yAxisID: 'y-axis-2',
			lineTension: 0
		}, {
			type: 'bar',
			backgroundColor: ar_defCol,
			label: 'Frecuencia',
			yAxisID: 'y-axis-1',
			data: ar_defCan
		}]
	};
	var ctx = document.getElementById('chart-area2-mes').getContext('2d');
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
						suggestedMin: 0/*,
						suggestedMax: 100,*/
					}
				}, {
					type: 'linear',
					display: true,
					position: 'right',
					id: 'y-axis-2',
					ticks: {
						suggestedMin: 0,
						suggestedMax: 100,
					}
				}]
			},
			legend:{
				labels:{
					usePointStyle: true
				}
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
	                            var data = Math.round(dataset.data[index]*100/sumTotMes)+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });
	                    }else{
	                        var meta = chartInstance.controller.getDatasetMeta(i);
	                        meta.data.forEach(function (bar, index) {
	                            var data = Math.round(dataset.data[index])+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });	                    	
	                    }
                    });
                }
            }
		}
	});
}

function processGraph3(ar_lab,ar_defCan,ar_defPor,ar_defCol){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'line',
			label: 'Acumulado',
			borderColor: window.chartColors.red,
			borderWidth: 2,
			fill: false,
			data: ar_defPor,
			yAxisID: 'y-axis-2',
			lineTension: 0
		}, {
			type: 'bar',
			backgroundColor: ar_defCol,
			label: 'Frecuencia',
			yAxisID: 'y-axis-1',
			data: ar_defCan
		}]
	};
	var ctx = document.getElementById('chart-area3').getContext('2d');
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
				}, {
					type: 'linear',
					display: true,
					position: 'right',
					id: 'y-axis-2',
					ticks: {
						suggestedMin: 0,
						suggestedMax: 100,
					}
				}]
			},
			legend:{
				labels:{
					usePointStyle: true
				}
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
	                            var data = Math.round(dataset.data[index]*100/sumTotUSem)+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });
	                    }else{
	                        var meta = chartInstance.controller.getDatasetMeta(i);
	                        meta.data.forEach(function (bar, index) {
	                            var data = Math.round(dataset.data[index])+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });	                    	
	                    }
                    });
                }
            }
		}
	});
}

function processGraph3Mes(ar_lab,ar_defCan,ar_defPor,ar_defCol){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'line',
			label: 'Acumulado',
			borderColor: window.chartColors.red,
			borderWidth: 2,
			fill: false,
			data: ar_defPor,
			yAxisID: 'y-axis-2',
			lineTension: 0
		}, {
			type: 'bar',
			backgroundColor: ar_defCol,
			label: 'Frecuencia',
			yAxisID: 'y-axis-1',
			data: ar_defCan
		}]
	};
	var ctx = document.getElementById('chart-area3-mes').getContext('2d');
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
				}, {
					type: 'linear',
					display: true,
					position: 'right',
					id: 'y-axis-2',
					ticks: {
						suggestedMin: 0,
						suggestedMax: 100,
					}
				}]
			},
			legend:{
				labels:{
					usePointStyle: true
				}
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
	                            var data = Math.round(dataset.data[index]*100/sumTotUMes)+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });
	                    }else{
	                        var meta = chartInstance.controller.getDatasetMeta(i);
	                        meta.data.forEach(function (bar, index) {
	                            var data = Math.round(dataset.data[index])+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });	                    	
	                    }
                    });
                }
            }
		}
	});
}

function processGraph4(ar_lab,ar_defCan,ar_defPor,ar_defCol){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'line',
			label: 'Acumulado',
			borderColor: window.chartColors.red,
			borderWidth: 2,
			fill: false,
			data: ar_defPor,
			yAxisID: 'y-axis-2',
			lineTension: 0
		}, {
			type: 'bar',
			backgroundColor: ar_defCol,
			label: 'Frecuencia',
			yAxisID: 'y-axis-1',
			data: ar_defCan
		}]
	};
	var ctx = document.getElementById('chart-area4').getContext('2d');
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
				}, {
					type: 'linear',
					display: true,
					position: 'right',
					id: 'y-axis-2',
					ticks: {
						suggestedMin: 0,
						suggestedMax: 100,
					}
				}]
			},
			legend:{
				labels:{
					usePointStyle: true
				}
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
	                            var data = Math.round(dataset.data[index]*100/sumTotDSem)+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });
	                    }else{
	                        var meta = chartInstance.controller.getDatasetMeta(i);
	                        meta.data.forEach(function (bar, index) {
	                            var data = Math.round(dataset.data[index])+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });	                    	
	                    }
                    });
                }
            }
		}
	});
}

function processGraph4Mes(ar_lab,ar_defCan,ar_defPor,ar_defCol){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'line',
			label: 'Acumulado',
			borderColor: window.chartColors.red,
			borderWidth: 2,
			fill: false,
			data: ar_defPor,
			yAxisID: 'y-axis-2',
			lineTension: 0
		}, {
			type: 'bar',
			backgroundColor: ar_defCol,
			label: 'Frecuencia',
			yAxisID: 'y-axis-1',
			data: ar_defCan
		}]
	};
	var ctx = document.getElementById('chart-area4-mes').getContext('2d');
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
				}, {
					type: 'linear',
					display: true,
					position: 'right',
					id: 'y-axis-2',
					ticks: {
						suggestedMin: 0,
						suggestedMax: 100,
					}
				}]
			},
			legend:{
				labels:{
					usePointStyle: true
				}
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
	                            var data = Math.round(dataset.data[index]*100/sumTotDMes)+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });
	                    }else{
	                        var meta = chartInstance.controller.getDatasetMeta(i);
	                        meta.data.forEach(function (bar, index) {
	                            var data = Math.round(dataset.data[index])+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });	                    	
	                    }
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
	  		"&ct="+codtll+"&cts="+codtipser+"&cs="+codsede+"&fecha="+fecha+"&ran1="+param_codran1+"&ran2="+param_codran2;
	  		a.click();
	  	}
	}).done(function(o) {
	  	console.log('Images Saved!'); 
	});
}