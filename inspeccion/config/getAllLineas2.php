<?php
	include('connection.php');
	
    $stmt=oci_parse($conn,"select * from LINEA_ETON");
    oci_execute($stmt);
    $resultado = array();

    while (($row = oci_fetch_object($stmt)) != false) {
        // Use nombres de atributo en mayúsculas para cada columna estándar de Oracle
        $clase = new stdClass();
        $clase->linea = $row->LINEA; 
        $resultado[] = $clase;
    }
    echo json_encode($resultado);
	oci_close($conn);
?>