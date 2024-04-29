var param_codran1=0;
var param_codran2=0;
var titulo_v='';
$(document).ready(function(){
	$.ajax({
		type:"POST",
		data:{
			codtll:codtll,
			codtipser:codtipser,
			codsede:codsede
		},
		url:"config/getInfoIndDef.php",
		success:function(data){
			console.log(data);
			$("#titulodetalle2").append(data.titulo);
			$("#titulodetalle").append(data.titulo);
			titulo_v=data.titulo_v;
			var html='';
			for (var i = 0; i < data.anios.length; i++) {
				html+=
				'<option>'+data.anios[i].ANIO+'</option>';
			}
			$("#idNumAnio").append(html);
			$("#idNumAnio").val(data.anio);

			var html='';
			for (var i = 0; i < data.semanas.length; i++) {
				html+=
				'<option>'+data.semanas[i].NUMERO_SEMANA+'</option>';
			}
			$("#idNumSem").append(html);
			$("#idNumSem").val(data.semana);
			fill_defectos(data.defectos);
	
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
	$("#idNumAnio").change(function(){
		$(".panelCarga").fadeIn(200);
		$.ajax({
			type:"POST",
			data:{
				codtll:codtll,
				codtipser:codtipser,
				codsede:codsede,
				anio:$("#idNumAnio").val()
			},
			url:"config/getSemanasIndDef.php",
			success:function(data){
				console.log(data);
				var html='';
				for (var i = 0; i < data.semanas.length; i++) {
					html+=
					'<option>'+data.semanas[i].NUMERO_SEMANA+'</option>';
				}
				$("#idNumSem").empty();
				$("#idNumSem").append(html);
				$("#idNumSem").val(data.semana);
				fill_defectos(data.defectos);
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
	$("#idNumSem").change(function(){
		$(".panelCarga").fadeIn(200);
		$.ajax({
			type:"POST",
			data:{
				codtll:codtll,
				codtipser:codtipser,
				codsede:codsede,
				anio:$("#idNumAnio").val(),
				semana:$("#idNumSem").val()
			},
			url:"config/getNewInfoIndDef.php",
			success:function(data){
				console.log(data);
				fill_defectos(data.defectos);
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
});

function fill_defectos(defectos){	
	var html='';
	for (var i = 0; i < defectos.length; i++) {
		html+=
		'<div class="lineBody" onclick="detalle_defecto(\''+defectos[i]['CODDEF']+'\',\''+defectos[i]['DESDEF']+'\')">'+
			'<div class="itemhs1 items4" style="width: calc(55% - 10px);text-align:left;display:flex;">'+
				'<div id="ext-'+defectos[i]['CODDEF']+'" class="ext-def" onclick="show_ext_def(\''+defectos[i]['CODDEF']+'\',\''+defectos[i]['DESDEF']+'\')">+</div>&nbsp;'+
				(i+1)+'. '+defectos[i]['DESDEF']+
			'</div>'+
			'<div class="itemhs1 items4" style="width: calc(15% - 10px);">'+formatNumber(defectos[i]['CANMUE'])+'</div>'+
			'<div class="itemhs1 items4" style="width: calc(15% - 10px);">'+formatNumber(defectos[i]['SUMDEF'])+'</div>'+
			'<div class="itemhs1 items4" style="width: calc(15% - 10px);">'+defectos[i]['PORDEF']+'%</div>'+
		'</div>'+
		'<div class="lineBody line-ext" id="ext-body-'+defectos[i]['CODDEF']+'" style="display:none;">'+
		'</div>';
	}
	$("#idDefectos").empty();
	$("#idDefectos").append(html);
}

var desdef_v='';
function show_ext_def(coddef,desdef){
	event.stopPropagation();
	if (document.getElementById("ext-"+coddef).innerHTML=="-") {
		document.getElementById("ext-"+coddef).innerHTML="+";
		$("#ext-body-"+coddef).css("display","none");
		return;
	}else{
		var ar=document.getElementsByClassName("ext-def");
		for (var i = 0; i < ar.length; i++) {
			ar[i].innerHTML="+";
		}
		document.getElementById("ext-"+coddef).innerHTML="-";
	}
	var ar=document.getElementsByClassName("line-ext");
	for (var i = 0; i < ar.length; i++) {
		ar[i].style.display="none";
	}
	$(".panelCarga").fadeIn(200);
	coddef_v=coddef;
	desdef_v=desdef;
	if (tipo==1) {
		$.ajax({
			type:"POST",
			data:{
				codtll:codtll,
				codtipser:codtipser,
				codsede:codsede,
				coddef:coddef,
				anio:$("#idNumAnio").val(),
				semana:$("#idNumSem").val(),
				tipo:tipo
			},
			url:"config/getInfoIndDefTll.php",
			success:function(data){
				console.log(data);
				fill_talleres(data.talleres,coddef,data.sumtot);
				$(".panelCarga").fadeOut(200);
			}
		});
	}else{
		$.ajax({
			type:"POST",
			data:{
				codtll:codtll,
				codtipser:codtipser,
				codsede:codsede,
				coddef:coddef,
				fecini:document.getElementById("fecini").value,
				fecfin:document.getElementById("fecfin").value,
				tipo:tipo
			},
			url:"config/getInfoIndDefTll.php",
			success:function(data){
				console.log(data);
				fill_talleres(data.talleres,coddef,data.sumtot);
				$(".panelCarga").fadeOut(200);
			}
		});
	}
}

function fill_talleres(data,coddef,sumtot){
	var html='';
	for (var i = 0; i < data.length; i++) {
		html+=
		'<div class="lineBody" onclick="detalle_defecto_taller(\''+data[i]['CODTLL']+'\',\''+data[i]['DESTLL']+'\')">'+
			'<div class="itemhs1 items4 items5" style="width: calc(55% - 10px);text-align:left;display:flex;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+data[i]['DESTLL']+'</div>'+
			'<div class="itemhs1 items4 items5" style="width: calc(15% - 10px);">'+formatNumber(data[i]['CANMUE'])+'</div>'+
			'<div class="itemhs1 items4 items5" style="width: calc(15% - 10px);">'+formatNumber(data[i]['SUMDEF'])+'</div>'+
			'<div class="itemhs1 items4 items5" style="width: calc(15% - 10px);">'+data[i]['PORDEF']+'%</div>'+
		'</div>';
	}
	$("#ext-body-"+coddef).empty();
	$("#ext-body-"+coddef).append(html);
	$("#ext-body-"+coddef).css("display","block");
}


function detalle_defecto_taller(codtll_new,destll){
	$(".panelCarga").fadeIn(200);
	$.ajax({
		type:"POST",
		data:{
			codtll:codtll_new,
			codtipser:codtipser,
			codsede:codsede,
			coddef:coddef_v
		},
		url:"config/getInfoIndDefXCod.php",
		success:function(data){
			console.log(data);
			$("#idDesDef").text(desdef_v.toUpperCase());
			param_codran2=parseInt(data.param[0].VALOR);
			param_codran1=parseInt(data.param[1].VALOR);
			$("#titulodetalle").empty();
			$("#titulodetalle").append(titulo_v+" TALLER: "+destll);

			var colors=[];
			var labels=[];
			var totdef=[];
			var html='';
			var max_per=0;
			for (var i = 0; i < data.anios.length; i++) {
				var porcentaje=Math.round(Math.round(data.anios[i]['SUMCODDEF']*10000)/data.anios[i]['SUMCANMUE'])/100;
				if(porcentaje>max_per){
					max_per=porcentaje;
				}
				html+=
				'<div class="divanios[i]">'+
					'<div class="itemhs1">'+data.anios[i]['ANHO']+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['SUMCODDEF'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['SUMCANMUE'])+'</div>'+
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
				var porcentaje=Math.round(Math.round(data.meses[i]['SUMCODDEF']*10000)/data.meses[i]['SUMCANMUE'])/100;
				if(porcentaje>max_per){
					max_per=porcentaje;
				}
				html+=
				'<div class="divanios[i]">'+
					'<div class="itemhs1">'+proceMes(data.meses[i]['MES'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['SUMCODDEF'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['SUMCANMUE'])+'</div>'+
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
				var porcentaje=Math.round(Math.round(data.semanas[i]['SUMCODDEF']*10000)/data.semanas[i]['SUMCANMUE'])/100;
				if(porcentaje>max_per){
					max_per=porcentaje;
				}
				html+=
				'<div class="divanios[i]">'+
					'<div class="itemhs1">S. '+data.semanas[i]['SEMANA']+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['SUMCODDEF'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['SUMCANMUE'])+'</div>'+
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

var param_codran1=0;
var param_codran2=0;
var coddef_v="";
function detalle_defecto(coddef,desdef){
	$(".panelCarga").fadeIn(200);
	coddef_v=coddef;
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
			$("#idDesDef").text(desdef.toUpperCase());
			param_codran2=parseInt(data.param[0].VALOR);
			param_codran1=parseInt(data.param[1].VALOR);
			$("#titulodetalle").empty();
			$("#titulodetalle").append(titulo_v+" TALLER: (TODOS)");

			var colors=[];
			var labels=[];
			var totdef=[];
			var html='';
			var max_per=0;
			for (var i = 0; i < data.anios.length; i++) {				
				var porcentaje=0;
				if (parseInt(data.anios[i]['SUMDEF'])!=0) {
					porcentaje=Math.round(Math.round(parseInt(data.anios[i]['SUMCODDEF'])*10000)/parseInt(data.anios[i]['SUMCANMUE']))/100;
				}
				if(porcentaje>max_per){
					max_per=porcentaje;
				}
				html+=
				'<div class="divanios[i]">'+
					'<div class="itemhs1">'+data.anios[i]['ANHO']+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['SUMCODDEF'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['SUMCANMUE'])+'</div>'+
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
				var porcentaje=0;
				if (parseInt(data.meses[i]['SUMDEF'])!=0) {
					porcentaje=Math.round(Math.round(parseInt(data.meses[i]['SUMCODDEF'])*10000)/parseInt(data.meses[i]['SUMCANMUE']))/100;
				}
				if(porcentaje>max_per){
					max_per=porcentaje;
				}
				html+=
				'<div class="divanios[i]">'+
					'<div class="itemhs1">'+proceMes(data.meses[i]['MES'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['SUMCODDEF'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['SUMCANMUE'])+'</div>'+
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
				var porcentaje=0;
				if (parseInt(data.semanas[i]['SUMDEF'])!=0) {
					porcentaje=Math.round(Math.round(parseInt(data.semanas[i]['SUMCODDEF'])*10000)/parseInt(data.semanas[i]['SUMCANMUE']))/100;
				}
				if(porcentaje>max_per){
					max_per=porcentaje;
				}
				html+=
				'<div class="divanios[i]">'+
					'<div class="itemhs1">S. '+data.semanas[i]['SEMANA']+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['SUMCODDEF'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['SUMCANMUE'])+'</div>'+
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

function update_fechas(){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		data:{
			codtll:codtll,
			codtipser:codtipser,
			codsede:codsede,
			fecini:document.getElementById("fecini").value,
			fecfin:document.getElementById("fecfin").value
		},
		url:"config/getInfoIndDefXFec.php",
		success:function(data){
			console.log(data);
			fill_defectos(data.defectos);	
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
			$(".panelCarga").fadeOut(200);
	    }
	});
}

function update_defectos(){
	$(".panelCarga").fadeIn(200);
		$.ajax({
			type:"POST",
			data:{
				codtll:codtll,
				codtipser:codtipser,
				codsede:codsede,
				anio:$("#idNumAnio").val(),
				semana:$("#idNumSem").val()
			},
			url:"config/getNewInfoIndDef.php",
			success:function(data){
				console.log(data);
				fill_defectos(data.defectos);
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
}

function downloadPDF(){
	$.ajax({
	  	type: "POST",
	  	url: "config/saveTmpImg2.php",
	  	data: { 
	    	imgBase64: document.getElementById("chart-area").toDataURL("image/png"),
			codtll:codtll,
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
	  		"&ct="+codtll+"&cts="+codtipser+"&cs="+codsede+"&cd="+cd;
	  		a.click();
	  	}
	}).done(function(o) {
	  	console.log('Images Saved!'); 
	});
}

function hide_modal(){
	$("#idModal").fadeOut(200);
}

function descargar_inddef(){
	var a=document.createElement("a");
	a.target="_blank";
	a.href="config/exports/exportIndDef.php?codtll="+codtll+"&codtipser="+codtipser+"&codsede="+codsede
	+"&tipo="+tipo+"&anio="+$("#idNumAnio").val()+"&semana="+$("#idNumSem").val()+"&fecini="+document.getElementById("fecini").value+"&fecfin="+document.getElementById("fecfin").value
	+"&titulo="+document.getElementById("titulodetalle2").innerHTML;
	a.click();
}