<?php
	set_time_limit(240);
	include("connection.php");
	$response=new stdClass();

	$ar_fecha=explode('-', $_POST['fecini']);
	$fecini=$ar_fecha[0].$ar_fecha[1].$ar_fecha[2];

	$ar_fefin=explode('-', $_POST['fecfin']);
	$fecfin=$ar_fefin[0].$ar_fefin[1].$ar_fefin[2];

	$detalleedcol=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	oci_bind_by_name($stmt, ':RESULTADO', $_POST['resultado']);
	oci_bind_by_name($stmt, ':CODAREA', $_POST['codarea']);
	oci_bind_by_name($stmt, ':CODTON', $_POST['codton']);
	oci_bind_by_name($stmt, ':CODAPA', $_POST['codapa']);
	oci_bind_by_name($stmt, ':CODESTDIM', $_POST['codestdim']);
	oci_bind_by_name($stmt, ':RANGO', $_POST['rango']);
	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	$opcion=32;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$sumpes=0;
	$sumcan=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODCOL=utf8_decode($row['CODCOL']);
		$obj->RANGO=utf8_decode($row['RANGO']);
		$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
		$obj->CANTOT=str_replace(",",".",$row['CANTOT']);
		$sumpes+=floatval($row['PESTOT']);
		$sumcan+=floatval($row['CANTOT']);
		$detalleedcol[$i]=$obj;
		$i++;
	}
	$response->detalleedcol=$detalleedcol;
	$response->sumpesedcol=$sumpes;
	$response->sumcanedcol=$sumcan;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>