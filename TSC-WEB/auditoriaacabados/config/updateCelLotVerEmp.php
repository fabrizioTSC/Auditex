<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_PCVA_UPDATE_CELLOTVEZ(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:CODCEL,:LOTE,:NUMVEZLOTE,:CODUSU); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
	oci_bind_by_name($stmt,':COLOR',$_POST['color']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':CODCEL',$_POST['codcel']);
	oci_bind_by_name($stmt,':LOTE',$_POST['lote']);
	oci_bind_by_name($stmt,':NUMVEZLOTE',$_POST['numvezlote']);
	session_start();
	oci_bind_by_name($stmt,':CODUSU',$_SESSION['user']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
		
		$lotes=[];
		$sql="BEGIN SP_PCVA_SELECT_LISTALOTE(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
		oci_bind_by_name($stmt,':COLOR',$_POST['color']);
		oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
		oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$obj=new stdClass();
			$obj->NROLOTE=$row['NROLOTE'];
			$obj->NUMVEZLOTE=$row['NUMVEZLOTE'];
			$obj->DESCEL=utf8_encode($row['DESCEL']);
			$obj->NUMCAJLOTE=$row['NUMCAJLOTE'];
			$obj->NUMCAJAUDLOTE=$row['NUMCAJAUDLOTE'];
			$obj->ESTADO=$row['ESTADO'];
			$obj->RESULTADO=$row['RESULTADO'];
			$obj->CODUSU=$row['CODUSU'];
			$obj->FECINI=$row['FECINI'];
			$obj->FECFIN=$row['FECFIN'];
			array_push($lotes,$obj);
		}
		$response->lotes=$lotes;
	}else{
		$response->detail="No se pudo actualizar la célula";
		$response->state=false;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>