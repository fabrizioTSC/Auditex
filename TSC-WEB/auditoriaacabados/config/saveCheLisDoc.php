<?php
	set_time_limit(240);
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AA_UPDATE_CHELISUSU(:CODFIC,:PARTE,:NUMVEZ,:CODUSU); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	session_start();
	oci_bind_by_name($stmt, ':CODUSU', $_SESSION['user']);
	$result=oci_execute($stmt);

	$array=$_POST['array'];

	$con_err=0;
	for ($i=0; $i < count($array); $i++) { 
		$sql="BEGIN SP_AA_UPDATE_CHELISDOC(:CODFIC,:PARTE,:NUMVEZ,:CODDOC,:RESDOC); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':CODDOC', $array[$i][0]);
		oci_bind_by_name($stmt, ':RESDOC', $array[$i][1]);
		$result=oci_execute($stmt);
		if (!$result) {
			$con_err++;
		}
	}
	if ($con_err==0) {		
		$sql="BEGIN SP_AA_UPDATE_AUDACADOC(:CODFIC,:PARTE,:NUMVEZ,:OBS); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':OBS', $_POST['obs']);
		$result=oci_execute($stmt);

		if ($result) {
			$response->state=true;
		}else{
			$response->state=false;
			$response->detail="No se pudo actualizar el check list";
		}
	}else{
		$response->state=false;
		$response->detail="No se pudo actualizar algunos documentos";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);

?>