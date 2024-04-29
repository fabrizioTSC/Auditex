$(document).ready(function(){
	$.ajax({
		type:"POST",
		url:"config/getAllLineas.php",
		success:function(data){
			console.log(data);
			var html='<div class="sameline-s2">'+
				'<div class="sameline-inter">';
			for (var i = 0; i <= data.lineas.length; i++) {
				if (i==data.lineas.length) {
					html+='<div class="itemMainContent">'+
							'<div class="bodySpecialButton" data-linea="0" data-clear="1">'+
								'<div class="icon"><i class="fa fa-check-circle" aria-hidden="true"></i></div>'+
								'<div class="detailSpecialButton">TODOS</div>'+
							'</div>'+
						'</div>';
				}else{
					html+='<div class="itemMainContent">'+
							'<div class="bodySpecialButton" data-linea="'+data.lineas[i].LINEA+'" data-clear="0">'+
								'<div class="icon"><i class="fa fa-check-circle" aria-hidden="true"></i></div>'+
								'<div class="detailSpecialButton">L&Iacute;NEA '+data.lineas[i].LINEA+'</div>'+
							'</div>'+
						'</div>';
				}
				if(i%4==3){
					html+='</div>'+
					'</div>'+
					'<div class="sameline-s2">'+
				'<div class="sameline-inter">';
				}else{
					if(i%2==1){
						html+='</div>'+
						'<div class="sameline-inter">';
					}
				}
			}
			html+='</div>'+
				'</div>'+
				'<script>'+
					'$(".bodySpecialButton").click(function(){'+
						'activeElements(this);'+
					'});';
				'</script>';
			$("#space-to-charge").empty();
			$("#space-to-charge").append(html);
			
			$(".panelCarga").fadeOut(200);
		}
	});
	var fecha=new Date();
	var dia=fecha.getDate();
	dia=""+dia;
	if (dia.length==1) {
		dia="0"+dia;
	}
	var mes=fecha.getMonth()+1;
	mes=""+mes;
	if (mes.length==1) {
		mes="0"+mes;
	}
	var anio=fecha.getFullYear();
	var hoy=anio+"-"+mes+"-"+dia;
	document.getElementById("idFecha").value=hoy;
	document.getElementById("idFechaFin").value=hoy;
});

function activeElements(dom){
	//console.log(dom.classList);
	if(dom.classList.value.indexOf("bodySelected")>=0){
		dom.classList.remove("bodySelected");
	}else{
		dom.classList.add("bodySelected");
	}
	if (dom.dataset.clear=="1") {
		let ar=document.getElementsByClassName("bodySpecialButton");
		for (var i = 0; i < ar.length; i++) {
			if(ar[i].dataset.clear=="0"){
				ar[i].classList.remove("bodySelected");
			}
		}
	}
}

function verreporte(){
	var ar_lineas=document.getElementsByClassName("bodySelected");
	if (ar_lineas.length==0) {
		alert("Seleccione las lineas a consultar!");
	}else{
		var lineas="";
		for (var i = 0; i < ar_lineas.length; i++) {
			lineas+=ar_lineas[i].dataset.linea;
			if (i!=ar_lineas.length-1) {
				lineas+="-";
			}
		}
		window.location.href="ReporteDefectos.php?l="+lineas+"&fecha="+document.getElementById("idFecha").value+
		"&fechafin="+document.getElementById("idFechaFin").value;
	}
}