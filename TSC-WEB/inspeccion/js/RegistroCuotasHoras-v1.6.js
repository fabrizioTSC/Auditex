function formatDate(date,type){
	var search="/";
	/*
	if (type==1) {
		search="-";
		replace="/";
	}
	while(date.indexOf(search)>=0){
		date=date.replace(search,replace);
	}*/
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

var ant_var=0;
$(document).ready(function(){
	//$( "#FechaSys" ).datepicker({ dateFormat: 'dd-mm-y' });
	$.ajax({
		url:"config/getEtonCuotasHoras.php",
		type:"POST",
		data:{
			anterior:ant_var
		},
		success:function(data){
			console.log(data);
			//$("#FechaSys").val(formatDate(data.FECHA,0));
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
			if (data.data_linea.CUOTA) {
				$("#info-linea").css("display","block");
				show_data(data.data_linea);
			}
			if (data.data_linea.CAMEST=="0") {
				document.getElementById("camest").checked=false;
			}else{
				document.getElementById("camest").checked=true;
			}
			if (data.data_hora.length>0) {
				$("#btn-generate").css("display","none");
				fill_horas(data.data_hora);
			}else{
				$("#btn-generate").css("display","flex");	
			}
			console.log(minturno+" - "+maxturno);
			if (maxturno==minturno) {
				document.getElementById("hor-ini").disabled=false;
				document.getElementById("hor-fin").disabled=false;
				document.getElementById("btn-eliminar").style.display="flex";
			}else{
				if(data.turno_selected==minturno){
					document.getElementById("hor-ini").disabled=false;
					document.getElementById("hor-fin").disabled=true;
					document.getElementById("btn-eliminar").style.display="none";
				}else{
					if(data.turno_selected==maxturno){
						document.getElementById("hor-ini").disabled=true;
						document.getElementById("hor-fin").disabled=false;
						document.getElementById("btn-eliminar").style.display="flex";
					}
				}
			}
			$("#select-turno-linea").val(data.turno_selected);
			$("#title-nuevo").css("display","none");
			$(".panelCarga").fadeOut(200);
		}
	});
	$(".ipt-hor-ini").blur(function(){
		$("#hor-ini").val(format_time($("#hor-ini").val()));
		recalculateJornada();
	});
	$(".ipt-hor-fin").blur(function(){		
		$("#hor-fin").val(format_time($("#hor-fin").val()));
		recalculateJornada();
	});
	$("#FechaSys").change(function(){
		$("#select-lineas").change();
	});
	$("#select-lineas").change(function(){
		$("#info-linea").css("display","none");
		$("#tbl-generate").css("display","none");
		$(".panelCarga").fadeIn(200);	
		$.ajax({
			url:"config/getEtonCuotasHorasXLin.php",
			type:"POST",
			data:{
				linea:$("#select-lineas").val(),
				anterior:ant_var
			},
			success:function(data){
				//console.log(data);
				$("#FechaSys").text(formatDate(data.fecha,0));
				$("#title-nuevo").css("display","none");
				if (data.data_linea.CUOTA) {
					$("#info-linea").css("display","block");
					show_data(data.data_linea);
				}
				if (data.data_linea.CAMEST=="0") {
					document.getElementById("camest").checked=false;
				}else{
					document.getElementById("camest").checked=true;
				}
				if(data.data_hora.length>0){
					$("#btn-generate").css("display","none");
					fill_horas(data.data_hora);
				}else{
					$("#btn-generate").css("display","flex");
				}
				if (data.turnos.length>0) {
					fill_turnos(data.turnos);
				}else{
					sin_turnos();
				}
				$("#select-turno-linea").val(data.turno_selected);
				if (maxturno==minturno) {
					document.getElementById("hor-ini").disabled=false;
					document.getElementById("hor-fin").disabled=false;
					document.getElementById("btn-eliminar").style.display="flex";
				}else{
					if(data.turno_selected==minturno){
						document.getElementById("hor-ini").disabled=false;
						document.getElementById("hor-fin").disabled=true;
						document.getElementById("btn-eliminar").style.display="none";
					}else{
						if(data.turno_selected==maxturno){
							document.getElementById("hor-ini").disabled=true;
							document.getElementById("hor-fin").disabled=false;
							document.getElementById("btn-eliminar").style.display="flex";
						}
					}
				}
				$(".panelCarga").fadeOut(200);
			}
		});
	});
	$("#select-turno-linea").change(function(){
		$("#info-linea").css("display","none");
		$("#tbl-generate").css("display","none");
		$(".panelCarga").fadeIn(200);	
		$.ajax({
			url:"config/getEtonCuotasHorasXLinXTur.php",
			type:"POST",
			data:{
				linea:$("#select-lineas").val(),
				turno:$("#select-turno-linea").val(),
				anterior:ant_var
			},
			success:function(data){
				//console.log(data);
				$("#FechaSys").text(formatDate(data.fecha,0));
				$("#title-nuevo").css("display","none");
				if (data.data_linea.CUOTA) {
					$("#info-linea").css("display","block");
					show_data(data.data_linea);
				}
				if (data.data_linea.CAMEST=="0") {
					document.getElementById("camest").checked=false;
				}else{
					document.getElementById("camest").checked=true;
				}
				if(data.data_hora.length>0){
					$("#btn-generate").css("display","none");
					fill_horas(data.data_hora);
				}else{
					$("#btn-generate").css("display","flex");
				}
				if (maxturno==minturno) {
					document.getElementById("hor-ini").disabled=false;
					document.getElementById("hor-fin").disabled=false;
					document.getElementById("btn-eliminar").style.display="flex";
				}else{
					if($("#select-turno-linea").val()==minturno){
						document.getElementById("hor-ini").disabled=false;
						document.getElementById("hor-fin").disabled=true;
						document.getElementById("btn-eliminar").style.display="none";
					}else{
						if($("#select-turno-linea").val()==maxturno){
							document.getElementById("hor-ini").disabled=true;
							document.getElementById("hor-fin").disabled=false;
							document.getElementById("btn-eliminar").style.display="flex";
						}else{
							document.getElementById("hor-ini").disabled=true;
							document.getElementById("hor-fin").disabled=true;
							document.getElementById("btn-eliminar").style.display="none";
						}
					}
				}
				$(".panelCarga").fadeOut(200);
			}
		});
	});
});

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

var horas=[];
function fill_horas(data){
	horas=data;
	var html='';
	for (var i = 0; i < data.length; i++) {
		html+=
			'<div class="tbl-linea">'+
				'<div class="body-tbl tbl-in3" style="padding-top:8px;">'+data[i].HORA+' a '+(parseInt(data[i].HORA)+1)+'</div>'+
				'<div class="body-tbl tbl-in3"><input type="number" class="simple-ipt ipt-numope" data-hora="'+data[i].HORA+'" id="numope-'+data[i].HORA+'" value="'+data[i].NUMOPE+'"/></div>'+
				'<div class="body-tbl tbl-in3"><input type="number" class="simple-ipt ipt-minhor" data-hora="'+data[i].HORA+'" id="minhor-'+data[i].HORA+'" value="'+data[i].MINUTOSHORA+'"/></div>'+
				'<div class="body-tbl tbl-in3"><input type="number" class="simple-ipt" id="minutos-'+data[i].HORA+'" value="'+data[i].MINASI+'" disabled/></div>'+
				//'<div class="body-tbl tbl-in3"><input type="number" class="simple-ipt ipt-turno" data-hora="'+data[i].HORA+'" id="turno-'+data[i].HORA+'" value="'+data[i].TURNO+'"/></div>'+
			'</div>';
	}
	html+=
	'<script>'+
		'$(".ipt-numope").blur(function(){'+
			'recalc_min(this);'+
			'recalc_numope(this);'+
		'});'+	
		'$(".ipt-minhor").blur(function(){'+
			'recalc_min(this);'+
			//'recalc_minhor(this);'+
		'});'+
		'$(".ipt-turno").blur(function(){'+
			'correct_turno(this);'+
		'});'+
	'</script>';
	$("#space-fill").empty();
	$("#space-fill").append(html);
	$("#tbl-generate").css("display","block");
}

function show_data(linea){
	$("#cuota").val(linea.CUOTA);
	$("#hor-ini").val(format_time(linea.HORINI.toString()));
	$("#hor-fin").val(format_time(linea.HORFIN.toString()));
	$("#jor").val(linea.JORNADA);
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
/*
function recalculateJornada(element){
	var linea=element.dataset.linea;
	$("#jornada-"+linea).val((parseInt($("#horfin-"+linea).val())-parseInt($("#horini-"+linea).val()))*60);
}
*/
function recalculateJornada(){
	var ini=$("#hor-ini").val();
	var fin=$("#hor-fin").val();
	if (!(ini=="" || fin=="")) {
		var jor=format_number(fin)-format_number(ini);
		$("#jor").val(jor*60);
	}
}

function format_number(time){
	time=time.substr(0,2);
	/*
	while(time.indexOf("0")>=0){
		time=time.replace("0","");
	}
	return time.replace(":","");
	*/
	return parseInt(time);
}

function validateFillCuota(element){
	/*if(document.getElementById("ctrl-cuota").checked){
		$(".ipt-cuota").val(element.value);
	}*/
}

function correct_turno(element){
	var hora=parseInt(element.dataset.hora);
	var ar=document.getElementsByClassName("ipt-turno");
	for (var i = 0; i < ar.length; i++) {
		if(parseInt(ar[i].dataset.hora)>=hora){
			$("#turno-"+ar[i].dataset.hora).val($("#turno-"+hora).val());
		}
	}
}

function recalc_min(element){
	var hora=element.dataset.hora;
	$("#minutos-"+hora).val(parseInt($("#minhor-"+hora).val())*parseInt($("#numope-"+hora).val()));
}

function recalc_numope(element){
	var value=element.value;
	var hora=parseInt(element.dataset.hora);
	var ar=document.getElementsByClassName("ipt-numope");
	for (var i = 0; i < ar.length; i++) {
		if(parseInt(ar[i].dataset.hora)>=hora){
			$("#numope-"+ar[i].dataset.hora).val($("#numope-"+hora).val());
			recalc_min(ar[i]);
		}
	}
}

function recalc_minhor(element){
	var value=element.value;
	var hora=parseInt(element.dataset.hora);
	var ar=document.getElementsByClassName("ipt-minhor");
	var jornada=0;
	for (var i = 0; i < ar.length; i++) {
		if(parseInt(ar[i].dataset.hora)>=hora){
			$("#minhor-"+ar[i].dataset.hora).val($("#minhor-"+hora).val());
			recalc_min(ar[i]);
		}
		jornada+=parseInt($("#minhor-"+ar[i].dataset.hora).val());
	}
	$("#jor").val(jornada);
}

/*
var ar_save=[];
function saveCuotaHora(){
	ar_save=[];
	var validate=true;
	var i=0;
	while (validate==true && i < lineas.length) {
		if($("#cuota-"+lineas[i].LINEA).val()=="0"){
			validate=false;
			alert("Complete la cuota de la linea "+(i+1)+"!");
		}else{
			if (parseInt($("#horini-"+lineas[i].LINEA).val())>=parseInt($("#horfin-"+lineas[i].LINEA).val())) {
				alert("La hora de inicio de la linea "+(i+1)+" no puede ser mayor a la hora de fin!");	
			}else{
				var aux=[];
				aux.push(lineas[i].LINEA);
				aux.push($("#cuota-"+lineas[i].LINEA).val());
				aux.push($("#horini-"+lineas[i].LINEA).val());
				aux.push($("#horfin-"+lineas[i].LINEA).val());
				aux.push($("#jornada-"+lineas[i].LINEA).val());
				if (document.getElementById("cambioestilo-"+lineas[i].LINEA).checked) {
					aux.push("1");
				}else{
					aux.push("0");
				}
				ar_save.push(aux);
			}
		}
		i++;
	}
	if (validate==true) {
		$(".panelCarga").fadeIn(200);
		$.ajax({
			url:"config/saveEtonCuotasHoras.php",
			type:"POST",
			data:{
				array:ar_save,
				nuevo:nuevo
			},
			success:function(data){
				console.log(data);
				if (!data.state) {
					alert(data.detail);
				}else{
					alert("Cuotas guardadas!");
				}
				$(".panelCarga").fadeOut(200);
			}
		});
	}
}*/

/////CONTINUAR AQUI
function generarHoras(){
	var horini=parseInt(document.getElementById("hor-ini").value.substr(0,2));
	var horfin=parseInt(document.getElementById("hor-fin").value.substr(0,2));
	if (horfin>horini) {
		$(".panelCarga").fadeIn(200);
		$.ajax({
			url:"config/saveEtonCuotasHoras.php",
			type:"POST",
			data:{
				linea:$("#select-lineas").val(),
				anterior:ant_var,
				turno:$("#turno-siguiente").text(),
				cuota:$("#cuota").val(),
				horini:format_number($("#hor-ini").val()),
				horfin:format_number($("#hor-fin").val()),
				jornada:$("#jor").val()
			},
			success:function(data){
				console.log(data);
				if (!data.state) {
					alert(data.detail);
					$("#select-lineas").change();
				}else{
					fill_turnos(data.turnos)
					fill_horas(data.data_hora);
					$("#select-turno-linea").val(data.turno_selected);
					$("#btn-generate").css("display","none");
					$(".panelCarga").fadeOut(200);
					$("#title-nuevo").css("display","none");
					document.getElementById("btn-eliminar").style.display="flex";
				}
			}
		});
	}else{
		alert("La hora de fin debe ser mayor a la hora de inicio!");
	}
}

function irMinutesAssign(){
	window.location.href="RegistrarMinutosLinea.php";
}

var ar_save=[];
function guardarHoras(){
	var horini=parseInt(document.getElementById("hor-ini").value.substr(0,2));
	var horfin=parseInt(document.getElementById("hor-fin").value.substr(0,2));
	if (horfin>horini) {
		ar_save=[];
		for (var i = horini; i < horfin; i++) {
			var aux=[];
			aux.push(i);
			if($("#numope-"+i).val()){
				aux.push($("#numope-"+i).val());
				aux.push($("#minutos-"+i).val());
				aux.push($("#minhor-"+i).val());
				ar_save.push(aux);
			}else{
				aux.push(0);
				aux.push(0);
				aux.push(60);
				ar_save.push(aux);
			}
		}
		var camest=0;
		if(document.getElementById("camest").checked){
			camest=1;
		}
		$(".panelCarga").fadeIn(200);
		$.ajax({
			url:"config/saveEtonMinutos.php",
			type:"POST",
			data:{
				linea:$("#select-lineas").val(),
				turno:$("#select-turno-linea").val(),
				cuota:$("#cuota").val(),
				horini:format_number($("#hor-ini").val()),
				horfin:format_number($("#hor-fin").val()),
				jornada:$("#jor").val(),
				array:ar_save,
				anterior:ant_var,
				camest:camest
			},
			success:function(data){
				console.log(data);
				if (!data.state) {
					alert(data.detail);
				}
				$("#jor").val(data.totmin);
				fill_horas(data.data_hora);
				$(".panelCarga").fadeOut(200);
			}
		});
	}else{
		alert("La hora de fin debe ser mayor a la hora de inicio!");
	}
}

var turno_to_select=0;
function agregar_turno(){
	$(".panelCarga").fadeIn(200);
	$("#info-linea").css("display","block");
	$("#tbl-generate").css("display","none");
	$("#cuota").val("0");
	turno_to_select=parseInt($("#select-turno-linea").val());
	if (turno_to_select==0) {
		$("#hor-ini").val(format_time("6"));
		$("#hor-fin").val(format_time("14"));
		$("#jor").val((14-6)*60);
		$(".panelCarga").fadeOut(200);
		document.getElementById("hor-ini").disabled=false;
		document.getElementById("hor-fin").disabled=false;
		$("#title-nuevo").css("display","block");
		$("#turno-siguiente").text("1");
	}else{
		$.ajax({
			url:"config/getTimeTurnoXLin.php",
			type:"POST",
			data:{
				linea:$("#select-lineas").val(),
				anterior:ant_var
			},
			success:function(data){
				console.log(data);
				$("#title-nuevo").css("display","block");
				$("#turno-siguiente").text(data.turno);
				$("#hor-ini").val(format_time(data.hor_fin));
				$("#hor-fin").val(format_time((parseInt(data.hor_fin)+1).toString()));
				$("#jor").val(60);
				$(".panelCarga").fadeOut(200);
			}
		});
		document.getElementById("hor-ini").disabled=true;
		document.getElementById("hor-fin").disabled=false;
	}
	$("#btn-generate").css("display","flex");
}

function delete_turno(){
	$(".panelCarga").fadeIn(200);
	$.ajax({
		url:"config/deleteEtonLineaTurno.php",
		type:"POST",
		data:{
			linea:$("#select-lineas").val(),
			turno:$("#select-turno-linea").val(),
			anterior:ant_var
		},
		success:function(data){
			console.log(data);
			if (!data.state) {
				alert(data.detail);
				$(".panelCarga").fadeOut(200);
			}else{
				$("#select-lineas").change();
			}
		}
	});	
}

function hideCharge(){
	$(".panelCarga").fadeOut(200);	
}

function show_day_before(){
	ant_var=1;
	$("#btn2").css("display","block");
	$("#btn1").css("display","none");
	$("#select-lineas").change();
}

function show_day_after(){
	ant_var=0;
	$("#btn1").css("display","block");
	$("#btn2").css("display","none");
	$("#select-lineas").change();
}