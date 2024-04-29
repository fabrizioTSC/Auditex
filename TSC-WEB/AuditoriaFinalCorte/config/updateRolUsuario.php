<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codusu'])) {
		$sql="update USUARIO set CODROL=".$_POST['codrol'].
		" where CODUSU=".$_POST['codusu'];
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
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