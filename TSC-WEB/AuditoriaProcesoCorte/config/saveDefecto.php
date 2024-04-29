<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['desc'])) {
		$sql="select MAX(CODDEF) as MAXCOD from DEFECTO";
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		$row=oci_fetch_array($stmt,OCI_ASSOC);

		$sqlInsert="INSERT INTO Defecto VALUES (".($row['MAXCOD']+1).",'".$_POST['desc']."','".$_POST['descaux']."','A')";
		$stmt=oci_parse($conn, $sqlInsert);
		$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);

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