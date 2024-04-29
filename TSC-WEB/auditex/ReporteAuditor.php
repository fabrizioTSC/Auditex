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

	<link rel="stylesheet" href="css/jquery/jquery-ui-1.12.1.css">
	<script href="js/jquery/jquery-1.12.1.js"></script>
  	<script src="js/jquery/jquery-ui-1.12.1.js"></script>
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
			<div class="headerTitle">Reporte por Auditor</div>
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
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);" onclick="consultar('ReporteAuditor.php')">Consultar</button>
			</div>		
			<?php
			if (isset($_GET['fecini'])) {
				$array_fecini=explode("/",$_GET['fecini']);
				$fecini=$array_fecini[2].$array_fecini[1].$array_fecini[0];
				$array_fecfin=explode("/",$_GET['fecfin']);
				$fecfin=$array_fecfin[2].$array_fecfin[1].$array_fecfin[0];
				
				include("config/connection.php");
				$sql="select nvl(fa.codusu,'-') CODUSU, count(*) AUDITORIA, nvl(a.cantidad,'0') aprobado, nvl(r.cantidad,'0') rechazado, sum(fa.canpar) Prendas, sum(fa.canaud) Auditado, sum(fa.candef) Defectos
				  	from fichaauditoria fa 
				   	left join
				    (select fa.codusu, count(*) cantidad
				    from fichaauditoria fa
				    where to_char(fa.feciniaud,'YYYYMMDD') >= '".$fecini."' 
				    and to_char(fa.feciniaud,'YYYYMMDD') <= '".$fecfin."'
				    and fa.estado = 'T' and fa.resultado = 'A'
				    group by fa.codusu) a on fa.codusu = a.codusu or (fa.codusu is null and a.codusu is null)
				 	left join
				    (select fa.codusu, count(*) cantidad
				    from fichaauditoria fa
				    where to_char(fa.feciniaud,'YYYYMMDD') >= '".$fecini."' 
				    and to_char(fa.feciniaud,'YYYYMMDD') <= '".$fecfin."'
				    and fa.estado = 'T' and fa.resultado = 'R'
				    group by fa.codusu) r on fa.codusu = r.codusu or (fa.codusu is null and r.codusu is null)       
				 	where to_char(fa.feciniaud,'YYYYMMDD') >= '".$fecini."' 
					and to_char(fa.feciniaud,'YYYYMMDD') <= '".$fecfin."'
					and fa.estado = 'T'
				 	group by fa.codusu, a.cantidad, r.cantidad";
				$stmt=oci_parse($conn, $sql);
				$result=oci_execute($stmt);
				$hiddenBtn="";
			?>
			<div style="margin-top: 10px;width: 100%;">
				<div class="rowLine" style="display: block;">
					<div class="tblPrendasDefecto" style="overflow-x: scroll;">
						<div class="tblHeader" style="width: 700px">
							<div class="itemHeader2" style="width: 90px;">Usuario</div>						
							<div class="itemHeader2" style="width: 90px;">Auditoria</div>
							<div class="itemHeader2" style="width: 90px;">Cant. Apro.</div>
							<div class="itemHeader2" style="width: 90px;">Cant. Rech.</div>
							<div class="itemHeader2" style="width: 90px;">Cant. Prendas</div>
							<div class="itemHeader2" style="width: 90px;">Cant. Auditada</div>
							<div class="itemHeader2" style="width: 90px;">Cant. Defectos</div>
						</div>
						<div class="tblBody" style="width: 700px">
				<?php
						while ($row=oci_fetch_array($stmt,OCI_ASSOC)) {
				?>
							<div class="tblLine">
								<div class="itemBody2" style="width: 90px;"><?php echo $row['CODUSU']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['AUDITORIA']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['APROBADO']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['RECHAZADO']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['PRENDAS']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['AUDITADO']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['DEFECTOS']; ?></div>	
							</div>
				<?php
						}
						if(oci_num_rows($stmt)==0){
							$hiddenBtn="display:none;";
				?>
							<div style="color: red;font-size: 15px;padding: 5px;">No hay resultados!</div>
				<?php
						}
				?>
						</div>
					</div>
					<div class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 10px;width: 135px;
					padding: 5px;display: flex;padding-left: 20px;<?php echo $hiddenBtn;?>" onclick="exportarAuditor()">
						<img src="assets/img/excel.png" style="width: 30px;height: 30px;">
						<div style="padding: 5px;width:calc(80px);text-align: center;">Descargar</div>
					</div>
				</div>
			</div>
			<?php
			}
			?>
		</div>
		<div class="bodyContent" style="padding-bottom: 10px;padding-top: 0px;">
			<div class="lineDecoration"></div>
			<div class="rowLine bodyPrimary">
				<button class="btnPrimary" style="margin-left: calc(50% - 80px);margin-top: 5px;" onclick="redirect('ReportesAuditoria.php')">Terminar</button>
			</div>		
		</div>
	</div>
	<script type="text/javascript">
		var feciniget='<?php if(isset($_GET['fecini'])){echo $_GET['fecini'];}else{ echo "";} ?>';
	</script>
	<script type="text/javascript" src="js/reportes.js"></script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>