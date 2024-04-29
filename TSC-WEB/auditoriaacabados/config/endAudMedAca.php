<?php

	include('connection.php');
	$response=new stdClass();

/*
	$sql="BEGIN SP_AA_UPDATE_ENDAUDMEDACA(:CODFIC,:VALIDAR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':VALIDAR', $validar,40);
	$result=oci_execute($stmt);
	if ($validar==0) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="Debe completar todas las medidas para terminar la auditoria";
	}
	*/

	$sql="BEGIN SP_AA_SELECT_TALXPCVAL(:CODFIC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$ar_tallas=[];
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODTAL=$row['CODTAL'];
		$obj->DESTAL=$row['DESTAL'];
		array_push($ar_tallas,$obj);
	}

	if (intval($_POST['cantidad'])>=2) {
		$val_talla=true;
		$val_prenda=true;
		$i=0;
		while ($val_talla && $val_prenda && $i<sizeof($ar_tallas)) { 
			$j=2;
			while ($val_prenda && $j<intval($_POST['cantidad'])+1) { 
				$sql="BEGIN SP_AA_VERTALPRE_AUDMEDFIN(:CODFIC,:CODTAL,:NUMPRE,:VALIDAR); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
				oci_bind_by_name($stmt, ':CODTAL', $ar_tallas[$i]->CODTAL);
				oci_bind_by_name($stmt, ':NUMPRE', $j);
				oci_bind_by_name($stmt, ':VALIDAR', $validar,40);
				$result=oci_execute($stmt);
				if ($validar==0) {
					$val_prenda=false;
				}
				$j++;
			}
			$i++;
		}
	}

	if (!$val_prenda) {
		$response->detail="Debe seleccionar una medida para la talla ".$ar_tallas[$i-1]->DESTAL." - prenda ".($j-1);
		$response->state=false;
	}else{
		$sql="BEGIN SP_AA_VERTALPRE_AUDMEDFIN(:CODFIC,:CODTAL,:NUMPRE,:VALIDAR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		$i=0;
		oci_bind_by_name($stmt, ':CODTAL', $ar_tallas[$i]->CODTAL);
		$j=1;
		oci_bind_by_name($stmt, ':NUMPRE', $j);
		oci_bind_by_name($stmt, ':VALIDAR', $validar,40);
		$result=oci_execute($stmt);
		if ($validar==0) {
			$response->detail="Debe completar todas las medidas de la prenda 1";
			$response->state=false;
		}else{
			$response->state=true;
		}
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);