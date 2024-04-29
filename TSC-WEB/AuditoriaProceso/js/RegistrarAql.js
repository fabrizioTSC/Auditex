window.onload=function(){
	$.ajax({
		type:"POST",
		url:"config/getAqls.php",
		data:{
			aql:0
		},
		success:function(data){
			//console.log(data);
			if (data.state==true) {
				$("#idSelectAql").empty();
				var html='<option value="0">(Seleccione)</option>';
				for (var i = 0; i < data.aqls.length; i++) {
					html+='<option value="'+data.aqls[i].CODAQL+'">'+data.aqls[i].AQL+'%'+'</option>';
				}
				$("#idSelectAql").append(html);
			}
			$(".panelCarga").fadeOut(300);
		}
	});
}

$(document).ready(function(){
	$("#idSelectAql").change(function(){
		$(".panelCarga").fadeIn(300);
		$("#idTblDetalleAql").css("display","none");
		$("#idMsg").css("display","none");
		$(".tblBodyDetalle").empty();
		if ($("#idSelectAql").val()!="0") {
			$.ajax({
				type:"POST",
				url:"config/getDetalleAql.php",
				data:{
					codaql:$("#idSelectAql").val()
				},
				success:function(data){
					//console.log(data);
					if (data.state==true) {
						if (data.aqls.length!=0) {
							var html="";
							for (var i = 0; i < data.aqls.length; i++) {
								html+='<div class="tblLine">'+
								'<div class="itemBody" style="width: 40%;">'+data.aqls[i].DESRAN+'</div>'+
								'<div class="itemBody" style="width: 30%;">'+data.aqls[i].CANAQL+'</div>'+
								'<div class="itemBody" style="width: 30%;">'+data.aqls[i].CANDEFMAX+'</div>'+
								'</div>';
							}
							$(".tblBodyDetalle").append(html);
							$("#idTblDetalleAql").css("display","block");
						}else{
							$("#idMsg").css("display","block");
						}
					}else{
						alert("Error al cargar informacion!");
					}
					$(".panelCarga").fadeOut(300);
				}
			});
		}
	});
});