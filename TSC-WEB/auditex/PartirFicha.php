<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="10";
	include("config/_validate_access.php");
	include("config/_contentMenu.php");
?>
<!DOCTYPE html >
<html lang="es">
<head>
	<title>AUDITEX</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/consultaAuditoria.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
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
			<div class="headerTitle">Partir ficha</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">	
			<div class="rowLineFlex">
				<div style="margin-left: 10%;width: 80%;display: flex;">
					<div class="lblNew" style="width: 70px;padding-top: 5px;">Ficha</div>
					<div class="spaceIpt" style="width: calc(100% - 105px);">
						<input type="number" id="idCodFicha" class="iptClass" style="width: calc(100% - 12px);" >
					</div>
					<div class="btnBuscarSpace" style="width: 30px;margin-left: 5px;"><i class="fa fa-search" aria-hidden="true"></i></div>
				</div>
			</div>
			<div class="msgForFichas"></div>
			<div id="idContentTblFichas" style="display: none;">
				<div class="spaceInLine"></div>
				<div class="lblNew" style="width: 100%;">Seleccione ficha a partir</div>
				<div class="rowLine" style="display: block;">
					<div class="tblPrendasDefecto">
						<div class="tblHeader">
							<div class="itemHeader verticalHeader">Ficha</div>							
							<div class="itemHeader">Tipo Auditoria</div>
							<div class="itemHeader verticalHeader">Parte</div>
							<div class="itemHeader verticalHeader">Vez</div>
							<div class="itemHeader verticalHeader">Prendas</div>
						</div>
						<div class="tblBody">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="bodyContent" id="idContentDescription" style="display: none;padding-bottom: 0px;">
			<div class="lineWithDecoration" style="margin-top: 0px;margin-bottom: 10px;width: 100%;margin-left: 0px;"></div>
			<div class="rowLine bodyPrimary">				
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 70px;">Taller</div>
					<div class="spaceIpt" style="width: calc(100% - 70px);">
						<div class="valueRequest" id="idNombreTaller"></div>
					</div>
				</div>		
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 210px;">Ficha</div>
					<div class="spaceIpt" style="width: calc(100% - 210px);">
						<div class="valueRequest" id="idCodFichaText"></div>
					</div>
				</div>
				<div class="rowLineFlex">
					<div class="lblNew" style="width: 210px;">Cantidad de prendas</div>
					<div class="spaceIpt" style="width: calc(100% - 210px);">
						<div class="valueRequest" id="idCantPrendas"></div>
					</div>
				</div>

				

				<div id="divPartir">

					<div class="sameLine" style="width: 100%; margin: 0;">
						<div class="lblNew" style="width: 250px;">Cantidad de prendas de ficha parcial</div>
						<div class="spaceIpt" style="margin-left: calc(100% - 352px); width: 102px;">
							<input type="number" readonly="readonly" id="idNewCantParte" class="iptClass" style="width: calc(100% - 12px);">
						</div>			
					</div>		

					<!-- PARTIR CON TALLA -->
					<div class="sameLine" style="width: 100%; margin: 0;">
						<div class="lblNew" style="width: 250px;">Partir con tallas </div>
						<div class="spaceIpt" style="margin-left: calc(100% - 352px); width: 102px;">
							<input type="checkbox" id="idPartirconTalla" class="iptClass" style="width: calc(100% - 12px);"  checked>
						</div>			
					</div>	

					<div class="sameLine">
						<div class="lblNew" style="width: 210px;">Cantidad a partir:</div>
						<!-- <div class="spaceIpt" style="width: calc(100% - 210px);"> -->
							<!-- <div class="valueRequest" id="idCantPrendas"></div> -->
						<!-- </div> -->
					</div>

					<div class="sameLine">

						<table class="table table-bordered table-hover table-hover" style="width: 100%;">
							<thead >
								<tr>
									<th>Talla</th>
									<th>Cantidad Parcial</th>
									<th>Cantidad Disponible</th>
								</tr>
							</thead>
							<tbody id="tbodytallas">

							</tbody>
						</table>


					</div>

					<div class="sameLine" style="margin-top: 5px;">
						<div class="lbl" style="width: 120px;">Taller:</div>
						<div class="spaceIpt" style="width: calc(100% - 120px);">
							<input type="text" id="idTaller" class="classIpt">
						</div>
					</div>
					<div class="tblSelection">
						<div class="listaTalleres" id="tabla-talleres">
							<div class="classTaller" data-idtaller="" data-nomtaller=""></div>
						</div>
					</div>
					<p style="width: 80%; margin: 10px auto 0 auto;"><b>NOTA:</b> En caso de ser el mismo taller, deje en blanco el nombre del taller.</p>
					<div class="rowLine">
						<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 10px;margin-bottom: 10px;" onclick="partirFicha()">Partir Ficha</button>
					</div>
				</div>
			</div>
		</div>
		<div class="lineWithDecoration" style="margin-left:10px;margin-top: 0px;margin-bottom: 10px; width: calc(100% - 20px);"></div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<!--<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="redirect('main.php')">Terminar</button>-->
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);">Terminar</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript" src="js/index-v1.1.js"></script>
	<!-- <script type="text/javascript" src="js/PartirFicha-v1.0.js"></script> -->
	<script type="text/javascript" src="js/PartirFicha-v2.0.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>