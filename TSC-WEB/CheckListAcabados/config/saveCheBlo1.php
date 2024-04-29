<?php
	set_time_limit(240);
	include('connection.php');
	$response=new stdClass();
	$array=$_POST['array'];

	$con_err=0;
	for ($i=0; $i < count($array); $i++) { 
		$sql="BEGIN SP_CLACA_INSERT_CHEBLO1(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:CODDOC,:RESDOC); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		oci_bind_by_name($stmt, ':CODDOC', $array[$i][0]);
		oci_bind_by_name($stmt, ':RESDOC', $array[$i][1]);
		$result=oci_execute($stmt);
		if (!$result) {
			$con_err++;
		}
	}

	$sql="BEGIN SP_CLACA_UPDATE_CHEBLO1END(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OBS,:RESULTADO,:NUMVEZFT,:HORARA); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':OBS', $_POST['obs']);
	oci_bind_by_name($stmt, ':RESULTADO', $_POST['resultado']);
	oci_bind_by_name($stmt, ':NUMVEZFT', $_POST['numvezft']);
	oci_bind_by_name($stmt, ':HORARA', $horara,40);
	$result=oci_execute($stmt);

	if ($result) {
		$response->state=true;
		$response->horara=$horara;
	}else{
		$response->state=false;
		$response->detail="No se pudo guardar la validacion!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);

?>