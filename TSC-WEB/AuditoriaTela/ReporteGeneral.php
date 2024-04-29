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
	<link rel="stylesheet" type="text/css" href="css/consultaAuditoria.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
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
			<div class="headerTitle">Reporte General</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent" style="padding-bottom: 0px;">
			<div style="padding: 5px;font-size: 15px;font-weight: bold;">Estado: <span id="idEstado"></span></div>
			<div id="maintbl" style="margin-bottom: 10px;overflow-x: scroll;height: calc(100vh - 220px);position: relative;">
				<div id="bodytbl" style="position: relative;">
					<div class="tblHeader" id="data-header" style="position: fixed;z-index: 11;top:0px;width: 2320px;">
						<div class="itemHeader2" style="width: 80px;">Partida</div>
						<div class="itemHeader2" style="width: 150px;">Proveedor</div>
						<div class="itemHeader2" style="width: 150px;">Cliente</div>
						<div class="itemHeader2" style="width: 100px;">Cod. Tela</div>
						<div class="itemHeader2" style="width: 300px;">Desc. Tela</div>
						<div class="itemHeader2" style="width: 100px;">Programa</div>
						<div class="itemHeader2" style="width: 100px;">Cod. Color</div>
						<div class="itemHeader2" style="width: 300px;">Desc. Color</div>


						<div class="itemHeader2" style="width: 80px;">Num. Vez</div>
						<div class="itemHeader2" style="width: 80px;">Auditor</div>
						<div class="itemHeader2" style="width: 80px;">Coord.</div>
						<div class="itemHeader2" style="width: 90px;">Fec. Inicio</div>
						<div class="itemHeader2" style="width: 90px;">Fec. Fin</div>
						<div class="itemHeader2" style="width: 90px;">Resultado</div>
						<div class="itemHeader2" style="width: 80px;">Estado</div>
						<div class="itemHeader2" style="width: 90px;">Res. Tono</div>
						<div class="itemHeader2" style="width: 90px;">Res. Apa.</div>
						<div class="itemHeader2" style="width: 90px;">Res. Est. Dim.</div>
						<div class="itemHeader2" style="width: 90px;">Rollos</div>
						<div class="itemHeader2" style="width: 90px;">Rol. Aud.</div>
						<div class="itemHeader2" style="width: 90px;">Calificaci&oacute;n</div>
						<div class="itemHeader2" style="width: 90px;">Puntos</div>
						<div class="itemHeader2" style="width: 90px;">Tipo</div>
						<div class="itemHeader2" style="width: 90px;">Peso</div>
						<div class="itemHeader2" style="width: 90px;">Pes. Aud.</div>
						<div class="itemHeader2" style="width: 90px;">Pes. Apr.</div>
						<div class="itemHeader2" style="width: 90px;">Pes. Cai.</div>
						<div class="itemHeader2" style="width: 90px;">% Kg Caida</div>
					</div>
					<div class="tblHeader" style="position: relative;z-index: 10;width: 2320px;">

						<div class="itemHeader2" style="width: 80px;">Partida</div>
						<div class="itemHeader2" style="width: 150px;">Proveedor</div>
						<div class="itemHeader2" style="width: 150px;">Cliente</div>
						<div class="itemHeader2" style="width: 100px;">Cod. Tela</div>
						<div class="itemHeader2" style="width: 300px;">Desc. Tela</div>
						<div class="itemHeader2" style="width: 100px;">Programa</div>
						<div class="itemHeader2" style="width: 100px;">Cod. Color</div>
						<div class="itemHeader2" style="width: 300px;">Desc. Color</div>

						<div class="itemHeader2" style="width: 80px;">Num. Vez</div>
						<div class="itemHeader2" style="width: 80px;">Auditor</div>
						<div class="itemHeader2" style="width: 80px;">Coord.</div>
						<div class="itemHeader2" style="width: 90px;">Fec. Inicio</div>
						<div class="itemHeader2" style="width: 90px;">Fec. Fin</div>
						<div class="itemHeader2" style="width: 90px;">Resultado</div>
						<div class="itemHeader2" style="width: 80px;">Estado</div>
						<div class="itemHeader2" style="width: 90px;">Res. Tono</div>
						<div class="itemHeader2" style="width: 90px;">Res. Apa.</div>
						<div class="itemHeader2" style="width: 90px;">Res. Est. Dim.</div>
						<div class="itemHeader2" style="width: 90px;">Rollos</div>
						<div class="itemHeader2" style="width: 90px;">Rol. Aud.</div>
						<div class="itemHeader2" style="width: 90px;">Calificaci&oacute;n</div>
						<div class="itemHeader2" style="width: 90px;">Puntos</div>
						<div class="itemHeader2" style="width: 90px;">Tipo</div>
						<div class="itemHeader2" style="width: 90px;">Peso</div>
						<div class="itemHeader2" style="width: 90px;">Pes. Aud.</div>
						<div class="itemHeader2" style="width: 90px;">Pes. Apr.</div>
						<div class="itemHeader2" style="width: 90px;">Pes. Cai.</div>
						<div class="itemHeader2" style="width: 90px;">% Kg Caida</div>
					</div>
					<div class="tblBody" id="idTblBody" style="position: relative;width: 2320px;">
					</div>
				</div>
			</div>
			<div id="msgNoResultados" style="color: red;font-size: 18px; padding: 5px;font-size: 14px;">No hay resultados!</div>
			<div class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;width: 135px;
				padding: 5px;display: flex;padding-left: 20px;" onclick="exportar()">
				<img src="assets/img/excel.png" style="width: 30px;height: 30px;">
				<div style="padding: 5px;width:calc(80px);text-align: center;">Descargar</div>
			</div>
			<div class="lineDecoration"></div>
		</div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="redirect('main.php')">Volver</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript">
		var fecini="<?php echo $_GET['fecini']; ?>";
		var fecfin="<?php echo $_GET['fecfin']; ?>";
		var codprv="<?php echo $_GET['codprv']; ?>";
		var estado="<?php echo $_GET['estado']; ?>";
		var resultado="<?php echo $_GET['resultado']; ?>";
	</script>
	<script type="text/javascript" src="js/ReporteGeneral-v1.1.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>