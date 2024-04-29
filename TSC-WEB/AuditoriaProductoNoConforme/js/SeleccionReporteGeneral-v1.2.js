function formatText(string){
	while(string.indexOf('"')>0){
		string=string.replace('"','');
	}
	return string;
}

var listaAuditores=[];
var sedes=[];
var tipser=[];
var talleres=[];
var talleres_aux=[];
function getTalleres(){
	$.ajax({
		type:"POST",
		url:"config/getInfoResultados.php",
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
			$("#nombreAuditor").val("(TODOS)");
			codsede_var="0";
			codtipser_var="0";
			codtll_var="0";
			codusu="0";


			var htmlTalleres="";
			
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
			$("#idTipoAuditoria").val(30);
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
			$(".panelCarga").fadeOut(200);
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

function mostraDatos(){
	var tipo="1";
	if (document.getElementById("tipo2").checked) {
		tipo="2";
	}else{
		if (document.getElementById("tipo3").checked) {
			tipo="3";
		}
	}
	if (opcion_rep==1) {
		var fecini=document.getElementById("idFechaDesde").value;
		var fecfin=document.getElementById("idFechaHasta").value;
		window.location.href="ReporteGeneral.php?fecini="+fecini+"&fecfin="+fecfin+"&tipo="+tipo+"&codsede="+codsede_var+"&codtipser="+codtipser_var;
	}else{
		if (document.getElementById("pedido").value=="") {
			alert("Debe agregar un pedido correcto");
			return;
		}
		if (color_var=='') {
			alert("Color incorrecto");
			return;
		}else{
			window.location.href="ReporteGeneral2.php?pedido="+document.getElementById("pedido").value+
			"&dsccol="+color_var+"&tipo="+tipo;
		}
	}
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


	$(".checkDetect").click(function(){
		var arrays=document.getElementsByClassName("checkDetect");
		for (var i=0;i<arrays.length;i++){
			arrays[i].checked=false;
		}
		this.checked=true;
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
	$("#color").keyup(function(){
		color_var=''
		$("#spaceColor").empty();
		var html="";
		var busqueda=document.getElementById("color").value;
		for (var i = 0; i < colores.length; i++) {
			//console.log(colores[i][1].toUpperCase());
			if ((colores[i][1].toUpperCase()).indexOf(busqueda.toUpperCase())>=0) {
				html+='<div class="taller" onclick="selectcolor(\''+colores[i][0]+'\',\''+colores[i][1]+'\')">'+colores[i][1]+'</div>';
			}
		}
		$("#spaceColor").append(html);
	});
});

var colores=[];
function search_color(){	
	if ($("#pedido").val()=="") {
		alert("Complete el pedido");
		return;
	}
	$(".panelCarga").fadeIn(200);
	document.getElementById("content-color").style.display="none";
	$.ajax({
		type:"POST",
		url:"config/getColXPedAPNC.php",
		data:{
			pedido:$("#pedido").val()
		},
		success:function(data){
			console.log(data);
			if (data.state) {
				colores=[];
				colores.push(["0","(TODOS)"]);
				var html='';
				html+='<div class="taller" onclick="selectcolor(\'0\',\'(TODOS)\')">(TODOS)</div>';
				for (var i = 0; i < data.colores.length; i++) {
					html+='<div class="taller" onclick="selectcolor(\''+data.colores[i].DSCCOL+'\',\''+data.colores[i].DSCCOL+'\')">'+data.colores[i].DSCCOL+'</div>';
					colores.push([data.colores[i].DSCCOL,data.colores[i].DSCCOL]);
				}
				$("#spaceColor").empty();
				$("#spaceColor").append(html);
				document.getElementById("content-color").style.display="block";
				document.getElementById("color").value="(TODOS)";
				color_var='0';
			}else{
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(200);
		}
	});
}

var opcion_rep=1;
function select_opc(dom,id){
	let ar=document.getElementsByClassName("label-opc");
	for (var i = 0; i < ar.length; i++) {
		ar[i].classList.remove("opc-active");
	}
	dom.classList.add("opc-active");
	if (id==1) {
		document.getElementById("opc2").style.display="none";
		document.getElementById("opc1").style.display="block";
		document.getElementById("opcion-resumen").style.display="none";
		document.getElementById("tipo1").checked=true;
		opcion_rep=1;
	}else{
		document.getElementById("opc1").style.display="none";
		document.getElementById("opc2").style.display="block";
		document.getElementById("opcion-resumen").style.display="flex";
		opcion_rep=2;
	}
}

var color_var='';
function selectcolor(codcol,dsccol){
	color_var=codcol;
	document.getElementById("color").value=dsccol;
}

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