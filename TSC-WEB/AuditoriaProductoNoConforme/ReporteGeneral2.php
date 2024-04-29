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
	<style type="text/css">
		.tblLine {
		    position: relative;
		}
	</style>
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
				if ($_GET['dsccol']=="0") {
					$color="TODOS";
				}else{
					$color=$_GET['dsccol'];
				}
				$titulo="PEDIDO: ".$_GET['pedido']." / COLOR: ".$color;
			?>
			<div class="lblNew" id="spacetitulo"><?php echo $titulo; ?></div>
			<?php
				function format_percent($value){
					$value=str_replace(",",".",$value);
					if ($value[0]==".") {
						$value= "0".$value;
					}
					$value=intval(floatval($value)*1000);
					$value=$value/1000;
					return $value."%";
				}
				$sql="BEGIN SP_APNC_REPORTE_GENERAL_PEDIDO(:PEDIDO,:COLOR,:TIPO,:OUTPUT_CUR); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':PEDIDO', $_GET['pedido']);
				oci_bind_by_name($stmt, ':COLOR', $_GET['dsccol']);
				oci_bind_by_name($stmt, ':TIPO', $_GET['tipo']);
				$OUTPUT_CUR=oci_new_cursor($conn);
				oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
				$result=oci_execute($stmt);
				oci_execute($OUTPUT_CUR);
				$hideButtton="";
			?>
			<div class="mayorContent">
				<?php
				if ($_GET['tipo']=="1") {
				?>
				<div class="rowLine" style="display: block;width: 1750px;">
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
					if ($_GET['tipo']=="2") {
				?>
				<div class="rowLine" style="display: block;width: 2610px;">
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
					}else{
						$ant_descol="";
						$sum2=0;
						$sum3=0;
						$sum4=0;
						$sumtot=0;
						$sumpor=0;
				?>
				<div class="rowLine" style="display: block;width: 870px;">
					<div class="tblPrendasDefecto">
				<?php
						while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
							if ($ant_descol!=utf8_encode($row['DESCOL'])) {
								if ($ant_descol!="") {
				?>
							<div class="tblLine">
								<div class="itemBody2" style="width: 400px;">Total Clas.</div>
								<div class="itemBody2" style="width: 80px;"><?php echo $sum2; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $sum3; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $sum4; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $sumtot; ?></div>
								<div class="itemBody2" style="width: 90px;"></div>
							</div>
							<div class="tblLine">
								<?php
									$sumtot2=0;
									$sumtot3=0;
									$sumtot4=0;
									if ($sum2+$sum3+$sum4!=0) {
										$sumtot2=($sumpor*$sum2)/($sum2+$sum3+$sum4);
										$sumtot3=($sumpor*$sum3)/($sum2+$sum3+$sum4);
										$sumtot4=($sumpor*$sum4)/($sum2+$sum3+$sum4);
									}
								?>
								<div class="itemBody2" style="width: 400px;">%</div>
								<div class="itemBody2" style="width: 80px;"><?php echo format_percent($sumtot2); ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo format_percent($sumtot3); ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo format_percent($sumtot4); ?></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 90px;"><?php echo format_percent($sumpor); ?></div>
							</div>
						</div>
				<?php
								}								
								$sum2=0;
								$sum3=0;
								$sum4=0;
								$sumtot=0;
								$sumpor=0;
								$ant_descol=utf8_encode($row['DESCOL']);
				?>
						<div class="tblHeader" style="margin-top: 10px;">
							<div class="itemHeader2" style="width: 80px;">Pedido</div>
							<div class="itemHeader2" style="width: 140px;">Color</div>
							<div class="itemHeader2" style="width: 80px;">Cant Pedido</div>
							<div class="itemHeader2" style="width: 70px;">Talla</div>
							<div class="itemHeader2" style="width: 80px;">Clas 2</div>
							<div class="itemHeader2" style="width: 80px;">Clas 3</div>
							<div class="itemHeader2" style="width: 80px;">Clas 4</div>
							<div class="itemHeader2" style="width: 80px;">Total Clas</div>
							<div class="itemHeader2" style="width: 90px;">% Clasificación</div>
						</div>
						<div class="tblBody">
				<?php
							}
				?>
							<div class="tblLine">
								<div class="itemBody2" style="width: 80px;"><?php echo $_GET['pedido']; ?></div>
								<div class="itemBody2" style="width: 140px;"><?php echo utf8_encode($row['DESCOL']); ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['CANPED']; ?></div>
								<div class="itemBody2" style="width: 70px;"><?php echo $row['DESTAL']; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['CAN2']; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['CAN3']; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['CAN4']; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $row['CANCLA']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo format_percent($row['PORCLA']); ?></div>
							</div>
				<?php
							$sum2+=intval($row['CAN2']);
							$sum3+=intval($row['CAN3']);
							$sum4+=intval($row['CAN4']);
							$sumtot+=intval($row['CANCLA']);
							$sumpor+=floatval(str_replace(",",".",$row['PORCLA']));
						}
					}
				}
				if(oci_num_rows($OUTPUT_CUR)==0){
					$hideButtton="display:none;";
				?>
					<div style="color: red;font-size: 18px; padding: 5px;font-size: 14px;">No hay resultados!</div>
				<?php
				}
				if ($_GET['tipo']=="3") {
				?>
							<div class="tblLine">
								<div class="itemBody2" style="width: 400px;">Total Clas.</div>
								<div class="itemBody2" style="width: 80px;"><?php echo $sum2; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $sum3; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $sum4; ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo $sumtot; ?></div>
								<div class="itemBody2" style="width: 90px;"></div>
							</div>
							<div class="tblLine">
								<?php
									$sumtot2=0;
									$sumtot3=0;
									$sumtot4=0;
									if ($sum2+$sum3+$sum4!=0) {
										$sumtot2=($sumpor*$sum2)/($sum2+$sum3+$sum4);
										$sumtot3=($sumpor*$sum3)/($sum2+$sum3+$sum4);
										$sumtot4=($sumpor*$sum4)/($sum2+$sum3+$sum4);
									}
								?>
								<div class="itemBody2" style="width: 400px;">%</div>
								<div class="itemBody2" style="width: 80px;"><?php echo format_percent($sumtot2); ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo format_percent($sumtot3); ?></div>
								<div class="itemBody2" style="width: 80px;"><?php echo format_percent($sumtot4); ?></div>
								<div class="itemBody2" style="width: 80px;"></div>
								<div class="itemBody2" style="width: 90px;"><?php echo format_percent($sumpor); ?></div>
							</div>
				<?php
				}
				?>
						</div>
					</div>
				</div>
			</div>
			<div class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;width: 135px;
			padding: 5px;display: flex;padding-left: 20px;<?php echo $hideButtton;?>" 
			onclick="exportar2('<?php echo $_GET['pedido']; ?>','<?php echo $_GET['dsccol']; ?>','<?php echo $_GET['tipo']; ?>','<?php echo $titulo;?>')">
				<img src="assets/img/excel.png" style="width: 30px;height: 30px;">
				<div style="padding: 5px;width:calc(80px);text-align: center;">Descargar</div>
			</div>
			<div class="lineDecoration"></div>
		</div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="window.history.back();">Volver</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript" src="js/ReporteGeneral-v1.0.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">		
		document.getElementById("ctrl-scroll").addEventListener("scroll",function(){
			if (document.getElementById("head-movil")) {
				document.getElementById("head-movil").style.top=document.getElementById("ctrl-scroll").scrollTop+"px";	
			}
			if(document.getElementById("head-movil2")){
				document.getElementById("head-movil2").style.top=document.getElementById("ctrl-scroll").scrollTop+"px";
			}
		});
	</script>
		<?php
		if ($_GET['tipo']=="3") {
		?>
		<script type="text/javascript">
			var ar=document.getElementsByClassName("tblBody");
			var cantal=ar[0].getElementsByClassName("tblLine").length-2;
			for (var i = 0; i < ar.length; i++) {
				var ar_2=ar[i].getElementsByClassName("tblLine");
				var txt1=ar_2[0].getElementsByClassName("itemBody2")[0].innerHTML;
				var txt2=ar_2[0].getElementsByClassName("itemBody2")[1].innerHTML;
				var txt3=ar_2[0].getElementsByClassName("itemBody2")[2].innerHTML;
				var heitam=26*cantal-11;
				ar_2[0].innerHTML+='<div class="itemBody2" style="width: 80px;background:#fff;position:absolute;height:'+heitam+'px;z-index:5;display: flex;justify-content: center;align-items: center;">'+txt1+'</div>';
				ar_2[0].innerHTML+='<div class="itemBody2" style="width: 140px;background:#fff;position:absolute;left: 90px;height:'+heitam+'px;z-index:5;display: flex;justify-content: center;align-items: center;">'+txt2+'</div>';
				ar_2[0].innerHTML+='<div class="itemBody2" style="width: 80px;background:#fff;position:absolute;left: 240px;height:'+heitam+'px;z-index:5;display: flex;justify-content: center;align-items: center;">'+txt3+'</div>';
			}
		</script>
		<?php
		}
		?>
</body>
</html>