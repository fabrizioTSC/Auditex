function exportar(codtll,codusu,codtad,fecini,fecfin,codsede,codtipser,titulo){
	var a=document.createElement('a');
	a.target="_blank";
	a.href="config/exports/exportReportGeneral.php?codtll="+codtll+"&codusu="+codusu+"&codtad="+codtad+"&fecini="+fecini+"&fecfin="+fecfin+"&codsede="+codsede+"&codtipser="+codtipser+
		"&titulo="+titulo;
	a.click();
}

function exportar_repregcla(codtll,codusu,codtad,fecha,codsede,codtipser,titulo){
	var a=document.createElement('a');
	a.target="_blank";
	a.href="config/exports/exportRepRegClasi.php?codtll="+codtll+"&codusu="+codusu+"&codtad="+codtad+"&fecha="+fecha+"&codsede="+codsede+"&codtipser="+codtipser+
		"&titulo="+titulo;
	a.click();
}