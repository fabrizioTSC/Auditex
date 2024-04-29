var usuarios=[];
$(document).ready(function(){
	$.ajax({
		type:"POST",
		data:{
		},
		url:"config/getUsuAplConfig.php",
		success:function(data){
			console.log(data);

			usuarios=data.usuarios;
			var html='';
			for (var i = 0; i < usuarios.length; i++) {
				html+='<div class="taller" onclick="selectUsuario(\''+
				usuarios[i].CODUSU+'\',\''+formatText(usuarios[i].NOMUSU)+'\')">'+
				usuarios[i].CODUSU+' - '+usuarios[i].NOMUSU+'</div>';
			}
			$("#listausuarios").empty();
			$("#listausuarios").append(html);

			codtll_var="0";

			$(".panelCarga").fadeOut(100);			
		}
	});
	$("#idusuario").keyup(function(){
		var html='';
		for (var i = 0; i < usuarios.length; i++) {
			if ((usuarios[i].CODUSU.toUpperCase()+" "+usuarios[i].NOMUSU.toUpperCase()).indexOf($("#idusuario").val().toUpperCase())>=0) {
				html+='<div class="taller" onclick="selectUsuario(\''+
				usuarios[i].CODUSU+'\',\''+formatText(usuarios[i].NOMUSU)+'\')">'+
				usuarios[i].CODUSU+' - '+usuarios[i].NOMUSU+'</div>';
			}
		}
		$("#listausuarios").empty();
		$("#listausuarios").append(html);		
	});
});

var codusu_var="";
function selectUsuario(codusu,nomusu){
	codusu_var=codusu;
	$("#idusuario").val(nomusu);
}

function mostrar_roles(){
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		data:{
			codusu:codusu_var
		},
		url:"config/getRolesUsuario.php",
		success:function(data){
			console.log(data);
			if (data.usuarioroles.length>0) {
				let htmlroles='';
				for (var i = 0; i < data.roles.length; i++) {
					htmlroles+='<option value="'+data.roles[i].CODROL+'">'+data.roles[i].DESROL+'</option>';
				}

				let html=
					'<tr>'+
						'<th>Auditor&iacute;a</th>'+
						//'<th>Estado</th>'+
						'<th>Rol</th>'+
					'</tr>';
				for (var i = 0; i < data.usuarioroles.length; i++) {
					let checked='';
					html+=
					'<tr>'+
						'<td>'+data.usuarioroles[i].DESTAD+'</td>'+
						//'<td><input type="checkbox" id="" '+checked+'></td>'+
						'<td><select class="classCmbBox" id="select-'+
						data.usuarioroles[i].CODTAD+'">'+
							htmlroles
						'</select></td>'+
					'</tr>';				
				}
				document.getElementById("tblbody").innerHTML=html;
				for (var i = 0; i < data.usuarioroles.length; i++) {
					document.getElementById("select-"+data.usuarioroles[i].CODTAD).value=
					data.usuarioroles[i].CODROL;
				}
				document.getElementById("idresult").style.display="block";
			}else{
				document.getElementById("idresult").style.display="none";
				alert("No hay roles para el usuario!");
			}
			$(".panelCarga").fadeOut(100);			
		}
	});
}

function save_roles(){
	let ar=document.getElementsByClassName("classCmbBox");
	let ar_send=[];
	for (var i = 0; i < ar.length; i++) {
		let ar_aux=[];
		ar_aux.push(ar[i].id.replace("select-",""));
		ar_aux.push(ar[i].value);
		ar_send.push(ar_aux);
	}
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		data:{
			codusu:codusu_var,
			array:ar_send
		},
		url:"config/saveRolesUsuario.php",
		success:function(data){
			console.log(data);
			if (!data.state) {
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(100);			
		}
	});
}