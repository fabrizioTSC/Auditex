<?php
	include('connection.php');
	$response=new stdClass();

	$err=0;
	$canaudtot=0;
	$candeftot=0;
	$array=$_POST['array'];
	for ($i=0; $i < count($array); $i++) { 
		$canaudtot+=intval($array[$i][1]);
		$candeftot+=intval($array[$i][2]);
		$sqlDefectos="BEGIN SP_APNC_INSERT_DETFICTAL(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:CODTAL,:CANAUD,:CANDEF); END;";
		$stmt=oci_parse($conn, $sqlDefectos);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		oci_bind_by_name($stmt, ':CODTAL', $array[$i][0]);
		oci_bind_by_name($stmt, ':CANAUD', $array[$i][1]);
		oci_bind_by_name($stmt, ':CANDEF', $array[$i][2]);
		$result=oci_execute($stmt);
		if (!$result) {
			$err++;
		}
	}
	if ($err==0) {
		$sqlDefectos="BEGIN SP_APNC_UPDATE_FICHA(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:CANAUD,:CANDEF); END;";
		$stmt=oci_parse($conn, $sqlDefectos);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		oci_bind_by_name($stmt, ':CANAUD', $canaudtot);
		oci_bind_by_name($stmt, ':CANDEF', $candeftot);
		$result=oci_execute($stmt);

		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo guardar el detalle de las tallas!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>