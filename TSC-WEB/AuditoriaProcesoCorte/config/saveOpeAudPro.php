<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codfic'])) {
		$sql="SELECT * FROM AuditoriaProcesoOpe where codfic=".$_POST['codfic'].
		" and secuen=".$_POST['secuen']." and codper=".$_POST['codper']." and codope=".$_POST['codope'];

		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		$row=oci_fetch_array($stmt);
		if (oci_num_rows($stmt)==0) {
			$sql="INSERT INTO AuditoriaProcesoOpe values (".$_POST['codfic'].",".
			$_POST['secuen'].",".$_POST['codper'].",".$_POST['codope'].",5,0,'-')";
			$response->sql=$sql;		

			$stmt=oci_parse($conn, $sql);
			$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
			$response->state=true;

		}else{
			$response->state=false;
			$error->detail="Ya existe la operacion con el operador!";
			$response->error=$error;			
		}
	}else{
		$response->state=false;
		$error->code=1;
		$error->detail="No es un metodo POST.";
		$response->error=$error;
	}
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>