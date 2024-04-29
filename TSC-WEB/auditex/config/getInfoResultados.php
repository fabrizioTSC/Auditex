<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['request'])) {

		// SEDES
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

		// TIPO SERVICIO
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

		// CLIENTES
		$clientes=array();
		$obj=new stdClass();
		$obj->CODCLI="0";
		$obj->DESCLI="(TODOS)";
		$clientes[0]=$obj;
		$i=1;
		$sql="BEGIN SP_AT_SELECT_CLITOREP(:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODCLI=$row['CODCLI'];
			$obj->DESCLI=utf8_encode($row['DESCLI']);
			$clientes[$i]=$obj;
			$i++;
		}
		$response->clientes=$clientes;

		// TALLERES
		$talleres=[];
		$obj=new stdClass();
		$obj->CODTLL="0";
		$obj->DESTLL="(TODOS)";
		$obj->CODSEDE="0";
		$obj->CODTIPSERV="0";
		$talleres[0]=$obj;
		$i=1;
		$sql="BEGIN SP_AT_SELECT_TALLERESXREP(:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$taller=new stdClass();
			$taller->CODTLL=$row['CODTLL'];
			$taller->DESTLL=utf8_encode($row['DESTLL']);
			$taller->CODSEDE=$row['CODSEDE'];
			$taller->CODTIPSERV=$row['CODTIPOSERV'];
			$talleres[$i]=$taller;
			$i++;
		}
		$response->talleres=$talleres;

		$auditor=[];
		$obj=new stdClass();
		$obj->CODUSU="0";
		$obj->NOMUSU="(TODOS)";
		$auditor[0]=$obj;
		$i=1;
		$sql="BEGIN SP_AT_SELECT_AUDITORES(:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$taller=new stdClass();
			$taller->NOMUSU=utf8_encode($row['NOMUSU']);
			$taller->CODUSU=$row['CODUSU'];
			$auditor[$i]=$taller;
			$i++;
		}
		$response->auditor=$auditor;
		
		$tipoauditoria=[];
		$i=0;
		$sql="BEGIN SP_AT_SELECT_TIPAUDS(:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$taller=new stdClass();
			$taller->DESTAD=utf8_encode($row['DESTAD']);
			$taller->CODTAD=$row['CODTAD'];
			$tipoauditoria[$i]=$taller;
			$i++;
		}
		$response->tipoauditoria=$tipoauditoria;
		
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