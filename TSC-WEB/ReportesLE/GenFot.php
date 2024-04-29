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
	<link rel="stylesheet" type="text/css" href="css/reporteLE.css">
	<style type="text/css">
		td input[type="number"]{
			width: calc(100% - 12px);
		}
		td,th{
			font-size: 12px;
		}
		th:nth-child(1),td:nth-child(1){
			width: 300px;
		}
		td img{
			width: 100%;
		}
		th:nth-child(9),td:nth-child(9){
			width: 200px;
		}
		.table-1 th:nth-child(1),.table-1 td:nth-child(1),
		.table-1 th:nth-child(2),.table-1 td:nth-child(2),
		.table-1 th:nth-child(5),.table-1 td:nth-child(5){
			width: 80px;
		}
		.table-1 th:nth-child(3),.table-1 td:nth-child(3){
			width: 160px;	
		}
		.td-a{
			text-decoration: underline;
			color: blue;
			cursor: pointer;
		}
		p{
			margin: 5px 0;
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
			<div class="headerTitle">Generar Reporte de Defectos y Humedad</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="div-flex mt5">
				<label>PO</label>
				<div class="content-input">
					<input type="text" value="<?php echo $_GET['po']; ?>" disabled>
				</div>
			</div>
			<div class="div-flex mt5">
				<label>PL</label>
				<div class="content-input">
					<input type="text" value="<?php echo $_GET['paclis']; ?>" disabled>
				</div>
			</div>
			<h4 style="">Estilos del PO - Packing List</h4>
			<p>(Seleccionar estilo para eligir fotos)</p>
			<div style="width: 100%;overflow-x: scroll;margin-bottom: 5px;">
				<table style="min-width: 800px;width: 100%;">
					<tbody id="table-body-est-pl">
					</tbody>
				</table>
			</div>
			<center>
				<button class="btnPrimary" onclick="guardar_dat_estilos()">Guardar</button>
				<button class="btnPrimary" onclick="pre_rep_fotos(1)">Prev. Cal. Int.</button>
				<button class="btnPrimary" onclick="pre_rep_fotos(2)">Prev. Humedad</button>
			</center>
			<center>
				<button style="margin-top: 5px;" class="btnPrimary" onclick="confirm_report()">Confirmar defectos</button>
				<button style="margin-top: 5px;" class="btnPrimary" onclick="confirm_report_2()">Confirmar humedad</button>
			</center>
			<div class="lineDecoration"></div>
			<div id="content-estilo" style="display: none;">
				<h4 style="">Estilo seleccionar: <span id="estclisel"></span></h4>
				<!--
				<div class="div-flex mt5">
					<label>FORM</label>
					<div class="content-input">
						<input type="text" id="form" disabled>
					</div>
				</div>
				<div class="div-flex mt5">
					<label>VERSION</label>
					<div class="content-input">
						<input type="text" id="version" disabled>
					</div>
				</div>
				<div class="div-flex mt5">
					<label>VENDOR</label>
					<div class="content-input">
						<input type="text" id="vendor" disabled>
					</div>
				</div>
				<div class="mt5">
					<label>ITEM DESCRIPTION</label>
					<textarea id="despre" rows="2" disabled></textarea>
				</div>
				<div class="div-flex mt5">
					<label>DATE (M/D/Y)</label>
					<div class="content-input">
						<input type="text" id="fecha" disabled>
					</div>
				</div>
				<div class="div-flex mt5">
					<label>SIZE</label>
					<div class="content-input">
						<input type="text" id="destal" disabled>
					</div>
				</div>
				<div class="mt5">
					<label>COLOR(S) DESCRIPTION</label>
					<textarea id="descol" rows="2" disabled></textarea>
				</div>
				<div class="div-flex mt5">
					<label>COLOR(S)</label>
					<div class="content-input">
						<input type="text" id="descolrep">
					</div>
				</div>
				<div class="mt5">
					<label>COMMENTS</label>
					<br>
					<textarea id="comentarios"></textarea>
				</div>-->
				<h4 style="">Lista de Fotos</h4>
				<div style="width: 100%;overflow-x: scroll;margin-bottom: 5px;">
					<table style="min-width: 800px;width: 100%;">
						<tbody id="table-body">
						</tbody>
					</table>
				</div>
				<center>
					<button class="btnPrimary" onclick="generar_rep_fotos()">Generar</button>
				</center>
				<div class="lineDecoration"></div>
			</div>
			<center>
				<button class="btnPrimary" onclick="window.history.back();">Volver</button>
			</center>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		var po="<?php echo $_GET['po']; ?>";
		var paclis="<?php echo $_GET['paclis']; ?>";
		$(document).ready(function(){
			$.ajax({
				type:"POST",
				url:"config/startGenRepFot.php",
				data:{
					po:po,
					paclis:paclis
				},
				success:function(data){
					console.log(data);
					if (data.state) {						
						document.getElementById("table-body-est-pl").innerHTML=data.html;
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		});
		var estcli_v='';
		function show_estilo(estcli){
			estcli_v=estcli;
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				url:"config/startGenRepFotEst.php",
				data:{
					po:po,
					paclis:paclis,
					estcli:estcli
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						document.getElementById("content-estilo").style.display="block";
						document.getElementById("estclisel").innerHTML=estcli;
						document.getElementById("table-body").innerHTML=data.html;
						/*
						document.getElementById("form").value=data.data.FORM;
						document.getElementById("version").value=data.data.VERSION;
						document.getElementById("fecha").value=data.data.FECHA;
						document.getElementById("vendor").value=data.data.VENDOR;
						document.getElementById("destal").value=data.data.DESTAL;
						document.getElementById("despre").value=data.data.DESPRE;
						document.getElementById("descol").value=data.data.DESCOL;
						document.getElementById("comentarios").value=data.data.COMENTARIOS;
						document.getElementById("descolrep").value=data.data.DESCOLREP;*/
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function generar_rep_fotos(){
			var ar_send=[];
			var ar=document.getElementsByClassName("ipt-tex");
			for (var i = 0; i < ar.length; i++) {
				let id=ar[i].id.replace("tex","");
				let ar_id=id.split(";");
				let aux=[];
				aux.push(ar_id[0]);
				aux.push(ar_id[1]);
				aux.push(ar_id[2]);
				aux.push(ar[i].value);
				if (document.getElementById("che"+ar_id[0]+";"+ar_id[1]+";"+ar_id[2]).checked) {
					aux.push("1");
				}else{
					aux.push("0");
				}
				ar_send.push(aux);
			}
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				url:"config/saveDatRepFotEst.php",
				data:{
					po:po,
					paclis:paclis,
					estcli:estcli_v,
					//comentarios:document.getElementById("comentarios").value,
					//descolrep:document.getElementById("descolrep").value,
					array:ar_send
				},
				success:function(data){
					console.log(data);
					alert(data.detail);
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function pre_rep_fotos(id){
			var a=document.createElement("a");
			a.target="_blank";
			a.href="fpdf/pdfReporteFotos.php?po="+po+"&paclis="+paclis+"&tipo="+id;
			a.click();
		}
		function guardar_dat_estilos(){
			var ar_send=[];
			var ar=document.getElementsByClassName("tex-descolrep");
			for (var i = 0; i < ar.length; i++) {
				let id=ar[i].id.replace("descolrep","");
				let ar_id=id.split("-");
				let aux=[];
				aux.push(ar_id[2]);
				aux.push(ar[i].value);
				aux.push(document.getElementById("com"+ar_id[0]+"-"+ar_id[1]+"-"+ar_id[2]).value);
				ar_send.push(aux);
			}
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				url:"config/saveDatRepFotEstilos.php",
				data:{
					po:po,
					paclis:paclis,
					array:ar_send
				},
				success:function(data){
					console.log(data);
					alert(data.detail);
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function confirm_report(){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				url:"config/confirmDatRepDef.php",
				data:{
					po:po,
					paclis:paclis
				},
				success:function(data){
					console.log(data);
					alert(data.detail);
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function confirm_report_2(){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				url:"config/confirmDatRepHum.php",
				data:{
					po:po,
					paclis:paclis
				},
				success:function(data){
					console.log(data);
					alert(data.detail);
					$(".panelCarga").fadeOut(100);
				}
			});
		}
	</script>
</body>
</html>