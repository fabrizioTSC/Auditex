<?php
	include('connection.php');
	$response=new stdClass();

	$tipaud=[];
	$i=0;
	$codtad;
	$sql="BEGIN SP_AT_SELECT_INDREPTIPAUD(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODTAD=$row['CODTAD'];
		$obj->DESTAD=utf8_encode($row['DESTAD']);
		$tipaud[$i]=$obj;
		$i++;
		if ($i==1) {
			$codtad=$row['CODTAD'];
		}
	}
	$response->tipaud=$tipaud;

	$tipindrep=[];
	$i=0;
	$sql="BEGIN SP_AT_SELECT_TIPINDREP(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODTIPIND=$row['CODTIPIND'];
		$obj->DESTIPIND=utf8_encode($row['DESTIPIND']);
		$tipindrep[$i]=$obj;
		$i++;
	}
	$response->tipindrep=$tipindrep;

	$indrepusu=[];
	$i=0;
	$sql="BEGIN SP_AT_SELECT_INDREPUSU(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODUSU=$row['CODUSU'];
		$obj->NOMUSU=utf8_encode($row['NOMUSU']);
		$obj->EMAUSU=$row['EMAILUSU'];
		$indrepusu[$i]=$obj;
		$i++;
	}
	$response->indrepusu=$indrepusu;

	$indrepdet=[];
	$i=0;
	$sql="BEGIN SP_AT_SELECT_INDREPDET(:CODTAD,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTAD', $codtad);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODUSU=$row['CODUSU'];
		$obj->CODTAD=$row['CODTAD'];
		$obj->CODTIPIND=$row['CODTIPIND'];
		$indrepdet[$i]=$obj;
		$i++;
	}
	$response->indrepdet=$indrepdet;

	$usuario=[];
	$i=0;
	$sql="BEGIN SP_AT_SELECT_USUMAIL(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODUSU=$row['CODUSU'];
		$obj->NOMUSU=utf8_encode($row['NOMUSU']);
		$obj->ALIUSU=utf8_encode($row['ALIUSU']);
		$usuario[$i]=$obj;
		$i++;
	}
	$response->usuario=$usuario;
	
	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>