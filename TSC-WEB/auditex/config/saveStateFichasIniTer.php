<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

	$conNExi=0;
	for ($i=0; $i <count($_POST['fichas']) ; $i++) {
		$sqlUpdate="BEGIN SP_AT_INITERFICHAS(:CODFIC,:USUMOV,:ESTADO,:CODTLL,:TIPMOV); END;";
		$stmt=oci_parse($conn, $sqlUpdate);
		oci_bind_by_name($stmt, ':CODFIC',$_POST['fichas'][$i]);	
		oci_bind_by_name($stmt, ':USUMOV',$_POST['usumov']);
		oci_bind_by_name($stmt, ':ESTADO',$_POST['estado']);
		oci_bind_by_name($stmt, ':CODTLL',$_POST['codtll']);
		oci_bind_by_name($stmt, ':TIPMOV',$_POST['tipmov']);
		$result=oci_execute($stmt);
		if (!$result) {
			$conNExi++;
		}
	}
	if ($conNExi!=0) {
		$response->state=false;
		$error->detail="Algunas fichas no se guardaron!";
	}else{
		$response->state=true;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>