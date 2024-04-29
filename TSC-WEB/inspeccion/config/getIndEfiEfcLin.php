<?php
	include("connection.php");
	$response=new stdClass();

	$titulo="";

	if($_POST['linea']=="0"){
		$titulo.="LINEA: TODOS / ";
	}else{
		$titulo.="LINEA: ".$_POST['linea']." / ";
	}
	$titulo.="TURNO: ".$_POST['turno']." / ";

	$ar_fecha=explode("-", $_POST['fecha']);

	$titulo.=$ar_fecha[2]."-".$ar_fecha[1]."-".$ar_fecha[0];
	$fecha=$ar_fecha[2].$ar_fecha[1].$ar_fecha[0];
	$fechaformat=$ar_fecha[0].$ar_fecha[1].$ar_fecha[2];

	///////NUEVO
	$sql="BEGIN SP_INSP_VALFECHOY(:FECHA,:CONTADOR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt,":FECHA", $fechaformat);
	oci_bind_by_name($stmt,":CONTADOR", $contador,40);
	$result=oci_execute($stmt);
	if ($contador==1) {
		$sql="BEGIN SP_INSP_GETDATFECHOY(:LINEA,:TURNO,:OUTPUT_CUR); END;";		
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt,":LINEA", $_POST['linea']);
		oci_bind_by_name($stmt,":TURNO", $_POST['turno']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$lineas=[];
		$i=0;
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$hora=((int)$row['HORFIN'])*100-41;
			$hora="".$hora;

			$uno=new stdClass();
			$uno->fecha=$row['FECHAFOR'];
			$uno->fechaf=$row['FECHA'];
			$fechafor=substr($row['FECHA'],6,2)."/".substr($row['FECHA'],4,2)."/".substr($row['FECHA'],0,4);
			$uno->fechaf2=$fechafor;
			$uno->hora=(int)$hora;
			$uno->linea=(int)$row['LINEA'];

			$stmt = oci_parse($conn,'BEGIN SP_MONI_SEL_DATOS_REP_MON6CE2(:LINEA,:FECHA,:HORA, :HORINIDIA, :HORINI, :HORFIN, :FECINI, :FECFIN, :HORACT, :TURNO, :MINASI1, :MINASI2, :MINEFICIENCIA, :PRENDASPRO, :PRENDASPRY, :CUOTA, :CAMBIOEST, :CLIENTE, :MINEFICACIA, :PRENDASDEF, :PRENDASINS, :PRENDASREP, :AUDAPR, :AUDTOT, :NUMINS,:MINEFICOM,:MINEFCCOM,:MINEFICOMEST,:MINEFCCOMEST,:PREING,:PREAUDAPR); END;');	
			oci_bind_by_name($stmt,':LINEA',$row['LINEA']);
			oci_bind_by_name($stmt,':FECHA',$row['FECHA']);
			oci_bind_by_name($stmt,':HORA',$hora);
			oci_bind_by_name($stmt,':HORINIDIA',$hinidia,40); 
			oci_bind_by_name($stmt,':HORINI',$hini,40);   
			oci_bind_by_name($stmt,':HORFIN',$hfin,40); 
			oci_bind_by_name($stmt,':FECINI',$fecini,40); 
			oci_bind_by_name($stmt,':FECFIN',$fecfin,40); 
			oci_bind_by_name($stmt,':HORACT',$hact,40); 
			oci_bind_by_name($stmt,':TURNO',$turno,40);
			oci_bind_by_name($stmt,':MINASI1',$rowdos_uno,40); 
			oci_bind_by_name($stmt,':MINASI2',$rowdos_dos,40); 
			oci_bind_by_name($stmt,':MINEFICIENCIA',$mineficiencia,40); 
			oci_bind_by_name($stmt,':PRENDASPRO',$prendaspro,40); 
			oci_bind_by_name($stmt,':PRENDASPRY',$prendaspry,40); 
			oci_bind_by_name($stmt,':CUOTA',$cuota,40); 
			oci_bind_by_name($stmt,':CAMBIOEST',$cambioest,40); 	
			oci_bind_by_name($stmt,':CLIENTE',$cliente,40); 
			oci_bind_by_name($stmt,':MINEFICACIA',$mineficacia,40); 
			oci_bind_by_name($stmt,':PRENDASDEF',$prendasdef,40); 
			oci_bind_by_name($stmt,':PRENDASINS',$prendasins,40); 
			oci_bind_by_name($stmt,':PRENDASREP',$prendasrep,40);    
			oci_bind_by_name($stmt,':AUDAPR',$audapr,40); 
			oci_bind_by_name($stmt,':AUDTOT',$audtot,40); 
			oci_bind_by_name($stmt,':NUMINS',$numins,40);  
			oci_bind_by_name($stmt,':MINEFICOM',$mineficom,40); 
			oci_bind_by_name($stmt,':MINEFCCOM',$minefccom,40);  
			oci_bind_by_name($stmt,':MINEFICOMEST',$mineficomest,40);
			oci_bind_by_name($stmt,':MINEFCCOMEST',$minefccomest,40);
			oci_bind_by_name($stmt,':PREING',$preing,40);
			oci_bind_by_name($stmt,':PREAUDAPR',$preaudapr,40);           
			$result=oci_execute($stmt);

			$uno->turno=(int)$turno;
			$uno->hini=$hini;
			$uno->hfin=$hfin;

			//------------------------CLIENTE
			$uno->cliente=$cliente;

			//--------------------EFICIENCIA - EFICACIA
			$denominador=$rowdos_uno+$rowdos_dos;
			if($denominador!=0){
				$uno->eficiencia=round(floatval($mineficiencia)*100/$denominador);
				$uno->eficacia=round(floatval($mineficacia)*100/$denominador);
			}else{
				$uno->eficiencia="-";
				$uno->eficacia="-";
			}

			//---------------------PRENDAS PRODUCIDAS
		    $uno->prendas_producidas=(int)$prendaspro;
			
			//---------------------CUOTA
			$uno->cuota=(int)$cuota;

			//---------------------PRENDAS DEFECTUOSAS
			$uno->prendas_defectuosas=(int)$prendasdef;
			$uno->prendas_inspecionadas=(int)$prendasins;
				
			//---------------------REPROCESOS DE COSTURA (CANTIDAD DE DEFECTOS)
			$uno->prendas_reproceso=(int)$prendasrep;

			//---------------------27/04/2020
			$uno->preing=(int)$preing;
			$uno->preaudapr=(int)$preaudapr;

			//---------------------PROYECCION
			$factor=(int)str_replace(",",".",$prendaspry);
			if ($factor<1) {
				$factor=1;
			}
			if ($denominador>0){
				$uno->factor=round($factor*100/$denominador)/100;
			}else{
				$uno->factor=0;
			}	
				
			//---------------------CAMBIO DE ESTILO
			if ($cambioest<="1") {
				$uno->flag_cambio=1;
			}else{
				$uno->flag_cambio=0;
			}
			$lineas[$i]=$uno;
			$i++;
			$stmt = oci_parse($conn,'BEGIN SP_INSP_INSERT_HISEFILINAUX(:LINEA,:TURNO,:FECHA,:FECHAFOR,:HORA, :HORINI, :HORFIN, :CLIENTE, :EFICIENCIA, :EFICACIA, :PRENDASPRO, :CUOTA, :PRENDASDEF, :PRENDASINS, :PRENDASREP, :FACTOR, :FLAGCAMBIO,:MINASI,:MINEFI,:MINEFC,:AUDAPR, :AUDTOT,:MINEFICOM,:MINEFCCOM,:MINEFICOMEST,:MINEFCCOMEST,:PREING,:PREAUDAPR); END;');	
			oci_bind_by_name($stmt,':LINEA',$uno->linea);
			oci_bind_by_name($stmt,':TURNO',$uno->turno);
			oci_bind_by_name($stmt,':FECHA',$uno->fechaf);
			oci_bind_by_name($stmt,':FECHAFOR',$uno->fechaf2);
			oci_bind_by_name($stmt,':HORA',$uno->hora);
			oci_bind_by_name($stmt,':HORINI',$uno->hini);   
			oci_bind_by_name($stmt,':HORFIN',$uno->hfin); 
			oci_bind_by_name($stmt,':CLIENTE',$uno->cliente); 
			oci_bind_by_name($stmt,':EFICIENCIA',$uno->eficiencia); 
			oci_bind_by_name($stmt,':EFICACIA',$uno->eficacia); 
			oci_bind_by_name($stmt,':PRENDASPRO',$uno->prendas_producidas);
			oci_bind_by_name($stmt,':CUOTA',$uno->cuota);
			oci_bind_by_name($stmt,':PRENDASDEF',$uno->prendas_defectuosas);
			oci_bind_by_name($stmt,':PRENDASINS',$uno->prendas_inspecionadas);
			oci_bind_by_name($stmt,':PRENDASREP',$uno->prendas_reproceso);
			oci_bind_by_name($stmt,':FACTOR',$uno->factor);
			oci_bind_by_name($stmt,':FLAGCAMBIO',$uno->flag_cambio);
			oci_bind_by_name($stmt,':MINASI',$denominador);
			oci_bind_by_name($stmt,':MINEFI',$mineficiencia);
			oci_bind_by_name($stmt,':MINEFC',$mineficacia);
			oci_bind_by_name($stmt,':AUDAPR',$audapr);
			oci_bind_by_name($stmt,':AUDTOT',$audtot);
			oci_bind_by_name($stmt,':MINEFICOM',$mineficom);
			oci_bind_by_name($stmt,':MINEFCCOM',$minefccom);
			oci_bind_by_name($stmt,':MINEFICOMEST',$mineficomest);
			oci_bind_by_name($stmt,':MINEFCCOMEST',$minefccomest);
			oci_bind_by_name($stmt,':PREING',$preing);
			oci_bind_by_name($stmt,':PREAUDAPR',$preaudapr);
			$result=oci_execute($stmt);
		}
	}
	///////NUEVO

	$anios=[];
	$i=0;
	$sql="BEGIN SP_MONI_INDICADOR_RESULTADOS(:LINEA,:TURNO,:FECHA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':LINEA', $_POST['linea']);
	oci_bind_by_name($stmt, ':TURNO', $_POST['turno']);
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
		$obj->MINEFICIENCIA=str_replace(",",".",$row['MINEFICIENCIA']);
		$obj->MINEFICACIA=str_replace(",",".",$row['MINEFICACIA']);
		$obj->MINASIGNADOS=str_replace(",",".",$row['MINASIGNADOS']);
		$anios[$i]=$obj;
		$i++;
	}
	$response->anios=$anios;

	$meses=[];
	$i=0;
	$sql="BEGIN SP_MONI_INDICADOR_RESULTADOS(:LINEA,:TURNO,:FECHA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':LINEA', $_POST['linea']);
	oci_bind_by_name($stmt, ':TURNO', $_POST['turno']);
	oci_bind_by_name($stmt, ':FECHA', $fecha);
	$opcion=1;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->MES=$row['MES'];
		$obj->MINEFICIENCIA=str_replace(",",".",$row['MINEFICIENCIA']);
		$obj->MINEFICACIA=str_replace(",",".",$row['MINEFICACIA']);
		$obj->MINASIGNADOS=str_replace(",",".",$row['MINASIGNADOS']);
		$meses[$i]=$obj;
		$i++;
	}
	$response->meses=$meses;

	$semanas=[];
	$i=0;
	$sql="BEGIN SP_MONI_INDICADOR_RESULTADOS(:LINEA,:TURNO,:FECHA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':LINEA', $_POST['linea']);
	oci_bind_by_name($stmt, ':TURNO', $_POST['turno']);
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
		$obj->MINEFICIENCIA=str_replace(",",".",$row['MINEFICIENCIA']);
		$obj->MINEFICACIA=str_replace(",",".",$row['MINEFICACIA']);
		$obj->MINASIGNADOS=str_replace(",",".",$row['MINASIGNADOS']);
		$semanas[$i]=$obj;
		$i++;
	}
	$response->semanas=$semanas;

	$response->titulo=$titulo;

	$param=[];
	$i=0;
	$sql="BEGIN SP_AT_SELECT_PARAMETROSREPORTE(:CODTAD,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$codtad=102;
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

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>