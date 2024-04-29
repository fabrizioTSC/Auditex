<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="3";
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
	<link rel="stylesheet" type="text/css" href="css/IndicadorResultado-v1.0.css">
	<script src="charts-dist/Chart.min.js"></script>
	<style type="text/css">
		.modalBackground::-webkit-scrollbar{
			background: transparent;
		}
		.modalBackground::-webkit-scrollbar-thumb{
			background: #aaa;
		}
		.modalBackground .lblTitulo{
			color: #333;
		}
		.opciones{
			padding: 10px;
			width: calc(50% - 20px);
			text-align: center;
			border-bottom: 1px solid #fff;
			font-size: 12px;
		}
		.opc-select{
			padding: 10px;
			width: calc(50% - 20px);
			text-align: center;
			border: 1px solid #fff;
			border-bottom: none;
		}
		.ext-def{
			font-weight: 800;
		    color: #fff;
		    background: #138dc7;
		    width: 12px;
		    text-align: center;
		    border-radius: 4px;
			cursor: pointer;
		}
		.items5{
			background: #ddd;
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
	<div class="modalContainer" id="idModal">
		<div class="modalBackground" style="max-height: calc(100vh - 60px);overflow-y: scroll;">
			<div class="rowLine" style="margin-bottom: 5px">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="downloadPDF()">Descargar PDF</button>
			</div>
			<div class="lblTitulo">INDICADOR DE DEFECTO: <span id="idDesDef"></span></div>
			<div class="lblTitulo" id="titulodetalle"></div>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;" id="content-canvas">
					<canvas id="chart-area"></canvas>
				</div>
			</div>
			<div class="contentTbl">
				<div class="lateralHeAders">
					<div class="items1">DETALLE GENERAL</div>
					<div class="items1 items2"># DEF.</div>
					<div class="items1 items2"># PREN MUE</div>
					<div class="items1 items2"># DEF. TOT.</div>
					<div class="items1">% DEF.</div>
				</div>
				<div class="contents" id="placeAnios">
				</div>
				<div class="contents" id="placeMeses">
				</div>
				<div class="contents" id="placeSemanas">
				</div>
			</div>
			<div class="rowLine" style="margin-bottom: 5px">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="hide_modal()">Volver</button>
			</div>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Indicador de Defectos Check List Proceso Acabados</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="lblTitulo">INDICADORES DE DEFECTOS</div>
			<div class="lblTitulo" id="titulodetalle2"></div>

			<div style="display: flex;margin: 10px auto; width: 100%;max-width: 500px;">
				<div class="opciones opc-select" onclick="select_opcion(this,1)">Año/Semana</div>
				<div class="opciones" onclick="select_opcion(this,2)">Rango de fechas</div>
			</div>
			<div class="content-opciones" id="opc-1">
				<div  style="display: flex;margin-bottom: 10px;">
					<div style="width: calc(50% - 200px);"></div>
					<div class="lblTitulo" style="width: 100px;margin-top: 12px;">AÑO:</div>
					<select class="classCmbBox" style="width: 100px;margin-bottom: 0px;" id="idNumAnio">
					</select>
					<div class="lblTitulo" style="width: 100px;margin-top: 12px;">SEMANA:</div>
					<select class="classCmbBox" style="width: 100px;margin-bottom: 0px;" id="idNumSem">
					</select>
				</div>
			</div>	
			<div class="content-opciones" style="display: none;" id="opc-2">
				<div style="display: flex;margin-bottom: 10px;">
					<div style="width: calc(50% - 270px);"></div>
					<div class="lblTitulo" style="width: 100px;margin-top: 12px;">Desde:</div>
					<input type="date" id="fecini" style="width: 150px;margin-bottom: 0px;font-family: sans-serif;">
					<div class="lblTitulo" style="width: 100px;margin-top: 12px;">Hasta:</div>
					<input type="date" id="fecfin" style="width: 150px;margin-bottom: 0px;font-family: sans-serif;">
				</div>
				<center>
					<button class="btnPrimary" style="margin-bottom: 10px;" onclick="update_fechas()">Buscar</button>	
				</center>
			</div>

			<div class="contentTbl" style="display: block;">
				<div class="tblSpace" style="width: 100%;">
					<div class="contentHeAders">
						<div class="items1" style="width: calc(55% - 10px);">DEFECTO</div>
						<div class="items1" style="width: calc(15% - 10px);">MUESTRA</div>
						<div class="items1" style="width: calc(15% - 10px);">TOTAL</div>
						<div class="items1" style="width: calc(15% - 10px);">%</div>
					</div>
					<div class="contentsBody" id="idDefectos">
						<!--
						<div class="lineBody">
							<div class="itemhs1 items4" style="width: 120px;text-align:left;"></div>
							<div class="itemhs1 items4" style="width: 80px;"></div>
							<div class="itemhs1 items4" style="width: 40px;"></div>
						</div>-->
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var codusu='<?php echo $_SESSION["user"] ?>';
		var codtll='<?php echo $_GET["codtll"] ?>';
		var codtipser='<?php echo $_GET["codtipser"] ?>';
		var codsede='<?php echo $_GET["codsede"] ?>';
		var tipo=1;
		function select_opcion(dom,id){
			tipo=id;
			var ar=document.getElementsByClassName("opciones");
			for (var i = 0; i < ar.length; i++) {
				ar[i].classList.remove("opc-select");
			}
			var ar=document.getElementsByClassName("content-opciones");
			for (var i = 0; i < ar.length; i++) {
				ar[i].style.display="none";
			}
			dom.classList.add("opc-select");
			document.getElementById("opc-"+id).style.display="block";
			if (id==1) {
				update_defectos();
			}else{
				update_fechas();
			}
		}
		var fecha=new Date();
		var dia=fecha.getDate();
		dia=""+dia;
		if (dia.length==1) {
			dia="0"+dia;
		}
		var mes=fecha.getMonth()+1;
		mes=""+mes;
		if (mes.length==1) {
			mes="0"+mes;
		}
		var anio=fecha.getFullYear();
		var hoy=anio+"-"+mes+"-"+dia;
		document.getElementById("fecini").value=hoy;
		document.getElementById("fecfin").value=hoy;
	</script>
	<script type="text/javascript" src="js/IndicadorDefectos-v1.0.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>