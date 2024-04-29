<?php
	session_start();
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['pass'])) {
		$sql="update USUARIO set PASSWORDUSU='".$_POST['pass']."'".
		" where CODUSU=".$_POST['codusu'];
		$stmt=oci_parse($conn,$sql);
		$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
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