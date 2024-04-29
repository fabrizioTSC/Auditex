<?php
	set_time_limit(240);
	include('connection.php');
	$response=new stdClass();
	$array=$_POST['array'];

	$con_err=0;
	for ($i=0; $i < count($array); $i++) { 
		$sql="BEGIN SP_CLC_INSERT_CHEBLO1(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:CODDOC,:RESDOC,:REPOSO); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		oci_bind_by_name($stmt, ':CODDOC', $array[$i][0]);
		oci_bind_by_name($stmt, ':RESDOC', $array[$i][1]);
		$float=floatval($array[$i][2])*100;
		oci_bind_by_name($stmt, ':REPOSO', $float);
		$result=oci_execute($stmt);
		if (!$result) {
			$con_err++;
		}
	}

	$sql="BEGIN SP_CLC_UPDATE_CHEBLO1END(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OBS,:RESULTADO); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':OBS', $_POST['obs']);
	oci_bind_by_name($stmt, ':RESULTADO', $_POST['resultado']);
	$result=oci_execute($stmt);

	if ($result) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo guardar la validacion!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);

?>