<?php
	include('connection.php');
	$response=new stdClass();

	$celula=[];
	$taller=new stdClass();
	$taller->CODTLL="0";
	$taller->DESTLL="NINGUNA";
	array_push($celula, $taller);
	$sql="begin SP_CLC_SELECT_CELULAS(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$taller=new stdClass();
		$taller->CODTLL=$row['CODTLL'];
		$taller->DESTLL=utf8_encode($row['DESTLL']);
		array_push($celula, $taller);
	}
	$response->state=true;
	$response->celula=$celula;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>