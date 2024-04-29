<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_APCR_SELECT_DETFIC(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
	oci_bind_by_name($stmt,':CODAQL',$_POST['codaql']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_assoc($OUTPUT_CUR);
	$ficha=new stdClass();
	$ficha->ESTADO=$row['ESTADO'];
	$ficha->DESTLL=utf8_encode($row['DESTLL']);
	$ficha->CANPRE=$row['CANPRE'];
	$ficha->CANPAR=$row['CANPAR'];
	$ficha->COMENTARIOS=utf8_encode($row['COMENTARIOS']);
	$ficha->AQL=$row['AQL'];
	$ficha->CANAUD=$row['CANAUD'];
	$ficha->RESULTADO=$row['RESULTADO'];
	$response->ficha=$ficha;		
	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>