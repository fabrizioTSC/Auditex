<?php
	include('connection.php');
	$response=new stdClass();

	$array=$_POST['array'];
	$ec=0;
	for ($i=0; $i < count($array); $i++) { 
		$sql="BEGIN SP_ATT_UPDATE_REGTES_PARTEVEZ(:PARTIDA, :CODTEL, :CODPRV, :CODESTDIM, :PARTE,:NUMVEZ,:TESTING); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
		oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
		oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
		oci_bind_by_name($stmt, ':CODESTDIM', $array[$i][0]);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':TESTING', $array[$i][1]);
		$result=oci_execute($stmt);
		
		if (!$result) {
			$ec++;
		}
	}
		
	if ($ec==0) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo guardar algunos registros!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>