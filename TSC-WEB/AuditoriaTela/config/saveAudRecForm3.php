<?php
	set_time_limit(360);
	include('connection.php');

	$response=new stdClass();

	$sql="BEGIN SP_ATR_VALUSU(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE, :CODUSU, :PERUSU,:VAL); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':PERUSU', $_POST['perusu']);
	oci_bind_by_name($stmt, ':VAL', $validar,40);
	$result=oci_execute($stmt);
	if ($validar>0) {
		$sql="BEGIN SP_ATR_UPDATE_PARAUD3(:PARTIDA,:CODPRV,:CODTEL,:CODTAD,:NUMVEZ,:PARTE,:CODUSU); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
		oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
		oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
		oci_bind_by_name($stmt, ':PERUSU', $_POST['perusu']);
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
			$response->state=true;
			$response->detail="Auditoria guardada!";
		}else{
			$response->state=false;
			$response->detail="No se pudo guardar la auditoria!";
		}
	}else{
		$response->state=false;
		if ($_POST['perusu']!=2) {
			$response->detail="La partida fue tomada por otro auditor!";
		}else{
			$response->detail="La partida fue tomada por otro supervisor!";
		}
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>