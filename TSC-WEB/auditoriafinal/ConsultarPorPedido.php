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
		.tblBody div{
			border-top: 1px solid #666;
		}
		.item1,.item2{
			width: calc(25% - 10px);
		}
		.item3{
			width: calc(100%/3);
		}
		h3,h4{
			margin: 5px 0;
		}
		.itemMainContent{
			height: auto;
			display: flex;
		}
		.bodySpecialButton{
			height: auto;
		}
		@media(max-width: 650px){
			.item1{
				width: calc(100% - 240px);
			}
			.item2{
				width: 70px;
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
			<div class="headerTitle">Consultar por Pedido</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">			
			<div class="rowLine" style="display: flex;">
				<div class="lbl" style="width: 80px;">Pedido:</div>
				<div class="spaceIpt" style="width: calc(120px);font-size: 15px">
					<input type="text" id="pedido" class="classIpt" style="width: calc(100% - 17px);">
				</div>
				<button class="btnPrimary" onclick="buscar_pedido()" style="margin-left: 5px;width: auto;"><i class="fa fa-search" aria-hidden="true"></i></button>
			</div>
			<div class="mainContent" style="margin-top: 5px; display: none;" id="table-colores">
				<div class="lineDecoration"></div>
				<h4>PO: <span id="po"></span></h4>
				<h4>Estilo Cliente: <span id="estcli"></span></h4>
				<h3>Colores</h3>
				<div class="tblContent" style="overflow-x: scroll;">
					<div class="tblHeader" style="width: 100%;">
						<div class="itemHeader item1">Color</div>
						<div class="itemHeader item2">Cant Pedido</div>
						<div class="itemHeader item2">Cant ficha</div>
						<div class="itemHeader item2">Cant Apr Fin Cos</div>
					</div>
					<div class="tblBody" id="table-body">
					</div>
				</div>
				<div class="mainContent" style="margin-top: 5px; display: none;" id="table-detalle">
					<div class="lineDecoration"></div>
					<h3>Fichas del pedido <span id="pedido-color"></span></h3>
					<div class="tblContent" style="overflow-x: scroll;">
						<div class="tblHeader" style="width: 100%;">
							<div class="itemHeader item3">Ficha</div>
							<div class="itemHeader item3">Cant ficha</div>
							<div class="itemHeader item3">Cant Apr Fin Cos</div>
						</div>
						<div class="tblBody" id="table-body-2">
						</div>
					</div>
					<div class="mainContent" style="margin-top: 5px; display: none;" id="table-consultas">
						<h4>Ficha: <span id="codficsel"></span></h4>
						<div class="rowLine" style="display: flex;">
							<div class="itemMainContent">
								<div class="bodySpecialButton" onclick="consultar_clc()">
									<div class="detailSpecialButton">Consultar Check List Corte</div>
								</div>
							</div>
							<div class="itemMainContent">
								<div class="bodySpecialButton" onclick="consultar_apc()">
									<div class="detailSpecialButton">Consultar Aud. Pro. Corte</div>
								</div>
							</div>
							<div class="itemMainContent">
								<div class="bodySpecialButton" onclick="consultar_afc()">	
									<div class="detailSpecialButton">Consultar Aud. Fin. Corte</div>
								</div>
							</div>
						</div>
						<div class="rowLine" style="display: flex;">
							<div class="itemMainContent">
								<div class="bodySpecialButton" onclick="consultar_apcos()">
									<div class="detailSpecialButton">Consultar Aud. Pro. Costura</div>
								</div>
							</div>
							<div class="itemMainContent">
								<div class="bodySpecialButton" onclick="consultar_afcos()">
									<div class="detailSpecialButton">Consultar Aud. Fin. Costura</div>
								</div>
							</div>
						</div>
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
		function buscar_pedido(){
			if($("#pedido").val()==""){
				alert("Escriba el pedido");
				return;
			}
			$(".panelCarga").fadeIn(100);
			$("#table-consultas").css("display","none");
			$.ajax({
				type:'POST',
				data:{
					pedido:$("#pedido").val()
				},
				url:'config/getColXPed.php',
				success:function(data){
					console.log(data);
					partidas_ar=data.colores;
					var html='';
					if (data.state) {
						$("#po").text(data.PO_CLI);
						$("#estcli").text(data.ESTILO_CLI);
						for (var i = 0; i < partidas_ar.length; i++) {
							html+=
								'<div style="display: flex;" onclick="show_detail(\''+partidas_ar[i].DSC_COLOR+'\',1)">'+
									'<div class="itemBody item1">'+partidas_ar[i].DSC_COLOR+'</div>'+
									'<div class="itemBody item2">'+partidas_ar[i].CANPEDCOL+'</div>'+
									'<div class="itemBody item2">'+partidas_ar[i].CANFICHA+'</div>'+
									'<div class="itemBody item2">'+partidas_ar[i].CANFICHAAUDITADA+'</div>'+
								'</div>';
						}
						$("#table-body").empty();
						$("#table-body").append(html);
						$("#table-colores").css("display","block");
					}else{
						$("#table-colores").css("display","none");
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		var dsccol_var='';
		function show_detail(dsccol){
			dsccol_var=dsccol;
			$("#table-consultas").css("display","none");
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				data:{
					pedido:$("#pedido").val(),
					dsccol:dsccol
				},
				url:'config/getDetalleColXPed.php',
				success:function(data){
					console.log(data);
					document.getElementById("pedido-color").innerHTML=$("#pedido").val()+" "+dsccol;
					partidas_ar=data.detalle;
					var html='';
					if (data.state) {
						$("#po").text(data.PO_CLI);
						$("#estcli").text(data.ESTILO_CLI);
						for (var i = 0; i < partidas_ar.length; i++) {
							html+=
								'<div style="display: flex;" onclick="select_ficha(\''+partidas_ar[i].CODFIC+'\')">'+
									'<div class="itemBody item3">'+partidas_ar[i].CODFIC+'</div>'+
									'<div class="itemBody item3">'+partidas_ar[i].CANFICHA+'</div>'+
									'<div class="itemBody item3">'+partidas_ar[i].CANFICHAAUDITADA+'</div>'+
								'</div>';
						}
						$("#table-body-2").empty();
						$("#table-body-2").append(html);
						$("#table-detalle").css("display","block");
					}else{
						$("#table-detalle").css("display","none");
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function show_veremp(){
			window.location.href="veremp.php?pedido="+$("#pedido").val()+"&color="+dsccol_var;
		}
		var codfic_v='';
		function select_ficha(codfic){
			$("#codficsel").text(codfic);
			codfic_v=codfic;
			$("#table-consultas").css("display","block");
		}
		function consultar_clc(){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				url:'config/getConFicSel.php',
				type:'POST',
				data:{
					codfic:codfic_v
				},
				success: function (data) {
					console.log(data);
					if (data.state) {
						window.location.href='../checklistcorte/VerCheckListCorte.php?codfic='+codfic_v+
						'&numvez='+data.ficha.NUMVEZ+'&parte='+data.ficha.PARTE+
						'&codtad='+data.ficha.CODTAD+'&partida='+data.ficha.PARTIDA;
					}else{
						alert(data.detail);
					}
			        $(".panelCarga").fadeOut(200);
			    },
			    error: function (jqXHR, exception) {
			        var msg = get_msg_error(jqXHR, exception);
			        alert(msg);
			        $(".panelCarga").fadeOut(100);
			    }
			});
		}
		function consultar_apc(){
			window.location.href='../auditoriaprocesocorte/ConsultarEditarAuditoria.php?codfic='+codfic_v;
		}
		function consultar_afc(){
			window.location.href='../auditoriafinalcorte/ConsultarEditarAuditoria.php?codfic='+codfic_v;
		}
		function consultar_apcos(){
			window.location.href='../AuditoriaProceso/ConsultarEditarAuditoria.php?codfic='+codfic_v;
		}
		function consultar_afcos(){
			window.location.href='../auditex/ConsultarEditarAuditoria.php?codfic='+codfic_v;
		}
	</script>
</body>
</html>