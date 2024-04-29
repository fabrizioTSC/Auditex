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
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<style type="text/css">
		.itemHeader,.itemBody{
			font-size: 12px;
		}
	</style>
</head>
<body onLoad="getFichas()">
	<div class="panelCarga" style="display: none;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<?php contentMenu();?>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Iniciar Check List Corte</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="rowLine bodyPrimary">
				<div class="sameLine" style="margin-bottom: 5px;">
					<div class="lbl" style="width: 80px;">Ficha:</div>
					<div class="spaceIpt" style="width: calc(100% - 140px);">
						<input type="number" id="codfic" class="classIpt" style="width: calc(100% - 15px);">
					</div>
					<button class="btnBuscarSpace" style="width: 30px;margin-left: 5px;border-style: none;font-size: 22px;" onclick="search_ficha()"><i class="fa fa-search" aria-hidden="true"></i></button>
				</div>
				<div class="rowLine">
						<div class="tblHeader" style="width: calc(100% - 10px);">
							<div class="itemHeader" style="width: 12%">Ficha</div>
							<div class="itemHeader" style="width: 16%">Usuario</div>
							<div class="itemHeader" style="width: 10%">Prendas</div>
							<div class="itemHeader" style="width: 12%">Partida</div>
							<div class="itemHeader" style="width: 25%">Tela</div>
							<div class="itemHeader" style="width: 25%">Color</div>
						</div>
					<div class="tblContent tblMaxHeight">
						<div class="tblBody">
						</div>
					</div>
				</div>
				<div class="spaceInLine"></div>
				<div id="fichaSelection">
					<div class="subtitle" id="text-efect" style="display: none;">Seleccione una ficha</div>
					<div class="spaceInLine"></div>
					<div class="textCenter" id="fichaSelected"></div>
				</div>	
				<div id="result-partida" style="display: none;margin-top: 5px;">
					<div class="rowLine bodyPrimary" style="margin-bottom: 5px;">
						<div class="sameLine" style="font-size: 15px;margin-bottom: 5px;">
							<span style="font-weight: 700;">Taller actual:&nbsp;</span><span id="idDesTll"></span>
						</div>
						<div class="sameLine">
							<div class="lbl" style="width: 120px;">Ingrese taller:</div>
							<div class="spaceIpt" style="width: calc(100% - 120px);">
								<input type="text" id="idTaller" class="classIpt">
							</div>
						</div>
						<div class="tblSelection" style="margin-bottom: 5px;">
							<div class="listaTalleres" id="tbl-taller">
								<div class="taller">asd</div>
							</div>
						</div>
						<div class="sameLine">
							<p><b>NOTA:</b> Solo en caso de cambio, seleccione el nuevo taller</p>
						</div>
						<div id="result-celula" style="display: none;margin-top: 5px;">
							<div class="rowLine bodyPrimary" style="margin-bottom: 5px;">
								<div class="sameLine" style="font-size: 15px;margin-bottom: 5px;">
									<span style="font-weight: 700;">Célula actual:&nbsp;</span><span id="idDesCel"></span>
								</div>
								<div class="sameLine">
									<div class="lbl" style="width: 120px;">Ingrese célula:</div>
									<div class="spaceIpt" style="width: calc(100% - 120px);">
										<input type="text" id="idCelula" class="classIpt">
									</div>
								</div>
								<div class="tblSelection" style="margin-bottom: 5px;">
									<div class="listaTalleres" id="tbl-celula">
										<div class="taller">asd</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<center>
					<div class="btnPrimary btnNextPage" onclick="comenzarAuditoria()">Iniciar auditoria</div>
					</center>
				</div>
				<div id="no-result-partida" style="display: none;">
					<div class="lbl" style="color: #a71616;">Partida no encontrada!</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var usuario_afc="<?php echo $_SESSION['user']; ?>";
	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/IniciarCheLisCor-v1.3.js"></script>
</body>
</html>