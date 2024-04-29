<?php
	include('connection.php');
	$response=new stdClass();

	//$sql="UPDATE parametrosreportes set valor=".$_POST['valor']." where codtad=".$_POST['codtad']." and codran=".$_POST['codran'];		
	//$stmt=oci_parse($conn, $sql);
	//$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);

	$stmt = oci_parse($conn,'BEGIN SP_INSP_UPD_PARAMETROSREPORTES(:CODTAD, :CODRAN, :VALOR); END;');                     
	//$codtad = $_POST['codtad'];
	//$codran  = $_POST['codran'];
	//$valor = $_POST['valor'];
	oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);   
	oci_bind_by_name($stmt,':CODRAN',$_POST['codran']);   
	oci_bind_by_name($stmt,':VALOR',$_POST['valor']);   
	$result=oci_execute($stmt); 

	if ($result) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail=utf8_encode("No se pudo guardar el parámetro!");
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>