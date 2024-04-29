<?php
	session_start();
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codfic'])) {
		$array=$_POST['array'];
		for ($i=0; $i < sizeof($array); $i++) {
			$sql="BEGIN AT_SP_PARTIR_FICHAAUDTALPAR(:CODFIC,:PARTE,:CODTAD,:CODTAL,:NUECAN); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
			oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
			oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
			oci_bind_by_name($stmt, ':CODTAL', $array[$i][0]);
			oci_bind_by_name($stmt, ':NUECAN', $array[$i][1]);
			$result=oci_execute($stmt);
		}

		$sql="BEGIN SP_AT_PARTIR_FICHAAUDTALLA(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:NUECAN); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUECAN', $_POST['nuecan']);
		$result=oci_execute($stmt);

		if ($result) {
			$response->state=true;
			$error->description="Ficha partida!";
		}else{
			$response->state=false;
			$error->code=3;
			$error->description="No se pudo partir la ficha!";
			$response->error=$error;			
		}
	}else{
		$response->state=false;
		$error->code=1;
		$error->description="No es un metodo POST.";
		$response->error=$error;
	}
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>