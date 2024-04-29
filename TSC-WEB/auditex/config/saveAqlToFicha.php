<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codfic'])) {
		$sql="BEGIN SP_AT_UPDATE_AQLTIPAUDFICHA(:CODFIC,:NUMVEZ,:PARTE,:CODAQL,:CODTAD,:NEWAQL); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		oci_bind_by_name($stmt, ':CODAQL', $_POST['codaql']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NEWAQL', $_POST['newaql']);
		$result=oci_execute($stmt);

		if ($result) {
			$response->state=true;
			$error->description="Ficha modificada!";
		}else{
			$response->state=false;
			$error->code=3;
			$error->description="No se pudo modificar ficha!";
			$response->error=$error;			
		}
	}else{
		$response->state=false;
		$error->code=1;
		$error->description="No es un metodo POST.";
		$response->error=$error;
	}
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>