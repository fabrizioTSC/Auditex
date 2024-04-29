<?php
	include('connection.php');
	$response=new stdClass();

	$proveedores=array();
	$obj=new stdClass();
	$obj->CODPRV="0";
	$obj->DESPRV="(TODOS)";
	$proveedores[0]=$obj;
	$i=1;
	$sql="BEGIN SP_AUDTEL_SELECT_PROVEEDOR(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODPRV=$row['CODPRV'];
		$obj->DESPRV=utf8_encode($row['DESCLI']);
		$proveedores[$i]=$obj;
		$i++;
	}
	$response->proveedores=$proveedores;

	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>