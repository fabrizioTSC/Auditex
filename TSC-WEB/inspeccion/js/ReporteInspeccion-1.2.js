var listaTalleres=[];
$(document).ready(function(){
	var widWin=window.innerWidth;
	var heiWin=window.innerHeight;
	$(window).resize(function(){
		if (heiWin==window.innerWidth || widWin==window.innerHeight) {
			if (dataTotal.length!=0) {
				var data=dataTotal;
				var array_labels=[];
				var array_values=[];
				var array_colors=[];

				var sumdet1=0;
				var sumVal=0;
				for (var i = 0; i < data.detDefecto.detalle1.length; i++) {
					sumVal+=parseInt(data.detDefecto.detalle1[i].CANTIDAD);
					if (i<data.detDefecto.detalle1.length-1) {
						var porValue=Math.round(parseInt(data.detDefecto.detalle1[i].CANTIDAD)*100/data.detDefecto.sumDetalle);
						array_labels.push(data.detDefecto.detalle1[i].DSCSUBFAMILIA+": "+porValue+"%");
						array_values.push(porValue);
						sumdet1+=parseInt(porValue);
						array_colors.push(window.chartColorsArray[i]);
					}else{
						var porValue=Math.round(sumVal*100/data.detDefecto.sumDetalle)-sumdet1;
						array_labels.push(data.detDefecto.detalle1[i].DSCSUBFAMILIA+": "+porValue+"%");
						array_values.push(porValue);
						sumdet1+=parseInt(porValue);
						array_colors.push(window.chartColorsArray[i]);
					}
				}
				$("#valcandefDet1").text(sumVal);
				$("#porDefDet1").text(sumdet1+"%");

				var porValue=Math.round(parseInt(data.detDefecto.sumDetalle)*100/data.detDefecto.sumDetalle)-sumdet1;
				array_labels.push("OTROS: "+porValue+"%");
				array_values.push(porValue);
				array_colors.push('rgb(200,200,200)');


				var displayLegend=true;
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
				var config = {
					type: 'doughnut',
					data: {
						datasets: [{
							data: array_values,
							backgroundColor: array_colors,
							label: 'Defectos'
						}],
						labels: array_labels
					},
					options: {
						responsive: true,
						legend: {
							display:displayLegend,
							position: 'right'
						},
						title: {
							display: true,
							text: 'DEFECTOS CONSTRUCCIÓN - LIMPIEZA/MANCHAS'
						},
						plugins: {
							labels: {
							    render: 'percentage',
							    fontColor: 'black',
							    precision: 2
							}
						}
					}
				};

				var ctx = document.getElementById('chart-area2').getContext('2d');
				window.myPie2 = new Chart(ctx, config);

				///////////////////////////////////////////////////////
				//GRAFICO DEFECTOS 2
				var array_labels=[];
				var array_values=[];
				var array_colors=[];

				var sumdet1=0;
				var sumVal=0;
				for (var i = 0; i < data.detDefecto.detalle2.length; i++) {
					sumVal+=parseInt(data.detDefecto.detalle2[i].CANTIDAD);
					if (i<data.detDefecto.detalle2.length-1) {
						var porValue=Math.round(parseInt(data.detDefecto.detalle2[i].CANTIDAD)*100/data.detDefecto.sumDetalle);
						array_labels.push(data.detDefecto.detalle2[i].DSCSUBFAMILIA+": "+porValue+"%");
						array_values.push(porValue);
						sumdet1+=parseInt(porValue);
						array_colors.push(window.chartColorsArray[i]);
					}else{
						var porValue=Math.round(sumVal*100/data.detDefecto.sumDetalle)-sumdet1;
						array_labels.push(data.detDefecto.detalle2[i].DSCSUBFAMILIA+": "+porValue+"%");
						array_values.push(porValue);
						sumdet1+=parseInt(porValue);
						array_colors.push(window.chartColorsArray[i]);
					}
				}
				$("#valcandefDet2").text(sumVal);
				$("#porDefDet2").text(sumdet1+"%");

				var porValue=sumdet1;
				array_labels.push("OTROS: "+porValue+"%");
				array_values.push(porValue);
				array_colors.push('rgb(200,200,200)');
				
				var config = {
					type: 'doughnut',
					data: {
						datasets: [{
							data: array_values,
							backgroundColor: array_colors,
							label: 'Defectos'
						}],
						labels: array_labels
					},
					options: {
						responsive: true,
						legend: {
							display:displayLegend,
							position: 'top'
						},
						title: {
							display: true,
							text: 'DEFECTOS TELAS - OTROS'
						},
						animation: {
							animateScale: true,
							animateRotate: true
						},
						plugins: {
							labels: {
							    render: 'percentage',
							    fontColor: 'black',
							    precision: 2
							}
						}
					}
				};

				var ctx = document.getElementById('chart-area3').getContext('2d');
				window.myPie2 = new Chart(ctx, config);
			}
		}
	});
	$("#selectOperaciones").change(function(){
		$.ajax({
			type:"POST",
			url:"config/getDetalleOperacionDef.php",
			data:{
				codtll:codtll_var,
				codope:$("#selectOperaciones").val()
			},
			success:function(data){
				//console.log(data);
				graphOpeDet(data.detalleOpe,data.nomDetOpe);
			}
		});
	});
	$("#selectDefectos").change(function(){
		$.ajax({
			type:"POST",
			url:"config/getDetalleDefectosOpe.php",
			data:{
				codtll:codtll_var,
				coddef:$("#selectDefectos").val()
			},
			success:function(data){
				//console.log(data);
				graphDefDet(data.detalleDef,data.nomDetDef);
			}
		});
	});
	$("#selectDefectosMaq").change(function(){
		$.ajax({
			type:"POST",
			url:"config/getDetalleDefectosOpeMaq.php",
			data:{
				codtll:codtll_var,
				coddef:$("#selectDefectosMaq").val()
			},
			success:function(data){
				//console.log(data);
				graphOpeMaq(data.detalleDef,data.nomDetDef);
			}
		});
	});
	$("#idLinea").keyup(function(){
		$(".listaTalleres").empty();
		var htmlTalleres="";
		var busqueda=document.getElementById("idLinea").value;
		for (var i = 0; i < listaTalleres.length; i++) {

			if ((listaTalleres[i].DESTLL.toUpperCase()).indexOf(busqueda.toUpperCase())>=0
				||(listaTalleres[i].CODTLL.toUpperCase()).indexOf(busqueda.toUpperCase())>=0) {				
				htmlTalleres+='<div class="taller" onclick="addWord(\''+formatText(listaTalleres[i].DESTLL)+'\',\''+listaTalleres[i].CODTLL+'\')">'
				+listaTalleres[i].CODTLL+' - '+listaTalleres[i].DESTLL+
				"</div>";
			}
		}
		$(".listaTalleres").append(htmlTalleres);
	});
	$.ajax({
		type:"POST",
		url:"config/getTalleresReporte.php",
		data:{
			request:"1"
		},
		success:function(data){
			console.log(data);
			$(".listaTalleres").empty();
			var htmlTalleres="";
			for (var i = 0; i < data.talleres.length; i++) {
				htmlTalleres+='<div class="taller" onclick="addWord(\''+formatText(data.talleres[i].DESTLL)+'\',\''+data.talleres[i].CODTLL+'\')">'+
				data.talleres[i].CODTLL+' - '+data.talleres[i].DESTLL+
				'</div>';
			}
			listaTalleres=data.talleres;
			$(".listaTalleres").append(htmlTalleres);
			
			$(".panelCarga").fadeOut(300);
		}
	});
});

function formatText(string){
	while(string.indexOf('"')>0){
		string=string.replace('"','');
	}
	while(string.indexOf('\'')>0){
		string=string.replace('\'','');
	}
	return string;
}

var codtll_var=0;
function addWord(word,codtll){
	$("#idNomLinea").text(word);
	$("#idLinea").val(word);
	codtll_var=codtll;
}

window.chartColors = {
	red: 'rgb(255, 99, 132)',
	orange: 'rgb(255, 159, 64)',
	yellow: 'rgb(255, 205, 86)',
	green: 'rgb(80, 200, 2)',
	blue: 'rgb(54, 162, 235)',
	purple: 'rgb(153, 102, 255)',
	grey: 'rgb(201, 203, 207)'
};
window.chartColorsArray = [
	'rgb(54, 162, 235)',
	'rgb(255, 50, 50)',
	'rgb(255, 159, 64)',
	'rgb(80, 200, 2)',
	'rgb(153, 102, 255)',
	'rgb(255, 205, 86)',
	'rgb(201, 203, 207)'
];

var interval;
function showReporte(){
	var linea =$("#idLinea").val();
	var tiempo =parseInt($("#idTiempo").val());
	if (linea=="" || codtll_var==0 || codtll_var=="") {
		alert("Debe seleccionar una linea de la tabla!");
	}else{
		$(".panelCarga").fadeIn(300);
		$.ajax({
			type:"POST",
			url:"config/getLineaInfo.php",
			data:{
				codtll:codtll_var
			},
			success:function(data){
				console.log(data);
				if (data.data) {
					showGraph(data);
					interval=setInterval(function(){
						chargeChart();
					},tiempo*1000*60);
				}else{
					alert("No hay defectos!");
				}
				$(".panelCarga").fadeOut(300);
			}
		});
	}
}

function chargeChart(){
	$(".panelCarga").fadeIn(300);
	$.ajax({
		type:"POST",
		url:"config/getLineaInfo.php",
		data:{
			codtll:codtll_var
		},
		success:function(data){
			console.log(data);
			if (data.data) {
				showGraph(data);
			}else{
				alert("No hay defectos!");
				clearInterval(interval);
			}
			$(".panelCarga").fadeOut(300);
		}
	});
}

var dataTotal=[];
function showGraph(data){
	dataTotal=data;
	$("#valcandef").text(data.datadef);
	$("#valCanPre").text(data.data.CANPRE);

	var prendasSinDef=(parseInt(data.data.CANPRE)-parseInt(data.data.CANPREDEF));

	$("#valCanPreSD").text(prendasSinDef);
	var pocpresdef=Math.round(prendasSinDef*100/parseInt(data.data.CANPRE),0);
	$("#perCanPreSD").text(pocpresdef+"%");

	$("#valCanPreD").text(data.data.CANPREDEF);
	var pocpredef=100-pocpresdef;
	$("#perCanPreD").text(pocpredef+"%");

	var config = {
		type: 'doughnut',
		data: {
			datasets: [{
				data: [
					data.data.CANPREDEF,
					prendasSinDef
				],
				backgroundColor: [
					window.chartColors.red,
					window.chartColors.green
				],
				label: 'Total prendas'
			}],
			labels: [
				'Tot. pren. defectuosas - '+pocpredef+'%',
				'Tot. pren. sin defecto - '+pocpresdef+'%'
			]
		},
		options: {
			responsive: true,
			legend: {
				position: 'top',
			},
			title: {
				display: true,
				text: 'PORCENTAJE DE PRENDAS DEFECTUOSAS'
			},
			animation: {
				animateScale: true,
				animateRotate: true
			},
			plugins: {
				datalabels: {
					formatter: function(value, context) {
						var total=0;
						for (var i = 0; i < context.dataset.data.length; i++) {
							total+=parseInt(context.dataset.data[i]);
						}
						return Math.round(value*100/total)+"%";
					},
					font:{
						weight:600
					}
				}
			}
		}
	};

	var ctx = document.getElementById('chart-area').getContext('2d');
	window.myPie = new Chart(ctx, config);

	$("#idTurno").text("1");
	var hoy=new Date();
	var dia=hoy.getDate();
	if (dia<10) {
		dia='0'+dia;
	}
	var mes=hoy.getMonth()+1;
	if (mes<10) {
		mes='0'+mes;
	}
	var anio=hoy.getFullYear();
	hoy=dia+"/"+mes+"/"+anio;
	$("#idFecha").text(hoy);
	$("#idFicha").text(data.detCliente.CODFIC);
	$("#idPedido").text(data.detCliente.PEDIDO);
	$("#idCliente").text(data.detCliente.DESCLI);
	$("#space1").css("display","none");
	$("#space2").css("display","block");

	///////////////////////////////////////////////////////
	//GRAFICO DEFECTOS 1
	var array_labels=[];
	var array_values=[];
	var array_colors=[];

	var sumdet1=0;
	var sumVal=0;
	for (var i = 0; i < data.detDefecto.detalle1.length; i++) {
		sumVal+=parseInt(data.detDefecto.detalle1[i].CANTIDAD);
		if (i<data.detDefecto.detalle1.length-1) {
			var porValue=Math.round(parseInt(data.detDefecto.detalle1[i].CANTIDAD)*100/data.detDefecto.sumDetalle);
			array_labels.push(data.detDefecto.detalle1[i].DSCSUBFAMILIA+": "+porValue+"%");
			array_values.push(porValue);
			sumdet1+=parseInt(porValue);
			array_colors.push(window.chartColorsArray[i]);
		}else{
			var porValue=Math.round(sumVal*100/data.detDefecto.sumDetalle)-sumdet1;
			array_labels.push(data.detDefecto.detalle1[i].DSCSUBFAMILIA+": "+porValue+"%");
			array_values.push(porValue);
			sumdet1+=parseInt(porValue);
			array_colors.push(window.chartColorsArray[i]);
		}
	}
	$("#valcandefDet1").text(sumVal);
	$("#porDefDet1").text(sumdet1+"%");

	var porValue=Math.round(parseInt(data.detDefecto.sumDetalle)*100/data.detDefecto.sumDetalle)-sumdet1;
	array_labels.push("OTROS: "+porValue+"%");
	array_values.push(porValue);
	array_colors.push('rgb(200,200,200)');


	var displayLegend=true;
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
	var config = {
		type: 'doughnut',
		data: {
			datasets: [{
				data: array_values,
				backgroundColor: array_colors,
				label: 'Defectos'
			}],
			labels: array_labels
		},
		options: {
			responsive: true,
			legend: {
				display:displayLegend,
				position: 'right'
			},
			title: {
				display: true,
				text: 'DEFECTOS CONSTRUCCIÓN - LIMPIEZA/MANCHAS'
			},
			animation: {
				animateScale: true,
				animateRotate: true
			},
			plugins: {
				datalabels: {
					formatter: function(value, context) {
						return Math.round(value)+"%";
					},
					font:{
						weight:600
					}
				}
			}
		}
	};

	var ctx = document.getElementById('chart-area2').getContext('2d');
	window.myPie2 = new Chart(ctx, config);

	///////////////////////////////////////////////////////
	//GRAFICO DEFECTOS 2
	var array_labels=[];
	var array_values=[];
	var array_colors=[];

	var sumdet1=0;
	var sumVal=0;
	for (var i = 0; i < data.detDefecto.detalle2.length; i++) {
		sumVal+=parseInt(data.detDefecto.detalle2[i].CANTIDAD);
		if (i<data.detDefecto.detalle2.length-1) {
			var porValue=Math.round(parseInt(data.detDefecto.detalle2[i].CANTIDAD)*100/data.detDefecto.sumDetalle);
			array_labels.push(data.detDefecto.detalle2[i].DSCSUBFAMILIA+": "+porValue+"%");
			array_values.push(porValue);
			sumdet1+=parseInt(porValue);
			array_colors.push(window.chartColorsArray[i]);
		}else{
			var porValue=Math.round(sumVal*100/data.detDefecto.sumDetalle)-sumdet1;
			array_labels.push(data.detDefecto.detalle2[i].DSCSUBFAMILIA+": "+porValue+"%");
			array_values.push(porValue);
			sumdet1+=parseInt(porValue);
			array_colors.push(window.chartColorsArray[i]);
		}
	}
	$("#valcandefDet2").text(sumVal);
	$("#porDefDet2").text(sumdet1+"%");

	var porValue=sumdet1;
	array_labels.push("OTROS: "+porValue+"%");
	array_values.push(porValue);
	array_colors.push('rgb(200,200,200)');
	
	var config = {
		type: 'doughnut',
		data: {
			datasets: [{
				data: array_values,
				backgroundColor: array_colors,
				label: 'Defectos'
			}],
			labels: array_labels
		},
		options: {
			responsive: true,
			legend: {
				display:displayLegend,
				position: 'top'
			},
			title: {
				display: true,
				text: 'DEFECTOS TELAS - OTROS'
			},
			animation: {
				animateScale: true,
				animateRotate: true
			},
			plugins: {
				datalabels: {
					formatter: function(value, context) {
						return Math.round(value)+"%";
					},
					font:{
						weight:600
					}
				}
			}
		}
	};

	var ctx = document.getElementById('chart-area3').getContext('2d');
	window.myPie2 = new Chart(ctx, config);

	var arlbl=[];
	var aropecan=[];
	var aropepor=[];
	var aropecol=[];
	var pos=0;
	var sumPor=0;
	var htmlselectOpe='';
	for (var i = 0; i < data.operaciones.length; i++) {
		arlbl.push(data.operaciones[i].DESOPE);
		aropecan.push(data.operaciones[i].CANTIDAD);
		var porc=Math.round(data.operaciones[i].CANTIDAD*10000/data.sumOpe)/100;
		aropecol.push(window.arrayColor[pos]);
		sumPor+=Math.round(porc*100)/100;
		if (sumPor>100) {
			sumPor=100;
		}
		aropepor.push(sumPor);
		if (sumPor>80) {
			pos=1;
		}
		htmlselectOpe+='<option value="'+data.operaciones[i].CODOPE+'">'+data.operaciones[i].DESOPE+'</option>';
	}
	$("#selectOperaciones").empty();
	$("#selectOperaciones").append(htmlselectOpe);
	processOpe1(arlbl,aropecan,aropepor,aropecol);
	graphOpeDet(data.detalleOpe,data.nomDetOpe);


	var arlbl=[];
	var aropecan=[];
	var aropepor=[];
	var aropecol=[];
	var pos=0;
	var sumPor=0;
	var htmlselectOpe='';
	for (var i = 0; i < data.defectos.length; i++) {
		arlbl.push(data.defectos[i].DESDEF);
		aropecan.push(data.defectos[i].CANTIDAD);
		var porc=Math.round(data.defectos[i].CANTIDAD*10000/data.sumDef)/100;
		aropecol.push(window.arrayColor[pos]);
		sumPor+=Math.round(porc*100)/100;
		if (sumPor>100) {
			sumPor=100;
		}
		aropepor.push(sumPor);
		if (sumPor>80) {
			pos=1;
		}
		htmlselectOpe+='<option value="'+data.defectos[i].CODDEF+'">'+data.defectos[i].DESDEF+'</option>';
	}
	$("#selectDefectos").empty();
	$("#selectDefectos").append(htmlselectOpe);

	processDef1(arlbl,aropecan,aropepor,aropecol);
	graphDefDet(data.detalleDef,data.nomDetDef);

	graphHomMaq(data.hommaq,data.tothommaq);

	var arlbl=[];
	var aropecan=[];
	var aropepor=[];
	var aropecol=[];
	var pos=0;
	var sumPor=0;
	var htmlselectOpe='';
	for (var i = 0; i < data.detdefmaq.length; i++) {
		arlbl.push(data.detdefmaq[i].DESDEF);
		aropecan.push(data.detdefmaq[i].CANTIDAD);
		var porc=Math.round(data.detdefmaq[i].CANTIDAD*10000/data.totdefmaq)/100;
		aropecol.push(window.arrayColor[pos]);
		sumPor+=Math.round(porc*100)/100;
		if (sumPor>100) {
			sumPor=100;
		}
		aropepor.push(sumPor);
		if (sumPor>80) {
			pos=1;
		}
		htmlselectOpe+='<option value="'+data.detdefmaq[i].CODDEF+'">'+data.detdefmaq[i].DESDEF+'</option>';
	}
	$("#selectDefectosMaq").empty();
	$("#selectDefectosMaq").append(htmlselectOpe);
	processDefMaq(arlbl,aropecan,aropepor,aropecol);

	graphOpeMaq(data.detopemaq,data.desdefmaq)
}

function backSpace1(){
	$("#space2").css("display","none");
	$("#space1").css("display","block");
	clearInterval(interval);
	document.getElementById('chart1').innerHTML='';
	document.getElementById('chart1').innerHTML='<canvas id="chart-area"></canvas>';	
	document.getElementById('chart2').innerHTML='';
	document.getElementById('chart2').innerHTML='<canvas id="chart-area2"></canvas>';
	document.getElementById('chart3').innerHTML='';
	document.getElementById('chart3').innerHTML='<canvas id="chart-area3"></canvas>';
	document.getElementById('chart4').innerHTML='';
	document.getElementById('chart4').innerHTML='<canvas id="chart-area4"></canvas>';
	document.getElementById('chart5').innerHTML='';
	document.getElementById('chart5').innerHTML='<canvas id="chart-area5"></canvas>';
	document.getElementById('chart6').innerHTML='';
	document.getElementById('chart6').innerHTML='<canvas id="chart-area6"></canvas>';
	document.getElementById('chart7').innerHTML='';
	document.getElementById('chart7').innerHTML='<canvas id="chart-area7"></canvas>';
	document.getElementById('chart8').innerHTML='';
	document.getElementById('chart8').innerHTML='<canvas id="chart-area8"></canvas>';
	document.getElementById('chart9').innerHTML='';
	document.getElementById('chart9').innerHTML='<canvas id="chart-area9"></canvas>';
	document.getElementById('chart10').innerHTML='';
	document.getElementById('chart10').innerHTML='<canvas id="chart-area10"></canvas>';
}

function exportar(){
	var a=document.createElement('a');
	a.target="_blank";
	a.href="config/export-ins/prueba.php";
	a.click();
}


window.arrayColor=['rgb(255,150,60)','rgb(240,200,160)'];

//// DETALLE CORREGIDO
function processOpe1(ar_lab,ar_opeCan,ar_opePor,ar_opeCol){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'line',
			borderColor: window.chartColors.red,
			data: ar_opePor,
			label: 'Acumulado',
			yAxisID: 'y-axis-2',
			lineTension: 0,
			fill: false,
			datalabels: {
				align: 'right',
				anchor: 'end'
			}
		}, {
			type: 'bar',
			backgroundColor: ar_opeCol,
			label: 'Frecuencia',
			yAxisID: 'y-axis-1',
			data: ar_opeCan,
			datalabels: {
				align: 'left',
				anchor: 'end'
			}
		}]
	};
	var ctx2 = document.getElementById('chart-area4').getContext('2d');
	window.myMixedChart = new Chart(ctx2, {
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
						suggestedMax: 100
					}
				}]
			},
			plugins: {
				datalabels: {
					formatter: function(value, context) {
						if (context.dataset.type=="line") {
							return Math.round(value)+"%";
						}else{
							return Math.round(value);
						}
					},
					font:{
						weight:600
					}
				}
			}
			/*,
			plugins: {
				labels: {
					render:function(data){
						if (data.dataset.type=="line") {
	                        return Math.round(data.value)+"%";
	                    }else{
	                    	return data.value;
	                    }
					},
				    fontColor: 'black',
				    precision: 2
				}
			}*/
		}
	});
}

function graphOpeDet(opedet,nombre_ope){
	var array_values=[];
	var array_colors=[];
	var array_labels=[];

	var sumTotal=0;
	for (var i = 0; i < opedet.length; i++) {
		sumTotal+=parseInt(opedet[i].CANTIDAD);
	}

	for (var i = 0; i < opedet.length; i++) {
		array_values.push(opedet[i].CANTIDAD);
		array_colors.push(window.chartColorsArray[i]);
		var desdef=opedet[i].DESDEF;
		if (desdef.length>15) {
			desdef=desdef.substr(0,15)+"...";
		}
		array_labels.push(desdef+" - "+Math.round(opedet[i].CANTIDAD*100/sumTotal)+"%");
	}

	var config = {
		type: 'doughnut',
		data: {
			datasets: [{
				data: array_values,
				backgroundColor: array_colors,
				label: 'Defectos'
			}],
			labels: array_labels
		},
		options: {
			responsive: true,
			legend: {
				position: 'right',
			},
			title: {
				display: true,
				text: nombre_ope
			},
			animation: {
				animateScale: true,
				animateRotate: true
			},
			plugins: {
				datalabels: {
					formatter: function(value, context) {
						var total=0;
						for (var i = 0; i < context.dataset.data.length; i++) {
							total+=parseInt(context.dataset.data[i]);
						}
						return Math.round(value*100/total)+"%";
					},
					font:{
						weight:600
					}
				}
			}
		}
	};

	var ctx = document.getElementById('chart-area5').getContext('2d');
	window.myPie2 = new Chart(ctx, config);
}

function processDef1(ar_lab,ar_opeCan,ar_opePor,ar_opeCol){
	var chartData = {
		labels: ar_lab,/*
		datasets: [{
			type: 'line',
			label: 'Acumulado',
			borderColor: window.chartColors.red,
			borderWidth: 2,
			fill: false,
			data: ar_opePor,
			yAxisID: 'y-axis-2',
			lineTension: 0
		}, {
			type: 'bar',
			backgroundColor: ar_opeCol,
			label: 'Frecuencia',
			yAxisID: 'y-axis-1',
			data: ar_opeCan
		}]*/
		datasets: [{
			type: 'line',
			borderColor: window.chartColors.red,
			data: ar_opePor,
			label: 'Acumulado',
			yAxisID: 'y-axis-2',
			lineTension: 0,
			fill: false,
			datalabels: {
				align: 'right',
				anchor: 'end'
			}
		}, {
			type: 'bar',
			backgroundColor: ar_opeCol,
			label: 'Frecuencia',
			yAxisID: 'y-axis-1',
			data: ar_opeCan,
			datalabels: {
				align: 'left',
				anchor: 'end'
			}
		}]
	};
	var ctx = document.getElementById('chart-area6').getContext('2d');
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
			plugins: {
				datalabels: {
					formatter: function(value, context) {
						if (context.dataset.type=="line") {
							return Math.round(value)+"%";
						}else{
							return Math.round(value);
						}
					},
					font:{
						weight:600
					}
				}
				/*
				labels: {
					render:function(data){
						if (data.dataset.type=="line") {
	                        return Math.round(data.value)+"%";
	                    }else{
	                    	return data.value;
	                    }
					},
				    fontColor: 'black',
				    precision: 2
				}*/
			}
		}
	});
}

function graphDefDet(defdet,nombre_def){
	var array_values=[];
	var array_colors=[];
	var array_labels=[];

	var sumTotal=0;
	for (var i = 0; i < defdet.length; i++) {
		sumTotal+=parseInt(defdet[i].CANTIDAD);
	}

	for (var i = 0; i < defdet.length; i++) {
		array_values.push(defdet[i].CANTIDAD);
		array_colors.push(window.chartColorsArray[i]);
		var desope=defdet[i].DESOPE;
		if (desope.length>15) {
			desope=desope.substr(0,15)+"...";
		}
		array_labels.push(desope+" - "+Math.round(defdet[i].CANTIDAD*100/sumTotal)+"%");
	}

	var config = {
		type: 'doughnut',
		data: {
			datasets: [{
				data: array_values,
				backgroundColor: array_colors,
				label: 'Defectos'
			}],
			labels: array_labels
		},
		options: {
			responsive: true,
			legend: {
				position: 'right',
			},
			title: {
				display: true,
				text: nombre_def
			},
			animation: {
				animateScale: true,
				animateRotate: true
			},
			plugins: {
				datalabels: {
					formatter: function(value, context) {
						var total=0;
						for (var i = 0; i < context.dataset.data.length; i++) {
							total+=parseInt(context.dataset.data[i]);
						}
						return Math.round(value*100/total)+"%";
					},
					font:{
						weight:600
					}
				}
			}
		}
	};

	var ctx = document.getElementById('chart-area7').getContext('2d');
	window.myPie2 = new Chart(ctx, config);
}

function graphHomMaq(hommaq,tothommaq){
	var array_values=[];
	var array_colors=[];
	var array_labels=[];

	for (var i = 0; i < hommaq.length; i++) {
		array_values.push(hommaq[i].CANTIDAD);
		array_colors.push(window.chartColorsArray[i]);
		array_labels.push(hommaq[i].DSCTIPODEF+" - "+Math.round(hommaq[i].CANTIDAD*100/tothommaq)+"%");
	}

	var config = {
		type: 'doughnut',
		data: {
			datasets: [{
				data: array_values,
				backgroundColor: array_colors,
				label: 'Defectos'
			}],
			labels: array_labels
		},
		options: {
			responsive: true,
			legend: {
				position: 'right',
			},
			animation: {
				animateScale: true,
				animateRotate: true
			},
			plugins: {
				datalabels: {
					formatter: function(value, context) {
						var total=0;
						for (var i = 0; i < context.dataset.data.length; i++) {
							total+=parseInt(context.dataset.data[i]);
						}
						return Math.round(value*100/total)+"%";
					},
					font:{
						weight:600
					}
				}
			}
		}
	};

	var ctx = document.getElementById('chart-area8').getContext('2d');
	window.myPie2 = new Chart(ctx, config);
}

function processDefMaq(ar_lab,ar_Can,ar_Por,ar_Col){
	var chartData = {
		labels: ar_lab,/*
		datasets: [{
			type: 'line',
			label: 'Acumulado',
			borderColor: window.chartColors.red,
			borderWidth: 2,
			fill: false,
			data: ar_Por,
			yAxisID: 'y-axis-2',
			lineTension: 0
		}, {
			type: 'bar',
			backgroundColor: ar_Col,
			label: 'Frecuencia',
			yAxisID: 'y-axis-1',
			data: ar_Can
		}]*/
		datasets: [{
			type: 'line',
			borderColor: window.chartColors.red,
			data: ar_Por,
			label: 'Acumulado',
			yAxisID: 'y-axis-2',
			lineTension: 0,
			fill: false,
			datalabels: {
				align: 'right',
				anchor: 'end'
			}
		}, {
			type: 'bar',
			backgroundColor: ar_Col,
			label: 'Frecuencia',
			yAxisID: 'y-axis-1',
			data: ar_Can,
			datalabels: {
				align: 'left',
				anchor: 'end'
			}
		}]
	};
	var ctx = document.getElementById('chart-area9').getContext('2d');
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
			plugins: {
				datalabels: {
					formatter: function(value, context) {
						if (context.dataset.type=="line") {
							return Math.round(value)+"%";
						}else{
							return Math.round(value);
						}
					},
					font:{
						weight:600
					}
				}
			}
		}
	});
}

function graphOpeMaq(opedet,nombre_ope){
	var array_values=[];
	var array_colors=[];
	var array_labels=[];

	var sumTotal=0;
	for (var i = 0; i < opedet.length; i++) {
		sumTotal+=parseInt(opedet[i].CANTIDAD);
	}

	for (var i = 0; i < opedet.length; i++) {
		array_values.push(opedet[i].CANTIDAD);
		array_colors.push(window.chartColorsArray[i]);
		var desope=opedet[i].DESOPE;
		if (desope.length>15) {
			desope=desope.substr(0,15)+"...";
		}
		array_labels.push(desope+" - "+Math.round(opedet[i].CANTIDAD*100/sumTotal)+"%");
	}

	var config = {
		type: 'doughnut',
		data: {
			datasets: [{
				data: array_values,
				backgroundColor: array_colors,
				label: 'Defectos'
			}],
			labels: array_labels
		},
		options: {
			responsive: true,
			legend: {
				position: 'right',
			},
			title: {
				display: true,
				text: nombre_ope
			},
			animation: {
				animateScale: true,
				animateRotate: true
			},
			plugins: {
				datalabels: {
					formatter: function(value, context) {
						var total=0;
						for (var i = 0; i < context.dataset.data.length; i++) {
							total+=parseInt(context.dataset.data[i]);
						}
						return Math.round(value*100/total)+"%";
					},
					font:{
						weight:600
					}
				}
			}
		}
	};

	var ctx = document.getElementById('chart-area10').getContext('2d');
	window.myPie2 = new Chart(ctx, config);
}

function downloadPDF(){
	$.ajax({
	  	type: "POST",
	  	url: "config/saveTmpImgReporte.php",
	  	data: { 
	    	img1: document.getElementById("chart-area").toDataURL("image/png"),
	    	img2: document.getElementById("chart-area2").toDataURL("image/png"),
	    	img3: document.getElementById("chart-area3").toDataURL("image/png"),
	    	img4: document.getElementById("chart-area4").toDataURL("image/png"),
	    	img5: document.getElementById("chart-area5").toDataURL("image/png"),
	    	img6: document.getElementById("chart-area6").toDataURL("image/png"),
	    	img7: document.getElementById("chart-area7").toDataURL("image/png"),
	    	img8: document.getElementById("chart-area8").toDataURL("image/png"),
	    	img9: document.getElementById("chart-area9").toDataURL("image/png"),
	    	img10: document.getElementById("chart-area10").toDataURL("image/png"),
			codtll:codtll_var,
			codusu:codusu
	  	},
	  	success:function(data){
	  		var codfic=dataTotal.detCliente.CODFIC;
	  		var descli=dataTotal.detCliente.DESCLI;
	  		var pedido=dataTotal.detCliente.PEDIDO;
	  		var nomtll=$("#idNomLinea").text();
	  		var a=document.createElement("a");
	  		a.target="_blank";
	  		a.href="fpdf/pdfReporteMonitor.php?"+
	  			"n="+data+
	  			"&cf="+codfic+
	  			"&dc="+descli+
	  			"&p="+pedido+
	  			"&nt="+nomtll+
	  			"&ct="+codtll_var;
	  		a.click();
	  	}
	}).done(function(o) {
	  	console.log('Imagenes guardadas!'); 
	});
}