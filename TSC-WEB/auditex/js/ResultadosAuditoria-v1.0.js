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
var clientes = [];
var codcliente;
var descripcioncliente;
var pedido;
var color;
var po;


function getTalleres(){
	$.ajax({
		type:"POST",
		url:"config/getInfoResultados.php",
		data:{
			request:"1"
		},
		success:function(data){
			console.log(data);

			// CLIENTES
			clientes = data.clientes;
			var html = "";
			for(let item of clientes){
				html+='<div class="cliente" onclick="selectCliente(\''+item.CODCLI+'\',\''+formatText(item.DESCLI)+'\')">'+item.DESCLI+'</div>';
			}

			$("#spaceClientes").empty();
			$("#spaceClientes").append(html);

			// SEDES
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
			$("#nombreCliente").val("(TODOS)");

			codsede_var="0";
			codtipser_var="0";
			codtll_var="0";
			codusu="0";
			codcliente = "0";
			descripcioncliente = "";
			pedido = "";
			color = "";



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
			$("#idTipoAuditoria").val(10);
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

function mostraDatos() {
	var mensaje="";
	if (codtll==0) {
		mensaje+="Se mostrarán todos los talleres";
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
	var codtad=document.getElementById("idTipoAuditoria").value;
	var fecini=document.getElementById("idFechaDesde").value;
	var fecfin=document.getElementById("idFechaHasta").value;

	var tipgra="";

	color = document.getElementById("nombreColor").value;
	pedido = document.getElementById("nombrePedido").value;
	po = document.getElementById("nombrePo").value;



	if (document.getElementById("idGrafico").checked) {
		tipgra="grafico";
	}else{
		tipgra="datos";
	}


	// window.location.href="ResultadosDatos.php?codusu="+codusu+"&codtad="+codtad+
	// "&fecini="+fecini+"&fecfin="+fecfin+"&tipgra="+tipgra+"&codsede="+codsede_var+"&codtipser="+codtipser_var+"&codtll="+codtll_var+
	// "&codcliente="+codcliente+"&pedido="+pedido+"&color="+color+"&descripcioncliente="+descripcioncliente+"&po="+po;

	let dessede = $("#nombreSede").val();
	let destiposervicio = $("#nombreTipoSer").val();
	let destaller = $("#nombreTaller").val();
	let desusu = $("#nombreAuditor").val();
	let desauditoria = $( "#idTipoAuditoria option:selected" ).text();

	let ruta = `
		ResultadosDatos.php?
		codusu=${codusu}&desusu=${desusu}&
		codtad=${codtad}&
		fecini=${fecini}&
		fecfin=${fecfin}&
		tipgra=${tipgra}&
		codsede=${codsede_var}&dessede=${dessede}&
		codtipser=${codtipser_var}&destiposervicio=${destiposervicio}&
		codtll=${codtll_var}&destaller=${destaller}&
		codcliente=${codcliente}&
		pedido=${pedido}&
		color=${color}&
		descripcioncliente=${descripcioncliente}&
		po=${po}&desauditoria=${desauditoria}
	`;

	window.location.href  = ruta;


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

	$("#nombreCliente").keyup(function(){
		$(".listaCliente").empty();
		var html="";
		var busqueda=document.getElementById("nombreCliente").value;

		for(let item of clientes){
			if ((item.DESCLI.toUpperCase()).indexOf(busqueda.toUpperCase())>=0) {				
				// html+='<div class="cliente" onclick="selectCliente(\''+item.CODCLI+'\','+item.DESCLI+')">'+item.DESCLI+"</div>";
				html+='<div class="cliente" onclick="selectCliente(\''+item.CODCLI+'\',\''+formatText(item.DESCLI)+'\')">'+item.DESCLI+'</div>';

			}

		}

		$(".listaCliente").append(html);


		// for (var i = 0; i < listaAuditores[0].length; i++) {
		// 	//console.log(listaTalleres[0][i].DESTLL.toUpperCase());
		// 	if ((listaAuditores[0][i].NOMUSU.toUpperCase()).indexOf(busqueda.toUpperCase())>=0) {				
		// 		htmlTalleres+='<div class="taller" onclick="addAuditor(\''+listaAuditores[0][i].NOMUSU+'\','+listaAuditores[0][i].CODUSU+')">'+listaAuditores[0][i].NOMUSU+"</div>";
		// 	}
		// }
		// $(".listaAuditores").append(htmlTalleres);
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

// var codtll_var="";
function selectCliente(codcli,descli){
	// if (codsede_var=="") {
	// 	alert("Seleccione una sede primero!");
	// }else{
		// if (codtipser_var=="") {
		// 	alert("Seleccione un tipo de servicio primero!");
		// }else{
			codcliente=codcli;
			descripcioncliente = descli;
			$("#nombreCliente").val(descli);
		// }
	// }
}
