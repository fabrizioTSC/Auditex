window.onload=cargarDatos();

function cargarDatos(){
	$.ajax({
		type:"POST",
		data:{

		},
		url:"config/getTipoAuditoriaAql.php",
		success:function(data){
			//console.log(data);
			if (data.state=true) {				
				var htmlTipos='<option value="0">(SELECCIONE)</option>';
				for (var i = 0; i < data.tipos.length; i++) {
					htmlTipos+='<option value="'+data.tipos[i].CODTAD+'">'+data.tipos[i].DESTAD+'</option>';
				}
				var htmlAqls='<option value="0">(SELECCIONE)</option>';
				for (var i = 0; i < data.aqls.length; i++) {
					htmlAqls+='<option value="'+data.aqls[i].CODAQL+'">AQL '+data.aqls[i].AQL+'%</option>';
				}
				$("#idSelectForTipoAuditoria").append(htmlTipos);
				$("#idSelectForAql").append(htmlAqls);
			}else{
				alert("Error al cargar pagina!");
				window.location.href="RegistrarAsignarAql.php";
			}
			$(".panelCarga").fadeOut(300);
		}
	});
}

function ModifcarAql(){
	/* Guardar los cambios del Aql al tipo de auditoria */
	$(".panelCarga").fadeIn(300);
	$.ajax({	
		type:"POST",
		data:{
			codtad:$("#idSelectForTipoAuditoria").val(),
			codaql:$("#idSelectForAql").val(),
		},
		url:"config/changeAqlToTipoAuditoria.php",
		success:function(data){
			console.log(data);
			if (data.state=true) {				
				alert(data.description);
				//window.location.href="RegistrarAsignarAql.php";
			}else{
				alert(data.error.description);
			}
			$(".panelCarga").fadeOut(300);
		}
	});
}

/* ASIGNAR AQL A FICHA AUDITORIA */

$(document).ready(function(){
	$(".btnBuscarSpace").click(function(){
		var codfic=document.getElementById("idCodFicha").value;
		$("#idContentForFicha").css("display","none");
		$("#idContentForAql").css("display","none");
		$("#idTblDefectos").empty();
		$(".msgForFichas").empty();
		$(".msgForFichas").css("display","none");
		$(".panelCarga").fadeIn(300);
		$.ajax({
			type:"POST",
			url:"config/getFichaDetalle.php",
			data:{
				codfic:codfic,
				typepost:1
			},
			success:function(data){
				$(".tblBody").empty();
				$("#idContentTblFichas").css("display","none");
				console.log(data);
				if (data.state==true) {
					var htmlFichas="";
					for (var i = 0; i < data.fichas.length; i++) {
						htmlFichas+=
							'<div class="tblLine" onclick="fichaSelectedForEdit('+data.fichas[i].CODFIC+',\''+
								data.fichas[i].AQL+'\','+
								data.fichas[i].CODAQL+','+
								data.fichas[i].CODTAD+','+
								data.fichas[i].NUMVEZ+','+
								data.fichas[i].PARTE+')">'+
								'<div class="itemBody" style="width: 50%;">'+data.fichas[i].DESTLL+'</div>'+
								'<div class="itemBody" style="width: 15%;">'+data.fichas[i].PARTE+'</div>'+
								'<div class="itemBody" style="width: 15%;">'+data.fichas[i].NUMVEZ+'</div>'+
								'<div class="itemBody" style="width: 20%;">'+data.fichas[i].CANPAR+'</div>'+
							'</div>';
					}
					$(".tblBody").append(htmlFichas);			
					$("#idContentTblFichas").css("display","block");
				}else{
					$(".msgForFichas").append("No se encontro la ficha!");
					$(".msgForFichas").css("display","block");
				}
				$(".panelCarga").fadeOut(300);
			}
		})
	});
});

var fsfecodfic=0;
var fsfecodaql=0;
var fsfecodtad=0;
var fsfenumvez=0;
var fsfeparte=0;
function fichaSelectedForEdit(codfic,aql,codaql,codtad,numvez,parte){
	$("#idContentForAql").css("display","none");
	$("#idSelectForAql").empty();
	$(".panelCarga").fadeIn(300);
	$.ajax({
		type:"GET",
		url:"config/getTipoAuditoriaAql.php",
		data:{

		},
		success:function(data){
			console.log(data);
			fsfecodfic=codfic;
			fsfecodaql=codaql;
			fsfecodtad=codtad;
			fsfenumvez=numvez;
			fsfeparte=parte;
			if (data.state) {
				var htmlAqls="";
				for (var i = 0; i < data.aqls.length; i++) {
					htmlAqls+='<option value="'+data.aqls[i].CODAQL+'">AQL '+data.aqls[i].AQL+'%</option>';
					data.aqls[i]
				}
				$("#idSelectForAql").append(htmlAqls);
				$("#idSelectForAql").val(codaql);
				$("#idContentForAql").css("display","block");				
			}else{
				alert("No se pudo obtener resultados!");
			}
			$(".panelCarga").fadeOut(300);
		}
	});
}

function ModifcarAqlToFicha(){
	$(".panelCarga").fadeIn(300);
	$.ajax({
		type:"POST",
		url:"config/saveAqlToFicha.php",
		data:{			
			codfic:fsfecodfic,
			codaql:fsfecodaql,
			codtad:fsfecodtad,
			numvez:fsfenumvez,
			parte:fsfeparte,
			newaql:$("#idSelectForAql").val()
		},
		success:function(data){
			console.log(data);
			if (data.state==true) {
				alert("Ficha modificada!");
				$(".btnBuscarSpace").click();
			}else{
				alert("No se pudo modificar ficha!");
			}
			$(".panelCarga").fadeOut(300);
		}
	});
}