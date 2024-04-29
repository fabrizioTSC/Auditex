$(document).ready(function(){
	$(".panelCarga").fadeOut(100);
	$(".btnBuscarSpace").click(function(){
		let codfic=$("#idCodFicha").val();
		if (codfic=="") {
			alert("Escriba el codigo de una ficha!");
		}else{
			$(".panelCarga").fadeIn(100);
			$.ajax({
				url:'config/validarFichaCLACA.php',
				type:'POST',
				data:{
					codfic:codfic
				},
				success: function (data) {
					console.log(data);
					if (data.state) {
						window.location.href='VerCheckListAcabados.php?codfic='+codfic+
						'&numvez='+data.ficha.NUMVEZ+'&parte='+data.ficha.PARTE+
						'&codtad='+data.ficha.CODTAD+'&partida='+data.ficha.PARTIDA+
						'&codtipser='+data.ficha.CODTIPSER;
					}else{
						alert(data.detail);
					}
			        $(".panelCarga").fadeOut(200);
			    },
			    error: function (jqXHR, exception) {
			        var msg = get_msg_error(jqXHR, exception);
			        alert(msg);
			        $(".panelCarga").fadeOut(100);
			    }
			});
		}
	});
});