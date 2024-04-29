$(document).ready(function(){
	$.ajax({
		type:"POST",
		url:"config/getFichasInicioAutomatico.php",
		data:{
			codtll:codtll,
			codsed:codsed,
			codtipser:codtipser
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
					'<div class="itemBody2" style="width: 100px;">'+data.fichas[i].FECMOV+'</div>'+
					'<div class="itemBody2" style="width: 100px;">'+data.fichas[i].USUMOV+'</div>'+
					'<div class="itemBody2" style="width: 150px;">'+data.fichas[i].OBSERVACION+'</div>'+
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
	a.href="config/exports/exportFichasInicioAutomatico.php?codtll="+codtll+"&codsed="+codsed+"&codtipser="+codtipser+
	"&t="+$("#titulodetalle").html();
	a.target="_blank";
	a.click();
}