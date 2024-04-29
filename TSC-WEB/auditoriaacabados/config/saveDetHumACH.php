<?php
	include('connection.php');
	$response=new stdClass();

	$err=0;
	$array=$_POST['array'];
	for ($i=0; $i < count($array); $i++) { 
		$sql="BEGIN SP_ACH_UPDATE_DETHUM(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:IDREG,:HUMEDAD); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		oci_bind_by_name($stmt, ':IDREG', $array[$i][0]);
		oci_bind_by_name($stmt, ':HUMEDAD', $array[$i][1]);
		$result=oci_execute($stmt);
		if (!$result) {
			$err++;
		}
	}
	if ($err==0) {
		$sql="BEGIN SP_ACH_UPDATE_FICDESGUA(:CODFIC,:CODTAD,:NUMVEZ,:PARTE); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		$result=oci_execute($stmt);
		if ($result) {
			$response->state=true;

			$sql="BEGIN SP_ACH_SELECT_FICDATHUM(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
			oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
			oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
			oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
			$OUTPUT_CUR=oci_new_cursor($conn);
			oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
			$result=oci_execute($stmt);
			oci_execute($OUTPUT_CUR);
			while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
				$response->HUMPRO=str_replace(",",".",$row['HUMPRO']);
				$response->RESULTADO=$row['RESULTADO'];
			}
		}else{
			$response->state=false;
			$response->detail="Hubo un error al guardar el promedio";
		}
	}else{
		$response->state=false;
		$response->detail="Hubo un error al guardar las humedades";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);