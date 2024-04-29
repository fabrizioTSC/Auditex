var listaUsuarios=[];
function getUsuarios(){
	$.ajax({
		type:"POST",
		url:"config/getUsuarios.php",
		data:{
			request:"1"
		},
		success:function(data){
			console.log(data);
			$(".listaTalleres").empty();
			var htmlUsuarios="";
			for (var i = 0; i < data.usuarios.length; i++) {
				var nombre=data.usuarios[i].NOMUSU;//+' '+data.usuarios[i].APPUSU+' '+data.usuarios[i].PAMUSU;
				htmlUsuarios+='<div class="taller" onclick="addWord(\''+nombre+'\','+data.usuarios[i].CODUSU+','+data.usuarios[i].CODROL+')">'+nombre+'</div>';
			}
			listaUsuarios.push(data.usuarios);
			$(".listaTalleres").append(htmlUsuarios);
			//console.log(listaUsuarios);
			$(".panelCarga").fadeOut(300);
		}
	});
}

$(document).ready(function(){
	$("#nombreusuario").keyup(function(){
		$(".listaTalleres").empty();
		var htmlTalleres="";
		var busqueda=document.getElementById("nombreusuario").value;
		for (var i = 0; i < listaUsuarios[0].length; i++) {
			var nombre=listaUsuarios[0][i].NOMUSU;//+' '+listaUsuarios[0][i].appusu+' '+listaUsuarios[0][i].apmusu;
			if ((nombre.toUpperCase()).indexOf(busqueda.toUpperCase())>=0) {				
				htmlTalleres+='<div class="taller" onclick="addWord(\''+nombre+'\','+listaUsuarios[0][i].CODUSU+','+listaUsuarios[0][i].CODROL+')">'+nombre+"</div>";
			}
			document.getElementById("btnUpdate").disabled=true;
			document.getElementById("btnUpdate").classList.add("btnPrimaryDisabled");
			document.getElementById("rolusuario").value=0;
		}
		$(".listaTalleres").append(htmlTalleres);
	});
});

var codRolUsuario=0;
var codUsuario=0;
function addWord(nombre,codusu,codrol){
	document.getElementById("nombreusuario").value=nombre;
	document.getElementById("rolusuario").value=codrol;
	document.getElementById("btnUpdate").disabled=false;
	document.getElementById("btnUpdate").classList.remove("btnPrimaryDisabled");
	codUsuario=codusu;
	codRolUsuario=codrol;
}

function updateRolUsuario(){
	if (document.getElementById("rolusuario").value!=0||document.getElementById("rolusuario").value=="") {
		$(".panelCarga").fadeIn(300);
		$.ajax({
			url:"config/updateRolUsuario.php",
			data:{
				codusu:codUsuario,
				codrol:document.getElementById("rolusuario").value
			},
			type:"POST",
			success:function(data){
				if (data.state==true) {
					alert("Cambio de rol exitoso!");
					window.location.reload();
				}else{
					alert("No se pudo cambiar el rol del usuario!");
				}
				$(".panelCarga").fadeOut(300);
			}
		});
	}else{
		alert("Escoja el rol del usuario!");
	}
}