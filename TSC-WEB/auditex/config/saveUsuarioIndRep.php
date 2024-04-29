<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AT_INSERT_INDREPUSU(:CODUSU); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
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