<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AUDTEL_UPDATE_PESPAR(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE, :PESO); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	$peso=floatval(str_replace(".",",",$_POST['peso']));
	oci_bind_by_name($stmt, ':PESO', $peso);
	$result=oci_execute($stmt);
		
	if ($result) {
		$sql="BEGIN SP_AUDTEL_VAL_ENDAUD(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE, :CONTADOR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
		oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
		oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		oci_bind_by_name($stmt, ':CONTADOR', $cont,40);
		$result=oci_execute($stmt);
		if ($cont>0) {
			$response->tryend=true;
		}else{
			$response->tryend=false;
		}
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo guardar el peso!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>