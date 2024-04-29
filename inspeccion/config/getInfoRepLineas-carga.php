<?php
	set_time_limit(240);
	include('connection.php');
	$response=new stdClass();

	$ar_lineas=explode("-",$_POST['lineas']);
	$ar_fecha = explode("-",$_POST['fecha']);
	$fecha=$ar_fecha[0].$ar_fecha[1].$ar_fecha[2];
	$fecha_for=$ar_fecha[2]."-".$ar_fecha[1]."-".$ar_fecha[0];
	$ar_fechafin = explode("-",$_POST['fechafin']);
	$fechafin=$ar_fechafin[0].$ar_fechafin[1].$ar_fechafin[2];
	$fechafin_for=$ar_fecha[2]."-".$ar_fecha[1]."-".$ar_fecha[0];

	date_default_timezone_set('America/Lima');
	$fecha_hoy=date('Ymd');
	$response->fecha=$fecha_hoy;
	$response->fechaini=$fecha;
	$response->fechafin=$fechafin;

	$lineas=[];
	$k=0;
	for ($i=0; $i < count($ar_lineas) ; $i++) {		
		$sql="BEGIN SP_INSP_SELECT_LINETOHORFINTUR(:LINEA,:FECHA,:FECHAFIN,:OUTPUT_CUR); END;";		
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt,":LINEA", $ar_lineas[$i]);
		oci_bind_by_name($stmt,":FECHA", $fecha);
		oci_bind_by_name($stmt,":FECHAFIN", $fechafin);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$aux=[];
		$l=0;
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			/*$aux[$l]=$row;
			$l++;*/
			if ($fecha_hoy!=$row['FECHA']) {
				$hora=((int)$row['HORFIN'])*100-41;
				$hora="".$hora;

				$uno=new stdClass();

				$uno->fecha=$row['FECHAFOR'];
				$uno->fechaf=$row['FECHA'];
				$fechafor=substr($row['FECHA'],6,2)."/".substr($row['FECHA'],4,2)."/".substr($row['FECHA'],0,4);
				$uno->fechaf2=$fechafor;
				$uno->hora=$hora;
				$uno->linea=(int)$ar_lineas[$i];

				$stmt = oci_parse($conn,'BEGIN SP_MONI_SEL_DATOS_REP_MONITOR3(:LINEA,:FECHA,:HORA, :HORINIDIA, :HORINI, :HORFIN, :FECINI, :FECFIN, :HORACT, :TURNO, :MINASI1, :MINASI2, :MINEFICIENCIA, :PRENDASPRO, :PRENDASPRY, :CUOTA, :CAMBIOEST, :CLIENTE, :MINEFICACIA, :PRENDASDEF, :PRENDASINS, :PRENDASREP); END;');	
				oci_bind_by_name($stmt,':LINEA',$ar_lineas[$i]);
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
				$result=oci_execute($stmt);

				$uno->turno=(int)$turno;
				$uno->hini=$hini;
				$uno->hfin=$hfin;

				//------------------------CLIENTE
				$uno->cliente=$cliente;

				//--------------------EFICIENCIA - EFICACIA
				$denominador=$rowdos_uno+$rowdos_dos;
				if($denominador!=0){
					$uno->eficiencia=round($mineficiencia*100/$denominador);
					$uno->eficacia=round($mineficacia*100/$denominador);
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

				//---------------------PROYECCION
				$factor=(int)str_replace(",",".",$prendaspry);
				if ($factor<1) {
					$factor=1;
				}
				if ($denominador>0){
					$uno->factor=round(100*$factor/$denominador)/100;
				}else{
					$uno->factor=0;
				}	
					
				//---------------------CAMBIO DE ESTILO
				if ($cambioest<="1") {
					$uno->flag_cambio=1;
				}else{
					$uno->flag_cambio=1;
				}
				$uno->memoria=0;
				$lineas[$k]=$uno;
				$k++;

				$stmt = oci_parse($conn,'BEGIN SP_INSP_INSERT_HISEFILIN(:LINEA,:TURNO,:FECHA,:FECHAFOR,:HORA, :HORINI, :HORFIN, :CLIENTE, :EFICIENCIA, :EFICACIA, :PRENDASPRO, :CUOTA, :PRENDASDEF, :PRENDASINS, :PRENDASREP, :FACTOR, :FLAGCAMBIO); END;');	
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
				$result=oci_execute($stmt);
			}
		}
		$response->aux=$aux;
	}
	$response->lineas=$lineas;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>