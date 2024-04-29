<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="14";
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
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<style type="text/css">
		.classTaller{
			padding: 5px;
		}
		h4{
			margin: 5px auto;
			width: 80%;
		}
		table{
			width: 100%;
			min-width: 700px;
			border-collapse: collapse;
			font-size: 13px;
		}
		td{
			padding: 5px;
			border: 1px solid #333;
			color:#333;
			background: #fff;
		}
		th{
			padding: 5px;
			border: 1px solid #333;
			color:#fff;
			background: #922B21;
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
			<div class="headerTitle">Iniciar Producto No Conforme</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="rowLine bodyPrimary">
				<div class="sameLine" style="margin-bottom: 5px;">
					<input type="radio" id="idopc1" name="opcion" checked>
					<label for="idopc1">Ficha</label>
				</div>
				<div class="sameLine" style="margin-bottom: 5px;" id="content-opc1">
					<div class="lbl" style="width: 80px;">Ficha:</div>
					<div class="spaceIpt" style="width: calc(100% - 110px);">
						<input type="number" id="idcodfic" class="classIpt" style="width: calc(100% - 12px);">
					</div>
					<button class="btnBuscarSpace" style="width: 30px;margin-left: 5px;border-style: none;font-size: 22px;" onclick="search_ficha()"><i class="fa fa-search" aria-hidden="true"></i></button>
				</div>
				<div class="sameLine" style="margin-bottom: 5px;margin-top: 10px;">
					<input type="radio" id="idopc2" name="opcion">
					<label for="idopc2">Pedido - Color</label>
				</div>
				<div class="sameLine" style="margin-bottom: 5px;display: none;" id="content-opc2">
					<div class="lbl" style="width: 150px;">Pedido - Color:</div>
					<div class="spaceIpt" style="width: calc(100% - 150px);">
						<input type="number" id="idpedido" class="classIpt" style="width: calc(100% - 12px);">
					</div>
					<button class="btnBuscarSpace" style="width: 30px;margin-left: 5px;border-style: none;font-size: 22px;" onclick="search_pedido()"><i class="fa fa-search" aria-hidden="true"></i></button>
				</div>
				<div id="resultcontent-2" style="display: none;">
					<div class="rowLine">
						<h4>Seleccione un color</h4>
						<div class="tblSelection">
							<div class="listaTalleres" id="tabla-colores">
								<div class="classTaller" data-idtaller="" data-nomtaller=""></div>
							</div>
						</div>
						<div id="select-ficha" style="display: none;">
							<h4>Seleccionado: <span id="idnomcol"></span></h4>
							<center>
								<button class="btnPrimary" onclick="start_apnc()" id="btn-ini-2">Iniciar</button>
							</center>
							<div style="margin-top: 10px;width: 100%;overflow-x: scroll;">
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
									<tbody id="table-body-list-2">
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div id="resultcontent-1" style="display: none;">
					<div class="rowLine">
						<div class="tblHeader" style="width: calc(100% - 10px);">
							<div class="itemHeader">Ficha</div>							
							<div class="itemHeader">Tipo Auditoria</div>
							<div class="itemHeader">Parte</div>
							<div class="itemHeader">Vez</div>
							<div class="itemHeader">Prendas</div>
						</div>
						<div class="tblContent tblMaxHeight">
							<div class="tblBody">
							</div>
						</div>
					</div>
					<div class="spaceInLine"></div>
					<div id="fichaSelection">
						<div class="subtitle">Seleccione una ficha</div>
						<div class="spaceInLine"></div>
						<div class="textCenter" id="fichaSelected"></div>
					</div>
					<div class="spaceInLine"></div>
					<div id="muestraSelection">
						<div class="subtitle">Seleccionar tipo de muestra</div>
						<div class="spaceInLine"></div>
						<div class="detalleMuestras">
							<div class="spaceTipoMuestra">
								<div class="inputCheckSpace" data-target="idCheckAql">
									<input type="checkbox" class="iptCheckBox" id="idCheckAql">
									<div class="descCheack">Aql:&nbsp;<div id=aqlValue>15%</div></div>
								</div>
							</div>
						</div>
						<div class="iptForDiscrecional">
							<div class="sameLine">
								<div class="subtitle formAlternative">Cantidad de prendas a auditar:</div>
								<input type="number" id="idNumberPrendas">
							</div>
						</div>
					</div>
					<div class="spaceInLine"></div>
					<div class="finalBtn">
						<div class="btnPrimary btnNextPage" onclick="comenzarAuditoria()">Iniciar</div>
					</div>
				</div>
				<div id="resultcontent-3" style="display: none;">
					<center>
						<button class="btnPrimary" onclick="start_apnc_o()" id="btn-ini-1">Iniciar</button>
					</center>
					<div style="margin-top: 10px;width: 100%;overflow-x: scroll;">
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
							<tbody id="table-body-list">
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var codusu="<?php echo $_SESSION['user']; ?>";
	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/IniciarAudProNoCon-v1.1.js"></script>
</body>
</html>