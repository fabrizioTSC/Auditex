var proveedores=[];
$(document).ready(function(){
	$.ajax({
		type:"POST",
		data:{
		},
		url:"config/getFiltroRepGen.php",
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
	document.getElementById("idFechaDesde").value=hoy;
	document.getElementById("idFechaHasta").value=hoy;
});

function selectPrv(codprv,desprv){
	$("#nombreProveedor").val(desprv);
	codprv_var=codprv;
	$("#nombreProveedor").keyup();
}
var codprv_var="";

function mostraReporte(){
	if (codprv_var=="") {
		alert("Seleccione un proveedor primero!");
	}else{
		window.location.href="ReporteGeneral.php?codprv="+codprv_var
		+"&fecini="+document.getElementById("idFechaDesde").value+"&fecfin="+document.getElementById("idFechaHasta").value
		+"&estado="+$("#selectEstados").val()+"&resultado="+$("#selectResultado").val();
	}
}