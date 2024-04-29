<?php
	set_time_limit(0);
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AA_SELECT_VALFICEXIAVI(:CODFIC,:RES); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':RES',$res,40);
	$result=oci_execute($stmt);

	if ($res==0) {
		$response->detail="Sin avíos disponibles";
		$response->state=false;
	}else{
		$chelisavi=[];
		$sql="BEGIN SP_AA_SELECT_AUDACACHKLSTAVIO(:CODFIC,:PARTE,:NUMVEZ,:CODAVIO,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
		oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
		oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
		oci_bind_by_name($stmt,':CODAVIO',$_POST['codavio']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->TIPOAVIO=utf8_encode($row['TIPOAVIO']);
			$obj->TALLA=utf8_encode($row['TALLA']);
			$obj->CODAVIO=$row['CODAVIO'];
			$obj->DESITEM=utf8_encode($row['DESITEM']);
			$obj->VALOR=$row['VALOR'];
			array_push($chelisavi,$obj);
		}
		$response->chelisavi=$chelisavi;
		$response->state=true;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>