<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Reporte_de_Estabilidad_Dimensional.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>
<div style="font-size: 20px;font-weight: bold;">Reporte de Estabilidad Dimensional</div>
<br>
<?php
	include('../connection.php');

	$titulo="";
	if ($_GET['codprv']=="0") {
		$titulo.="PROVEEDOR: "."(TODOS)";
	}else{
		$sql="BEGIN SP_AUDTEL_SELECT_PRVIND(:CODPRV,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$titulo.="PROVEEDOR: ".utf8_encode($row['DESPRV']);
	}
	if ($_GET['codcli']=="0") {
		$titulo.=" / CLIENTE: (TODOS)";
	}else{
		$sql="BEGIN SP_AUDTEL_SELECT_PRVIND(:CODCLI,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODCLI', $_GET['codcli']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$titulo.=" / CLIENTE: ".utf8_encode($row['DESPRV']);
	}
	if ($_GET['codtel']=="0") {
		$titulo.=" / TELA: (TODOS)";
	}else{
		$titulo.=" / TELA: ".$_GET['codtel'];
	}
	if ($_GET['codcol']=="0") {
		$titulo.=" / COLOR: (TODOS)";
	}else{
		$titulo.=" / COLOR: ".$_GET['codcol'];
	}
	if ($_GET['codpro']=="0") {
		$titulo.=" / PROGRAMA: (TODOS)";
	}else{
		$titulo.=" / PROGRAMA: ".$_GET['codpro'];
	}

	$ar_fecha=explode('-', $_GET['fecini']);
	$fecini=$ar_fecha[0].$ar_fecha[1].$ar_fecha[2];

	$ar_fefin=explode('-', $_GET['fecfin']);
	$fecfin=$ar_fefin[0].$ar_fefin[1].$ar_fefin[2];

	echo '<div style="font-size: 15px;font-weight: bold;">'.$titulo.'</div><br>';
	
	$sql="BEGIN SP_AUDTEL_REP_DENS_ANCHO_PRG(:FECINI,:FECFIN,:CODPRV,:CODCLI,:OPCION,:CODTEL,:CODCOL,:CODPRO,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_GET['codcli']);
	$opcion=1;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	oci_bind_by_name($stmt, ':CODTEL', $_GET['codtel']);
	oci_bind_by_name($stmt, ':CODCOL', $_GET['codcol']);
	oci_bind_by_name($stmt, ':CODPRO', $_GET['codpro']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	
?>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">#</th>
			<th style="border:1px solid #333;">Partida</th>
			<th style="border:1px solid #333;">Proveedor</th>
			<th style="border:1px solid #333;">Cliente</th>
			<th style="border:1px solid #333;">Programa</th>
			<th style="border:1px solid #333;">Cod. Tela</th>
			<th style="border:1px solid #333;">Desc. Tela</th>
			<th style="border:1px solid #333;">Color</th>
			<th style="border:1px solid #333;">Ancho</th>
			<th style="border:1px solid #333;">Std. Ancho</th>
			<th style="border:1px solid #333;">LIC2</th>
			<th style="border:1px solid #333;">LSC3</th>
			<th style="border:1px solid #333;">Densidad</th>
			<th style="border:1px solid #333;">Est&aacute;ndar</th>
			<th style="border:1px solid #333;">LIC</th>
			<th style="border:1px solid #333;">LSC</th>
			<th style="border:1px solid #333;">Fecha</th>
			<th style="border:1px solid #333;">KG.</th>
			<th style="border:1px solid #333;">Gr. por desv. por m2 de std.</th>
			<th style="border:1px solid #333;">% de desv. por  dens. std.</th>
			<th style="border:1px solid #333;">KG. afectados +/-</th>
			<th style="border:1px solid #333;">KG. afectados +</th>
			<th style="border:1px solid #333;">%Enc Anc 3ra Lav</th>
			<th style="border:1px solid #333;">Std %Enc Anc 3ra Lav </th>
			<th style="border:1px solid #333;">LI A3</th>
			<th style="border:1px solid #333;">LS A3</th>
			<th style="border:1px solid #333;">%Enc Lar 3ra Lav</th>
			<th style="border:1px solid #333;">Std %Enc Lar 3ra Lav </th>
			<th style="border:1px solid #333;">LI L3</th>
			<th style="border:1px solid #333;">LS L3</th>
			<th style="border:1px solid #333;">%Rev 3ra Lav</th>
			<th style="border:1px solid #333;">Std %Rev 3ra Lav</th>
			<th style="border:1px solid #333;">LI R3</th>
			<th style="border:1px solid #333;">LS R3</th>
			<th style="border:1px solid #333;">Inc Aca</th>
			<th style="border:1px solid #333;">Std Inc Aca</th>
			<th style="border:1px solid #333;">LI Inc Aca</th>
			<th style="border:1px solid #333;">LS Inc Aca</th>
			<th style="border:1px solid #333;">Inc Lav</th>
			<th style="border:1px solid #333;">Std Inc Lav</th>
			<th style="border:1px solid #333;">LI Inc Lav</th>
			<th style="border:1px solid #333;">LS Inc Lav</th>
		</tr>
	</thead>
	<tbody>
<?php
	$i=1;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $i; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['PARTIDA']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['PROVEEDOR']); ?></td>		
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['CLIENTE']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['PROGRAMA']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['CODTEL']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESTEL']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['CODCOL']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['VALORTSC']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['VALOR']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['LI']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['LS']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['VALORTSCANCHO']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['VALORANCHO']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['LIANCHO']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['LSANCHO']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['FECFINAUD']; ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['PESO']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['GR_DESV']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['POR_GR_DESV']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['KG_AFEC']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['KG_AFEC_MAS']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['VALORTSCENCANCHO3']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['VALORENCANCHO3']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['LIENCANCHO3']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['LSENCANCHO3']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['VALORTSCENCLARGO3']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['VALORENCLARGO3']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['LIENCLARGO3']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['LSENCLARGO3']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['VALORTSCREV3']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['VALORREV3']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['LIREV3']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['LSREV3']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['VALORTSCINCACA']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['VALORINCACA']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['LIINCACA']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['LSINCACA']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['VALORTSCINCLAV']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['VALORINCLAV']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['LIINCLAV']); ?></td>
			<td style="border:1px solid #333;"><?php echo str_replace(",",".",$row['LSINCLAV']); ?></td>
		</tr>
<?php
		$i++;
	}
?>
	</tbody>
</table>