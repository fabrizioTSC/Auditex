<?php
	include('connection.php');
	$response=new stdClass();

	$estdim=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_SELECT_ESTDIMCARGA(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODESTDIM=$row['CODESTDIM'];
		$obj->DESESTDIM=utf8_encode($row['DESESTDIM']);
		$obj->DIMTOL=$row['DIMTOL'];
		$obj->DIMVAL=$row['DIMVAL'];
		$estdim[$i]=$obj;
		$i++;
	}
	$response->estdim=$estdim;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>