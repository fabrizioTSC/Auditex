var proveedores=[];
var auditores=[];
var supervisores=[];
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
	document.getElementById("idFecha").value=hoy;
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

function mostraIndRes(){
	if (codprv_var=="") {
		alert("Seleccione un proveedor primero!");
	}else{
		window.location.href="IndicadorResultados.php?codprv="+codprv_var+"&fecha="+document.getElementById("idFecha").value
		+"&codusu="+codusu_var+"&codusueje="+codusueje_var+"&bloque="+$("#selectBloque").val();
	}
}