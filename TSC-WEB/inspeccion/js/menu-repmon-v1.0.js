
var l1="-";
var l2="-";
var l1des="-";
var l2des="-";

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
							'<div class="bodySpecialButton" data-linea="0">'+
								'<div class="icon"><i class="fa fa-check-circle" aria-hidden="true"></i></div>'+
								'<div class="detailSpecialButton">NINGUNA</div>'+
							'</div>'+
						'</div>';
				}else{
					html+='<div class="itemMainContent">'+
							'<div class="bodySpecialButton" data-linea="'+data.lineas[i].LINEA+'" data-deslinea="'+data.lineas[i].DESLIN+'" >'+
								'<div class="icon"><i class="fa fa-check-circle" aria-hidden="true"></i></div>'+
								// '<div class="detailSpecialButton">L&Iacute;NEA '+data.lineas[i].LINEA+'</div>'+
								'<div class="detailSpecialButton">'+data.lineas[i].DESLIN+'</div>'+

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
	});/*
	$(".bodySpecialButton").click(function(){
		if (this.dataset.linea!=l1 && this.dataset.linea!=l2) {
			if (l1=="0" && l2=="0") {
				l2=this.dataset.linea;
			}else{
				l1=l2;
				l2=this.dataset.linea;
			}
			var array=document.getElementsByClassName("bodySpecialButton");
			for (var i = 0; i < array.length; i++) {
				array[i].classList.remove("bodySelected");
				if(array[i].dataset.linea==l1 || array[i].dataset.linea==l2){
					array[i].classList.add("bodySelected");	
				}
			}
		}
	});*/
});

function activeElements(dom){
	if (dom.dataset.linea!=l1 && dom.dataset.linea!=l2) {
		if (l1=="-" && l2=="-") {
			l2=dom.dataset.linea;

			// DES LINEA
			l2des=dom.dataset.deslinea;
		}else{
			l1=l2;
			l2=dom.dataset.linea;

			// DES LINEA
			l1des = l2des;
			l2des = dom.dataset.deslinea;
		}
		var array=document.getElementsByClassName("bodySpecialButton");
		for (var i = 0; i < array.length; i++) {
			array[i].classList.remove("bodySelected");
			if(array[i].dataset.linea==l1 || array[i].dataset.linea==l2){
				array[i].classList.add("bodySelected");	
			}
		}
	}	
}

function goMonitor(){
	window.location.href="ReporteMonitor.php?l="+$("#lin1").val()+"-"+$("#lin2").val();
}
function verreporte(){
	if (l1=="-" || l2=="-") {
		alert("Seleccione 2 linea a mostrar!");
	}else{
		window.location.href="ReporteMonitor.php?l="+l1+"-"+l2+"&ldes="+l1des+"|"+l2des;
	}
}