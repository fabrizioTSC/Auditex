<?php
	set_time_limit(360);
	include('connection.php');

	$response=new stdClass();
	$array=$_POST['array'];

	$sql="BEGIN SP_AUDTEL_UPDATE_TELAAUX(:CODTEL,:DESTEL,:CODTELPRV,:COMPOS,:REN,:RUTA); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	oci_bind_by_name($stmt, ':DESTEL', $_POST['destel']);
	oci_bind_by_name($stmt, ':CODTELPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':COMPOS', $_POST['comfin']);
	oci_bind_by_name($stmt, ':REN', $_POST['ren']);
	oci_bind_by_name($stmt, ':RUTA', $_POST['ruttel']);
	$result=oci_execute($stmt);
	if($result){
		$sql="BEGIN SP_AUDTEL_INSERT_TELA(:CODTEL,:CONTADOR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
		oci_bind_by_name($stmt, ':CONTADOR', $cont,40);
		if ($cont==0) {
			for ($i=0; $i < count($array); $i++) { 
				$sql="BEGIN SP_AUDTEL_UPDATE_TELESTDIM(:CODTEL,:CODESTDIM,:VALOR,:TOLERANCIA); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
				oci_bind_by_name($stmt, ':CODESTDIM', $array[$i][0]);
				oci_bind_by_name($stmt, ':VALOR', $array[$i][1]);
				oci_bind_by_name($stmt, ':TOLERANCIA',$array[$i][2]);
				$result=oci_execute($stmt);
			}
			$response->state=true;
			$response->detail="Tela editada!";
		}else{
			$response->state=false;
			$response->detail="No se pudo editar la estabilidad dimensional de la tela!";			
		}
	}else{
		$response->state=false;
		$response->detail="No se pudo editar la tela!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>