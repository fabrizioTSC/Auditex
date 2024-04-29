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
	<div class="panelCarga" style="display: none;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Consultar / Editar Auditoria de Telas</div>
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
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 10px;" onclick="buscar_partida()">Buscar</button>
			<div style="color: #bf3b3b;margin-top: 5px;display: none;" id="msg-nopartidas">No existe partida!</div>
			<div class="mainContent" style="margin-top: 5px; display: none;" id="tablepartidas">
				<div class="tblContent" style="overflow-x: scroll;">
					<div class="tblHeader" style="width: auto;">
						<div class="itemHeader" style="width:100px;">COD. TEL.</div>
						<div class="itemHeader" style="width:150px;">DES. PROVEEDOR</div>
						<div class="itemHeader" style="width:100px;">COD. AUD.</div>
						<div class="itemHeader" style="width:100px;">NUM. VEZ</div>
						<div class="itemHeader" style="width:100px;">PARTE</div>
						<div class="itemHeader" style="width:100px;">ESTADO</div>
						<div class="itemHeader" style="width:100px;">RES.</div>
					</div>
					<div class="tblBody" style="width: 820px;" id="table-body">
					</div>
				</div>
			</div>
			<div class="lineDecoration"></div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="redirect('main.php')">Volver</button>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		function buscar_partida(){
			if ($("#idpartida").val()=="") {
				alert("Ingrese una partida!");
			}else{
				$(".panelCarga").fadeIn(100);
				$.ajax({
					type:'POST',
					url:'config/buscarPartida.php',
					data:{
						partida:$("#idpartida").val().toUpperCase()
					},
					success:function(data){
						console.log(data);
						var html='';
						if (data.state) {
							if(data.partidas.length==1){
								show_detail(data.partidas[0].CODTEL,data.partidas[0].CODPRV,data.partidas[0].NUMVEZ,data.partidas[0].PARTE,data.partidas[0].CODTAD);
							}else{
								for (var i = 0; i < data.partidas.length; i++) {
									html+=
										'<div style="display: flex;" onclick="show_detail(\''+data.partidas[i].CODTEL+'\','+
										'\''+data.partidas[i].CODPRV+'\',\''+data.partidas[i].NUMVEZ+'\',\''+data.partidas[i].PARTE+'\',\''+data.partidas[i].CODTAD+'\')">'+
											'<div class="itemBody itemBodyLink" style="width:100px;">'+data.partidas[i].CODTEL+'</div>'+
											'<div class="itemBody" style="width:150px;">'+data.partidas[i].DESPRV+'</div>'+
											'<div class="itemBody" style="width:100px;">'+data.partidas[i].CODTAD+'</div>'+
											'<div class="itemBody" style="width:100px;">'+data.partidas[i].NUMVEZ+'</div>'+
											'<div class="itemBody" style="width:100px;">'+data.partidas[i].PARTE+'</div>'+
											'<div class="itemBody" style="width:100px;">'+data.partidas[i].ESTADO+'</div>'+
											'<div class="itemBody" style="width:100px;">'+validate_res(data.partidas[i].RESULTADO)+'</div>'+
										'</div>';
								}
								$("#table-body").empty();
								$("#table-body").append(html);
								$("#tablepartidas").css("display","block");
								$("#msg-nopartidas").css("display","none");
							}
						}else{
							$("#tablepartidas").css("display","none");
							$("#msg-nopartidas").css("display","block");
							alert(data.detail);
						}
						$(".panelCarga").fadeOut(100);
					}
				});
			}			
		}
		function validate_res(res){
			if (res!=null) {
				return res;
			}else{
				return '-';
			}
		}
		function show_detail(codtel,codprv,numvez,parte,codtad){
			window.location.href="VerAuditoriaTela.php?partida="+$("#idpartida").val().toUpperCase()+"&codtel="+codtel+"&codprv="+codprv+
			"&numvez="+numvez+"&parte="+parte+"&codtad="+codtad;
		}
	</script>
</body>
</html>