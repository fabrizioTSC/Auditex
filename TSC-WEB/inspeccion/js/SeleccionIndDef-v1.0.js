var lineas=[];
$(document).ready(function(){
	$.ajax({
		type:"POST",
		data:{
		},
		url:"config/getAllLineas.php",
		success:function(data){
			console.log(data);
			lineas.push({'LINEA':0,'DESLIN':'(TODOS)'});
			for (var i = 0; i < data.lineas.length; i++) {
				lineas.push(data.lineas[i]);
			}
			var html='';
			for (var i = 0; i < lineas.length; i++) {
				html+='<div class="taller" onclick="selectLinea(\''+lineas[i].LINEA+'\',\''+formatText(lineas[i].DESLIN)+'\')">'+lineas[i].DESLIN+'</div>';
			}
			$("#spaceLineas").empty();
			$("#spaceLineas").append(html);

			$("#nombreLinea").val("(TODOS)");
			codlin_var="0";

			$(".panelCarga").fadeOut(200);			
		}
	});
	$("#nombreLinea").keyup(function(){
		var html='';
		for (var i = 0; i < lineas.length; i++) {
			if ((lineas[i].DESLIN.toUpperCase()).indexOf($("#nombreLinea").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="selectLinea(\''+lineas[i].LINEA+'\',\''+formatText(lineas[i].DESLIN)+'\')">'+lineas[i].DESLIN+'</div>';
			}
		}
		$("#spaceLineas").empty();
		$("#spaceLineas").append(html);	
	});
});

var codlin_var="";
function selectLinea(codlin,deslin){
	codlin_var=codlin;
	$("#nombreLinea").val(deslin);
}

function mostraIndRes(){
	if (codlin_var=="") {
		alert("Seleccione un taller primero!");
	}else{
		window.location.href="IndicadorDefectos.php?codlin="+codlin_var;
	}
}