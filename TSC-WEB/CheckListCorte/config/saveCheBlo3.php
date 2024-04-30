<?php
	set_time_limit(240);
	include('connection.php');

	$response = new stdClass();
	$array = $_POST['array'];

	$con_err = 0;

	foreach ($array as $item) {
		$sql = "EXEC AUDITEX.SP_CLC_INSERT_CHEBLO3 ?, ?, ?, ?, ?, ?";
		$stmt = sqlsrv_prepare($conn, $sql, array(
			$_POST['codfic'], 
			$_POST['codtad'], 
			$_POST['numvez'], 
			$_POST['parte'], 
			$item[0], 
			$item[1]
		));
		$result = sqlsrv_execute($stmt);
		if ($stmt === false) {
			$con_err++;
		}
	}

	$sql = "EXEC AUDITEX.SP_CLC_UPDATE_CHEBLO3END ?, ?, ?, ?, ?, ?";
	$stmt = sqlsrv_prepare($conn, $sql, array(
		$_POST['codfic'], 
		$_POST['codtad'], 
		$_POST['numvez'], 
		$_POST['parte'], 
		$_POST['obs'], 
		$_POST['resultado']
	));
	$result = sqlsrv_execute($stmt);

	if ($result) {
		$response->state = true;
	} else {
		$response->state = false;
		$response->detail = "No se pudo guardar la validación";
	}

	sqlsrv_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);


/*	set_time_limit(240);
	include('connection.php');
	$response=new stdClass();
	$array=$_POST['array'];

	$con_err=0;
	for ($i=0; $i < count($array); $i++) { 
		$sql="BEGIN SP_CLC_INSERT_CHEBLO3(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:CODTEN,:RESTEN); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		oci_bind_by_name($stmt, ':CODTEN', $array[$i][0]);
		oci_bind_by_name($stmt, ':RESTEN', $array[$i][1]);
		$result=oci_execute($stmt);
		if (!$result) {
			$con_err++;
		}
	}

	$sql="BEGIN SP_CLC_UPDATE_CHEBLO3END(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OBS,:RESULTADO); END;";
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
	echo json_encode($response); */
?>