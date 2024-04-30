<?php
    set_time_limit(240);
    include('connection.php');
    $response = new stdClass();
    $array = $_POST['array'];
    $con_err = 0;
    
    for ($i = 0; $i < count($array); $i++) {
        $sql = "EXEC AUDITEX.SP_CLC_INSERT_CHEBLO1 ?, ?, ?, ?, ?, ?, ?";
        $params = array(
            $_POST['codfic'],
            $_POST['codtad'],
            $_POST['numvez'],
            $_POST['parte'],
            $array[$i][0],
            $array[$i][1],
            floatval($array[$i][2]) * 100
        );

        // Using var_dump to show the parameters
        //var_dump($params);

        $stmt = sqlsrv_prepare($conn, $sql, $params);
        $result = sqlsrv_execute($stmt);
        if ($result === false) {
            $con_err++;
        }
    }

    $sql = "EXEC AUDITEX.SP_CLC_UPDATE_CHEBLO1END ?, ?, ?, ?, ?, ?";
    $stmt = sqlsrv_prepare($conn, $sql, array(
        $_POST['codfic'],
        $_POST['codtad'],
        $_POST['numvez'],
        $_POST['parte'],
        $_POST['obs'],
        $_POST['resultado']
    ));
    $result = sqlsrv_execute($stmt);
    if ($result !== false) {
        $response->state = true;
    } else {
        $response->state = false;
        $response->detail = "No se pudo guardar la validacion!";
    }

    sqlsrv_close($conn);
    header('Content-Type: application/json');
    echo json_encode($response);
?>
