<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="1";
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
	<div class="panelCarga" style="display: block;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Cargar Tela</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>		
		<div class="bodyContent mainBodyContent">
			<div class="sameline" style="margin-bottom: 5px;">
				<div class="lbl lbl2">C&oacute;digo Tela:</div>
				<div class="contentInput">
					<input type="text" id="idcodtel" class="classIpt specialIpt">
				</div>
			</div>
			<div class="sameline" style="margin-bottom: 5px;">
				<div class="lbl lbl2">C&oacute;digo Prov.:</div>
				<div class="contentInput">
					<input type="text" id="idcodprv" class="classIpt specialIpt">
				</div>
			</div>
			<div class="sameline" style="margin-bottom: 5px;">
				<div class="lbl lbl2">Descripci&oacute;n Tela:</div>
				<div class="contentInput">
					<input type="text" id="iddestel" class="classIpt">
				</div>
			</div>
			<div class="sameline" style="margin-bottom: 5px;">
				<div class="lbl lbl2">Composici&oacute;n final:</div>
				<div class="contentInput">
					<input type="text" id="idcomfin" class="classIpt">
				</div>
			</div>
			<div class="sameline" style="margin-bottom: 5px;">
				<div class="lbl lbl2">Rendimiento por peso:</div>
				<div class="contentInput">
					<input type="text" id="idren" class="classIpt">
				</div>
			</div>
			<div class="sameline" style="margin-bottom: 5px;">
				<div class="lbl lbl2">Ruta:</div>
				<div class="contentInput">
					<input type="text" id="idruttel" class="classIpt">
				</div>
			</div>
			<div class="sameline" style="margin-bottom: 5px;">
				<div class="lbl lbl2" style=""></div>
				<div class="contentInput" style="display: flex;">
					<div class="lbl lbl2" style="width: calc(50% - 3px); margin-right: 3px;text-align: center;">Valor</div>
					<div class="lbl lbl2" style="width: calc(50% - 3px); margin-left: 3px;text-align: center;">Tolerancia</div>
				</div>
			</div>
			<div id="content-estdim">
				<div class="sameline" style="margin-bottom: 5px;">
					<div class="lbl lbl2" style="">Composici&oacute;n final</div>
					<div class="contentInput" style="display: flex;">
						<input type="text" data-cod="" data-tipo="1" class="classIpt classsave" style="width: calc(50% - 3px); margin-right: 3px;">
						<input type="text" data-cod="" data-tipo="2" class="classIpt" style="width: calc(50% - 3px); margin-left: 3px;">
					</div>
				</div>
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;margin-bottom: 0px;" onclick="send_data()">Guardar</button>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$.ajax({
				type:"POST",
				url:"config/getInfoEstDim.php",
				success:function(data){
					console.log(data);
					var html='';
					for (var i = 0; i < data.estdim.length; i++) {
						html+=
						'<div class="sameline" style="margin-bottom: 5px;">'+
							'<div class="lbl lbl2 lbl3" style="">'+data.estdim[i].DESESTDIM+'</div>'+
							'<div class="contentInput" style="display: flex;">'+
								'<input type="text" data-cod="'+data.estdim[i].CODESTDIM+'" data-tipo="1" class="classIpt classsave" style="width: calc(50% - 3px); margin-right: 3px;" placeholder="'+validate_content(data.estdim[i].DIMVAL)+'">'+
								'<input type="text" data-cod="'+data.estdim[i].CODESTDIM+'" data-tipo="2" class="classIpt classsave" style="width: calc(50% - 3px); margin-left: 3px;" placeholder="'+validate_content(data.estdim[i].DIMTOL)+'">'+
							'</div>'+
						'</div>';
					}
					$("#content-estdim").empty();
					$("#content-estdim").append(html);
					$(".panelCarga").fadeOut(100);
				}
			});
		});
		function validate_content(text){
			if (text==null) {
				return '';
			}else{
				return text;
			}
		}
		function send_data(){
			var ar=document.getElementsByClassName("classsave");
			var validado=true;
			var ar_send=[];
			var cod_ant=0;
			var ar_aux=[];
			for (var i = 0; i < ar.length; i++) {
				if(ar[i].value==""){
					validado=false;
				}
				if (cod_ant!=ar[i].dataset.cod) {
					if (i!=0) {
						ar_send.push(ar_aux);
					}
					ar_aux=[];
					cod_ant=ar[i].dataset.cod;
					ar_aux.push(cod_ant);
					ar_aux.push(ar[i].value);
				}else{
					ar_aux.push(ar[i].value);		
					if (i==ar.length-1) {
						ar_send.push(ar_aux);
					}			
				}
			}
			console.log(ar_send);
			if (validado && validar_campos()) {
				$(".panelCarga").fadeIn(100);
				$.ajax({
					type:"POST",
					url:"config/saveInfoTela.php",
					data:{
						codtel:$("#idcodtel").val(),
						codprv:$("#idcodprv").val(),
						destel:$("#iddestel").val(),
						comfin:$("#idcomfin").val(),
						ruttel:$("#idruttel").val(),
						ren:$("#idren").val(),
						array:ar_send
					},
					success:function(data){
						console.log(data);
						alert(data.detail);
						if (data.state) {
							window.location.reload();
						}
						$(".panelCarga").fadeOut(100);
					}
				});
			}else{
				alert("Complete todos los campos!");
			}
		}
		function validar_campos(){
			if ($("#idcodtel").val()!=""
				&& $("#iddestel").val()!=""
				&& $("#idcomfin").val()!=""
				&& $("#idren").val()!=""
				&& $("#idruttel").val()!="") {
				return true;
			}else{
				return false;
			}
		}
	</script>
</body>
</html>