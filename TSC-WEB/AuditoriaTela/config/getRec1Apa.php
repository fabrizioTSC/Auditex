<?php
	include('connection.php');
	$response=new stdClass();

	$rec1=array();
	$i=0;
	$sql="BEGIN SP_AUDTEL_SELECT_PARAUDAPAREC1(:CODGRPREC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODGRPREC', $_POST['codgrprec']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODREC1=$row['CODREC1'];
		$obj->DESREC1=utf8_encode($row['DESREC1']);
		$obj->CM=$row['CM'];
		$obj->CAIDA=$row['CAIDA'];
		$rec1[$i]=$obj;
		$i++;
	}
	$response->rec1=$rec1;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>