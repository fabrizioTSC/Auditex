<?php

	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AA_UPDATE_OBSAUDMED(:CODFIC,:OBS); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	$obs=utf8_decode($_POST['obs']);
	oci_bind_by_name($stmt, ':OBS', $obs);
	$result=oci_execute($stmt);

	if ($result) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo guardar la observacion de la auditoría";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>