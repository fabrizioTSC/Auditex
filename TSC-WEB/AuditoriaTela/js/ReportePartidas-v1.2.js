$(document).ready(function(){
	$("#spaceBtnExport").css("display","none");
	$("#maintbl").css("display","none");
	$("#maintbl").scroll(function(){
		if ($("#maintbl").scrollTop()>50) {
			$("#data-header").css("position","absolute");
			$("#data-header").css("top",$("#maintbl").scrollTop()+"px");
		}else{
			$("#data-header").css("position","relative");
			$("#data-header").css("top","0px");
		}
	});
});

function search_partida(){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		data:{
			partida:($("#idpartida").val()).toUpperCase()
		},
		url:"config/getInfoRepPar.php",
		success:function(data){
			console.log(data);
			if (data.info.length>0) {
				var html='';
				for (var i = 0; i < data.info.length; i++) {
					html+=
					'<div class="tblLine">';
					if (data.info[i].BUTTON=="1") {
						html+=
						'<div class="itemBody2" style="width: 110px;">'+
							'<button class="btnPrimary" style="width:100%;font-size:12px;" onclick="delete_partida(\''+data.info[i].PARTIDA+'\',\''+data.info[i].CODTEL+'\',\''+data.info[i].CODPRV+'\')">Eliminar partida</button>'+
						'</div>';
					}else{
						html+=
						'<div class="itemBody2" style="width: 110px;">'+
							'<button class="btnPrimary" style="width:100%;font-size:12px;" onclick="delete_auditoria(\''+data.info[i].PARTIDA+'\',\''+data.info[i].CODTEL+'\',\''+data.info[i].CODPRV+'\')">Eliminar auditoría</button>'+
						'</div>';
					}
					html+=
					 	'<div class="itemBody2" style="width: 90px;">'+data.info[i].PARTIDA+'</div>'+
					 	'<div class="itemBody2" style="width: 150px;">'+data.info[i].CODTEL+'</div>'+
					 	'<div class="itemBody2" style="width: 90px;">'+data.info[i].SITUACION+'</div>'+
					 	'<div class="itemBody2" style="width: 90px;">'+data.info[i].COLOR+'</div>'+
					 	'<div class="itemBody2" style="width: 150px;">'+data.info[i].DESPRV+'</div>'+
					 	'<div class="itemBody2" style="width: 150px;">'+data.info[i].RUTA+'</div>'+
					 	'<div class="itemBody2" style="width: 150px;">'+data.info[i].ARTICULO+'</div>'+
					 	'<div class="itemBody2" style="width: 150px;">'+data.info[i].COMPOSICION+'</div>'+
					 	'<div class="itemBody2" style="width: 90px;">'+data.info[i].RENDIMIENTO+'</div>'+
					 	'<div class="itemBody2" style="width: 90px;">'+data.info[i].PESO+'</div>'+
					 	'<div class="itemBody2" style="width: 90px;">'+data.info[i].PROGRAMA+'</div>'+
					 	'<div class="itemBody2" style="width: 90px;">'+data.info[i].X_FACTORY+'</div>'+
					 '</div>';
				}
				$("#idTblBody").empty();
				$("#idTblBody").append(html);
				$("#maintbl").css("display","block");
				$("#spaceBtnExport").css("display","flex");
				$("#no-result").css("display","none");
			}else{
				$("#spaceBtnExport").css("display","none");
				$("#maintbl").css("display","none");
				$("#no-result").css("display","block");
			}
			$(".panelCarga").fadeOut(100);
		}
	});
}

function export_excel(){
	var partida=$("#idpartida").val();
	if (partida=="") {
		partida="0";
	}
	var a =document.createElement("a");
	a.href="config/exports/exportRepPar.php?partida="+partida;
	a.target="_blank";
	a.click();
}

function delete_partida(partida,codtel,codprv){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		data:{
			partida:partida,
			codtel:codtel,
			codprv:codprv
		},
		url:"config/deleteFichasRPAudTel.php",
		success:function(data){
			console.log(data);
			if (data.state) {
				window.location.reload();
			}else{
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(100);
		}
	});
}

function delete_auditoria(partida,codtel,codprv){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		data:{
			partida:partida,
			codtel:codtel,
			codprv:codprv
		},
		url:"config/deleteFicAudRP.php",
		success:function(data){
			console.log(data);
			if (data.state) {
				window.location.reload();
			}else{
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(100);
		}
	});
}