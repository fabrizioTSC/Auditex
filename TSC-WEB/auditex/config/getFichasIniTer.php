<?php
	include('connection.php');
	$response=new stdClass();

	$titulo="";
	if ($_POST['codsed']=="0") {
		$titulo.="SEDE: (TODOS) / ";
	}else{
		$sql="BEGIN SP_AT_SELECT_SEDE(:CODSED,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODSED', $_POST['codsed']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$titulo.="SEDE: ".utf8_encode($row['DESSEDE'])." / ";
	}
	if ($_POST['codtipser']=="0") {
		$titulo.="TIPO SERVICIO: (TODOS) / ";
	}else{
		$sql="BEGIN SP_AT_SELECT_TIPSER(:CODTIPSER,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$titulo.="TIPO SERVICIO: ".utf8_encode($row['DESTIPSERV'])." / ";
	}
	if ($_POST['codtll']=="0") {
		$titulo.="TALLER: (TODOS)";
	}else{
		$sql="BEGIN SP_AT_SELECT_TALLER(:CODTLL,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$titulo.="TALLER: ".utf8_encode($row['DESTLL']);
	}
	
	if ($_POST['tipo']==2) {
		$titulo.=" / Tipo: Iniciadas";
	}else{
		$titulo.=" / Tipo: Terminadas";
	}

	$ar_fecini=explode('-',$_POST['fecini']);
	$ar_fecfin=explode('-',$_POST['fecfin']);

	$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
	$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];

    $titulo= $titulo." / Del ".$ar_fecini[2]."-".$ar_fecini[1]."-".$ar_fecini[0]." al ".$ar_fecfin[2]."-".$ar_fecfin[1]."-".$ar_fecfin[0];		

    $response->titulo=$titulo;
	
	$fichas=array();
	$i=0;
	$sql="begin SP_AT_SELECT_AUDINIFINTALLER(:CODTLL,:CODSED,:CODTIPSER,:TIPO,:FECINI,:FECFIN,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt,':CODTLL', $_POST['codtll']);
	oci_bind_by_name($stmt,':CODSED', $_POST['codsed']);
	oci_bind_by_name($stmt,':CODTIPSER', $_POST['codtipser']);
	oci_bind_by_name($stmt,':TIPO', $_POST['tipo']);
	oci_bind_by_name($stmt,':FECINI', $fecini);
	oci_bind_by_name($stmt,':FECFIN', $fecfin);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
		
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$ficha=new stdClass();
		$ficha->CODFIC=$row['CODFIC'];
		$ficha->CANPAR=$row['CANPAR'];
		$ficha->DESCLI=utf8_encode($row['DESCLI']);
		$ficha->FECMOV=$row['FECMOV'];
		$ficha->USUMOV=utf8_encode($row['USUMOV']);
		$ficha->OBSERVACION=utf8_encode($row['OBSERVACION']);
		$ficha->CODTLL=utf8_encode($row['CODTLL']);
		$ficha->DESTLL=utf8_encode($row['DESTLL']);
		$ficha->CODSED=$row['CODSEDE'];
		$ficha->DESSED=utf8_encode($row['DESSEDE']);
		$ficha->CODTIPSER=$row['CODTIPOSERV'];
		$ficha->DESTIPSER=utf8_encode($row['DESTIPSERV']);
		$ficha->TIPO=utf8_encode($row['MODOINI']);
		$fichas[$i]=$ficha;
		$i++;
	}

	if (oci_num_rows($OUTPUT_CUR)==0) {			
		$response->state=false;
		$response->description="No hay fichas para el taller!";
	}else{
		$response->state=true;
		$response->fichas=$fichas;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>