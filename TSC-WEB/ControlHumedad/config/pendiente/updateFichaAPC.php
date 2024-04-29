<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

	$sql="BEGIN SP_APCR_SELECT_FICINIAUD(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt,':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt,':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt,':CODAQL', $_POST['codaql']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$rowAux=oci_fetch_assoc($OUTPUT_CUR);

	if(is_null($rowAux['CODUSU'])){
		$sql="BEGIN SP_APCR_UPDATE_FICINIAUD(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL,:TIPAUD,:NEWCAN); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt,':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt,':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt,':PARTE', $_POST['parte']);
		oci_bind_by_name($stmt,':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt,':CODAQL', $_POST['codaql']);
		oci_bind_by_name($stmt,':TIPAUD', $_POST['tipaud']);
		oci_bind_by_name($stmt,':NEWCAN', $_POST['newnumero']);
		$result=oci_execute($stmt);		
		if($result){			
			$response->state=true;
			$response->description="Éxito";
		}else{
			$response->state=false;
			$error->code=2;
			$error->description="No se actualizó ficha.";
			$response->err=$error;
		}
	}else{
		if($rowAux['CODUSU']==$_POST['codusu']){
			$response->state=true;
			$response->description="Éxito";
		}else{
			$response->state=false;
			$response->row=$rowAux;
			$error->code=5;
			$error->description="La ficha ya fue tomada por otro auditor!";
			$response->err=$error;
		}
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>