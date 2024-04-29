let LINEAS = [];

$(document).ready(function(){
	$.ajax({
		type:"POST",
		url:"config/getAllLineas2.php",
		success:function(data){
            let js = JSON.parse(data);
            let contador = 0;
            let lineas ='<div class="sameline-s2">'+
            '<div class="sameline-inter">';
            //ARMANDO LINEAS
            js.forEach(function(obj){

                if (contador  < js.length  ) {
					lineas+='<div class="itemMainContent">'+
							'<div class="bodySpecialButton" data-linea="'+obj.linea+'">'+
								'<div class="icon"><i class="fa fa-check-circle" aria-hidden="true"></i></div>'+
								'<div class="detailSpecialButton">L&Iacute;NEA '+obj.linea+'</div>'+
							'</div>'+
                        '</div>';
                    if(contador == js.length -1){
                        lineas+='<div class="itemMainContent">'+
                        '<div class="bodySpecialButton" data-linea="0">'+
                            '<div class="icon"><i class="fa fa-check-circle" aria-hidden="true"></i></div>'+
                            '<div class="detailSpecialButton">NINGUNA</div>'+
                        '</div>'+
                    '</div>';   
                    }
				}
				if(contador  % 4 ==3){
					lineas+='</div>'+
					'</div>'+
					'<div class="sameline-s2">'+
				'<div class="sameline-inter">';
				}else{
					if(contador % 2 == 1){
						lineas+='</div>'+
						'<div class="sameline-inter">';
					}
                }

                contador++;
                
            });
			$("#space-to-charge").html(lineas);
            //OCULTANDO PANEL DE CARGA
			$(".panelCarga").fadeOut(200);
        }
	});

});



//ACTIVANDO Y DESACTIVANDO LINEAS PARA EL FILTRO
$("#space-to-charge").on('click','.bodySpecialButton',function(){
    let idlinea = $(this).attr("data-linea");

    //VERIFICA SI TIENE LA CLASE
    if($(this).hasClass("bodySelected")){
        $(this).removeClass("bodySelected");
        //OPTENIENDO EL INDICE
        let i = LINEAS.indexOf(idlinea);
        //REMOVIENDO 
        LINEAS.splice(i,1);

    }else{
        $(this).addClass("bodySelected");
        //AGREGANDO DATO AL ARRAY
        LINEAS.push(idlinea);
    }

    console.log(LINEAS);
});

//MUESTRA REPORTES
function mostrarReporte(){
    if(LINEAS.length > 0){
        let linea = "";
        for(let x = 0; x < LINEAS.length ; x++){
            if(x <= 0){
                linea += LINEAS[x];
            }else{
                linea += "," + LINEAS[x];
            }
        }
        console
        location.href = "ReporteLineas2.php?lineas="+linea+"&finicio="+$("#idFecha").val()+"&ffin="+$("#idFechaFin").val();


    }else{
        alert("Seleccione al menos una línea");
    }
}

