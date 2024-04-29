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

	$sql="BEGIN SP_AA_INSERT_CHELISDEF(:CODFIC,:PARTE,:NUMVEZ,:CODDEF,:CANDEF); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	oci_bind_by_name($stmt, ':CANDEF', $_POST['candef']);
	$result=oci_execute($stmt);

	$sql="BEGIN SP_AA_UPDATE_CANDEFCHELIS(:CODFIC,:PARTE,:NUMVEZ); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	$result=oci_execute($stmt);

	if ($result) {
		$defectos=[];
		$sql="begin SP_AA_SELECT_DETCHELISDEF(:CODFIC,:PARTE,:NUMVEZ,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODDEF=$row['CODDEF'];
			$obj->DESFAM=utf8_encode($row['DSCFAMILIA']);
			$obj->DESDEF=utf8_encode($row['DESDEF']);
			$obj->CODDEFAUX=$row['CODDEFAUX'];
			$obj->CANDEF=$row['CANDEF'];
			array_push($defectos, $obj);
		}
		$response->defectos=$defectos;
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo guardar el defecto";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);

?>