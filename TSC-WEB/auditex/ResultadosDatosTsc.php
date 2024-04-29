<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	ini_set('memory_limit', '-1');

	$appcod="10";
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

	<style>
		.tblHeader-new{
			display: inline-flex;
			background: #980f0f;
			border-radius: 5px 5px 0px 0px;
			/* width: 100%; */
			font-size: 15px;
			font-weight: bold
		}

		.itemBody2{
			background: #fff;
		}
	</style>

	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
</head>
<body>
	<?php contentMenu();?>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">REPORTE GENERAL DE AUDITORÍA FINAL DE COSTURA INTERNO TSC </div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent" style="padding-bottom: 0px;">	
			<?php 
				include("config/connection.php");
				$titulo="";
				$destll = "";
				$desusu = "";
				$desauditoria = $_GET["desauditoria"];

				
				if($_GET['codsede']!=0){

					// $sql="BEGIN SP_AT_SELECT_SEDE(:CODSED,:OUTPUT_CUR); END;";
					// $stmt=oci_parse($conn, $sql);
					// oci_bind_by_name($stmt, ':CODSED', $_GET['codsede']);
					// $OUTPUT_CUR=oci_new_cursor($conn);
					// oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
					// $result=oci_execute($stmt);
					// oci_execute($OUTPUT_CUR);
					// $row=oci_fetch_assoc($OUTPUT_CUR);
					$titulo.= "SEDE: ". utf8_encode($_GET['dessede'])." / ";
				}else{
					$titulo.= "SEDE: ". "(TODOS) / ";
				}
				if($_GET['codtipser']!=0){
					// $sql="BEGIN SP_AT_SELECT_TIPSER(:CODTIPSER,:OUTPUT_CUR); END;";
					// $stmt=oci_parse($conn, $sql);
					// oci_bind_by_name($stmt, ':CODTIPSER', $_GET['codtipser']);
					// $OUTPUT_CUR=oci_new_cursor($conn);
					// oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
					// $result=oci_execute($stmt);
					// oci_execute($OUTPUT_CUR);
					// $row=oci_fetch_assoc($OUTPUT_CUR);
					$titulo.= "TIPO SERVICIO: ". utf8_encode($_GET['destiposervicio'])." / ";
				}else{
					$titulo.= "TIPO SERVICIO: ". "(TODOS) / ";
				}
				if($_GET['codtll']!=0){
					// $sql="BEGIN SP_AT_SELECT_TALLER(:CODTLL,:OUTPUT_CUR); END;";
					// $stmt=oci_parse($conn, $sql);
					// oci_bind_by_name($stmt, ':CODTLL', $_GET['codtll']);
					// $OUTPUT_CUR=oci_new_cursor($conn);
					// oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
					// $result=oci_execute($stmt);
					// oci_execute($OUTPUT_CUR);
					// $row=oci_fetch_assoc($OUTPUT_CUR);
					$titulo.= "TALLER: ". utf8_encode($_GET['destaller'])." / ";
					$destll = $_GET['destaller'];
				}else{
					$titulo.= "TALLER: ". "(TODOS)";
				}

				$titulo.= "</br>";

				if($_GET['codusu']!=0){
					// $sql="BEGIN SP_AT_SELECT_AUDITOR(:CODUSU,:OUTPUT_CUR); END;";
					// $stmt=oci_parse($conn, $sql);
					// oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
					// $OUTPUT_CUR=oci_new_cursor($conn);
					// oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
					// $result=oci_execute($stmt);
					// oci_execute($OUTPUT_CUR);
					// $row=oci_fetch_assoc($OUTPUT_CUR);
					$titulo.="AUDITOR: ". utf8_encode($_GET['desusu'])." / ";
					$desusu = $_GET['desusu'];

				}else{
					$titulo.="AUDITOR: ". "(TODOS) / ";
				}

				// CLIENTE
				if($_GET["codcliente"] != 0){
					$titulo.="CLIENTE: ". utf8_encode($_GET["descripcioncliente"])." / ";
				}else{
					$titulo.="CLIENTE: ". "(TODOS)" ." / ";
				}

				// PEDIDOS
				if($_GET["pedido"] != ""){
					$titulo.="PEDIDO: ". utf8_encode($_GET["pedido"])." / ";
				}else{
					$titulo.="PEDIDO: ". "(TODOS)" ." / ";
				}

				// COLOR
				if($_GET["color"] != ""){
					$titulo.="COLOR: ". utf8_encode($_GET["color"])." / ";
				}else{
					$titulo.="COLOR: ". "(TODOS)" ." / ";
				}

				// PO
				if($_GET["po"] != ""){
					$titulo.="PO: ". utf8_encode($_GET["po"])." / ";
				}else{
					$titulo.="PO: ". "(TODOS)";
				}

				$titulo.= "</br>";


				$ar_fecini=explode("-",$_GET['fecini']);
				$ar_fecfin=explode("-",$_GET['fecfin']);
				$titulo.= "RANGO DE FECHAS: ". $ar_fecini[2]."-".$ar_fecini[1]."-".$ar_fecini[0]." al ".$ar_fecfin[2]."-".$ar_fecfin[1]."-".$ar_fecfin[0];
			?>
			<div class="lblNew" id="spacetitulo">
				<?php echo $titulo; ?>
			</div>
			<?php
				$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
				$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];
				// $sql="BEGIN SP_AT_REPORTE_GENERAL_NEW(:FECINI,:FECFIN,:CODTAD,:CODTLL,:CODUSU,:CODSED,:CODTIPSER,:OUTPUT_CUR); END;";
				$sql="BEGIN SP_AT_REPORTE_GENERAL_NEW(:FECINI,:FECFIN,:CODTAD,:CODTLL,:CODUSU,:CODSED,:CODTIPSER,:CODCLIENTE,:PEDIDO,:COLOR,:PO,:OUTPUT_CUR); END;";

				$codtad = $_GET['codtad'] == "0" ? null : $_GET["codtad"];
				$codtll = $_GET['codtll'] == "0" ? null : $_GET["codtll"];
				$codusu = $_GET['codusu'] == "0" ? null : $_GET["codusu"];
				$codsede = $_GET['codsede'] == "0" ? null : $_GET["codsede"];
				$codtipser = $_GET['codtipser'] == "0" ? null : $_GET["codtipser"];
				$codcliente = $_GET['codcliente'] == "0" ? null : $_GET["codcliente"];
				$pedido = $_GET['pedido'] == "" ? null : $_GET["pedido"];
				$color = $_GET['color'] == "" ? null : $_GET["color"];
				$po = $_GET['po'] == "" ? null : $_GET["po"];




				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':FECINI', $fecini);
				oci_bind_by_name($stmt, ':FECFIN', $fecfin);
				oci_bind_by_name($stmt, ':CODTAD', $codtad);
				oci_bind_by_name($stmt, ':CODTLL', $codtll);
				oci_bind_by_name($stmt, ':CODUSU', $codusu);
				oci_bind_by_name($stmt, ':CODSED', $codsede);
				oci_bind_by_name($stmt, ':CODTIPSER', $codtipser);

				oci_bind_by_name($stmt, ':CODCLIENTE', $codcliente);
				oci_bind_by_name($stmt, ':PEDIDO', $pedido);
				oci_bind_by_name($stmt, ':COLOR', $color);
				oci_bind_by_name($stmt, ':PO', $po);


				
				$OUTPUT_CUR=oci_new_cursor($conn);
				oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
				$result=oci_execute($stmt);
				oci_execute($OUTPUT_CUR);

				$_SESSION["data_reporte_auditoriafinal_tsc"] = [];

				$hideButtton="";
			?>
			<div class="mayorContent" id="ctrl-div">
				<div class="rowLine" style="display: block;width: 100%;">
					<div class="tblPrendasDefecto" style="position: relative;">

						<div class="tblHeader-new" >

							<!-- <div class="itemHeader2 verticalHeader" style="width: 150px;">Ficha</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">Pedido</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">PO</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">Est. TSC</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">Est. CLI</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">Alternativa</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">Ruta</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">T. STD</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">T. Comp. Estilo</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">T. Comp. Ficha</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">Min. Totales</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">Parte</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">Num. Vez</div>
							<div class="itemHeader2" style="width: 150px;">Tipo Auditoria</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">AQL</div>
							<div class="itemHeader2" style="width:150px;">Fecha Realizada</div>
							<div class="itemHeader2 verticalHeader" style="width:150px;">Usuario</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">Cant. Parte</div>
							<div class="itemHeader2" style="width: 150px;">Cant. Muestra</div>
							<div class="itemHeader2" style="width: 150px;">Cant. Max. Def.</div>


							<div class="itemHeader2 verticalHeader" style="width: 150px;">Defectos Encontrados</div>
							<div class="itemHeader2 verticalHeader" style="width: 200px;">Defectos</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">Cantidad por Defectos</div>



							<div class="itemHeader2 verticalHeader" style="width: 150px;">Resultado</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">Cliente</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">Sede</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">Tip. Serv.</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">Taller</div>

							<div class="itemHeader2 verticalHeader" style="width: 150px;">Partida.</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">Tipo Tela.</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">Color.</div>

							<div class="itemHeader2 verticalHeader" style="width: 150px;">Programa.</div>
							<div class="itemHeader2 verticalHeader" style="width: 150px;">Descripción Prenda.</div>

							<div class="itemHeader2 verticalHeader" style="width: 150px;">Observaciones Auditoria</div> -->
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Ficha</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Est. TSC</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Alternativa</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Ruta</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">T. STD</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">T. Comp. Estilo</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">T. Comp. Ficha</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Min. Totales</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Parte</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Num. Vez</div>
							<div class="itemHeader2" style="min-width: 150px;">Tipo Auditoria</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">AQL</div>
							<div class="itemHeader2" style="min-width:150px;">Fecha Realizada</div>
							<div class="itemHeader2 verticalHeader" style="min-width:150px;">Usuario</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Cant. Parte</div>
							<div class="itemHeader2" style="min-width: 150px;">Cant. Muestra</div>
							<div class="itemHeader2" style="min-width: 150px;">Cant. Max. Def.</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Defectos Encontrados</div>
							<!-- <div class="itemHeader2 verticalHeader" style="min-width: 200px;">Defectos</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Cantidad por Defectos</div> -->
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Resultado</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Cliente</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Sede</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Tip. Serv.</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Taller</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Est. CLI</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Programa.</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Pedido</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">PO</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Descripción Prenda.</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Tipo Tela.</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Partida.</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Color.</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Observaciones Auditoria</div>



						</div>

						<div class="tblHeader-new" id="move-head" style="position: absolute;top: 0;left: 0;">

							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Ficha</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Est. TSC</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Alternativa</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Ruta</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">T. STD</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">T. Comp. Estilo</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">T. Comp. Ficha</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Min. Totales</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Parte</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Num. Vez</div>
							<div class="itemHeader2" style="min-width: 150px;">Tipo Auditoria</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">AQL</div>
							<div class="itemHeader2" style="min-width:150px;">Fecha Realizada</div>
							<div class="itemHeader2 verticalHeader" style="min-width:150px;">Usuario</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Cant. Parte</div>
							<div class="itemHeader2" style="min-width: 150px;">Cant. Muestra</div>
							<div class="itemHeader2" style="min-width: 150px;">Cant. Max. Def.</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Defectos Encontrados</div>
							<!-- <div class="itemHeader2 verticalHeader" style="min-width: 200px;">Defectos</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Cantidad por Defectos</div> -->
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Resultado</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Cliente</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Sede</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Tip. Serv.</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Taller</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Est. CLI</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Programa.</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Pedido</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">PO</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Descripción Prenda.</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Tipo Tela.</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Partida.</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Color.</div>
							<div class="itemHeader2 verticalHeader" style="min-width: 150px;">Observaciones Auditoria</div>



						</div>

						<div class="tblBody">
				<?php
						while ($row=oci_fetch_assoc($OUTPUT_CUR)) {

						$_SESSION["data_reporte_auditoriafinal_tsc"][] = $row;

				?>
							<div class="tblLine">
								<div class="itemBody2" style="min-width: 150px;"><?php echo $row['CODFIC']; ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo $row['ESTILO_TSC']; ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo $row['ALTERNATIVA']; ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo $row['RUTA']; ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo $row['MINSTD']; ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo $row['MINADIEST']; ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo $row['MINCOMFIC']; ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo $row['MINTOT']; ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo $row['PARTE']; ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo $row['NUMVEZ']; ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo utf8_encode($row['DESTAD']); ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo $row['AQL']; ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo $row['FECFINAUDFOR']; ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo $row['DESUSU']; ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo $row['CANPAR']; ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo $row['CANAUD']; ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo $row['CANDEFMAX']; ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo $row['CANDEF']; ?></div>
								<!-- <div class="itemBody2" style="min-width: 200px;"><?php echo $row['DESCDEFECTOS']; ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo $row['CANTDEFECTOS']; ?></div> -->
								<div class="itemBody2" style="min-width: 150px;"><?php if($row['RESULTADO']=="A"){echo "Aprobado";}else{echo "Rechazado";} ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo utf8_encode($row['DESCLI']); ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo utf8_encode($row['DESSEDE']); ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo utf8_encode($row['DESTIPSERV']); ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo utf8_encode($row['DESTLL']); ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo $row['ESTCLI']; ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo utf8_encode($row['PROGRAMA']); ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo $row['PEDIDO']; ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo $row['PO']; ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo utf8_encode($row['DESPRE']); ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo utf8_encode($row['TIPOTELA']); ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo utf8_encode($row['PARTIDA']); ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo utf8_encode($row['COLOR']); ?></div>
								<div class="itemBody2" style="min-width: 150px;"><?php echo utf8_encode($row['OBSERVACIONES']); ?></div>



							</div>
				<?php
						}
						if(oci_num_rows($OUTPUT_CUR)==0){
							$hideButtton="display:none;";
				?>
					<div style="color: red;font-size: 18px; padding: 5px;font-size: 14px;">No hay resultados!</div>
				<?php
						}
				?>
						</div>
					</div>
				</div>
			</div>
			<div class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;width: 135px;
			padding: 5px;display: flex;padding-left: 20px;<?php echo $hideButtton;?>" 
			onclick="exportar('<?php echo $_GET['codtll']; ?>',<?php echo $_GET['codusu']; ?>,<?php echo $_GET['codtad']; ?>,
			'<?php echo $_GET['fecini']; ?>','<?php echo $_GET['fecfin']; ?>','<?php echo $_GET['codsede']; ?>','<?php echo $_GET['codtipser']; ?>',
			'<?php echo $codcliente; ?>','<?php echo $pedido; ?>','<?php echo $color; ?>','<?php echo $po; ?>',
			'<?php echo $destll; ?>','<?php echo $desusu; ?>','<?php echo $desauditoria; ?>',

				'<?php echo $titulo;?>')">
				<img src="assets/img/excel.png" style="width: 30px;height: 30px;">
				<div style="padding: 5px;width:calc(80px);text-align: center;">Descargar</div>
			</div>
			<div class="lineDecoration"></div>
		</div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<!-- <button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="redirect('ReportesAuditoria.php')">Volver</button> -->

				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="goBack()">Volver</button>

				
			</div>		
		</div>
	</div>
	<script type="text/javascript" src="js/graficasDatos-v1.0Tsc.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" >
		function goBack() {
			window.history.back();
		}
		document.getElementById("ctrl-div").addEventListener('scroll',function(){
			document.getElementById("move-head").style.top=document.getElementById("ctrl-div").scrollTop+"px";
		});
	</script>
</body>
</html>