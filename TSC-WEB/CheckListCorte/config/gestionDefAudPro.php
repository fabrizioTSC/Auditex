<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if ($_POST['action']=="delete") {
		if ($_POST['coddef'].""!="0") {
		
			$sql="DELETE FROM AuditoriaProcesoOpeDetalle WHERE CODFIC=".$_POST['codfic'].
			" and secuen=".$_POST['secuen']." and codope=".$_POST['codope']." and coddef=".$_POST['coddef']." and codper=".$_POST['codper'];
			
			$stmt=oci_parse($conn, $sql);
			$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
			if ($result) {
				$response->state=true;
			}else{
				$response->state=false;
				$response->detail="No se pudo eliminar el defecto";
			}
		}		

		$sql="UPDATE AuditoriaProcesoOpe set CANDEF=(CANDEF-".$_POST['candef'].") WHERE CODFIC=".$_POST['codfic'].
		" and secuen=".$_POST['secuen']." and codope=".$_POST['codope']." and codper=".$_POST['codper'];
		
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
	}else{
		
		if ($_POST['action']=="edit") {

			if ($_POST['coddef']!="0") {
				$sql="UPDATE AuditoriaProcesoOpeDetalle set CODPER=".$_POST['codper_new'].", CODOPE=".$_POST['codope_new'].
				", CODDEF=".$_POST['coddef_new'].", CANDEF=".$_POST['candef_new'].
				" WHERE CODFIC=".$_POST['codfic'].
				" and secuen=".$_POST['secuen']." and codope=".$_POST['codope']." and coddef=".$_POST['coddef']." and codper=".$_POST['codper'];
				
				$stmt=oci_parse($conn, $sql);
				$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
				if ($result) {
					$response->state=true;
				}else{
					$response->state=false;
					$response->detail="No se pudo actualizar el defecto";
				}
			}else{	
				$sql="INSERT INTO AuditoriaProcesoOpeDetalle values (".$_POST['codfic'].",".$_POST['secuen'].",".
				$_POST['codper_new'].",".$_POST['codope_new'].",".$_POST['coddef_new'].",".$_POST['candef_new'].")";
				
				$stmt=oci_parse($conn, $sql);
				$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
				if ($result) {
					$response->state=true;
				}else{
					$response->state=false;
					$response->detail="No se pudo agregar el defecto";
				}
			}


			$sql="UPDATE AuditoriaProcesoOpe set CANDEF=(CANDEF-".$_POST['candef']."+".$_POST['candef_new'].")".
			", CODPER=".$_POST['codper_new'].", CODOPE=".$_POST['codope_new'].
			" WHERE CODFIC=".$_POST['codfic'].
			" and secuen=".$_POST['secuen']." and codope=".$_POST['codope']." and codper=".$_POST['codper'];

			$stmt=oci_parse($conn, $sql);
			$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);	
		}
	}
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>