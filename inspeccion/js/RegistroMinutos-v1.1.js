var minutos=[];
$(document).ready(function(){
	$.ajax({
		url:"config/getEtonMinutes.php",
		type:"POST",
		success:function(data){
			console.log(data);
			$("#FechaSys").text(data.FECHA);
			var html='';
			for (var i = 0; i < data.lineas.length; i++) {
				html+=
				'<option value="'+data.lineas[i].LINEA+'">'+data.lineas[i].DESLIN+'</option>';
			}
			$("#select-lineas").empty();
			$("#select-lineas").append(html);
			FillMinutos(data.linea_hora);
		}
	});
	$("#select-lineas").change(function(){
		$(".panelCarga").fadeIn(200);
		$.ajax({
			url:"config/getEtonMinutesLinea.php",
			data:{
				linea:$("#select-lineas").val()
			},
			type:"POST",
			success:function(data){
				FillMinutos(data.linea_hora);
			}
		});
	});
});

function FillMinutos(data){
	minutos=data;
	var html='';
	for (var i = 0; i < data.length; i++) {
		html+=
		'<div class="tbl-linea">'+
			'<div class="body-tbl tbl-in3" style="padding-top:8px;">'+data[i].LINEA+'</div>'+
			'<div class="body-tbl tbl-in3" style="padding-top:8px;">'+data[i].HORA+'</div>'+
			'<div class="body-tbl tbl-in3"><input type="number" class="simple-ipt ipt-min" id="minutos-'+data[i].HORA+'" value="'+data[i].MIN_ASIGNADOS+'"/></div>'+
		'</div>';
	}
	html+=
	'<script>'+
		'$(".ipt-min").blur(function(){'+
			'validateFillMin(this);'+
		'});'
	'</script>';
	$("#space-fill").empty();
	$("#space-fill").append(html);
	$(".panelCarga").fadeOut(200);
}

function validateFillMin(element){
	if(document.getElementById("ctrl-min").checked){
		var array=$(".ipt-min");
		var active=false;
		for (var i = 0; i < array.length; i++) {
			if(array[i].id==element.id){
				active=true;
			}
			if (active==true) {
				array[i].value=element.value;
			}
		}
	}
}

var ar_save=[];
function saveMinutes(){
	ar_save=[];
	$(".panelCarga").fadeIn(200);
	for (var i = 0; i < minutos.length; i++) {
		var aux=[];
		aux.push(minutos[i].HORA);
		aux.push($("#minutos-"+minutos[i].HORA).val());
		ar_save.push(aux);
	}

	$.ajax({
		url:"config/saveEtonMinutos.php",
		data:{
			linea:$("#select-lineas").val(),
			array:ar_save
		},
		type:"POST",
		success:function(data){
			if(data.state){
				alert("Cuotas guardadas!");
			}else{
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(200);
		}
	});
}