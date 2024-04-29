<?php

	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_APCR_INSERT_FICCORMEDFIN(:CODFIC,:NUMPRE,:HILO,:TRAVEZ,:LARGMANGA); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':NUMPRE', $_POST['cantidad']);
	oci_bind_by_name($stmt, ':HILO', $_POST['hilo']);
	oci_bind_by_name($stmt, ':TRAVEZ', $_POST['travez']);
	oci_bind_by_name($stmt, ':LARGMANGA', $_POST['largmanga']);
	$result=oci_execute($stmt);

	if ($result) {

		$detalle=[];
		$i=0;
		$ant_nom="";
		$cont=0;
		$sql="BEGIN SP_APCR_SELECT_ESTILOMEDIDA(:CODFIC,:HILO,:TRAVEZ,:LARGMANGA,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);

		oci_bind_by_name($stmt, ':HILO', $_POST['hilo']);
		oci_bind_by_name($stmt, ':TRAVEZ', $_POST['travez']);
		oci_bind_by_name($stmt, ':LARGMANGA', $_POST['largmanga']);

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
		$sql="BEGIN SP_APCR_SELECT_HEAMEDTAL(:CODFIC,:HILO,:TRAVEZ,:LARGMANGA,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':HILO', $_POST['hilo']);
		oci_bind_by_name($stmt, ':TRAVEZ', $_POST['travez']);
		oci_bind_by_name($stmt, ':LARGMANGA', $_POST['largmanga']);
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
		$sql="BEGIN SP_APCR_SELECT_FICCORMEDFIN(:CODFIC,:HILO,:TRAVEZ,:LARGMANGA,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt, ':HILO', $_POST['hilo']);
		oci_bind_by_name($stmt, ':TRAVEZ', $_POST['travez']);
		oci_bind_by_name($stmt, ':LARGMANGA', $_POST['largmanga']);
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

		// RANGO DE MEDIDAS
		$rangomedidas=[];
		// $i=0;
		// $validador=false;
		$sql="BEGIN PQ_MEDIDAS.SPU_GETRANGOMEDIDAS(:I_TIPOMEDIDA,:I_AMPLIADO,:O_CURSOR); END;";
		$stmt=oci_parse($conn, $sql);

		$tipomedida = $_POST["tipomedida"];
		$ampliado 	= "0";


		oci_bind_by_name($stmt, ':I_TIPOMEDIDA',$tipomedida);
		oci_bind_by_name($stmt, ':I_AMPLIADO', $ampliado);
		$O_CURSOR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':O_CURSOR', $O_CURSOR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($O_CURSOR);
		while($row=oci_fetch_assoc($O_CURSOR)){
			$obj=new stdClass();
			$obj->ID_TIPO_MEDIDA=$row['ID_TIPO_MEDIDA'];
			$obj->ORDEN_MEDIDA=$row['ORDEN_MEDIDA'];
			$obj->MEDIDA=$row['MEDIDA'];
			$obj->AMPLIADO=$row['AMPLIADO'];
			$rangomedidas[]=$obj;
			// $i++;
		}
		$response->rangomedidas=$rangomedidas;




		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se guardaron los registros correctamente!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>