<?php 
	set_time_limit(240);
	include('../connection.php');
	header("Pragma: public");
	header("Expires: 0");
	$filename = "Reporte_eficacia_costura.xls";
	header("Content-type: application/x-msdownload");
	header("Content-Disposition: attachment; filename=$filename");
	header("Pragma: no-cache");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	function formatMiles($value){
		$value=$value."";
		$delimiter=".";
		if (strrpos($value,",")!=false) {
			$delimiter=",";
		}
		$ar=explode($delimiter, $value);
		$entero=$ar[0];
		$i=strlen($entero)-1;
		$a=0;
		$aux="";
		while($i>=0){
			if ($a%3==0 && $a!=0) {
				$aux=$entero[$i].",".$aux;
			}else{
				$aux=$entero[$i].$aux;
			}
			$a++;
			$i--;
		}
		return $aux;
	}

	$ar_lineas=explode("-",$_GET['lineas']);
	$ar_fecha = explode("-",$_GET['fecha']);
	$fecha=$ar_fecha[0].$ar_fecha[1].$ar_fecha[2];
	$fecha_for=$ar_fecha[2]."-".$ar_fecha[1]."-".$ar_fecha[0];
	$ar_fechafin = explode("-",$_GET['fechafin']);
	$fechafin=$ar_fechafin[0].$ar_fechafin[1].$ar_fechafin[2];
	$fechafin_for=$ar_fecha[2]."-".$ar_fecha[1]."-".$ar_fecha[0];
	
	date_default_timezone_set('America/Lima');
	$fecha_hoy=date('Ymd');

	$sql="BEGIN SP_INSP_GET_HORAACTUAL(:HORAACTUAL); END;";		
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt,":HORAACTUAL", $horaactual,40);
	$result=oci_execute($stmt);

	$lineas=[];
	$k=0;
	if ($ar_lineas[0]=="0") {		
		$sql="BEGIN SP_INSP_SELECT_LEHORFINTURALL(:FECHA,:FECHAFIN,:OUTPUT_CUR); END;";		
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt,":FECHA", $fecha);
		oci_bind_by_name($stmt,":FECHAFIN", $fechafin);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			if ($fecha_hoy==$row['FECHA']) {
				$uno=new stdClass();

				$uno->horaactual=$horaactual;

				$hora=((int)$row['HORFIN'])*100;
				$hora="".$hora;

				if (intval($hora)<intval($horaactual)) {
					$uno->hora=$hora;
				}else{
					$uno->hora=$horaactual;
				}

				$uno->fecha=$row['FECHAFOR'];
				$uno->fechaf=$row['FECHA'];
				$uno->linea=$row['LINEA'];

				$stmt = oci_parse($conn,'BEGIN SP_MONI_SEL_DATOS_REP_MON3CE3(:LINEA,:FECHA,:HORA, :HORINIDIA, :HORINI, :HORFIN, :FECINI, :FECFIN, :HORACT, :TURNO, :MINASI1, :MINASI2, :MINEFICIENCIA, :PRENDASPRO, :PRENDASPRY, :CUOTA, :CAMBIOEST, :CLIENTE, :MINEFICACIA, :PRENDASDEF, :PRENDASINS, :PRENDASREP,:MINEFICOM,:MINEFCCOM,:MINEFICOMEST,:MINEFCCOMEST,:PREING,:PREAUDAPR,:NUMOPE); END;');	
				oci_bind_by_name($stmt,':LINEA',$row['LINEA']);
				oci_bind_by_name($stmt,':FECHA',$row['FECHA']);
				oci_bind_by_name($stmt,':HORA',$uno->hora);
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
				oci_bind_by_name($stmt,':NUMOPE',$numope,40);
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
				$uno->mineficienciacom=$mineficienciacom;
				$uno->mineficaciacom=$mineficaciacom;
				$uno->mineficienciacomest=$mineficienciacomest;
				$uno->mineficaciacomest=$mineficaciacomest;
				if($denominador!=0){
					$uno->eficiencia=round(floatval($mineficiencia)*100/$denominador, 2);
					$uno->eficacia=round(floatval($mineficacia)*100/$denominador, 2);
					$uno->eficienciacom=round(floatval($mineficienciacom)*100/$denominador,2);
					$uno->eficaciacom=round(floatval($mineficaciacom)*100/$denominador,2);
					$uno->eficienciacomest=round(floatval($mineficienciacomest)*100/$denominador,2);
					$uno->eficaciacomest=round(floatval($mineficaciacomest)*100/$denominador,2);
				}else{
					$uno->eficiencia="-";
					$uno->eficacia="-";
					$uno->eficienciacom="-";
					$uno->eficaciacom="-";
					$uno->eficienciacomest="-";
					$uno->eficaciacomest="-";
				}

				//---------------------PRENDAS PRODUCIDAS
			    $uno->prendas_producidas=$prendaspro;
				
				//---------------------CUOTA
				$uno->cuota=$cuota;

				//---------------------PRENDAS DEFECTUOSAS
				$uno->prendas_defectuosas=$prendasdef;
				$uno->prendas_inspecionadas=$prendasins;

				//---------------------27/04/2020
				$uno->preing=$preing;
				$uno->preaudapr=$preaudapr;
					
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
				$uno->numope=$numope;
				$lineas[$k]=$uno;
				$k++;
			}else{
				$stmt2 = oci_parse($conn,'BEGIN SP_INSP_SELECT_HISEFILIN(:LINEA,:TURNO,:FECHA, :OUTPUT); END;');	
				oci_bind_by_name($stmt2,':LINEA',$row['LINEA']);
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
					$uno->mineficienciacom=$row2['MINEFICIENCIACOMP'];
					$uno->mineficaciacom=$row2['MINEFICACIACOMP'];
					$uno->mineficienciacomest=$row2['MINEFICIENCIACOMPEST'];
					$uno->mineficaciacomest=$row2['MINEFICACIACOMPEST'];
					$uno->preing=$row2['PREING'];
					$uno->preaudapr=$row2['PREAUDAPR'];
					$uno->numope=$row2['NUMOPE'];
					$denominador=floatval($row2['MINASIGNADOS']);
					if ($denominador!=0) {
						$uno->eficienciacom=round(floatval($row2['MINEFICIENCIACOMP'])*100/$denominador,2);
						$uno->eficaciacom=round(floatval($row2['MINEFICACIACOMP'])*100/$denominador,2);

						$uno->eficienciacomest=round(floatval($row2['MINEFICIENCIACOMPEST'])*100/$denominador,2);
						$uno->eficaciacomest=round(floatval($row2['MINEFICACIACOMPEST'])*100/$denominador,2);
					}else{
						$uno->eficienciacom=0;
						$uno->eficaciacom=0;

						$uno->eficienciacomest=0;
						$uno->eficaciacomest=0;	
					}
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
	}else{
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
					$uno=new stdClass();
					$uno->horaactual=$horaactual;

					$hora=((int)$row['HORFIN'])*100;
					$hora="".$hora;

					if (intval($hora)<intval($horaactual)) {
						$uno->hora=$hora;
					}else{
						$uno->hora=$horaactual;
					}

					$uno->fecha=$row['FECHAFOR'];
					$uno->fechaf=$row['FECHA'];
					$uno->linea=$ar_lineas[$i];

					$stmt = oci_parse($conn,'BEGIN SP_MONI_SEL_DATOS_REP_MON3CE3(:LINEA,:FECHA,:HORA, :HORINIDIA, :HORINI, :HORFIN, :FECINI, :FECFIN, :HORACT, :TURNO, :MINASI1, :MINASI2, :MINEFICIENCIA, :PRENDASPRO, :PRENDASPRY, :CUOTA, :CAMBIOEST, :CLIENTE, :MINEFICACIA, :PRENDASDEF, :PRENDASINS, :PRENDASREP,:MINEFICOM,:MINEFCCOM,:MINEFICOMEST,:MINEFCCOMEST,:PREING,:PREAUDAPR,:NUMOPE); END;');	
					oci_bind_by_name($stmt,':LINEA',$ar_lineas[$i]);
					oci_bind_by_name($stmt,':FECHA',$row['FECHA']);
					oci_bind_by_name($stmt,':HORA',$uno->hora);
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
					oci_bind_by_name($stmt,':NUMOPE',$numope,40);
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
					$uno->mineficienciacom=$mineficienciacom;
					$uno->mineficaciacom=$mineficaciacom;
					$uno->mineficienciacomest=$mineficienciacomest;
					$uno->mineficaciacomest=$mineficaciacomest;
					if($denominador!=0){
						$uno->eficiencia=round(floatval($mineficiencia)*100/$denominador,2);
						$uno->eficacia=round(floatval($mineficacia)*100/$denominador,2);
						$uno->eficienciacom=round(floatval($mineficienciacom)*100/$denominador,2);
						$uno->eficaciacom=round(floatval($mineficaciacom)*100/$denominador,2);
						$uno->eficienciacomest=round(floatval($mineficienciacomest)*100/$denominador,2);
						$uno->eficaciacomest=round(floatval($mineficaciacomest)*100/$denominador,2);
					}else{
						$uno->eficiencia="-";
						$uno->eficacia="-";
						$uno->eficienciacom="-";
						$uno->eficaciacom="-";
						$uno->eficienciacomest="-";
						$uno->eficaciacomest="-";
					}

					//---------------------PRENDAS PRODUCIDAS
				    $uno->prendas_producidas=$prendaspro;
					
					//---------------------CUOTA
					$uno->cuota=$cuota;

					//---------------------PRENDAS DEFECTUOSAS
					$uno->prendas_defectuosas=$prendasdef;
					$uno->prendas_inspecionadas=$prendasins;

					//---------------------27/04/2020
					$uno->preing=$preing;
					$uno->preaudapr=$preaudapr;
						
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
					$uno->numope=$numope;
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
						$uno->mineficienciacom=$row2['MINEFICIENCIACOMP'];
						$uno->mineficaciacom=$row2['MINEFICACIACOMP'];
						$uno->mineficienciacomest=$row2['MINEFICIENCIACOMPEST'];
						$uno->mineficaciacomest=$row2['MINEFICACIACOMPEST'];
						$uno->preing=$row2['PREING'];
						$uno->preaudapr=$row2['PREAUDAPR'];
						$uno->numope=$row2['NUMOPE'];
						$denominador=floatval($row2['MINASIGNADOS']);
						if ($denominador!=0) {
							$uno->eficienciacom=round(floatval($row2['MINEFICIENCIACOMP'])*100/$denominador,2);
							$uno->eficaciacom=round(floatval($row2['MINEFICACIACOMP'])*100/$denominador,2);

							$uno->eficienciacomest=round(floatval($row2['MINEFICIENCIACOMPEST'])*100/$denominador,2);
							$uno->eficaciacomest=round(floatval($row2['MINEFICACIACOMPEST'])*100/$denominador,2);
						}else{
							$uno->eficienciacom=0;
							$uno->eficaciacom=0;

							$uno->eficienciacomest=0;
							$uno->eficaciacomest=0;	
						}
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
	}
	oci_close($conn);

	function format_for_hora($text){
		return substr($text,0,2).":".substr($text,2,2);
	}
?>
<div style="font-size: 20px;font-weight: bold;">Reporte de Eficacia de costura</div>
<br>
<div style="font-weight: bold;">Fechas:</div>
<div>Del <?php echo $fecha_for; ?> al <?php echo $fechafin_for; ?></div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Lineas de Planta - Chincha</th>
			<th style="border:1px solid #333;">Turno</th>
			<th style="border:1px solid #333;">Fecha</th>
			<th style="border:1px solid #333;">Operarios inicio de turno</th>
			<th style="border:1px solid #333;">Hora fin de jornada</th>
			<th style="border:1px solid #333;">Cliente</th>
			<th style="border:1px solid #333;">Eficiencia</th>
			<th style="border:1px solid #333;">Eficacia</th>
			<th style="border:1px solid #333;">Min. Eficiencia</th>
			<th style="border:1px solid #333;">Min. Eficacia</th>
			<th style="border:1px solid #333;">Min. Asi.</th>
			<th style="border:1px solid #333;">Prendas ingresadas</th>
			<th style="border:1px solid #333;">Prendas Producidas</th>
			<th style="border:1px solid #333;">Proyecci&oacute;n</th>
			<th style="border:1px solid #333;">Cuota</th>
			<th style="border:1px solid #333;">Prendas auditadas aprobadas</th>
			<th style="border:1px solid #333;">Prendas Inspeccionadas</th>
			<th style="border:1px solid #333;">Prendas Defectuosas</th>
			<th style="border:1px solid #333;">% Prendas Defectuosas</th>
			<th style="border:1px solid #333;">Reproceso de costura</th>
			<th style="border:1px solid #333;">% Reproceso de costura</th>
			<!--
			<th style="border:1px solid #333;">Efi. Est.</th>
			<th style="border:1px solid #333;">Efc. Est.</th>
			<th style="border:1px solid #333;">Min. Efi. Est.</th>
			<th style="border:1px solid #333;">Min. Efc. Est.</th>
			<th style="border:1px solid #333;">Efi. Ori.</th>
			<th style="border:1px solid #333;">Efc. Ori.</th>
			<th style="border:1px solid #333;">Min. Efi. Ori.</th>
			<th style="border:1px solid #333;">Min. Efc. Ori.</th>-->
		</tr>
	</thead>
	<tbody>
		<?php 
			for ($i=0; $i < count($lineas) ; $i++) {
				if ($lineas[$i]->turno!=0) {
		?>
		<tr>
		<?php
					$pren_defe=0;
					if ($lineas[$i]->prendas_inspecionadas!=0) {
						$pren_defe=round($lineas[$i]->prendas_defectuosas*100/$lineas[$i]->prendas_inspecionadas);
					}
					$pren_repr=0;
					if ($lineas[$i]->prendas_inspecionadas!=0) {
						$pren_repr=round($lineas[$i]->prendas_reproceso*100/$lineas[$i]->prendas_inspecionadas);
					}
		?>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->linea; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->turno; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->fecha; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->numope; ?></td>
			<td style="border:1px solid #333;"><?php echo format_for_hora($lineas[$i]->hora); ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->cliente; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->eficienciacom; ?>%</td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->eficaciacom; ?>%</td>
			<td style="border:1px solid #333;"><?php echo formatMiles($lineas[$i]->mineficienciacom); ?></td>
			<td style="border:1px solid #333;"><?php echo formatMiles($lineas[$i]->mineficaciacom); ?></td>
			<td style="border:1px solid #333;"><?php echo formatMiles($lineas[$i]->minasi); ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->preing; ?></td>
			<td style="border:1px solid #333;"><?php echo formatMiles($lineas[$i]->prendas_producidas); ?></td>
			<td style="border:1px solid #333;"><?php echo formatMiles(round(((int)$lineas[$i]->prendas_producidas)*((int)$lineas[$i]->factor))); ?></td>
			<td style="border:1px solid #333;"><?php echo formatMiles($lineas[$i]->cuota); ?></td>
			<td style="border:1px solid #333;"><?php echo formatMiles($lineas[$i]->preaudapr); ?></td>
			<td style="border:1px solid #333;"><?php echo formatMiles($lineas[$i]->prendas_inspecionadas); ?></td>
			<td style="border:1px solid #333;"><?php echo formatMiles($lineas[$i]->prendas_defectuosas); ?></td>
			<td style="border:1px solid #333;"><?php echo $pren_defe; ?>%</td>
			<td style="border:1px solid #333;"><?php echo formatMiles($lineas[$i]->prendas_reproceso); ?></td>
			<td style="border:1px solid #333;"><?php echo $pren_repr; ?>%</td>
			<!--			
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->eficienciacomest; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->eficaciacomest; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->mineficienciacomest; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->mineficaciacomest; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->eficiencia; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->eficacia; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->mineficiencia; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->mineficacia; ?></td>-->
		</tr>
		<?php
				}else{
		?>
		<tr style="background: #f5ffa6;">
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->linea; ?></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->fecha; ?></td>
			<td style="border:1px solid #333;" colspan="18">DESACTIVADO</td>
			<!--
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"></td>-->
		</tr>
		<?php
				}
			}
		?>
	</tbody>
</table>