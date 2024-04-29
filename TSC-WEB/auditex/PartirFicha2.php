<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="10";
	include("config/_validate_access.php");
	include("config/_contentMenu.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>AUDITEX</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/consultaAuditoria.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<style type="text/css">
		.itemHeader,.itemBody{
			width: calc(100% / 3);
		}
		.ipt-newtal{
			padding: 2px!important;
			width: 50px!important;
		}
	</style>
</head>
<body>
	<?php contentMenu();?>
	<div class="panelCarga" style="display: block;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Partir ficha</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">	
			<div class="rowLineFlex">
				<div style="margin-left: 10%;width: 80%;display: flex;">
					<div class="lblNew" style="width: 70px;padding-top: 5px;">Ficha</div>
					<div class="spaceIpt" style="width: calc(100% - 105px);">
						<input type="number" id="idCodFicha" class="iptClass" style="width: calc(100% - 12px);">
					</div>
					<div class="btnBuscarSpace" style="width: 30px;margin-left: 5px;"><i class="fa fa-search" aria-hidden="true"></i></div>
				</div>
			</div>
			<div class="msgForFichas"></div>
			<div id="idContentTblFichas" style="display: none;">
				<div class="spaceInLine"></div>
				<div class="lblNew" style="width: 100%;">Seleccione ficha a partir</div>
				<div class="rowLine" style="display: block;">
					<div class="tblPrendasDefecto">
						<div class="tblHeader">
							<div class="itemHeader verticalHeader">Ficha</div>							
							<div class="itemHeader">Tipo Auditoria</div>
							<div class="itemHeader verticalHeader">Parte</div>
							<div class="itemHeader verticalHeader">Vez</div>
							<div class="itemHeader verticalHeader">Prendas</div>
						</div>
						<div class="tblBody">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="bodyContent" id="idContentDescription" style="display: none;padding-bottom: 0px;">
			<div class="lineWithDecoration" style="margin-top: 0px;margin-bottom: 10px;width: 100%;margin-left: 0px;"></div>
			<div class="rowLine bodyPrimary">				
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 70px;">Taller</div>
					<div class="spaceIpt" style="width: calc(100% - 70px);">
						<div class="valueRequest" id="idNombreTaller"></div>
					</div>
				</div>		
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 210px;">Ficha</div>
					<div class="spaceIpt" style="width: calc(100% - 210px);">
						<div class="valueRequest" id="idCodFichaText"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 210px;">Cantidad de prendas</div>
					<div class="spaceIpt" style="width: calc(100% - 210px);">
						<div class="valueRequest" id="idCantPrendas"></div>
					</div>
				</div>
				<div id="divPartir">
					<div class="sameLine" style="width: 100%; margin: 0;">
						<div class="lblNew" style="width: 250px;">Cantidad de prendas de ficha parcial</div>
						<div class="spaceIpt" style="margin-left: calc(100% - 352px); width: 102px;">
							<input type="number" id="idNewCantParte" class="iptClass" style="width: calc(100% - 12px);" disabled>
						</div>			
					</div>
					<div class="tblPrendasDefecto" style="width: 80%;margin: 10px auto;">
						<div class="tblHeader">
							<div class="itemHeader">Talla</div>
							<div class="itemHeader">Cantidad</div>
							<div class="itemHeader">Can. Parte</div>
						</div>
						<div class="tblBody" id="table-tallas">
							
						</div>
					</div>
					<div class="rowLine">
						<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 10px;margin-bottom: 10px;" onclick="partirFicha()">Partir Ficha</button>
					</div>
				</div>
			</div>
		</div>
		<div class="lineWithDecoration" style="margin-left:10px;margin-top: 0px;margin-bottom: 10px; width: calc(100% - 20px);"></div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<!--<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="redirect('main.php')">Terminar</button>-->
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);">Terminar</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript" src="js/index-v1.1.js"></script>
	<script type="text/javascript">
		function formatText(string){
	while(string.indexOf('"')>0){
		string=string.replace('"','');
	}
	while(string.indexOf('\'')>0){
		string=string.replace('\'','');
	}
	return string;
}

$(document).ready(function(){
	$("#idNewCantParte").keydown(function(e){
		if (e.keyCode==109||e.keyCode==189||e.keyCode==107||e.keyCode==187) {
			e.preventDefault();
		}
	});
	$("#idCodFicha").keyup(function(e){
		if (e.keyCode==13) {
			$(".btnBuscarSpace").click();
		}
	});
	$(".panelCarga").fadeOut(300);
	$(".btnBuscarSpace").click(function(){
		var codfic=document.getElementById("idCodFicha").value;
		$("#idContentForFicha").css("display","none");
		$("#idTblDefectos").empty();
		$(".msgForFichas").empty();
		$(".msgForFichas").css("display","none");
		$(".panelCarga").fadeIn(100);
		$("#divPartir").css("display","none");
		$.ajax({
			type:"POST",
			url:"config/getFicha2.php",
			data:{
				codfic:codfic
			},
			success:function(data){
				$(".tblBody").empty();
				$("#idContentTblFichas").css("display","none");
				console.log(data);
				if (data.state==true) {
					var htmlFichas="";
					for (var i = 0; i < data.fichas.length; i++) {
							htmlFichas+=
							'<div class="tblLine" onclick="fichaSelectedForPartir('+data.fichas[i].CODFIC+',\''+
								data.fichas[i].AQL+'\','+
								data.fichas[i].CODAQL+','+
								data.fichas[i].CODTAD+','+
								data.fichas[i].NUMVEZ+','+
								data.fichas[i].PARTE+',\''+
								data.fichas[i].CODTLL+'\','+
								data.fichas[i].CANPAR+','+
								data.fichas[i].CANTIDAD+')">'+
								'<div class="itemBody">'+data.fichas[i].CODFIC+'</div>';
							if (data.fichas[i].TIPAUD=='M') {
								htmlFichas+='<div class="itemBody">Final de costura</div>';
							}else{
								htmlFichas+='<div class="itemBody">Otro</div>';
							}
							htmlFichas+=
								'<div class="itemBody">'+data.fichas[i].PARTE+'</div>'+
								'<div class="itemBody">'+data.fichas[i].NUMVEZ+'</div>'+
								'<div class="itemBody">'+data.fichas[i].CANPAR+'</div>'+
							'</div>';
					}
					$(".tblBody").append(htmlFichas);			
					$("#idContentTblFichas").css("display","block");

				}else{
					$(".msgForFichas").append("No se encontro la ficha!");
					$(".msgForFichas").css("display","block");
				}
				getTalleres();
				$(".panelCarga").fadeOut(100);
			}
		});
	});
	$("#idTaller").keyup(function(){
		codtll_v='';
		$("#tabla-talleres").empty();
		let html='';
		for (var i = 0; i < ar_talleres.length; i++) {
			if ((ar_talleres[i].DESTLL+ar_talleres[i].DESCOM).toUpperCase().indexOf($("#idTaller").val().toUpperCase())>=0) {
				html+=
				'<div class="taller" onclick="select_taller(\''+ar_talleres[i].CODTLL+'\',\''+ar_talleres[i].DESTLL+'\')">'+
					ar_talleres[i].DESTLL+
				'</div>';
			}
		}
		$("#tabla-talleres").append(html);
	});
});

var ar_talleres=[];
function getTalleres(){
	$.ajax({
		type:"POST",
		url:"config/getTalleres.php",
		data:{
		},
		success:function(data){
			ar_talleres=data.talleres;
			$("#tabla-talleres").empty();
			let html='';
			for (var i = 0; i < ar_talleres.length; i++) {
				html+=
				'<div class="taller" onclick="select_taller(\''+ar_talleres[i].CODTLL+'\',\''+ar_talleres[i].DESTLL+'\')">'+
					ar_talleres[i].DESTLL+
				'</div>';
			}
			$("#tabla-talleres").append(html);
		}
	});
}

var codtll_v='';
function select_taller(codtll,destll){
	codtll_v=codtll;
	$("#idTaller").val(destll);
}

var fsfpcodfic=0;
var fsfpcodaql=0;
var fsfpcodtad=0;
var fsfpnumvez=0;
var fsfpparte=0;
var fsfpcantidad=0;
var antcodtll='';
function fichaSelectedForPartir(codfic,aql,codaql,codtad,numvez,parte,codtll,cantidadParte,cantPren){
	$("#idTaller").val('');
	codtll_v='';
	antcodtll=codtll;
	$("#idContentDescription").css("display","block");
	document.getElementById("idCodFichaText").innerHTML=codfic;
	if (cantidadParte!=cantPren) {
		document.getElementById("idCantPrendas").innerHTML=cantidadParte+ " de "+cantPren;	
	}else{
		document.getElementById("idCantPrendas").innerHTML=cantidadParte;	
	}	
	fsfpcodfic=codfic;
	fsfpcodaql=codaql;
	fsfpcodtad=codtad;
	fsfpnumvez=numvez;
	fsfpparte=parte;
	fsfpcantidad=cantidadParte;
	$("#idNewCantParte").val("");
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		url:"config/getTalXFic.php",
		data:{
			codfic:codfic,
			parte:parte
		},
		success:function(data){
			var html='';
			for (var i = 0; i < data.tallas.length; i++) {
				html+=
			'<div class="tblLine">'+
				'<div class="itemBody">'+data.tallas[i].DESTAL+'</div>'+
				'<div class="itemBody">'+data.tallas[i].CANTAL+'</div>'+
				'<div class="itemBody"><input type="number" id="t-'+data.tallas[i].CODTAL+'" class="ipt-newtal" onkeyup="validate_value(this,'+data.tallas[i].CANTAL+')"/></div>'+
			'</div>';
			}
			document.getElementById("table-tallas").innerHTML=html;

			$("#divPartir").css("display","block");
			$(".panelCarga").fadeOut(100);
		}
	});
}

function validate_value(dom,maxcan){
	if (dom.value>maxcan) {
		alert("La cantidad de la parte no debe ser mayor a la parte");
		dom.value=maxcan;
		return;
	}
	var total=0;
	var ar=document.getElementsByClassName("ipt-newtal");
	for (var i = 0; i < ar.length; i++) {
		if (ar[i].value!="") {
			total+=parseInt(ar[i].value);
		}
	}
	document.getElementById("idNewCantParte").value=total;
}

function partirFicha(){
	var ar_send=[];
	var ar=document.getElementsByClassName("ipt-newtal");
	for (var i = 0; i < ar.length; i++) {
		var aux=[];
		var canpartal=0;
		if (ar[i].value!="") {
			canpartal=ar[i].value;
		}
		aux.push(ar[i].id.replace("t-",""));
		aux.push(canpartal);
		ar_send.push(aux);
	}
	var cantidadIngresada=parseInt($("#idNewCantParte").val());
	if (cantidadIngresada>=fsfpcantidad) {
		alert("La cantidad no debe exceder a la total de la ficha!");
		return;
	}
	if (cantidadIngresada<=0 || cantidadIngresada=="") {
		alert("Debe ingresar cantidades en las partes!");
		return;
	}
	$(".panelCarga").fadeIn(300);
	$.ajax({
		type:"POST",
		data:{				
			codfic:fsfpcodfic,
			codaql:fsfpcodaql,
			codtad:fsfpcodtad,
			numvez:fsfpnumvez,
			parte:fsfpparte,
			nuecan:$("#idNewCantParte").val(),
			array:ar_send
		},
		url:"config/PartirFicha2.php",
		success:function(data){
			//console.log(data);
			if (data.state==true) {
				alert("Ficha partida!");
				$("#divPartir").css("display","none");
				$(".btnBuscarSpace").click();
				$("#idContentDescription").css("display","none");
			}else{
				alert("No se pudo partir la ficha!");
			}
			$(".panelCarga").fadeOut(300);
		}
	});
	
}
	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>