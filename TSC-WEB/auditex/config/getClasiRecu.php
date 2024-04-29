<?php
	include('connection.php');
	$response=new stdClass();

	$i=0;
	$clarec=array();
	$total=0;
	$sql="BEGIN SP_AT_SELECT_CLAREC(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$operador=new stdClass();
		$operador->CODCLAREC=$row['CODCLAREC'];
		$operador->DESCLAREC=utf8_encode($row['DESCLAREC']);

		$sql="BEGIN SP_AT_SELECT_CPXFICAUDCLAREC(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODCLAREC,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
		oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
		oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
		oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
		oci_bind_by_name($stmt,':CODCLAREC',$row['CODCLAREC']);
		$OUTPUT_CUR2=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR2,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR2);
		$row2=oci_fetch_assoc($OUTPUT_CUR2);

		if($row2){
			if ($row2['CANPRE']==null) {
				$operador->CANPRE=0;
			}else{
				$operador->CANPRE=$row2['CANPRE'];
				$total+=(int)$row2['CANPRE'];
			}

			$operador->OBSERVACION = $row2['OBSERVACION'] == null ? "" : $row2['OBSERVACION'];


		}		

		$clarec[$i]=$operador;
		$i++;
	}
	$response->clarec=$clarec;
	$response->total=$total;

	$sql="BEGIN SP_AT_SELECT_FICAUDREC(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_assoc($OUTPUT_CUR);

	if($row){
		$response->fechaReg=$row['FECREG'];
	}

	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>