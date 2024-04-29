
console.log("INTEGRACION CARGADA");

// INTEGRACION DE MEDIDAS
function RegistrarMedidas_Integracion(ficha,archivo,divcontenido = "DivContenido"){

    $(".panelCarga").fadeIn(100);

	$.ajax({

		url:'/tsc/controllers/auditex-moldes/integracioncorte.controller.php',
		type:'GET',
		data:{
			operacion:'getencogimientos',
			ficha,
			archivo
		},
		success:function(e){
			
			$("#"+divcontenido).removeClass("d-none");
			$("#"+divcontenido).html(e);
			$(".panelCarga").fadeOut(100);
		}

	});

}