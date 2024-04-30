<?php
	include('connection.php');
	$response=new stdClass();

	$sql = "EXEC AUDITEX.SP_CLC_UPDATE_USUFIC ?, ?, ?, ?, ?";
	$stmt = sqlsrv_prepare($conn, $sql, array(
		&$_POST['codfic'],
		&$_POST['codtad'],
		&$_POST['numvez'],
		&$_POST['parte'],
		&$_POST['codusu']
	));
	$result = sqlsrv_execute($stmt);
	$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
	$verificar = intval($row['VERIFICAR']);
	$response->verificar=$verificar;
	if ($verificar==0) {
		$response->state=false;
		$response->detail="La ficha fue tomada por otro auditor!";
	}else{
		$partida=new stdClass();

		$sql = "EXEC AUDITEX.SP_GEN_SELECT_NOMCEL ?";
		$stmt = sqlsrv_prepare($conn, $sql, array(&$_POST['codfic']));
		$result = sqlsrv_execute($stmt);
		$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
		$partida->DESCEL = utf8_encode($row['DESTLL']);

		$sql = "EXEC AUDITEX.SP_CLC_SELECT_INFFIC ?, ?, ?, ?";
		$stmt = sqlsrv_prepare($conn, $sql, array(
			&$_POST['codfic'],
			&$_POST['codtad'],
			&$_POST['numvez'],
			&$_POST['parte']
		));
		$result = sqlsrv_execute($stmt);
		$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
		$partida->DESTLL = utf8_encode($row['DESTLL']);
		$partida->PEDIDO = $row['PEDIDO'];
		$partida->ESTTSC = $row['ESTTSC'];
		$partida->ESTCLI = $row['ESTCLI'];
		$partida->DESCLI = utf8_encode($row['DESCLI']);
		$partida->CANPAR = $row['CANPAR'];
		$partida->OBSDOC = utf8_encode($row['OBSDOC']);
		$partida->OBSTIZ = utf8_encode($row['OBSTIZ']);
		$partida->OBSTEN = utf8_encode($row['OBSTEN']);
		$partida->RESDOC = $row['RESDOC'];
		$partida->RESTIZ = $row['RESTIZ'];
		$partida->RESTEN = $row['RESTEN'];
	
		$response->state = true;
		$response->partida = $partida;
		$maxform = 1;
		if ($partida->RESDOC=="A") {
			$maxform=2;
			if ($partida->RESTIZ=="A") {
				$maxform=3;
			}
		}

		$tela = new stdClass();
		$sql = "EXEC AUDITEX.SP_CLC_SELECT_PARTIDACLC ?, ?";
		$stmt = sqlsrv_prepare($conn, $sql, array(&$_POST['codfic'], &$_POST['partida']));
		$result = sqlsrv_execute($stmt);
		$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
		$tela->CODTEL = $row['CODTEL'] !== null ? $row['CODTEL'] : $row['CODTEL_1'];
	
		$tela->COLOR = $row['COLOR'];
		$tela->ARTICULO = utf8_encode($row['ARTICULO']);
		$response->tela = $tela;
		$link = new stdClass();
		$sql = "EXEC AUDITEX.SP_CLC_GET_INFOPARTIDA ?, ?";

		$params = array(
			array($_POST['partida'], SQLSRV_PARAM_IN),
			array($tela->CODTEL, SQLSRV_PARAM_IN)
		);
		$stmt = sqlsrv_query($conn, $sql, $params);

		if ($stmt === false) {
			die(print_r(sqlsrv_errors(), true));
		}

		$link = new stdClass();
		while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$link->CODPRV = $row['CODPRV'];
			$link->NUMVEZ = $row['NUMVEZ'];
			$link->PARTE = $row['PARTE'];
			$link->CODTAD = $row['CODTAD'];
		}

		$response->link = $link;


		$rutatela = [];
		$i = 0;
		$sql = "EXEC AUDITEX.SP_CLC_GET_DETRUTA ?";
		$stmt = sqlsrv_prepare($conn, $sql, array(&$_POST['codfic']));
		$result = sqlsrv_execute($stmt);
		while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$obj = new stdClass();
			$obj->CODETAPA = $row['CODETAPA'];
			$obj->ETAPA = utf8_encode($row['ETAPA']);
			$rutatela[$i] = $obj;
			$i++;
		}
		$response->rutatela = $rutatela;

		$chkblo1 = [];
		$i = 0;
		$sql = "EXEC AUDITEX.SP_CLC_SELECT_CHKBLO1";
		$stmt = sqlsrv_prepare($conn, $sql);
		$result = sqlsrv_execute($stmt);
		while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$obj = new stdClass();
			$obj->CODDOC = $row['CODDOC'];
			$obj->DESDOC = utf8_encode($row['DESDOC']);
			$obj->VALIDAR = $row['VALIDAR'];
			$obj->EDITABLE = $row['EDITABLE'];
			$obj->REPOSO = $row['REPOSO'];
			$chkblo1[$i] = $obj;
			$i++;
		}
		$response->chkblo1 = $chkblo1;

		$chkblosave = [];
		$i = 0;
		$sql = "EXEC AUDITEX.SP_CLC_SELECT_CHEDOCGUA ?, ?, ?, ?";
		$stmt = sqlsrv_prepare($conn, $sql, array(
			&$_POST['codfic'],
			&$_POST['codtad'],
			&$_POST['numvez'],
			&$_POST['parte']
		));

		$result = sqlsrv_execute($stmt);
		while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$obj = new stdClass();
			$obj->CODDOC = $row['CODDOC'];
			$obj->RESDOC = $row['RESDOC'];
			$obj->REPOSO = str_replace(",", ".", $row['REPOSO']);
			$chkblosave[$i] = $obj;
			$i++;
		}
		$response->chkblosave = $chkblosave;

		$chkblo2 = [];
		$i = 0;
		$sql = "EXEC AUDITEX.SP_CLC_SELECT_CHKBLO2";
		$stmt = sqlsrv_prepare($conn, $sql);
		$result = sqlsrv_execute($stmt);
		while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$obj = new stdClass();
			$obj->CODTIZ = $row['CODTIZ'];
			$obj->DESTIZ = utf8_encode($row['DESTIZ']);
			$obj->VALIDAR = $row['VALIDAR'];
			$obj->EDITABLE = $row['EDITABLE'];
			$chkblo2[$i] = $obj;
			$i++;
		}
		$response->chkblo2 = $chkblo2;

		$chkblosave2 = [];
		$i = 0;
		$sql = "EXEC AUDITEX.SP_CLC_SELECT_CHETIZGUA ?, ?, ?, ?";
		$stmt = sqlsrv_prepare($conn, $sql, array(
			&$_POST['codfic'],
			&$_POST['codtad'],
			&$_POST['numvez'],
			&$_POST['parte']
		));
		$result = sqlsrv_execute($stmt);
		while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$obj = new stdClass();
			$obj->CODTIZ = $row['CODTIZ'];
			$obj->RESTIZ = $row['RESTIZ'];
			$obj->VECES = $row['VECES'];
			$chkblosave2[$i] = $obj;
			$i++;
		}
		$response->chkblosave2 = $chkblosave2;

		$chkblo3 = [];
		$i = 0;
		$sql = "EXEC AUDITEX.SP_CLC_SELECT_CHKBLO3";
		$stmt = sqlsrv_prepare($conn, $sql);
		$result = sqlsrv_execute($stmt);
		while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$obj = new stdClass();
			$obj->CODTEN = $row['CODTEN'];
			$obj->DESTEN = utf8_encode($row['DESTEN']);
			$obj->VALIDAR = $row['VALIDAR'];
			$obj->EDITABLE = $row['EDITABLE'];
			$chkblo3[$i] = $obj;
			$i++;
		}
		$response->chkblo3 = $chkblo3;


		$chkblosave3 = [];
		$i = 0;
		$sql = "EXEC AUDITEX.SP_CLC_SELECT_CHETENGUA ?, ?, ?, ?";
		$stmt = sqlsrv_prepare($conn, $sql, array(
			&$_POST['codfic'],
			&$_POST['codtad'],
			&$_POST['numvez'],
			&$_POST['parte']
		));
		$result = sqlsrv_execute($stmt);
		while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$obj = new stdClass();
			$obj->CODTEN = $row['CODTEN'];
			$obj->RESTEN = $row['RESTEN'];
			$chkblosave3[$i] = $obj;
			$i++;
		}
		$response->chkblosave3 = $chkblosave3;

		$response->maxform=$maxform;
	}

	sqlsrv_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>