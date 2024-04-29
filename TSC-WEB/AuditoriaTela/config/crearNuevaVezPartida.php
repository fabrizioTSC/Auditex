<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AUDTEL_INSERT_NUEPARAUDV2(:PARTIDA,:CODPRV,:CODTEL); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
	}else{
		$response->state=false;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>