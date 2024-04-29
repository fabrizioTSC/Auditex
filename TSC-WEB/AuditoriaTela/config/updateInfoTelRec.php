<?php
	include('connection.php');
	$response=new stdClass();

	$tallas=[];
	$i=0;

	$sql="BEGIN SP_AUDTEL_UPDATE_TELREC(:CODTEL,:DESTEL,:CODTELPRV,:COMPOS); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	oci_bind_by_name($stmt, ':DESTEL', $_POST['destel']);
	oci_bind_by_name($stmt, ':CODTELPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':COMPOS', $_POST['comfin']);
	$result=oci_execute($stmt);
	if($result){
		$array=$_POST['array'];
		for ($i=0; $i < count($array); $i++) { 
			$sql="BEGIN SP_AUDTEL_INSERT_TELRECTALMED(:CODTEL,:CODTAL,:LARGO,:TOLLAR,:ALTO,:TOLALT,:PESO); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
			oci_bind_by_name($stmt, ':CODTAL', $array[$i][0]);
			oci_bind_by_name($stmt, ':LARGO', $array[$i][1]);
			oci_bind_by_name($stmt, ':TOLLAR',$array[$i][2]);
			oci_bind_by_name($stmt, ':ALTO', $array[$i][3]);
			oci_bind_by_name($stmt, ':TOLALT',$array[$i][4]);
			oci_bind_by_name($stmt, ':PESO',$array[$i][5]);
			$result=oci_execute($stmt);
		}
		$response->state=true;
		$response->detail="Tela guardada!";
	}else{
		$response->state=false;
		$response->detail="No se pudo actualizar la tela!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>