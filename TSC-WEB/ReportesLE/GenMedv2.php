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
			<div class="headerTitle">Generar Reporte Medidas</div>
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
			<p>(Seleccionar estilo para eligir medidas)</p>
			<div style="width: 100%;overflow-x: scroll;margin-bottom: 5px;">
				<table style="min-width: 800px;width: 100%;">
					<tbody id="table-body-est-pl">
					</tbody>
				</table>
			</div>
			<center>
				<button class="btnPrimary" onclick="guardar_dat_estilos()">Guardar</button>
				<button class="btnPrimary" onclick="pre_rep_medidas()">Previsualizar</button>
			</center>
			<center>
				<button style="margin-top: 5px;" class="btnPrimary" onclick="confirm_report()">Confirmar Medidas</button>
			</center>
			<div class="lineDecoration"></div>
			<div id="content-estilo" style="display: none;">
				<h4 style="">Estilo seleccionada: <span id="estclisel"></span></h4>
				<h4 style="">Lista de Medidas</h4>
				<p>(Seleccionar medida para ver tallas)</p>
				<div style="width: 100%;overflow-x: scroll;margin-bottom: 5px;">
					<table style="min-width: 550px;width: 100%;">
						<tbody id="table-body">
						</tbody>
					</table>
				</div>
				<center>
					<button class="btnPrimary" onclick="save_med_sel()">Generar</button>
				</center>
				<div id="table-tallas" style="display: none;">					
					<div class="lineDecoration"></div>
					<h4 style="">Medida seleccionada: <span id="codmedsel"></span></h4>
					<h4 style="">Lista de Tallas</h4>
					<p>(Seleccionar talla para ver colores)</p>
					<div style="width: 100%;overflow-x: scroll;margin-bottom: 5px;">
						<table style="min-width: 550px;width: 100%;">
							<tbody id="table-body-tal">
							</tbody>
						</table>
					</div>
					<div id="table-color" style="display: none;">					
						<div class="lineDecoration"></div>
						<h4 style="">Talla seleccionada: <span id="codtalsel"></span></h4>
						<h4 style="">Lista de colores</h4>
						<div style="width: 100%;overflow-x: scroll;margin-bottom: 5px;">
							<table style="min-width: 550px;width: 100%;">
								<tbody id="table-body-color">
								</tbody>
							</table>
						</div>
						<center>
							<button class="btnPrimary" onclick="save_detalle_color()">Guardar</button>
						</center>
					</div>
				</div>
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
				url:"config/startGenRepMedv2.php",
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
		var nuevo_file=0;
		function cargar_pdf(){
			if (document.getElementById("rutpdf").innerHTML!="") {
				nuevo_file=1;
				var c=confirm("Desea reemplazar el archivo anterior?");
				if (!c) {
					return;
				}
			}
			document.getElementById("newfile").click();
		}
		function charge_pdf(){
			var file=document.getElementById("newfile").files[0];
			if (file.type!="application/pdf") {
				alert("Debe cargar un PDF");
				return;
			}else{
				console.log(file);
				$(".panelCarga").fadeIn(100);
				var fd=new FormData();
				fd.append('po',po);
				fd.append('paclis',paclis);
				fd.append('file',file);
				fd.append('nuevo',nuevo_file);
				fd.append('rutpdfant',document.getElementById("rutpdf").innerHTML);
				var rq=new XMLHttpRequest();
				rq.open('POST','config/savePDFMedidas.php',true);
				rq.onload=function (){
					if (rq.status==200) {
						var response=JSON.parse(rq.responseText);
						console.log(response);
						if (!response.state) {
							alert(response.detail);
						}else{
							window.location.reload();
						}
						$(".panelCarga").fadeOut(100);
					}else{
						alert("Hubo un problema en la carga");
						$(".panelCarga").fadeOut(100);
					}
				}
				rq.send(fd);
			}
		}
		function show_estilo(estcli){
			document.getElementById("table-tallas").style.display="none";
			document.getElementById("table-color").style.display="none";
			estcli_v=estcli;
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				url:"config/getGenRepMedEst.php",
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
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		var codmed_v='';
		function show_tallas(codmed,desmed){
			desmed=desmed.replace('*','"');
			codmed_v=codmed;
			document.getElementById("table-color").style.display="none";
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				url:"config/getGenRepMedEstTXM.php",
				data:{
					po:po,
					paclis:paclis,
					estcli:estcli_v,
					codmed:codmed_v
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						document.getElementById("table-tallas").style.display="block";
						document.getElementById("codmedsel").innerHTML=desmed;
						document.getElementById("table-body-tal").innerHTML=data.html;
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		var codtal_v='';
		function show_colors(codtal,destal){
			codtal_v=codtal;
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				url:"config/getGenRepMedEstCXT.php",
				data:{
					po:po,
					paclis:paclis,
					estcli:estcli_v,
					codmed:codmed_v,
					codtal:codtal_v
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						document.getElementById("table-color").style.display="block";
						document.getElementById("codtalsel").innerHTML=destal;
						document.getElementById("table-body-color").innerHTML=data.html;
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function save_med_sel(){
			var ar_send=[];
			var ar=document.getElementsByClassName("ipt-che");
			for (var i = 0; i < ar.length; i++) {
				let id=ar[i].id.replace("che","");
				let aux=[];
				aux.push(id);
				if (ar[i].checked) {
					aux.push("1");
				}else{
					aux.push("0");
				}
				ar_send.push(aux);
			}
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				url:"config/saveDatRepMedEst.php",
				data:{
					po:po,
					paclis:paclis,
					estcli:estcli_v,
					array:ar_send
				},
				success:function(data){
					console.log(data);
					alert(data.detail);
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function save_detalle_color(){
			var tam_max_marcas=3;
			var ar_send=[];
			var ar=document.getElementsByClassName("ipt-col");
			let ant_descol="";
			var ar_val=[];
			let contador=0;
			for (var i = 0; i < ar.length; i++) {
				let ar_id=ar[i].id.split("-");
				let aux=[];
				aux.push(ar_id[1]);//numpre
				aux.push(ar_id[2]);//descol
				if (ar[i].checked) {
					aux.push("1");
				}else{
					aux.push("0");
				}
				aux.push(document.getElementById("sel-"+ar_id[1]+"-"+ar_id[2]).value);//valorrep
				ar_send.push(aux);
				if (ar_id[2]!=ant_descol) {
					if (i!=0) {
						var aux2=[];
						aux2.push(ant_descol);
						aux2.push(contador);
						ar_val.push(aux2);
					}
					contador=0;
					ant_descol=ar_id[2];
				}
				if (ar[i].checked) {
					contador++;
				}
			}
			console.log(ar_send);
			var aux2=[];
			aux2.push(ant_descol);
			aux2.push(contador);
			ar_val.push(aux2);
			//console.log(ar_val);
			var i=0;
			var validar=true;
			while (i < ar_val.length && validar) {
				if (ar_val[i][1]!=tam_max_marcas) {
					if (ar_val[i][1]-tam_max_marcas>0) {
						alert("Demasiadas marcas seleccionadas del color "+ar_val[i][0]+". Deben ser "+tam_max_marcas+" marcas");	
					}else{
						alert("Faltan marcas seleccionadas del color "+ar_val[i][0]+". Deben ser "+tam_max_marcas+" marcas");	
					}
					validar=false;
					return;				
				}
				i++;
			}
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				url:"config/saveDatRepMedEstCTM.php",
				data:{
					po:po,
					paclis:paclis,
					estcli:estcli_v,
					codmed:codmed_v,
					codtal:codtal_v,
					array:ar_send
				},
				success:function(data){
					console.log(data);
					alert(data.detail);
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function pre_rep_medidas(){
			var a=document.createElement("a");
			a.target="_blank";
			a.href="fpdf/pdfReporteMedidas.php?po="+po+"&paclis="+paclis;
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
				//aux.push(ar[i].value);
				aux.push(document.getElementById("com"+ar_id[0]+"-"+ar_id[1]+"-"+ar_id[2]).value);
				ar_send.push(aux);
			}
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				url:"config/saveDatRepMedEstilos.php",
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
				url:"config/confirmDatRepMed.php",
				data:{
					po:po,
					paclis:paclis
				},
				success:function(data){
					console.log(data);
					//alert(data.detail);
				}
			});
			$.ajax({
				type:"GET",
				url:"fpdf/pdfReporteMedidas-d.php",
				data:{
					po:po,
					paclis:paclis
				},
				success:function(data){
					if (data=="1") {
						alert("PDF creado");
					}else{
						alert("Error al cargar PDF");
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
	</script>
</body>
</html>