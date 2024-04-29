<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codusu'])) {
		$sql="BEGIN SP_AT_UPDATE_ROLUSUARIO(:CODUSU,:CODROL); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
		oci_bind_by_name($stmt, ':CODROL', $_POST['codrol']);
		$result=oci_execute($stmt);
		if($result){			
			$response->state=true;
			$response->description="Exito!";
		}else{
			$response->state=false;
			$error->code=2;
			$error->description="No se actualizo el rol del usuari!.";
			$response->error=$error;
		}		
	}else{
		$response->state=false;
		$error->code=1;
		$error->description="No es un metodo POST.";
		$response->err=$error;
	}
	header('Content-Type: application/json');
	echo json_encode($response);
?>