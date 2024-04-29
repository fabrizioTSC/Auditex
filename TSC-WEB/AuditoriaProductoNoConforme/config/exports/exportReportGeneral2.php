<?php 
header("Pragma: public");
header("Expires: 0");
$filename = "Reporte_general.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

include("../connection.php");

function format_percent($value){
	$value=str_replace(",",".",$value);
	if ($value[0]==".") {
		$value= "0".$value;
	}
	$value=intval(floatval($value)*1000);
	$value=$value/1000;
	return $value."%";
}

$sql="BEGIN SP_APNC_REPORTE_GENERAL_PEDIDO(:PEDIDO,:COLOR,:TIPO,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':PEDIDO', $_GET['pedido']);
oci_bind_by_name($stmt, ':COLOR', $_GET['dsccol']);
oci_bind_by_name($stmt, ':TIPO', $_GET['tipo']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);

?>
<div style="font-size: 20px;font-weight: bold;">Reporte General</div>
<br>
<div style="font-weight: bold;"><?php echo $_GET['titulo'];?></div>
<br>
<table>
	<?php
	if ($_GET['tipo']=="1") {
	?>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Pedido</th>
			<th style="border:1px solid #333;">Color</th>
			<th style="border:1px solid #333;">Ficha</th>
			<th style="border:1px solid #333;">Generado</th>
			<th style="border:1px solid #333;">Parte</th>
			<th style="border:1px solid #333;">Auditor</th>
			<th style="border:1px solid #333;">Fecha</th>
			<th style="border:1px solid #333;">Cant Ficha</th>
			<th style="border:1px solid #333;">Cant Def</th>
			<th style="border:1px solid #333;">Cant Rec</th>
			<th style="border:1px solid #333;">Taller</th>
			<th style="border:1px solid #333;">Sede</th>
			<th style="border:1px solid #333;">Tipo de servicio</th>
			<th style="border:1px solid #333;">Cliente</th>
			<th style="border:1px solid #333;">Estilo TSC</th>
			<th style="border:1px solid #333;">Estilo cliente</th>
		</tr>
	</thead>
	<tbody>
	<?php
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $row['PEDIDO']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DSCCOL']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CODFIC']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['GENERADO']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['PARTE']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CODUSU']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['FECINIAUD']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANTIDAD']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANDEF']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANRECUP']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESTLL']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['DESSEDE']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['DESTIPSERV']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESCLI']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['ESTTSC']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['ESTCLI']); ?></td>
		</tr>
	<?php
		}
	?>
	</tbody>
	<?php
	}else{
		if ($_GET['tipo']=="2") {
	?>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Pedido</th>
			<th style="border:1px solid #333;">Color</th>
			<th style="border:1px solid #333;">Ficha</th>
			<th style="border:1px solid #333;">Generado</th>
			<th style="border:1px solid #333;">Parte</th>
			<th style="border:1px solid #333;">Auditor</th>
			<th style="border:1px solid #333;">Fecha</th>
			<th style="border:1px solid #333;">Cant Ficha</th>
			<th style="border:1px solid #333;">Talla</th>
			<th style="border:1px solid #333;">Clas 2</th>
			<th style="border:1px solid #333;">Clas 3</th>
			<th style="border:1px solid #333;">Clas 4</th>
			<th style="border:1px solid #333;">Cant Clas</th>
			<th style="border:1px solid #333;">Cod Def</th>
			<th style="border:1px solid #333;">Defecto</th>
			<th style="border:1px solid #333;">Familia</th>
			<th style="border:1px solid #333;">Ubicación</th>
			<th style="border:1px solid #333;">Observación</th>
			<th style="border:1px solid #333;">Sede</th>
			<th style="border:1px solid #333;">Tipo de servicio</th>
			<th style="border:1px solid #333;">Cliente</th>
			<th style="border:1px solid #333;">Estilo TSC</th>
			<th style="border:1px solid #333;">Estilo cliente</th>
		</tr>
	</thead>
	<tbody>
	<?php
			while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $row['PEDIDO']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DSCCOL']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CODFIC']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['GENERADO']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['PARTE']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CODUSU']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['FECINIAUD']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANTIDAD']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESTAL']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANFIN2']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANFIN3']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANFIN4']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANCLA']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CODDEFAUX']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESDEF']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DSCFAMILIA']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESUBIDEF']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['OBS']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['DESSEDE']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['DESTIPSERV']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESCLI']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['ESTTSC']); ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['ESTCLI']); ?></td>
		</tr>
	<?php
			}
		}else{
			$ant_descol="";
			$sum2=0;
			$sum3=0;
			$sum4=0;
			$sumtot=0;
			$sumpor=0;
			while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
				if ($ant_descol!=utf8_encode($row['DESCOL'])) {
					if ($ant_descol!="") {
	?>
		<tr>
			<td style="border:1px solid #333;" colspan="4">Total Clas.</td>
			<td style="border:1px solid #333;"><?php echo $sum2; ?></td>
			<td style="border:1px solid #333;"><?php echo $sum3; ?></td>
			<td style="border:1px solid #333;"><?php echo $sum4; ?></td>
			<td style="border:1px solid #333;"><?php echo $sumtot; ?></td>
			<td style="border:1px solid #333;"></td>
		</tr>
		<tr>
			<?php			
				$sumtot2=0;
				$sumtot3=0;
				$sumtot4=0;
				if ($sum2+$sum3+$sum4!=0) {
					$sumtot2=($sumpor*$sum2)/($sum2+$sum3+$sum4);
					$sumtot3=($sumpor*$sum3)/($sum2+$sum3+$sum4);
					$sumtot4=($sumpor*$sum4)/($sum2+$sum3+$sum4);
				}
			?>
			<td style="border:1px solid #333;" colspan="4">%</td>
			<td style="border:1px solid #333;"><?php echo format_percent($sumtot2); ?></td>
			<td style="border:1px solid #333;"><?php echo format_percent($sumtot3); ?></td>
			<td style="border:1px solid #333;"><?php echo format_percent($sumtot4); ?></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"><?php echo format_percent($sumpor); ?></td>
		</tr>
		<tr></tr>
	</tbody>
	<?php
					}
					$sum2=0;
					$sum3=0;
					$sum4=0;
					$sumtot=0;
					$sumpor=0;
					$ant_descol=utf8_encode($row['DESCOL']);
	?>
	<thead>
		<tr>
			<th style="border:1px solid #333;">Pedido</th>
			<th style="border:1px solid #333;">Color</th>
			<th style="border:1px solid #333;">Cant Pedido</th>
			<th style="border:1px solid #333;">Talla</th>
			<th style="border:1px solid #333;">Clas 2</th>
			<th style="border:1px solid #333;">Clas 3</th>
			<th style="border:1px solid #333;">Clas 4</th>
			<th style="border:1px solid #333;">Total Clas</th>
			<th style="border:1px solid #333;">% Clasificaci&oacute;n</th>
		</tr>
	</thead>
	<tbody>
	<?php
				}
	?>
		<tr>
			<td style="border:1px solid #333;"><?php echo $_GET['pedido']; ?></td>
			<td style="border:1px solid #333;"><?php echo utf8_encode($row['DESCOL']); ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANPED']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['DESTAL']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CAN2']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CAN3']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CAN4']; ?></td>
			<td style="border:1px solid #333;"><?php echo $row['CANCLA']; ?></td>
			<td style="border:1px solid #333;"><?php echo format_percent($row['PORCLA']); ?></td>
		</tr>
	<?php
				$sum2+=intval($row['CAN2']);
				$sum3+=intval($row['CAN3']);
				$sum4+=intval($row['CAN4']);
				$sumtot+=intval($row['CANCLA']);
				$sumpor+=floatval(str_replace(",",".",$row['PORCLA']));
			}
			if ($_GET['tipo']=="3") {
	?>	
		<tr>
			<td style="border:1px solid #333;" colspan="4">Total Clas.</td>
			<td style="border:1px solid #333;"><?php echo $sum2; ?></td>
			<td style="border:1px solid #333;"><?php echo $sum3; ?></td>
			<td style="border:1px solid #333;"><?php echo $sum4; ?></td>
			<td style="border:1px solid #333;"><?php echo $sumtot; ?></td>
			<td style="border:1px solid #333;"></td>
		</tr>
		<tr>
			<?php			
				$sumtot2=0;
				$sumtot3=0;
				$sumtot4=0;
				if ($sum2+$sum3+$sum4!=0) {
					$sumtot2=($sumpor*$sum2)/($sum2+$sum3+$sum4);
					$sumtot3=($sumpor*$sum3)/($sum2+$sum3+$sum4);
					$sumtot4=($sumpor*$sum4)/($sum2+$sum3+$sum4);
				}
			?>
			<td style="border:1px solid #333;" colspan="4">%</td>
			<td style="border:1px solid #333;"><?php echo format_percent($sumtot2); ?></td>
			<td style="border:1px solid #333;"><?php echo format_percent($sumtot3); ?></td>
			<td style="border:1px solid #333;"><?php echo format_percent($sumtot4); ?></td>
			<td style="border:1px solid #333;"></td>
			<td style="border:1px solid #333;"><?php echo format_percent($sumpor); ?></td>
		</tr>
	<?php
			}
		}
	?>
	</tbody>
	<?php
	}
	?>
</table>