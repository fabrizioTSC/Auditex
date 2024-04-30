<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	
	// Asignar valores fijos
	$codfic = 11353;
	$numvez = 2;
	$parte = 1;
	$codtad = 30;
	$codaql = 1;
	$tipomuestra = 'aql';
	$nummuestra = 0;
	
	// Obtener información de partida
	$sql = "EXEC AUDITEX.SP_AFC_GET_INFOPARTIDA ?";
	$params = array($codfic);
	$stmt = sqlsrv_query($conn, $sql, $params);
	if ($stmt === false) {
		die(print_r(sqlsrv_errors(), true));
	}
	$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
	$partidaclass = new stdClass();
	$partidaclass->partida = $row['PARTIDA'];
	$partidaclass->tiptel = $row['ARTICULO'];
	$partidaclass->color = $row['COLOR'];
	$partidaclass->codtel = $row['CODTEL'];
	$partidaclass->descli = utf8_encode($row['DESCLI']);
	sqlsrv_free_stmt($stmt);
	
	// Obtener información adicional de partida
	$sql = "EXEC AUDITEX.SP_AFC_GET_INFOPARTIDA2 ?, ?";
	$params = array($partidaclass->partida, $partidaclass->codtel);
	$stmt = sqlsrv_query($conn, $sql, $params);
	if ($stmt === false) {
		die(print_r(sqlsrv_errors(), true));
	}
	$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
	$partidaclass->codprv = $row['CODPRV'];
	$partidaclass->numvez = $row['NUMVEZ'];
	$partidaclass->parte = $row['PARTE'];
	$partidaclass->codtad = $row['CODTAD'];
	sqlsrv_free_stmt($stmt);
	
	$response->partida = $partidaclass;
	
	// Obtener información de DESCEL
	$sql = "EXEC AUDITEX.SP_GEN_SELECT_NOMCEL ?";
	$params = array($codfic);
	$stmt = sqlsrv_query($conn, $sql, $params);
	if ($stmt === false) {
		die(print_r(sqlsrv_errors(), true));
	}
	$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
	$response->DESCEL = utf8_encode($row['DESTLL']);
	sqlsrv_free_stmt($stmt);
	
	// Obtener información de fichas
	$sql = "EXEC AUDITEX.SP_APCR_SELECT_FICHAXTALLER ?, ?, ?, ?, ?";
	$params = array($codfic, $numvez, $parte, $codtad, $codaql);
	$stmt = sqlsrv_query($conn, $sql, $params);
	if ($stmt === false) {
		die(print_r(sqlsrv_errors(), true));
	}
	$fichas = array();
	while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
		$ficha = new stdClass();
		$ficha->CANAUD = $row['CANAUD'];
		$ficha->CANPAR = $row['CANPAR'];
		$ficha->CANPRE = $row['CANPRE'];
		$ficha->CANDEFMAX = $row['CANDEFMAX'];
		$ficha->CODAQL = $row['CODAQL'];
		$ficha->AQL = $row['AQL'];
		$ficha->DESTLL = utf8_encode($row['DESTLL']);
		$ficha->PEDIDO = $row['PEDIDO'];
		$ficha->ESTTSC = $row['ESTTSC'];
		$ficha->ESTCLI = $row['ESTCLI'];
		$fichas[] = $ficha;
	}
	$response->fichas = $fichas;
	sqlsrv_free_stmt($stmt);
	
	if (empty($fichas)) {
		$response->state = false;
		$response->description = "No hay fichas para el taller";
	} else {
		// Obtener información de fichatallas
		$sql = "EXEC AUDITEX.SP_APCR_SELECT_FICHATALLAS ?";
		$params = array($codfic);
		$stmt = sqlsrv_query($conn, $sql, $params);
		if ($stmt === false) {
			die(print_r(sqlsrv_errors(), true));
		}
		$fichatallas = array();
		while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$fichatalla = (object)$row;
			$fichatallas[] = $fichatalla;
		}
		$response->fichatallas = $fichatallas;
		sqlsrv_free_stmt($stmt);
		
		// Obtener información de defectos
		$sql = "EXEC AUDITEX.SP_APCR_SELECT_DEFECTOS";
		$stmt = sqlsrv_query($conn, $sql);
		if ($stmt === false) {
			die(print_r(sqlsrv_errors(), true));
		}
		$defectos = array();
		while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$defecto = new stdClass();
			$defecto->coddef = $row['CODDEF'];
			$defecto->desdef = utf8_encode($row['DESDEF']);
			$defectos[] = $defecto;
		}
		$response->defectos = $defectos;
		sqlsrv_free_stmt($stmt);
		
		// Obtener información de defectos pasados
		$sql = "EXEC AUDITEX.SP_APCR_SELECT_DETDEF ?, ?, ?, ?";
		$params = array($codfic, $numvez, $parte, $codtad);
		$stmt = sqlsrv_query($conn, $sql, $params);
		if ($stmt === false) {
			die(print_r(sqlsrv_errors(), true));
		}
		$defectosPasados = array();
		while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$defectoPas = (object)$row;
			$defectosPasados[] = $defectoPas;
		}
		$response->defectosPasados = $defectosPasados;
		sqlsrv_free_stmt($stmt);
		
		// Obtener observaciones
		$sql = "EXEC AUDITEX.SP_AFC_SELECT_OBSFICCOR ?, ?, ?, ?";
		$params = array($codfic, $numvez, $parte, $codtad);
		$stmt = sqlsrv_query($conn, $sql, $params);
		if ($stmt === false) {
			die(print_r(sqlsrv_errors(), true));
		}
		$obs = array();
		while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$obj = new stdClass();
			$obj->SEC = $row['SEC'];
			$obj->OBS = utf8_encode($row['OBS']);
			$obs[] = $obj;
		}
		$response->obs = $obs;
		sqlsrv_free_stmt($stmt);
		
		$response->state = true;
	}


    /*  var_dump($response);   */
	  sqlsrv_close($conn);
	  header('Content-Type: application/json');   
	 echo json_encode($response); 
?>


