<?php
	include('connection.php');
	$response=new stdClass();

	$sql="begin SP_CLC_UPDATE_TLLXFIC(:CODFIC,:CODENV,:CODTLL,:CODCEL); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt,':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt,':CODENV', $_POST['codenv']);
	oci_bind_by_name($stmt,':CODTLL', $_POST['codtll']);
	oci_bind_by_name($stmt,':CODCEL', $_POST['codcel']);
	$result=oci_execute($stmt);
	if($result){
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo actualizar la ficha";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>