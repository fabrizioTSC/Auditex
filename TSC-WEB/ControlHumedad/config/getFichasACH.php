<?php
	include('connection.php');
	$response=new stdClass();

	$fichas=array();
	$i=0;		
	$sql="BEGIN SP_ACH_SELECT_FICHAS(:CODFIC,:ESTADO); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':ESTADO', $estado,40);
	$result=oci_execute($stmt);
	if ($estado==0) {			
		$response->state=false;
		$response->detail="Ficha no encontrada!";
	}else{
		$sql="BEGIN SP_ACH_VALFICTER(:CODFIC,:ESTADO); END;";
		$stmt=oci_parse($conn, $sql);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':ESTADO', $estado,40);
		$result=oci_execute($stmt);
		if ($estado==0) {
			$response->state=true;
		}else{
			$response->state=false;
			$response->detail="Las fichas fueron terminadas!";
		}
		
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>