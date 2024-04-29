<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_ACH_UPDATE_RESFIC(:CODFIC,:NUMVEZ,:PARTE,:RES,:OBS); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':RES', $_POST['resultado']);
	oci_bind_by_name($stmt, ':OBS', $_POST['obs']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->detail="Auditoria actualizada!";
	}else{
		$response->state=false;
		$response->detail="No se pudo actualizar el registro!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>