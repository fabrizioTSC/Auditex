$(document).ready(function(){
	$.ajax({
		url:"config/getParametroReportes.php",
		type:"POST",
		success:function(data){
			var html='';
			for (var i = 0; i < data.parametrosreportes.length; i++) {
				html+=
				'<div class="tblLine">'+
					'<div class="itemBody" style="width: 50%;text-align: center;">'+data.parametrosreportes[i].DESTAD+'</div>'+
					'<div class="itemBody" style="width: 20%;text-align: center;">'+data.parametrosreportes[i].CODRAN+'</div>'+
					'<div class="itemBody" style="width: 30%;text-align: center;"><input class="ipt-to-save" data-codtad="'+data.parametrosreportes[i].CODTAD+'" data-codran="'+data.parametrosreportes[i].CODRAN+'" style="width:calc(100% - 12px);text-align:center;" value="'+data.parametrosreportes[i].VALOR+'"></div>'+
				'</div>';
			}

			$("#data-parametros").empty();
			$("#data-parametros").append(html);

			$(".panelCarga").fadeOut(100);
		}
	});
});

function saveParameters(){
	$(".panelCarga").fadeIn(100);
	var ar=document.getElementsByClassName("ipt-to-save");
	for (var i = 0; i < ar.length; i++) {
		$.ajax({
			url:"config/saveParametroReportes.php",
			type:"POST",
			data:{
				codtad:ar[i].dataset.codtad,
				codran:ar[i].dataset.codran,
				valor:ar[i].value
			},
			success:function(data){
				if (!data.state) {
					alert(data.detail);
				}
				$(".panelCarga").fadeOut(100);
			}
		});		
	}
}