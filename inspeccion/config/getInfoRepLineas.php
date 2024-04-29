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
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			if ($fecha_hoy==$row['FECHA']) {
				$hora=((int)$row['HORFIN'])*100-41;
				$hora="".$hora;

				$uno=new stdClass();

				$uno->fecha=$row['FECHAFOR'];
				$uno->fechaf=$row['FECHA'];
				$uno->hora=$hora;
				$uno->linea=$ar_lineas[$i];

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

				$uno->turno=$turno;
				$uno->hini=$hini;
				$uno->hfin=$hfin;

				//------------------------CLIENTE
				$uno->cliente=$cliente;

				//--------------------EFICIENCIA - EFICACIA
				$denominador=$rowdos_uno+$rowdos_dos;
				$uno->minasi=$denominador;
				$uno->mineficiencia=$mineficiencia;
				$uno->mineficacia=$mineficacia;
				if($denominador!=0){
					$uno->eficiencia=round(floatval($mineficiencia)*100/$denominador);
					$uno->eficacia=round(floatval($mineficacia)*100/$denominador);
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
				$uno->memoria=0;
				$lineas[$k]=$uno;
				$k++;
			}else{
				$stmt2 = oci_parse($conn,'BEGIN SP_INSP_SELECT_HISEFILIN(:LINEA,:TURNO,:FECHA, :OUTPUT); END;');	
				oci_bind_by_name($stmt2,':LINEA',$ar_lineas[$i]);
				oci_bind_by_name($stmt2,':TURNO',$row['TURNO']);
				oci_bind_by_name($stmt2,':FECHA',$row['FECHA']);
				$OUTPUT_CUR2=oci_new_cursor($conn);
				oci_bind_by_name($stmt2,':OUTPUT',$OUTPUT_CUR2,-1,OCI_B_CURSOR);
				$result2=oci_execute($stmt2);
				oci_execute($OUTPUT_CUR2);
				while($row2=oci_fetch_assoc($OUTPUT_CUR2)){
					$uno=new stdClass();
					$uno->linea=$row2['LINEA'];
					$uno->fecha=$row2['FECHAFOR'];
					$uno->fechaf=$row2['FECHA'];
					$uno->turno=$row2['TURNO'];
					$uno->hora=$row2['HORA'];
					$uno->hini=$row2['HORINI'];
					$uno->hfin=$row2['HORFIN'];
					$uno->cliente=$row2['CLIENTE'];
					$uno->eficiencia=$row2['EFICIENCIA'];
					$uno->eficacia=$row2['EFICACIA'];
				    $uno->prendas_producidas=$row2['PREPRO'];;
					$uno->cuota=$row2['CUOTA'];;
					$uno->prendas_defectuosas=$row2['PREDEF'];;
					$uno->prendas_inspecionadas=$row2['PREINS'];;
					$uno->prendas_reproceso=$row2['PREREP'];;
					$uno->factor=$row2['FACTOR'];
					$uno->minasi=$row2['MINASIGNADOS'];
					$uno->mineficacia=$row2['MINEFICIENCIA'];
					$uno->mineficiencia=$row2['MINEFICACIA'];
					$uno->memoria=1;
					if ($row2['FLAGCAMBIO']=="1") {
						$uno->flag_cambio=true;
					}else{
						$uno->flag_cambio=false;
					}

					$lineas[$k]=$uno;
					$k++;
				}
			}
		}
	}
	$response->lineas=$lineas;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>