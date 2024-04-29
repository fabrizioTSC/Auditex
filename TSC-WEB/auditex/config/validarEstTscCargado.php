<?php
	include('connection.php');
	$response=new stdClass();

	$val_round=1;
	$sql="BEGIN SP_AT_VAL_ESTTSC(:ESTTSC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	
	$row=oci_fetch_assoc($OUTPUT_CUR);
	if($row['CANTIDAD']=="0"||$row['CANTIDAD']==0){
		$response->state=true;
	}else{
		$response->state=false;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);	
?>