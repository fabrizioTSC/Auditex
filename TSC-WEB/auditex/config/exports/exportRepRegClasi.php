<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Reporte_registro_clasificacion.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

$ar_fecini=explode("-",$_GET['fecha']);

include("../connection.php");

$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
$sql="BEGIN SP_AT_REPORTE_REG_CLASIF(:FECHA,:CODTAD,:CODTLL,:CODUSU,:CODSED,:CODTIPSER,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':FECHA', $fecini);
oci_bind_by_name($stmt, ':CODTAD', $_GET['codtad']);
oci_bind_by_name($stmt, ':CODTLL', $_GET['codtll']);
oci_bind_by_name($stmt, ':CODUSU', $_GET['codusu']);
oci_bind_by_name($stmt, ':CODSED', $_GET['codsede']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['codtipser']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);

?>
<div style="font-size: 20px;font-weight: bold;">Reporte Registro de Clasificaci&oacute;n</div>
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
?>
<?php 
	if ($_GET['codtad']!="0") {
?>
<br>
<div style="font-weight: bold;">Tipo Auditoria: <?php echo $_GET['codtad'];?></div>
<?php
	}
	$fecini=$ar_fecini[2]."/".$ar_fecini[1]."/".$ar_fecini[0];
?>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Ficha</th>		
			<th style="border:1px solid #333;">Parte</th>
			<th style="border:1px solid #333;">N&uacute;m. Vez</th>
			<th style="border:1px solid #333;">Tipo Auditoria</th>
			<th style="border:1px solid #333;">AQL</th>
			<th style="border:1px solid #333;">Fecha Realizada</th>
			<th style="border:1px solid #333;">Usuario</th>
			<th style="border:1px solid #333;">Cant. Parte</th>
			<th style="border:1px solid #333;">Cant. Muestra</th>
			<th style="border:1px solid #333;">Cant. Max. Def.</th>
			<th style="border:1px solid #333;">Defectos</th>
			<th style="border:1px solid #333;">Resultado</th>
			<th style="border:1px solid #333;">Sede</th>
			<th style="border:1px solid #333;">Tipo Servicio</th>
			<th style="border:1px solid #333;">Taller</th>
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
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESTAD']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['AQL']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['FECFINAUDFOR']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['DESUSU']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANPAR']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANAUD']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANDEFMAX']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANDEF']; ?></td>
			<td style="border:1px solid #333;"><?php if($row['RESULTADO']=="A"){echo "Aprobado";}else{echo "Rechazado";} ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESSEDE']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESTIPSERV']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESTLL']); ?></td>
		</tr>
		<?php
			}
		?>
	</tbody>
</table>