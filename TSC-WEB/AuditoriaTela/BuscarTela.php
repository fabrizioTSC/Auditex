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
	<div class="panelCarga" style="display: none;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Consultar - Editar Tela</div>
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
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;margin-bottom: 0px;" onclick="search_tela()">Buscar</button>
			<div id="no-result" style="display: none;">
				<div class="lineDecoration"></div>
				<div style="color: #b91a1a;font-size: 15px;font-weight: bold;">Tela no existe</div>
			</div>
			<div id="content-tela" style="display: none;">
				<div class="lineDecoration"></div>
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
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;margin-bottom: 0px;" onclick="save_changes()">Guardar</button>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		function search_tela(){
			if($("#idcodtel").val()!=""){
				$(".panelCarga").fadeIn(100);
				$("#no-result").css("display","none");
				$("#content-tela").css("display","none");
				$.ajax({
					type:"POST",
					url:"config/getInfoTela.php",
					data:{
						codtel:$("#idcodtel").val()
					},
					success:function(data){
						console.log(data);
						if (data.estdim.length>0) {
							$("#idcodprv").val(data.infotela.CODTELPRV);
							$("#iddestel").val(data.infotela.DESTEL);
							$("#idcomfin").val(data.infotela.COMPOS);idren
							$("#idren").val(data.infotela.RENDIMIENTO);
							$("#idruttel").val(data.infotela.RUTA);
							var html='';
							for (var i = 0; i < data.estdim.length; i++) {
								html+=
								'<div class="sameline" style="margin-bottom: 5px;">'+
									'<div class="lbl lbl2 lbl3" style="">'+data.estdim[i].DESESTDIM+'</div>'+
									'<div class="contentInput" style="display: flex;">'+
										'<input type="text" class="classIpt classsave" style="width: calc(50% - 3px); margin-right: 3px;" data-pos="0" data-codestdim="'+data.estdim[i].CODESTDIM+'" value="'+validate_content(data.estdim[i].VALOR)+'">'+
										'<input type="text" class="classIpt classsave" style="width: calc(50% - 3px); margin-left: 3px;" data-pos="1" data-codestdim="'+data.estdim[i].CODESTDIM+'" value="'+validate_content(data.estdim[i].TOLERANCIA)+'">'+
									'</div>'+
								'</div>';
							}
							$("#content-estdim").empty();
							$("#content-estdim").append(html);
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
		function validate_content(text){
			text=text.replace(",",".");
			if (text[0]==".") {
				text="0"+text;
			}
			return text;
		}
		function save_changes(){			
			var ar=document.getElementsByClassName("classsave");
			var validado=true;
			var ar_send=[];
			var cod_ant=0;
			var ar_aux=[];
			for (var i = 0; i < ar.length; i++) {
				if(ar[i].value==""){
					validado=false;
				}
				if (cod_ant!=ar[i].dataset.codestdim) {
					if (i!=0) {
						ar_send.push(ar_aux);
					}
					ar_aux=[];
					cod_ant=ar[i].dataset.codestdim;
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
					url:"config/updateInfoTela.php",
					data:{
						codtel:$("#idcodtel").val(),
						codprv:$("#idcodprv").val(),
						destel:$("#iddestel").val(),
						comfin:$("#idcomfin").val(),
						ren:$("#idren").val(),
						ruttel:$("#idruttel").val(),
						array:ar_send
					},
					success:function(data){
						console.log(data);
						alert(data.detail);
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