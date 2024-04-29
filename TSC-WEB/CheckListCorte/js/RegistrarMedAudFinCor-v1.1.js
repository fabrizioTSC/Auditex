$(document).ready(function(){
	$.ajax({
		url:"config/getValidatePreviewFicAudCor.php",
		type:"POST",
		data:{
			codfic:codfic,
			hilo:hilo,
			travez:travez,
			largmanga:largmanga
		},
		success:function (data){
			console.log(data);
			if (data.detalle.length>0) {
				var html='';
				html+=
				'<div class="column-tbl">'+
					'<div class="header-item item-center item-c0"></div>'+
					'<div class="header-item item-maxheight">Prenda</div>';
				for (var j = 0; j < data.numpre; j++) {
					for (var i = 0; i < data.talla.length; i++) {
						html+=
					'<div class="header-item item-center item-c2">'+(j+1)+'</div>';
					}
				}
				html+=					
				'</div>';

				html+=
				'<div class="column-tbl">'+
					'<div class="header-item">Medida</div>'+
					'<div class="header-item item-maxheight">Talla</div>';
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

				var ant_nom=data.detalle[0].DESMED;
				for (var i = 0; i < data.detalle.length; i++) {
					if (data.detalle[i].DESMED!=ant_nom) {
						html+=
					'<div class="header-item item-center item-c0"></div>';
						for (var k = 0; k < data.detalletalla.length; k++) {
							if (data.detalletalla[k].DESMED==ant_nom) {
								html+=
					'<div class="header-item item-s2 item-center item-c3">'+data.detalletalla[k].MEDIDA+'</div>';	
							}
						}
						html+=
				'</div>'+
				'<div class="column-tbl-s2">'+
					'<div class="header-item item-s2">'+data.detalle[i].DESMEDCOR+'</div>'+
					'<div class="header-item item-s2 item-maxheight" title="'+correct_text(data.detalle[i].DESMED)+'">'+data.detalle[i].DESMED+'</div>';
						ant_nom=data.detalle[i].DESMED;
					}
					if (i==0) {
						html+=
				'<div class="column-tbl-s2">'+
					'<div class="header-item item-s2">'+data.detalle[i].DESMEDCOR+'</div>'+
					'<div class="header-item item-s2 item-maxheight" title="'+correct_text(data.detalle[i].DESMED)+'">'+data.detalle[i].DESMED+'</div>';
					}
					var style=" item-c3";
					/*
					if(reg_med_nivel_uno(data.detalle[i].VALOR)){
						style=" item-c4";
					}else{
						if(reg_med_nivel_dos(data.detalle[i].VALOR)){
							style=" item-c5";
						}
					}*/
					if(data.detalle[i].TOLVAL==1){
						style=" item-c5";
					}else{
						if(data.detalle[i].TOLVAL==0){
							style=" item-c4";
						}
					}
					html+=
					'<div class="header-item item-s2 item-center'+style+'">'+data.detalle[i].VALOR+'</div>';
				}
				html+=
					'<div class="header-item item-center item-c0"></div>';
				for (var k = 0; k < data.detalletalla.length; k++) {
					if (data.detalletalla[k].DESMED==ant_nom) {
						html+=
					'<div class="header-item item-s2 item-center item-c3">'+data.detalletalla[k].MEDIDA+'</div>';	
					}
				}
				html+=
				'</div>';

				$("#space-tbl-medidas").append(html);
				$("#resume-medida").css("display","block");
			}

			$(".panelCarga").fadeOut(100);
		}
	});
	
	//		$(".panelCarga").fadeOut(100);
});

var last_pos=0;
var array_tallas=[];
var ar_var_med=['1','7/8','3/4','5/6','1/2','3/8','1/4','1/8','0','-1/8','-1/4','-3/8','-1/2','-5/6','-3/4','-7/8','-1'];
function generateTable(){
	if ($("#CanXTalla").val()>=1) {
		$(".panelCarga").fadeIn(100);
		$.ajax({
			url:"config/getDetalleMedidas.php",
			type:"POST",
			data:{
				codfic:codfic,
				hilo:hilo,
				travez:travez,
				largmanga:largmanga,
				cantidad:$("#CanXTalla").val()
			},
			success:function (data){
				console.log(data);
				if (data.state) {
					$("#content-main").css("display","none");
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
					//var item_color='';
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
							'<div class="column-tbl">'+
								'<div class="header-item">C. Med.</div>'+
								'<div class="header-item">Medida</div>'+
								'<div class="header-item item-maxheight">Desc.</div>';
								/*
								'<div class="header-item item-center item-c2">1</div>'+
								'<div class="header-item item-center item-c2">7/8</div>'+
								'<div class="header-item item-center item-c2">3/4</div>'+
								'<div class="header-item item-center item-c2">5/8</div>'+
								'<div class="header-item item-center item-c2">1/2</div>'+
								'<div class="header-item item-center item-c2">3/8</div>'+
								'<div class="header-item item-center item-c2">1/4</div>'+
								'<div class="header-item item-center item-c2">1/8</div>'+
								'<div class="header-item item-center item-c4">0</div>'+
								'<div class="header-item item-center item-c2">-1/8</div>'+
								'<div class="header-item item-center item-c2">-1/4</div>'+
								'<div class="header-item item-center item-c2">-3/8</div>'+
								'<div class="header-item item-center item-c2">-1/2</div>'+
								'<div class="header-item item-center item-c2">-5/8</div>'+
								'<div class="header-item item-center item-c2">-3/4</div>'+
								'<div class="header-item item-center item-c2">-7/8</div>'+
								'<div class="header-item item-center item-c2">-1</div>'+
								*/
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
								'<div class="header-item item-s2">'+data.detalle[i].DESMEDCOR+'</div>'+
								'<div class="header-item item-s2">'+data.detalle[i].MEDIDA+'</div>'+
								'<div class="header-item item-s2 item-maxheight" title="'+correct_text(data.detalle[i].DESMED)+'">'+data.detalle[i].DESMED+'</div>'+
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
										console.log("-"+ar_var_med[l]);
									}
									if (ar_var_med[l]=="0") {
										html+=
									'<div class="header-item item-center item-s2 item-c4 dato-0" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\'0\',this,0)">'+html_spans+'</div>';
									}else{
										html+=
									'<div class="header-item item-center item-s2'+style_tol+' dato-'+ar_var_med[l]+'" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\''+ar_var_med[l]+'\',this,'+val_tol+')">'+html_spans+'</div>';
									}
								}
								/*
									'<div class="header-item item-center item-s2 item-c3 dato-1" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\'1\',this)">'+html_spans+'</div>'+
									'<div class="header-item item-center item-s2 item-c3 dato-7/8" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\'7/8\',this)">'+html_spans+'</div>'+
									'<div class="header-item item-center item-s2 item-c3 dato-3/4" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\'3/4\',this)">'+html_spans+'</div>'+
									'<div class="header-item item-center item-s2 item-c3 dato-5/8" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\'5/8\',this)">'+html_spans+'</div>'+
									'<div class="header-item item-center item-s2 item-c3 dato-1/2" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\'1/2\',this)">'+html_spans+'</div>'+
									'<div class="header-item item-center item-s2 item-c3 dato-3/8" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\'3/8\',this)">'+html_spans+'</div>'+
									'<div class="header-item item-center item-s2 item-c5 dato-1/4" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\'1/4\',this)">'+html_spans+'</div>'+
									'<div class="header-item item-center item-s2 item-c5 dato-1/8" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\'1/8\',this)">'+html_spans+'</div>'+
									'<div class="header-item item-center item-s2 item-c4 dato-0" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\'0\',this)">'+html_spans+'</div>'+
									'<div class="header-item item-center item-s2 item-c5 dato--1/8" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\'-1/8\',this)">'+html_spans+'</div>'+
									'<div class="header-item item-center item-s2 item-c5 dato--1/4" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\'-1/4\',this)">'+html_spans+'</div>'+
									'<div class="header-item item-center item-s2 item-c3 dato--3/8" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\'-3/8\',this)">'+html_spans+'</div>'+
									'<div class="header-item item-center item-s2 item-c3 dato--1/2" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\'-1/2\',this)">'+html_spans+'</div>'+
									'<div class="header-item item-center item-s2 item-c3 dato--5/8" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\'-5/8\',this)">'+html_spans+'</div>'+
									'<div class="header-item item-center item-s2 item-c3 dato--3/4" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\'-3/4\',this)">'+html_spans+'</div>'+
									'<div class="header-item item-center item-s2 item-c3 dato--7/8" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\'-7/8\',this)">'+html_spans+'</div>'+
									'<div class="header-item item-center item-s2 item-c3 dato--1" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\'-1\',this)">'+html_spans+'</div>'+*/
						html+=								
								'</div>'+
							'</div>';
					}
					html+=
						'</div>'+
						'<div class="title-medida tit-special">'+k+' de '+data.cont+'</div>'+
					'</div>';
					$("#talla-select").text(array_tallas[0]);
					$("#space-tbl-generate").append(html);
					$("#second-frame").css("display","block");
					if (data.replicar==true) {
						replicar_informacion(data.guardado);
					}
				}else{
					alert(data.detail);
				}
				$(".panelCarga").fadeOut(100);
			}
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
		document.getElementsByClassName("contentButton-"+data[i].CODMED+"-"+data[i].CODTAL)[0].
			getElementsByClassName("dato-"+data[i].VALOR)[0].getElementsByClassName("span-"+data[i].NUMPRE)[0].innerText=data[i].NUMPRE;
	}
}

function register(codmed,codtal,valor,element,tolval){
	$(".panelCarga").fadeIn(100);
	document.getElementsByClassName("contentButton-"+codmed+"-"+codtal)[0].dataset.clicked="1";
	//var ar_elem=document.getElementsByClassName("contentButton-"+codmed+"-"+codtal)[0].getElementsByClassName("header-item");
	var ar_elem=document.getElementsByClassName("contentButton-"+codmed+"-"+codtal)[0].getElementsByClassName("span-"+numero_prenda);
	for (var i = 0; i < ar_elem.length; i++) {
		ar_elem[i].innerText="";
	}
	element.getElementsByClassName("span-"+numero_prenda)[0].innerText=numero_prenda;
	$.ajax({
		url:"config/updateDetailAudFinCor.php",
		type:"POST",
		data:{
			codfic:codfic,
			codmed:codmed,
			codtal:codtal,
			numpre:numero_prenda,
			valor:valor,
			tolval:tolval
		},
		success:function (data){
			if (data.state!=true) {
				alert(data.detail);
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
		var newpos=0;
		if (dir==0) {
			newpos=pos-1;
		}else{
			newpos=pos+1;
		}
		$("#talla-select").text(array_tallas[newpos-1]);
		$(".content"+newpos).css("display","block");
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
		window.location.href=path;
	}else{
		var conf=confirm("Quedan medidas sin registrar. Desea salir de todas maneras?");
		if (conf) {
			window.location.href=path;			
		}
	}
}