<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_CLACA_SELECT_RESULTADOS(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$response->RESDOC=$row['RESDOC'];
		$response->RESFICPRO=$row['RESFICPRO'];
		$response->RESMED=$row['RESMED'];
		$response->OBSDOC=utf8_encode($row['OBSDOC']);
		$response->OBSFICPRO=utf8_encode($row['OBSFICPRO']);
		$response->OBSMED=utf8_encode($row['OBSMED']);
	}
	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>