<?php
	include('connection.php');
	$response=new stdClass();

	$array=$_POST['array'];
	$err=0;
	for ($i=0; $i < count($array); $i++) { 
		/*
		$sql="BEGIN SP_INSP_UPDATE_MINCOMEST(:ESTTSC,:ALTERNATIVA,:RUTA,:MINADIC); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
		oci_bind_by_name($stmt, ':ALTERNATIVA', $array[$i][0]);
		oci_bind_by_name($stmt, ':RUTA', $array[$i][1]);
		oci_bind_by_name($stmt, ':MINADIC', $array[$i][2]);
		$result=oci_execute($stmt);
		if (!$result) {
			$err++;
		}else{
			*/
			$sql="BEGIN SP_INSP_INSERT_LOGMINCOMV2(:ESTTSC,:ALTERNATIVA,:RUTA,:MINADICINI,:MINADICFIN,:OBS,:CODUSU); END;";
			$stmt=oci_parse($conn,$sql);
			oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
			oci_bind_by_name($stmt, ':ALTERNATIVA', $array[$i][0]);
			oci_bind_by_name($stmt, ':RUTA', $array[$i][1]);
			oci_bind_by_name($stmt, ':MINADICFIN', $array[$i][2]);
			oci_bind_by_name($stmt, ':MINADICINI', $array[$i][3]);
			oci_bind_by_name($stmt, ':OBS', $array[$i][4]);
			oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
			$result=oci_execute($stmt);
		/*}*/
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