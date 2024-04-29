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
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
</head>
<body>
	<?php contentMenu();
	$param1="";
	if (isset($_GET['codfic'])) {
		$param1=$_GET['codfic'];
	}
	?>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Consultar fichas</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="sameLine" style="margin-bottom: 5px;">
				<div class="lbl" style="padding-top: 0px;">C&oacute;digo de Ficha</div>
			</div>
			<div class="sameLine" style="margin-bottom: 5px;">
				<div class="spaceIpt" style="width: calc(100% - 10px);font-size: 15px">
					<input type="text" id="idCodFic" class="classIpt" value="<?php echo $param1; ?>">
				</div>
			</div>
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="consultarFichaEstado('ConsultarFichas.php')">Consultar</button>
			</div>		
			<?php
			if (isset($_GET['codfic'])) {				
				include("config/connection.php");
				$sql="select a.parte,
			       	decode(a.estado, 'N', 'No Iniciada', 'I', 'Iniciada', 'T', 'Terminada', 'A', 'Aprobada') estado, 
			       	b.destll Taller, a.canpar Cantidad  
					from fichacosturaavance a, taller b
					where a.codtll = b.codtll and a.codfic = ".$_GET['codfic'];
				$stmt=oci_parse($conn, $sql);
				$result=oci_execute($stmt);
			?>
			<div style="margin-top: 10px;width: 100%;">
				<div class="rowLine" style="display: block;">
					<div class="tblPrendasDefecto">
						<div class="tblHeader">
							<div class="itemHeader2" style="width: 50px;">Parte</div>						
							<div class="itemHeader2" style="width: calc(25% - 10px);">Estado</div>
							<div class="itemHeader2" style="width: calc(50% - 70px);">Taller</div>
							<div class="itemHeader2" style="width: calc(25% - 10px);">Cantidad</div>
						</div>
						<div class="tblBody">
				<?php
						while ($row=oci_fetch_array($stmt,OCI_ASSOC)) {
				?>
							<div class="tblLine">
								<div class="itemBody2" style="width: 50px;"><?php echo $row['PARTE']; ?></div>
								<div class="itemBody2" style="width: calc(25% - 10px);"><?php echo $row['ESTADO']; ?></div>
								<div class="itemBody2" style="width: calc(50% - 70px);"><?php echo $row['TALLER']; ?></div>
								<div class="itemBody2" style="width: calc(25% - 10px);"><?php echo $row['CANTIDAD']; ?></div>
							</div>
				<?php
						}
						if(oci_num_rows($stmt)==0){
				?>
							<div style="color: red;font-size: 15px;padding: 5px;">No hay resultados!</div>
				<?php
						}
				?>
						</div>
					</div>
				</div>
			</div>
			<div class="lbl" style="margin-top: 10px;padding-top: 0px;">Movimientos</div>
			<div style="margin-top: 5px;width: 100%;">
				<div class="rowLine" style="display: block;">
					<div class="tblPrendasDefecto">
						<div class="tblHeader">					
							<!--<div class="itemHeader2" style="width: 70px;">Cod. Fic.</div>-->
							<div class="itemHeader2" style="width: 50px;">Parte</div>
							<div class="itemHeader2" style="width: calc(25% - 10px);">Fec. Mov.</div>
							<!--<div class="itemHeader2" style="width: 70px;">Usu. Mov.</div>-->
							<div class="itemHeader2" style="width: calc(50% - 70px);;">Movimiento</div>
							<div class="itemHeader2" style="width: calc(25% - 10px);;">Cantidad</div>
							<!--<div class="itemHeader2" style="width: 200px;">Taller</div>-->
						</div>
						<div class="tblBody">
				<?php
					$sql="select a.codfic, a.parte, a.fecmov, a.usumov, b.desmov, a.canpar, c.destll  
						from  fichacosturamovimiento a, fichacosturamovimientotipo b, taller c
						where a.tipmov = b.tipmov and a.codtll = c.codtll
						and a.codfic = '".$_GET['codfic']."'
						order by a.fecmov desc";
					$stmt=oci_parse($conn, $sql);
					$result=oci_execute($stmt);
						while ($row=oci_fetch_array($stmt,OCI_ASSOC)) {
				?>
							<div class="tblLine">
								<!--<div class="itemBody2" style="width: 70px;"><?php echo $row['CODFIC']; ?></div>-->
								<div class="itemBody2" style="width: 50px;"><?php echo $row['PARTE']; ?></div>
								<div class="itemBody2" style="width: calc(25% - 10px);;"><?php echo $row['FECMOV']; ?></div>
								<!--<div class="itemBody2" style="width: 70px;"><?php echo $row['USUMOV']; ?></div>-->
								<div class="itemBody2" style="width: calc(50% - 70px);;"><?php echo utf8_encode($row['DESMOV']); ?></div>
								<div class="itemBody2" style="width: calc(25% - 10px);;"><?php echo $row['CANPAR']; ?></div>
								<!--<div class="itemBody2" style="width: 200px;"><?php echo utf8_encode($row['DESTLL']); ?></div>-->
							</div>
				<?php
						}
						if(oci_num_rows($stmt)==0){
				?>
							<div style="color: red;font-size: 15px;padding: 5px;">No hay resultados!</div>
				<?php
						}
				?>
						</div>
					</div>
				</div>
			</div>
			<?php
			}
			?>
		</div>
		<div class="lineWithDecoration"></div>
		<div class="bodyContent" style="padding-bottom: 0px;padding-top: 0px;">
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 5px;" onclick="redirect('main.php')">Terminar</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript" src="js/IniciarFichas.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>