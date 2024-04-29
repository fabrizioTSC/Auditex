<?php
	include('connection.php');
	$response=new stdClass();

	$infotela=new stdClass();
	$sql="BEGIN SP_AUDTEL_SELECT_TELA(:CODTEL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$infotela->CODTEL=$row['CODTEL'];
		$infotela->DESTEL=utf8_encode($row['DESTEL']);
		$infotela->CODTELPRV=$row['CODTELPRV'];
		$infotela->COMPOS=utf8_encode($row['COMPOS']);
		$infotela->RENDIMIENTO=utf8_encode($row['RENDIMIENTO']);
		$infotela->RUTA=utf8_encode($row['RUTA']);
	}
	$response->infotela=$infotela;

	$estdim=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_SELECT_ESTDIM(:CODTEL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODESTDIM=$row['CODESTDIM'];
		$obj->DESESTDIM=utf8_encode($row['DESESTDIM']);
		$obj->VALOR=$row['VALOR'];
		$obj->TOLERANCIA=$row['TOLERANCIA'];
		$estdim[$i]=$obj;
		$i++;
	}
	$response->estdim=$estdim;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>