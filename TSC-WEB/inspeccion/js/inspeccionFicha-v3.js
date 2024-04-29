$(document).ready(function(){
	var winWid=(window.innerWidth-220)/2;
	$(".contentMsgInstant").css("left",winWid+"px");
	searchFicha();
	/* INICIO - AJUSTAR CABECERA */
	var arrayClass=document.getElementsByClassName("class"+1);
	var arrayInside=arrayClass[0].getElementsByClassName("itemblock");
	var numrows=arrayInside.length;
	$("#idContainerHeader").css("width",(numrows*140-12)+"px");
	$("#contentSelect").css("width",(numrows*140-12)+"px");
	$(".bigitemTable").css("width",(numrows*140+142-12)+"px");
	/* FIN - AJUSTAR CABECERA */

	/*
	$("#idSelectTipDef").change(function(){
		var value_select=$("#idSelectTipDef").val();
		//console.log(value_select);
		$(".classcontainer").css("display","none");
		$(".class"+value_select).css("display","flex");
		var arrayClass=document.getElementsByClassName("class"+value_select);
		var arrayInside=arrayClass[0].getElementsByClassName("itemblock");
		var numrows=arrayInside.length;
		$("#idContainerHeader").css("width",(numrows*140-12)+"px");
		$("#contentSelect").css("width",(numrows*140-12)+"px");
		$(".bigitemTable").css("width",(numrows*140+142-12)+"px");

		$(".tableforinspec").scrollLeft(0);
		$(".classBlockLateral").css("position","relative");
		$(".classBlockLateral").css("left","0px");
		$(".bigitemTable").css("width",(numrows*140+142-12)+"px");
	});*/


	var iniV=0;
	var iniH=0;
	$(".tableforinspec").scroll(function(){
		var posTable=parseInt($(".tableforinspec").scrollTop());
		if (iniV!=posTable) {
			if (posTable!=0) {
				$(".headerTable").css("position","absolute");
				$(".headerTable").css("top",posTable+"px");
			}else{
				$(".headerTable").css("position","relative");
				$(".headerTable").css("top","0px");
			}
		}		
		var scrollH=parseInt($(".tableforinspec").scrollLeft());
		if (iniH!=scrollH) {
			var value_select=codfam_var;
			var arrayClass=document.getElementsByClassName("class"+value_select);
			var arrayInside=arrayClass[0].getElementsByClassName("itemblock");
			var numrows=arrayInside.length;

			var widWin=window.innerWidth;
			var widHea=parseInt($(".bigitemTable").css("width").replace("px",""));
			if (scrollH!=0) {
				if(widHea-60>widWin){
					$(".classBlockLateral").css("position","absolute");
					$(".classBlockLateral").css("left",scrollH+"px");
					$(".bigitemTable").css("width",(numrows*140-12)+"px");
				}
			}else{
				$(".classBlockLateral").css("position","relative");
				$(".classBlockLateral").css("left","0px");
				$(".bigitemTable").css("width",(numrows*140+142-12)+"px");
			}
		}
		iniV=posTable;
		iniH=scrollH;
	});
	$("#idDefectoSearch").keyup(function(){
		var defLook=$("#idDefectoSearch").val();
		var arrayClass=document.getElementsByClassName("class"+codfam_var);
		var arrayDefectos=arrayClass[0].getElementsByClassName("classDefToHide");
		for (var i = 0; i < arrayDefectos.length; i++) {
			if((arrayDefectos[i].dataset.desdef.toUpperCase()).indexOf(defLook.toUpperCase())>=0){
				arrayDefectos[i].style.display="block";
				$(".classDefToHide"+arrayDefectos[i].dataset.coddef).css("display","block");
			}else{
				arrayDefectos[i].style.display="none";
				$(".classDefToHide"+arrayDefectos[i].dataset.coddef).css("display","none");
			}
		}
	});
});

var codfam_var=1;
function showContent(codfam){
	if($(".modalDefectos").css("display")=="block"){
		resetFilter();
	}
	codfam_var=codfam;
	var value_select=codfam;
	//console.log(value_select);
	$(".classcontainer").css("display","none");
	$(".class"+value_select).css("display","flex");
	var arrayClass=document.getElementsByClassName("class"+value_select);
	var arrayInside=arrayClass[0].getElementsByClassName("itemblock");
	var numrows=arrayInside.length;
	$("#idContainerHeader").css("width",(numrows*140-12)+"px");
	$("#contentSelect").css("width",(numrows*140-12)+"px");
	$(".bigitemTable").css("width",(numrows*140+142-12)+"px");

	$(".tableforinspec").scrollLeft(0);
	$(".classBlockLateral").css("position","relative");
	$(".classBlockLateral").css("left","0px");
	$(".bigitemTable").css("width",(numrows*140+142-12)+"px");
}

function hideDetalle(){
	if ($("#detailInspeccion").css("display")=="block") {
		$("#detailInspeccion").fadeOut(200);
		$("#btnHideDetalle").text("Mostrar detalle");
	}else{
		$("#detailInspeccion").fadeIn(200);
		$("#btnHideDetalle").text("Ocultar detalle");
	}
}

function addValue(codope,coddef){
	var id="OPE"+codope+"DEF"+coddef;
	var valueNum=parseInt($("#"+id).text());
	valueNum++;
	$("#"+id).empty();
	$("#"+id).append(valueNum);
	var defCont=parseInt($("#def"+coddef).text())+1;
	$("#def"+coddef).html(defCont);
	var opeCont=parseInt($("#ope"+codope).text())+1;
	$("#ope"+codope).html(opeCont);
}

var waitTap;
var tapCounter=0;
function desValue(codope,coddef){
	event.stopPropagation();
	tapCounter++;
	waitTap=setTimeout(function(){
		tapCounter=0;
	},1000);
	if (tapCounter==2) {
		clearInterval(waitTap);
		var id="OPE"+codope+"DEF"+coddef;
		var valueNum=parseInt($("#"+id).text());
		if (valueNum!=0) {
			valueNum--;
			$("#"+id).empty();
			$("#"+id).append(valueNum);
			var defCont=parseInt($("#def"+coddef).text());
			$("#def"+coddef).html(defCont-1);
			var opeCont=parseInt($("#ope"+codope).text());
			$("#ope"+codope).html(opeCont-1);
			showMsg("Defecto quitado!");
		}
		tapCounter=0;
	}
}

function addTotalValue(id_val){
	var valueNum=parseInt($("#"+id_val).text());
	valueNum++;
	$("#"+id_val).empty();
	$("#"+id_val).append(valueNum);	
}
function desTotalValue(id_val){
	event.stopPropagation();
	var valueNum=parseInt($("#"+id_val).text());
	if (valueNum!=0) {
		valueNum--;
		$("#"+id_val).empty();
		$("#"+id_val).append(valueNum);
	}
}

function searchFicha(){
	$("#idresultFicha").css("display","none");
	$.ajax({
		type:"POST",
		url:"config/searchFicha.php",
		data:{
			codfic:codfic
		},
		success:function(data){
			console.log(data);
			if(data.state==true){
				$("#idLinea").text(data.ficha.linea);
				$("#idColor").text(data.ficha.color);
				$("#idEstilo").text(data.ficha.estilo);
				$("#idTurno").text(turno);
				$("#idCliente").text(data.ficha.cliente);
				$("#idCodFic").text(codfic);
			}else{
				alert(data.detail);
			}
			$("#idresultFicha").css("display","block");
			$("#PlaceToSearch").css("display","none");
			$(".panelCarga").fadeOut(200);
			if (data.operaciones.length>0) {
				for (var i = 0; i < data.operaciones.length; i++) {
					$("#headerope"+data.operaciones[i]).css("display","block");
					$("#contenope"+data.operaciones[i]).css("display","flex");
				}
			}
		}
	});
}

var arrayToSend=[];
function saveInspeccion(){
	var arrayDO=document.getElementsByClassName("divBtnsAddMinus");
	arrayToSend=[];
	var contTotalDef=0;
	for (var i = 0; i < arrayDO.length; i++) {
		var aux=[];
		if(arrayDO[i].innerHTML!="0"){
			aux.push(arrayDO[i].dataset.ope);
			aux.push(arrayDO[i].dataset.def);
			aux.push(arrayDO[i].innerHTML);
			contTotalDef=contTotalDef+parseInt(arrayDO[i].innerHTML);
			arrayToSend.push(aux);
		}
	}
	var manualTotal=parseInt($("#idNumPreDefNumNew").text());
	if (contTotalDef<manualTotal) {
		alert("Los defectos/operaciones son menores a los defectos totales!");
	}else{
		if ((manualTotal==""||manualTotal==0)&&contTotalDef>0) {
			alert("Debe indicar la cantidad de prendas con defecto!");
		}else{
			if (arrayToSend.length==0) {
				var val=confirm("Desea guardar sin defectos?");
				if (val==true) {
					confirmSaveInpeccion();
				}
			}else{
				confirmSaveInpeccion();
			}
		}
	}
}

function confirmSaveInpeccion(){
	console.log(arrayToSend);
	if ($("#idcanpre").val()=="" || $("#idcanpre").val()=="0") {
		alert("Complete la cantidad de prendas!");
		$("#idcanpre").focus();
	}else{
		$(".panelCarga").fadeIn(200);
		$.ajax({
			url:"config/save_inspeccion.php",
			type:"POST",
			data:{
				codusu:codusu_var,
				codfic:codfic,
				turinscos:turno,
				canpre:$("#idcanpre").val(),
				canpredef:$("#idNumPreDefNumNew").text(),
				codtll:codtll,
				array:arrayToSend,
				codstl:$("#idEstilo").text()
			},
			success:function(data){
				console.log(data);
				
				if (data.state==true) {
					alert(data.detail);
					location.href="main.php"
				}else{
					alert(data.error.detail);
				}
				
				$(".panelCarga").fadeOut(200);
			}
		});
	}
}

function showMsg(msg){
	$(".contentMsgInstant").text(msg);
	$(".contentMsgInstant").fadeIn(100);
	setTimeout(function(){
		$(".contentMsgInstant").fadeOut(100);
	},2000);
}

function addOperacion(){
	$(".selectionOpeModal").fadeIn(200);
}

function confirmAddOpe(){
	var codope=$("#seleccionope").val();
	$("#headerope"+codope).css("display","block");
	$("#contenope"+codope).css("display","flex");
	closeModal('selectionOpeModal');
}

function closeModal(class_name){
	$("."+class_name).fadeOut(200);	
	if (class_name=='modalDefectos') {
		resetFilter();
	}
}

function filterDefecto(){
	$(".modalDefectos").fadeIn(200);
}

function resetFilter(){
	var arrayClass=document.getElementsByClassName("class"+codfam_var);
	var arrayDefectos=arrayClass[0].getElementsByClassName("classDefToHide");
	for (var i = 0; i < arrayDefectos.length; i++) {
		arrayDefectos[i].style.display="block";
		$(".classDefToHide"+arrayDefectos[i].dataset.coddef).css("display","block");
	}
	$("#idDefectoSearch").val("");
}