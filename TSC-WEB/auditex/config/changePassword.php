<?php
	session_start();
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['pass'])) {
		$sql="BEGIN SP_AT_UPDATE_PASSWORD(:CODUSU,:PASS); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':CODUSU',$_POST['codusu']);
		oci_bind_by_name($stmt,':PASS',$_POST['pass']);
		$result=oci_execute($stmt);
		if($result){			
			$response->state=true;
			$response->description="Cambio exitoso!";
		}else{
			$response->state=false;
			$error->code=2;
			$error->description="No se cambio la contraseña!";
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