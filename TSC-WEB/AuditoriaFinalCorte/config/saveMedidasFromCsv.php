<?php
set_time_limit(480);
include('connection.php'); // Asegúrate de que esta conexión sea a una base de datos SQL Server
$response = new stdClass();
$array = json_decode($_POST['array']);

// Primer procedimiento almacenado
$sql = "{CALL AUDITEX.SP_AFC_INSERT_ESTTSCUNIMEDAUX(?, ?, ?)}";
$params = array(
    array(&$_POST['esttsc'], SQLSRV_PARAM_IN),
    array(&$_POST['medida'], SQLSRV_PARAM_IN),
    array(&$_POST['islarman'], SQLSRV_PARAM_IN)
);
$stmt = sqlsrv_prepare($conn, $sql, $params);
$result = sqlsrv_execute($stmt);

// Segundo procedimiento almacenado
$sql = "{CALL AUDITEX.SP_AFC_DELETE_ESTTSC_JV2(?, ?, ?, ?)}";
$hilo = intval($_POST['hilo']);
$travez = intval($_POST['travez']);
$largmanga = intval($_POST['largmanga']);
$params = array(
    array(&$_POST['esttsc'], SQLSRV_PARAM_IN),
    array(&$hilo, SQLSRV_PARAM_IN),
    array(&$travez, SQLSRV_PARAM_IN),
    array(&$largmanga, SQLSRV_PARAM_IN)
);
$stmt = sqlsrv_prepare($conn, $sql, $params);
$result = sqlsrv_execute($stmt);



if ($result) {
    $valida_pc = false;
    $initial_pos = 5;
    for ($i = 0; $i < count($array[0]); $i++) {
        if ($array[0][$i] == "P/C" || $array[0][$i] == "C/P") {
            $valida_pc = true;
            $initial_pos = 6;
        }
    }

    // Actualización del código para la selección de tallas
	$tallas = [];
	$i = 0;
	for ($j = $initial_pos; $j < count($array[0]); $j++) {
		$sql = "{CALL AUDITEX.SP_AFC_SELECT_TALLA(?)}";
		$destal = trim($array[0][$j]);
		$params = array(
			array(&$destal, SQLSRV_PARAM_IN)
		);
		$stmt = sqlsrv_prepare($conn, $sql, $params);
		sqlsrv_execute($stmt);

		// No necesitas sqlsrv_next_result ya que no estás utilizando un cursor
		while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$tallas[$i] = $row['CODTAL'];
			$i++;
		}
	}

    $response->tallas = $tallas;
    $auditable_cad = '';

    $w = 0;
    $m = 0;

    for ($i = 1; $i < count($array); $i++) {
        $paramsCommon = array(
            array(&$_POST['esttsc'], SQLSRV_PARAM_IN),
            array(&$i, SQLSRV_PARAM_IN)
        );
    
        if ($valida_pc) {
            // Seleccionar si es auditable
            $sql = "{CALL AUDITEX.SP_AFC_SELECT_AUDBYEC(?, ?, ?)}";
            $params = array_merge($paramsCommon, array(array(&$auditable, SQLSRV_PARAM_INOUT, null, SQLSRV_SQLTYPE_VARCHAR(40))));
            $stmt = sqlsrv_prepare($conn, $sql, $params);
            $result = sqlsrv_execute($stmt);
    
            // Insertar medidas
            $sql = "{CALL AUDITEX.SP_AFC_INSERT_ESTTSCMED_JV2(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
            $params = array_merge($paramsCommon, array(
                array(&$array[$i][1], SQLSRV_PARAM_IN),
                array(&$array[$i][0], SQLSRV_PARAM_IN),
                array(&$array[$i][4], SQLSRV_PARAM_IN),
                array(&$array[$i][5], SQLSRV_PARAM_IN),
                array(&$auditable, SQLSRV_PARAM_IN),
                array(&$array[$i][2], SQLSRV_PARAM_IN),
                array(&$hilo, SQLSRV_PARAM_IN),
                array(&$travez, SQLSRV_PARAM_IN),
                array(&$largmanga, SQLSRV_PARAM_IN)
            ));
        } else {
            // Seleccionar si es auditable
            $sql = "{CALL AUDITEX.SP_AFC_SELECT_AUDBYEC(?, ?, ?)}";
            $params = array_merge($paramsCommon, array(array(&$auditable, SQLSRV_PARAM_INOUT, null, SQLSRV_SQLTYPE_VARCHAR(40))));
            $stmt = sqlsrv_prepare($conn, $sql, $params);
            $result = sqlsrv_execute($stmt);
    
            // Insertar medidas
            $sql = "{CALL AUDITEX.SP_AFC_INSERT_ESTTSCMED_JV2(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
            $params = array_merge($paramsCommon, array(
                array(&$array[$i][1], SQLSRV_PARAM_IN),
                array(&$array[$i][0], SQLSRV_PARAM_IN),
                array(&$array[$i][3], SQLSRV_PARAM_IN),
                array(&$array[$i][4], SQLSRV_PARAM_IN),
                array(&$auditable, SQLSRV_PARAM_IN),
                array(&$parte, SQLSRV_PARAM_IN),
                array(&$hilo, SQLSRV_PARAM_IN),
                array(&$travez, SQLSRV_PARAM_IN),
                array(&$largmanga, SQLSRV_PARAM_IN)
            ));
        }
    
        $stmt = sqlsrv_prepare($conn, $sql, $params);
        $result = sqlsrv_execute($stmt);
        if (!$result) {
            $auditable_cad .= $i . ": " . $auditable . " - ";
        }
    
		// Para el procedimiento almacenado SP_GETIDTSCV2
		$sql = "{CALL AUDITEX.SP_GETIDTSCV2(?, ?, ?, ?)}";
		$params = array(
			array(&$_POST['esttsc'], SQLSRV_PARAM_IN),
			array(&$hilo, SQLSRV_PARAM_IN),
			array(&$travez, SQLSRV_PARAM_IN),
			array(&$largmanga, SQLSRV_PARAM_IN)
		);
		$stmt = sqlsrv_prepare($conn, $sql, $params);
		$result = sqlsrv_execute($stmt);
		$idregistrar = null;
		while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$idregistrar = $row["ID"];
			// Supongamos que solo esperamos un ID, podrías romper el ciclo después de la primera iteración si es el caso.
			break;
		}

    
        if ($result) {
            for ($k = $initial_pos; $k < count($array[$i]); $k++) {
                $sql = "{CALL AUDITEX.SP_AFC_INSERT_ESTTSCMEDDET_JV2(?, ?, ?, ?, ?, ?, ?, ?, ?)}";
                $params = array(
                    array(&$idregistrar, SQLSRV_PARAM_IN),
                   
                    array(&$_POST['esttsc'], SQLSRV_PARAM_IN),
                    array(&$i, SQLSRV_PARAM_IN),
                    array(&$hilo, SQLSRV_PARAM_IN),
                    array(&$travez, SQLSRV_PARAM_IN),
                    array(&$largmanga, SQLSRV_PARAM_IN),
                    array(&$tallas[$k - $initial_pos], SQLSRV_PARAM_IN),
                    array(&$array[$i][$k], SQLSRV_PARAM_IN),
                    array(&$estado, SQLSRV_PARAM_IN)
                );
                $stmt = sqlsrv_prepare($conn, $sql, $params);
                $result = sqlsrv_execute($stmt);
                if ($result) {
                    $w++;
                }
            }
            $m++;
        }
    }

    
    $response->insert1 = $m;
    $response->insert2 = $w;
    $response->state = true;
    $response->auditable_cad = $auditable_cad;
} else {
    $response->state = false;
    $response->detail = "No se pudo eliminar las medidas anteriores!";
}

sqlsrv_close($conn);
header('Content-Type: application/json');
echo json_encode($response);

?>
