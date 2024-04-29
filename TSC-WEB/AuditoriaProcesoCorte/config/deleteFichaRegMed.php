<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_APCR_DELETE_FICHAREGMED(:CODFIC,:HILO,:TRAVEZ,:LARGMANGA); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':HILO', $_POST['hilo']);
	oci_bind_by_name($stmt, ':TRAVEZ', $_POST['travez']);
	oci_bind_by_name($stmt, ':LARGMANGA', $_POST['largmanga']);
	$result=oci_execute($stmt);

	if ($result) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo eliminar la ficha!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);