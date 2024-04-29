<?php
	include("connection.php");
	$response=new stdClass();
	$error=new stdClass();

	$stmt = oci_parse($conn,'BEGIN SP_INSP_INSERT_ESTOPEALL(:ESTTSC); END;');
	oci_bind_by_name($stmt,':ESTTSC',$_POST['esttsc']);
	$result=oci_execute($stmt); 

	if ($result) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo guardar los estilos!";
	}

	oci_close($conn);
	header("Content-Type:application/json");
	echo json_encode($response);
?>