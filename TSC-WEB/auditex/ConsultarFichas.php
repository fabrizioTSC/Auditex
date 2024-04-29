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
	<div class="panelCarga" style="display: none;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
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

				$descli="";
				$sql="BEGIN SP_AFC_GET_INFOPARTIDA(:CODFIC,:OUTPUT_CUR); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt,':CODFIC',$_GET['codfic']);
				$OUTPUT_CUR=oci_new_cursor($conn);
				oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
				$result=oci_execute($stmt);
				oci_execute($OUTPUT_CUR);
				while($row=oci_fetch_assoc($OUTPUT_CUR)){
					$descli=utf8_encode($row['DESCLI']);
				}		

				$sql="BEGIN SP_AT_SELECT_ESTADOFICHAS(:CODFIC,:OPCION,:OUTPUT_CUR); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':CODFIC',$_GET['codfic']);
				$opcion=1;
				oci_bind_by_name($stmt, ':OPCION',$opcion);
				$OUTPUT_CUR=oci_new_cursor($conn);
				oci_bind_by_name($stmt, ':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
				$result=oci_execute($stmt);
				oci_execute($OUTPUT_CUR);
				$ficdel=new stdClass();
			?>
			<div style="margin-top: 10px;width: 100%;">
				<div class="rowLine" style="display: block;">
					<div class="tblPrendasDefecto">
						<div class="tblHeader">
							<div class="itemHeader2" style="width: 50px;">Parte</div>						
							<div class="itemHeader2" style="width: calc(20% - 25px);">Estado</div>
							<div class="itemHeader2" style="width: calc(30% - 25px);">Cliente</div>
							<div class="itemHeader2" style="width: calc(30% - 25px);">Taller</div>
							<div class="itemHeader2" style="width: calc(20% - 25px);">Cantidad</div>
						</div>
						<div class="tblBody">
				<?php
						while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
							$ficdel->CODFIC=$_GET['codfic'];
							$ficdel->PARTE=$row['PARTE'];
							$ficdel->CODTLL=$row['CODTLL'];
							$ficdel->ESTADO=$row['ESTADO'];
				?>
							<div class="tblLine">
								<div class="itemBody2" style="width: 50px;"><?php echo $row['PARTE']; ?></div>
								<div class="itemBody2" style="width: calc(20% - 25px);"><?php echo $row['ESTADO']; ?></div>
								<div class="itemBody2" style="width: calc(30% - 25px);"><?php echo $descli; ?></div>
								<div class="itemBody2" style="width: calc(30% - 25px);"><?php echo $row['TALLER']; ?></div>
								<div class="itemBody2" style="width: calc(20% - 25px);"><?php echo $row['CANTIDAD']; ?></div>
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
					$sql="BEGIN SP_AT_SELECT_ESTADOFICHAS(:CODFIC,:OPCION,:OUTPUT_CUR); END;";
					$stmt=oci_parse($conn, $sql);
					oci_bind_by_name($stmt, ':CODFIC',$_GET['codfic']);
					$opcion=2;
					oci_bind_by_name($stmt, ':OPCION',$opcion);
					$OUTPUT_CUR=oci_new_cursor($conn);
					oci_bind_by_name($stmt, ':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
					$result=oci_execute($stmt);
					oci_execute($OUTPUT_CUR);
						while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
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
						if(oci_num_rows($OUTPUT_CUR)==0){
				?>
							<div style="color: red;font-size: 15px;padding: 5px;">No hay resultados!</div>
				<?php
						}
				?>
						</div>
					</div>
				</div>
				<?php 
					if (isset($ficdel->ESTADO)) {
						if (($_SESSION['perfil']=="2" || $_SESSION['perfil']=="1") && $ficdel->ESTADO=="Iniciada") {
					echo
				'<div class="rowLine bodyPrimary">
					<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 5px;" onclick="delete_ingreso('.$ficdel->CODFIC.','.
					$ficdel->PARTE.',\''.
					$ficdel->CODTLL.'\')">Eliminar inicio</button>
				</div>	';
						}
					}
				?>
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
	<script type="text/javascript" src="js/IniciarFichas-v1.1.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>