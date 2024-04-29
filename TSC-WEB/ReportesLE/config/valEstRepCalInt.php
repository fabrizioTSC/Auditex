<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_RLE_SELECT_ESTCALINT(:PO,:PACLIS,:ESTADO); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PO', $_POST['po']);
	oci_bind_by_name($stmt, ':PACLIS', $_POST['paclis']);
	oci_bind_by_name($stmt, ':ESTADO', $estado,40);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->estado=trim($estado);
	}else{
		$response->state=false;
		$response->detail="No se pudo encontrar el estado del reporte";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>