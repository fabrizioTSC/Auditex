<?php
	include('connection.php');
	$response=new stdClass();


	/*$sqlDefectos="BEGIN SP_APNC_SELECT_VALDETTAL(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:CONTADOR); END;";
	$stmt=oci_parse($conn, $sqlDefectos);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':CONTADOR', $contador,40);
	$result=oci_execute($stmt);

	if ($contador>0) {*/
		$sqlDefectos="BEGIN SP_APNC_INSERT_DETFIC(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:CODTAL,:CODDEF,:UBIDEF,:ESTADO); END;";
		$stmt=oci_parse($conn, $sqlDefectos);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		oci_bind_by_name($stmt, ':CODTAL', $_POST['codtal']);
		oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
		oci_bind_by_name($stmt, ':UBIDEF', $_POST['ubicacion']);
		oci_bind_by_name($stmt, ':ESTADO', $estado,40);
		$result=oci_execute($stmt);
		if ($result) {
			if($estado==0){
				$response->state=true;

				$sql="BEGIN SP_APNC_SELECT_UBIDEFXCOD(:CODUBIDEF,:OUTPUT_CUR); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':CODUBIDEF', $_POST['ubicacion']);
				$OUTPUT_CUR=oci_new_cursor($conn);
				oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
				$result=oci_execute($stmt);
				oci_execute($OUTPUT_CUR);
				$row=oci_fetch_assoc($OUTPUT_CUR);
				$response->codubidef=utf8_encode($row['DESUBIDEF']);
			}else{
				$response->state=false;
				$response->detail="Ya se encuentra registrada la talla - defecto - ubicacion!";
			}
		}else{
			$response->state=false;
			$response->detail="No se pudo guardar el detalle de la ficha!";
		}
	/*}else{
		$response->state=false;
		$response->detail="Debe agregar las cantidades a auditar primero!";
	}*/

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>