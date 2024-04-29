<?php
	include("connection.php");
	$response=new stdClass();

	$ar_fecini=explode("-",$_POST['fecini']);
	$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
	$ar_fecfin=explode("-",$_POST['fecfin']);
	$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];

	$mincom=[];
	$i=0;
	$sql="BEGIN SP_INSP_REP_MINCOM(:FECINI,:FECFIN,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->FECHA=$row['FECHA'];
		$obj->LINEA=$row['LINEA'];
		$obj->TURNO=$row['TURNO'];
		$obj->HORINI=$row['HORINI'];
		$obj->HORFIN=$row['HORFIN'];
		$obj->CODFIC=$row['CODFIC'];
		$obj->ESTCLI=$row['ESTCLI'];
		$obj->ESTTSC=$row['ESTTSC'];
		$obj->ALTERNATIVA=$row['ALTERNATIVA'];
		$obj->RUTA=$row['RUTA'];
		$obj->TIESTD=str_replace(",",".",$row['TIESTD']);
		$obj->TIECOMEST=intval(floatval(str_replace(",",".",$row['TIE_COM_EST']))*1000)/1000;
		$obj->TIECOM=intval(floatval(str_replace(",",".",$row['TIECOM']))*1000)/1000;
		$obj->TIETOT=str_replace(",",".",$row['TIETOT']);
		$obj->OBS=utf8_encode($row['OBS']);
		$mincom[$i]=$obj;
		$i++;
	}
	$response->mincom=$mincom;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>