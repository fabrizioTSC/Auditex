<?php
    include('connection.php'); // Asegúrate de que este archivo establece una conexión con SQL Server
    $response = new stdClass();

    // Verificar si hay desorden
    $sql = "{CALL AUDITEX.SP_AFC_VAL_DESORDEN(?)}";
    $params = array(
        array(&$_POST['esttsc'], SQLSRV_PARAM_IN)
    );
    $stmt = sqlsrv_prepare($conn, $sql, $params);
    if (!sqlsrv_execute($stmt)) {
        die(print_r(sqlsrv_errors(), true));
    }
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $response->desorden = ($row) ? true : false;

    // Obtener el encabezado
    $head = '<tr>
        <th>COD.</th>
        <th>DESCRIPCIÓN</th>
        <th>P/C</th>
        <th>CRITICA</th>
        <th>MARGEN (1)</th>
        <th>MARGEN (2)</th>';
    $hc = 0;
    $params = array(
        array(&$_POST['esttsc'], SQLSRV_PARAM_IN),
        array(&$_POST['hilo'], SQLSRV_PARAM_IN),
        array(&$_POST['travez'], SQLSRV_PARAM_IN),
        array(&$_POST['largmanga'], SQLSRV_PARAM_IN)
    );
    $sql = "{CALL AUDITEX.SP_AFC_SELECT_ENCHEAD(?, ?, ?, ?)}";
    $stmt = sqlsrv_prepare($conn, $sql, $params);
    if (!sqlsrv_execute($stmt)) {
        die(print_r(sqlsrv_errors(), true));
    }
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $head .= '<th>'.htmlspecialchars($row['destal']).'</th>';
        $hc++;
    }
    $head .= '</tr>';

    // Obtener el cuerpo
    $body = '';
    $i = 0;
    $j = 0;
    $params = array(
        array(&$_POST['esttsc'], SQLSRV_PARAM_IN),
        array(&$_POST['hilo'], SQLSRV_PARAM_IN),
        array(&$_POST['travez'], SQLSRV_PARAM_IN),
        array(&$_POST['largmanga'], SQLSRV_PARAM_IN)
    );
    $sql = "{CALL AUDITEX.SP_AFC_SELECT_ENCBODY(?, ?, ?, ?)}";
    $stmt = sqlsrv_prepare($conn, $sql, $params);
    if (!sqlsrv_execute($stmt)) {
        die(print_r(sqlsrv_errors(), true));
    }
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        if ($i == 0) {
            if ($j != 0) {
                $body .= '</tr>';
            }
            $j++;
            $body .= '<tr>
                <td>'.htmlspecialchars($row['DESMEDCOR']).'</td>
                <td>'.htmlspecialchars($row['DESMED']).'</td>
                <td>'.htmlspecialchars($row['PARTE']).'</td>
                <td>'.htmlspecialchars($row['AUDITABLE']).'</td>
                <td>'.htmlspecialchars($row['TOLERANCIAMENOS']).'</td>
                <td>'.htmlspecialchars($row['TOLERANCIAMAS']).'</td>';
        }
        $body .= '<td>'.htmlspecialchars($row['MEDIDA']).'</td>';
        $i++;
        if ($i == $hc) {
            $i = 0;
        }
    }
    $body .= '</tr>'; // Cierra la última fila si es necesario

    if ($j > 0) { // Cambio de verificación para confirmar si hubo resultados
        $response->state = true;
        $response->body = $body;
        $response->head = $head;
    } else {
        $response->state = false;
        $response->detail = 'No hay encogimiento';
    }

    sqlsrv_close($conn);
    header('Content-Type: application/json');
    echo json_encode($response);
?>
