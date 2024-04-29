<?php
	include('connection.php');
	$response=new stdClass();

	$err=0;
	if (isset($_POST['array'])) {
		$array=$_POST['array'];
		for ($i=0; $i < count($array); $i++) { 
			$sql="BEGIN SP_AFC_UPDATE_ESTTSCFOR(:ESTTSC,:CODMED,:AUDITABLE); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
			oci_bind_by_name($stmt, ':CODMED', $array[$i][0]);
			oci_bind_by_name($stmt, ':AUDITABLE', $array[$i][1]);
			$result=oci_execute($stmt);
			if (!$result) {
				$err++;
			}
		}
		if ($err==0) {
			$response->state=true;
		}else{
			$response->state=false;
			$response->detail="No se cargaron correctamente los cambios!";
		}
	}else{
		$response->state=false;
		$response->detail="No hay cambios que guardar";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>