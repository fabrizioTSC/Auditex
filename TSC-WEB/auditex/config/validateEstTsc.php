<?php
	include('connection.php');
	require_once '../../../TSC/models/modelo/core.modelo.php';

	$response=new stdClass();
	$objModelo 	= new CoreModelo();

	// EJECUTAMOS CARGA
	$response_sige = $objModelo->setAllSQLSIGE("uspGetSetMedidasAuditex",[4,null,$_POST['codfic'],0],"correcto");
    // echo json_encode($response);

	$sql="BEGIN SP_AT_SELECT_ESTTSCXFIC(:CODFIC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$esttsc=array();
	$i=0;
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->ESTTSC=$row['ESTTSC'];
		$esttsc[$i]=$obj;
		$i++;
	}
	if ($i>0) {
		$response->state=true;
		$response->esttsc=$esttsc;
	}else{
		$response->state=false;
		$response->detail="No hay estilos para la ficha!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>