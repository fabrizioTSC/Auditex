<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_CLACA_VAL_FICINFTEL(:CODFIC,:CONTADOR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':CONTADOR',$contador,40);
	$result=oci_execute($stmt);
	$partidaclass=new stdClass();
	if ($contador>0) {
		$sql="BEGIN SP_APNC_GET_INFOPARTIDA(:CODFIC,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$partidaclass->partida=$row['PARTIDA'];
		$partidaclass->articulo=$row['ARTICULO'];
		$partidaclass->color=$row['COLORPRENDA'];
		$partidaclass->codtel=$row['CODTEL'];
		$partidaclass->tallercos=utf8_encode($row['TALLERCOS']);
		$partidaclass->tallercor=utf8_encode($row['TALLERCOR']);
		$partidaclass->esttsc=$row['ESTTSC'];
		$partidaclass->estcli=$row['ESTCLI'];
		$partidaclass->pedido=$row['PEDIDO'];
		$partidaclass->cliente=utf8_encode($row['CLIENTE']);

		$sql="BEGIN SP_APCR_GET_INFOPARTIDA2(:PARTIDA,:CODTEL,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':PARTIDA',$partidaclass->partida);
		oci_bind_by_name($stmt,':CODTEL',$partidaclass->codtel);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$partidaclass->codprv=$row['CODPRV'];
		$partidaclass->numvez=$row['NUMVEZ'];
		$partidaclass->parte=$row['PARTE'];
		$partidaclass->codtad=$row['CODTAD'];
	}
	$response->partida=$partidaclass;

	//reutilzado
	$sql="BEGIN SP_APNC_SELECT_FICHADETALLE(:CODFIC,:CODENV,:CANTIDAD,:CANAUDTER); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':CODENV',$codenv,40);
	oci_bind_by_name($stmt,':CANTIDAD',$cantidad,40);
	oci_bind_by_name($stmt,':CANAUDTER',$canpar,40);
	$result=oci_execute($stmt);
	$ficha=new stdClass();
	$ficha->CODENV=$codenv;
	$ficha->CANTIDAD=$cantidad;
	$ficha->CANPAR=$canpar;
	$response->ficha=$ficha;

	$sql="BEGIN SP_CLACA_INSERT_FICHA(:CODFIC,:CODENV,:CODUSU,:CODTIPSER,:CANTIDAD,:CANAUDTER); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':CODENV',$codenv);
	oci_bind_by_name($stmt,':CODUSU',$_POST['codusu']);
	oci_bind_by_name($stmt,':CODTIPSER',$_POST['codtipser']);
	oci_bind_by_name($stmt,':CANTIDAD',$cantidad);
	oci_bind_by_name($stmt,':CANAUDTER',$canpar);
	$result=oci_execute($stmt);

	

	$dettal=array();
	$i=0;
	$sql="BEGIN SP_CLACA_SELECT_DETTALFIC(:CODFIC,:CODENV,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':CODENV',$codenv);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODTAL=$row['CODTAL'];
		$obj->DESTAL=utf8_encode($row['DESTAL']);
		$obj->CANPRE=$row['CANPRE'];
		$obj->CANTOT=$row['CANTOT'];
		$obj->CANAUD=$row['CANAUD'];
		$obj->CANDEF=$row['CANDEF'];
		$dettal[$i]=$obj;
		$i++;
	}
	$response->dettal=$dettal;

	$codtad=$_POST['codtad'];
	$numvez=$_POST['numvez'];
	$parte=$_POST['parte'];
	$sql="BEGIN SP_CLACA_SELECT_FICHA(:CODFIC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_assoc($OUTPUT_CUR);
	$obj=new stdClass();
	$obj->CODTAD=$row['CODTAD'];
	$obj->NUMVEZ=$row['NUMVEZ'];
	$obj->PARTE=$row['PARTE'];
	$obj->FECINIAUD=$row['FECINIAUD'];
	$obj->ESTADO=$row['ESTADO'];
	$obj->OBSDOC=utf8_encode($row['OBSDOC']);
	$obj->OBSFICPRO=utf8_encode($row['OBSFICPRO']);
	$obj->OBSMED=utf8_encode($row['OBSMED']);
	$obj->RESDOC=$row['RESDOC'];
	$obj->RESFICPRO=$row['RESFICPRO'];
	$obj->RESMED=$row['RESMED'];
	$obj->OBSREV=utf8_encode($row['OBSREV']);
	$obj->HORARA=$row['HORARA'];
	$obj->NUMVEZFT=$row['NUMVEZFT'];
	$response->detficaud=$obj;
	if ($row['ESTADO']=="T") {
		$response->close=true;
	}
	$maxform=1;
	if ($obj->RESDOC=="A") {
		$maxform=2;
		if ($obj->RESFICPRO=="A") {
			$maxform=3;
		}
	}

	$rutatela=[];
	$i=0;
	$sql="BEGIN SP_CLC_GET_DETRUTA(:CODFIC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODETAPA=$row['CODETAPA'];
		$obj->ETAPA=utf8_encode($row['ETAPA']);
		$rutatela[$i]=$obj;
		$i++;
	}
	$response->rutatela=$rutatela;
	
	$response->state=true;

	$chkblo1=array();
	$i=0;
	$tela=new stdClass();
	$sql="BEGIN SP_CLACA_SELECT_CHKBLO1(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODDOC=$row['CODDOC'];
		$obj->DESDOC=utf8_encode($row['DESDOC']);
		$obj->VALIDAR=$row['VALIDAR'];
		$obj->EDITABLE=$row['EDITABLE'];
		$chkblo1[$i]=$obj;
		$i++;
	}
	$response->chkblo1=$chkblo1;

	$chkblosave=array();
	$i=0;
	$sql="BEGIN SP_CLACA_SELECT_CHEDOCGUA(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':CODTAD', $codtad);
	oci_bind_by_name($stmt, ':NUMVEZ', $numvez);
	oci_bind_by_name($stmt, ':PARTE', $parte);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODDOC=$row['CODDOC'];
		$obj->RESDOC=$row['RESDOC'];
		$chkblosave[$i]=$obj;
		$i++;
	}
	$response->chkblosave=$chkblosave;

	$chkblo2=array();
	$i=0;
	$sql="BEGIN SP_CLACA_SELECT_CHKBLO2(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODFICPRO=$row['CODFICPRO'];
		$obj->DESFICPRO=utf8_encode($row['DESFICPRO']);
		$obj->VALIDAR=$row['VALIDAR'];
		$obj->EDITABLE=$row['EDITABLE'];
		$chkblo2[$i]=$obj;
		$i++;
	}
	$response->chkblo2=$chkblo2;

	$chkblosave2=array();
	$i=0;
	$tela=new stdClass();
	$sql="BEGIN SP_CLACA_SELECT_CHEFICPROGUA(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':CODTAD', $codtad);
	oci_bind_by_name($stmt, ':NUMVEZ', $numvez);
	oci_bind_by_name($stmt, ':PARTE', $parte);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODFICPRO=$row['CODFICPRO'];
		$obj->RESFICPRO=$row['RESFICPRO'];
		$chkblosave2[$i]=$obj;
		$i++;
	}
	$response->chkblosave2=$chkblosave2;

	$chkblo3=array();
	$i=0;
	$tela=new stdClass();
	$sql="BEGIN SP_CLACA_SELECT_CHKBLO3(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODMED=$row['CODMED'];
		$obj->DESMED=utf8_encode($row['DESMED']);
		$obj->VALIDAR=$row['VALIDAR'];
		$obj->EDITABLE=$row['EDITABLE'];
		$obj->RUTABASE=$row['RUTABASE'];
		$chkblo3[$i]=$obj;
		$i++;
	}
	$response->chkblo3=$chkblo3;

	$chkblosave3=array();
	$i=0;
	$tela=new stdClass();
	$sql="BEGIN SP_CLACA_SELECT_CHEMEDGUA(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':CODTAD', $codtad);
	oci_bind_by_name($stmt, ':NUMVEZ', $numvez);
	oci_bind_by_name($stmt, ':PARTE', $parte);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$end_blo2=true;
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODMED=$row['CODMED'];
		$obj->RESMED=$row['RESMED'];
		$chkblosave3[$i]=$obj;
		$i++;
	}
	$response->chkblosave3=$chkblosave3;

	$response->maxform=$maxform;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>