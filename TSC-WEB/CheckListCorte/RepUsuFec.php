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
			<div class="headerTitle">Reporte Usuario/Fecha</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">
			<div class="sameLine hideMargin" style="margin-bottom: 5px;">
				<div class="lbl" style="padding-top: 0px;">Ingrese fechas</div>
			</div>
			<div class="sameLine hideMargin" style="margin-bottom: 5px;">
				<div class="lbl" style="width: 70px;">Desde:</div>
				<div class="spaceIpt" style="width: calc(100% - 70px);font-size: 15px">
					<input type="text" id="idFechaDesde" class="classIpt" value="<?php echo $param1; ?>" style="width: auto;">
				</div>
			</div>
			<div class="sameLine hideMargin" style="margin-bottom: 10px;">
				<div class="lbl" style="width: 70px;">Hasta:</div>
				<div class="spaceIpt" style="width: calc(100% - 70px);font-size: 15px">
					<input type="text" id="idFechaHasta" class="classIpt" value="<?php echo $param2; ?>" style="width: auto;">
				</div>
			</div>
			<div class="rowLine bodyPrimary" style="display: flex;">
				<button class="btnPrimary" style="width: auto;margin-right: 5px;" onclick="consultar('RepUsuFec.php')">Consultar</button>
				<div class="btnPrimary" style="width: 135px;margin-right: 5px;
				padding: 5px;display: flex;padding-left: 20px;" onclick="exportar()" id="spaceBtnExport">
					<img src="assets/img/excel.png" style="width: 30px;height: 30px;">
					<div style="padding: 5px;width:calc(80px);text-align: center;">Descargar</div>
				</div>
				<button class="btnPrimary" style="width: auto;" onclick="window.history.back();">Volver</button>
			</div>	
			<?php
			$hiddenBtn="";
			if (isset($_GET['fecini'])) {
				include("config/connection.php");

				$array_fecini=explode("/",$_GET['fecini']);
				$fecini=$array_fecini[2].$array_fecini[1].$array_fecini[0];
				$array_fecfin=explode("/",$_GET['fecfin']);
				$fecfin=$array_fecfin[2].$array_fecfin[1].$array_fecfin[0];

				$sql="BEGIN SP_CLC_REPORTES_EJECUTIVO(:FECINI,:FECFIN,:OPCION,:OUTPUT_CUR); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':FECINI', $fecini);
				oci_bind_by_name($stmt, ':FECFIN', $fecfin);
				$opcion=0;
				oci_bind_by_name($stmt, ':OPCION', $opcion);
				$OUTPUT_CUR=oci_new_cursor($conn);
				oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
				$result=oci_execute($stmt);
				oci_execute($OUTPUT_CUR);
			?>
			<div style="margin-top: 10px;width: 100%;">
				<div class="rowLine" style="display: block;">
					<div class="tblPrendasDefecto" style="overflow-x: scroll;">
						<div class="tblHeader" style="width: 600px">
							<div class="itemHeader2 " style="width: 90px;">Usuario</div>						
							<div class="itemHeader2 " style="width: 90px;">Fecha</div>
							<div class="itemHeader2 " style="width: 90px;">Check List</div>
							<div class="itemHeader2" style="width: 90px;">Cant. Ter.</div>
							<div class="itemHeader2" style="width: 90px;">Cant. Pen.</div>
							<div class="itemHeader2" style="width: 90px;">Cant. Prendas</div>
						</div>
						<div class="tblBody" style="width: 600px">
				<?php
						while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
				?>
							<div class="tblLine">
								<div class="itemBody2" style="width: 90px;"><?php echo $row['CODUSU']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['FECHA']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['AUDITORIA']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['TERMINADO']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['PENDIENTE']; ?></div>
								<div class="itemBody2" style="width: 90px;"><?php echo $row['PRENDAS']; ?></div>
							</div>
				<?php
						}
						if(oci_num_rows($OUTPUT_CUR)==0){
							$hiddenBtn="none";
				?>
							<div style="color: red;font-size: 15px;padding: 5px;">No hay resultados!</div>
				<?php
						}else{
							$hiddenBtn="flex";
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
	</div>
	<script type="text/javascript">
		<?php
			if ($hiddenBtn=="") {
		?>
		$("#spaceBtnExport").css("display","none");
		<?php
			}else{
		?>
		$("#spaceBtnExport").css("display","<?php echo $hiddenBtn; ?>");
		<?php
			}
		?>
		var feciniget='<?php if(isset($_GET['fecini'])){echo $_GET['fecini'];}else{ echo "";} ?>';
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#idFechaDesde").datepicker({dateFormat: 'dd/mm/yy'});
			$("#idFechaHasta").datepicker({dateFormat: 'dd/mm/yy'});
			if (feciniget=="") {
				var fecha=new Date();
				var dia=fecha.getDate();
				dia=""+dia;
				if (dia.length==1) {
					dia="0"+dia;
				}
				var mes=fecha.getMonth()+1;
				mes=""+mes;
				if (mes.length==1) {
					mes="0"+mes;
				}
				var anio=fecha.getFullYear();
				var hoy=dia+"/"+mes+"/"+anio;
				document.getElementById("idFechaDesde").value=hoy;
				document.getElementById("idFechaHasta").value=hoy;
			}
		});
		function consultar(path){
			var fecini=$("#idFechaDesde").val();
			var fecfin=$("#idFechaHasta").val();
			if (fecini=="" || fecfin=="") {
				alert("Complete las fechas!");
			}else{
				location.href=path+"?fecini="+fecini+"&fecfin="+fecfin;
			}
		}
		function exportar(){
			var a=document.createElement("a");
			a.href='config/exports/exportRepUsuFec.php'+
			'?fecini='+$("#idFechaDesde").val()+
			'&fecfin='+$("#idFechaHasta").val();
			a.target='_blank';
			a.click();
		}
	</script>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
</body>
</html>