<?php
	include('connection.php');
	$response=new stdClass();

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
	$defectos=[];
	$i=0;
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$defecto=new stdClass();
		$defecto->coddef=$row['CODDEF'];
		$defecto->desdef=utf8_encode($row['DESDEF']);
		$defecto->codope=$row['CODOPE'];
		$defecto->desope=utf8_encode($row['DESOPE']);
		$defecto->candef=$row['CANDEF'];
		$defectos[$i]=$defecto;
		$i++;
	}
	$response->defectos=$defectos;

	$sql="BEGIN SP_AFC_SELECT_FICDET(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL,:OUTPUT_CUR); END;";
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

	$row=oci_fetch_assoc($OUTPUT_CUR);
	$ficha=new stdClass();
	$ficha->ESTADO=$row['ESTADO'];
	$ficha->DESTLL=utf8_encode($row['DESTLL']);
	$ficha->CANPRE=$row['CANPRE'];
	$ficha->CANPAR=$row['CANPAR'];
	$ficha->COMENTARIOS=utf8_encode($row['COMENTARIOS']);
	$ficha->AQL=$row['AQL'];
	$ficha->CANAUD=$row['CANAUD'];
	$ficha->RESULTADO=$row['RESULTADO'];
	$ficha->PEDIDO=$row['PEDIDO'];
	$ficha->ESTTSC=$row['ESTTSC'];
	$ficha->ESTCLI=$row['ESTCLI'];
	
	$response->state=true;
	$response->ficha=$ficha;
	

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

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>