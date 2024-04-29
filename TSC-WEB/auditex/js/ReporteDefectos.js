function exportar(codtll,codusu,fecini,fecfin,codsede,codtipser,titulo){
	var a=document.createElement('a');
	a.target="_blank";
	a.href="config/exports/exportReportDefectos.php?codtll="+codtll+"&codusu="+codusu+"&fecini="+fecini+"&fecfin="+fecfin+"&codsede="+codsede+"&codtipser="+codtipser+
		"&titulo="+titulo;
	a.click();
}