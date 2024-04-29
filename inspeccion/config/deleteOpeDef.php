<?php
	include("connection.php");
	$response=new stdClass();

	$sql="BEGIN SP_INSP_DELETE_DETINSCOS(:CODINSCOS,:CODDEF,:CODOPE); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':CODINSCOS', $_POST['codinscos']);
	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	oci_bind_by_name($stmt, ':CODOPE', $_POST['codope']);
	$result=oci_execute($stmt);

	if ($result==true) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo eliminar la operación/defecto!";
	}

	oci_close($conn);
	header("Content-Type:application/json");
	echo json_encode($response);
?>