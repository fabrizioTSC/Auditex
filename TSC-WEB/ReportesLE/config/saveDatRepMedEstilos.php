<?php
	include('connection.php');
	$response=new stdClass();

	$array=$_POST['array'];
	for ($i=0; $i < count($array); $i++) {		
		$sql="BEGIN SP_RLE_UPDATE_POPLMEDSESTREP(:PO,:PACLIS,:ESTCLI,:COM); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PO', $_POST['po']);
		oci_bind_by_name($stmt, ':PACLIS', $_POST['paclis']);
		oci_bind_by_name($stmt, ':ESTCLI', $array[$i][0]);
		oci_bind_by_name($stmt, ':COM', $array[$i][1]);
		$result=oci_execute($stmt);
	}
	$response->state=true;
	$response->detail="Datos guardados";

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>