<?php
	set_time_limit(240);
	include('connection.php');

	$response = new stdClass();
	$array = $_POST['array'];
	$con_err = 0;

	for ($i=0; $i < count($array); $i++) { 
		$sql = "EXEC AUDITEX.SP_CLC_INSERT_CHEBLO2 ?, ?, ?, ?, ?, ?, ?";
		$stmt = sqlsrv_prepare($conn, $sql, array(
			$_POST['codfic'], 
			$_POST['codtad'], 
			$_POST['numvez'], 
			$_POST['parte'], 
			$array[$i][0],
			$array[$i][1], 
			$array[$i][2]
		));
		$result = sqlsrv_execute($stmt);
		if ($result === false) {
			$con_err++;
		}
	}

	$sql = "EXEC AUDITEX.SP_CLC_UPDATE_CHEBLO2END ?, ?, ?, ?, ?, ?";
	$stmt = sqlsrv_prepare($conn, $sql, array(
		$_POST['codfic'], 
		$_POST['codtad'], 
		$_POST['numvez'], 
		$_POST['parte'], 
		$_POST['obs'], 
		$_POST['resultado']
	));
	$result = sqlsrv_execute($stmt);
	if ($result) {
		$response->state = true;

		$chkblosave2 = array();
		$sql = "EXEC AUDITEX.SP_CLC_SELECT_CHETIZGUA ?, ?, ?, ?";
		$stmt = sqlsrv_prepare($conn, $sql, array(
			$_POST['codfic'], 
			$_POST['codtad'], 
			$_POST['numvez'], 
			$_POST['parte']
		));
		$result = sqlsrv_execute($stmt);
		
		if ($result) {
			$chkblosave2 = array();
			while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
				$obj = new stdClass();
				$obj->CODTIZ = $row['CODTIZ'];
				$obj->RESTIZ = $row['RESTIZ'];
				$obj->VECES = $row['VECES'];
				$chkblosave2[] = $obj;
			}
		} else {
			$response->state = false;
			$response->detail = "No se pudo recuperar la información de la tabla resultante";
		}

		$response->chkblosave2 = $chkblosave2;
	} else {
		$response->state = false;
		$response->detail = "No se pudo guardar la validación";
	}

	sqlsrv_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>