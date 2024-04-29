<?php
	set_time_limit(240);
	include('connection.php');
	$response=new stdClass();
	$array=$_POST['array'];

	$con_err=0;
	for ($i=0; $i < count($array); $i++) { 
		$sql="BEGIN SP_CLC_INSERT_CHEBLO2(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:CODDOC,:RESDOC,:REPROCESO); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		oci_bind_by_name($stmt, ':CODDOC', $array[$i][0]);
		oci_bind_by_name($stmt, ':RESDOC', $array[$i][1]);
		oci_bind_by_name($stmt, ':REPROCESO', $array[$i][2]);
		$result=oci_execute($stmt);
		if (!$result) {
			$con_err++;
		}
	}

	$sql="BEGIN SP_CLC_UPDATE_CHEBLO2END(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OBS,:RESULTADO); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':OBS', $_POST['obs']);
	oci_bind_by_name($stmt, ':RESULTADO', $_POST['resultado']);
	$result=oci_execute($stmt);

	if ($result) {
		$response->state=true;
		
		$chkblosave2=array();
		$i=0;
		$tela=new stdClass();
		$sql="BEGIN SP_CLC_SELECT_CHETIZGUA(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$end_blo2=true;
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODTIZ=$row['CODTIZ'];
			$obj->RESTIZ=$row['RESTIZ'];
			$obj->VECES=$row['VECES'];
			$chkblosave2[$i]=$obj;
			$i++;
		}
		$response->chkblosave2=$chkblosave2;
	}else{
		$response->state=false;
		$response->detail="No se pudo guardar la validacion!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);

?>