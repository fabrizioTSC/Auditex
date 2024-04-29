var listaTalleres=[];
$(document).ready(function(){
	$("#idTallerName").keyup(function(){
		$(".listaTalleres").empty();
		var htmlTalleres="";
		var busqueda=document.getElementById("idTallerName").value;
		for (var i = 0; i < listaTalleres[0].length; i++) {
			////console.log(listaTalleres[0][i].DESTLL.toUpperCase());
			if ((listaTalleres[0][i].DESTLL.toUpperCase()).indexOf(busqueda.toUpperCase())>=0) {				
				htmlTalleres+='<div class="taller" onclick="addWord(\''+formatText(listaTalleres[0][i].DESTLL)+'\',\''+listaTalleres[0][i].CODTLL+'\')">'+listaTalleres[0][i].DESTLL+"</div>";
			}
		}
		$(".listaTalleres").append(htmlTalleres);
	});
	$.ajax({
		type:"POST",
		url:"config/getTalleres.php",
		data:{
			request:"1"
		},
		success:function(data){
			$(".listaTalleres").empty();
			var htmlTalleres="";
			for (var i = 0; i < data.talleres.length; i++) {
				htmlTalleres+='<div class="taller" onclick="addWord(\''+formatText(data.talleres[i].DESTLL)+'\',\''+data.talleres[i].CODTLL+'\')">'+data.talleres[i].DESTLL+'</div>';
			}
			listaTalleres.push(data.talleres);
			$(".listaTalleres").append(htmlTalleres);
			$(".panelCarga").fadeOut(300);
		}
	});
	$("#idCodfic").keyup(function(){
		$(".tblBody").empty();
		var htmlFichas="";
		for (var i = 0; i < listaFichas.length; i++) {
			if(listaFichas[i].CODFIC.indexOf($("#idCodfic").val())>=0){
				htmlFichas+=
				'<div class="tblLine" onclick="fichaSelection('+listaFichas[i].CODFIC+')">'+
					'<div class="itemBody" style="width: calc(50% - 10px);">'+listaFichas[i].CODFIC+'</div>'+
					'<div class="itemBody" style="width: calc(50% - 10px);">'+listaFichas[i].CANPAR+'</div>'+
				'</div>';
			}
		}
		$(".tblBody").append(htmlFichas);
	});
});

function formatText(string){
	while(string.indexOf('"')>0){
		string=string.replace('"','');
	}
	while(string.indexOf('\'')>0){
		string=string.replace('\'','');
	}
	return string;
}

var codtll_var;
function addWord(word,codtll){
	$("#idDesTll").text(word);
	codtll_var=codtll;
	getFichas(codtll_var);
}

var listaFichas=[];
function getFichas(codtll){
	$(".panelCarga").fadeIn(200);
	$.ajax({
		type:"POST",
		url:"config/getFichasAudPro.php",
		data:{
			codtll:codtll
		},
		success:function(data){
			console.log(data);
			if (data.state==false) {
				alert(data.description);
			}else{
				listaFichas=data.fichas;
				$(".tblBody").empty();
				var htmlFichas="";
				for (var i = 0; i < data.fichas.length; i++) {
					htmlFichas+=
					'<div class="tblLine" onclick="fichaSelection('+data.fichas[i].CODFIC+')">'+
						'<div class="itemBody" style="width: calc(50% - 10px);">'+data.fichas[i].CODFIC+'</div>'+
						'<div class="itemBody" style="width: calc(50% - 10px);">'+data.fichas[i].CANPAR+'</div>'+
					'</div>';
				}
				$(".tblBody").append(htmlFichas);						
			}

			$("#space2").css("display","block");
			$("#space1").css("display","none");
			$(".panelCarga").fadeOut(300);
		}
	});
}

function backLineas(){
	$("#space1").css("display","block");
	$("#space2").css("display","none");
}

function fichaSelection(codfic){
	$("#idCodFic").text(codfic);
	$("#space3").css("display","block");
	$("#space2").css("display","none");
}

function backFichas(){
	$("#space2").css("display","block");
	$("#space3").css("display","none");
}

function irAuditoriaProceso(){
	$(".panelCarga").fadeIn(200);
	$.ajax({
		type:"POST",
		url:"config/validateIniciado.php",
		data:{
			codfic:$("#idCodFic").text(),
			codtll:codtll_var
		},
		success:function(data){
			console.log(data);
			if (data.state) {
				location.href="RegistrarAuditoriaProceso.php?codfic="+$("#idCodFic").text()+"&turno=1&codtll="+codtll_var;
			}else{
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(200);
		}
	});
}