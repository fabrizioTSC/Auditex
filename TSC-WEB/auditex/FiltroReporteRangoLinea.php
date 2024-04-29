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
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/filtroRepRanLinea-v1.0.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
</head>
<body onload="getTalleres()">
	<?php contentMenu();?>
	<div class="panelCarga" style="display: block;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Filtro Ind. Clasi. Ficha</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">	
			<div class="sameLine">
				<div class="lblNew" style="width: 80px;padding-top: 5px;">Sede</div>
				<input type="text" id="nombreSede" class="iptClass" style="width: calc(100% - 80px);font-size: 15px;">
			</div>
			<div class="tblSelection">
				<div class="listaTalleres" id="spaceSedes">
					<div class="taller"></div>
				</div>
			</div>
			<div style="width: 100%;height: 20px;"></div>
			<div class="sameLine">
				<div class="lblNew" style="width: 120px;padding-top: 5px;">Tipo servicio</div>
				<input type="text" id="nombreTipoSer" class="iptClass" style="width: calc(100% - 120px);font-size: 15px;">
			</div>
			<div class="tblSelection">
				<div class="listaTalleres" id="spaceTipoSer">
					<div class="taller"></div>
				</div>
			</div>
			<div style="width: 100%;height: 20px;"></div>
			<div class="option-line">
				<div class="class-for-radio">
			  		<input class="input-radio-class" id="ipt1" type="radio" name="gender" value="male"> A&ntilde;o/Mes
			  	</div>
				<div class="class-for-selects">
					<select class="special-select select-anio" id="select-anio1" data-ctrl="ipt1" style="margin-right: 5px">
					</select>
					<select class="special-select" id="select-mes1" data-ctrl="ipt1" style="margin-left: 5px">
						<option value="01">Enero</option>
						<option value="02">Febrero</option>
						<option value="03">Marzo</option>
						<option value="04">Abril</option>
						<option value="05">Mayo</option>
						<option value="06">Junio</option>
						<option value="07">Julio</option>
						<option value="08">Agosto</option>
						<option value="09">Setiembre</option>
						<option value="10">Octubre</option>
						<option value="11">Noviembre</option>
						<option value="12">Diciembre</option>
					</select>
				</div>
			</div>
			<div class="option-line">
				<div class="class-for-radio">
			  		<input class="input-radio-class" id="ipt2" type="radio" name="gender" value="female"> A&ntilde;o/Semana
			  	</div>
				<div class="class-for-selects">
					<select class="special-select select-anio" id="select-anio" data-ctrl="ipt2" style="margin-right: 5px" disabled>
					</select>
					<select class="special-select" id="select-semana" data-ctrl="ipt2" style="margin-left: 5px" disabled>
					</select>
				</div>
			</div>
			<div class="option-line">
				<div class="class-for-radio">
			  		<input class="input-radio-class" id="ipt3" type="radio" name="gender" value="other"> Rango fechas
			  	</div>
				<div class="class-for-selects">
					<input type="date" id="rango1" class="special-input" data-ctrl="ipt3" style="margin-right: 5px; font-family: sans-serif;" disabled/>
					<input type="date" id="rango2" class="special-input" data-ctrl="ipt3" style="margin-left: 5px; font-family: sans-serif;" disabled/>
				</div>
			</div>
		</div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="enviarParamaetros()">Mostrar resultado</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript" src="js/FiltroReporteRangoLinea-v1.0.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>