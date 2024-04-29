<?php
	include('connection.php');
	$response=new stdClass();

	function fecha_formato($text){
		return substr($text, 6,2)."/".substr($text, 4,2)."/".substr($text, 0,4);
	}

	$sql="BEGIN SP_INSP_SELECT_DATE(:ANTERIOR,:FECHA); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':ANTERIOR', $_POST['anterior']);
	oci_bind_by_name($stmt, ':FECHA', $fecha,40);
	$result=oci_execute($stmt);
	$response->fecha=$fecha;

	$fectext="";
	$fechas=[];
	$sql="BEGIN SP_INSP_SELECT_LISFECREGCUOHOR(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODFEC=$row['FECFOR'];
		$obj->FECHA=fecha_formato($row['FECFOR']);
		array_push($fechas, $obj);
		if ($fectext=="") {
			$fectext=$row['FECFOR'];
		}
	}
	$response->fechas=$fechas;

	$lineas=[];
	$i=0;
	$linea=0;
	$sql="BEGIN SP_INSP_SELECT_LINEASETON(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		if ($i==0) {
			$linea=$row['LINEA'];
		}
		$obj=new stdClass();
		$obj->LINEA=$row['LINEA'];
		$obj->DESLIN=$row['DESLIN'];

		$lineas[$i]=$obj;
		$i++;
	}
	$response->lineas=$lineas;

	$turnos=[];
	$i=0;
	$turno=0;
	$sql="BEGIN SP_INSP_SELECT_LINETOTXL_V2(:LINEA,:FECHA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':LINEA', $linea);
	oci_bind_by_name($stmt, ':FECHA', $fectext);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$turno=$row['TURNO'];
		$obj=new stdClass();
		$obj->TURNO=$row['TURNO'];
		$turnos[$i]=$obj;
		$i++;
	}
	$response->turnos=$turnos;
	$response->turno_selected=$turno;

	$obj=new stdClass();
	$sql="BEGIN SP_INSP_SELECT_LINEAETON_V2(:LINEA,:TURNO,:FECHA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':LINEA', $linea);
	oci_bind_by_name($stmt, ':TURNO', $turno);
	oci_bind_by_name($stmt, ':FECHA', $fectext);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj->CUOTA=$row['CUOTA'];
		$obj->HORINI=$row['HORINI'];
		$obj->HORFIN=$row['HORFIN'];
		$obj->JORNADA=$row['JORNADA'];
		$obj->CAMEST=$row['CAMBIOESTILO'];
	}
	$response->data_linea=$obj;

	$data_hora=[];
	$i=0;
	$sql="BEGIN SP_INSP_SELECT_LINETOHORAS_V2(:LINEA,:TURNO,:FECHA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':LINEA', $linea);
	oci_bind_by_name($stmt, ':TURNO', $turno);
	oci_bind_by_name($stmt, ':FECHA', $fectext);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->HORA=$row['HORA'];
		$obj->NUMOPE=$row['NUMOPE'];
		$obj->MINUTOSHORA=$row['MINUTOSHORA'];
		$obj->MIN_DESCUENTO=$row['MIN_DESCUENTO'];
		$obj->MINASI=$row['MIN_ASIGNADOS'];
		$data_hora[$i]=$obj;
		$i++;
	}
	$response->data_hora=$data_hora;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>