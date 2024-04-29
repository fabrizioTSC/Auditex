function cargarFondo(){
	var height=document.documentElement.clientHeight;
	$(".allBody").css("height",height);
}

$(document).ready(function(){
	$(".btnPrimaryLogin").click(function(){
		$(".panelCarga").fadeIn(300);
	});
});