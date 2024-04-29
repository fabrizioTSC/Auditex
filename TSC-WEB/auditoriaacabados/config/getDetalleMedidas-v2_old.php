<?php

	include('connection.php');
	$response=new stdClass();

		$sql="BEGIN SP_AA_SELECT_FICCORMEDFINACA(:CODFIC,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
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

		$detalle=[];
		$i=0;
		$ant_nom="";
		$cont=0;
		$sql="BEGIN SP_AA_SELECT_ESTMEDCOSFIC(:CODFIC, :ESTTSC,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
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
			if ($ant_nom!=utf8_encode($row['DESTAL'])) {
				$ant_nom=utf8_encode($row['DESTAL']);
				$cont++;
			}
		}
		$response->detalle=$detalle;
		$response->cont=$cont;

		$heamedtal=[];
		$i=0;
		$validador=false;
		$sql="BEGIN SP_AA_SELECT_HEAMEDTALFIC(:CODFIC, :ESTTSC,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
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
		$sql="BEGIN SP_AA_SELECT_FICAUDMED(:CODFIC,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
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

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>