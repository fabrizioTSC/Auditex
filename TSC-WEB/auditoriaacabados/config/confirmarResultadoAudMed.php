<?php

	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AA_UPDATE_CONRESAUDMED(:CODFIC,:RES); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':RES', $_POST['res']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
	}else{
		$response->detail="No se pudo confirmar el resultado";
		$response->state=false;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);