<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_INSP_SELECT_DATE(:ANTERIOR,:FECHA); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':ANTERIOR', $_POST['anterior']);
	oci_bind_by_name($stmt, ':FECHA', $fecha,40);
	$result=oci_execute($stmt);
	$response->fecha=$fecha;

	$obj=new stdClass();
	$sql="BEGIN SP_INSP_SELECT_LINEAETON(:LINEA,:TURNO,:ANTERIOR,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':LINEA', $_POST['linea']);
	oci_bind_by_name($stmt, ':TURNO', $_POST['turno']);
	oci_bind_by_name($stmt, ':ANTERIOR', $_POST['anterior']);
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
	$sql="BEGIN SP_INSP_SELECT_LINETOHORAS(:LINEA,:TURNO,:ANTERIOR,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':LINEA', $_POST['linea']);
	oci_bind_by_name($stmt, ':TURNO', $_POST['turno']);
	oci_bind_by_name($stmt, ':ANTERIOR', $_POST['anterior']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->HORA=$row['HORA'];
		$obj->NUMOPE=$row['NUMOPE'];
		$obj->MINUTOSHORA=$row['MINUTOSHORA'];
		$obj->MINASI=$row['MIN_ASIGNADOS'];
		$data_hora[$i]=$obj;
		$i++;
	}
	$response->data_hora=$data_hora;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>