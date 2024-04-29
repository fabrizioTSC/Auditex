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
		input[type="number"]{
			width: calc(100% - 12px); 
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
			<div class="headerTitle">Consultar Auditoria de Tela Rectilineo</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">			
			<div class="rowLine" style="display: flex;">
				<div class="lbl" style="width: 120px;">Ingrese partida:</div>
				<input type="text" id="idpartida" class="classIpt" style="width: 150px;">
				<button class="btnPrimary" style="margin-left: 10px;width: 40px;" onclick="search_partida()"><i class="fa fa-search" aria-hidden="true"></i></button>
			</div>
			<div id="list-partidas" style="display: none;">
				<div class="lineDecoration"></div>
				<div class="lbl" style="margin-bottom: : 10px;">Seleccione partida a consultar</div>
				<div>
					<div class="tblHeader">
						<div class="itemHeader" style="width: 40%;text-align: center;">Proveedor</div>
						<div class="itemHeader" style="width: 20%;text-align: center;">Cod. Tela</div>
						<div class="itemHeader" style="width: 20%;text-align: center;">Parte</div>
						<div class="itemHeader" style="width: 20%;text-align: center;">Vez</div>
					</div>
					<div class="tblBody" id="data-partidas">
					</div>
				</div>
			</div>
			<div class="lineDecoration"></div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="redirect('main.php')">Volver</button>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		function search_partida(){
			if ($("#idpartida").val()=="") {
				alert("Ingrese una partida!");
			}else{
				$(".panelCarga").fadeIn(100);
				$("#list-partidas").css("display","none");
				$.ajax({
					type:'POST',
					url:'config/searchParTelRecTer.php',
					data:{
						partida:$("#idpartida").val().toUpperCase()
					},
					success:function(data){
						if (data.state) {
							console.log(data);
							var html='';
							for (var i = 0; i < data.partidas.length; i++) {
								html+=
								'<div class="tblLine" onclick="send_page(\''+data.partidas[i].CODPRV+'\',\''+data.partidas[i].CODTEL+'\',\''+data.partidas[i].CODTAD+'\',\''+data.partidas[i].PARTE+'\',\''+data.partidas[i].NUMVEZ+'\')">'+
									'<div class="itemBody" style="width: 40%;text-align: center;">'+data.partidas[i].DESCLI+'</div>'+
									'<div class="itemBody" style="width: 20%;text-align: center;">'+data.partidas[i].CODTEL+'</div>'+
									'<div class="itemBody" style="width: 20%;text-align: center;">'+data.partidas[i].PARTE+'</div>'+
									'<div class="itemBody" style="width: 20%;text-align: center;">'+data.partidas[i].NUMVEZ+'</div>'+
								'</div>';
							}
							$("#data-partidas").empty();
							$("#data-partidas").append(html);
							$("#list-partidas").css("display","block");
						}else{
							$("#list-partidas").css("display","none");
							alert(data.detail);
						}
						$(".panelCarga").fadeOut(100);
					}
				});
			}			
		}
		function validate_res(text){
			if (text!=null) {
				return text;
			}else{
				return '';
			}
		}
		function send_page(codprv,codtel,codtad,parte,numvez){
			let partida=$("#idpartida").val().toUpperCase();
			window.location.href="VerAudTelRec.php?partida="+partida+"&codprv="+codprv+"&codtel="+codtel+"&codtad="+codtad+"&parte="+parte+"&numvez="+numvez;
		}
	</script>
</body>
</html>