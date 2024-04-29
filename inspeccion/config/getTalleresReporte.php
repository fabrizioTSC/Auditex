<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['request'])) {
		$talleres=[];
		$i=0;
		
		$stmt = oci_parse($conn,'BEGIN SP_INSP_SELECT_TLLREP(:OUTPUT_CUR); END;');
		$OUTPUT_CUR = oci_new_cursor($conn);
		oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);    
		$result=oci_execute($stmt); 
		oci_execute($OUTPUT_CUR);
		while ($row = oci_fetch_assoc($OUTPUT_CUR)) {		
			$obj=new stdClass();
			$obj->CODTLL=$row['CODTLL'];
			$obj->DESTLL=utf8_encode($row['DESTLL']);
			$talleres[$i]=$obj;
			$i++;
		}
		$response->talleres=$talleres;

		$turnos=[];
		$i=0;
		
		$stmt = oci_parse($conn,'BEGIN SP_INSP_SELECT_TURREP(:OUTPUT_CUR); END;');
		$OUTPUT_CUR = oci_new_cursor($conn);
		oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);    
		$result=oci_execute($stmt); 
		oci_execute($OUTPUT_CUR);
		while ($row = oci_fetch_assoc($OUTPUT_CUR)) {		
			$obj=new stdClass();
			$obj->TURNO=$row['TURNO'];
			$turnos[$i]=$obj;
			$i++;
		}
		$response->turnos=$turnos;

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