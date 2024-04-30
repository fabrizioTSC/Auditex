<?php
	include('connection.php'); // Asegúrate de que este archivo use detalles de conexión de SQL Server
	$response = new stdClass();
	
	// Inicialización de la lista de ESTTSC con el valor de "Todos"
	$esttsc = array();
	$obj = new stdClass();
	$obj->ESTTSC = "0"; // Asumiendo que "0" puede representar "Todos"
	$obj->DESESTTSC = "(TODOS)";
	$esttsc[] = $obj; // Agregando el objeto "Todos" al inicio del arreglo
	
	// Llamando al primer procedimiento almacenado SP_AFC_SELECT_ESTTSCREP
	$sql = "EXEC AUDITEX.SP_AFC_SELECT_ESTTSCREP;";
	$stmt = sqlsrv_query($conn, $sql);
	if ($stmt === false) {
		die(print_r(sqlsrv_errors(), true));
	}
	while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
		$obj = new stdClass();
		$obj->ESTTSC = $row['esttsc']; // Asumiendo que 'esttsc' es el nombre correcto de la columna en SQL Server
		$obj->DESESTTSC = $row['esttsc']; // Modifica aquí si el nombre de la columna difiere
		$esttsc[] = $obj;
	}
	
	$response->state = true;
	$response->esttsc = $esttsc;
	
	// Inicialización de la lista de usuarios con el valor de "Todos"
	$usuarios = array();
	$obj = new stdClass();
	$obj->CODUSU = "0"; // Asumiendo que "0" puede representar "Todos"
	$obj->DESUSU = "(TODOS)"; // Asumiendo que 'DESUSU' es el campo para el nombre descriptivo del usuario
	$usuarios[] = $obj; // Agregando el objeto "Todos" al inicio del arreglo
	
	// Llamando al segundo procedimiento almacenado SP_AT_SELECT_USUARIOS
	$sql = "EXEC AUDITEX.SP_AT_SELECT_USUARIOS;";
	$stmt = sqlsrv_query($conn, $sql);
	if ($stmt === false) {
		die(print_r(sqlsrv_errors(), true));
	}
	while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
		$obj = new stdClass();
		$obj->CODUSU = $row['CODUSU'];
		$obj->NOMUSU = $row['NOMUSU'];
		$obj->ALIUSU = $row['ALIUSU'];
		$obj->EMAILUSU = $row['EMAILUSU'];  // Será null si no hay correo electrónico
		$obj->DNIUSU = $row['DNIUSU'];
		$obj->ESTADO = $row['ESTADO'];
		$obj->PASSWORDUSU = $row['PASSWORDUSU'];
		$obj->CODROL = $row['CODROL'];
		$obj->DESUSU = $row['NOMUSU']; // Aquí se asigna 'NOMUSU' a 'DESUSU'
		$usuarios[] = $obj;
	}
	
	$response->state = true;
	$response->usuario = $usuarios;
	
	sqlsrv_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
	
?>
