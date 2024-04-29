<?php
	function format_hour($val){
		$val="".$val;
		if (strlen($val)==1) {
			return "0".$val;
		}else{
			return $val;
		}
	}

	date_default_timezone_set('America/Lima');
	set_time_limit(240);
	include('connection.php');

	$response=new stdClass();

	//DIA ANTERIOR

	$turnos_ant=[];
	$i=0;

	$stmt = oci_parse($conn,'BEGIN SP_INSP_SELECT_TURFECANT(:OUTPUT_CUR); END;');
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);

	//MINEFICIENCIA, MINEFICACIA, MINASI1, MINASI2, PRENDASDEF, PRENDASINS, PRENDASREP
	$minefit=0;
	$minefct=0;
	$minasi1t=0;
	$minasi2t=0;
	$predeft=0;
	$preinst=0;
	$prerept=0;
	$turnoant="0";
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$stmt2 = oci_parse($conn,'BEGIN SP_MONI_SEL_DATOS_REP_MONITOR3(:LINEA,:FECHA,:HORA, :HORINIDIA, :HORINI, :HORFIN, :FECINI, :FECFIN, :HORACT, :TURNO, :MINASI1, :MINASI2, :MINEFICIENCIA, :PRENDASPRO, :PRENDASPRY, :CUOTA, :CAMBIOEST, :CLIENTE, :MINEFICACIA, :PRENDASDEF, :PRENDASINS, :PRENDASREP); END;');
		oci_bind_by_name($stmt2,':LINEA',$row['LINEA']);
		oci_bind_by_name($stmt2,':FECHA',$row['FECHAF']);
		$horfin=format_hour(intval($row['HORFIN'])-1)."59";
		oci_bind_by_name($stmt2,':HORA',$horfin);
		oci_bind_by_name($stmt2,':HORINIDIA',$hinidia,40); 
		oci_bind_by_name($stmt2,':HORINI',$hini,40);   
		oci_bind_by_name($stmt2,':HORFIN',$hfin,40); 
		oci_bind_by_name($stmt2,':FECINI',$fecini,40); 
		oci_bind_by_name($stmt2,':FECFIN',$fecfin,40); 
		oci_bind_by_name($stmt2,':HORACT',$hact,40); 
		oci_bind_by_name($stmt2,':TURNO',$turno,40);
		oci_bind_by_name($stmt2,':MINASI1',$minasi1,40); 
		oci_bind_by_name($stmt2,':MINASI2',$minasi2,40); 
		oci_bind_by_name($stmt2,':MINEFICIENCIA',$mineficiencia,40); 
		oci_bind_by_name($stmt2,':PRENDASPRO',$prendaspro,40); 
		oci_bind_by_name($stmt2,':PRENDASPRY',$prendaspry,40); 
		oci_bind_by_name($stmt2,':CUOTA',$cuota,40); 
		oci_bind_by_name($stmt2,':CAMBIOEST',$cambioest,40); 	
		oci_bind_by_name($stmt2,':CLIENTE',$cliente,40); 
		oci_bind_by_name($stmt2,':MINEFICACIA',$mineficacia,40); 
		oci_bind_by_name($stmt2,':PRENDASDEF',$prendasdef,40); 
		oci_bind_by_name($stmt2,':PRENDASINS',$prendasins,40); 
		oci_bind_by_name($stmt2,':PRENDASREP',$prendasrep,40);
		$result2=oci_execute($stmt2);

		if ($row['TURNO']==$turnoant) {
			$minefit+=floatval(str_replace(",",".",$mineficiencia));
			$minefct+=floatval(str_replace(",",".",$mineficacia));
			$minasi1t+=$minasi1;
			$minasi2t+=$minasi2;
			$predeft+=$prendasdef;
			$preinst+=$prendasins;
			$prerept+=$prendasrep;
		}else{
			if($turnoant!="0"){
				$obj=new stdClass();
				$obj->TURNO=$turnoant;
				$obj->MINEFI=$minefit;
				$obj->MINEFC=$minefct;
				$obj->MINASI1=$minasi1t;
				$obj->MINASI2=$minasi2t;
				$obj->PREDEF=$predeft;
				$obj->PREINS=$preinst;
				$obj->PREREP=$prerept;
				$turnos_ant[$i]=$obj;
				$i++;
			}

			$minefit=floatval(str_replace(",",".",$mineficiencia));
			$minefct=floatval(str_replace(",",".",$mineficacia));
			$minasi1t=$minasi1;
			$minasi2t=$minasi2;
			$predeft=$prendasdef;
			$preinst=$prendasins;
			$prerept=$prendasrep;
			$turnoant=$row['TURNO'];
		}
	}
	
	$obj=new stdClass();
	$obj->TURNO=$turnoant;
	$obj->MINEFI=$minefit;
	$obj->MINEFC=$minefct;
	$obj->MINASI1=$minasi1t;
	$obj->MINASI2=$minasi2t;
	$obj->PREDEF=$predeft;
	$obj->PREINS=$preinst;
	$obj->PREREP=$prerept;
	$turnos_ant[$i]=$obj;

	$response->turnos_ant=$turnos_ant;

	//DIA ACTUAL

	$turnos=[];
	$i=0;

	$stmt = oci_parse($conn,'BEGIN SP_INSP_SELECT_LINETOREPTUR(:OUTPUT_CUR); END;');
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);

	//MINEFICIENCIA, MINEFICACIA, MINASI1, MINASI2, PRENDASDEF, PRENDASINS, PRENDASREP
	$minefit=0;
	$minefct=0;
	$minasi1t=0;
	$minasi2t=0;
	$predeft=0;
	$preinst=0;
	$prerept=0;
	$turnoant="0";
	$audaprt=0;
	$audtott=0;
	while($row=oci_fetch_assoc($OUTPUT_CUR)){	
		$stmt2 = oci_parse($conn,'BEGIN SP_MONI_SEL_DATOS_REP_MONITOR6(:LINEA,:FECHA,:HORA, :HORINIDIA, :HORINI, :HORFIN, :FECINI, :FECFIN, :HORACT, :TURNO, :MINASI1, :MINASI2, :MINEFICIENCIA, :PRENDASPRO, :PRENDASPRY, :CUOTA, :CAMBIOEST, :CLIENTE, :MINEFICACIA, :PRENDASDEF, :PRENDASINS, :PRENDASREP,:AUDAPR,:AUDTOT,:NUMINS); END;');	
		oci_bind_by_name($stmt2,':LINEA',$row['LINEA']);
		oci_bind_by_name($stmt2,':FECHA',$row['FECHAF']);
		$horfin=format_hour(intval($row['HORFIN'])-1)."59";
		oci_bind_by_name($stmt2,':HORA',$horfin);
		oci_bind_by_name($stmt2,':HORINIDIA',$hinidia,40); 
		oci_bind_by_name($stmt2,':HORINI',$hini,40);   
		oci_bind_by_name($stmt2,':HORFIN',$hfin,40); 
		oci_bind_by_name($stmt2,':FECINI',$fecini,40); 
		oci_bind_by_name($stmt2,':FECFIN',$fecfin,40); 
		oci_bind_by_name($stmt2,':HORACT',$hact,40); 
		oci_bind_by_name($stmt2,':TURNO',$turno,40);
		oci_bind_by_name($stmt2,':MINASI1',$minasi1,40); 
		oci_bind_by_name($stmt2,':MINASI2',$minasi2,40); 
		oci_bind_by_name($stmt2,':MINEFICIENCIA',$mineficiencia,40); 
		oci_bind_by_name($stmt2,':PRENDASPRO',$prendaspro,40); 
		oci_bind_by_name($stmt2,':PRENDASPRY',$prendaspry,40); 
		oci_bind_by_name($stmt2,':CUOTA',$cuota,40); 
		oci_bind_by_name($stmt2,':CAMBIOEST',$cambioest,40); 	
		oci_bind_by_name($stmt2,':CLIENTE',$cliente,40); 
		oci_bind_by_name($stmt2,':MINEFICACIA',$mineficacia,40); 
		oci_bind_by_name($stmt2,':PRENDASDEF',$prendasdef,40); 
		oci_bind_by_name($stmt2,':PRENDASINS',$prendasins,40); 
		oci_bind_by_name($stmt2,':PRENDASREP',$prendasrep,40);
		oci_bind_by_name($stmt2,':AUDAPR',$audapr,40); 
		oci_bind_by_name($stmt2,':AUDTOT',$audtot,40);
		oci_bind_by_name($stmt2,':NUMINS',$numins,40);
		$result2=oci_execute($stmt2);
/*
				$obj=new stdClass();
				$obj->MINEFI=str_replace(",",".",$mineficiencia);
				$obj->MINEFC=str_replace(",",".",$mineficacia);
				$turnos[$i]=$obj;
				$i++;*/
		if ($row['TURNO']==$turnoant) {
			$minefit+=floatval(str_replace(",",".",$mineficiencia));
			$minefct+=floatval(str_replace(",",".",$mineficacia));
			$minasi1t+=$minasi1;
			$minasi2t+=$minasi2;
			$predeft+=$prendasdef;
			$preinst+=$prendasins;
			$prerept+=$prendasrep;
			$audaprt+=$audapr;
			$audtott+=$audtot;
		}else{
			if($turnoant!="0"){
				$obj=new stdClass();
				$obj->TURNO=$turnoant;
				$obj->MINEFI=$minefit;
				$obj->MINEFC=$minefct;
				$obj->MINASI1=$minasi1t;
				$obj->MINASI2=$minasi2t;
				$obj->PREDEF=$predeft;
				$obj->PREINS=$preinst;
				$obj->PREREP=$prerept;
				$obj->AUDAPR=$audaprt;
				$obj->AUDTOT=$audtott;
				$turnos[$i]=$obj;
				$i++;
			}

			$minefit=floatval(str_replace(",",".",$mineficiencia));
			$minefct=floatval(str_replace(",",".",$mineficacia));
			$minasi1t=$minasi1;
			$minasi2t=$minasi2;
			$predeft=$prendasdef;
			$preinst=$prendasins;
			$prerept=$prendasrep;
			$audaprt=$audapr;
			$audtott=$audtot;
			$turnoant=$row['TURNO'];
		}
	}
	
	$obj=new stdClass();
	$obj->TURNO=$turnoant;
	$obj->MINEFI=$minefit;
	$obj->MINEFC=$minefct;
	$obj->MINASI1=$minasi1t;
	$obj->MINASI2=$minasi2t;
	$obj->PREDEF=$predeft;
	$obj->PREINS=$preinst;
	$obj->PREREP=$prerept;
	$obj->AUDAPR=$audaprt;
	$obj->AUDTOT=$audtott;
	$turnos[$i]=$obj;

	$response->turnos=$turnos;

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

	$stmt = oci_parse($conn,'BEGIN SP_INSP_DATA_REPTUR(:FECHA,:SEMANA,:MES); END;');
	oci_bind_by_name($stmt,':FECHA',$fecha,40);
	oci_bind_by_name($stmt,':SEMANA',$semana,40);
	oci_bind_by_name($stmt,':MES',$mes,40);
	$result=oci_execute($stmt); 
	$response->fecha=$fecha;
	$response->semana=$semana;
	$response->mes=$mes;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>