	<?php
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
	<link rel="stylesheet" type="text/css" href="css/index-v1.0.css">
	<link rel="stylesheet" type="text/css" href="css/consultaAuditoria.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<style type="text/css">
		.mayorContent{
			min-height: calc(100vh - 230px);
			position: relative;
		}
	</style>
</head>
<body>
	<?php contentMenu();?>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Reporte General Verificado de Empaque Acabados</div>
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
					$titulo.="SEDE: (TODOS) / ";
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
					$titulo.="TIPO SERVICIO: (TODOS) / ";
				}
				if($_GET['codcel']!=0){
					$sql="BEGIN SP_AT_SELECT_TALLER(:CODTLL,:OUTPUT_CUR); END;";
					$stmt=oci_parse($conn, $sql);
					oci_bind_by_name($stmt, ':CODTLL', $_GET['codcel']);
					$OUTPUT_CUR=oci_new_cursor($conn);
					oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
					$result=oci_execute($stmt);
					oci_execute($OUTPUT_CUR);
					$row=oci_fetch_assoc($OUTPUT_CUR);
					$titulo.="CELULA: ".utf8_encode($row['DESTLL'])." / ";
				}else{
					$titulo.="CELULA: (TODOS) / ";
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
				$sql="BEGIN SP_AA_REPEMP_GENERAL(:FECINI,:FECFIN,:CODCEL,:CODUSU,:CODSED,:CODTIPSER,:OUTPUT_CUR); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':FECINI', $fecini);
				oci_bind_by_name($stmt, ':FECFIN', $fecfin);
				oci_bind_by_name($stmt, ':CODCEL', $_GET['codcel']);
				oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
				oci_bind_by_name($stmt, ':CODSED', $_GET['codsede']);
				oci_bind_by_name($stmt, ':CODTIPSER', $_GET['codtipser']);
				$OUTPUT_CUR=oci_new_cursor($conn);
				oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
				$result=oci_execute($stmt);
				oci_execute($OUTPUT_CUR);
				$hideButtton="";
			?>
			<div class="mayorContent" id="main-table">
				<div class="rowLine" style="display: block;width: 1770px;">
					<div class="tblPrendasDefecto" style="position: relative;padding-bottom: 86px;">
						<div class="tblHeader">
							<div class="itemHeader2" style="width: 150px;">Cliente</div>
							<div class="itemHeader2" style="width: 80px;">Pedido</div>
							<div class="itemHeader2" style="width: 150px;">Color</div>
							<div class="itemHeader2" style="width: 80px;">PO</div>
							<div class="itemHeader2" style="width: 80px;">Lote</div>
							<div class="itemHeader2" style="width: 80px;">Vez</div>
							<div class="itemHeader2" style="width: 120px;">Fecha Inicio</div>
							<div class="itemHeader2" style="width: 120px;">Fecha Fin</div>
							<div class="itemHeader2" style="width: 120px;">Usuario</div>

							<div class="itemHeader2" style="width: 80px;">Can Caj Lote</div>
							<div class="itemHeader2" style="width: 80px;">Pre Lote</div>
							<div class="itemHeader2" style="width: 80px;">Can Caj Mue</div>
							<div class="itemHeader2" style="width: 80px;">Pre Mue</div>
							<div class="itemHeader2" style="width: 80px;">Can Caj Def</div>
							<div class="itemHeader2" style="width: 80px;">Pre Def</div>
							<div class="itemHeader2" style="width: 100px;">Resultado</div>
							<div class="itemHeader2" style="width: 150px;">Célula</div>
							<div class="itemHeader2" style="width: 150px;">Sede</div>
							<div class="itemHeader2" style="width: 150px;">Tipo Servicio</div>
						</div>
						<div class="tblHeader" id="header-animate" style="position: absolute;top: 0;z-index: 11;left: 0;">
							<div class="itemHeader2" style="width: 150px;">Cliente</div>
							<div class="itemHeader2" style="width: 80px;">Pedido</div>
							<div class="itemHeader2" style="width: 150px;">Color</div>
							<div class="itemHeader2" style="width: 80px;">PO</div>
							<div class="itemHeader2" style="width: 80px;">Lote</div>
							<div class="itemHeader2" style="width: 80px;">Vez</div>
							<div class="itemHeader2" style="width: 120px;">Fecha Inicio</div>
							<div class="itemHeader2" style="width: 120px;">Fecha Fin</div>
							<div class="itemHeader2" style="width: 120px;">Usuario</div>

							<div class="itemHeader2" style="width: 80px;">Can Caj Lote</div>
							<div class="itemHeader2" style="width: 80px;">Pre Lote</div>
							<div class="itemHeader2" style="width: 80px;">Can Caj Mue</div>
							<div class="itemHeader2" style="width: 80px;">Pre Mue</div>
							<div class="itemHeader2" style="width: 80px;">Can Caj Def</div>
							<div class="itemHeader2" style="width: 80px;">Pre Def</div>
							<div class="itemHeader2" style="width: 100px;">Resultado</div>
							<div class="itemHeader2" style="width: 150px;">Célula</div>
							<div class="itemHeader2" style="width: 150px;">Sede</div>
							<div class="itemHeader2" style="width: 150px;">Tipo Servicio</div>
						</div>
						<div class="tblBody">
				<?php
						$sumcajlot=0;
						$sumcanlote=0;
						$sumcajaudlot=0;
						$sumcanaudlot=0;
						$sumcajlot_a=0;
						$sumcanlote_a=0;
						$sumcajaudlot_a=0;
						$sumcanaudlot_a=0;
						$sumcajlot_r=0;
						$sumcanlote_r=0;
						$sumcajaudlot_r=0;
						$sumcanaudlot_r=0;
						while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
							$sumcajlot+=intval($row['NUMCAJLOTE']);
							$sumcanlote+=intval($row['CANLOTE']);
							$sumcajaudlot+=intval($row['NUMCAJAUDLOTE']);
							$sumcanaudlot+=intval($row['CANAUDLOTE']);
							if ($row['RESULTADOTXT']=="Aprobado") {
								$sumcajlot_a+=intval($row['NUMCAJLOTE']);
								$sumcanlote_a+=intval($row['CANLOTE']);
								$sumcajaudlot_a+=intval($row['NUMCAJAUDLOTE']);
								$sumcanaudlot_a+=intval($row['CANAUDLOTE']);
							}else{
								$sumcajlot_r+=intval($row['NUMCAJLOTE']);
								$sumcanlote_r+=intval($row['CANLOTE']);
								$sumcajaudlot_r+=intval($row['NUMCAJAUDLOTE']);
								$sumcanaudlot_r+=intval($row['CANAUDLOTE']);
							}
				?>
							<div class="tblLine">
								<div class="itemBody2" style="width: 150px;"><?php echo utf8_encode($row['DESCLI']); ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['PEDIDO']; ?></div>
								<div class="itemBody2" style="width: 150px;"><?php echo $row['DESCOL']; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['PO']; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['NROLOTE']; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['NUMVEZLOTE']; ?></div>
								<div class="itemBody2" style="width: 120px;"><?php echo $row['FECINIAUDFOR']; ?></div>
								<div class="itemBody2" style="width: 120px;"><?php echo $row['FECFINAUDFOR']; ?></div>
								<div class="itemBody2" style="width: 120px;"><?php echo utf8_encode($row['DESUSU']); ?></div>

								<div class="itemBody2" style="width: 80px;"><?php echo $row['NUMCAJLOTE']; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['CANLOTE']; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['NUMCAJAUDLOTE']; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['CANAUDLOTE']; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['NUMCAJDEF']; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['CANDEF']; ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo $row['RESULTADOTXT']; ?></div>
								<div class="itemBody2" style="width: 150px;"><?php echo utf8_encode($row['DESCEL']); ?></div>
								<div class="itemBody2" style="width: 150px;"><?php echo utf8_encode($row['DESSEDE']); ?></div>
								<div class="itemBody2" style="width: 150px;"><?php echo utf8_encode($row['DESTIPSERV']); ?></div>
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
				<?php
						if(oci_num_rows($OUTPUT_CUR)!=0){
				?>
						<div class="rowLine" id="totales" style="display: block;width: 1770px;position: absolute;bottom: 0;left:0;z-index: 11;background: #000;">
							<div class="tblLine" style="background: #000;color: #fff;border: none;">
								<div class="itemBody2" style="width: 150px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 150px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 120px;"></div>
								<div class="itemBody2" style="width: 120px;"></div>
								<div class="itemBody2" style="width: 120px;">TOTAL</div>
								<div class="itemBody2" style="width: 80px;"><?php echo number_format($sumcajlot); ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo number_format($sumcanlote); ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo number_format($sumcajaudlot); ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo number_format($sumcanaudlot); ?></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 100px;"></div>
								<div class="itemBody2" style="width: 150px;"></div>
								<div class="itemBody2" style="width: 150px;"></div>
								<div class="itemBody2" style="width: 150px;"></div>
							</div>
							<div class="tblLine" style="background: #000;color: #fff;border: none;">
								<div class="itemBody2" style="width: 150px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 150px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 120px;"></div>
								<div class="itemBody2" style="width: 120px;"></div>
								<div class="itemBody2" style="width: 120px;">APROBADO</div>
								<div class="itemBody2" style="width: 80px;"><?php echo number_format($sumcajlot_a); ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo number_format($sumcanlote_a); ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo number_format($sumcajaudlot_a); ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo number_format($sumcanaudlot_a); ?></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 100px;"></div>
								<div class="itemBody2" style="width: 150px;"></div>
								<div class="itemBody2" style="width: 150px;"></div>
								<div class="itemBody2" style="width: 150px;"></div>
							</div>
							<div class="tblLine" style="background: #000;color: #fff;border: none;">
								<div class="itemBody2" style="width: 150px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 150px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 120px;"></div>
								<div class="itemBody2" style="width: 120px;"></div>
								<div class="itemBody2" style="width: 120px;">RECHAZADO</div>
								<div class="itemBody2" style="width: 80px;"><?php echo number_format($sumcajlot_r); ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo number_format($sumcanlote_r); ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo number_format($sumcajaudlot_r); ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo number_format($sumcanaudlot_r); ?></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 100px;"></div>
								<div class="itemBody2" style="width: 150px;"></div>
								<div class="itemBody2" style="width: 150px;"></div>
								<div class="itemBody2" style="width: 150px;"></div>
							</div>
						</div>
				<?php
						}
				?>
			</div>
			<div class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;width: 135px;
			padding: 5px;display: flex;padding-left: 20px;<?php echo $hideButtton;?>" 
			onclick="exportar_veremp(<?php echo $_GET['codusu']; ?>,13,
			'<?php echo $_GET['fecini']; ?>','<?php echo $_GET['fecfin']; ?>','<?php echo $titulo;?>','<?php echo $_GET['codsede']; ?>','<?php echo $_GET['codtipser']; ?>','<?php echo $_GET['codcel']; ?>')">
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
	<script type="text/javascript" src="js/ReporteGeneral-v1.0.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript" >
		$(document).ready(function(){
			$("#main-table").scroll(function(){
				var top=$("#main-table").scrollTop();
				$("#totales").css("bottom",-1*top+"px");
				$("#header-animate").css("top",top+"px");
			});
		});
		function goBack() {
			window.history.back();
		}
	</script>
</body>
</html>