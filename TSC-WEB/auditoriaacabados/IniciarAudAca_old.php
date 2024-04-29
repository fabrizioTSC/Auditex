<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: ../../dashboard/index.php');
	}
	$appcod="13";
	//include("config/_validate_access.php");
	include("config/_contentMenu.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>AUDITEX</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/AuditoriaMedidas-v1.0.css">
	<style type="text/css">
		.btnPrimary {
			margin: auto;
		}
		.item-maxheight{
			height: 40px;
		}
		.item-c2,.item-c3,.item-c4,.item-c5{
			height: 10px;
		}
		.column-tbl-s2 {
		    width: 142px;
		}
		.item-s2 {
		    width: 130px;
    		font-size: 11px;
		}
		.header-content{
			position: relative;
			z-index: 10;
		}
		.main-content-medida{
			position: relative;
		}
		.link-a{
			text-decoration: underline;
			color: -webkit-link;
		}

		.modal{
			background: rgba(50,50,50,0.6);
			width: 100%;
			height: calc(100vh - 60px);
			padding-top: 60px;
			position: fixed;
			top: 0;
			left: 0;
			z-index: 11;
			font-family: sans-serif;
		}
		.contentEditar{
			max-width: 480px;
			margin: auto;
			cursor: pointer;
		}
	</style>
	<link rel="stylesheet" type="text/css" href="css/chelis.css">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/index-v1.0.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<style type="text/css">
		.itemMainContent{
			height: auto;
			display: flex;
		}
		.bodySpecialButton{
			height: auto;
		}
		.val-lleva{
			margin: 0;
		}
		.th-animate-col{
			background: #ccc;
			color: #000;
		}
		.th-animate-col-sel{
			background: #980f0f;
			color: #fff;
		}
		.iptSpecial{
			width: calc(100% - 17px)!important;
		}
		.class-humedad{
			width: calc(100% - 17px)!important;	
		}
		.mainBodyContent{
			margin-bottom: 90px;
		}
		@media(max-width: 500px){
			.mainBodyContent{
				margin-bottom: 70px;
			}
		}
		h4{
			margin-top: 0;
			margin-bottom: 5px;
		}
	</style>
</head>
<body>
	<div class="modal" id="modal1" style="display: none;">
		<div class="contentEditar">
			<div class="titleContent">Seleccionar encogimiento</div>
			<div class="lineDecoration"></div>
			<div class="bodyEdicion">
			    <table>
			        <thead>
			            <tr>
			                <th>HILO</th>
		                	<th>TRAVEZ</th>
			                <th>LARG. MANGA</th>
		                	<th>OPERACIÓN</th>
			            </tr>
			        </thead>
			        <tbody id="tbl-body">
			        </tbody>
			    </table>
			</div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;" onclick="close_modal('modal1')">Cancerlar</button>
		</div>
	</div>
	<?php contentMenu();?>
	<div class="panelCarga" style="display: none;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Iniciar auditoria acabados</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent" style="padding-top: 10px;">
			<div style="display: flex;">
				<div class="rowLine" style="display: flex;width: auto;">
					<label style="padding: 7px 5px 0 0;">Ficha</label>
					<input type="number" id="codfic" style="width: 100px;">
				</div>
				<div style="display: flex;justify-content: flex-end;width: 100%;">
					<button style="margin: 0;" class="btnPrimary" onclick="window.location.href='ConsultarPorPedido.php';">Cons. Pedido</button>
				</div>
			</div>
			<div id="main-content" style="display: none;">
				<div class="lineDecoration"></div>		
				<div class="rowLineFlex">	
					<div class="rowLineFlex" style="width: 130px;">
						<div class="lblNew" style="width: 60px;">Ficha</div>
						<div class="spaceIpt" style="width: calc(100% - 60px);">
							<div class="valueRequest" id="codficsel"></div>
						</div>
					</div>		
					<div class="rowLineFlex" style="width: 50%;">
						<div class="lblNew" style="width: 60px;">Cant</div>
						<div class="spaceIpt" style="width: calc(100% - 60px);">
							<div class="valueRequest" id="canfic"></div>
						</div>
					</div>
				</div>
				<div id="content-aud" style="display: block;">			
					<div class="rowLineFlex">
						<div class="lblNew" style="width: 130px;">Cliente</div>
						<div class="spaceIpt" style="width: calc(100% - 130px);">
							<div class="valueRequest" id="cliente"></div>
						</div>
					</div>			
					<div class="rowLineFlex">
						<div class="lblNew" style="width: 130px;">Pedido - Color</div>
						<div class="spaceIpt" style="width: calc(100% - 130px);">
							<div class="valueRequest" id="pedido"></div>
						</div>
					</div>
					<div class="rowLineFlex">
						<div class="lblNew" style="width: 130px;">Est TSC - Cliente</div>
						<div class="spaceIpt" style="width: calc(100% - 130px);">
							<div class="valueRequest" id="esttsc"></div>
						</div>
					</div>	
					<div class="rowLineFlex">
						<div class="lblNew" style="width: 130px;">Prenda</div>
						<div class="spaceIpt" style="width: calc(100% - 130px);">
							<div class="valueRequest" id="despre"></div>
						</div>
					</div>	
					<div class="rowLineFlex">
						<div class="spaceIpt" style="width: calc(100% - 145px);">
							<div class="valueRequest" id="audfincor"></div>
						</div>
					</div>			
					<div class="rowLineFlex">
						<div class="spaceIpt" style="width: calc(100% - 145px);">
							<div class="valueRequest" id="audprocos"></div>
						</div>
					</div>		
					<div class="rowLineFlex">
						<div class="spaceIpt" style="width: calc(100% - 145px);">
							<div class="valueRequest" id="audfincos"></div>
						</div>
					</div>			
					<div class="rowLineFlex">
						<div class="lblNew" style="width: 130px;">Taller Corte</div>
						<div class="spaceIpt" style="width: calc(100% - 130px);">
							<div class="valueRequest" id="destllcor"></div>
						</div>
					</div>		
					<div class="rowLineFlex">
						<div class="lblNew" style="width: 130px;">Taller Costura</div>
						<div class="spaceIpt" style="width: calc(100% - 130px);">
							<div class="valueRequest" id="destll"></div>
						</div>
					</div>			
					<div class="rowLineFlex">
						<div class="lblNew" style="width: 130px;">Artículo</div>
						<div class="spaceIpt" style="width: calc(100% - 130px);">
							<div class="valueRequest" id="articulo"></div>
						</div>
					</div>		
					<div class="rowLineFlex">
						<div class="lblNew" style="width: 130px;">Partida</div>
						<div class="spaceIpt" style="width: calc(100% - 130px);">
							<div class="valueRequest" id="partida"></div>
						</div>
					</div>			
					<div class="rowLineFlex">
						<div class="lblNew" style="width: 130px;">Ruta Prenda</div>
						<div class="spaceIpt" style="width: calc(100% - 130px);">
							<div class="valueRequest" id="rutpre"></div>
						</div>
					</div>				
					<div class="rowLineFlex">
						<div class="lblNew" style="width: 130px;">Can acabados</div>
						<div class="spaceIpt" style="width: calc(100% - 130px);">
							<div class="valueRequest" id="canaca"></div>
						</div>
					</div>	
				</div>
				<a onclick="ctrl_header()" id="ctrl-header" style="text-decoration: underline;color: #0089ff;font-size: 12px;">Ocultar detalle ficha</a>
				<div id="detalle-checklist" style="display: none;width: 100%;">
					<div class="lineDecoration"></div>		
					<h4 style="margin: 10px 0 5px 0">Check List</h4>	
					<div class="rowLineFlex">
						<div class="lblNew" style="width: 130px;">Cant Faltante</div>
						<div class="spaceIpt" style="width: calc(100% - 130px);">
							<div class="valueRequest" id="canfal"></div>
						</div>
					</div>
					<div id="iniciar-partevez" style="display: block;">
						<div class="sameLine">
							<div class="lbl" style="width: 120px;">Planta / Servicio:</div>
							<div class="spaceIpt" style="width: calc(100% - 120px);">
								<input type="text" id="idTaller" class="classIpt">
							</div>
						</div>
						<div class="tblSelection" style="margin-bottom: 5px;">
							<div class="listaTalleres" id="tbl-taller">
								<div class="taller"></div>
							</div>
						</div>
						<div id="result-celula" style="display: none;margin-top: 5px;">
							<div class="rowLine bodyPrimary" style="margin-bottom: 5px;">
								<div class="sameLine">
									<div class="lbl" style="width: 120px;">Ingrese célula:</div>
									<div class="spaceIpt" style="width: calc(100% - 120px);">
										<input type="text" id="idCelula" class="classIpt">
									</div>
								</div>
								<div class="tblSelection" style="margin-bottom: 5px;">
									<div class="listaTalleres" id="tbl-celula">
										<div class="taller"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="sameLine">
							<div class="lbl" style="width: 120px;">Cantidad:</div>
							<div class="spaceIpt" style="width: calc(100% - 120px);">
								<input type="number" id="idCanParChecLis" class="classIpt">
							</div>
						</div>
						<center>
							<div class="btnPrimary btnNextPage" style="margin-top: 5px;" onclick="grabar_parte_checklist()">Iniciar</div>
						</center>
						<div class="lbl">Seleccione un parte/vez de la lista</div>			
						<div style="width: 100%;overflow-x: scroll;margin-top: 5px;">
							<table style="min-width:700px;width: 100%;">
								<tbody id="tbl-chelis">
									<tr>
										<th>Planta/Servicio</th>
										<th>Célula</th>
										<th>Parte</th>
										<th>Vez</th>
										<th>Cantidad</th>
										<th>Usuario</th>
										<th>Fec Fin</th>
										<th>Estado</th>
										<th>Resultado</th>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<a onclick="ctrl_partevez()" id="ctrl-partevez" style="text-decoration: underline;color: #0089ff;font-size: 12px;">Ocultar inicio</a>
					<div id="det-chelisparvez" style="display: none;">						
						<div class="lineDecoration"></div>		
						<div id="det-chelisparvez-1" style="display: block;">	
							<div class="rowLineFlex">	
								<div class="rowLineFlex" style="width: calc(50% - 5px);margin-right: 5px;">
									<div class="lblNew" style="width: 80px;">Parte</div>
									<div class="spaceIpt" style="width: calc(100% - 80px);">
										<div class="valueRequest" id="parte-parvez"></div>
									</div>
								</div>		
								<div class="rowLineFlex" style="width: 50%;">
									<div class="lblNew" style="width: 80px;">Vez</div>
									<div class="spaceIpt" style="width: calc(100% - 80px);">
										<div class="valueRequest" id="numvez-parvez"></div>
									</div>
								</div>
							</div>
							<div class="rowLineFlex">	
								<div class="rowLineFlex" style="width: calc(50% - 5px);margin-right: 5px;">
									<div class="lblNew" style="width: 80px;">Usuario</div>
									<div class="spaceIpt" style="width: calc(100% - 80px);">
										<div class="valueRequest" id="codusu-parvez"></div>
									</div>
								</div>	
								<div class="rowLineFlex" style="width: 50%;">
									<div class="lblNew" style="width: 80px;">Fec Inicio</div>
									<div class="spaceIpt" style="width: calc(100% - 80px);">
										<div class="valueRequest" id="feciniaud-parvez"></div>
									</div>
								</div>
							</div>
							<div class="rowLineFlex">	
								<div class="rowLineFlex" style="width: calc(50% - 5px);margin-right: 5px;">
									<div class="lblNew" style="width: 80px;">Prendas</div>
									<div class="spaceIpt" style="width: calc(100% - 80px);">
										<div class="valueRequest" id="cantidad-parvez"></div>
									</div>
								</div>		
								<div class="rowLineFlex" style="width: 50%;">
									<div class="lblNew" style="width: 80px;">Fec Fin</div>
									<div class="spaceIpt" style="width: calc(100% - 80px);">
										<div class="valueRequest" id="fecfinaud-parvez"></div>
									</div>
								</div>
							</div>
							<div class="rowLineFlex">	
								<div class="rowLineFlex" style="width: calc(50% - 5px);margin-right: 5px;">
									<div class="lblNew" style="width: 80px;">Muestreo</div>
									<div class="spaceIpt" style="width: calc(100% - 80px);">
										<div class="valueRequest" id="aql-parvez"></div>
									</div>
								</div>		
								<div class="rowLineFlex" style="width: 50%;">
									<div class="lblNew" style="width: 80px;">Estado</div>
									<div class="spaceIpt" style="width: calc(100% - 80px);">
										<div class="valueRequest" id="estado-parvez"></div>
									</div>
								</div>
							</div>
							<div class="rowLineFlex">	
								<div class="rowLineFlex" style="width: calc(50% - 5px);margin-right: 5px;">
									<div class="lblNew" style="width: 80px;">Max Def</div>
									<div class="spaceIpt" style="width: calc(100% - 80px);">
										<div class="valueRequest" id="candefmax-parvez"></div>
									</div>
								</div>		
								<div class="rowLineFlex" style="width: 50%;">
									<div class="lblNew" style="width: 80px;">Resultado</div>
									<div class="spaceIpt" style="width: calc(100% - 80px);">
										<div class="valueRequest" id="resultado-parvez"></div>
									</div>
								</div>
							</div>	
							<div class="rowLineFlex">
								<div class="lblNew" style="width: 80px;">Planta / Servicio</div>
								<div class="spaceIpt" style="width: calc(100% - 80px);">
									<div class="valueRequest" id="destll-parvez"></div>
								</div>
							</div>	
							<div class="rowLineFlex">
								<div class="lblNew" style="width: 80px;">Célula</div>
								<div class="spaceIpt" style="width: calc(100% - 80px);">
									<div class="valueRequest" id="descel-parvez"></div>
								</div>
							</div>	
						</div>
						<a onclick="ctrl_header_dos()" id="ctrl-header-2" style="text-decoration: underline;color: #0089ff;font-size: 12px;">Ocultar detalle</a>
						<div class="lineDecoration"></div>
						<div style="margin-top: 10px;">
							<a onclick="ctrl_chelisdoc()" id="ctrl-chelisdoc" style="font-weight: bold;">1. Validación de documentación (<span style="text-decoration: underline;color: #0089ff;" id="text-doc">Ocultar</span>)</a>
						</div>
						<div id="chelisdoc" style="display: block;">
							<div id="content-check1">
							</div>
							<div class="lbl">Observaci&oacute;n:</div>
							<div style="width: 100%;">
								<textarea class="textarea-class" id="obs-doc"></textarea>
							</div>
							<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="save_chelisdoc()" id="btn-1">Guardar</button>
						</div>
						<div class="lineDecoration"></div>
						<div style="margin-top: 10px;">
							<a onclick="ctrl_defectos()" id="ctrl-defectos" style="font-weight: bold;">2. Defectos (<span style="text-decoration: underline;color: #0089ff;" id="text-def">Mostrar</span>)</a>
						</div>
						<div id="defectos" style="display: none;">
							<div class="sameLine">
								<div class="lbl" style="width: 120px;">Ingrese defecto:</div>
								<div class="spaceIpt" style="width: calc(100% - 120px);">
									<input type="text" id="defecto" class="classIpt">
								</div>
							</div>
							<div class="tblSelection" style="margin-bottom: 5px;">
								<div class="listaTalleres" id="tbl-defectos">
									<div class="taller"></div>
								</div>
							</div>
							<div class="sameLine">
								<div class="lbl" style="width: 120px;">Cantidad:</div>
								<div class="spaceIpt" style="width: calc(100% - 120px);">
									<input type="number" id="idCanDef" class="classIpt">
								</div>
							</div>
							<center>
								<div class="btnPrimary btnNextPage" style="margin-top: 5px;" onclick="add_defecto()">Añadir</div>
							</center>
							<div style="width: 100%;overflow-x: scroll;margin-top: 5px;">
								<table style="min-width:500px;width: 100%;">
									<tbody id="tbl-det-defectos">
										<tr>
											<th>Familia</th>
											<th>Defecto</th>
											<th>Código Aux</th>
											<th>Cantidad</th>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="lineDecoration"></div>
						<div style="margin-top: 10px;">
							<a onclick="ctrl_acabados()" id="ctrl-acabados" style="font-weight: bold;">3. Proceso de acabados (<span style="text-decoration: underline;color: #0089ff;" id="text-aca">Mostrar</span>)</a>
						</div>
						<div id="acabados-test" style="display: none;">
							<div class="lbl">Seleccione un grupo</div>
							<table>
								<tbody>
									<tr>
										<th class="th-animate-col" id="col-0" onclick="show_grupo(0)">TODOS</th>
										<th class="th-animate-col" id="col-1" onclick="show_grupo(1)">AVIOS</th>
										<th class="th-animate-col" id="col-2" onclick="show_grupo(2)">DOBLADO</th>
										<th class="th-animate-col" id="col-3" onclick="show_grupo(3)">BOLSA</th>
										<th class="th-animate-col" id="col-4" onclick="show_grupo(4)">CAJAS</th>
									</tr>
								</tbody>
							</table>
							<div style="display: flex;justify-content: flex-end;margin-top: 5px;align-items: center;">
								<label>TODOS</label>
								<input type="checkbox" onclick="check_all(this)" style="margin: 5px;">
								<div class="check-content">
									<div class="marker-check" onclick="change_check_all(this)">NO</div>
								</div>
							</div>
							<div style="width: 100%;overflow-x: scroll;margin-top: 5px;">
								<table style="min-width:400px;width: 100%;">
									<tbody id="content-check3">
										<tr>
											<th>Grupo</th>
											<th>Descripción</th>
											<th>Lleva</th>
											<th>Valor</th>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="lbl">Observaci&oacute;n:</div>
							<div style="width: 100%;">
								<textarea class="textarea-class" id="obs-aca"></textarea>
							</div>
							<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="save_acabados()" id="btn-3">Guardar</button>
						</div>
						<div id="acabados" style="display: none;">
							<div class="lbl">Seleccione un grupo</div>
							<table>
								<tbody>
									<tr>
										<th class="th-animate-col" id="col-dos-2" onclick="show_grupo_dos(2)">Avios de costura</th>
										<th class="th-animate-col" id="col-dos-6" onclick="show_grupo_dos(6)">Avios de acabados</th>
										<th class="th-animate-col" id="col-dos-38" onclick="show_grupo_dos(38)">Transfer</th>
									</tr>
								</tbody>
							</table>
							<div style="margin-top: 5px;">
								<div onclick="ctrl_codigo()" style="text-decoration: underline;color: #0089ff;"><span id="text-codigo">Ocultar</span> código</div>
							</div>
							<div style="display: flex;justify-content: flex-end;margin-top: 5px;align-items: center;">
								<label>TODOS</label>
								<div class="check-content">
									<div class="marker-check" onclick="change_check_all_dos(this)">NO</div>
								</div>
							</div>
							<div style="width: 100%;overflow-x: scroll;margin-top: 5px;">
								<table style="min-width:600px;width: 100%;">
									<tbody id="content-check3-dos">
										<tr>
											<th>Tipo Avio</th>
											<th>Talla</th>
											<th>Codigo</th>
											<th>Descripción</th>
											<th>Valor</th>
										</tr>
									</tbody>
								</table>
							</div>							
							<div style="margin-top: 5px;">
								<div class="lblNew" style="width: 100px;margin-right: 5px;">Observación:</div>
								<textarea style="padding: 5px;font-family: sans-serif;width: calc(100% - 12px);" id="idobsaca-dos"></textarea>
							</div>
							<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 5px;" onclick="save_acabados_dos()" id="btn-3">Guardar</button>
						</div>
						<center>
							<div class="btnPrimary btnNextPage" style="margin-top: 5px;" onclick="end_chelis()">Terminar</div>
						</center>
					</div>
				</div>
				<div id="detalle-humedad" style="display: none;">
					<div class="lineDecoration"></div>
					<h4 style="margin: 10px 0 5px 0">Control de Humedad</h4>	
					<div style="display: flex">
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 100px;margin-right: 5px;">Temperatura Amb.:</div>
							<div class="spaceIpt" style="width: calc(100% - 100px);">
								<input type="number" id="idTemAmb" class="iptSpecial">
							</div>
						</div>
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 100px;margin-right: 5px;">Humedad Amb.:</div>
							<div class="spaceIpt" style="width: calc(100% - 100px);">
								<input type="number" id="idHumAmb" class="iptSpecial">
							</div>
						</div>
					</div>
					<div style="display: flex">
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 100px;margin-right: 5px;">Humedad Max.:</div>
							<div class="spaceIpt" style="width: calc(100% - 100px);">
								<input type="number" id="idHumMax" disabled class="iptSpecial">
							</div>
						</div>
					</div>
					<center>
						<button class="btnPrimary" onclick="guardar_datos_cabecera()" style="margin-top: 5px;">Guardar Datos</button>
					</center>
					<div class="lineDecoration"></div>
					<div class="content-table" id="table-main">
						<table>
							<thead>
								<tr>
									<th id="th-h1">ID</th>
									<th id="th-h2">HUMEDAD</th>
								</tr>
							</thead>
							<thead id="table-head-active" style="position: absolute;top: 0;left: 0;">
								<tr>
									<th id="th-h1-r">ID</th>
									<th id="th-h2-r">HUMEDAD</th>
								</tr>
							</thead>
							<tbody id=table-humedad>
								<tr>
									<td><input type="number" value="1" disabled></td>
									<td><input class="class-humedad" data-idreg="1" type="number" value="0"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div style="display: flex;margin-top: 5px;">
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 80px;margin-right: 5px;">Resultado:</div>
							<div class="spaceIpt" style="width: calc(100% - 80px);">
								<select id="idResultado" class="classCmbBox" style="width: calc(100% - 12px);" onchange="validar_obs(this)">
									<option value="A">Aprobado</option>
									<option value="C">Aprobado no conforme</option>
									<option value="R">Rechazado</option>
								</select>
								<!--
								<span id="idResultado"></span>-->
							</div>
						</div>
						<div class="rowLineFlex">
							<div class="lblNew" style="width: 100px;margin-right: 5px;">Promedio:</div>
							<div class="spaceIpt" style="width: 80px;">
								<input type="number" id="idPromedio" class="iptSpecial">
							</div>
						</div>
					</div>
					<center>
						<button class="btnPrimary" onclick="guardar_humedad()" style="margin: auto;margin-top: 10px;">Guardar</button>
					</center>
					<div style="margin-top: 5px; display: none;" id="div-observacion">
						<div class="lblNew" style="width: 100px;margin-right: 5px;">Observación:</div>
						<textarea style="padding: 5px;font-family: sans-serif;width: calc(100% - 12px);" id="idObservacion"></textarea>
					</div>
					<div class="lineDecoration"></div>
					<center>
						<button class="btnPrimary" onclick="terminar_auditora()" style="margin: auto;margin-top: 10px;">Terminar</button>
						<button class="btnPrimary" onclick="volver_inicio()" style="margin: auto;margin-top: 10px;">Volver</button>
					</center>
				</div>
				<div id="detalle-audmed" style="display: none;">
					<div class="lineDecoration"></div>
					<h4 style="margin: 10px 0 5px 0">Verificación de Medidas</h4>
					<div id="links-ver-med" style="display: block;">
						<div id="medcorpro">
						</div>
						<div id="medcorfin">
						</div>
						<div id="medcosfin">
						</div>
						<div id="repmedcorpro">
						</div>
						<div id="repmedcorfin">
						</div>
						<div id="repmedcosfin">
						</div>
					</div>
					<a onclick="ctrl_links()" style="text-decoration: underline;color: #0089ff;font-size: 12px;margin-top: 5px;"><span id="text-links">Ocultar</span> links</a>
					<script type="text/javascript">
						function ctrl_links(){
							if (document.getElementById("links-ver-med").style.display=="block") {
								document.getElementById("links-ver-med").style.display="none";
								document.getElementById("text-links").innerHTML="Mostrar";
							}else{
								document.getElementById("links-ver-med").style.display="block";
								document.getElementById("text-links").innerHTML="Ocultar";
							}
						}
					</script>
					<div id="content-main">
						<div class="sameline">
							<div class="btnPrimary" onclick="generateTable()" style="width: 150px;">Ver marcas</div>
						</div>
						<div class="lineDecoration"></div>	
						<div id="resume-medida" style="display: none;overflow: scroll;max-height: calc(100vh - 185px);position: relative;">
							<div class="tbl-header" id="space-res-hader" style="display: flex;position: relative;z-index: 10;">
							</div>
							<div id="space-tbl-medidas" style="display: flex;position: relative;">
							</div>
						</div>
					</div>
					<div id="second-frame" style="display: none;">
						<div class="title-medida">Talla&nbsp;<span id="talla-select"></span>&nbsp;- Prendas <div class="content-btns-prenda" id="space-btns-prendas"></div></div>
						<div id="space-tbl-generate" style="max-height: calc(100vh - 212px);overflow-y: scroll;position: relative;">
						</div>
						<div class="sameline" style="margin-top: 5px;">
							<div class="btnPrimary" onclick="move_frame(0)" style="width: 100px;margin-right: calc(50% - 100px);">Anterior</div>
							<div class="btnPrimary" onclick="move_frame(1)" style="width: 100px;margin-left: calc(50% - 100px);">Siguiente</div>
						</div>
					</div>
					<div style="display: flex;">
						<label style="font-weight: bold;padding-top: 5px;margin-right: 5px;">Resultado:</label>
						<select class="classCmbBox" id="idResAca" style="margin-top: 5px;width: 150px;">
							<option value="R">Rechazado</option>
							<option value="C">Aprobado no conforme</option>
						</select>
						<span style="padding-top: 5px; " id="idResAcaText">Aprobado</span>
					</div>
					<div style="margin-top: 5px;" id="div-obs-aca">
						<div class="lblNew" style="width: 100px;margin-right: 5px;">Observación:</div>
						<textarea style="padding: 5px;font-family: sans-serif;width: calc(100% - 12px);" id="idObsAca"></textarea>
					</div>
					<div class="btnPrimary" onclick="update_res_aca()" style="width: 100px;" id="btn-end-aca">Guadar</div>
				</div>
			</div>
		</div>
	</div>
	<div class="content-parts-auditoria">
		<div class="body-parts-auditoria">
			<div class="part-auditoria" id="redirect-1" onclick="checklis_acabados()">
				<h4>1</h4>
				<div class="label-part">Check List</div>
			</div>
			<div class="part-auditoria" id="redirect-2" onclick="control_humedad()">
				<h4>2</h4>
				<div class="label-part">Control de Humedad</div>
			</div>
			<div class="part-auditoria" id="redirect-3" onclick="aud_med()">
				<h4>3</h4>
				<div class="label-part">Verificación de Medidas</div>
			</div>
		</div>	
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		var codfic_v='<?php if(isset($_GET['codfic'])){echo $_GET['codfic'];}else{ echo "";} ?>';	
		var chelis_v='<?php if(isset($_GET['chelis'])){echo $_GET['chelis'];}else{ echo "0";} ?>';	
		function show_form(num_form){
			$(".forms-content").css("display","none");
			$("#form-"+num_form).css("display","block");
			var array=document.getElementsByClassName("part-auditoria");
			for (var i = 0; i < array.length; i++) {
				array[i].classList.remove("part-active");
			}
			document.getElementById("redirect-"+num_form).classList.add("part-active");
		}
		var show_codigo=true;
		function ctrl_codigo(){
			if (show_codigo) {
				show_codigo=false;
				$("#text-codigo").text("Mostrar");
			}else{
				show_codigo=true;
				$("#text-codigo").text("Ocultar");
			}
			controlar_tbl_codigo();
		}
		function controlar_tbl_codigo(){
			let ar=document.getElementsByClassName("td-for-control");
			if (show_codigo) {
				for (var i = 0; i < ar.length; i++) {
					ar[i].style.display="table-cell";
				}
			}else{
				for (var i = 0; i < ar.length; i++) {
					ar[i].style.display="none";
				}
			}
		}
		$(document).ready(function(){
			get_talleres();
			get_celulas();
			get_defectos();
			$("#defecto").keyup(function(){
				coddef_v='';
				var html='';
				for (var i = 0; i < ar_defectos.length; i++) {
					let des=ar_defectos[i].CODDEF+' - '+ar_defectos[i].DESDEF+' ('+ar_defectos[i].CODDEFAUX+')';
					if (des.toUpperCase().indexOf($("#defecto").val().toUpperCase())>=0) {
						html+='<div class="taller" onclick="select_defecto(\''+ar_defectos[i].CODDEF+'\',\''+des+'\')">'+des+'</div>';
					}
				}
				document.getElementById("tbl-defectos").innerHTML=html;
			});
			$("#idTaller").keyup(function(){
				codtll_v='';
				codtipser_v='';
				var html='';
				for (var i = 0; i < ar_talleres.length; i++) {
					if (ar_talleres[i].DESTLL.indexOf($("#idTaller").val().toUpperCase())>=0) {
						html+='<div class="taller" onclick="select_taller(\''+ar_talleres[i].CODTLL+'\',\''+ar_talleres[i].DESTLL+'\',\''+ar_talleres[i].CODTIPSER+'\')">'+
						ar_talleres[i].DESTLL+'</div>';				
					}
				}
				document.getElementById("tbl-taller").innerHTML=html;
			});
			$("#idCelula").keyup(function(){
				codcel_v='';
				var html='';
				for (var i = 0; i < ar_celula.length; i++) {
					if (ar_celula[i].DESTLL.indexOf($("#idCelula").val().toUpperCase())>=0) {
						html+='<div class="taller" onclick="select_celula(\''+ar_celula[i].CODTLL+'\',\''+ar_celula[i].DESTLL+'\')">'+
						ar_celula[i].DESTLL+'</div>';				
					}
				}
				document.getElementById("tbl-celula").innerHTML=html;
			});
			$("#space-tbl-generate").scroll(function(){
				var des=$("#space-tbl-generate").scrollTop();
				if (des>20) {
					$(".header-content").css("position","absolute");
					$(".header-content").css("top",des+"px");
				}else{
					$(".header-content").css("position","relative");
					$(".header-content").css("top","0px");
				}
				let desH=$("#space-tbl-generate").scrollLeft();
				if (desH>50) {
					$(".column-tbl-static").css("position","absolute");
					$(".column-tbl-static").css("left",desH+"px");
				}else{
					$(".column-tbl-static").css("position","relative");
					$(".column-tbl-static").css("left","0px");
				}
			});
			$("#resume-medida").scroll(function(){
				var des=$("#resume-medida").scrollTop();
				if (des>20) {
					$("#space-res-hader").css("position","absolute");
					$("#space-res-hader").css("top",$("#resume-medida").scrollTop()+"px");
				}else{
					$("#space-res-hader").css("position","relative");
					$("#space-res-hader").css("top","0px");
				}
			});

			if (codfic_v!=""){
				$("#codfic").val(codfic_v);
				if (chelis_v=="1") {
					checklis_acabados();
				}
			}
		});
		var codtll_v='';
		var codtipser_v='';
		function select_taller(codtll,destll,codtipser){
			codtll_v=codtll;
			codtipser_v=codtipser;
			$("#idTaller").val(destll);
			if (codtipser=="1") {
				document.getElementById("result-celula").style.display="block";
			}else{
				document.getElementById("result-celula").style.display="none";
			}
			$("#idCelula").val("");
			$("#idCelula").keyup();
		}
		var ar_defectos=[];
		function get_defectos(){
			$.ajax({
				type:"POST",
				url:"config/getDefectos.php",
				success:function(data){
					console.log(data);
					ar_defectos=data.defectos;
					var html='';
					for (var i = 0; i < ar_defectos.length; i++) {
						let des=ar_defectos[i].CODDEF+' - '+ar_defectos[i].DESDEF+' ('+ar_defectos[i].CODDEFAUX+')';
						html+='<div class="taller" onclick="select_defecto(\''+ar_defectos[i].CODDEF+'\',\''+des+'\')">'+des+'</div>';
					}
					document.getElementById("tbl-defectos").innerHTML=html;
				}
			});	
		}
		var ar_celula=[];
		function get_celulas(){
			$.ajax({
				type:"POST",
				url:"config/getCelulas.php",
				success:function(data){
					console.log(data);
					ar_celula=data.celula;
					var html='';
					for (var i = 0; i < ar_celula.length; i++) {
						html+='<div class="taller" onclick="select_celula(\''+ar_celula[i].CODTLL+'\',\''+ar_celula[i].DESTLL+'\')">'+
						ar_celula[i].DESTLL+'</div>';				
					}
					document.getElementById("tbl-celula").innerHTML=html;
				}
			});	
		}
		var ar_talleres=[];
		function get_talleres(){
			$.ajax({
				type:"POST",
				url:"config/getTalleres.php",
				success:function(data){
					console.log(data);
					ar_talleres=data.talleres;
					var html='';
					for (var i = 0; i < ar_talleres.length; i++) {
						html+='<div class="taller" onclick="select_taller(\''+ar_talleres[i].CODTLL+'\',\''+ar_talleres[i].DESTLL+'\',\''+ar_talleres[i].CODTIPSER+'\')">'+
						ar_talleres[i].DESTLL+'</div>';				
					}
					document.getElementById("tbl-taller").innerHTML=html;
				}
			});
		}
		var coddef_v='';
		function select_defecto(coddef,desdef){
			coddef_v=coddef;
			document.getElementById("defecto").value=desdef;
		}
		var codcel_v='';
		function select_celula(codcel,descel){
			codcel_v=codcel;
			$("#idCelula").val(descel);	
		}
		function ctrl_header(){
			if(document.getElementById("content-aud").style.display=="none"){
				document.getElementById("content-aud").style.display="block";
				document.getElementById("ctrl-header").innerHTML="Ocultar detalle Ficha";
			}else{
				document.getElementById("content-aud").style.display="none";
				document.getElementById("ctrl-header").innerHTML="Mostrar detalle ficha";
			}
		}
		function ctrl_partevez(){
			if(document.getElementById("iniciar-partevez").style.display=="none"){
				document.getElementById("iniciar-partevez").style.display="block";
				document.getElementById("ctrl-partevez").innerHTML="Ocultar inicio";
			}else{
				document.getElementById("iniciar-partevez").style.display="none";
				document.getElementById("ctrl-partevez").innerHTML="Mostrar inicio";
			}
		}
		function ctrl_header_dos(){
			if(document.getElementById("det-chelisparvez-1").style.display=="none"){
				document.getElementById("det-chelisparvez-1").style.display="block";
				document.getElementById("ctrl-header-2").innerHTML="Ocultar detalle";
			}else{
				document.getElementById("det-chelisparvez-1").style.display="none";
				document.getElementById("ctrl-header-2").innerHTML="Mostrar detalle";
			}
		}
		function ctrl_chelisdoc(){
			if(document.getElementById("chelisdoc").style.display=="none"){
				document.getElementById("chelisdoc").style.display="block";
				document.getElementById("text-doc").innerHTML="Ocultar";
			}else{
				document.getElementById("chelisdoc").style.display="none";
				document.getElementById("text-doc").innerHTML="Mostrar";
			}
		}
		function ctrl_defectos(){
			if(document.getElementById("defectos").style.display=="none"){
				document.getElementById("defectos").style.display="block";
				document.getElementById("text-def").innerHTML="Ocultar";
			}else{
				document.getElementById("defectos").style.display="none";
				document.getElementById("text-def").innerHTML="Mostrar";
			}
		}
		function ctrl_acabados(){
			if(document.getElementById("acabados").style.display=="none"){
				document.getElementById("acabados").style.display="block";
				document.getElementById("text-aca").innerHTML="Mostrar";
			}else{
				document.getElementById("acabados").style.display="none";
				document.getElementById("text-aca").innerHTML="Mostrar";
			}
		}
		var header_visible=false;
		function show_header(){
			if (document.getElementById("codficsel").innerHTML==$("#codfic").val()) {
				return;
			}
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/getInfoAcabados-v2.php',
				data:{
					codfic:$("#codfic").val()
				},
				success:function(data){
					console.log(data);
					document.getElementById("codficsel").innerHTML=$("#codfic").val();
					document.getElementById("cliente").innerHTML=data.CLIENTE;
					document.getElementById("pedido").innerHTML=data.PEDIDO+' - '+data.COLOR;
					document.getElementById("esttsc").innerHTML=data.ESTTSC+' - '+data.ESTCLI;
					document.getElementById("despre").innerHTML=data.DESPRE;
					document.getElementById("audfincor").innerHTML='<a href="../AuditoriaFinalCorte/ConsultarEditarAuditoria.php?codfic='+$("#codfic").val()+'">Aud. Final de Corte</a>';
					document.getElementById("audprocos").innerHTML='<a href="../auditoriaproceso/ConsultarEditarAuditoriaProceso.php?codfic='+$("#codfic").val()+'">Aud. Proceso de Costura</a>';
					document.getElementById("audfincos").innerHTML='<a href="../auditex/ConsultarEditarAuditoria.php?codfic='+$("#codfic").val()+'">Aud. Final de Costura</a>';
					document.getElementById("destllcor").innerHTML=data.TALLERCOR;
					document.getElementById("destll").innerHTML=data.TALLERCOS;
					document.getElementById("articulo").innerHTML=data.ARTICULO;
					document.getElementById("partida").innerHTML=data.PARTIDA;
					document.getElementById("rutpre").innerHTML=get_rutaprenda(data.ruta);
					document.getElementById("canfic").innerHTML=data.CANFIC;
					document.getElementById("canaca").innerHTML=data.CANACA;
					header_visible=true;
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function get_rutaprenda(data){
			let ruta='';
			for (var i = 0; i < data.length; i++) {
				ruta+=data[i].CODETAPA+' - '+data[i].ETAPA;
				if (i!=data.length-1) {
					ruta+=' | ';
				}
			}
			return ruta;
		}
		var canfal_v='';
		function checklis_acabados(){
			if ($("#codfic").val()=="") {
				alert("Complete la ficha");
				return;
			}
			document.getElementById("det-chelisparvez").style.display="none";
			document.getElementById("defectos").style.display="none";
			document.getElementById("acabados").style.display="none";
			document.getElementById("chelisdoc").style.display="none";
			document.getElementById("detalle-checklist").style.display="none";
			document.getElementById("detalle-humedad").style.display="none";
			document.getElementById("detalle-audmed").style.display="none";
			document.getElementById("main-content").style.display="none";
			document.getElementById("content-aud").style.display="block";
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/getInfoCheLis.php',
				data:{
					codfic:$("#codfic").val()
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						document.getElementById("canfal").innerHTML=data.CANFAL;
						fill_tblchelis(data.audchelis);
						canfal_v=data.CANFAL;
						$(".panelCarga").fadeOut(100);
						document.getElementById("chelisdoc").style.display="block";
						document.getElementById("detalle-checklist").style.display="block";
						document.getElementById("main-content").style.display="block";
						show_header();
						ctrl_header();
						show_form(1);
					}else{
						alert(data.detail);
						$(".panelCarga").fadeOut(100);
					}
				}
			});
		}
		function grabar_parte_checklist(){
			if (codtipser_v=='1' && codcel_v=='') {
				alert("Debe seleccionar una célula");
				return;
			}
			if (codtll_v=='') {
				alert("Debe seleccionar una Planta/Servicio");
				return;	
			}
			if ($("#idCanParChecLis").val()=='') {
				alert("Debe agregar una cantidad");
				return;	
			}
			if (parseInt($("#idCanParChecLis").val())>parseInt(canfal_v)) {
				alert("La cantidad debe ser menor al faltante");
				return;	
			}
			if (parseInt($("#idCanParChecLis").val())<=0) {
				alert("La cantidad debe ser mayor a cero");
				return;	
			}
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/saveParteCheLis.php',
				data:{
					codfic:$("#codfic").val(),
					cantidad:$("#idCanParChecLis").val(),
					codtll:codtll_v,
					codtipser:codtipser_v,
					codcel:codcel_v
				},
				success:function(data){
					console.log(data);
					if (!data.state) {
						alert(data.detail);
					}else{
						fill_tblchelis(data.audchelis);
						let i=data.audchelis.length-1;
						show_chelisparvez(data.audchelis[i].PARTE,data.audchelis[i].NUMVEZ);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function val_null(text){
			if (text==null) {
				return '';
			}else{
				return text;
			}
		}
		function fill_tblchelis(data){
			let html='<tr>'+
						'<th>Planta/Servicio</th>'+
						'<th>Célula</th>'+
						'<th>Parte</th>'+
						'<th>Vez</th>'+
						'<th>Cantidad</th>'+
						'<th>Usuario</th>'+
						'<th>Fec Fin</th>'+
						'<th>Estado</th>'+
						'<th>Resultado</th>'+
					'</tr>';
			for (var i = 0; i < data.length; i++) {
				html+='<tr onclick="show_chelisparvez(\''+data[i].PARTE+'\',\''+data[i].NUMVEZ+'\')">'+
						'<td>'+data[i].DESTLL+'</td>'+
						'<td>'+data[i].DESCEL+'</td>'+
						'<td>'+data[i].PARTE+'</td>'+
						'<td>'+data[i].NUMVEZ+'</td>'+
						'<td>'+data[i].CANTIDAD+'</td>'+
						'<td>'+val_null(data[i].CODUSU)+'</td>'+
						'<td>'+val_null(data[i].FECFINAUD)+'</td>'+
						'<td>'+data[i].ESTADO+'</td>'+
						'<td>'+val_null(data[i].RESULTADO)+'</td>'+
					'</tr>';
			}
			document.getElementById("tbl-chelis").innerHTML=html;
		}
		var parte_v='';
		var numvez_v='';
		function show_chelisparvez(parte,numvez){
			parte_v=parte;
			numvez_v=numvez;
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/getDetCheLisPartVez.php',
				data:{
					codfic:$("#codfic").val(),
					parte:parte,
					numvez:numvez
				},
				success:function(data){
					console.log(data);
					ctrl_partevez();
					document.getElementById("parte-parvez").innerHTML=data.PARTE;
					document.getElementById("numvez-parvez").innerHTML=data.NUMVEZ;
					document.getElementById("destll-parvez").innerHTML=data.DESTLL;
					document.getElementById("codusu-parvez").innerHTML=data.CODUSU;
					document.getElementById("descel-parvez").innerHTML=data.DESCEL;
					document.getElementById("feciniaud-parvez").innerHTML=data.FECINIAUD;
					document.getElementById("cantidad-parvez").innerHTML=data.CANTIDAD;
					document.getElementById("fecfinaud-parvez").innerHTML=data.FECFINAUD;
					document.getElementById("aql-parvez").innerHTML="AQL "+data.AQL+"% ("+data.CANAUD+" prendas)";
					document.getElementById("estado-parvez").innerHTML=data.ESTADO;
					document.getElementById("candefmax-parvez").innerHTML=data.CANDEFMAX;
					document.getElementById("resultado-parvez").innerHTML=data.RESULTADO;
					document.getElementById("obs-doc").innerHTML=data.OBSDOC;
					document.getElementById("idobsaca-dos").innerHTML=data.OBSPRO;
					fill_defectos(data.defectos);
					document.getElementById("det-chelisparvez").style.display="block";
					let html='';
					for (var i = 0; i < data.chelisdoc.length; i++) {
						html+=
						'<div class="sameline">'+
							'<div class="lbl-form">'+data.chelisdoc[i].DESCLDOC+'</div>'+
							'<div class="check-content">'+
								'<div class="marker-check anicheblo1" onclick="change_check1(this)" id="cheblo1-'+data.chelisdoc[i].CODCLDOC+'">NO</div>'+
							'</div>'+
						'</div>';
					}
					document.getElementById("content-check1").innerHTML=html;

					for (var i = 0; i < data.chelisdoc.length; i++) {
						if (data.chelisdoc[i].VALOR=="1") {
							document.getElementById("cheblo1-"+data.chelisdoc[i].CODCLDOC).click();
						}
					}

					html=
					'<tr>'+
						'<th>Grupo</th>'+
						'<th>Descripción</th>'+
						'<th>Lleva</th>'+
						'<th>Valor</th>'+
					'</tr>';
					for (var i = 0; i < data.chelisaca.length; i++) {
						html+=
						'<tr class="fila-val" data-codgrp="'+data.chelisaca[i].CODGRPCLPRO+'" style="display:none;" id="fila-lleva-'+data.chelisaca[i].CODCLPRO+'">'+
							'<td>'+data.chelisaca[i].DESGRPCLPRO+'</td>'+
							'<td>'+data.chelisaca[i].DESCLPRO+'</td>'+
							'<td><input class="val-lleva" type="checkbox" onclick="val_lleva_aca(this)" id="lleva-'+data.chelisaca[i].CODCLPRO+'"/></td>'+
							'<td>'+
								'<div class="check-content" style="display:none;" id="aca-cheblo3-'+data.chelisaca[i].CODCLPRO+'">'+
									'<div class="marker-check anicheblo3" onclick="change_check1(this)" id="cheblo3-'+data.chelisaca[i].CODCLPRO+'">NO</div>'+
								'</div>'+
							'</td>'+
						'</tr>';
					}
					document.getElementById("content-check3").innerHTML=html;

					for (var i = 0; i < data.chelisaca.length; i++) {
						if (data.chelisaca[i].LLEVA=="1") {
							document.getElementById("lleva-"+data.chelisaca[i].CODCLPRO).click();
						}
						if (data.chelisaca[i].VALOR=="1") {
							document.getElementById("cheblo3-"+data.chelisaca[i].CODCLPRO).click();
						}
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}		
		function change_check1(dom){
			var text=dom.innerHTML;
			if (text=="NO") {
				text="SI";
				dom.style.background="#55840b";
				dom.dataset.value="1";
				dom.style.left="20px";
			}else{
				text="NO";
				dom.style.background="#980f0f";
				dom.dataset.value="0";
				dom.style.left="0px";
			}
			dom.innerHTML=text;
		}		
		function change_check1_dos(dom){
			var text=dom.innerHTML;
			if (text=="NO") {
				text="SI";
				dom.style.background="#55840b";
				dom.dataset.value="1";
				dom.style.left="20px";
			}else{
				text="NO";
				dom.style.background="#980f0f";
				dom.dataset.value="0";
				dom.style.left="0px";
			}
			dom.innerHTML=text;
		}	
		function change_check_all(dom){
			var text=dom.innerHTML;
			let ar=document.getElementsByClassName("anicheblo3");
			if (text=="NO") {
				text="SI";
				dom.style.background="#55840b";
				dom.style.left="20px";
				for (var i = 0; i < ar.length; i++) {
					let id=ar[i].id.replace("cheblo3-","");
					if (document.getElementById("fila-lleva-"+id).style.display!="none") {
						if (ar[i].innerHTML=="NO") {
							change_check1(ar[i]);
						}
					}	
				}
			}else{
				text="NO";
				dom.style.background="#980f0f";
				dom.style.left="0px";
				for (var i = 0; i < ar.length; i++) {
					let id=ar[i].id.replace("cheblo3-","");
					if (document.getElementById("fila-lleva-"+id).style.display!="none") {
						if (ar[i].innerHTML=="SI") {
							change_check1(ar[i]);
						}	
					}		
				}
			}
			dom.innerHTML=text;
		}
		function change_check_all_dos(dom){
			var text=dom.innerHTML;
			let ar=document.getElementsByClassName("anicheblo3-dos");
			if (text=="NO") {
				text="SI";
				dom.style.background="#55840b";
				dom.style.left="20px";
				for (var i = 0; i < ar.length; i++) {
					let id=ar[i].id.replace("cheblo3-dos-","");
					if (ar[i].innerHTML=="NO") {
						change_check1_dos(ar[i]);
					}
				}
			}else{
				text="NO";
				dom.style.background="#980f0f";
				dom.style.left="0px";
				for (var i = 0; i < ar.length; i++) {
					let id=ar[i].id.replace("cheblo3-dos-","");
					if (ar[i].innerHTML=="SI") {
						change_check1_dos(ar[i]);
					}	
				}
			}
			dom.innerHTML=text;
		}
		function val_lleva_aca(dom){
			let id=dom.id.replace("lleva-","");
			if (dom.checked) {
				document.getElementById("aca-cheblo3-"+id).style.display="block";
			}else{
				document.getElementById("aca-cheblo3-"+id).style.display="none";
			}
		}
		function check_all(dom){
			let ar=document.getElementsByClassName("val-lleva");
			if (dom.checked) {
				for (var i = 0; i < ar.length; i++) {
					let id=ar[i].id.replace("lleva-","");
					if (document.getElementById("fila-lleva-"+id).style.display!="none") {
						if(!ar[i].checked){
							ar[i].checked=true;
							val_lleva_aca(ar[i]);
						}
					}
				}
			}else{
				for (var i = 0; i < ar.length; i++) {
					let id=ar[i].id.replace("lleva-","");
					if (document.getElementById("fila-lleva-"+id).style.display!="none") {
						if(ar[i].checked){
							ar[i].checked=false;
							val_lleva_aca(ar[i]);
						}
					}
				}
			}				
		}
		function save_chelisdoc(){
			let ar=document.getElementsByClassName("anicheblo1");
			let ar_send=[];
			for (var i = 0; i < ar.length; i++) {
				let aux=[];
				aux.push(ar[i].id.replace("cheblo1-",""));
				let text=ar[i].innerHTML;
				if (text=="NO") {
					aux.push("0");
				}else{
					aux.push("1");
				}
				ar_send.push(aux);
			}
			console.log(ar_send);
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/saveCheLisDoc.php',
				data:{
					codfic:$("#codfic").val(),
					parte:parte_v,
					numvez:numvez_v,
					obs:document.getElementById("obs-doc").value,
					array:ar_send
				},
				success:function(data){
					console.log(data);
					if (!data.state) {
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function add_defecto(){
			if (document.getElementById("idCanDef").value=="") {
				alert("Debe añadir una cantidad de defecto");
				return;
			}
			if (coddef_v=="") {
				alert("Debe seleccionar un defecto");
				return;
			}
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/saveCheLisDef.php',
				data:{
					codfic:$("#codfic").val(),
					parte:parte_v,
					numvez:numvez_v,
					coddef:coddef_v,
					candef:document.getElementById("idCanDef").value
				},
				success:function(data){
					console.log(data);
					if (!data.state) {
						alert(data.detail);
					}else{
						$("#defecto").val("");
						$("#defecto").keyup();
						$("#idCanDef").val("");
						fill_defectos(data.defectos);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function fill_defectos(data){
			let html=
			'<tr>'+
				'<th>Familia</th>'+
				'<th>Defecto</th>'+
				'<th>Código Aux</th>'+
				'<th>Cantidad</th>'+
			'</tr>';
			for (var i = 0; i < data.length; i++) {
				html+=
				'<tr>'+
					'<td>'+data[i].DESFAM+'</td>'+
					'<td>'+data[i].DESDEF+'</td>'+
					'<td>'+data[i].CODDEFAUX+'</td>'+
					'<td>'+
						'<div style="display:flex;">'+
							'<span style="padding:5px;">'+data[i].CANDEF+'</span>'+
							'<div style="display: flex;justify-content: flex-end;padding-left: 5px;width: calc(100% - 18px);">'+
								'<button onclick="update_def(-1,\''+data[i].CODDEF+'\')" style="margin-right: 5px;"><i class="fa fa-minus" aria-hidden="true"></i></button>'+
								'<button onclick="update_def(1,\''+data[i].CODDEF+'\')"><i class="fa fa-plus" aria-hidden="true"></i></button>'+
							'</div>'+
						'</td>'+
					'</td>'+
				'</tr>';				
			}
			document.getElementById("tbl-det-defectos").innerHTML=html;
		}
		function update_def(value,coddef){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/updateCheLisDef.php',
				data:{
					codfic:$("#codfic").val(),
					parte:parte_v,
					numvez:numvez_v,
					coddef:coddef,
					candef:value
				},
				success:function(data){
					console.log(data);
					if (!data.state) {
						alert(data.detail);
					}else{
						fill_defectos(data.defectos);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function end_chelis(){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/endCheLis.php',
				data:{
					codfic:$("#codfic").val(),
					parte:parte_v,
					numvez:numvez_v
				},
				success:function(data){
					console.log(data);
					if (!data.state) {
						alert(data.detail);
					}else{
						checklis_acabados();
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function show_grupo(id){
			let ar1=document.getElementsByClassName("th-animate-col");
			for (var i = 0; i < ar1.length; i++) {
				ar1[i].classList.remove("th-animate-col-sel");
			}
			document.getElementById("col-"+id).classList.add("th-animate-col-sel");
			let ar=document.getElementsByClassName("fila-val");
			if (id==0) {
				for (var i = 0; i < ar.length; i++) {
					ar[i].style.display="table-row";
				}
			}else{
				for (var i = 0; i < ar.length; i++) {
					if(ar[i].dataset.codgrp==id){
						ar[i].style.display="table-row";
					}else{
						ar[i].style.display="none";
					}
				}
			}
		}
		function show_grupo_dos(id){
			let ar1=document.getElementsByClassName("th-animate-col");
			for (var i = 0; i < ar1.length; i++) {
				ar1[i].classList.remove("th-animate-col-sel");
			}
			document.getElementById("col-dos-"+id).classList.add("th-animate-col-sel");
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/getGrupoProAca.php',
				data:{
					codfic:$("#codfic").val(),
					parte:parte_v,
					numvez:numvez_v,
					codavio:id
				},
				success:function(data){
					console.log(data);
					if (!data.state) {
						alert(data.detail);
					}else{
						html=
						'<tr>'+
							'<th>Tipo Avio</th>'+
							'<th>Talla</th>'+
							'<th class="td-for-control">Codigo</th>'+
							'<th>Descripción</th>'+
							'<th>Valor</th>'+
						'</tr>';
						for (var i = 0; i < data.chelisavi.length; i++) {
							html+=
							'<tr>'+
								'<td>'+data.chelisavi[i].TIPOAVIO+'</td>'+
								'<td>'+data.chelisavi[i].TALLA+'</td>'+
								'<td class="td-for-control">'+data.chelisavi[i].CODAVIO+'</td>'+
								'<td>'+data.chelisavi[i].DESITEM+'</td>'+
								'<td>'+
									'<div class="check-content">'+
										'<div class="marker-check anicheblo3-dos" onclick="change_check1_dos(this)" id="cheblo3-dos-'+data.chelisavi[i].CODAVIO+'" data-ta="'+data.chelisavi[i].TIPOAVIO+'">NO</div>'+
									'</div>'+
								'</td>'+
							'</tr>';
						}
						document.getElementById("content-check3-dos").innerHTML=html;
						for (var i = 0; i < data.chelisavi.length; i++) {
							if (data.chelisavi[i].VALOR=="1") {
								change_check1_dos(document.getElementById("cheblo3-dos-"+data.chelisavi[i].CODAVIO));
							}
						}
						controlar_tbl_codigo();
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function save_acabados(){
			let ar=document.getElementsByClassName("anicheblo3");
			let ar_send=[];
			for (var i = 0; i < ar.length; i++) {
				let aux=[];
				let id=ar[i].id.replace("cheblo3-","");
				aux.push(id);
				if (document.getElementById("lleva-"+id).checked) {
					aux.push("1");
					let text=ar[i].innerHTML;
					if (text=="NO") {
						aux.push("0");
					}else{
						aux.push("1");
					}
				}else{
					aux.push("0");
					aux.push("0");
				}
				ar_send.push(aux);
			}
			console.log(ar_send);
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/saveCheLisAca.php',
				data:{
					codfic:$("#codfic").val(),
					parte:parte_v,
					numvez:numvez_v,
					obs:document.getElementById("obs-aca").value,
					array:ar_send
				},
				success:function(data){
					console.log(data);
					if (!data.state) {
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}		
		function save_acabados_dos(){
			let ar=document.getElementsByClassName("anicheblo3-dos");
			let ar_send=[];
			for (var i = 0; i < ar.length; i++) {
				let aux=[];
				let id=ar[i].id.replace("cheblo3-dos-","");
				aux.push(id);
				let text=ar[i].innerHTML;
				if (text=="NO") {
					aux.push("0");
				}else{
					aux.push("1");
				}
				aux.push(ar[i].dataset.ta);
				ar_send.push(aux);
			}
			console.log(ar_send);
			/*if (ar_send.length==0) {
				alert("No hay avios para guardar");
				return;
			}*/
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/saveCheLisAca-v2.php',
				data:{
					codfic:$("#codfic").val(),
					parte:parte_v,
					numvez:numvez_v,
					array:ar_send,
					obs:document.getElementById("idobsaca-dos").value
				},
				success:function(data){
					console.log(data);
					if (!data.state) {
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function function_process_num(humedad){
			if (humedad==0) {
				return "";
			}else{
				return humedad;
			}
		}
		function validar_obs(dom){
			if (dom.value=="C") {
				document.getElementById("div-observacion").style.display="block";
			}else{
				document.getElementById("div-observacion").style.display="none";
				document.getElementById("idObservacion").value="";
			}
		}
		document.getElementById("th-h1-r").style.width=(document.getElementById("th-h1").offsetWidth+5)+"px";
		document.getElementById("th-h2-r").style.width=(document.getElementById("th-h2").offsetWidth-5)+"px";
		document.getElementById("table-main").addEventListener("scroll",function(){
			document.getElementById("table-head-active").style.top=document.getElementById("table-main").scrollTop+"px";
		});
		var codtad_v='';
		var parte_v='';
		var numvez_v='';
		function control_humedad(){
			if ($("#codfic").val()=="") {
				alert("Complete la ficha");
				return;
			}
			document.getElementById("detalle-checklist").style.display="none";
			document.getElementById("detalle-humedad").style.display="none";
			document.getElementById("detalle-audmed").style.display="none";
			document.getElementById("main-content").style.display="none";
			document.getElementById("div-observacion").style.display="none";
			document.getElementById("content-aud").style.display="block";			
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/getDetalleFichaACH.php',
				data:{
					codfic:$("#codfic").val()
				},
				success:function(data){
					console.log(data);
					if (data.close) {
						$(".panelCarga").fadeOut(100);
						alert("La ficha ya fue terminada!");
					}
					if (data.state) {
						codtad_v=data.detficaud.codtad;
						parte_v=data.detficaud.numvez;
						numvez_v=data.detficaud.parte;

						canaudter=parseInt(data.ficha.CANTIDAD);
						let html='';
						for (var i = 0; i < data.detalle_humedad.length; i++) {
							html+=
							'<tr>'+
								'<td><input type="number" value="'+data.detalle_humedad[i].IDREG+'" disabled></td>'+
								'<td><input class="class-humedad" data-idreg="'+data.detalle_humedad[i].IDREG+'" type="number" value="'+function_process_num(data.detalle_humedad[i].HUMEDAD)+'"></td>'+
							'</tr>';
						}
						document.getElementById("table-humedad").innerHTML=html;
						document.getElementById("idTemAmb").value=data.TEMAMB;
						document.getElementById("idHumAmb").value=data.HUMAMB;
						document.getElementById("idHumMax").value=data.HUMMAX;
						document.getElementById("idResultado").value=data.RESULTADO;
						document.getElementById("div-observacion").style.display="block";
						document.getElementById("idObservacion").value=data.OBS;
						document.getElementById("idPromedio").value=data.HUMPRO;

						$(".panelCarga").fadeOut(100);
						document.getElementById("detalle-humedad").style.display="block";
						document.getElementById("main-content").style.display="block";
						show_header();
						ctrl_header();
						show_form(2);
					}else{
						$(".panelCarga").fadeOut(300);
						alert(data.detail);
					}
				}
			});
		}
		function guardar_datos_cabecera(){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				data:{
					codfic:document.getElementById("codficsel").innerHTML,
					codtad:codtad_v,
					numvez:numvez_v,
					parte:parte_v,
					temamb:Math.round(parseFloat(document.getElementById("idTemAmb").value)*100),
					humamb:Math.round(parseFloat(document.getElementById("idHumAmb").value)*100)
				},
				url:"config/saveDetTemHumACH.php",
				success:function(data){
					if(!data.state){
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function guardar_humedad(){
			let ar=document.getElementsByClassName("class-humedad");
			let ar_send=[];
			for (var i = 0; i < ar.length; i++) {
				let aux=[];
				aux.push(ar[i].dataset.idreg);
				if (ar[i].value!="") {
					aux.push(Math.round(parseFloat(ar[i].value)*100));
				}else{
					aux.push(0);
				}		
				ar_send.push(aux);
			}
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				data:{
					codfic:document.getElementById("codficsel").innerHTML,
					codtad:codtad_v,
					numvez:numvez_v,
					parte:parte_v,
					array:ar_send
				},
				url:"config/saveDetHumACH.php",
				success:function(data){
					if(!data.state){
						alert(data.detail);
					}else{				
						document.getElementById("idResultado").value=data.RESULTADO;
						document.getElementById("idPromedio").value=data.HUMPRO;
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}		
		function terminar_auditora(){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:"POST",
				data:{
					codfic:document.getElementById("codficsel").innerHTML,
					codtad:codtad_v,
					numvez:numvez_v,
					parte:parte_v,
					res:document.getElementById("idResultado").value,
					obs:document.getElementById("idObservacion").value
				},
				url:"config/endFichaACH.php",
				success:function(data){
					console.log(data);
					alert(data.detail);
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function correct_text(text){
			while(text.indexOf("\"")>=0){
				text=text.replace("\"","");
			}
			return text;
		}
		var numpre_v='';
		var esttsc_v='';
		var numprefic_v='';
		var numpreadific_v='';
		function aud_med(){
			if ($("#codfic").val()=="") {
				alert("Complete la ficha");
				return;
			}
			document.getElementById("detalle-checklist").style.display="none";
			document.getElementById("detalle-humedad").style.display="none";
			document.getElementById("detalle-audmed").style.display="none";
			document.getElementById("main-content").style.display="none";			
			document.getElementById("content-aud").style.display="block";
			document.getElementById("second-frame").style.display="none";
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/getPreAudMedACA.php',
				data:{
					codfic:$("#codfic").val()
				},
				success:function(data){
					console.log(data);
					if (data.state) {
						esttsc_v=data.esttsc;
						numpre_v=data.numpre;
						numprefic_v=data.datos.NUMPRE;
						numpreadific_v=data.datos.NUMPREADI;
						document.getElementById("medcorpro").innerHTML='<div class="link-a" onclick="go_link(1)">Medidas de Corte - Proceso</div>';
						document.getElementById("medcorfin").innerHTML='<div class="link-a" onclick="go_link(2)">Medidas de Corte - Final</div>';
						document.getElementById("medcosfin").innerHTML='<div class="link-a" onclick="go_link(3)">Medidas de Costura - Final</div>';
						document.getElementById("repmedcorpro").innerHTML='<a href="../auditoriaprocesocorte/ReporteDesMed.php?esttsc='+esttsc_v+'&codfic='+$("#codfic").val()+'">Reporte de desviación de medidas Corte - Proceso</a>';	
						document.getElementById("repmedcorfin").innerHTML='<a href="../auditoriafinalcorte/ReporteDesMed.php?esttsc='+esttsc_v+'&codfic='+$("#codfic").val()+'">Reporte de desviación de medidas Corte - Final</a>';
						//document.getElementById("repmedcosfin").innerHTML='<a href="" target="_blank">Medidas de Costura - Final</a>';	
						$("#idObsAca").val(data.datos.COMENTARIOS);
						if (data.datos.RESULTADO=="A") {
							$("#idResAca").remove();
							$("#btn-end-aca").remove();
						}
						if (data.datos.RESULTADO=="R") {
							$("#idResAcaText").remove();
						}
						if (data.datos.RESULTADO=="C") {
							$("#idResAca").remove();
							$("#idResAcaText").text("APROBADO NO CONFORME");
							$("#btn-end-aca").remove();
						}
						if (data.detalle.length>0) {
							$("#CanXTalla").val(data.numpre);
							var html='';
							var html2='';
							html2+=
							'<div style="display:flex;">'+
								'<div class="column-tbl">'+
									'<div class="header-item item-center item-c0"></div>'+
									'<div class="header-item item-maxheight">Prenda</div>'+
								'</div>';
							html+=
							'<div class="column-tbl">';
							for (var j = 0; j < data.numpre; j++) {
								for (var i = 0; i < data.talla.length; i++) {
									html+=
								'<div class="header-item item-center item-c2">'+(j+1)+'</div>';
								}
							}
							html+=					
							'</div>';

							html2+=
								'<div class="column-tbl">'+
									'<div class="header-item">Medida</div>'+
									'<div class="header-item item-maxheight">Talla</div>'+
								'</div>';
							html+=
							'<div class="column-tbl">';
							for (var j = 0; j < data.numpre; j++) {
								for (var i = 0; i < data.talla.length; i++) {
									html+=
								'<div class="header-item item-center item-c2">'+data.talla[i].DESTAL+'</div>';	
								}
							}
							html+=
								'<div class="header-item item-center item-c0"></div>';
							for (var i = 0; i < data.talla.length; i++) {
									html+=
								'<div class="header-item item-center item-c2">'+data.talla[i].DESTAL+'</div>';	
							}
							html+=
							'</div>';

							var ant_nom=data.detalle[0].DESMED;
							for (var i = 0; i < data.detalle.length; i++) {
								if (data.detalle[i].DESMED!=ant_nom) {
									html+=
								'<div class="header-item item-center item-c0"></div>';
									for (var k = 0; k < data.detalletalla.length; k++) {
										if (data.detalletalla[k].DESMED==ant_nom) {
											html+=
								'<div class="header-item item-s2 item-center item-c3">'+data.detalletalla[k].MEDIDA+'</div>';	
										}
									}

									html2+=
								'<div class="column-tbl-s2">'+
									'<div class="header-item item-s2">'+data.detalle[i].DESMEDCOR+'</div>'+
									'<div class="header-item item-s2 item-maxheight" title="'+correct_text(data.detalle[i].DESMED)+'">'+data.detalle[i].DESMED+'</div>'+
								'</div>';
									html+=
							'</div>'+
							'<div class="column-tbl-s2">';
									ant_nom=data.detalle[i].DESMED;
								}
								if (i==0) {
									html2+=
								'<div class="column-tbl-s2">'+
									'<div class="header-item item-s2">'+data.detalle[i].DESMEDCOR+'</div>'+
									'<div class="header-item item-s2 item-maxheight" title="'+correct_text(data.detalle[i].DESMED)+'">'+data.detalle[i].DESMED+'</div>'+
								'</div>';

									html+=
							'<div class="column-tbl-s2">';
								}
								var style=" item-c3";
								if(data.detalle[i].TOLVAL==1){
									style=" item-c5";
								}else{
									if(data.detalle[i].TOLVAL==0){
										style=" item-c4";
									}
								}
								if (data.detalle[i].VALOR!=null) {
									html+=
								'<div class="header-item item-s2 item-center'+style+'">'+data.detalle[i].VALOR+'</div>';
								}else{
									html+=
								'<div class="header-item item-s2 item-center'+style+'"></div>';
								}
							}
							html+=
								'<div class="header-item item-center item-c0"></div>';
							for (var k = 0; k < data.detalletalla.length; k++) {
								if (data.detalletalla[k].DESMED==ant_nom) {
									html+=
								'<div class="header-item item-s2 item-center item-c3">'+data.detalletalla[k].MEDIDA+'</div>';	
								}
							}
							html2+=
							'</div>';
							html+=
							'</div>';

							$("#space-res-hader").empty();
							$("#space-tbl-medidas").empty();
							$("#space-res-hader").append(html2);
							$("#space-tbl-medidas").append(html);
							$("#resume-medida").css("display","block");
						}else{
							$("#btndescarga").remove();
						}

						$(".panelCarga").fadeOut(100);
						document.getElementById("detalle-audmed").style.display="block";
						document.getElementById("main-content").style.display="block";
						document.getElementById("content-main").style.display="block";
						show_header();
						ctrl_header();
						show_form(3);
					}else{
						alert(data.detail);
						$(".panelCarga").fadeOut(100);
					}
				}
			});
		}
		var last_pos=0;
		var array_tallas=[];
		var ar_var_med=['1','7/8','3/4','5/6','1/2','3/8','1/4','1/8','0','-1/8','-1/4','-3/8','-1/2','-5/6','-3/4','-7/8','-1'];
		function generateTable(){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				url:"config/getDetalleMedidas-v2.php",
				type:"POST",
				data:{
					codfic:document.getElementById("codficsel").innerHTML,
					esttsc:esttsc_v,
					cantidad:numpre_v
				},
				success:function (data){
					console.log(data);
					if (data.state) {
						$("#content-main").css("display","none");

						var html2=
						'<div class="header-content">';
						var ant_codtal='';
						var pos=1;
						for (var i = 0; i < data.heamedtal.length; i++) {
							if(data.heamedtal[i].CODTAL!=ant_codtal){
								ant_codtal=data.heamedtal[i].CODTAL;
								if (i!=0) {
									html2+=
							'</div>';
									style="none";
								}else{
									style="flex";
								}
								html2+=
							'<div class="content-medida headers header-'+pos+'" style="display:'+style+';">'+					
								'<div class="column-tbl column-tbl-static">'+
									'<div class="header-item">C. Med.</div>'+
									'<div class="header-item">Medida</div>'+
									'<div class="header-item item-maxheight">Desc.</div>'+
								'</div>';
								pos++;
							}
							html2+=
								'<div class="column-tbl-s2">'+
									'<div class="header-item item-s2">'+data.heamedtal[i].DESMEDCOR+'</div>'+
									'<div class="header-item item-s2">'+data.heamedtal[i].MEDIDA+'</div>'+
									'<div class="header-item item-s2 item-maxheight" title="'+correct_text(data.heamedtal[i].DESMED)+'">'+data.heamedtal[i].DESMED+'</div>'+
								'</div>';
						}
						html2+=
							'</div>'+
						'</div>';

						var html='';
						var destal="";
						var display='style="display:block;"';
						var k=0;
						last_pos=parseInt(data.cont);
						var html_btns='<div class="content-btns-prenda">';
						var html_spans='';
						for (var l = 0; l < parseInt(numpre_v); l++) {
							if (l==0) {
								html_btns+='<button class="btn-prenda btn-prenda-select" onclick="select_btn(this,\''+(l+1)+'\')">'+(l+1)+'</button>';
							}else{
								html_btns+='<button class="btn-prenda" onclick="select_btn(this,\''+(l+1)+'\')">'+(l+1)+'</button>';
							}
							html_spans+='<span class="span-spe span-'+(l+1)+'"></span>';
						}
						$("#space-btns-prendas").empty();
						$("#space-btns-prendas").append(html_btns);
						for (var i = 0; i < data.detalle.length; i++) {
							if(data.detalle[i].DESTAL!=destal){
								k++;
								if (k>1) {
									html+=
							'</div>'+
							'<div class="title-medida tit-special">'+(k-1)+' de '+data.cont+'</div>'+
						'</div>';
									display='style="display:none;"';
								}
								html_btns+='</div>';
									html+=
						'<div class="main-content-medida content'+k+'" data-pos="'+k+'" '+display+'>'+
							'<div class="content-medida">'+					
								'<div class="column-tbl column-tbl-static">';
									for (var l = 0; l < ar_var_med.length; l++) {
										if (ar_var_med[l]=="0") {
											html+=
									'<div class="header-item item-center item-c4">'+ar_var_med[l]+'</div>';
										}else{
											html+=
									'<div class="header-item item-center item-c2">'+ar_var_med[l]+'</div>';
										}
									}
									html+=
								'</div>';
								destal=data.detalle[i].DESTAL;
								array_tallas.push(destal);
							}

							html+=
								'<div class="column-tbl-s2">'+
									'<div class="content-validate contentButton-'+data.detalle[i].CODMED+'-'+data.detalle[i].CODTAL+'" data-clicked="0">';
							var style_tol=' item-c3';
							var val_tol='2';
									for (var l = 0; l < ar_var_med.length; l++) {
										if (ar_var_med[l]==data.detalle[i].TOLERANCIAMAS) {
											style_tol=' item-c5';
											val_tol='1';
										}
										if (l>0 && ar_var_med[l-1]=="-"+data.detalle[i].TOLERANCIAMENOS && parseInt(ar_var_med[l-1])<0) {
											style_tol=' item-c3';
											val_tol='2';
										}
										if (i==0) {
											//console.log("-"+ar_var_med[l]);
										}
										if (ar_var_med[l]=="0") {
											html+=
										'<div class="header-item item-center item-s2 item-c4 dato-0" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\'0\',this,0)">'+html_spans+'</div>';
										}else{
											html+=
										'<div class="header-item item-center item-s2'+style_tol+' dato-'+ar_var_med[l]+'" onclick="register('+data.detalle[i].CODMED+',\''+data.detalle[i].CODTAL+'\',\''+ar_var_med[l]+'\',this,'+val_tol+')">'+html_spans+'</div>';
										}
									}
							html+=								
									'</div>'+
								'</div>';
						}
						html+=
							'</div>'+
							'<div class="title-medida tit-special">'+k+' de '+data.cont+'</div>'+
						'</div>';
						$("#talla-select").text(array_tallas[0]);
						$("#space-tbl-generate").empty();
						$("#space-tbl-generate").append(html2);
						$("#space-tbl-generate").append(html);
						$("#second-frame").css("display","block");
						if (data.replicar==true) {
							replicar_informacion(data.guardado);
						}
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function replicar_informacion(data){
			for (var i = 0; i < data.length; i++) {
				if (data[i].VALOR!=null) {
					if (document.getElementsByClassName("contentButton-"+data[i].CODMED+"-"+data[i].CODTAL)[0].
					getElementsByClassName("dato-"+data[i].VALOR)[0]) {
						var element=document.getElementsByClassName("contentButton-"+data[i].CODMED+"-"+data[i].CODTAL)[0].
						getElementsByClassName("dato-"+data[i].VALOR)[0].
						getElementsByClassName("span-"+data[i].NUMPRE)[0];
						element.innerText=data[i].NUMPRE;
						if (parseInt(numprefic_v)<parseInt(data[i].NUMPRE)) {
							element.style.fontWeight="bold";
							element.style.color="#000";
						}
					}
				}
			}
		}
		function move_frame(dir){
			var ar_content=document.getElementsByClassName("main-content-medida");
			var i=0;
			var validate=false;
			var pos=0;
			while( i < ar_content.length && validate==false) {
				if(ar_content[i].style.display=="block"){
					validate=true;
					pos=parseInt(ar_content[i].dataset.pos);
				}
				i++;
			}
			if ((dir==0 && pos==1) ||(dir==1 && pos==last_pos)) {

			}else{
				$(".content"+pos).css("display","none");
				$(".header-"+pos).css("display","none");
				var newpos=0;
				if (dir==0) {
					newpos=pos-1;
				}else{
					newpos=pos+1;
				}
				$("#talla-select").text(array_tallas[newpos-1]);
				$(".content"+newpos).css("display","block");
				$(".header-"+newpos).css("display","flex");
			}
		}
		function update_res_aca(){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				type:'POST',
				url:'config/endAudMedAcaEje.php',
				data:{
					codfic:$("#codfic").val(),
					res:$("#idResAca").val(),
					obs:$("#idObsAca").val()
				},
				success:function (data){
					console.log(data);
					if (data.state) {
					}
					alert(data.detail);
					$(".panelCarga").fadeOut(100);
				}
			});
		}
		function close_modal(id){
			$("#"+id).fadeOut(100);
		}
		function go_link(id){
			if (id==1) {				
				$(".panelCarga").fadeIn(100);
				$.ajax({
					type:'POST',
					url:'config/getEncFicProCor.php',
					data:{
						codfic:$("#codfic").val()
					},
					success:function(data){
						console.log(data);
						if (data.state) {
							let html='';
							for (var i = 0; i < data.fichas.length; i++) {
								html+=
								'<tr>'+
            						'<td>'+data.fichas[i].hilo+'</td>'+
            						'<td>'+data.fichas[i].travez+'</td>'+
            						'<td>'+data.fichas[i].largmanga+'</td>'+
            						'<td><a href="../auditoriaprocesocorte/AuditarMedidas.php?codfic='+$("#codfic").val()+'&hilo='+data.fichas[i].hilo+'&travez='+data.fichas[i].travez+'&largmanga='+data.fichas[i].largmanga+'">ver</a></td>'+
								'</tr>';
							}
							document.getElementById("tbl-body").innerHTML+=html;
							$("#modal1").fadeIn(100);
						}else{
							$("#modal1").fadeOut(100);
							alert(data.detail);
						}
						$(".panelCarga").fadeOut(100);
					}
				});
			}else{
				if (id==3) {
					window.location.href="../auditex/AuditoriaMedidas.php?codfic="+$("#codfic").val();
				}else{
					$(".panelCarga").fadeIn(100);
				$.ajax({
						type:'POST',
						url:'config/getEncFicFinCor.php',
						data:{
							codfic:$("#codfic").val()
						},
						success:function(data){
							console.log(data);
							if (data.state) {
								let html='';
								for (var i = 0; i < data.fichas.length; i++) {
									html+=
									'<tr>'+
	            						'<td>'+data.fichas[i].hilo+'</td>'+
	            						'<td>'+data.fichas[i].travez+'</td>'+
	            						'<td>'+data.fichas[i].largmanga+'</td>'+
	            						'<td><a href="../auditoriafinalcorte/RegistrarMedidasAudFinCor.php?codfic='+$("#codfic").val()+'&hilo='+data.fichas[i].hilo+'&travez='+data.fichas[i].travez+'&largmanga='+data.fichas[i].largmanga+'">ver</a></td>'+
									'</tr>';
								}
								document.getElementById("tbl-body").innerHTML+=html;
								$("#modal1").fadeIn(100);
							}else{
								alert(data.detail);
							}
							$(".panelCarga").fadeOut(100);
						}
					});
				}
			}
		}
	</script>
</body>
</html>