window.chartColors = {
	red: 'rgb(255, 99, 132)',
	reddark: 'rgb(255, 50, 60)',
	orange: 'rgb(255, 159, 64)',
	yellow: 'rgb(255, 205, 86)',
	green: 'rgb(80, 200, 2)',
	blue: 'rgb(54, 162, 235)',
	purple: 'rgb(153, 102, 255)',
	grey: 'rgb(201, 203, 207)',
	black: 'rgb(50, 50, 50)',
	mostaza: 'rgb(195, 170, 5)',
	reddarkdark: 'rgb(140, 10, 20)'
};

var param_codran1=0;
var param_codran2=0;
$(document).ready(function(){
	$.ajax({
		type:"POST",
		data:{
			codprv:codprv,
			codusu:codusurep,
			codusueje:codusueje,
			bloque:bloque,
			fecha:fecha
		},
		url:"config/getInfoIndicadores.php",
		success:function(data){
			console.log(data);
			var labels=[];
			var rechazado=[];
			var aprnocon=[];
			var aprobado=[];
			var colors=[];
			var html='';
			param_codran2=parseInt(data.param[0].VALOR);
			param_codran1=parseInt(data.param[1].VALOR);
			$("#titulodetalle").append(data.titulo);
			for (var i = 0; i < data.anios.length; i++) {
				var PorKgApr=0;
				var PorKgCon=0;
				var PorKgRec=0;
				if (data.anios[i]['PESTOT']!="0") {
					PorKgApr=Math.round(data.anios[i]['PESAPR']*10000/data.anios[i]['PESTOT'])/100;
					PorKgCon=Math.round(data.anios[i]['PESCON']*10000/data.anios[i]['PESTOT'])/100;
					PorKgRec=Math.round(data.anios[i]['PESREC']*10000/data.anios[i]['PESTOT'])/100;
				}
				var PorAudApr=0;
				var PorAudCon=0;
				var PorAudRec=0;
				if (data.anios[i]['CANTOT']!="0") {
					PorAudApr=Math.round(data.anios[i]['CANAPR']*10000/data.anios[i]['CANTOT'])/100;
					PorAudCon=Math.round(data.anios[i]['CANCON']*10000/data.anios[i]['CANTOT'])/100;
					PorAudRec=Math.round(data.anios[i]['CANREC']*10000/data.anios[i]['CANTOT'])/100;
				}
				var styleC="colorB";
				var color=window.chartColors.yellow;
				if (PorKgApr>=param_codran1) {
					styleC="colorA";
					color=window.chartColors.green;
				}else{
					if (PorKgApr<param_codran2) {
						styleC="colorC";
						color=window.chartColors.reddark;
					}
				}
				var styleC2="colorB";
				if (PorAudApr>=param_codran1) {
					styleC2="colorA";
				}else{
					if (PorAudApr<param_codran2) {
						styleC2="colorC";
					}
				}
				html+=
				'<div class="divanios[i]">'+
					'<div class="itemhs1">'+data.anios[i]['ANHO']+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['PESTOT'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['PESAPR'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['PESCON'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['PESREC'])+'</div>'+
					'<div class="itemhs1 items4 '+styleC+'">'+PorKgApr+'%</div>'+
					'<div class="itemhs1 items4">'+PorKgCon+'%</div>'+
					'<div class="itemhs1 items4">'+PorKgRec+'%</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['CANTOT'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['CANAPR'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['CANCON'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.anios[i]['CANREC'])+'</div>'+
					'<div class="itemhs1 items4 '+styleC2+'">'+PorAudApr+'%</div>'+
					'<div class="itemhs1 items4">'+PorAudCon+'%</div>'+
					'<div class="itemhs1 items4">'+PorAudRec+'%</div>'+
				'</div>';
				colors.push(color);
				labels.push(data.anios[i]['ANHO']);
				rechazado.push(PorKgRec);
				aprnocon.push(PorKgCon);
				aprobado.push(PorKgApr);
			}
			$("#placeAnios").append(html);

			html='';
			for (var i = 0; i < data.meses.length; i++) {
				var PorKgApr=0;
				var PorKgCon=0;
				var PorKgRec=0;
				if (data.meses[i]['PESTOT']!="0") {
					PorKgApr=Math.round(data.meses[i]['PESAPR']*10000/data.meses[i]['PESTOT'])/100;
					PorKgCon=Math.round(data.meses[i]['PESCON']*10000/data.meses[i]['PESTOT'])/100;
					PorKgRec=Math.round(data.meses[i]['PESREC']*10000/data.meses[i]['PESTOT'])/100;
				}
				var PorAudApr=0;
				var PorAudCon=0;
				var PorAudRec=0;
				if (data.meses[i]['CANTOT']!="0") {
					PorAudApr=Math.round(data.meses[i]['CANAPR']*10000/data.meses[i]['CANTOT'])/100;
					PorAudCon=Math.round(data.meses[i]['CANCON']*10000/data.meses[i]['CANTOT'])/100;
					PorAudRec=Math.round(data.meses[i]['CANREC']*10000/data.meses[i]['CANTOT'])/100;
				}
				var styleC="colorB";
				var color=window.chartColors.yellow;
				if (PorKgApr>=param_codran1) {
					styleC="colorA";
					color=window.chartColors.green;
				}else{
					if (PorKgApr<param_codran2) {
						styleC="colorC";
						color=window.chartColors.reddark;
					}
				}
				var styleC2="colorB";
				if (PorAudApr>=param_codran1) {
					styleC2="colorA";
				}else{
					if (PorAudApr<param_codran2) {
						styleC2="colorC";
					}
				}
				html+=
				'<div class="divanios[i]">'+
					'<div class="itemhs1">'+proceMes(data.meses[i]['MES'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['PESTOT'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['PESAPR'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['PESCON'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['PESREC'])+'</div>'+
					'<div class="itemhs1 items4 '+styleC+'">'+PorKgApr+'%</div>'+
					'<div class="itemhs1 items4">'+PorKgCon+'%</div>'+
					'<div class="itemhs1 items4">'+PorKgRec+'%</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['CANTOT'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['CANAPR'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['CANCON'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.meses[i]['CANREC'])+'</div>'+
					'<div class="itemhs1 items4 '+styleC2+'">'+PorAudApr+'%</div>'+
					'<div class="itemhs1 items4">'+PorAudCon+'%</div>'+
					'<div class="itemhs1 items4">'+PorAudRec+'%</div>'+
				'</div>';
				colors.push(color);
				labels.push(proceMes(data.meses[i]['MES']));
				rechazado.push(PorKgRec);
				aprnocon.push(PorKgCon);
				aprobado.push(PorKgApr);
			}
			$("#placeMeses").append(html);

			html='';
			var numSem=0;
			for (var i = 0; i < data.semanas.length; i++) {
				var PorKgApr=0;
				var PorKgCon=0;
				var PorKgRec=0;
				if (data.semanas[i]['PESTOT']!="0") {
					PorKgApr=Math.round(data.semanas[i]['PESAPR']*10000/data.semanas[i]['PESTOT'])/100;
					PorKgCon=Math.round(data.semanas[i]['PESCON']*10000/data.semanas[i]['PESTOT'])/100;
					PorKgRec=Math.round(data.semanas[i]['PESREC']*10000/data.semanas[i]['PESTOT'])/100;
				}
				var PorAudApr=0;
				var PorAudCon=0;
				var PorAudRec=0;
				if (data.semanas[i]['CANTOT']!="0") {
					PorAudApr=Math.round(data.semanas[i]['CANAPR']*10000/data.semanas[i]['CANTOT'])/100;
					PorAudCon=Math.round(data.semanas[i]['CANCON']*10000/data.semanas[i]['CANTOT'])/100;
					PorAudRec=Math.round(data.semanas[i]['CANREC']*10000/data.semanas[i]['CANTOT'])/100;
				}
				var styleC="colorB";
				var color=window.chartColors.yellow;
				if (PorKgApr>=param_codran1) {
					styleC="colorA";
					color=window.chartColors.green;
				}else{
					if (PorKgApr<param_codran2) {
						styleC="colorC";
						color=window.chartColors.reddark;
					}
				}
				var styleC2="colorB";
				if (PorAudApr>=param_codran1) {
					styleC2="colorA";
				}else{
					if (PorAudApr<param_codran2) {
						styleC2="colorC";
					}
				}
				html+=
				'<div class="divanios[i]">'+
					'<div class="itemhs1">S. '+data.semanas[i]['NUMERO_SEMANA']+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['PESTOT'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['PESAPR'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['PESCON'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['PESREC'])+'</div>'+
					'<div class="itemhs1 items4 '+styleC+'">'+PorKgApr+'%</div>'+
					'<div class="itemhs1 items4">'+PorKgCon+'%</div>'+
					'<div class="itemhs1 items4">'+PorKgRec+'%</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['CANTOT'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['CANAPR'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['CANCON'])+'</div>'+
					'<div class="itemhs1 items4">'+formatNumber(data.semanas[i]['CANREC'])+'</div>'+
					'<div class="itemhs1 items4 '+styleC2+'">'+PorAudApr+'%</div>'+
					'<div class="itemhs1 items4">'+PorAudCon+'%</div>'+
					'<div class="itemhs1 items4">'+PorAudRec+'%</div>'+
				'</div>';
				colors.push(color);
				labels.push("S. "+data.semanas[i]['NUMERO_SEMANA']);
				rechazado.push(PorKgRec);
				aprnocon.push(PorKgCon);
				aprobado.push(PorKgApr);
			}
			$("#placeSemanas").append(html);

			processGraph(labels,rechazado,aprnocon,aprobado,colors);

			if(codprv=="0"){
				html='';
				var html2='';
				for (var i = 0; i < data.proveedores.length; i++) {
					var color="#000";
					var background="#ddd";
					if (i%2==0) {
						background="#fff";
					}
					html+='<div class="items1 items2 item-ajustar" style="background: '+background+';">'+data.proveedores[i]+'</div>';
					html2+=
						'<div class="items1 items2" style="background:'+background+';color:'+color+';"># TOT. KG.</div>'+
						'<div class="items1 items2" style="background:'+background+';color:'+color+';"># TOT. KG. APROBADOS</div>'+
						'<div class="items1 items2" style="background:'+background+';color:'+color+';"># TOT. KG. APR. NO CON.</div>'+
						'<div class="items1 items2" style="background:'+background+';color:'+color+';"># TOT. KG. RECHAZADOS</div>'+
						'<div class="items1" style="background:'+background+';color:'+color+';">% KG. APROBADOS</div>'+
						'<div class="items1" style="background:'+background+';color:'+color+';">% KG. APR. NO CON.</div>'+
						'<div class="items1" style="background:'+background+';color:'+color+';">% KG. RECHAZADOS</div>';
				}
				$("#placeProvee").append(html);
				$("#placeDetalle").append(html2);

				var html=
					'<div style="display:flex;">';
				for (var i = 0; i < data.headers.length; i++) {
					if (i>8) {
						html+='<div class="itemhs1">'+data.headers[i]+'</div>';
					}else{
						if (i>2) {
							html+='<div class="itemhs1">'+proceMes(data.headers[i])+'</div>';
						}else{
							html+='<div class="itemhs1">'+data.headers[i]+'</div>';
						}		
					}				
				}
				html+=
					'</div>'+
					'<div style="display:flex;">'+
						'<div id="placeAniosP">'+
						'</div>'+
						'<div id="placeMesesP">'+
						'</div>'+
						'<div id="placeSemanasP">'+
						'</div>'+
					'</div>';
				$("#tblByPro").append(html);

				var html='';
				var ant_pro='';
				var color_table="#000";
				var background="#ddd";
				var l=0;
				for (var i = 0; i < data.aniosprv.length; i++) {
					var PorKgApr=0;
					var PorKgCon=0;
					var PorKgRec=0;
					if(data.aniosprv[i]['PESTOT']!=0){
						PorKgApr=Math.round(data.aniosprv[i]['PESAPR']*10000/data.aniosprv[i]['PESTOT'])/100;
						PorKgCon=Math.round(data.aniosprv[i]['PESCON']*10000/data.aniosprv[i]['PESTOT'])/100;
						PorKgRec=Math.round(data.aniosprv[i]['PESREC']*10000/data.aniosprv[i]['PESTOT'])/100;
					}
					var styleC="colorB";
					var color=window.chartColors.yellow;
					if (PorKgApr>=param_codran1) {
						styleC="colorA";
						color=window.chartColors.green;
					}else{
						if (PorKgApr<param_codran2) {
							styleC="colorC";
							color=window.chartColors.reddark;
						}
					}
					if (ant_pro!=data.aniosprv[i]['DESPRV']) {
						l++;
						ant_pro=data.aniosprv[i]['DESPRV'];
						if (i!=0) {
							html+=
				'</div>';
						}
						html+=
				'<div class="contents">';
					}
					if (l%2==1) {
						background="#fff";
					}else{
						background="#ddd";
					}
					html+=
					'<div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.aniosprv[i]['PESTOT'])+'</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.aniosprv[i]['PESAPR'])+'</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.aniosprv[i]['PESCON'])+'</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.aniosprv[i]['PESREC'])+'</div>'+
						'<div class="itemhs1 items4 '+styleC+'">'+PorKgApr+'%</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+PorKgCon+'%</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+PorKgRec+'%</div>'+
					'</div>';
				}
				html+=
				'</div>';
				$("#placeAniosP").append(html);

				html='';
				ant_pro='';
				var l=0;
				for (var i = 0; i < data.mesesprv.length; i++) {
					var PorKgApr=0;
					var PorKgCon=0;
					var PorKgRec=0;
					if(data.mesesprv[i]['PESTOT']!=0){
						PorKgApr=Math.round(data.mesesprv[i]['PESAPR']*10000/data.mesesprv[i]['PESTOT'])/100;
						PorKgCon=Math.round(data.mesesprv[i]['PESCON']*10000/data.mesesprv[i]['PESTOT'])/100;
						PorKgRec=Math.round(data.mesesprv[i]['PESREC']*10000/data.mesesprv[i]['PESTOT'])/100;
					}
					var styleC="colorB";
					var color=window.chartColors.yellow;
					if (PorKgApr>=param_codran1) {
						styleC="colorA";
						color=window.chartColors.green;
					}else{
						if (PorKgApr<param_codran2) {
							styleC="colorC";
							color=window.chartColors.reddark;
						}
					}
					if (ant_pro!=data.mesesprv[i]['DESPRV']) {
						ant_pro=data.mesesprv[i]['DESPRV'];
						l++;
						if (i!=0) {
							html+=
				'</div>';
						}
						html+=
				'<div class="contents">';
					}
					if (l%2==1) {
						background="#fff";
					}else{
						background="#ddd";
					}
					html+=
					'<div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.mesesprv[i]['PESTOT'])+'</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.mesesprv[i]['PESAPR'])+'</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.mesesprv[i]['PESCON'])+'</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.mesesprv[i]['PESREC'])+'</div>'+
						'<div class="itemhs1 items4 '+styleC+'">'+PorKgApr+'%</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+PorKgCon+'%</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+PorKgRec+'%</div>'+
					'</div>';
				}
				html+=
				'</div>';
				$("#placeMesesP").append(html);

				html='';
				ant_pro='';
				l=0;
				for (var i = 0; i < data.semanasprv.length; i++) {
					var PorKgApr=0;
					var PorKgCon=0;
					var PorKgRec=0;
					if(data.semanasprv[i]['PESTOT']!=0){
						PorKgApr=Math.round(data.semanasprv[i]['PESAPR']*10000/data.semanasprv[i]['PESTOT'])/100;
						PorKgCon=Math.round(data.semanasprv[i]['PESCON']*10000/data.semanasprv[i]['PESTOT'])/100;
						PorKgRec=Math.round(data.semanasprv[i]['PESREC']*10000/data.semanasprv[i]['PESTOT'])/100;
					}
					var styleC="colorB";
					var color=window.chartColors.yellow;
					if (PorKgApr>=param_codran1) {
						styleC="colorA";
						color=window.chartColors.green;
					}else{
						if (PorKgApr<param_codran2) {
							styleC="colorC";
							color=window.chartColors.reddark;
						}
					}
					if (ant_pro!=data.semanasprv[i]['DESPRV']) {
						l++;
						ant_pro=data.semanasprv[i]['DESPRV'];
						if (i!=0) {
							html+=
				'</div>';
						}
						html+=
				'<div class="contents">';
					}
					if (l%2==1) {
						background="#fff";
					}else{
						background="#ddd";
					}
					html+=
					'<div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.semanasprv[i]['PESTOT'])+'</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.semanasprv[i]['PESAPR'])+'</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.semanasprv[i]['PESCON'])+'</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.semanasprv[i]['PESREC'])+'</div>'+
						'<div class="itemhs1 items4 '+styleC+'">'+PorKgApr+'%</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+PorKgCon+'%</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+PorKgRec+'%</div>'+
					'</div>';
				}
				html+=
				'</div>';
				$("#placeSemanasP").append(html);
			}else{
				$("#tblforprv").remove();
			}

			//////

				html='';
				var html2='';
				for (var i = 0; i < data.clientes.length; i++) {
					var color="#000";
					var background="#ddd";
					if (i%2==0) {
						background="#fff";
					}
					html+='<div class="items1 items2 item-ajustar" style="background: '+background+';">'+data.clientes[i]+'</div>';
					html2+=
						'<div class="items1 items2" style="background:'+background+';color:'+color+';"># TOT. KG.</div>'+
						'<div class="items1 items2" style="background:'+background+';color:'+color+';"># TOT. KG. APROBADOS</div>'+
						'<div class="items1 items2" style="background:'+background+';color:'+color+';"># TOT. KG. APR. NO CON.</div>'+
						'<div class="items1 items2" style="background:'+background+';color:'+color+';"># TOT. KG. RECHAZADOS</div>'+
						'<div class="items1" style="background:'+background+';color:'+color+';">% KG. APROBADOS</div>'+
						'<div class="items1" style="background:'+background+';color:'+color+';">% KG. APR. NO CON.</div>'+
						'<div class="items1" style="background:'+background+';color:'+color+';">% KG. RECHAZADOS</div>';
				}
				$("#placeCli").append(html);
				$("#placeDetalleCli").append(html2);

				var html=
					'<div style="display:flex;">';
				for (var i = 0; i < data.headerscli.length; i++) {
					if (i>8) {
						html+='<div class="itemhs1">'+data.headerscli[i]+'</div>';
					}else{
						if (i>2) {
							html+='<div class="itemhs1">'+proceMes(data.headerscli[i])+'</div>';
						}else{
							html+='<div class="itemhs1">'+data.headerscli[i]+'</div>';
						}		
					}				
				}
				html+=
					'</div>'+
					'<div style="display:flex;">'+
						'<div id="placeAniosC">'+
						'</div>'+
						'<div id="placeMesesC">'+
						'</div>'+
						'<div id="placeSemanasC">'+
						'</div>'+
					'</div>';
				$("#tblByCli").append(html);

				var html='';
				var ant_pro='';
				var color_table="#000";
				var background="#ddd";
				var l=0;
				for (var i = 0; i < data.anioscli.length; i++) {
					var PorKgApr=0;
					var PorKgCon=0;
					var PorKgRec=0;
					if(data.anioscli[i]['PESTOT']!=0){
						PorKgApr=Math.round(data.anioscli[i]['PESAPR']*10000/data.anioscli[i]['PESTOT'])/100;
						PorKgCon=Math.round(data.anioscli[i]['PESCON']*10000/data.anioscli[i]['PESTOT'])/100;
						PorKgRec=Math.round(data.anioscli[i]['PESREC']*10000/data.anioscli[i]['PESTOT'])/100;
					}
					var styleC="colorB";
					var color=window.chartColors.yellow;
					if (PorKgApr>=param_codran1) {
						styleC="colorA";
						color=window.chartColors.green;
					}else{
						if (PorKgApr<param_codran2) {
							styleC="colorC";
							color=window.chartColors.reddark;
						}
					}
					if (ant_pro!=data.anioscli[i]['DESPRV']) {
						l++;
						ant_pro=data.anioscli[i]['DESPRV'];
						if (i!=0) {
							html+=
				'</div>';
						}
						html+=
				'<div class="contents">';
					}
					if (l%2==1) {
						background="#fff";
					}else{
						background="#ddd";
					}
					html+=
					'<div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.anioscli[i]['PESTOT'])+'</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.anioscli[i]['PESAPR'])+'</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.anioscli[i]['PESCON'])+'</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.anioscli[i]['PESREC'])+'</div>'+
						'<div class="itemhs1 items4 '+styleC+'">'+PorKgApr+'%</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+PorKgCon+'%</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+PorKgRec+'%</div>'+
					'</div>';
				}
				html+=
				'</div>';
				$("#placeAniosC").append(html);

				html='';
				ant_pro='';
				var l=0;
				for (var i = 0; i < data.mesescli.length; i++) {
					var PorKgApr=0;
					var PorKgCon=0;
					var PorKgRec=0;
					if(data.mesescli[i]['PESTOT']!=0){
						PorKgApr=Math.round(data.mesescli[i]['PESAPR']*10000/data.mesescli[i]['PESTOT'])/100;
						PorKgCon=Math.round(data.mesescli[i]['PESCON']*10000/data.mesescli[i]['PESTOT'])/100;
						PorKgRec=Math.round(data.mesescli[i]['PESREC']*10000/data.mesescli[i]['PESTOT'])/100;
					}
					var styleC="colorB";
					var color=window.chartColors.yellow;
					if (PorKgApr>=param_codran1) {
						styleC="colorA";
						color=window.chartColors.green;
					}else{
						if (PorKgApr<param_codran2) {
							styleC="colorC";
							color=window.chartColors.reddark;
						}
					}
					if (ant_pro!=data.mesescli[i]['DESPRV']) {
						ant_pro=data.mesescli[i]['DESPRV'];
						l++;
						if (i!=0) {
							html+=
				'</div>';
						}
						html+=
				'<div class="contents">';
					}
					if (l%2==1) {
						background="#fff";
					}else{
						background="#ddd";
					}
					html+=
					'<div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.mesescli[i]['PESTOT'])+'</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.mesescli[i]['PESAPR'])+'</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.mesescli[i]['PESCON'])+'</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.mesescli[i]['PESREC'])+'</div>'+
						'<div class="itemhs1 items4 '+styleC+'">'+PorKgApr+'%</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+PorKgCon+'%</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+PorKgRec+'%</div>'+
					'</div>';
				}
				html+=
				'</div>';
				$("#placeMesesC").append(html);

				html='';
				ant_pro='';
				l=0;
				for (var i = 0; i < data.semanascli.length; i++) {
					var PorKgApr=0;
					var PorKgCon=0;
					var PorKgRec=0;
					if(data.semanascli[i]['PESTOT']!=0){
						PorKgApr=Math.round(data.semanascli[i]['PESAPR']*10000/data.semanascli[i]['PESTOT'])/100;
						PorKgCon=Math.round(data.semanascli[i]['PESCON']*10000/data.semanascli[i]['PESTOT'])/100;
						PorKgRec=Math.round(data.semanascli[i]['PESREC']*10000/data.semanascli[i]['PESTOT'])/100;
					}
					var styleC="colorB";
					var color=window.chartColors.yellow;
					if (PorKgApr>=param_codran1) {
						styleC="colorA";
						color=window.chartColors.green;
					}else{
						if (PorKgApr<param_codran2) {
							styleC="colorC";
							color=window.chartColors.reddark;
						}
					}
					if (ant_pro!=data.semanascli[i]['DESPRV']) {
						l++;
						ant_pro=data.semanascli[i]['DESPRV'];
						if (i!=0) {
							html+=
				'</div>';
						}
						html+=
				'<div class="contents">';
					}
					if (l%2==1) {
						background="#fff";
					}else{
						background="#ddd";
					}
					html+=
					'<div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.semanascli[i]['PESTOT'])+'</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.semanascli[i]['PESAPR'])+'</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.semanascli[i]['PESCON'])+'</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+formatNumber(data.semanascli[i]['PESREC'])+'</div>'+
						'<div class="itemhs1 items4 '+styleC+'">'+PorKgApr+'%</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+PorKgCon+'%</div>'+
						'<div class="itemhs1 items4" style="background:'+background+';color:'+color_table+';">'+PorKgRec+'%</div>'+
					'</div>';
				}
				html+=
				'</div>';
				$("#placeSemanasC").append(html);



			$("#titParUno").text(data.semanas[data.semanas.length-1]['ANIO']+" - Semana "+numSem);
			$("#titParDos").text(data.semanas[data.semanas.length-1]['ANIO']+" - Semana "+numSem);
			$("#titParUno-Mes").text(data.meses[data.meses.length-1]['ANHO'].substring(0,4)+" - "+proceMesLarge(data.meses[data.meses.length-1]['MES']));
			$("#titParDos-Mes").text(data.meses[data.meses.length-1]['ANHO'].substring(0,4)+" - "+proceMesLarge(data.meses[data.meses.length-1]['MES']));

			var defLbl=[];
			var defCan=[];
			var defPor=[];
			var defColor=[];
			html='';
			var sumPor=0;
			var pos=0;
			for (var i = 0; i < data.defuno.length; i++) {
				var por1=0;
				if (i!=data.defuno.length-1) {
					por1=Math.round(data.defuno[i]['SUMA']*10000/data.sumDU)/100;
					sumPor+=Math.round(por1*100)/100;
				}else{
					por1=Math.round((100-sumPor)*100)/100;
					sumPor=100;
				}
				if (i==0) {
					$("#defPosUno").text(data.defuno[i]['DSCFAMILIA']);
				}
				if (i==1) {
					$("#defPosDos").text(data.defuno[i]['DSCFAMILIA']);
				}
				html+=
				'<div class="lineBody">'+
					'<div class="itemhs1 items4" style="width: 120px;text-align:left;">'+(i+1)+'. '+data.defuno[i]['DSCFAMILIA']+'</div>'+
					'<div class="itemhs1 items4" style="width: 80px;">'+formatNumber(data.defuno[i]['SUMA'])+'</div>'+
					'<div class="itemhs1 items4" style="width: 40px;">'+por1+'%</div>'+
					'<div class="itemhs1 items4" style="width: 90px;">'+Math.round(sumPor*100)/100+'%</div>'+
				'</div>';		
				defLbl.push(data.defuno[i]['DSCFAMILIA']);		
				defCan.push(data.defuno[i]['SUMA']);
				defPor.push(Math.round(sumPor*100)/100);
				defColor.push(window.arrayColor[pos]);
				if (sumPor>80) {
					pos=1;
				}
			}
			sumTotSem=data.sumDU;
			processGraph2(defLbl,defCan,defPor,defColor);
			$("#idDefUno").append(html);

			//Grafico - Tabla nivel 1 - Mes
			var defLbl=[];
			var defCan=[];
			var defPor=[];
			var defColor=[];
			html='';
			var sumPor=0;
			var pos=0;
			for (var i = 0; i < data.defunomes.length; i++) {
				var por1=0;
				if (i!=data.defunomes.length-1) {
					por1=Math.round(data.defunomes[i]['SUMA']*10000/data.sumDUM)/100;
					sumPor+=Math.round(por1*100)/100;
				}else{
					por1=Math.round((100-sumPor)*100)/100;
					sumPor=100;
				}
				if (i==0) {
					$("#defPosUno-Mes").text(data.defunomes[i]['DSCFAMILIA']);
				}
				if (i==1) {
					$("#defPosDos-Mes").text(data.defunomes[i]['DSCFAMILIA']);
				}
				html+=
				'<div class="lineBody">'+
					'<div class="itemhs1 items4" style="width: 120px;text-align:left;">'+(i+1)+'. '+data.defunomes[i]['DSCFAMILIA']+'</div>'+
					'<div class="itemhs1 items4" style="width: 80px;">'+formatNumber(data.defunomes[i]['SUMA'])+'</div>'+
					'<div class="itemhs1 items4" style="width: 40px;">'+por1+'%</div>'+
					'<div class="itemhs1 items4" style="width: 90px;">'+Math.round(sumPor*100)/100+'%</div>'+
				'</div>';		
				defLbl.push(data.defunomes[i]['DSCFAMILIA']);		
				defCan.push(data.defunomes[i]['SUMA']);
				defPor.push(Math.round(sumPor*100)/100);
				defColor.push(window.arrayColor[pos]);
				if (sumPor>80) {
					pos=1;
				}
			}
			sumTotMes=data.sumDUM;
			processGraph2Mes(defLbl,defCan,defPor,defColor);
			$("#idDefUno-Mes").append(html);

			sumTotUSem=data.sumDefectosU;
			sumTotDSem=data.sumDefectosD;
			sumTotUMes=data.sumDefectosUM;
			sumTotDMes=data.sumDefectosDM;

			var defLbl=[];
			var defCan=[];
			var defPor=[];
			var defColor=[];
			html='';
			var sumPor=0;
			var pos=0;
			for (var i = 0; i < data.defectosU.length; i++) {
				var por1=0;
				if (i!=data.defectosU.length-1) {
					por1=Math.round(data.defectosU[i]['SUMA']*10000/data.sumDefectosU)/100;
					sumPor+=por1;
				}else{
					por1=Math.round((100-sumPor)*100)/100;
					sumPor=100;
				}
				if(sumPor>100){
					sumPor=100;
				}
				html+=
				'<div class="lineBody">'+
					'<div class="itemhs1 items4" style="width: 120px;text-align:left;">'+(i+1)+'. '+data.defectosU[i]['DESDEF']+'</div>'+
					'<div class="itemhs1 items4" style="width: 80px;">'+formatNumber(data.defectosU[i]['SUMA'])+'</div>'+
					'<div class="itemhs1 items4" style="width: 40px;">'+por1+'%</div>'+
					'<div class="itemhs1 items4" style="width: 90px;">'+Math.round(sumPor*100)/100+'%</div>'+
					'<div class="itemhs1 items3" style="width: 50px; background:transparent;border-color:transparent;"></div>'+
					'<div class="itemhs1 items4 itemSpecial" style="width: 100px;">'+Math.round(data.defectosU[i]['SUMA']*10000/data.sumDU)/100+'%</div>'+
				'</div>';		
				defLbl.push(data.defectosU[i]['DESDEF']);		
				defCan.push(data.defectosU[i]['SUMA']);
				defPor.push(Math.round(sumPor*100)/100);
				defColor.push(window.arrayColor[pos]);
				if (sumPor>80) {
					pos=1;
				}
			}
			processGraph3(defLbl,defCan,defPor,defColor);
			$("#idDefectoUno").append(html);

			var defLbl=[];
			var defCan=[];
			var defPor=[];
			var defColor=[];
			html='';
			var sumPor=0;
			var pos=0;
			for (var i = 0; i < data.defectosD.length; i++) {
				var por1=0;
				if (i!=data.defectosD.length-1) {
					por1=Math.round(data.defectosD[i]['SUMA']*10000/data.sumDefectosD)/100;
					sumPor+=por1;
				}else{
					por1=Math.round((100-sumPor)*100)/100;
					sumPor=100;
				}
				if(sumPor>100){
					sumPor=100;
				}
				html+=
				'<div class="lineBody">'+
					'<div class="itemhs1 items4" style="width: 120px;text-align:left;">'+(i+1)+'. '+data.defectosD[i]['DESDEF']+'</div>'+
					'<div class="itemhs1 items4" style="width: 80px;">'+formatNumber(data.defectosD[i]['SUMA'])+'</div>'+
					'<div class="itemhs1 items4" style="width: 40px;">'+por1+'%</div>'+
					'<div class="itemhs1 items4" style="width: 90px;">'+Math.round(sumPor*100)/100+'%</div>'+
					'<div class="itemhs1 items3" style="width: 50px; background:transparent;border-color:transparent;"></div>'+
					'<div class="itemhs1 items4 itemSpecial" style="width: 100px;">'+Math.round(data.defectosD[i]['SUMA']*10000/data.sumDU)/100+'%</div>'+
				'</div>';		
				defLbl.push(data.defectosD[i]['DESDEF']);		
				defCan.push(data.defectosD[i]['SUMA']);
				defPor.push(Math.round(sumPor*100)/100);
				defColor.push(window.arrayColor[pos]);
				if (sumPor>80) {
					pos=1;
				}
			}
			processGraph4(defLbl,defCan,defPor,defColor);
			$("#idDefectoDos").append(html);

			var defLbl=[];
			var defCan=[];
			var defPor=[];
			var defColor=[];
			html='';
			var sumPor=0;
			var pos=0;
			for (var i = 0; i < data.defectosUM.length; i++) {
				var por1=0;
				if (i!=data.defectosUM.length-1) {
					por1=Math.round(data.defectosUM[i]['SUMA']*10000/data.sumDefectosUM)/100;
					sumPor+=por1;
				}else{
					por1=Math.round((100-sumPor)*100)/100;
					sumPor=100;
				}
				if(sumPor>100){
					sumPor=100;
				}
				html+=
				'<div class="lineBody">'+
					'<div class="itemhs1 items4" style="width: 120px;text-align:left;">'+(i+1)+'. '+data.defectosUM[i]['DESDEF']+'</div>'+
					'<div class="itemhs1 items4" style="width: 80px;">'+formatNumber(data.defectosUM[i]['SUMA'])+'</div>'+
					'<div class="itemhs1 items4" style="width: 40px;">'+por1+'%</div>'+
					'<div class="itemhs1 items4" style="width: 90px;">'+Math.round(sumPor*100)/100+'%</div>'+
					'<div class="itemhs1 items3" style="width: 50px; background:transparent;border-color:transparent;"></div>'+
					'<div class="itemhs1 items4 itemSpecial" style="width: 100px;">'+Math.round(data.defectosUM[i]['SUMA']*10000/data.sumDUM)/100+'%</div>'+
				'</div>';		
				defLbl.push(data.defectosUM[i]['DESDEF']);		
				defCan.push(data.defectosUM[i]['SUMA']);
				defPor.push(Math.round(sumPor*100)/100);
				defColor.push(window.arrayColor[pos]);
				if (sumPor>80) {
					pos=1;
				}
			}
			processGraph3Mes(defLbl,defCan,defPor,defColor);
			$("#idDefectoUno-Mes").append(html);

			var defLbl=[];
			var defCan=[];
			var defPor=[];
			var defColor=[];
			html='';
			var sumPor=0;
			var pos=0;
			for (var i = 0; i < data.defectosDM.length; i++) {
				var por1=0;
				if (i!=data.defectosDM.length-1) {
					por1=Math.round(data.defectosDM[i]['SUMA']*10000/data.sumDefectosDM)/100;
					sumPor+=por1;
				}else{
					por1=Math.round((100-sumPor)*100)/100;
					sumPor=100;
				}
				if(sumPor>100){
					sumPor=100;
				}
				html+=
				'<div class="lineBody">'+
					'<div class="itemhs1 items4" style="width: 120px;text-align:left;">'+(i+1)+'. '+data.defectosDM[i]['DESDEF']+'</div>'+
					'<div class="itemhs1 items4" style="width: 80px;">'+formatNumber(data.defectosDM[i]['SUMA'])+'</div>'+
					'<div class="itemhs1 items4" style="width: 40px;">'+por1+'%</div>'+
					'<div class="itemhs1 items4" style="width: 90px;">'+Math.round(sumPor*100)/100+'%</div>'+
					'<div class="itemhs1 items3" style="width: 50px; background:transparent;border-color:transparent;"></div>'+
					'<div class="itemhs1 items4 itemSpecial" style="width: 100px;">'+Math.round(data.defectosDM[i]['SUMA']*10000/data.sumDUM)/100+'%</div>'+
				'</div>';		
				defLbl.push(data.defectosDM[i]['DESDEF']);		
				defCan.push(data.defectosDM[i]['SUMA']);
				defPor.push(Math.round(sumPor*100)/100);
				defColor.push(window.arrayColor[pos]);
				if (sumPor>80) {
					pos=1;
				}
			}
			processGraph4Mes(defLbl,defCan,defPor,defColor);
			$("#idDefectoDos-Mes").append(html);

			//////////////

			$(".panelCarga").fadeOut(200);
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
	        alert(msg);
			$(".panelCarga").fadeOut(200);
	    }
	});
});
var sumTotSem=0;
var sumTotMes=0;
var sumTotUSem=0;
var sumTotUMes=0;
var sumTotDSem=0;
var sumTotDMes=0;

window.arrayColor=['rgb(255,150,60)','rgb(240,200,160)'];

function processGraph(ar_lab,ar_rec,ar_apr_noc,ar_apr,ar_color){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'line',
			label: 'Kg. Rechazados',
			borderColor: window.chartColors.reddarkdark,
			borderWidth: 2,
			fill: false,
			data: ar_rec,
			lineTension: 0,
			yAxisID: 'y-axis-3',
			datalabels: {
				align: 'right',
				anchor: 'end'
			}
		}, {
			type: 'line',
			label: 'Kg. Apr. no con.',
			borderColor: window.chartColors.yellow,
			borderWidth: 2,
			fill: false,
			data: ar_apr_noc,
			lineTension: 0,
			yAxisID: 'y-axis-2',
			datalabels: {
				align: 'left',
				anchor: 'end'
			}
		}, {
			type: 'bar',
			label: 'Kg. Aprobados',
			backgroundColor:ar_color,
			data: ar_apr,
			yAxisID: 'y-axis-1',
			datalabels: {
				align: 'center',
				anchor: 'start'
			}
		}]
	};
	var wWin=window.innerWidth;
	var dBorder=true;
	var stepTicks=5;
	if (wWin<600) {
		dBorder=false;
		stepTicks=20;
	}
	var ctx = document.getElementById('chart-area').getContext('2d');
	window.myMixedChart = new Chart(ctx, {
		type: 'bar',
		data: chartData,
		options: {
			responsive: true,
			tooltips: {
				mode: 'index',
				intersect: true
			},
			scales: {
				xAxes: [{
					display: true,
					scaleLabel: {
						display: true
					}
				}],				
				yAxes: [{
					display: true,
					scaleLabel: {
						display: false
					},
					gridLines: {
						display: dBorder,
						drawBorder: true,
						color: ['none','rgb(50,200,50)','yellow','none']
					},
					ticks: {
						suggestedMin: 0,
						suggestedMax: 100
					},
					afterBuildTicks: function(humdaysChart) {
					    humdaysChart.ticks = [];
					    humdaysChart.ticks.push(0);
					    humdaysChart.ticks.push(param_codran1);
					    humdaysChart.ticks.push(param_codran2);
					    humdaysChart.ticks.push(100);
					},
					id: 'y-axis-1',
				},{
					type: 'linear',
					display: false,
					position: 'left',
					id: 'y-axis-2',
					ticks: {
						suggestedMin: 0,
						suggestedMax: 100
					}
				},{
					type: 'linear',
					display: false,
					position: 'right',
					id: 'y-axis-3',
					ticks: {
						suggestedMin: 0,
						suggestedMax: 100
					}
				}]
			},			
			legend:{
				labels:{
					usePointStyle: true
				}
			},
			plugins: {
				datalabels: {
        			color: 'black',
					formatter: function(value, context) {
						//if (context.dataset.type=="line") {
							return Math.round(value)+"%";
						/*}else{
							return Math.round(value);
						}*/
					},
					font:{
						weight:'bold'
					}
				}
			}
		}
	});
}
function processGraph2(ar_lab,ar_defCan,ar_defPor,ar_defCol){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'line',
			label: 'Acumulado',
			borderColor: window.chartColors.red,
			borderWidth: 2,
			fill: false,
			data: ar_defPor,
			yAxisID: 'y-axis-2',
			lineTension: 0
		}, {
			type: 'bar',
			backgroundColor: ar_defCol,
			label: 'Frecuencia',
			yAxisID: 'y-axis-1',
			data: ar_defCan
		}]
	};
	var ctx = document.getElementById('chart-area2').getContext('2d');
	window.myMixedChart = new Chart(ctx, {
		type: 'bar',
		data: chartData,
		options: {
			responsive: true,
			tooltips: {
				mode: 'index',
				intersect: true
			},
			scales: {
				xAxes: [{
					display: true,
					scaleLabel: {
						display: true
					}
				}],
				yAxes: [{
					type: 'linear',
					display: true,
					position: 'left',
					id: 'y-axis-1',
					ticks: {
						suggestedMin: 0/*,
						suggestedMax: 100,*/
					}
				}, {
					type: 'linear',
					display: true,
					position: 'right',
					id: 'y-axis-2',
					ticks: {
						suggestedMin: 0,
						suggestedMax: 100,
					}
				}]
			},
			legend:{
				labels:{
					usePointStyle: true
				}
			},
			animation: {
                duration: 1,
                onComplete: function () {
                    var chartInstance = this.chart,
                    ctx = chartInstance.ctx;
                    ctx.fillStyle = "rgba(0, 0, 0, 1)";
			        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
			        ctx.textAlign = 'center';
			        ctx.textBaseline = 'bottom';
                    this.data.datasets.forEach(function (dataset, i) {
                    	if (dataset.type=="bar") {
	                        var meta = chartInstance.controller.getDatasetMeta(i);
	                        meta.data.forEach(function (bar, index) {
	                            var data = Math.round(dataset.data[index]*100/sumTotSem)+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });
	                    }else{
	                        var meta = chartInstance.controller.getDatasetMeta(i);
	                        meta.data.forEach(function (bar, index) {
	                            var data = Math.round(dataset.data[index])+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });	                    	
	                    }
                    });
                }
            }
		}
	});
}

function processGraph2Mes(ar_lab,ar_defCan,ar_defPor,ar_defCol){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'line',
			label: 'Acumulado',
			borderColor: window.chartColors.red,
			borderWidth: 2,
			fill: false,
			data: ar_defPor,
			yAxisID: 'y-axis-2',
			lineTension: 0
		}, {
			type: 'bar',
			backgroundColor: ar_defCol,
			label: 'Frecuencia',
			yAxisID: 'y-axis-1',
			data: ar_defCan
		}]
	};
	var ctx = document.getElementById('chart-area2-mes').getContext('2d');
	window.myMixedChart = new Chart(ctx, {
		type: 'bar',
		data: chartData,
		options: {
			responsive: true,
			tooltips: {
				mode: 'index',
				intersect: true
			},
			scales: {
				xAxes: [{
					display: true,
					scaleLabel: {
						display: true
					}
				}],
				yAxes: [{
					type: 'linear',
					display: true,
					position: 'left',
					id: 'y-axis-1',
					ticks: {
						suggestedMin: 0/*,
						suggestedMax: 100,*/
					}
				}, {
					type: 'linear',
					display: true,
					position: 'right',
					id: 'y-axis-2',
					ticks: {
						suggestedMin: 0,
						suggestedMax: 100,
					}
				}]
			},
			legend:{
				labels:{
					usePointStyle: true
				}
			},
			animation: {
                duration: 1,
                onComplete: function () {
                    var chartInstance = this.chart,
                    ctx = chartInstance.ctx;
                    ctx.fillStyle = "rgba(0, 0, 0, 1)";
			        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
			        ctx.textAlign = 'center';
			        ctx.textBaseline = 'bottom';
                    this.data.datasets.forEach(function (dataset, i) {
                    	if (dataset.type=="bar") {
	                        var meta = chartInstance.controller.getDatasetMeta(i);
	                        meta.data.forEach(function (bar, index) {
	                            var data = Math.round(dataset.data[index]*100/sumTotMes)+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });
	                    }else{
	                        var meta = chartInstance.controller.getDatasetMeta(i);
	                        meta.data.forEach(function (bar, index) {
	                            var data = Math.round(dataset.data[index])+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });	                    	
	                    }
                    });
                }
            }
		}
	});
}

function processGraph3(ar_lab,ar_defCan,ar_defPor,ar_defCol){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'line',
			label: 'Acumulado',
			borderColor: window.chartColors.red,
			borderWidth: 2,
			fill: false,
			data: ar_defPor,
			yAxisID: 'y-axis-2',
			lineTension: 0
		}, {
			type: 'bar',
			backgroundColor: ar_defCol,
			label: 'Frecuencia',
			yAxisID: 'y-axis-1',
			data: ar_defCan
		}]
	};
	var ctx = document.getElementById('chart-area3').getContext('2d');
	window.myMixedChart = new Chart(ctx, {
		type: 'bar',
		data: chartData,
		options: {
			responsive: true,
			tooltips: {
				mode: 'index',
				intersect: true
			},
			scales: {
				xAxes: [{
					display: true,
					scaleLabel: {
						display: true
					}
				}],
				yAxes: [{
					type: 'linear',
					display: true,
					position: 'left',
					id: 'y-axis-1',
					ticks: {
						suggestedMin: 0
					}
				}, {
					type: 'linear',
					display: true,
					position: 'right',
					id: 'y-axis-2',
					ticks: {
						suggestedMin: 0,
						suggestedMax: 100,
					}
				}]
			},
			legend:{
				labels:{
					usePointStyle: true
				}
			},
			animation: {
                duration: 1,
                onComplete: function () {
                    var chartInstance = this.chart,
                    ctx = chartInstance.ctx;
                    ctx.fillStyle = "rgba(0, 0, 0, 1)";
			        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
			        ctx.textAlign = 'center';
			        ctx.textBaseline = 'bottom';
                    this.data.datasets.forEach(function (dataset, i) {
                    	if (dataset.type=="bar") {
	                        var meta = chartInstance.controller.getDatasetMeta(i);
	                        meta.data.forEach(function (bar, index) {
	                            var data = Math.round(dataset.data[index]*100/sumTotUSem)+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });
	                    }else{
	                        var meta = chartInstance.controller.getDatasetMeta(i);
	                        meta.data.forEach(function (bar, index) {
	                            var data = Math.round(dataset.data[index])+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });	                    	
	                    }
                    });
                }
            }
		}
	});
}

function processGraph3Mes(ar_lab,ar_defCan,ar_defPor,ar_defCol){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'line',
			label: 'Acumulado',
			borderColor: window.chartColors.red,
			borderWidth: 2,
			fill: false,
			data: ar_defPor,
			yAxisID: 'y-axis-2',
			lineTension: 0
		}, {
			type: 'bar',
			backgroundColor: ar_defCol,
			label: 'Frecuencia',
			yAxisID: 'y-axis-1',
			data: ar_defCan
		}]
	};
	var ctx = document.getElementById('chart-area3-mes').getContext('2d');
	window.myMixedChart = new Chart(ctx, {
		type: 'bar',
		data: chartData,
		options: {
			responsive: true,
			tooltips: {
				mode: 'index',
				intersect: true
			},
			scales: {
				xAxes: [{
					display: true,
					scaleLabel: {
						display: true
					}
				}],
				yAxes: [{
					type: 'linear',
					display: true,
					position: 'left',
					id: 'y-axis-1',
					ticks: {
						suggestedMin: 0
					}
				}, {
					type: 'linear',
					display: true,
					position: 'right',
					id: 'y-axis-2',
					ticks: {
						suggestedMin: 0,
						suggestedMax: 100,
					}
				}]
			},
			legend:{
				labels:{
					usePointStyle: true
				}
			},
			animation: {
                duration: 1,
                onComplete: function () {
                    var chartInstance = this.chart,
                    ctx = chartInstance.ctx;
                    ctx.fillStyle = "rgba(0, 0, 0, 1)";
			        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
			        ctx.textAlign = 'center';
			        ctx.textBaseline = 'bottom';
                    this.data.datasets.forEach(function (dataset, i) {
                    	if (dataset.type=="bar") {
	                        var meta = chartInstance.controller.getDatasetMeta(i);
	                        meta.data.forEach(function (bar, index) {
	                            var data = Math.round(dataset.data[index]*100/sumTotUMes)+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });
	                    }else{
	                        var meta = chartInstance.controller.getDatasetMeta(i);
	                        meta.data.forEach(function (bar, index) {
	                            var data = Math.round(dataset.data[index])+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });	                    	
	                    }
                    });
                }
            }
		}
	});
}

function processGraph4(ar_lab,ar_defCan,ar_defPor,ar_defCol){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'line',
			label: 'Acumulado',
			borderColor: window.chartColors.red,
			borderWidth: 2,
			fill: false,
			data: ar_defPor,
			yAxisID: 'y-axis-2',
			lineTension: 0
		}, {
			type: 'bar',
			backgroundColor: ar_defCol,
			label: 'Frecuencia',
			yAxisID: 'y-axis-1',
			data: ar_defCan
		}]
	};
	var ctx = document.getElementById('chart-area4').getContext('2d');
	window.myMixedChart = new Chart(ctx, {
		type: 'bar',
		data: chartData,
		options: {
			responsive: true,
			tooltips: {
				mode: 'index',
				intersect: true
			},
			scales: {
				xAxes: [{
					display: true,
					scaleLabel: {
						display: true
					}
				}],
				yAxes: [{
					type: 'linear',
					display: true,
					position: 'left',
					id: 'y-axis-1',
					ticks: {
						suggestedMin: 0
					}
				}, {
					type: 'linear',
					display: true,
					position: 'right',
					id: 'y-axis-2',
					ticks: {
						suggestedMin: 0,
						suggestedMax: 100,
					}
				}]
			},
			legend:{
				labels:{
					usePointStyle: true
				}
			},
			animation: {
                duration: 1,
                onComplete: function () {
                    var chartInstance = this.chart,
                    ctx = chartInstance.ctx;
                    ctx.fillStyle = "rgba(0, 0, 0, 1)";
			        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
			        ctx.textAlign = 'center';
			        ctx.textBaseline = 'bottom';
                    this.data.datasets.forEach(function (dataset, i) {
                    	if (dataset.type=="bar") {
	                        var meta = chartInstance.controller.getDatasetMeta(i);
	                        meta.data.forEach(function (bar, index) {
	                            var data = Math.round(dataset.data[index]*100/sumTotDSem)+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });
	                    }else{
	                        var meta = chartInstance.controller.getDatasetMeta(i);
	                        meta.data.forEach(function (bar, index) {
	                            var data = Math.round(dataset.data[index])+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });	                    	
	                    }
                    });
                }
            }
		}
	});
}

function processGraph4Mes(ar_lab,ar_defCan,ar_defPor,ar_defCol){
	var chartData = {
		labels: ar_lab,
		datasets: [{
			type: 'line',
			label: 'Acumulado',
			borderColor: window.chartColors.red,
			borderWidth: 2,
			fill: false,
			data: ar_defPor,
			yAxisID: 'y-axis-2',
			lineTension: 0
		}, {
			type: 'bar',
			backgroundColor: ar_defCol,
			label: 'Frecuencia',
			yAxisID: 'y-axis-1',
			data: ar_defCan
		}]
	};
	var ctx = document.getElementById('chart-area4-mes').getContext('2d');
	window.myMixedChart = new Chart(ctx, {
		type: 'bar',
		data: chartData,
		options: {
			responsive: true,
			tooltips: {
				mode: 'index',
				intersect: true
			},
			scales: {
				xAxes: [{
					display: true,
					scaleLabel: {
						display: true
					}
				}],
				yAxes: [{
					type: 'linear',
					display: true,
					position: 'left',
					id: 'y-axis-1',
					ticks: {
						suggestedMin: 0
					}
				}, {
					type: 'linear',
					display: true,
					position: 'right',
					id: 'y-axis-2',
					ticks: {
						suggestedMin: 0,
						suggestedMax: 100,
					}
				}]
			},
			legend:{
				labels:{
					usePointStyle: true
				}
			},
			animation: {
                duration: 1,
                onComplete: function () {
                    var chartInstance = this.chart,
                    ctx = chartInstance.ctx;
                    ctx.fillStyle = "rgba(0, 0, 0, 1)";
			        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
			        ctx.textAlign = 'center';
			        ctx.textBaseline = 'bottom';
                    this.data.datasets.forEach(function (dataset, i) {
                    	if (dataset.type=="bar") {
	                        var meta = chartInstance.controller.getDatasetMeta(i);
	                        meta.data.forEach(function (bar, index) {
	                            var data = Math.round(dataset.data[index]*100/sumTotDMes)+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });
	                    }else{
	                        var meta = chartInstance.controller.getDatasetMeta(i);
	                        meta.data.forEach(function (bar, index) {
	                            var data = Math.round(dataset.data[index])+"%";
	                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
	                        });	                    	
	                    }
                    });
                }
            }
		}
	});
}

function downloadPDF(){
	$.ajax({
	  	type: "POST",
	  	url: "config/saveTmpImg.php",
	  	data: { 
	    	img1: document.getElementById("chart-area").toDataURL("image/png"),
			codprv:codprv,
			fecha:fecha,
			codusu:codusurep,
			codusueje:codusueje,
			bloque:bloque
	  	},
	  	success:function(data){
	  		var title=$("#titulodetalle").text();
	  		var a=document.createElement("a");
	  		a.target="_blank";
	  		a.href="fpdf/crearPdfIndRes.php?n="+data+
	  		"&t="+title+"&codprv="+codprv+"&fecha="+fecha+"&codusu="+codusurep+"&codusueje="+codusueje+"&bloque="+bloque+"&ran1="+param_codran1+"&ran2="+param_codran2;
	  		a.click();
	  	}
	}).done(function(o) {
	  	console.log('Images Saved!'); 
	});
}