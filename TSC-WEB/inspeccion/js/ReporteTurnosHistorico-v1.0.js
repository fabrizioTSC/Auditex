var minutos=5;
var arrow_up='<i class="fa fa-arrow-up" aria-hidden="true" style="color:#008000;"></i>';
var arrow_down='<i class="fa fa-arrow-down" aria-hidden="true" style="color:#840b0b;"></i>';
var arrow_equals='<div style="font-size:65px;font-weight:bold;color:#ff9800;">=</div>';
var efi_top_param=0;
var efi_bottom_param=0;
var pren_top_param=0;
var pren_bottom_param=0;
$(document).ready(function(){
	var heicon=document.getElementsByClassName("content-box")[0].offsetHeight;
	$(".title-box").css("marginTop",heicon*0.2+"px");
	$(".title-box").css("height",heicon*0.6+"px");

	$(".level-one").css("height",heicon*0.3+"px");
	$(".level-two").css("paddingTop",heicon*0.35*0.2+"px");
	$(".level-two").css("height",heicon*0.35*0.5+"px");
	$(".level-two").css("paddingBottom",heicon*0.35*0.1+"px");
	$.ajax({
		url:'config/getInfoReporteTurnosHis.php',
		type:'POST',
		data:{
			type:type,
			fecha:fecha,
			anio:anio,
			semana:semana,
			mes:mes
		},
		success:function(data){
			console.log(data);
			efi_top_param=data.parametrosreportes[1].VALOR;
			efi_bottom_param=data.parametrosreportes[0].VALOR;
			pren_top_param=data.parametrosreportes[3].VALOR;
			pren_bottom_param=data.parametrosreportes[2].VALOR;

			$("#idfecha").text(data.fecha);
			$("#idsemana").text(data.semana);
			$("#idmes").text(data.mes);

			var sumdemtot=0;
			var sumefitot=0;
			var sumefctot=0;
			var sumdemtotant=0;
			var sumefitotant=0;
			var sumefctotant=0;
			var sumpreinstot=0;
			var sumpredeftot=0;
			var sumprereptot=0;
			var sumaudapr=0;
			var sumaudtot=0;

			for (var i = 0; i < data.turnos.length; i++) {
				var pos=data.turnos[i].TURNO;
				var efi=0;
				var sumden_ant=0;
				var sumden=parseFloat(data.turnos[i].MINASI1)+parseFloat(data.turnos[i].MINASI2);
				var l;
				console.log(sumden);
				sumaudapr+=parseInt(data.turnos[i].AUDAPR);
				sumaudtot+=parseInt(data.turnos[i].AUDTOT);
				$("#num"+pos).text(data.turnos[i].AUDAPR);
				$("#den"+pos).text(data.turnos[i].AUDTOT);
				if (sumden!=0) {
					efi=Math.round(parseFloat(data.turnos[i].MINEFI)*100/sumden);
					console.log(efi);
				}
				$("#eficiencia"+pos).text(efi+"%");
				
				if (efi!=0) {
					for (var j = 0; j < data.turnos_ant.length; j++) {
						if(data.turnos_ant[j].TURNO==data.turnos[i].TURNO){
							l=j;
						}
					}
					if (l!=null) {
						var efi_ant=0;
						sumden_ant=parseFloat(data.turnos_ant[l].MINASI1)+parseFloat(data.turnos_ant[l].MINASI2);
						if (sumden_ant!=0) {
							efi_ant=Math.round(parseFloat(data.turnos_ant[l].MINEFI)*100/sumden_ant);
						}
						sumefitotant+=parseFloat(data.turnos_ant[l].MINEFI);
						if (efi>efi_ant) {
							$("#arrow-eficiencia"+pos).append(arrow_up);
						}else{
							if(efi!=efi_ant){
								$("#arrow-eficiencia"+pos).append(arrow_down);
							}else{
								$("#arrow-eficiencia"+pos).append(arrow_equals);				
							}
						}
					}
				}else{
					$("#arrow-eficiencia"+pos).append();
				}

				if (efi!=0) {
					if (efi>efi_top_param) {
						$("#ctrl_efi_"+pos).addClass("content-green");
					}else{
						if (efi<efi_bottom_param) {
							$("#ctrl_efi_"+pos).addClass("content-red");
						}else{
							$("#ctrl_efi_"+pos).addClass("content-yellow");
						}
					}
				}

				var efc=0;
				if (sumden!=0) {
					efc=Math.round(parseFloat(data.turnos[i].MINEFC)*100/sumden);
				}
				$("#eficacia"+pos).text(efc+"%");
				
				if (efc!=0) {
					if (l!=null) {
						var efc_ant=0;
						if (sumden_ant!=0) {
							efc_ant=Math.round(parseFloat(data.turnos_ant[l].MINEFC)*100/sumden_ant);
						}
						sumefctotant+=parseFloat(data.turnos_ant[l].MINEFC);
						if (efc>efc_ant) {
							$("#arrow-eficacia"+pos).append(arrow_up);
						}else{
							if(efc!=efc_ant){
								$("#arrow-eficacia"+pos).append(arrow_down);
							}else{
								$("#arrow-eficacia"+pos).append(arrow_equals);				
							}
						}
					}
				}else{
					$("#arrow-eficacia"+pos).append();
				}

				if (efc!=0) {
					if (efc>efi_top_param) {
						$("#ctrl_efc_"+pos).addClass("content-green");
					}else{
						if (efc<efi_bottom_param) {
							$("#ctrl_efc_"+pos).addClass("content-red");
							$("#frac-"+pos).css("background","white");
						}else{
							$("#ctrl_efc_"+pos).addClass("content-yellow");
						}
					}
				}

				if(data.turnos[i].PREINS!=0){
					var porpredef=Math.round(data.turnos[i].PREDEF*100/data.turnos[i].PREINS);
					$("#pren_defe"+pos).text(data.turnos[i].PREDEF);
					$("#pren_defe_porc"+pos).text("("+porpredef+"%)");

					var porprerep=Math.round(data.turnos[i].PREREP*100/data.turnos[i].PREINS);
					$("#pren_repr"+pos).text(data.turnos[i].PREREP);
					$("#pren_repr_porc"+pos).text("("+porprerep+"%)");

					if (porpredef>pren_top_param) {
						$("#ctrl_defe_porc"+pos).addClass("content-red");
						$("#ctrl_repr_porc"+pos).addClass("content-red");
					}else{
						if (porpredef<pren_bottom_param) {
							$("#ctrl_defe_porc"+pos).addClass("content-green");
							$("#ctrl_repr_porc"+pos).addClass("content-green");
						}else{
							$("#ctrl_defe_porc"+pos).addClass("content-yellow");
							$("#ctrl_repr_porc"+pos).addClass("content-yellow");
						}		
					}
				}
				sumdemtot+=sumden;
				sumefitot+=parseFloat(data.turnos[i].MINEFI);
				sumefctot+=parseFloat(data.turnos[i].MINEFC);
				sumpreinstot+=parseFloat(data.turnos[i].PREINS);
				sumpredeftot+=parseFloat(data.turnos[i].PREDEF);
				sumprereptot+=parseFloat(data.turnos[i].PREREP);
				sumdemtotant+=sumden_ant;
			}

			var pos=3;
			var efitot=0;
			var efctot=0;
			$("#num"+pos).text(sumaudapr);
			$("#den"+pos).text(sumaudtot);
			if (sumdemtot!=0) {
				efitot=Math.round(sumefitot*100/sumdemtot);
				efctot=Math.round(sumefctot*100/sumdemtot);
			}
			$("#eficiencia"+pos).text(efitot+"%");
			$("#eficacia"+pos).text(efctot+"%");
			if (efitot!=0) {
				var efitot_ant=0;
				if (sumden_ant!=0) {
					efitot_ant=Math.round(sumefitotant*100/sumdemtotant);
				}
				if (efitot>efitot_ant) {
					$("#arrow-eficiencia"+pos).append(arrow_up);
				}else{
					if(efitot!=efitot_ant){
						$("#arrow-eficiencia"+pos).append(arrow_down);
					}else{
						$("#arrow-eficiencia"+pos).append(arrow_equals);				
					}
				}
			}else{
				$("#arrow-eficiencia"+pos).append();
			}
			if (efitot!=0) {
				if (efitot>efi_top_param) {
					$("#ctrl_efi_"+pos).addClass("content-green");
				}else{
					if (efitot<efi_bottom_param) {
						$("#ctrl_efi_"+pos).addClass("content-red");
					}else{
						$("#ctrl_efi_"+pos).addClass("content-yellow");
					}
				}
			}			
			if (efctot!=0) {
				if (l!=null) {
					var efctot_ant=0;
					if (sumden_ant!=0) {
						efctot_ant=Math.round(sumefctotant*100/sumdemtotant);
					}
					if (efctot>efctot_ant) {
						$("#arrow-eficacia"+pos).append(arrow_up);
					}else{
						if(efctot!=efctot_ant){
							$("#arrow-eficacia"+pos).append(arrow_down);
						}else{
							$("#arrow-eficacia"+pos).append(arrow_equals);				
						}
					}
				}
			}else{
				$("#arrow-eficacia"+pos).append();
			}
			if (efctot!=0) {
				if (efctot>efi_top_param) {
					$("#ctrl_efc_"+pos).addClass("content-green");
				}else{
					if (efctot<efi_bottom_param) {
						$("#ctrl_efc_"+pos).addClass("content-red");
						$("#frac-"+pos).css("background","white");
					}else{
						$("#ctrl_efc_"+pos).addClass("content-yellow");
					}
				}
			}
			if(sumpreinstot!=0){
				var porpredef=Math.round(sumpredeftot*100/sumpreinstot);
				$("#pren_defe"+pos).text(sumpredeftot);
				$("#pren_defe_porc"+pos).text("("+porpredef+"%)");

				var porprerep=Math.round(sumprereptot*100/sumpreinstot);
				$("#pren_repr"+pos).text(sumprereptot);
				$("#pren_repr_porc"+pos).text("("+porprerep+"%)");

				if (porpredef>pren_top_param) {
					$("#ctrl_defe_porc"+pos).addClass("content-red");
					$("#ctrl_repr_porc"+pos).addClass("content-red");
				}else{
					if (porpredef<pren_bottom_param) {
						$("#ctrl_defe_porc"+pos).addClass("content-green");
						$("#ctrl_repr_porc"+pos).addClass("content-green");
					}else{
						$("#ctrl_defe_porc"+pos).addClass("content-yellow");
						$("#ctrl_repr_porc"+pos).addClass("content-yellow");
					}		
				}
			}


			$(".panelCarga").fadeOut(100);
		},
	    error: function (jqXHR, exception) {
	        var msg = '';
	        if (jqXHR.status === 0) {
	            msg = 'Sin conexión.\nVerifique su conexión a internet!';
	        } else if (jqXHR.status == 404) {
	            msg = 'No se encuentra el archivo necesario para guardar la inspección!';
	        } else if (jqXHR.status == 500) {
	            msg = 'Servidor no disponible (Web de TSC). Intente más tarde';
	        } else if (exception === 'parsererror') {
	            msg = 'La respuesta tiene errores. Por favor, contactar al equipo de desarrollo!';
	        } else if (exception === 'timeout') {
	            msg = 'Tiempo de respuesta muy largo (Web de TSC)!';
	        } else if (exception === 'abort') {
	            msg = 'Se cancelo la consulta!';
	        } else {
	            msg = 'Error desconocido.\n' + jqXHR.responseText+'.\nInforme al equipo de desarrollo!';
	        }
	        $("#idMsg").text(msg);
	        $("#idContentMsg").fadeIn(200);/*
	        setTimeout(function(){
				window.location.reload();
	        },3000);*/
	    }
	});
});