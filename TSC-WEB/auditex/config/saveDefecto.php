<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['desc'])) {
		$sqlDefectos="BEGIN SP_AT_INSERT_DEFECTO(:CODDEFAUX,:DESDEF); END;";
		$stmt=oci_parse($conn, $sqlDefectos);		
		oci_bind_by_name($stmt, ':CODDEFAUX', $_POST['descaux']);
		oci_bind_by_name($stmt, ':DESDEF', $_POST['desc']);
		$result=oci_execute($stmt);

		if ($result) {
			$response->state=true;
			$response->description="Defecto agregado!";			
		}else{
			$response->state=false;
			$error->code=3;
			$error->description="No se pudo agregar el defecto!";
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