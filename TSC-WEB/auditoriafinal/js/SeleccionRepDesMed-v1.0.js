var esttsc=[];
var ficha=[];
var colores=[];
$(document).ready(function(){
	$("#nombrePedido").keyup(function(){
		var html='';
		for (var i = 0; i < ficha.length; i++) {
			if ((ficha[i].PEDIDO.toUpperCase()).indexOf($("#nombrePedido").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="selectPedido(\''+ficha[i].CODPED+'\',\''+ficha[i].PEDIDO+'\')">'+ficha[i].PEDIDO+'</div>';
			}
		}
		$("#spaceficha").empty();
		$("#spaceficha").append(html);	
	});
	$("#nombreColor").keyup(function(){
		var html='';
		for (var i = 0; i < colores.length; i++) {
			if ((colores[i].COLOR.toUpperCase()).indexOf($("#nombreColor").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="selectColor(\''+colores[i].CODCOL+'\',\''+colores[i].COLOR+'\')">'+colores[i].COLOR+'</div>';
			}
		}
		$("#spaceColor").empty();
		$("#spaceColor").append(html);	
	});
});

function consultar_esttsc(){
	$(".panelCarga").fadeIn(200);
	$.ajax({
		type:"POST",
		data:{
			esttsc:$("#nombreEsttsc").val()
		},
		url:"config/getFichasRepDesMed.php",
		success:function(data){
			console.log(data);

			if (data.ficha.length!=1) {
				ficha=data.ficha;
				var html='';
				for (var i = 0; i < ficha.length; i++) {
					html+='<div class="taller" onclick="selectPedido(\''+ficha[i].CODPED+'\',\''+ficha[i].PEDIDO+'\')">'+ficha[i].PEDIDO+'</div>';
				}
				$("#spaceficha").empty();
				$("#spaceficha").append(html);

				$("#nombrePedido").val("(TODOS)");
				codped_var="0";
				$("#resultesttsc").css("display","block");
			}else{
				alert("No se encontró el estilo!");
				$("#resultesttsc").css("display","none");
			}
			$(".panelCarga").fadeOut(200);			
		}
	});
}

var codped_var="";
function selectPedido(codped,pedido){
	codped_var=codped;
	$("#nombrePedido").val(pedido);
	$("#resultesttsc-2").css("display","none");
	$(".panelCarga").fadeIn(200);
	$.ajax({
		type:"POST",
		data:{
			esttsc:$("#nombreEsttsc").val(),				
			pedido:codped_var
		},
		url:"config/getFichasRepDesMedCol.php",
		success:function(data){
			console.log(data);
			colores=data.ficha;
			var html='';
			for (var i = 0; i < colores.length; i++) {
				html+='<div class="taller" onclick="selectColor(\''+colores[i].CODCOL+'\',\''+colores[i].COLOR+'\')">'+colores[i].COLOR+'</div>';
			}
			$("#spaceColor").empty();
			$("#spaceColor").append(html);

			$("#nombreColor").val("(TODOS)");
			codcol_var="0";
			$("#resultesttsc-2").css("display","block");
			$(".panelCarga").fadeOut(200);			
		}
	});
}

var codcol_var="";
function selectColor(codcol,color){
	codcol_var=codcol;
	$("#nombreColor").val(color);
}

function mostraReporte(){
	if (codped_var=="") {
		alert("Seleccione una ficha!");
	}else{
		window.location.href="ReporteDesMed.php?esttsc="+$("#nombreEsttsc").val()+"&pedido="+codped_var+"&color="+codcol_var;
	}
}