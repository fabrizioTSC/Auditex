function search_ficha(){	
	document.getElementById("resultcontent-2").style.display="none";
	document.getElementById("select-ficha").style.display="none";
	/*
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		url:"config/getFichasAPNC.php",
		data:{
			codfic:$("#idcodfic").val()
		},
		success:function(data){
			console.log(data);
			if (data.state) {
				window.location.href="AudProNoCon.php?codfic="+$("#idcodfic").val()+"&fichaauto=0";
			}else{
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(100);
		}
	});*/
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		url:"config/getListaFichaAPNC.php",
		data:{
			codfic:$("#idcodfic").val()
		},
		success:function(data){
			console.log(data);
			var html='';
			for (var i = 0; i < data.data.length; i++) {
				html+=
				'<tr>'+
					'<td>'+data.data[i].NUMVEZ+'</td>'+
					'<td>'+data.data[i].PARTE+'</td>'+
					'<td>'+data.data[i].FECINIAUDF+'</td>'+
					'<td>'+data.data[i].CODUSU+'</td>'+
					'<td>'+data.data[i].CANMUE+'</td>'+
					'<td>'+data.data[i].CANDEF+'</td>'+
					'<td>'+data.data[i].PORNOCON+'</td>'+
					'<td>'+data.data[i].CANTIDAD+'</td>'+
				'</tr>';
			}
			document.getElementById("table-body-list").innerHTML=html;
			document.getElementById("resultcontent-3").style.display="block";

			$(".panelCarga").fadeOut(100);
		}
	});
}
function search_pedido(){
	document.getElementById("select-ficha").style.display="none";
	document.getElementById("resultcontent-2").style.display="none";
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		url:"config/getColXPedAPNC.php",
		data:{
			pedido:$("#idpedido").val()
		},
		success:function(data){
			console.log(data);
			if (data.state) {
				let html='';
				for (var i = 0; i < data.colores.length; i++) {
					html+='<div class="classTaller" onclick="select_color(\''+data.colores[i].DSCCOL+'\',\''+data.colores[i].CODFIC+'\')">'+data.colores[i].DSCCOL+'</div>';
				}
				$("#tabla-colores").empty();
				$("#tabla-colores").append(html);
				document.getElementById("resultcontent-2").style.display="block";
			}else{
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(100);
		}
	});
}
let dsccol_v='';
let codfic_v='';
function select_color(dsccol,codfic){
	document.getElementById("select-ficha").style.display="block";
	document.getElementById("idnomcol").innerHTML=dsccol;
	dsccol_v=dsccol;
	codfic_v=codfic;
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		url:"config/getListaPedColAPNC.php",
		data:{
			pedido:$("#idpedido").val(),
			descol:dsccol
		},
		success:function(data){
			console.log(data);
			var html='';
			for (var i = 0; i < data.data.length; i++) {
				html+=
				'<tr>'+
					'<td>'+data.data[i].NUMVEZ+'</td>'+
					'<td>'+data.data[i].PARTE+'</td>'+
					'<td>'+data.data[i].FECINIAUDF+'</td>'+
					'<td>'+data.data[i].CODUSU+'</td>'+
					'<td>'+data.data[i].CANMUE+'</td>'+
					'<td>'+data.data[i].CANDEF+'</td>'+
					'<td>'+data.data[i].PORNOCON+'</td>'+
					'<td>'+data.data[i].CANTIDAD+'</td>'+
				'</tr>';
			}
			document.getElementById("table-body-list-2").innerHTML=html;
			$(".panelCarga").fadeOut(100);
		}
	});
}
function start_apnc(){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		url:"config/tryStaAPNCFic.php",
		data:{
			codfic:codfic_v,
			fichaauto:1
		},
		success:function(data){
			console.log(data);
			if (data.state) {
				window.location.href="AudProNoCon.php?codfic="+codfic_v;
			}else{
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(100);
		}
	});
}
function start_apnc_o(){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		url:"config/tryStaAPNCFic.php",
		data:{
			codfic:$("#idcodfic").val(),
			fichaauto:0
		},
		success:function(data){
			console.log(data);
			if (data.state) {
				window.location.href="AudProNoCon.php?codfic="+$("#idcodfic").val();
			}else{
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(100);
		}
	});
}
$(document).ready(function(){
	$("#idopc1").click(function(){
		if (document.getElementById("idopc1").checked) {
			document.getElementById("content-opc1").style.display="flex";
			document.getElementById("content-opc2").style.display="none";
			document.getElementById("resultcontent-2").style.display="none";
		}else{
			document.getElementById("content-opc1").style.display="none";
			document.getElementById("content-opc2").style.display="flex";	
		}
		document.getElementById("resultcontent-3").style.display="none";
	});
	$("#idopc2").click(function(){
		if (document.getElementById("idopc2").checked) {
			document.getElementById("content-opc1").style.display="none";
			document.getElementById("content-opc2").style.display="flex";	
		}else{
			document.getElementById("content-opc1").style.display="flex";
			document.getElementById("content-opc2").style.display="none";
		}
		document.getElementById("resultcontent-3").style.display="none";
	});
	$("#idcodfic").keyup(function(e){
		if(e.keyCode==13){
			search_ficha();
		}
	});
	$("#idpedido").keyup(function(e){
		if(e.keyCode==13){
			search_pedido();
		}
	});
});
/*
var codAqlForUpdate=0;
function comenzarAuditoria(){
	var tipoMuestra="";
	var codAuditoria=0;
	var numMuestra=0;
	if (document.getElementById("idCheckAql").checked==true) {
		tipoMuestra="aql";
		codAqlForUpdate=fichaCodAql;
		sendParameters(codficFinal,tipoMuestra,numMuestra);
	}else{
		alert("Seleccione su tipo de muestra.");
	}
}

var fichaCodTad=0;
var fichaNumVez=0;
var fichaParte=0;
var fichaCodAql=0;
function fichaSelection(codfic,aql,codtad,numvez,parte,codaql){
	fichaCodTad=codtad;
	fichaNumVez=numvez;
	fichaParte=parte;
	fichaCodAql=codaql;
	document.getElementById("fichaSelected").style.display="block";
	$("#fichaSelected").empty();
	$("#fichaSelected").append("Ficha seleccionada: "+codfic);
	codficFinal=codfic;
	document.getElementById("aqlValue").innerHTML=aql+"%";
	document.getElementById("muestraSelection").style.display="block";	
	var checkList =document.getElementsByClassName("iptCheckBox");
	for (var i = 0; i < checkList.length; i++) {
		checkList[i].checked=false;
	}
	$(".iptForDiscrecional").css("display","none");
	$("#idNumberPrendas").val("");	
	$("#idCheckAql").click();
	$(".finalBtn").css("display","block");
}

function sendParameters(codficFinal,tipoMuestra,numMuestra){
	$(".panelCarga").fadeIn(200);
	var numeroPrendas=0;
	if($("#idNumberPrendas").val()!=""){
		numeroPrendas=$("#idNumberPrendas").val();
	}
	$.ajax({
		type:"POST",
		url:"config/updateFichaAPC.php",
		data:{			
			codfic:codficFinal,
			numvez:fichaNumVez,
			parte:fichaParte,
			codaql:fichaCodAql,
			codtad:fichaCodTad,
			tipaud:tipoMuestra,
			newnumero:numeroPrendas,
			codusu:codusu
		},
		success:function(data){
			//console.log(data);
			if(data.state==false){
				alert(data.err.description);
				$(".panelCarga").fadeOut(300);
			}else{
				window.location.href="AudProCor.php?codFic="+codficFinal+
				"&numvez="+fichaNumVez+"&parte="+fichaParte+"&codtad="+fichaCodTad+
				"&tipoMuestra="+tipoMuestra+"&numMuestra="+numMuestra+"&codaql="+fichaCodAql;
			}
		}
	});
}*/