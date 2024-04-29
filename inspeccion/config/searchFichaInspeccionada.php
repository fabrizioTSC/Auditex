<?php
	include("connection.php");
	$response=new stdClass();

	$defectos=[];
	$i=0;

	$sql="BEGIN SP_INSP_SELECT_FICHAINSPEC(:CODINSCOS,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':CODINSCOS', $_POST['codinscos']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$defecto=new stdClass();
		$defecto->CODOPE=$row['CODOPE'];
		$defecto->DESOPE=utf8_encode($row['DESOPE']);
		$defecto->CODDEF=$row['CODDEF'];
		$defecto->DESDEF=utf8_encode($row['DESDEF']);
		$defecto->CANDET=$row['CANDET'];
		$defectos[$i]=$defecto;
		$i++;
	}
	$response->defectos=$defectos;
	$response->state=true;		

	oci_close($conn);
	header("Content-Type:application/json");
	echo json_encode($response);
?>