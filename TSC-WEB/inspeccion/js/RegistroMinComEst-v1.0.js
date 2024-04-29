function formatDate(date,type){
	var search="/";
	if (date.indexOf(search)<0) {
		search="-";
	}
	var fecha=date.split(search);
	if(type==0){
		var anio=parseInt(fecha[2]);
		console.log(anio);
		if (anio>2000) {
			fecha=fecha[0]+search+mes_strtonum(fecha[1])+search+(anio);
		}else{
			fecha=fecha[0]+search+mes_strtonum(fecha[1])+search+(anio+2000);
		}
		return fecha;
	}
}

function mes_strtonum(value){
	switch(value){
		case 'ENE':
		case 'JAN':
			return '01';
			break;
		case 'FEB':
			return '02';
			break;
		case 'MAR':
			return '03';
			break;
		case 'ABR':
		case 'APR':
			return '04';
			break;
		case 'MAY':
			return '05';
			break;
		case 'JUN':
			return '06';
			break;
		case 'JUL':
			return '07';
			break;
		case 'AGO':
		case 'AUG':
			return '08';
			break;
		case 'SET':
		case 'SEP':
			return '09';
			break;
		case 'OCT':
			return '10';
			break;
		case 'NOV':
			return '11';
			break;
		case 'DIC':
		case 'DEC':
			return '12';
			break;
		default:
			return value;
			break;
	}
}

function format_null(text){
	if (text==null) {
		return "";
	}else{
		return text;
	}
}

function get_esttsc(){
	$(".panelCarga").fadeIn(200);
	$.ajax({
		url:"config/getMinAsiComEst.php",
		type:"POST",
		data:{			
			esttsc:$("#idesttsc").val()
		},
		success:function(data){
			console.log(data);
			if (data.state) {
				fill_fichas(data.esttsc);
				$("#tbl-generate").css("display","block");
			}else{
				$("#tbl-generate").css("display","none");
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(200);
		}
	});
}

function fill_fichas(data){
	var html='';
	for (var i = 0; i < data.length; i++) {
		html+=
			'<div class="tbl-linea">'+
				'<div class="body-tbl tbl-in4" style="padding-top:8px;">'+data[i].ALTERNATIVA+'</div>'+
				'<div class="body-tbl tbl-in4" style="padding-top:8px;">'+data[i].RUTA+'</div>'+
				'<div class="body-tbl tbl-in4" style="padding-top:8px;">'+data[i].MINCOST+'</div>'+
				'<div class="body-tbl tbl-in4">'+
					'<input type="number" class="simple-ipt ipt-minadic" data-alternativa="'+data[i].ALTERNATIVA+'"'+
					' data-ruta="'+data[i].RUTA+'" data-valini="'+data[i].MINADIC+'" value="'+data[i].MINADIC+'" style="width:calc(100% - 12px);"/>'+
				'</div>'+
			'</div>';
	}
	$("#space-fill").empty();
	$("#space-fill").append(html);
	$("#tbl-generate").css("display","block");
}

function guardarMinCom(){
	var ar_send=[];
	var ar=document.getElementsByClassName("ipt-minadic");
	for (var i = 0;i <ar.length; i++) {
		if (ar[i].value!=ar[i].dataset.valini) {
			var aux=[];
			aux.push(ar[i].dataset.alternativa);
			aux.push(ar[i].dataset.ruta);
			aux.push(parseFloat(ar[i].value)*10000);
			aux.push(parseFloat(ar[i].dataset.valini)*10000);
			ar_send.push(aux);
			ar[i].dataset.valini=ar[i].value;
		}
	}
	if (ar_send.length==0) {
		alert("No hay nada que guardar!");
	}else{
		console.log(ar_send);
		$(".panelCarga").fadeIn(200);
		$.ajax({
			url:"config/saveMinComEst.php",
			type:"POST",
			data:{
				esttsc:$("#idesttsc").val(),
				codusu:codusu,
				array:ar_send
			},
			success:function(data){
				console.log(data);
				if (!data.state) {
					alert(data.detail);
				}
				$(".panelCarga").fadeOut(200);
			}
		});
	}
}

$(document).ready(function(){
});

function show_data(linea){
	console.log(linea.CUOTA);
	if(linea.CUOTA!=undefined){
		$("#cuota").val(linea.CUOTA);
		$("#hor-ini").val(format_time(linea.HORINI.toString()));
		$("#hor-fin").val(format_time(linea.HORFIN.toString()));
	}else{
		$("#cuota").val("");
		$("#hor-ini").val("");
		$("#hor-fin").val("");
	}
}

function format_time(time){
	if (time.indexOf(":")<0) {
		if (time.length==1) {
			return "0"+time+":00";
		}else{
			return time+":00";
		}
	}else{
		return time;
	} 
}

function format_number(time){
	time=time.substr(0,2);
	return parseInt(time);
}

function hideCharge(){
	$(".panelCarga").fadeOut(200);	
}

var maxturno=0;
var minturno=0;
function fill_turnos(turnos){
	maxturno=0;
	minturno=0;
	var html='';
	for (var i = 0; i < turnos.length; i++) {
		if(i==0){
			minturno=turnos[i].TURNO;
		}
		if (i==turnos.length-1) {
			maxturno=turnos[i].TURNO;	
		}
		html+=
		'<option value="'+turnos[i].TURNO+'">'+turnos[i].TURNO+'</option>';
	}
	$("#select-turno-linea").empty();
	$("#select-turno-linea").append(html);	
}
function sin_turnos(){
	$("#select-turno-linea").empty();
	$("#select-turno-linea").append('<option value="0">Sin turnos</option>');
}