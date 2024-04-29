var val_round=100;
$(document).ready(function(){
	$("#space-tbl-generate").scroll(function(){
		var des=$("#space-tbl-generate").scrollTop();
		if (des>20) {
			document.getElementsByClassName("header-content")[1].style.display="absolute";
			document.getElementsByClassName("header-content")[1].style.top=des+"px";
			/*$(".header-content").css("position","absolute");
			$(".header-content").css("top",des+"px");*/
		}else{
			document.getElementsByClassName("header-content")[1].style.display="absolute";
			document.getElementsByClassName("header-content")[1].style.top="0px";
			/*$(".header-content").css("position","relative");
			$(".header-content").css("top","0px");*/
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
	$.ajax({
		url:"config/getPreInfAudMed.php",
		type:"POST",
		data:{
			pedido:pedido,
			dsccol:dsccol
		},
		success:function (data){
			console.log(data);
			esttsc=data.esttsc;
			if (data.detalle.length>0) {
				$("#comentarioAM").val(data.COMENTARIOS);
				$("#CanXTalla").val(data.NUMPRE);
				$("#CanXTallaAdi").val(data.NUMPREADI);
				if (data.ESTADO=="T") {
					document.getElementById("btn-generar").innerHTML="Ver detalle";
				}else{
					document.getElementById("space-editar").style.display="none";
				}
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

						html2+=
					'<div class="column-tbl-s2">'+
						'<div class="header-item item-s2">'+data.detalle[i].DESMEDCOR+'</div>'+
						'<div class="header-item item-s2 item-maxheight" title="'+correct_text(data.detalle[i].DESMED)+'">'+data.detalle[i].DESMED+'</div>'+
					'</div>';
						html+=
				'</div>'+
				'<div class="column-tbl-s2">';
						ant_nom=data.detalle[i].DESMED;
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
						if (parseInt($("#CanXTalla").val())<parseInt(data.detalle[i].NUMPRE)) {
						html+=
					'<div class="header-item item-s2 item-center'+style+'" style="font-weight:bold;color:#000;">'+data.detalle[i].VALOR+'</div>';
						}else{
						html+=
					'<div class="header-item item-s2 item-center'+style+'">'+data.detalle[i].VALOR+'</div>';
						}
					}else{
						html+=
					'<div class="header-item item-s2 item-center'+style+'"></div>';
					}
				}
				html+=
					'<div class="header-item item-center item-c0"></div>';
				for (var k = 0; k < data.detalletalla.length; k++) {
					if (data.detalletalla[k].DESMED==ant_nom) {
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

			$(".panelCarga").fadeOut(100);
		}
	});
	
	//		$(".panelCarga").fadeOut(100);
});

var last_pos=0;
var array_tallas=[];
var ar_var_med=['1','7/8','3/4','5/6','1/2','3/8','1/4','1/8','0','-1/8','-1/4','-3/8','-1/2','-5/6','-3/4','-7/8','-1'];
var register_edit=true;
function generateTable(){
	if ($("#CanXTalla").val()>=1) {
		$(".panelCarga").fadeIn(100);
		$.ajax({
			url:"config/getDetalleMedidas.php",
			type:"POST",
			data:{
				pedido:pedido,
				dsccol:dsccol,
				esttsc:esttsc,
				cantidad:$("#CanXTalla").val(),
				canadi:$("#CanXTallaAdi").val()
			},
			success:function (data){
				console.log(data);
				if (data.state) {
					if (data.datos.ESTADO=='T') {
						register_edit=false;
						$("#btn-end").remove();
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
					for (var l = 0; l < parseInt($("#CanXTalla").val())+parseInt($("#CanXTallaAdi").val()); l++) {
						if (l==0) {
							html_btns+='<button class="btn-prenda btn-prenda-select" onclick="select_btn(this,\''+(l+1)+'\')">'+(l+1)+'</button>';
						}else{
							html_btns+='<button class="btn-prenda" onclick="select_btn(this,\''+(l+1)+'\')">'+(l+1)+'</button>';
						}
						html_spans+='<span class="span-spe span-'+(l+1)+'"></span>';
					}
					$("#space-btns-prendas").append(html_btns);
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
					$("#space-tbl-generate").append(html2);
					$("#space-tbl-generate").append(html);
					$("#second-frame").css("display","block");
					if (data.replicar==true) {
						replicar_informacion(data.guardado);
					}
					document.getElementsByClassName("header-content")[1].style.position="absolute";
					document.getElementsByClassName("header-content")[1].style.top="0px";
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

function editar_table(){
	$.ajax({
		url:"config/editRestartStateMed.php",
		type:"POST",
		data:{
			pedido:pedido,
			dsccol:dsccol
		},
		success:function (data){
			if (data.state) {
				generateTable();
			}else{
				alert(data.detail);
			}
		}
	});
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
		if (data[i].VALOR!=null) {
			var element=document.getElementsByClassName("contentButton-"+data[i].CODMED+"-"+data[i].CODTAL)[0].
			getElementsByClassName("dato-"+data[i].VALOR)[0].
			getElementsByClassName("span-"+data[i].NUMPRE)[0];
			element.innerText=data[i].NUMPRE;
			if (parseInt($("#CanXTalla").val())<parseInt(data[i].NUMPRE)) {
				element.style.fontWeight="bold";
				element.style.color="#000";
			}
		}
	}
}

function register(codmed,codtal,valor,element,tolval){
	if (!register_edit) {
		return;
	}
	$(".panelCarga").fadeIn(100);
	document.getElementsByClassName("contentButton-"+codmed+"-"+codtal)[0].dataset.clicked="1";
	var ar_elem=document.getElementsByClassName("contentButton-"+codmed+"-"+codtal)[0].getElementsByClassName("span-"+numero_prenda);
	for (var i = 0; i < ar_elem.length; i++) {
		ar_elem[i].innerText="";
	}
	element.getElementsByClassName("span-"+numero_prenda)[0].innerText=numero_prenda;
	if (parseInt($("#CanXTalla").val())<numero_prenda) {
		element.getElementsByClassName("span-"+numero_prenda)[0].style.fontWeight="bold";
		element.getElementsByClassName("span-"+numero_prenda)[0].style.color="#000";
	}
	$.ajax({
		url:"config/updateDetailAudMed.php",
		type:"POST",
		data:{
			pedido:pedido,
			dsccol:dsccol,
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

function endRegistroMedida(){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		url:"config/endAudMedFin.php",
		type:"POST",
		data:{
			pedido:pedido,
			dsccol:dsccol
		},
		success:function (data){
			console.log(data)
			if (!data.state) {
				alert(data.detail);
			}else{
				window.location.reload();
			}
			$(".panelCarga").fadeOut(100);
		}
	});
}

function download_excel(){
	var link="config/exports/exportMedidas.php?codfic="+codfic+"&esttsc="+esttsc;
	var a =document.createElement("a");
	a.href=link;
	a.target="_blank";
	a.click();
}

function save_comment(){	
	$(".panelCarga").fadeIn(100);
	$.ajax({
		url:"config/saveObsAudMed.php",
		type:"POST",
		data:{
			pedido:pedido,
			dsccol:dsccol,
			obs:$("#comentarioAM").val()
		},
		success:function (data){
			console.log(data)
			if (!data.state) {
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(100);
		}
	});
}