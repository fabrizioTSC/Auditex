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
	$("#idFicha").keyup(function(){
		$("#fichasTaller").empty();
		var htmlContent="";
		for (var i = 0; i < array_fichas.length; i++) {
			if(array_fichas[i].CODFIC.indexOf($("#idFicha").val())>=0){
				htmlContent+=
				'<div class="tblLine">'+
					'<div class="itemBody" style="width: 50%;">'+array_fichas[i].CODFIC+'</div>'+
					'<div class="itemBody" style="width: 50%;"><input data-ficha="'+array_fichas[i].CODFIC+'" class="iptCheck" type="checkbox" style="margin-bottom:0px;'+
					'width:18px;height:18px;"/></div>'+
				'</div>';
			}
		}
		$("#fichasTaller").append(htmlContent);
	});
});

var listaFichas=[];
var usu_name_var="";
function chargeTallerTerFichas(usu_name){
	usu_name_var=usu_name;
	$.ajax({
		url:"config/getTalleresIniTer.php",
		type:"POST",
		data:{
			estado:"I"
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
var array_fichas=[];
function addWord(destll,codtll){
	$("#hiddenSpace").css("display","none");
	$(".panelCarga").fadeIn(300);
	destll_var=destll;
	codtll_var=codtll;
	$("#idTallerName").val(destll_var);
	$.ajax({
		url:"config/getFichasXTallerIniTer.php",
		data:{
			codtll:codtll_var,
			estado:"I"
		},
		type:"POST",
		success:function(data){
			array_fichas=data.fichas;
			$("#fichasTaller").empty();
			var htmlContent="";
			for (var i = 0; i < data.fichas.length; i++) {
				htmlContent+=
				'<div class="tblLine">'+
					'<div class="itemBody" style="width: 50%;">'+data.fichas[i].CODFIC+'</div>'+
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

function saveFichasTerminadas(){
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
			url:"config/saveStateFichasIniTer.php",
			type:"POST",
			data:{
				codtll:codtll_var,
				fichas:arrayFichas,
				usumov:usu_name_var,
				estado:'T',
				tipmov:3
			},
			success:function(data){
				if (!data.state) {
					alert(data.error.detail);
				}
				addWord(destll_var,codtll_var);
				$(".panelCarga").fadeOut(300);
			}
		});
	}
}