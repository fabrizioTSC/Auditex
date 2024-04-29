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
		.itemBodyLink{
			text-decoration: underline;
			color: #1d1dd4;
			cursor: pointer;
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
			<div class="headerTitle">Partidas a Auditar</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">			
			<div class="rowLine" style="display: flex;">
				<div class="lbl" style="width: 120px;">Buscar partida:</div>
				<div class="spaceIpt" style="width: calc(120px);font-size: 15px">
					<input type="text" id="idpartida" class="classIpt">
				</div>
			</div>
			<div style="color: #bf3b3b;margin-top: 5px;display: none;" id="msg-nopartidas">No existe partida!</div>
			<div class="mainContent" style="margin-top: 5px; display: block;" id="tablepartidas">
				<div class="tblContent" style="overflow-x: scroll;">
					<div class="tblHeader" style="width: auto;">
						<div class="itemHeader" style="width:100px;">PARTIDA</div>
						<div class="itemHeader" style="width:100px;">COD. TEL.</div>
						<div class="itemHeader" style="width:150px;">DES. PROVEEDOR</div>
						<div class="itemHeader" style="width:100px;">NUM. VEZ</div>
						<div class="itemHeader" style="width:100px;">PARTE</div>
						<div class="itemHeader" style="width:100px;">CODTAD</div>
					</div>
					<div class="tblBody" style="width: 710px;" id="table-body">
					</div>
				</div>
			</div>
			<div class="lineDecoration"></div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="redirect('main.php')">Volver</button>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		var partidas_ar;
		$(document).ready(function(){			
			$.ajax({
				type:'POST',
				url:'config/getPartidasAAuditar.php',
				success:function(data){
					console.log(data);
					partidas_ar=data.partidas;
					var html='';
					if (data.state) {
						for (var i = 0; i < partidas_ar.length; i++) {
							html+=
								'<div style="display: flex;" onclick="show_detail(\''+partidas_ar[i].PARTIDA+'\',\''+partidas_ar[i].CODTEL+'\','+
								'\''+partidas_ar[i].CODPRV+'\',\''+partidas_ar[i].NUMVEZ+'\',\''+partidas_ar[i].PARTE+'\',\''+partidas_ar[i].CODTAD+'\')">'+
									'<div class="itemBody itemBodyLink" style="width:100px;">'+partidas_ar[i].PARTIDA+'</div>'+
									'<div class="itemBody" style="width:100px;">'+partidas_ar[i].CODTEL+'</div>'+
									'<div class="itemBody" style="width:150px;">'+partidas_ar[i].DESPRV+'</div>'+
									'<div class="itemBody" style="width:100px;">'+partidas_ar[i].NUMVEZ+'</div>'+
									'<div class="itemBody" style="width:100px;">'+partidas_ar[i].PARTE+'</div>'+
									'<div class="itemBody" style="width:100px;">'+partidas_ar[i].CODTAD+'</div>'+
								'</div>';
						}
						$("#table-body").empty();
						$("#table-body").append(html);
						$("#tablepartidas").css("display","block");
						$("#msg-nopartidas").css("display","none");
					}else{
						$("#tablepartidas").css("display","none");
						$("#msg-nopartidas").css("display","block");
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		});
		$("#idpartida").keyup(function(){
			var html='';
			for (var i = 0; i < partidas_ar.length; i++) {
				if ((partidas_ar[i].PARTIDA).toUpperCase().indexOf($("#idpartida").val().toUpperCase())>=0) {
					html+=
						'<div style="display: flex;" onclick="show_detail(\''+partidas_ar[i].PARTIDA+'\',\''+partidas_ar[i].CODTEL+'\','+
						'\''+partidas_ar[i].CODPRV+'\',\''+partidas_ar[i].NUMVEZ+'\',\''+partidas_ar[i].PARTE+'\',\''+partidas_ar[i].CODTAD+'\')">'+
							'<div class="itemBody itemBodyLink" style="width:100px;">'+partidas_ar[i].PARTIDA+'</div>'+
							'<div class="itemBody" style="width:100px;">'+partidas_ar[i].CODTEL+'</div>'+
							'<div class="itemBody" style="width:150px;">'+partidas_ar[i].DESPRV+'</div>'+
							'<div class="itemBody" style="width:100px;">'+partidas_ar[i].NUMVEZ+'</div>'+
							'<div class="itemBody" style="width:100px;">'+partidas_ar[i].PARTE+'</div>'+
							'<div class="itemBody" style="width:100px;">'+partidas_ar[i].CODTAD+'</div>'+
						'</div>';
				}
			}
			$("#table-body").empty();
			$("#table-body").append(html);
		});
		function show_detail(partida,codtel,codprv,numvez,parte,codtad){
			window.location.href="AuditoriaTela.php?p="+partida.toUpperCase()+"&codprv="+codprv;
		}
	</script>
</body>
</html>