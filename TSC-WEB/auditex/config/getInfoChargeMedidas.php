<?php
	include("connection.php");
	$response=new stdClass();

	$sql="BEGIN SP_AT_INFO_TAMDESMED(:TAMDESMED); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':TAMDESMED', $tamdesmed,40);
	$result=oci_execute($stmt);

	$response->tamdesmed=$tamdesmed;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>