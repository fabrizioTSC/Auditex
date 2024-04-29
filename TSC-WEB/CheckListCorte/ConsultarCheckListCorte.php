<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="2";
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
	<link rel="stylesheet" type="text/css" href="css/CheckListCorte-v1.0.css">
	<style type="text/css">
		table{
			width: 100%;
			border-collapse: collapse;
		}
		td,th{
			padding: 5px;
			border: 1px solid #333;
			font-size: 13px;
		}
		th{
			background: #980f0f;
			color: #fff;
		}
		td{
			background: #fff;
			color: #333;
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
			<div class="headerTitle">Consultar / Editar Check List</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">	
			<div style="padding: 0 10px;">
				<div class="sameline">
					<div class="lblNew" style="width: 60px;padding-top: 8px;">Ficha</div>
					<div class="spaceIpt" style="width: calc(100% - 90px);">
						<input type="number" id="idCodFicha" style="width: calc(100% - 12px);padding: 5px;">
					</div>
					<button class="btnBuscarSpace" style="width: 30px;margin-left: 5px;border-style: none;font-size: 22px;"><i class="fa fa-search" aria-hidden="true"></i></button>
				</div>
				<div id="content-result" style="display: none;margin-top: 10px;">
					<table>
						<thead>
							<tr>
								<th>Auditor</th>
								<th>Taller y Célula</th>
								<th>Cantidad</th>
								<th>Fecha auditada</th>
								<th>Resultado</th>
							</tr>
						</thead>
						<tbody id="table-body">
							
						</tbody>
					</table>
				</div>
				<div class="lineDecoration"></div>
				<div class="btnPrimary" onclick="redirect('main.php')" style="margin: auto;width: 150px;margin-top: 10px;">Terminar</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var codusu_var='<?php echo $_SESSION['user']; ?>';
		var perusu_var='<?php echo $_SESSION['perfil']; ?>';
	</script>
	<script type="text/javascript" src="js/ConsultarCheLisCor-v1.1.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>