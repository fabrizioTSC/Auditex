<?php
	set_time_limit(60);
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_INSP_SELECT_VALNUETUR_V2(:LINEA,:FECHA,:TURNO,:CANTIDAD); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt,':LINEA',$_POST['linea']);
	oci_bind_by_name($stmt,':FECHA',$_POST['fecha']);
	oci_bind_by_name($stmt,':TURNO',$_POST['turno']);
	oci_bind_by_name($stmt,':CANTIDAD',$cantidad,40);
	$result=oci_execute($stmt);

	if ($cantidad==0) {
		$sql="BEGIN SP_INSP_INSERT_LINETOTUR_V2(:LINEA,:FECHA,:TURNO,:CUOTA,:HORINI,:HORFIN,:JORNADA); END;";
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt,':LINEA',$_POST['linea']);
		oci_bind_by_name($stmt,':FECHA',$_POST['fecha']);
		oci_bind_by_name($stmt,':TURNO',$_POST['turno']);
		oci_bind_by_name($stmt,':CUOTA',$_POST['cuota']);
		oci_bind_by_name($stmt,':HORINI',$_POST['horini']);
		oci_bind_by_name($stmt,':HORFIN',$_POST['horfin']);
		oci_bind_by_name($stmt,':JORNADA',$_POST['jornada']);
		$result=oci_execute($stmt);
		if($result){
			$response->state=true;
			$response->turno_selected=$_POST['turno'];

			$data_hora=[];
			$i=0;
			for ($j=((int)$_POST['horini']); $j < ((int) $_POST['horfin']); $j++) {
				$minasi=0;
				$numope=0;
				$numdes=0;
				$minho=60;
				$sql="BEGIN SP_INSP_INSERT_LINETOTURHOR_V3(:LINEA,:FECHA,:HORA,:MINASI,:TURNO,:NUMOPE,:MINHOR,:MINDES); END;";
				$stmt=oci_parse($conn,$sql);
				oci_bind_by_name($stmt,':LINEA',$_POST['linea']);
				oci_bind_by_name($stmt,':FECHA',$_POST['fecha']);
				oci_bind_by_name($stmt,':HORA',$j);
				oci_bind_by_name($stmt,':MINASI',$minasi);
				oci_bind_by_name($stmt,':TURNO',$_POST['turno']);
				oci_bind_by_name($stmt,':NUMOPE',$numope);
				oci_bind_by_name($stmt,':MINHOR',$minho);
				oci_bind_by_name($stmt,':MINDES',$numdes);
				$result=oci_execute($stmt);

				$obj=new stdClass();
				$obj->HORA=$j;
				$obj->NUMOPE=$numope;
				$obj->MINUTOSHORA=$minho;
				$obj->MINASI=$minasi;
				$obj->MIN_DESCUENTO=$numdes;
				$data_hora[$i]=$obj;
				$i++;
			}
			$response->data_hora=$data_hora;
			$turnos=[];

			$i=0;
			$turno=0;
			$sql="BEGIN SP_INSP_SELECT_LINETOTXL_V2(:LINEA,:FECHA,:OUTPUT_CUR); END;";
			$stmt=oci_parse($conn,$sql);
			oci_bind_by_name($stmt, ':LINEA', $_POST['linea']);
			oci_bind_by_name($stmt, ':FECHA', $_POST['fecha']);
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
		}else{
			$response->state=false;
			$response->detail="No se pudo crear el nuevo turno!";
		}
	}else{
		$response->state=false;
		$response->detail="Alguien ya creó el turno!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>