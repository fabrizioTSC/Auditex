<?php
	include('connection.php');
	$response=new stdClass();

	$talleres=[];
	$i=0;
	$sql="begin SP_AT_SELECT_TALLERES(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$taller=new stdClass();
		$taller->CODTLL=$row['CODTLL'];
		$taller->DESTLL=utf8_encode($row['DESTLL']);
		$taller->DESCOM=utf8_encode($row['DESCOM']);
		$talleres[$i]=$taller;
		$i++;
	}
	$response->state=true;
	$response->talleres=$talleres;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>