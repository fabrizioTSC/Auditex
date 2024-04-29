$(document).ready(function(){
	$("#idcodfic").val(codfic);
	$(".btnBuscarSpace").click(function(){
		document.getElementById("table-result").style.display="none";
		var codfic=document.getElementById("idcodfic").value;
		if (codfic=="") {
			alert("Escriba el código de ficha!");
		}else{
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				url:"config/getFicTerACH.php",
				data:{
					codfic:codfic
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						document.getElementById("table-result").style.display="block";
						document.getElementById("table-body").innerHTML=data.html;
						//window.location.href="VerAudProNoCon.php?codfic="+codfic;
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
	});
	if (codfic!="") {
		$(".btnBuscarSpace").click();
	}
});

function show_consulta_ficha(numvez,parte){
	window.location.href="VerAudConHum.php?codfic="+document.getElementById("idcodfic").value+
	"&numvez="+numvez+
	"&parte="+parte;
}