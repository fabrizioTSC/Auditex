<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: ../../dashboard/index.php');
	}
	$appcod="101";
	include("config/_validate_access.php");
	include("config/_contentMenu.php");
?>
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
		<div class="space-content" id="main-content-1">
			<div class="space-content-s2">
				<div class="content-box main-content-box">
					<div class="level-one">
						<!-- L&Iacute;NEA <span id="num_linea1"></span> -->
						<span id="num_linea1"></span>

					</div>
					<div class="line-separate"></div>
					<div class="level-two">
						<span id="change1"></span>
					</div>
				</div>
				<div class="content-box" id="ctrl_efi_1_1">
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
				<div class="content-box" id="ctrl_efi_2_1">
					<div class="normal-one n-dl">
						PRENDAS PRODUCIDAS
					</div>
					<div class="normal-two">
						<span id="pren_prod1"></span>
					</div>
				</div>
				<div class="content-box" id="ctrl_defe_porc1">
					<div class="normal-one">
						PRENDAS DEFECTUOSAS
					</div>
					<div class="normal-two n-t-l4">
						<span id="pren_defe1"></span>&nbsp;<span id="pren_defe_porc1"></span>
					</div>
				</div>
			</div>
			<div class="space-content-s2">
				<div class="content-box" id="ctrl_efi_3_1">
					<div class="normal-one">
						CLIENTE
					</div>
					<div class="normal-two n-tl" id="ctrl_size_nom1">
						<span id="nom_cliente1"></span>
					</div>
				</div>
				<div class="content-box" id="ctrl_efi_0_1">
					<div class="normal-one">
						EFICACIA
					</div>
					<div class="normal-two same-line">
						<div class="content-icon2" id="arrow-eficacia1"></div>
						<div class="content-text2">
							<span id="eficacia1"></span>
						</div>
						<div class="content-frac2" id="arrow-eficacia1">
							<div class="frac-num"><span id="num1"></span></div>
							<div class="frac-line" id="frac-1"></div>
							<div class="frac-num"><span id="den1"></span></div>
						</div>
					</div>
				</div>
				<div class="content-box content-no-st">
					<div class="space-content-s3">
						<div class="content-box-s2" id="ctrl_efi_5_1">
							<div class="normal-one n-o-s2">
								PROYEC.
							</div>
							<div class="normal-two n-t-s2">
								<span id="proyeccion1"></span>
							</div>							
						</div>						
					</div>
					<div class="lateral-separate"></div>
					<div class="space-content-s3">
						<div class="content-box-s2" id="ctrl_efi_6_1">
							<div class="normal-one n-o-s2">
								CUOTA
							</div>
							<div class="normal-two n-t-s2">
								<span id="cuota1"></span>
							</div>
						</div>					
					</div>
				</div>
				<div class="content-box" id="ctrl_repr_porc1">
					<div class="normal-one">
						REPROCESO DE COSTURA
					</div>
					<div class="normal-two n-t-l4">
						<span id="pren_repr1"></span>&nbsp;<span id="pren_repr_porc1"></span>
					</div>
				</div>
			</div>
		</div>
		<div class="blank-separate"></div>
		<div class="space-content" id="main-content-2">
			<div class="space-content-s2">
				<div class="content-box main-content-box">
					<div class="level-one">
						<!-- L&Iacute;NEA <span id="num_linea2"></span> -->
						<span id="num_linea2"></span>

					</div>
					<div class="line-separate"></div>
					<div class="level-two">
						<span id="change2"></span>
					</div>
				</div>
				<div class="content-box" id="ctrl_efi_1_2">
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
				<div class="content-box" id="ctrl_efi_2_2">
					<div class="normal-one n-dl">
						PRENDAS PRODUCIDAS
					</div>
					<div class="normal-two">
						<span id="pren_prod2"></span>
					</div>
				</div>
				<div class="content-box" id="ctrl_defe_porc2">
					<div class="normal-one">
						PRENDAS DEFECTUOSAS
					</div>
					<div class="normal-two n-t-l4">
						<span id="pren_defe2"></span>&nbsp;<span id="pren_defe_porc2"></span>
					</div>
				</div>
			</div>
			<div class="space-content-s2">
				<div class="content-box" id="ctrl_efi_3_2">
					<div class="normal-one">
						CLIENTE
					</div>
					<div class="normal-two n-tl" id="ctrl_size_nom2">
						<span id="nom_cliente2"></span>
					</div>
				</div>
				<div class="content-box" id="ctrl_efi_0_2">
					<div class="normal-one">
						EFICACIA
					</div>
					<div class="normal-two same-line">
						<div class="content-icon2" id="arrow-eficacia2"></div>
						<div class="content-text2">
							<span id="eficacia2"></span>
						</div>
						<div class="content-frac2" id="arrow-eficacia2">
							<div class="frac-num"><span id="num2"></span></div>
							<div class="frac-line" id="frac-2"></div>
							<div class="frac-num"><span id="den2"></span></div>
						</div>
					</div>
				</div>
				<div class="content-box content-no-st">
					<div class="space-content-s3">
						<div class="content-box-s2" id="ctrl_efi_5_2">
							<div class="normal-one n-o-s2">
								PROYEC.
							</div>
							<div class="normal-two n-t-s2">
								<span id="proyeccion2"></span>
							</div>							
						</div>						
					</div>
					<div class="lateral-separate"></div>
					<div class="space-content-s3">
						<div class="content-box-s2" id="ctrl_efi_6_2">
							<div class="normal-one n-o-s2">
								CUOTA
							</div>
							<div class="normal-two n-t-s2">
								<span id="cuota2"></span>
							</div>
						</div>					
					</div>
				</div>
				<div class="content-box" id="ctrl_repr_porc2">
					<div class="normal-one">
						REPROCESO DE COSTURA
					</div>
					<div class="normal-two n-t-l4">
						<span id="pren_repr2"></span>&nbsp;<span id="pren_repr_porc2"></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var l="<?php echo $_GET['l']; ?>";
		var ldes="<?php echo $_GET['ldes']; ?>";

	</script>
	<script type="text/javascript" src="js/ReporteMonitor-v1.10.js"></script>
</body>
</html>