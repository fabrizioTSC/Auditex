<?php
    include('connection.php');
    $response = new stdClass();

    $sql = "EXEC AUDITEX.SP_CLC_SELECT_TLLXFIC ?";
    $stmt = sqlsrv_prepare($conn, $sql, array($_POST['codfic']));
    $result = sqlsrv_execute($stmt);

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $response->CODTLL = $row['CODTLL'];
    $response->DESTLL = utf8_encode($row['DESTLL']);

    $sql = "EXEC AUDITEX.SP_GEN_SELECT_NOMCEL ?";
    $stmt = sqlsrv_prepare($conn, $sql, array($_POST['codfic']));
    $result = sqlsrv_execute($stmt);

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $response->CODCEL = $row['CODTLL'];
    $response->DESCEL = utf8_encode($row['DESTLL']);
    $response->state = true;

    sqlsrv_close($conn);
    header('Content-Type: application/json');
    echo json_encode($response);
	
?>