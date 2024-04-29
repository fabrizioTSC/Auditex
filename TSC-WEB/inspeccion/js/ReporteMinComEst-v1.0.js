$(document).ready(function(){
	$.ajax({
		type:"POST",
		data:{
			esttsc:esttsc,
			codfic:codfic,
			fecini:fecini,
			fecfin:fecfin
		},
		url:"config/getInfoRepMinComEst.php",
		success:function(data){
			console.log(data);

			$("#spacetitulo").text(data.titulo+"Desde "+date_format(fecini)+" hasta "+date_format(fecfin));

			var html='';
			for (var i = 0; i < data.mincom.length; i++) {
				html+='<div class="body-line">'+
						'<div class="body" style="width: 80px">'+data.mincom[i].FECHA+'</div>'+
						'<div class="body" style="width: 120px;">'+data.mincom[i].CODUSU+'</div>'+
						'<div class="body" style="width: 80px;">'+data.mincom[i].ESTCLI+'</div>'+
						'<div class="body" style="width: 80px;">'+data.mincom[i].ESTTSC+'</div>'+
						'<div class="body" style="width: 120px">'+data.mincom[i].ALTERNATIVA+'</div>'+
						'<div class="body" style="width: 80px">'+data.mincom[i].RUTA+'</div>'+
						'<div class="body" style="width: 80px;">'+data.mincom[i].TIESTD+'</div>'+
						'<div class="body" style="width: 80px;">'+data.mincom[i].TIECOM+'</div>'+
						'<div class="body" style="width: 80px">'+data.mincom[i].TIETOT+'</div>'+
						'<div class="body" style="width: 140px;">'+data.mincom[i].OBS+'</div>'+
						'<div class="body" style="width: 80px">'+data.mincom[i].TIEORI+'</div>'+
					'</div>';
			}
			$("#placeResult").empty();
			$("#placeResult").append(html);
			$(".panelCarga").fadeOut(100);
		}
	});
});
function hour_format(hour){
	var dig1="";
	if (hour.length==1) {
		dig1="0";
	}
	return dig1+hour+":00";
}
function date_format(date){
	var ar=date.split("-");
	return ar[2]+"-"+ar[1]+"-"+ar[0];
}

function exportarMinCom(){
	var a=document.createElement("a");
	a.href="config/export-ins/exportRepMinComEst.php?fecini="+fecini+"&fecfin="+fecfin+
	"&titulo="+$("#spacetitulo").text()+"&esttsc="+esttsc+"&codfic="+codfic;
	a.target="_blank";
	a.click();
}