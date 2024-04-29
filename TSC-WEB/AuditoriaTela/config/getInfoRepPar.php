<?php
	include('connection.php');
	$response=new stdClass();

	$partida="0";
	if ($_POST['partida']!="") {
		$partida=$_POST['partida'];
	}

	$info=[];
	$i=0;
	$sql="BEGIN SP_AUDITEL_REP_PARTIDAS(:PARTIDA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $partida);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->PARTIDA=$row['PARTIDA'];
		$obj->CODTEL=$row['CODTEL'];
		$obj->SITUACION=$row['SITUACION'];
		$obj->BUTTON=$row['MOSTRARBUTTON'];
		$obj->COLOR=utf8_encode($row['COLOR']);
		$obj->CODPRV=$row['CODPRV'];
		$obj->DESPRV=utf8_encode($row['DESPRV']);
		$obj->RUTA=utf8_encode($row['RUTA']);
		$obj->ARTICULO=utf8_encode($row['ARTICULO']);
		$obj->COMPOSICION=utf8_encode($row['COMPOSICION']);
		$obj->RENDIMIENTO=str_replace(",",".",$row['RENDIMIENTO']);
		$obj->PESO=$row['PESO'];
		$obj->PROGRAMA=utf8_encode($row['PROGRAMA']);
		$obj->X_FACTORY=$row['X_FACTORY'];
		$info[$i]=$obj;
		$i++;
	}
	$response->info=$info;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>