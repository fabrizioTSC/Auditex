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
			<div class="headerTitle">Registrar Auditoria de Telas</div>
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
			<div id="list-partidas" style="display: none;">
				<div class="lineDecoration"></div>
				<div class="lbl" style="margin-bottom: : 10px;">Partidas para auditar</div>
				<div>
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
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="iniciar_auditoria()">Registrar</button>
			<div class="lineDecoration"></div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="redirect('main.php')">Volver</button>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		function iniciar_auditoria(){ 
			if ($("#idpartida").val()=="") {
				alert("Ingrese una partida!");
			}else{
				$(".panelCarga").fadeIn(100);
				$("#list-partidas").css("display","none");
				$.ajax({
					type:'POST',
					url:'config/validarPartida.php',
					data:{
						partida:$("#idpartida").val().toUpperCase()
					},
					success:function(data){
						if (data.state) {
							if(!data.state_lista){
								window.location.href="AuditoriaTela.php?p="+$("#idpartida").val().toUpperCase();
							}else{
								console.log(data);
								var html='';
								for (var i = 0; i < data.partidasauditoria.length; i++) {
									html+=
									'<div class="tblLine" onclick="redirect(\'AuditoriaTela.php?p='+$("#idpartida").val().toUpperCase()+'&codprv='+data.partidasauditoria[i].CODPRV+'&codtel='+data.partidasauditoria[i].CODTEL+'\')">'+
										'<div class="itemBody" style="width: 40%;text-align: center;">'+data.partidasauditoria[i].DESPRV+'</div>'+
										'<div class="itemBody" style="width: 20%;text-align: center;">'+data.partidasauditoria[i].CODTEL+'</div>'+
										'<div class="itemBody" style="width: 15%;text-align: center;">'+data.partidasauditoria[i].CODTAD+'</div>'+
										'<div class="itemBody" style="width: 8%;text-align: center;">'+data.partidasauditoria[i].PARTE+'</div>'+
										'<div class="itemBody" style="width: 8%;text-align: center;">'+data.partidasauditoria[i].NUMVEZ+'</div>'+
										'<div class="itemBody" style="width: 9%;text-align: center;">'+validate_res(data.partidasauditoria[i].RESULTADO)+'</div>'+
									'</div>';
								}
								$("#data-partidas").empty();
								$("#data-partidas").append(html);
								$("#list-partidas").css("display","block");
								$(".panelCarga").fadeOut(100);	
							}
						}else{
							$(".panelCarga").fadeOut(100);	
							if (data.state_confirm) {
								//var c=confirm("No hay pendientes para la partida! Desea ver una lista de partidas disponibles para nuevo intento de auditoría?");
								var c=confirm("La partida ya fue auditada. ¿Desea continuar con la siguiente vez de la auditoría?");
								if (c) {
									//crear_nuevo_numvez();
									show_lista_nuevointento();
								}
							}else{
								alert("La partida no existe");
							}
						}
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
		function show_lista_nuevointento(){
			$(".panelCarga").fadeIn(100);
			$("#list-partidas").css("display","none");
			$.ajax({
				type:'POST',
				url:'config/listaNuevoIntento.php',
				data:{
					partida:$("#idpartida").val().toUpperCase()
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						var html='';
						for (var i = 0; i < data.partidasauditoria.length; i++) {
							html+=
							'<div class="tblLine" onclick="crear_nuevo_numvez(\''+$("#idpartida").val().toUpperCase()+'\',\''+data.partidasauditoria[i].CODPRV+'\',\''+data.partidasauditoria[i].CODTEL+'\')">'+
								'<div class="itemBody" style="width: 40%;text-align: center;">'+data.partidasauditoria[i].DESPRV+'</div>'+
								'<div class="itemBody" style="width: 20%;text-align: center;">'+data.partidasauditoria[i].CODTEL+'</div>'+
								'<div class="itemBody" style="width: 15%;text-align: center;">'+data.partidasauditoria[i].CODTAD+'</div>'+
								'<div class="itemBody" style="width: 8%;text-align: center;">'+data.partidasauditoria[i].PARTE+'</div>'+
								'<div class="itemBody" style="width: 8%;text-align: center;">'+data.partidasauditoria[i].NUMVEZ+'</div>'+
								'<div class="itemBody" style="width: 9%;text-align: center;">'+validate_res(data.partidasauditoria[i].RESULTADO)+'</div>'+
							'</div>';
						}
						$("#data-partidas").empty();
						if (data.partidasauditoria.length==0) {
							$("#data-partidas").append('<div style="color:red;padding:5px;">Sin partidas rechazadas</div>');
						}else{
							$("#data-partidas").append(html);
						}
						$("#list-partidas").css("display","block");
					}
					$(".panelCarga").fadeOut(100);	
				}
			});
		}
		function crear_nuevo_numvez(partida,codprv,codtel){
			var c=confirm("Seguro que desea crear un intento nuevo para la partida "+partida+"?");
			if (c) {
				$.ajax({
					type:'POST',
					url:'config/crearNuevaVezPartida.php',
					data:{
						partida:partida,
						codprv:codprv,
						codtel:codtel
					},
					success:function(data){
						if (data.state) {
							window.location.href="AuditoriaTela.php?p="+$("#idpartida").val().toUpperCase()+"&codprv="+codprv;
						}else{
							alert("No se pudo crear el nuevo intento!");
						}
					}
				});
			}
		}
	</script>
</body>
</html>