<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="101";
	include("config/_validate_access.php");
	include("config/_contentMenu.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>AUDITEX - INSPECCION</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="css/RegistroCuotasHoras-v1.2.css">
	<!--
	<script type="text/javascript" src="js/jquery/jquery-1.12.1.js"></script>
	<script type="text/javascript" src="js/jquery/jquery-ui-1.12.1.js"></script>
	<link rel="stylesheet" href="css/jquery/jquery-ui-1.12.1.css">
	-->
	<style type="text/css">
		.tblData{
			width: 100%;
		}/*
		.tbl-header,.tbl-body{
			width: 980px;
		}*/
		.tbl-in4{
			width: calc(25% - 10px);
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
			<div class="headerTitle">Registro de Minutos de Compensaci&oacute;n por Estilo</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div style="display: flex;">
				<div class="lbl" style="width: 70px;">Estilo:</div>
				<div class="spaceIpt" style="width: 150px;font-size: 15px">
					<input type="text" id="idesttsc" class="classIpt" style="width: 130px;">
				</div>
				<button class="btnPrimary" style="width: 40px;" onclick="get_esttsc()"><i class="fa fa-search" aria-hidden="true"></i></button>
			</div>
			<div id="tbl-generate" style="display: none;">
				<div class="lineDecoration"></div>
				<div style="text-align: center;margin-top: 5px;">
					<button class="btnPrimary" style="margin-top: 0px;" onclick="guardarMinCom()">Guardar</button>
				</div>
				<div class="tblData">
					<div class="tbl-header">
						<div class="head-tbl tbl-in4">Pri. Act.</div>					
						<div class="head-tbl tbl-in4">Ult. Act.</div>						
						<div class="head-tbl tbl-in4">Alternativa</div>
						<div class="head-tbl tbl-in4">Ruta</div>
						<div class="head-tbl tbl-in4">Min. Cost.</div>
						<div class="head-tbl tbl-in4">Tiem. Com.</div>
						<div class="head-tbl tbl-in4">Min. Tot.</div>
						<div class="head-tbl tbl-in4">Obs.</div>
						<!--
						<div class="head-tbl tbl-in3">Pri. Act.</div>
						<div class="head-tbl tbl-in3">Ult. Act.</div>	
-->						
					</div>
					<div class="tbl-body" id="space-fill">
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var codusu="<?php echo $_SESSION['user']; ?>";
	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/RegistroMinComEst-v1.2.js"></script>
</body>
</html>