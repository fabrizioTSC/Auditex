function search_ficha(){	
	$(".panelCarga").fadeIn(100);
	$.ajax({
		type:"POST",
		url:"config/getFichasCLACA.php",
		data:{
			codfic:$("#idcodfic").val()
		},
		success:function(data){
			console.log(data);
			if (data.state) {
				window.location.href="CheckListAcabados.php?codfic="+$("#idcodfic").val()+
				"&codtipser="+$("#idcodtipser").val();
			}else{
				alert(data.detail);
			}
			$(".panelCarga").fadeOut(100);
		}
	});	
}