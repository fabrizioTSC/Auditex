<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

	$defectos=array();
	$fichatallas=array();
	$defectosPasados=array();
	$fichas=[];
	$i=0;
	$sql="BEGIN SP_AFC_SELECT_FICHAXTALLER(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
	oci_bind_by_name($stmt,':CODAQL',$_POST['codaql']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$ficha=new stdClass();
		$ficha->CANAUD=$row['CANAUD'];
		$ficha->CANPAR=$row['CANPAR'];
		$ficha->CANPRE=$row['CANPRE'];
		$ficha->CANDEFMAX=$row['CANDEFMAX'];
		$ficha->CODAQL=$row['CODAQL'];
		$ficha->AQL=$row['AQL'];
		$ficha->DESTLL=utf8_encode($row['DESTLL']);
		$ficha->PEDIDO=$row['PEDIDO'];
		$ficha->ESTTSC=$row['ESTTSC'];
		$ficha->ESTCLI=$row['ESTCLI'];
		$fichas[$i]=$ficha;
		$i++;
	}
	$response->fichas=$fichas;

	if (oci_num_rows($stmt)==0) {			
		$response->state=false;
		$response->description="No hay fichas para el taller";
	}else{
		$sql="BEGIN SP_AFC_SELECT_FICHATALLAS(:CODFIC,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$fichatalla=new stdClass();
			$fichatalla=$row;
			array_push($fichatallas,$fichatalla);
		}
		$sql="BEGIN SP_AFC_SELECT_DEFECTOS(:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$defecto=new stdClass();
			$defecto->coddef=$row['CODDEF'];
			$defecto->desdef=utf8_encode($row['DESDEF']);
			array_push($defectos,$defecto);
		}
		$sql="BEGIN SP_AFC_SELECT_AUDFINCORDETDEF(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
		oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
		oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
		oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){				
			$defectoPas=new stdClass();
			$defectoPas=$row;
			array_push($defectosPasados,$defectoPas);
		}
		$response->defectos=$defectos;
		$response->fichatallas=$fichatallas;
		$response->defectosPasados=$defectosPasados;
		$response->state=true;

		$sql="BEGIN SP_AFC_SELECT_OBSFICCOR(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
		oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
		oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
		oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$obs=[];
		$i=0;
		while($row=oci_fetch_assoc($OUTPUT_CUR)){				
			$obj=new stdClass();
			$obj->SEC=$row['SEC'];
			$obj->OBS=utf8_encode($row['OBS']);
			$obs[$i]=$obj;
			$i++;
		}
		$response->obs=$obs;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>