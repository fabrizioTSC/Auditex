<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="3";
	include("config/_validate_access.php");
	include("config/_contentMenu.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>AUDITEX</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<style type="text/css">
		.lbl2{
			width: 150px;
			padding-right: 5px;
		}
		.lbl3{
			font-size: 12px;
		}
		.contentInput{
			width: calc(100% - 155px);
		}
		.specialIpt{
			width: 150px;
		}
		@media(max-width: 400px){
			.lbl2{
				width: calc(40% - 5px);
			}
			.contentInput{
				width: calc(60%);
			}
			.specialIpt{
				width: calc(100% - 16px);
			}
		}
	</style>
</head>
<body>
	<?php contentMenu();?>
	<div class="panelCarga" style="display: none;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Editar medidas auditables Estilo TSC</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>		
		<div class="bodyContent mainBodyContent">
			<div class="sameline" style="margin-bottom: 5px;">
				<div class="lbl lbl2">Estilo TSC:</div>
				<div class="contentInput">
					<input type="text" id="idesttsc" class="classIpt specialIpt">
				</div>
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;margin-bottom: 0px;" onclick="search_esttsc()">Buscar</button>
			<div id="no-result" style="display: none;">
				<div class="lineDecoration"></div>
				<div style="color: #b91a1a;font-size: 15px;font-weight: bold;">Estilo TSC no existe</div>
			</div>
			<div id="content-tela" style="display: none;">
				<div class="lineDecoration"></div>
				<div id="maintbl" style="margin-bottom: 10px;overflow-y: scroll;height: calc(100vh - 211px);position: relative;margin-top: 10px;">
					<div id="bodytbl" style="position: relative;">
						<div class="tblHeader" id="data-header" style="position: relative;z-index: 11;">
							<div class="itemHeader" style="width: 40%;text-align: center;">Des. Medida</div>
							<div class="itemHeader" style="width: 20%;text-align: center;">Des. Medida Corta</div>
							<div class="itemHeader" style="width: 20%;text-align: center;">P/C</div>
							<div class="itemHeader" style="width: 20%;text-align: center;">
								<div>Auditable</div>
								<input type="checkbox" id="save-all" style="margin: 0px;" />
							</div>
						</div>
						<div class="tblBody" id="data-preview" style="position: relative;">
						</div>
					</div>
				</div>
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;margin-bottom: 0px;" onclick="save_changes()">Guardar</button>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		var click_all=0;
		$(document).ready(function(){
			$("#maintbl").scroll(function(){
				if ($("#maintbl").scrollTop()>50) {
					$("#data-header").css("position","absolute");
					$("#data-header").css("top",$("#maintbl").scrollTop()+"px");
				}else{
					$("#data-header").css("position","relative");
					$("#data-header").css("top","0px");
				}
			});
			$("#save-all").click(function(){
				var ar=document.getElementsByClassName("check-save");
				if (click_all==0) {
					click_all=1;
					for (var i = 0; i < ar.length; i++) {
						ar[i].checked=true;
						ar[i].dataset.clicked="1";
					}
				}else{
					click_all=0;
					for (var i = 0; i < ar.length; i++) {
						ar[i].checked=false;
						ar[i].dataset.clicked="1";
					}
				}
			});
		});
		function search_esttsc(){
			if($("#idcodtel").val()!=""){
				$(".panelCarga").fadeIn(100);
				$("#no-result").css("display","none");
				$("#content-tela").css("display","none");
				$.ajax({
					type:"POST",
					url:"config/getEstTsc.php",
					data:{
						esttsc:$("#idesttsc").val()
					},
					success:function(data){
						console.log(data);
						if (data.esttsc.length>0) {
							var html='';
							for (var i = 0; i < data.esttsc.length; i++) {
								html+=
								'<div class="tblLine">'+
				            		'<div class="itemBody" style="width: 40%;text-align: center;">'+data.esttsc[i].DESMED+'</div>'+
				            		'<div class="itemBody" style="width: 20%;text-align: center;">'+data.esttsc[i].DESMEDCOR+'</div>'+
									'<div class="itemBody" style="width: 20%;text-align: center;">'+data.esttsc[i].PARTE+'</div>'+
				            		'<div class="itemBody" style="width: 20%;text-align: center;">'+
				            			'<input type="checkbox" data-clicked="0" class="check-save" data-codmed="'+data.esttsc[i].CODMED+'" '+validar_check(data.esttsc[i].AUDITABLE)+'/>'
				            		+'</div>'+
								'</div>';
							}
							html+=
							'<script>'+
								'$(document).ready(function(){'+
									'$(".check-save").click(function(){'+
										'update_click(this)'+
									'});'+
								'});';
							$("#data-preview").empty();
							$("#data-preview").append(html);
							$("#content-tela").css("display","block");
						}else{
							$("#no-result").css("display","block");
						}
						$(".panelCarga").fadeOut(100);
					}
				});
			}else{
				alert("Complete el codigo de tela!");
			}
		}
		function update_click(dom){
			dom.dataset.clicked="1";
		}
		function validar_check(text){
			if (text=="A") {
				return "checked";
			}else{
				return "";
			}
		}
		function save_changes(){			
			var ar=document.getElementsByClassName("check-save");
			var ar_send=[];
			for (var i = 0; i < ar.length; i++) {
				if (ar[i].dataset.clicked=="1") {
					var ar_aux=[];
					ar_aux.push(ar[i].dataset.codmed);
					if (ar[i].checked) {
						ar_aux.push("A");
					}else{
						ar_aux.push("");
					}
					ar_send.push(ar_aux);
				}
			}
			console.log(ar_send);
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				url:"config/updateInfoEstTsc.php",
				data:{
					esttsc:$("#idesttsc").val(),
					array:ar_send
				},
				success:function(data){
					console.log(data);
					if (!data.state) {
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
	</script>
</body>
</html>