<?php
	include("connection.php");
	$response=new stdClass();
	
	if ($_POST['type']=="delete") {
		$sql="BEGIN SP_INSP_DELETE_DETINSCOSALL(:CODINSCOS); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt, ':CODINSCOS', $_POST['codinscos']);
		$result=oci_execute($stmt);

		if ($result==true) {
			$response->state=true;

			$sql="BEGIN SP_INSP_DELETE_INSCOS(:CODINSCOS); END;";
			$stmt=oci_parse($conn,$sql);
			oci_bind_by_name($stmt, ':CODINSCOS', $_POST['codinscos']);
			$result=oci_execute($stmt);
		}else{
			$response->state=false;
			$response->detail="No se pudo eliminar la inspección!";
		}
	}

	oci_close($conn);
	header("Content-Type:application/json");
	echo json_encode($response);
?>