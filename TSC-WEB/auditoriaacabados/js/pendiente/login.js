function cargarFondo(){
	var height=document.documentElement.clientHeight;
	$(".allBody").css("height",height);
}

$(document).ready(function(){
	$(".btnPrimaryLogin").click(function(){
		$("#idPassword").val($("#idPassword").val().toUpperCase());
		$(".panelCarga").fadeIn(300);
	});
});