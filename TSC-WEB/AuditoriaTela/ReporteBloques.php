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
			<div class="headerTitle">Indicador de Análisis no conforme - Rechazo</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="rowLine" style="margin-bottom: 5px">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="downloadPDF()">Descargar PDF</button>
			</div>
			<div class="lblTitulo" id="titulodetalle"></div>
			<div class="lbl">KG <span class="idtit1"></span> POR BLOQUES</div>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;">
					<canvas id="chart-area"></canvas>
				</div>
			</div>
			<div id="maintbl" style="margin-bottom: 10px;">
				<div id="bodytbl" style="position: relative;">
					<div class="tblHeader">
						<div class="itemHeader2" style="width: 28%;">Bloque</div>
						<div class="itemHeader2" style="width: 18%;">Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;">% por Kg. Aud.</div>
						<div class="itemHeader2" style="width: 18%;">% Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;"># <span class="tit2"></span></div>
					</div>
					<div class="tblBody" id="idTblBody">
					</div>
				</div>
			</div>
			<div class="lineDecoration"></div>
			<div class="lbl">TONO</div>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;">
					<canvas id="chart-area2"></canvas>
				</div>
			</div>
			<div id="maintbl" style="margin-bottom: 10px;">
				<div id="bodytbl" style="position: relative;">
					<div class="tblHeader">
						<div class="itemHeader2" style="width: 28%;">Defecto</div>
						<div class="itemHeader2" style="width: 18%;">Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;">% por Kg. Aud.</div>
						<div class="itemHeader2" style="width: 18%;">% Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;"># <span class="tit2"></span></div>
					</div>
					<div class="tblBody" id="idTblBody2">
					</div>
				</div>
			</div>
			<div class="lineDecoration"></div>
			<div class="lbl">TONO - COLOR</div>
			<div class="sameline">
				<div class="lblNew" style="width: 100px;padding-top: 8px;">Tono:</div>
				<select class="classCmbBox classseltoncol" id="selectTonCol" style="width: calc(140px);">
				</select>
			</div>
			<!--<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;">
					<canvas id="chart-area2-1"></canvas>
				</div>
			</div>-->
			<div id="maintbl" style="margin-bottom: 10px;">
				<div id="bodytbl" style="position: relative;">
					<div class="tblHeader">
						<div class="itemHeader2" style="width: 28%;">Cod. Color</div>
						<div class="itemHeader2" style="width: 18%;">Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;">% por Kg. Aud.</div>
						<div class="itemHeader2" style="width: 18%;">% Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;"># <span class="tit2"></span></div>
					</div>
					<div class="tblBody" id="idTblBody2-1">
					</div>
				</div>
			</div>
			<div class="lineDecoration"></div>
			<div class="lbl">TONO - TELA</div>
			<div class="sameline">
				<div class="lblNew" style="width: 100px;padding-top: 8px;">Tono:</div>
				<select class="classCmbBox classseltontel" id="selectTonTel" style="width: calc(140px);">
				</select>
			</div>
			<!--<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;">
					<canvas id="chart-area2-1"></canvas>
				</div>
			</div>-->
			<div id="maintbl" style="margin-bottom: 10px;">
				<div id="bodytbl" style="position: relative;">
					<div class="tblHeader">
						<div class="itemHeader2" style="width: 28%;">Tela</div>
						<div class="itemHeader2" style="width: 18%;">Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;">% por Kg. Aud.</div>
						<div class="itemHeader2" style="width: 18%;">% Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;"># <span class="tit2"></span></div>
					</div>
					<div class="tblBody" id="idTblBody2-2">
					</div>
				</div>
			</div>
			<div class="lineDecoration"></div>
			<div class="lbl">APARIENCIA</div>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;">
					<canvas id="chart-area3"></canvas>
				</div>
			</div>
			<div id="maintbl" style="margin-bottom: 10px;">
				<div id="bodytbl" style="position: relative;">
					<div class="tblHeader">
						<div class="itemHeader2" style="width: 28%;">&Aacute;rea</div>
						<div class="itemHeader2" style="width: 18%;">Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;">% por Kg. Aud.</div>
						<div class="itemHeader2" style="width: 18%;">% Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;"># <span class="tit2"></span></div>
					</div>
					<div class="tblBody" id="idTblBody3">
					</div>
				</div>
			</div>
			<!--<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;">
					<canvas id="chart-area4"></canvas>
				</div>
			</div>-->
			<div class="lineDecoration"></div>
			<div class="lbl">APARIENCIA - DEFECTO</div>
			<div class="sameline">
				<div class="lblNew" style="width: 140px;padding-top: 8px;">Cod. &Aacute;rea:</div>
				<select class="classCmbBox classApaCodareDef" id="selectApaCodAreaDef" style="width: calc(140px);">
				</select>
			</div>
			<div id="maintbl" style="margin-bottom: 10px;">
				<div id="bodytbl" style="position: relative;">
					<div class="tblHeader">
						<div class="itemHeader2" style="width: 28%;">&Aacute;rea</div>
						<div class="itemHeader2" style="width: 28%;">Defecto</div>
						<div class="itemHeader2" style="width: 18%;">Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;">% por Kg. Aud.</div>
						<div class="itemHeader2" style="width: 18%;">% Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;"># <span class="tit2"></span></div>
					</div>
					<div class="tblBody" id="idTblBody4">
					</div>
				</div>
			</div>
			<div class="lineDecoration"></div>
			<div class="lbl">APARIENCIA - COLOR</div>
			<div class="sameline">
				<div class="lblNew" style="width: 140px;padding-top: 8px;">Cod. Apariencia:</div>
				<select class="classCmbBox classApaCodApaCol" id="selectApaCodApaCol" style="width: calc(140px);">
				</select>
			</div>
			<div id="maintbl" style="margin-bottom: 10px;">
				<div id="bodytbl" style="position: relative;">
					<div class="tblHeader">
						<div class="itemHeader2" style="width: 28%;">Cod. Color</div>
						<div class="itemHeader2" style="width: 18%;">Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;">% por Kg. Aud.</div>
						<div class="itemHeader2" style="width: 18%;">% Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;"># <span class="tit2"></span></div>
					</div>
					<div class="tblBody" id="idTblBody4-1">
					</div>
				</div>
			</div>
			<div class="lineDecoration"></div>
			<div class="lbl">APARIENCIA - TELA</div>
			<div class="sameline">
				<div class="lblNew" style="width: 140px;padding-top: 8px;">Cod. Apariencia:</div>
				<select class="classCmbBox classApaCodApaTel" id="selectApaCodApaTel" style="width: calc(140px);">
				</select>
			</div>
			<div id="maintbl" style="margin-bottom: 10px;">
				<div id="bodytbl" style="position: relative;">
					<div class="tblHeader">
						<div class="itemHeader2" style="width: 28%;">Tela</div>
						<div class="itemHeader2" style="width: 18%;">Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;">% por Kg. Aud.</div>
						<div class="itemHeader2" style="width: 18%;">% Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;"># <span class="tit2"></span></div>
					</div>
					<div class="tblBody" id="idTblBody4-2">
					</div>
				</div>
			</div>
			<div class="lineDecoration"></div>
			<div class="lbl">ESTABILIDAD DIMENSIONAL</div>
			<div class="firstGraph">
				<div class="contentGraph" style="min-width: 700px;">
					<canvas id="chart-area5"></canvas>
				</div>
			</div>
			<div id="maintbl" style="margin-bottom: 10px;">
				<div id="bodytbl" style="position: relative;">
					<div class="tblHeader">
						<div class="itemHeader2" style="width: 28%;">Caracter&iacute;stica</div>
						<div class="itemHeader2" style="width: 28%;">Fuera Lim.</div>
						<div class="itemHeader2" style="width: 18%;">Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;">% por Kg. Aud.</div>
						<div class="itemHeader2" style="width: 18%;">% Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;"># <span class="tit2"></span></div>
					</div>
					<div class="tblBody" id="idTblBody5">
					</div>
				</div>
			</div>
			<div class="lineDecoration"></div>
			<div class="lbl">ESTABILIDAD DIMENSIONAL - COLOR</div>
			<div class="sameline">
				<div class="lblNew" style="width: 140px;padding-top: 8px;">Est. Dimensional:</div>
				<select class="classCmbBox" id="selectEstDimCol" style="width: calc(140px);">
				</select>
				<button class="btnPrimary" style="margin-left: 5px;width: auto;height: 35px;" onclick="update_edcol()"><i class="fa fa-search" aria-hidden="true"></i></button>
			</div>
			<div class="sameline">
				<div class="lblNew" style="width: 140px;padding-top: 8px;">Rango:</div>
				<select class="classCmbBox" id="selectEstDimRanCol" style="width: calc(140px);">
				</select>
			</div>
			<div id="maintbl" style="margin-bottom: 10px;">
				<div id="bodytbl" style="position: relative;">
					<div class="tblHeader">
						<div class="itemHeader2" style="width: 28%;">Cod. Color</div>
						<div class="itemHeader2" style="width: 28%;">Fuera Lim.</div>
						<div class="itemHeader2" style="width: 18%;">Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;">% por Kg. Aud.</div>
						<div class="itemHeader2" style="width: 18%;">% Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;"># <span class="tit2"></span></div>
					</div>
					<div class="tblBody" id="idTblBody5-1">
					</div>
				</div>
			</div>
			<div class="lineDecoration"></div>
			<div class="lbl">ESTABILIDAD DIMENSIONAL - TELA</div>
			<div class="sameline">
				<div class="lblNew" style="width: 140px;padding-top: 8px;">Est. Dimensional:</div>
				<select class="classCmbBox" id="selectEstDimTel" style="width: calc(140px);">
				</select>
				<button class="btnPrimary" style="margin-left: 5px;width: auto;height: 35px;" onclick="update_edtel()"><i class="fa fa-search" aria-hidden="true"></i></button>
			</div>
			<div class="sameline">
				<div class="lblNew" style="width: 140px;padding-top: 8px;">Rango:</div>
				<select class="classCmbBox" id="selectEstDimRanTel" style="width: calc(140px);">
				</select>
			</div>
			<div id="maintbl" style="margin-bottom: 10px;">
				<div id="bodytbl" style="position: relative;">
					<div class="tblHeader">
						<div class="itemHeader2" style="width: 28%;">Tela</div>
						<div class="itemHeader2" style="width: 28%;">Fuera Lim.</div>
						<div class="itemHeader2" style="width: 18%;">Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;">% por Kg. Aud.</div>
						<div class="itemHeader2" style="width: 18%;">% Kg. <span class="tit2"></span></div>
						<div class="itemHeader2" style="width: 18%;"># <span class="tit2"></span></div>
					</div>
					<div class="tblBody" id="idTblBody5-2">
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var codusu='<?php echo $_SESSION['user']; ?>';
		var codprv='<?php echo $_GET['codprv']; ?>';
		var codcli='<?php echo $_GET['codcli']; ?>';
		var codusurep='<?php echo $_GET['codusu']; ?>';
		var codusueje='<?php echo $_GET['codusueje']; ?>';
		var fecini='<?php echo $_GET['fecini']; ?>';
		var fecfin='<?php echo $_GET['fecfin']; ?>';
		var resultado='<?php echo $_GET['resultado']; ?>';
		var codarea='<?php if (isset($_GET['codarea'])){echo $_GET['codarea'];}else{ echo "0";} ?>';
		var codton='<?php if (isset($_GET['codton'])){echo $_GET['codton'];}else{ echo "0";} ?>';
		var codapa='<?php if (isset($_GET['codapa'])){echo $_GET['codapa'];}else{ echo "0";} ?>';
		var codestdim='<?php if (isset($_GET['codestdim'])){echo $_GET['codestdim'];}else{ echo "0";} ?>';
		var rango='<?php if (isset($_GET['rango'])){echo $_GET['rango'];}else{ echo "0";} ?>';
		var coddef='<?php if (isset($_GET['coddef'])){echo $_GET['coddef'];}else{ echo "0";} ?>';
	</script>
	<script type="text/javascript" src="js/ReporteBloques-v1.2.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>