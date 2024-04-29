<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Reporte_fichas_inicio_automatico.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

include("../connection.php");

$sql="begin SP_AT_SELECT_AUDINIAUT(:CODTLL,:CODSED,:CODTIPSER,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn,$sql);
oci_bind_by_name($stmt,':CODTLL', $_GET['codtll']);
oci_bind_by_name($stmt,':CODSED', $_GET['codsed']);
oci_bind_by_name($stmt,':CODTIPSER', $_GET['codtipser']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt,':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);

?>
<div style="font-size: 20px;font-weight: bold;">Reporte fichas inicio autom&aacute;tico</div>
<br>
<div><?php echo $_GET['t']; ?></div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Ficha</th>
			<th style="border:1px solid #333;">Sede</th>
			<th style="border:1px solid #333;">Tipo Servicio</th>
			<th style="border:1px solid #333;">Taller</th>
			<th style="border:1px solid #333;">Fecha Movimiento</th>
			<th style="border:1px solid #333;">Usuario Movimiento</th>
			<th style="border:1px solid #333;">Observaci&oacute;n</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $row['CODFIC'];?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESSEDE']);?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESTIPSERV']);?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESTLL']);?></td>
			<td style="border:1px solid #333;"><?php echo $row['FECMOV'];?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['USUMOV']);?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['OBSERVACION']);?></td>
		</tr>
		<?php
			}
		?>
	</tbody>
</table>