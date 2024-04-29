$(document).ready(function(){
	$("#idFechaDesde").datepicker({dateFormat: 'dd/mm/yy'});
	$("#idFechaHasta").datepicker({dateFormat: 'dd/mm/yy'});
	if (feciniget=="") {
		var fecha=new Date();
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
		var hoy=dia+"/"+mes+"/"+anio;
		document.getElementById("idFechaDesde").value=hoy;
		document.getElementById("idFechaHasta").value=hoy;
	}
});
function exportarAuditorFechaCalInt(){
	var fecini=$("#idFechaDesde").val();
	var fecfin=$("#idFechaHasta").val();
	var a=document.createElement('a');
	a.target="_blank";
	a.href="config/exports/exportReportAuditorFechaCalInt.php?fecini="+fecini+"&fecfin="+fecfin;
	a.click();		
}
function exportarAuditorFechaEmb(){
	var fecini=$("#idFechaDesde").val();
	var fecfin=$("#idFechaHasta").val();
	var a=document.createElement('a');
	a.target="_blank";
	a.href="config/exports/exportReportAuditorFechaEmb.php?fecini="+fecini+"&fecfin="+fecfin;
	a.click();		
}
function consultar(path){
	var fecini=$("#idFechaDesde").val();
	var fecfin=$("#idFechaHasta").val();
	if (fecini=="" || fecfin=="") {
		alert("Complete las fechas!");
	}else{
		location.href=path+"?fecini="+fecini+"&fecfin="+fecfin;
	}
}