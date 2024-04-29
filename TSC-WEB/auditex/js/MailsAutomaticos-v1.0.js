var listausuariosrep=[];
var listadetalle=[];
var listaheaders=[];
var listausuario=[];
$(document).ready(function(){
	$.ajax({
		url:"config/getParametrosMail.php",
		type:"POST",
		success:function(data){
			console.log(data);
			var html='';
			for (var i = 0; i < data.tipaud.length; i++) {
				html+=
					'<option value="'+data.tipaud[i].CODTAD+'">'+data.tipaud[i].DESTAD+'</option>';
			}
			$("#idTipAud").append(html);
			listaheaders=data.tipindrep;
			fill_header(data.tipindrep);
			listausuario=data.usuario;
			fill_usuarios(listausuario);
			listausuariosrep=data.indrepusu;
			fill_usuario_rep(listausuariosrep);
			listadetalle=data.indrepdet;
			fill_detalle(listadetalle);
			$(".panelCarga").fadeOut(100);
		}
	});
	$("#idUsuario").keyup(function(){
		$("#lista-usuarios").empty();
		var html='';
		for (var i = 0; i < listausuario.length; i++) {
			if ((listausuario[i].NOMUSU+" "+listausuario[i].CODUSU).toUpperCase().indexOf($("#idUsuario").val().toUpperCase())>=0) {
				html+=
					'<div class="line-lista" onclick="select_usuario(\''+listausuario[i].CODUSU+'\',\''+listausuario[i].NOMUSU+'\')">'+listausuario[i].NOMUSU+' ('+listausuario[i].CODUSU+')</div>';
			}
		}
		$("#lista-usuarios").append(html);
	});
	$("#idTipAud").change(function(){
		$(".panelCarga").fadeIn(100);
		$.ajax({
			url:"config/getDetalleIndRepXCodtad.php",
			type:"POST",
			data:{
				codtad:$("#idTipAud").val()
			},
			success:function(data){
				console.log(data);
				fill_usuario_rep(listausuariosrep);
				listadetalle=data.indrepdet;
				fill_detalle(listadetalle);
				$(".panelCarga").fadeOut(100);
			}
		});
	});
});

function fill_header(data){
	$("#allHeaders").empty();
	var html='';
	for (var i = 0; i < data.length; i++) {
		html+=
			'<div class="itemHeader" style="width: 80px;text-align: center;font-size:11px;">'+data[i].DESTIPIND+'</div>';
	}
	var widHeader=360+(data.length)*90;
	$("#header-to-alter").css("width",widHeader+"px");
	$("#data-users").css("width",widHeader+"px");
	$("#allHeaders").append(html);
}

function fill_usuarios(data){
	$("#lista-usuarios").empty();
	var html='';
	for (var i = 0; i < data.length; i++) {
		html+=
			'<div class="line-lista" onclick="select_usuario(\''+data[i].CODUSU+'\',\''+data[i].NOMUSU+'\')">'+data[i].NOMUSU+' ('+data[i].CODUSU+')</div>';
	}
	$("#lista-usuarios").append(html);
}

function fill_detalle(data){
	for (var i = 0; i < data.length; i++) {
		var id=data[i].CODUSU+"-"+data[i].CODTAD+"-"+data[i].CODTIPIND;
		document.getElementById(id).checked=true;
	}
}

function fill_usuario_rep(data){
	$("#data-users").empty();
	var html='';
	for (var i = 0; i < data.length; i++) {
		html+=
		'<div class="tblLine">'+
			'<div class="itemBody" style="width: 190px;">'+data[i].NOMUSU+'</div>'+
			'<div class="itemBody" style="width: 150px;">'+data[i].EMAUSU+'</div>';
		for (var j = 0; j < listaheaders.length; j++) {
			html+=
			'<div class="itemBody" style="width: 80px;text-align:center;">'+
				'<input type="checkbox" id="'+data[i].CODUSU+'-'+$("#idTipAud").val()+'-'+listaheaders[j].CODTIPIND+'" onclick="change_this(this)"'+
				' class="check-indrep" data-codusu="'+data[i].CODUSU+'" data-codtipind="'+listaheaders[j].CODTIPIND+'" data-change="0"/>'+
			'</div>';
		}
		html+=
		'</div>';
	}
	$("#data-users").append(html);
}

function change_this(dom){
	if(dom.dataset.change=="0"){
		dom.dataset.change="1";
	}else{
		dom.dataset.change="0";
	}
}

var codusu_var=0;
function select_usuario(codusu,nomusu){
	codusu_var=codusu;
	$("#idUsuario").val(nomusu);
}

function saveParameters(){
	var ar_checks=document.getElementsByClassName("check-indrep");
	var ar_send=[];
	for (var i = 0; i < ar_checks.length; i++) {
		if (ar_checks[i].dataset.change=="1") {
			var aux=[];
			aux.push(ar_checks[i].dataset.codusu);
			aux.push(ar_checks[i].dataset.codtipind);
			ar_send.push(aux);
		}
	}
	if (ar_send.length==0) {
		alert("No hay cambios en el panel!");
	}else{
		$(".panelCarga").fadeIn(100);
		$.ajax({
			url:"config/saveIndRepUsuarios.php",
			type:"POST",
			data:{
				array:ar_send,
				codtad:$("#idTipAud").val()
			},
			success:function(data){
				console.log(data);
				if (data.state) {
					alert("Cambios guardados!");
					window.location.reload();
				}else{
					alert("No se pude guardar los cambios!");
					$(".panelCarga").fadeOut(100);
				}
			}
		});	
	}
}

function hide_modal(id){
	$("#"+id).fadeOut(100);	
	$("#idUsuario").val("");
	$("#idUsuario").keyup();
	codusu_var=0;
}

function show_modal(id){
	$("#"+id).fadeIn(100);	
}

function add_usuario(){
	if (codusu_var==0) {
		alert("Seleccione un usuario!");
	}else{
		$(".panelCarga").fadeIn(100);
		$.ajax({
			url:"config/saveUsuarioIndRep.php",
			type:"POST",
			data:{
				codusu:codusu_var
			},
			success:function(data){
				console.log(data);
				if (data.state) {
					alert("Usuario agregado!");
					window.location.reload();
				}else{
					alert("No se pude agregar usuario!");
					$(".panelCarga").fadeOut(100);
				}
			}
		});	
	}
}

function enviar_mail(){	
	/*$.ajax({
		url:"config/_sendMails.php",
		type:"GET",
		success:function(data){
			console.log(data);
			if (data.state) {
				alert("Usuario agregado!");
				window.location.reload();
			}else{
				alert("No se pude agregar usuario!");
				$(".panelCarga").fadeOut(100);
			}
		}
	});*/
	var a=document.createElement("a");
	a.target="_blank";
	a.href="config/_sendMails.php";
	a.click();
}