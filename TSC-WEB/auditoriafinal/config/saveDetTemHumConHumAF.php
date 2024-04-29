<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AF_UPDATE_CHPEDCOLCONHUMDET(:PEDIDO,:DESCOL,:TEMAMB,:HUMAMB); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
	oci_bind_by_name($stmt, ':DESCOL', $_POST['dsccol']);
	oci_bind_by_name($stmt, ':TEMAMB', $_POST['temamb']);
	oci_bind_by_name($stmt, ':HUMAMB', $_POST['humamb']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="Hubo un error al guardar los datos";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);