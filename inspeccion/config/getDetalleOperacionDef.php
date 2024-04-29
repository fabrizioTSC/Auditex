<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codtll'])) {

		$sumOpe=0;
		$sql="BEGIN SP_INSP_SELECT_INFREPDETOPE(:CODTLL,:CODOPE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
		oci_bind_by_name($stmt, ':CODOPE', $_POST['codope']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);  
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$detalleOpe=array();
		$i=0;
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODDEF=$row['CODDEF'];
			$obj->DESDEF=utf8_encode($row['DESDEF']);
			$obj->CANTIDAD=$row['CANTIDAD'];
			$detalleOpe[$i]=$obj;
			$i++;
		}
		$response->detalleOpe=$detalleOpe;
		
		$sql="BEGIN SP_INSP_SELECT_OPERACION(:CODOPE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt, ':CODOPE', $_POST['codope']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);  
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);

		$response->nomDetOpe=utf8_encode($row['DESOPE']);
		$response->state=true;		
	}else{
		$response->state=false;
		$error->code=1;
		$error->description="No es un metodo POST.";
		$response->err=$error;
	}
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>