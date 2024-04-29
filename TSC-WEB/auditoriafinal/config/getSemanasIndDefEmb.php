<?php
	set_time_limit(240);
	include("connection.php");
	$response=new stdClass();

	$semanas=[];
	$i=0;
	$sql="BEGIN SP_AT_SELECT_SEMANAS_A_HOY(:ANIO,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':ANIO', $_POST['anio']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$semana=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		if ($i==0) {
			$semana=(int)$row['NUMERO_SEMANA'];
		}
		$obj=new stdClass();
		$obj->NUMERO_SEMANA=$row['NUMERO_SEMANA'];
		$obj->MIN=$row['MIN'];
		$obj->MAX=$row['MAX'];
		$semanas[$i]=$obj;
		$i++;
	}
	$response->semanas=$semanas;
	$response->semana=$semana;

	function process_percent($value){
		$value=str_replace(",",".",$value);
		if ($value[0]==".") {
			return "0".$value;
		}else{
			return $value;
		}
	}

	$defectos=[];
	$i=0;
	$sql="BEGIN SP_AF_INDVEREMP_DEFECTOS_ALL(:OUTPUT_CUR,:NUMANIO,:NUMSEM); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	oci_bind_by_name($stmt, ':NUMANIO', $_POST['anio']);
	oci_bind_by_name($stmt, ':NUMSEM', $semana);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$sumtot=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODDEF=$row['CODDEF'];
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		$obj->SUMDEF=$row['SUMDEF'];
		$obj->CANMUE=$row['CANMUE'];
		$obj->PORDEF=process_percent($row['PORDEF']);
		$defectos[$i]=$obj;
		$i++;
	}
	$response->defectos=$defectos;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>