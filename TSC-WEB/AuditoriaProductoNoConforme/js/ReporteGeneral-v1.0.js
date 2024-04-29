function exportar(codsede,codtipser,tipo,fecini,fecfin,titulo){
	var a=document.createElement('a');
	a.target="_blank";
	a.href="config/exports/exportReportGeneral.php?codsede="+codsede+"&codtipser="+codtipser+"&tipo="+tipo+"&fecini="+fecini+"&fecfin="+fecfin+"&titulo="+titulo;
	a.click();
}
function exportar2(pedido,dsccol,tipo,titulo){
	var a=document.createElement('a');
	a.target="_blank";
	a.href="config/exports/exportReportGeneral2.php?pedido="+pedido+"&dsccol="+dsccol+"&tipo="+tipo+"&titulo="+titulo;
	a.click();
}