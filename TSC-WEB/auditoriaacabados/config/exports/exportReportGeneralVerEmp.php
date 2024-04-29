<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Reporte_general_verificado_empaque_acabados.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

$ar_fecini=explode("-",$_GET['fecini']);
$ar_fecfin=explode("-",$_GET['fecfin']);

include("../connection.php");

$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];
$sql="BEGIN SP_AA_REPEMP_GENERAL(:FECINI,:FECFIN,:CODCEL,:CODUSU,:CODSED,:CODTIPSER,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':FECINI', $fecini);
oci_bind_by_name($stmt, ':FECFIN', $fecfin);
oci_bind_by_name($stmt, ':CODCEL', $_GET['codcel']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODSED', $_GET['codsede']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['codtipser']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);

?>
<div style="font-size: 20px;font-weight: bold;">Reporte General Verificado de Empaque Acabados</div>
<br>
<div style="font-weight: bold;"><?php echo $_GET['titulo'];?></div>
<?php 
	$fecini=$ar_fecini[2]."/".$ar_fecini[1]."/".$ar_fecini[0];
	$fecfin=$ar_fecfin[2]."/".$ar_fecfin[1]."/".$ar_fecfin[0];
	$sumcajlot=0;
	$sumcanlote=0;
	$sumcajaudlot=0;
	$sumcanaudlot=0;
	$sumcajlot_a=0;
	$sumcanlote_a=0;
	$sumcajaudlot_a=0;
	$sumcanaudlot_a=0;
	$sumcajlot_r=0;
	$sumcanlote_r=0;
	$sumcajaudlot_r=0;
	$sumcanaudlot_r=0;
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
			<th style="border:1px solid #333;">Lote</th>
			<th style="border:1px solid #333;">Vez</th>
			<th style="border:1px solid #333;">Fecha Inicio</th>
			<th style="border:1px solid #333;">Fecha Fin</th>
			<th style="border:1px solid #333;">Usuario</th>
			<th style="border:1px solid #333;">Can Caj Lote</th>
			<th style="border:1px solid #333;">Pre Lote</th>
			<th style="border:1px solid #333;">Can Caj Mue</th>
			<th style="border:1px solid #333;">Pre Mue</th>
			<th style="border:1px solid #333;">Can Caj Def</th>
			<th style="border:1px solid #333;">Pre Def</th>
			<th style="border:1px solid #333;">Resultado</th>
			<th style="border:1px solid #333;">C&eacute;lula</th>
			<th style="border:1px solid #333;">Sede</th>
			<th style="border:1px solid #333;">Tipo Servicio</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
							$sumcajlot+=intval($row['NUMCAJLOTE']);
							$sumcanlote+=intval($row['CANLOTE']);
							$sumcajaudlot+=intval($row['NUMCAJAUDLOTE']);
							$sumcanaudlot+=intval($row['CANAUDLOTE']);
							if ($row['RESULTADOTXT']=="Aprobado") {
								$sumcajlot_a+=intval($row['NUMCAJLOTE']);
								$sumcanlote_a+=intval($row['CANLOTE']);
								$sumcajaudlot_a+=intval($row['NUMCAJAUDLOTE']);
								$sumcanaudlot_a+=intval($row['CANAUDLOTE']);
							}else{
								$sumcajlot_r+=intval($row['NUMCAJLOTE']);
								$sumcanlote_r+=intval($row['CANLOTE']);
								$sumcajaudlot_r+=intval($row['NUMCAJAUDLOTE']);
								$sumcanaudlot_r+=intval($row['CANAUDLOTE']);
							}
		?>
		<tr>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESCLI']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['PEDIDO']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['DESCOL']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['PO']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['NROLOTE']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['NUMVEZLOTE']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['FECINIAUDFOR']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['FECFINAUDFOR']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESUSU']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['NUMCAJLOTE']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANLOTE']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['NUMCAJAUDLOTE']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANAUDLOTE']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['NUMCAJDEF']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANDEF']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['RESULTADOTXT']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESCEL']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESSEDE']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESTIPSERV']); ?></td>
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
			<td style="border:1px solid #333;"><?php echo number_format($sumcajlot); ?></td>
			<td style="border:1px solid #333;"><?php echo number_format($sumcanlote); ?></td>
			<td style="border:1px solid #333;"><?php echo number_format($sumcajaudlot); ?></td>
			<td style="border:1px solid #333;"><?php echo number_format($sumcanaudlot); ?></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
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
			<td style="border:1px solid #333;">APROBADO</td>
			<td style="border:1px solid #333;"><?php echo number_format($sumcajlot_a); ?></td>
			<td style="border:1px solid #333;"><?php echo number_format($sumcanlote_a); ?></td>
			<td style="border:1px solid #333;"><?php echo number_format($sumcajaudlot_a); ?></td>
			<td style="border:1px solid #333;"><?php echo number_format($sumcanaudlot_a); ?></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
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
			<td style="border:1px solid #333;"><?php echo number_format($sumcajlot_r); ?></td>
			<td style="border:1px solid #333;"><?php echo number_format($sumcanlote_r); ?></td>
			<td style="border:1px solid #333;"><?php echo number_format($sumcajaudlot_r); ?></td>
			<td style="border:1px solid #333;"><?php echo number_format($sumcanaudlot_r); ?></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
		</tr>
	</tbody>
</table>