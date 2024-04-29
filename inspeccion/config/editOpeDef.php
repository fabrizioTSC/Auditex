<?php
	include("connection.php");
	$response=new stdClass();

	$sql="BEGIN SP_INSP_UPDATE_DETINSCOS(:CODINSCOS,:CODDEF,:CODOPE,:CANDET); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':CODINSCOS', $_POST['codinscos']);
	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	oci_bind_by_name($stmt, ':CODOPE', $_POST['codope']);
	oci_bind_by_name($stmt, ':CANDET', $_POST['candet']);
	$result=oci_execute($stmt);

	if ($result==true) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo editar la operación/defecto!";
	}

	oci_close($conn);
	header("Content-Type:application/json");
	echo json_encode($response);
?>