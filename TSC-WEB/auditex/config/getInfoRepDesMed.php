<?php
	include('connection.php');
	$response=new stdClass();

	$ar_fecini=explode("-",$_POST['fecini']);
	$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
	$ar_fecfin=explode("-",$_POST['fecfin']);
	$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];

	$header=array();
	$i=0;
	$sql="BEGIN SP_AT_REPORTE_DESV_MEDIDAS(:ESTTSC,:CODFIC,:FECINI,:FECFIN,:TIPO,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	$tipo=1;
	oci_bind_by_name($stmt, ':TIPO', $tipo);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->ESTCLI=$row['ESTCLI'];
		$obj->DESCLI=utf8_encode($row['DESCLI']);
		$header[$i]=$obj;
		$i++;
	}
	$response->header=$header;

	$datos=array();
	$i=0;
	$sql="BEGIN SP_AT_REPORTE_DESV_MEDIDAS(:ESTTSC,:CODFIC,:FECINI,:FECFIN,:TIPO,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	$tipo=2;
	oci_bind_by_name($stmt, ':TIPO', $tipo);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODMED=$row['CODMED'];
		$obj->DESMED=utf8_encode($row['DESMED']);
		$obj->CODDES=$row['CODDES'];
		$obj->SECUENCIA=$row['SECUENCIA'];
		$obj->VALPUL=$row['VALPUL'];
		$obj->VALCM=$row['VALCM'];
		$obj->TOLVAL=$row['TOLVAL'];
		$obj->CODTAL=$row['CODTAL'];
		$obj->DESTAL=utf8_encode($row['DESTAL']);
		$obj->ORDEN=$row['ORDEN'];
		$obj->TOTAL=$row['TOTAL'];
		$datos[$i]=$obj;
		$i++;
	}
	$response->datos=$datos;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>