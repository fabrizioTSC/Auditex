<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AFC_UPDATE_FICEND(:CODFIC,:RES,:OBS); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':RES', $_POST['res']);
	oci_bind_by_name($stmt, ':OBS', $_POST['obs']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo actualizar la ficha!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>