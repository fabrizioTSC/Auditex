<?php
	include('connection.php');
	$response=new stdClass();

	$rec2=array();
	$i=0;
	$sql="BEGIN SP_AUDTEL_SELECT_PARAUDTONREC2(:CODREC1,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODREC1', $_POST['codrec1']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODREC1=$row['CODREC1'];
		$obj->CODREC2=$row['CODREC2'];
		$obj->DESREC2=utf8_encode($row['DESREC2']);
		$rec2[$i]=$obj;
		$i++;
	}
	$response->rec2=$rec2;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>