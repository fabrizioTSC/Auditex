<?php
	/////// CARGA A HISTORICO DE EFICIENCIA POR REGISTROS
	set_time_limit(1200);
	include('connection.php');

		/*$sql="select hel.*,to_char(fecha,'YYYYMMDD') FECHAF,to_char(fecha,'DD/MM/YYYY') FECHAD from HISEFILIN hel where minasignados is null
		and to_char(fecha,'YYYYMMDD')>'20190815' and to_char(fecha,'YYYYMMDD')<='20191019'
		order by fecha,linea,turno";	*/
		$sql="select hel.*,to_char(fecha,'YYYYMMDD') FECHAF,to_char(fecha,'DD/MM/YYYY') FECHAD from HISEFILIN HEL where to_char(fecha,'YYYYMMDD')>='20191216'";
		$stmt=oci_parse($conn,$sql);
		$result=oci_execute($stmt);

		while($row=oci_fetch_array($stmt,OCI_ASSOC)){
			echo $row['LINEA']."<br>";
			$uno=new stdClass();

			$uno->fechaf=$row['FECHAF'];
			$fechafor=$row['FECHAD'];
			$uno->fechaf2=$fechafor;
			$uno->hora=(int)$row['HORA'];
			$uno->linea=(int)$row['LINEA'];
/*
			$uno=new stdClass();

			$uno->fechaf='20191019';
			$fechafor='19/10/2019';
			$uno->fechaf2=$fechafor;
			$uno->hora=2159;
			$uno->linea=10;*/

			$stmt2 = oci_parse($conn,'BEGIN SP_MONI_SEL_DATOS_REP_MONITOR3(:LINEA,:FECHA,:HORA, :HORINIDIA, :HORINI, :HORFIN, :FECINI, :FECFIN, :HORACT, :TURNO, :MINASI1, :MINASI2, :MINEFICIENCIA, :PRENDASPRO, :PRENDASPRY, :CUOTA, :CAMBIOEST, :CLIENTE, :MINEFICACIA, :PRENDASDEF, :PRENDASINS, :PRENDASREP); END;');	
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
			$result=oci_execute($stmt2);

			$uno->turno=(int)$turno;
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
			echo json_encode($uno)."<BR>";

			$stmt2 = oci_parse($conn,'BEGIN SP_INSP_INSERT_HISEFILIN(:LINEA,:TURNO,:FECHA,:FECHAFOR,:HORA, :HORINI, :HORFIN, :CLIENTE, :EFICIENCIA, :EFICACIA, :PRENDASPRO, :CUOTA, :PRENDASDEF, :PRENDASINS, :PRENDASREP, :FACTOR, :FLAGCAMBIO,:MINASI,:MINEFI,:MINEFC); END;');	
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
			$result=oci_execute($stmt2);
			if ($result) {
				echo $uno->linea." - ".$uno->fechaf." - ".$uno->turno." - CORRECTO.<br><br>";
			}else{
				echo $uno->linea." - ".$uno->fechaf." - ".$uno->turno." - NO CORRECTO.<br><br>";
			}
		}

	oci_close($conn);
?>