<?php
	set_time_limit(360);
	include('connection.php');

	$response=new stdClass();

	$sql="BEGIN SP_ATR_UPDATE_AUD(:PARTIDA,:CODPRV,:CODTEL,:CODTAD,:NUMVEZ,:PARTE,:CODUSU); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	$result=oci_execute($stmt);
	if($result){
		$array=$_POST['array'];
		for ($i=0; $i < count($array); $i++) { 
			$sql="BEGIN SP_AUDTEL_INSERT_DETPATR(:PARTIDA,:CODPRV,:CODTEL,:CODTAD,:NUMVEZ,:PARTE,:CODTAL,:LARGO,:ALTO,:CANAUD,:CANSEG,:OBS); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
			oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
			oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
			oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
			oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
			oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
			oci_bind_by_name($stmt, ':CODTAL', $array[$i][0]);
			oci_bind_by_name($stmt, ':LARGO', $array[$i][1]);
			oci_bind_by_name($stmt, ':ALTO', $array[$i][2]);
			oci_bind_by_name($stmt, ':CANAUD', $array[$i][3]);
			oci_bind_by_name($stmt, ':CANSEG', $array[$i][4]);
			oci_bind_by_name($stmt, ':OBS', $array[$i][5]);
			$result=oci_execute($stmt);
		}
		$sql="BEGIN SP_ATR_UPDATE_AUD2(:PARTIDA,:CODPRV,:CODTEL,:CODTAD,:NUMVEZ,:PARTE); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
		oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
		oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		$result=oci_execute($stmt);
		
		$response->state=true;
		$response->detail="Auditoria guardada!";
	}else{
		$response->state=false;
		$response->detail="No se pudo guardar la auditoria!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>