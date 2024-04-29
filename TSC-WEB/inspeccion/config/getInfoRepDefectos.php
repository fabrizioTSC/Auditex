<?php
	set_time_limit(240);
	include('connection.php');
	$response=new stdClass();

	$ar_lineas=explode("-",$_POST['lineas']);
	$ar_fecha = explode("-",$_POST['fecha']);
	$fecha=$ar_fecha[0].$ar_fecha[1].$ar_fecha[2];
	$ar_fechafin = explode("-",$_POST['fechafin']);
	$fechafin=$ar_fechafin[0].$ar_fechafin[1].$ar_fechafin[2];
	
	$lineas=[];
	if ($ar_lineas[0]=="0") {
		$sql="BEGIN SP_INSP_REP_DETDEFINS(:LINEA,:FECHA,:FECHAFIN,:OUTPUT_CUR); END;";		
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt,":LINEA", $ar_lineas[0]);
		oci_bind_by_name($stmt,":FECHA", $fecha);
		oci_bind_by_name($stmt,":FECHAFIN", $fechafin);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$uno=new stdClass();
			$uno->CODINSCOS=$row['CODINSCOS'];
			$uno->CODFIC=$row['CODFIC'];
			$uno->CANFIC=$row['CANFIC'];
			$uno->FECINS=$row['FECINS'];
			$uno->CODUSU=$row['CODUSU'];
			$uno->DESTLL=utf8_encode($row['DESTLL']);
			$uno->DEFECTO=utf8_encode($row['DEFECTO']);
			$uno->FAMILIA=utf8_encode($row['FAMILIA']);
			$uno->OPERACION=utf8_encode($row['OPERACION']);
			$uno->CANDEF=$row['CANDEF'];
		    $uno->CANINS=$row['CANINS'];;
			$uno->CANPREDEF=$row['CANPREDEF'];;
			array_push($lineas, $uno);
		}
	}else{
		for ($i=0; $i < count($ar_lineas) ; $i++) {	
			$sql="BEGIN SP_INSP_REP_DETDEFINS(:LINEA,:FECHA,:FECHAFIN,:OUTPUT_CUR); END;";		
			$stmt=oci_parse($conn,$sql);
			oci_bind_by_name($stmt,":LINEA", $ar_lineas[$i]);
			oci_bind_by_name($stmt,":FECHA", $fecha);
			oci_bind_by_name($stmt,":FECHAFIN", $fechafin);
			$OUTPUT_CUR=oci_new_cursor($conn);
			oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR,-1,OCI_B_CURSOR);
			$result=oci_execute($stmt);
			oci_execute($OUTPUT_CUR);
			while($row=oci_fetch_assoc($OUTPUT_CUR)){
				$uno=new stdClass();
				$uno->CODINSCOS=$row['CODINSCOS'];
				$uno->CODFIC=$row['CODFIC'];
				$uno->CANFIC=$row['CANFIC'];
				$uno->FECINS=$row['FECINS'];
				$uno->CODUSU=$row['CODUSU'];
				$uno->DESTLL=utf8_encode($row['DESTLL']);
				$uno->DEFECTO=utf8_encode($row['DEFECTO']);
				$uno->FAMILIA=utf8_encode($row['FAMILIA']);
				$uno->OPERACION=utf8_encode($row['OPERACION']);
				$uno->CANDEF=$row['CANDEF'];
			    $uno->CANINS=$row['CANINS'];;
				$uno->CANPREDEF=$row['CANPREDEF'];;
				array_push($lineas, $uno);
			}
		}
	}
	$response->lineas=$lineas;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>