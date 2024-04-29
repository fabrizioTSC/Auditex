<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codfic'])) {

		$sql="UPDATE AuditoriaProcesoOpe SET CANDEF=CANDEF+".$_POST['candef'].
		" where codfic=".$_POST['codfic'].
		" and secuen=".$_POST['secuen']." and codper=".$_POST['codper']." and codope=".$_POST['codope'];
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
		if ($result) {
		
			$sql="SELECT * FROM AuditoriaProcesoOpeDetalle where codfic=".$_POST['codfic'].
			" and secuen=".$_POST['secuen']." and codper=".$_POST['codper']." and codope=".$_POST['codope']." and coddef=".$_POST['coddef'];

			$stmt=oci_parse($conn, $sql);
			$result=oci_execute($stmt);
			$row=oci_fetch_array($stmt);
			if (oci_num_rows($stmt)==0) {
				$sql="INSERT INTO AuditoriaProcesoOpeDetalle values (".$_POST['codfic'].",".
				$_POST['secuen'].",".$_POST['codper'].",".$_POST['codope'].",".$_POST['coddef'].",".$_POST['candef'].")";
				$response->sql=$sql;		

				$stmt=oci_parse($conn, $sql);
				$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
				$response->state=true;
				$response->detail="Guardado!";
			}else{
				$sql="update AuditoriaProcesoOpeDetalle set candef=".($_POST['candef']+$row['CANDEF']).
				" WHERE codfic=".$_POST['codfic']." and secuen=".$_POST['secuen']." and codper=".$_POST['codper'].
				" and codope=".$_POST['codope']." and coddef=".$_POST['coddef'];
				$response->sql=$sql;		

				$stmt=oci_parse($conn, $sql);
				$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
				$response->state=true;
				$response->detail="Actualizado!";
			}
		}else{
			$response->state=false;
			$response->detail="No se pudo agregar el defecto!";
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