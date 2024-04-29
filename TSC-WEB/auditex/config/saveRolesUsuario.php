<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

	$err=0;
	$array=$_POST['array'];
	for ($i=0; $i <count($array) ; $i++) {
		$sqlUpdate="BEGIN SP_AT_UPDATE_ROLESBYUSU(:CODUSU,:CODTAD,:CODROL); END;";
		$stmt=oci_parse($conn, $sqlUpdate);
		oci_bind_by_name($stmt, ':CODUSU',$_POST['codusu']);
		oci_bind_by_name($stmt, ':CODTAD',$array[$i][0]);
		oci_bind_by_name($stmt, ':CODROL',$array[$i][1]);
		$result=oci_execute($stmt);
		if (!$result) {
			$err++;
		}
	}
	if ($err!=0) {
		$response->state=false;
		$error->detail="Algunos roles no se guardaron!";
	}else{
		$response->state=true;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>