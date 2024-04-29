<?php 
set_time_limit(240);
include('../connection.php');
header("Pragma: public");
header("Expires: 0");
$filename = "Reporte_minutos_compensados_estilo.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	$ar_fecini = explode("-",$_GET['fecini']);
	$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
	$ar_fecfin = explode("-",$_GET['fecfin']);
	$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];

	function format_for_hora($text){
		$dig1="";
		if (strlen($text)==1) {
			$dig1="0";
		}
		return $dig1.$text.":00";
	}
?>
<div style="font-size: 20px;font-weight: bold;">Reporte de minutos compensados por Estilo</div>
<br>
<div><?php echo $_GET['titulo']; ?></div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Fecha</th>
			<th style="border:1px solid #333;">Usuario</th>
			<th style="border:1px solid #333;">Est. cliente</th>
			<th style="border:1px solid #333;">Est. TSC</th>
			<th style="border:1px solid #333;">Alternativa</th>
			<th style="border:1px solid #333;">Ruta</th>
			<th style="border:1px solid #333;">Tiempo STD</th>
			<th style="border:1px solid #333;">Tiempo Com.</th>
			<th style="border:1px solid #333;">Tiempo Total</th>
			<th style="border:1px solid #333;">Observacion</th>
			<th style="border:1px solid #333;">Tiempo Original</th>
		</tr>
	</thead>
	<tbody>
<?php	
	$sql="BEGIN SP_INSP_REP_MINCOMEST(:FECINI,:FECFIN,:ESTTSC,:CODFIC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':ESTTSC', $_GET['esttsc']);
	oci_bind_by_name($stmt, ':CODFIC', $_GET['codfic']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $row['FECHA']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CODUSU']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['ESTCLI']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['ESTTSC']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['ALTERNATIVA']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['RUTA']; ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['TIESTD']); ?></td>
			<td style="border:1px solid #333;"><?php echo intval(floatval(str_replace(",",".",$row['TIECOM']))*1000)/1000; ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['TIETOT']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['OBS']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['TIEORI']); ?></td>
		</tr>
<?php
	}
	oci_close($conn);
?>
	</tbody>
</table>