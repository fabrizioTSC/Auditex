<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Reporte_general_acabados.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

$ar_fecini=explode("-",$_GET['fecini']);
$ar_fecfin=explode("-",$_GET['fecfin']);

include("../connection.php");

$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];
$sql="BEGIN SP_AA_REPACA_GENERAL(:FECINI,:FECFIN,:CODTLL,:CODUSU,:CODSED,:CODTIPSER,:OUTPUT_CUR); END;";
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
<div style="font-size: 20px;font-weight: bold;">Reporte General Auditoria de Acabados</div>
<br>
<div style="font-weight: bold;"><?php echo $_GET['titulo'];?></div>
<?php 
	if ($_GET['codtll']!="0") {
?>
<br>
<div style="font-weight: bold;">Taller: <?php echo $_GET['codtll'];?></div>
<?php
	}
?>
<?php 
	if ($_GET['codusu']!="0") {
?>
<br>
<div style="font-weight: bold;">Usuario: <?php echo $_GET['codusu'];?></div>
<?php
	}
	$fecini=$ar_fecini[2]."/".$ar_fecini[1]."/".$ar_fecini[0];
	$fecfin=$ar_fecfin[2]."/".$ar_fecfin[1]."/".$ar_fecfin[0];
	$sumtot=0;
	$totmue=0;
	$totdef=0;
	$sumapr=0;
	$sumrec=0;
?>
<br>
<div style="font-weight: bold;">Fechas:</div>
<div>Del <?php echo $fecini; ?> al <?php echo $fecfin; ?></div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Ficha</th>
			<th style="border:1px solid #333;">Pedido</th>
			<th style="border:1px solid #333;">Color</th>
			<th style="border:1px solid #333;">Parte</th>
			<th style="border:1px solid #333;">Num. Vez</th>
			<th style="border:1px solid #333;">AQL</th>
			<th style="border:1px solid #333;">Fecha Realizada</th>
			<th style="border:1px solid #333;">Usuario</th>
			<th style="border:1px solid #333;">Cantidad</th>
			<th style="border:1px solid #333;">Cant. Muestra</th>
			<th style="border:1px solid #333;">Cant. Max. Def.</th>
			<th style="border:1px solid #333;">Defectos</th>
			<th style="border:1px solid #333;">Resultado</th>
			<th style="border:1px solid #333;">Cliente</th>
			<th style="border:1px solid #333;">Sede</th>
			<th style="border:1px solid #333;">Tip. Serv.</th>
			<th style="border:1px solid #333;">Taller</th>
			<th style="border:1px solid #333;">C&eacute;lula</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
				$sumtot+=intval($row['CANTIDAD']);
				$totmue+=intval($row['CANAUD']);
				$totdef+=intval($row['CANDEF']);
				if ($row['RESULTADO']=="Aprobado") {
					$sumapr+=intval($row['CANTIDAD']);
				}else{
					$sumrec+=intval($row['CANTIDAD']);
				}
		?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $row['CODFIC']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['PEDIDO']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESCOL']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['PARTE']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['NUMVEZ']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['AQL']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['FECFINAUDFOR']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['DESUSU']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANTIDAD']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANAUD']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANDEFMAX']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANDEF']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['RESULTADO']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESCLI']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESSEDE']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESTIPSERV']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESTLL']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESCEL']); ?></td>
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
			<td style="border:1px solid #333;">TOTAL</td>
			<td style="border:1px solid #333;"><?php echo number_format($sumtot); ?></td>
			<td style="border:1px solid #333;"><?php echo number_format($totmue); ?></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"><?php echo number_format($totdef); ?></td>
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
			<td style="border:1px solid #333;">APROBADO</td>
			<td style="border:1px solid #333;"><?php echo number_format($sumapr); ?></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
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
			<td style="border:1px solid #333;">RECHAZADO</td>
			<td style="border:1px solid #333;"><?php echo number_format($sumrec); ?></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
		</tr>
	</tbody>
</table>