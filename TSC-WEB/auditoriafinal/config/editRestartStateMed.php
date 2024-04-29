<?php

	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AF_UPDATE_RESTARTMED(:PEDIDO,:DESCOL); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
	oci_bind_by_name($stmt, ':DESCOL', $_POST['dsccol']);
	$result=oci_execute($stmt);

	if ($result) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo reiniciar el estado de la auditoría";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>