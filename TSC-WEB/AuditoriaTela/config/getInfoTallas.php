<?php
	include('connection.php');
	$response=new stdClass();

	$tallas=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_SELECT_TALLAS(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODTAL=$row['CODTAL'];
		$obj->DESTAL=utf8_encode($row['DESTAL']);
		$tallas[$i]=$obj;
		$i++;
	}
	$response->tallas=$tallas;
	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>