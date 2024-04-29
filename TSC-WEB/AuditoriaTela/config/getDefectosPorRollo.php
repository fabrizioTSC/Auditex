<?php
	include('connection.php');
	$response=new stdClass();

	$defectos=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_SELECT_DEFPORROL(:PARTIDA,:CODTEL,:CODPRV,:CODTAD,:NUMVEZ,:PARTE,:NUMROL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':NUMROL', $_POST['numrol']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODARE=$row['CODAREAD'];
		$obj->DESARE=utf8_encode($row['DSCAREAD']);
		$obj->CODDEF=$row['CODDEF'];
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		$obj->PESO=$row['PESO'];
		$obj->CANTIDAD=utf8_encode($row['CANTIDAD']);
		$defectos[$i]=$obj;
		$i++;
	}
	$response->defectos=$defectos;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>