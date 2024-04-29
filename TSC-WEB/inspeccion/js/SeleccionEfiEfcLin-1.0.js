$(document).ready(function(){
	$.ajax({
		type:'POST',
		url:'config/getFiltroEfiEfcLin.php',
		success:function(data){
			console.log(data);
			let html='';
			for (var i = 0; i < data.lineas.length; i++) {
				html+='<option value="'+data.lineas[i].LINEA+'">'+data.lineas[i].DESLIN+'</option>';
			}
			$("#idlinea").append(html);
			$(".panelCarga").fadeOut(100);
		}
	});
	var fecha=new Date();
  	fecha.setDate(fecha.getDate());
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
	document.getElementById("idfecha").value=hoy;
});

function showReporte(){
	var link='IndEfiEfcLin.php?linea='+$("#idlinea").val()+
	'&turno='+$("#idturno").val()+
	'&opcion='+$("#idopcion").val()+
	'&fecha='+$("#idfecha").val();
	window.location.href=link;
}