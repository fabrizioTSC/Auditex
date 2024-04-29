<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_RLE_SELECT_ESTDETMET(:PO,:ESTADO); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PO', $_POST['po']);
	oci_bind_by_name($stmt, ':ESTADO', $id,40);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->ID=trim($id);
	}else{
		$response->state=false;
		$response->detail="No se pudo encontrar el estado del reporte";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>