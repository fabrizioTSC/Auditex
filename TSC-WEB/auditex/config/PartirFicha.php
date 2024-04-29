<?php
	session_start();
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codfic'])) {
		/*$sql="BEGIN SP_AT_PARTIR_FICHAAUDITORIA(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL,:NUECAN); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':CODAQL', $_POST['codaql']);
		oci_bind_by_name($stmt, ':NUECAN', $_POST['nuecan']);
		$result=oci_execute($stmt);*/
		//SP_AT_PARTIR_FICAUDTAL(p_codfic, p_numvez, p_parte, p_codtad, p_codaql, p_nuecan, p_codtll, p_nuetll,p_codusu);
		$sql="BEGIN SP_AT_PARTIR_FICAUDTAL(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL,:NUECAN,
		:CODTLL, :NUECODTLL, :CODUSU); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':CODAQL', $_POST['codaql']);
		oci_bind_by_name($stmt, ':NUECAN', $_POST['nuecan']);
		oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
		oci_bind_by_name($stmt, ':NUECODTLL', $_POST['nuecodtll']);
		oci_bind_by_name($stmt, ':CODUSU', $_SESSION['user']);
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