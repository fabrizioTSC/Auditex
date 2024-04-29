<?php
	include('connection.php');
	$response=new stdClass();

	$anios=[];
	$i=0;	
	$stmt = oci_parse($conn,'BEGIN SP_INSP_SELECT_ANITUR(:OUTPUT_CUR); END;');
	$OUTPUT_CUR = oci_new_cursor($conn);
	oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);   
	$result=oci_execute($stmt); 
	oci_execute($OUTPUT_CUR);
	while ($row = oci_fetch_assoc($OUTPUT_CUR)) {		
		$obj=new stdClass();
		$obj->ANIO=$row['ANIOS'];
		$anios[$i]=$obj;
		if($i==0){
			$anio=$row['ANIOS'];
		}
		$i++;
	}
	$response->anios=$anios;

	$semanas=[];
	$i=0;	
	$stmt = oci_parse($conn,'BEGIN SP_INSP_SELECT_SEMTUR(:ANIO,:OUTPUT_CUR); END;');
	oci_bind_by_name($stmt,":ANIO", $anio);
	$OUTPUT_CUR = oci_new_cursor($conn);
	oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);   
	$result=oci_execute($stmt); 
	oci_execute($OUTPUT_CUR);
	while ($row = oci_fetch_assoc($OUTPUT_CUR)) {		
		$obj=new stdClass();
		$obj->SEMANA=$row['SEMANA'];
		$semanas[$i]=$obj;
		if($i==0){
			$semana=$row['SEMANA'];
		}
		$i++;
	}
	$response->semanas=$semanas;

	$meses=[];
	$i=0;	
	$stmt = oci_parse($conn,'BEGIN SP_INSP_SELECT_MESTUR(:ANIO,:OUTPUT_CUR); END;');
	oci_bind_by_name($stmt,":ANIO", $anio);
	$OUTPUT_CUR = oci_new_cursor($conn);
	oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);   
	$result=oci_execute($stmt); 
	oci_execute($OUTPUT_CUR);
	while ($row = oci_fetch_assoc($OUTPUT_CUR)) {		
		$obj=new stdClass();
		$obj->MES=$row['MES'];
		$meses[$i]=$obj;
		if($i==0){
			$mes=$row['MES'];
		}
		$i++;
	}
	$response->meses=$meses;

	$response->anio=$anio;
	$response->mes=$mes;
	$response->semana=$semana;
	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>