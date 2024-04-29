<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Reporte_ranking_lineas_servicios.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

include("../connection.php");

	$whereSede="";
	$whereTipSer="";
	if ($_GET['codsede']!=0) {
		$whereSede=" and ae.codsede=".$_GET['codsede'];
	}
	if ($_GET['codtipser']!=0) {
		$whereTipSer=" and ae.codtiposerv=".$_GET['codtipser'];
	}
	$talleres=[];

	if ($_GET['option']=="1") {
		$sql="select ae.codtll, t.destll, s.dessede, ts.destipserv
		     , (count(fa.codfic) - nvl(count(fap.codfic),0))/ count(fa.codfic) Porcentaje
		     , count(fa.codfic) Aud_tot
		     , count(fa.codfic) - nvl(count(fap.codfic),0) Aud_rec
		  from taller t, sede s, tiposervicio ts
		    , (select distinct a.codenv, a.codfic, t.codtll, t.codsede, t.codtiposerv
		         from auditoriaenvio a, taller t where a.codtll = t.codtll) ae
		     , fichaauditoria fa left join fichaauditoria fap on fa.codfic = fap.codfic and fa.parte = fap.parte
		   and fa.numvez = fap.numvez and fa.codtad = fap.codtad and fap.estado = 'T' and fap.resultado = 'A'  
		  where t.codtll = ae.codtll and t.codsede = s.codsede and t.codtiposerv = ts.codtipserv 
		   and fa.estado = 'T'  
		   and to_char(fa.feciniaud,'YYYYMM') = '".$_GET['anio'].$_GET['mes']."' 
		   and ae.codenv = fa.codenv
		   ".$whereSede."
		   ".$whereTipSer."
		 group by ae.codtll, t.destll, s.dessede, ts.destipserv
		 having (count(fa.codfic) - nvl(count(fap.codfic),0)) > 0
		 order by Porcentaje desc";
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		$i=0;
		while ($row=oci_fetch_array($stmt)) {
			$obj=new stdClass();
			$obj->CODTLL=$row['CODTLL'];
			$obj->DESTLL=utf8_encode($row['DESTLL']);
			$obj->DESSEDE=utf8_encode($row['DESSEDE']);
			$obj->DESTIPSERV=utf8_encode($row['DESTIPSERV']);
			$obj->PORCENTAJE=$row['PORCENTAJE'];
			$obj->AUD_TOT=$row['AUD_TOT'];
			$obj->AUD_REC=$row['AUD_REC'];
			$talleres[$i]=$obj;
			$i++;
		}
	}
	if ($_GET['option']=="2") {
		$sql="select numero_semana, min(fecha_calendario) MIN, max(fecha_calendario) MAX
		from fecha_semana where anio = ".$_GET['anio']." and NUMERO_SEMANA=".$_GET['semana']."
			group by numero_semana order by numero_semana desc";			
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		$rowresult=oci_fetch_array($stmt);
		$ar_fecini=explode("/", $rowresult['MIN']);
		$ar_fecfin=explode("/", $rowresult['MAX']);

		$sql="select ae.codtll, t.destll, s.dessede, ts.destipserv
		     , (count(fa.codfic) - nvl(count(fap.codfic),0))/ count(fa.codfic) Porcentaje
		     , count(fa.codfic) Aud_tot
		     , count(fa.codfic) - nvl(count(fap.codfic),0) Aud_rec
		  from taller t, sede s, tiposervicio ts
		    , (select distinct a.codenv, a.codfic, t.codtll, t.codsede, t.codtiposerv
		         from auditoriaenvio a, taller t where a.codtll = t.codtll) ae
		     , fichaauditoria fa left join fichaauditoria fap on fa.codfic = fap.codfic and fa.parte = fap.parte
		   and fa.numvez = fap.numvez and fa.codtad = fap.codtad and fap.estado = 'T' and fap.resultado = 'A'  
		  where t.codtll = ae.codtll and t.codsede = s.codsede and t.codtiposerv = ts.codtipserv 
		   and fa.estado = 'T'  
		   and to_char(fa.feciniaud,'YYYYMMDD') >= '".($ar_fecini[2]+2000).$ar_fecini[1].$ar_fecini[0]."'
		   and to_char(fa.feciniaud,'YYYYMMDD') <= '".($ar_fecfin[2]+2000).$ar_fecfin[1].$ar_fecfin[0]."'     
		   and ae.codenv = fa.codenv
		   ".$whereSede."
		   ".$whereTipSer."
		 group by ae.codtll, t.destll, s.dessede, ts.destipserv
		 having (count(fa.codfic) - nvl(count(fap.codfic),0)) > 0
		 order by Porcentaje desc";
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		$i=0;
		while ($row=oci_fetch_array($stmt)) {
			$obj=new stdClass();
			$obj->CODTLL=$row['CODTLL'];
			$obj->DESTLL=utf8_encode($row['DESTLL']);
			$obj->DESSEDE=utf8_encode($row['DESSEDE']);
			$obj->DESTIPSERV=utf8_encode($row['DESTIPSERV']);
			$obj->PORCENTAJE=$row['PORCENTAJE'];
			$obj->AUD_TOT=$row['AUD_TOT'];
			$obj->AUD_REC=$row['AUD_REC'];
			$talleres[$i]=$obj;
			$i++;
		}
	}
	if ($_GET['option']=="3") {
		$ar_fecini=explode("-", $_GET['fecini']);
		$ar_fecfin=explode("-", $_GET['fecfin']);

		$sql="select ae.codtll, t.destll, s.dessede, ts.destipserv
		     , (count(fa.codfic) - nvl(count(fap.codfic),0))/ count(fa.codfic) Porcentaje
		     , count(fa.codfic) Aud_tot
		     , count(fa.codfic) - nvl(count(fap.codfic),0) Aud_rec
		  from taller t, sede s, tiposervicio ts
		    , (select distinct a.codenv, a.codfic, t.codtll, t.codsede, t.codtiposerv
		         from auditoriaenvio a, taller t where a.codtll = t.codtll) ae
		     , fichaauditoria fa left join fichaauditoria fap on fa.codfic = fap.codfic and fa.parte = fap.parte
		   and fa.numvez = fap.numvez and fa.codtad = fap.codtad and fap.estado = 'T' and fap.resultado = 'A'  
		  where t.codtll = ae.codtll and t.codsede = s.codsede and t.codtiposerv = ts.codtipserv 
		   and fa.estado = 'T'  
		   and to_char(fa.feciniaud,'YYYYMMDD') >= '".$ar_fecini[0].$ar_fecini[1].$ar_fecini[2]."'
		   and to_char(fa.feciniaud,'YYYYMMDD') <= '".$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2]."'     
		   and ae.codenv = fa.codenv
		   ".$whereSede."
		   ".$whereTipSer."
		 group by ae.codtll, t.destll, s.dessede, ts.destipserv
		 having (count(fa.codfic) - nvl(count(fap.codfic),0)) > 0
		 order by Porcentaje desc";
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		$talleres=[];
		$i=0;
		while ($row=oci_fetch_array($stmt)) {
			$obj=new stdClass();
			$obj->CODTLL=$row['CODTLL'];
			$obj->DESTLL=utf8_encode($row['DESTLL']);
			$obj->DESSEDE=utf8_encode($row['DESSEDE']);
			$obj->DESTIPSERV=utf8_encode($row['DESTIPSERV']);
			$obj->PORCENTAJE=$row['PORCENTAJE'];
			$obj->AUD_TOT=$row['AUD_TOT'];
			$obj->AUD_REC=$row['AUD_REC'];
			$talleres[$i]=$obj;
			$i++;
		}
	}

?>
<div style="font-size: 20px;font-weight: bold;">Reporte de Ranking de rechazos de auditor&iacute;as finales de costura en L&iacute;neas/Servicios</div>
<br>
<div style="font-weight: bold;"><?php echo $_GET['titulo'];?></div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Cod. Taller</th>		
			<th style="border:1px solid #333;">Taller</th>
			<th style="border:1px solid #333;">Sede</th>
			<th style="border:1px solid #333;">Tipo Servicio</th>
			<th style="border:1px solid #333;">%</th>
			<th style="border:1px solid #333;">Total auditadas</th>
			<th style="border:1px solid #333;">Total rechazadas</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$i=0;
			while ($i<count($talleres)) {
		?>
		<tr>
			<td style="border:1px solid #333;"><?php echo "COD".$talleres[$i]->CODTLL; ?></td>
			<td style="border:1px solid #333;"><?php echo $talleres[$i]->DESTLL; ?></td>
			<td style="border:1px solid #333;"><?php echo $talleres[$i]->DESSEDE; ?></td>
			<td style="border:1px solid #333;"><?php echo $talleres[$i]->DESTIPSERV; ?></td>
			<td style="border:1px solid #333;"><?php echo (round(((float)str_replace(",",".",$talleres[$i]->PORCENTAJE))*10000)/100)." %"; ?></td>
			<td style="border:1px solid #333;"><?php echo $talleres[$i]->AUD_TOT; ?></td>
			<td style="border:1px solid #333;"><?php echo $talleres[$i]->AUD_REC; ?></td>
		</tr>
		<?php
				$i++;
			}
		?>
	</tbody>
</table>