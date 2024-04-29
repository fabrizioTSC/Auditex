<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

	$sql="BEGIN SP_AT_SELECT_VALUSUFICAUD(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL,:CODUSU,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
	oci_bind_by_name($stmt,':CODAQL',$_POST['codaql']);
	oci_bind_by_name($stmt,':CODUSU',$_POST['usuario']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	if(oci_num_rows($OUTPUT_CUR)==0){
		$sql="BEGIN SP_AT_UPDATE_FICHAAUDITORIA2(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL,:CODUSU); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
		oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
		oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
		oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
		oci_bind_by_name($stmt,':CODAQL',$_POST['codaql']);
		oci_bind_by_name($stmt,':CODUSU',$_POST['usuario']);
		$result=oci_execute($stmt);
	}

	$sql="BEGIN SP_AT_UPDATE_AUDDETDEF(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODOPE,:CODDEF,:CANDEF,:ESTADO); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
	oci_bind_by_name($stmt,':CODOPE',$_POST['codope']);
	oci_bind_by_name($stmt,':CODDEF',$_POST['coddef']);
	oci_bind_by_name($stmt,':CANDEF',$_POST['candef']);
	oci_bind_by_name($stmt,':ESTADO',$estado,40);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->description="Defecto actualizado!";
	}else{
		$response->state=false;
		$error->description="No se pudo actualizar defecto!";
		$response->error=$error;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>