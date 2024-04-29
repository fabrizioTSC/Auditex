<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_INSP_SELECT_DEFECTO(:CODDEF,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);

	$row=oci_fetch_assoc($OUTPUT_CUR);
	$defecto=new stdClass();
	$defecto->CODDEF=$row['CODDEF'];
	$defecto->CODDEFAUX=$row['CODDEFAUX'];
	$defecto->CODFAM=$row['CODFAM'];
	$defecto->DESDEF=utf8_encode($row['DESDEF']);
	$defecto->DSCFAMILIA=utf8_encode($row['DSCFAMILIA']);

	$response->defecto=$defecto;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>