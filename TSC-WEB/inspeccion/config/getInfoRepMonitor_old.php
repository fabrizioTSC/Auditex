<?php
	date_default_timezone_set('America/Lima');
	set_time_limit(240);
	include('connection.php');
	$response=new stdClass();

	function format_time($value){
		if (strlen($value)==1) {
			$value="0".$value;
		}
		return $value."00";
	}
	$uno=new stdClass();

	$stmt = oci_parse($conn,'BEGIN SP_INSP_SELECT_MAXFECLIN(:LINEA, :OUTPUT_CUR); END;');	
	oci_bind_by_name($stmt,':LINEA',$_POST['l1']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_assoc($OUTPUT_CUR);
	$dia_ant = $row['MAXFEC'];

	$hora = date("Hi");
	$response->fechaant_hora_uno=$dia_ant." - ".$hora;

	////////// linea 1 anterior	
	$stmt = oci_parse($conn,'BEGIN SP_MONI_SEL_DATOS_REP_MON_V2(:LINEA,:FECHA,:HORA, :HORINIDIA, :HORINI, :HORFIN, :FECINI, :FECFIN, :HORACT, :TURNO, :MINASI1, :MINASI2, :MINEFICIENCIA, :PRENDASPRO, :PRENDASPRY, :CUOTA, :CAMBIOEST, :CLIENTE, :MINEFICACIA, :PRENDASDEF, :PRENDASINS, :PRENDASREP,:MINEFICOM,:MINEFCCOM,:MINEFICOMEST,:MINEFCCOMEST,:PREING,:PREAUDAPR); END;');	
	oci_bind_by_name($stmt,':LINEA',$_POST['l1']);
	oci_bind_by_name($stmt,':FECHA',$dia_ant);
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
	oci_bind_by_name($stmt,':MINEFICOM',$mineficienciacom,40); 
	oci_bind_by_name($stmt,':MINEFCCOM',$mineficaciacom,40);   
	oci_bind_by_name($stmt,':MINEFICOMEST',$mineficienciacomest,40); 
	oci_bind_by_name($stmt,':MINEFCCOMEST',$mineficaciacomest,40);   
	oci_bind_by_name($stmt,':PREING',$preing,40); 
	oci_bind_by_name($stmt,':PREAUDAPR',$preaudapr,40);
	
	$result=oci_execute($stmt);

	// echo $rowdos_uno . "br";
	// echo $rowdos_dos;
	// SP_MONI_SEL_DATOS_REP_MON_V2
	$rowdos_uno = (float)$rowdos_uno;
	$rowdos_dos = (float)$rowdos_dos;



	$denominador = $rowdos_uno +  $rowdos_dos;

	if($denominador!=0){
		$mineficienciacom=floatval($mineficienciacom);
		$uno->ant_eficiencia=round($mineficienciacom*100/$denominador);
		$mineficaciacom=floatval($mineficaciacom);
		$uno->ant_eficacia=round($mineficaciacom*100/$denominador);
	}else{
		$uno->ant_eficiencia="-";
		$uno->ant_eficacia="-";
	}

	/////////////////// DATOS DE LINEA 1
	$stmt = oci_parse($conn,'BEGIN SP_MONI_SEL_DATOS_REP_MON5_V2(:LINEA, :HORINIDIA, :HORINI, :HORFIN, :FECINI, :FECFIN, :HORACT, :TURNO, :MINASI1, :MINASI2, :MINEFICIENCIA, :PRENDASPRO, :PRENDASPRY, :CUOTA, :CAMBIOEST, :CLIENTE, :MINEFICACIA, :PRENDASDEF, :PRENDASINS, :PRENDASREP,:AUDAPR,:AUDTOT,:NUMINS,:MINEFICOM,:MINEFCCOM,:MINEFICOMEST,:MINEFCCOMEST,:PREING,:PREAUDAPR); END;');
	oci_bind_by_name($stmt,':LINEA',$_POST['l1']);
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
	oci_bind_by_name($stmt,':MINEFICOM',$mineficienciacom,40); 
	oci_bind_by_name($stmt,':MINEFCCOM',$mineficaciacom,40);  
	oci_bind_by_name($stmt,':MINEFICOMEST',$mineficienciacomest,40); 
	oci_bind_by_name($stmt,':MINEFCCOMEST',$mineficaciacomest,40);   
	oci_bind_by_name($stmt,':PREING',$preing,40); 
	oci_bind_by_name($stmt,':PREAUDAPR',$preaudapr,40);	
    
	// Execute statement               
	$result=oci_execute($stmt);
	$uno->turno=$turno;
	$uno->hini=$hini;
	$uno->hfin=$hfin;

	//------------------------CLIENTE
	$uno->cliente=$cliente;

	//--------------------EFICIENCIA - EFICACIA
	$denominador=$rowdos_uno+$rowdos_dos;
	if($denominador!=0){
		$mineficienciacom=floatval($mineficienciacom);
		$uno->eficiencia=round($mineficienciacom*100/$denominador);
		$mineficaciacom=floatval($mineficaciacom);
		$uno->eficacia=round($mineficaciacom*100/$denominador);
	}else{
		$uno->eficiencia="-";
		$uno->eficacia="-";
	}

	//---------------------PRENDAS PRODUCIDAS
    $uno->prendas_producidas=$prendaspro;
	
	//---------------------CUOTA
	$uno->cuota=$cuota;

	//---------------------PRENDAS DEFECTUOSAS
	$uno->prendas_defectuosas=$prendasdef;
	$uno->prendas_inspecionadas=$prendasins;
		
	//---------------------REPROCESOS DE COSTURA (CANTIDAD DE DEFECTOS)
	$uno->prendas_reproceso=$prendasrep;

	//---------------------PROYECCION
	$factor=(int)str_replace(",",".",$prendaspry);
	if ($factor<1) {
		$factor=1;
	}
	if ($denominador>0){
		$uno->factor=$factor/$denominador;
	}else{
		$uno->factor=0;
	}	
		
	//---------------------CAMBIO DE ESTILO
	if ($cambioest<="1") {
		$uno->flag_cambio=false;
	}else{
		$uno->flag_cambio=true;
	}
	$uno->audapr=$audapr;
	$uno->audtot=$audtot;
	$uno->numins=$numins;
	$response->uno=$uno;

	$dos=new stdClass();

	$stmt = oci_parse($conn,'BEGIN SP_INSP_SELECT_MAXFECLIN(:LINEA, :OUTPUT_CUR); END;');	
	oci_bind_by_name($stmt,':LINEA',$_POST['l2']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_assoc($OUTPUT_CUR);
	$dia_ant = $row['MAXFEC'];
	$response->fechaant_hora_dos=$dia_ant." - ".$hora;

	////////// linea 2 anterior	
	$stmt = oci_parse($conn,'BEGIN SP_MONI_SEL_DATOS_REP_MON_V2(:LINEA,:FECHA,:HORA, :HORINIDIA, :HORINI, :HORFIN, :FECINI, :FECFIN, :HORACT, :TURNO, :MINASI1, :MINASI2, :MINEFICIENCIA, :PRENDASPRO, :PRENDASPRY, :CUOTA, :CAMBIOEST, :CLIENTE, :MINEFICACIA, :PRENDASDEF, :PRENDASINS, :PRENDASREP,:MINEFICOM,:MINEFCCOM,:MINEFICOMEST,:MINEFCCOMEST,:PREING,:PREAUDAPR); END;');	
	oci_bind_by_name($stmt,':LINEA',$_POST['l2']);
	oci_bind_by_name($stmt,':FECHA',$dia_ant);
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
	oci_bind_by_name($stmt,':MINEFICOM',$mineficienciacom,40); 
	oci_bind_by_name($stmt,':MINEFCCOM',$mineficaciacom,40);              
	oci_bind_by_name($stmt,':MINEFICOMEST',$mineficienciacomest,40); 
	oci_bind_by_name($stmt,':MINEFCCOMEST',$mineficaciacomest,40);
	oci_bind_by_name($stmt,':PREING',$preing,40); 
	oci_bind_by_name($stmt,':PREAUDAPR',$preaudapr,40);
	$result=oci_execute($stmt);

	$denominador=$rowdos_uno+$rowdos_dos;
	if($denominador!=0){
		$mineficienciacom=floatval($mineficienciacom);
		$dos->ant_eficiencia=round($mineficienciacom*100/$denominador);
		$mineficaciacom=floatval($mineficaciacom);
		$dos->ant_eficacia=round($mineficaciacom*100/$denominador);
	}else{
		$dos->ant_eficiencia="-";
		$dos->ant_eficacia="-";
	}

	/////////////////// DATOS DE LINEA 2	
	$stmt = oci_parse($conn,'BEGIN SP_MONI_SEL_DATOS_REP_MON5_V2(:LINEA, :HORINIDIA, :HORINI, :HORFIN, :FECINI, :FECFIN, :HORACT, :TURNO, :MINASI1, :MINASI2, :MINEFICIENCIA, :PRENDASPRO, :PRENDASPRY, :CUOTA, :CAMBIOEST, :CLIENTE, :MINEFICACIA, :PRENDASDEF, :PRENDASINS, :PRENDASREP,:AUDAPR,:AUDTOT,:NUMINS,:MINEFICOM,:MINEFCCOM,:MINEFICOMEST,:MINEFCCOMEST,:PREING,:PREAUDAPR); END;');	
	oci_bind_by_name($stmt,':LINEA',$_POST['l2']);
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
	oci_bind_by_name($stmt,':MINEFICOM',$mineficienciacom,40); 
	oci_bind_by_name($stmt,':MINEFCCOM',$mineficaciacom,40);   
	oci_bind_by_name($stmt,':MINEFICOMEST',$mineficienciacomest,40); 
	oci_bind_by_name($stmt,':MINEFCCOMEST',$mineficaciacomest,40);
	oci_bind_by_name($stmt,':PREING',$preing,40); 
	oci_bind_by_name($stmt,':PREAUDAPR',$preaudapr,40);
	             
	$result=oci_execute($stmt);  
	$dos->turno=$turno;
	$dos->hini=$hini;
	$dos->hfin=$hfin;

	//------------------------CLIENTE
	$dos->cliente=$cliente;

	//--------------------EFICIENCIA - EFICACIA
	$denominador=$rowdos_uno+$rowdos_dos;	
	
	if($denominador!=0){
		$mineficienciacom=floatval($mineficienciacom);
		$dos->eficiencia=round($mineficienciacom*100/$denominador);
		$mineficaciacom=floatval($mineficaciacom);
		$dos->eficacia=round($mineficaciacom*100/$denominador);
	}else{
		$dos->eficiencia="-";
		$dos->eficacia="-";
	}

	//---------------------PRENDAS PRODUCIDAS
	$dos->prendas_producidas=$prendaspro;	

	//---------------------CUOTA	
	$dos->cuota=$cuota;
	$dos->prendas_defectuosas=$prendasdef;
	$dos->prendas_inspecionadas=$prendasins;

	//---------------------REPROCESOS DE COSTURA (CANTIDAD DE DEFECTOS)
	$dos->prendas_reproceso=$prendasrep;
	$factor=(int)str_replace(",",".",$prendaspry);
	if ($factor<1) {
		$factor=1;
	}
	if ($denominador>0){
		$dos->factor=$factor/$denominador;
	}else{
		$dos->factor=0;
	}

	//---------------------CAMBIO DE ESTILO
	if ($cambioest<="1") {
		$dos->flag_cambio=false;
	}else{
		$dos->flag_cambio=true;
	}
	$dos->audapr=$audapr;
	$dos->audtot=$audtot;
	$dos->numins=$numins;
	$response->dos=$dos;

	$parametrosreportes=[];
	$i=0;
	$stmt = oci_parse($conn,'BEGIN SP_INSP_SEL_PARAMETROSREPORTES(:CODTAD, :OUTPUT_CUR); END;');                     
	$codtad = 102;
	oci_bind_by_name($stmt,':CODTAD',$codtad);   
	$OUTPUT_CUR = oci_new_cursor($conn);
	oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);  
	$result=oci_execute($stmt); 
	oci_execute($OUTPUT_CUR);
	while ($row = oci_fetch_assoc($OUTPUT_CUR)) {	
		$obj=new stdClass();
		$obj->CODTAD=$row['CODTAD'];
		$obj->DESTAD=utf8_encode($row['DESTAD']);
		$obj->CODRAN=$row['CODRAN'];
		$obj->VALOR=$row['VALOR'];
		$parametrosreportes[$i]=$obj;
		$i++;
	}

	$response->parametrosreportes=$parametrosreportes;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>