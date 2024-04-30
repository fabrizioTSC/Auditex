<?php
	include('connection.php');

	$response = new stdClass();
	$error = new stdClass();

	$sql = "EXEC AUDITEX.SP_AFC_UPDATE_FICAUDCOR3 ?, ?, ?, ?, ?, ?, ?, ?";
	$params = array(
		$_POST['codfic'], 
		$_POST['numvez'], 
		$_POST['parte'], 
		$_POST['codtad'], 
		$_POST['codaql'], 
		$_POST['codusu'], 
		$_POST['resultado'], 
		$_POST['defectos']
	);
	$stmt = sqlsrv_query($conn, $sql, $params);

	if ($stmt) {				
		if ($_POST['resultado'] == "R") {
			$sql = "EXEC AUDITEX.SP_AFC_INSERT_FICAUDCORREC ?, ?, ?, ?, ?";
			$params = array(
				$_POST['codfic'], 
				$_POST['numvez'], 
				$_POST['parte'], 
				$_POST['codtad'], 
				$_POST['codaql']
			);
			$stmt = sqlsrv_query($conn, $sql, $params);

			if ($stmt) {
				$response->state = true;
				$response->description = "Éxito";
			} else {
				$response->state = false;
				$error->description = "No se guardó la nueva parte de la ficha!";
				$response->error = $error;
			}
		} else {
			$response->state = true;
			$response->description = "Éxito";
		}
	} else {
		$response->state = false;
		$error->code = 2;
		$error->description = "No se actualizó la ficha.";
		$response->error = $error;
	}

	sqlsrv_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);

/*	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

	$sql="BEGIN SP_AFC_UPDATE_FICAUDCOR3(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL,:CODUSU,:RESULTADO,:CANDEF); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
	oci_bind_by_name($stmt,':CODAQL',$_POST['codaql']);
	oci_bind_by_name($stmt,':CODUSU',$_POST['codusu']);
	oci_bind_by_name($stmt,':RESULTADO',$_POST['resultado']);
	oci_bind_by_name($stmt,':CANDEF',$_POST['defectos']);
	$result=oci_execute($stmt);
	if($result){				
		if ($_POST['resultado']=="R") {
			$sql="BEGIN SP_AFC_INSERT_FICAUDCORREC(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
			oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
			oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
			oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
			oci_bind_by_name($stmt,':CODAQL',$_POST['codaql']);
			$result=oci_execute($stmt);
			if ($result) {
				$response->state=true;
				$response->description="Éxito";
			}else{
				$response->state=false;
				$error->description="No se guardó la nueva parte de la ficha!";
				$response->error=$error;
			}
		}else{
			$response->state=true;
			$response->description="Éxito";
		}
	}else{
		$response->state=false;
		$error->code=2;
		$error->description="No se actualizó la ficha.";
		$response->error=$error;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response); */
?>