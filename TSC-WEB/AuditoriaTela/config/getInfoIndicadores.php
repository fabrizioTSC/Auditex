<?php
	set_time_limit(240);
	include("connection.php");
	$response=new stdClass();

	$titulo="";
	if ($_POST['codprv']=="0") {
		$titulo.="PROVEEDOR: (TODOS)";
	}else{
		$sql="BEGIN SP_AUDTEL_SELECT_PRVIND(:CODPRV,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$titulo.="PROVEEDOR: ".utf8_encode($row['DESPRV']);
	}
	if ($_POST['codusu']=="0") {
		$titulo.=" / AUDITOR: (TODOS)";
	}else{
		$titulo.=" / AUDITOR: ".$_POST['codusu'];
	}
	if ($_POST['codusueje']=="0") {
		$titulo.=" / SUPERVISOR: (TODOS)";
	}else{
		$titulo.=" / SUPERVISOR: ".$_POST['codusueje'];
	}
	switch ($_POST['bloque']) {
		case '0':
			$titulo.=" / BLOQUE: (TODOS)";
			break;		
		case '1':
			$titulo.=" / BLOQUE: Tono";
			break;
		case '2':
			$titulo.=" / BLOQUE: Apariencia";
			break;
		case '3':
			$titulo.=" / BLOQUE: Estabilidad Dimensional";
			break;
		case '4':
			$titulo.=" / BLOQUE: Defectos";
			break;
	}

	$ar_fecha=explode('-', $_POST['fecha']);
	$fecha=$ar_fecha[2].$ar_fecha[1].$ar_fecha[0];

	$response->titulo=$titulo." / ".$ar_fecha[2]."-".$ar_fecha[1]."-".$ar_fecha[0];

	$anios=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_INDRESAUX(:CODPRV,:CODUSU,:CODUSUEJE,:BLOQUE,:FECHA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	oci_bind_by_name($stmt, ':BLOQUE', $_POST['bloque']);
	oci_bind_by_name($stmt, ':FECHA', $fecha);
	$opcion=0;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->ANHO=$row['ANHO'];
		$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
		$obj->PESAPR=str_replace(",",".",$row['PESAPR']);
		$obj->PESCON=str_replace(",",".",$row['PESCON']);
		$obj->PESREC=str_replace(",",".",$row['PESREC']);
		$obj->CANTOT=str_replace(",",".",$row['CANTOT']);
		$obj->CANAPR=str_replace(",",".",$row['CANAPR']);
		$obj->CANCON=str_replace(",",".",$row['CANCON']);
		$obj->CANREC=str_replace(",",".",$row['CANREC']);
		$anios[$i]=$obj;
		$i++;
	}
	$response->anios=$anios;

	$meses=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_INDRESAUX(:CODPRV,:CODUSU,:CODUSUEJE,:BLOQUE,:FECHA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	oci_bind_by_name($stmt, ':BLOQUE', $_POST['bloque']);
	oci_bind_by_name($stmt, ':FECHA', $fecha);
	$opcion=1;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->ANHO=$row['ANHO'];
		$obj->MES=$row['MES'];
		$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
		$obj->PESAPR=str_replace(",",".",$row['PESAPR']);
		$obj->PESCON=str_replace(",",".",$row['PESCON']);
		$obj->PESREC=str_replace(",",".",$row['PESREC']);
		$obj->CANTOT=str_replace(",",".",$row['CANTOT']);
		$obj->CANAPR=str_replace(",",".",$row['CANAPR']);
		$obj->CANCON=str_replace(",",".",$row['CANCON']);
		$obj->CANREC=str_replace(",",".",$row['CANREC']);
		$meses[$i]=$obj;
		$i++;
	}
	$response->meses=$meses;

	$semanas=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_INDRESAUX(:CODPRV,:CODUSU,:CODUSUEJE,:BLOQUE,:FECHA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	oci_bind_by_name($stmt, ':BLOQUE', $_POST['bloque']);
	oci_bind_by_name($stmt, ':FECHA', $fecha);
	$opcion=2;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->NUMERO_SEMANA=$row['NUMERO_SEMANA'];
		$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
		$obj->PESAPR=str_replace(",",".",$row['PESAPR']);
		$obj->PESCON=str_replace(",",".",$row['PESCON']);
		$obj->PESREC=str_replace(",",".",$row['PESREC']);
		$obj->CANTOT=str_replace(",",".",$row['CANTOT']);
		$obj->CANAPR=str_replace(",",".",$row['CANAPR']);
		$obj->CANCON=str_replace(",",".",$row['CANCON']);
		$obj->CANREC=str_replace(",",".",$row['CANREC']);
		$semanas[$i]=$obj;	
		$i++;
	}
	$response->semanas=$semanas;

	//////////DETALLE POR PROVEEDOR

	$param=[];
	$i=0;
	$sql="BEGIN SP_AT_SELECT_PARAMETROSREPORTE(:CODTAD,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$codtad=10;
	oci_bind_by_name($stmt, ':CODTAD', $codtad);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODRAN=$row['CODRAN'];
		$obj->VALOR=$row['VALOR'];
		$param[$i]=$obj;
		$i++;
	}
	$response->param=$param;

	if ($_POST['codprv']=="0") {
		$proveedores=[];
		$ant_prv="";
		$p=0;

		$headers=[];
		$ant_hea="";
		$h=0;
		
		$aniosprv=[];
		$i=0;
		$sql="BEGIN SP_AUDTEL_INDRESPRVAUX(:FECHA,:OPCION,:CODUSU,:CODUSUEJE,:BLOQUE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':FECHA', $fecha);
		$opcion=0;
		oci_bind_by_name($stmt, ':OPCION', $opcion);
		oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
		oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
		oci_bind_by_name($stmt, ':BLOQUE', $_POST['bloque']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			if (utf8_encode($row['DESCLI'])!=$ant_prv) {	
				$ant_prv=utf8_encode($row['DESCLI']);		
				$proveedores[$p]=$ant_prv;
				$p++;
			}
			$val=true;
			$tam=count($headers);
			$j=0;
			while($val==true and $j<$tam){
				if ($headers[$j]==$row['ANHO']) {
					$val=false;
				}
				$j++;
			}
			if ($val) {
				$ant_hea=$row['ANHO'];
				$headers[$h]=$ant_hea;
				$h++;
			}
			$obj=new stdClass();
			$obj->DESPRV=utf8_encode($row['DESCLI']);
			$obj->ANHO=$row['ANHO'];
			$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
			$obj->PESAPR=str_replace(",",".",$row['PESAPR']);
			$obj->PESCON=str_replace(",",".",$row['PESCON']);
			$obj->PESREC=str_replace(",",".",$row['PESREC']);
			$aniosprv[$i]=$obj;
			$i++;
		}
		$response->aniosprv=$aniosprv;
		$response->proveedores=$proveedores;

		$mesesprv=[];
		$i=0;
		$sql="BEGIN SP_AUDTEL_INDRESPRVAUX(:FECHA,:OPCION,:CODUSU,:CODUSUEJE,:BLOQUE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':FECHA', $fecha);
		$opcion=1;
		oci_bind_by_name($stmt, ':OPCION', $opcion);
		oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
		oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
		oci_bind_by_name($stmt, ':BLOQUE', $_POST['bloque']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$val=true;
			$tam=count($headers);
			$j=0;
			while($val==true and $j<$tam){
				if ($headers[$j]==$row['MES']) {
					$val=false;
				}
				$j++;
			}
			if ($val) {
				$ant_hea=$row['MES'];
				$headers[$h]=$ant_hea;
				$h++;
			}
			$obj=new stdClass();
			$obj->DESPRV=utf8_encode($row['DESCLI']);
			$obj->ANHO=$row['ANHO'];
			$obj->MES=$row['MES'];
			$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
			$obj->PESAPR=str_replace(",",".",$row['PESAPR']);
			$obj->PESCON=str_replace(",",".",$row['PESCON']);
			$obj->PESREC=str_replace(",",".",$row['PESREC']);
			$mesesprv[$i]=$obj;
			$i++;
		}
		$response->mesesprv=$mesesprv;

		$semanasprv=[];
		$i=0;
		$sql="BEGIN SP_AUDTEL_INDRESPRVAUX(:FECHA,:OPCION,:CODUSU,:CODUSUEJE,:BLOQUE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':FECHA', $fecha);
		$opcion=2;
		oci_bind_by_name($stmt, ':OPCION', $opcion);
		oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
		oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
		oci_bind_by_name($stmt, ':BLOQUE', $_POST['bloque']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$val=true;
			$tam=count($headers);
			$j=0;
			while($val==true and $j<$tam){
				if ($headers[$j]=="S. ".$row['NUMERO_SEMANA']) {
					$val=false;
				}
				$j++;
			}
			if ($val) {
				$ant_hea="S. ".$row['NUMERO_SEMANA'];
				$headers[$h]=$ant_hea;
				$h++;
			}
			$obj=new stdClass();
			$obj->DESPRV=utf8_encode($row['DESCLI']);
			//$obj->ANHO=$row['ANIO'];
			$obj->NUMERO_SEMANA=$row['NUMERO_SEMANA'];
			$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
			$obj->PESAPR=str_replace(",",".",$row['PESAPR']);
			$obj->PESCON=str_replace(",",".",$row['PESCON']);
			$obj->PESREC=str_replace(",",".",$row['PESREC']);
			$semanasprv[$i]=$obj;
			$i++;
		}
		$response->semanasprv=$semanasprv;
		$response->headers=$headers;
	}
	//if ($_POST['codcli']=="0") {
		$clientes=[];
		$ant_prv="";
		$p=0;

		$headerscli=[];
		$ant_hea="";
		$h=0;
		
		$anioscli=[];
		$i=0;
		$sql="BEGIN SP_AUDTEL_INDRESCLI(:FECHA,:OPCION,:CODUSU,:CODUSUEJE,:CODPRV,:BLOQUE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':FECHA', $fecha);
		$opcion=0;
		oci_bind_by_name($stmt, ':OPCION', $opcion);
		oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
		oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
		oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
		oci_bind_by_name($stmt, ':BLOQUE', $_POST['bloque']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			if (utf8_encode($row['DESCLI'])!=$ant_prv) {	
				$ant_prv=utf8_encode($row['DESCLI']);		
				$clientes[$p]=$ant_prv;
				$p++;
			}
			$val=true;
			$tam=count($headerscli);
			$j=0;
			while($val==true and $j<$tam){
				if ($headerscli[$j]==$row['ANHO']) {
					$val=false;
				}
				$j++;
			}
			if ($val) {
				$ant_hea=$row['ANHO'];
				$headerscli[$h]=$ant_hea;
				$h++;
			}
			$obj=new stdClass();
			$obj->DESPRV=utf8_encode($row['DESCLI']);
			$obj->ANHO=$row['ANHO'];
			$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
			$obj->PESAPR=str_replace(",",".",$row['PESAPR']);
			$obj->PESCON=str_replace(",",".",$row['PESCON']);
			$obj->PESREC=str_replace(",",".",$row['PESREC']);
			$anioscli[$i]=$obj;
			$i++;
		}
		$response->anioscli=$anioscli;
		$response->clientes=$clientes;

		$mesescli=[];
		$i=0;
		$sql="BEGIN SP_AUDTEL_INDRESCLI(:FECHA,:OPCION,:CODUSU,:CODUSUEJE,:CODPRV,:BLOQUE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':FECHA', $fecha);
		$opcion=1;
		oci_bind_by_name($stmt, ':OPCION', $opcion);
		oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
		oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
		oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
		oci_bind_by_name($stmt, ':BLOQUE', $_POST['bloque']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$val=true;
			$tam=count($headerscli);
			$j=0;
			while($val==true and $j<$tam){
				if ($headerscli[$j]==$row['MES']) {
					$val=false;
				}
				$j++;
			}
			if ($val) {
				$ant_hea=$row['MES'];
				$headerscli[$h]=$ant_hea;
				$h++;
			}
			$obj=new stdClass();
			$obj->DESPRV=utf8_encode($row['DESCLI']);
			$obj->ANHO=$row['ANHO'];
			$obj->MES=$row['MES'];
			$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
			$obj->PESAPR=str_replace(",",".",$row['PESAPR']);
			$obj->PESCON=str_replace(",",".",$row['PESCON']);
			$obj->PESREC=str_replace(",",".",$row['PESREC']);
			$mesescli[$i]=$obj;
			$i++;
		}
		$response->mesescli=$mesescli;

		$semanascli=[];
		$i=0;
		$sql="BEGIN SP_AUDTEL_INDRESCLI(:FECHA,:OPCION,:CODUSU,:CODUSUEJE,:CODPRV,:BLOQUE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':FECHA', $fecha);
		$opcion=2;
		oci_bind_by_name($stmt, ':OPCION', $opcion);
		oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
		oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
		oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
		oci_bind_by_name($stmt, ':BLOQUE', $_POST['bloque']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$val=true;
			$tam=count($headerscli);
			$j=0;
			while($val==true and $j<$tam){
				if ($headerscli[$j]=="S. ".$row['NUMERO_SEMANA']) {
					$val=false;
				}
				$j++;
			}
			if ($val) {
				$ant_hea="S. ".$row['NUMERO_SEMANA'];
				$headerscli[$h]=$ant_hea;
				$h++;
			}
			$obj=new stdClass();
			$obj->DESPRV=utf8_encode($row['DESCLI']);
			//$obj->ANHO=$row['ANIO'];
			$obj->NUMERO_SEMANA=$row['NUMERO_SEMANA'];
			$obj->PESTOT=str_replace(",",".",$row['PESTOT']);
			$obj->PESAPR=str_replace(",",".",$row['PESAPR']);
			$obj->PESCON=str_replace(",",".",$row['PESCON']);
			$obj->PESREC=str_replace(",",".",$row['PESREC']);
			$semanascli[$i]=$obj;
			$i++;
		}
		$response->semanascli=$semanascli;
		$response->headerscli=$headerscli;
	//}



	
	//DETALLE NIVEL 1 - SEMANA
	$defuno=[];
	$i=0;
	$sumDU=0;
	$coddefuno=0;
	$coddefdos=0;


	$sql="BEGIN SP_AUDTEL_INDRESAUX(:CODPRV,:CODUSU,:CODUSUEJE,:BLOQUE,:FECHA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	oci_bind_by_name($stmt, ':BLOQUE', $_POST['bloque']);
	oci_bind_by_name($stmt, ':FECHA', $fecha);
	$opcion=3;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		if ($i==0) {
			$coddefuno=$row['CODAREA'];
		}
		if ($i==1) {
			$coddefdos=$row['CODAREA'];
		}
		$obj=new stdClass();
		$obj->CODFAMILIA=$row['CODAREA'];
		$obj->DSCFAMILIA=utf8_encode($row['DESAREA']);
		$obj->SUMA=$row['SUMA'];
		$defuno[$i]=$obj;
		$i++;
		$sumDU+=(int)$row['SUMA'];
	}
	$response->defuno=$defuno;
	$response->sumDU=$sumDU;

	//DETALLE NIVEL 1 - MES
	$defunomes=[];
	$i=0;
	$sumDUM=0;
	$coddefunoM=0;
	$coddefdosM=0;
	$sql="BEGIN SP_AUDTEL_INDRESAUX(:CODPRV,:CODUSU,:CODUSUEJE,:BLOQUE,:FECHA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	oci_bind_by_name($stmt, ':BLOQUE', $_POST['bloque']);
	oci_bind_by_name($stmt, ':FECHA', $fecha);
	$opcion=4;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		if ($i==0) {
			$coddefunoM=$row['CODAREA'];
		}
		if ($i==1) {
			$coddefdosM=$row['CODAREA'];
		}
		$obj=new stdClass();
		$obj->CODFAMILIA=$row['CODAREA'];
		$obj->DSCFAMILIA=utf8_encode($row['DESAREA']);
		$obj->SUMA=$row['SUMA'];
		$defunomes[$i]=$obj;
		$i++;
		$sumDUM+=(int)$row['SUMA'];
	}
	$response->defunomes=$defunomes;
	$response->sumDUM=$sumDUM;

	////////////// RESULTADO DE LOS 2 MAYORES - Semana
	$defuno=[];
	$i=0;
	$sumDefectosU=0;
	$sql="BEGIN SP_AUDTEL_INDRESULTADOS2(:CODPRV,:CODUSU,:CODUSUEJE,:FECHA,:CODAREA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	oci_bind_by_name($stmt, ':FECHA', $fecha);
	oci_bind_by_name($stmt, ':CODAREA', $coddefuno);
	$opcion=0;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODDEF=$row['CODDEF'];
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		if ($row['CANDEF']==null) {
			$sumDefectosU+=0;
			$obj->SUMA=0;
		}else{
			$sumDefectosU+=(int)$row['CANDEF'];
			$obj->SUMA=$row['CANDEF'];
		}
		$defuno[$i]=$obj;
		$i++;
	}
	$response->defectosU=$defuno;
	$response->sumDefectosU=$sumDefectosU;

	//SEGUNDO FAMDEFECTO MAS GRANDE
	$defuno=[];
	$i=0;
	$sumDefectosD=0;
	$sql="BEGIN SP_AUDTEL_INDRESULTADOS2(:CODPRV,:CODUSU,:CODUSUEJE,:FECHA,:CODAREA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	oci_bind_by_name($stmt, ':FECHA', $fecha);
	oci_bind_by_name($stmt, ':CODAREA', $coddefdos);
	$opcion=0;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODDEF=$row['CODDEF'];
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		$obj->SUMA=$row['CANDEF'];
		$defuno[$i]=$obj;
		$i++;
		$sumDefectosD+=(int)$row['CANDEF'];
	}
	$response->defectosD=$defuno;
	$response->sumDefectosD=$sumDefectosD;

	//////////////////////////////////////////////////////////////////////////////
	////////////// RESULTADO DE LOS 2 MAYORES - Mes
	$defuno=[];
	$i=0;
	$sumDefectosUM=0;
	$sql="BEGIN SP_AUDTEL_INDRESULTADOS2(:CODPRV,:CODUSU,:CODUSUEJE,:FECHA,:CODAREA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	oci_bind_by_name($stmt, ':FECHA', $fecha);
	oci_bind_by_name($stmt, ':CODAREA', $coddefunoM);
	$opcion=1;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODDEF=$row['CODDEF'];
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		if ($row['CANDEF']==null) {
			$sumDefectosUM+=0;
			$obj->SUMA=0;
		}else{
			$sumDefectosUM+=(int)$row['CANDEF'];
			$obj->SUMA=$row['CANDEF'];
		}
		$defuno[$i]=$obj;
		$i++;
	}
	$response->defectosUM=$defuno;
	$response->sumDefectosUM=$sumDefectosUM;

	//SEGUNDO FAMDEFECTO MAS GRANDE
	$defuno=[];
	$i=0;
	$sumDefectosDM=0;
	$sql="BEGIN SP_AUDTEL_INDRESULTADOS2(:CODPRV,:CODUSU,:CODUSUEJE,:FECHA,:CODAREA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODUSUEJE', $_POST['codusueje']);
	oci_bind_by_name($stmt, ':FECHA', $fecha);
	oci_bind_by_name($stmt, ':CODAREA', $coddefdosM);
	$opcion=1;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODDEF=$row['CODDEF'];
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		$obj->SUMA=$row['CANDEF'];
		$defuno[$i]=$obj;
		$i++;
		$sumDefectosDM+=(int)$row['CANDEF'];
	}
	$response->defectosDM=$defuno;
	$response->sumDefectosDM=$sumDefectosDM;




	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>