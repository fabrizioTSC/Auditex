<?php
set_time_limit(120);
header("Pragma: public");
header("Expires: 0");
$filename = "Reporte_ranking_lineas_servicios.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

include("../connection.php");

	$anio="";
	if(isset($_GET['anio'])){
		$anio=$_GET['anio'];
	}
	$mes="";
	if(isset($_GET['mes'])){
		$mes=$_GET['mes'];
	}
	$semana="";
	if(isset($_GET['semana'])){
		$semana=$_GET['semana'];
	}
	$fecini="";
	$fecfin="";
	if ($_GET['option']=="3") {
		$ar_fecini=explode("-", $_GET['fecini']);
		$ar_fecfin=explode("-", $_GET['fecfin']);

		$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
		$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];
	}

	$talleres=[];
	$i=0;
	$sql="BEGIN SP_AT_REPORTE_RANKINGLINEA(:CODSED,:CODTIPSER,:OPCION,:ANIO,:MES,:SEMANA,:FECINI,:FECFIN,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODSED', $_GET['codsede']);
	oci_bind_by_name($stmt, ':CODTIPSER', $_GET['codtipser']);
	oci_bind_by_name($stmt, ':OPCION', $_GET['option']);
	oci_bind_by_name($stmt, ':ANIO', $anio);
	oci_bind_by_name($stmt, ':MES', $mes);
	oci_bind_by_name($stmt, ':SEMANA', $semana);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODTLL=$row['CODTLL'];
		$obj->DESCOM=utf8_encode($row['DESCOM']);
		$obj->DESTLL=utf8_encode($row['DESTLL']);
		$obj->DESSEDE=utf8_encode($row['DESSEDE']);
		$obj->DESTIPSERV=utf8_encode($row['DESTIPSERV']);
		$obj->PORCENTAJE=$row['PORCENTAJE'];
		$obj->AUD_TOT=$row['AUD_TOT'];
		$obj->AUD_REC=$row['AUD_REC'];
		$talleres[$i]=$obj;
		$i++;
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
			<th style="border:1px solid #333;">Nombre Comercial</th>
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
			<td style="border:1px solid #333;"><?php echo "COD-".$talleres[$i]->CODTLL; ?></td>
			<td style="border:1px solid #333;"><?php echo $talleres[$i]->DESCOM; ?></td>
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