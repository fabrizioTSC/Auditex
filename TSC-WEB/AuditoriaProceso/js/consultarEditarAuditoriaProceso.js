$(document).ready(function(){
	$(".btnBuscarSpace").click(function(){
		$("#spaceResultado").css("display","none");
		if ($("#idCodFicha").val()=="") {
			alert("Introduzca un código de ficha!");
		}else{
			$("#spaceResultado").css("display","none");
			$(".panelCarga").fadeIn(200);
			$.ajax({
				type:"POST",
				url:"config/getFichaAudPro.php",
				data:{
					codfic:$("#idCodFicha").val()
				},
				success:function(data){
					console.log(data);
					$("#resultFichas").empty();					
					if (data.state==true) {
						if (data.fichas.length!=0) {
							var html="";
							for (var i = 0; i < data.fichas.length; i++) {
								var fecfin="No finalizada"
								if (data.fichas[i].FECFIN!=null) {
									fecfin=data.fichas[i].FECFIN;
								}
								html+=
								'<div class="tblLine" onclick="showdetalleFicha('+data.fichas[i].SECUEN+',\''+data.fichas[i].CODTLL+'\','+
									data.fichas[i].TURNO+')">'+
									'<div class="itemBody" style="width: 20%;">'+data.fichas[i].SECUEN+'</div>'+
									'<div class="itemBody" style="width: 20%;">'+data.fichas[i].ALIUSU+'</div>'+
									'<div class="itemBody" style="width: 30%;">'+data.fichas[i].FECINI+'</div>'+
									'<div class="itemBody" style="width: 30%;">'+fecfin+'</div>'+
								'</div>';
							}
							$("#resultFichas").append(html);
							$("#idContentTblFichas").css("display","block");
						}else{
							alert("Ficha no encontrada!");
							$("#idContentTblFichas").css("display","none");
						}
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(200);
				}
			});
		}
	});

	$(".panelCarga").fadeOut(200);
	$.ajax({
		type:"POST",
		url:"config/getDataAudPro.php",
		data:{
		},
		success:function(data){
			console.log(data);
			var htmlOperador="";
			for (var i = 0; i < data.operadores.length; i++) {
				htmlOperador+='<option class="defecto" value="'+data.operadores[i].CODPER+'">'
				+data.operadores[i].NOMPER+'</option>';
			}
			$("#selectForOperadores").empty();
			$("#selectForOperadores").append(htmlOperador);

			var htmlOperacion="";
			for (var i = 0; i < data.operaciones.length; i++) {
				htmlOperacion+='<option class="defecto" value="'+data.operaciones[i].CODOPE+'">'
				+data.operaciones[i].DESOPE+'</option>';
			}
			$("#selectForOperaciones").empty();
			$("#selectForOperaciones").append(htmlOperacion);

			var htmlDefecto="";
			for (var i = 0; i < data.defectos.length; i++) {
				htmlDefecto+='<option class="defecto" value="'+data.defectos[i].CODDEF+'">'
				+data.defectos[i].CODDEFAUX+' - '+data.defectos[i].DESDEF+'</option>';
			}			
			$("#selectForDefectos").empty();
			$("#selectForDefectos").append(htmlDefecto);
		}
	});
	if (codfic!="") {
		$(".btnBuscarSpace").click();
	}
});

var secuen_var=0;
var codtll_var=0;
var turno_var=0;
function showdetalleFicha(secuen,codtll,turno){
	secuen_var=secuen;
	codtll_var=codtll;
	turno_var=turno;
	$(".panelCarga").fadeIn(200);
	$.ajax({
		type:"POST",
		url:"config/getDetAudPro.php",
		data:{
			codfic:$("#idCodFicha").val(),
			secuen:secuen
		},
		success:function(data){
			console.log(data);
			$("#idTblDefectos").empty();					
			if (data.state==true) {
				var html="";
				for (var i = 0; i < data.detalle.length; i++) {
					html+=
					'<div class="tblLine" onclick="openoptions(this,'+data.detalle[i].CODOPE+','+data.detalle[i].CODDEF+','+data.detalle[i].CANDEF+','+data.detalle[i].CODPER+')">'+
						'<div class="itemBody" style="width: 100px;">'+(i +1)+'</div>'+
						'<div class="itemBody" style="width: 200px;">'+data.detalle[i].DESTLL+'</div>'+
						'<div class="itemBody" style="width: 200px;">'+data.detalle[i].NOMPER+'</div>'+
						'<div class="itemBody" style="width: 200px;">'+data.detalle[i].DESOPE+'</div>'+
						'<div class="itemBody" style="width: 100px;">'+data.detalle[i].NUMVEZ+'</div>'+
						'<div class="itemBody" style="width: 200px;">'+data.detalle[i].DESDEF+'</div>'+
						'<div class="itemBody" style="width: 100px;">'+data.detalle[i].CANDEF+'</div>'+
						'<div class="itemBody" style="width: 100px;">'+data.detalle[i].USUARIOFIN+'</div>'+
						'<div class="itemBody" style="width: 100px;">'+data.detalle[i].ESTADO+'</div>'+
						'<div class="itemBody" style="width: 100px;">'+data.detalle[i].FECHAFIN+'</div>'+
					'</div>';
				}

				// <div class="itemHeader" style="width: 100px;">Item</div>
				// <div class="itemHeader" style="width: 200px;">Operario</div>
				// <div class="itemHeader" style="width: 200px;">Operación</div>
				// <div class="itemHeader" style="width: 100px;">Vez</div>
				// <div class="itemHeader" style="width: 200px;">Defecto</div>
				// <div class="itemHeader" style="width: 100px;">Cant.</div>
				// <div class="itemHeader" style="width: 100px;">Auditor</div>
				// <div class="itemHeader" style="width: 100px;">Resultado</div>


				$("#idTblDefectos").append(html);
				$("#spaceResultado").css("display","block");

				if (data.partida.CODTEL!=null && data.partida.PARTIDA!=null) {
					document.getElementById("idaudfincor").innerHTML=
					'<a href="../AuditoriaFinalCorte/ConsultarEditarAuditoria.php?codfic='+codfic+'">'+data.partida.DESTLL+'</a>';
					document.getElementById("idpartida").innerHTML='<a href="../auditoriatela/VerAuditoriaTela.php?partida='+
					data.partida.PARTIDA+'&codtel='+data.partida.CODTEL+
					'&codprv='+data.partida.CODPRV+
					'&numvez='+	data.partida.NUMVEZ+
					'&parte='+data.partida.PARTE+
					'&codtad='+data.partida.CODTAD+'">'+data.partida.PARTIDA+'</a>';
				}
			}
			$(".panelCarga").fadeOut(200);
		}
	});
}

var codope_var=0;
var coddef_var=0;
var candef_var=0;
var codper_var=0;
function openoptions(dom,codope,coddef,candef,codper){
	codope_var=codope;
	coddef_var=coddef;
	candef_var=candef;
	codper_var=codper;
	var bottom=dom.getBoundingClientRect().bottom;
	$(".opcionesDefecto").css("top",bottom+"px");
	$(".opcionesDefecto").css("right","10px");
	$(".opcionesDefecto").fadeIn(100);
}

function gestionDefecto(action){
	$(".panelCarga").fadeIn(200);
	$.ajax({
		type:"POST",
		url:"config/gestionDefAudPro.php",
		data:{
			codfic:$("#idCodFicha").val(),
			secuen:secuen_var,
			action:action,
			codper:codper_var,
			codope:codope_var,
			candef:candef_var,
			coddef:coddef_var,
			codper_new:$("#selectForOperadores").val(),
			codope_new:$("#selectForOperaciones").val(),
			candef_new:$("#idCantDefectos").val(),
			coddef_new:$("#selectForDefectos").val(),
		},
		success:function(data){
			console.log(data);
			if (data.state==true) {
				closeOpcionesDefecto();
				cerrarMenuDefecto();
				showdetalleFicha(secuen_var,codtll_var,turno_var);
			}else{
				alert(data.detail);
				$(".panelCarga").fadeOut(200);
			}
		}
	})
}

function abrirMenuDefecto(){
	closeOpcionesDefecto();
	$("#selectForOperadores").val(codper_var);
	$("#selectForOperaciones").val(codope_var);
	$("#selectForDefectos").val(coddef_var);
	$("#idCantDefectos").val(candef_var);
	$(".editarDefectos").fadeIn(200);
}

function cerrarMenuDefecto(){
	$(".editarDefectos").fadeOut(200);
}

function closeOpcionesDefecto(){
	$(".opcionesDefecto").fadeOut(100);	
}

function contunieAudPro(){
	location.href="RegistrarAuditoriaProceso.php?codfic="+$("#idCodFicha").val()+"&turno="+turno_var+"&codtll="+codtll_var+"&secuen="+secuen_var;
}

function backToMain(){
	location.href="main.php";
}