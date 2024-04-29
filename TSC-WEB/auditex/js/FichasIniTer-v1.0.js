$(document).ready(function(){
	$("#tblMain").scroll(function(){
		if ($("#tblMain").scrollTop()>50) {
			$("#tbl-header").css("position","absolute");
			$("#tbl-header").css("top",$("#tblMain").scrollTop()+"px");
		}else{
			$("#tbl-header").css("position","relative");
			$("#tbl-header").css("top","0px");
		}
	});
	$.ajax({
		type:"POST",
		url:"config/getFichasIniTer.php",
		data:{
			codtll:codtll,
			codsed:codsed,
			codtipser:codtipser,
			fecini:fecini,
			fecfin:fecfin,
			tipo:tipo
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
					'<div class="itemBody2" style="width: 100px;">'+process_tipo(data.fichas[i].TIPO)+'</div>'+
					'<div class="itemBody2" style="width: 150px;">'+data.fichas[i].OBSERVACION+'</div>'+
				'</div>';
			}
			$("#tbl-body").empty();
			$("#tbl-body").append(html);
			$(".panelCarga").fadeOut(200);
		}
	});
});
function process_tipo(text){
	switch(text){
		case 'A':
			return 'AUTO.';
			break;
		case 'M':
			return 'MANUAL';
			break;
		default:
			return text;
			break;
	}
}

function exportar(){
	var a=document.createElement("a");
	a.href="config/exports/exportFichasIniTer.php?codtll="+codtll+
	"&codsed="+codsed+
	"&codtipser="+codtipser+
	"&fecini="+fecini+
	"&fecfin="+fecfin+
	"&tipo="+tipo+
	"&t="+$("#titulodetalle").html();
	a.target="_blank";
	a.click();
}