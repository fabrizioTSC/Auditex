<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AT_ANULAR_FICHAAUDITORIA(:CODFIC,:PARTE,:NUMVEZ); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	$result=oci_execute($stmt);
	if($result){	
		$response->state=true;
		$response->detail="Ficha anulada!";
	}else{
		$response->state=false;
		$response->detail="La ficha no se puede anular!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>