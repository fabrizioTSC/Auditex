<?php
	include('connection.php');
	$response=new stdClass();

	$infoprv=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_SELECT_INFTELDATCSV(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODDAT=$row['CODDATA'];
		$obj->DESDAT=utf8_encode($row['DESDATA']);
		$obj->CODTEL=$row['CODTEL'];
		$obj->CODPRV=$row['CODPRV'];
		$obj->DESTEL=$row['DESTEL'];
		$obj->COMFIN=$row['COMFIN'];
		$infoprv[$i]=$obj;
		$i++;
	}
	$response->infoprv=$infoprv;

	$infoestdim=[];
	$i=0;
	$estdim=[];
	$l=0;
	$sql="BEGIN SP_AUDTEL_SELECT_DATCSVESTDIM(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$codestdim=0;
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODESTDIM=$row['CODESTDIM'];
		$obj->DESESTDIM=utf8_encode($row['DESESTDIM']);
		$obj->CODDAT=$row['CODDATA'];		
		$obj->VALOR=$row['VALOR'];
		$obj->TOLERANCIA=$row['TOLERANCIA'];
		$infoestdim[$i]=$obj;
		$i++;
		if ($codestdim!=$row['CODESTDIM']) {
			$codestdim=$row['CODESTDIM'];
			$estdim[$l]=$row['CODESTDIM'];
			$l++;
		}
	}
	$response->infoestdim=$infoestdim;
	$response->estdim=$estdim;
	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>