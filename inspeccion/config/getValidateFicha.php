<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

	$codinscos="0";
	$sql="BEGIN SP_INSP_SELECT_INSCOSEXISTS(:CODFIC,:CODUSU,:CODTLL,:OUTPUT_CUR); END;";	
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt,':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt,':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt,':CODTLL', $_POST['codtll']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$codinscos=$row['CODINSCOS'];
	}
	$response->codinscos=$codinscos;
	if ($codinscos!="0") {
		$response->state=true;
	}else{
		$response->state=false;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>