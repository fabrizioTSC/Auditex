window.onload=cargarDefectos();

function cargarDefectos(){
	$.ajax({
		type:"GET",
		data:{
			onlydefect:1
		},
		url:"config/getDefectoOperacion.php",
		success:function(data){
			//console.log(data);
			if (data.state==true) {
				var htmlDefectos="";
				for (var i = 0; i < data.defectos.length; i++) {
					htmlDefectos+='<div class="tblLine">'+
						'<div class="itemBody" style="width:15%;">'+data.defectos[i].coddef+'</div>'+
						'<div class="itemBody" style="width:70%;">'+data.defectos[i].desdef+'</div>';//+
						//'<div class="itemBody" style="width:35%;">'+data.defectos[i].coddefaux+'</div>';
						if (data.defectos[i].estado=='A') {
							htmlDefectos+='<div class="itemBody" style="width:15%;">Activo</div>';	
						}else{
							htmlDefectos+='<div class="itemBody" style="width:15%;">Inactivo</div>';	
						}
					htmlDefectos+='</div>';
				}
				$(".tblBody").append(htmlDefectos);
			}
			$(".panelCarga").fadeOut(300);
		}
	});
}

function agregarDefecto(){
	var desc=$("#description").val();
	var descaux=$("#descriptionAuxiliar").val();
	if (desc==""||descaux=="") {
		alert("Complete los campos!");
	}else{
		$(".panelCarga").fadeIn(300);
		$.ajax({
			type:"POST",
			url:"config/saveDefecto.php",
			data:{
				desc:desc,
				descaux:descaux
			},
			success:function(data){
				if(data.state==true){
					alert("Agregado correctamente!");
					window.location.reload();
				}else{
					alert(data.error.description);
				}
				$(".panelCarga").fadeOut(300);
			}
		});
	}
}