<?php
	include('connection.php');
	$response=new stdClass();

	$array=$_POST['array'];
	for ($i=0; $i < count($array); $i++) {
		$sql="BEGIN SP_RLE_UPDATE_POPLFOTOS(:PO,:PACLIS,:PEDIDO,:DESCOL,:RUTIMA,:TITULO,:SEL); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PO', $_POST['po']);
		oci_bind_by_name($stmt, ':PACLIS', $_POST['paclis']);
		oci_bind_by_name($stmt, ':PEDIDO', $array[$i][0]);
		oci_bind_by_name($stmt, ':DESCOL', $array[$i][1]);
		oci_bind_by_name($stmt, ':RUTIMA', $array[$i][2]);
		oci_bind_by_name($stmt, ':TITULO', $array[$i][3]);
		oci_bind_by_name($stmt, ':SEL', $array[$i][4]);
		$result=oci_execute($stmt);
	}
	$response->state=true;
	$response->detail="Datos guardados";

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>