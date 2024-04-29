<?php 
set_time_limit(120);
header("Pragma: public");
header("Expires: 0");
$filename = "Porcentaje_de_Defectos_por_Talleres_defectos_y_rango_de_fechas.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

$array_fecini=explode("/",$_GET['fecini']);
$fecini=$array_fecini[2].$array_fecini[1].$array_fecini[0];
$array_fecfin=explode("/",$_GET['fecfin']);
$fecfin=$array_fecfin[2].$array_fecfin[1].$array_fecfin[0];

include("../connection.php");

$sql="BEGIN SP_AT_REPORTES_EJECUTIVO(:FECINI,:FECFIN,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':FECINI', $fecini);
oci_bind_by_name($stmt, ':FECFIN', $fecfin);
$opcion=2;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
?>
<div style="font-size: 20px;font-weight: bold;">Porcentaje de Defectos por Talleres, Defectos y Rango de fechas</div>
<br>
<div style="font-weight: bold;">Fechas:</div>
<div>Del <?php echo $_GET['fecini']; ?> al <?php echo $_GET['fecfin']; ?></div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Ficha</th>
			<th style="border:1px solid #333;">Cod. Taller</th>
			<th style="border:1px solid #333;">Taller</th>
			<th style="border:1px solid #333;">Cod. Defecto</th>
			<th style="border:1px solid #333;">Defecto</th>
			<th style="border:1px solid #333;">Cantidad Defecto</th>
			<th style="border:1px solid #333;">Cantidad Total</th>
			<th style="border:1px solid #333;">Porcentaje</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $row['CODFIC'];?></td>
			<td style="border:1px solid #333;"><?php echo "COD-".$row['CODTLL'];?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESTLL']);?></td>
			<td style="border:1px solid #333;"><?php echo $row['CODDEF'];?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESDEF']);?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANDEF'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANTOT'];?></td>
			<td style="border:1px solid #333;"><?php echo $row['POR'];?></td>
		</tr>
		<?php
			}
		?>
	</tbody>
</table>