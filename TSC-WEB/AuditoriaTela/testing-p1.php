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
			<div class="headerTitle">Seleccionar partida</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">			
			<div class="rowLine" style="display: flex;">
				<div class="lbl" style="width: 120px;">Ingrese partida:</div>
				<div class="spaceIpt" style="width: calc(120px);font-size: 15px">
					<input type="text" id="idpartida" class="classIpt">
				</div>
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;" onclick="buscar_partida()">Buscar</button>
			<div id="list-partidas" style="display: none;">
				<div class="lineDecoration"></div>
					<div class="tblHeader">
						<div class="itemHeader" style="width: 40%;text-align: center;">Proveedor</div>
						<div class="itemHeader" style="width: 20%;text-align: center;">Cod. Tela</div>
						<div class="itemHeader" style="width: 15%;text-align: center;">Cod. Aud.</div>
						<div class="itemHeader" style="width: 8%;text-align: center;">Parte.</div>
						<div class="itemHeader" style="width: 8%;text-align: center;">Vez</div>
						<div class="itemHeader" style="width: 9%;text-align: center;">Res.</div>
					</div>
					<div class="tblBody" id="data-partidas">
					</div>
				</div>
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="redirect('main.php')">Volver</button>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		function buscar_partida(){
			if ($("#idpartida").val()=="") {
				alert("Ingrese una partida!");
			}else{
				$(".panelCarga").fadeIn(100);
				$("#list-partidas").css("display","none");
				$.ajax({
					type:'POST',
					url:'config/getPartidasTesting.php',
					data:{
						partida:$("#idpartida").val().toUpperCase()
					},
					success:function(data){
						console.log(data);
						if (data.partidas.length==0) {
							alert('Partida no encontrada!');
						}else{
							var html='';
							for (var i = 0; i < data.partidas.length; i++) {
								html+=
								'<div class="tblLine" onclick="redirect(\'testing-p2.php?p='+$("#idpartida").val().toUpperCase()+'&codprv='+data.partidas[i].CODPRV+
								'&codtel='+data.partidas[i].CODTEL+
								'&codtad='+data.partidas[i].CODTAD+
								'&parte='+data.partidas[i].PARTE+
								'&numvez='+data.partidas[i].NUMVEZ+'\')">'+
									'<div class="itemBody" style="width: 40%;text-align: center;">'+data.partidas[i].DESPRV+'</div>'+
									'<div class="itemBody" style="width: 20%;text-align: center;">'+data.partidas[i].CODTEL+'</div>'+
									'<div class="itemBody" style="width: 15%;text-align: center;">'+data.partidas[i].CODTAD+'</div>'+
									'<div class="itemBody" style="width: 8%;text-align: center;">'+data.partidas[i].PARTE+'</div>'+
									'<div class="itemBody" style="width: 8%;text-align: center;">'+data.partidas[i].NUMVEZ+'</div>'+
									'<div class="itemBody" style="width: 9%;text-align: center;">'+data.partidas[i].RESULTADO+'</div>'+
								'</div>';
							}
							$("#data-partidas").empty();
							$("#data-partidas").append(html);
							$("#list-partidas").css("display","block");
						}
						$(".panelCarga").fadeOut(100);
					}
				});
			}			
		}
	</script>
</body>
</html>