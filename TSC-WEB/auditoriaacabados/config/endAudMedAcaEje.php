<?php

	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AA_UPDATE_ENDAUDMEDACAEJE(:CODFIC,:CODUSU,:RES,:OBS); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	session_start();
	oci_bind_by_name($stmt, ':CODUSU', $_SESSION['user']);
	oci_bind_by_name($stmt, ':RES', $_POST['res']);
	oci_bind_by_name($stmt, ':OBS', $_POST['obs']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->detail="Auditoria finalizada";
	}else{
		$response->state=false;
		$response->detail="No se pudo actualizar la auditoria";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);