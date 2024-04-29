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
	<!-- Iconos de fuente externa -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
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
			<div class="headerTitle">Consultar fichas iniciadas</div>
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
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="consultarFichaEstado('ConsultarFichasTerminadas.php')">Consultar</button>
			</div>		
			<?php
			if (isset($_GET['codfic'])) {				
				include("config/connection.php");
				$sql="select * from fichacosturaavance WHERE CODFIC=".$_GET['codfic'];
				$stmt=oci_parse($conn, $sql);
				$result=oci_execute($stmt);
			?>
			<div style="margin-top: 10px;width: 100%;">
				<div class="rowLine" style="display: block;">
					<div class="tblPrendasDefecto">
						<div class="tblHeader">
							<div class="itemHeader2" style="width: 50%;">C&oacute;digo Ficha</div>						
							<div class="itemHeader2" style="width: 50%;">Estado</div>
						</div>
						<div class="tblBody">
				<?php
						while ($row=oci_fetch_array($stmt,OCI_ASSOC)) {
							$estado="";
							if ($row['ESTADO']=="I") {
								$estado="Iniciada";
							}elseif ($row['ESTADO']=="N"){
								$estado="Env&iacute;o";
							}elseif ($row['ESTADO']=="T"){
								$estado="Terminada";
							}elseif ($row['ESTADO']=="A"){
								$estado="Aprobada";
							}
				?>
							<div class="tblLine">
								<div class="itemBody2" style="width: 50%;"><?php echo $row['CODFIC']; ?></div>
								<div class="itemBody2" style="width: 50%;"><?php echo $estado; ?></div>
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