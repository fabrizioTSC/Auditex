<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="10";
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
	<link rel="stylesheet" type="text/css" href="css/consultaAuditoria.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<style type="text/css">
		.ipt-check,.ipt-check-s{
			margin: 0!important;
		}
		.td-c{
			text-align: center;
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
			<div class="headerTitle">Reporte Control de Humedad</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
				<div class="sameLine">
					<div class="lblNew" style="width: 80px;padding-top: 5px;">Pedido</div>
					<input type="text" id="idpedido" class="iptClass" style="width: calc(100% - 130px);font-size: 15px;">
					<button class="btnPrimary" style="margin-left:5px;width: 40px;" onclick="buscar()"><i class="fa fa-search" aria-hidden="true"></i></button>
				</div>
				<div id="div-main" style="display: none;width: calc(80%);margin-left: 10%;margin-top: 10px;">
					<div style="display: flex;justify-content: flex-end;">
						<div style="margin-right: 5px;">TODOS </div><input type="checkbox" id="che-all" class="ipt-check-s">
					</div>
					<table style="margin-top: 5px;">
						<thead>
							<tr>
								<th>Color</th>
								<th>Sel.</th>
							</tr>
						</thead>
						<tbody id="tbl-body">
							<tr>
								<td>Color</td>
								<td class="td-c"><input type="checkbox" id="che-asd" class="ipt-check"></td>
							</tr>
						</tbody>
					</table>
					<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;" onclick="consultar()">Consultar</button>

					<button class="btnPrimary" id="btnExportarPdf" style="margin-left: calc(50% - 80px);margin-top: 10px;">Exportar PDF</button>

				</div>
		</div>
	</div>
	<script type="text/javascript">

		// BUSCAR
		function buscar(){
			if ($("#idpedido").val()=="") {
				alert("Complete un pedido");
				return;
			}
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				data:{
					pedido:$("#idpedido").val()
				},
				url:"config/getColoresXPedido.php",
				success:function(data){
					console.log(data);
					document.getElementById("che-all").checked=false;
					if (data.state) {
						$("#tbl-body").empty();
						$("#tbl-body").append(data.html);
						$("#div-main").css("display","block");
					}else{
						$("#div-main").css("display","none");
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}

		// DOCUMENT READY
		$(document).ready(function(){
			$("#che-all").click(function(){
				var ar=document.getElementsByClassName("ipt-check");
				if (document.getElementById("che-all").checked) {
					for (var i = 0; i < ar.length; i++) {
						ar[i].checked=true;
					}
				}else{
					for (var i = 0; i < ar.length; i++) {
						ar[i].checked=false;
					}
				}
			});
		});

		// CONSULTAR
		function consultar(){

			let concat = GetColores();
			window.location.href="ReporteControlHumedadPC.php?pedido="+$("#idpedido").val()+"&colores="+concat;

		}


		// EXPORTAR PDF
		$("#btnExportarPdf").click(function(){
			let colores = GetColores();
			let pedido = $("#idpedido").val();
			
			window.open(`/TSC/auditex-acabados/views/reportehumedad/pdfhumedad.report.php?pedido=${pedido}&colores=${colores}`,'_blank');
			// console.log(concat);

		});

		function GetColores(){

			var ar=document.getElementsByClassName("ipt-check");
			var ar_send=[];
			for (var i = 0; i < ar.length; i++) {
				if(ar[i].checked){
					ar_send.push("'"+ar[i].id.replace("che-","")+"'");
				}
			}
			if (ar_send.length==0) {
				alert("Debe seleccionar algún color");
				return;
			}			
			var concat="";
			for (var i = 0; i < ar_send.length; i++) {
				concat+=ar_send[i];
				if(i!=ar_send.length-1){
					concat+=",";
				}
			}
			// console.log(concat);

			return concat;
		}


	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>