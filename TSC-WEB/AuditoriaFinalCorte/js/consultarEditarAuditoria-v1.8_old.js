var perfilUsuario=0;
function verificarPerfil(perfil){
	perfilUsuario=perfil;
	$(".panelCarga").fadeOut(100);	
}
var numobs=0;
$(document).ready(function(){
	$(".btnBuscarSpace").click(function(){
		var codfic=document.getElementById("idCodFicha").value;
		if (codfic=="") {
			alert("Escriba el código de ficha!");
		}else{
			$("#idContentForFicha").css("display","none");
			$("#idTblDefectos").empty();
			$(".msgForFichas").empty();
			$(".msgForFichas").css("display","none");
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				url:"config/getFichaAudCor.php",
				data:{
					codfic:codfic
				},
				success:function(data){
					$("#idTblFichas").empty();
					$("#idContentTblFichas").css("display","none");
					console.log(data);
					if (data.state==true) {
						if (data.fichas.length==0) {
							$(".msgForFichas").append("No se encontro la ficha!");
							$(".msgForFichas").css("display","block");
							$("#lblCanFic").css("display","none");
						}else{
							$("#lblCanFic").css("display","block");
							$("#idCanFic").text(data.fichas[0].CANTIDAD);
							var htmlFichas="";
							for (var i = 0; i < data.fichas.length; i++) {
								var fecha=new Date(data.fichas[i].FECINIAUD);
								var dia=fecha.getDate()+"";
								if(dia.length==1){
									dia="0"+dia;
								}
								var mes=(fecha.getMonth()+1)+"";
								if(mes.length==1){
									mes="0"+mes;
								}
								var hoy=dia+"/"+mes+"/"+fecha.getFullYear();
								var resul="";
								if (data.fichas[i].RESULTADO=="A") {
									resul="APROB.";
								}else{
									resul="RECHAZ.";
								}
								htmlFichas+=
								'<div class="tblLine" onclick="fichaSelectedForConsulta('+data.fichas[i].CODFIC+',\''+
									data.fichas[i].AQL+'\','+
									data.fichas[i].CODAQL+','+
									data.fichas[i].CODTAD+','+
									data.fichas[i].NUMVEZ+','+
									data.fichas[i].PARTE+')">';
									/*
								if (data.fichas[i].TIPAUD='M') {
									htmlFichas+='<div class="itemBody" style="width: 27%;">Final costura</div>';
								}else{
									htmlFichas+='<div class="itemBody" style="width: 27%;">Otra auditoria</div>';
								}*/
								htmlFichas+=
									'<div class="itemBody" style="width: 27%;">'+data.fichas[i].CODUSU+'</div>'+
									'<div class="itemBody" style="width: 13%;">'+data.fichas[i].PARTE+'</div>'+
									'<div class="itemBody" style="width: 10%;">'+data.fichas[i].NUMVEZ+'</div>'+
									'<div class="itemBody" style="width: 10%;">'+data.fichas[i].CANPAR+'</div>'+
									//'<div class="itemBody" style="width: 25%;">'+hoy+'</div>'+
									'<div class="itemBody" style="width: 20%;">'+data.fichas[i].FECINIAUD+'</div>'+									
									'<div class="itemBody" style="width: 20%;">'+resul+'</div>'+
								'</div>';
							}
							$("#idTblFichas").append(htmlFichas);			
							$("#idContentTblFichas").css("display","block");
						}
						$(".panelCarga").fadeOut(100);
					}else{
						alert(data.detail);
						$(".panelCarga").fadeOut(100);
					}
				}
			});
		}
	});
	if (codfic!="") {
		$(".btnBuscarSpace").click();
		$(".panelCarga").fadeIn(100);
	}
	$(".contentEditar").click(function(e){
		e.stopPropagation();
	});
	$(".editarDefectos").click(function(){
		cerrarMenuDefecto();
	});
});

var afClassName="";
var afcodfic=0;
var afcodtad=0;
var afnumvez=0;
var afparte=0;
var afcoddef=0;
var afcodope=0;
var afcandef=0;
function animarFondo(dom,codfic,codtad,numvez,parte,coddef,codope,candef){
	afClassName=dom.className;
	var arrayClassName=document.getElementsByClassName(afClassName);
	for (var i = 0; i < arrayClassName.length; i++) {
		arrayClassName[i].style.background="white";
	}
	dom.style.background="#ccc";
	var bottom=dom.getBoundingClientRect().bottom;
	var right=dom.getBoundingClientRect().right;
	$(".opcionesDefecto").css("top",bottom+"px");
	$(".opcionesDefecto").css("right","10px");
	$(".opcionesDefecto").css("display","flex");
	afcodfic=codfic;
	afcodtad=codtad;
	afnumvez=numvez;
	afparte=parte;
	afcoddef=coddef;
	afcodope=codope;
	afcandef=candef;
}

function abrirMenuDefecto(){
	$(".panelCarga").fadeIn(300);
	$("#selectForDefectos").empty();
	$("#selectForOperaciones").empty();
	if (defectos.length!=0) {
		var htmlDefectos="";
		for (var i = 0;i<defectos.length; i++) {
			htmlDefectos+='<option value="'+defectos[i].coddef+'">'+defectos[i].desdef+'</option>';
		}
		$("#selectForDefectos").append(htmlDefectos);
		/*		
		var htmlOperaciones="";
		for (var i = 0;i<operaciones.length; i++) {
			htmlOperaciones+='<option value="'+operaciones[i].codope+'">'+operaciones[i].desope+'</option>';
		}
		$("#selectForOperaciones").append(htmlOperaciones);*/
		$("#idCantDefectos").val(afcandef);
		$("#selectForDefectos").val(afcoddef);
		$("#selectForOperaciones").val(afcodope);
		$(".editarDefectos").css("display","block");
		$(".panelCarga").fadeOut(300);
	}else{
		$.ajax({
			type:"POST",
			url:"config/getDefectoOperacion.php",
			data:{
				onlydefect:1
			},
			success:function(data){
				//console.log(data);
				var htmlDefectos="";
				defectos=data.defectos;
				operaciones=data.operaciones;
				for (var i = 0;i<data.defectos.length; i++) {
					htmlDefectos+='<option value="'+data.defectos[i].CODDEF+'">'+data.defectos[i].DESDEF+'</option>';
				}
				$("#selectForDefectos").append(htmlDefectos);
				/*		
				var htmlOperaciones="";
				for (var i = 0;i<data.operaciones.length; i++) {
					htmlOperaciones+='<option value="'+data.operaciones[i].codope+'">'+data.operaciones[i].desope+'</option>';
				}
				$("#selectForOperaciones").append(htmlOperaciones);*/
				$("#idCantDefectos").val(afcandef);
				$("#selectForDefectos").val(afcoddef);
				$("#selectForOperaciones").val(afcodope);
				$(".editarDefectos").css("display","block");
				$(".panelCarga").fadeOut(300);
			}
		});
	}
}

function cerrarMenuDefecto(){
	$(".editarDefectos").css("display","none");
}

function editarDefecto(action){
	$(".panelCarga").fadeIn(200);
	$.ajax({
		type:"POST",
		url:"config/gestionDefectos.php",
		data:{			
			option:action,
			codfic:fsfccodfic,
			codtad:fsfccodtad,
			numvez:fsfcnumvez,
			parte:fsfcparte,
			coddef:afcoddef,
			codope:0,//afcodope,
			codaql:fsfccodaql,
			candef:$("#idCantDefectos").val(),
			newcoddef:$("#selectForDefectos").val(),
			newcodope:0//$("#selectForOperaciones").val()
		},
		success:function(data){
			console.log(data);
			if (data.state==true) {
				$(".btnBuscarSpace").click();
				//fichaSelectedForConsulta(fsfccodfic,fsfcaql,fsfccodaql,fsfccodtad,fsfcnumvez,fsfcparte,fsfctipaud);	
			}else{
				alert(data.error.state+" Revise que no se repita defecto / operacion!");
			}
			cerrarMenuDefecto();
			closeOpcionesDefecto();
			$(".panelCarga").fadeOut(200);
		}
	});
}

function newdefecto(){
	$(".panelCarga").fadeIn(300);
	$("#selectForDefectos").empty();
	$("#selectForOperaciones").empty();
	if (defectos.length!=0) {
		var htmlDefectos="";
		for (var i = 0;i<defectos.length; i++) {
			htmlDefectos+='<option value="'+defectos[i].CODDEF+'">'+defectos[i].DESDEF+'</option>';
		}
		$("#selectForDefectosNew").append(htmlDefectos);
		/*
		var htmlOperaciones="";
		for (var i = 0;i<operaciones.length; i++) {
			htmlOperaciones+='<option value="'+operaciones[i].codope+'">'+operaciones[i].desope+'</option>';
		}
		$("#selectForOperacionesNew").append(htmlOperaciones);*/
		$(".agregarDefectos").css("display","block");
		$(".panelCarga").fadeOut(300);
	}else{
		$.ajax({
			type:"POST",
			url:"config/getDefectoOperacion.php",
			data:{

			},
			success:function(data){
				var htmlDefectos="";
				defectos=data.defectos;
				operaciones=data.operaciones;
				for (var i = 0;i<data.defectos.length; i++) {
					htmlDefectos+='<option value="'+data.defectos[i].CODDEF+'">'+data.defectos[i].DESDEF+'</option>';
				}
				$("#selectForDefectosNew").append(htmlDefectos);
				/*	
				var htmlOperaciones="";
				for (var i = 0;i<data.operaciones.length; i++) {
					htmlOperaciones+='<option value="'+data.operaciones[i].codope+'">'+data.operaciones[i].desope+'</option>';
				}
				$("#selectForOperacionesNew").append(htmlOperaciones);*/
				$(".agregarDefectos").css("display","block");
				$(".panelCarga").fadeOut(200);
			}
		});
	}
}
var defectos=[];
var operaciones=[];

function cerrarMenuDefectoNew(){
	$(".agregarDefectos").fadeOut(200);
}

function guardarDefecto(){
	$(".panelCarga").fadeIn(200);
	$.ajax({
		type:"POST",
		url:"config/guardarNuevoDefecto.php",
		data:{						
			codfic:fsfccodfic,
			codtad:fsfccodtad,
			numvez:fsfcnumvez,
			parte:fsfcparte,
			coddef:$("#selectForDefectosNew").val(),
			codope:0,//$("#selectForOperacionesNew").val(),
			codaql:fsfccodaql,
			candef:$("#idCantDefectosNew").val(),
		},
		success:function(data){
			console.log(data);
			if (data.state==true) {
				$(".btnBuscarSpace").click();	
			}else{
				alert(data.error.state+" Revise que no se repita defecto!");
			}
			cerrarMenuDefectoNew();
			$(".panelCarga").fadeOut(200);
		}
	});
}

function borrarDefecto(action){
	$(".panelCarga").fadeIn(300);
	$.ajax({
		type:"POST",
		url:"config/gestionDefectos.php",
		data:{			
			option:action,
			codfic:fsfccodfic,
			codtad:fsfccodtad,
			numvez:fsfcnumvez,
			parte:fsfcparte,
			codaql:fsfccodaql,
			coddef:afcoddef,
			codope:afcodope
		},
		success:function(data){
			console.log(data);
			if (data.state==true) {
				$(".btnBuscarSpace").click();
				//fichaSelectedForConsulta(fsfccodfic,fsfcaql,fsfccodaql,fsfccodtad,fsfcnumvez,fsfcparte,fsfctipaud);	
			}else{
				alert(data.error.state);
			}
			closeOpcionesDefecto();
			$(".panelCarga").fadeOut(300);
		}
	});
}

function closeOpcionesDefecto(){
	$(".opcionesDefecto").css("display","none");
	var arrayClassName=document.getElementsByClassName(afClassName);
	for (var i = 0; i < arrayClassName.length; i++) {
		arrayClassName[i].style.background="white";
	}
}

var fsfccodfic=0;
var fsfcaql=0;
var fsfccodaql=0;
var fsfccodtad=0;
var fsfcnumvez=0;
var fsfcparte=0;
var canpar_var=0;
function anular_ficha(){
	$(".panelCarga").fadeIn(300);
	$.ajax({
		type:"POST",
		url:"config/anularFicha.php",
		data:{
			codfic:fsfccodfic,
			parte:fsfcparte,
			numvez:fsfcnumvez
		},
		success:function(data){
			console.log(data);
			alert(data.detail);
			if (data.state) {
				window.location.reload();
			}else{
				$(".panelCarga").fadeOut(300);
			}
		}
	});
}

var numobs=0;
function fichaSelectedForConsulta(codfic,aql,codaql,codtad,numvez,parte){
	fsfccodfic=codfic;
	fsfcaql=aql;
	fsfccodaql=codaql;
	fsfccodtad=codtad;
	fsfcnumvez=numvez;
	fsfcparte=parte;
	$("#idContentForFicha").css("display","none");
	$("#idTblDefectos").empty();
	$("#msgForDefectos").css("display","none");
	$(".panelCarga").fadeIn(300);
	$.ajax({
		type:"POST",
		url:"config/getFichaDetalleConsulta.php",
		data:{
			codfic:codfic,
			codtad:codtad,
			numvez:numvez,
			parte:parte,
			codaql:codaql
		},
		success:function(data){
			console.log(data);
			
			if(data.state==true){
				var html='';
				numobs=data.obs.length;
				for (var i = 0; i < data.obs.length; i++) {
					html+=
					'<div class="sameline line-for-obs" id="lineobs'+data.obs[i].SEC+'">'+
						'<div style="width:calc(100% - 54px);" id="obs'+data.obs[i].SEC+'">'+data.obs[i].SEC+'. '+data.obs[i].OBS+'</div>'+
						'<div style="width:calc(54px);display:flex;">'+
							'<button class="solocorte" style="width:27px;" onclick="edit_obs('+data.obs[i].SEC+',\''+data.obs[i].OBS+'\')"><i class="fa fa-pencil" aria-hidden="true"></i></button>'+
							'<button class="solocorte" style="width:27px;" onclick="delete_obs('+data.obs[i].SEC+')"><i class="fa fa-trash" aria-hidden="true"></i></button>'+
						'</div>'+
					'</div>';
				}
				$("#tblObservaciones").empty();
				$("#tblObservaciones").append(html);

				canpar_var=parseInt(data.ficha.CANPAR);
				$("#idcanpar").text(canpar_var);
				if (data.ficha.RESULTADO!="A") {
					$("#btnClasiRecu").css("display","none");
				}else{
					$("#btnClasiRecu").css("display","block");
				}
				document.getElementById("linkaudprocor").innerHTML='<a href="../auditoriaprocesocorte/ConsultarEditarAuditoria.php?codfic='+
				codfic+'">Aud. Proceso de Corte</a>';
				document.getElementById("idCliente").innerHTML=data.partida.descli;
				if (data.DESCEL=="") {
					document.getElementById("idNombreTaller").innerHTML=data.ficha.DESTLL;	
				}else{
					document.getElementById("idNombreTaller").innerHTML=data.ficha.DESTLL+" - "+data.DESCEL;
				}
				document.getElementById("idNombreTaller").innerHTML=data.ficha.DESTLL;
				document.getElementById("idPedido").innerHTML=data.ficha.PEDIDO;
				document.getElementById("idesttsc").innerHTML=data.ficha.ESTTSC;
				document.getElementById("idestcli").innerHTML=data.ficha.ESTCLI;
				if (data.partida.partida!=undefined) {
					if (data.partida.numvez==null) {
						document.getElementById("idpartida").innerHTML=data.partida.partida;
					}else{
						document.getElementById("idpartida").innerHTML=
						'<a href="../Auditoriatela/VerAuditoriaTela.php?partida='+data.partida.partida+
						'&codtel='+data.partida.codtel+'&codprv='+data.partida.codprv+
						'&numvez='+data.partida.numvez+'&parte='+data.partida.parte+
						'&codtad='+data.partida.codtad+'">'+data.partida.partida+'</a>';
					}
				}else{
					document.getElementById("idpartida").innerHTML="";
				}			
				if (data.partida.color!=undefined) {
					document.getElementById("idcolor").innerHTML=data.partida.color;
				}else{
					document.getElementById("idcolor").innerHTML="";
				}				
				if (data.partida.tiptel!=undefined) {
					document.getElementById("idtiptel").innerHTML=data.partida.tiptel;
				}else{
					document.getElementById("idtiptel").innerHTML="";
				}
				if (data.ficha.CANPRE!=data.ficha.CANPAR) {
					document.getElementById("idCantPrendas").innerHTML=data.ficha.CANPAR+" de "+data.ficha.CANPRE;
				}else{
					document.getElementById("idCantPrendas").innerHTML=data.ficha.CANPAR;
				}
				if (data.ficha.COMENTARIOS=="aql") {
					document.getElementById("idMuestreo").innerHTML=(data.ficha.COMENTARIOS).toUpperCase()+" "+data.ficha.AQL+"%";
				}else{
					document.getElementById("idMuestreo").innerHTML=(data.ficha.COMENTARIOS).toUpperCase();
				}
				document.getElementById("idNumPrendasAuditar").innerHTML="("+data.ficha.CANAUD+" prendas)";
				if (data.defectos.length==0) {
					$("#msgForDefectos").css("display","block");
					$("#tblContentDefectos").css("display","none");
				}else{					
					$("#tblContentDefectos").css("display","block");
					var htmlDefectos="";
					var sumaDefectos=0;
					for (var i = 0; i < data.defectos.length; i++) {
						//LOS AUDITORES PUEDEN EDITAR LOS DEFECTOS
						if (perfilUsuario==3 || perfilUsuario=="3") {
							htmlDefectos+=
							'<div class="tblLine lineDefectos" onclick="animarFondo(this,'+
							codfic+','+
							codtad+','+
							numvez+','+
							parte+','+
							data.defectos[i].coddef+','+
							data.defectos[i].codope+','+
							data.defectos[i].candef+')">'+
								'<div class="itemBody" style="width: 80%;">'+data.defectos[i].desdef+'</div>'+
								/*
								'<div class="itemBody" style="width: 40%;">'+data.defectos[i].desope+'</div>'+*/
								'<div class="itemBody" style="width: 20%;">'+data.defectos[i].candef+'</div>'+
							'</div>';	
						}else{
							htmlDefectos+=
							'<div class="tblLine lineDefectos">'+
								'<div class="itemBody" style="width: 80%;">'+data.defectos[i].desdef+'</div>'+
								/*
								'<div class="itemBody" style="width: 40%;">'+data.defectos[i].desope+'</div>'+*/
								'<div class="itemBody" style="width: 20%;">'+data.defectos[i].candef+'</div>'+
							'</div>';
						}						
						sumaDefectos+=parseInt(data.defectos[i].candef);
					}
					if (perusu_var!="2") {
						$("#btnanular").remove();
					}
					htmlDefectos+=
						'<div class="tblLine finalPartTbl">'+
							'<div class="itemBody" style="width: 80%;">TOTAL</div>'+
							'<div class="itemBody" style="width: 20%;">'+sumaDefectos+'</div>'+
						'</div>';
				}
				$("#idTblDefectos").append(htmlDefectos);
				$("#idContentForFicha").css("display","block");

				/*FICHA TALLAS*/
				var cantidadAuditar=parseInt(data.ficha.CANAUD);
				var totalAuditar=parseInt(data.ficha.CANPRE);
				var htmlDefectos="";
				$("#idTblTallas").empty();
				var sumaCorregidora=0;
				for(var i=0;i<data.fichatallas.length;i++){
					var canXtalla=0;
					canXtalla=Math.round(data.fichatallas[i]["CANPRE"]*cantidadAuditar/totalAuditar);
					if (i==data.fichatallas.length-1) {
						canXtalla=cantidadAuditar-sumaCorregidora;
					}else if(i==data.fichatallas.length-2){
						//canXtalla=cantidadAuditar-sumaCorregidora-Math.round(data.fichatallas[i]["canpre"]*cantidadAuditar/totalAuditar);
						var valorCorrector=cantidadAuditar-Math.round(data.fichatallas[i]["CANPRE"]*cantidadAuditar/totalAuditar)-sumaCorregidora;
						if (valorCorrector<0) {
							canXtalla=canXtalla+valorCorrector;
						}					
						sumaCorregidora+=canXtalla;
					}else{
						sumaCorregidora+=canXtalla;
					}
					htmlDefectos+=
						'<div class="tblLine">'+
							'<div class="itemBody" style="width: 50%;">'+data.fichatallas[i]["DESTAL"]+'</div>'+
							'<div class="itemBody" style="width: 50%;">'+Math.round(canXtalla)+'</div>'+
						'</div>';
				}
				htmlDefectos+=
					'<div class="tblLine finalPartTbl">'+
						'<div class="itemBody" style="width: 50%;">TOTAL</div>'+
						'<div class="itemBody" style="width: 50%;">'+cantidadAuditar+'</div>'+
					'</div>';
				$("#idTblTallas").append(htmlDefectos);
				$(".panelCarga").fadeOut(300);
			}


			// SOLO CORTE
			solocorte();
		}
	});
}

function backToMain(){
	window.location.href="main.php";
}

function clasiRecuperacion(){
	$(".panelCarga").fadeIn(200);
	$.ajax({
		type:"POST",
		url:"config/getClasiRecu.php",
		data:{
			codfic:fsfccodfic,
			codtad:fsfccodtad,
			parte:fsfcparte,
			numvez:fsfcnumvez
		},
		success:function(data){
			console.log(data);
			$("#idBtnRegClasiRecu").css("display","block");
			var f=new Date();			
			var dia=f.getDate()+"";
			if(dia.length==1){
				dia="0"+dia;
			}
			var mes=(f.getMonth()+1)+"";
			if(mes.length==1){
				mes="0"+mes;
			}
			var hoy=dia+"/"+mes+"/"+(f.getFullYear()-2000);
			$("#idInfoRegister").empty();
			if (data.fechaReg!=null) {
				$("#idInfoRegister").text("Registrado el "+data.fechaReg);
				if (data.fechaReg!=hoy) {
					$("#idBtnRegClasiRecu").css("display","none");
				}
			}
			var html="";
			for (var i = 0; i < data.clarec.length; i++) {
				html+=
					'<div class="sameline" style="width: 100%;margin-bottom: 5px;">'+
						'<div class="lbl" style="margin: 0px;width: 50%;font-size: 12px;">'+data.clarec[i].DESCLAREC+'</div>'+
						'<input type="number" data-idClaRec="'+data.clarec[i].CODCLAREC+'" class="iptNumber classClaRec" style="width: 50%;margin: 0px;" value="'+data.clarec[i].CANPRE+'">'+
					'</div>';
			}
			html+='<div class="lineDecoration"></div>'+
				'<div class="sameline" style="width: 100%;margin-bottom: 5px;">'+
					'<div class="lbl" style="margin: 0px;width: 50%">TOTAL</div>'+
					'<input type="number" id="idClaRecTotal" class="iptNumber" style="width: 50%;margin: 0px;" value="'+data.total+'" disabled>'+
				'</div>';
			$("#placeClaRec").empty();
			$("#placeClaRec").append(html);
			$(".contentClasiRecu").fadeIn(200);
			$(".panelCarga").fadeOut(200);
		}
	});
}

function cerrarClasiRecu(){
	$(".contentClasiRecu").fadeOut(200);	
}

function saveClasiRecu(){
	var totalClaRec=$("#idClaRecTotal").val();
	var arrayClaRec=document.getElementsByClassName("classClaRec");
	var arrayToSave=[];
	var sumtotal=0;
	for (var i = 0; i < arrayClaRec.length; i++) {
		var aux=[];
		aux.push(arrayClaRec[i].dataset.idclarec);
		aux.push(arrayClaRec[i].value);
		sumtotal+=parseInt(arrayClaRec[i].value);
		arrayToSave.push(aux);
	}
	$("#idClaRecTotal").val(sumtotal);
	if (sumtotal!=canpar_var) {
		alert("La cantidad parte de la ficha es "+canpar_var+"!");
	}else{
		$(".panelCarga").fadeIn(200);
		$.ajax({
			type:"POST",
			url:"config/saveClasiRecu.php",
			data:{
				codfic:fsfccodfic,
				codtad:fsfccodtad,
				parte:fsfcparte,
				numvez:fsfcnumvez,
				canpre:sumtotal,
				codusu:codusu_var,
				array:arrayToSave
			},
			success:function(data){
				console.log(data);
				if (data.state==true) {
					alert("Clasificacion guardada!");
				}
				cerrarClasiRecu();
				$(".panelCarga").fadeOut(200);
			}
		});
	}
}

function show_panel_obs(){
	$("#modal-1").css("display","block");
}

function hide_modal(id){
	$("#"+id).css("display","none");
}

const max_tam=250;
function save_observacion(){
	if ($("#idTextObs").val().length<max_tam) {		
		$(".panelCarga").fadeIn(100);
		$.ajax({
			type:"POST",
			data:{
				codfic:fsfccodfic,
				codtad:fsfccodtad,
				parte:fsfcparte,
				numvez:fsfcnumvez,
				obs:$("#idTextObs").val()
			},
			url:"config/saveObservacionFicCor.php",
			success:function(data){
				console.log(data);
				var html='';
				if(!data.state){
					alert(data.description);
				}else{
					numobs++;
					html+=
					'<div class="sameline line-for-obs" id="lineobs'+numobs+'">'+
						'<div style="width:calc(100% - 54px);" id="obs'+numobs+'">'+numobs+'. '+$("#idTextObs").val()+'</div>'+
						'<div style="width:calc(54px);display:flex;">'+
							'<button class="solocorte" style="width:27px;" onclick="edit_obs('+numobs+',\''+$("#idTextObs").val()+'\')"><i class="fa fa-pencil" aria-hidden="true"></i></button>'+
							'<button class="solocorte" style="width:27px;" onclick="delete_obs('+numobs+')"><i class="fa fa-trash" aria-hidden="true"></i></button>'+
						'</div>'+
					'</div>';
					$("#tblObservaciones").append(html);
				}
				hide_modal('modal-1');
				$(".panelCarga").fadeOut(100);

				// SOLO CORTE
				solocorte();
			}
		});
	}else{
		alert("El texto debe ser menor a "+max_tam+" caracteres!");
	}
}


function delete_obs(id){
	var c=confirm("Seguro que desea eliminar la observación "+id+"?");
	if (c) {		
		$(".panelCarga").fadeIn(100);
		$.ajax({
			type:"POST",
			data:{
				codfic:fsfccodfic,
				codtad:fsfccodtad,
				parte:fsfcparte,
				numvez:fsfcnumvez,
				sec:id
			},
			url:"config/deleteObservacionFicCor.php",
			success:function(data){
				console.log(data);
				if(!data.state){
					alert(data.description);
				}else{
					$("#lineobs"+id).remove();
				}
				$(".panelCarga").fadeOut(100);
			}
		});
	}
}

var id_send;
function edit_obs(id,obs){
	id_send=id;
	$("#idTextObsEdit").val(obs);
	$("#modal-2").css("display","block");
}

function save_edit_observacion(){
	if ($("#idTextObsEdit").val().length<max_tam) {		
		$(".panelCarga").fadeIn(100);
		$.ajax({
			type:"POST",
			data:{
				codfic:fsfccodfic,
				codtad:fsfccodtad,
				parte:fsfcparte,
				numvez:fsfcnumvez,
				sec:id_send,
				obs:$("#idTextObsEdit").val()
			},
			url:"config/editObservacionFicCor.php",
			success:function(data){
				console.log(data);
				if(!data.state){
					alert(data.description);
				}else{
					$("#obs"+id_send).empty();
					$("#obs"+id_send).append(id_send+". "+$("#idTextObsEdit").val());
				}
				hide_modal('modal-2');
				$(".panelCarga").fadeOut(100);
			}
		});
	}else{
		alert("El texto debe ser menor a "+max_tam+" caracteres!");
	}
}


function RegistrarMedidas(){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		url:'config/agregado/getEncogimiento.php',
		type:'POST',
		data:'codfic='+fsfccodfic,
		success:function(e){
			//if(e != ""){
				$("#DivContenido").removeClass("d-none");
				$("#DivContenido").html(e);
				/*
			}else{
				$("#DivContenido").addClass("d-none");
				window.location.href="RegistrarMedidasAudFinCor.php?codfic="+codFicha;
			}*/
			$(".panelCarga").fadeOut(100);
		}
	});
}

function solocorte(){
	if(SOLOCORTE){
		$(".solocorte").addClass("d-none");
	}else{
		$(".solocorte").removeClass("d-none");
	}
}