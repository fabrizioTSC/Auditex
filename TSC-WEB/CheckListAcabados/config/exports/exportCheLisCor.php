<?php
header("Pragma: public");
header("Expires: 0");
$filename = "Check List Corte - ".$_GET['codfic'].".xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

include("../connection.php");

function process_res($text){
	if ($text=="1") {
		return "SI";
	}else{
		return "NO";
	}
}
function process_resultado($text){
	if ($text=="A") {
		return "Aprobado";
	}else{
		if ($text=="P") {
			return "Pendiente";
		}else{
			if ($text=="" || $text==null) {
				return "-";
			}else{
				return "Rechazado";
			}	
		}	
	}	
}
?>

<h3>CHECK LIST CORTE</h3>
<div>Ficha: <?php echo $_GET['codfic']; ?></div>
<div>Taller: <?php echo $_GET['tal']; ?></div>
<div>Pedido: <?php echo $_GET['pedido']; ?></div>
<div>Estilo TSC: <?php echo $_GET['esttsc']; ?></div>
<div>Estilo Cliente: <?php echo $_GET['estcli']; ?></div>
<div>Cliente: <?php echo $_GET['cli']; ?></div>
<div>Partida: <?php echo $_GET['partida']; ?></div>
<div>Cod. Tela: <?php echo $_GET['codtel']; ?></div>
<div>Color: <?php echo $_GET['color']; ?></div>
<div>Cant. Pedido: <?php echo $_GET['canpre']; ?></div>
<div>Ruta prenda: <?php echo $_GET['ruttel']; ?></div>

<?php
	$sql="BEGIN SP_CLC_SELECT_RESULTADOS(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_GET['codfic']);
	oci_bind_by_name($stmt, ':CODTAD', $_GET['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_GET['parte']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$resdoc="";
	$resten="";
	$restiz="";
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$resdoc=process_resultado($row['RESDOC']);
		$resten=process_resultado($row['RESTEN']);
		$restiz=process_resultado($row['RESTIZ']);
	}
?>

<h4>Resultados</h4>
<div>1. Validacion de documentacion: <?php echo $resdoc; ?></div>
<div>2. Validacion del tizado/moldes: <?php echo $restiz; ?></div>
<div>3. Validacion del tendido: <?php echo $resten; ?></div>

<h4>1. Validacion de documentacion</h4>
<table>
	<tr>
		<th style="border:1px #333 solid;">Descripcion</th>
		<th style="border:1px #333 solid;">Resultado</th>
		<!--<th style="border:1px #333 solid;">Reposo</th>-->
	</tr>
<?php	
$sql="BEGIN SP_CLC_SELECT_CHEDOCGUA(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODFIC', $_GET['codfic']);
oci_bind_by_name($stmt, ':CODTAD', $_GET['codtad']);
oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
oci_bind_by_name($stmt, ':PARTE', $_GET['parte']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while($row=oci_fetch_assoc($OUTPUT_CUR)){
?>
	<tr>
		<td style="border:1px #333 solid;"><?php echo utf8_encode($row['DESDOC']); ?></td>
		<td style="border:1px #333 solid;"><?php echo process_res($row['RESDOC']); ?></td>
		<<!--td style="border:1px #333 solid;"><?php echo str_replace(",",".",$row['REPOSO']); ?></td>-->
	</tr>
<?php
}
?>
</table>
<?php
if ($_GET['obs1']!="") {
?>
<div>Observacion</div>
<div><?php echo $_GET['obs1']; ?></div>
<?php
}
?>
<h4>2. Validacion del tizado/moldes</h4>
<table>
	<tr>
		<th style="border:1px #333 solid;">Descripcion</th>
		<th style="border:1px #333 solid;">Veces</th>
		<th style="border:1px #333 solid;">Resultado</th>
	</tr>
<?php	
$sql="BEGIN SP_CLC_SELECT_CHETIZGUA(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODFIC', $_GET['codfic']);
oci_bind_by_name($stmt, ':CODTAD', $_GET['codtad']);
oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
oci_bind_by_name($stmt, ':PARTE', $_GET['parte']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while($row=oci_fetch_assoc($OUTPUT_CUR)){
?>
	<tr>
		<td style="border:1px #333 solid;"><?php echo utf8_encode($row['DESTIZ']); ?></td>
		<td style="border:1px #333 solid;"><?php echo str_replace(",",".",$row['VECES']); ?></td>
		<td style="border:1px #333 solid;"><?php echo process_res($row['RESTIZ']); ?></td>
	</tr>
<?php
}
?>
</table>
<?php
if ($_GET['obs2']!="") {
?>
<div>Observacion</div>
<div><?php echo $_GET['obs2']; ?></div>
<?php
}
?>
<h4>3. Validacion del tendido</h4>
<table>
	<tr>
		<th style="border:1px #333 solid;">Descripcion</th>
		<th style="border:1px #333 solid;">Resultado</th>
	</tr>
<?php	
$sql="BEGIN SP_CLC_SELECT_CHETENGUA(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODFIC', $_GET['codfic']);
oci_bind_by_name($stmt, ':CODTAD', $_GET['codtad']);
oci_bind_by_name($stmt, ':NUMVEZ', $_GET['numvez']);
oci_bind_by_name($stmt, ':PARTE', $_GET['parte']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while($row=oci_fetch_assoc($OUTPUT_CUR)){
?>
	<tr>
		<td style="border:1px #333 solid;"><?php echo utf8_encode($row['DESTEN']); ?></td>
		<td style="border:1px #333 solid;"><?php echo process_res($row['RESTEN']); ?></td>
	</tr>
<?php
}
?>
</table>
<?php
if ($_GET['obs3']!="") {
?>
<div>Observacion</div>
<div><?php echo $_GET['obs3']; ?></div>
<?php
}
?>