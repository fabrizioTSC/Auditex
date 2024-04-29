<?php
	include('connection.php');
	$response=new stdClass();

	$infotela=new stdClass();
	$sql="BEGIN SP_AUDTEL_SELECT_TELREC(:CODTEL,:OUTPUT_CUR); END;";
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
	}
	$response->infotela=$infotela;

	$tallas=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_SELECT_TALTELREC(:CODTEL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODTEL=$row['CODTEL'];
		$obj->CODTAL=$row['CODTAL'];
		$obj->DESTAL=utf8_encode($row['DESTAL']);
		$obj->LARGO=$row['LARGO'];
		$obj->TOLLARGO=$row['TOLLARGO'];
		$obj->ALTO=$row['ALTO'];
		$obj->TOLALTO=$row['TOLALTO'];
		$obj->PESOUNI=str_replace(",",".",$row['PESOUNI']);
		$tallas[$i]=$obj;
		$i++;
	}
	$response->tallas=$tallas;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>