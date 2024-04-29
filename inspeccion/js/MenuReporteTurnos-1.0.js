$(document).ready(function(){
	$.ajax({
		type:"POST",
		url:"config/getParRepTur.php",
		success:function(data){
			console.log(data);			
			var html='';
			for (var i = 0; i < data.anios.length; i++) {
				html+=
				'<option value="'+data.anios[i].ANIO+'">'+data.anios[i].ANIO+'</option>';
			}
			$("#select-anio1").append(html);
			$("#select-anio2").append(html);
			$("#select-anio1").val(data.anio);
			$("#select-anio2").val(data.anio);

			var html='';
			for (var i = 0; i < data.semanas.length; i++) {
				html+=
				'<option value="'+data.semanas[i].SEMANA+'">'+data.semanas[i].SEMANA+'</option>';
			}
			$("#select-semana").append(html);
			$("#select-semana").val(data.semana);

			var html='';
			for (var i = 0; i < data.meses.length; i++) {
				html+=
				'<option value="'+data.meses[i].MES+'">'+data.meses[i].MES+'</option>';
			}
			$("#select-mes").append(html);
			$("#select-mes").val(data.mes);

			$(".panelCarga").fadeOut(200);
		}
	});
	$("#select-anio1").change(function(){
		$(".panelCarga").fadeIn(200);
		$.ajax({
			type:"POST",
			url:"config/getSemanasRepTur.php",
			data:{
				anio:$("#select-anio1").val()
			},
			success:function(data){
				console.log(data);			
				var html='';
				for (var i = 0; i < data.semanas.length; i++) {
					html+=
					'<option value="'+data.semanas[i].SEMANA+'">'+data.semanas[i].SEMANA+'</option>';
				}
				$("#select-semana").append(html);
				$("#select-semana").val(data.semana);
				$(".panelCarga").fadeOut(200);
			}
		});
	});
	$("#select-anio2").change(function(){
		$(".panelCarga").fadeIn(200);
		$.ajax({
			type:"POST",
			url:"config/getMesesRepTur.php",
			data:{
				anio:$("#select-anio2").val()
			},
			success:function(data){
				console.log(data);
				var html='';
				for (var i = 0; i < data.meses.length; i++) {
					html+=
					'<option value="'+data.meses[i].MES+'">'+data.meses[i].MES+'</option>';
				}
				$("#select-mes").append(html);
				$("#select-mes").val(data.mes);
				$(".panelCarga").fadeOut(200);
			}
		});
	});
	$("#check1").click(function(){
		document.getElementById("check1").checked=true;
		document.getElementById("check2").checked=false;
		document.getElementById("check3").checked=false;
		$("#option1").css("display","block");
		$("#option2").css("display","none");
		$("#option3").css("display","none");
	});
	$("#check2").click(function(){
		document.getElementById("check1").checked=false;
		document.getElementById("check2").checked=true;
		document.getElementById("check3").checked=false;
		$("#option1").css("display","none");
		$("#option2").css("display","block");
		$("#option3").css("display","none");
	});
	$("#check3").click(function(){
		document.getElementById("check1").checked=false;
		document.getElementById("check2").checked=false;
		document.getElementById("check3").checked=true;
		$("#option1").css("display","none");
		$("#option2").css("display","none");
		$("#option3").css("display","block");
	});
	var fecha=new Date();
  	fecha.setDate(fecha.getDate() - 1);
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
	document.getElementById("idFecha").value=hoy;
});

function showReporte(){
	var link='ReporteTurnosHistorico.php';
	if (document.getElementById("check1").checked) {
		link+='?type=0&fecha='+$("#idFecha").val();
	}else{
		if (document.getElementById("check2").checked) {
			link+='?type=1&anio='+$("#select-anio1").val()+'&semana='+$("#select-semana").val();
		}else{
			link+='?type=2&anio='+$("#select-anio2").val()+'&mes='+$("#select-mes").val();
		}
	}
	window.location.href=link;
}