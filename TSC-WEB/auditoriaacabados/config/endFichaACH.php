<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_ACH_END_FICHA(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:RES,:OBS); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':RES', $_POST['res']);
	oci_bind_by_name($stmt, ':OBS', $_POST['obs']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->detail="Ficha terminada";
	}else{
		$response->state=false;
		$response->detail="Hubo un error al terminar la ficha";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);