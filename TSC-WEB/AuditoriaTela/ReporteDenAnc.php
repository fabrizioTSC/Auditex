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
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="css/IndicadorResultado-v1.0.css">
	<script src="charts-dist/Chart.min.js"></script>
	<script src="charts-dist/chartjs-plugin-datalabels.js"></script>
	<style type="text/css">
		.item-ajustar{
			height: 156px;
		}
		.linestyleend{
			background: #666;
			color:#fff;
		}
		#data-header{
			position: absolute;
			top: 0;
		}
		@media(max-width: 400px){
			.item-ajustar{
				height: 163px;
			}
		}
	</style>
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
			<div class="headerTitle">Reporte de Estabilidad Dimensional</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="sameline">
				<div class="lblNew" style="width: 100px;padding-top: 8px;">Telas:</div>
				<select class="classCmbBox" id="selectTela" style="width: calc(140px);">
				</select>
				<button class="btnPrimary" style="margin-left: 5px;width: auto;height: 35px;" onclick="update_reportes()"><i class="fa fa-search" aria-hidden="true"></i></button>
			</div>
			<div class="sameline">
				<div class="lblNew" style="width: 100px;padding-top: 8px;">Colores:</div>
				<select class="classCmbBox" id="selectColor" style="width: calc(140px);">
				</select>
			</div>
			<div class="sameline">
				<div class="lblNew" style="width: 100px;padding-top: 8px;">Programa:</div>
				<select class="classCmbBox" id="selectPrograma" style="width: calc(140px);">
				</select>
			</div>
			<!--
			<div class="rowLine" style="margin-bottom: 5px">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="downloadPDF()">Descargar PDF</button>
			</div>-->
			<div class="lblTitulo" id="titulodetalle"></div>

			<div class="lbl" style="margin-bottom: 10px;">ANCHOS (BEFORE)</div>
			<div class="firstGraph">

				<div style="display: flex;align-items: stretch;justify-content: center;">

					<!-- GENERAL -->
					<div class="contentGraph2" style="margin: 10px;flex-basis: 700px" id="chart-den1">
						<canvas id="chart-area-den1"></canvas>
					</div>

					<!-- TOTALES -->
					<div class="contentGraph2" style="margin: 10px;flex-basis: 200px" id="chart-den1total">
						<canvas style="margin-top: 80px;" id="chart-area-den1total"></canvas>
					</div>

				</div>

				<div style="display: flex;align-items: stretch;justify-content: center;">

					<!-- HISTOGRAMA -->
					<div class="contentGraph2" style="margin: 10px;flex-basis: 900px" id="chart-den1Histograma">
						<canvas id="chart-area-den1Histograma"></canvas>
					</div>


				</div>


			</div>

			<div class="lineDecoration"></div>

			<div class="lbl" style="margin-bottom: 10px;">DENSIDADES (BEFORE) </div>
			<div class="firstGraph">

				<div style="display: flex;align-items: stretch;justify-content: center;">

					<!-- GENERAL -->
						<div class="contentGraph2" style="margin: 10px;flex-basis: 700px " id="chart-anc1">
							<canvas id="chart-area-anc1"></canvas>
						</div>


					<!-- TOTALES -->
						<div class="contentGraph2" style="margin: 10px;flex-basis: 200px" id="chart-anc1total">
							<canvas style="margin-top: 80px;" id="chart-area-anc1total"></canvas>
						</div> 

				</div>

				<div style="display: flex;align-items: stretch;justify-content: center;">

					<!-- HISTOGRAMA -->
					<div class="contentGraph2" style="margin: 10px;flex-basis: 900px;" id="chart-anc1Histograma">
						<canvas id="chart-area-anc1Histograma"  ></canvas>
					</div>


				</div>


			</div>

			<!-- AGREGADO -->
			<div class="lineDecoration"></div>

			<div class="lbl" style="margin-bottom: 10px;">ANCHOS (AFTER)</div>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;" id="chart-anc2">
					<canvas id="chart-area-anc2"></canvas>
				</div>
			</div>

			<div class="lineDecoration"></div>
			
			<div class="lbl" style="margin-bottom: 10px;">DENSIDADES (AFTER) </div>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;" id="chart-den2">
					<canvas id="chart-area-den2"></canvas>
				</div>
			</div>
			<!-- END AGREGADO -->


			<div class="lineDecoration"></div>
			<div class="lbl" style="margin-bottom: 10px;">%ENC ANCHO 3RA LAV</div>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;" id="chart-gra3">
					<canvas id="chart-area-gra3"></canvas>
				</div>
			</div>
			<div class="lineDecoration"></div>
			<div class="lbl" style="margin-bottom: 10px;">%ENC LARGO 3RA LAV</div>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;" id="chart-gra4">
					<canvas id="chart-area-gra4"></canvas>
				</div>
			</div>
			<div class="lineDecoration"></div>
			<div class="lbl" style="margin-bottom: 10px;">% REVIRADO 3RA LAV</div>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;" id="chart-gra5">
					<canvas id="chart-area-gra5"></canvas>
				</div>
			</div>
			<div class="lineDecoration"></div>
			<div class="lbl" style="margin-bottom: 10px;">INCLINACIÓN ACABADO</div>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;" id="chart-gra6">
					<canvas id="chart-area-gra6"></canvas>
				</div>
			</div>
			<div class="lineDecoration"></div>
			<div class="lbl" style="margin-bottom: 10px;">INCLINACIÓN LAVADO</div>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;" id="chart-gra7">
					<canvas id="chart-area-gra7"></canvas>
				</div>
			</div>
			<div class="lineDecoration"></div>

			<div class="btnPrimary" style="margin-left: calc(50% - 80px);margin: 10px auto;width: 135px;
				padding: 5px;display: flex;padding-left: 20px;" onclick="exportar()">
				<img src="assets/img/excel.png" style="width: 30px;height: 30px;">
				<div style="padding: 5px;width:calc(80px);text-align: center;">Descargar</div>
			</div>
			<div id="maintbl" style="margin-bottom: 10px;">
				<div id="bodytbl" style="position: relative;overflow-x: scroll;max-height: calc(100vh - 300px);">
					<div class="tblHeader" style="width: 4540px;" id="data-header">
						<div class="itemHeader2" style="width: 70px;">#</div>
						<div class="itemHeader2" style="width: 90px;">Partida</div>
						<div class="itemHeader2" style="width: 150px;">Proveedor</div>
						<div class="itemHeader2" style="width: 150px;">Cliente</div>
						<div class="itemHeader2" style="width: 150px;">Programa</div>
						<div class="itemHeader2" style="width: 150px;">Cod. Tela</div>
						<div class="itemHeader2" style="width: 150px;">Desc. Tela</div>
						<div class="itemHeader2" style="width: 150px;">Color</div>
						<div class="itemHeader2" style="width: 90px;">Ancho</div>
						<div class="itemHeader2" style="width: 90px;">Std. Ancho</div>
						<div class="itemHeader2" style="width: 90px;">LIC2</div>
						<div class="itemHeader2" style="width: 90px;">LSC3</div>
						<div class="itemHeader2" style="width: 90px;">Densidad</div>
						<div class="itemHeader2" style="width: 90px;">Est&aacute;ndar</div>
						<div class="itemHeader2" style="width: 90px;">LIC</div>
						<div class="itemHeader2" style="width: 90px;">LSC</div>
						<div class="itemHeader2" style="width: 90px;">Fecha</div>
						<div class="itemHeader2" style="width: 90px;">KG.</div>
						<div class="itemHeader2" style="width: 90px;">Gr. por desv. por m2 de std.</div>
						<div class="itemHeader2" style="width: 90px;">% de desv. por  dens. std.</div>
						<div class="itemHeader2" style="width: 90px;">KG. afectados +/-</div>
						<div class="itemHeader2" style="width: 90px;">KG. afectados +</div>
						<div class="itemHeader2" style="width: 90px;">%Enc Anc 3ra Lav</div>
						<div class="itemHeader2" style="width: 90px;">Std %Enc Anc 3ra Lav </div>
						<div class="itemHeader2" style="width: 90px;">LI A3</div>
						<div class="itemHeader2" style="width: 90px;">LS A3</div>
						<div class="itemHeader2" style="width: 90px;">%Enc Lar 3ra Lav</div>
						<div class="itemHeader2" style="width: 90px;">Std %Enc Lar 3ra Lav </div>
						<div class="itemHeader2" style="width: 90px;">LI L3</div>
						<div class="itemHeader2" style="width: 90px;">LS L3</div>
						<div class="itemHeader2" style="width: 90px;">%Rev 3ra Lav</div>
						<div class="itemHeader2" style="width: 90px;">Std %Rev 3ra Lav</div>
						<div class="itemHeader2" style="width: 90px;">LI R3</div>
						<div class="itemHeader2" style="width: 90px;">LS R3</div>
						<div class="itemHeader2" style="width: 90px;">Inc Aca</div>
						<div class="itemHeader2" style="width: 90px;">Std Inc Aca</div>
						<div class="itemHeader2" style="width: 90px;">LI Inc Aca</div>
						<div class="itemHeader2" style="width: 90px;">LS Inc Aca</div>
						<div class="itemHeader2" style="width: 90px;">Inc Lav</div>
						<div class="itemHeader2" style="width: 90px;">Std Inc Lav</div>
						<div class="itemHeader2" style="width: 90px;">LI Inc Lav</div>
						<div class="itemHeader2" style="width: 90px;">LS Inc Lav</div>
					</div>
					<div class="tblHeader" style="width: 4540px;">
						<div class="itemHeader2" style="width: 70px;">#</div>
						<div class="itemHeader2" style="width: 90px;">Partida</div>
						<div class="itemHeader2" style="width: 150px;">Proveedor</div>
						<div class="itemHeader2" style="width: 150px;">Cliente</div>
						<div class="itemHeader2" style="width: 150px;">Programa</div>
						<div class="itemHeader2" style="width: 150px;">Cod. Tela</div>
						<div class="itemHeader2" style="width: 150px;">Desc. Tela</div>
						<div class="itemHeader2" style="width: 150px;">Color</div>
						<div class="itemHeader2" style="width: 90px;">Ancho</div>
						<div class="itemHeader2" style="width: 90px;">Std. Ancho</div>
						<div class="itemHeader2" style="width: 90px;">LIC2</div>
						<div class="itemHeader2" style="width: 90px;">LSC3</div>
						<div class="itemHeader2" style="width: 90px;">Densidad</div>
						<div class="itemHeader2" style="width: 90px;">Est&aacute;ndar</div>
						<div class="itemHeader2" style="width: 90px;">LIC</div>
						<div class="itemHeader2" style="width: 90px;">LSC</div>
						<div class="itemHeader2" style="width: 90px;">Fecha</div>
						<div class="itemHeader2" style="width: 90px;">KG.</div>
						<div class="itemHeader2" style="width: 90px;">Gr. por desv. por m2 de std.</div>
						<div class="itemHeader2" style="width: 90px;">% de desv. por  dens. std.</div>
						<div class="itemHeader2" style="width: 90px;">KG. afectados +/-</div>
						<div class="itemHeader2" style="width: 90px;">KG. afectados +</div>
						<div class="itemHeader2" style="width: 90px;">%Enc Anc 3ra Lav</div>
						<div class="itemHeader2" style="width: 90px;">Std %Enc Anc 3ra Lav </div>
						<div class="itemHeader2" style="width: 90px;">LI A3</div>
						<div class="itemHeader2" style="width: 90px;">LS A3</div>
						<div class="itemHeader2" style="width: 90px;">%Enc Lar 3ra Lav</div>
						<div class="itemHeader2" style="width: 90px;">Std %Enc Lar 3ra Lav </div>
						<div class="itemHeader2" style="width: 90px;">LI L3</div>
						<div class="itemHeader2" style="width: 90px;">LS L3</div>
						<div class="itemHeader2" style="width: 90px;">%Rev 3ra Lav</div>
						<div class="itemHeader2" style="width: 90px;">Std %Rev 3ra Lav</div>
						<div class="itemHeader2" style="width: 90px;">LI R3</div>
						<div class="itemHeader2" style="width: 90px;">LS R3</div>
						<div class="itemHeader2" style="width: 90px;">Inc Aca</div>
						<div class="itemHeader2" style="width: 90px;">Std Inc Aca</div>
						<div class="itemHeader2" style="width: 90px;">LI Inc Aca</div>
						<div class="itemHeader2" style="width: 90px;">LS Inc Aca</div>
						<div class="itemHeader2" style="width: 90px;">Inc Lav</div>
						<div class="itemHeader2" style="width: 90px;">Std Inc Lav</div>
						<div class="itemHeader2" style="width: 90px;">LI Inc Lav</div>
						<div class="itemHeader2" style="width: 90px;">LS Inc Lav</div>
					</div>
					<div class="tblBody" id="idTblBody" style="width: 4540px;">
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var codusu='<?php echo $_SESSION['user']; ?>';
		var codprv='<?php echo $_GET['codprv']; ?>';
		var codcli='<?php echo $_GET['codcli']; ?>';
		var fecini='<?php echo $_GET['fecini']; ?>';
		var fecfin='<?php echo $_GET['fecfin']; ?>';
	</script>
	<script type="text/javascript" src="js/ReporteDenAnc-v1.4.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>