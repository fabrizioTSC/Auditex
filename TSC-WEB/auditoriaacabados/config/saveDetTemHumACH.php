<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_ACH_UPDATE_FICDATCAB(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:TEMAMB,:HUMAMB); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':TEMAMB', $_POST['temamb']);
	oci_bind_by_name($stmt, ':HUMAMB', $_POST['humamb']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="Hubo un error al guardar los datos";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);