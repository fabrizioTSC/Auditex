var values1=[];
var values2=[];
var values3=[];
var values4=[];
var values5=[];
var values6=[];
var values7=[];
var values8=[];
var values9=[];
var pormin1=0;
var pormin2=0;
var pormin3=0;
var pormin4=0;
var pormin5=0;
var pormin6=0;
var pormin7=0;
var pormin8=0;
var pormin9=0;

function fillArray(codclarec,por){
	switch(codclarec){
		case "1":
			values1.push(por);
			if (pormin1==0) {
				pormin1=por;
			}else{
				if (pormin1>por) {
					pormin1=por;					
				}
			}
		break;
		case "2":
			values2.push(por);
			if (pormin2==0) {
				pormin2=por;
			}else{
				if (pormin2>por) {
					pormin2=por;					
				}
			}
		break;
		case "3":
			values3.push(por);
			if (pormin3==0) {
				pormin3=por;
			}else{
				if (pormin3>por) {
					pormin3=por;					
				}
			}
		break;
		case "4":
			values4.push(por);
			if (pormin4==0) {
				pormin4=por;
			}else{
				if (pormin4>por) {
					pormin4=por;					
				}
			}
		break;
		case "5":
			values5.push(por);
			if (pormin5==0) {
				pormin5=por;
			}else{
				if (pormin5>por) {
					pormin5=por;					
				}
			}
		break;
		case "6":
			values6.push(por);
			if (pormin6==0) {
				pormin6=por;
			}else{
				if (pormin6>por) {
					pormin6=por;					
				}
			}
		break;
		case "7":
			values7.push(por);
			if (pormin7==0) {
				pormin7=por;
			}else{
				if (pormin7>por) {
					pormin7=por;					
				}
			}
		break;
		case "8":
			values8.push(por);
			if (pormin8==0) {
				pormin8=por;
			}else{
				if (pormin8>por) {
					pormin8=por;					
				}
			}
		break;
		case "9":
			values9.push(por);
			if (pormin9==0) {
				pormin9=por;
			}else{
				if (pormin9>por) {
					pormin9=por;					
				}
			}
		break;
		default:break;
	}
}

function getArrayvalues(pos){
	switch((pos+1).toString()){
		case "1":return values1;
		break;
		case "2":return values2;
		break;
		case "3":return values3;
		break;
		case "4":return values4;
		break;
		case "5":return values5;
		break;
		case "6":return values6;
		break;
		case "7":return values7;
		break;
		case "8":return values8;
		break;
		case "9":return values9;
		break;
		default:return [];
		break;
	}	
}
function getporminvalue(pos){
	switch((pos+1).toString()){
		case "1":return pormin1;
		break;
		case "2":return pormin2;
		break;
		case "3":return pormin3;
		break;
		case "4":return pormin4;
		break;
		case "5":return pormin5;
		break;
		case "6":return pormin6;
		break;
		case "7":return pormin7;
		break;
		case "8":return pormin8;
		break;
		case "9":return pormin9;
		break;
		default:return 0;
		break;
	}	
}

var ultimomes=[];
var ultimosem=[];

var titulo_var="";
var titulo_mes="";
var titulo_sem="";
$(document).ready(function(){
	$.ajax({
		type:"POST",
		data:{
			codtll:codtll,
			codtipser:codtipser,
			codsede:codsede
		},
		url:"config/getInfoIndicadoresClasiFicha.php",
		success:function(data){
			console.log(data);
			var labels=[];
			var colors=[];
			titulo_var=data.titulo;
			$("#spacetitulo").text(data.titulo);
			$("#spacetitulo-2").text(data.titulo);

			$("#idHeaderLateral").empty();
			var html='<div class="items1 maxHeight">DETALLE GENERAL</div>';
			for (var i = 0; i < data.clasi.length; i++) {
				html+='<div class="items1 items2 maxHeight">'+data.clasi[i].DESCLAREC+'</div>'+
				'<div class="items1 items2 maxHeight">% '+data.clasi[i].DESCLAREC+'</div>';
			}
			html+='<div class="items1">TOTAL</div>';
			$("#idHeaderLateral").append(html);
			var anio_ant="";
			var pos_sum=0;
			html="";
			for (var i = 0; i < data.anios.length; i++) {
				if (anio_ant=="") {
					var por=Math.round((data.anios[i]['CANPRE']/data.sumaAnios[pos_sum])*10000)/100;
					html+=
						'<div class="divanios'+pos_sum+'">'+
							'<div class="itemhs1 maxHeight">'+data.anios[i]['ANHO']+'</div>'+
							'<div class="itemhs1 items4 maxHeight">'+formatNumber(data.anios[i]['CANPRE'])+'</div>'+
							'<div class="itemhs1 items4 maxHeight">'+por+'%</div>';
					anio_ant=data.anios[i]['ANHO'];
					labels.push(data.anios[i]['ANHO']);
					colors.push(window.chartColors.blue);
					fillArray(data.anios[i].CODCLAREC,por);
				}else{
					if (data.anios[i]['ANHO']==anio_ant) {
						var por=Math.round((data.anios[i]['CANPRE']/data.sumaAnios[pos_sum])*10000)/100;
						html+=
							'<div class="itemhs1 items4 maxHeight">'+formatNumber(data.anios[i]['CANPRE'])+'</div>'+
							'<div class="itemhs1 items4 maxHeight">'+por+'%</div>';
						fillArray(data.anios[i].CODCLAREC,por);
					}else{
						labels.push(data.anios[i]['ANHO']);
						colors.push(window.chartColors.blue);
						pos_sum++;
						var por=Math.round((data.anios[i]['CANPRE']/data.sumaAnios[pos_sum])*10000)/100;
						html+=							
							'<div class="itemhs1">'+formatNumber(data.sumaAnios[pos_sum-1])+'</div>'+
						'</div>'+
						'<div class="divanios'+pos_sum+'">'+
							'<div class="itemhs1 maxHeight">'+data.anios[i]['ANHO']+'</div>'+
							'<div class="itemhs1 items4 maxHeight">'+formatNumber(data.anios[i]['CANPRE'])+'</div>'+
							'<div class="itemhs1 items4 maxHeight">'+por+'%</div>';
						anio_ant=data.anios[i]['ANHO'];
						fillArray(data.anios[i].CODCLAREC,por);
					}
				}
			}html+=
					'<div class="itemhs1">'+formatNumber(data.sumaAnios[pos_sum])+'</div>'+
				'</div>';
			$("#placeAnios").append(html);

			titulo_mes=" ("+data.lastMes.substr(0,4)+" - "+proceMesLarge(data.lastMes.substr(4,5))+")";

			lastMes=data.lastMes;
			var anio_ant="";
			var pos_sum=0;
			html="";
			for (var i = 0; i < data.meses.length; i++) {
				if (anio_ant=="") {
					labels.push(proceMes(data.meses[i]['ANHO_MES'].substr(4,5)));
					colors.push(window.chartColors.orange);
					var por=Math.round((data.meses[i]['CANPRE']/data.sumaMeses[pos_sum])*10000)/100;
					html+=
						'<div class="divanios'+pos_sum+'">'+
							'<div class="itemhs1 maxHeight">'+proceMes(data.meses[i]['ANHO_MES'].substr(4,5))+'</div>'+
							'<div class="itemhs1 items4 maxHeight">'+formatNumber(data.meses[i]['CANPRE'])+'</div>'+
							'<div class="itemhs1 items4 maxHeight">'+por+'%</div>';
					anio_ant=data.meses[i]['ANHO_MES'];
					fillArray(data.meses[i].CODCLAREC,por);
					fillResMain("mes",data.meses[i]['ANHO_MES'],data.meses[i]['DESCLAREC'],por,data.meses[i].CODCLAREC);
				}else{
					if (data.meses[i]['ANHO_MES']==anio_ant) {
						var por=Math.round((data.meses[i]['CANPRE']/data.sumaMeses[pos_sum])*10000)/100;
						html+=
							'<div class="itemhs1 items4 maxHeight">'+formatNumber(data.meses[i]['CANPRE'])+'</div>'+
							'<div class="itemhs1 items4 maxHeight">'+por+'%</div>';
						fillArray(data.meses[i].CODCLAREC,por);
						fillResMain("mes",data.meses[i]['ANHO_MES'],data.meses[i]['DESCLAREC'],por,data.meses[i].CODCLAREC);
					}else{
						labels.push(proceMes(data.meses[i]['ANHO_MES'].substr(4,5)));
						colors.push(window.chartColors.orange);
						pos_sum++;
						var por=Math.round((data.meses[i]['CANPRE']/data.sumaMeses[pos_sum])*10000)/100;
						html+=							
							'<div class="itemhs1">'+formatNumber(data.sumaMeses[pos_sum-1])+'</div>'+
						'</div>'+
						'<div class="divanios'+pos_sum+'">'+
							'<div class="itemhs1 maxHeight">'+proceMes(data.meses[i]['ANHO_MES'].substr(4,5))+'</div>'+
							'<div class="itemhs1 items4 maxHeight">'+formatNumber(data.meses[i]['CANPRE'])+'</div>'+
							'<div class="itemhs1 items4 maxHeight">'+por+'%</div>';
						anio_ant=data.meses[i]['ANHO_MES'];
						fillArray(data.meses[i].CODCLAREC,por);
						fillResMain("mes",data.meses[i]['ANHO_MES'],data.meses[i]['DESCLAREC'],por,data.meses[i].CODCLAREC);
					}
				}
			}html+=
					'<div class="itemhs1">'+formatNumber(data.sumaMeses[pos_sum])+'</div>'+
				'</div>';
			$("#placeMeses").append(html);

			titulo_sem=" ("+data.lastMes.substr(0,4)+" - Sem. "+data.lastSem+")";

			lastSem=data.lastSem;
			var anio_ant="";
			var pos_sum=0;
			html="";
			for (var i = 0; i < data.semanas.length; i++) {
				if (anio_ant=="") {
					labels.push("S. "+data.semanas[i]['NUMERO_SEMANA']);
					colors.push(window.chartColors.green);
					var por=Math.round((data.semanas[i]['CANPRE']/data.sumaSemanas[pos_sum])*10000)/100;
					html+=
						'<div class="divanios'+pos_sum+'">'+
							'<div class="itemhs1 maxHeight">S. '+data.semanas[i]['NUMERO_SEMANA']+'</div>'+
							'<div class="itemhs1 items4 maxHeight">'+formatNumber(data.semanas[i]['CANPRE'])+'</div>'+
							'<div class="itemhs1 items4 maxHeight">'+por+'%</div>';
					anio_ant=data.semanas[i]['NUMERO_SEMANA'];
					fillArray(data.semanas[i].CODCLAREC,por);
					fillResMain("sem",data.semanas[i]['NUMERO_SEMANA'],data.semanas[i]['DESCLAREC'],por,data.semanas[i].CODCLAREC);
				}else{
					if (data.semanas[i]['NUMERO_SEMANA']==anio_ant) {
						var por=Math.round((data.semanas[i]['CANPRE']/data.sumaSemanas[pos_sum])*10000)/100;
						html+=
							'<div class="itemhs1 items4 maxHeight">'+formatNumber(data.semanas[i]['CANPRE'])+'</div>'+
							'<div class="itemhs1 items4 maxHeight">'+por+'%</div>';
						fillArray(data.semanas[i].CODCLAREC,por);						
						fillResMain("sem",data.semanas[i]['NUMERO_SEMANA'],data.semanas[i]['DESCLAREC'],por,data.semanas[i].CODCLAREC);
					}else{
						labels.push("S. "+data.semanas[i]['NUMERO_SEMANA']);
						colors.push(window.chartColors.green);
						pos_sum++;
						var por=Math.round((data.semanas[i]['CANPRE']/data.sumaSemanas[pos_sum])*10000)/100;
						html+=							
							'<div class="itemhs1">'+formatNumber(data.sumaSemanas[pos_sum-1])+'</div>'+
						'</div>'+
						'<div class="divanios'+pos_sum+'">'+
							'<div class="itemhs1 maxHeight">S. '+data.semanas[i]['NUMERO_SEMANA']+'</div>'+
							'<div class="itemhs1 items4 maxHeight">'+formatNumber(data.semanas[i]['CANPRE'])+'</div>'+
							'<div class="itemhs1 items4 maxHeight">'+por+'%</div>';
						anio_ant=data.semanas[i]['NUMERO_SEMANA'];
						fillArray(data.semanas[i].CODCLAREC,por);
						fillResMain("sem",data.semanas[i]['NUMERO_SEMANA'],data.semanas[i]['DESCLAREC'],por,data.semanas[i].CODCLAREC);
					}
				}
			}html+=
					'<div class="itemhs1">'+formatNumber(data.sumaSemanas[pos_sum])+'</div>'+
				'</div>';
			$("#placeSemanas").append(html);

			for (var i = 0; i < data.clasi.length; i++) {
				var array=getArrayvalues(i);
				//console.log(array);
				if(i==0){
					processGraph(labels,array,colors,data.clasi[i].DESCLAREC,i,100);
				}else{
					$("#spaceForGraph"+(i+1)).css("display","block");
					processGraph(labels,array,colors,data.clasi[i].DESCLAREC,i,getporminvalue(i));
				}
			}
			graphAdded(ultimomes,"mes");
			graphAdded(ultimosem,"sem");
			$(".panelCarga").fadeOut(100);
		}
	});
});

var lastMes="";
var lastSem="";
function fillResMain(option,place_time,label,value,codclarec){
	if (codclarec!="1") {
		if (option=="mes") {
			if (place_time==lastMes) {
				var aux=[];
				aux.push(label);
				aux.push(value);
				ultimomes.push(aux);
			}		
		}else{
			if (place_time==lastSem) {
				var aux=[];
				aux.push(label);
				aux.push(value);
				ultimosem.push(aux);
			}			
		}
	}
}

function processGraph(ar_lab,ar_val,ar_color,titulo,pos,max){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'bar',
			backgroundColor:ar_color,
			data: ar_val
		}]
	};
	var ctx = document.getElementById('chart-area'+(pos+1)).getContext('2d');
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
					}
				}],
				yAxes: [{
					display: true,
					scaleLabel: {
						display: false
					},
					ticks: {
						suggestedMin: 0,
						suggestedMax: max
					}
				}]
			},
			title: {
				display: true,
				text: titulo
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
}

function graphAdded(array,option){
	var titulo="Detalle último mes"+titulo_mes;
	var color=window.chartColors.orange;
	if (option=="sem") {
		titulo="Detalle última semana"+titulo_sem;
		color=window.chartColors.green;
	}
	var ar_lab=[];
	var ar_val=[];
	var max=0;
	for (var i = 0; i < array.length; i++) {
		ar_lab.push(array[i][0]);
		ar_val.push(array[i][1]);
		if (parseFloat(array[i][1])>max) {
			max=parseFloat(array[i][1]);
		}
	}

	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'bar',
			backgroundColor:color,
			data: ar_val
		}]
	};
	var ctx = document.getElementById('chart-area'+option).getContext('2d');
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
					}
				}],
				yAxes: [{
					display: true,
					scaleLabel: {
						display: false
					},
					ticks: {
						suggestedMin: 0,
						suggestedMax: max
					}
				}]
			},
			title: {
				display: true,
				text: titulo
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
}

function exportar(codtll,codsede,codtipser){
	window.location.href="config/exports/exportReportClasiFicha.php?codtll="+
	codtll+"&codsede="+codsede+"&codtipser="+codtipser+"&titulo="+titulo_var;
}
function format_mes(text){
	var res=""+(parseInt(text)+1);
	if (res.lenght==1) {
		res="0"+res;
	}
	return res;
}
function format_dia(text){
	var res=""+text;
	if (res.lenght==1) {
		res="0"+res;
	}
	return res;
}

function downloadPDF(){
	var a=new Date();
	var name=a.getFullYear()+format_mes(a.getMonth())+format_dia(a.getDate())+a.getHours()+a.getMinutes()+a.getSeconds();
	console.log(name);
	$.ajax({
	  	type: "POST",
	  	url: "config/saveTmpImgIndClasi.php",
	  	data: { 
	    	img1: document.getElementById("chart-areames").toDataURL("image/png"),
	    	img2: document.getElementById("chart-areasem").toDataURL("image/png"),
	    	img3: document.getElementById("chart-area1").toDataURL("image/png"),
	    	img4: document.getElementById("chart-area2").toDataURL("image/png"),
	    	img5: document.getElementById("chart-area3").toDataURL("image/png"),
	    	img6: document.getElementById("chart-area4").toDataURL("image/png"),
	    	img7: document.getElementById("chart-area5").toDataURL("image/png"),
	    	img8: document.getElementById("chart-area6").toDataURL("image/png"),
			
	    	img9: document.getElementById("chart-area7").toDataURL("image/png"),
	    	img10: document.getElementById("chart-area8").toDataURL("image/png"),
	    	img11: document.getElementById("chart-area9").toDataURL("image/png"),
	    	img12: document.getElementById("chart-area10").toDataURL("image/png"),
	    	img13: document.getElementById("chart-area11").toDataURL("image/png"),
	    	img14: document.getElementById("chart-area12").toDataURL("image/png"),
			name:name
	  	},
	  	success:function(data){
	  		console.log(data);
	  		if (data) {
		  		var title=$("#spacetitulo").html();
		  		var a=document.createElement("a");
		  		a.target="_blank";
		  		a.href="fpdf/crearPdfIndClasi.php?t="+title+"&ct="+codtll+"&cts="+codtipser+"&cs="+codsede+"&name="+name;
		  		a.click();
		  	}
	  	}
	}).done(function(o) {
	  	console.log('Images Saved!'); 
	});
}