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
	var heightDevice=window.screen.height;
	$(".menuContent").css("height",heightDevice+"px");
	$(".menuContent").click(function(){
		$(".menuContent").css("display","none");
	});
	$(".spaceMenu").click(function(e){
		e.stopPropagation();
	});	
	$("#idTallerName").keyup(function(){
		$(".listaTalleres").empty();
		var htmlTalleres="";
		var busqueda=document.getElementById("idTallerName").value;
		for (var i = 0; i < listaFichas[0].length; i++) {
			////console.log(listaTalleres[0][i].DESTLL.toUpperCase());
			if ((listaFichas[0][i].DESTLL.toUpperCase()).indexOf(busqueda.toUpperCase())>=0) {				
				htmlTalleres+='<div class="taller" onclick="addWord(\''+formatText(listaFichas[0][i].DESTLL)+'\',\''+listaFichas[0][i].CODTLL+'\')">'+listaFichas[0][i].DESTLL+"</div>";
			}
		}
		$(".listaTalleres").append(htmlTalleres);
	});
});

var listaFichas=[];
var usu_name_var="";
function chargeTallerIniFichas(usu_name){
	usu_name_var=usu_name;
	$.ajax({
		url:"config/getFichasAIniciar.php",
		type:"POST",
		data:{
			codfic:"0"
		},
		success:function(data){
			if (data.fichas.length>0) {
				$(".listaTalleres").empty();
				var htmlTalleres="";
				for (var i = 0; i < data.fichas.length; i++) {
					htmlTalleres+='<div class="taller" onclick="addWord(\''+formatText(data.fichas[i].DESTLL)+'\',\''+data.fichas[i].CODTLL+'\')">'+data.fichas[i].DESTLL+'</div>';
				}
				listaFichas.push(data.fichas);
				$(".listaTalleres").append(htmlTalleres);
			}else{
				$(".tblSelection").css("display","none");
				$("#idMsg").css("display","block");
			}
			$(".panelCarga").fadeOut(300);
		}
	});
}

var destll_var="";
var codtll_var="";
function addWord(destll,codtll){
	$("#hiddenSpace").css("display","none");
	$(".panelCarga").fadeIn(300);
	destll_var=destll;
	codtll_var=codtll;
	$("#idTallerName").val(destll_var);
	$.ajax({
		url:"config/getTalleresXFichaIniciar.php",
		data:{
			codtll:codtll_var
		},
		type:"POST",
		success:function(data){
			$("#fichasTaller").empty();
			var htmlContent="";
			for (var i = 0; i < data.fichas.length; i++) {
				htmlContent+=
				'<div class="tblLine">'+
					'<div class="itemBody" style="width: 50%;">'+data.fichas[i].CODFIC+'</div>'+
					//'<div class="itemBody" style="width: 50%;">'+data.fichas[i].PARTE+'</div>'+
					'<div class="itemBody" style="width: 50%;"><input data-ficha="'+data.fichas[i].CODFIC+'" class="iptCheck" type="checkbox" style="margin-bottom:0px;'+
					'width:18px;height:18px;"/></div>'+
				'</div>';
			}
			$("#fichasTaller").append(htmlContent);
			$("#hiddenSpace").css("display","block");
			$(".panelCarga").fadeOut(300);
		}
	});
}

function saveFichasIniciadas(){
	var arrayClass=document.getElementsByClassName("tblLine");
	var arrayFichas=[];
	for (var i = 0; i < arrayClass.length; i++) {
		var checkbox=arrayClass[i].getElementsByClassName("iptCheck")[0];
		if (checkbox.checked==true) {
			arrayFichas.push(checkbox.dataset.ficha);
		}
	}
	if (arrayFichas.length==0) {
		alert("No hay nada que guardar!");
	}else{
		$(".panelCarga").fadeIn(300);
		$.ajax({
			url:"config/saveStateFichasIniciar.php",
			type:"POST",
			data:{
				codtll:codtll_var,
				fichas:arrayFichas,
				usumov:usu_name_var
			},
			success:function(data){
				if (data.state==true) {
					addWord(destll_var,codtll_var);
				}else{
					alert(data.error.detail);
				}
				$(".panelCarga").fadeOut(300);
			}
		});
	}
}

function consultarFichaEstado(path){
	var codfic=$("#idCodFic").val();
	if (codfic=="") {
		alert("Complete el código de la ficha!");
	}else{
		location.href=path+"?codfic="+codfic;
	}
}
