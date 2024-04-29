<?php
	include("connection.php");
	$response=new stdClass();
	date_default_timezone_set("America/Lima");

	if (!isset($_POST['codinscos'])) {
		$codinscos="0";
		$sql="BEGIN SP_INSP_SELECT_INSCOSEXISTS(:CODFIC,:CODUSU,:CODTLL,:OUTPUT_CUR); END;";	
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt,':CODFIC', $_POST['codfic']);
		oci_bind_by_name($stmt,':CODUSU', $_POST['codusu']);
		oci_bind_by_name($stmt,':CODTLL', $_POST['codtll']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$codinscos=$row['CODINSCOS'];
		}
		$response->codinscos=$codinscos;
		if ($codinscos!="0") {
			$response->exist=true;
			$response->codinscos=$codinscos;
		}else{
			$response->exist=false;

			$sql="BEGIN SP_INSP_INSERT_INSCOS(:CODUSU,:CODFIC,:TURNO,:CANPRE,:CANPREDEF,:CODTLL,:CODINSCOS); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
			oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
			oci_bind_by_name($stmt, ':TURNO', $_POST['turinscos']);
			oci_bind_by_name($stmt, ':CANPRE', $_POST['canpre']);
			oci_bind_by_name($stmt, ':CANPREDEF', $_POST['canpredef']);
			oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
			oci_bind_by_name($stmt, ':CODINSCOS', $codinscos,40);
			$result=oci_execute($stmt);

			if ($result) {
				$response->codinscos=$codinscos;
				$response->state=true;
				$response->detail="Inspección guardada!";
				if (isset($_POST['array'])) {
					$array=$_POST['array'];
					for ($i=0; $i < count($array); $i++) {
						$sql="BEGIN SP_INSP_INSERT_DETINSCOS(:CODINSCOS,:CODDEF,:CODOPE,:CANDET); END;";
						$stmt=oci_parse($conn, $sql);
						oci_bind_by_name($stmt, ':CODINSCOS',$codinscos);
						oci_bind_by_name($stmt, ':CODDEF', $array[$i][1]);
						oci_bind_by_name($stmt, ':CODOPE', $array[$i][0]);
						oci_bind_by_name($stmt, ':CANDET', $array[$i][2]);
						$result=oci_execute($stmt);

						$sql="BEGIN SP_INSP_INSERT_ESTILOOPERACION(:ESTTSC,:CODOPE,:ESTADO,:ORDEN); END;";
						$stmt=oci_parse($conn, $sql);
						$estado='A';
						$orden=1;
						oci_bind_by_name($stmt, ':ESTTSC',$_POST['codstl']);
						oci_bind_by_name($stmt, ':CODOPE',$array[$i][0]);
						oci_bind_by_name($stmt, ':ESTADO',$estado);
						oci_bind_by_name($stmt, ':ORDEN',$orden);
						$result=oci_execute($stmt);						
					}						
				}
			}else{
				$response->state=false;
				$response->detail="No se pudo guardar la inspección!";
				$response->error=$error;
			}
		}
	}else{
		$sql="BEGIN SP_INSP_UPDATE_INSCOS(:CODINSCOS,:CANPRE,:CANPREDEF); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODINSCOS', $_POST['codinscos']);
		oci_bind_by_name($stmt, ':CANPRE', $_POST['canpre']);
		oci_bind_by_name($stmt, ':CANPREDEF', $_POST['canpredef']);
		$result=oci_execute($stmt);

		if ($result) {
			$response->state=true;
			$response->detail="Inspección guardada!";

			$sql="BEGIN SP_INSP_DELETE_DETINSCOSALL(:CODINSCOS); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':CODINSCOS',$_POST['codinscos']);
			$result=oci_execute($stmt);

			if (isset($_POST['array'])) {
				$array=$_POST['array'];
				for ($i=0; $i < count($array); $i++) { 
					$sql="BEGIN SP_INSP_INSERT_DETINSCOS(:CODINSCOS,:CODDEF,:CODOPE,:CANDET); END;";
					$stmt=oci_parse($conn, $sql);
					oci_bind_by_name($stmt, ':CODINSCOS',$_POST['codinscos']);
					oci_bind_by_name($stmt, ':CODDEF', $array[$i][1]);
					oci_bind_by_name($stmt, ':CODOPE', $array[$i][0]);
					oci_bind_by_name($stmt, ':CANDET', $array[$i][2]);
					$result=oci_execute($stmt);

					$sql="BEGIN SP_INSP_INSERT_ESTILOOPERACION(:ESTTSC,:CODOPE,:ESTADO,:ORDEN); END;";
					$stmt=oci_parse($conn, $sql);
					$estado='A';
					$orden=1;
					oci_bind_by_name($stmt, ':ESTTSC',$_POST['codstl']);
					oci_bind_by_name($stmt, ':CODOPE',$array[$i][0]);
					oci_bind_by_name($stmt, ':ESTADO',$estado);
					oci_bind_by_name($stmt, ':ORDEN',$orden);
					$result=oci_execute($stmt);	
				}
			}
		}else{
			$response->state=false;
			$response->detail="No se pudo actualizar la inspección!";		
		}
	}

	oci_close($conn);
	header("Content-Type:application/json");
	echo json_encode($response);
?>