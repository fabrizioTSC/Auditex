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
			<div class="headerTitle">Iniciar Auditoria Final</div>
			<div class="menuHeader" onclick="showMenu()">
				<div class="iconSpace iconMode2"><i class="fa fa-bars" aria-hidden="true"></i></div>				
			</div>
		</div>
		<div class="bodyContent mainBodyContent">			
			<div class="rowLine" style="display: flex;">
				<div class="lbl" style="width: 50px;">PO:</div>
				<div class="spaceIpt" style="width: calc(120px);font-size: 15px">
					<input type="text" id="po" class="classIpt" style="width: calc(100% - 17px);" value="<?php if(isset($_GET['po'])){echo $_GET['po'];} ?>">
				</div>
				<div class="lbl" style="width: 70px;margin-left: 5px;">Pedido:</div>
				<div class="spaceIpt" style="width: calc(120px);font-size: 15px">
					<input type="text" id="pedido" class="classIpt" style="width: calc(100% - 17px);" value="<?php if(isset($_GET['pedido'])){echo $_GET['pedido'];} ?>">
				</div>
				<button class="btnPrimary" onclick="buscar_pedido()" style="margin-left: 5px;width: auto;"><i class="fa fa-search" aria-hidden="true"></i></button>
			</div>
			<?php
			include('config/connection.php');
			if (isset($_GET['pedido']) || isset($_GET['po'])) {
			?>
			<div class="mainContent" style="margin-top: 5px;">
				<div class="lineDecoration"></div>
				<h4>PO: <span id="potext"></span></h4>
				<h4>Estilo Cliente: <span id="estcli"></span></h4>
				<h3>Colores</h3>
				<div class="tblContent" style="overflow-x: scroll;width: 100%;">
					<div class="tblHeader" style="width:100%;min-width: 600px;">
						<div class="itemHeader">Pedido</div>
						<div class="itemHeader item1">Color</div>
						<div class="itemHeader item2">Cant Pedido</div>
						<div class="itemHeader item2">Cant ficha</div>
						<div class="itemHeader item2">Cant Apr Fin Cos</div>
						<div class="itemHeader item2">Cant APT</div>
					</div>
					<div class="tblBody" id="table-body" style="width:100%;min-width: 600px;">
			<?php
				$pedido="";
				if (isset($_GET['pedido']) ) {
					$pedido=$_GET['pedido'];
				}else{
					$pedido="0";
				}
				$po="";
				if (isset($_GET['po']) ) {
					$po=$_GET['po'];
				}else{
					$po="0";
				}

				// echo "GAAAAAA" . $po ."-". $pedido;
				$popasar =		($po == "0" || $po == ""  ) ? null : $po;
				$pedidopasar =	$pedido == "0" ? null : $pedido;

				$sql="BEGIN SP_AF_SELECT_PO_PED_X_COL(:PO,:PEDIDO,:OUTPUT_CUR); END;";
				$stmt=oci_parse($conn, $sql);

				

				oci_bind_by_name($stmt, ':PO', $popasar );
				oci_bind_by_name($stmt, ':PEDIDO',  $pedidopasar);

				$OUTPUT_CUR=oci_new_cursor($conn);
				oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
				$result=oci_execute($stmt);
				oci_execute($OUTPUT_CUR);
				$estcli='';
				$canaca='0';
				while($row=oci_fetch_assoc($OUTPUT_CUR)){
					echo
					'<div style="display: flex;" onclick="show_detail(\''.utf8_encode($row['PEDIDO']).'\',\''.utf8_encode($row['DSC_COLOR']).'\')">'.
						'<div class="itemBody">'.$row['PEDIDO'].'</div>'.
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
					$("#potext").text("<?php echo $po;?>");
					$("#estcli").text("<?php echo $estcli;?>");
				</script>
					</div>
				</div>
			<?php
				if (isset($_GET['dsccol'])) {
					$pedido=$_GET['pedido'];
					$style_disabled1='';
					$sql="BEGIN SP_AF_SELECT_VALPEDCLI(:PEDIDO,:CONTADOR); END;";
					$stmt=oci_parse($conn, $sql);
					oci_bind_by_name($stmt, ':PEDIDO', $pedido);
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
					<h3>Fichas del pedido <span id="pedido-color"><?php echo $pedido." - ".$_GET['dsccol']; ?></span></h3>
				</div>
				<div class="content-parts-auditoria">
					<div class="body-parts-auditoria">
						<div class="part-auditoria <?php echo $style_disabled2; ?>" id="redirect-1" onclick="calidad_interna('<?php echo $pedido; ?>','<?php echo $_GET['dsccol']; ?>')">
							<h4>1</h4>
							<div class="label-part">Calidad Interna</div>
						</div>
						<div class="part-auditoria <?php echo $style_disabled1; ?>" id="redirect-2" onclick="control_humedad('<?php echo $pedido; ?>','<?php echo $_GET['dsccol']; ?>')">
							<h4>2</h4>
							<div class="label-part">Control Humedad</div>
						</div>
						<div class="part-auditoria" id="redirect-3" onclick="aud_med('<?php echo $pedido; ?>','<?php echo $_GET['dsccol']; ?>')">
							<h4>3</h4>
							<div class="label-part">Medidas</div>
						</div>
						<div class="part-auditoria <?php echo $style_disabled2; ?>" id="redirect-4" onclick="show_veremp('<?php echo $pedido; ?>','<?php echo $_GET['dsccol']; ?>')">
							<h4>4</h4>
							<div class="label-part">Embalaje</div>
						</div>
						<div class="part-auditoria" id="redirect-5" onclick="resultado('<?php echo $pedido; ?>','<?php echo $_GET['dsccol']; ?>')">
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
			if($("#po").val()=="" && $("#pedido").val()==""){
				alert("Escriba la PO o el pedido");
				return;
			}
			window.location.href="IniciarAudFin.php?pedido="+$("#pedido").val()+"&po="+$("#po").val();
		}
		function show_detail(pedido,dsccol){
			window.location.href="IniciarAudFin.php?pedido="+pedido+"&dsccol="+dsccol;
		}
		function show_veremp(pedido,dsccol){
			window.location.href="VerEmp.php?pedido="+pedido+"&color="+dsccol;
		}
		function calidad_interna(pedido,dsccol){
			window.location.href="AudCalInt.php?pedido="+pedido+"&color="+dsccol;
		}
		function control_humedad(pedido,dsccol){
			window.location.href="AudConHum.php?pedido="+pedido+"&color="+dsccol;
		}
		function aud_med(pedido,dsccol){
			$(".panelCarga").fadeIn(100);
			$.ajax({
				url:"config/valPedColAudMed.php",
				type:"POST",
				data:{
					pedido:pedido,
					dsccol:dsccol
				},
				success:function(data){
					if (data.state) {
						window.location.href="AudMed.php?pedido="+pedido+"&dsccol="+dsccol;
					}else{
						alert(data.detail);
					}
					$(".panelCarga").fadeOut(100);
				}
			});
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