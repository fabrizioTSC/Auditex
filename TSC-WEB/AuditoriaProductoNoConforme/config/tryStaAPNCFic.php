<?php
	include('connection.php');
	$response=new stdClass();
	session_start();
		
	$sql="BEGIN SP_APNC_SELECT_FICHADETALLE(:CODFIC,:CODENV,:CANTIDAD,:CANAUDTER); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':CODENV',$codenv,40);
	oci_bind_by_name($stmt,':CANTIDAD',$cantidad,40);
	oci_bind_by_name($stmt,':CANAUDTER',$canaudter,40);
	$result=oci_execute($stmt);
	if ($codenv!=0) {
		$sql="BEGIN SP_APNC_INSERT_FICHA2(:CODFIC,:FICHAAUTO,:CODENV,:CODUSU,:CANTIDAD,:CANAUDTER); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
		oci_bind_by_name($stmt,':FICHAAUTO',$_POST['fichaauto']);
		oci_bind_by_name($stmt,':CODENV',$codenv);
		oci_bind_by_name($stmt,':CODUSU',$_SESSION['user']);
		oci_bind_by_name($stmt,':CANTIDAD',$cantidad);
		oci_bind_by_name($stmt,':CANAUDTER',$canaudter);
		$result=oci_execute($stmt);
		if ($result) {
			$response->state=true;
		}else{
			$response->state=false;
			$response->detail="No se pudo iniciar la ficha";
		}
	}else{
		$response->state=false;
		$response->detail="La ficha no tiene datos";
	}
		

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>