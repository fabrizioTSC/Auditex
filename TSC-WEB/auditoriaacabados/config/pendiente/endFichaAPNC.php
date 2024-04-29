<?php
	include('connection.php');
	$response=new stdClass();

	$err=0;
	if (isset($_POST['array'])) {
		$array=$_POST['array'];
		for ($i=0; $i < count($array); $i++) { 
			$sql="BEGIN SP_APNC_UPDATE_FICTALDEFOBS(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:CODTAL,:CODDEF,:UBIDEF,:OBS); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
			oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
			oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
			oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
			oci_bind_by_name($stmt, ':CODTAL', $array[$i][1]);
			oci_bind_by_name($stmt, ':CODDEF', $array[$i][0]);
			oci_bind_by_name($stmt, ':UBIDEF', $array[$i][2]);
			oci_bind_by_name($stmt, ':OBS', $array[$i][3]);
			$result=oci_execute($stmt);
			if (!$result) {
				$err++;
			}
		}
	}
	if ($err==0) {
		$sql="BEGIN SP_APNC_END_FICHA(:CODFIC,:CODTAD,:NUMVEZ); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		//oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		$result=oci_execute($stmt);

		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo finalizar la ficha!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>