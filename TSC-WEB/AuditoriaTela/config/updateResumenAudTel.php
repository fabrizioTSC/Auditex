<?php
	include('connection.php');
	$response=new stdClass();			

	$sql="BEGIN SP_AUDTEL_SELECT_RESULTADOS(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE, :PESO, :PESOAUD, :PESOAPRO, :PESOCAI, :CALIFICACION, :TIPO, :RESULTADO); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':PESO', $peso,40);
	oci_bind_by_name($stmt, ':PESOAUD', $pesoaud,40);
	oci_bind_by_name($stmt, ':PESOAPRO', $pesoapro,40);
	oci_bind_by_name($stmt, ':PESOCAI', $pesocai,40);
	oci_bind_by_name($stmt, ':CALIFICACION', $calificacion,40);
	oci_bind_by_name($stmt, ':TIPO', $tipo,40);
	oci_bind_by_name($stmt, ':RESULTADO', $resultado,40);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->peso=str_replace(",", ".", $peso);
		$response->pesoaud=str_replace(",", ".", $pesoaud);
		$response->pesoapro=str_replace(",", ".", $pesoapro);
		$response->pesocai=str_replace(",", ".", $pesocai);
		$response->calificacion=$calificacion;
		$response->tipo=$tipo;
		$response->resultado=$resultado;
	}else{
		$response->state=false;
		$response->detail="No se pudo obtener el resumen de la partida";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>