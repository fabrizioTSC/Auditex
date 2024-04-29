var perfilUsuario=0;
function verificarPerfil(perfil){
	perfilUsuario=perfil;
	$(".panelCarga").fadeOut(300);	
}

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
			$(".panelCarga").fadeIn(300);
			$.ajax({
				type:"POST",
				url:"config/getFicha.php",
				data:{
					codfic:codfic,
					typeRequest:0
				},
				success:function(data){
					$(".tblBody").empty();
					$("#idContentTblFichas").css("display","none");
					console.log(data);
					if (data.state==true) {
						if (data.fichas.length==0) {
							$(".msgForFichas").append("No se encontro la ficha!");
							$(".msgForFichas").css("display","block");
						}else{
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
								if (data.fichas[i].TIPAUD='M') {
									htmlFichas+='<div class="itemBody" style="width: 27%;">Final costura</div>';
								}else{
									htmlFichas+='<div class="itemBody" style="width: 27%;">Otra auditoria</div>';
								}
								htmlFichas+=
									'<div class="itemBody" style="width: 13%;">'+data.fichas[i].PARTE+'</div>'+
									'<div class="itemBody" style="width: 10%;">'+data.fichas[i].NUMVEZ+'</div>'+
									'<div class="itemBody" style="width: 25%;">'+hoy+'</div>'+
									'<div class="itemBody" style="width: 25%;">'+resul+'</div>'+
								'</div>';
							}
							$(".tblBody").append(htmlFichas);			
							$("#idContentTblFichas").css("display","block");
							$(".panelCarga").fadeOut(300);
						}
					}else{
						alert(data.error.detail);
						$(".panelCarga").fadeOut(300);
					}
				}
			})
		}
	});
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
				$(".panelCarga").fadeOut(300);
			}
		});
	}
}
var defectos=[];
var operaciones=[];

function cerrarMenuDefectoNew(){
	$(".agregarDefectos").fadeOut(300);
}

function guardarDefecto(){
	$(".panelCarga").fadeIn(300);
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
			$(".panelCarga").fadeOut(300);
		}
	});
}

function borrarDefecto(action){
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
var fsfctipaud=0;
function fichaSelectedForConsulta(codfic,aql,codaql,codtad,numvez,parte,tipaud){
	fsfccodfic=codfic;
	fsfcaql=aql;
	fsfccodaql=codaql;
	fsfccodtad=codtad;
	fsfcnumvez=numvez;
	fsfcparte=parte;
	fsfctipaud=tipaud;
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
				if (data.ficha.RESULTADO!="A") {
					$("#btnClasiRecu").css("display","none");
				}else{
					$("#btnClasiRecu").css("display","block");
				}
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
						if (perfilUsuario==0) {
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