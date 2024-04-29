<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="14";
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
			<div class="headerTitle">Reporte General</div>
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
				$ar_fecini=explode("-",$_GET['fecini']);
				$ar_fecfin=explode("-",$_GET['fecfin']);
				$titulo.=$ar_fecini[2]."-".$ar_fecini[1]."-".$ar_fecini[0]." al ".$ar_fecfin[2]."-".$ar_fecfin[1]."-".$ar_fecfin[0];
			?>
			<div class="lblNew" id="spacetitulo"><?php echo $titulo; ?></div>
			<?php
				$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
				$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];
				$sql="BEGIN SP_APNC_REPORTE_GENERAL(:CODSED,:CODTIPSER,:FECINI,:FECFIN,:TIPO,:OUTPUT_CUR); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':CODSED', $_GET['codsede']);
				oci_bind_by_name($stmt, ':CODTIPSER', $_GET['codtipser']);
				oci_bind_by_name($stmt, ':FECINI', $fecini);
				oci_bind_by_name($stmt, ':FECFIN', $fecfin);
				oci_bind_by_name($stmt, ':TIPO', $_GET['tipo']);
				$OUTPUT_CUR=oci_new_cursor($conn);
				oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
				$result=oci_execute($stmt);
				oci_execute($OUTPUT_CUR);
				$hideButtton="";
			?>
			<div class="mayorContent" id="ctrl-scroll">
				<?php
				if ($_GET['tipo']=="1") {
				?>
				<div class="rowLine" style="display: block;width: 1850px;">
					<div class="tblPrendasDefecto" style="position: relative;">
						<div class="tblHeader">
							<div class="itemHeader2" style="width: 80px;">Pedido</div>
							<div class="itemHeader2" style="width: 130px;">Color</div>
							<div class="itemHeader2" style="width: 80px;">Ficha</div>
							<div class="itemHeader2" style="width: 100px;">Generado</div>
							<div class="itemHeader2" style="width: 80px;">Parte</div>
							<div class="itemHeader2" style="width: 100px;">Auditor</div>
							<div class="itemHeader2" style="width: 90px;">Fecha</div>
							<div class="itemHeader2" style="width: 90px;">Cant Ficha</div>
							<div class="itemHeader2" style="width: 90px;">Cant Muestra</div>
							<div class="itemHeader2" style="width: 90px;">Cant Def</div>
							<div class="itemHeader2" style="width: 90px;">Cant Rec</div>
							<div class="itemHeader2" style="width: 120px;">Taller</div>
							<div class="itemHeader2" style="width: 120px;">Sede</div>
							<div class="itemHeader2" style="width: 120px;">Tipo de servicio</div>
							<div class="itemHeader2" style="width: 120px;">Cliente</div>
							<div class="itemHeader2" style="width: 90px;">Estilo TSC</div>
							<div class="itemHeader2" style="width: 90px;">Estilo cliente</div>
						</div>
						<div class="tblHeader" id="head-movil" style="position: absolute;top: 0;left: 0;">
							<div class="itemHeader2" style="width: 80px;">Pedido</div>
							<div class="itemHeader2" style="width: 130px;">Color</div>
							<div class="itemHeader2" style="width: 80px;">Ficha</div>
							<div class="itemHeader2" style="width: 100px;">Generado</div>
							<div class="itemHeader2" style="width: 80px;">Parte</div>
							<div class="itemHeader2" style="width: 100px;">Auditor</div>
							<div class="itemHeader2" style="width: 90px;">Fecha</div>
							<div class="itemHeader2" style="width: 90px;">Cant Ficha</div>
							<div class="itemHeader2" style="width: 90px;">Cant Muestra</div>
							<div class="itemHeader2" style="width: 90px;">Cant Def</div>
							<div class="itemHeader2" style="width: 90px;">Cant Rec</div>
							<div class="itemHeader2" style="width: 120px;">Taller</div>
							<div class="itemHeader2" style="width: 120px;">Sede</div>
							<div class="itemHeader2" style="width: 120px;">Tipo de servicio</div>
							<div class="itemHeader2" style="width: 120px;">Cliente</div>
							<div class="itemHeader2" style="width: 90px;">Estilo TSC</div>
							<div class="itemHeader2" style="width: 90px;">Estilo cliente</div>
						</div>
						<div class="tblBody">
				<?php
						while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
				?>
							<div class="tblLine">
								<div class="itemBody2" style="width: 80px;"><?php echo $row['PEDIDO']; ?></div>
								<div class="itemBody2" style="width: 130px;"><?php echo utf8_encode($row['DSCCOL']); ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['CODFIC']; ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo $row['GENERADO']; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['PARTE']; ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo $row['CODUSU']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['FECINIAUD']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['CANTIDAD']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['CANMUE']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['CANDEF']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['CANRECUP']; ?></div>
								<div class="itemBody2" style="width: 120px;"><?php echo utf8_encode($row['DESTLL']); ?></div>
								<div class="itemBody2" style="width: 120px;"><?php echo $row['DESSEDE']; ?></div>
								<div class="itemBody2" style="width: 120px;"><?php echo $row['DESTIPSERV']; ?></div>
								<div class="itemBody2" style="width: 120px;"><?php echo utf8_encode($row['DESCLI']); ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo utf8_encode($row['ESTTSC']); ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo utf8_encode($row['ESTCLI']); ?></div>
							</div>
				<?php
						}
				}else{
				?>
				<div class="rowLine" style="display: block;width: 2710px;">
					<div class="tblPrendasDefecto" style="position: relative;">
						<div class="tblHeader">
							<div class="itemHeader2" style="width: 80px;">Pedido</div>
							<div class="itemHeader2" style="width: 130px;">Color</div>
							<div class="itemHeader2" style="width: 80px;">Ficha</div>
							<div class="itemHeader2" style="width: 100px;">Generado</div>
							<div class="itemHeader2" style="width: 80px;">Parte</div>
							<div class="itemHeader2" style="width: 100px;">Auditor</div>
							<div class="itemHeader2" style="width: 90px;">Fecha</div>
							<div class="itemHeader2" style="width: 90px;">Cant Ficha</div>
							<div class="itemHeader2" style="width: 90px;">Cant Muestra</div>
							<div class="itemHeader2" style="width: 90px;">Talla</div>
							<div class="itemHeader2" style="width: 90px;">Clas 2</div>
							<div class="itemHeader2" style="width: 90px;">Clas 3</div>
							<div class="itemHeader2" style="width: 90px;">Clas 4</div>
							<div class="itemHeader2" style="width: 90px;">Cant Clas</div>
							<div class="itemHeader2" style="width: 90px;">Cod Def</div>
							<div class="itemHeader2" style="width: 160px;">Defecto</div>
							<div class="itemHeader2" style="width: 130px;">Familia</div>
							<div class="itemHeader2" style="width: 130px;">Ubicación</div>
							<div class="itemHeader2" style="width: 130px;">Observación</div>
							<div class="itemHeader2" style="width: 120px;">Sede</div>
							<div class="itemHeader2" style="width: 120px;">Tipo de servicio</div>
							<div class="itemHeader2" style="width: 120px;">Cliente</div>
							<div class="itemHeader2" style="width: 90px;">Estilo TSC</div>
							<div class="itemHeader2" style="width: 90px;">Estilo cliente</div>
						</div>
						<div class="tblHeader" id="head-movil2" style="position: absolute;top: 0;left: 0;">
							<div class="itemHeader2" style="width: 80px;">Pedido</div>
							<div class="itemHeader2" style="width: 130px;">Color</div>
							<div class="itemHeader2" style="width: 80px;">Ficha</div>
							<div class="itemHeader2" style="width: 100px;">Generado</div>
							<div class="itemHeader2" style="width: 80px;">Parte</div>
							<div class="itemHeader2" style="width: 100px;">Auditor</div>
							<div class="itemHeader2" style="width: 90px;">Fecha</div>
							<div class="itemHeader2" style="width: 90px;">Cant Ficha</div>
							<div class="itemHeader2" style="width: 90px;">Cant Muestra</div>
							<div class="itemHeader2" style="width: 90px;">Talla</div>
							<div class="itemHeader2" style="width: 90px;">Clas 2</div>
							<div class="itemHeader2" style="width: 90px;">Clas 3</div>
							<div class="itemHeader2" style="width: 90px;">Clas 4</div>
							<div class="itemHeader2" style="width: 90px;">Cant Clas</div>
							<div class="itemHeader2" style="width: 90px;">Cod Def</div>
							<div class="itemHeader2" style="width: 160px;">Defecto</div>
							<div class="itemHeader2" style="width: 130px;">Familia</div>
							<div class="itemHeader2" style="width: 130px;">Ubicación</div>
							<div class="itemHeader2" style="width: 130px;">Observación</div>
							<div class="itemHeader2" style="width: 120px;">Sede</div>
							<div class="itemHeader2" style="width: 120px;">Tipo de servicio</div>
							<div class="itemHeader2" style="width: 120px;">Cliente</div>
							<div class="itemHeader2" style="width: 90px;">Estilo TSC</div>
							<div class="itemHeader2" style="width: 90px;">Estilo cliente</div>
						</div>
						<div class="tblBody">
				<?php
						while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
				?>
							<div class="tblLine">
								<div class="itemBody2" style="width: 80px;"><?php echo $row['PEDIDO']; ?></div>
								<div class="itemBody2" style="width: 130px;"><?php echo utf8_encode($row['DSCCOL']); ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['CODFIC']; ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo $row['GENERADO']; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['PARTE']; ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo $row['CODUSU']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['FECINIAUD']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['CANTIDAD']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['CANMUE']; ?></div>

								<div class="itemBody2" style="width: 90px;"><?php echo utf8_encode($row['DESTAL']); ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['CANFIN2']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['CANFIN3']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['CANFIN4']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['CANCLA']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['CODDEFAUX']; ?></div>
								<div class="itemBody2" style="width: 160px;"><?php echo utf8_encode($row['DESDEF']); ?></div>
								<div class="itemBody2" style="width: 130px;"><?php echo utf8_encode($row['DSCFAMILIA']); ?></div>
								<div class="itemBody2" style="width: 130px;"><?php echo utf8_encode($row['DESUBIDEF']); ?></div>
								<div class="itemBody2" style="width: 130px;"><?php echo utf8_encode($row['OBS']); ?></div>

								<div class="itemBody2" style="width: 120px;"><?php echo $row['DESSEDE']; ?></div>
								<div class="itemBody2" style="width: 120px;"><?php echo $row['DESTIPSERV']; ?></div>
								<div class="itemBody2" style="width: 120px;"><?php echo utf8_encode($row['DESCLI']); ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo utf8_encode($row['ESTTSC']); ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo utf8_encode($row['ESTCLI']); ?></div>
							</div>
				<?php
					}
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
			onclick="exportar('<?php echo $_GET['codsede']; ?>','<?php echo $_GET['codtipser']; ?>','<?php echo $_GET['tipo']; ?>',
			'<?php echo $_GET['fecini']; ?>','<?php echo $_GET['fecfin']; ?>','<?php echo $titulo;?>')">
				<img src="assets/img/excel.png" style="width: 30px;height: 30px;">
				<div style="padding: 5px;width:calc(80px);text-align: center;">Descargar</div>
			</div>
			<div class="lineDecoration"></div>
		</div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<!-- <button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="redirect('main.php')">Volver</button> -->
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="window.history.back();">Volver</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript" src="js/ReporteGeneral-v1.0.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		function goBack(){
			window.history.back();
		}
		document.getElementById("ctrl-scroll").addEventListener("scroll",function(){
			if (document.getElementById("head-movil")) {
				document.getElementById("head-movil").style.top=document.getElementById("ctrl-scroll").scrollTop+"px";	
			}
			if(document.getElementById("head-movil2")){
				document.getElementById("head-movil2").style.top=document.getElementById("ctrl-scroll").scrollTop+"px";
			}
		});
	</script>
</body>
</html>