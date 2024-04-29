<?php
	set_time_limit(240);
	include('connection.php');
	$response=new stdClass();
	$array=json_decode($_POST['array']);

	$sql="BEGIN SP_AA_INSERT_ESTTSCDATOS(:ESTTSC,:UNIDAD); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
	oci_bind_by_name($stmt, ':UNIDAD', $_POST['medida']);
	$result=oci_execute($stmt);

	$sql="BEGIN SP_AA_DELETE_ESTTSCCOSMED(:ESTTSC); END;";
	$stmt=oci_parse($conn, $sql);
	//
	oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
	$result=oci_execute($stmt);
	if ($result) {
		
		$initial_pos=6;

		$tallas=[];
		$i=0;
		for ($j=$initial_pos; $j < count($array[0]); $j++) { 
			$sql="BEGIN SP_AFC_SELECT_TALLA(:DESTAL,:OUTPUT_CUR); END;";
			$stmt=oci_parse($conn, $sql);
			$destal=trim($array[0][$j]);
			oci_bind_by_name($stmt, ':DESTAL', $destal);
			$OUTPUT_CUR=oci_new_cursor($conn);
			oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
			$result=oci_execute($stmt);
			oci_execute($OUTPUT_CUR);
			$row=oci_fetch_assoc($OUTPUT_CUR);
			$tallas[$i]=$row['CODTAL'];
			$i++;
		}
		$response->tallas=$tallas;

		$w=0;
		$m=0;
		for ($i=1; $i < count($array); $i++) {
			$sql="BEGIN SP_AA_INSERT_ESTTSCMED(:ESTTSC,:CODMED,:DESMED,:DESMEDCOR,:TOLERANCIAMENOS,:TOLERANCIAMAS,:AUDITABLE); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
			oci_bind_by_name($stmt, ':CODMED', $i);
			oci_bind_by_name($stmt, ':DESMED', $array[$i][1]);
			oci_bind_by_name($stmt, ':DESMEDCOR', $array[$i][0]);
			oci_bind_by_name($stmt, ':TOLERANCIAMENOS', $array[$i][3]);
			oci_bind_by_name($stmt, ':TOLERANCIAMAS', $array[$i][4]);
			$auditable='A';
			if (trim($array[$i][2])==""){
				$auditable='';
			}
			oci_bind_by_name($stmt, ':AUDITABLE', $auditable);
			$result=oci_execute($stmt);

			if($result){
				for ($k=$initial_pos; $k < count($array[$i]); $k++) {
					$sql="BEGIN SP_AA_INSERT_ESTTSCMEDDET(:ESTTSC,:CODMED,:CODTAL,:MEDIDA,:ESTADO); END;";
					$stmt=oci_parse($conn, $sql);					
					oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
					oci_bind_by_name($stmt, ':CODMED', $i);
					oci_bind_by_name($stmt, ':CODTAL', $tallas[$k-$initial_pos]);
					oci_bind_by_name($stmt, ':MEDIDA', $array[$i][$k]);
					$estado='A';
					oci_bind_by_name($stmt, ':ESTADO', $estado);
					$result=oci_execute($stmt);
					if($result){
						$w++;
					}
				}
				$m++;
			}
		}
		$response->insert1=$m;
		$response->insert2=$w;
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo eliminar las medidas anteriores!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);

?>