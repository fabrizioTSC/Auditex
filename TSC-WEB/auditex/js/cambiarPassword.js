var codusuario=0;
function sendCodUser(codusu){
	codusuario=codusu;
}

function confirmarPassword(){
	var pass=document.getElementById("pass1").value;
	var pass2=document.getElementById("pass2").value;
	if (pass=="") {
		alert("Ingrese una contraseña!");
	}else{
		if (pass==pass2) {
			$.ajax({
				type:"POST",
				data:{
					codusu:codusuario,
					pass:pass
				},
				url:"config/changePassword.php",
				success:function(data){
					if (data.state==true) {
						alert(data.description);
						window.location.href="main.php";
					}else{
						alert(data.error.description);
					}
				}
			});
		}else{
			alert("No coinciden las contraseñas!");
		}
	}
}