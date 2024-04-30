<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	
	$partidaclass=new stdClass();
	$sql="EXEC AUDITEX.SP_AFC_GET_INFOPARTIDA ?;";
	$stmt=sqlsrv_prepare($conn, $sql, array(&$_POST['codfic']));
	$result=sqlsrv_execute($stmt);
	$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
	$partidaclass->partida=$row['PARTIDA'];
	$partidaclass->tiptel=$row['ARTICULO'];
	$partidaclass->color=$row['COLOR'];
	$partidaclass->codtel=$row['CODTEL'];
	$partidaclass->descli=utf8_encode($row['DESCLI']);

	$sql="EXEC AUDITEX.SP_AFC_GET_INFOPARTIDA2 ?, ?;";
	$stmt=sqlsrv_prepare($conn, $sql, array(&$partidaclass->partida, &$partidaclass->codtel));
	$result=sqlsrv_execute($stmt);
	$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

	if($row){
		$partidaclass->codprv=$row['CODPRV'];
		$partidaclass->numvez=$row['NUMVEZ'];
		$partidaclass->parte=$row['PARTE'];
		$partidaclass->codtad=$row['CODTAD'];
	}
	$response->partida=$partidaclass;

	$defectos=array();
	$fichatallas=array();
	$defectosPasados=array();
	$fichas=[];
	$i=0;
	$sql="EXEC AUDITEX.SP_AFC_SELECT_FICHAXTALLER ?, ?, ?, ?, ?;";
	$stmt=sqlsrv_prepare($conn, $sql, array(&$_POST['codfic'], &$_POST['numvez'], &$_POST['parte'], &$_POST['codtad'], &$_POST['codaql']));
	$result=sqlsrv_execute($stmt);
	while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
		$ficha=new stdClass();
		$ficha->CANAUD=$row['CANAUD'];
		$ficha->CANPAR=$row['CANPAR'];
		$ficha->CANPRE=$row['CANPRE'];
		$ficha->CANDEFMAX=$row['CANDEFMAX'];
		$ficha->CODAQL=$row['CODAQL'];
		$ficha->AQL=$row['AQL'];
		$ficha->DESTLL=utf8_encode($row['DESTLL']);
		$ficha->PEDIDO=$row['PEDIDO'];
		$ficha->ESTTSC=$row['ESTTSC'];
		$ficha->ESTCLI=$row['ESTCLI'];
		$fichas[$i]=$ficha;
		$i++;
	}
	$response->fichas=$fichas;
	$sql="EXEC AUDITEX.SP_GEN_SELECT_NOMCEL ?;";
	$stmt=sqlsrv_prepare($conn, $sql, array(&$_POST['codfic']));
	$result=sqlsrv_execute($stmt);
	$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
	$response->DESCEL=utf8_encode($row['DESTLL']);

	if (count($fichas) == 0) {			
		$response->state=false;
		$response->description="No hay fichas para el taller";
	}else{
		$sql="EXEC AUDITEX.SP_AFC_SELECT_FICHATALLAS ?;";
		$stmt=sqlsrv_prepare($conn, $sql, array(&$_POST['codfic']));
		$result=sqlsrv_execute($stmt);
		while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$fichatalla=new stdClass();
			$fichatalla=$row;
			array_push($fichatallas,$fichatalla);
		}
		$sql="EXEC AUDITEX.SP_AFC_SELECT_DEFECTOS;";
		$stmt=sqlsrv_prepare($conn, $sql);
		$result=sqlsrv_execute($stmt);
		while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
			$defecto=new stdClass();
			$defecto->coddef=$row['CODDEF'];
			$defecto->desdef=utf8_encode($row['DESDEF']);
			array_push($defectos,$defecto);
		}
		$sql="EXEC AUDITEX.SP_AFC_SELECT_AUDFINCORDETDEF ?, ?, ?, ?;";
		$stmt=sqlsrv_prepare($conn, $sql, array(&$_POST['codfic'], &$_POST['numvez'], &$_POST['parte'], &$_POST['codtad']));
		$result=sqlsrv_execute($stmt);
		while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){				
			$defectoPas=new stdClass();
			$defectoPas=$row;
			array_push($defectosPasados,$defectoPas);
		}
		$response->defectos=$defectos;
		$response->fichatallas=$fichatallas;
		$response->defectosPasados=$defectosPasados;
		$response->state=true;

		$sql="EXEC AUDITEX.SP_AFC_SELECT_OBSFICCOR  ?, ?, ?, ?;";
		$stmt=sqlsrv_prepare($conn, $sql, array(&$_POST['codfic'], &$_POST['numvez'], &$_POST['parte'], &$_POST['codtad']));
		$result=sqlsrv_execute($stmt);
		$obs=[];
		$i=0;
		while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){				
			$obj=new stdClass();
			$obj->SEC=$row['SEC'];
			$obj->OBS=utf8_encode($row['OBS']);
			$obs[$i]=$obj;
			$i++;
		}
		$response->obs=$obs;
	}

	sqlsrv_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>