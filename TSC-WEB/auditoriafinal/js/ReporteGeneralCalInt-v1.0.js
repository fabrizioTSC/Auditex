function exportar_calint(codusu,codtad,fecini,fecfin,titulo){
	var a=document.createElement('a');
	a.target="_blank";
	a.href="config/exports/exportReportGeneralCalInt.php?codusu="+codusu+"&codtad="+codtad+"&fecini="+fecini+"&fecfin="+fecfin+"&titulo="+titulo;
	a.click();
}

function exportar_emb(codusu,codtad,fecini,fecfin,titulo){
	var a=document.createElement('a');
	a.target="_blank";
	a.href="config/exports/exportReportGeneralEmb.php?codusu="+codusu+"&codtad="+codtad+"&fecini="+fecini+"&fecfin="+fecfin+"&titulo="+titulo;
	a.click();
}

