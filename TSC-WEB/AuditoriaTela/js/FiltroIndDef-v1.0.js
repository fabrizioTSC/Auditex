var proveedores=[];
var clientes=[];
var programa=[];
$(document).ready(function(){
	$.ajax({
		type:"POST",
		data:{
		},
		url:"config/getFiltroIndDef.php",
		success:function(data){
			console.log(data);

			proveedores=data.proveedores;
			var html='';
			for (var i = 0; i < proveedores.length; i++) {
				html+='<div class="taller" onclick="selectPrv(\''+proveedores[i].CODPRV+'\',\''+formatText(proveedores[i].DESPRV)+'\')">'+proveedores[i].DESPRV+'</div>';
			}
			$("#spacePrv").empty();
			$("#spacePrv").append(html);

			clientes=data.clientes;
			var html='';
			for (var i = 0; i < clientes.length; i++) {
				html+='<div class="taller" onclick="selectCli(\''+clientes[i].CODCLI+'\',\''+formatText(clientes[i].DESCLI)+'\')">'+clientes[i].DESCLI+'</div>';
			}
			$("#spaceCli").empty();
			$("#spaceCli").append(html);

			$("#nombrePrv").val("(TODOS)");
			$("#nombreCli").val("(TODOS)");
			$("#nombrePro").val("(TODOS)");
			codprv_var="0";
			codcli_var="0";
			codpro_var="0";

			get_programa();
		}
	});
	$("#nombrePrv").keyup(function(){
		var html='';
		for (var i = 0; i < proveedores.length; i++) {
			if ((proveedores[i].DESPRV.toUpperCase()).indexOf($("#nombrePrv").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="selectPrv(\''+proveedores[i].CODPRV+'\',\''+formatText(proveedores[i].DESPRV)+'\')">'+proveedores[i].DESPRV+'</div>';
			}
		}
		$("#spacePrv").empty();
		$("#spacePrv").append(html);		
	});
	$("#nombreCli").keyup(function(){
		var html='';
		for (var i = 0; i < clientes.length; i++) {
			if ((clientes[i].DESCLI.toUpperCase()).indexOf($("#nombreCli").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="selectCli(\''+clientes[i].CODCLI+'\',\''+formatText(clientes[i].DESCLI)+'\')">'+clientes[i].DESCLI+'</div>';
			}
		}
		$("#spaceCli").empty();
		$("#spaceCli").append(html);	
	});
	$("#nombrePro").keyup(function(){
		var html='';
		for (var i = 0; i < programa.length; i++) {
			if ((programa[i].DESPRO.toUpperCase()).indexOf($("#nombrePro").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="selectPro(\''+programa[i].CODPRO+'\',\''+formatText(programa[i].DESPRO)+'\')">'+programa[i].DESPRO+'</div>';
			}
		}
		$("#spacePro").empty();
		$("#spacePro").append(html);	
	});
	/*
	var fecha=new Date();
	var dia=fecha.getDate();
	dia=""+dia;
	if (dia.length==1) {
		dia="0"+dia;
	}
	var mes=fecha.getMonth()+1;
	mes=""+mes;
	if (mes.length==1) {
		mes="0"+mes;
	}
	var anio=fecha.getFullYear();
	var hoy=anio+"-"+mes+"-"+dia;
	document.getElementById("idFecha").value=hoy;*/
});

var codprv_var="";
function selectPrv(codprv,desprv){
	codprv_var=codprv;
	$("#nombrePrv").val(desprv);
	get_programa();
}

var codcli_var="";
function selectCli(codcli,descli){
	codcli_var=codcli;
	$("#nombreCli").val(descli);
	get_programa();
}

var codpro_var="";
function selectPro(codpro,despro){
	codpro_var=codpro;
	$("#nombrePro").val(despro);
}

function get_programa(){
	$(".panelCarga").fadeIn(200);
	$.ajax({
		type:"POST",
		data:{
			codprv:codprv_var,
			codcli:codcli_var
		},
		url:"config/getFiltroIndDefPro.php",
		success:function(data){
			console.log(data);

			programa=data.programa;
			var html='';
			for (var i = 0; i < programa.length; i++) {
				html+='<div class="taller" onclick="selectPro(\''+programa[i].CODPRO+'\',\''+formatText(programa[i].DESPRO)+'\')">'+programa[i].DESPRO+'</div>';
			}
			$("#spacePro").empty();
			$("#spacePro").append(html);

			$("#nombrePro").val("(TODOS)");
			codpro_var="0";

			$(".panelCarga").fadeOut(200);
		}
	});
}

function mostraIndRes(){
	window.location.href="IndicadorDefectos.php?codprv="+codprv_var+"&codcli="+codcli_var+"&codpro="+codpro_var;//+"&fecha="+document.getElementById("idFecha").value;
}