window.chartColorsArray = [
	'rgb(54, 162, 235)',
	'rgb(255, 50, 50)',
	'rgb(255, 159, 64)',
	'rgb(80, 200, 2)',
	'rgb(153, 102, 255)',
	'rgb(255, 205, 86)',
	'rgb(201, 203, 207)'
];
var displayLegend=true;

$(document).ready(function(){
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
		//$(".panelCarga").fadeIn(100);
	});
	$("#idFecIni").val(fecini);
	$("#idFecFin").val(fecfin);

	if (window.innerWidth>=430) {
		if (window.innerWidth<=750) {
			displayLegend=true;
		}else{
			if (window.innerWidth>1180) {
				displayLegend=true;	
			}else{
				displayLegend=false;	
			}
		}
	}else{
		displayLegend=false;
	}
	get_infindcon();
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
		}
	});
}

function get_infindcon(){
	$(".panelCarga").fadeIn(100);
	let opcion="0";
	if (!document.getElementById("tipo0").checked) {
		opcion="1";
	}
	$.ajax({
		type:"POST",
		data:{
			codprv:codprv,
			codcli:codcli,
			opcion:opcion,
			anio:$("#idNumAnio").val(),
			semana:$("#idNumSem").val(),
			fecini:$("#idFecIni").val(),
			fecfin:$("#idFecFin").val()
		},
		url:"config/getInfoIndCon.php",
		success:function(data){
			console.log(data);
			$("#titulodetalle2").empty();
			$("#titulodetalle").empty();
			$("#titulodetalle2").append(data.titulo);
			$("#titulodetalle").append(data.titulo);

			fill_parte_grafico('Tono',1,data.tono,data.sum_tono);
			fill_parte_grafico('Apariencia',2,data.apariencia,data.sum_apariencia);
			fill_parte_grafico('Estabilidad Dimensional',3,data.estdim,data.sum_estdim);
			fill_parte_grafico('Defectos',4,data.defecto,data.sum_defecto);
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

function fill_parte_grafico(nombre,codpar,data,suma){
	var html='';
	let ar_labels=[];
	let ar_percents=[];
	let array_colors=[];
	for (var i = 0; i < data.length; i++) {
		let percent=parseInt(data[i]['PESO']*10000/parseInt(suma))/100;
		html+=
		'<div class="lineBody">'+
			'<div class="itemhs1 items4" style="width: calc(70% - 10px);text-align:left;">'+data[i]['RESPONSABLE']+'</div>'+
			'<div class="itemhs1 items4" style="width: calc(15% - 10px);">'+formatNumber(data[i]['PESO'])+'</div>'+
			'<div class="itemhs1 items4" style="width: calc(15% - 10px);">'+percent+'%</div>'+
		'</div>';
		ar_labels.push(data[i]['RESPONSABLE']);
		ar_percents.push(percent);
		array_colors.push(window.chartColorsArray[i]);
	}

	document.getElementById("chart"+codpar).innerHTML='<canvas id="chart-area'+codpar+'"></canvas>';
	var config = {
		type: 'doughnut',
		data: {
			datasets: [{
				data: ar_percents,
				backgroundColor: array_colors,
				label: 'Defectos'
			}],
			labels: ar_labels
		},
		options: {
			responsive: true,
			legend: {
				display:displayLegend,
				position: 'right'
			},
			title: {
				display: true,
				text: 'Responsable por '+nombre
			},
			plugins: {
				labels: {
				    render: 'percentage',
				    fontColor: 'black',
				    precision: 2
				},
				datalabels: {
					formatter: function(value, context) {
						var total=0;
						for (var i = 0; i < context.dataset.data.length; i++) {
							total+=parseFloat(context.dataset.data[i]);
						}
						return Math.round(value*10000/total)/100+"%";
					},
					font:{
						weight:600
					},
					anchor:function(i) {
						if(i.dataIndex%2==0){
							return 'center';
						}else{
							return 'end';
						}
					}
				}
			}
		}
	};

	var ctx = document.getElementById('chart-area'+codpar).getContext('2d');
	window.myPie2 = new Chart(ctx, config);

	$("#table-res-"+codpar).empty();
	$("#table-res-"+codpar).append(html);
}