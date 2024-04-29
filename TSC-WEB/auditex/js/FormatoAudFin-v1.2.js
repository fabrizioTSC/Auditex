$(document).ready(function(){
	$.ajax({
		type:"POST",
		data:{
			codtll:codtll,
			codtipser:codtipser,
			codsede:codsede,
			pedido:pedido,
			codfic:codfic,
			check:check,
			option:option,
			fecini:fecini,
			fecfin:fecfin
		},
		url:"config/getInfoForAudFin.php",
		success:function(data){
			console.log(data);
			var html='';
			$("#title-form").append(data.titulo);
			var cont=1;
			if (data.data.length>0) {
				for (var i = 0; i < data.data.length; i++) {
					var item='';
					if (data.data[i].AUDITOR!="") {
						item+=cont;
						cont++;
					}
					html+=
					'<div class="tblLine">'+
						'<div class="itemBody2" style="width: 50px;">'+item+'</div>'+
						'<div class="itemBody2" style="width: 80px;">'+data.data[i].FECHA+'</div>'+
						'<div class="itemBody2" style="width: 100px;">'+data.data[i].AUDITOR+'</div>'+
						'<div class="itemBody2" style="width: 130px;">'+data.data[i].TALLER+'</div>'+
						'<div class="itemBody2" style="width: 150px;">'+data.data[i].CLIENTE+'</div>'+
						'<div class="itemBody2" style="width: 60px;">'+data.data[i].ESTILO+'</div>'+
						'<div class="itemBody2" style="width: 80px;">'+data.data[i].PEDIDO+'</div>'+
						'<div class="itemBody2" style="width: 60px;">'+data.data[i].FICHA+'</div>'+
						'<div class="itemBody2" style="width: 100px;">'+data.data[i].DSCCOL+'</div>'+
						'<div class="itemBody2" style="width: 80px;">'+data.data[i].PARTE+'</div>'+
						'<div class="itemBody2" style="width: 80px;">'+data.data[i].VEZ+'</div>'+
						'<div class="itemBody2" style="width: 80px;">'+data.data[i].LOTE+'</div>'+
						'<div class="itemBody2" style="width: 80px;">'+data.data[i].MUESTRA+'</div>'+
						'<div class="itemBody2" style="width: 80px;">'+data.data[i].CODDEF+'</div>'+
						'<div class="itemBody2" style="width: 100px;">'+data.data[i].DEFECTO+'</div>'+
						'<div class="itemBody2" style="width: 80px;">'+data.data[i].CANDEF+'</div>'+
						'<div class="itemBody2" style="width: 60px;">'+data.data[i].RESULTADO+'</div>'+
					'</div>';
				}
			}

			$("#body-response").empty();
			$("#body-response").append(html);

			$(".panelCarga").fadeOut(200);
		}
	});
	$("#tbl-formato").scroll(function(){
		if($("#tbl-formato").scrollTop()>0){
			$("#tbl-header-animate").css("position","absolute");
			$("#tbl-header-animate").css("top",$("#tbl-formato").scrollTop());
		}else{
			$("#tbl-header-animate").css("position","relative");
			$("#tbl-header-animate").css("top",0);
		}
	});
});

function exportar(){
	window.location.href="config/exports/exportFormatoAudFin.php?codtll="+codtll+"&codsede="+codsede+
	"&codtipser="+codtipser+"&fecini="+fecini+"&fecfin="+fecfin+"&option="+option+"&pedido="+pedido+"&codfic="+codfic+"&check="+check;
}