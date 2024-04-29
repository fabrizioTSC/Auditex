<?php
	include('connection.php');
	$response=new stdClass();

	$parte=$_POST['parte'];
	$numvez=$_POST['numvez'];

	$defectos=[];
	$sql="begin SP_AF_SELECT_DETCALINT(:PEDIDO,:DSCCOL,:PARTE,:NUMVEZ,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
	oci_bind_by_name($stmt, ':DSCCOL', $_POST['dsccol']);
	oci_bind_by_name($stmt, ':PARTE', $parte);
	oci_bind_by_name($stmt, ':NUMVEZ', $numvez);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODDEF=$row['CODDEF'];
		$obj->DESFAM=utf8_encode($row['DSCFAMILIA']);
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		$obj->CODDEFAUX=$row['CODDEFAUX'];
		$obj->CANDEF=$row['CANDEF'];
		array_push($defectos, $obj);
	}
	$response->defectos=$defectos;

	$fotos=[];
	$sql="begin SP_AF_SELECT_IMGCALINT(:PEDIDO,:DSCCOL,:PARTE,:NUMVEZ,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
	oci_bind_by_name($stmt, ':DSCCOL', $_POST['dsccol']);
	oci_bind_by_name($stmt, ':PARTE', $parte);
	oci_bind_by_name($stmt, ':NUMVEZ', $numvez);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->RUTIMA=$row['RUTIMA'];
		$obj->OBSIMAGEN=utf8_encode($row['OBSIMAGEN']);
		array_push($fotos, $obj);
	}
	$response->fotos=$fotos;

	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>