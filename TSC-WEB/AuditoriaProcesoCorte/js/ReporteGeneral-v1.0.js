function exportar(codtll,codusu,codtad,fecini,fecfin,codsede,codtipser,titulo){
	var a=document.createElement('a');
	a.target="_blank";
	a.href="config/exports/exportReportGeneral.php?codtll="+codtll+"&codusu="+codusu+"&codtad="+codtad+"&fecini="+fecini+"&fecfin="+fecfin+"&codsede="+codsede+"&codtipser="+codtipser+
		"&titulo="+titulo;
	a.click();
}