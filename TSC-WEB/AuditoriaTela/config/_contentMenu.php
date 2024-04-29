<?php 
	function contentMenu(){
?>	
	<div class="menuContent">
		<div class="spaceMenu">
			<div class="userSpace">
				<img src="assets/img/user.png" class="imgUser">
				<div class="detailUser" style="font-weight: bold; font-size: 13px; padding-bottom: 3px;">
					USUARIO
				</div>
				<div class="detailUser"><?php echo $_SESSION['user'];?></div>
			</div>
			<div class="lineDecoration"></div>
		
		<!--
			<div class="itemsMenu" onclick="redirect('main.php')">Inicio</div>
			<div class="itemsMenu" onclick="redirect('../../dashboard/')">Men&uacute; principal</div>
			<div class="itemsMenu" onclick="redirect('config/logout.php')">Salir</div>
-->

			<div class="itemsMenu" onclick="redirect('../../../dashboard/')">Men&uacute; principal</div>
			<div class="itemsMenu" onclick="redirect('../../../dashboard/logout.php?operacion=logout')">Salir</div>
		

		</div>
	</div>
<?php
	}
	function getAuditorContent(){
?>
	<div class="bodyContent mainBodyContent">		
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('IniciarAuditoriaTela.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REGISTRAR AUDITOR&Iacute;A DE TELA PRINCIPAL</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ListaAAuditar.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">PARTIDAS POR AUDITAR</div>
				</div>
			</div>
		</div>
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ConsultarAuditoriaTela.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">CONSULTAR AUDITOR&Iacute;A DE TELA PRINCIPAL</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ReportePartidas.php')">
					<div class="icon"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTE DE PARTIDAS</div>
				</div>
			</div>
		</div>
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('IniciarAudTelRec.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REGISTRAR AUDITOR&Iacute;A DE TELA RECTILINEO</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ConsultarAudTelRec.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">CONSULTAR AUDITOR&Iacute;A DE TELA RECTILINEO</div>
				</div>
			</div>
		</div>
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('testing-p1.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REGISTRAR ANCHO DE TELA - TESTING</div>
				</div>
			</div>
		</div>
	</div>
<?php
	}
	function getEjecutivoContent(){
?>
	<div class="bodyContent mainBodyContent">		
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ListaASupervisar.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">PARTIDAS POR SUPERVISAR</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('CargarTela.php')">
					<div class="icon"><i class="fa fa-upload" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">CARGAR TELA</div>
				</div>
			</div>
		</div>
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('BuscarTela.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">CONSULTAR / EDITAR TELA</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ConsultarAuditoriaTela.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">CONSULTAR AUDITOR&Iacute;A DE TELA PRINCIPAL</div>
				</div>
			</div>
		</div>
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('SeleccionIndicadorResultado.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">INDICADOR DE RESULTADOS</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('SeleccionRepGen.php')">
					<div class="icon"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTE GENERAL</div>
				</div>
			</div>
		</div>
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ReportePartidas.php')">
					<div class="icon"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTE DE PARTIDAS</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('SeleccionRepBlo.php')">
					<div class="icon"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTE DE ANÁLISIS</div>
				</div>
			</div>
		</div>
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('AgregarTela.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">AGREGAR PARTIDA</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('SeleccionRepDenAnc.php')">
					<div class="icon"><i class="fa fa-area-chart" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTE DENSIDAD Y ANCHO</div>
				</div>
			</div>
		</div>
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('CargarTelaRectilineo.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">AGREGAR TELA RECTILINEO</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ActualizarTelaRectilineo.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">EDITAR TELA RECTILINEO</div>
				</div>
			</div>
		</div>
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('SeleccionIndCon.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">INDICADOR DE CONCESIONADOS</div>
				</div>
			</div>
		</div>
	</div>
<?php
	}
	function getAnaConContent(){
?>
	<div class="bodyContent mainBodyContent">
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ListaAEstCon.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">PROYECCI&Oacute;N DE CAIDA POR ESTUDIO DE CONSUMO</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ConsultarAuditoriaTela.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">CONSULTAR AUDITOR&Iacute;A DE TELA PRINCIPAL</div>
				</div>
			</div>
		</div>
	</div>
<?php
	}
?>