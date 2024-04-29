<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="14";
	include("config/_validate_access.php");
	include("config/_contentMenu.php");
	// holi mundo xd 
?>
<!DOCTYPE html>
<html>
<head>
	<title>AUDITEX</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index.css">
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
			<div class="headerTitle">Consultar Producto No Conforme</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="rowLine bodyPrimary">
				<div class="sameLine" style="margin-bottom: 5px;">
					<div class="lbl" style="width: 80px;">Ficha:</div>
					<div class="spaceIpt" style="width: calc(100% - 110px);">
						<input type="number" id="idcodfic" class="classIpt" style="width: calc(100% - 12px);" value="<?=  isset($_GET["codfic"]) ? $_GET["codfic"] : ''; ?>" >
					</div>
					<button class="btnBuscarSpace" style="width: 30px;margin-left: 5px;border-style: none;font-size: 22px;"><i class="fa fa-search" aria-hidden="true"></i></button>
				</div>
				<div id="table-result" style="display: none;">
					<table>
						<thead>
							<tr>
								<th>Num Vez</th>
								<th>Parte</th>
								<th>Fecha</th>
								<th>Auditor</th>
								<th>Cant Muestra</th>
								<th>Cant Clasi</th>
								<th>% No COnforme</th>
								<th>Cant Ficha</th>
							</tr>
						</thead>
						<tbody id="table-body">
							<tr>
								<td>Numvez</td>
								<td>Parte</td>
								<td>Usuario</td>
								<td>Cantidad</td>
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
	<script type="text/javascript" src="js/ConsultarAudProNoCon-v1.2.js"></script>
</body>
</html>