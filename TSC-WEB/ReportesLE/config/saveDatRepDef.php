<?php
	include('connection.php');
	$response=new stdClass();
	
	$arraycol=$_POST['arraycol'];
	for ($i=0; $i < count($arraycol); $i++) {			
		$sql="BEGIN SP_RLE_UPDATE_POPLCOL(:PO,:PACLIS,:DESCOL,:DESCOLREP); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PO', $_POST['po']);
		oci_bind_by_name($stmt, ':PACLIS', $_POST['paclis']);
		oci_bind_by_name($stmt, ':DESCOL', $arraycol[$i][0]);
		oci_bind_by_name($stmt, ':DESCOLREP', $arraycol[$i][1]);
		$result=oci_execute($stmt);
	}

	$sql="BEGIN SP_RLE_UPDATE_REPPOPLCALV2(:PO,:PACLIS,:3,:4,:5,:6,:7,:8,:9,:10,:12,:13,:14,:15,:16,:17,:18,:19,:20,:21,:22,:23,:24,:25,:26,:27,:CODUSU); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PO', $_POST['po']);
	oci_bind_by_name($stmt, ':PACLIS', $_POST['paclis']);
	oci_bind_by_name($stmt, ':3', $_POST['form']);
	oci_bind_by_name($stmt, ':4', $_POST['version']);
	oci_bind_by_name($stmt, ':5', $_POST['vendor']);
	oci_bind_by_name($stmt, ':6', $_POST['factory']);
	oci_bind_by_name($stmt, ':7', $_POST['codwardes']);
	oci_bind_by_name($stmt, ':8', $_POST['categoria']);
	oci_bind_by_name($stmt, ':9', $_POST['descolrep']);
	oci_bind_by_name($stmt, ':10', $_POST['codaud']);
	oci_bind_by_name($stmt, ':12', $_POST['pass']);
	oci_bind_by_name($stmt, ':13', $_POST['carinspul']);
	oci_bind_by_name($stmt, ':14', $_POST['carinsmoisture']);
	oci_bind_by_name($stmt, ':15', $_POST['comentarios']);
	oci_bind_by_name($stmt, ':16', $_POST['prefinal']);
	oci_bind_by_name($stmt, ':17', $_POST['inline']);
	oci_bind_by_name($stmt, ':18', $_POST['inlinevez']);
	oci_bind_by_name($stmt, ':19', $_POST['reaudit']);
	oci_bind_by_name($stmt, ':20', $_POST['reauditvez']);
	oci_bind_by_name($stmt, ':21', $_POST['certifiedaud']);
	oci_bind_by_name($stmt, ':22', $_POST['trainee']);
	oci_bind_by_name($stmt, ':23', $_POST['precertifiedaud']);
	oci_bind_by_name($stmt, ':24', $_POST['correlationaud']);
	oci_bind_by_name($stmt, ':25', $_POST['leauditor']);
	oci_bind_by_name($stmt, ':26', $_POST['finalaudit']);
	$despre=utf8_encode($_POST['despre']);
	oci_bind_by_name($stmt, ':27', $despre);
	session_start();
	oci_bind_by_name($stmt, ':CODUSU', $_SESSION['user']);
	$result=oci_execute($stmt);
	if ($result) {
		$array=$_POST['array'];
		for ($i=0; $i < count($array); $i++) {			
			$sql="BEGIN SP_RLE_UPDATE_POPLCALDEF(:PO,:PACLIS,:CODDEF,:CANDEFREP,:CORACT); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':PO', $_POST['po']);
			oci_bind_by_name($stmt, ':PACLIS', $_POST['paclis']);
			oci_bind_by_name($stmt, ':CODDEF', $array[$i][0]);
			oci_bind_by_name($stmt, ':CANDEFREP', $array[$i][1]);
			oci_bind_by_name($stmt, ':CORACT', $array[$i][2]);
			$result=oci_execute($stmt);
		}

		$response->state=true;
		$response->detail="Datos guardados";
	}else{
		$response->state=false;
		$response->detail="No se guardo la información";
	}
	

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>