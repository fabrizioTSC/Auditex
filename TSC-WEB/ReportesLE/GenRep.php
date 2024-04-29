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
	<link rel="stylesheet" type="text/css" href="css/index-v1.0.css">
	<link rel="stylesheet" type="text/css" href="css/opciones.css">
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
			<div class="headerTitle">Generar Reportes</div>
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
				<button class="btnPrimary" onclick="buscar_pedido()" style="margin-left: 5px;width: auto;"><i class="fa fa-search" aria-hidden="true"></i></button>
			</div>
			<?php
			include('config/connection.php');
			if (isset($_GET['po'])) {
			?>
			<div class="mainContent" style="margin-top: 5px;">
				<div class="lineDecoration"></div>
				<div class="tblContent" style="width: 100%;">
					<div class="tblHeader" style="width:100%;">
						<div class="itemHeader" style="width: calc(100% - 10px);">PACKING LIST</div>
					</div>
					<div class="tblBody" id="table-body" style="width:100%;">
			<?php
				$sql="BEGIN SP_RLE_SELECT_POPL(:PO,:OUTPUT_CUR); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':PO', $_GET['po']);
				$OUTPUT_CUR=oci_new_cursor($conn);
				oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
				$result=oci_execute($stmt);
				oci_execute($OUTPUT_CUR);
				while($row=oci_fetch_assoc($OUTPUT_CUR)){
					echo
					'<div style="display: flex;" onclick="show_detail(\''.utf8_encode($row['NROPACKING']).'\')">'.
						'<div class="itemBody" style="width: calc(100% - 10px);">'.$row['NROPACKING'].'</div>'.
					'</div>';
				}
			?>
				</div>
				<div style="margin-top: 10px;font-size: 12px;">
					<table>
						<tr>
							<th>Pedido</th>
							<th>Color</th>
							<th>Can PO</th>
							<th>PL</th>
							<th>Can PL</th>
							<th>Can Cal Int</th>
							<th>Can Emb</th>
						</tr>						
			<?php
				$sql="BEGIN SP_RLE_SELECT_POPLAVANCE(:PO,:OUTPUT_CUR); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':PO', $_GET['po']);
				$OUTPUT_CUR=oci_new_cursor($conn);
				oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
				$result=oci_execute($stmt);
				oci_execute($OUTPUT_CUR);
				while($row=oci_fetch_assoc($OUTPUT_CUR)){
					echo
						'<tr>
							<td>'.$row['PEDIDO'].'</td>
							<td>'.$row['DESCOL'].'</td>
							<td>'.$row['CANPO'].'</td>
							<td>'.$row['NROPACKING'].'</td>
							<td>'.$row['CANPACLIS'].'</td>
							<td>'.$row['CANCAL'].'</td>
							<td>'.$row['CANEMB'].'</td>
						</tr>';
				}
			?>
					</table>
				</div>
				<div id="div-estcli" style="display: none;">
					<div class="mainContent" style="margin-top: 5px;">
						<div class="lineDecoration"></div>
						<h3>Packing List: <span id="paclis"></span></h3>
					</div>
					<div class="content-parts-auditoria">
						<div class="body-parts-auditoria">
							<div class="part-auditoria" id="redirect-1" onclick="defectos()">
								<h4>1</h4>
								<div class="label-part">Auditoría Calidad</div>
							</div>
							<div class="part-auditoria" id="redirect-2" onclick="medidas()">
								<h4>2</h4>
								<div class="label-part">Medidas</div>
							</div>
							<div class="part-auditoria" id="redirect-3" onclick="fotos()">
								<h4>3</h4>
								<div class="label-part">Defectos y Humedad</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
			<?php
			}
			?>
			<div class="lineDecoration"></div>
			<button class="btnPrimary" style="margin-left: calc(50% - 80px); margin-top: 0px;" onclick="window.history.back();">Volver</button>
		</div>
	</div>
	<script type="text/javascript" src="js/animacionesGlobales.js"></script>
	<script type="text/javascript">
		var partidas_ar;
		function buscar_pedido(){
			if($("#po").val()==""){
				alert("Escriba la PO");
				return;
			}
			window.location.href="GenRep.php?po="+$("#po").val();
		}
		var paclis_v='';
		function show_detail(paclis){
			//window.location.href="IniciarAudFin.php?pedido="+pedido+"&dsccol="+dsccol;
			document.getElementById("div-estcli").style.display="block";
			document.getElementById("paclis").innerHTML=paclis;
			paclis_v=paclis;
		}
		function defectos(){
			//window.location.href="GenRepDef.php?estcli="+estcli_v;
			window.location.href="GenDef.php?po="+$("#po").val()+"&paclis="+paclis_v;
		}
		function medidas(){
			window.location.href="GenMed.php?po="+$("#po").val()+"&paclis="+paclis_v;
			//window.location.href="GenRepDef.php?estcli="+estcli_v;
		}
		function fotos(){
			//window.location.href="GenRepDef.php?estcli="+estcli_v;
			window.location.href="GenFot.php?po="+$("#po").val()+"&paclis="+paclis_v;
		}
	</script>
</body>
</html>