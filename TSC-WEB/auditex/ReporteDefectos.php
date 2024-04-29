<?php
	set_time_limit(120000);
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
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
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
</head>
<body>
	<?php contentMenu();?>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Reporte de defectos de auditoría final de costura</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>
			</div>
		</div>
		<div class="bodyContent mainBodyContent" style="padding-bottom: 0px;">	
			<?php 
				include("config/connection.php");
				$titulo="";
				if($_GET['codsede']!=0){
					$sql="BEGIN SP_AT_SELECT_SEDE(:CODSED,:OUTPUT_CUR); END;";
					$stmt=oci_parse($conn, $sql);
					oci_bind_by_name($stmt, ':CODSED', $_GET['codsede']);
					$OUTPUT_CUR=oci_new_cursor($conn);
					oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
					$result=oci_execute($stmt);
					oci_execute($OUTPUT_CUR);
					$row=oci_fetch_assoc($OUTPUT_CUR);
					$titulo.="SEDE: ".utf8_encode($row['DESSEDE'])." / ";
				}else{
					$titulo.="SEDE: "."(TODOS) / ";
				}
				if($_GET['codtipser']!=0){
					$sql="BEGIN SP_AT_SELECT_TIPSER(:CODTIPSER,:OUTPUT_CUR); END;";
					$stmt=oci_parse($conn, $sql);
					oci_bind_by_name($stmt, ':CODTIPSER', $_GET['codtipser']);
					$OUTPUT_CUR=oci_new_cursor($conn);
					oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
					$result=oci_execute($stmt);
					oci_execute($OUTPUT_CUR);
					$row=oci_fetch_assoc($OUTPUT_CUR);
					$titulo.="TIPO SERVICIO: ".utf8_encode($row['DESTIPSERV'])." / ";
				}else{
					$titulo.="TIPO SERVICIO: "."(TODOS) / ";
				}
				if($_GET['codtll']!=0){
					$sql="BEGIN SP_AT_SELECT_TALLER(:CODTLL,:OUTPUT_CUR); END;";
					$stmt=oci_parse($conn, $sql);
					oci_bind_by_name($stmt, ':CODTLL', $_GET['codtll']);
					$OUTPUT_CUR=oci_new_cursor($conn);
					oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
					$result=oci_execute($stmt);
					oci_execute($OUTPUT_CUR);
					$row=oci_fetch_assoc($OUTPUT_CUR);
					$titulo.="TALLER: ".utf8_encode($row['DESTLL'])." / ";
				}else{
					$titulo.="TALLER: "."(TODOS) / ";
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
					$titulo.="USUARIO: ".utf8_encode($row['ALIUSU'])." / ";
				}else{
					$titulo.="USUARIO: "."(TODOS) / ";
				}
				$ar_fecini=explode("-",$_GET['fecini']);
				$ar_fecfin=explode("-",$_GET['fecfin']);
				$titulo.=$ar_fecini[2]."-".$ar_fecini[1]."-".$ar_fecini[0]." al ".$ar_fecfin[2]."-".$ar_fecfin[1]."-".$ar_fecfin[0];
			?>
			<div class="lblNew" id="spacetitulo"><?php echo $titulo; ?></div>
			<?php
				$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
				$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];
				$sql="BEGIN SP_AT_REPORTE_DEFECTOS(:FECINI,:FECFIN,:CODTLL,:CODUSU,:CODSED,:CODTIPSER,:OUTPUT_CUR); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':FECINI', $fecini);
				oci_bind_by_name($stmt, ':FECFIN', $fecfin);
				oci_bind_by_name($stmt, ':CODTLL', $_GET['codtll']);
				oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
				oci_bind_by_name($stmt, ':CODSED', $_GET['codsede']);
				oci_bind_by_name($stmt, ':CODTIPSER', $_GET['codtipser']);
				$OUTPUT_CUR=oci_new_cursor($conn);
				oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
				$result=oci_execute($stmt);
				oci_execute($OUTPUT_CUR);
				$hideButtton="";
			?>
			<div class="mayorContent">
				<div class="rowLine" style="display: block;width: 2110px;">
					<div class="tblPrendasDefecto">
						<div class="tblHeader">
							<div class="itemHeader2" style="width: 80px;">Ficha</div>
							<div class="itemHeader2" style="width: 80px;">Parte</div>
							<div class="itemHeader2" style="width: 80px;">Num. Vez</div>
							<div class="itemHeader2" style="width: 100px;">Pedido</div>
							<div class="itemHeader2" style="width: 100px;">Color</div>
							<div class="itemHeader2" style="width: 90px;">Can Ficha</div>
							<div class="itemHeader2" style="width: 100px;">Fecha</div>
							<div class="itemHeader2" style="width: 90px;">Usuario</div>
							<div class="itemHeader2" style="width: 190px;">Taller</div>
							<div class="itemHeader2" style="width: 190px;">Defecto</div>
							<div class="itemHeader2" style="width: 190px;">Fam Defecto</div>
							<div class="itemHeader2" style="width: 90px;">Partida</div>
							<div class="itemHeader2" style="width: 90px;">Can Defecto</div>
							<div class="itemHeader2" style="width: 90px;">Can Parte</div>
							<div class="itemHeader2" style="width: 90px;">Sede</div>
							<div class="itemHeader2" style="width: 100px;">Tipo Servicio</div>
							<div class="itemHeader2" style="width: 190px;">Cliente</div>
							<div class="itemHeader2" style="width: 190px;">Resultado</div>
						</div>
						<div class="tblBody">
				<?php
						while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
				?>
							<div class="tblLine">
								<div class="itemBody2" style="width: 80px;"><?php echo $row['CODFIC']; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['PARTE']; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['NUMVEZ']; ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo utf8_encode($row['PEDIDO']); ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo $row['DESCOL']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['CANTIDAD']; ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo $row['FECFINAUDFOR']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo utf8_encode($row['DESUSU']); ?></div>
								<div class="itemBody2" style="width: 190px;"><?php echo utf8_encode($row['DESTLL']); ?></div>
								<div class="itemBody2" style="width: 190px;"><?php echo utf8_encode($row['DESDEF']); ?></div>
								<div class="itemBody2" style="width: 190px;"><?php echo utf8_encode($row['DSCFAMILIA']); ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo utf8_encode($row['PARTIDA']); ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['CANDEF']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['CANPAR']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo utf8_encode($row['DESSEDE']); ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo utf8_encode($row['DESTIPSERV']); ?></div>
								<div class="itemBody2" style="width: 190px;"><?php echo utf8_encode($row['DESCLI']); ?></div>
								<div class="itemBody2" style="width: 190px;"><?php echo utf8_encode($row['RESULTADO']); ?></div>
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
			onclick="exportar('<?php echo $_GET['codtll']; ?>',<?php echo $_GET['codusu']; ?>,
			'<?php echo $_GET['fecini']; ?>','<?php echo $_GET['fecfin']; ?>','<?php echo $_GET['codsede']; ?>','<?php echo $_GET['codtipser']; ?>','<?php echo $titulo;?>')">
				<img src="assets/img/excel.png" style="width: 30px;height: 30px;">
				<div style="padding: 5px;width:calc(80px);text-align: center;">Descargar</div>
			</div>
			<div class="lineDecoration"></div>
		</div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="goBack()">Volver</button>				
			</div>		
		</div>
	</div>
	<script type="text/javascript" src="js/ReporteDefectos.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" >
		function goBack() {
			window.history.back();
		}
	</script>
</body>
</html>