<?php
	ini_set('max_execution_time', 120);
	include('connection.php');
	$response=new stdClass();
	
	$sql="BEGIN SP_AFC_VAL_FICINFTEL(:CODFIC,:CONTADOR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':CONTADOR',$contador,40);
	$result=oci_execute($stmt);
	$partidaclass=new stdClass();
	if ($contador>0) {	
		$sql="BEGIN SP_AFC_GET_INFOPARTIDA(:CODFIC,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$partidaclass->partida=utf8_encode($row['PARTIDA']);

		// $partidaclass->tiptel=utf8_encode($row['ARTICULO']);
		$partidaclass->tiptel=$row['ARTICULO'];


		$partidaclass->color=utf8_encode($row['COLOR']);
		$partidaclass->codtel=$row['CODTEL'];
		$partidaclass->DESTLL=utf8_encode($row['DESTLL']);

		$sql="BEGIN SP_AFC_GET_INFOPARTIDA2(:PARTIDA,:CODTEL,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':PARTIDA',$partidaclass->partida);
		oci_bind_by_name($stmt,':CODTEL',$partidaclass->codtel);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);

		if($row){
			$partidaclass->codprv=$row['CODPRV'];
			$partidaclass->numvez=$row['NUMVEZ'];
			$partidaclass->parte=$row['PARTE'];
			$partidaclass->codtad=$row['CODTAD'];
		}
	}
	$response->partida=$partidaclass;

	$fichas				=	array();
	$defectos			=	array();
	$operaciones		=	array();
	$fichatallas		=	array();
	$defectosPasados	=	array();
	$i=0;

	// $sql="BEGIN SP_AT_SELECT_FICHAXTALLER_V2(:CODTLL,:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL,:OUTPUT_CUR); END;";
	$sql="BEGIN SP_AT_SELECT_FICHAXTALLER_V2(:CODTLL,:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL,:TIPOAUDITORIA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODTLL',$_POST['codtll']);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
	oci_bind_by_name($stmt,':CODAQL',$_POST['codaql']);

	// TIPO AUDITORIA
	oci_bind_by_name($stmt,':TIPOAUDITORIA',$_POST['tipoauditoria']);

	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$ficha=new stdClass();
		$ficha->CANAUD=$row['CANAUD'];
		$ficha->CANPRE=$row['CANPRE'];
		$ficha->CANDEFMAX=$row['CANDEFMAX'];
		$ficha->CANPAR=$row['CANPAR'];
		$ficha->DESTLL=utf8_encode($row['DESTLL']);
		$ficha->AQL=$row['AQL'];
		$fichas[$i]=$ficha;
		$i++;
	}

	$data=new stdClass();
	$sql="BEGIN SP_AFC_GET_INFOPARTIDA(:CODFIC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$data->DESCLI=utf8_encode($row['DESCLI']);
	}		
	$response->data=$data;

	if (oci_num_rows($OUTPUT_CUR)==0) {			
		$response->state=false;
		$response->description="No hay fichas para el taller";
	}else{
		/* FICHA TALLA */
		$sql="BEGIN SP_AT_SELECT_FICHATALLAS(:CODFIC,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$fichatalla=new stdClass();
			$fichatalla->CANPRE=$row['CANPRE'];
			$fichatalla->DESTAL=utf8_encode($row['DESTAL']);
			array_push($fichatallas,$fichatalla);
		}
		/* DEFECTOS */
		$sql="BEGIN SP_AT_SELECT_DEFECTOS(:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$defecto=new stdClass();
			$defecto->coddef=$row['CODDEF'];
			// $defecto->desdef=utf8_encode($row['DESDEF']);
			$defecto->desdef = $row['DESDEF'];
			array_push($defectos,$defecto);
		}
		/* OPERACIONES */
		$sql="BEGIN SP_AT_SELECT_OPER_ESP(:FICHA,:PARTE,:VEZ,:TIPOAUDITORIA,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);

		// AGREGADOS
		oci_bind_by_name($stmt,':FICHA',$_POST['codfic']);
		oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
		oci_bind_by_name($stmt,':VEZ',$_POST['numvez']);
		oci_bind_by_name($stmt,':TIPOAUDITORIA',$_POST['tipoauditoria']);

		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){

			$defecto=new stdClass();
			$defecto->codope=$row['CODOPE'];
			// $defecto->desope=utf8_encode($row['DESOPE']);
			$defecto->desope	=	$row['DESOPE'];

			array_push($operaciones,$defecto);
		}
		/* DEFECTOS PASADOS */
		// $sql="BEGIN SP_AT_SELECT_AUDDETDEF(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:OUTPUT_CUR); END;";
		$sql="BEGIN SP_AT_SELECT_AUDDETDEF_V2(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:TIPOAUDITORIA,:OUTPUT_CUR); END;";

		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
		oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
		oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
		oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);

		// AGREGADO
		oci_bind_by_name($stmt,':TIPOAUDITORIA',$_POST['tipoauditoria']);

		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$defecto=new stdClass();
			$defecto->CODDEF=$row['CODDEF'];

			// $defecto->DESDEF=utf8_encode($row['DESDEF']);
			$defecto->DESDEF=$row['DESDEF'];
			$defecto->CODOPE=$row['CODOPE'];
			// $defecto->DESOPE=utf8_encode($row['DESOPE']);
			$defecto->DESOPE= $row['DESOPE'];
			$defecto->CANDEF=$row['CANDEF'];
			array_push($defectosPasados,$defecto);
		}
		$response->state=true;
		$response->fichas=$fichas;
		$response->defectos=$defectos;
		$response->operaciones=$operaciones;
		$response->fichatallas=$fichatallas;
		$response->defectosPasados=$defectosPasados;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>