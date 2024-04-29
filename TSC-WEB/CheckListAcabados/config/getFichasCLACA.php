<?php
	include('connection.php');
	$response=new stdClass();

	$fichas=array();
	$i=0;		
	$sql="BEGIN SP_CLACA_SELECT_VALFIC(:CODFIC,:ESTADO); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':ESTADO', $estado,40);
	$result=oci_execute($stmt);
	if ($estado==0) {			
		$response->state=false;
		$response->detail="Ficha no encontrada!";
	}else{
		$response->state=true;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>