<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="6";
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
	<!-- Iconos de fuente externa -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
</head>
<body>
	<?php contentMenu();?>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Reporte</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">	
			<div class="lblNew">Datos del <?php echo $_GET['fecini']; ?> al <?php echo $_GET['fecfin']; ?></div>
			<?php
				include("config/connection.php");
				$sql="SELECT * FROM FICHAAUDITORIA fa ".
				" inner join AUDITORIAENVIO ae".
				" on fa.CODENV=ae.CODENV".
				" inner join TALLER tll".
				" on ae.CODTLL=tll.CODTLL".
				" inner join USUARIO usua".
				" on fa.CODUSU=usua.ALIUSU".
				" where fa.ESTADO='R'";
				if (isset($_GET['fecini'])) {
					$fecini=strtotime($_GET['fecini']);
					$fecini=date("d/m/Y", $fecini);
					$fecfin=strtotime($_GET['fecfin']);
					$fecfin=date("d/m/Y", $fecfin);
					$sql.=" AND fa.FECFINAUD BETWEEN TO_DATE('".$fecini."','dd/mm/YYYY') AND TO_DATE('".$fecfin."','dd/mm/YYYY')";	
				}
				if($_GET['codtad']!=0){
					$sql.=" AND fa.CODTAD=".$_GET['codtad'];
				}
				if($_GET['codtll']!=0){
					$sql.=" AND tll.CODTLL=".$_GET['codtll'];	
				}
				if($_GET['codusu']!=0){
					$sql.=" AND usua.CODUSU=".$_GET['codusu'];	
				}
				$sql.=" ORDER BY fa.FECFINAUD DESC";
				$stmt=oci_parse($conn, $sql);
				$result=oci_execute($stmt);
			?>
			<div class="mayorContent">
				<div class="rowLine" style="display: block;width: 780px;">
					<div class="tblPrendasDefecto">
						<div class="tblHeader">
							<div class="itemHeader2 verticalHeader" style="width: 80px;">Ficha</div>						
							<div class="itemHeader2" style="width: 100px;">Tipo Auditoria</div>
							<div class="itemHeader2 verticalHeader" style="width: 100px;">AQL</div>
							<div class="itemHeader2" style="width:100px;">Fecha Realizada</div>
							<div class="itemHeader2" style="width: 100px;">Cantidad Parte</div>
							<div class="itemHeader2" style="width: 100px;">Cantidad Max. Def.</div>
							<div class="itemHeader2 verticalHeader" style="width: 100px;">Defectos</div>
							<div class="itemHeader2 verticalHeader" style="width: 100px;">Resultado</div>
						</div>
						<div class="tblBody">
				<?php
						while ($row=oci_fetch_array($stmt,OCI_ASSOC)) {
							$fecha=strtotime($row['FECFINAUD']);
							$fecha=date("Y-m-d", $fecha);
				?>
							<div class="tblLine">
								<div class="itemBody2" style="width: 80px;"><?php echo $row['CODFIC']; ?></div>
								<div class="itemBody2" style="width: 100px;"><?php if($row['CODTAD']==10){echo "Final costura";}else{echo "Otro";} ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo $row['AQL']; ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo $fecha; ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo $row['CANPAR']; ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo $row['CANDEFMAX']; ?></div>
								<div class="itemBody2" style="width: 100px;"><?php echo $row['CANDEF']; ?></div>
								<div class="itemBody2" style="width: 100px;"><?php if($row['RESULTADO']=="A"){echo "Aprobado";}else{echo "Rechazado";} ?></div>
							</div>
				<?php
						}
						if(oci_num_rows($stmt)==0){
				?>
					<div style="color: red;font-size: 18px;">No hay resultados!</div>
				<?php
						}
				?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-bottom: 10px;" onclick="redirect('ReportesAuditoria.php')">Terminar</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript" src="js/graficasDatos.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>