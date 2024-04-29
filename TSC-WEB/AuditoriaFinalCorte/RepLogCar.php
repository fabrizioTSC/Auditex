<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="3";
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
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
</head>
<body>
	<?php contentMenu();?>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Reporte Log de Carga de Medidas</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>			
			</div>
		</div>
		<div class="bodyContent mainBodyContent" style="padding-bottom: 0px;">	
			<?php 
				include("config/connection.php");
				$titulo="";
				if($_GET['esttsc']!=0){
					$titulo.=$_GET['esttsc']." / ";
				}else{
					$titulo.="(TODOS) / ";
				}
				if($_GET['codusu']!=0){
					$sql="BEGIN SP_AT_SELECT_AUDITOR(:CODUSU,:OUTPUT_CUR); END;";
					$stmt=oci_parse($conn, $sql);
					oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
					$OUTPUT_CUR=oci_new_cursor($conn);
					oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
					$result=oci_execute($stmt);
					oci_execute($OUTPUT_CUR);
					$row=oci_fetch_assoc($OUTPUT_CUR);
					$titulo.=utf8_encode($row['ALIUSU'])." / ";
				}else{
					$titulo.="(TODOS) / ";
				}
				$ar_fecini=explode("-",$_GET['fecini']);
				$ar_fecfin=explode("-",$_GET['fecfin']);
				$titulo.=$ar_fecini[2]."-".$ar_fecini[1]."-".$ar_fecini[0]." al ".$ar_fecfin[2]."-".$ar_fecfin[1]."-".$ar_fecfin[0];
			?>
			<div class="lblNew" id="spacetitulo"><?php echo $titulo; ?></div>
			<?php
				$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
				$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];
				$sql="BEGIN SP_AFC_REPORTE_LOG_CARGA_MED(:ESTTSC,:CODUSU,:CONFEC,:FECINI,:FECFIN,:OUTPUT_CUR); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':ESTTSC', $_GET['esttsc']);
				oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
				oci_bind_by_name($stmt, ':CONFEC', $_GET['fec']);
				oci_bind_by_name($stmt, ':FECINI', $fecini);
				oci_bind_by_name($stmt, ':FECFIN', $fecfin);
				$OUTPUT_CUR=oci_new_cursor($conn);
				oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
				$result=oci_execute($stmt);
				oci_execute($OUTPUT_CUR);
				$hideButtton="";
			?>
			<div class="mayorContent">
				<div class="rowLine" style="display: block;width: 1220px;">
					<div class="tblPrendasDefecto">
						<div class="tblHeader">
							<div class="itemHeader2" style="width: 100px;">Est. TSC</div>
							<div class="itemHeader2" style="width: 100px;">Hilo</div>
							<div class="itemHeader2" style="width: 100px;">Travez</div>
							<div class="itemHeader2" style="width: 100px;">Largmanga</div>
							<div class="itemHeader2" style="width: 100px;">Cod. Usu.</div>
							<div class="itemHeader2" style="width: 150px;">Fecha</div>
							<div class="itemHeader2" style="width: 90px;">Cargado</div>
							<div class="itemHeader2" style="width: 300px;">Nom. Archivo</div>
							<div class="itemHeader2" style="width: 90px;">Link CSV</div>
						</div>
						<div class="tblBody">
				<?php
						while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
				?>
							<div class="tblLine">
								<div class="itemBody2" style="width: 100px;"><?php echo $row['ESTTSC']; ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo $row['HILO']; ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo $row['TRAVEZ']; ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo $row['LARGMANGA']; ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo $row['CODUSU']; ?></div>
								<div class="itemBody2" style="width: 150px;"><?php echo $row['FECHA']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['CARGADO']; ?></div>
								<div class="itemBody2" style="width: 300px;"><?php echo utf8_encode($row['NOMARCHIVO']); ?></div>
								<div class="itemBody2" style="width: 90px;"><?php 
									echo '<a target="_blank" href="../carga-csv-afc/'.$row['ESTTSC']
									.'-'.intval(floatval($row['HILO'])*100)
									.'-'.intval(floatval($row['TRAVEZ'])*100)
									.'-'.intval(floatval($row['LARGMANGA'])*100)
									.'-'.$row['FECHAF'].'.csv">Ver</a>'; 
								?></div>
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
			<!--
			<div class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;width: 135px;
			padding: 5px;display: flex;padding-left: 20px;<?php echo $hideButtton;?>" 
			onclick="exportar('<?php echo $_GET['codtll']; ?>',<?php echo $_GET['codusu']; ?>,<?php echo $_GET['codtad']; ?>,
			'<?php echo $_GET['fecini']; ?>','<?php echo $_GET['fecfin']; ?>','<?php echo $_GET['codsede']; ?>','<?php echo $_GET['codtipser']; ?>','<?php echo $titulo;?>')">
				<img src="assets/img/excel.png" style="width: 30px;height: 30px;">
				<div style="padding: 5px;width:calc(80px);text-align: center;">Descargar</div>
			</div>
			-->
			<div class="lineDecoration"></div>
		</div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="window.history.back()">Volver</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript" src="js/ReporteGeneral-v1.0.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>