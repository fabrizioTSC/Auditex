<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Reporte_defectos-Auditoria_final_costura.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

$ar_fecini=explode("-",$_GET['fecini']);
$ar_fecfin=explode("-",$_GET['fecfin']);

include("../connection.php");

$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];
$sql="BEGIN SP_AT_REPORTE_DEFECTOS(:FECINI,:FECFIN,:CODTLL,:CODUSU,:CODSED,:CODTIPSER,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':FECINI', $fecini);
oci_bind_by_name($stmt, ':FECFIN', $fecfin);
oci_bind_by_name($stmt, ':CODTLL', $_GET['codtll']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODSED', $_GET['codsede']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['codtipser']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);

?>
<div style="font-size: 20px;font-weight: bold;">Reporte de defectos de auditor&iacute;a final de costura</div>
<br>
<div style="font-weight: bold;"><?php echo $_GET['titulo'];?></div>
<?php
	$fecini=$ar_fecini[2]."/".$ar_fecini[1]."/".$ar_fecini[0];
	$fecfin=$ar_fecfin[2]."/".$ar_fecfin[1]."/".$ar_fecfin[0];
?>
<br>
<div style="font-weight: bold;">Fechas:</div>
<div>Del <?php echo $fecini; ?> al <?php echo $fecfin; ?></div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Ficha</th>
			<th style="border:1px solid #333;">Parte</th>
			<th style="border:1px solid #333;">Num. Vez</th>
			<th style="border:1px solid #333;">Pedido</th>
			<th style="border:1px solid #333;">Color</th>
			<th style="border:1px solid #333;">Can Ficha</th>
			<th style="border:1px solid #333;">Fecha</th>
			<th style="border:1px solid #333;">Usuario</th>
			<th style="border:1px solid #333;">Taller</th>
			<th style="border:1px solid #333;">Defecto</th>
			<th style="border:1px solid #333;">Fam Defecto</th>
			<th style="border:1px solid #333;">Partida</th>
			<th style="border:1px solid #333;">Can Defecto</th>
			<th style="border:1px solid #333;">Can Parte</th>
			<th style="border:1px solid #333;">Sede</th>
			<th style="border:1px solid #333;">Tipo Servicio</th>
			<th style="border:1px solid #333;">Cliente</th>
			<th style="border:1px solid #333;">Resultado</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $row['CODFIC']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['PARTE']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['NUMVEZ']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['PEDIDO']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['DESCOL']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANTIDAD']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['FECFINAUDFOR']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESUSU']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESTLL']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESDEF']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DSCFAMILIA']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['PARTIDA']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANDEF']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANPAR']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESSEDE']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESTIPSERV']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESCLI']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['RESULTADO']); ?></td>
		</tr>
		<?php
			}
		?>
	</tbody>
</table>