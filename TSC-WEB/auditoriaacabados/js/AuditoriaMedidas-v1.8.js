var 	val_round = 100;
let		TIPOMEDIDA = null;

$(document).ready(function(){
	show_header();
	ctrl_header();
	$("#space-tbl-generate").scroll(function(){
		var des=$("#space-tbl-generate").scrollTop();
		if (des>5) {
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
		url:"config/getPreAudMed.php",
		type:"POST",
		data:{
			codfic:codfic
		},
		success:function (data){

			console.log(data);
			esttsc=data.esttsc;
			TIPOMEDIDA = data.TIPOMEDIDA;

			if (data.detalle.length>0) {
				$("#CanXTalla").val(data.NUMPRE);
				$("#CanXTallaAdi").val(data.NUMPREADI);
				if (data.NUMPREADI=="") {
					$("#CanXTallaAdi").val("0");	
				}
				if (data.ESTADO=="T") {
					$("#confirmar-resultado").css("display","block");
					document.getElementById("con-resultado").value=data.RESULTADO;
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

function add_pulgadas(){
	var text=document.getElementById("ctrl-pulg").innerHTML;
	if (text=="Ampliar pulgadas") {
		document.getElementById("ctrl-pulg").innerHTML="Reducir pulgadas";
		tip_med=2;
	}else{
		document.getElementById("ctrl-pulg").innerHTML="Ampliar pulgadas";
		tip_med=1;
	}
	generateTable();
}

var header_visible=false;
function show_header(){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:'POST',
		url:'config/getInfoAcabados-v2.php',
		data:{
			codfic:codfic
		},
		success:function(data){
			console.log(data);
			document.getElementById("cliente").innerHTML=data.CLIENTE;
			document.getElementById("pedido").innerHTML=data.PEDIDO+' - '+data.COLOR;
			document.getElementById("esttsc").innerHTML=data.ESTTSC+' - '+data.ESTCLI;
			document.getElementById("despre").innerHTML=data.DESPRE;
			document.getElementById("audfincor").innerHTML='<a href="../AuditoriaFinalCorte/ConsultarEditarAuditoria.php?codfic='+codfic+'">Aud. Final de Corte</a>';
			document.getElementById("audprocos").innerHTML='<a href="../auditoriaproceso/ConsultarEditarAuditoriaProceso.php?codfic='+codfic+'">Aud. Proceso de Costura</a>';
			document.getElementById("audfincos").innerHTML='<a href="../auditex/ConsultarEditarAuditoria.php?codfic='+codfic+'">Aud. Final de Costura</a>';
			document.getElementById("destllcor").innerHTML=data.TALLERCOR;
			document.getElementById("destll").innerHTML=data.TALLERCOS;
			document.getElementById("articulo").innerHTML=data.ARTICULO;
			document.getElementById("partida").innerHTML=data.PARTIDA;
			document.getElementById("rutpre").innerHTML=get_rutaprenda(data.ruta);
			document.getElementById("canfic").innerHTML=data.CANFIC;
			document.getElementById("canaca").innerHTML=data.CANACA;
			header_visible=true;
			$(".panelCarga").fadeOut(100);
		}
	});
}
function get_rutaprenda(data){
	let ruta='';
	for (var i = 0; i < data.length; i++) {
		ruta+=data[i].CODETAPA+' - '+data[i].ETAPA;
		if (i!=data.length-1) {
			ruta+=' | ';
		}
	}
	return ruta;
}

var last_pos=0;
var tip_med=1;
var array_tallas=[];
var ar_var_med1=['1','7/8','3/4','5/8','1/2','3/8','1/4','1/8','0','-1/8','-1/4','-3/8','-1/2','-5/8','-3/4','-7/8','-1'];
var ar_var_med2=['2','1 7/8','1 3/4','1 5/8','1 1/2','1 3/8','1 1/4','1 1/8','1','7/8','3/4','5/8','1/2','3/8','1/4','1/8','0','-1/8','-1/4','-3/8','-1/2','-5/8','-3/4','-7/8','-1','-1 1/8','-1 1/4','-1 3/8','-1 1/2','-1 5/8','-1 3/4','-1 7/8','-2'];
var ar_var_med=[];
var register_edit=true;
let RANGOMEDIDAS = [];

function generateTable(){
	if ($("#CanXTalla").val()>=1) {
		var canadi=0;
		if ($("#CanXTallaAdi").val()!="") {
			canadi=$("#CanXTallaAdi").val();
		}

		// if (tip_med==1) {
		// 	ar_var_med=ar_var_med1;
		// }else{
		// 	ar_var_med=ar_var_med2;
		// }


		$(".panelCarga").fadeIn(100);
		$.ajax({
			url:"config/getDetalleMedidas.php",
			type:"POST",
			data:{
				codfic:codfic,
				esttsc:esttsc,
				cantidad:$("#CanXTalla").val(),
				canadi:canadi,
				tipomedida:TIPOMEDIDA
			},
			success:function (data){
				console.log(data);
				if (data.state) {

					// MEDIDAS
					RANGOMEDIDAS = data.rangomedidas;
					ar_var_med = [];
					if (tip_med==1) {
						for(let item of RANGOMEDIDAS){
							if(item.AMPLIADO == "0"){
								ar_var_med.push(item.MEDIDA);
							}
						}
					}else{

						for(let item of RANGOMEDIDAS){
							ar_var_med.push(item.MEDIDA);
						}
					}

					document.getElementById("comentarioAM").value=data.datos.COMENTARIOS;
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
					for (var l = 0; l < parseInt($("#CanXTalla").val())+parseInt(canadi); l++) {
						if (l==0) {
							html_btns+='<button class="btn-prenda btn-prenda-select" onclick="select_btn(this,\''+(l+1)+'\')">'+(l+1)+'</button>';
						}else{
							html_btns+='<button class="btn-prenda" onclick="select_btn(this,\''+(l+1)+'\')">'+(l+1)+'</button>';
						}
						html_spans+='<span class="span-spe span-'+(l+1)+'"></span>';
					}
					$("#space-btns-prendas").empty();
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
									if (ar_var_med[l]=="0") {
										html+=
									'<div class="header-item item-center item-s2 item-c4 dato-0" onclick="register(\''+data.detalle[i].CODMED+'\',\''+data.detalle[i].CODTAL+'\',\'0\',this,0)">'+html_spans+'</div>';
									}else{
										html+=
									'<div class="header-item item-center item-s2'+style_tol+' dato-'+replace_blank(ar_var_med[l])+'" onclick="register(\''+data.detalle[i].CODMED+'\',\''+data.detalle[i].CODTAL+'\',\''+ar_var_med[l]+'\',this,'+val_tol+')">'+html_spans+'</div>';
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
					$("#space-tbl-generate").empty();
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
				move_table_talla(ant_pos);
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
function replace_blank(dato){
	var new_dato=dato.replace(" ","|");
	return new_dato;
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
			if (document.getElementsByClassName("contentButton-"+data[i].CODMED+"-"+data[i].CODTAL)[0].
			getElementsByClassName("dato-"+replace_blank(data[i].VALOR))[0]) {
				var element=document.getElementsByClassName("contentButton-"+data[i].CODMED+"-"+data[i].CODTAL)[0].
				getElementsByClassName("dato-"+replace_blank(data[i].VALOR))[0].
				getElementsByClassName("span-"+data[i].NUMPRE)[0];
				element.innerText=data[i].NUMPRE;
				if (parseInt($("#CanXTalla").val())<parseInt(data[i].NUMPRE)) {
					element.style.fontWeight="bold";
					element.style.color="#000";
				}
			}
		}
	}
}

function register(codmed,codtal,valor,element,tolval){
	if (!register_edit) {
		return;
	}
	var c=true;
	if (element.getElementsByClassName("span-"+numero_prenda)[0].innerText!="") {
		c=confirm("Desea eliminar la medida?");
	}
	if (!c) {
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
			}else{
				if (data.estado!="0") {
					element.getElementsByClassName("span-"+numero_prenda)[0].innerText=numero_prenda;
				}else{
					element.getElementsByClassName("span-"+numero_prenda)[0].innerText="";
				}
			}
			$(".panelCarga").fadeOut(100);
		}
	});
}

var ant_pos=1;
function move_frame(dir){
	select_btn(document.getElementsByClassName("btn-prenda")[0],'1');
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
		ant_pos=newpos;
	}
}

function move_table_talla(){
	$(".content1").css("display","none");
	$(".header-1").css("display","none");
	$("#talla-select").text(array_tallas[ant_pos-1]);
	$(".content"+(ant_pos)).css("display","block");
	$(".header-"+(ant_pos)).css("display","flex");
}

function endRegistroMedida(){
	$(".panelCarga").fadeIn(100);
	var canadi=0;
	if ($("#CanXTallaAdi").val()!="") {
		canadi=$("#CanXTallaAdi").val();
	}
	$.ajax({
		url:"config/endAudMedAca.php",
		type:"POST",
		data:{
			codfic:codfic,
			cantidad:parseInt($("#CanXTalla").val())+parseInt(canadi)
		},
		success:function (data){
			console.log(data)
			if (!data.state) {

				var conf=confirm("Quedan medidas sin registrar. Desea finalizar de todas manera?");
				if (conf) {
					window.location.reload();
				}

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

function redirect_back(){
	window.location.href="IniciarAudAca.php?codfic="+codfic;
}

function save_comment(){	
	$(".panelCarga").fadeIn(100);
	$.ajax({
		url:"config/saveObsAudMed.php",
		type:"POST",
		data:{
			codfic:codfic,
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

function confirmar_resultado(){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		url:"config/confirmarResultadoAudMed.php",
		type:"POST",
		data:{
			codfic:codfic,
			res:$("#con-resultado").val()
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