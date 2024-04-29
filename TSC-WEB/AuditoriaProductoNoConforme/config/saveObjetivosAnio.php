<?php
	include('connection.php');
	$response=new stdClass();

	$array=$_POST['array'];
	$o=0;
	for ($i=0; $i < count($array); $i++) { 
		$sql="BEGIN SP_APNC_INSERT_OBJANIO(:ANIO,:OBJ); END;";		
		$stmt=oci_parse($conn, $sql);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':ANIO', $array[$i][0]);
		oci_bind_by_name($stmt, ':OBJ', $array[$i][1]);
		$result=oci_execute($stmt);
		if (!$result) {
			$o++;
		}
	}
	if ($o==0) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo guardar los datos";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>