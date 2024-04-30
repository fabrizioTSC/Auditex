<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();


	$codfic = $_POST['codfic'];
	$numvez = $_POST['numvez'];
	$parte = $_POST['parte'];
	$codtad = $_POST['codtad'];
	$codaql = $_POST['codaql'];
	$codusu = $_POST['codusu'];
	$resultado = $_POST['resultado'];
	$defectos = $_POST['defectos'];


	$sql="EXEC AUDITEX.SP_APCR_UPDATE_FICHA3 ?, ?, ?, ?, ?, ?, ?, ?;";
	$stmt=sqlsrv_prepare($conn, $sql, array(&$codfic, &$numvez, &$parte, &$codtad, &$codaql, &$codusu, &$resultado, &$defectos));

	$result=sqlsrv_execute($stmt);
	if($result){				
		if ($_POST['resultado']=="R") {

			$codfic = $_POST['codfic'];
			$numvez = $_POST['numvez'];
			$parte = $_POST['parte'];
			$codtad = $_POST['codtad'];
			$codaql = $_POST['codaql'];

			$sql="EXEC AUDITEX.SP_APCR_INSERT_FICAUDCORREC ?, ?, ?, ?, ?;";
			$stmt=sqlsrv_prepare($conn, $sql, array(&$codfic, &$numvez, &$parte, &$codtad, &$codaql));

			$result=sqlsrv_execute($stmt);
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

	sqlsrv_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>