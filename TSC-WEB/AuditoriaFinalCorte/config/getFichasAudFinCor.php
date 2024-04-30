<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

	function replace_null($text){
		if ($text==null || $text=="null") {
			return "";
		}else{
			return $text;
		}
	}
	// Para auditoria final de costura
	$fichas=array();
	$i=0;		
	$sql="EXEC AUDITEX.SP_AFC_SELECT_FICHAS;";
	$stmt=sqlsrv_prepare($conn, $sql);
	$result=sqlsrv_execute($stmt);
	while($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
		$ficha=new stdClass();
		$ficha->CODFIC=$row['CODFIC'];
		$ficha->CANPAR=$row['CANPAR'];
		$ficha->PARTE=$row['PARTE'];
		$ficha->NUMVEZ=$row['NUMVEZ'];
		$ficha->CODAQL=$row['CODAQL'];
		$ficha->AQL=$row['AQL'];
		$ficha->CODTAD=$row['CODTAD'];
		$ficha->CODUSU=replace_null($row['CODUSU']);
		$fichas[$i]=$ficha;
		$i++;
	}
	sqlsrv_free_stmt($stmt);
	if (count($fichas) == 0) {			
		$response->state=false;
		$response->description="No hay fichas!";
	}else{
		$response->state=true;
		$response->fichas=$fichas;
	}

	sqlsrv_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>