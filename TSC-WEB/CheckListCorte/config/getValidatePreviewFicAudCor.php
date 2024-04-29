<?php

	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();


	$hilo = $_POST['hilo']  == "vacio" ? null : $_POST['hilo'];
	$travez = $_POST['travez']  == "vacio" ? null : $_POST['travez'];
	$largmanga = $_POST['largmanga']  == "vacio" ? null : $_POST['largmanga'];


	//////////// COMENTADO POR EL MOMENTO
	$sql="BEGIN SP_AFC_SELECT_PREDETFICMED_J(:CODFIC,:HILO,:TRAVEZ,:LARGMANGA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':HILO', $hilo);
	oci_bind_by_name($stmt, ':TRAVEZ', $travez);
	oci_bind_by_name($stmt, ':LARGMANGA', $largmanga);

	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$detalle=[];
	$i=0;
	$numpre=0;
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->NUMPRE=$row['NUMPRE'];
		$obj->VALOR=$row['VALOR'];
		$obj->CODTAL=$row['CODTAL'];
		$obj->CODMED=$row['CODMED'];
		$obj->TOLVAL=$row['TOLVAL'];
		$obj->DESMEDCOR=utf8_encode($row['DESMEDCOR']);
		$obj->DESMED=utf8_encode($row['DESMED']);
		$detalle[$i]=$obj;
		$i++;
		if((int)$row['NUMPRE']>$numpre){
			$numpre=$row['NUMPRE'];
		}
	}
	$response->detalle=$detalle;
	$response->numpre=$numpre;

	if (oci_num_rows($stmt)>0) {
		$sql="BEGIN SP_AFC_SELECT_PREDETTALFIC_J(:CODFIC,:HILO,:TRAVEZ,:LARGMANGA,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':HILO', $hilo);
		oci_bind_by_name($stmt, ':TRAVEZ', $travez);
		oci_bind_by_name($stmt, ':LARGMANGA', $largmanga);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$talla=[];
		$i=0;
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODTAL=$row['CODTAL'];
			$obj->DESTAL=utf8_encode($row['DESTAL']);
			$talla[$i]=$obj;
			$i++;
		}
		$response->talla=$talla;

		$sql="BEGIN SP_AFC_SELECT_PREDETTAL_J(:CODFIC,:HILO,:TRAVEZ,:LARGMANGA,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':HILO', $hilo);
		oci_bind_by_name($stmt, ':TRAVEZ', $travez);
		oci_bind_by_name($stmt, ':LARGMANGA', $largmanga);

		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$detalletalla=[];
		$i=0;
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODMED=$row['CODMED'];
			$obj->CODTAL=$row['CODTAL'];
			$obj->MEDIDA=utf8_encode($row['MEDIDA']);
			$obj->DESMED=utf8_encode($row['DESMED']);
			$detalletalla[$i]=$obj;
			$i++;
		}
		$response->detalletalla=$detalletalla;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>