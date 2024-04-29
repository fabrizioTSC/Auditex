<?php
	include('connection.php');
	$response=new stdClass();

	$programa=array();
	$obj=new stdClass();
	$obj->CODPRO="0";
	$obj->DESPRO="(TODOS)";
	$programa[0]=$obj;
	$i=1;
	$sql="BEGIN SP_AUDTEL_SELECT_PROGRAMA(:CODPRV,:CODCLI,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODPRO=utf8_encode($row['PROGRAMA']);
		$obj->DESPRO=utf8_encode($row['PROGRAMA']);
		$programa[$i]=$obj;
		$i++;
	}
	$response->programa=$programa;

	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>