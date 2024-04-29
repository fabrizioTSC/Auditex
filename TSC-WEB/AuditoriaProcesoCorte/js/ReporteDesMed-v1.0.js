var val_round=100;
$(document).ready(function(){
	$("#space-tbl-generate").scroll(function(){
		var des=$("#space-tbl-generate").scrollTop();
		if (des>20) {
			$(".header-content").css("position","absolute");
			$(".header-content").css("top",$("#space-tbl-generate").scrollTop()+"px");
		}else{
			$(".header-content").css("position","relative");
			$(".header-content").css("top","0px");
		}
	});
	$("#resume-medida").scroll(function(){
		var des=$("#resume-medida").scrollTop();
		if (des>20) {
			$("#space-res-hader").css("position","absolute");
			$("#space-res-hader").css("top",$("#resume-medida").scrollTop()+"px");
		}else{
			$("#space-res-hader").css("position","relative");
			$("#space-res-hader").css("top","0px");
		}
	});
	$.ajax({
		url:"config/getInfoRepDesMed.php",
		type:"POST",
		data:{
			esttsc:esttsc,
			codfic:codfic
		},
		success:function (data){
			//console.log(data);
			$("#idestcli").text(data.header[0].ESTCLI);
			$("#idcliente").text(data.header[0].DESCLI);
			if (data.datos.length==0) {
				alert("No hay resultados!");
			}else{
				let codmed_ant=data.datos[0].CODMED;
				let sec_ant=data.datos[0].SECUENCIA;
				let html_head=
						'<tr>'+
						    '<th>Desv.</th>';
				let html_total=
						'<tr>'+
						    '<th class="class-total">TOTAL</th>';
				let html_body=
						'<tr>'+
						    '<td>'+data.datos[0].VALPUL+'</td>';
				let html=
					'<h5>'+data.datos[0].DESMED+'</h5>'+
					'<center><span class="titlefue" data-codmed="'+data.datos[0].CODMED+'"></span>% fuera de tolerancia</center>'+
					'<center><span class="titleden" data-codmed="'+data.datos[0].CODMED+'"></span>% dentro de tolerancia</center>'+
					'<table style="width: 100%;">';
				let inicio=true;
				let color='#fff';
				for (var i = 0; i < data.datos.length; i++) {
					if (data.datos[i].CODMED!=codmed_ant) {

						codmed_ant=data.datos[i].CODMED;
						html+=
						html_head+
						html_body+
							'<td class="totpul totmed-'+data.datos[i].CODMED+'" id="'+data.datos[i].CODMED+'-'+data.datos[i].VALPUL+'" data-codmed="'+data.datos[i].CODMED+'" data-valpul="'+data.datos[i].VALPUL+'">'+data.datos[i].TOTAL+'</td>'+
							'<td class="portotpul" data-codmed="'+data.datos[i].CODMED+'" data-valpul="'+data.datos[i].VALPUL+'">'+data.datos[i].TOTAL+'%</td>'+
						'</tr>'+
						html_total+
					'</table>'+
					'<h5>'+data.datos[i].DESMED+'</h5>'+
					'<center><span class="titlefue" data-codmed="'+data.datos[i].CODMED+'"></span>% fuera de tolerancia</center>'+
					'<center><span class="titleden" data-codmed="'+data.datos[i].CODMED+'"></span>% dentro de tolerancia</center>'+
					'<table style="width: 100%;">';

						html_head=
						'<tr>'+
						    '<th>Desv.</th>';
						html_total=
						'<tr>'+
						    '<th class="class-total">TOTAL</th>';
						html_body='';
						inicio=false;

					}
						if (data.datos[i].SECUENCIA=="1") {
							html_head+=
							'<th>'+data.datos[i].DESTAL+'</th>';
							html_total+=
							'<th class="class-total class-totsum" data-codmed="'+data.datos[i].CODMED+'" data-codtal="'+data.datos[i].CODTAL+'"></th>'
						}
						if (i>1 && data.datos[i-1].SECUENCIA=="1" && data.datos[i].SECUENCIA=="2") {
							html_head+=
							'<th>TOTAL</th>'+
						    '<th>%</th>'+
						'</tr>';
							html_total+=
							'<th class="class-total class-tot-med" id="'+data.datos[i].CODMED+'" data-codmed="'+data.datos[i].CODMED+'"></th>'+
						    '<th class="class-total">100%</th>'+
						'</tr>';
						}
						if (data.datos[i].SECUENCIA!=sec_ant) {
							sec_ant=data.datos[i].SECUENCIA;
							if (inicio) {
								html_body+=
							'<td class="totpul totmed-'+data.datos[i-1].CODMED+'" id="'+data.datos[i-1].CODMED+'-'+data.datos[i-1].VALPUL+'" data-codmed="'+data.datos[i-1].CODMED+'" data-valpul="'+data.datos[i-1].VALPUL+'">'+data.datos[i-1].TOTAL+'</td>'+
							'<td class="portotpul" data-codmed="'+data.datos[i-1].CODMED+'" data-valpul="'+data.datos[i-1].VALPUL+'">'+data.datos[i-1].TOTAL+'%</td>'+
						'</tr>';
							}
							inicio=true;
							color=get_color(data.datos[i]);
							html_body+=
						'<tr>'+
						    '<td>'+data.datos[i].VALPUL+'</td>'+
						    '<td class="classmed-'+data.datos[i].CODMED+' class-'+data.datos[i].CODMED+'-'+data.datos[i].CODTAL+
						    ' class-'+data.datos[i].CODMED+'-'+data.datos[i].VALPUL+'" style="background:'+color+'">'+data.datos[i].TOTAL+'</td>';
						}else{
							color=get_color(data.datos[i]);
							html_body+=
						    '<td class="classmed-'+data.datos[i].CODMED+' class-'+data.datos[i].CODMED+'-'+data.datos[i].CODTAL+
						    ' class-'+data.datos[i].CODMED+'-'+data.datos[i].VALPUL+'" style="background:'+color+'">'+data.datos[i].TOTAL+'</td>';
						}
					
				}
					html+=
					html_head+
					html_body+
							'<td class="totpul totmed-'+data.datos[data.datos.length-1].CODMED+'" id="'+data.datos[data.datos.length-1].CODMED+'-'+data.datos[data.datos.length-1].VALPUL+'" data-codmed="'+data.datos[data.datos.length-1].CODMED+'" data-valpul="'+data.datos[data.datos.length-1].VALPUL+'">'+data.datos[data.datos.length-1].TOTAL+'</td>'+
							'<td class="portotpul" data-codmed="'+data.datos[data.datos.length-1].CODMED+'" data-valpul="'+data.datos[data.datos.length-1].VALPUL+'">'+data.datos[data.datos.length-1].TOTAL+'%</td>'+
						'</tr>'+
					html_total+
					'</table>';

				$("#content-main").append(html);

				let ar=document.getElementsByClassName("totpul");
				for (var i = 0; i < ar.length; i++) {
					let suma=0;
					var ar_fila=document.getElementsByClassName("class-"+ar[i].dataset.codmed+"-"+ar[i].dataset.valpul);
					for (var j = 0; j < ar_fila.length; j++) {
						suma+=parseInt(ar_fila[j].innerHTML);
					}
					ar[i].innerHTML=suma;
				}

				ar=document.getElementsByClassName("class-totsum");
				for (var i = 0; i < ar.length; i++) {
					let suma=0;
					var ar_fila=document.getElementsByClassName("class-"+ar[i].dataset.codmed+"-"+ar[i].dataset.codtal);
					for (var j = 0; j < ar_fila.length; j++) {
						suma+=parseInt(ar_fila[j].innerHTML);
					}
					ar[i].innerHTML=suma;
				}

				ar=document.getElementsByClassName("class-tot-med");
				for (var i = 0; i < ar.length; i++) {
					let suma=0;
					var ar_fila=document.getElementsByClassName("totmed-"+ar[i].dataset.codmed);
					for (var j = 0; j < ar_fila.length; j++) {
						suma+=parseInt(ar_fila[j].innerHTML);
					}
					ar[i].innerHTML=suma;
				}

				ar=document.getElementsByClassName("portotpul");
				for (var i = 0; i < ar.length; i++) {
					let por=0;
					if (parseInt(document.getElementById(ar[i].dataset.codmed).innerHTML)!=0) {
						por=Math.round(parseInt(document.getElementById(ar[i].dataset.codmed+'-'+ar[i].dataset.valpul).innerHTML)*10000/parseInt(document.getElementById(ar[i].dataset.codmed).innerHTML))/100;
					}
					ar[i].innerHTML=por+"%";
				}

				let arf=document.getElementsByClassName("titlefue");
				let ard=document.getElementsByClassName("titleden");
				for (var i = 0; i < arf.length; i++) {
					let arc=document.getElementsByClassName("classmed-"+ard[i].dataset.codmed);
					let sumf=0;
					let sumt=0;
					for (var j = 0; j < arc.length; j++) {
						sumt+=parseInt(arc[j].innerHTML);
						//console.log(arc[j].style.background);
						if (arc[j].style.background=="rgb(255, 255, 255)") {
							sumf+=parseInt(arc[j].innerHTML);
						}
					}
					if (sumt!=0) {
						arf[i].innerHTML=Math.round(sumf*10000/sumt)/100;
						ard[i].innerHTML=Math.round((sumt-sumf)*10000/sumt)/100;
					}else{
						arf[i].innerHTML=0;
						ard[i].innerHTML=0;
					}
				}
			}
			$(".panelCarga").fadeOut(100);
		}
	});
});

function correct_text(text){
	while(text.indexOf("\"")>=0){
		text=text.replace("\"","");
	}
	return text;
}

function download_excel(){
	/*
	var link="config/exports/exportMedidas.php?codfic="+codfic+"&hilo="+hilo*100+"&travez="+travez*100+"&largamanga="+largmanga*100;
	var a =document.createElement("a");
	a.href=link;
	a.target="_blank";
	a.click();*/
}

function get_color(data){
	if (data.VALPUL=="0") {
		return "#e5ffc9";
	}else{
		if (data.TOLVAL=="0" || data.TOLVAL=="1") {
			return "#e5ffc9";
		}else{
			return "#fff";
		}		
	}
}