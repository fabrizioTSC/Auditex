<?php 
	function contentMenu(){
?>	
	<div class="menuContent">
		<div class="spaceMenu">
			<div class="userSpace">
				<div class="titleversion"></div>
				<img src="assets/img/user.png" class="imgUser">
				<div class="detailUser" style="font-weight: bold; font-size: 13px; padding-bottom: 3px;">
					<?php 
						if ($_SESSION['perfil']==1) {
							echo "ADMINISTRADOR";
						}else{
							if ($_SESSION['perfil']==2) {
								echo "EJECUTIVO";
							}else{
								if ($_SESSION['perfil']==3) {
									echo "AUDITOR";
								}else{
									echo "CONTROLADOR";
								}
							}
						}
					?>
				</div>
				<div class="detailUser"><?php echo $_SESSION['user'];?></div>
			</div>
			<div class="lineDecoration"></div>
				
			<div class="itemsMenu" onclick="redirect('main.php')">Inicio</div>
			<div class="itemsMenu" onclick="redirect('../../../dashboard/')">Men&uacute; principal</div>
			<div class="itemsMenu" onclick="redirect('../../../dashboard/logout.php?operacion=logout')">Salir</div>
		
						
		</div>
	</div>
<?php
	}
	function getGeneralContent(){
?>
	<div class="bodyContent mainBodyContent" style="padding-top: 10px;">		
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('IniciarAudAca.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">INICIAR AUDITORIA DE ACABADOS</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ConsultarAudAca.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">CONSULTAR AUDITORIA DE ACABADOS</div>
				</div>
			</div>
		</div>		
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ConsultarPorPedido.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">CONSULTAR POR PEDIDO</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('CargarMedidas.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">CARGAR MEDIDAS</div>
				</div>
			</div>
		</div>
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('IniciarVerEmp.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">VERIFICADO POR EMPAQUE</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('IniciarAudMed.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REGISTRAR DE MEDIDAS</div>
				</div>
			</div>
		</div>	
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ConsultaMedidas.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">CONSULTAR MEDIDAS</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ListaCheLisRec.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">CHECK LIST RECHAZADOS</div>
				</div>
			</div>
		</div>
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('SeleccionRepGen.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTE GENERAL</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('SeleccionRepGenVerEmp.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTE GENERAL VERIFICADO EMPAQUE</div>
				</div>
			</div>
		</div>
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('SeleccionIndDef.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">INDICADOR DE DEFECTOS</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('SeleccionIndicadorResultado.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">INDICADOR DE RESULTADOS</div>
				</div>
			</div>
		</div>
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ReporteAuditorFecha.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTE POR AUDITOR Y FECHA</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('ReporteAuditorFechaVerEmp.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">REPORTE POR AUDITOR Y FECHA VERIFICADO DE EMPAQUE ACABADOS</div>
				</div>
			</div>
		</div>
		<div class="rowLine" style="display: flex;">
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('SeleccionIndDefVerEmp.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">INDICADOR DE DEFECTOS VERIFICADO DE EMPAQUE</div>
				</div>
			</div>
			<div class="itemMainContent">
				<div class="bodySpecialButton" onclick="redirect('SeleccionIndicadorResultadoVerEmp.php')">
					<div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
					<div class="detailSpecialButton">INDICADOR DE RESULTADOS VERIFICADO DE EMPAQUE</div>
				</div>
			</div>
		</div>
	</div>
<?php
	}
?>