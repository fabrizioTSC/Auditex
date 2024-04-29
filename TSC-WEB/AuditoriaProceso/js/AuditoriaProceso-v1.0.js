var codtipser_tll="";
$(document).ready(function(){
	$.ajax({
		type:"POST",
		url:"config/getFichaAudiPro.php",
		data:{
			codfic:codfic,
			codtll:codtll,
			codusu:codusu,
			turno:turno,
			secuen:secuen
		},
		success:function(data){
			console.log(data);
			$("#idFicha").text(codfic);
			$("#idCliente").text(data.taller.DESCLI);
			$("#idLinea").text(data.taller.DESTLL);
			$("#idColor").text(data.taller.DESCOL);
			secuen=data.secuen;
			codtipser_tll=data.taller.CODTIPOSERV;
			getParametersAudPro();
		}
	});
	$("#idOperador").keyup(function(){
		codoper_var=0;
		$(".tblOperador").empty();
		var htmlTalleres="";
		var busqueda=document.getElementById("idOperador").value;
		for (var i = 0; i < listaOperadores.length; i++) {
			if ((listaOperadores[i].NOMPER.toUpperCase()).indexOf(busqueda.toUpperCase())>=0) {				
				htmlTalleres+='<div class="operacion" onclick="addOperador(\''+listaOperadores[i].NOMPER+'\','+listaOperadores[i].CODPER+')">'+listaOperadores[i].NOMPER+"</div>";
			}
		}
		$(".tblOperador").append(htmlTalleres);
	});
	$("#idOperacion").keyup(function(){
		codope_var=0;
		$(".tblOperacion").empty();
		var htmlTalleres="";
		var busqueda=document.getElementById("idOperacion").value;
		for (var i = 0; i < listaOperacion.length; i++) {
			if ((listaOperacion[i].DESOPE.toUpperCase()).indexOf(busqueda.toUpperCase())>=0) {				
				htmlTalleres+='<div class="defecto" onclick="addOperacion(\''+listaOperacion[i].DESOPE+'\','+listaOperacion[i].CODOPE+')">'+listaOperacion[i].DESOPE+"</div>";
			}
		}
		$(".tblOperacion").append(htmlTalleres);
	});
	$("#idDefecto").keyup(function(){
		coddef_var=0;
		$(".tblDefectos").empty();
		var htmlTalleres="";
		var busqueda=document.getElementById("idDefecto").value;
		for (var i = 0; i < listaDefecto.length; i++) {
			if ((listaDefecto[i].DESDEF.toUpperCase()).indexOf(busqueda.toUpperCase())>=0 || (listaDefecto[i].CODDEFAUX.toUpperCase()).indexOf(busqueda.toUpperCase())>=0) {				
				htmlTalleres+='<div class="defecto" onclick="addDefecto(\''+listaDefecto[i].CODDEFAUX+' - '+listaDefecto[i].DESDEF+'\','+listaDefecto[i].CODDEF+')">'+
					listaDefecto[i].CODDEFAUX+' - '+listaDefecto[i].DESDEF+"</div>";
			}
		}
		$(".tblDefectos").append(htmlTalleres);
	});
});

var listaOperadores=[];
var listaOperacion=[];
var listaDefecto=[];
function getParametersAudPro(){
	$.ajax({
		type:"POST",
		url:"config/getDataAudPro.php",
		data:{
		},
		success:function(data){
			console.log(data);

			if(codtipser_tll=="2"){
				listaOperadores.push(data.operadores[0]);
			}else{
				for (var i = 0; i < data.operadores.length; i++) {
					if (data.operadores[i].CODPER!="0") {
						listaOperadores.push(data.operadores[i]);
					}
				}
			}
			var htmlOperador="";
			for (var i = 0; i < listaOperadores.length; i++) {
				htmlOperador+='<div class="defecto" '+
				'onclick="addOperador(\''+listaOperadores[i].NOMPER+'\','+listaOperadores[i].CODPER+')">'
				+listaOperadores[i].NOMPER+'</div>';
			}
			$(".tblOperador").empty();
			$(".tblOperador").append(htmlOperador);

			if(codtipser_tll=="2"){
				$("#idOperador").val(listaOperadores[0].NOMPER);
			}

			listaOperacion=data.operaciones;
			var htmlOperacion="";
			for (var i = 0; i < listaOperacion.length; i++) {
				htmlOperacion+='<div class="defecto" '+
				'onclick="addOperacion(\''+listaOperacion[i].DESOPE+'\','+listaOperacion[i].CODOPE+')">'
				+listaOperacion[i].DESOPE+'</div>';
			}
			$(".tblOperacion").empty();
			$(".tblOperacion").append(htmlOperacion);

			listaDefecto=data.defectos;
			var htmlDefecto="";
			for (var i = 0; i < listaDefecto.length; i++) {
				htmlDefecto+='<div class="defecto" '+
				'onclick="addDefecto(\''+listaDefecto[i].CODDEFAUX+' - '+listaDefecto[i].DESDEF+'\','+listaDefecto[i].CODDEF+')">'
				+listaDefecto[i].CODDEFAUX+' - '+listaDefecto[i].DESDEF+'</div>';
			}			
			$(".tblDefectos").empty();
			$(".tblDefectos").append(htmlDefecto);

			$(".panelCarga").fadeOut(200);
		}
	});
}

var codoper_var=0;
function addOperador(word,codoper){
	codoper_var=codoper;
	$("#idOperador").val(word);
	$("#idOperadorTxt").text(word);
}

var codope_var=0;
function addOperacion(word,codope){
	codope_var=codope;
	$("#idOperacion").val(word);
	$("#idOperacionTxt").text(word);
}

function pass_addOperacion(){
	if(codtipser_tll=="2"){
		if (codope_var==0||codope_var=="") {
			alert("Debe seleccionar operación!");
		}else{
			$(".panelCarga").fadeIn(200);
			$.ajax({
				type:"POST",
				url:"config/saveOpeAudPro.php",
				data:{
					codfic:codfic,
					secuen:secuen,
					codper:codoper_var,
					codope:codope_var
				},
				success:function(data){
					console.log(data);
					if (data.state==true) {
						$("#contentOperacion").css("display","none");
						$("#contentDefecto").css("display","block");
					}else{
						alert(data.error.detail);
					}
					$(".panelCarga").fadeOut(200);
				}
			});
		}
	}else{
		if (codoper_var==0||codope_var==0||codoper_var==""||codope_var=="") {
			alert("Debe seleccionar operador y operación!");
		}else{
			$(".panelCarga").fadeIn(200);
			$.ajax({
				type:"POST",
				url:"config/saveOpeAudPro.php",
				data:{
					codfic:codfic,
					secuen:secuen,
					codper:codoper_var,
					codope:codope_var
				},
				success:function(data){
					console.log(data);
					if (data.state==true) {
						$("#contentOperacion").css("display","none");
						$("#contentDefecto").css("display","block");
					}else{
						alert(data.error.detail);
					}
					$(".panelCarga").fadeOut(200);
				}
			});
		}
	}
}

function back_addOperacion(){
	$("#contentDefecto").css("display","none");
	$("#contentOperacion").css("display","block");	
	$("#idOperador").val("");
	$("#idOperacion").val("");
	codoper_var=0;
	codope_var=0;
	$(".tblBodyResumen").empty();
	$("#idCanDef").val(0);
	$("#idDefecto").val("");
	coddef=0;
	$(".tblDefectosRegistrados").css("display","none");
	$("#idOperador").keyup();
	$("#idOperacion").keyup();
	$("#idDefecto").keyup();
}

var coddef_var=0;
var wordDef_ft="";
function addDefecto(word,coddef){
	coddef_var=coddef;
	$("#idDefecto").val(word);
	wordDef_ft=word;
}

function pass_addDefecto(){
	if (coddef_var==0 || $("#idCanDef").val()==0 || $("#idCanDef").val()=="") {
		alert("Debe seleccionar defecto y cantidad!");
	}else{
		$(".panelCarga").fadeIn(200);
		$.ajax({
			type:"POST",
			url:"config/saveDefAudPro.php",
			data:{
				codfic:codfic,
				secuen:secuen,
				codper:codoper_var,
				codope:codope_var,
				coddef:coddef_var,
				candef:$("#idCanDef").val()
			},
			success:function(data){
				console.log(data);
				if (data.state==true) {
					var html="";
					html+=
					'<div class="tblLine">'+
						'<div class="itemBody" style="width: 75%;">'+wordDef_ft+'</div>'+
						'<div class="itemBody" style="width: 25%;">'+$("#idCanDef").val()+'</div>'+
					'</div>';
					$(".tblBodyResumen").append(html);
					$("#idCanDef").val(0);
					$("#idDefecto").val("");
					$(".tblDefectosRegistrados").css("display","block");
				}
				alert(data.detail);	
				$(".panelCarga").fadeOut(200);
			}
		});
	}
}

function end_AuditoriaProceso(){
	$(".panelCarga").fadeIn(200);
	$.ajax({
		type:"POST",
		url:"config/endFichaAudPro.php",
		data:{
			codfic:codfic,
			secuen:secuen
		},
		success:function(data){
			console.log(data);
			if (data.state==true) {
				location.href="main.php";
			}else{
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(200);
		}
	});
}

window.onbeforeunload = function(){
   end_AuditoriaProceso();
}