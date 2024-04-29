<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codtll'])) {
		$sumOpe=0;
		$sql="BEGIN SP_INSP_SELECT_INFREPDETDEF(:CODTLL,:CODDEF,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
		oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);  
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$detalleDef=array();
		$i=0;
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODOPE=$row['CODOPE'];
			$obj->DESOPE=utf8_encode($row['DESOPE']);
			$obj->CANTIDAD=$row['CANTIDAD'];
			$detalleDef[$i]=$obj;
			$i++;
		}
		$response->detalleDef=$detalleDef;		

		$sql="BEGIN SP_INSP_SELECT_DEFECTO(:CODDEF,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);  
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$response->nomDetDef=utf8_encode($row['DESDEF']);

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