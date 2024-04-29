$(document).ready(function(){
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
	document.getElementById("idfecini").value=hoy;
	document.getElementById("idfecfin").value=hoy;
});

function showReporte(){
	var link='ReporteMinCom.php?fecini='+$("#idfecini").val()+'&fecfin='+$("#idfecfin").val();
	window.location.href=link;
}