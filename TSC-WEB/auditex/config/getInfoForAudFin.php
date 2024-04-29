<?php
	include("connection.php");
	$response=new stdClass();

	$titulo="";
	if ($_POST['option']=="1") {
		if ($_POST['codsede']=="0") {
			$titulo.="SEDE: (TODOS) / ";
		}else{
			$sql="BEGIN SP_AT_SELECT_SEDE(:CODSED,:OUTPUT_CUR); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
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
	}else{
		if ($_POST['option']=="2") {
			$titulo="PEDIDO: ".$_POST['pedido'];
		}else{
			$titulo="FICHA: ".$_POST['codfic'];
		}
	}

	$fecini=explode("-", $_POST['fecini']);
	$fecfin=explode("-", $_POST['fecfin']);

	if ($_POST['option']=="1") {
		$response->titulo=$titulo." / Del ".$fecini[2]."-".$fecini[1]."-".$fecini[0]." al ".$fecfin[2]."-".$fecfin[1]."-".$fecfin[0];
	}else{
		if ($_POST['check']=="1") {
			$response->titulo=$titulo." / Del ".$fecini[2]."-".$fecini[1]."-".$fecini[0]." al ".$fecfin[2]."-".$fecfin[1]."-".$fecfin[0];
		}else{
			$response->titulo=$titulo;
		}
	}	

	$fecini=$fecini[0].$fecini[1].$fecini[2];
	$fecfin=$fecfin[0].$fecfin[1].$fecfin[2];

	$data=[];
	$i=0;
	$ant="";
	$ant_fp="";
	if ($_POST['option']=="1") {
		$sql="BEGIN SP_AT_REPORTE_DETAUDFIN(:CODTLL,:CODSED,:CODTIPSER,:FECINI,:FECFIN,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
		oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
		oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
		oci_bind_by_name($stmt, ':FECINI', $fecini);
		oci_bind_by_name($stmt, ':FECFIN', $fecfin);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
	}else{		
		if ($_POST['option']=="2") {
			$sql="BEGIN SP_AT_REPORTE_DETAUDFIN2(:PEDIDO,:FECINI,:FECFIN,:CHECK,:OUTPUT_CUR); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
			oci_bind_by_name($stmt, ':FECINI', $fecini);
			oci_bind_by_name($stmt, ':FECFIN', $fecfin);
			oci_bind_by_name($stmt, ':CHECK', $_POST['check']);
			$OUTPUT_CUR=oci_new_cursor($conn);
			oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
			$result=oci_execute($stmt);
			oci_execute($OUTPUT_CUR);
		}else{			
			$sql="BEGIN SP_AT_REPORTE_DETAUDFIN3(:CODFIC,:FECINI,:FECFIN,:CHECK,:OUTPUT_CUR); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
			oci_bind_by_name($stmt, ':FECINI', $fecini);
			oci_bind_by_name($stmt, ':FECFIN', $fecfin);
			oci_bind_by_name($stmt, ':CHECK', $_POST['check']);
			$OUTPUT_CUR=oci_new_cursor($conn);
			oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
			$result=oci_execute($stmt);
			oci_execute($OUTPUT_CUR);
		}
	}
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$cod=$row['FECHA'].$row['FICHA'].$row['PARTE'].$row['VEZ'];
		$fp=$row['FICHA'].$row['PARTE'];
		if ($ant!=$cod) {
			if ($ant_fp!=$fp and $i!=0) {
				$obj=new stdClass();
				$obj->FECHA="";
				$obj->AUDITOR="";
				$obj->TALLER="";
				$obj->CLIENTE="";
				$obj->ESTILO="";
				$obj->PEDIDO="";
				$obj->FICHA="";
				$obj->DSCCOL="";
				$obj->PARTE="";
				$obj->VEZ="";
				$obj->LOTE="";
				$obj->MUESTRA="";
				$obj->CODDEF="";
				$obj->DEFECTO="";
				$obj->CANDEF="";
				$obj->RESULTADO="";
				$data[$i]=$obj;
				$i++;
				$ant_fp=$fp;
			}
			$obj=new stdClass();
			$obj->FECHA=$row['FECHA'];
			$obj->AUDITOR=$row['AUDITOR'];
			$obj->TALLER=utf8_encode($row['TALLER']);
			$obj->CLIENTE=utf8_encode($row['CLIENTE']);
			$obj->ESTILO=$row['ESTILO'];
			$obj->PEDIDO=$row['PEDIDO'];
			$obj->FICHA=$row['FICHA'];
			$obj->DSCCOL=$row['DSCCOL'];
			$obj->PARTE=$row['PARTE'];
			$obj->VEZ=$row['VEZ'];
			$obj->LOTE=$row['LOTE'];
			$obj->MUESTRA=$row['MUESTRA'];
			if ($row['CODDEF']!=null) {
				$obj->CODDEF=$row['CODDEF'];	
			}else{
				$obj->CODDEF="-";
			}			
			$obj->DEFECTO=utf8_encode($row['DEFECTO']);
			if ($row['CANDEF']!=null) {
				$obj->CANDEF=$row['CANDEF'];	
			}else{
				$obj->CANDEF="-";
			}
			$obj->RESULTADO=$row['RESULTADO'];
			$data[$i]=$obj;
			$i++;
			$ant=$cod;
		}else{
			$obj=new stdClass();
			$obj->FECHA="";
			$obj->AUDITOR="";
			$obj->TALLER="";
			$obj->CLIENTE="";
			$obj->ESTILO="";
			$obj->PEDIDO="";
			$obj->FICHA="";
			$obj->DSCCOL="";
			$obj->PARTE="";
			$obj->VEZ="";
			$obj->LOTE="";
			$obj->MUESTRA="";
			$obj->CODDEF=$row['CODDEF'];
			$obj->DEFECTO=utf8_encode($row['DEFECTO']);
			$obj->CANDEF=$row['CANDEF'];
			$obj->RESULTADO="";
			$data[$i]=$obj;
			$i++;
		}
	}
	$response->data=$data;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>