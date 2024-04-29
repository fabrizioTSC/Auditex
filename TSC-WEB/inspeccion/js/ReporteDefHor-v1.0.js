function format_date(text){
	var y=text.substring(0,4);
	var m=text.substring(4,6);
	var d=text.substring(6,8);
	return y+"-"+m+"-"+d;
}
function format_date_lbl(text){
	var y=text.substring(0,4);
	var m=text.substring(4,6);
	var d=text.substring(6,8);
	return d+"/"+m+"/"+y;
}
function format_date_text(text){
	return text.replace("-","").replace("-","");
}
$(document).ready(function(){
	$("#maintbl").scroll(function(){
		if ($("#maintbl").scrollTop()>50) {
			$("#data-header").css("position","absolute");
			$("#data-header").css("top",$("#maintbl").scrollTop()+"px");
		}else{
			$("#data-header").css("position","relative");
			$("#data-header").css("top","0px");
		}
	});
	/*$("#idFecha").change(function(){
		$(".panelCarga").fadeIn(100);
		$.ajax({
			url:"config/updateDefHor.php",
			type:"POST",
			data:{
				fecha:format_date_text($("#idFecha").val())
			},
			success:function(data){
				console.log(data);
				if (data.state) {
					fill_hours(data);
				}else{
					alert(data.detail);
				}
			$(".panelCarga").fadeOut(100);
			}
		});
	});*/
	$.ajax({
		url:"config/getDefHor.php",
		type:"POST",
		success:function(data){
			console.log(data);
			$("#idFecha").val(format_date(data.fecha));

			fill_hours(data);

			$(".panelCarga").fadeOut(100);
		}
	});
});

function update_reporte(){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		url:"config/updateDefHor.php",
		type:"POST",
		data:{
			fecha:format_date_text($("#idFecha").val())
		},
		success:function(data){
			console.log(data);
			if (data.state) {
				fill_hours(data);
			}else{
				alert(data.detail);
			}
		$(".panelCarga").fadeOut(100);
		}
	});
}

function fill_hours(data){	
	var html='';
	if (data.defectos.length>0) {
		for (var i = parseInt(data.minhora); i < parseInt(data.maxhora)+1; i++) {
			html+='<div class="head-tbl" style="width:50px;">'+i+'</div>';
		}
		html+='<div class="head-tbl" style="width:90px;">TOTAL</div>';
		$("#header-horas").empty();
		$("#header-horas").append(html);
		var tam_hor=parseInt(data.maxhora)-parseInt(data.minhora)+1;
		$("#header-hora").css("width",(tam_hor*60-10)+"px");
		$(".tbl-header").css("width",(310+(tam_hor*60)+100)+"px");
		$(".tbl-body").css("width",(310+(tam_hor*60)+100)+"px");
		
		var html='';
		var html2='';
		var lin_ant=0;
		var coddef_ant=0;
		var cont=0;
		var cont2=0;
		var color="";
		for (var i = 0; i < data.defectos.length; i++) {
			if (coddef_ant!=data.defectos[i].CODDEF) {
				cont2++;
				coddef_ant=data.defectos[i].CODDEF;
				if (i!=0) {
					html2+='<div class="body-tbl" style="width:200px;height:'+((cont+1)*28-10)+'px;">'+data.defectos[i-1].DESDEF+'</div>';
					cont=0;
				}
			}
			if (data.defectos[i].LINEA!=lin_ant) {
				cont++;
				lin_ant=data.defectos[i].LINEA;
				if (i!=0) {
					html+=
					'<div class="head-tbl" style="width:90px;" onclick="show_operaciones('+data.defectos[i-1].CODDEF+',\''+data.defectos[i-1].DESDEF+'\','+
					data.defectos[i-1].LINEA+',0,'+data.defectos[i-1].CANDEFLINDEF+')">'+data.defectos[i-1].CANDEFLINDEF+'</div>'+
				'</div>';
					if (coddef_ant!=data.defectos[i-1].CODDEF) {
						//cont++;
						html+=
				'<div style="display: flex;" class="total-block">'+
					'<div class="head-tbl" style="width:90px;">TOTAL</div>';
						for (var j = parseInt(data.minhora); j < parseInt(data.maxhora)+1; j++) {
							html+=
						'<div class="head-tbl class-total" id="item'+data.defectos[i-1].CODDEF+''+j+'" data-coddef="'+data.defectos[i-1].CODDEF+'" data-hora="'+j+'"'+
						' style="width:50px;" onclick="show_operaciones('+data.defectos[i-1].CODDEF+',\''+data.defectos[i-1].DESDEF+'\',0,'+j+',0)">0</div>';
						}
						html+=
					'<div class="head-tbl" style="width:90px;" onclick="show_operaciones('+data.defectos[i-1].CODDEF+',\''+data.defectos[i-1].DESDEF+'\',0,0,'+
					data.defectos[i-1].CANDEFDEF+')">'+data.defectos[i-1].CANDEFDEF+'</div>'+
				'</div>';
					}
				}
				html+=
				'<div style="display: flex;">'+
					'<div class="head-tbl" style="width:90px;">'+data.defectos[i].LINEA+'</div>';
			}else{
				if (coddef_ant!=data.defectos[i-1].CODDEF) {
					cont++;
					lin_ant=data.defectos[i].LINEA;
					if (i!=0) {
						html+=
					'<div class="head-tbl" style="width:90px;" onclick="show_operaciones('+data.defectos[i-1].CODDEF+',\''+data.defectos[i-1].DESDEF+'\','+
					data.defectos[i-1].LINEA+',0,'+data.defectos[i-1].CANDEFLINDEF+')">'+data.defectos[i-1].CANDEFLINDEF+'</div>'+
				'</div>';
					}
					html+=
				'<div style="display: flex;" class="total-block">'+
					'<div class="head-tbl" style="width:90px;">TOTAL</div>';
					for (var j = parseInt(data.minhora); j < parseInt(data.maxhora)+1; j++) {
						html+=
						'<div class="head-tbl class-total" id="item'+data.defectos[i-1].CODDEF+''+j+'" data-coddef="'+data.defectos[i-1].CODDEF+'" data-hora="'+j+'" style="width:50px;" style="width:50px;"'+
						' onclick="show_operaciones('+data.defectos[i-1].CODDEF+',\''+data.defectos[i-1].DESDEF+'\',0,'+j+',0)">0</div>';
					}
					html+=
					'<div class="head-tbl" style="width:90px;" onclick="show_operaciones('+data.defectos[i-1].CODDEF+',\''+data.defectos[i-1].DESDEF+'\',0,0,'+
					data.defectos[i-1].CANDEFDEF+')">'+data.defectos[i-1].CANDEFDEF+'</div>'+
				'</div>'+
				'<div style="display: flex;">'+
					'<div class="head-tbl" style="width:90px;">'+data.defectos[i].LINEA+'</div>';
				}
			}
			if (data.defectos[i].CANDEF=="0") {
				color="color:#fff;";
			}else{
				color="";
			}
			html+=
					'<div class="head-tbl class-'+data.defectos[i].CODDEF+'-'+data.defectos[i].NHORA+'" '+
					'style="width:50px;'+color+'" onclick="show_operaciones('+data.defectos[i].CODDEF+',\''+data.defectos[i].DESDEF+'\','+data.defectos[i].LINEA+','+
					data.defectos[i].NHORA+','+data.defectos[i].CANDEF+')">'+data.defectos[i].CANDEF+'</div>';;
		}
		html+=
					'<div class="head-tbl" style="width:90px;" onclick="show_operaciones('+data.defectos[data.defectos.length-1].CODDEF+',\''+data.defectos[data.defectos.length-1].DESDEF+'\','+
					data.defectos[data.defectos.length-1].LINEA+',0,'+data.defectos[data.defectos.length-1].CANDEFLINDEF+')">'+data.defectos[data.defectos.length-1].CANDEFLINDEF+'</div>'+
				'</div>'+
				'<div style="display: flex;" class="total-block">'+
					'<div class="head-tbl" style="width:90px;">TOTAL</div>';
					for (var j = parseInt(data.minhora); j < parseInt(data.maxhora)+1; j++) {
						html+=
						'<div class="head-tbl class-total" id="item'+data.defectos[data.defectos.length-1].CODDEF+''+j+'" data-coddef="'+data.defectos[data.defectos.length-1].CODDEF+'" data-hora="'+j+'" style="width:50px;"'+
						' onclick="show_operaciones('+data.defectos[data.defectos.length-1].CODDEF+',\''+data.defectos[data.defectos.length-1].DESDEF+'\',0,'+j+',0)">0</div>';
					}
					html+=
					'<div class="head-tbl" style="width:90px;" onclick="show_operaciones('+data.defectos[data.defectos.length-1].CODDEF+',\''+data.defectos[data.defectos.length-1].DESDEF+'\',0,0,'+
					data.defectos[data.defectos.length-1].CANDEFDEF+')">'+data.defectos[data.defectos.length-1].CANDEFDEF+'</div>'+
				'</div>';
		html2+='<div class="body-tbl" style="width:200px;height:'+((cont+1)*28-10)+'px;">'+data.defectos[data.defectos.length-1].DESDEF+'</div>';

		console.log(cont2);

		$("#space-lindef").empty();
		$("#space-lindef").append(html);

		$("#space-def").empty();
		$("#space-def").append(html2);

		var ar=document.getElementsByClassName("class-total");
		for (var i = 0; i < ar.length; i++) {
			var ar_aux=document.getElementsByClassName("class-"+ar[i].dataset.coddef+"-"+ar[i].dataset.hora);
			var suma=0;
			for (var j = 0; j < ar_aux.length; j++) {
				suma+=parseInt(ar_aux[j].innerHTML);
			}
			ar[i].innerHTML=suma;
		}
		$("#tbl-none").css("display","none");
		$("#tbl-generate").css("display","block");
	}else{
		$("#tbl-none").css("display","block");
		$("#tbl-generate").css("display","none");
	}
}

function show_operaciones(coddef,desdef,linea,hora,cantidad){
	if (linea==0) {
		var can=parseInt($("#item"+coddef+""+hora).text());
		if (can!=0) {
			show_modal_oper(coddef,desdef,linea,hora);
		}
	}else{
		if (cantidad!=0) {
			show_modal_oper(coddef,desdef,linea,hora);
		}
	}
}

function show_modal_oper(coddef,desdef,linea,hora){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		url:"config/getOpeTotDef.php",
		type:"POST",
		data:{
			fecha:format_date_text($("#idFecha").val()),
			coddef:coddef,
			linea:linea,
			hora:hora
		},
		success:function(data){
			console.log(data);
			var html='';
			for (var i = 0; i < data.operaciones.length; i++) {
				html+=
				'<div class="line-body">'+
					'<div class="body-tbl" style="width:70%;">'+data.operaciones[i].DESOPE+'</div>'+
					'<div class="body-tbl" style="width:30%;">'+data.operaciones[i].CANTIDAD+'</div>'+
				'</div>';
			}
			$("#data-body-ope").empty();
			$("#data-body-ope").append(html);

			$("#idFechaOpe").text(format_date_lbl(format_date_text($("#idFecha").val())));
			$("#idDefectoOpe").text(desdef);
			if (linea==0) {
				$("#content-linea").css("display","none");
			}else{
				$("#content-linea").css("display","block");
				$("#idLineaOpe").text(linea);
			}
			if (hora==0) {
				$("#content-hora").css("display","none");
			}else{
				$("#content-hora").css("display","block");
				$("#idHoraOpe").text(hora);
			}
			$(".panelCarga").fadeOut(100);
			$("#modalEdit").fadeIn(100);
		}
	});
}

function closeModal(id){
	$("#"+id).fadeOut(100);
}