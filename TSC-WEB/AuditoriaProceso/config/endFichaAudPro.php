<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_APC_UPDATE_AUDITORIAPROCESO(:CODFIC,:SECUEN); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':SECUEN', $_POST['secuen']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->detail="Auditoria Finalizada";
	}else{
		$response->state=false;
		$response->detail="No se pudo finalizar la auditoria!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>