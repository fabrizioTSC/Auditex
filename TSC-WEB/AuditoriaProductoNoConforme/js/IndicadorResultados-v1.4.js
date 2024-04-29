var param_codran1=0;
var param_codran2=0;
$(document).ready(function(){
	$.ajax({
		type:"POST",
		data:{
			codtipser:codtipser,
			codsede:codsede,
			fecha:fecha
		},
		url:"config/getInfoIndicadores.php",
		success:function(data){
			console.log(data);
			var labels=[];
			var ar_porcentaje=[];
			var ar_obj=[];
			var html='';
			param_codran2=parseInt(data.param[0].VALOR);
			param_codran1=parseInt(data.param[1].VALOR);
			if (codtipser=="0" && codsede=="0") {
				document.getElementById("caso2").remove();
				$("#titulodetalle").append(data.titulo);
				for (var i = 0; i < data.anios.length; i++) {
					let porcentaje=data.anios[i]['PORCLA'];
					html+=
					'<div class="divanios[i]">'+
						'<div class="itemhs1">'+data.anios[i]['ANIO']+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['CANCLAPLACHI'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['CANCLASERCHI'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['CANCLASERLIM'])+'</div>'+
						'<div class="itemhs1 items4" style="background: yellow;">'+formatNumber(data.anios[i]['CANCLA'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['CANPROCHI'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['CANPROLIM'])+'</div>'+
						'<div class="itemhs1 items4" style="background: yellow;">'+formatNumber(data.anios[i]['CANPRO'])+'</div>'+
						'<div class="itemhs1 items4">'+data.anios[i]['PORCLAPLACHI']+'%</div>'+
						'<div class="itemhs1 items4">'+data.anios[i]['PORCLASERCHI']+'%</div>'+
						'<div class="itemhs1 items4">'+data.anios[i]['PORCLASERLIM']+'%</div>'+
						'<div class="itemhs1 items4">'+porcentaje+'%</div>'+
						'<div class="itemhs1 items4" style="background: red;color: yellow;">'+data.anios[i]['OBJETIVO']+'%</div>'+
					'</div>';
					labels.push(data.anios[i]['ANIO']);
					ar_porcentaje.push(porcentaje);
					ar_obj.push(data.anios[i]['OBJETIVO']);
				}
				$("#placeAniosPS").append(html);

				html='';
				for (var i = 0; i < data.meses.length; i++) {
					let porcentaje=data.meses[i]['PORCLA'];
					html+=
					'<div class="divanios[i]">'+
						'<div class="itemhs1">'+proceMes(data.meses[i]['MES'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['CANCLAPLACHI'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['CANCLASERCHI'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['CANCLASERLIM'])+'</div>'+
						'<div class="itemhs1 items4" style="background: yellow;">'+formatNumber(data.meses[i]['CANCLA'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['CANPROCHI'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['CANPROLIM'])+'</div>'+
						'<div class="itemhs1 items4" style="background: yellow;">'+formatNumber(data.meses[i]['CANPRO'])+'</div>'+
						'<div class="itemhs1 items4">'+data.meses[i]['PORCLAPLACHI']+'%</div>'+
						'<div class="itemhs1 items4">'+data.meses[i]['PORCLASERCHI']+'%</div>'+
						'<div class="itemhs1 items4">'+data.meses[i]['PORCLASERLIM']+'%</div>'+
						'<div class="itemhs1 items4">'+porcentaje+'%</div>'+
						'<div class="itemhs1 items4" style="background: red;color: yellow;">'+data.meses[i]['OBJETIVO']+'%</div>'+
					'</div>';
					labels.push(proceMes(data.meses[i]['MES']));
					ar_porcentaje.push(porcentaje);
					ar_obj.push(data.meses[i]['OBJETIVO']);
				}
				$("#placeMesesPS").append(html);

				html='';
				for (var i = 0; i < data.semanas.length; i++) {
					let porcentaje=data.semanas[i]['PORCLA'];
					html+=
					'<div class="divanios[i]">'+
						'<div class="itemhs1">'+"Sem. "+data.semanas[i]['NUMERO_SEMANA']+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['CANCLAPLACHI'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['CANCLASERCHI'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['CANCLASERLIM'])+'</div>'+
						'<div class="itemhs1 items4" style="background: yellow;">'+formatNumber(data.semanas[i]['CANCLA'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['CANPROCHI'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['CANPROLIM'])+'</div>'+
						'<div class="itemhs1 items4" style="background: yellow;">'+formatNumber(data.semanas[i]['CANPRO'])+'</div>'+
						'<div class="itemhs1 items4">'+data.semanas[i]['PORCLAPLACHI']+'%</div>'+
						'<div class="itemhs1 items4">'+data.semanas[i]['PORCLASERCHI']+'%</div>'+
						'<div class="itemhs1 items4">'+data.semanas[i]['PORCLASERLIM']+'%</div>'+
						'<div class="itemhs1 items4">'+porcentaje+'%</div>'+
						'<div class="itemhs1 items4" style="background: red;color: yellow;">'+data.semanas[i]['OBJETIVO']+'%</div>'+
					'</div>';
					labels.push("Sem. "+data.semanas[i]['NUMERO_SEMANA']);
					ar_porcentaje.push(porcentaje);
					ar_obj.push(data.semanas[i]['OBJETIVO']);
				}
				$("#placeSemanasPS").append(html);
			}else{
				document.getElementById("caso1").remove();
				$("#titulodetalle").append(data.titulo);
				for (var i = 0; i < data.anios.length; i++) {
					let porcentaje=data.anios[i]['PORCLA'];
					html+=
					'<div class="divanios[i]">'+
						'<div class="itemhs1">'+data.anios[i]['ANIO']+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['CANCLA'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['CANPRO'])+'</div>'+
						'<div class="itemhs1 items4">'+porcentaje+'%</div>'+
						'<div class="itemhs1 items4" style="background: red;color: yellow;">'+data.anios[i]['OBJETIVO']+'%</div>'+
					'</div>';
					labels.push(data.anios[i]['ANIO']);
					ar_porcentaje.push(porcentaje);
					ar_obj.push(data.anios[i]['OBJETIVO']);
				}
				$("#placeAniosPS").append(html);

				html='';
				for (var i = 0; i < data.meses.length; i++) {
					let porcentaje=data.meses[i]['PORCLA'];
					html+=
					'<div class="divanios[i]">'+
						'<div class="itemhs1">'+proceMes(data.meses[i]['MES'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['CANCLA'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['CANPRO'])+'</div>'+
						'<div class="itemhs1 items4">'+porcentaje+'%</div>'+
						'<div class="itemhs1 items4" style="background: red;color: yellow;">'+data.meses[i]['OBJETIVO']+'%</div>'+
					'</div>';
					labels.push(proceMes(data.meses[i]['MES']));
					ar_porcentaje.push(porcentaje);
					ar_obj.push(data.meses[i]['OBJETIVO']);
				}
				$("#placeMesesPS").append(html);

				html='';
				for (var i = 0; i < data.semanas.length; i++) {
					let porcentaje=data.semanas[i]['PORCLA'];
					html+=
					'<div class="divanios[i]">'+
						'<div class="itemhs1">'+"Sem. "+data.semanas[i]['NUMERO_SEMANA']+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['CANCLA'])+'</div>'+
						'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['CANPRO'])+'</div>'+
						'<div class="itemhs1 items4">'+porcentaje+'%</div>'+
						'<div class="itemhs1 items4" style="background: red;color: yellow;">'+data.semanas[i]['OBJETIVO']+'%</div>'+
					'</div>';
					labels.push("Sem. "+data.semanas[i]['NUMERO_SEMANA']);
					ar_porcentaje.push(porcentaje);
					ar_obj.push(data.semanas[i]['OBJETIVO']);
				}
				$("#placeSemanasPS").append(html);
			}

			processGraph(labels,ar_porcentaje,ar_obj);


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

function processGraph(ar_lab,ar_clasi,ar_obj){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'line',
			label: '% prendas clasificadas',
			borderColor: window.chartColors.black,
			borderWidth: 2,
			fill: false,
			data: ar_clasi,
			lineTension: 0,
			datalabels: {
				align: 'right',
				anchor: 'start'
			}
		},{
			type: 'line',
			label: 'Objetivo plazo',
			borderColor: window.chartColors.red,
			borderWidth: 2,
			fill: false,
			data: ar_obj,
			lineTension: 0,
			datalabels: {
				align: 'left',
				anchor: 'end'
			}
		}]
	};
	var wWin=window.innerWidth;
	var dBorder=true;
	var stepTicks=5;
	if (wWin<600) {
		dBorder=false;
		stepTicks=20;
	}
	var ctx = document.getElementById('chart-area-ps').getContext('2d');
	window.myMixedChart = new Chart(ctx, {
		type: 'bar',
		data: chartData,
		options: {
			responsive: true,
			tooltips: {
				mode: 'index',
				intersect: true
			},
			legend:{
				labels:{
					usePointStyle: true
				}
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
						color: ['none','none'/*,'rgb(250,50,50)'*/,'none']
					},
					ticks: {
						suggestedMin: 0,
						suggestedMax: 2.5
					},
					afterBuildTicks: function(humdaysChart) {
					    humdaysChart.ticks = [];
					    humdaysChart.ticks.push(0);
					    humdaysChart.ticks.push(1.3);
					    humdaysChart.ticks.push(1.5);
					}
				}]
			},/*
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
	                            var data = Math.round(dataset.data[index]*1000)/1000+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });
	                    //}
                    });

                }
            }*/
			plugins: {
				datalabels: {
        			color: 'black',
					formatter: function(value, context) {
						if (context.dataset.type=="bar") {
							return (Math.round(Math.round(value)*10000/sumTotSem)/100)+"%";
						}else{
							return Math.round(value*100)/100+"%";
						}
					},
					font:{
						weight:'bold'
					}
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
	    	img8: document.getElementById("chart-area-ps").toDataURL("image/png"),
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
	  		a.href="fpdf/crearPdf.php?n="+data+"&t="+title+"&t2="+t2+"&t3="+t3+
	  		"&t4="+t4+"&t4_1="+t4_1+"&t4_2="+t4_2+"&t5="+t5+"&t5_1="+t5_1+"&t5_2="+t5_2+"&ct="+codtll+"&cts="+codtipser+"&cs="+codsede+"&fecha="+fecha;
	  		a.click();
	  	}
	}).done(function(o) {
	  	console.log('Images Saved!'); 
	});
}

function processGraphPS(ar_lab,ar_rec,ar_apr,ar_color){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'line',
			label: 'Aud. Apr. 2da ó más',
			borderColor: window.chartColors.black,
			borderWidth: 2,
			fill: false,
			data: ar_rec,
			lineTension: 0
		},{
			type: 'bar',
			label: 'Aud. Apr. 1ra',
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
	var ctx = document.getElementById('chart-area-ps').getContext('2d');
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