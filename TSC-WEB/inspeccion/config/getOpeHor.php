<?php
	include('connection.php');
	$response=new stdClass();


	$sql="BEGIN SP_INSP_SELECT_DATEMINCOM(:FECHA); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':FECHA', $fechamincom,40);
	$result=oci_execute($stmt);
	$response->fecha=$fechamincom;

	$operaciones=[];
	$i=0;
	$sql="BEGIN SP_INSP_REP_DEF_OPELINEA(:FECHA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':FECHA', $fechamincom);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$minhora=1000;
	$maxhora=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		if ($row['NHORA']<$minhora) {
			$minhora=$row['NHORA'];
		}
		if ($row['NHORA']>$maxhora) {
			$maxhora=$row['NHORA'];
		}
		$obj=new stdClass();
		$obj->LINEA=$row['LINEA'];
		$obj->NHORA=$row['NHORA'];
		$obj->CANDEFLINOPE=$row['CANDEFLINOPE'];
		$obj->CODOPE=$row['CODOPE'];
		$obj->DESOPE=utf8_encode($row['DESOPE']);
		$obj->CANDEFOPE=$row['CANDEFOPE'];
		$obj->CANDEF=$row['CANDEF'];
		$operaciones[$i]=$obj;
		$i++;			
	}
	$response->operaciones=$operaciones;
	$response->minhora=$minhora;
	$response->maxhora=$maxhora;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>