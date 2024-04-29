var param_codran1=0;
var param_codran2=0;
$(document).ready(function(){
	var fecha=new Date();
	var dia=fecha.getDate();
	dia=""+dia;
	if (dia.length==1) {
		dia="0"+dia;
	}
	var mes=fecha.getMonth()+1;
	mes=""+mes;
	if (mes.length==1) {
		mes="0"+mes;
	}
	var anio=fecha.getFullYear();
	var hoy=anio+"-"+mes+"-"+dia;
	document.getElementById("idFecIni").value=hoy;
	document.getElementById("idFecFin").value=hoy;
	$.ajax({
		type:"POST",
		data:{
		},
		url:"config/getAniosGeneral.php",
		success:function(data){
			var html='';
			for (var i = 0; i < data.anios.length; i++) {
				html+=
				'<option>'+data.anios[i].ANIO+'</option>';
			}
			$("#idNumAnio").append(html);
			$("#idNumAnio").val(data.anio);
			get_semanas();
		}
	});	
	$("#idNumAnio").change(function(){
		$(".panelCarga").fadeIn(100);
		get_semanas();
	});
	$("#idNumSem").change(function(){
		$(".panelCarga").fadeIn(100);
		get_infindres();
	});
});

function get_semanas(){
	$.ajax({
		type:"POST",
		data:{
			anio:$("#idNumAnio").val()
		},
		url:"config/getSemanasGeneral.php",
		success:function(data){
			var html='';
			for (var i = 0; i < data.semanas.length; i++) {
				html+=
				'<option>'+data.semanas[i].NUMERO_SEMANA+'</option>';
			}
			$("#idNumSem").append(html);
			$("#idNumSem").val(data.semana);
			get_infindres();
		}
	});
}

function get_infindres(){
	let opcion="0";
	if (!document.getElementById("tipo0").checked) {
		opcion="1";
	}
	$.ajax({
		type:"POST",
		data:{
			codlin:codlin,
			codtipser:codtipser,
			codsede:codsede,
			opcion:opcion,
			anio:$("#idNumAnio").val(),
			semana:$("#idNumSem").val(),
			fecini:$("#idFecIni").val(),
			fecfin:$("#idFecFin").val()
		},
		url:"config/getInfoIndDef.php",
		success:function(data){
			console.log(data);
			$("#titulodetalle2").empty();
			$("#titulodetalle").empty();
			$("#titulodetalle2").append(data.titulo);
			$("#titulodetalle").append(data.titulo);

			var html='';
			for (var i = 0; i < data.defectos.length; i++) {
				html+=
				'<div class="lineBody" onclick="detalle_defecto(\''+data.defectos[i]['CODDEF']+'\',\''+data.defectos[i]['DESDEF']+'\')">'+
					'<div class="itemhs1 items4" style="width: calc(55% - 10px);text-align:left;">'+(i+1)+'. '+data.defectos[i]['DESDEF']+'</div>'+
					'<div class="itemhs1 items4" style="width: calc(15% - 10px);">'+formatNumber(data.defectos[i]['SUMDEF'])+'</div>'+
					'<div class="itemhs1 items4" style="width: calc(15% - 10px);">'+formatNumber(data.defectos[i]['CANINS'])+'</div>'+
					'<div class="itemhs1 items4" style="width: calc(15% - 10px);">'+data.defectos[i]['PORDEF']+'%</div>'+
				'</div>';
			}
			$("#idDefectos").empty();
			$("#idDefectos").append(html);
			$(".panelCarga").fadeOut(100);
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

function update_reporte(){
	$(".panelCarga").fadeIn(100);
	get_infindres();
}

var param_codran1=0;
var param_codran2=0;
var coddef_v="";
function detalle_defecto(coddef,desdef){
	$(".panelCarga").fadeIn(200);
	coddef_v=coddef;
	$.ajax({
		type:"POST",
		data:{
			codlin:codlin,
			codtipser:codtipser,
			codsede:codsede,
			coddef:coddef
		},
		url:"config/getInfoIndDefXCod.php",
		success:function(data){
			console.log(data);
			$("#idDesDef").text(desdef.toUpperCase());
			param_codran2=parseInt(data.param[0].VALOR);
			param_codran1=parseInt(data.param[1].VALOR);

			var colors=[];
			var labels=[];
			var totdef=[];
			var html='';
			var max_per=0;
			for (var i = 0; i < data.anios.length; i++) {
				var porcentaje=Math.round(Math.round(data.anios[i]['SUMCODDEF']*10000)/data.anios[i]['SUMDEF'])/100;
				if(porcentaje>max_per){
					max_per=porcentaje;
				}
				html+=
				'<div class="divanios[i]">'+
					'<div class="itemhs1">'+data.anios[i]['ANHO']+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['SUMCODDEF'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['SUMDEF'])+'</div>'+
					'<div class="itemhs1 items4">'+porcentaje+'%</div>'+
				'</div>';
				colors.push('#1f71c5');
				labels.push(data.anios[i]['ANHO']);
				totdef.push(porcentaje);
			}
			$("#placeAnios").empty();
			$("#placeAnios").append(html);
			var html='';
			for (var i = 0; i < data.meses.length; i++) {
				var porcentaje=Math.round(Math.round(data.meses[i]['SUMCODDEF']*10000)/data.meses[i]['SUMDEF'])/100;
				if(porcentaje>max_per){
					max_per=porcentaje;
				}
				html+=
				'<div class="divanios[i]">'+
					'<div class="itemhs1">'+proceMes(data.meses[i]['MES'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['SUMCODDEF'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['SUMDEF'])+'</div>'+
					'<div class="itemhs1 items4">'+porcentaje+'%</div>'+
				'</div>';
				colors.push('#46c711');
				labels.push(proceMes(data.meses[i]['MES']));
				totdef.push(porcentaje);
			}
			$("#placeMeses").empty();
			$("#placeMeses").append(html);
			var html='';
			for (var i = 0; i < data.semanas.length; i++) {
				var porcentaje=Math.round(Math.round(data.semanas[i]['SUMCODDEF']*10000)/data.semanas[i]['SUMDEF'])/100;
				if(porcentaje>max_per){
					max_per=porcentaje;
				}
				html+=
				'<div class="divanios[i]">'+
					'<div class="itemhs1">S. '+data.semanas[i]['SEMANA']+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['SUMCODDEF'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['SUMDEF'])+'</div>'+
					'<div class="itemhs1 items4">'+porcentaje+'%</div>'+
				'</div>';
				colors.push('#ead431');
				labels.push("S. "+data.semanas[i]['SEMANA']);
				totdef.push(porcentaje);
			}
			max_per=Math.round(porcentaje);
			$("#placeSemanas").empty();
			$("#placeSemanas").append(html);
			processGraph(labels,totdef,colors,max_per);
			$(".panelCarga").fadeOut(200);
			$("#idModal").fadeIn(200);
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
}

function processGraph(ar_lab,ar_apr,ar_color,max_value){
	$("#chart-area").remove();
	//document.getElementById('chart-area').innerHTML='';
	document.getElementById('content-canvas').innerHTML='<canvas id="chart-area"></canvas>';
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'bar',
			label: '% defectos',
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
						suggestedMax: 5
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
                    	//if (dataset.type=="bar") {
	                        var meta = chartInstance.controller.getDatasetMeta(i);
	                        meta.data.forEach(function (bar, index) {
	                            var data = dataset.data[index]+"%";
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
	  	url: "config/saveTmpImg2.php",
	  	data: { 
	    	imgBase64: document.getElementById("chart-area").toDataURL("image/png"),
			codlin:codlin,
			codtipser:codtipser,
			codsede:codsede,
			codusu:codusu
	  	},
	  	success:function(data){
	  		var title=$("#titulodetalle").text();
	  		var title2=$("#idDesDef").text();
	  		var cd=coddef_v;
	  		var a=document.createElement("a");
	  		a.target="_blank";
	  		a.href="fpdf/crearPdfIndDef.php?n="+data+
	  		"&t="+title+"&t2="+title2+
	  		"&cl="+codlin+"&cts="+codtipser+"&cs="+codsede+"&cd="+cd;
	  		a.click();
	  	}
	}).done(function(o) {
	  	console.log('Images Saved!'); 
	});
}

function hide_modal(){
	$("#idModal").fadeOut(200);
}