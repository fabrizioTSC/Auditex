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
			<div class="headerTitle">Calidad Interna Rec.</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">			
			<div class="rowLine" style="display: flex;">
				<div class="lbl" style="width: 130px;margin-right: 5px;">Pedido - Color:</div>
				<div class="spaceIpt" style="max-width: calc(100% - 160px);width:150px;font-size: 15px">
					<input type="text" id="idpedcol" class="classIpt">
				</div>
			</div>
			<div style="color: #bf3b3b;margin-top: 5px;display: none;" id="msg-nopartidas">No hay pedido - color rechazados</div>
			<div class="mainContent" style="margin-top: 5px; display: block;" id="tablepartidas">
				<div class="tblContent" style="overflow-x: scroll;">
					<div class="tblHeader" style="width: auto;">
						<div class="itemHeader" style="width:100px;">PEDIDO</div>
						<div class="itemHeader" style="width:150px;">COLOR</div>
						<div class="itemHeader" style="width:150px;">VEZ</div>
						<div class="itemHeader" style="width:150px;">FEC REC</div>
						<div class="itemHeader" style="width:150px;">AUDITOR</div>
						<div class="itemHeader" style="width:150px;">COORDINADOR</div>
						<div class="itemHeader" style="width:100px;">CAN AUD</div>
						<div class="itemHeader" style="width:100px;">MAX DEF</div>
						<div class="itemHeader" style="width:100px;">CAN DEF</div>
					</div>
					<div class="tblBody" style="width: 1240px;" id="table-body">
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
				url:'config/getCalIntRecAF.php',
				success:function(data){
					console.log(data);
					ar_fichas=data.pedcol;
					var html='';
					if (data.state) {
						for (var i = 0; i < ar_fichas.length; i++) {
							html+=
								'<div style="display: flex;" onclick="show_detail(\''+ar_fichas[i].PEDIDO+'\',\''+ar_fichas[i].DESCOL+'\',\''+ar_fichas[i].NUMVEZ+'\')">'+
									'<div class="itemBody" style="width:100px;">'+ar_fichas[i].PEDIDO+'</div>'+
									'<div class="itemBody" style="width:150px;">'+ar_fichas[i].DESCOL+'</div>'+
									'<div class="itemBody" style="width:150px;">'+ar_fichas[i].NUMVEZ+'</div>'+
									'<div class="itemBody" style="width:150px;">'+ar_fichas[i].FECFINAUD+'</div>'+
									'<div class="itemBody" style="width:150px;">'+ar_fichas[i].CODUSU+'</div>'+
									'<div class="itemBody" style="width:150px;">'+val_null(ar_fichas[i].CODUSUEJE)+'</div>'+
									'<div class="itemBody" style="width:100px;">'+ar_fichas[i].CANAUD+'</div>'+
									'<div class="itemBody" style="width:100px;">'+ar_fichas[i].CANDEFMAX+'</div>'+
									'<div class="itemBody" style="width:100px;">'+ar_fichas[i].CANDEF+'</div>'+
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
		$("#idpedcol").keyup(function(){
			var html='';
			for (var i = 0; i < ar_fichas.length; i++) {
				if ((ar_fichas[i].PEDIDO+ar_fichas[i].DESCOL).toUpperCase().indexOf($("#idpedcol").val().toUpperCase())>=0) {
					html+=
						'<div style="display: flex;" onclick="show_detail(\''+ar_fichas[i].PEDIDO+'\',\''+ar_fichas[i].DESCOL+'\',\''+ar_fichas[i].NUMVEZ+'\')">'+
							'<div class="itemBody" style="width:100px;">'+ar_fichas[i].PEDIDO+'</div>'+
							'<div class="itemBody" style="width:150px;">'+ar_fichas[i].DESCOL+'</div>'+
							'<div class="itemBody" style="width:150px;">'+ar_fichas[i].NUMVEZ+'</div>'+
							'<div class="itemBody" style="width:150px;">'+ar_fichas[i].FECFINAUD+'</div>'+
							'<div class="itemBody" style="width:150px;">'+ar_fichas[i].CODUSU+'</div>'+
							'<div class="itemBody" style="width:150px;">'+val_null(ar_fichas[i].CODUSUEJE)+'</div>'+
							'<div class="itemBody" style="width:100px;">'+ar_fichas[i].CANAUD+'</div>'+
							'<div class="itemBody" style="width:100px;">'+ar_fichas[i].CANDEFMAX+'</div>'+
							'<div class="itemBody" style="width:100px;">'+ar_fichas[i].CANDEF+'</div>'+
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
		function show_detail(pedido,color,numvez){
			window.location.href="ConAudCalInt.php?pedido="+pedido+"&color="+color+"&numvez="+numvez;
		}
	</script>
</body>
</html>