<?php
	function add_cero($valor){
		$valor="".$valor;
		if (strlen($valor)>1) {
			if ($valor[0]=="," || $valor[0]==".") {
				return "0".$valor;
			}
			if (($valor[1]=="," && $valor[0]=="-")||($valor[1]=="." && $valor[0]=="-")) {
				return str_replace("-","-0",$valor);
			}
		}
		return $valor;
	}
	include('connection.php');
	$response=new stdClass();

	session_start();
	if($_SESSION['perfil']=="2"){
		$response->btncmcwts=true;
	}else{
		if($_SESSION['perfil']=="3"){
			$response->btncmcprv=true;
		}
	}

	$partida=new stdClass();
	$codprv=$_POST['codprv'];
	$codtel=$_POST['codtel'];
	$sql="BEGIN SP_AUDTEL_SELECT_PARTIDAV2(:PARTIDA,:CODPRV,:CODTEL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	oci_bind_by_name($stmt, ':CODPRV', $codprv);
	oci_bind_by_name($stmt, ':CODTEL', $codtel);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$codtad=""; 
	$numvez="";
	$parte="";
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->FUENTE=$row['FUENTE'];
		$obj->PARTIDA=$row['PARTIDA'];
		$obj->DSCCOL=utf8_encode($row['DSCCOL']);
		$obj->CODTEL=$row['CODTEL'];
		$codtel=$row['CODTEL'];
		$obj->DESTEL=utf8_encode($row['DESTEL']);
		$obj->CODCLI=$row['CODCLI'];
		$obj->DESCLI=utf8_encode($row['DESCLI']);
		$obj->COMPOS=utf8_encode($row['COMPOS']);
		$obj->CODPRV=$row['CODPRV'];
		$obj->TIPO=$row['TIPO'];
		$codprv=$row['CODPRV'];
		$obj->DESPRV=utf8_encode($row['DESPRV']);
		$obj->CODTAD=$row['CODTAD'];
		$codtad=$row['CODTAD'];
		$obj->NUMVEZ=$row['NUMVEZ'];
		$numvez=$row['NUMVEZ'];
		$obj->PARTE=$row['PARTE'];
		$parte=$row['PARTE'];
		$obj->ROLLOS=$row['ROLLOS'];
		$obj->CODAQL=$row['CODAQL'];
		$obj->AQL=$row['AQL'];
		$obj->ROLLOSAUD=$row['ROLLOSAUD'];
		$obj->CALIFICACION=$row['CALIFICACION'];
		$obj->TIPO=$row['TIPO'];
		$obj->PROGRAMA=utf8_encode($row['PROGRAMA']);
		$obj->XFACTORY=$row['FECEMB'];
		$obj->DESTINO=utf8_encode($row['DESTINO']);
		$obj->PESO=str_replace(",",".",$row['PESO']);
		$obj->PESOAPRO=str_replace(",",".",$row['PESOAPRO']);
		$obj->PESOAUD=str_replace(",",".",$row['PESOAUD']);
		$obj->PESOCAI=str_replace(",",".",$row['PESOCAI']);
		$obj->RESULTADO=$row['RESULTADO'];
		$obj->CODCOL=utf8_encode($row['CODCOL']);
		$obj->PESOPRG=str_replace(",",".",$row['PESOPRG']);
		$obj->CODUSUROLLOEJETSC=$row['CODUSUROLLOEJETSC'];
		$obj->RESROLLOEJETSC=$row['RESROLLOEJETSC'];
		$obj->CODUSUESTDIMEJETSC=$row['CODUSUESTDIMEJETSC'];
		$obj->RESESTDIMEJETSC=$row['RESESTDIMEJETSC'];
		$obj->CODUSUAPAEJETSC=$row['CODUSUAPAEJETSC'];
		$obj->RESAPAEJETSC=$row['RESAPAEJETSC'];
		$obj->CODUSUTONEJETSC=$row['CODUSUTONEJETSC'];
		$obj->RESTONEJETSC=$row['RESTONEJETSC'];
		$obj->CODUSUTONAUDTSC=$row['CODUSUTONAUDTSC'];
		$obj->CODUSUAPAAUDTSC=$row['CODUSUAPAAUDTSC'];
		$obj->CODUSUESTDIMAUDTSC=$row['CODUSUESTDIMAUDTSC'];
		$obj->CODUSUROLLOAUDTSC=$row['CODUSUROLLOAUDTSC'];
		$obj->RENDIMIENTO=str_replace(",",".",$row['RENDIMIENTO']);
		$obj->RENMET=str_replace(",",".",$row['RENMET']);
		$obj->RES1=utf8_encode($row['RES1']);
		$obj->RES2=utf8_encode($row['RES2']);
		$obj->RES3=utf8_encode($row['RES3']);
		$obj->RES4=utf8_encode($row['RES4']);
		$obj->CODUSU=$row['CODUSU'];
		$obj->CODUSUEJE=$row['CODUSUEJE'];
		$obj->FECINIAUD=$row['FECINIAUDF'];
		$obj->FECFINAUD=$row['FECFINAUDF'];
		$obj->RUTA=$row['RUTA'];
		$obj->NOMENC1=utf8_encode($row['NOMENC1']);
		$obj->NOMENC2=utf8_encode($row['NOMENC2']);
		$obj->NOMENC3=utf8_encode($row['NOMENC3']);
		$obj->NOMENC4=utf8_encode($row['NOMENC4']);
		$obj->OBSTON=utf8_encode($row['OBSTON']);
		$obj->OBSAPA=utf8_encode($row['OBSAPA']);
		$obj->OBSESTDIM=utf8_encode($row['OBSESTDIM']);
		$obj->OBSDEF=utf8_encode($row['OBSDEF']);
		$obj->ESTILOCLI=$row['ESTILOCLI'];
		$obj->CMCPRV=str_replace(",",".",$row['CMCPRV']);
		$obj->CMCWTS=str_replace(",",".",$row['CMCWTS']);

		// AGREGADO
		$obj->RENDIMIENTOREAL=str_replace(",",".",$row['RENDIMIENTOREAL']);
		//AGREGADO 11/12/2023
		$obj->COMBO=utf8_encode($row['COMBO']);

		$partida=$obj;
	}
	$response->partida=$partida;

	$tonos=array();
	$i=0;
	$sql="BEGIN SP_AUDTEL_SELECT_TONO(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODTON=$row['CODTON'];
		$obj->DESTON=utf8_encode($row['DESTON']);
		$tonos[$i]=$obj;
		$i++;
	}
	$response->tonos=$tonos;

	$apariencia=array();
	$i=0;
	$sql="BEGIN SP_AUDTEL_SELECT_APARIENCIA(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODAPA=$row['CODAPA'];
		$obj->CODAREAD=$row['CODAREAD'];
		$obj->DSCAREAD=utf8_encode($row['DSCAREAD']);
		$obj->DESAPA=utf8_encode($row['DESAPA']);
		$obj->CODGRPREC=$row['CODGRPREC'];
		$apariencia[$i]=$obj;
		$i++;
	}
	$response->apariencia=$apariencia;

	$estdim=array();
	$i=0;
	$sql="BEGIN SP_AUDTEL_SELECT_ESTDIM_V2(:CODTEL,:CODPRV,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTEL', $codtel);
	oci_bind_by_name($stmt, ':CODPRV', $codprv);

	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODESTDIM=$row['CODESTDIM'];
		$obj->VALOR=str_replace(",", ".", $row['VALOR']);
		$obj->TOLERANCIA=str_replace(",", ".", $row['TOLERANCIA']);
		$obj->TOLERANCIA_NEGATIVA=str_replace(",", ".", $row['TOLERANCIA_NEGATIVA']);
		$obj->DIMVAL=$row['DIMVAL'];
		$obj->DIMTOL=$row['DIMTOL'];
		$obj->DESESTDIM=utf8_encode($row['DESESTDIM']);
		$obj->VALIDATOL=$row['VALIDATOL'];
		$obj->TIPOREPOSO=$row['TIPOREPOSO'];

		$estdim[$i]=$obj;
		$i++;
	}
	$response->estdim=$estdim;

	$defectos=array();
	$i=0;
	$sql="BEGIN SP_AUDTEL_SELECT_DEFECTOS(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODARE=$row['CODAREAD'];
		$obj->DESARE=utf8_encode($row['DSCAREAD']);
		$obj->CODDEF=$row['CODDEF'];
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		$obj->PESO=$row['PESO'];
		$defectos[$i]=$obj;
		$i++;
	}
	$response->defectos=$defectos;

	$numrollos=array();
	$i=0;
	$sql="BEGIN SP_AUDTEL_SELECT_PARROL(:PARTIDA,:CODTEL,:CODPRV,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	oci_bind_by_name($stmt, ':CODTEL', $codtel);
	oci_bind_by_name($stmt, ':CODPRV', $codprv);
	oci_bind_by_name($stmt, ':CODTAD', $codtad);
	oci_bind_by_name($stmt, ':NUMVEZ', $numvez);
	oci_bind_by_name($stmt, ':PARTE', $parte);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->NUMROL=$row['NUMROL'];
		$obj->ANCSINREP=str_replace(",", ".",$row['ANCSINREP']);
		$obj->DENSINREP=str_replace(",", ".",$row['DENSINREP']);
		$obj->PESO=str_replace(",", ".",$row['PESO']);
		$obj->ANCTOT=str_replace(",", ".",$row['ANCTOT']);
		$obj->ANCUTI=str_replace(",", ".",$row['ANCUTI']);
		$obj->INCSTD=str_replace(",", ".",$row['INCSTD']);
		$obj->INCDER=str_replace(",", ".",$row['INCDER']);
		$obj->INCIZQ=str_replace(",", ".",$row['INCIZQ']);
		$obj->INCMED=str_replace(",", ".",$row['INCMED']);
		$obj->RAPPORT=str_replace(",", ".",$row['RAPPORT']);
		$obj->METLIN=str_replace(",", ".",$row['METLIN']);
		$obj->PUNTOS=str_replace(",", ".",$row['PUNTOS']);
		$obj->CALIFICACION=$row['CALIFICACION'];
		$obj->ESTADO=$row['ESTADO'];

		$numrollosdef=array();
		$l=0;
		$sql="BEGIN SP_AUDTEL_SELECT_PARROLDEF(:PARTIDA,:CODTEL,:CODPRV,:CODTAD,:NUMVEZ,:PARTE,:NUMROL,:OUTPUT_CUR); END;";
		$stmt2=oci_parse($conn, $sql);
		oci_bind_by_name($stmt2, ':PARTIDA', $_POST['partida']);
		oci_bind_by_name($stmt2, ':CODTEL', $codtel);
		oci_bind_by_name($stmt2, ':CODPRV', $codprv);
		oci_bind_by_name($stmt2, ':CODTAD', $codtad);
		oci_bind_by_name($stmt2, ':NUMVEZ', $numvez);
		oci_bind_by_name($stmt2, ':PARTE', $parte);
		oci_bind_by_name($stmt2, ':NUMROL', $row['NUMROL']);
		$OUTPUT_CUR2=oci_new_cursor($conn);
		oci_bind_by_name($stmt2, ':OUTPUT_CUR', $OUTPUT_CUR2,-1,OCI_B_CURSOR);
		$result2=oci_execute($stmt2);
		oci_execute($OUTPUT_CUR2);
		$sumpuntos=0;
		while($row2=oci_fetch_assoc($OUTPUT_CUR2)){
			$obj2=new stdClass();
			$obj2->CODARE=$row2['CODAREAD'];
			$obj2->DESARE=utf8_encode($row2['DSCAREAD']);
			$obj2->CODDEF=$row2['CODDEF'];
			$obj2->PESO=$row2['PESO'];
			$obj2->CANTIDAD=$row2['CANTIDAD'];
			$obj2->DESDEF=utf8_encode($row2['DESDEF']);
			$numrollosdef[$l]=$obj2;
			$l++;
			$sumpuntos+=intval($row2['PESO'])*intval($row2['CANTIDAD']);
		}
		$obj->PUNTOSDEF=$sumpuntos;
		$obj->DEFECTOS=$numrollosdef;
		$numrollos[$i]=$obj;
		$i++;
	}
	$response->numrollos=$numrollos;

	$sql="BEGIN SP_AUDTEL_VALIDAR_NUMFORMV2(:PARTIDA,:CODPRV,:CODTEL,:NUMVEZ,:NUMFORM,:RES1,:RES2,:RES3); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	oci_bind_by_name($stmt, ':CODPRV', $codprv);
	oci_bind_by_name($stmt, ':CODTEL', $codtel);
	oci_bind_by_name($stmt, ':NUMVEZ', $numvez);
	oci_bind_by_name($stmt, ':NUMFORM', $numform,40);
	oci_bind_by_name($stmt, ':RES1', $res1,40);
	oci_bind_by_name($stmt, ':RES2', $res2,40);
	oci_bind_by_name($stmt, ':RES3', $res3,40);
	$result=oci_execute($stmt);
	$response->numform=$numform;
	$response->res1=$res1;
	$response->res2=$res2;
	$response->res3=$res3;

	if ($res1!=null) {
		$detalle1=array();
		$i=0;
		$sql="BEGIN SP_AUDTEL_SELECT_PARAUDTON(:PARTIDA,:CODTEL,:CODPRV,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
		oci_bind_by_name($stmt, ':CODTEL', $codtel);
		oci_bind_by_name($stmt, ':CODPRV', $codprv);
		oci_bind_by_name($stmt, ':CODTAD', $codtad);
		oci_bind_by_name($stmt, ':NUMVEZ', $numvez);
		oci_bind_by_name($stmt, ':PARTE', $parte);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODTON=$row['CODTON'];
			$obj->DESTON=utf8_encode($row['DESTON']);
			$obj->RESTSC=$row['RESTSC'];
			$obj->DESREC1=utf8_encode($row['DESREC1']);
			$obj->DESREC2=utf8_encode($row['DESREC2']);
			$detalle1[$i]=$obj;
			$i++;
		}
		$response->detalle1=$detalle1;
	}
	if ($res2!=null) {		
		$detalle2=array();
		$i=0;
		$sql="BEGIN SP_AUDTEL_SELECT_PARAUDCOLAPA(:PARTIDA,:CODTEL,:CODPRV,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
		oci_bind_by_name($stmt, ':CODTEL', $codtel);
		oci_bind_by_name($stmt, ':CODPRV', $codprv);
		oci_bind_by_name($stmt, ':CODTAD', $codtad);
		oci_bind_by_name($stmt, ':NUMVEZ', $numvez);
		oci_bind_by_name($stmt, ':PARTE', $parte);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->DESAPA=utf8_encode($row['DESAPA']);
			$obj->DSCAREAD=utf8_encode($row['DSCAREAD']);
			$obj->CODAPA=$row['CODAPA'];
			$obj->RESTSC=$row['RESTSC'];
			$obj->DESREC1=utf8_encode($row['DESREC1']);
			$obj->CM=str_replace(",",".",$row['CM']);
			$obj->CAIDA=str_replace(",",".",$row['CAIDA']);
			$detalle2[$i]=$obj;
			$i++;
		}
		$response->detalle2=$detalle2;	
	}
	if ($res3!=null) {
		$detalle3=array();
		$i=0;
		$sql="BEGIN SP_AUDTEL_SELECT_PARAUDESTDIM(:PARTIDA,:CODTEL,:CODPRV,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
		oci_bind_by_name($stmt, ':CODTEL', $codtel);
		oci_bind_by_name($stmt, ':CODPRV', $codprv);
		oci_bind_by_name($stmt, ':CODTAD', $codtad);
		oci_bind_by_name($stmt, ':NUMVEZ', $numvez);
		oci_bind_by_name($stmt, ':PARTE', $parte);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODESTDIM=$row['CODESTDIM'];
			$obj->DESESTDIM=utf8_encode($row['DESESTDIM']);
			$obj->VALORPRV=str_replace(",", ".", $row['VALORPRV']);
			$obj->VALORTSC=str_replace(",", ".", add_cero($row['VALORTSC']));
			$obj->RESTSC=$row['RESTSC'];
			$obj->DESREC1=utf8_encode($row['DESREC1']);
			$obj->CAIDA=str_replace(",", ".", $row['CAIDA']);
			$obj->DIMVAL=$row['DIMVAL'];
			$obj->DIMTOL=$row['DIMTOL'];
			$obj->VALOR=str_replace(",", ".", add_cero($row['VALOR']));
			$obj->TOLERANCIA=$row['TOLERANCIA'];
			$detalle3[$i]=$obj;
			$i++;
		}
		$response->detalle3=$detalle3;
	}
	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>