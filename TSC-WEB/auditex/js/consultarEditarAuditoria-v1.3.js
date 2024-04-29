var perfilUsuario=0;
function verificarPerfil(perfil){
	perfilUsuario=perfil;
}

$(document).ready(function(){
	$(".panelCarga").fadeOut(100);	
	$(".btnBuscarSpace").click(function(){
		var codfic=document.getElementById("idCodFicha").value;
		if (codfic=="") {
			alert("Escriba el código de ficha!");
		}else{
			$("#idContentForFicha").css("display","none");
			$("#idTblDefectos").empty();
			$(".msgForFichas").empty();
			$(".msgForFichas").css("display","none");
			$(".panelCarga").fadeIn(300);
			$.ajax({
				type:"POST",
				url:"config/getFicha.php",
				data:{
					codfic:codfic,
					typeRequest:2
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
						$(".panelCarga").fadeOut(300);
					}else{
						alert(data.error.detail);
						$(".panelCarga").fadeOut(300);
					}
				}
			})
		}
	});
	if (codfic!="") {
		$(".btnBuscarSpace").click();
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
		var htmlOperaciones="";
		for (var i = 0;i<operaciones.length; i++) {
			htmlOperaciones+='<option value="'+operaciones[i].codope+'">'+operaciones[i].desope+'</option>';
		}
		$("#selectForOperaciones").append(htmlOperaciones);
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

			},
			success:function(data){
				//console.log(data);
				var htmlDefectos="";
				defectos=data.defectos;
				operaciones=data.operaciones;
				for (var i = 0;i<data.defectos.length; i++) {
					htmlDefectos+='<option value="'+data.defectos[i].coddef+'">'+data.defectos[i].desdef+'</option>';
				}
				$("#selectForDefectos").append(htmlDefectos);			
				var htmlOperaciones="";
				for (var i = 0;i<data.operaciones.length; i++) {
					htmlOperaciones+='<option value="'+data.operaciones[i].codope+'">'+data.operaciones[i].desope+'</option>';
				}
				$("#selectForOperaciones").append(htmlOperaciones);
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
			codope:afcodope,
			codaql:fsfccodaql,
			candef:$("#idCantDefectos").val(),
			newcoddef:$("#selectForDefectos").val(),
			newcodope:$("#selectForOperaciones").val()
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
			htmlDefectos+='<option value="'+defectos[i].coddef+'">'+defectos[i].desdef+'</option>';
		}
		$("#selectForDefectosNew").append(htmlDefectos);			
		var htmlOperaciones="";
		for (var i = 0;i<operaciones.length; i++) {
			htmlOperaciones+='<option value="'+operaciones[i].codope+'">'+operaciones[i].desope+'</option>';
		}
		$("#selectForOperacionesNew").append(htmlOperaciones);
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
					htmlDefectos+='<option value="'+data.defectos[i].coddef+'">'+data.defectos[i].desdef+'</option>';
				}
				$("#selectForDefectosNew").append(htmlDefectos);			
				var htmlOperaciones="";
				for (var i = 0;i<data.operaciones.length; i++) {
					htmlOperaciones+='<option value="'+data.operaciones[i].codope+'">'+data.operaciones[i].desope+'</option>';
				}
				$("#selectForOperacionesNew").append(htmlOperaciones);
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
			codope:$("#selectForOperacionesNew").val(),
			codaql:fsfccodaql,
			candef:$("#idCantDefectosNew").val(),
		},
		success:function(data){
			console.log(data);
			if (data.state==true) {
				$(".btnBuscarSpace").click();	
			}else{
				alert(data.error.state+" Revise que no se repita defecto / operacion!");
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
		url:"config/getFicha.php",
		data:{
			codfic:codfic,
			codtad:codtad,
			numvez:numvez,
			parte:parte,
			codaql:codaql,
			requestFicha:"0"
		},
		success:function(data){
			console.log(data);
			if(data.state==true){
				canpar_var=parseInt(data.ficha.CANPAR);
				$("#idcanpar").text(canpar_var);
				if (data.ficha.RESULTADO!="A") {
					$("#btnClasiRecu").css("display","none");
				}else{
					$("#btnClasiRecu").css("display","block");
				}
				document.getElementById("idCliente").innerHTML=data.data.DESCLI;
				document.getElementById("idNombreTaller").innerHTML=data.ficha.DESTLL;
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
				if (data.partida.partida!=undefined) {
					document.getElementById("idpartida").innerHTML=
					'<a href="../Auditoriatela/VerAuditoriaTela.php?partida='+data.partida.partida+
					'&codtel='+data.partida.codtel+'&codprv='+data.partida.codprv+
					'&numvez='+data.partida.numvez+'&parte='+data.partida.parte+
					'&codtad='+data.partida.codtad+'">'+data.partida.partida+'</a>';
				}else{
					document.getElementById("idpartida").innerHTML="";
				}
				if (data.partida.DESTLL!=undefined) {
					document.getElementById("idNombreTalCor").innerHTML=
					'<a href="../AuditoriaFinalCorte/ConsultarEditarAuditoria.php?codfic='+codfic+'">'+data.partida.DESTLL+'</a>';
				}else{
					document.getElementById("idNombreTalCor").innerHTML="";
				}			
				if (data.partida.color!=undefined) {
					document.getElementById("idcolor").innerHTML=data.partida.color
				}else{
					document.getElementById("idcolor").innerHTML="";
				}
				if (data.partida.tiptel!=undefined) {
					document.getElementById("idtiptel").innerHTML=data.partida.tiptel;
				}else{
					document.getElementById("idtiptel").innerHTML="";
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
							data.defectos[i].codfic+','+
							data.defectos[i].codtad+','+
							data.defectos[i].numvez+','+
							data.defectos[i].parte+','+
							data.defectos[i].coddef+','+
							data.defectos[i].codope+','+
							data.defectos[i].candef+')">'+
								'<div class="itemBody" style="width: 40%;">'+data.defectos[i].desdef+'</div>'+
								'<div class="itemBody" style="width: 40%;">'+data.defectos[i].desope+'</div>'+
								'<div class="itemBody" style="width: 20%;">'+data.defectos[i].candef+'</div>'+
							'</div>';	
						}else{
							htmlDefectos+=
							'<div class="tblLine lineDefectos">'+
								'<div class="itemBody" style="width: 40%;">'+data.defectos[i].desdef+'</div>'+
								'<div class="itemBody" style="width: 40%;">'+data.defectos[i].desope+'</div>'+
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
				$(".panelCarga").fadeOut(300);
			}
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

function validar_esttsc(){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		data:{
			codfic:document.getElementById("idCodFicha").value
		},
		url:"config/validateEstTsc.php",
		success:function(data){
			//console.log(data);
			if(data.state==true){
				window.location.href="AuditoriaMedidas.php?codfic="+document.getElementById("idCodFicha").value+
				"&esttsc="+data.esttsc[0].ESTTSC+"&consulta=1";
			}else{
				alert(data.detail);
				$(".panelCarga").fadeOut(300);
			}
		}
	});
}