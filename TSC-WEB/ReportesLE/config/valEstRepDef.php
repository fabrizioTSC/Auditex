<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_RLE_SELECT_ESTDEF(:PO,:PACLIS,:ESTADO,:ESTADOHUM); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PO', $_POST['po']);
	oci_bind_by_name($stmt, ':PACLIS', $_POST['paclis']);
	oci_bind_by_name($stmt, ':ESTADO', $estado,40);
	oci_bind_by_name($stmt, ':ESTADOHUM', $estadohum,40);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->estado=trim($estado);
		$response->estadohum=trim($estadohum);
	}else{
		$response->state=false;
		$response->detail="No se pudo encontrar el estado del reporte";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>