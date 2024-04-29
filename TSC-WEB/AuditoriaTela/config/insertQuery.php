<?php
	include("connection.php");
	$response=new stdClass();

	$codinscos="0";
	$sql="BEGIN SP_AUDITEL_INS_PARTELTXT (:QUERY,:CODERR,:MSGERR); END;";	
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt,':QUERY', $_POST['query']);
	oci_bind_by_name($stmt,':CODERR', $coderr,40);
	oci_bind_by_name($stmt,':MSGERR', $msgerr,10000);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->detail="Error ".$coderr.". ".utf8_encode($msgerr);
	}else{
		$response->state=false;
		$response->detail="No se pudo ejecutar la consulta!";
	}

	oci_close($conn);
	header("Content-Type:application/json");
	echo json_encode($response);
?>