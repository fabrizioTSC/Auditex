<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AA_UPDATE_DETAUDMED(:CODFIC,:NUMPRE,:CODTAL,:CODMED,:VALOR,:TOLVAL,:ESTADO); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':NUMPRE', $_POST['numpre']);
	oci_bind_by_name($stmt, ':CODTAL', $_POST['codtal']);
	oci_bind_by_name($stmt, ':CODMED', $_POST['codmed']);
	oci_bind_by_name($stmt, ':VALOR', $_POST['valor']);
	oci_bind_by_name($stmt, ':TOLVAL', $_POST['tolval']);
	oci_bind_by_name($stmt, ':ESTADO', $estado,40);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->estado=$estado;
	}else{
		$response->state=false;
		$response->detail="No se pudo actualizar el registro!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>