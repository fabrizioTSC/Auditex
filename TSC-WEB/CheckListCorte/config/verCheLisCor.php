<?php
	include('connection.php');
	$response=new stdClass();
	
		$partida=new stdClass();

		$sql="BEGIN SP_GEN_SELECT_NOMCEL(:CODFIC,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$partida->DESCEL=utf8_encode($row['DESTLL']);
		
		$sql="BEGIN SP_CLC_SELECT_INFFIC(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$partida->DESTLL=utf8_encode($row['DESTLL']);
			$partida->PEDIDO=$row['PEDIDO'];
			$partida->ESTTSC=$row['ESTTSC'];
			$partida->ESTCLI=$row['ESTCLI'];
			$partida->DESCLI=utf8_encode($row['DESCLI']);
			$partida->CANPAR=$row['CANPAR'];
			$partida->OBSDOC=utf8_encode($row['OBSDOC']);
			$partida->OBSTIZ=utf8_encode($row['OBSTIZ']);
			$partida->OBSTEN=utf8_encode($row['OBSTEN']);
			$partida->RESDOC=$row['RESDOC'];
			$partida->RESTIZ=$row['RESTIZ'];
			$partida->RESTEN=$row['RESTEN'];
		}
		$response->state=true;
		$response->partida=$partida;
		$maxform=1;
		if ($partida->RESDOC=="A") {
			$maxform=2;
			if ($partida->RESTIZ=="A") {
				$maxform=3;
				/*if ($partida->RESTEN=="A") {
					$maxform=4;
				}*/
			}
		}

		$tela=new stdClass();
		$sql="BEGIN SP_CLC_SELECT_PARTIDACLC(:CODFIC,:PARTIDA,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$tela->CODTEL=$row['CODTEL'];
			$tela->COLOR=$row['COLOR'];
			$tela->ARTICULO=utf8_encode($row['ARTICULO']);
		}
		$response->tela=$tela;

		$link=new stdClass();
		$sql="BEGIN SP_CLC_GET_INFOPARTIDA(:PARTIDA,:CODTEL,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
		oci_bind_by_name($stmt, ':CODTEL', $tela->CODTEL);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$link->CODPRV=$row['CODPRV'];
			$link->NUMVEZ=$row['NUMVEZ'];
			$link->PARTE=$row['PARTE'];
			$link->CODTAD=$row['CODTAD'];
		}
		$response->link=$link;

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

		$chkblo1=array();
		$i=0;
		$tela=new stdClass();
		$sql="BEGIN SP_CLC_SELECT_CHKBLO1(:OUTPUT_CUR); END;";
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
			$obj->REPOSO=$row['REPOSO'];
			$chkblo1[$i]=$obj;
			$i++;
		}
		$response->chkblo1=$chkblo1;

		$chkblosave=array();
		$i=0;
		$sql="BEGIN SP_CLC_SELECT_CHEDOCGUA(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODDOC=$row['CODDOC'];
			$obj->RESDOC=$row['RESDOC'];
			$obj->REPOSO=str_replace(",",".",$row['REPOSO']);
			$chkblosave[$i]=$obj;
			$i++;
		}
		$response->chkblosave=$chkblosave;

		$chkblo2=array();
		$i=0;
		$sql="BEGIN SP_CLC_SELECT_CHKBLO2(:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODTIZ=$row['CODTIZ'];
			$obj->DESTIZ=utf8_encode($row['DESTIZ']);
			$obj->VALIDAR=$row['VALIDAR'];
			$obj->EDITABLE=$row['EDITABLE'];
			$chkblo2[$i]=$obj;
			$i++;
		}
		$response->chkblo2=$chkblo2;

		$chkblosave2=array();
		$i=0;
		$tela=new stdClass();
		$sql="BEGIN SP_CLC_SELECT_CHETIZGUA(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$end_blo2=true;
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODTIZ=$row['CODTIZ'];
			$obj->RESTIZ=$row['RESTIZ'];
			$obj->VECES=$row['VECES'];
			$chkblosave2[$i]=$obj;
			$i++;
		}
		$response->chkblosave2=$chkblosave2;

		$chkblo3=array();
		$i=0;
		$tela=new stdClass();
		$sql="BEGIN SP_CLC_SELECT_CHKBLO3(:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODTEN=$row['CODTEN'];
			$obj->DESTEN=utf8_encode($row['DESTEN']);
			$obj->VALIDAR=$row['VALIDAR'];
			$obj->EDITABLE=$row['EDITABLE'];
			$chkblo3[$i]=$obj;
			$i++;
		}
		$response->chkblo3=$chkblo3;

		$chkblosave3=array();
		$i=0;
		$tela=new stdClass();
		$sql="BEGIN SP_CLC_SELECT_CHETENGUA(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$end_blo2=true;
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODTEN=$row['CODTEN'];
			$obj->RESTEN=$row['RESTEN'];
			$chkblosave3[$i]=$obj;
			$i++;
		}
		$response->chkblosave3=$chkblosave3;

		$response->maxform=$maxform;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>