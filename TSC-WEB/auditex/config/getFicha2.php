<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	
	$sql="BEGIN SP_AT_SELECT_FICHA_N(:CODFIC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$fichas=[];
	$i=0;
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$ficha=new stdClass();
		$ficha->CODFIC=$row['CODFIC'];
		$ficha->AQL=$row['AQL'];
		$ficha->CODAQL=$row['CODAQL'];
		$ficha->CODTAD=$row['CODTAD'];
		$ficha->NUMVEZ=$row['NUMVEZ'];
		$ficha->PARTE=$row['PARTE'];
		$ficha->CODUSU=$row['CODUSU'];
		$ficha->CANPAR=$row['CANPAR'];
		$ficha->FECINIAUD=$row['FECINIAUD'];
		$ficha->CANTIDAD=$row['CANTOT'];
		$ficha->CANPRE=$row['CANTOT'];
		$ficha->CANPAR=$row['CANPAR'];
		$ficha->COMENTARIOS=utf8_encode($row['COMENTARIOS']);
		$ficha->CANAUD=$row['CANAUD'];
		$ficha->RESULTADO=$row['RESULTADO'];		
		
		$fichas[$i]=$ficha;
		$i++;
	}
	if (oci_num_rows($OUTPUT_CUR)==0) {
		$response->state=false;
		$error->detail="No existe ficha!";
		$response->error=$error;
		$response->fichas=$fichas;
	}else{
		$response->state=true;
		$response->fichas=$fichas;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>