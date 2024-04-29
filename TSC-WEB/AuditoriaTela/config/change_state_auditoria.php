<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AUDTEL_VALPESEND(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE,:ESTADO); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':ESTADO', $estado,40);
	$result=oci_execute($stmt);
	if ($estado==0) {
		if ($_SESSION['perfil']=="2") {
			$sql="BEGIN SP_AUDTEL_VALEXIESTCON(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE,:ESTADO); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
			oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
			oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
			oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
			oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
			oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
			oci_bind_by_name($stmt, ':ESTADO', $estado,40);
			$result=oci_execute($stmt);
			if ($estado==0) {		
				$sql="BEGIN SP_AUDTEL_CAMESTAUD(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
				oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
				oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
				oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
				oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
				oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
				$result=oci_execute($stmt);
				if ($result) {
					$response->state=true;
				}else{
					$response->state=false;
					$response->detail="No se pudo finalizar la auditoria!";
				}
			}else{
				$response->state=false;
				$response->detail="Partida a espera de resultados de estudio de consumo. No se pudo finalizar la auditoria!";
			}
		}else{
			$sql="BEGIN SP_AUDTEL_CAMESTAUD(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
			oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
			oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
			oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
			oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
			oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
			$result=oci_execute($stmt);
			if ($result) {
				$response->state=true;
			}else{
				$response->state=false;
				$response->detail="No se pudo finalizar la auditoria!";
			}
		}
	}else{
		$response->state=false;
		$response->detail="Debe ingresar un peso mayor a 0 para terminar la auditoría!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>