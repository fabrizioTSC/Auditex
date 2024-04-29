var param_codran1=0;
var param_codran2=0;
var titulo_var="";
$(document).ready(function(){
	$.ajax({
		type:"POST",
		data:{
			linea:linea,
			turno:turno,
			fecha:fecha
		},
		url:"config/getIndEfiEfcLin.php",
		success:function(data){
			console.log(data);

			var colors=[];
			var labels=[];
			var rechazado=[];
			var aprobado=[];

			$("#spacetitulo").text(data.titulo);

			/////
			let html='';
			param_codran2=parseInt(data.param[0].VALOR);
			param_codran1=parseInt(data.param[1].VALOR);

			for (var i = 0; i < data.anios.length; i++) {
				var efi=Math.round(data.anios[i]['MINEFICIENCIA']*10000/data.anios[i]['MINASIGNADOS'])/100;
				var efc=Math.round(data.anios[i]['MINEFICACIA']*10000/data.anios[i]['MINASIGNADOS'])/100;
				var styleC="colorB";
				if (efi>=param_codran1) {
					styleC="colorA";
				}else{
					if (efi<param_codran2) {
						styleC="colorC";
					}
				}
				var styleC2="colorB";
				var color=window.chartColors.yellow;
				if (efc>=param_codran1) {
					styleC2="colorA";
					color=window.chartColors.green;
				}else{
					if (efc<param_codran2) {
						styleC2="colorC";
						color=window.chartColors.reddark;
					}
				}
				html+=
				'<div class="divanios[i]">'+
					'<div class="itemhs1">'+data.anios[i]['ANHO']+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['MINEFICIENCIA'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['MINEFICACIA'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['MINASIGNADOS'])+'</div>'+
					'<div class="itemhs1 items4 '+styleC+'" >'+formatPercent(data.anios[i]['MINEFICIENCIA']/data.anios[i]['MINASIGNADOS'])+'%</div>'+
					'<div class="itemhs1 items4 '+styleC2+'">'+formatPercent(data.anios[i]['MINEFICACIA']/data.anios[i]['MINASIGNADOS'])+'%</div>'+
				'</div>';
				colors.push(color);
				labels.push(data.anios[i]['ANHO']);
				rechazado.push(efi);
				aprobado.push(efc);
			}
			$("#placeAnios").append(html);
			html='';
			for (var i = 0; i < data.meses.length; i++) {	
				var efi=Math.round(data.meses[i]['MINEFICIENCIA']*10000/data.meses[i]['MINASIGNADOS'])/100;
				var efc=Math.round(data.meses[i]['MINEFICACIA']*10000/data.meses[i]['MINASIGNADOS'])/100;
				var styleC="colorB";
				if (efi>=param_codran1) {
					styleC="colorA";
				}else{
					if (efi<param_codran2) {
						styleC="colorC";
					}
				}
				var styleC2="colorB";
				var color=window.chartColors.yellow;
				if (efc>=param_codran1) {
					styleC2="colorA";
					color=window.chartColors.green;
				}else{
					if (efc<param_codran2) {
						styleC2="colorC";
						color=window.chartColors.reddark;
					}
				}
				html+=
				'<div class="divanios[i]">'+
					'<div class="itemhs1">'+proceMes(data.meses[i]['MES'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['MINEFICIENCIA'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['MINEFICACIA'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['MINASIGNADOS'])+'</div>'+
					'<div class="itemhs1 items4 '+styleC+'">'+formatPercent(data.meses[i]['MINEFICIENCIA']/data.meses[i]['MINASIGNADOS'])+'%</div>'+
					'<div class="itemhs1 items4 '+styleC2+'">'+formatPercent(data.meses[i]['MINEFICACIA']/data.meses[i]['MINASIGNADOS'])+'%</div>'+
				'</div>';
				colors.push(color);
				labels.push(proceMes(data.meses[i]['MES']));
				rechazado.push(efi);
				aprobado.push(efc);
			}
			$("#placeMeses").append(html);

			html='';
			var numSem=0;
			for (var i = 0; i < data.semanas.length; i++) {	
				var efi=Math.round(data.semanas[i]['MINEFICIENCIA']*10000/data.semanas[i]['MINASIGNADOS'])/100;
				var efc=Math.round(data.semanas[i]['MINEFICACIA']*10000/data.semanas[i]['MINASIGNADOS'])/100;				
				var styleC="colorB";
				if (efi>=param_codran1) {
					styleC="colorA";
				}else{
					if (efi<param_codran2) {
						styleC="colorC";
					}
				}
				var styleC2="colorB";
				var color=window.chartColors.yellow;
				if (efc>=param_codran1) {
					styleC2="colorA";
					color=window.chartColors.green;
				}else{
					if (efc<param_codran2) {
						styleC2="colorC";
						color=window.chartColors.reddark;
					}
				}
				html+=
				'<div class="divanios[i]">'+
					'<div class="itemhs1">S. '+data.semanas[i]['NUMERO_SEMANA']+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['MINEFICIENCIA'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['MINEFICACIA'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['MINASIGNADOS'])+'</div>'+
					'<div class="itemhs1 items4 '+styleC+'">'+formatPercent(data.semanas[i]['MINEFICIENCIA']/data.semanas[i]['MINASIGNADOS'])+'%</div>'+
					'<div class="itemhs1 items4 '+styleC2+'">'+formatPercent(data.semanas[i]['MINEFICACIA']/data.semanas[i]['MINASIGNADOS'])+'%</div>'+
				'</div>';
				colors.push(color);
				labels.push("S. "+data.semanas[i]['NUMERO_SEMANA']);
				rechazado.push(efi);
				aprobado.push(efc);
			}
			$("#placeSemanas").append(html);
			processGraph(labels,rechazado,aprobado,colors);

			////

			$(".panelCarga").fadeOut(100);
		}
	});
});

function formatPercent(val){
	//val=parseFloat(val.replace(",","."));
	val=Math.round(val*10000)/100;
	return val;
}

function exportarRanking(){
	window.location.href="config/exports/exportReportRankinLinea.php?codsede="+codsede+"&codtipser="+codtipser+
		"&anio="+anio+"&mes="+mes+"&semana="+semana+"&fecini="+fecini+"&fecfin="+fecfin+"&titulo="+$("#spacetitulo").text()+"&option="+option;
}

function processGraph(ar_lab,ar_rec,ar_apr,ar_color){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'line',
			label: 'Eficiencia',
			borderColor: window.chartColors.black,
			borderWidth: 2,
			fill: false,
			data: ar_rec,
			lineTension: 0,
			datalabels: {
				align: 'top',
				anchor: 'end'
			}
		}, {
			type: 'bar',
			label: 'Eficacia',
			backgroundColor:ar_color,
			data: ar_apr,
			datalabels: {
				align: 'center',
				anchor: 'start'
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
			plugins: {
				datalabels: {
        			color: 'black',
					formatter: function(value, context) {
						//if (context.dataset.type=="line") {
							return Math.round(value*100)/100+"%";
						/*}else{
							return Math.round(value);
						}*/
					},
					font:{
						weight:'bold'
					}
				}
			}
		}
	});
}