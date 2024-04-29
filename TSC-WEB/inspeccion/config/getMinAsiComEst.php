<?php
	include('connection.php');
	$response=new stdClass();

	$esttsc=[];
	$i=0;	
	$stmt = oci_parse($conn,'BEGIN SP_INSP_SELECT_MINADICOMEST(:ESTTSC,:OUTPUT_CUR); END;');
	oci_bind_by_name($stmt,":ESTTSC", $_POST['esttsc']);
	$OUTPUT_CUR = oci_new_cursor($conn);
	oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);   
	$result=oci_execute($stmt); 
	oci_execute($OUTPUT_CUR);
	while ($row = oci_fetch_assoc($OUTPUT_CUR)) {		
		$obj=new stdClass();
		$obj->FECHAMIN=$row['FECHAMIN'];
		$obj->FECHAMAX=$row['FECHAMAX'];		
		$obj->ESTILO_TSC=$row['ESTILO_TSC'];
		$obj->ALTERNATIVA=$row['ALTERNATIVA'];
		$obj->RUTA=$row['RUTA'];
		$obj->MINCOST=str_replace(",",".",$row['MINCOST']);
		$obj->MINADIC=str_replace(",",".",$row['MINADIC']);
		$obj->MINTOT=str_replace(",",".",$row['MINTOT']);
		$obj->OBSERVACION=utf8_encode($row['OBSERVACION']);
		$esttsc[$i]=$obj;
		$i++;
	}
	if ($i==0) {
		$response->detail="No se encontro el estilo!";
		$response->state=false;
	}else{
		$response->esttsc=$esttsc;
		$response->state=true;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>