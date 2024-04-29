<?php
	include('connection.php');
	$response=new stdClass();

	$sqlDefectos="BEGIN SP_APNC_UPDATE_DETFICTALDEF(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OBJ,:CODTAL,:CODDEF,
	:UBIDEF,:CANTIDAD); END;";
	$stmt=oci_parse($conn, $sqlDefectos);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':OBJ', $_POST['obj']);
	oci_bind_by_name($stmt, ':CODTAL', $_POST['codtal']);
	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	oci_bind_by_name($stmt, ':UBIDEF', $_POST['ubidef']);
	oci_bind_by_name($stmt, ':CANTIDAD', $_POST['cantidad']);
	$result=oci_execute($stmt);
	if ($result) {
		if (strpos($_POST['obj'], "canfin")>=0) {
			$sqlDefectos="BEGIN SP_APNC_UPDATE_FICXDEF(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:CODTAL,:ADDDEC); END;";
			$stmt=oci_parse($conn, $sqlDefectos);
			oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
			oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
			oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
			oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
			oci_bind_by_name($stmt, ':CODTAL', $_POST['codtal']);
			oci_bind_by_name($stmt, ':ADDDEC', $_POST['adddec']);
			$result=oci_execute($stmt);
		}
		$response->state=true;
		
		if (isset($_POST['pedido'])) {
			$porpedcol=array();
			$i=0;
			$sql="BEGIN SP_APNC_SELECT_PORPORPEDCOL(:PEDIDO,:COLOR,:OUTPUT_CUR); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
			oci_bind_by_name($stmt,':COLOR',$_POST['color']);
			$OUTPUT_CUR=oci_new_cursor($conn);
			oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
			$result=oci_execute($stmt);
			oci_execute($OUTPUT_CUR);
			while($row=oci_fetch_assoc($OUTPUT_CUR)){
				$obj=new stdClass();
				$obj->can2=str_replace(",",".",$row['CAN2']);
				$obj->can3=str_replace(",",".",$row['CAN3']);
				$obj->can4=str_replace(",",".",$row['CAN4']);
				$obj->canter=str_replace(",",".",$row['CANTER']);
				$obj->por2=str_replace(",",".",$row['POR2']);
				$obj->por3=str_replace(",",".",$row['POR3']);
				$obj->por4=str_replace(",",".",$row['POR4']);
				$porpedcol[$i]=$obj;
				$i++;
			}
			$response->porpedcol=$porpedcol;
		}
	}else{
		$response->state=false;
		$response->detail="No se pudo guardar el detalle de la talla!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>