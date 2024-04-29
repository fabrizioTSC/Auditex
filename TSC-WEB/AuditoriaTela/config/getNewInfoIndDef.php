<?php
	set_time_limit(240);
	include("connection.php");
	$response=new stdClass();

	$defectos=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_IND_DEFECTOS_ALL(:CODPRV,:CODCLI,:CODPRO,:OUTPUT_CUR,:NUMANIO,:NUMSEM); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	oci_bind_by_name($stmt, ':CODPRO', $_POST['codpro']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	oci_bind_by_name($stmt, ':NUMANIO', $_POST['anio']);
	oci_bind_by_name($stmt, ':NUMSEM', $_POST['semana']);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$sumtot=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODDEF=$row['CODDEF'];
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		$obj->SUMDEF=$row['SUMDEF'];
		$obj->CANMUE=$row['CANMUE'];
		$sumtot+=$row['SUMDEF'];
		$defectos[$i]=$obj;
		$i++;
	}
	$response->defectos=$defectos;
	$response->sumtot=$sumtot;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>