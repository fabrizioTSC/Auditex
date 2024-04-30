<?php
	include('connection.php');
	$response = new stdClass();

	$celula = [];
	$taller = new stdClass();
	$taller->CODTLL = "0";
	$taller->DESTLL = "NINGUNA";
	array_push($celula, $taller);

	$sql = "EXEC AUDITEX.SP_CLC_SELECT_CELULAS";

	$stmt = sqlsrv_prepare($conn, $sql);

	// Execute the statement
	$result = sqlsrv_execute($stmt);

	// Fetch the results
	while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
		$taller = new stdClass();
		$taller->CODTLL = $row['CODTLL'];
		$taller->DESTLL = utf8_encode($row['DESTLL']); 
		array_push($celula, $taller);
	}

	$response->state = true;
	$response->celula = $celula;

	sqlsrv_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);

?>