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

function fill_fichas(data){
	var html='';
	for (var i = 0; i < data.length; i++) {
		html+=
			'<div class="tbl-linea">'+
				'<div class="body-tbl tbl-in3" style="padding-top:8px;">'+data[i].CODFIC+'</div>'+
				'<div class="body-tbl tbl-in3" style="padding-top:8px;">'+data[i].ESTCLI+'</div>'+
				'<div class="body-tbl tbl-in3" style="padding-top:8px;">'+data[i].ESTTSC+'</div>'+
				'<div class="body-tbl tbl-in3" style="padding-top:8px;">'+data[i].ALTERNATIVA+'</div>'+
				'<div class="body-tbl tbl-in3" style="padding-top:8px;"><span id="std-'+data[i].CODFIC+'">'+data[i].TIE_STD+'</span></div>'+
				'<div class="body-tbl tbl-in3"">'+
					'<input type="number" class="simple-ipt ipt-tiecom" data-codfic="'+data[i].CODFIC+'" value="'+data[i].TIE_COM+'" style="width:calc(100% - 12px);"/>'+
				'</div>'+
				'<div class="body-tbl tbl-in3" style="padding-top:8px;"><span id="tot-'+data[i].CODFIC+'">'+data[i].MIN_TOT+'</span></div>'+
				'<div class="body-tbl tbl-in4"">'+
					'<input type="text" class="simple-ipt ipt-obs" data-codfic="'+data[i].CODFIC+'" value="'+format_null(data[i].OBS)+'" style="width:calc(100% - 12px);"/>'+
				'</div>'+
				/*
				'<div class="body-tbl tbl-in3"><input type="number" class="simple-ipt ipt-numope" data-hora="'+data[i].HORA+'" id="numope-'+data[i].HORA+'" value="'+data[i].NUMOPE+'"/></div>'+
				'<div class="body-tbl tbl-in3"><input type="number" class="simple-ipt ipt-minhor" data-hora="'+data[i].HORA+'" id="minhor-'+data[i].HORA+'" value="'+data[i].MINUTOSHORA+'"/></div>'+
				'<div class="body-tbl tbl-in3"><input type="number" class="simple-ipt" id="minutos-'+data[i].HORA+'" value="'+data[i].MINASI+'" disabled/></div>'+
				//'<div class="body-tbl tbl-in3"><input type="number" class="simple-ipt ipt-turno" data-hora="'+data[i].HORA+'" id="turno-'+data[i].HORA+'" value="'+data[i].TURNO+'"/></div>'+*/
			'</div>';
	}
	html+=
	'<script>'+
		'$(".ipt-tiecom").blur(function(){'+
			'recalc_tot(this);'+
		'});'+
	'</script>';
	$("#space-fill").empty();
	$("#space-fill").append(html);
	$("#tbl-generate").css("display","block");
}

function recalc_tot(dom){
	var codfic=dom.dataset.codfic;
	$("#tot-"+codfic).text(parseFloat($("#std-"+codfic).text())+parseFloat(dom.value));
}

function guardarMinCom(){
	var ar_send=[];
	var ar=document.getElementsByClassName("ipt-tiecom");
	var ar2=document.getElementsByClassName("ipt-obs");
	for (var i = 0;i <ar.length; i++) {
		var aux=[];
		aux.push(ar[i].dataset.codfic);
		aux.push(parseFloat(ar[i].value)*10000);
		aux.push(ar2[i].value);
		ar_send.push(aux);
	}
	console.log(ar_send);
	$(".panelCarga").fadeIn(200);
	$.ajax({
		url:"config/saveMinCom.php",
		type:"POST",
		data:{			
			linea:$("#select-lineas").val(),
			turno:$("#select-turno-linea").val(),
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

var ant_var=0;
$(document).ready(function(){
	$.ajax({
		url:"config/getInfoMinCom.php",
		type:"POST",
		data:{
			anterior:ant_var
		},
		success:function(data){
			console.log(data);
			$("#FechaSys").text(formatDate(data.fecha,0));
			var html='';
			for (var i = 0; i < data.lineas.length; i++) {
				html+=
				'<option value="'+data.lineas[i].LINEA+'">LINEA '+data.lineas[i].LINEA+'</option>';
			}
			$("#select-lineas").empty();
			$("#select-lineas").append(html);
			if (data.turnos.length>0) {
				fill_turnos(data.turnos);
			}else{
				sin_turnos();
			}
			if (data.fichas.length==0) {
				$("#tbl-generate").css("display","none");
			}else{
				fill_fichas(data.fichas);
			}
			show_data(data.data_linea);
			$("#select-turno-linea").val(data.turno_selected);
			$("#title-nuevo").css("display","none");
			$(".panelCarga").fadeOut(200);
		}
	});
	$("#select-lineas").change(function(){
		$(".panelCarga").fadeIn(200);	
		$.ajax({
			url:"config/getNewInfoTurMinCom.php",
			type:"POST",
			data:{
				linea:$("#select-lineas").val(),
				anterior:ant_var
			},
			success:function(data){
				console.log(data);
				show_data(data.data_linea);
				if (data.turnos.length>0) {
					fill_turnos(data.turnos);
				}else{
					sin_turnos();
				}
				if (data.fichas.length==0) {
					$("#tbl-generate").css("display","none");
				}else{
					fill_fichas(data.fichas);
				}
				$("#select-turno-linea").val(data.turno_selected);
				$(".panelCarga").fadeOut(200);
			}
		});
	});
	$("#select-turno-linea").change(function(){
		$(".panelCarga").fadeIn(200);	
		$.ajax({
			url:"config/getNewInfoMinCom.php",
			type:"POST",
			data:{
				linea:$("#select-lineas").val(),
				turno:$("#select-turno-linea").val(),
				anterior:ant_var
			},
			success:function(data){
				console.log(data);
				if (data.fichas.length==0) {
					$("#tbl-generate").css("display","none");
				}else{
					fill_fichas(data.fichas);
				}
				show_data(data.data_linea);
				$(".panelCarga").fadeOut(200);
			}
		});
	});
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