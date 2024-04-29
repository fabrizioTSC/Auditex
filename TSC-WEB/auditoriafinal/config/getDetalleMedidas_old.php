<?php

	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AF_INSERT_MEDFINCAB(:PEDIDO,:DESCOL,:CODUSU,:NUMPRE,:NUMPREADI); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
	oci_bind_by_name($stmt, ':DESCOL', $_POST['dsccol']);
	session_start();
	oci_bind_by_name($stmt, ':CODUSU', $_SESSION['user']);
	oci_bind_by_name($stmt, ':NUMPRE', $_POST['cantidad']);
	oci_bind_by_name($stmt, ':NUMPREADI', $_POST['canadi']);
	$result=oci_execute($stmt);

	/*FALTA VERIFICAR ALGO DENTRO*/
	$sql="BEGIN SP_AF_INSERT_FICCORMEDFIN(:PEDIDO,:DESCOL,:ESTTSC,:NUMPRE); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
	oci_bind_by_name($stmt, ':DESCOL', $_POST['dsccol']);
	oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
	$totnumpre=intval($_POST['cantidad'])+intval($_POST['canadi']);
	oci_bind_by_name($stmt, ':NUMPRE', $totnumpre);
	$result=oci_execute($stmt);

	if ($result) {
		$sql="BEGIN SP_AF_SELECT_AUDMEDFIN(:PEDIDO,:DESCOL,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
		oci_bind_by_name($stmt, ':DESCOL', $_POST['dsccol']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODUSU=$row['CODUSU'];
			$obj->ESTADO=$row['ESTADO'];
			$obj->RESULTADO=$row['RESULTADO'];
			$obj->FECINIAUD=$row['FECINIAUD'];
			$obj->FECFINAUD=$row['FECFINAUD'];
			$obj->COMENTARIOS=utf8_encode($row['COMENTARIOS']);
			$response->datos=$obj;
		}

		$ant_nom="";
		$cont=0;
		$detalle=[];
		$i=0;
		$sql="BEGIN SP_AF_SELECT_ESTMEDCOSPEDCOL(:PEDIDO,:DESCOL,:ESTTSC,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
		oci_bind_by_name($stmt, ':DESCOL', $_POST['dsccol']);
		oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODMED=$row['CODMED'];
			$obj->CODTAL=$row['CODTAL'];
			$obj->TOLERANCIAMAS=$row['TOLERANCIAMAS'];
			$obj->TOLERANCIAMENOS=$row['TOLERANCIAMENOS'];
			$obj->DESMEDCOR=utf8_encode($row['DESMEDCOR']);
			$obj->DESTAL=utf8_encode($row['DESTAL']);
			$obj->DESMED=utf8_encode($row['DESMED']);
			$obj->MEDIDA=$row['MEDIDA'];
			$detalle[$i]=$obj;
			$i++;
			if ($ant_nom!=utf8_encode($row['CODTAL'])) {
				$ant_nom=utf8_encode($row['CODTAL']);
				$cont++;
			}
		}
		$response->detalle=$detalle;
		$response->cont=$cont;

		$heamedtal=[];
		$i=0;
		$validador=false;
		$sql="BEGIN SP_AF_SELECT_HEAMEDTALPEDCOL(:PEDIDO,:DESCOL,:ESTTSC,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
		oci_bind_by_name($stmt, ':DESCOL', $_POST['dsccol']);
		oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->DESMED=utf8_encode($row['DESMED']);
			$obj->DESMEDCOR=$row['DESMEDCOR'];
			$obj->CODTAL=$row['CODTAL'];
			$obj->MEDIDA=$row['MEDIDA'];
			$heamedtal[$i]=$obj;
			$i++;
		}
		$response->heamedtal=$heamedtal;

		$guardado=[];
		$i=0;
		$validador=false;
		$sql="BEGIN SP_AF_SELECT_AUDMEDFINPEDCOL(:PEDIDO,:DESCOL,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
		oci_bind_by_name($stmt, ':DESCOL', $_POST['dsccol']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODMED=$row['CODMED'];
			$obj->CODTAL=$row['CODTAL'];
			$obj->NUMPRE=$row['NUMPRE'];
			$obj->VALOR=$row['VALOR'];
			if ($row['VALOR']!="0") {
				$validador=true;
			}
			$guardado[$i]=$obj;
			$i++;
		}
		$response->guardado=$guardado;
		$response->replicar=$validador;
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se guardaron los registros correctamente!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>