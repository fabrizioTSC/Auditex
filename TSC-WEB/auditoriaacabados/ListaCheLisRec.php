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
	<link rel="stylesheet" type="text/css" href="css/index-v1.0.css">
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
			<div class="headerTitle">Check list Pendientes</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">			
			<div class="rowLine" style="display: flex;">
				<div class="lbl" style="width: 80px;margin-right: 5px;">Ficha:</div>
				<div class="spaceIpt" style="max-width: calc(100% - 160px);width:150px;font-size: 15px">
					<input type="text" id="idcodfic" class="classIpt">
				</div>
			</div>
			<div style="color: #bf3b3b;margin-top: 5px;display: none;" id="msg-nopartidas">No hay pedido - color rechazados</div>
			<div class="mainContent" style="margin-top: 5px; display: block;" id="tablepartidas">
				<div class="tblContent" style="overflow-x: scroll;max-height: calc(100vh - 159px);">
					<div class="tblHeader" style="width: auto;">
						<div class="itemHeader" style="width:90px;">Ficha</div>
						<div class="itemHeader" style="width:90px;">Parte</div>
						<div class="itemHeader" style="width:90px;">Numvez</div>
						<div class="itemHeader" style="width:150px;">Fec Inicio</div>
						<div class="itemHeader" style="width:150px;">Fec Rec</div>
						<div class="itemHeader" style="width:150px;">Auditor</div>
						<div class="itemHeader" style="width:150px;">Motivo</div>
						<div class="itemHeader" style="width:100px;">Max Def</div>
						<div class="itemHeader" style="width:100px;">Prendas</div>
						<div class="itemHeader" style="width:100px;">Defectos</div>
						<div class="itemHeader" style="width:150px;">Taller</div>
						<div class="itemHeader" style="width:150px;">Célula</div>
					</div>
					<div class="tblBody" style="width: 1590px;" id="table-body">
					</div>
				</div>
			</div>
			<div class="lineDecoration"></div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="window.history.back();">Volver</button>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		var ar_fichas=[];
		$(document).ready(function(){			
			$.ajax({
				type:'POST',
				url:'config/getCheLisRecACA.php',
				success:function(data){
					console.log(data);
					ar_fichas=data.fichas;
					var html='';
					if (data.state) {
						for (var i = 0; i < ar_fichas.length; i++) {
							html+=
								'<div style="display: flex;" onclick="show_detail(\''+ar_fichas[i].CODFIC+'\',\''+ar_fichas[i].PARTE+'\',\''+ar_fichas[i].NUMVEZ+'\')">'+
									'<div class="itemBody" style="width:90px;">'+ar_fichas[i].CODFIC+'</div>'+
									'<div class="itemBody" style="width:90px;">'+ar_fichas[i].PARTE+'</div>'+
									'<div class="itemBody" style="width:90px;">'+ar_fichas[i].NUMVEZ+'</div>'+
									'<div class="itemBody" style="width:150px;">'+val_null(ar_fichas[i].FECINIAUD)+'</div>'+
									'<div class="itemBody" style="width:150px;">'+val_null(ar_fichas[i].FECFINAUD)+'</div>'+
									'<div class="itemBody" style="width:150px;">'+ar_fichas[i].CODUSU+'</div>'+
									'<div class="itemBody" style="width:150px;">'+ar_fichas[i].MOTIVO+'</div>'+
									'<div class="itemBody" style="width:100px;">'+ar_fichas[i].CANDEFMAX+'</div>'+
									'<div class="itemBody" style="width:100px;">'+ar_fichas[i].CANTIDAD+'</div>'+
									'<div class="itemBody" style="width:100px;">'+ar_fichas[i].CANDEF+'</div>'+
									'<div class="itemBody" style="width:150px;">'+ar_fichas[i].DESTLL+'</div>'+
									'<div class="itemBody" style="width:150px;">'+ar_fichas[i].DESCEL+'</div>'+
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
		$("#idcodfic").keyup(function(){
			var html='';
			for (var i = 0; i < ar_fichas.length; i++) {
				if ((ar_fichas[i].CODFIC).toUpperCase().indexOf($("#idcodfic").val().toUpperCase())>=0) {
					html+=
						'<div style="display: flex;" onclick="show_detail(\''+ar_fichas[i].CODFIC+'\',\''+ar_fichas[i].PARTE+'\',\''+ar_fichas[i].NUMVEZ+'\')">'+
							'<div class="itemBody" style="width:90px;">'+ar_fichas[i].CODFIC+'</div>'+
							'<div class="itemBody" style="width:90px;">'+ar_fichas[i].PARTE+'</div>'+
							'<div class="itemBody" style="width:90px;">'+ar_fichas[i].NUMVEZ+'</div>'+
							'<div class="itemBody" style="width:150px;">'+val_null(ar_fichas[i].FECINIAUD)+'</div>'+
							'<div class="itemBody" style="width:150px;">'+val_null(ar_fichas[i].FECFINAUD)+'</div>'+
							'<div class="itemBody" style="width:150px;">'+ar_fichas[i].CODUSU+'</div>'+
							'<div class="itemBody" style="width:150px;">'+ar_fichas[i].MOTIVO+'</div>'+
							'<div class="itemBody" style="width:100px;">'+ar_fichas[i].CANDEFMAX+'</div>'+
							'<div class="itemBody" style="width:100px;">'+ar_fichas[i].CANTIDAD+'</div>'+
							'<div class="itemBody" style="width:100px;">'+ar_fichas[i].CANDEF+'</div>'+
							'<div class="itemBody" style="width:150px;">'+ar_fichas[i].DESTLL+'</div>'+
							'<div class="itemBody" style="width:150px;">'+ar_fichas[i].DESCEL+'</div>'+
						'</div>';
				}
			}
			$("#table-body").empty();
			$("#table-body").append(html);
		});
		function val_null(text){
			if (text==null) {
				return '';
			}else{
				return text;
			}
		}
		function show_detail(codfic,parte,numvez){
			window.location.href="IniciarAudAca.php?codfic="+codfic+"&chelis="+1;
		}
	</script>
</body>
</html>