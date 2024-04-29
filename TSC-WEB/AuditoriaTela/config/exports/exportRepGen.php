<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Reporte_general.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
function get_estado($text){
	switch($text) {
		case "0":
			return "Todos";
			break;
		case "1":
			return "Terminado";
			break;
		case "2":
			return "Por terminar";
			break;
		case "3":
			return "Por auditar";
			break;
	}
}
?>
<div style="font-size: 20px;font-weight: bold;">Reporte General</div>
<br>
<div style="font-weight: bold;">Estado: <?php echo get_estado($_GET['estado']); ?></div>
<br>
<?php
	include('../connection.php');

	$ar_fecini=explode("-",$_GET['fecini']);
	$ar_fecfin=explode("-",$_GET['fecfin']);

	$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
	$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];

	$sql="BEGIN SP_AUDTEL_REPORTE_GENERAL(:FECINI,:FECFIN,:CODPRV,:TIPO,:RESULTADO,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
	oci_bind_by_name($stmt, ':TIPO', $_GET['estado']);
	oci_bind_by_name($stmt, ':RESULTADO', $_GET['resultado']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
?>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Partida</th>
			<th style="border:1px solid #333;">Proveedor</th>
			<th style="border:1px solid #333;">Cliente</th>
			<th style="border:1px solid #333;">Cod. Tela</th>
			<th style="border:1px solid #333;">Desc. Tela</th>
			<th style="border:1px solid #333;">Programa</th>
			<th style="border:1px solid #333;">Cod. Color</th>
			<th style="border:1px solid #333;">Desc. Color</th>


			<th style="border:1px solid #333;">Num. Vez</th>
			<th style="border:1px solid #333;">Auditor</th>
			<th style="border:1px solid #333;">Coordinador</th>
			<th style="border:1px solid #333;">Fec. Inicio</th>
			<th style="border:1px solid #333;">Fec. Fin</th>
			<th style="border:1px solid #333;">Resultado</th>
			<th style="border:1px solid #333;">Estado</th>
			<th style="border:1px solid #333;">Res. Tono</th>
			<th style="border:1px solid #333;">Res. Apariencia</th>
			<th style="border:1px solid #333;">Res. Est. Dim.</th>
			<th style="border:1px solid #333;">Rollos</th>
			<th style="border:1px solid #333;">Rol. a Auditar</th>
			<th style="border:1px solid #333;">Calificaci&oacute;n</th>
			<th style="border:1px solid #333;">Puntos</th>
			<th style="border:1px solid #333;">Tipo</th>
			<th style="border:1px solid #333;">Peso</th>
			<th style="border:1px solid #333;">Pes. Auditado</th>
			<th style="border:1px solid #333;">Pes. Aprobado</th>
			<th style="border:1px solid #333;">Pes. Caida</th>
			<th style="border:1px solid #333;">% Kg Caida</th>
		</tr>
	</thead>
	<tbody>
<?php
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $row['PARTIDA']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESPRV']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['CLIENTE']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CODTEL']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESTEL']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['PROGRAMA']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['CODCOL']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DSCCOL']); ?></td>


			<td style="border:1px solid #333;"><?php echo $row['NUMVEZ']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CODUSU']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CODUSUEJE']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['FECINIAUDF']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['FECFINAUDF']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['RESULTADOF']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['ESTADO']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['RESTONTSCF']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['RESAPATSCF']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['RESESTDIMTSCF']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['ROLLOS']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['ROLLOSAUD']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CALIFICACION']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['PUNTOS']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['TIPO']; ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['PESO']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['PESOAUD']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['PESOAPRO']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['PESOCAI']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['PORKGCAIDA'])." %"; ?></td>
		</tr>
<?php
	}
?>
	</tbody>
</table>