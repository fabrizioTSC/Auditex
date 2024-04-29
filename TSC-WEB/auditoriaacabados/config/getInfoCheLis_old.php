<?php
	include('connection.php');
	$response=new stdClass();

	$sql="begin SP_AA_VAL_EXIFIC(:CODFIC,:CONTADOR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt,':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt,':CONTADOR', $contador,40);
	$result=oci_execute($stmt);

	if ($contador==0) {
		$response->state=false;
		$response->detail="La ficha no existe";
	}else{
		$audchelis=[];
		$sql="BEGIN SP_AA_SELECT_AUDACAALL(:CODFIC,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->PARTE=$row['PARTE'];
			$obj->NUMVEZ=$row['NUMVEZ'];
			$obj->FECINIAUD=$row['FECINIAUD'];
			$obj->FECFINAUD=$row['FECFINAUD'];
			$obj->DESTLL=utf8_encode($row['DESTLL']);
			$obj->DESCEL=utf8_encode($row['DESCEL']);
			$obj->CANTIDAD=$row['CANTIDAD'];
			$obj->CODUSU=$row['CODUSU'];
			$obj->ESTADO=$row['ESTADO'];
			$obj->RESULTADO=$row['RESULTADO'];
			array_push($audchelis, $obj);
		}
		$response->audchelis=$audchelis;

		$sql="begin SP_AA_GET_CANFAL(:CODFIC,:CANFAL); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt,':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt,':CANFAL', $canfal,40);
		$result=oci_execute($stmt);
		$response->state=true;
		$response->CANFAL=$canfal;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>