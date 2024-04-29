<?php
	set_time_limit(240);
	include("connection.php");
	$response=new stdClass();

	$titulo="";
	if ($_POST['codprv']=="0") {
		$titulo.="(TODOS)";
	}else{
		$sql="BEGIN SP_AUDTEL_SELECT_PRVIND(:CODPRV,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$titulo.=utf8_encode($row['DESPRV']);
	}
	if ($_POST['codcli']=="0") {
		$titulo.=" / (TODOS)";
	}else{
		$sql="BEGIN SP_AUDTEL_SELECT_PRVIND(:CODCLI,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$titulo.=" / ".utf8_encode($row['DESPRV']);
	}
	if ($_POST['codusu']=="0") {
		$titulo.=" / (TODOS)";
	}else{
		$titulo.=" / ".$_POST['codusu'];
	}
	if ($_POST['codusueje']=="0") {
		$titulo.=" / (TODOS)";
	}else{
		$titulo.=" / ".$_POST['codusueje'];
	}

	$ar_fecha=explode('-', $_POST['fecini']);
	$fecini=$ar_fecha[0].$ar_fecha[1].$ar_fecha[2];

	$ar_fefin=explode('-', $_POST['fecfin']);
	$fecfin=$ar_fefin[0].$ar_fefin[1].$ar_fefin[2];

	$response->titulo=$titulo." / Del ".$ar_fecha[2]."-".$ar_fecha[1]."-".$ar_fecha[0]." al ".$ar_fefin[2]."-".$ar_fefin[1]."-".$ar_fefin[0];

	$detalletotal=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	$opcion=-1;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	oci_bind_by_name($stmt, ':RESULTADO', $_POST['resultado']);
	oci_bind_by_name($stmt, ':CODAREA', $_POST['codarea']);
	oci_bind_by_name($stmt, ':CODTON', $_POST['codton']);
	oci_bind_by_name($stmt, ':CODAPA', $_POST['codapa']);
	oci_bind_by_name($stmt, ':CODESTDIM', $_POST['codestdim']);
	oci_bind_by_name($stmt, ':RANGO', $_POST['rango']);
	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
		$obj->CANTOT=str_replace(",",".",$row['CANTOT']);
		$detalletotal[$i]=$obj;
		$i++;
	}
	$response->detalletotal=$detalletotal;

	$detalle1=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	oci_bind_by_name($stmt, ':RESULTADO', $_POST['resultado']);
	oci_bind_by_name($stmt, ':CODAREA', $_POST['codarea']);
	oci_bind_by_name($stmt, ':CODTON', $_POST['codton']);
	oci_bind_by_name($stmt, ':CODAPA', $_POST['codapa']);
	oci_bind_by_name($stmt, ':CODESTDIM', $_POST['codestdim']);
	oci_bind_by_name($stmt, ':RANGO', $_POST['rango']);
	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	$opcion=0;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$sumpes=0;
	$sumcan=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->BLOQUE=$row['BLOQUE'];
		$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
		$obj->CANTOT=str_replace(",",".",$row['CANTOT']);
		$sumpes+=floatval($row['PESTOT']);
		$sumcan+=floatval($row['CANTOT']);
		$detalle1[$i]=$obj;
		$i++;
	}
	$response->detalle1=$detalle1;
	$response->sumpesblo=$sumpes;
	$response->sumcanblo=$sumcan;

	//TONO
	$detalletono=[];
	$tonos=[];
	$tono='';
	$i=0;
	$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	oci_bind_by_name($stmt, ':RESULTADO', $_POST['resultado']);
	oci_bind_by_name($stmt, ':CODAREA', $_POST['codarea']);
	oci_bind_by_name($stmt, ':CODTON', $_POST['codton']);
	oci_bind_by_name($stmt, ':CODAPA', $_POST['codapa']);
	oci_bind_by_name($stmt, ':CODESTDIM', $_POST['codestdim']);
	oci_bind_by_name($stmt, ':RANGO', $_POST['rango']);
	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	$opcion=1;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$sumpes=0;
	$sumcan=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->DESTON=utf8_decode($row['DESTON']);
		$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
		$obj->CANTOT=str_replace(",",".",$row['CANTOT']);
		$sumpes+=floatval($row['PESTOT']);
		$sumcan+=floatval($row['CANTOT']);
		$detalletono[$i]=$obj;
		$obj=new stdClass();
		$obj->CODTON=$row['CODTON'];
		if ($i==0) {
			$tono=$row['CODTON'];
		}
		$obj->DESTON=utf8_decode($row['DESTON']);
		$tonos[$i]=$obj;
		$i++;
	}
	$response->tonos=$tonos;
	$response->detalletono=$detalletono;
	$response->sumpestono=$sumpes;
	$response->sumcantono=$sumcan;

	//TONO - COLOR
	$detalletonocolor=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	oci_bind_by_name($stmt, ':RESULTADO', $_POST['resultado']);
	oci_bind_by_name($stmt, ':CODAREA', $_POST['codarea']);
	oci_bind_by_name($stmt, ':CODTON', $tono);
	oci_bind_by_name($stmt, ':CODAPA', $_POST['codapa']);
	oci_bind_by_name($stmt, ':CODESTDIM', $_POST['codestdim']);
	oci_bind_by_name($stmt, ':RANGO', $_POST['rango']);
	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	$opcion=12;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$sumpes=0;
	$sumcan=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODCOL=$row['CODCOL'];
		$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
		$obj->CANTOT=str_replace(",",".",$row['CANTOT']);
		$sumpes+=floatval($row['PESTOT']);
		$sumcan+=floatval($row['CANTOT']);
		$detalletonocolor[$i]=$obj;
		$i++;
	}
	$response->detalletonocolor=$detalletonocolor;
	$response->sumpestonocolor=$sumpes;
	$response->sumcantonocolor=$sumcan;

	//TONO - TELA
	$detalletonotela=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	oci_bind_by_name($stmt, ':RESULTADO', $_POST['resultado']);
	oci_bind_by_name($stmt, ':CODAREA', $_POST['codarea']);
	oci_bind_by_name($stmt, ':CODTON', $tono);
	oci_bind_by_name($stmt, ':CODAPA', $_POST['codapa']);
	oci_bind_by_name($stmt, ':CODESTDIM', $_POST['codestdim']);
	oci_bind_by_name($stmt, ':RANGO', $_POST['rango']);
	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	$opcion=13;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$sumpes=0;
	$sumcan=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->DESTEL=utf8_decode($row['DESTEL']);
		$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
		$obj->CANTOT=str_replace(",",".",$row['CANTOT']);
		$sumpes+=floatval($row['PESTOT']);
		$sumcan+=floatval($row['CANTOT']);
		$detalletonotela[$i]=$obj;
		$i++;
	}
	$response->detalletonotela=$detalletonotela;
	$response->sumpestonotela=$sumpes;
	$response->sumcantonotela=$sumcan;

	//APARIENCIA
	$codarea='';
	$codareas=[];
	$detalleapa=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	oci_bind_by_name($stmt, ':RESULTADO', $_POST['resultado']);
	oci_bind_by_name($stmt, ':CODAREA', $_POST['codarea']);
	oci_bind_by_name($stmt, ':CODTON', $_POST['codton']);
	oci_bind_by_name($stmt, ':CODAPA', $_POST['codapa']);
	oci_bind_by_name($stmt, ':CODESTDIM', $_POST['codestdim']);
	oci_bind_by_name($stmt, ':RANGO', $_POST['rango']);
	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	$opcion=2;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$sumpes=0;
	$sumcan=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->DSCAREAD=utf8_decode($row['DSCAREAD']);
		$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
		$obj->CANTOT=str_replace(",",".",$row['CANTOT']);
		$sumpes+=floatval($row['PESTOT']);
		$sumcan+=floatval($row['CANTOT']);
		$detalleapa[$i]=$obj;
		$obj=new stdClass();
		$obj->CODAREAD=$row['CODAREAD'];
		if ($i==0) {
			$codarea=$row['CODAREAD'];
		}
		$obj->DSCAREAD=utf8_decode($row['DSCAREAD']);
		$codareas[$i]=$obj;
		$i++;
	}
	$response->detalleapa=$detalleapa;
	$response->sumpesapa=$sumpes;
	$response->sumcanapa=$sumcan;
	$response->codareas=$codareas;

	//APARIENCIA DEFECTO
	$codapas=[];
	$codapa='';
	$detalleapadef=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	oci_bind_by_name($stmt, ':RESULTADO', $_POST['resultado']);
	oci_bind_by_name($stmt, ':CODAREA', $codarea);
	oci_bind_by_name($stmt, ':CODTON', $_POST['codton']);
	oci_bind_by_name($stmt, ':CODAPA', $_POST['codapa']);
	oci_bind_by_name($stmt, ':CODESTDIM', $_POST['codestdim']);
	oci_bind_by_name($stmt, ':RANGO', $_POST['rango']);
	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	$opcion=21;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$sumpes=0;
	$sumcan=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->DSCAREAD=utf8_decode($row['DSCAREAD']);
		$obj->DESAPA=utf8_encode($row['DESAPA']);
		$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
		$obj->CANTOT=str_replace(",",".",$row['CANTOT']);
		$sumpes+=floatval($row['PESTOT']);
		$sumcan+=floatval($row['CANTOT']);
		$detalleapadef[$i]=$obj;
		$obj=new stdClass();
		$obj->CODAPA=$row['CODAPA'];
		if ($i==0) {
			$codapa=$row['CODAPA'];
		}
		$obj->DESAPA=utf8_encode($row['DESAPA']);
		$codapas[$i]=$obj;
		$i++;
	}
	$response->detalleapadef=$detalleapadef;
	$response->codapas=$codapas;
	$response->sumpesapadef=$sumpes;
	$response->sumcanapadef=$sumcan;

	//APARIENCIA COLOR
	$detalleapacol=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	oci_bind_by_name($stmt, ':RESULTADO', $_POST['resultado']);
	oci_bind_by_name($stmt, ':CODAREA', $codarea);
	oci_bind_by_name($stmt, ':CODTON', $_POST['codton']);
	oci_bind_by_name($stmt, ':CODAPA', $codapa);
	oci_bind_by_name($stmt, ':CODESTDIM', $_POST['codestdim']);
	oci_bind_by_name($stmt, ':RANGO', $_POST['rango']);
	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	$opcion=22;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$sumpes=0;
	$sumcan=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODCOL=$row['CODCOL'];
		$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
		$obj->CANTOT=str_replace(",",".",$row['CANTOT']);
		$sumpes+=floatval($row['PESTOT']);
		$sumcan+=floatval($row['CANTOT']);
		$detalleapacol[$i]=$obj;
		$i++;
	}
	$response->detalleapacol=$detalleapacol;
	$response->sumpesapacol=$sumpes;
	$response->sumcanapacol=$sumcan;

	//APARIENCIA TELA
	$detalleapatel=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	oci_bind_by_name($stmt, ':RESULTADO', $_POST['resultado']);
	oci_bind_by_name($stmt, ':CODAREA', $codarea);
	oci_bind_by_name($stmt, ':CODTON', $_POST['codton']);
	oci_bind_by_name($stmt, ':CODAPA', $codapa);
	oci_bind_by_name($stmt, ':CODESTDIM', $_POST['codestdim']);
	oci_bind_by_name($stmt, ':RANGO', $_POST['rango']);
	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	$opcion=23;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$sumpes=0;
	$sumcan=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->DESTEL=utf8_encode($row['DESTEL']);
		$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
		$obj->CANTOT=str_replace(",",".",$row['CANTOT']);
		$sumpes+=floatval($row['PESTOT']);
		$sumcan+=floatval($row['CANTOT']);
		$detalleapatel[$i]=$obj;
		$i++;
	}
	$response->detalleapatel=$detalleapatel;
	$response->sumpesapatel=$sumpes;
	$response->sumcanapatel=$sumcan;

	//EST. DIM.
	$estdim='';
	$estdims=[];
	$rango='';
	$rangos=[];
	$detalleed=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	oci_bind_by_name($stmt, ':RESULTADO', $_POST['resultado']);
	oci_bind_by_name($stmt, ':CODAREA', $_POST['codarea']);
	oci_bind_by_name($stmt, ':CODTON', $_POST['codton']);
	oci_bind_by_name($stmt, ':CODAPA', $_POST['codapa']);
	oci_bind_by_name($stmt, ':CODESTDIM', $_POST['codestdim']);
	oci_bind_by_name($stmt, ':RANGO', $_POST['rango']);
	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	$opcion=3;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$sumpes=0;
	$sumcan=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->DESESTDIM=utf8_decode($row['DESESTDIM']);
		$obj->RANGO=utf8_decode($row['RANGO']);
		$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
		$obj->CANTOT=str_replace(",",".",$row['CANTOT']);
		$sumpes+=floatval($row['PESTOT']);
		$sumcan+=floatval($row['CANTOT']);
		$detalleed[$i]=$obj;
		$obj=new stdClass();
		$obj->CODESTDIM=$row['CODESTDIM'];
		if ($i==0) {
			$estdim=$row['CODESTDIM'];
			$rango=$row['RANGO'];
		}
		$obj->DESESTDIM=utf8_decode($row['DESESTDIM']);
		$estdims[$i]=$obj;
		$obj=new stdClass();
		$obj->RANGO=$row['RANGO'];
		$rangos[$i]=$obj;
		$i++;
	}
	$response->estdims=$estdims;
	$response->rangos=$rangos;
	$response->detalleed=$detalleed;
	$response->sumpesed=$sumpes;
	$response->sumcaned=$sumcan;

	$detalleedcol=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	oci_bind_by_name($stmt, ':RESULTADO', $_POST['resultado']);
	oci_bind_by_name($stmt, ':CODAREA', $_POST['codarea']);
	oci_bind_by_name($stmt, ':CODTON', $_POST['codton']);
	oci_bind_by_name($stmt, ':CODAPA', $_POST['codapa']);
	oci_bind_by_name($stmt, ':CODESTDIM', $estdim);
	oci_bind_by_name($stmt, ':RANGO', $rango);
	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	$opcion=32;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$sumpes=0;
	$sumcan=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODCOL=utf8_decode($row['CODCOL']);
		$obj->RANGO=utf8_decode($row['RANGO']);
		$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
		$obj->CANTOT=str_replace(",",".",$row['CANTOT']);
		$sumpes+=floatval($row['PESTOT']);
		$sumcan+=floatval($row['CANTOT']);
		$detalleedcol[$i]=$obj;
		$i++;
	}
	$response->detalleedcol=$detalleedcol;
	$response->sumpesedcol=$sumpes;
	$response->sumcanedcol=$sumcan;


	$detalleedtel=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_REP_BLOQUESAUX(:FECINI,:FECFIN,:CODPRV,:CODCLI,:CODUSU,:CODUSUEJE,:OPCION,:RESULTADO,:CODAREA,:CODTON,:CODAPA,:CODESTDIM,:RANGO,:CODDEF,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	oci_bind_by_name($stmt, ':RESULTADO', $_POST['resultado']);
	oci_bind_by_name($stmt, ':CODAREA', $_POST['codarea']);
	oci_bind_by_name($stmt, ':CODTON', $_POST['codton']);
	oci_bind_by_name($stmt, ':CODAPA', $_POST['codapa']);
	oci_bind_by_name($stmt, ':CODESTDIM', $estdim);
	oci_bind_by_name($stmt, ':RANGO', $rango);
	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	$opcion=33;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$sumpes=0;
	$sumcan=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->DESTEL=utf8_encode($row['DESTEL']);
		$obj->RANGO=utf8_encode($row['RANGO']);
		$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
		$obj->CANTOT=str_replace(",",".",$row['CANTOT']);
		$sumpes+=floatval($row['PESTOT']);
		$sumcan+=floatval($row['CANTOT']);
		$detalleedtel[$i]=$obj;
		$i++;
	}
	$response->detalleedtel=$detalleedtel;
	$response->sumpesedtel=$sumpes;
	$response->sumcanedtel=$sumcan;


	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>