<?php
	include('connection.php');
	$response=new stdClass();

	/// VALIDA SI ESTA INICIADA LA FICHA
	/*$sql="BEGIN SP_APC_VALIDATE_INIFIC(:CODFIC,:CODTLL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_assoc($OUTPUT_CUR);
	if ($row['CONT']=="0") {
		$response->state=false;
		$response->detail="Debe iniciar la ficha primero!";
	}else{
		$response->state=true;
	}*/

	/// INICIA LA FICHA
	$sql="BEGIN SP_APC_UPDATE_INIFIC(:CODFIC,:CODTLL,:CODUSU); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo iniciar la ficha!";
	}
	
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>