var sedes=[];
var tipser=[];
var talleres=[];
var talleres_aux=[];
$(document).ready(function(){

    $( "#rango1" ).datepicker({ dateFormat: 'dd-mm-yy' });
    $( "#rango2" ).datepicker({ dateFormat: 'dd-mm-yy' });
    $( "#rango1" ).css("padding","5px");
    $( "#rango2" ).css("padding","5px");
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
			var hoy=dia+"-"+mes+"-"+anio;
			document.getElementById("rango1").value=hoy;
			document.getElementById("rango2").value=hoy;
			document.getElementById("dosrango1").value=hoy;
			document.getElementById("dosrango2").value=hoy;
			document.getElementById("tresrango1").value=hoy;
			document.getElementById("tresrango2").value=hoy;
			$("#dosrango1").attr("disabled",true);
			$("#dosrango2").attr("disabled",true);
			$("#tresrango1").attr("disabled",true);
			$("#tresrango2").attr("disabled",true);

			$(".panelCarga").fadeOut(200);			
		}
	});
	$("#fechas2").click(function(){
		if(state2){
			$("#dosrango1").attr("disabled",true);
			$("#dosrango2").attr("disabled",true);
			state2=false;
		}else{
			$("#dosrango1").attr("disabled",false);
			$("#dosrango2").attr("disabled",false);
			state2=true;
		}
	});
	$("#fechas3").click(function(){
		if(state3){
			$("#tresrango1").attr("disabled",true);
			$("#tresrango2").attr("disabled",true);
			state3=false;
		}else{
			$("#tresrango1").attr("disabled",false);
			$("#tresrango2").attr("disabled",false);
			state3=true;
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
var state2=false;
var state3=false;
var option=1;

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

function mostrarFormato(){
	if (option==1) {
		if (codsede_var=="") {
			alert("Seleccione una sede primero!");
		}else{
			if (codtipser_var=="") {
				alert("Seleccione un tipo de servicio primero!");
			}else{
				if (codtll_var=="") {
					alert("Seleccione un taller primero!");
				}else{
	    			var rango1=$( "#rango1" ).val().split("-");
	    			rango1=rango1[2]+"-"+rango1[1]+"-"+rango1[0];
	    			var rango2=$( "#rango2" ).val().split("-");
	    			rango2=rango2[2]+"-"+rango2[1]+"-"+rango2[0];
					window.location.href="FormatoAudFin.php?codsede="+codsede_var+"&codtipser="+codtipser_var+"&codtll="+codtll_var+
					"&fecini="+rango1+"&fecfin="+rango2+"&option="+option;
				}
			}
		}
	}else{
		if (option==2) {
			if($("#idPedido").val()==""){
				alert("Ingrese un pedido!");
			}else{
    			var rango1=$( "#dosrango1" ).val().split("-");
    			rango1=rango1[2]+"-"+rango1[1]+"-"+rango1[0];
    			var rango2=$( "#dosrango2" ).val().split("-");
    			rango2=rango2[2]+"-"+rango2[1]+"-"+rango2[0];
    			var check2=0;
    			if($("#fechas2").prop("checked")){
    				check2=1;
    			}
    			console.log(check2);
				window.location.href="FormatoAudFin.php?pedido="+$("#idPedido").val()+"&fecini="+rango1+"&fecfin="+rango2+"&option="+option+"&check="+check2;
			}
		}else{
			if($("#idCodFic").val()==""){
				alert("Ingrese una ficha!");
			}else{
    			var rango1=$( "#tresrango1" ).val().split("-");
    			rango1=rango1[2]+"-"+rango1[1]+"-"+rango1[0];
    			var rango2=$( "#tresrango2" ).val().split("-");
    			rango2=rango2[2]+"-"+rango2[1]+"-"+rango2[0];
    			var check3=0;
    			if($("#fechas3").prop("checked")){
    				check3=1;
    			}
    			console.log(check3);
				window.location.href="FormatoAudFin.php?codfic="+$("#idCodFic").val()+"&fecini="+rango1+"&fecfin="+rango2+"&option="+option+"&check="+check3;
			}		
		}
	}
}

function show_option(id){
	var ar=document.getElementsByClassName("filter_option");
	for (var i = 0; i < ar.length; i++) {
		ar[i].classList.remove("filter_active");
	}
	document.getElementById("option"+id).classList.add("filter_active");
	var ar=document.getElementsByClassName("content_filtro");
	for (var i = 0; i < ar.length; i++) {
		ar[i].style.display="none";
	}
	$("#content-option"+id).css("display","block");
	option=id;
}