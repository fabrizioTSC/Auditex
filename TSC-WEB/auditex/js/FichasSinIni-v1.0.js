$(document).ready(function(){
	$.ajax({
		type:"POST",
		url:"config/getFichasSinIniciar.php",
		data:{
			codtll:codtll,
			codsed:codsed,
			codtipser:codtipser,
			numdias:numdias
		},
		success:function(data){
			console.log(data);
			$("#titulodetalle").append(data.titulo);
			var html='';
			for (var i = 0; i <data.fichas.length; i++) {
				html+=
				'<div class="tblLine">'+
					'<div class="itemBody2" style="width: 80px;">'+data.fichas[i].CODFIC+'</div>'+
					'<div class="itemBody2" style="width: 100px;">'+data.fichas[i].DESSED+'</div>'+
					'<div class="itemBody2" style="width: 100px;">'+data.fichas[i].DESTIPSER+'</div>'+
					'<div class="itemBody2 itemvariable">'+data.fichas[i].DESTLL+'</div>'+
					'<div class="itemBody2" style="width: 100px;">'+data.fichas[i].FECENV+'</div>'+
					'<div class="itemBody2" style="width: 80px;">'+parseInt(data.fichas[i].DIAS)+'</div>'+
				'</div>';
			}
			$("#tbl-body").empty();
			$("#tbl-body").append(html);
			$(".panelCarga").fadeOut(200);
		}
	});
});

function exportar(){
	var a=document.createElement("a");
	a.href="config/exports/exportFichasSinIniciar.php?codtll="+codtll+"&codsed="+codsed+"&codtipser="+codtipser+
	"&numdias="+numdias+"&t="+$("#titulodetalle").html();
	a.target="_blank";
	a.click();
}