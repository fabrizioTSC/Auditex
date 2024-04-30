<?php
    include('connection.php'); // Asegúrate de que este archivo establece una conexión con SQL Server
    $response = new stdClass();

    $table = '';
    $params = array(
        array(&$_POST['esttsc'], SQLSRV_PARAM_IN)
    );

    $sql = "{CALL AUDITEX.SP_AFC_SELECT_ENCOGIMIENTO(?)}";
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if (!sqlsrv_execute($stmt)) {
        die(print_r(sqlsrv_errors(), true));
    }

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $obj = new stdClass(); // Si necesitas hacer algo con este objeto, aquí sería
        $hilo = str_replace(",", ".", $row['hilo']);
        $travez = str_replace(",", ".", $row['travez']);
        $largmanga = str_replace(",", ".", $row['LARGMANGA']);
        
        $table .= "<tr onclick=\"show_medidas('$hilo','$travez','$largmanga')\">
            <td>$hilo</td>
            <td>$travez</td>
            <td>$largmanga</td>
        </tr>";
    }

    if (sqlsrv_has_rows($stmt)) {
        $response->state = true;
        $response->detail = $table;
    } else {
        $response->state = false;
        $response->detail = 'No hay encogimientos';
    }

    sqlsrv_close($conn);
    header('Content-Type: application/json');
    echo json_encode($response);
?>
