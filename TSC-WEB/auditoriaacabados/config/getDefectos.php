<?php
	include('connection.php');
	$response=new stdClass();

	$defectos=[];
	$sql="begin SP_AA_SELECT_DEFECTOS(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$taller=new stdClass();
		$taller->CODDEF=$row['CODDEF'];
		$taller->DESDEF=utf8_encode($row['DESDEF']);
		$taller->CODDEFAUX=$row['CODDEFAUX'];
		array_push($defectos, $taller);
	}
	$response->state=true;
	$response->defectos=$defectos;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>