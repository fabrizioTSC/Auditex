<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Reporte_general.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

$ar_fecini=explode("-",$_GET['fecini']);
$ar_fecfin=explode("-",$_GET['fecfin']);

include("../connection.php");

$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];
$sql="BEGIN SP_APNC_REPORTE_GENERAL(:CODSED,:CODTIPSER,:FECINI,:FECFIN,:TIPO,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODSED', $_GET['codsede']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['codtipser']);
oci_bind_by_name($stmt, ':FECINI', $fecini);
oci_bind_by_name($stmt, ':FECFIN', $fecfin);
oci_bind_by_name($stmt, ':TIPO', $_GET['tipo']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);

?>
<div style="font-size: 20px;font-weight: bold;">Reporte General</div>
<br>
<div style="font-weight: bold;"><?php echo $_GET['titulo'];?></div>
<?php 
	$fecini=$ar_fecini[2]."/".$ar_fecini[1]."/".$ar_fecini[0];
	$fecfin=$ar_fecfin[2]."/".$ar_fecfin[1]."/".$ar_fecfin[0];
	if ($_GET['tipo']=="1") {
?>
<br>
<div style="font-weight: bold;">Fechas:</div>
<div>Del <?php echo $fecini; ?> al <?php echo $fecfin; ?></div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Pedido</th>
			<th style="border:1px solid #333;">Color</th>
			<th style="border:1px solid #333;">Ficha</th>
			<th style="border:1px solid #333;">Generado</th>
			<th style="border:1px solid #333;">Parte</th>
			<th style="border:1px solid #333;">Auditor</th>
			<th style="border:1px solid #333;">Fecha</th>
			<th style="border:1px solid #333;">Cant Ficha</th>
			<th style="border:1px solid #333;">Cant Muestra</th>
			<th style="border:1px solid #333;">Cant Def</th>
			<th style="border:1px solid #333;">Cant Rec</th>
			<th style="border:1px solid #333;">Taller</th>
			<th style="border:1px solid #333;">Sede</th>
			<th style="border:1px solid #333;">Tipo de servicio</th>
			<th style="border:1px solid #333;">Cliente</th>
			<th style="border:1px solid #333;">Estilo TSC</th>
			<th style="border:1px solid #333;">Estilo cliente</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $row['PEDIDO']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DSCCOL']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CODFIC']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['GENERADO']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['PARTE']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CODUSU']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['FECINIAUD']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANTIDAD']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANMUE']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANDEF']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANRECUP']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESTLL']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['DESSEDE']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['DESTIPSERV']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESCLI']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['ESTTSC']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['ESTCLI']); ?></td>
		</tr>
		<?php
			}
		?>
	</tbody>
</table>
<?php
	}else{
?>
<br>
<div style="font-weight: bold;">Fechas:</div>
<div>Del <?php echo $fecini; ?> al <?php echo $fecfin; ?></div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Pedido</th>
			<th style="border:1px solid #333;">Color</th>
			<th style="border:1px solid #333;">Ficha</th>
			<th style="border:1px solid #333;">Generado</th>
			<th style="border:1px solid #333;">Parte</th>
			<th style="border:1px solid #333;">Auditor</th>
			<th style="border:1px solid #333;">Fecha</th>
			<th style="border:1px solid #333;">Cant Ficha</th>
			<th style="border:1px solid #333;">Cant Muestra</th>
			<th style="border:1px solid #333;">Talla</th>
			<th style="border:1px solid #333;">Clas 2</th>
			<th style="border:1px solid #333;">Clas 3</th>
			<th style="border:1px solid #333;">Clas 4</th>
			<th style="border:1px solid #333;">Cant Clas</th>
			<th style="border:1px solid #333;">Cod Def</th>
			<th style="border:1px solid #333;">Defecto</th>
			<th style="border:1px solid #333;">Familia</th>
			<th style="border:1px solid #333;">Ubicación</th>
			<th style="border:1px solid #333;">Observación</th>
			<th style="border:1px solid #333;">Sede</th>
			<th style="border:1px solid #333;">Tipo de servicio</th>
			<th style="border:1px solid #333;">Cliente</th>
			<th style="border:1px solid #333;">Estilo TSC</th>
			<th style="border:1px solid #333;">Estilo cliente</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $row['PEDIDO']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DSCCOL']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CODFIC']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['GENERADO']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['PARTE']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CODUSU']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['FECINIAUD']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANTIDAD']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANMUE']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESTAL']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANFIN2']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANFIN3']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANFIN4']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANCLA']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CODDEFAUX']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESDEF']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DSCFAMILIA']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESUBIDEF']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['OBS']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['DESSEDE']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['DESTIPSERV']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESCLI']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['ESTTSC']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['ESTCLI']); ?></td>
		</tr>
		<?php
			}
		?>
	</tbody>
</table>
<?php
	}
?>