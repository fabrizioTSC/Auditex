function exportar(codtll,codusu,codtad,fecini,fecfin){	
	var a=document.createElement('a');
	a.target="_blank";
	a.href="config/exports/exportReportGeneral.php?codtll="+codtll+"&codusu="+codusu+"&codtad="+codtad+"&fecini="+fecini+"&fecfin="+fecfin;
	a.click();
}