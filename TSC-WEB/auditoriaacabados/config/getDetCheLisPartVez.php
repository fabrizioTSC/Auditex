<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AA_SELECT_AUDACAPARTEVEZ(:CODFIC,:PARTE,:NUMVEZ,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_assoc($OUTPUT_CUR);
	$response->PARTE=$row['PARTE'];
	$response->NUMVEZ=$row['NUMVEZ'];
	$response->FECINIAUD=$row['FECINIAUD'];
	$response->FECFINAUD=$row['FECFINAUD'];
	$response->DESTLL=utf8_encode($row['DESTLL']);
	$response->DESCEL=utf8_encode($row['DESCEL']);
	$response->CANTIDAD=$row['CANTIDAD'];
	$response->CODUSU=$row['CODUSU'];
	$response->ESTADO=$row['ESTADO'];
	$response->RESULTADO=$row['RESULTADO'];
	$response->AQL=$row['AQL'];
	$response->CANAUD=$row['CANAUD'];
	$response->CANDEFMAX=$row['CANDEFMAX'];
	$response->OBSDOC=utf8_encode($row['OBSDOC']);
	$response->OBSPRO=utf8_encode($row['OBSPRO']);

	$chelisdoc=[];
	$sql="BEGIN SP_AA_SELECT_AUDACACHKLSTDOC(:CODFIC,:PARTE,:NUMVEZ,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODCLDOC=$row['CODCLDOC'];
		$obj->DESCLDOC=utf8_encode($row['DESCLDOC']);
		$obj->VALOR=$row['VALOR'];
		array_push($chelisdoc,$obj);
	}
	$response->chelisdoc=$chelisdoc;
/*
	$chelisavi=[];
	$sql="BEGIN SP_AA_SELECT_AUDACACHKLSTAVIO(:CODFIC,:PARTE,:NUMVEZ,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODCLDOC=$row['CODCLDOC'];
		$obj->DESCLDOC=utf8_encode($row['DESCLDOC']);
		$obj->VALOR=$row['VALOR'];
		array_push($chelisavi,$obj);
	}
	$response->chelisavi=$chelisavi;*/

	$defectos=[];
	$sql="begin SP_AA_SELECT_DETCHELISDEF(:CODFIC,:PARTE,:NUMVEZ,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODDEF=$row['CODDEF'];
		$obj->DESFAM=utf8_encode($row['DSCFAMILIA']);
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		$obj->CODDEFAUX=$row['CODDEFAUX'];
		$obj->CANDEF=$row['CANDEF'];
		array_push($defectos, $obj);
	}
	$response->defectos=$defectos;

	$chelisaca=[];
	$sql="BEGIN SP_AA_SELECT_AUDACACHKLSTPRO(:CODFIC,:PARTE,:NUMVEZ,:COD,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	$cod=0;
	oci_bind_by_name($stmt,':COD',$cod);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODCLPRO=$row['CODCLPRO'];
		$obj->CODGRPCLPRO=$row['CODGRPCLPRO'];
		$obj->DESGRPCLPRO=utf8_encode($row['DESGRPCLPRO']);
		$obj->DESCLPRO=utf8_encode($row['DESCLPRO']);
		$obj->LLEVA=$row['LLEVA'];
		$obj->VALOR=$row['VALOR'];
		array_push($chelisaca,$obj);
	}
	$response->chelisaca=$chelisaca;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>