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

function consultar(path){
	var fecini=$("#idFechaDesde").val();
	var fecfin=$("#idFechaHasta").val();
	if (fecini=="" || fecfin=="") {
		alert("Complete las fechas!");
	}else{
		location.href=path+"?fecini="+fecini+"&fecfin="+fecfin;
	}
}

function exportar(){	
	var fecini=$("#idFechaDesde").val();
	var fecfin=$("#idFechaHasta").val();
	var a=document.createElement('a');
	a.target="_blank";
	a.href="config/exports/exportReport1.php?fecini="+fecini+"&fecfin="+fecfin;
	a.click();
}
function exportar2(){	
	var fecini=$("#idFechaDesde").val();
	var fecfin=$("#idFechaHasta").val();
	var a=document.createElement('a');
	a.target="_blank";
	a.href="config/exports/exportReport2.php?fecini="+fecini+"&fecfin="+fecfin;
	a.click();
}
function exportar3(){	
	var fecini=$("#idFechaDesde").val();
	var fecfin=$("#idFechaHasta").val();
	var a=document.createElement('a');
	a.target="_blank";
	a.href="config/exports/exportReport3.php?fecini="+fecini+"&fecfin="+fecfin;
	a.click();
}
function exportar4(){	
	var fecini=$("#idFechaDesde").val();
	var fecfin=$("#idFechaHasta").val();
	var a=document.createElement('a');
	a.target="_blank";
	a.href="config/exports/exportReport4.php?fecini="+fecini+"&fecfin="+fecfin;
	a.click();
}
function exportar5(){	
	var fecini=$("#idFechaDesde").val();
	var fecfin=$("#idFechaHasta").val();
	var a=document.createElement('a');
	a.target="_blank";
	a.href="config/exports/exportReport5.php?fecini="+fecini+"&fecfin="+fecfin;
	a.click();
}	
function exportarAuditor(){	
	var fecini=$("#idFechaDesde").val();
	var fecfin=$("#idFechaHasta").val();
	var a=document.createElement('a');
	a.target="_blank";
	a.href="config/exports/exportReportAuditor.php?fecini="+fecini+"&fecfin="+fecfin;
	a.click();	
}
function exportarAuditorFecha(){
	var fecini=$("#idFechaDesde").val();
	var fecfin=$("#idFechaHasta").val();
	var a=document.createElement('a');
	a.target="_blank";
	a.href="config/exports/exportReportAuditorFecha.php?fecini="+fecini+"&fecfin="+fecfin;
	a.click();		
}
function exportarAuditorFechaVerEmp(){
	var fecini=$("#idFechaDesde").val();
	var fecfin=$("#idFechaHasta").val();
	var a=document.createElement('a');
	a.target="_blank";
	a.href="config/exports/exportReportAuditorFechaVerEmp.php?fecini="+fecini+"&fecfin="+fecfin;
	a.click();		
}