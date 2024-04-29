<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Reporte_general - CHECK_LIST_CORTE.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

$ar_fecini=explode("-",$_GET['fecini']);
$ar_fecfin=explode("-",$_GET['fecfin']);

include("../connection.php");

$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];
$sql="BEGIN SP_CLC_REPORTE_GENERAL(:FECINI,:FECFIN,:CODTLL,:CODUSU,:CODSED,:CODTIPSER,:ESTADO,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':FECINI', $fecini);
oci_bind_by_name($stmt, ':FECFIN', $fecfin);
oci_bind_by_name($stmt, ':CODTLL', $_GET['codtll']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODSED', $_GET['codsede']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['codtipser']);
oci_bind_by_name($stmt, ':ESTADO', $_GET['estado']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);

?>
<div style="font-size: 20px;font-weight: bold;">Reporte General - Check List Corte</div>
<br>
<div style="font-weight: bold;"><?php echo $_GET['titulo'];?></div>

<!--?php 
	if ($_GET['codtll']!="0") {
?>
<br>
<div style="font-weight: bold;">Taller: <!--?php echo $_GET['codtll'];?></div>

<!--?php
	}
?>
-->
<?php 
	if ($_GET['codusu']!="0") {
?>
<br>
<div style="font-weight: bold;">Usuario: <?php echo $_GET['codusu'];?></div>
<?php
	}
	$fecini=$ar_fecini[2]."/".$ar_fecini[1]."/".$ar_fecini[0];
	$fecfin=$ar_fecfin[2]."/".$ar_fecfin[1]."/".$ar_fecfin[0];
?>
<!--<br>
<div style="font-weight: bold;">Fechas:</div>
<div>Del <!--?php echo $fecini; ?> al <!--?php echo $fecfin; ?></div>
-->
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Ficha</th>
			<th style="border:1px solid #333;">Usuario</th>
			<th style="border:1px solid #333;">Fec. Inicio</th>
			<th style="border:1px solid #333;">Fec. Fin</th>
			<th style="border:1px solid #333;">Cantidad</th>
			<th style="border:1px solid #333;">Estado</th>
			<th style="border:1px solid #333;">Est. Doc.</th>
			<th style="border:1px solid #333;">Fec. Doc.</th>
			<th style="border:1px solid #333;">Obs. Doc.</th>
			<th style="border:1px solid #333;">Est. Tiz./Mol.</th>
			<th style="border:1px solid #333;">Fec. Tiz./Mol.</th>
			<th style="border:1px solid #333;">Obs. Tiz./Mol.</th>
			<th style="border:1px solid #333;">Est. Tendido</th>
			<th style="border:1px solid #333;">Fec. Tendido</th>
			<th style="border:1px solid #333;">Obs. Tendido</th>
			<th style="border:1px solid #333;">Sede</th>
			<th style="border:1px solid #333;">Tipo Ser.</th>
			<th style="border:1px solid #333;">Taller</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $row['CODFIC']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['DESUSU']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['FECINIAUDFOR']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_decode($row['FECFINAUDFOR']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANTIDAD']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['ESTADO']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['ESTDOC']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['FECFINDOC']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_decode($row['OBSDOC']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['ESTTIZ']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['FECFINTIZ']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_decode($row['OBSTIZ']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['ESTTEN']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['FECFINTEN']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_decode($row['OBSTEN']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_decode($row['DESSEDE']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_decode($row['DESTIPSERV']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_decode($row['DESTLL']); ?></td>
		</tr>
		<?php
			}
		?>
	</tbody>
</table>