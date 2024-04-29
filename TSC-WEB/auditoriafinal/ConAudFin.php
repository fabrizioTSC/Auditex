<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$appcod="1";
	include("config/_validate_access.php");
	include("config/_contentMenu.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>AUDITEX</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height">	
	<link rel="stylesheet" type="text/css" href="css/chelis.css">	
	<link rel="stylesheet" type="text/css" href="css/index-v1.0.css">
	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="js/jquery/jquery-3.3.1.js"></script>
	<style type="text/css">
		input[type="number"]{
			width: calc(100% - 12px); 
		}
		.itemBodyLink{
			text-decoration: underline;
			color: #1d1dd4;
			cursor: pointer;
		}
		.tblBody div{
			border-top: 1px solid #666;
		}
		.item1,.item2{
			width: calc(25% - 10px);
		}
		.item3{
			width: calc(100%/3);
		}
		h3,h4{
			margin: 5px 0;
		}
		.itemMainContent{
			height: auto;
			display: flex;
		}
		.bodySpecialButton{
			height: auto;
		}
		.mainBodyContent{
			margin-bottom: 70px;
		}
		@media(max-width: 650px){
			.item1{
				width: calc(100% - 240px);
			}
			.item2{
				width: 70px;
			}
		}
		@media(max-width: 500px){
			.mainBodyContent{
				margin-bottom: 50px;
			}
		}
		h4{
			margin-top: 0;
		}
		.part-disabled{
			cursor: none;
			pointer-events: none;
			color: #bbb;
			background: #eee;
		}
	</style>
</head>
<body>
	<?php contentMenu();?>
	<div class="panelCarga" style="display: none;">
		<div class="bodyCarga">
			<img src="assets/img/carga.gif" class="imgCarga">
			<div class="textCarga">CARGANDO...</div>
		</div>
	</div>
	<div class="mainContent">
		<div class="headerContent">
			<div class="headerTitle">Consultar Auditoria Final</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent" style="mar">			
			<div class="rowLine" style="display: flex;">
				<div class="lbl" style="width: 80px;">Pedido:</div>
				<div class="spaceIpt" style="width: calc(120px);font-size: 15px">
					<input type="text" id="pedido" class="classIpt" style="width: calc(100% - 17px);" value="<?php if(isset($_GET['pedido'])){echo $_GET['pedido'];} ?>">
				</div>
				<button class="btnPrimary" onclick="buscar_pedido()" style="margin-left: 5px;width: auto;"><i class="fa fa-search" aria-hidden="true"></i></button>
			</div>
			<?php
			include('config/connection.php');
			if (isset($_GET['pedido'])) {
			?>
			<div class="mainContent" style="margin-top: 5px;">
				<div class="lineDecoration"></div>
				<h4>PO: <span id="po"></span></h4>
				<h4>Estilo Cliente: <span id="estcli"></span></h4>
				<h3>Colores</h3>
				<div class="tblContent" style="overflow-x: scroll;width: 100%;">
					<div class="tblHeader" style="width:100%;min-width: 450px;">
						<div class="itemHeader item1">Color</div>
						<div class="itemHeader item2">Cant Pedido</div>
						<div class="itemHeader item2">Cant ficha</div>
						<div class="itemHeader item2">Cant Apr Fin Cos</div>
						<div class="itemHeader item2">Cant APT</div>
					</div>
					<div class="tblBody" id="table-body" style="width:100%;min-width: 450px;">
			<?php
				$sql="BEGIN SP_AF_SELECT_PED_X_COL(:PEDIDO,:OUTPUT_CUR); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':PEDIDO', $_GET['pedido']);
				$OUTPUT_CUR=oci_new_cursor($conn);
				oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
				$result=oci_execute($stmt);
				oci_execute($OUTPUT_CUR);
				$po='';
				$estcli='';
				$canaca='0';
				while($row=oci_fetch_assoc($OUTPUT_CUR)){
					echo
					'<div style="display: flex;" onclick="show_detail(\''.utf8_encode($row['DSC_COLOR']).'\')">'.
						'<div class="itemBody item1">'.utf8_encode($row['DSC_COLOR']).'</div>'.
						'<div class="itemBody item2">'.$row['CANPEDCOL'].'</div>'.
						'<div class="itemBody item2">'.$row['CANFICHA'].'</div>'.
						'<div class="itemBody item2">'.$row['CANFICHAAUDITADA'].'</div>'.
						'<div class="itemBody item2">'.$row['CANACA'].'</div>'.
					'</div>';
					if (isset($_GET['dsccol'])) {
						if ($_GET['dsccol']==utf8_encode($row['DSC_COLOR'])) {
							$canaca=$row['CANACA'];
						}	
					}
					$po=utf8_encode($row['PO_CLI']);
					$estcli=utf8_encode($row['ESTILO_CLI']);
				}
			?>
				<script type="text/javascript">
					$("#po").text("<?php echo $po;?>");
					$("#estcli").text("<?php echo $estcli;?>");
				</script>
					</div>
				</div>
			<?php
				if (isset($_GET['dsccol'])) {
					$style_disabled1='';
					$sql="BEGIN SP_AF_SELECT_VALPEDCLI(:PEDIDO,:CONTADOR); END;";
					$stmt=oci_parse($conn, $sql);
					oci_bind_by_name($stmt, ':PEDIDO', $_GET['pedido']);
					oci_bind_by_name($stmt, ':CONTADOR', $contador,40);
					$result=oci_execute($stmt);
					oci_execute($OUTPUT_CUR);
					if ($contador==0) {
						$style_disabled1="part-disabled";
					}
					$style_disabled2='';
					if ($canaca=="0") {
						$style_disabled2="part-disabled";
					}
			?>
				<div class="mainContent" style="margin-top: 5px;">
					<div class="lineDecoration"></div>
					<h3>Fichas del pedido <span id="pedido-color"><?php echo $_GET['pedido']." - ".$_GET['dsccol']; ?></span></h3>
				</div>
				<div class="content-parts-auditoria">
					<div class="body-parts-auditoria">
						<div class="part-auditoria <?php echo $style_disabled2; ?>" id="redirect-1" onclick="calidad_interna('<?php echo $_GET['pedido']; ?>','<?php echo $_GET['dsccol']; ?>')">
							<h4>1</h4>
							<div class="label-part">Calidad Interna</div>
						</div>
						<div class="part-auditoria <?php echo $style_disabled1; ?>" id="redirect-2" onclick="control_humedad('<?php echo $_GET['pedido']; ?>','<?php echo $_GET['dsccol']; ?>')">
							<h4>2</h4>
							<div class="label-part">Control Humedad</div>
						</div>
						<div class="part-auditoria" id="redirect-3" onclick="aud_med('<?php echo $_GET['pedido']; ?>','<?php echo $_GET['dsccol']; ?>')">
							<h4>3</h4>
							<div class="label-part">Medidas</div>
						</div>
						<div class="part-auditoria <?php echo $style_disabled2; ?>" id="redirect-4" onclick="show_veremp('<?php echo $_GET['pedido']; ?>','<?php echo $_GET['dsccol']; ?>')">
							<h4>4</h4>
							<div class="label-part">Embalaje</div>
						</div>
						<div class="part-auditoria" id="redirect-5" onclick="resultado('<?php echo $_GET['pedido']; ?>','<?php echo $_GET['dsccol']; ?>')">
							<h4>5</h4>
							<div class="label-part">Resultados</div>
						</div>
					</div>	
				</div>
			<?php
				}
			?>
			</div>
			<?php
			}
			?>
			<div class="lineDecoration"></div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="redirect('main.php')">Volver</button>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		var partidas_ar;
		function buscar_pedido(){
			if($("#pedido").val()==""){
				alert("Escriba el pedido");
				return;
			}
			window.location.href="ConAudFin.php?pedido="+$("#pedido").val();
		}
		function show_detail(dsccol){
			window.location.href="ConAudFin.php?pedido="+$("#pedido").val()+"&dsccol="+dsccol;
		}
		function show_veremp(pedido,dsccol){
			window.location.href="ConsultaVerEmp.php?pedido="+pedido+"&color="+dsccol;
		}
		function calidad_interna(pedido,dsccol){
			window.location.href="ConsultaAudCalInt.php?pedido="+pedido+"&color="+dsccol;
		}
		function control_humedad(pedido,dsccol){
			window.location.href="ConsultaAudConHum.php?pedido="+pedido+"&color="+dsccol;
		}
		function aud_med(pedido,dsccol){
			window.location.href="ConsultaAudMed.php?pedido="+pedido+"&color="+dsccol;
		}
		function resultado(pedido,dsccol){
			show_nodisponible();
		}
		function show_nodisponible(){
			alert("Auditoria no disponible");
		}
	</script>
</body>
</html>