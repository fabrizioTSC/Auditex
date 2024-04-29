var proveedores=[];
var auditores=[];
var supervisores=[];
var clientes=[];
$(document).ready(function(){
	$.ajax({
		type:"POST",
		data:{
		},
		url:"config/getFiltroIndRes.php",
		success:function(data){
			console.log(data);

			proveedores=data.proveedores;
			var html='';
			for (var i = 0; i < proveedores.length; i++) {
				html+='<div class="taller" onclick="selectPrv(\''+proveedores[i].CODPRV+'\',\''+formatText(proveedores[i].DESPRV)+'\')">'+proveedores[i].DESPRV+'</div>';
			}
			$("#spaceproveedores").empty();
			$("#spaceproveedores").append(html);

			$("#nombreProveedor").val("(TODOS)");
			codprv_var="0";

			auditores=data.auditores;
			var html='';
			for (var i = 0; i < auditores.length; i++) {
				html+='<div class="taller" onclick="selectAudi(\''+auditores[i].CODUSU+'\',\''+formatText(auditores[i].DESUSU)+'\')">'+auditores[i].DESUSU+'</div>';
			}
			$("#spaceauditores").empty();
			$("#spaceauditores").append(html);

			$("#nombreAuditor").val("(TODOS)");
			codusu_var="0";

			supervisores=data.supervisores;
			var html='';
			for (var i = 0; i < supervisores.length; i++) {
				html+='<div class="taller" onclick="selectSuper(\''+supervisores[i].CODUSUEJE+'\',\''+formatText(supervisores[i].DESUSUEJE)+'\')">'+supervisores[i].DESUSUEJE+'</div>';
			}
			$("#spacesupervisores").empty();
			$("#spacesupervisores").append(html);

			$("#nombreSupervisor").val("(TODOS)");
			codusueje_var="0";

			clientes=data.clientes;
			var html='';
			for (var i = 0; i < clientes.length; i++) {
				html+='<div class="taller" onclick="selectCli(\''+clientes[i].CODCLI+'\',\''+formatText(clientes[i].DESCLI)+'\')">'+clientes[i].DESCLI+'</div>';
			}
			$("#spaceclientes").empty();
			$("#spaceclientes").append(html);

			$("#nombreCliente").val("(TODOS)");
			codcli_var="0";

			$(".panelCarga").fadeOut(200);			
		}
	});
	$("#nombreProveedor").keyup(function(){
		var html='';
		for (var i = 0; i < proveedores.length; i++) {
			if ((proveedores[i].DESPRV.toUpperCase()).indexOf($("#nombreProveedor").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="selectPrv(\''+proveedores[i].CODPRV+'\',\''+formatText(proveedores[i].DESPRV)+'\')">'+proveedores[i].DESPRV+'</div>';
			}
		}
		$("#spaceproveedores").empty();
		$("#spaceproveedores").append(html);	
	});
	$("#nombreAuditor").keyup(function(){
		var html='';
		for (var i = 0; i < auditores.length; i++) {
			if ((auditores[i].DESUSU.toUpperCase()).indexOf($("#nombreAuditor").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="selectAudi(\''+auditores[i].CODUSU+'\',\''+formatText(auditores[i].DESUSU)+'\')">'+auditores[i].DESUSU+'</div>';
			}
		}
		$("#spaceauditores").empty();
		$("#spaceauditores").append(html);	
	});
	$("#nombreSupervisor").keyup(function(){
		var html='';
		for (var i = 0; i < supervisores.length; i++) {
			if ((supervisores[i].DESUSUEJE.toUpperCase()).indexOf($("#nombreSupervisor").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="selectSuper(\''+supervisores[i].CODPRV+'\',\''+formatText(supervisores[i].DESUSUEJE)+'\')">'+supervisores[i].DESUSUEJE+'</div>';
			}
		}
		$("#spacesupervisores").empty();
		$("#spacesupervisores").append(html);	
	});
	$("#nombreCliente").keyup(function(){
		var html='';
		for (var i = 0; i < clientes.length; i++) {
			if ((clientes[i].DESCLI.toUpperCase()).indexOf($("#nombreCliente").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="selectCli(\''+clientes[i].CODCLI+'\',\''+formatText(clientes[i].DESCLI)+'\')">'+clientes[i].DESCLI+'</div>';
			}
		}
		$("#spaceclientes").empty();
		$("#spaceclientes").append(html);
	});
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
	document.getElementById("idfecini").value=hoy;
	document.getElementById("idfecfin").value=hoy;
});

function selectPrv(codprv,desprv){
	$("#nombreProveedor").val(desprv);
	codprv_var=codprv;
	$("#nombreProveedor").keyup();
}
var codprv_var="";

function selectAudi(codusu,desprv){
	$("#nombreAuditor").val(desprv);
	codusu_var=codusu;
	$("#nombreAuditor").keyup();
}
var codusu_var="";

function selectSuper(codusueje,desprv){
	$("#nombreSupervisor").val(desprv);
	codusueje_var=codusueje;
	$("#nombreSupervisor").keyup();
}
var codusueje_var="";

function selectCli(codcli,descli){
	$("#nombreCliente").val(descli);
	codcli_var=codcli;
	$("#nombreCliente").keyup();
}
var codcli_var="";

function mostraIndRes(){
	if (codprv_var=="") {
		alert("Seleccione un proveedor primero!");
	}else{
		window.location.href="IndicadorConcesionados.php?codprv="+codprv_var+"&codcli="+codcli_var+"&fecini="+document.getElementById("idfecini").value+
		"&fecfin="+document.getElementById("idfecfin").value;
	}
}