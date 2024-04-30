<?php
	include('connection.php');
	$response = new stdClass();

	$talleres = [];
	$i = 0;

	$sql = "EXEC AUDITEX.SP_CLC_SELECT_TALLERES";

	$stmt = sqlsrv_prepare($conn, $sql);

	$result = sqlsrv_execute($stmt);
	while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
		$taller = new stdClass();
		$taller->CODTLL = $row['CODTLL'];
		$taller->DESTLL = utf8_encode($row['DESTLL']); // Assuming DESTLL is stored as UTF-8
		$taller->DESCOM = utf8_encode($row['DESCOM']); // Assuming DESCOM is stored as UTF-8
		$taller->CODTIPSER = $row['CODTIPSER'];
		$talleres[$i] = $taller;
		$i++;
	}

	$response->state = true;
	$response->talleres = $talleres;

	sqlsrv_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>