var sedes=[];
var tipser=[];
var talleres=[];
var talleres_aux=[];
$(document).ready(function(){
	$.ajax({
		type:"POST",
		data:{
		},
		url:"config/getFiltroIndRes.php",
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

			talleres=data.talleres;
			talleres_aux=talleres;
			var html='';
			for (var i = 0; i < talleres_aux.length; i++) {
				html+='<div class="taller" onclick="selectTaller(\''+talleres_aux[i].CODTLL+'\',\''+formatText(talleres_aux[i].DESTLL)+'\')">'+talleres_aux[i].DESTLL+'</div>';
			}
			$("#spaceTalleres").empty();
			$("#spaceTalleres").append(html);

			$("#nombreSede").val("(TODOS)");
			$("#nombreTipoSer").val("(TODOS)");
			$("#nombreTaller").val("(TODOS)");
			codsede_var="0";
			codtipser_var="0";
			codtll_var="0";

			$(".panelCarga").fadeOut(200);			
		}
	});
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
	$("#nombreTaller").keyup(function(){
		var html='';
		for (var i = 0; i < talleres_aux.length; i++) {
			if ((talleres_aux[i].DESTLL.toUpperCase()).indexOf($("#nombreTaller").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="selectTaller(\''+talleres_aux[i].CODTLL+'\',\''+formatText(talleres_aux[i].DESTLL)+'\')">'+talleres_aux[i].DESTLL+'</div>';
			}
		}
		$("#spaceTalleres").empty();
		$("#spaceTalleres").append(html);	
	});
});

var codsede_var="";
function selectSede(codsede,dessede){
	codsede_var=codsede;
	$("#nombreSede").val(dessede);

	if (codsede!="0") {
		var array_aux=[];
		var html='';
		for (var i = 0; i < talleres.length; i++) {
			if (talleres[i].CODSEDE==codsede) {
				array_aux.push(talleres[i]);
				html+='<div class="taller" onclick="selectTaller(\''+talleres[i].CODTLL+'\',\''+formatText(talleres[i].DESTLL)+'\')">'+talleres[i].DESTLL+'</div>';
			}else{
				if (i==0) {
					array_aux.push(talleres[i]);
					html+='<div class="taller" onclick="selectTaller(\''+talleres[i].CODTLL+'\',\''+formatText(talleres[i].DESTLL)+'\')">'+talleres[i].DESTLL+'</div>';					
				}
			}
		}
		talleres_aux=array_aux;
		$("#spaceTalleres").empty();
		$("#spaceTalleres").append(html);
	}else{
		var html='';
		for (var i = 0; i < talleres.length; i++) {
			html+='<div class="taller" onclick="selectTaller(\''+talleres[i].CODTLL+'\',\''+formatText(talleres[i].DESTLL)+'\')">'+talleres[i].DESTLL+'</div>';
		}
		$("#spaceTalleres").empty();
		$("#spaceTalleres").append(html);
	}
	//$("#nombreTaller").keyup();
	//$("#nombreTipoSer").keyup();
	$("#nombreTaller").val("(TODOS)");
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
				for (var i = 0; i < talleres.length; i++) {			
					if (talleres[i].CODTIPSERV==codtipser && talleres[i].CODSEDE==codsede_var) {
						array_aux.push(talleres[i]);
						html+='<div class="taller" onclick="selectTaller(\''+talleres[i].CODTLL+'\',\''+formatText(talleres[i].DESTLL)+'\')">'+talleres[i].DESTLL+'</div>';
					}else{
						if (i==0) {
							array_aux.push(talleres[i]);
							html+='<div class="taller" onclick="selectTaller(\''+talleres[i].CODTLL+'\',\''+formatText(talleres[i].DESTLL)+'\')">'+talleres[i].DESTLL+'</div>';					
						}
					}
				}
			}else{
				for (var i = 0; i < talleres.length; i++) {
					if (talleres[i].CODTIPSERV==codtipser) {
						array_aux.push(talleres[i]);
						html+='<div class="taller" onclick="selectTaller(\''+talleres[i].CODTLL+'\',\''+formatText(talleres[i].DESTLL)+'\')">'+talleres[i].DESTLL+'</div>';
					}else{
						if (i==0) {
							array_aux.push(talleres[i]);
							html+='<div class="taller" onclick="selectTaller(\''+talleres[i].CODTLL+'\',\''+formatText(talleres[i].DESTLL)+'\')">'+talleres[i].DESTLL+'</div>';					
						}
					}
				}
			}
			talleres_aux=array_aux;
			$("#spaceTalleres").empty();
			$("#spaceTalleres").append(html);
		}else{
			if (codsede_var!="0") {
				var array_aux=[];
				var html='';
				for (var i = 0; i < talleres.length; i++) {
					if (talleres[i].CODSEDE==codsede_var) {
						array_aux.push(talleres[i]);
						html+='<div class="taller" onclick="selectTaller(\''+talleres[i].CODTLL+'\',\''+formatText(talleres[i].DESTLL)+'\')">'+talleres[i].DESTLL+'</div>';
					}else{
						if (i==0) {
							array_aux.push(talleres[i]);
							html+='<div class="taller" onclick="selectTaller(\''+talleres[i].CODTLL+'\',\''+formatText(talleres[i].DESTLL)+'\')">'+talleres[i].DESTLL+'</div>';					
						}
					}
				}
				talleres_aux=array_aux;
				$("#spaceTalleres").empty();
				$("#spaceTalleres").append(html);
			}else{
				var html='';
				for (var i = 0; i < talleres.length; i++) {
					html+='<div class="taller" onclick="selectTaller(\''+talleres[i].CODTLL+'\',\''+formatText(talleres[i].DESTLL)+'\')">'+talleres[i].DESTLL+'</div>';
				}
				$("#spaceTalleres").empty();
				$("#spaceTalleres").append(html);
			}
		}
		//$("#nombreTaller").keyup();
		$("#nombreTaller").val("(TODOS)");
		codtll_var="0";
	}
}

var codtll_var="";
function selectTaller(codtll,destll){
	if (codsede_var=="") {
		alert("Seleccione una sede primero!");
	}else{
		if (codtipser_var=="") {
			alert("Seleccione un tipo de servicio primero!");
		}else{
			codtll_var=codtll;
			$("#nombreTaller").val(destll);
		}
	}
}

function mostraIndRes(){
	if (codsede_var=="") {
		alert("Seleccione una sede primero!");
	}else{
		if (codtipser_var=="") {
			alert("Seleccione un tipo de servicio primero!");
		}else{
			if (codtll_var=="") {
				alert("Seleccione un taller primero!");
			}else{
				window.location.href="FichasSinTerminar.php?codsede="+codsede_var+"&codtipser="+codtipser_var+
				"&codtll="+codtll_var+"&numdias="+$("#idnumdias").val();//+"&fecha="+document.getElementById("idFecha").value;
			}
		}
	}
}