function formatText(string){
	while(string.indexOf('"')>0){
		string=string.replace('"','');
	}
	return string;
}

var listaAuditores=[];
var sedes=[];
var tipser=[];
var celulas=[];
var celulas_aux=[];
function getDatos(){
	$.ajax({
		type:"POST",
		url:"config/getInfoRepGen.php",
		data:{
			request:"1"
		},
		success:function(data){
			console.log(data);

			sedes=data.sedes;
			var html='';
			for (var i = 0; i < sedes.length; i++) {
				html+='<div class="taller" onclick="selectSede(\''+sedes[i].CODSEDE+'\',\''+formatText(sedes[i].DESSEDE)+'\')">'+sedes[i].DESSEDE+'</div>';
			}
			$("#spaceSedes").empty();
			$("#spaceSedes").append(html);

			tipser=data.tipser;
			var html='';
			for (var i = 0; i < tipser.length; i++) {
				html+='<div class="taller" onclick="selectTipSer(\''+tipser[i].CODTIPSERV+'\',\''+formatText(tipser[i].DESTIPSERV)+'\')">'+tipser[i].DESTIPSERV+'</div>';
			}
			$("#spaceTipoSer").empty();
			$("#spaceTipoSer").append(html);

			celulas=data.celulas;
			celulas_aux=celulas;
			var html='';
			for (var i = 0; i < celulas_aux.length; i++) {
				html+='<div class="taller" onclick="selectCelula(\''+celulas_aux[i].CODCEL+'\',\''+formatText(celulas_aux[i].DESCEL)+'\')">'+celulas_aux[i].DESCEL+'</div>';
			}
			$("#spacecelulas").empty();
			$("#spacecelulas").append(html);

			$("#nombreSede").val("(TODOS)");
			$("#nombreTipoSer").val("(TODOS)");
			$("#nombrecelula").val("(TODOS)");
			$("#nombreAuditor").val("(TODOS)");
			codsede_var="0";
			codtipser_var="0";
			codcel_var="0";
			codusu="0";


			var htmlcelulas="";
			
			$(".listaAuditores").empty();
			var htmlcelulas="";
			for (var i = 0; i < data.auditor.length; i++) {
				var nombre=data.auditor[i].NOMUSU;//+' '+data.auditor[i].appusu+' '+data.auditor[i].apmusu;
				htmlcelulas+='<div class="taller" onclick="addAuditor(\''+nombre+'\','+data.auditor[i].CODUSU+')">'+nombre+'</div>';
			}
			listaAuditores.push(data.auditor);
			$(".listaAuditores").append(htmlcelulas);
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
			$(".panelCarga").fadeOut(200);
		}
	});
}

var codtll=0;
function addTaller(nombre,cod){
	codtll=cod;
	document.getElementById("nombrecelula").value=nombre;
}

var codusu=0;
function addAuditor(nombre,cod){
	codusu=cod;
	document.getElementById("nombreAuditor").value=nombre;
}

function mostraDatos() {
	var mensaje="";
	if (codtll==0) {
		mensaje+="Se mostrarán todos los celulas";
		if (codusu==0) {
			mensaje+=" y todos los auditores!";
		}
	}else{
		if (codusu==0) {
			mensaje+="Se mostrarán todos los auditores!";
		}
	}
	if (mensaje!="") {
		/*var option=confirm(mensaje);
		if (option==true) {*/
			enviarParamaetros();
		/*}*/
	}else{
		enviarParamaetros();
	}
}

function enviarParamaetros(){
	var fecini=document.getElementById("idFechaDesde").value;
	var fecfin=document.getElementById("idFechaHasta").value;
	var tipgra="";
	if (document.getElementById("idGrafico").checked) {
		tipgra="grafico";
	}else{
		tipgra="datos";
	}
	/*
	window.location.href="ReporteGeneralVerEmp.php?codusu="+codusu+"&codsede="+codsede_var+"&codtipser="+codtipser_var+"&codcel="+codcel_var+
	"&fecini="+fecini+"&fecfin="+fecfin+"&tipgra="+tipgra;*/
	window.location.href="ReporteGeneralCalInt.php?codusu="+codusu+"&fecini="+fecini+"&fecfin="+fecfin+"&tipgra="+tipgra;
}

$(document).ready(function(){
	$("#nombreSede").keyup(function(){
		var html='';
		for (var i = 0; i < sedes.length; i++) {
			if ((sedes[i].DESSEDE.toUpperCase()).indexOf($("#nombreSede").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="selectSede(\''+sedes[i].CODSEDE+'\',\''+formatText(sedes[i].DESSEDE)+'\')">'+sedes[i].DESSEDE+'</div>';
			}
		}
		$("#spaceSedes").empty();
		$("#spaceSedes").append(html);		
	});
	$("#nombreTipoSer").keyup(function(){
		var html='';
		for (var i = 0; i < tipser.length; i++) {
			if ((tipser[i].DESTIPSERV.toUpperCase()).indexOf($("#nombreTipoSer").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="selectTipSer(\''+tipser[i].CODTIPSERV+'\',\''+formatText(tipser[i].DESTIPSERV)+'\')">'+tipser[i].DESTIPSERV+'</div>';
			}
		}
		$("#spaceTipoSer").empty();
		$("#spaceTipoSer").append(html);	
	});
	$("#nombrecelula").keyup(function(){
		var html='';
		for (var i = 0; i < celulas_aux.length; i++) {
			if ((celulas_aux[i].DESCEL.toUpperCase()).indexOf($("#nombrecelula").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="selectCelula(\''+celulas_aux[i].CODCEL+'\',\''+formatText(celulas_aux[i].DESCEL)+'\')">'+celulas_aux[i].DESCEL+'</div>';
			}
		}
		$("#spacecelulas").empty();
		$("#spacecelulas").append(html);	
	});

	$(".checkDetect").click(function(){
		var arrays=document.getElementsByClassName("checkDetect");
		for (var i=0;i<arrays.length;i++){
			arrays[i].checked=false;
		}
		this.checked=true;
	});
	$("#nombreAuditor").keyup(function(){
		$(".listaAuditores").empty();
		var htmlcelulas="";
		var busqueda=document.getElementById("nombreAuditor").value;
		for (var i = 0; i < listaAuditores[0].length; i++) {
			//console.log(listacelulas[0][i].DESTLL.toUpperCase());
			if ((listaAuditores[0][i].NOMUSU.toUpperCase()).indexOf(busqueda.toUpperCase())>=0) {				
				htmlcelulas+='<div class="taller" onclick="addAuditor(\''+listaAuditores[0][i].NOMUSU+'\','+listaAuditores[0][i].CODUSU+')">'+listaAuditores[0][i].NOMUSU+"</div>";
			}
		}
		$(".listaAuditores").append(htmlcelulas);
	});
});

var codsede_var="";
function selectSede(codsede,dessede){
	codsede_var=codsede;
	$("#nombreSede").val(dessede);

	if (codsede!="0") {
		var array_aux=[];
		var html='';
		for (var i = 0; i < celulas.length; i++) {
			if (celulas[i].CODSEDE==codsede) {
				array_aux.push(celulas[i]);
				html+='<div class="taller" onclick="selectTaller(\''+celulas[i].CODTLL+'\',\''+formatText(celulas[i].DESTLL)+'\')">'+celulas[i].DESTLL+'</div>';
			}else{
				if (i==0) {
					array_aux.push(celulas[i]);
					html+='<div class="taller" onclick="selectTaller(\''+celulas[i].CODTLL+'\',\''+formatText(celulas[i].DESTLL)+'\')">'+celulas[i].DESTLL+'</div>';					
				}
			}
		}
		celulas_aux=array_aux;
		$("#spacecelulas").empty();
		$("#spacecelulas").append(html);
	}else{
		var html='';
		for (var i = 0; i < celulas.length; i++) {
			html+='<div class="taller" onclick="selectTaller(\''+celulas[i].CODTLL+'\',\''+formatText(celulas[i].DESTLL)+'\')">'+celulas[i].DESTLL+'</div>';
		}
		$("#spacecelulas").empty();
		$("#spacecelulas").append(html);
	}
	$("#nombrecelula").val("(TODOS)");
	codtll_var="0";
	$("#nombreTipoSer").val("(TODOS)");
	codtipser_var="0";
}

var codtipser_var="";
function selectTipSer(codtipser,destipser){
	if (codsede_var=="") {
		alert("Seleccione una sede primero!");
	}else{
		codtipser_var=codtipser;
		$("#nombreTipoSer").val(destipser);

		if (codtipser!="0") {
			var array_aux=[];
			var html='';
			if (codsede_var!="0") {
				for (var i = 0; i < celulas.length; i++) {			
					if (celulas[i].CODTIPSERV==codtipser && celulas[i].CODSEDE==codsede_var) {
						array_aux.push(celulas[i]);
						html+='<div class="taller" onclick="selectTaller(\''+celulas[i].CODTLL+'\',\''+formatText(celulas[i].DESTLL)+'\')">'+celulas[i].DESTLL+'</div>';
					}else{
						if (i==0) {
							array_aux.push(celulas[i]);
							html+='<div class="taller" onclick="selectTaller(\''+celulas[i].CODTLL+'\',\''+formatText(celulas[i].DESTLL)+'\')">'+celulas[i].DESTLL+'</div>';					
						}
					}
				}
			}else{
				for (var i = 0; i < celulas.length; i++) {
					if (celulas[i].CODTIPSERV==codtipser) {
						array_aux.push(celulas[i]);
						html+='<div class="taller" onclick="selectTaller(\''+celulas[i].CODTLL+'\',\''+formatText(celulas[i].DESTLL)+'\')">'+celulas[i].DESTLL+'</div>';
					}else{
						if (i==0) {
							array_aux.push(celulas[i]);
							html+='<div class="taller" onclick="selectTaller(\''+celulas[i].CODTLL+'\',\''+formatText(celulas[i].DESTLL)+'\')">'+celulas[i].DESTLL+'</div>';					
						}
					}
				}
			}
			celulas_aux=array_aux;
			$("#spacecelulas").empty();
			$("#spacecelulas").append(html);
		}else{
			if (codsede_var!="0") {
				var array_aux=[];
				var html='';
				for (var i = 0; i < celulas.length; i++) {
					if (celulas[i].CODSEDE==codsede_var) {
						array_aux.push(celulas[i]);
						html+='<div class="taller" onclick="selectTaller(\''+celulas[i].CODTLL+'\',\''+formatText(celulas[i].DESTLL)+'\')">'+celulas[i].DESTLL+'</div>';
					}else{
						if (i==0) {
							array_aux.push(celulas[i]);
							html+='<div class="taller" onclick="selectTaller(\''+celulas[i].CODTLL+'\',\''+formatText(celulas[i].DESTLL)+'\')">'+celulas[i].DESTLL+'</div>';					
						}
					}
				}
				celulas_aux=array_aux;
				$("#spacecelulas").empty();
				$("#spacecelulas").append(html);
			}else{
				var html='';
				for (var i = 0; i < celulas.length; i++) {
					html+='<div class="taller" onclick="selectCelula(\''+celulas[i].CODTLL+'\',\''+formatText(celulas[i].DESTLL)+'\')">'+celulas[i].DESTLL+'</div>';
				}
				$("#spacecelulas").empty();
				$("#spacecelulas").append(html);
			}
		}
		$("#nombrecelula").val("(TODOS)");
		codtll_var="0";
	}
}

var codcel_var="";
function selectCelula(codcel,descel){
	if (codsede_var=="") {
		alert("Seleccione una sede primero!");
	}else{
		if (codtipser_var=="") {
			alert("Seleccione un tipo de servicio primero!");
		}else{
			codcel_var=codcel;
			$("#nombrecelula").val(descel);
		}
	}
}