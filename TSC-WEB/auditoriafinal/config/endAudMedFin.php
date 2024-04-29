<?php

	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AF_UPDATE_ENDAUDMEDFIN(:PEDIDO,:DESCOL,:CANTIDAD,:VALIDAR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
	oci_bind_by_name($stmt, ':DESCOL', $_POST['dsccol']);
	oci_bind_by_name($stmt, ':CANTIDAD', $_POST['cantidad']);
	oci_bind_by_name($stmt, ':VALIDAR', $validar,40);
	$result=oci_execute($stmt);
	if ($validar==0) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="Debe completar todas las medidas de las prendas no adicionales para terminar la auditoria";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);