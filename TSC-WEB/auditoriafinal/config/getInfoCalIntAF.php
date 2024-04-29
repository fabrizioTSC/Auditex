<?php
	include('connection.php');
	$response=new stdClass();

	$sql="begin SP_AF_SELECT_AUDFINCALIDAD(:PEDIDO,:DSCCOL,:PARTE,:NUMVEZ,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt,':PEDIDO', $_POST['pedido']);
	oci_bind_by_name($stmt,':DSCCOL', $_POST['dsccol']);
	$parte=1;
	oci_bind_by_name($stmt,':PARTE', $parte);
	$numvez=$_POST['numvez'];
	oci_bind_by_name($stmt,':NUMVEZ', $numvez);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_assoc($OUTPUT_CUR);
	$datos=new stdClass();
	$datos->DESCLI=utf8_encode($row['DESCLI']);
	$datos->PO=$row['PO'];	
	$datos->ESTTSC=$row['ESTTSC'];
	$datos->ESTCLI=$row['ESTCLI'];	
	$datos->PRENDA=utf8_encode($row['PRENDA']);
	$datos->CODUSU=$row['CODUSU'];	
	$datos->FECINIAUD=$row['FECINIAUD'];
	$datos->FECFINAUD=$row['FECFINAUD'];	
	$datos->CANTIDAD=$row['CANTIDAD'];
	$datos->ESTADO=$row['ESTADO'];	
	$datos->RESULTADO=$row['RESULTADO'];
	$datos->RESULTADOL=$row['RESULTADOL'];
	$datos->AQL=$row['AQL'];	
	$datos->CANAUD=$row['CANAUD'];
	$datos->CANDEFMAX=$row['CANDEFMAX'];	
	$datos->COMENTARIOS=utf8_encode($row['COMENTARIOS']);
	$datos->PARTE=$row['PARTE'];	
	$datos->NUMVEZ=$row['NUMVEZ'];
	$response->datos=$datos;
	$numvez=$row['NUMVEZ'];

	if ($row['FECINIAUD']!=null) {
		$veces=[];
		$sql="begin SP_AUDFIN_SELECT_CALIDADVEZ(:PEDIDO,:DSCCOL,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
		oci_bind_by_name($stmt, ':DSCCOL', $_POST['dsccol']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->PARTE=$row['PARTE'];
			$obj->NUMVEZ=$row['NUMVEZ'];
			$obj->CODUSU=$row['CODUSU'];
			$obj->FECINIAUD=$row['FECINIAUD'];
			$obj->FECFINAUD=$row['FECFINAUD'];
			$obj->CANTIDAD=$row['CANTIDAD'];
			$obj->CANAUD=$row['CANAUD'];
			$obj->CANDEFMAX=$row['CANDEFMAX'];
			$obj->AQL=$row['AQL'];
			$obj->ESTADO=$row['ESTADO'];
			$obj->RESULTADO=$row['RESULTADO'];
			$obj->ESTADOTXT=$row['ESTADOTXT'];
			$obj->RESULTADOTXT=$row['RESULTADOTXT'];
			array_push($veces, $obj);
		}
		$response->veces=$veces;

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
	}

	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>