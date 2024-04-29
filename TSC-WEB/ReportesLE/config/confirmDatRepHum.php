<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_RLE_UPDATE_CONHUM(:PO,:PACLIS,:CODUSU); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PO', $_POST['po']);
	oci_bind_by_name($stmt, ':PACLIS', $_POST['paclis']);
	session_start();
	oci_bind_by_name($stmt, ':CODUSU', $_SESSION['user']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->detail="Reporte confirmado";
	}else{
		$response->state=false;
		$response->detail="No se pudo confirmar el reporte";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>