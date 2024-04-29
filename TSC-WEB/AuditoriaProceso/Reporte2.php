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

	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
	<?php contentMenu();
	$param1="";
	$param2="";
	if (isset($_GET['fecini'])) {
		$param1=$_GET['fecini'];
		$param2=$_GET['fecfin'];
	}
	?>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Reporte 2</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="sameLine" style="margin-bottom: 5px;">
				<div class="lbl" style="padding-top: 0px;">Ingrese fechas</div>
			</div>
			<div class="sameLine" style="margin-bottom: 5px;">
				<div class="lbl" style="width: 70px;">Desde:</div>
				<div class="spaceIpt" style="width: calc(100% - 70px);font-size: 15px">
					<input type="text" id="idFechaDesde" class="classIpt" value="<?php echo $param1; ?>">
				</div>
			</div>
			<div class="sameLine" style="margin-bottom: 10px;">
				<div class="lbl" style="width: 70px;">Hasta:</div>
				<div class="spaceIpt" style="width: calc(100% - 70px);font-size: 15px">
					<input type="text" id="idFechaHasta" class="classIpt" value="<?php echo $param2; ?>">
				</div>
			</div>
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="consultar('Reporte2.php')">Consultar</button>
			</div>		
			<?php
			if (isset($_GET['fecini'])) {
				$fecini=strtotime($_GET['fecini']);
				$fecini=date("Ymd", $fecini);
				$fecfin=strtotime($_GET['fecfin']);
				$fecfin=date("Ymd", $fecfin);
				
				include("config/connection.php");
				$sql="select a.codtll as CODTLL, t.destll as DESTLL, sum(a.canaud) canaud, sum(a.canteo) canteo, 
				round(100*sum(a.canteo)/sum(a.canaud),2) efi 
					from (
    					select ae.codtll, fa.canaud, case fa.resultado when 'A' then fa.canaud else 0 end canteo from  fichaauditoria fa, auditoriaenvio ae
    					where fa.codenv = ae.codenv and (fa.codfic, fa.codtad, fa.parte) in
    					(select codfic, codtad, parte from fichaauditoria fa where fa.codenv = ae.codenv
    					and fa.estado = 'T' and fa.resultado = 'A'
    					and to_char(fa.feciniaud,'YYYYMMDD') >= '".$fecini."'
    					and to_char(fa.feciniaud,'YYYYMMDD') <= '".$fecfin."'
    				)
    			) a, taller t
    			where a.codtll = t.codtll
    			group by a.codtll, t.destll
    			order by efi desc, t.destll";
				$stmt=oci_parse($conn, $sql);
				$result=oci_execute($stmt);
				$validador=false;
			?>
			<div style="margin-top: 10px;width: 100%;">
				<div class="rowLine" style="display: block;">
					<div class="tblPrendasDefecto" style="overflow-x: scroll;">
						<div class="tblHeader tblExpanded">
							<div class="itemHeader2 verticalHeader itemSpace1">Cod. Taller</div>						
							<div class="itemHeader2 verticalHeader itemSpace2">Taller</div>
							<div class="itemHeader2 itemSpace3">Cant. Auditoria</div>
							<div class="itemHeader2 itemSpace4">Cant. Te&oacute;rica</div>
							<div class="itemHeader2 verticalHeader itemSpace5">Eficiencia</div>
						</div>
						<div class="tblBody tblExpanded">
				<?php
						while ($row=oci_fetch_array($stmt,OCI_ASSOC)) {
							if ($row['CODTLL']!="") {
								$validador=true;
							}
				?>
							<div class="tblLine">
								<div class="itemBody2 itemSpace1"><?php echo $row['CODTLL']; ?></div>
								<div class="itemBody2 itemSpace2"><?php echo $row['DESTLL']; ?></div>
								<div class="itemBody2 itemSpace3"><?php echo $row['CANAUD']; ?></div>
								<div class="itemBody2 itemSpace3"><?php echo $row['CANTEO']; ?></div>
								<div class="itemBody2 itemSpace3"><?php echo $row['EFI']; ?></div>
							</div>
				<?php
						}
						if(oci_num_rows($stmt)==0 || $validador==false){
				?>
							<div style="color: red;font-size: 15px;padding: 5px;">No hay resultados!</div>
						</div>
				<?php
						}else{
				?>
						</div>
					</div>
					<div class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;width: 135px;
					padding: 5px;display: flex;padding-left: 20px;" onclick="exportar2()">
						<img src="assets/img/excel.png" style="width: 30px;height: 30px;">
						<div style="padding: 5px;width:calc(80px);text-align: center;">Descargar</div>
				<?php		
						}
				?>
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
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 5px;margin-bottom: 10px;" onclick="redirect('ReportesAuditoria.php')">Terminar</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript" src="js/reportes.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>