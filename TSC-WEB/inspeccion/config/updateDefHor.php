<?php
	include('connection.php');
	$response=new stdClass();


	$sql="BEGIN SP_INSP_VAL_FECREPHOR(:FECHA,:ESTADO); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':FECHA', $_POST['fecha']);
	oci_bind_by_name($stmt, ':ESTADO', $estado,40);
	$result=oci_execute($stmt);

	if ($estado==0) {
		$response->state=false;
		$response->detail="La fecha no puede ser mayor al dia de hoy!";
	}else{
		$response->state=true;
		$defectos=[];
		$i=0;
		$sql="BEGIN SP_INSP_REP_DEF_DEFLINEA(:FECHA,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt, ':FECHA', $_POST['fecha']);
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
			$obj->CANDEFLINDEF=$row['CANDEFLINDEF'];
			$obj->CODDEF=$row['CODDEF'];
			$obj->DESDEF=utf8_encode($row['DESDEF']);
			$obj->CANDEFDEF=$row['CANDEFDEF'];
			$obj->CANDEF=$row['CANDEF'];
			$defectos[$i]=$obj;
			$i++;			
		}
		$response->defectos=$defectos;
		$response->minhora=$minhora;
		$response->maxhora=$maxhora;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>