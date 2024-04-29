/* Registro de prendas */
function showMenu(){
	window.location.href="RegistrarAuditoria.php";
}

var listaDefectos=[];
var listaOperaciones=[];
var cantidadAuditar=0;
var totalAuditar=0;
var codFicha="";
var tipoAuditoria="";
var cantidadDeMuestra=0;
var fichaNumVez=0;
var fichaParte=0;
var fichaCodTad=0;
var fichaCodAql=0;
var canMaxDefectos=0;
var codaql=0;
var codUsuario=0;
var usuario="";
var codtll_var="";

function cargarDatos(codFic,codtll,tipoMuestra,numMuestra,numvez,parte,codtad,codaql,codusu,codusuario){
	usuario=codusuario;
	codUsuario=codusu;
	fichaNumVez=numvez;
	fichaParte=parte;
	fichaCodTad=codtad;
	fichaCodAql=codaql;
	document.getElementById("idCodFicha").innerHTML=codFic;
	tipoAuditoria=tipoMuestra;
	codFicha=codFic;
	codtll_var=codtll;
	$.ajax({
		type:"POST",
		data:{
			codfic:codFic,
			codtll:codtll,
			numvez:numvez,
			parte:parte,
			codtad:codtad,
			codaql:codaql,
			tipomuestra:tipoMuestra,
			nummuestra:numMuestra
		},
		url:"config/getDetallePrendasAAuditar.php",
		success:function(data){
			console.log(data);
			if (data.state==true) {
				if (data.partida.partida!=undefined) {
					document.getElementById("idpartida").innerHTML=
					'<a href="../Auditoriatela/VerAuditoriaTela.php?partida='+data.partida.partida+
					'&codtel='+data.partida.codtel+'&codprv='+data.partida.codprv+
					'&numvez='+data.partida.numvez+'&parte='+data.partida.parte+
					'&codtad='+data.partida.codtad+'">'+data.partida.partida+'</a>';
				}

				cantidadAuditar=data.fichas[0].CANAUD;
				totalAuditar=data.fichas[0].CANPRE;
				canMaxDefectos=data.fichas[0].CANDEFMAX;

				codaql=data.fichas[0].CODAQL;
				var parteAuditoria="";
				if(data.fichas[0].CANPAR!=data.fichas[0].CANPRE){
					parteAuditoria=data.fichas[0].CANPAR+" de "+data.fichas[0].CANPRE;
				}else{
					parteAuditoria=data.fichas[0].CANPAR;
				}
				document.getElementById("idNombreTaller").innerHTML=data.fichas[0].DESTLL;
				document.getElementById("idCantPrendas").innerHTML=parteAuditoria;
				if (tipoMuestra=="aql") {					
					document.getElementById("idMuestreo").innerHTML=tipoMuestra.toUpperCase()+" "+data.fichas[0].AQL+"%";
					var num=data.fichas[0].AQL*data.fichas[0].CANPRE/100;
					num=Math.round(num);
					document.getElementById("idNumPrendasAuditar").innerHTML="("+cantidadAuditar+" prendas"+")";
					prendasXauditar=cantidadAuditar;
				}else{
					cantidadAuditar=numMuestra;
					prendasXauditar=cantidadAuditar;
					document.getElementById("idMuestreo").innerHTML=tipoMuestra.toUpperCase();
					document.getElementById("idNumPrendasAuditar").innerHTML="("+cantidadAuditar+" prendas"+")";
				}
				document.getElementById("idCanMaxDef").innerHTML=canMaxDefectos+" prendas";
				cantidadDeMuestra=cantidadAuditar;
			}else{
				alert(data.description);
			}
			/***************************/
			/* Llenado de datos manual */
			/***************************/
			listaDefectos=data.defectos;
			var htmlDefectos="";
			/********************************/
			/* DEFECTOS */
			for (var i = 0; i < listaDefectos.length; i++) {
				htmlDefectos+='<div class="defecto" '+
				'onclick="addDefecto(\''+listaDefectos[i].desdef+'\','+listaDefectos[i].coddef+')">'
				+listaDefectos[i].desdef+'</div>';
			}
			$(".tblDefectos").append(htmlDefectos);
			listaOperaciones=data.operaciones;
			var htmlDefectos="";
			/********************************/
			/* OPERACIONES */
			for (var i = 0; i < listaOperaciones.length; i++) {
				htmlDefectos+='<div class="operacion" '+
				'onclick="addOperacion(\''+listaOperaciones[i].desope+'\','+listaOperaciones[i].codope+')">'
				+listaOperaciones[i].desope+'</div>';
			}
			$(".tblOperaciones").append(htmlDefectos);
			/********************************/
			/* FICHA TALLA */
			var htmlDefectos="";
			$(".tblBody").empty();
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
			if (data.defectosPasados.length>0) {
				var htmlResumen="";
				for(var a=0;a<data.defectosPasados.length;a++){
					cantidadPrendasDefecto+=parseInt(data.defectosPasados[a].CANDEF);
					htmlResumen+=
					'<div class="tblLine">'+
						'<div class="itemBody" style="width: 40%;">'+data.defectosPasados[a].DESDEF+'</div>'+
						'<div class="itemBody" style="width: 40%;">'+data.defectosPasados[a].DESOPE+'</div>'+
						'<div class="itemBody" style="width: 20%;">'+data.defectosPasados[a].CANDEF+'</div>'+
					'</div>';
				}
				$(".tblBodyResumen").append(htmlResumen);
				$("#idTblResumen").css("display","block");
			}
			$(".tblBody").append(htmlDefectos);
			$(".lblMsg").empty();
			$(".panelCarga").fadeOut(300);
		}
	});
}

function comenzarRevision(){
	$(".bodyContent").css("display","none");	
	$(".bodyContentNew").css("display","block");
}

var auditoriaDefecto="";
var codAuditoriaDefecto=0;
var codAuditoriaOperacion=0;
var auditoriaOperacion="";
var prendasXauditar=0;
$(document).ready(function(){
	$("#idCanPren").keydown(function(e){
		if (e.keyCode==109||e.keyCode==189||e.keyCode==107||e.keyCode==187) {
			e.preventDefault();
		}
	});
	$("#idDefecto").keyup(function(){
		$(".tblDefectos").empty();
		var htmlTalleres="";
		var busqueda=document.getElementById("idDefecto").value;
		for (var i = 0; i < listaDefectos.length; i++) {
			if ((listaDefectos[i].desdef.toUpperCase()).indexOf(busqueda.toUpperCase())>=0) {				
				htmlTalleres+='<div class="defecto" onclick="addDefecto(\''+listaDefectos[i].desdef+'\','+listaDefectos[i].coddef+')">'+listaDefectos[i].desdef+"</div>";
			}
		}
		$(".tblDefectos").append(htmlTalleres);
	});
	$("#idOperacion").keyup(function(){
		$(".tblOperaciones").empty();
		var htmlTalleres="";
		var busqueda=document.getElementById("idOperacion").value;
		for (var i = 0; i < listaOperaciones.length; i++) {
			if ((listaOperaciones[i].desope.toUpperCase()).indexOf(busqueda.toUpperCase())>=0) {				
				htmlTalleres+='<div class="operacion" onclick="addOperacion(\''+listaOperaciones[i].desope+'\','+listaOperaciones[i].codope+')">'+listaOperaciones[i].desope+"</div>";
			}
		}
		$(".tblOperaciones").append(htmlTalleres);
	});
});

function addDefecto(word,coddef){
	//console.log(word);
	codAuditoriaDefecto=coddef;
	auditoriaDefecto=word;
	$("#idDefecto").val(word);
}

function addOperacion(word,codope){
	//console.log(word);
	codAuditoriaOperacion=codope;
	auditoriaOperacion=word;
	$("#idOperacion").val(word);
}

var cantidadPrendasDefecto=0;
function aniadirPrenda(){
	if (auditoriaDefecto=="") {
		alert("Escoga un efecto");
	}else{
		if (auditoriaOperacion=="") {
			alert("Escoga una operacion");
		}else{
			if ($("#idCanPren").val()=="") {
				alert("Agregue una cantidad de prendas auditadas");
			}else{
				$(".panelCarga").fadeIn(300);
				var canPrendas=$("#idCanPren").val();
				$.ajax({
					type:"POST",
					url:"config/saveAuditoriaDefecto.php",
					data:{
						codfic:codFicha,
						coddef:codAuditoriaDefecto,
						codope:codAuditoriaOperacion,
						candef:canPrendas,
						numvez:fichaNumVez,
						parte:fichaParte,
						codaql:fichaCodAql,
						codtad:fichaCodTad,
						codusu:codUsuario,
						usuario:usuario,
						canpar:document.getElementById("idCantPrendas").innerHTML,
						codtll:codtll_var
					},
					success:function(data){
						if(data.state==true){
							cantidadPrendasDefecto+=parseInt(canPrendas);
							var htmlResumen=
								'<div class="tblLine">'+
									'<div class="itemBody" style="width: 40%;">'+auditoriaDefecto+'</div>'+
									'<div class="itemBody" style="width: 40%;">'+auditoriaOperacion+'</div>'+
									'<div class="itemBody" style="width: 20%;">'+canPrendas+'</div>'+
								'</div>';
							$(".tblBodyResumen").append(htmlResumen);
							$("#idTblResumen").css("display","block");
							$("#idDefecto").val("");
							$("#idOperacion").val("");
							$("#idCanPren").val("");
							$(".lblMsg").empty();
							auditoriaOperacion="";
							auditoriaDefecto="";
							codAuditoriaOperacion=0;
							codAuditoriaDefecto=0;
							mensajeInstantaneo(data.description);
						}else{
							mensajeInstantaneo(data.error.description);
						}
						$(".modalContainer").css("display","none");
						$(".panelCarga").fadeOut(300);
					}
				});
			}
		}
	}
}

function mensajeInstantaneo(msg){
	$(".textMsgCarga").empty();
	$(".textMsgCarga").append(msg);
	$(".msgInstant").fadeIn(300);
	setTimeout(function(){
		$(".msgInstant").fadeOut(300);
	},2000);
}

function cerrarModal(){
	$(".modalContainer").css("display","none");
}

function confirmarAuditoriaPrenda(){
	var canPrendas=$("#idCanPren").val();
	$.ajax({
		type:"POST",
		url:"config/saveAuditoriaDefecto.php",
		data:{
			codfic:codFicha,
			coddef:codAuditoriaDefecto,
			codope:codAuditoriaOperacion,
			candef:canPrendas,
			numvez:fichaNumVez,
			parte:fichaParte,
			codtad:fichaCodTad
		},
		success:function(data){
			console.log(data);
			if(data.state==true){
				prendasXauditar=prendasXauditar-canPrendas;
				$("#idDefecto").val("");
				$("#idOperacion").val("");
				$("#idCanPren").val("");
				auditoriaOperacion="";
				auditoriaDefecto="";
				codAuditoriaOperacion=0;
				codAuditoriaDefecto=0;
				alert(data.description);
			}else{
				alert(data.error.description);
			}
			$(".modalContainer").css("display","none");
		}
	});
}

function terminarAuditoraFicha(){
	var estadoAuditoria="A";
	if (parseInt(canMaxDefectos)<parseInt(cantidadPrendasDefecto)) {
		estadoAuditoria="R";
	}
	$(".panelCarga").fadeIn(300);
	$.ajax({
		type:"POST",
		data:{
			codfic:codFicha,
			numvez:fichaNumVez,
			parte:fichaParte,
			codtad:fichaCodTad,
			codaql:fichaCodAql,
			resultado:estadoAuditoria,
			defectos:cantidadPrendasDefecto,
			codusu:usuario,
			canpar:document.getElementById("idCantPrendas").innerHTML,
			codtll:codtll_var
		},
		url:"config/changeStateFicha.php",
		success:function(data){
			//console.log(data);
			if(data.state==true){
				window.location.href="AuditoriaRegistrada.php?codfic="+codFicha+
				"&numvez="+fichaNumVez+"&parte="+fichaParte+"&codtad="+fichaCodTad+
				"&tipoAuditoria="+tipoAuditoria+"&cantidadDeMuestra="+cantidadDeMuestra+"&resultado="+estadoAuditoria+"&codaql="+fichaCodAql;
			}else{
				alert(data.error.description);
				$(".panelCarga").fadeOut(300);
			}
		}
	});
}