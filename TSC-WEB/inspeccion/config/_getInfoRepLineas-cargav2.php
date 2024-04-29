<?php

	////// CARGA MASIVA DE EFICIENCIA A LA TABLA HISTORICA DE UNA FECHA EN ADELANTE
	set_time_limit(12400);
	include('connection.php');
	$fecha=explode("-",$_GET['fecha']);
	$fecha=$fecha[0].$fecha[1].$fecha[2];
	$err_counter=0;

	date_default_timezone_set('America/Lima');
	$fecha_hoy=date('Ymd');

	$sql="select lect.*,to_char(lect.fecha,'YYYYMMDD') FECHAF
	  ,to_char(lect.fecha,'DD/MM/YYYY') FECHAD,to_char(lect.HORFIN)||'00' HORA
	  from linea_eton_cuota_turno lect
	  LEFT JOIN HISEFILIN hel
	  ON lect.LINEA=hel.LINEA AND lect.TURNO=hel.TURNO AND trunc(lect.fecha)=trunc(hel.fecha)
	  WHERE to_char(lect.fecha,'YYYYMMDD')='$fecha'
	  /* and to_char(lect.fecha,'YYYYMMDD')<='20200330'*/
	  order by trunc(lect.fecha) asc,hel.linea,hel.turno";
  
	$stmt=oci_parse($conn,$sql);
	$result=oci_execute($stmt);

	while($row=oci_fetch_array($stmt,OCI_ASSOC)){
		if ($fecha_hoy!=$row['FECHAF']) {
			//echo $row['LINEA']."<br>";
			$uno=new stdClass();

			$uno->fechaf=$row['FECHAF'];
			$fechafor=$row['FECHAD'];
			$uno->fechaf2=$fechafor;
			$uno->hora=(int)$row['HORA'];
			$uno->linea=(int)$row['LINEA'];

			$stmt2 = oci_parse($conn,'BEGIN SP_MONI_SEL_DATOS_REP_MON6CE2(:LINEA,:FECHA,:HORA, :HORINIDIA, :HORINI, :HORFIN, :FECINI, :FECFIN, :HORACT, :TURNO, :MINASI1, :MINASI2, :MINEFICIENCIA, :PRENDASPRO, :PRENDASPRY, :CUOTA, :CAMBIOEST, :CLIENTE, :MINEFICACIA, :PRENDASDEF, :PRENDASINS, :PRENDASREP, :AUDAPR, :AUDTOT, :NUMINS,:MINEFICOM,:MINEFCCOM,:MINEFICOMEST,:MINEFCCOMEST,:PREING,:PREAUDAPR); END;');
			oci_bind_by_name($stmt2,':LINEA',$uno->linea);
			oci_bind_by_name($stmt2,':FECHA',$uno->fechaf);
			oci_bind_by_name($stmt2,':HORA',$uno->hora);
			oci_bind_by_name($stmt2,':HORINIDIA',$hinidia,40); 
			oci_bind_by_name($stmt2,':HORINI',$hini,40);
			oci_bind_by_name($stmt2,':HORFIN',$hfin,40);
			oci_bind_by_name($stmt2,':FECINI',$fecini,40); 
			oci_bind_by_name($stmt2,':FECFIN',$fecfin,40); 
			oci_bind_by_name($stmt2,':HORACT',$hact,40); 
			oci_bind_by_name($stmt2,':TURNO',$turno,40);
			oci_bind_by_name($stmt2,':MINASI1',$rowdos_uno,40); 
			oci_bind_by_name($stmt2,':MINASI2',$rowdos_dos,40); 
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
			oci_bind_by_name($stmt2,':MINEFICOM',$mineficom,40);
			oci_bind_by_name($stmt2,':MINEFCCOM',$minefccom,40);   
			oci_bind_by_name($stmt2,':MINEFICOMEST',$mineficomest,40);
			oci_bind_by_name($stmt2,':MINEFCCOMEST',$minefccomest,40);
			oci_bind_by_name($stmt2,':PREING',$preing,40);
			oci_bind_by_name($stmt2,':PREAUDAPR',$preaudapr,40);
			$result=oci_execute($stmt2);

			$uno->turno=(int)$turno;
			$uno->hini=$hini;
			$uno->hfin=$hfin;

			//------------------------CLIENTE
			$uno->cliente=$cliente;

			//--------------------EFICIENCIA - EFICACIA
			$denominador=$rowdos_uno+$rowdos_dos;
			$uno->minasi=$denominador;
			$uno->mineficiencia=round(floatval(str_replace(",",".",$mineficiencia)));
			$uno->mineficacia=round(floatval(str_replace(",",".",$mineficacia)));
			if($denominador!=0){
				$uno->eficiencia=round(floatval(str_replace(",",".",$mineficiencia))*100/$denominador);
				$uno->eficacia=round(floatval(str_replace(",",".",$mineficacia))*100/$denominador);
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

			//---------------------27/04/2020
			$uno->preing=(int)$preing;
			$uno->preaudapr=(int)$preaudapr;
				
			//---------------------REPROCESOS DE COSTURA (CANTIDAD DE DEFECTOS)
			$uno->prendas_reproceso=(int)$prendasrep;

			//---------------------PROYECCION
			$factor=(int)str_replace(",",".",$prendaspry);

			$uno->factor=1;
			/*
			if ($factor>1) {
				$factor=1;
			}
			if ($denominador>0){
			}else{
				$uno->factor=0;
			}*/	
				
			//---------------------CAMBIO DE ESTILO
			if ($cambioest=="1") {
				$uno->flag_cambio=1;
			}else{
				$uno->flag_cambio=0;
			}

			//echo json_encode($uno)."<BR>";

			$stmt2 = oci_parse($conn,'BEGIN SP_INSP_INSERT_HISEFILINAUX(:LINEA,:TURNO,:FECHA,:FECHAFOR,:HORA, :HORINI, :HORFIN, :CLIENTE, :EFICIENCIA, :EFICACIA, :PRENDASPRO, :CUOTA, :PRENDASDEF, :PRENDASINS, :PRENDASREP, :FACTOR, :FLAGCAMBIO,:MINASI,:MINEFI,:MINEFC,:AUDAPR, :AUDTOT,:MINEFICOM,:MINEFCCOM,:MINEFICOMEST,:MINEFCCOMEST,:PREING,:PREAUDAPR); END;');	
			oci_bind_by_name($stmt2,':LINEA',$uno->linea);
			oci_bind_by_name($stmt2,':TURNO',$uno->turno);
			oci_bind_by_name($stmt2,':FECHA',$uno->fechaf);
			oci_bind_by_name($stmt2,':FECHAFOR',$uno->fechaf2);
			oci_bind_by_name($stmt2,':HORA',$uno->hora);
			oci_bind_by_name($stmt2,':HORINI',$uno->hini);   
			oci_bind_by_name($stmt2,':HORFIN',$uno->hfin); 
			oci_bind_by_name($stmt2,':CLIENTE',$uno->cliente); 
			oci_bind_by_name($stmt2,':EFICIENCIA',$uno->eficiencia); 
			oci_bind_by_name($stmt2,':EFICACIA',$uno->eficacia); 
			oci_bind_by_name($stmt2,':PRENDASPRO',$uno->prendas_producidas);
			oci_bind_by_name($stmt2,':CUOTA',$uno->cuota); 
			oci_bind_by_name($stmt2,':PRENDASDEF',$uno->prendas_defectuosas); 
			oci_bind_by_name($stmt2,':PRENDASINS',$uno->prendas_inspecionadas); 
			oci_bind_by_name($stmt2,':PRENDASREP',$uno->prendas_reproceso); 
			oci_bind_by_name($stmt2,':FACTOR',$uno->factor); 
			oci_bind_by_name($stmt2,':FLAGCAMBIO',$uno->flag_cambio);
			oci_bind_by_name($stmt2,':MINASI',$denominador);
			oci_bind_by_name($stmt2,':MINEFI',$mineficiencia);
			oci_bind_by_name($stmt2,':MINEFC',$mineficacia);
			oci_bind_by_name($stmt2,':AUDAPR',$audapr);
			oci_bind_by_name($stmt2,':AUDTOT',$audtot);
			oci_bind_by_name($stmt2,':MINEFICOM',$mineficom); 
			oci_bind_by_name($stmt2,':MINEFCCOM',$minefccom);
			oci_bind_by_name($stmt2,':MINEFICOMEST',$mineficomest);
			oci_bind_by_name($stmt2,':MINEFCCOMEST',$minefccomest);
			oci_bind_by_name($stmt2,':PREING',$preing);
			oci_bind_by_name($stmt2,':PREAUDAPR',$preaudapr);
			$result=oci_execute($stmt2);
			if ($result) {
				//echo $uno->linea." - ".$uno->fechaf." - ".$uno->turno." - CORRECTO.<br><br>";
			}else{
				/*echo "Linea: ".$uno->linea." - Turno: ".$uno->turno." - ".$uno->fechaf.
				" - Pre. Ing.: ".$preing." - Pre. Aud. Apr.: ".$preaudapr." - NO CORRECTO.<br><br>";*/
				$err_counter++;
			}
		}
	}
	echo "Errores: ".$err_counter;
	oci_close($conn);
?>