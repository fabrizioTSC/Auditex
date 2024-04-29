$(document).ready(function(){
	$(".panelCarga").fadeOut(100);
	$(".btnBuscarSpace").click(function(){
		let codfic=$("#idCodFicha").val();
		if (codfic=="") {
			alert("Escriba el codigo de una ficha!");
		}else{
			document.getElementById("content-result").style.display="none";
			$(".panelCarga").fadeIn(100);
			$.ajax({
				url:'config/validarFichaCLC.php',
				type:'POST',
				data:{
					codfic:codfic
				},
				success: function (data) {
					console.log(data);
					if (data.state) {
						let html='';
						for (var i = 0; i < data.fichas.length; i++) {
							html+=
							'<tr onclick="show_ficha('+data.fichas[i].CODFIC+')">'+
								'<td>'+data.fichas[i].CODUSU+'</td>';
								if (data.fichas[i].CELULA=="") {
							html+=
								'<td>'+data.fichas[i].TALLER+'</td>'+
								'<td>'+data.fichas[i].CANTIDAD+'</td>'+
								'<td>'+data.fichas[i].FECFINAUD+'</td>'+
								'<td>'+data.fichas[i].RESULTADO+'</td>'+
							'</tr>';
								}else{
							html+=
								'<td>'+data.fichas[i].TALLER+' - '+data.fichas[i].CELULA+'</td>'+
								'<td>'+data.fichas[i].CANTIDAD+'</td>'+
								'<td>'+data.fichas[i].FECFINAUD+'</td>'+
								'<td>'+data.fichas[i].RESULTADO+'</td>'+
							'</tr>';
								}							
						}
						document.getElementById("table-body").innerHTML=html;
						document.getElementById("content-result").style.display="block";
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
	$("#idCodFicha").keyup(function(e){
		if (e.keyCode==13) {
			$(".btnBuscarSpace").click();
		}
	});
});

function show_ficha(codfic){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		url:'config/getConFicSel.php',
		type:'POST',
		data:{
			codfic:codfic
		},
		success: function (data) {
			console.log(data);
			if (data.state) {
				window.location.href='VerCheckListCorte.php?codfic='+codfic+
				'&numvez='+data.ficha.NUMVEZ+'&parte='+data.ficha.PARTE+
				'&codtad='+data.ficha.CODTAD+'&partida='+data.ficha.PARTIDA;
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