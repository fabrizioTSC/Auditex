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
			<div class="headerTitle">Reporte General Check List Proceso Acabados</div>
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
					$titulo.="TALLER: (TODOS) / ";
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
				$sql="BEGIN SP_AA_REPACA_GENERAL(:FECINI,:FECFIN,:CODTLL,:CODUSU,:CODSED,:CODTIPSER,:OUTPUT_CUR); END;";
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
			<div class="mayorContent" id="main-table">
				<div class="rowLine" style="display: block;width: 2000px;">
					<div class="tblPrendasDefecto" style="position: relative;padding-bottom: 86px;">
						<div class="tblHeader">
							<div class="itemHeader2 verticalHeader" style="width: 80px;">Ficha</div>
							<div class="itemHeader2 verticalHeader" style="width: 80px;">Pedido</div>
							<div class="itemHeader2 verticalHeader" style="width: 80px;">Color</div>
							<div class="itemHeader2 verticalHeader" style="width: 80px;">Parte</div>
							<div class="itemHeader2 verticalHeader" style="width: 80px;">Num. Vez</div>
							<div class="itemHeader2 verticalHeader" style="width: 100px;">AQL</div>
							<div class="itemHeader2" style="width:100px;">Fecha Realizada</div>
							<div class="itemHeader2 verticalHeader" style="width:90px;">Usuario</div>
							<div class="itemHeader2 verticalHeader" style="width: 90px;">Cantidad</div>
							<div class="itemHeader2" style="width: 90px;">Cant. Muestra</div>
							<div class="itemHeader2" style="width: 100px;">Cant. Max. Def.</div>
							<div class="itemHeader2 verticalHeader" style="width: 90px;">Defectos</div>
							<div class="itemHeader2 verticalHeader" style="width: 90px;">Resultado</div>
							<div class="itemHeader2 verticalHeader" style="width: 100px;">Cliente</div>
							<div class="itemHeader2 verticalHeader" style="width: 90px;">Sede</div>
							<div class="itemHeader2 verticalHeader" style="width: 90px;">Tip. Serv.</div>
							<div class="itemHeader2 verticalHeader" style="width: 190px;">Taller</div>
							<div class="itemHeader2 verticalHeader" style="width: 190px;">Célula</div>
						</div>
						<div class="tblHeader" id="header-animate" style="position: absolute;top: 0;z-index: 11;left: 0;">
							<div class="itemHeader2 verticalHeader" style="width: 80px;">Ficha</div>
							<div class="itemHeader2 verticalHeader" style="width: 80px;">Pedido</div>
							<div class="itemHeader2 verticalHeader" style="width: 80px;">Color</div>
							<div class="itemHeader2 verticalHeader" style="width: 80px;">Parte</div>
							<div class="itemHeader2 verticalHeader" style="width: 80px;">Num. Vez</div>
							<div class="itemHeader2 verticalHeader" style="width: 100px;">AQL</div>
							<div class="itemHeader2" style="width:100px;">Fecha Realizada</div>
							<div class="itemHeader2 verticalHeader" style="width:90px;">Usuario</div>
							<div class="itemHeader2 verticalHeader" style="width: 90px;">Cantidad</div>
							<div class="itemHeader2" style="width: 90px;">Cant. Muestra</div>
							<div class="itemHeader2" style="width: 100px;">Cant. Max. Def.</div>
							<div class="itemHeader2 verticalHeader" style="width: 90px;">Defectos</div>
							<div class="itemHeader2 verticalHeader" style="width: 90px;">Resultado</div>
							<div class="itemHeader2 verticalHeader" style="width: 100px;">Cliente</div>
							<div class="itemHeader2 verticalHeader" style="width: 90px;">Sede</div>
							<div class="itemHeader2 verticalHeader" style="width: 90px;">Tip. Serv.</div>
							<div class="itemHeader2 verticalHeader" style="width: 190px;">Taller</div>
							<div class="itemHeader2 verticalHeader" style="width: 190px;">Célula</div>
						</div>
						<div class="tblBody">
				<?php
						$sumtot=0;
						$totmue=0;
						$totdef=0;
						$sumapr=0;
						$sumrec=0;
						while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
							$sumtot+=intval($row['CANTIDAD']);
							$totmue+=intval($row['CANAUD']);
							$totdef+=intval($row['CANDEF']);
							if ($row['RESULTADO']=="Aprobado") {
								$sumapr+=intval($row['CANTIDAD']);
							}else{
								$sumrec+=intval($row['CANTIDAD']);
							}
				?>
							<div class="tblLine">
								<div class="itemBody2" style="width: 80px;"><?php echo $row['CODFIC']; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['PEDIDO']; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo utf8_encode($row['DESCOL']); ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['PARTE']; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['NUMVEZ']; ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo $row['AQL']; ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo $row['FECFINAUDFOR']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['DESUSU']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['CANTIDAD']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['CANAUD']; ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo $row['CANDEFMAX']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['CANDEF']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['RESULTADO']; ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo utf8_encode($row['DESCLI']); ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo utf8_encode($row['DESSEDE']); ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo utf8_encode($row['DESTIPSERV']); ?></div>
								<div class="itemBody2" style="width: 190px;"><?php echo utf8_encode($row['DESTLL']); ?></div>
								<div class="itemBody2" style="width: 190px;"><?php echo utf8_encode($row['DESCEL']); ?></div>
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
						<div class="rowLine" id="totales" style="display: block;width: 2000px;position: absolute;bottom: 0;left:0;z-index: 11;background: #000;">
							<div class="tblLine" style="background: #000;color: #fff;border: none;">
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 100px;"></div>
								<div class="itemBody2" style="width: 100px;"></div>
								<div class="itemBody2" style="width: 90px;">TOTAL</div>
								<div class="itemBody2" style="width: 90px;"><?php echo number_format($sumtot); ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo number_format($totmue); ?></div>
								<div class="itemBody2" style="width: 100px;"></div>
								<div class="itemBody2" style="width: 90px;"><?php echo number_format($totdef); ?></div>
								<div class="itemBody2" style="width: 90px;"></div>
								<div class="itemBody2" style="width: 100px;"></div>
								<div class="itemBody2" style="width: 90px;"></div>
								<div class="itemBody2" style="width: 90px;"></div>
								<div class="itemBody2" style="width: 190px;"></div>
								<div class="itemBody2" style="width: 190px;"></div>
							</div>
							<div class="tblLine" style="background: #000;color: #fff;border: none;">
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 100px;"></div>
								<div class="itemBody2" style="width: 100px;"></div>
								<div class="itemBody2" style="width: 90px;">APROBADO</div>
								<div class="itemBody2" style="width: 90px;"><?php echo number_format($sumapr); ?></div>
								<div class="itemBody2" style="width: 90px;"></div>
								<div class="itemBody2" style="width: 100px;"></div>
								<div class="itemBody2" style="width: 90px;"></div>
								<div class="itemBody2" style="width: 90px;"></div>
								<div class="itemBody2" style="width: 100px;"></div>
								<div class="itemBody2" style="width: 90px;"></div>
								<div class="itemBody2" style="width: 90px;"></div>
								<div class="itemBody2" style="width: 190px;"></div>
								<div class="itemBody2" style="width: 190px;"></div>
							</div>
							<div class="tblLine" style="background: #000;color: #fff;border: none;">
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 100px;"></div>
								<div class="itemBody2" style="width: 100px;"></div>
								<div class="itemBody2" style="width: 90px;">RECHAZADO</div>
								<div class="itemBody2" style="width: 90px;"><?php echo number_format($sumrec); ?></div>
								<div class="itemBody2" style="width: 90px;"></div>
								<div class="itemBody2" style="width: 100px;"></div>
								<div class="itemBody2" style="width: 90px;"></div>
								<div class="itemBody2" style="width: 90px;"></div>
								<div class="itemBody2" style="width: 100px;"></div>
								<div class="itemBody2" style="width: 90px;"></div>
								<div class="itemBody2" style="width: 90px;"></div>
								<div class="itemBody2" style="width: 190px;"></div>
								<div class="itemBody2" style="width: 190px;"></div>
							</div>
						</div>
				<?php
						} 
				?>
			</div>
			<div class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;width: 135px;
			padding: 5px;display: flex;padding-left: 20px;<?php echo $hideButtton;?>" 
			onclick="exportar('<?php echo $_GET['codtll']; ?>',<?php echo $_GET['codusu']; ?>,13,
			'<?php echo $_GET['fecini']; ?>','<?php echo $_GET['fecfin']; ?>','<?php echo $_GET['codsede']; ?>','<?php echo $_GET['codtipser']; ?>','<?php echo $titulo;?>')">
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