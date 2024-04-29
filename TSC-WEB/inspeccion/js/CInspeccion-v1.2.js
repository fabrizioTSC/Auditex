$(document).ready(function(){
	$(".panelCarga").fadeOut(200);
});

function searchFicha(){
	if ($("#iccodfic").val()!="") {
		$(".panelCarga").fadeIn(200);
		$("#space2").css("display","none");
		$("#space1").css("display","none");
		$.ajax({
			type:"POST",
			url:"config/getFichasInspeccion.php",
			data:{
				codfic:$("#iccodfic").val()
			},
			success:function(data){
				console.log(data);
				if(data.state==true){
					$("#idListaFichas").empty();
					var html="";
					for (var i = 0; i < data.fichas.length; i++) {
						var fecha=data.fichas[i].FECINSCOS.split('/');
						var fec=new Date((2000+parseInt(fecha[2]))+"-"+fecha[1]+"-"+fecha[0]+"T00:00:00");
						var hoy=new Date();
						var dif=(hoy-fec)/(24*60*60*1000);
						var disabled="disabled";
						var state_dis=0;
						if (dif<2 && codusu==data.fichas[i].CODUSU) {
							$("#spaceBtnEdit").css("display","block");
							var disabled="";
							state_dis=1;
						}else{
							$("#spaceBtnEdit").css("display","none");
							state_dis=0;
						}

						html+=
						'<div class="tblLine" style="width:auto;" onclick="selectedFicha('+data.fichas[i].CODINSCOS+','+data.fichas[i].CANPRE+','+data.fichas[i].CANPREDEF+',\''
						+data.fichas[i].FECINSCOS+'\','+state_dis+')">'+
							'<div class="itemBody2" style="width: 50px;">'+data.fichas[i].CODINSCOS+'</div>'+
							'<div class="itemBody2" style="width: calc(100px);">'+data.fichas[i].DESTLL+'</div>'+
							'<div class="itemBody2" style="width: calc(90px);">'+data.fichas[i].CODUSU+'</div>'+
							'<div class="itemBody2" style="width: calc(70px);">'+data.fichas[i].FECINSCOS+'</div>'+
							'<div class="itemBody2" style="width: 60px;">'+data.fichas[i].CANTIDAD+'</div>'+
							'<div class="itemBody2" style="width: 60px;">'+data.fichas[i].CANPRE+'</div>'+
							'<div class="itemBody2" style="width: 60px;">'+data.fichas[i].CANPREDEF+'</div>'+
							'<div class="itemBody2" style="width: 60px;">'+data.fichas[i].CANDETDEF+'</div>'+
							'<div class="itemBody2" style="width: 60px;"><button style="width:25px;" onclick="deleteAllIns('+data.fichas[i].CODINSCOS+')" '+disabled+'><i class="fa fa-trash" aria-hidden="true"></i></button>'+
							'<button style="width:25px;" onclick="editAllIns('+data.fichas[i].CODINSCOS+')" '+disabled+'><i class="fa fa-pencil" aria-hidden="true"></i></button></div>'+
						'</div>';
					}
					$("#idListaFichas").append(html);
					$("#space1").css("display","block");
				}else{
					alert(data.detail);
				}
				$(".panelCarga").fadeOut(200);
			}
		});
	}else{
		alert("Ingrese un código de ficha!");
	}
}

var codinscos_var="";
var candettotal=0;
function selectedFicha(codinscos,canpre,canpredef,fecinscos,state_dis){
	$("#space1").css("display","none");
	$(".panelCarga").fadeIn(200);
	$("#idCan").text(canpre);
	$("#idCanDef").text(canpredef);
	codinscos_var=codinscos;
	$.ajax({
		type:"POST",
		url:"config/searchFichaInspeccionada.php",
		data:{
			codinscos:codinscos
		},
		success:function(data){
			var disabled="disabled";
			if (state_dis==1) {
				$("#spaceBtnEdit").css("display","block");
				disabled="";
			}else{
				$("#spaceBtnEdit").css("display","none");
			}
			$("#idNumIns").text(codinscos);
			//console.log(data);
			if(data.state==true){
				$("#idListaIns").empty();
				var html="";
				for (var i = 0; i < data.defectos.length; i++) {					
					html+=
					'<div class="tblLine">'+
						'<div class="itemBody2" style="width: calc(50% - 85px);">'+data.defectos[i].DESOPE+'</div>'+
						'<div class="itemBody2" style="width: calc(50% - 85px);">'+data.defectos[i].DESDEF+'</div>'+
						'<div class="itemBody2" style="width: 70px;">'+data.defectos[i].CANDET+'</div>'+
						'<div class="itemBody2" style="width: 60px;">'+
							'<button style="width:25px;" onclick="deleteDefOpe('+
							data.defectos[i].CODOPE+','+data.defectos[i].CODDEF+','+codinscos_var+','+data.defectos[i].CANDET+')" '+disabled+'><i class="fa fa-trash" aria-hidden="true"></i></button>'+
							'<button style="width:25px;" onclick="editDefOpe('+
							data.defectos[i].CODOPE+','+data.defectos[i].CODDEF+','+codinscos_var+','+data.defectos[i].CANDET+',\''+
							data.defectos[i].DESOPE+'\',\''+data.defectos[i].DESDEF+'\')" '+disabled+'><i class="fa fa-pencil" aria-hidden="true"></i></button>'+
						'</div>'+
					'</div>';
					candettotal+=parseInt(data.defectos[i].CANDET);
				}
				$("#idListaIns").append(html);
				$("#space2").css("display","block");
			}else{
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(200);
		}
	});	
}

function backFichas(){
	$("#space1").css("display","block");
	$("#space2").css("display","none");	
}

function editInspect(path){
	location.href=path+"?codinscos="+codinscos_var;
}

function deleteDefOpe(codope,coddef,codinscos,candet){
	var canpredef=parseInt($("#idCanDef").text());
	if (candettotal-candet<canpredef) {
		alert("No se puede eliminar defecto ya que la cantidad de prendas con defectos excederia a la cantidad de defectos!");
	}else{
		var confirm_var=confirm("Seguro que desea eliminar la operación/defecto?");
		if (confirm_var==true) {
			$(".panelCarga").fadeIn(200);
			$.ajax({
				type:"POST",
				url:"config/deleteOpeDef.php",
				data:{
					codinscos:codinscos,
					codope:codope,
					coddef:coddef
				},
				success:function(data){
					if (data.state==true) {
						searchFicha();
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(200);
				}
			});
		}
	}
}

var candet_ant=0;
var codinscos_editvar="";
var codope_editvar="";
var coddef_editvar="";
function editDefOpe(codope,coddef,codinscos,candet,desope,desdef){
	codinscos_editvar=codinscos;
	codope_editvar=codope;
	coddef_editvar=coddef;
	$("#idNumInsEditDefOpe").text(codinscos);
	candet_ant=parseInt(candet);
	$("#idnewcandet").val(candet);
	$("#nomoperacion").text(desope);
	$("#nomdefecto").text(desdef);
	$("#modalEditDefOpe").fadeIn(200);
}

function closeModalEditDefOpe(){
	$("#modalEditDefOpe").fadeOut(200);
}

function deleteAllIns(codinscos){
	event.stopPropagation();
	var confirm_var=confirm("Seguro que desea eliminar la inspección "+codinscos+"?");
	if (confirm_var==true) {
		$(".panelCarga").fadeIn(200);
		$.ajax({
			type:"POST",
			url:"config/editAllInspeccion.php",
			data:{
				codinscos:codinscos,
				type:"delete"
			},
			success:function(data){
				if (data.state==true) {
					searchFicha();
				}else{
					alert(data.detail);
				}
				$(".panelCarga").fadeOut(200);
			}
		});
	}
}

/*
var codinscos_var_edit="";
var canpredef_var_edit="";
var candetdef_var_edit="";
function editAllIns(codinscos,canpredef,candetdef){
	event.stopPropagation();
	codinscos_var_edit=codinscos;
	canpredef_var_edit=canpredef;
	candetdef_var_edit=candetdef;
	$("#idNumInsEdit").text(codinscos);
	$("#idnewcanpredef").val(canpredef);
	$("#modalEdit").fadeIn(100);
}
*/

function editAllIns(codinscos){
	event.stopPropagation();
	location.href="EditarInspeccionFicha.php?codinscos="+codinscos;
}

function saveEditDetDefOpe(){
	var canpredef=parseInt($("#idCanDef").text());
	var candetnew=parseInt($("#idnewcandet").val());
	if (candettotal-candet_ant+candetnew<canpredef) {
		alert("No se puede editar defecto ya que la cantidad de prendas con defectos excederia a la cantidad de defectos!");
	}else{
		if (candetnew==0) {
			alert("Para eliminar utilice la opción de \"Eliminación\"!");
		}else{
			$(".panelCarga").fadeIn(200);
			$.ajax({
				type:"POST",
				url:"config/editOpeDef.php",
				data:{
					codinscos:codinscos_editvar,
					codope:codope_editvar,
					coddef:coddef_editvar,
					candet:candetnew
				},
				success:function(data){
					if (data.state==true) {
						closeModalEditDefOpe();
						searchFicha();
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(200);
				}
			});
		}
	}
}

function saveEditInspect(){
	var var_canpredef=parseInt($("#idnewcanpredef").val());
	if (var_canpredef>parseInt(candetdef_var_edit)) {
		alert("Las prendas con defectos no puede ser mayor a la cantidad de defectos!");
	}else{
		$(".panelCarga").fadeIn(200);
		$.ajax({
			type:"POST",
			url:"config/editAllInspeccion.php",
			data:{
				codinscos:codinscos_var_edit,
				canpredef:var_canpredef,
				type:"edit"
			},
			success:function(data){
				if (data.state==true) {
					closeModalEdit();
					searchFicha();
				}else{
					alert(data.detail);
				}
				$(".panelCarga").fadeOut(200);
			}
		});
	}
}

function closeModalEdit(){
	$("#modalEdit").fadeOut(100);
}