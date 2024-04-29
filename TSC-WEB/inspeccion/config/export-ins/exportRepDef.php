<?php 
	set_time_limit(240);
	include('../connection.php');
	header("Pragma: public");
	header("Expires: 0");
	$filename = "Reporte_defectos_inspeccion.xls";
	header("Content-type: application/x-msdownload");
	header("Content-Disposition: attachment; filename=$filename");
	header("Pragma: no-cache");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	$ar_lineas=explode("-",$_GET['lineas']);
	$ar_fecha = explode("-",$_GET['fecha']);
	$fecha=$ar_fecha[0].$ar_fecha[1].$ar_fecha[2];
	$fecha_for=$ar_fecha[2]."-".$ar_fecha[1]."-".$ar_fecha[0];
	$ar_fechafin = explode("-",$_GET['fechafin']);
	$fechafin=$ar_fechafin[0].$ar_fechafin[1].$ar_fechafin[2];
	$fechafin_for=$ar_fechafin[2]."-".$ar_fechafin[1]."-".$ar_fechafin[0];
	
	$lineas=[];
	if ($ar_lineas[0]=="0") {
		$sql="BEGIN SP_INSP_REP_DETDEFINS(:LINEA,:FECHA,:FECHAFIN,:OUTPUT_CUR); END;";		
		$stmt=oci_parse($conn,$sql);
		oci_bind_by_name($stmt,":LINEA", $ar_lineas[0]);
		oci_bind_by_name($stmt,":FECHA", $fecha);
		oci_bind_by_name($stmt,":FECHAFIN", $fechafin);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$uno=new stdClass();
			$uno->CODINSCOS=$row['CODINSCOS'];
			$uno->CODFIC=$row['CODFIC'];
			$uno->CANFIC=$row['CANFIC'];
			$uno->FECINS=$row['FECINS'];
			$uno->CODUSU=$row['CODUSU'];
			$uno->DESTLL=utf8_encode($row['DESTLL']);
			$uno->DEFECTO=utf8_encode($row['DEFECTO']);
			$uno->FAMILIA=utf8_encode($row['FAMILIA']);
			$uno->OPERACION=utf8_encode($row['OPERACION']);
			$uno->CANDEF=$row['CANDEF'];
		    $uno->CANINS=$row['CANINS'];;
			$uno->CANPREDEF=$row['CANPREDEF'];;
			array_push($lineas, $uno);
		}
	}else{
		for ($i=0; $i < count($ar_lineas) ; $i++) {	
			$sql="BEGIN SP_INSP_REP_DETDEFINS(:LINEA,:FECHA,:FECHAFIN,:OUTPUT_CUR); END;";		
			$stmt=oci_parse($conn,$sql);
			oci_bind_by_name($stmt,":LINEA", $ar_lineas[$i]);
			oci_bind_by_name($stmt,":FECHA", $fecha);
			oci_bind_by_name($stmt,":FECHAFIN", $fechafin);
			$OUTPUT_CUR=oci_new_cursor($conn);
			oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR,-1,OCI_B_CURSOR);
			$result=oci_execute($stmt);
			oci_execute($OUTPUT_CUR);
			while($row=oci_fetch_assoc($OUTPUT_CUR)){
				$uno=new stdClass();
				$uno->CODINSCOS=$row['CODINSCOS'];
				$uno->CODFIC=$row['CODFIC'];
				$uno->CANFIC=$row['CANFIC'];
				$uno->FECINS=$row['FECINS'];
				$uno->CODUSU=$row['CODUSU'];
				$uno->DESTLL=utf8_encode($row['DESTLL']);
				$uno->DEFECTO=utf8_encode($row['DEFECTO']);
				$uno->FAMILIA=utf8_encode($row['FAMILIA']);
				$uno->OPERACION=utf8_encode($row['OPERACION']);
				$uno->CANDEF=$row['CANDEF'];
			    $uno->CANINS=$row['CANINS'];;
				$uno->CANPREDEF=$row['CANPREDEF'];;
				array_push($lineas, $uno);
			}
		}
	}
	oci_close($conn);
?>
<div style="font-size: 20px;font-weight: bold;">Reporte Defectos de Inspeccion</div>
<br>
<div style="font-weight: bold;">Fechas:</div>
<div>Del <?php echo $fecha_for; ?> al <?php echo $fechafin_for; ?></div>
<br>
<table>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Inspecci&oacute;n</th>
			<th style="border:1px solid #333;">Ficha</th>
			<th style="border:1px solid #333;">Cant. Ficha</th>
			<th style="border:1px solid #333;">Fecha</th>
			<th style="border:1px solid #333;">Usuario</th>
			<th style="border:1px solid #333;">Taller</th>
			<th style="border:1px solid #333;">Defecto</th>
			<th style="border:1px solid #333;">Familia defecto</th>
			<th style="border:1px solid #333;">Operaci&oacute;n</th>
			<th style="border:1px solid #333;">Cant. Defectos</th>
			<th style="border:1px solid #333;">Cant. Inspeccionada</th>
			<th style="border:1px solid #333;">Cant. Prendas Defectuosas</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			for ($i=0; $i < count($lineas) ; $i++) {
		?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->CODINSCOS; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->CODFIC; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->CANFIC; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->FECINS; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->CODUSU; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->DESTLL; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->DEFECTO; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->FAMILIA; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->OPERACION; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->CANDEF; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->CANINS; ?></td>
			<td style="border:1px solid #333;"><?php echo $lineas[$i]->CANPREDEF; ?></td>
		</tr>
		<?php
			}
		?>
	</tbody>
</table>