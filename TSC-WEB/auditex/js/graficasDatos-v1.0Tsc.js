function exportar(codtll,codusu,codtad,fecini,fecfin,codsede,codtipser, codcliente,pedido,color,po, destll,desusu,desauditoria,  titulo){

	var a=document.createElement('a');

	a.target="_blank";

	let ref = `

	config/exports/exportReportGeneralTsc.php?
	codtll=${codtll}&destll=${destll}&
	codusu=${codusu}&desusu=${desusu}&
	codtad=${codtad}&desauditoria=${desauditoria}&
	fecini=${fecini}&
	fecfin=${fecfin}&
	codsede=${codsede}&
	codtipser=${codtipser}&
	codcliente=${codcliente}&
	pedido=${pedido}&
	color=${color}&
	po=${po}&
	titulo=${titulo}
	`;

	console.log("ref",ref);

	a.href = ref;
	// a.href="config/exports/exportReportGeneral.php?codtll="+codtll+"&codusu="+codusu+"&codtad="+codtad+"&fecini="+fecini+"&fecfin="+fecfin+"&codsede="+codsede+"&codtipser="+codtipser+
	// 	"&codcliente="+codcliente+"&pedido="+pedido+"&color="+color+"&po="+po+
	// 	"&titulo="+titulo;

	a.click();


}

function exportar_repregcla(codtll,codusu,codtad,fecha,codsede,codtipser,titulo){
	var a=document.createElement('a');
	a.target="_blank";
	a.href="config/exports/exportRepRegClasi.php?codtll="+codtll+"&codusu="+codusu+"&codtad="+codtad+"&fecha="+fecha+"&codsede="+codsede+"&codtipser="+codtipser+
		"&titulo="+titulo;
	a.click();
}