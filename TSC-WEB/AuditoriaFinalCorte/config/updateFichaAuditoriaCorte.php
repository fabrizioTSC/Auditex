<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

		$sql="EXEC AUDITEX.SP_AFC_UPDATE_FICAUDCOR ?, ?, ?, ?, ?, ?, ?;";
		$stmt=sqlsrv_prepare($conn, $sql, array(&$_POST['codfic'], &$_POST['numvez'], &$_POST['parte'], &$_POST['codtad'], &$_POST['codaql'], &$_POST['tipaud'], &$_POST['newnumero']));
		$result=sqlsrv_execute($stmt);		
		if($result){			
			$response->state=true;
			$response->description="Éxito";
		}else{
			$response->state=false;
			$error->code=2;
			$error->description="No se actualizó ficha.";
			$response->err=$error;
		}
	sqlsrv_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>