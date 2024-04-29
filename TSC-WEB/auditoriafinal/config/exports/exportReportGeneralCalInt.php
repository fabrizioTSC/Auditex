<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Reporte_general_calidad_interna.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

$ar_fecini=explode("-",$_GET['fecini']);
$ar_fecfin=explode("-",$_GET['fecfin']);

include("../connection.php");

$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];
$sql="BEGIN SP_AF_REPCAL_GENERAL(:FECINI,:FECFIN,:CODUSU,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':FECINI', $fecini);
oci_bind_by_name($stmt, ':FECFIN', $fecfin);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);

?>
<div style="font-size: 20px;font-weight: bold;">Reporte General Calidad Interna</div>
<br>
<div style="font-weight: bold;"><?php echo $_GET['titulo'];?></div>
<?php 
	$fecini=$ar_fecini[2]."/".$ar_fecini[1]."/".$ar_fecini[0];
	$fecfin=$ar_fecfin[2]."/".$ar_fecfin[1]."/".$ar_fecfin[0];
						$suma=0;
						$sumcanaud=0;
						$sumcandef=0;
						$suma_a=0;
						$suma_r=0;
?>
<br>
<div style="font-weight: bold;">Fechas:</div>
<div>Del <?php echo $fecini; ?> al <?php echo $fecfin; ?></div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Cliente</th>
			<th style="border:1px solid #333;">Pedido</th>
			<th style="border:1px solid #333;">Color</th>
			<th style="border:1px solid #333;">PO</th>
			<th style="border:1px solid #333;">Vez</th>
			<th style="border:1px solid #333;">AQL</th>
			<th style="border:1px solid #333;">Fecha Inicio</th>
			<th style="border:1px solid #333;">Fecha Fin</th>
			<th style="border:1px solid #333;">Usuario</th>

			<th style="border:1px solid #333;">Cantidad</th>
			<th style="border:1px solid #333;">Can Muestra</th>
			<th style="border:1px solid #333;">Can Max Def</th>
			<th style="border:1px solid #333;">Defectos</th>
			<th style="border:1px solid #333;">Resultado</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
				$suma+=intval($row['CANTIDAD']);
				$sumcanaud+=intval($row['CANAUD']);
				$sumcandef+=intval($row['CANDEF']);
				if ($row['RESULTADOTXT']=="Aprobado") {
					$suma_a+=intval($row['CANTIDAD']);
				}else{
					$suma_r+=intval($row['CANTIDAD']);
				}
		?>
		<tr>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESCLI']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['PEDIDO']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['DESCOL']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['PO_CLI']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['NUMVEZ']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['AQL']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['FECINIAUDFOR']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['FECFINAUDFOR']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESUSU']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANTIDAD']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANAUD']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANDEFMAX']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANDEF']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['RESULTADOTXT']; ?></td>
		</tr>
		<?php
			}
		?>
		<tr>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;">TOTAL</td>
			<td style="border:1px solid #333;"><?php echo number_format($suma); ?></td>
			<td style="border:1px solid #333;"><?php echo number_format($sumcanaud); ?></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"><?php echo number_format($sumcandef); ?></td>
			<td style="border:1px solid #333;"></td>
		</tr>
		<tr>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;">APROBADO</td>
			<td style="border:1px solid #333;"><?php echo number_format($suma_a); ?></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
		</tr>
		<tr>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;">RECHAZADO</td>
			<td style="border:1px solid #333;"><?php echo number_format($suma_r); ?></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
		</tr>
	</tbody>
</table>