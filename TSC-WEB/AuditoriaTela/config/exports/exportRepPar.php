<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Reporte_partidas.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

?>
<div style="font-size: 20px;font-weight: bold;">Reporte de Partidas</div>
<?php
if ($_GET['partida']=="0") {
?>
<br>
<div style="font-weight: bold;">Todas las partidas</div>
<?php
}else{
?>
<br>
<div style="font-weight: bold;">Partida: <?php echo $_GET['partida']; ?></div>
<?php
}
?>
<br>
<?php
	include('../connection.php');

	$sql="BEGIN SP_AUDITEL_REP_PARTIDAS(:PARTIDA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_GET['partida']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
?>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Partida</th>
			<th style="border:1px solid #333;">Cod. Tela</th>
			<th style="border:1px solid #333;">Situaci&oacute;n</th>
			<th style="border:1px solid #333;">Color</th>
			<th style="border:1px solid #333;">Proveedor</th>
			<th style="border:1px solid #333;">Ruta</th>
			<th style="border:1px solid #333;">Art&iacute;culo</th>
			<th style="border:1px solid #333;">Composici&oacute;n</th>
			<th style="border:1px solid #333;">Rendimiento</th>
			<th style="border:1px solid #333;">Peso</th>
			<th style="border:1px solid #333;">Programa</th>
			<th style="border:1px solid #333;">X Factory</th>
		</tr>
	</thead>
	<tbody>
<?php
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $row['PARTIDA']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CODTEL']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['SITUACION']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['COLOR']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESPRV']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['RUTA']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['ARTICULO']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['COMPOSICION']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['RENDIMIENTO']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['PESO']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['PROGRAMA']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['X_FACTORY']; ?></td>
		</tr>
<?php
	}
?>
	</tbody>
</table>