<?php
	set_time_limit(480);
	include('connection.php');
	$response=new stdClass();
	$array=json_decode($_POST['array']);

	$sql="BEGIN SP_AFC_INSERT_ESTTSCUNIMEDAUX(:ESTTSC,:UNIDAD,:CONLARGMANGA); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
	oci_bind_by_name($stmt, ':UNIDAD', $_POST['medida']);
	oci_bind_by_name($stmt, ':CONLARGMANGA', $_POST['islarman']);
	$result=oci_execute($stmt);

	$sql="BEGIN SP_AFC_DELETE_ESTTSC_JV2(:ESTTSC,:HILO,:TRAVEZ,:LARGMANGA); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
	//AGREGADO
	$hilo=intval($_POST['hilo']);
	oci_bind_by_name($stmt, ':HILO', $hilo);
	$travez=intval($_POST['travez']);
	oci_bind_by_name($stmt, ':TRAVEZ', $travez);
	$largmanga=intval($_POST['largmanga']);
	oci_bind_by_name($stmt, ':LARGMANGA', $largmanga);
	//
	$result=oci_execute($stmt);
	if ($result) {
		$valida_pc=false;
		$initial_pos=5;
		for ($i=0; $i <count($array[0]) ; $i++) { 
			if ($array[0][$i]=="P/C" || $array[0][$i]=="C/P") {
				$valida_pc=true;
				$initial_pos=6;
			}
		}

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
		$auditable_cad='';

		$w=0;
		$m=0;
		for ($i=1; $i < count($array); $i++) {
			if ($valida_pc) {
				$sql="BEGIN SP_AFC_SELECT_AUDBYEC(:ESTTSC,:CODMED,:AUDITABLE); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
				oci_bind_by_name($stmt, ':CODMED', $i);
				oci_bind_by_name($stmt, ':AUDITABLE', $auditable,40);
				$result=oci_execute($stmt);

				$sql="BEGIN SP_AFC_INSERT_ESTTSCMED_JV2(:ESTTSC,:CODMED,:DESMED,:DESMEDCOR,:TOLERANCIAMENOS,:TOLERANCIAMAS,:AUDITABLE,:PARTE,:HILO,:TRAVEZ,:LARGMANGA); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
				oci_bind_by_name($stmt, ':CODMED', $i);
				oci_bind_by_name($stmt, ':DESMED', $array[$i][1]);
				oci_bind_by_name($stmt, ':DESMEDCOR', $array[$i][0]);
				oci_bind_by_name($stmt, ':TOLERANCIAMENOS', $array[$i][4]);
				oci_bind_by_name($stmt, ':TOLERANCIAMAS', $array[$i][5]);
				if ($auditable==null) {
					$auditable='';
				}else{
					if ($auditable=='-') {
						$auditable='A';
						if (trim($array[$i][3])==""){
							$auditable='';
						}
					}
				}
				oci_bind_by_name($stmt, ':AUDITABLE', $auditable);
				oci_bind_by_name($stmt, ':PARTE', $array[$i][2]);

				//AGREGADO
				$hilo=intval($_POST['hilo']);
				oci_bind_by_name($stmt, ':HILO', $hilo);
				$travez=intval($_POST['travez']);
				oci_bind_by_name($stmt, ':TRAVEZ', $travez);
				$largmanga=intval($_POST['largmanga']);
				oci_bind_by_name($stmt, ':LARGMANGA', $largmanga);

				$result=oci_execute($stmt);
				if (!$result) {
					$auditable_cad.=$i.": ".$auditable." - ";
				}
			}else{
				$sql="BEGIN SP_AFC_SELECT_AUDBYEC(:ESTTSC,:CODMED,:AUDITABLE); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
				oci_bind_by_name($stmt, ':CODMED', $i);
				oci_bind_by_name($stmt, ':AUDITABLE', $auditable,40);
				$result=oci_execute($stmt);

				$sql="BEGIN SP_AFC_INSERT_ESTTSCMED_JV2(:ESTTSC,:CODMED,:DESMED,:DESMEDCOR,:TOLERANCIAMENOS,:TOLERANCIAMAS,:AUDITABLE,:PARTE,:HILO,:TRAVEZ,:LARGMANGA); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
				oci_bind_by_name($stmt, ':CODMED', $i);
				oci_bind_by_name($stmt, ':DESMED', $array[$i][1]);
				oci_bind_by_name($stmt, ':DESMEDCOR', $array[$i][0]);
				oci_bind_by_name($stmt, ':TOLERANCIAMENOS', $array[$i][3]);
				oci_bind_by_name($stmt, ':TOLERANCIAMAS', $array[$i][4]);
				if ($auditable==null) {
					$auditable='';
				}else{
					if ($auditable=='-') {
						$auditable='A';
						if (trim($array[$i][2])==""){
							$auditable='';
						}
					}
				}
				oci_bind_by_name($stmt, ':AUDITABLE', $auditable);
				$parte="P";
				oci_bind_by_name($stmt, ':PARTE', $parte);

				//AGREGADO
				$hilo=intval($_POST['hilo']);
				oci_bind_by_name($stmt, ':HILO', $hilo);
				$travez=intval($_POST['travez']);
				oci_bind_by_name($stmt, ':TRAVEZ', $travez);
				$largmanga=intval($_POST['largmanga']);
				oci_bind_by_name($stmt, ':LARGMANGA', $largmanga);

				$result=oci_execute($stmt);
				if (!$result) {
					$auditable_cad.=$i.": ".$auditable." - ";
				}
			}
			// OBTIENE ID PRA REGISTRO
			$sql="BEGIN AUDITEX.SP_GETIDTSCV2(:ESTTSC,:HILO,:TRAVEZ,:LARGMANGA,:OUTPUT_CUR); END;";
			$stmt=oci_parse($conn, $sql);
			$OUTPUT_CUR=oci_new_cursor($conn);
			oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
			$hilo=intval($_POST['hilo']);
			oci_bind_by_name($stmt, ':HILO', $hilo);
			$travez=intval($_POST['travez']);
			oci_bind_by_name($stmt, ':TRAVEZ', $travez);
			$largmanga=intval($_POST['largmanga']);
			oci_bind_by_name($stmt, ':LARGMANGA', $largmanga);
			oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
			$result=oci_execute($stmt);
			oci_execute($OUTPUT_CUR);
			$idregistrar;
			while($row=oci_fetch_assoc($OUTPUT_CUR)){
				$idregistrar= $row["ID"];
			}

			if($result){
				for ($k=$initial_pos; $k < count($array[$i]); $k++) {
					$sql="BEGIN SP_AFC_INSERT_ESTTSCMEDDET_JV2(:ID,:ESTTSC,:CODMED,:HILO,:TRAVEZ,:LARGMANGA,:CODTAL,:MEDIDA,:ESTADO); END;";
					$stmt=oci_parse($conn, $sql);
					oci_bind_by_name($stmt, ':ID', $idregistrar);
					
					oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
					oci_bind_by_name($stmt, ':CODMED', $i);

					$hilo=intval($_POST['hilo']);
					oci_bind_by_name($stmt, ':HILO', $hilo);
					$travez=intval($_POST['travez']);
					oci_bind_by_name($stmt, ':TRAVEZ', $travez);
					$largmanga=intval($_POST['largmanga']);
					oci_bind_by_name($stmt, ':LARGMANGA', $largmanga);


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
		$response->auditable_cad=$auditable_cad;
	}else{
		$response->state=false;
		$response->detail="No se pudo eliminar las medidas anteriores!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);

?>