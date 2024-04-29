<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AA_GET_INFOCABECERA(:CODFIC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_assoc($OUTPUT_CUR);
	$response->CLIENTE=utf8_encode($row['CLIENTE']);
	$response->PEDIDO=$row['PEDIDO'];
	$response->COLOR=$row['COLOR'];
	$response->ESTTSC=$row['ESTTSC'];
	$response->ESTCLI=$row['ESTCLI'];
	$response->TALLERCOR=utf8_encode($row['TALLERCOR']);
	$response->TALLERCOS=utf8_encode($row['TALLERCOS']);
	$response->ARTICULO=$row['ARTICULO'];
	$response->CANFIC=$row['CANFIC'];
	$response->CANACA=$row['CANACA'];
	$response->DESPRE=utf8_encode($row['DESPRE']);
	$response->TIPOMEDIDA=$row['TIPOMEDIDA'];


	$sql="BEGIN SP_AA_GET_INFOPARTIDA(:CODFIC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_assoc($OUTPUT_CUR);

	if($row){
		$response->PARTIDA=$row['PARTIDA'];
		$response->CODTEL=$row['CODTEL'];
		$response->CODPRV=$row['CODPRV'];
	}

	$dato_tela=new stdClass();
	$sql="BEGIN SP_AFC_GET_INFOPARTIDA(:CODFIC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_assoc($OUTPUT_CUR);
	$dato_tela->partida=$row['PARTIDA'];
	$dato_tela->tiptel=$row['ARTICULO'];
	$dato_tela->color=$row['COLOR'];
	$dato_tela->codtel=$row['CODTEL'];
	$dato_tela->descli=utf8_encode($row['DESCLI']);

	$sql="BEGIN SP_AFC_GET_INFOPARTIDA2(:PARTIDA,:CODTEL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':PARTIDA',$dato_tela->partida);
	oci_bind_by_name($stmt,':CODTEL',$dato_tela->codtel);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_assoc($OUTPUT_CUR);
	if($row){
		$dato_tela->codprv=$row['CODPRV'];
		$dato_tela->numvez=$row['NUMVEZ'];
		$dato_tela->parte=$row['PARTE'];
		$dato_tela->codtad=$row['CODTAD'];
	}
	$response->dato_tela=$dato_tela;

	$ruta=[];
	$sql="BEGIN SP_AA_GET_DETRUTA(:CODFIC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODETAPA=$row['CODETAPA'];
		$obj->ETAPA=$row['ETAPA'];
		array_push($ruta, $obj);
	}
	$response->ruta=$ruta;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>