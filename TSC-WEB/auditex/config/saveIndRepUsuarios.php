<?php
	include('connection.php');
	$response=new stdClass();

	$array=$_POST['array'];
	$cont=0;
	for ($i=0; $i < count($array) ; $i++) { 
		$sql="BEGIN SP_AT_INSERT_INDREPDET(:CODUSU,:CODTAD,:CODTIPIND); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODUSU', $array[$i][0]);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':CODTIPIND', $array[$i][1]);
		$result=oci_execute($stmt);
		if (!$result) {
			$cont++;
		}
	}
	if ($cont==0) {
		$response->state=true;
	}else{
		$response->state=false;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>