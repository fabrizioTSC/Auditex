<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

	function replace_null($text){
		if ($text==null || $text=="null") {
			return "";
		}else{
			return $text;
		}
	}
	// Para auditoria final de costura
	$fichas=array();
	$i=0;		
	$sql="BEGIN SP_AFC_SELECT_FICHAS(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$ficha=new stdClass();
		$ficha->CODFIC=$row['CODFIC'];
		$ficha->CANPAR=$row['CANPAR'];
		$ficha->PARTE=$row['PARTE'];
		$ficha->NUMVEZ=$row['NUMVEZ'];
		$ficha->CODAQL=$row['CODAQL'];
		$ficha->AQL=$row['AQL'];
		$ficha->CODTAD=$row['CODTAD'];
		$ficha->CODUSU=replace_null($row['CODUSU']);
		$fichas[$i]=$ficha;
		$i++;
	}
	if (oci_num_rows($stmt)==0) {			
		$response->state=false;
		$response->description="No hay fichas!";
	}else{
		$response->state=true;
		$response->fichas=$fichas;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>