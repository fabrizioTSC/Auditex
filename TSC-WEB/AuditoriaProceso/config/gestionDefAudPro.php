<?php
	include('connection.php');
	$response=new stdClass();

	if ($_POST['action']=="delete") {
		$sql="BEGIN SP_APC_DELETE_AUDPROOPEDET(:CODFIC,:SECUEN,:CODPER,:CODOPE,:CODDEF,:CANDEF); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':SECUEN', $_POST['secuen']);
		oci_bind_by_name($stmt, ':CODPER', $_POST['codper']);
		oci_bind_by_name($stmt, ':CODOPE', $_POST['codope']);
		oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
		oci_bind_by_name($stmt, ':CANDEF', $_POST['candef']);
		$result=oci_execute($stmt);
		if($result)	{
			$response->state=true;
		}else{
			$response->state=false;
			$response->detail="Hubo un error. Actualice la ventana por favor!";
		}
	}elseif ($_POST['action']=="edit") {
		$sql="BEGIN SP_APC_UPDATE_AUDPROOPEDET2(:CODFIC,:SECUEN,:CODPER,:CODOPE,:CODDEF,:CANDEF,:NEWCODPER,:NEWCODOPE,:NEWCODDEF,:NEWCANDEF); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':SECUEN', $_POST['secuen']);
		oci_bind_by_name($stmt, ':CODPER', $_POST['codper']);
		oci_bind_by_name($stmt, ':CODOPE', $_POST['codope']);
		oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
		oci_bind_by_name($stmt, ':CANDEF', $_POST['candef']);
		oci_bind_by_name($stmt, ':NEWCODPER', $_POST['codper_new']);
		oci_bind_by_name($stmt, ':NEWCODOPE', $_POST['codope_new']);
		oci_bind_by_name($stmt, ':NEWCODDEF', $_POST['coddef_new']);
		oci_bind_by_name($stmt, ':NEWCANDEF', $_POST['candef_new']);
		$result=oci_execute($stmt);
		if($result)	{
			$response->state=true;
		}else{
			$response->state=false;
			$response->detail="Hubo un error. Actualice la ventana por favor!";
		}
	}
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>