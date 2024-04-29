var val_round=100;
let TIPOMEDIDA = null;

$(document).ready(function(){
	$("#resume-medida").scroll(function(){
		var des=$("#resume-medida").scrollTop();
		if (des>20) {
			$("#space-res-hader").css("position","absolute");
			$("#space-res-hader").css("top",$("#resume-medida").scrollTop()+"px");
		}else{
			$("#space-res-hader").css("position","relative");
			$("#space-res-hader").css("top","0px");
		}
	});
	$("#idresultado").change(function(){
		if ($("#idresultado").val()=="C") {
			$("#content-obs").css("display","block");
		}else{
			$("#content-obs").css("display","none");
			$("#idobservacion").val("");
		}
	});
	$.ajax({
		url:"config/getValidatePreviewFicAudCor.php",
		type:"POST",
		data:{
			codfic:codfic,
			hilo:hilo*val_round,
			travez:travez*val_round,
			largmanga:largmanga*val_round
		},
		success:function (data){
			console.log(data);
			if (data.detalle.length>0) {


				// TIPO DE MEDIDA
				TIPOMEDIDA = data.data.TIPOMEDIDA;


				$("#CanXTalla").val(data.numpre);
				var html='';
				var html2='';
				html2+=
				'<div style="display:flex;">'+
					'<div class="column-tbl">'+
						'<div class="header-item item-center item-c0"></div>'+
						'<div class="header-item item-maxheight">Prenda</div>'+
					'</div>';
				html+=
				'<div class="column-tbl">';
				for (var j = 0; j < data.numpre; j++) {
					for (var i = 0; i < data.talla.length; i++) {
						html+=
					'<div class="header-item item-center item-c2">'+(j+1)+'</div>';
					}
				}
				html+=					
				'</div>';

				html2+=
					'<div class="column-tbl">'+
						'<div class="header-item">Medida</div>'+
						'<div class="header-item item-maxheight">Talla</div>'+
					'</div>';
				html+=
				'<div class="column-tbl">';
				for (var j = 0; j < data.numpre; j++) {
					for (var i = 0; i < data.talla.length; i++) {
						html+=
					'<div class="header-item item-center item-c2">'+data.talla[i].DESTAL+'</div>';	
					}
				}
				html+=
					'<div class="header-item item-center item-c0"></div>';
				for (var i = 0; i < data.talla.length; i++) {
						html+=
					'<div class="header-item item-center item-c2">'+data.talla[i].DESTAL+'</div>';	
				}
				html+=
				'</div>';

				var ant_nom=data.detalle[0].CODMED;
				for (var i = 0; i < data.detalle.length; i++) {
					if (data.detalle[i].CODMED!=ant_nom) {
						html+=
					'<div class="header-item item-center item-c0"></div>';
						for (var k = 0; k < data.detalletalla.length; k++) {
							if (data.detalletalla[k].CODMED==ant_nom) {
								html+=
					'<div class="header-item item-s2 item-center item-c3">'+data.detalletalla[k].MEDIDA+'</div>';	
							}
						}

						html2+=
					'<div class="column-tbl-s2">'+
						'<div class="header-item item-s2">'+data.detalle[i].DESMEDCOR+'</div>'+
						'<div class="header-item item-s2 item-maxheight" title="'+correct_text(data.detalle[i].DESMED)+'">'+data.detalle[i].DESMED+'</div>'+
					'</div>';
						html+=
				'</div>'+
				'<div class="column-tbl-s2">';
						ant_nom=data.detalle[i].CODMED;
					}
					if (i==0) {
						html2+=
					'<div class="column-tbl-s2">'+
						'<div class="header-item item-s2">'+data.detalle[i].DESMEDCOR+'</div>'+
						'<div class="header-item item-s2 item-maxheight" title="'+correct_text(data.detalle[i].DESMED)+'">'+data.detalle[i].DESMED+'</div>'+
					'</div>';

						html+=
				'<div class="column-tbl-s2">';
					}
					var style=" item-c3";
					if(data.detalle[i].TOLVAL==1){
						style=" item-c5";
					}else{
						if(data.detalle[i].TOLVAL==0){
							style=" item-c4";
						}
					}
					if (data.detalle[i].VALOR!=null) {
						html+=
					'<div class="header-item item-s2 item-center'+style+'">'+data.detalle[i].VALOR+'</div>';
					}else{
						html+=
					'<div class="header-item item-s2 item-center'+style+'"></div>';
					}
				}
				html+=
					'<div class="header-item item-center item-c0"></div>';
				for (var k = 0; k < data.detalletalla.length; k++) {
					if (data.detalletalla[k].CODMED==ant_nom) {
						html+=
					'<div class="header-item item-s2 item-center item-c3">'+data.detalletalla[k].MEDIDA+'</div>';	
					}
				}
				html2+=
				'</div>';
				html+=
				'</div>';

				$("#space-res-hader").append(html2);
				$("#space-tbl-medidas").append(html);
				$("#resume-medida").css("display","block");
			}else{
				$("#btndescarga").remove();
			}
			if (data.data.OBSRESULTADOMED!="") {
				$("#content-obs").css("display","block");
				$("#idobservacion").val(data.data.OBSRESULTADOMED);
			}
			$("#idresultado").val(data.data.RESULTADOMED);

			$(".panelCarga").fadeOut(100);
		}
	});
	
	//		$(".panelCarga").fadeOut(100);
});

function delete_ficha(){
	var c=confirm("Seguro que desea eliminar los registros de la ficha?");
	if (c) {
		$(".panelCarga").fadeIn(100);
		$.ajax({
			url:"config/deleteFichaRegMed.php",
			type:"POST",
			data:{
				codfic:codfic,
				hilo:hilo*val_round,
				travez:travez*val_round,
				largmanga:largmanga*val_round
			},
			success:function (data){
				console.log(data);
				if (data.state) {
					window.location.reload();
				}else{
					alert(data.detail);
					$(".panelCarga").fadeOut(100);
				}
			}
		});
	}
}

var last_pos=0;
var array_tallas=[];
var ar_var_med=['1','7/8','3/4','5/8','1/2','3/8','1/4','1/8','0','-1/8','-1/4','-3/8','-1/2','-5/8','-3/4','-7/8','-1'];
function generateTable(){
	if ($("#CanXTalla").val()>=1) {
		$(".panelCarga").fadeIn(100);
		$.ajax({
			url:"config/getDetalleMedidas.php",
			type:"POST",
			data:{
				codfic:codfic,
				hilo:hilo*val_round,
				travez:travez*val_round,
				largmanga:largmanga*val_round,
				cantidad:$("#CanXTalla").val(),
				tipomedida : TIPOMEDIDA

			},
			success:function (data){
				console.log(data);
				if (data.state) {
					if (data.detalle.length==0) {
						alert("No hay medidas para mostrar");
						$(".panelCarga").fadeOut(100);
						return;
					}
					$("#content-main").css("display","none");

					var html2=
					'<div class="header-content">';
					var ant_codtal='';
					var pos=1;
					for (var i = 0; i < data.heamedtal.length; i++) {
						if(data.heamedtal[i].CODTAL!=ant_codtal){
							ant_codtal=data.heamedtal[i].CODTAL;
							if (i!=0) {
								html2+=
						'</div>';
								style="none";
							}else{
								style="flex";
							}
							html2+=
						'<div class="content-medida headers header-'+pos+'" style="display:'+style+';">'+					
							'<div class="column-tbl column-tbl-static">'+
								'<div class="header-item">C. Med.</div>'+
								'<div class="header-item">Medida</div>'+
								'<div class="header-item item-maxheight">Desc.</div>'+
							'</div>';
							pos++;
						}
						html2+=
							'<div class="column-tbl-s2">'+
								'<div class="header-item item-s2">'+data.heamedtal[i].DESMEDCOR+'</div>'+
								'<div class="header-item item-s2">'+data.heamedtal[i].MEDIDA+'</div>'+
								'<div class="header-item item-s2 item-maxheight" title="'+correct_text(data.heamedtal[i].DESMED)+'">'+data.heamedtal[i].DESMED+'</div>'+
							'</div>';
					}
					html2+=
						'</div>'+
					'</div>';

					var html='';
					var destal="";
					var display='style="display:block;"';
					var k=0;
					last_pos=parseInt(data.cont);
					var html_btns='<div class="content-btns-prenda">';
					var html_spans='';
					for (var l = 0; l < parseInt($("#CanXTalla").val()); l++) {
						if (l==0) {
							html_btns+='<button class="btn-prenda btn-prenda-select" onclick="select_btn(this,\''+(l+1)+'\')">'+(l+1)+'</button>';
						}else{
							html_btns+='<button class="btn-prenda" onclick="select_btn(this,\''+(l+1)+'\')">'+(l+1)+'</button>';
						}
						html_spans+='<span class="span-spe span-'+(l+1)+'"></span>';
					}
					$("#space-btns-prendas").append(html_btns);

					// CARGAMOS MEDIDAS
					let RANGOMEDIDAS =  data.rangomedidas;
					ar_var_med = [];

					for(let item of RANGOMEDIDAS){
						ar_var_med.push(item.MEDIDA);
					}


					for (var i = 0; i < data.detalle.length; i++) {
						if(data.detalle[i].DESTAL!=destal){
							k++;
							if (k>1) {
								html+=
						'</div>'+
						'<div class="title-medida tit-special">'+(k-1)+' de '+data.cont+'</div>'+
					'</div>';
								display='style="display:none;"';
							}
							html_btns+='</div>';
								html+=
					'<div class="main-content-medida content'+k+'" data-pos="'+k+'" '+display+'>'+
						'<div class="content-medida">'+	
							'<div class="column-tbl column-tbl-static">';
								for (var l = 0; l < ar_var_med.length; l++) {
									if (ar_var_med[l]=="0") {
										html+=
								'<div class="header-item item-center item-c4">'+ar_var_med[l]+'</div>';
									}else{
										html+=
								'<div class="header-item item-center item-c2">'+ar_var_med[l]+'</div>';
									}
								}
								html+=
							'</div>';
							destal=data.detalle[i].DESTAL;
							array_tallas.push(destal);
						}

						html+=
							'<div class="column-tbl-s2">'+
								'<div class="content-validate contentButton-'+data.detalle[i].CODMED+'-'+data.detalle[i].CODTAL+'" data-clicked="0">';
						var style_tol=' item-c3';
						var val_tol='2';
								for (var l = 0; l < ar_var_med.length; l++) {
									if (ar_var_med[l]==data.detalle[i].TOLERANCIAMAS) {
										style_tol=' item-c5';
										val_tol='1';
									}
									if (l>0 && ar_var_med[l-1]=="-"+data.detalle[i].TOLERANCIAMENOS && parseInt(ar_var_med[l-1])<0) {
										style_tol=' item-c3';
										val_tol='2';
									}
									if (i==0) {
										//console.log("-"+ar_var_med[l]);
									}
									if (ar_var_med[l]=="0") {
										html+=
									'<div class="header-item item-center item-s2 item-c4 dato-0" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\'0\',this,0)">'+html_spans+'</div>';
									}else{
										html+=
									'<div class="header-item item-center item-s2'+style_tol+' dato-'+ar_var_med[l]+'" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\''+ar_var_med[l]+'\',this,'+val_tol+')">'+html_spans+'</div>';
									}
								}
						html+=								
								'</div>'+
							'</div>';
					}
					html+=
						'</div>'+
						'<div class="title-medida tit-special">'+k+' de '+data.cont+'</div>'+
					'</div>';
					$("#talla-select").text(array_tallas[0]);
					$("#space-tbl-generate").append(html2);
					$("#space-tbl-generate").append(html);
					$("#second-frame").css("display","block");
					//if (data.replicar==true) {
						replicar_informacion(data.guardado);
					//}

					let tblpart1=document.getElementsByClassName("main-content-medida")[0].offsetHeight;
					let tblpart2=document.getElementsByClassName("header-content")[0].offsetHeight;
					let totalspace=document.getElementById("space-tbl-generate").offsetHeight;
					if (tblpart1+tblpart2-totalspace>=tblpart2) {
						$("#space-tbl-generate").scroll(function(){
							var des=$("#space-tbl-generate").scrollTop();
							if (des>20) {
								$(".header-content").css("position","absolute");
								$(".header-content").css("top",$("#space-tbl-generate").scrollTop()+"px");
							}else{
								$(".header-content").css("position","relative");
								$(".header-content").css("top","0px");
							}
							let desH=$("#space-tbl-generate").scrollLeft();
							if (desH>50) {
								$(".column-tbl-static").css("position","absolute");
								$(".column-tbl-static").css("left",desH+"px");
							}else{
								$(".column-tbl-static").css("position","relative");
								$(".column-tbl-static").css("left","0px");
							}
						});
					}else{
						$("#space-tbl-generate").scroll(function(){
							let desH=$("#space-tbl-generate").scrollLeft();
							if (desH>50) {
								$(".column-tbl-static").css("position","absolute");
								$(".column-tbl-static").css("left",desH+"px");
							}else{
								$(".column-tbl-static").css("position","relative");
								$(".column-tbl-static").css("left","0px");
							}
						});
					}

	
				}else{
					alert(data.detail);
				}
				$(".panelCarga").fadeOut(100);
			}
		}).fail( function() {
			alert("Hubo un error al generar medidas");
			$(".panelCarga").fadeOut(100);
		});
	}else{
		alert("Ingrese una cantidad apropiada!");
	}
}
function correct_text(text){
	while(text.indexOf("\"")>=0){
		text=text.replace("\"","");
	}
	return text;
}

var numero_prenda=1;
function select_btn(dom,pos){
	numero_prenda=pos;
	var ar=document.getElementsByClassName("btn-prenda");
	for (var i = 0; i < ar.length; i++) {
		ar[i].classList.remove("btn-prenda-select");
	}
	dom.classList.add("btn-prenda-select");
}

function replicar_informacion(data){
	for (var i = 0; i < data.length; i++) {
		console.log(i);
		if (data[i].VALOR!=null) {
			document.getElementsByClassName("contentButton-"+data[i].CODMED+"-"+data[i].CODTAL)[0].
			getElementsByClassName("dato-"+data[i].VALOR)[0].
			getElementsByClassName("span-"+data[i].NUMPRE)[0].innerText=data[i].NUMPRE;
		}
	}
}

function register(codmed,codtal,valor,element,tolval){
	$(".panelCarga").fadeIn(100);
	document.getElementsByClassName("contentButton-"+codmed+"-"+codtal)[0].dataset.clicked="1";
	$.ajax({
		url:"config/updateDetailAudFinCor.php",
		type:"POST",
		data:{
			codfic:codfic,
			codmed:codmed,
			codtal:codtal,
			numpre:numero_prenda,
			valor:valor,
			tolval:tolval,
			hilo:hilo*val_round,
			travez:travez*val_round,
			largmanga:largmanga*val_round
		},
		success:function (data){
			if (data.state!=true) {
				alert(data.detail);
			}else{
				var ar_elem=document.getElementsByClassName("contentButton-"+codmed+"-"+codtal)[0].
				getElementsByClassName("span-"+numero_prenda);
				for (var i = 0; i < ar_elem.length; i++) {
					if (ar_elem[i]!=element.getElementsByClassName("span-"+numero_prenda)[0]) {
						ar_elem[i].innerText="";
					}
				}
				if (element.getElementsByClassName("span-"+numero_prenda)[0].innerText=="") {
					element.getElementsByClassName("span-"+numero_prenda)[0].innerText=numero_prenda;
				}else{
					element.getElementsByClassName("span-"+numero_prenda)[0].innerText="";
				}
			}
			$(".panelCarga").fadeOut(100);
		}
	});
}

function move_frame(dir){
	var ar_content=document.getElementsByClassName("main-content-medida");
	var i=0;
	var validate=false;
	var pos=0;
	while( i < ar_content.length && validate==false) {
		if(ar_content[i].style.display=="block"){
			validate=true;
			pos=parseInt(ar_content[i].dataset.pos);
		}
		i++;
	}
	if ((dir==0 && pos==1) ||(dir==1 && pos==last_pos)) {

	}else{
		$(".content"+pos).css("display","none");
		$(".header-"+pos).css("display","none");
		var newpos=0;
		if (dir==0) {
			newpos=pos-1;
		}else{
			newpos=pos+1;
		}
		$("#talla-select").text(array_tallas[newpos-1]);
		$(".content"+newpos).css("display","block");
		$(".header-"+newpos).css("display","flex");
	}
}

function endRegistroMedida(path){
	var ar_val=document.getElementsByClassName("content-validate");
	var validate=false;
	var i=0;
	while (validate==false && i < ar_val.length) {
		if(ar_val[i].dataset.clicked=="0"){
			validate=true;
		}
		i++;
	}				
	if (validate==false) {
		//window.location.href=path;
		window.location.reload();
	}else{
		var conf=confirm("Quedan medidas sin registrar. Desea salir de todas maneras?");
		if (conf) {
			window.location.reload();
		}
	}
}
function save_header(){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		url:"config/updateEndFichaAFC.php",
		type:"POST",
		data:{
			codfic:codfic,
			res:$("#idresultado").val(),
			obs:$("#idobservacion").val()
		},
		success:function (data){
			if (!data.state) {
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(100);
		}
	});

}

function download_excel(){
	var link="config/exports/exportMedidas.php?codfic="+codfic+"&hilo="+hilo*100+"&travez="+travez*100+"&largamanga="+largmanga*100;
	var a =document.createElement("a");
	a.href=link;
	a.target="_blank";
	a.click();
}

function redirect_registro(){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		url:"config/getVezAudFinCor.php",
		type:"POST",
		data:{
			codfic:codfic
		},
		success:function (data){
			//console.log(data.numvez);
			var link="RegistrarAudFinCor.php?codFic="+codfic+"&numvez="+data.numvez+"&parte=1&codtad=3&tipoMuestra=aql&numMuestra=0&codaql=1";
			var a=document.createElement("a");
			a.href=link;
			a.click();			
		}
	});
}