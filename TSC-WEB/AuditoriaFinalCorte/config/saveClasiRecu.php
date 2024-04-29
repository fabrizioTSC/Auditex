<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codfic'])) {

		$sql="select * from fichaauditoriarecuperacion where codfic=".$_POST['codfic'].
		" and codtad=".$_POST['codtad']." and parte=".$_POST['parte']." and numvez=".$_POST['numvez'];
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		$row=oci_fetch_array($stmt);
		$isNew=false;

		if (oci_num_rows($stmt)==0) {
			$sql="INSERT INTO fichaauditoriarecuperacion values (".$_POST['codfic'].",".
			$_POST['codtad'].",".$_POST['numvez'].",".$_POST['parte'].",".$_POST['canpre'].",'".$_POST['codusu']."',SYSDATE)";
			$stmt=oci_parse($conn, $sql);
			$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
			$isNew=true;
		}else{
			$sql="UPDATE fichaauditoriarecuperacion set canpre=".$_POST['canpre'].",codusu='".$_POST['codusu']."',fecreg=SYSDATE".
			" WHERE codfic=".$_POST['codfic']." and codtad=".$_POST['codtad']." and numvez=".$_POST['numvez'].
			" and parte=".$_POST['parte'];
			$stmt=oci_parse($conn, $sql);
			$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
		}
		if ($isNew) {
			$array=$_POST['array'];
			for ($i=0; $i < count($array); $i++) { 
				$sql="INSERT INTO FICHAAUDITORIARECUPERACIONDET values (".$_POST['codfic'].",".
				$_POST['codtad'].",".$_POST['numvez'].",".$_POST['parte'].",".$array[$i][0].",".$array[$i][1].")";
				$stmt=oci_parse($conn, $sql);
				$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);				
			}
		}else{
			$array=$_POST['array'];
			for ($i=0; $i < count($array); $i++) { 
				$sql="select * from FICHAAUDITORIARECUPERACIONDET where codfic=".$_POST['codfic'].
				" and codtad=".$_POST['codtad']." and parte=".$_POST['parte']." and numvez=".$_POST['numvez']." and codclarec=".$array[$i][0];
				$stmt=oci_parse($conn, $sql);
				$result=oci_execute($stmt);
				$row=oci_fetch_array($stmt);

				if (oci_num_rows($stmt)==0) {
					$sql="INSERT INTO FICHAAUDITORIARECUPERACIONDET values (".$_POST['codfic'].",".
					$_POST['codtad'].",".$_POST['numvez'].",".$_POST['parte'].",".$array[$i][0].",".$array[$i][1].")";
					$stmt=oci_parse($conn, $sql);
					$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);				
				}else{
					$sql="UPDATE FICHAAUDITORIARECUPERACIONDET set canpre=".$array[$i][1].
					" WHERE codfic=".$_POST['codfic']." and codtad=".$_POST['codtad']." and numvez=".$_POST['numvez'].
					" and parte=".$_POST['parte']." and codclarec=".$array[$i][0];
					$stmt=oci_parse($conn, $sql);
					$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
				}
			}			
		}
		$response->state=true;
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