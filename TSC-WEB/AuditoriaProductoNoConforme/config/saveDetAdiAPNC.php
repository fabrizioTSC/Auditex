<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_APNC_UPDATE_DETADIFICHA(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CANMUE,:CANRECUP); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
	oci_bind_by_name($stmt,':CANMUE',$_POST['canmue']);
	oci_bind_by_name($stmt,':CANRECUP',$_POST['canrecup']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->detail="Registro guardado";
	}else{
		$response->state=false;
		$response->detail="No se pudo guardar los datos";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>