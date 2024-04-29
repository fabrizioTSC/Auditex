<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="16";
	//include("config/_validate_access.php");
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
		
		table,th,td{
			border-collapse: collapse;
		}
		table{
			width: 100%;
			font-size: 13px;
		}
		th,td{
			border: 1px #333 solid;
			padding: 5px;
		}
		th{
			background: #980f0f;
			color: #fff;
		}
		td{
			background: #fff;
		}
	</style>
</head>
<body>
	<div class="panelCarga" style="display: none;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<?php contentMenu();?>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Consultar Auditoría de Control de humedad</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="rowLine bodyPrimary">
				<div class="sameLine" style="margin-bottom: 5px;display: none;">
					<div class="lbl" style="width: 80px;">Ficha:</div>
					<div class="spaceIpt" style="width: calc(100% - 110px);">
						<input type="number" id="idcodfic" class="classIpt" style="width: calc(100% - 12px);">
					</div>
					<button class="btnBuscarSpace" style="width: 30px;margin-left: 5px;border-style: none;font-size: 22px;"><i class="fa fa-search" aria-hidden="true"></i></button>
				</div>
				<h3 style="margin: 0 0 5px 0">Seleccione auditoria a consultar</h3>
				<div id="table-result" style="display: none;">
					<table>
						<thead>
							<tr>
								<th>Cliente</th>
								<th>Hum. Max.</th>
								<th>Usuario</th>
								<th>Fecha</th>
								<th>Hum. Prom.</th>
								<th>Registros</th>
								<th>Cant. Ficha</th>
							</tr>
						</thead>
						<tbody id="table-body">
							<tr>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var codusu="<?php echo $_SESSION['user']; ?>";
		var codfic="<?php if(isset($_GET['codfic'])){echo $_GET['codfic'];}else{ echo "";} ?>";
	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/ConsultarAudConHum-v1.0.js"></script>
</body>
</html>