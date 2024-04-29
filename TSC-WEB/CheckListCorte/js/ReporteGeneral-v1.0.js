function exportar(codtll,codusu,estado,fecini,fecfin,codsede,codtipser,titulo){
	var a=document.createElement("a");
	a.href='config/exports/exportReportGeneral.php'+
	'?codtll='+codtll+
	'&codusu='+codusu+
	'&estado='+estado+
	'&fecini='+fecini+
	'&fecfin='+fecfin+
	'&codsede='+codsede+
	'&codtipser='+codtipser+
	'&titulo='+titulo;
	a.target='_blank';
	a.click();
}