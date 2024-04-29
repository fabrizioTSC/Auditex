<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	
	$esttsc="";
	$sql="BEGIN SP_AA_SELECT_ESTTSCREPDESMED(:PEDIDO,:COLOR,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
	oci_bind_by_name($stmt, ':COLOR', $_POST['color']);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$esttsc=$row['ESTTSC'];
	}
	$response->state=true;
	$response->esttsc=$esttsc;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>