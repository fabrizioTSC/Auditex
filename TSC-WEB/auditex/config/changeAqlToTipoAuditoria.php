<?php
	ini_set('max_execution_time', 300);
	include('connection.php');
	$response=new stdClass();

	$sqlDefectos="BEGIN SP_AT_SELECT_FICHASXCODTAD(:CODTAD,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sqlDefectos);
	oci_bind_by_name($stmt, ':CODAQL', $_POST['codtad']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($rowFichas=oci_fetch_assoc($OUTPUT_CUR)){
		$sql="BEGIN SP_AT_UPDATE_AQLTIPAUDFICHA(:CODFIC,:NUMVEZ,:PARTE,:CODAQL,:CODTAD,:NEWAQL); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $rowFichas['CODFIC']);
		oci_bind_by_name($stmt, ':NUMVEZ', $rowFichas['NUMVEZ']);
		oci_bind_by_name($stmt, ':PARTE', $rowFichas['PARTE']);
		oci_bind_by_name($stmt, ':CODAQL', $rowFichas['CODAQL']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NEWAQL', $_POST['codaql']);
		$result=oci_execute($stmt);
		if (!$result) {
			$i++;
			$response->num_error=$i;
		}
	}
	$response->state=true;
	$response->description="Fichas actualizadas!";
	
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>