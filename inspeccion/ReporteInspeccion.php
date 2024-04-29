<?php
	session_start();
	if (!isset($_SESSION['user-ins'])) {
		header('Location: index.php');
	}
	include("config/_contentMenu.php");
	include("config/connection.php");
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
	<link rel="stylesheet" type="text/css" href="css/demo-v5.css">
	<link rel="stylesheet" type="text/css" href="css/responsive-demo-2.css">
	<link rel="stylesheet" type="text/css" href="css/reporte-react-v.1.1.css">
	<script src="charts-dist/Chart.min.js"></script>
	<!--<script src="charts-dist/chartjs-plugin-labels.min.js"></script>-->
	<script src="charts-dist/chartjs-plugin-datalabels.js"></script>
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
			<div class="headerTitle">Reporte de inspecci&oacute;n</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent" style="padding-bottom: 5px;">
			<div id="space1">
				<div class="sameline" style="font-weight: bold;">
					Reporte por lineas <input type="checkbox" id="check1" checked>
				</div>
				<div id="option1">
					<div class="rowSameLine" style="margin-top: 5px;">
						<div class="lbl" style="width: 60px;">Linea:</div>
						<input type="text" id="idLinea" class="classIpt" style="width: 200px;margin-right: 10px;">
					</div>		
					<div class="lbl" style="padding: 0px;margin-bottom: 10px;margin-left: 10%;">Lista de Lineas:</div>
					<div class="tblSelection tblStyle2">
						<div class="listaTalleres">
						</div>
					</div>
				</div>	
				<div class="lineDecoration"></div>
				<div class="sameline" style="font-weight: bold;">
					Reporte por turnos <input type="checkbox" id="check2">
				</div>
				<div id="option2" style="display: none;">
					<div class="spaceAlign" style="display: flex;">
						<div class="lbl" style="width: 60px;">Turno:</div>
						<select class="classSelect" id="select-turno">
						</select>
					</div>
				</div>	
				<div class="lineDecoration"></div>
				<div class="rowSameLine" style="margin-top: 5px;">
					<div class="lbl" style="width: 200px;">Tiem. Actualizaci&oacute;n (Min.):</div>
					<input type="number" id="idTiempo" class="classIpt" style="width: 80px;margin-right: 10px;" value="15">
				</div>	
				<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
					<div class="rowLine bodyPrimary">
						<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 5px;" onclick="showReporte()">Mostrar reporte</button>
					</div>		
				</div>
				<div class="lineDecoration"></div>
				<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
					<div class="rowLine bodyPrimary">
						<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="redirect('main.php')">Terminar</button>
					</div>		
				</div>		
			</div>	
			<div id="space2" style="display: none;">
				<div class="linkclass" onclick="backSpace1()" style="margin-bottom: 5px;">Volver</div>
				<div class="rowLine" style="margin-bottom: 5px">
					<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="downloadPDF()">Descargar PDF</button>
				</div>
				<div class="lbl" style="padding: 0px;margin-bottom: 5px;">Resumen General de Registro de Inspecci&oacute;n</div>
				<div class="lineDecoration"></div>
				<div id="detail1">
					<div class="lbl" style="padding: 0px;margin-bottom: 5px;">Linea:&nbsp;<span id="idNomLinea"></span>&nbsp;&nbsp;-<!--&nbsp;&nbsp;Turno:&nbsp;
						<span id="idTurno"></span>&nbsp;&nbsp;--->&nbsp;&nbsp;Fecha:&nbsp;<span id="idFecha"></span></div>
					<div class="lbl" style="padding: 0px;margin-bottom: 5px;">Ficha:&nbsp;
						<span id="idFicha"></span>&nbsp;&nbsp;-&nbsp;&nbsp;Pedido:&nbsp;<span id="idPedido"></span>&nbsp;&nbsp;-&nbsp;&nbsp;Cliente:&nbsp;
						<span id="idCliente"></span></div>
				</div>
				<div id="detail2">
					<div class="lbl" style="padding: 0px;margin-bottom: 5px;">Turno:&nbsp;<span id="idTurnoTur"></span>&nbsp;&nbsp;-<!--&nbsp;&nbsp;Turno:&nbsp;
						<span id="idTurno"></span>&nbsp;&nbsp;--->&nbsp;&nbsp;Fecha:&nbsp;<span id="idFechaTur"></span></div>
				</div>
				<div class="lineDecoration"></div>
				<div class="response-tablet">
					<div id="spaceForCharts">
						<div class="classMainChart">
							<div class="alignCharts">
								<div class="completeWidth"></div>
								<div class="tableContentResult spaceWithoutMargin" style="margin-bottom: 5px;margin-right: 5px;margin-left: 0px;">
									<div class="detailPercent">100%</div>
									<div class="lbl lbl-box" style="padding: 0px;margin-bottom: 2px;">Total prendas inspeccionadas</div>
									<div class="spanDetail" id="valCanPre"></div>
								</div>
								<div class="tableContentResult spaceWithoutMargin" style="margin-bottom: 5px;margin-left: 0px;">
									<div class="detailPercent" id="perCanPreSD"></div>
									<div class="lbl lbl-box" style="padding: 0px;margin-bottom: 2px;">Total prendas sin defecto</div>
									<div class="spanDetail" id="valCanPreSD"></div>
								</div>
								<div class="tableContentResult spaceWithoutMargin" style="margin-bottom: 5px;margin-left: 5px;">
									<div class="detailPercent" id="perCanPreD"></div>
									<div class="lbl lbl-box" style="padding: 0px;margin-bottom: 2px;">Total prendas defectuosas</div>
									<div class="spanDetail" id="valCanPreD"></div>
								</div>
								<div class="completeWidth"></div>
							</div>
							<div class="spaceGraph" id="chart1">
								<canvas id="chart-area"></canvas>
							</div>
						</div>
					</div>
					<div class="lineDecoration" id="lineDecoCentral"></div>
					<div id="spaceForCharts2">
						<div class="classSecondResult">					
							<div class="tableContentResult" style="margin-bottom: 5px;">
								<div class="detailPercent">100%</div>
								<div class="lbl lbl-box" style="padding: 0px;margin-bottom: 2px;">Total defectos</div>
								<span class="spanDetail" id="valcandef"></span>
							</div>
						</div>
						<div class="animateClass">
							<div class="contentclass">
								<div class="spaceNewBox">
									<div class="tableContentResult">
										<div class="detailPercent" id="porDefDet1">100%</div>
										<div class="lbl lbl-box" style="padding: 0px;margin-bottom: 2px;">Def. Const. - Limp. Manchas</div>
										<span class="spanDetail" id="valcandefDet1">0</span>
									</div>
								</div>
								<div class="spaceGraph secondSSpaceGraph" id="chart2">
									<canvas id="chart-area2"></canvas>					
								</div>
							</div>
							<div class="contentclass">	
								<div class="spaceNewBox">			
									<div class="tableContentResult" style="margin-bottom: 5px;">
										<div class="detailPercent" id="porDefDet2">100%</div>
										<div class="lbl lbl-box" style="padding: 0px;margin-bottom: 2px;">Def. Tela - Otros</div>
										<span class="spanDetail" id="valcandefDet2">0</span>
									</div>
								</div>
								<div class="spaceGraph secondSSpaceGraph" id="chart3">
									<canvas id="chart-area3"></canvas>						
								</div>
							</div>
						</div>
					</div>
				</div>
				<div>
					<div class="lineDecoration"></div>
					<div id="spaceForCharts3">
						<div class="lbl" style="padding: 0px;margin-bottom: 5px;">Diagrama de Pareto por Operaci&oacute;n - Costura</div>
						<div class="spaceGraph" style="overflow-x: scroll;">
							<div class="spaceGraph2" id="chart4">
								<canvas id="chart-area4"></canvas>					
							</div>				
						</div>
						<div class="spaceAlign">
							<select class="classSelect" id="selectOperaciones"></select>
						</div>
						<div class="spaceGraph" id="chart5">
							<canvas id="chart-area5"></canvas>
						</div>
					</div>
					<div class="lineDecoration"></div>
					<div id="spaceForCharts4">
						<div class="lbl" style="padding: 0px;margin-bottom: 5px;">Diagrama de Pareto por Defectos</div>
						<div class="spaceGraph" style="overflow-x: scroll;">
							<div class="spaceGraph2" id="chart6">
								<canvas id="chart-area6"></canvas>					
							</div>				
						</div>
						<div class="spaceAlign">
							<select class="classSelect" id="selectDefectos"></select>
						</div>
						<div class="spaceGraph" id="chart7">
							<canvas id="chart-area7"></canvas>
						</div>
					</div>
					<div class="lineDecoration"></div>
					<div id="spaceForCharts4">
						<div class="lbl" style="padding: 0px;margin-bottom: 5px;">Defectos causados - Hombre VS. M&aacute;quina</div>
						<div class="spaceGraph" id="chart8">
							<canvas id="chart-area8"></canvas>
						</div>
						<div class="lbl" style="padding: 0px;margin-bottom: 5px;">Detalle defectos por m&aacute;quina</div>
						<div class="spaceGraph" style="overflow-x: scroll;">
							<div class="spaceGraph2" id="chart9">
								<canvas id="chart-area9"></canvas>					
							</div>				
						</div>
						<div class="spaceAlign">
							<select class="classSelect" id="selectDefectosMaq"></select>
						</div>
						<div class="spaceGraph" id="chart10">
							<canvas id="chart-area10"></canvas>
						</div>
					</div>
				</div>
				<!--
				<div class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;width: 135px;
				padding: 5px;display: flex;padding-left: 20px;" onclick="exportar()">
					<img src="assets/img/excel.png" style="width: 30px;height: 30px;">
					<div style="padding: 5px;width:calc(80px);text-align: center;">Descargar</div>
				</div>
				-->
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var codusu='<?php echo $_SESSION['user-ins']; ?>';
	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" src="js/ReporteInspeccion-1.3.js"></script>
</body>
</html>