<?php
    include("connection.php");
    $response = new stdClass();

    $tamdesmed = isset($_POST['tamdesmed']) ? $_POST['tamdesmed'] : ''; 

    $sql = "{CALL AUDITEX.SP_AFC_INFO_TAMDESMED(?)}"; 
    $params = array(
        array(&$tamdesmed, SQLSRV_PARAM_INOUT, null, SQLSRV_SQLTYPE_VARCHAR(40)) 
    );
    $stmt = sqlsrv_prepare($conn, $sql, $params);
    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true)); // Manejo de errores
    }

    $result = sqlsrv_execute($stmt);
    if (!$result) {
        die(print_r(sqlsrv_errors(), true)); // Manejo de errores
    }

    $response->tamdesmed = $tamdesmed;

    sqlsrv_close($conn);
    header('Content-Type: application/json');
    echo json_encode($response);
?>
