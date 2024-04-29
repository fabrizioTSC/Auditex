<?php
	include('connection.php');
	$response=new stdClass();
	
	$tipos=array();
	$i=0;
	$sql="BEGIN SP_AT_SELECT_TIPAUDS(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$taller=new stdClass();
		$taller=$row;
		$tipos[$i]=$taller;
		$i++;
	}

	$aqls=array();
	$i=0;
	$sql="BEGIN SP_AT_SELECT_AQLS(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$taller=new stdClass();
		$taller=$row;
		$aqls[$i]=$taller;
		$i++;
	}
	$response->state=true;
	$response->tipos=$tipos;
	$response->aqls=$aqls;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>