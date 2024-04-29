function formatText(string){
	while(string.indexOf('"')>0){
		string=string.replace('"','');
	}
	return string;
}

var listaTalleres=[];
var listaAuditores=[];
function getTalleres(){
	$.ajax({
		type:"POST",
		url:"config/getInfoResultados.php",
		data:{
			request:"1"
		},
		success:function(data){
			console.log(data);
			$(".listaTalleres").empty();
			var htmlTalleres="";
			for (var i = 0; i < data.talleres.length; i++) {
				htmlTalleres+='<div class="taller" onclick="addTaller(\''+formatText(data.talleres[i].DESTLL)+'\','+data.talleres[i].CODTLL+')">'+data.talleres[i].DESTLL+'</div>';
			}
			listaTalleres.push(data.talleres);
			$(".listaTalleres").append(htmlTalleres);
			
			$(".listaAuditores").empty();
			var htmlTalleres="";
			for (var i = 0; i < data.auditor.length; i++) {
				var nombre=data.auditor[i].NOMUSU;//+' '+data.auditor[i].appusu+' '+data.auditor[i].apmusu;
				htmlTalleres+='<div class="taller" onclick="addAuditor(\''+nombre+'\','+data.auditor[i].CODUSU+')">'+nombre+'</div>';
			}
			var htmlTipo="";
			for (var i = 0; i < data.tipoauditoria.length; i++) {
				htmlTipo+='<option value="'+data.tipoauditoria[i].CODTAD+'">'+data.tipoauditoria[i].DESTAD+'</option>';				
			}
			$("#idTipoAuditoria").append(htmlTipo);
			listaAuditores.push(data.auditor);
			$(".listaAuditores").append(htmlTalleres);
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
			$(".panelCarga").fadeOut(300);
		}
	});
}

var codtll=0;
function addTaller(nombre,cod){
	codtll=cod;
	document.getElementById("nombreTaller").value=nombre;
}

var codusu=0;
function addAuditor(nombre,cod){
	codusu=cod;
	document.getElementById("nombreAuditor").value=nombre;
}

function mostraDatos() {
	var mensaje="";
	if (codtll==0) {
		mensaje+="Se mostraran todos los talleres";
		if (codusu==0) {
			mensaje+=" y todos os auditores!";
		}
	}else{
		if (codusu==0) {
			mensaje+="Se mostraran todos los auditores!";
		}
	}
	if (mensaje!="") {
		var option=confirm(mensaje);
		if (option==true) {
			enviarParamaetros();
		}
	}else{
		enviarParamaetros();
	}
}

function enviarParamaetros(){
	var codtad=document.getElementById("idTipoAuditoria").value;
	var fecini=document.getElementById("idFechaDesde").value;
	var fecfin=document.getElementById("idFechaHasta").value;
	var tipgra="";
	if (document.getElementById("idGrafico").checked) {
		tipgra="grafico";
	}else{
		tipgra="datos";
	}
	window.location.href="ResultadosDatos.php?codtll="+codtll+"&codusu="+codusu+"&codtad="+codtad+
	"&fecini="+fecini+"&fecfin="+fecfin+"&tipgra="+tipgra;
}

$(document).ready(function(){
	$(".checkDetect").click(function(){
		var arrays=document.getElementsByClassName("checkDetect");
		for (var i=0;i<arrays.length;i++){
			arrays[i].checked=false;
		}
		this.checked=true;
	});
	$("#nombreTaller").keyup(function(){
		$(".listaTalleres").empty();
		var htmlTalleres="";
		var busqueda=document.getElementById("nombreTaller").value;
		for (var i = 0; i < listaTalleres[0].length; i++) {
			//console.log(listaTalleres[0][i].DESTLL.toUpperCase());
			if ((listaTalleres[0][i].DESTLL.toUpperCase()).indexOf(busqueda.toUpperCase())>=0) {				
				htmlTalleres+='<div class="taller" onclick="addTaller(\''+formatText(listaTalleres[0][i].DESTLL)+'\','+listaTalleres[0][i].CODTLL+')">'+listaTalleres[0][i].DESTLL+"</div>";
			}
		}
		$(".listaTalleres").append(htmlTalleres);
	});
	$("#nombreAuditor").keyup(function(){
		$(".listaAuditores").empty();
		var htmlTalleres="";
		var busqueda=document.getElementById("nombreAuditor").value;
		for (var i = 0; i < listaAuditores[0].length; i++) {
			//console.log(listaTalleres[0][i].DESTLL.toUpperCase());
			if ((listaAuditores[0][i].NOMUSU.toUpperCase()).indexOf(busqueda.toUpperCase())>=0) {				
				htmlTalleres+='<div class="taller" onclick="addAuditor(\''+listaAuditores[0][i].NOMUSU+'\','+listaAuditores[0][i].CODUSU+')">'+listaAuditores[0][i].NOMUSU+"</div>";
			}
		}
		$(".listaAuditores").append(htmlTalleres);
	});
});