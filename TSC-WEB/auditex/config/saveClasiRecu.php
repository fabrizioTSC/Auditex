<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AT_INSERT_FICAUDREC(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CANPRE,:CODUSU); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
	oci_bind_by_name($stmt,':CANPRE',$_POST['canpre']);
	oci_bind_by_name($stmt,':CODUSU',$_POST['codusu']);
	$result=oci_execute($stmt);
	if ($result) {
		$array=$_POST['array'];
		for ($i=0; $i < count($array); $i++) {
			$sql="BEGIN SP_AT_INSERT_FICAUDRECDET_NEW(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODCLAREC,:CANPRE,:OBS); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
			oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
			oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
			oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
			oci_bind_by_name($stmt,':CODCLAREC',$array[$i][0]);
			oci_bind_by_name($stmt,':CANPRE',$array[$i][1]);
			oci_bind_by_name($stmt,':OBS',$array[$i][2]);
			$result=oci_execute($stmt);
		}
		$response->state=true;
	}else{
		$result->state=false;
		$result->detail="No se pudo guardar la clasificación de recuperación!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>