var change="CAMBIO DE ESTILO";
var efi_top_param=0;
var efi_bottom_param=0;
var pren_top_param=0;
var pren_bottom_param=0;
var arrow_up='<i class="fa fa-arrow-up" aria-hidden="true" style="color:#008000;"></i>';
var arrow_down='<i class="fa fa-arrow-down" aria-hidden="true" style="color:#840b0b;"></i>';
var arrow_equals='<div style="font-size:65px;font-weight:bold;color:#ff9800;">=</div>';
$(document).ready(function(){
	var array=l.split("-");

	$.ajax({
		url:"config/getInfoRepMonitor.php",
		type:"POST",
		data:{
			l1:array[0],
			l2:array[1]
		},
		success:function(data){
			//console.log(data);
			efi_top_param=data.parametrosreportes[1].VALOR;
			efi_bottom_param=data.parametrosreportes[0].VALOR;
			pren_top_param=data.parametrosreportes[3].VALOR;
			pren_bottom_param=data.parametrosreportes[2].VALOR;
			fillContent(1,data.uno,array[0]);
			fillContent(2,data.dos,array[1]);
			activeRefresher();
			$(".panelCarga").fadeOut(200);
		},
		error:function (jqXHR, exception) {
	        window.location.reload();
	    }
	});
});

function fillContent(pos,data,l){
	if(l!="0"){
		if (data.ant_eficiencia!="-" && data.eficiencia!="-") {
			if (parseInt(data.eficiencia)>parseInt(data.ant_eficiencia)) {
				$("#arrow-eficiencia"+pos).append(arrow_up);
			}else{
				if(parseInt(data.eficiencia)!=parseInt(data.ant_eficiencia)){
					$("#arrow-eficiencia"+pos).append(arrow_down);
				}else{
					$("#arrow-eficiencia"+pos).append(arrow_equals);				
				}
			}
		}else{
			$("#arrow-eficiencia"+pos).append();
		}
		if (data.ant_eficacia!="-" && data.eficacia!="-") {
			if (parseInt(data.eficacia)>parseInt(data.ant_eficacia)) {
				$("#arrow-eficacia"+pos).append(arrow_up);
			}else{
				if(parseInt(data.eficacia)!=parseInt(data.ant_eficacia)){
					$("#arrow-eficacia"+pos).append(arrow_down);
				}else{
					$("#arrow-eficacia"+pos).append(arrow_equals);			
				}
			}
		}else{
			$("#arrow-eficacia"+pos).append();
		}
		$("#num_linea"+pos).text(""+l+" - T "+data.turno);
		$("#nom_cliente"+pos).text(data.cliente);
		if (data.flag_cambio) {
			$("#change"+pos).text(change);	
		}
		resizeTitle(pos,data.cliente.length);
		$("#pren_prod"+pos).text(formatMiles(data.prendas_producidas));
		$("#pren_defe"+pos).text(formatMiles(data.prendas_defectuosas));
		$("#eficiencia"+pos).text(data.eficiencia+"%");
		$("#eficacia"+pos).text(data.eficacia+"%");
		//$("#cuota"+pos).text(formatMiles(Math.round(parseInt(data.cuota)*data.factor).toString()));
		$("#cuota"+pos).text(formatMiles(Math.round(parseInt(data.cuota)).toString()));
		var pren_defe=0;
		if (data.prendas_inspecionadas!=0) {
			pren_defe=Math.round(data.prendas_defectuosas*100/data.prendas_inspecionadas);
		}
		$("#pren_defe_porc"+pos).text("("+pren_defe+"%)");
		if (pren_defe>pren_top_param) {
			$("#ctrl_defe_porc"+pos).addClass("content-red");
			$("#ctrl_repr_porc"+pos).addClass("content-red");
		}else{
			if (pren_defe<pren_bottom_param) {
				$("#ctrl_defe_porc"+pos).addClass("content-green");
				$("#ctrl_repr_porc"+pos).addClass("content-green");
			}else{
				$("#ctrl_defe_porc"+pos).addClass("content-yellow");
				$("#ctrl_repr_porc"+pos).addClass("content-yellow");
			}		
		}
		$("#pren_repr"+pos).text(formatMiles(data.prendas_reproceso));
		var pren_repr=0;
		if (data.prendas_inspecionadas!=0) {
			pren_repr=Math.round(data.prendas_reproceso*100/data.prendas_inspecionadas);
		}
		$("#pren_repr_porc"+pos).text("("+pren_repr+"%)");
		$("#proyeccion"+pos).text(formatMiles(Math.round(data.prendas_producidas*data.factor).toString()));
		if (data.eficiencia!="-") {
			var efi=parseInt(data.eficiencia);
			if (efi>efi_top_param) {
				addClasses(pos,"content-green");
			}else{
				if (efi<efi_bottom_param) {
					addClasses(pos,"content-red");
				}else{
					addClasses(pos,"content-yellow");
				}
			}
		}else{
			addClasses(pos,"content-green");		
		}
	}else{
		$("#main-content-"+pos).empty();
	}
}

function addClasses(pos,content){
	for (var i = 0; i < 6; i++) {
		$("#ctrl_efi_"+(i+1)+"_"+pos).addClass(content);
	}
}

function resizeTitle(pos,large){
	if (large>12) {
		if (large>19) {
			if(large>25){
				if (window.innerWidth>1200) {			
					if (window.innerWidth>2000) {
						$("#ctrl_size_nom"+pos).css("fontSize","70px");	
					}else{
						$("#ctrl_size_nom"+pos).css("fontSize","45px");	
					}
				}else{
					$("#ctrl_size_nom"+pos).css("fontSize","25px");					
				}
			}else{
				if (window.innerWidth>1200) {				
					if (window.innerWidth>2000) {
						$("#ctrl_size_nom"+pos).css("fontSize","80px");	
					}else{
						$("#ctrl_size_nom"+pos).css("fontSize","50px");	
					}
				}else{
					$("#ctrl_size_nom"+pos).css("fontSize","30px");					
				}
			}
		}else{
			if (window.innerWidth>1300) {
				if (window.innerWidth>2000) {
					$("#ctrl_size_nom"+pos).css("fontSize","100px");	
				}else{
					$("#ctrl_size_nom"+pos).css("paddingTop","30px");
					$("#ctrl_size_nom"+pos).css("height","calc(70% - 30px)");	
				}
			}else{
				$("#ctrl_size_nom"+pos).css("paddingTop","10px");
				$("#ctrl_size_nom"+pos).css("height","70%");					
			}				
		}
	}else{
		if (window.innerWidth>1300) {
			if (window.innerWidth>2000) {
				$("#ctrl_size_nom"+pos).css("fontSize","120px");	
			}else{
				$("#ctrl_size_nom"+pos).css("paddingTop","30px");
				$("#ctrl_size_nom"+pos).css("height","calc(70% - 30px)");	
			}
		}else{
			$("#ctrl_size_nom"+pos).css("paddingTop","10px");
			$("#ctrl_size_nom"+pos).css("height","70%");					
		}	
	}
}

function activeRefresher(){
	setTimeout(function(){
		window.location.reload();
	},60*5000);
}

function formatMiles(value){
	var i=value.length-1;
	var a=0;
	var aux="";
	while(i>=0){
		if (a%3==0 && a!=0) {
			aux=value[i]+","+aux;
		}else{
			aux=value[i]+aux;
		}
		a++;
		i--;
	}
	return aux;
}