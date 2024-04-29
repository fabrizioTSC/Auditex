<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

	if (isset($_POST['request'])) {
		$sedes=array();
		$obj=new stdClass();
		$obj->CODSEDE="0";
		$obj->DESSEDE="(TODOS)";
		$sedes[0]=$obj;
		$i=1;
		$sql="BEGIN SP_AT_SELECT_SEDES(:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODSEDE=$row['CODSEDE'];
			$obj->DESSEDE=utf8_encode($row['DESSEDE']);
			$sedes[$i]=$obj;
			$i++;
		}
		$response->sedes=$sedes;
		
		$tipser=array();
		$obj=new stdClass();
		$obj->CODTIPSERV="0";
		$obj->DESTIPSERV="(TODOS)";
		$tipser[0]=$obj;
		$i=1;
		$sql="BEGIN SP_AT_SELECT_TIPSERS(:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODTIPSERV=$row['CODTIPSERV'];
			$obj->DESTIPSERV=utf8_encode($row['DESTIPSERV']);
			$tipser[$i]=$obj;
			$i++;
		}
		$response->tipser=$tipser;

		$anios=array();
		$i=0;
		$sql="BEGIN SP_AT_SELECT_ANIOS(:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->ANIO=$row['ANIO'];
			$anios[$i]=$obj;
			$i++;
		}
		$response->anios=$anios;

		$semanas=array();
		$i=0;
		$sql="BEGIN SP_AT_SELECT_SEMANAS(:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->NUMERO_SEMANA=$row['NUMERO_SEMANA'];
			$obj->MIN=$row['MIN'];
			$obj->MAX=$row['MAX'];
			$semanas[$i]=$obj;
			$i++;
		}
		$response->semanas=$semanas;
		$response->anio=date("Y");		

		$sql="BEGIN SP_AT_SELECT_SEMANA_ACTUAL(:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$rowsemana=oci_fetch_assoc($OUTPUT_CUR);
		$response->semana=$rowsemana['NUMERO_SEMANA'];

		$response->state=true;
	}else{
		$response->state=false;
		$error->code=1;
		$error->description="No es un metodo POST.";
		$response->err=$error;
	}
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>