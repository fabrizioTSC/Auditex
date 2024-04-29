<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AUDTEL_VALUSU(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE, :CODUSU, :PERUSU,:VAL); END;";
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
		$sql="BEGIN SP_AUDTEL_UPDATE_PARROL(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE, :NUMROL, :DENSINREP, :METLIN,:ANCUTI,:INCDER,:INCMED,:ANCSINREP,:PESO,:ANCTOT,:INCSTD,:INCIZQ,:RAPPORT,:PUNROL,:CALIFICACION); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
		oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
		oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		oci_bind_by_name($stmt, ':NUMROL', $_POST['numrol']);
		oci_bind_by_name($stmt, ':DENSINREP', $_POST['densinrep']);
		oci_bind_by_name($stmt, ':METLIN', $_POST['metlin']);
		oci_bind_by_name($stmt, ':ANCUTI', $_POST['ancuti']);
		oci_bind_by_name($stmt, ':INCDER', $_POST['incder']);
		oci_bind_by_name($stmt, ':INCMED', $_POST['incmed']);
		oci_bind_by_name($stmt, ':ANCSINREP', $_POST['ancsinrep']);
		oci_bind_by_name($stmt, ':PESO', $_POST['peso']);
		oci_bind_by_name($stmt, ':ANCTOT', $_POST['anctot']);
		oci_bind_by_name($stmt, ':INCSTD', $_POST['incstd']);
		oci_bind_by_name($stmt, ':INCIZQ', $_POST['incizq']);
		oci_bind_by_name($stmt, ':RAPPORT', $_POST['rapport']);
		oci_bind_by_name($stmt, ':PUNROL', $punrol,40);
		oci_bind_by_name($stmt, ':CALIFICACION', $calificacion,40);
		$result=oci_execute($stmt);
			
		if ($result) {
			$response->state=true;
			$response->punrol=str_replace(",",".",$punrol);
			$response->detail="Información de rollo guardada!";
			$response->calificacion=$calificacion;
		}else{
			$response->state=false;
			$response->detail="No se pudo guardar la información!";
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