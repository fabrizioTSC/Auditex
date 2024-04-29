<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Analisis_de_Defectos_de_Tela_Acabada.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

include("../connection.php");

if ($_GET['tipo']=="1") {
	$sql="BEGIN  SP_AUDTEL_IND_DEFECTOS_ALL(:CODPRV,:CODCLI,:CODPRO,:OUTPUT_CUR,:NUMANIO,:NUMSEM); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_GET['codcli']);
	oci_bind_by_name($stmt, ':CODPRO', $_GET['codpro']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	oci_bind_by_name($stmt, ':NUMANIO', $_GET['anio']);
	oci_bind_by_name($stmt, ':NUMSEM', $_GET['semana']);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
}else{
	$array_fecini=explode("-",$_GET['fecini']);
	$array_fecfin=explode("-",$_GET['fecfin']);
	$fecini=$array_fecini[0].$array_fecini[1].$array_fecini[2];
	$fecfin=$array_fecfin[0].$array_fecfin[1].$array_fecfin[2];	
	$sql="BEGIN SP_AUDTEL_IND_DEFECTOS_RF(:CODPRV,:CODCLI,:CODPRO,:OUTPUT_CUR,:FECINI,:FECFIN); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODPRV', $_GET['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_GET['codcli']);
	oci_bind_by_name($stmt, ':CODPRO', $_GET['codpro']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
}


?>
<div style="font-size: 20px;font-weight: bold;">AN&Aacute;LISIS DE DEFECTOS DE TELA ACABADA</div>
<br>
<div><?php echo $_GET['titulo']; ?></div>
<br>
<?php
	if ($_GET['tipo']=="1") {
?>
<div>A&ntilde;o: <?php echo $_GET['anio']; ?> - Semana: <?php echo $_GET['semana']; ?></div>
<?php
	}else{
?>
<div><?php echo "Del ".$array_fecini[2]."-".$array_fecini[1]."-".$array_fecini[0]." al ".$array_fecfin[2]."-".$array_fecfin[1]."-".$array_fecfin[0]; ?></div>
<?php
	}
?>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">#</th>
			<th style="border:1px solid #333;">DEFECTO</th>
			<th style="border:1px solid #333;">kg MUESTRA</th>
			<th style="border:1px solid #333;">TOTAL</th>
			<th style="border:1px solid #333;">DEFECTOS/tn</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$i=1;
			$sumtot=0;
			$defectos=[];
			while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
				$sumtot+=intval($row['SUMDEF']);
				$obj=new stdClass();
				$obj->DESDEF=utf8_encode($row['DESDEF']);
				$obj->SUMDEF=utf8_encode($row['SUMDEF']);
				$obj->CANMUE=utf8_encode($row['CANMUE']);
				array_push($defectos, $obj);
			}
			for ($i=0; $i < count($defectos); $i++) {
		?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $i+1;?></td>
			<td style="border:1px solid #333;"><?php echo $defectos[$i]->DESDEF;?></td>
			<td style="border:1px solid #333;"><?php echo number_format($defectos[$i]->CANMUE);?></td>
			<td style="border:1px solid #333;"><?php echo number_format($defectos[$i]->SUMDEF);?></td>
			<td style="border:1px solid #333;"><?php echo intval(intval($defectos[$i]->SUMDEF)*100000/intval($defectos[$i]->CANMUE))/100;?></td>
		</tr>
		<?php
			}
		?>
	</tbody>
</table>