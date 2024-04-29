<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_INSP_SELECT_DATEMINCOM(:FECHA); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':FECHA', $fechamincom,40);
	$result=oci_execute($stmt);

	$array=$_POST['array'];
	$err=0;
	for ($i=0; $i < count($array); $i++) { 
		$sql="BEGIN SP_INSP_UPDATE_DETMINCOM(:LINEA,:FECHA,:TURNO,:CODFIC,:MINCOM,:OBS); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt, ':LINEA', $_POST['linea']);
		oci_bind_by_name($stmt, ':FECHA', $fechamincom);
		oci_bind_by_name($stmt, ':TURNO', $_POST['turno']);
		oci_bind_by_name($stmt, ':CODFIC', $array[$i][0]);
		oci_bind_by_name($stmt, ':MINCOM', $array[$i][1]);
		oci_bind_by_name($stmt, ':OBS', $array[$i][2]);
		$result=oci_execute($stmt);
		if (!$result) {
			$err++;
		}
	}
	if ($err==0) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo guardar los tiempos!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>