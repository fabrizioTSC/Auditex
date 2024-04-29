<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_APCR_UPDATE_FICCORMEDFIN(:CODFIC,:NUMPRE,:CODTAL,:CODMED,:VALOR,:TOLVAL,:HILO,:TRAVEZ,:LARGMANGA); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':NUMPRE', $_POST['numpre']);
	oci_bind_by_name($stmt, ':CODTAL', $_POST['codtal']);
	oci_bind_by_name($stmt, ':CODMED', $_POST['codmed']);
	oci_bind_by_name($stmt, ':VALOR', $_POST['valor']);
	oci_bind_by_name($stmt, ':TOLVAL', $_POST['tolval']);
	oci_bind_by_name($stmt, ':HILO', $_POST['hilo']);
	oci_bind_by_name($stmt, ':TRAVEZ', $_POST['travez']);
	oci_bind_by_name($stmt, ':LARGMANGA', $_POST['largmanga']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo actualizar el registro!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>