<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Reporte_numero_de_auditorías_por_Auditor_y_Fecha.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

include("../connection.php");

$array_fecini=explode("/",$_GET['fecini']);
$fecini=$array_fecini[2].$array_fecini[1].$array_fecini[0];
$array_fecfin=explode("/",$_GET['fecfin']);
$fecfin=$array_fecfin[2].$array_fecfin[1].$array_fecfin[0];	

$sql="BEGIN SP_AT_REPORTES_EJECUTIVO(:FECINI,:FECFIN,:OPCION,:OUTPUT_CUR); END;";
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
<div style="font-size: 20px;font-weight: bold;">Reporte de n&uacute;mero de auditor&iacute;as por Auditor y Fecha</div>
<br>
<div style="font-weight: bold;">Fechas:</div>
<div>Del <?php echo $_GET['fecini']; ?> al <?php echo $_GET['fecfin']; ?></div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Usuario</th>						
			<th style="border:1px solid #333;">Fecha</th>
			<th style="border:1px solid #333;">Auditoria</th>
			<th style="border:1px solid #333;">Cant. Apro.</th>
			<th style="border:1px solid #333;">Cant. Rech.</th>
			<th style="border:1px solid #333;">Cant. Prendas</th>
			<th style="border:1px solid #333;">Cant. Auditada</th>
			<th style="border:1px solid #333;">Cant. Defectos</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $row['CODUSU']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['FECHA']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['AUDITORIA']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['APROBADO']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['RECHAZADO']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['PRENDAS']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['AUDITADO']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['DEFECTOS']; ?></td>	
		</tr>
		<?php
			}
		?>
	</tbody>
</table>