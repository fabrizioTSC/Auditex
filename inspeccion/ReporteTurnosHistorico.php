<!DOCTYPE html>
<html>
<head>
	<title>Reporte Monitor</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/ReporteMonitor-v1.4.css">
	<link rel="stylesheet" type="text/css" href="css/ReporteMonitorPC-v1.2.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<style type="text/css">
		.content-msg{
			position: fixed;
			top: 20px;
			left: 0px;
			width: 100%;
			z-index: 200;
		}
		.body-msg{
			margin: auto;
			padding: 20px;
			border-radius: 10px;
			background: white;
			font-family: sans-serif;
			width: 260px;
			text-align: center;
			box-shadow: 0px 0px 13px 6px rgba(50,50,50,0.5);
			color: red;
		}
		.space-content{
			width: calc(calc(100%/3) - 20px);
			padding: 10px;
			display: block;
			height: calc(100vh - 20px);
		}
		.content-box{
			margin: 0px;
			width: calc(100% - 20px);
			height: calc(calc(100vh - 160px)/5);
			background: #aaa;
		}
		.content-separator{
			width: calc(100% - 20px);
			height: 10px;
		}
		.title-box{
			font-size: 60px;
		}
		.level-one{
			padding:0px;
		}
		.level-two{
			font-size: 25px;
		}
		.content-red{
			background: red;
			color: white;
		}
		.content-green{
			background: #16d22d;
			color: black;
		}
		.content-yellow{
			background: yellow;
			color: black;
		}
		.n-t-l4{
			letter-spacing: 0px;
		}
		.content-icon2{
			width: 25%;
		}
		.content-text2{
			width: 50%;
		}
		.content-frac2{
			width: 25%;
			padding-top: 10px;
		}
		.frac-num{
			font-size: 25px;
		}
		.frac-line{
			background: black;
		}
	</style>
</head>
<body>
	<div class="content-msg" id="idContentMsg" style="display: none;">
		<div class="body-msg"><span id="idMsg">text</span></div>
	</div>
	<div class="panelCarga" style="display: block;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="main-content-report">
		<div class="space-content">
			<!--
			<div class="content-box main-content-box">
				<div class="level-one">
					L&Iacute;NEA <span id="num_linea1"></span>
				</div>
				<div class="line-separate"></div>
				<div class="level-two">
					<span id="change1"></span>
				</div>
			</div>-->
			<div class="content-box">
				<div class="title-box">TURNO I</div>
			</div>
			<div class="content-separator"></div>
			<div class="content-box" id="ctrl_efi_1">
				<div class="normal-one">
					EFICIENCIA
				</div>
				<div class="normal-two same-line">
					<div class="content-icon" id="arrow-eficiencia1"></div>
					<div class="content-text">
						<span id="eficiencia1"></span>
					</div>
				</div>
			</div>
			<div class="content-separator"></div>
			<div class="content-box" id="ctrl_efc_1">
				<div class="normal-one">
					EFICACIA
				</div>
				<div class="normal-two same-line">
					<div class="content-icon content-icon2" id="arrow-eficacia1"></div>
					<div class="content-text content-text2">
						<span id="eficacia1"></span>
					</div>
					<div class="content-frac2">
						<div class="frac-num"><span id="num1"></span></div>
						<div class="frac-line" id="frac-1"></div>
						<div class="frac-num"><span id="den1"></span></div>
					</div>
				</div>
			</div>
			<div class="content-separator"></div>
			<div class="content-box" id="ctrl_defe_porc1">
				<div class="normal-one">
					PRENDAS DEFECTUOSAS
				</div>
				<div class="normal-two n-t-l4">
					<span id="pren_defe1"></span>&nbsp;<span id="pren_defe_porc1"></span>
				</div>
			</div>
			<div class="content-separator"></div>
			<div class="content-box" id="ctrl_repr_porc1">
				<div class="normal-one">
					REPROCESO DE COSTURA
				</div>
				<div class="normal-two n-t-l4">
					<span id="pren_repr1"></span>&nbsp;<span id="pren_repr_porc1"></span>
				</div>
			</div>
		</div>
		<div class="space-content">
			<div class="content-box">
				<div class="title-box">TURNO II</div>
			</div>
			<div class="content-separator"></div>
			<div class="content-box" id="ctrl_efi_2">
				<div class="normal-one">
					EFICIENCIA
				</div>
				<div class="normal-two same-line">
					<div class="content-icon" id="arrow-eficiencia2"></div>
					<div class="content-text">
						<span id="eficiencia2"></span>
					</div>
				</div>
			</div>
			<div class="content-separator"></div>
			<div class="content-box" id="ctrl_efc_2">
				<div class="normal-one">
					EFICACIA
				</div>
				<div class="normal-two same-line">
					<div class="content-icon content-icon2" id="arrow-eficacia2"></div>
					<div class="content-text content-text2">
						<span id="eficacia2"></span>
					</div>
					<div class="content-frac2">
						<div class="frac-num"><span id="num2"></span></div>
						<div class="frac-line" id="frac-2"></div>
						<div class="frac-num"><span id="den2"></span></div>
					</div>
				</div>
			</div>
			<div class="content-separator"></div>
			<div class="content-box" id="ctrl_defe_porc2">
				<div class="normal-one">
					PRENDAS DEFECTUOSAS
				</div>
				<div class="normal-two n-t-l4">
					<span id="pren_defe2"></span>&nbsp;<span id="pren_defe_porc2"></span>
				</div>
			</div>
			<div class="content-separator"></div>
			<div class="content-box" id="ctrl_repr_porc2">
				<div class="normal-one">
					REPROCESO DE COSTURA
				</div>
				<div class="normal-two n-t-l4">
					<span id="pren_repr2"></span>&nbsp;<span id="pren_repr_porc2"></span>
				</div>
			</div>
		</div>
		<div class="blank-separate"></div>
		<div class="space-content">
			<div class="content-box main-content-box">
				<div class="level-one">
					TOTAL
				</div>
				<?php
				if($_GET['type']=="0"){
				?>
				<div class="level-two">
					FECHA: <span id="idfecha"><?php echo $_GET['fecha']; ?></span>
				</div>
				<?php
				}else{
					if($_GET['type']=="1"){
				?>
				<div class="level-two">
					AÑO: <span id="idsemana"><?php echo $_GET['anio']; ?></span> - SEMANA: <span id="idmes"><?php echo $_GET['semana']; ?></span>
				</div>
				<?php
					}else{
				?>
				<div class="level-two">
					AÑO: <span id="idsemana"><?php echo $_GET['anio']; ?></span> - MES: <span id="idmes"><?php echo $_GET['mes']; ?></span>
				</div>
				<?php
					}
				}
				?>
			</div>
			<div class="content-separator"></div>
			<div class="content-box" id="ctrl_efi_3">
				<div class="normal-one">
					EFICIENCIA
				</div>
				<div class="normal-two same-line">
					<div class="content-icon" id="arrow-eficiencia3"></div>
					<div class="content-text">
						<span id="eficiencia3"></span>
					</div>
				</div>
			</div>
			<div class="content-separator"></div>
			<div class="content-box" id="ctrl_efc_3">
				<div class="normal-one">
					EFICACIA
				</div>
				<div class="normal-two same-line">
					<div class="content-icon content-icon2" id="arrow-eficacia3"></div>
					<div class="content-text content-text2">
						<span id="eficacia3"></span>
					</div>
					<div class="content-frac2">
						<div class="frac-num"><span id="num3"></span></div>
						<div class="frac-line" id="frac-3"></div>
						<div class="frac-num"><span id="den3"></span></div>
					</div>
				</div>
			</div>
			<div class="content-separator"></div>
			<div class="content-box" id="ctrl_defe_porc3">
				<div class="normal-one">
					PRENDAS DEFECTUOSAS
				</div>
				<div class="normal-two n-t-l4">
					<span id="pren_defe3"></span>&nbsp;<span id="pren_defe_porc3"></span>
				</div>
			</div>
			<div class="content-separator"></div>
			<div class="content-box" id="ctrl_repr_porc3">
				<div class="normal-one">
					REPROCESO DE COSTURA
				</div>
				<div class="normal-two n-t-l4">
					<span id="pren_repr3"></span>&nbsp;<span id="pren_repr_porc3"></span>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var type="<?php if (isset($_GET['type'])) { echo $_GET['type']; }else{ echo ''; } ?>";
		var fecha="<?php if (isset($_GET['fecha'])) { echo $_GET['fecha']; }else{ echo ''; } ?>";
		var anio="<?php if (isset($_GET['anio'])) { echo $_GET['anio']; }else{ echo ''; } ?>";
		var semana="<?php if (isset($_GET['semana'])) { echo $_GET['semana']; }else{ echo ''; } ?>";
		var mes="<?php if (isset($_GET['mes'])) { echo $_GET['mes']; }else{ echo ''; } ?>";
	</script>
	<script type="text/javascript" src="js/ReporteTurnosHistorico-v1.0.js"></script>
</body>
</html>